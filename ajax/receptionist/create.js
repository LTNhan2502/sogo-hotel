$(document).ready(function(){
    let nameValid = false;
    
    // Kiểm tra name
    $(document).on('change','#new_rec',function(){
        var value = $(this).val();
        var regex = /[~!@#$%^&*()_+`\-={}[\]:;"'<>,.?/\\|]/;

        // Kiểm tra rỗng
        if(value == ''){
            $('#new_rec_error').html('Không được để trống!');
            nameValid = false; 
            return false;            
        }

        // Kiểm tra độ dài 2 < name < 50
        else if(value.length < 2 || value.length > 50){
            $('#new_rec_error').html('Tên phải từ 2 tới 50 kí tự!');
            nameValid = false; 
            return false;
        }

        // Kiểm tra kí tự đặc biệt
        else if(regex.test(value)){
            $('#new_rec_error').html('Tên không được chứa kí tự đặc biệt!');
            nameValid = false; 
            return false;
        }

        //Kiểm tra số
        else if(!isNaN(value)){
            $('#new_rec_error').html('Tên không được chứa số!');
            nameValid = false; 
            return false;
        }

        // Đều đúng
        else{
            $('#new_rec_error').html('');
            nameValid = true; 
        }
        console.log(nameValid);
    });

    $("#createRecForm").on("submit", function(e){
        e.preventDefault();
        if (!nameValid) { // kiểm tra trạng thái của input
            $("#new_all_error").html("Hãy nhập đầy đủ thông tin hợp lệ!");
            return false;
        }else if($("#new_rec").val() == ''){
            $("#new_all_error").html("Hãy nhập đầy đủ thông tin hợp lệ!");
        }else{
            var form = $("#createRecForm")[0]; //Truy cập vào đối tượng DOM
            var formData = new FormData(form);
    
            $("#new_all_error").html("");
            console.log(nameValid);
            
            $.ajax({
                type: "POST",
                url: "Controller/admin/admin_rec_list.php?act=create_action",
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

