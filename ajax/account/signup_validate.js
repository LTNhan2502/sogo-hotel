$(document).ready(function () {
    var nameflag = true;
    var emailflag = true;
    var passflag = true;
    var repassflag = true;

    //Kiểm tra name
    $(document).on("change", "#name_user", function () {
        let name = $(this).val();
        let regex_name_special = /[~!@#$%^&*()_+`\-={}[\]:;"'<>,.?/\\|]/;
        let regex_name_number = /\d/;

        //Kiểm tra rỗng
        if (!name || name.trim() == "") {
            $("#name_user_error").html("Không được để trống!");
            nameflag = true;
            return false;
        }

        //Kiểm tra số kí tự
        else if (name.length < 2 || name.length > 45) {
            $("#name_user_error").html("Họ và tên phải từ 2 tới 45 kí tự!");
            nameflag = true;
            return false;
        }

        //Kiểm tra kí tự đặc biệt
        else if (regex_name_special.test(name)) {
            $("#name_user_error").html("Họ và tên không được có kí tự đặc biệt!");
            nameflag = true;
            return false;
        }

        //Kiểm tra chứa số
        else if (regex_name_number.test(name)) {
            $("#name_user_error").html("Họ và tên không được có số!");
            nameflag = true;
            return false;
        }

        //Đều ổn
        else {
            $("#name_user_error").html("");
            nameflag = false;
        }
    });

    //Kiểm tra email
    $(document).on("change", "#email_user", function () {
        let email = $(this).val();
        let regex_email = /^[a-zA-Z0-9._%+-]+@gmail+\.com$/;
        // let regex_email = /^[^\s@]+@gmail\.com$/;

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

        //Kiểm tra tồn tại
        else {
            $.ajax({
                url: "Controller/user/booking.php?act=check_email",
                method: "POST",
                data: { email },
                dataType: "JSON",
                success: function(res) {
                    let isExist = (res.countSignup == 0) ? false : true;
                    if (isExist) {
                        $("#email_user_error").html("Email này đã tồn tại!");                        
                        emailflag = true;
                        return;
                    }

                    //Đều ổn
                    else {
                        $("#email_user_error").html('');
                        emailflag = false;
                    }
                }
            });
        }
    });

    //Kiểm tra password
    $(document).on("change", "#password_user", function(){
        let password = $(this).val();
        let repassword = $("#re_password_user");

        //Kiểm tra rỗng
        if(!password || password.trim() == ''){
            $("#password_error").html("Không được để trống!");
            passflag = true;
        }

        //Kiểm tra độ dài
        else if(password.length < 6){
            $("#password_error").html("Mật khẩu phải trên 5 kí tự!");
            passflag = true;
        }

        //Kiểm tra nhập lại password
        else if(password != repassword && password.length > 5 && repassword != ''){
            $("#re_password_error").html("Mật khẩu không khớp!");
            $("#password_error").html('');
            passflag = false;
        }
        //Đều ổn
        else{
            $("#password_error").html('');
            passflag = false;
        }
    });

    //Kiểm tra retype password
    $(document).on("change", "#re_password_user", function(){
        let repass = $(this).val();
        let pass = $("#password_user").val();

        //Kiểm tra trùng
        if(repass != pass && pass != ''){
            $("#re_password_error").html("Mật khẩu không khớp!");
            repassflag = true;
        }

        //Kiểm tra mật khẩu chưa nhập
        else if(repass != pass && pass == ''){
            $("#re_password_error").html("Hãy nhập mật khẩu!");
            repassflag = true;
        }

        //Kiểm tra trống
        else if(!repass || repass.trim() == ''){
            $("#re_password_error").html("Mật khẩu không khớp!");
            repassflag = true;
        }

        //Đều ổn
        else{
            $("#re_password_error").html("");
            repassflag = false;
        }
    })

    //Submit
    $("#signUpForm").on("submit", function(e){
        e.preventDefault();
        if(nameflag || emailflag || passflag || repassflag){
            $("#signup_error").html("Hãy nhập đầy đủ các thông tin hợp lệ!");  
            console.log(nameflag, emailflag, passflag, repassflag);      
        }else if($("#name_user").val() == '' || $("#email_user").val() == '' || 
            $("#password_user").val() == '' || $("#re_password_user").val() == '' || 
            $("#re_password_user").val() != $("#password_user").val()){
            $("#signup_error").html("Hãy nhập đầy đủ các thông tin hợp lệ!");
            console.log(nameflag, emailflag, passflag, repassflag);      
        }else{
            console.log(nameflag, emailflag, passflag, repassflag);      
            $("#signup_error").html("");
            let form = $("#signUpForm")[0];
            let formData = new FormData(form);            

            $.ajax({
                url: "Controller/user/signup.php?act=signup_action",
                method: "POST",
                data: formData,
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
                        }).then(function(){
                            window.location.href = 'index.php?action=login';
                        });
                    }else if(res.status == 403){
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
                        text: "Không thể đăng kí!",
                        icon: "error",
                        timer: 3200,
                        timerProgressBar: true
                    });
                }
            })
        }
    });     
});
