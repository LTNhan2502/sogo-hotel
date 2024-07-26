// Chỗ để bấm submit
var arrayImg = ['#upload_img','#upload_img1', '#upload_img2', '#upload_img3'];
// Lấy ID file input
var fileImg = ['#img','#img1', '#img2', '#img3'];
// Phần gán hiển thị cho ảnh 
var showImg = ['#prevent_img','#preview_img1', '#preview_img2', '#preview_img3'];
 
arrayImg.forEach((arr, index) => {
   $(arr).on('click', function() {
      // Lấy ra files
      var file_data = $(fileImg[index]).prop('files')[0];
      if(!file_data || file_data.length === 0){ 
         Swal.fire("Vui lòng chọn tệp");return;
      }
   
      // Lấy ra kiểu file
      var type = file_data.type;
      var match = ["image/gif", "image/png", "image/jpg","image/jpeg", "image/webp"];
      if(type == match[0] || type == match[1] || type == match[2] || type == match[3] || type[4]) {
         var form_data = new FormData();
         form_data.append('file', file_data)
         $.ajax({
            url: 'Model/upload_img1.php',
            contentType: false,
            processData: false,
            data: form_data,    
            type: 'post',
            success: function(res) {
               var data = JSON.parse(res);
               if(data.status == 200) {
                  $(showImg[index]).attr('src', data.data);
               }
            }
         })
      }
   })
})

// $.ajax({
            //    url: 'Controller/admin/admin_room_list.php?act=upload_img',
            //    contentType: false,
            //    processData: false,
            //    data: form_data,
            //    type: 'post',
            //    success: function(res) {
            //       var data = JSON.parse(res);
            //       if (data.status == 200) {
            //          $(showImg[index]).attr('src', data.data);
            //          $(showError[index]).text('');
            //          isValid[index] = true;
            //       } else {
            //          $(showError[index]).text(data.message);
            //          isValid[index] = false;
            //       }
            //       // Cập nhật isValid
            //       checkAllValid();
            //    },
            //    error: function() {
            //       $(showError[index]).text('Đã xảy ra lỗi khi upload ảnh.');
            //       isValid[index] = false;
            //       checkAllValid();
            //    }
            // });
//Lấy ra phần tử cuối là tên của ảnh. Vì val() trả về C:\fakepath\tên_ảnh.jpg nên phải làm như bên dưới
            // var img_big = $("#img").val().split("\\");
            // var img_big_value = img_big[2];
