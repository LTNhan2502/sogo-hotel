$(document).ready(function(){
   // Lấy ID file input
   var fileImg = ['#img1', '#img2', '#img3'];
   // Phần gán hiển thị cho ảnh 
   var showImg = ['#preview_img1', '#preview_img2', '#preview_img3'];
   // Thẻ small báo lỗi
   var showError = ['#img_error1', '#img_error2', '#img_error3'];
   // Kiểm tra đúng sai để cho vào submit
   var isValid = [false, false, false];

   //Các flag xác định lỗi
   var smValid = false;
   var quantityValid = false;
   var svValid = false;
   var desValid = false;
   var reqValid = false;

   //Validate hình ảnh
   fileImg.forEach((arr, index) => {
      console.log(isValid);
      $(document).on('change', fileImg, function() {
         // Lấy ra files
         var file_data = $(fileImg[index]).prop('files')[0];
         if (!file_data || file_data.length === 0) {
            $(showError[index]).text('Vui lòng chọn ảnh!');
            // Cập nhật isValid
            isValid[index] = false;
            checkAllValid();
            return;
         }

         // Lấy ra kiểu file
         var type = file_data.type;
         var match = ["image/gif", "image/png", "image/jpg", "image/jpeg", "image/webp"];
         if (match.includes(type)) {
            var form_data = new FormData();
            form_data.append('file', file_data);
            $.ajax({
               url: 'Controller/admin/admin_room_list.php?act=check_img',
               contentType: false,
               processData: false,
               data: form_data,
               type: 'post',
               success: function(res) {
                  var data = JSON.parse(res);
                  if (data.status == 200) {
                     $(showImg[index]).attr('src', data.data);
                     $(showError[index]).text('');
                     isValid[index] = true;
                  } else if(data.status == 403){
                     $(showError[index]).text(data.message);
                     isValid[index] = false;
                  }else{
                     $(showError[index]).text(data.message);
                     isValid[index] = false;
                  }
                  // Cập nhật isValid
                  checkAllValid();
               },
               error: function() {
                  $(showError[index]).text('Đã xảy ra lỗi khi upload ảnh.');
                  isValid[index] = false;
                  checkAllValid();
               }
            });
         } else {
            $(showError[index]).text('Chỉ được upload file ảnh');
            $(fileImg[index]).val('');
            // Cập nhật isValid
            isValid[index] = false;
            checkAllValid();
         }
         // return false;
      });
   });

   //Validate diện tích
   $(document).on("change", "#square_meter_create", function(){
      var sm_value = $(this).val();
      var regex_sm = /\d+/;

      if(sm_value == ''){
         $("#sm_error").html("Không được để trống!");
         smValid = false;
         return false;
      }else if(isNaN(sm_value)){
         $("#sm_error").html("Hãy nhập số!");
         smValid = false;
         return false;
      }else{
         $("#sm_error").html("");
         smValid = true;
      }
   });

   //Validate số khách
   $(document).on("change", "#quantity_create", function(){
      var quantity_value = $(this).val();

      if(quantity_value == ''){
         $("#quantity_error").html("Không được để trống!");
         quantityValid = false;
         return false;
      }else if(isNaN(quantity_value)){
         $("#quantity_error").html("Hãy nhập số!");
         quantityValid = false;
         return false;
      }else{
         $("#quantity_error").html("");
         quantityValid = true;
      }
   });

   //Validate tiện ích
   $(document).on("change", "#service_create", function(){
      var sv_value = $(this).val();

      if(sv_value == ''){
         $("#sv_error").html("Không được để trống!");
         svValid = false;
         return false;
      }else{
         $("#sv_error").html("");
         svValid = true;
      }
   });

   //Validate yêu cầu
   $(document).on("change", "#requirement_create", function(){
      var req_value = $(this).val();

      if(req_value == ''){
         $("#req_error").html("Không được để trống!");
         reqValid = false;
         return false;
      }else{
         $("#req_error").html("");
         reqValid = true;
      }
   });

   //Validate mô tả
   $(document).on("change", "#description_create", function(){
      var des_value = $(this).val();

      if(des_value == ''){
         $("#des_error").html("Không được để trống!");
         desValid = false;
         return false;
      }else{
         $("#des_error").html("");
         desValid = true;
      }
   });

   // Hàm kiểm tra tất cả isValid
   function checkAllValid() {
      if (isValid.every(v => v === true)) {
         console.log("Tất cả isValid:", isValid);
         // Thực hiện các hành động tiếp theo nếu tất cả đều hợp lệ
      }
   }

   //Submit
   $(document).on("submit", "#createForm", function(e){
      e.preventDefault();
      var id = $(".d-none").data("id");

      if(!isValid || !smValid || !quantityValid || !svValid || !reqValid || !desValid){
         $("#create_error").html("Hãy nhập đầy đủ các thông tin hợp lệ!");
         return false;
      }else if($("#square_meter_create").val() == '' || $("#quantity_create").val() == '' || 
               $("#service_create").val() == '' || $("#requirement_create").val() == '' || $("#description_create").val() == '' ||
               $("#img1").val() == '' || $("#img2").val() == '' || $("#img3").val() == ''){
         $("#create_error").html("Hãy nhập đầy đủ các thông tin hợp lệ!");
         return false;
      }else{
         $("#create_error").html("");
         var form = $("#createForm")[0];
         var formData = new FormData(form);
         //Lấy ra phần tử cuối là tên của ảnh. Vì val() trả về C:\fakepath\tên_ảnh.jpg nên phải làm như bên dưới
         // var img_big = $("#img").val().split("\\");
         // var img_big_value = img_big[2];

         $.ajax({
            url: "Controller/admin/admin_room_list.php?act=create_detail_action",
            method: "POST",
            data: formData,
            dataType: "JSON",
            contentType: false,
            processData: false,
            success: function(res){
               if(res.status == 200){
                  Swal.fire({                         
                     title: "Thành công!",
                     text: res.message,
                     icon: "success",
                     timer: 900,
                     timerProgressBar: true
                  }).then(function() {
                     window.location.href = "admin_index.php?action=admin_room_list";
                  });
               }else{
                  Swal.fire({                         
                     title: "Thất bại!",
                     text: res.message,
                     icon: "error",
                     timer: 3200,
                     timerProgressBar: true
                 });
               }
            },
            error: function(){
               Swal.fire({                         
                  title: "Lỗi!",
                  text: 'Lỗi không xác định',
                  icon: "error",
                  timer: 3200,
                  timerProgressBar: true
              });
            }
         })
      }
   })  

})   
   