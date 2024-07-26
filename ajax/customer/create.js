$(document).ready(function(){
    let nameValid = false;
    
    // Kiểm tra name
    $(document).on('change','#new_cus',function(){
        var value = $(this).val();
        var regex = /[~!@#$%^&*()_+`\-={}[\]:;"'<>,.?/\\|]/;

        // Kiểm tra rỗng
        if(value == ''){
            $('#new_cus_error').html('Không được để trống!');
            nameValid = false; 
            return false;            
        }

        // Kiểm tra độ dài 2 < name < 30
        else if(value.length < 2 || value.length > 50){
            $('#new_cus_error').html('Tên phải từ 2 tới 50 kí tự!');
            nameValid = false; 
            return false;
        }

        // Kiểm tra kí tự đặc biệt
        else if(regex.test(value)){
            $('#new_cus_error').html('Tên không được bao gồm kí tự đặc biệt!');
            nameValid = false; 
            return false;
        }

        //Kiểm tra số
        else if(!isNaN(value)){
            $('#new_cus_error').html('Tên không được bao gồm số!');
            nameValid = false; 
            return false;
        }

        // Đều đúng
        else{
            $('#new_cus_error').html('');
            nameValid = true; 
        }
        console.log(nameValid);
    });

    $("#createCusForm").on("submit", function(e){
        e.preventDefault();
        if (!nameValid) { // kiểm tra trạng thái của input
            $("#new_all_error").html("Hãy nhập đầy đủ thông tin hợp lệ!");
            return false;
        }else if($("#new_cus").val() == ''){
            $("#new_all_error").html("Hãy nhập đầy đủ thông tin hợp lệ!");
        }else{
            var form = $("#createCusForm")[0]; //Truy cập vào đối tượng DOM
            var formData = new FormData(form);
    
            $("#new_all_error").html("");
            console.log(nameValid);
            
            $.ajax({
                type: "POST",
                url: "Controller/admin/admin_cus_list.php?act=create_action",
                dataType: "JSON",
                data: formData,
                contentType: false, //Dùng FormData thì bắt buộc phải có cái này
                processData: false, //Dùng FormData thì bắt buộc phải có cái này
                dataType: "JSON",
                success: function(res){
                    if(res.status == 'success'){
                        Swal.fire({                             
                            title: 'Thành công!',
                            text: res.message,
                            icon: 'success',
                            timer: 900,
                            timerProgressBar: true
                        });
                        setTimeout(() => {
                            window.location.reload();
                        }, 930);
                    }else{
                        Swal.fire({                             
                            title: 'Thất bại!',
                            text: res.message,
                            icon: 'error',
                            timer: 3000,
                            timerProgressBar: true
                        });
                    }                    
                }
            })
        }
        return false;
    });
})

