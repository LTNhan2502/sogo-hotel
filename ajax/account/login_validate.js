$(document).ready(function () {
    var emailflag = true;
    var passflag = true;

    //Kiểm tra email
    $(document).on("change", "#email_user", function () {
        let email = $(this).val();
        let regex_email = /^[a-zA-Z0-9._%+-]+@gmail+\.com$/;

        //Kiểm tra rỗng
        if (!email || email.trim() == "") {
            $("#email_user_error").html("Không được để trống!");
            emailflag = true;
            return false;
        }

        //Kiểm tra hợp lệ
        else if (!regex_email.test(email)) {
            $("#email_user_error").html("Email không hợp lệ!");
            emailflag = true;
            return false;
        }

        //Đều ổn
        else {
            $("#email_user_error").html('');
            emailflag = false;
        }
                
    });

    //Kiểm tra password
    $(document).on("change", "#password_user", function(){
        let password = $(this).val();

        //Kiểm tra rỗng
        if(!password || password.trim() == ''){
            $("#password_error").html("Không được để trống!");
            passflag = true;
        }

        //Đều ổn
        else{
            $("#password_error").html('');
            passflag = false;
        }
    });

    //Thực hiện đăng nhập
    $('#loginForm1').on("submit", function(e){
        e.preventDefault(); 
        if(emailflag || passflag){
            $("#login_error").html("Hãy điền thông tin đăng nhập!");
            console.log(emailflag, passflag);
        }else{
            $("#login_error").html("");
            let form = $("#loginForm1")[0];
            let form_data = new FormData(form); 
            // //console log formdata
            // for (var pair of form_data.entries()) {
            //     console.log(pair[0] + ': ' + pair[1]);
            // }
            $.ajax({
                url: "Controller/user/login.php?act=login_action",
                method: "POST",
                data: form_data,
                contentType: false,
                processData: false, 
                dataType: "JSON",
                success: function(res){
                    console.log(res);
                    if(res.status == 200){
                        Swal.fire({                         
                            title: "Thành công!",
                            text: res.message,
                            icon: "success",
                            timer: 900,
                            timerProgressBar: true
                        }).then(function() {
                            window.location.href = "index.php";
                        });
                    }else if(res.status == 403){
                        Swal.fire({                         
                            title: "Thất bại!",
                            text: res.message,
                            icon: "error",
                            timer: 5500,
                            timerProgressBar: true
                        })
                    }else if(res.status == 404){
                        Swal.fire({                         
                            title: "Thất bại!",
                            text: res.message,
                            icon: "error",
                            timer: 3200,
                            timerProgressBar: true
                        })
                    }else if(res.status == 424){
                        Swal.fire({                         
                            title: "Từ chối đăng nhập!",
                            text: res.message,
                            icon: "error",
                            timer: 3200,
                            timerProgressBar: true
                        })
                    }
                },
                error: function(){
                    Swal.fire({                         
                        title: "Lỗi!",
                        text: "Lỗi không xác định!",
                        icon: "error",
                        timer: 3200,
                        timerProgressBar: true
                    });
                }
            })
        }
    })
})