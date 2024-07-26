$(document).ready(function(){
    let usernameFlag = true;
    let passOldFlag = true;
    let passNewFlag = true;
    let passConfFlag = true;
    let fullNameCreateFlag = true;
    let usernameCreateFlag = true;
    let passCreateFlag = true;
    let passConfCreateFlag = true;


    //Đăng nhập
    $("#loginAdmin").on("submit", function(e){
        e.preventDefault()
        let form = $("#loginAdmin")[0]
        let formData = new FormData(form)

        $.ajax({
            url: "Controller/admin/admin_login.php?act=login_action",
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "JSON",
            success: function(res){
                // console.log(res);return;
                if(res.status == 200){
                    Swal.fire({                                 
                        title: "Thành công!",
                        text: res.message,
                        icon: "success",
                        timer: 900,
                        timerProgressBar: true
                    }).then(function(){
                        window.location.href = 'admin_index.php?action=admin_home';
                    });
                }else if(res.status == 404){
                    Swal.fire({                                 
                        title: "Thất bại!",
                        text: res.message,
                        icon: "error",
                        timer: 3200,
                        timerProgressBar: true
                    })
                }else{
                    Swal.fire({                                 
                        title: "Thất bại!",
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
                    text: 'Lỗi không xác định!',
                    icon: "error",
                    timer: 3200,
                    timerProgressBar: true
                })
            }
        })
    })


    //Thay đổi mật khẩu
    //Kiểm tra username phải đúng và có tồn tại
    $(document).on("change", "#username_admin", function(){
        let username = $(this).val()

        if(!username || username.trim() == ''){
            $("#username_error").html("Không được để trống!")
            usernameFlag = true
        }else{
            $.ajax({
                url: "Controller/admin/admin_login.php?act=check_username",
                method: "POST",
                data: {username},
                dataType: "JSON",
                success: function(res){
                    if(res.status == 200){
                        $("#username_error").html('');
                        usernameFlag = false;
                    }else{
                        $("#username_error").html(res.message);
                        usernameFlag = true;
                    }
                },
                error: function(){
                    Swal.fire({
                        title: "Lỗi",
                        text: "Lỗi không xác định",
                        icon: "error"
                    })
                }
            })
        }
    })
    
    //Kiểm password cũ
    $(document).on("change", "#old_pass", function(){
        let password_user_old = $(this).val();
        let username = $("#username_admin").val();

        //Kiểm tra rỗng
        if(!password_user_old || password_user_old.trim() == ''){
            $("#old_pass_error").html("Không được để trống!");
            passOldFlag = true;
        }else if(!username){
            $("#old_pass_error").html("Hãy nhập username trước!");
            passOldFlag = true;
        }else{
            $.ajax({
                url: "Controller/admin/admin_login.php?act=check_pass",
                method: "POST",
                data: {password_user_old, username},
                dataType: "JSON",
                success: function(res){
                    if(res.status == 200){
                        $("#old_pass_error").html('');
                        passOldFlag = false;
                    }else{
                        $("#old_pass_error").html(res.message);
                        passOldFlag = true;
                    }
                }
            })
        }

    })

    //Kiểm tra password mới
    $(document).on("change", "#new_pass", function(){
        let password = $(this).val();
        let repassword = $("#new_pass_conf");
        let passwordold = $("#old_pass").val();

        //Kiểm tra rỗng
        if(!password || password.trim() == ''){
            $("#new_pass_error").html("Không được để trống!");
            passNewFlag = true;
        }

        //Kiểm tra độ dài
        else if(password.length < 6){
            $("#new_pass_error").html("Mật khẩu phải trên 5 kí tự!");
            passNewFlag = true;
        }

        //Kiểm tra nhập lại password
        else if(password != repassword && password.length > 5 && repassword != '' && passwordold != ''){
            $("#new_pass_conf_error").html("Mật khẩu và xác nhận mật khẩu không khớp!");
            $("#new_pass_error").html('');
            passNewFlag = false;
        }

        //Kiểm tra password cũ 
        else if(password == repassword && password.length > 5 && repassword != '' && passwordold == ''){
            $("#old_pass_error").html("Hãy nhập mật khẩu cũ!");
            $("#new_pass_error").html('');
            passNewFlag = false;
        }

        //Đều ổn
        else{
            $("#new_pass_error").html('');
            passNewFlag = false;
        }
    });

    //Kiểm tra retype password
    $(document).on("change", "#new_pass_conf", function(){
        let repassword = $(this).val();
        let password = $("#new_pass").val();
        let passwordold = $("#old_pass").val();            

        //Kiểm tra trùng
        if(repassword != password && password != ''){
            $("#new_pass_conf_error").html("Mật khẩu không khớp!");
            passConfFlag = true;
        }

        //Kiểm tra mật khẩu chưa nhập
        else if(repassword != password && password == ''){
            $("#new_pass_conf_error").html("Hãy nhập mật khẩu!");
            passConfFlag = true;
        }

        //Kiểm tra password cũ 
        else if(password == repassword && password.length > 5 && repassword != '' && passwordold == ''){
            $("#password_old_error").html("Hãy nhập mật khẩu cũ!");
            $("#new_pass_conf_error").html('');
            passConfFlag = false;
        }

        //Kiểm tra trống
        else if(!repassword || repassword.trim() == ''){
            $("#new_pass_conf_error").html("Mật khẩu không khớp!");
            passConfFlag = true;
        }

        //Đều ổn
        else{
            $("#new_pass_conf_error").html("");
            passConfFlag = false;
        }
    })

    $(document).on('submit', "#changePassForm", function(e){
        e.preventDefault()

        if($("#username_admin").val() == '' || $("#old_pass").val() == '' || $("#new_pass").val() == '' || $("#new_pass_conf").val() == ''){
            $("#all_error_admin_change_pass").html("Hãy nhập đầy đủ thông tin hợp lệ")
            return
        }else if(usernameFlag || passOldFlag || passNewFlag || passConfFlag){
            $("#all_error_admin_change_pass").html("Hãy nhập đầy đủ thông tin hợp lệ")
            return
        }else{
            $("#all_error_admin_change_pass").html("")
            let form = $("#changePassForm")[0]
            let formData = new FormData(form)
            $.ajax({
                url: "Controller/admin/admin_login.php?act=change_pass",
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                dataType: "JSON",
                success: function(res){
                    if(res.status == 200){
                        Swal.fire({                                 
                            title: "Thành công!",
                            text: res.message,
                            icon: "success",
                            timer: 900,
                            timerProgressBar: true
                        }).then(function(){
                            window.location.href = 'admin_index.php?action=admin_login';
                        });
                    }else{
                        Swal.fire({                                 
                            title: "Thất bại!",
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
                    })
                }
            })
        }
    })

    //Tạo tài khoản mới
    //Kiểm tra họ và tên
    $(document).on("change", "#fullname_create", function(){
        let username = $(this).val()        
        let regex_name_special = /[~!@#$%^&*()_+`\-={}[\]:;"'<>,.?/\\|]/;
        let regex_name_number = /\d/;

        //Kiểm tra trống
        if(username == '' && username.trim() == ''){
            $("#fullname_create_error").html("Không được để trống!")
            fullNameCreateFlag = true
            return;
        }
        //Kiểm tra kí tự đặc biệt
        else if(regex_name_special.test(username)){
            $("#fullname_create_error").html("Không được chứa kí tự đặc biệt!")
            fullNameCreateFlag = true
            return;
        }
        //Kiểm tra số
        else if(regex_name_number.test(username)){
            $("#fullname_create_error").html("Không được chứa số!")
            fullNameCreateFlag = true
            return;
        }
        //Kiểm tra độ dài phải từ 2-45
        else if(username.length < 2 || username.length > 45){
            $("#fullname_create_error").html("Độ dài phải từ 2-45 kí tự!")
            fullNameCreateFlag = true
            return;
        }
        //Đều ổn
        else{
            $("#fullname_create_error").html("")
            fullNameCreateFlag = false
        }
    })

    //Kiểm tra username đã tồn tại hay chưa
    $(document).on("change", "#username_create", function(){
        let username = $(this).val()

        if(!username || username.trim() == ''){
            $("#username_create_error").html("Không được để trống!")
            usernameCreateFlag = true
        }else{
            $.ajax({
                url: "Controller/admin/admin_login.php?act=check_username_create",
                method: "POST",
                data: {username},
                dataType: "JSON",
                success: function(res){
                    if(res.status == 200){
                        $("#username_create_error").html('');
                        usernameCreateFlag = false;
                    }else{
                        $("#username_create_error").html(res.message);
                        usernameCreateFlag = true;
                    }
                },
                error: function(){
                    Swal.fire({
                        title: "Lỗi",
                        text: "Lỗi không xác định",
                        icon: "error"
                    })
                }
            })
        }
    })

    //Kiểm tra password mới
    $(document).on("change", "#new_pass_create", function(){
        let password = $(this).val();
        let repassword = $("#new_pass_create_conf");

        //Kiểm tra rỗng
        if(!password || password.trim() == ''){
            $("#new_pass_create_error").html("Không được để trống!");
            passCreateFlag = true;
        }

        //Kiểm tra độ dài
        else if(password.length < 6){
            $("#new_pass_create_error").html("Mật khẩu phải trên 5 kí tự!");
            passCreateFlag = true;
        }

        //Kiểm tra nhập lại password
        else if(password != repassword && password.length > 5 && repassword != ''){
            $("#new_pass_conf_create_error").html("Mật khẩu và xác nhận mật khẩu không khớp!");
            $("#new_pass_create_error").html('');
            passCreateFlag = false;
        }

        //Đều ổn
        else{
            $("#new_pass_create_error").html('');
            passCreateFlag = false;
        }
    });

    //Kiểm tra retype password
    $(document).on("change", "#new_pass_create_conf", function(){
        let repassword = $(this).val();
        let password = $("#new_pass_create").val();

        //Kiểm tra trùng
        if(repassword != password && password != ''){
            $("#new_pass_create_conf_error").html("Mật khẩu không khớp!");
            passConfCreateFlag = true;
        }

        //Kiểm tra mật khẩu chưa nhập
        else if(repassword != password && password == ''){
            $("#new_pass_create_conf_error").html("Hãy nhập mật khẩu!");
            passConfCreateFlag = true;
        }

        //Kiểm tra trống
        else if(!repassword || repassword.trim() == ''){
            $("#new_pass_create_conf_error").html("Mật khẩu không khớp!");
            passConfCreateFlag = true;
        }

        //Đều ổn
        else{
            $("#new_pass_create_conf_error").html("");
            passConfCreateFlag = false;
        }
    })

    $(document).on('submit', "#createNewForm", function(e){
        e.preventDefault()

        if($("#fullname_create").val() == '' || $("#username_create").val() == '' || $("#new_pass_create").val() == '' || $("#new_pass_conf_create").val() == ''){
            $("#all_error_admin_create").html("Hãy nhập đầy đủ thông tin hợp lệ")
            return
        }else if(fullNameCreateFlag || usernameCreateFlag || passCreateFlag || passConfCreateFlag){
            $("#all_error_admin_create").html("Hãy nhập đầy đủ thông tin hợp lệ")
            return
        }else{
            $("#all_error_admin_create").html("")
            let form = $("#createNewForm")[0]
            let formData = new FormData(form)
            $.ajax({
                url: "Controller/admin/admin_login.php?act=create_anew_admin",
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                dataType: "JSON",
                success: function(res){
                    if(res.status == 200){
                        Swal.fire({                                 
                            title: "Thành công!",
                            text: res.message,
                            icon: "success",
                            timer: 900,
                            timerProgressBar: true
                        }).then(function(){
                            window.location.href = 'admin_index.php?action=admin_login';
                        });
                    }else{
                        Swal.fire({                                 
                            title: "Thất bại!",
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
                    })
                }
            })
        }
    })

    //Đăng xuất
    $(document).on("click", "#logout_button", function () {
        Swal.fire({
            title: "Đăng xuất?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Có",
            cancelButtonText: "Huỷ"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "Controller/admin/admin_login.php?act=logout",
                    dataType: "JSON",
                    success: function (res) {
                        if (res.status == 200) {
                            Swal.fire({
                                title: "Thành công!",
                                text: res.message,
                                icon: "success",
                                timer: 900,
                                timerProgressBar: true
                            }).then(function () {
                                window.location.href = "admin_index.php?action=admin_login";
                            });
                        } else {
                            Swal.fire({
                                title: "Thất bại!",
                                text: res.message,
                                icon: "error",
                                timer: 3200,
                                timerProgressBar: true
                            });
                        }
                    },
                    error: function () {
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
        });
    })

    //Thay đổi user_id thì thay đổi các giá trị trong permission
    $(document).on("change", "#user_id", function(){
        let user_id = $(this).val();
    
        $.ajax({
            url: "Controller/admin/admin_authorize.php?act=get_permission",
            method: "POST",
            data: { user_id },
            success: function(res){                
                $(".section").empty().append(res);
            },
            error: function(){
                Swal.fire({
                    title: "Lỗi!",
                    text: 'Không thể lấy dữ liệu quyền!',
                    icon: "error",
                    timer: 3200,
                    timerProgressBar: true
                });
            }
        });

        $.ajax({
            url: "Controller/admin/admin_authorize.php?act=get_priority",
            method: "POST",
            data: {user_id},
            success: function(res){
                $("#priority").val(res)
            },
            error: function(){
                Swal.fire({
                    title: "Lỗi!",
                    text: 'Không thể lấy dữ liệu quyền!',
                    icon: "error",
                    timer: 3200,
                    timerProgressBar: true
                });
            }
        })
    });
    

    //Phân quyền
    $(document).on("submit", ".permission-form", function(e) {
        e.preventDefault();
        let user_id = $("#user_id").val();
        let form = $(".permission-form")[0];
        let formData = new FormData(form);
    
        // Kiểm tra nếu user_id là 1, không gửi authorities
        if (user_id != 1) {
            // $("input[name='authorities[]']:checked").each(function() {
            //     formData.append("authorities[]", $(this).val());
            // });
            $.ajax({
                url: "Controller/admin/admin_authorize.php?act=authorize",
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                dataType: "JSON",
                success: function(res) {
                    // console.log(res);return;
                    if(res.status == 200){
                        Swal.fire({
                            title: "Thành công!",
                            text: res.message,
                            icon: "success",
                            timer: 900,
                            timerProgressBar: true
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
                error: function() {
                    Swal.fire({
                        title: "Lỗi!",
                        text: "Có lỗi xảy ra khi gửi dữ liệu.",
                        icon: "error"
                    });
                }
            });
        }else{
            Swal.fire({
                title: "Nhắc nhở!",
                text: "Không có quyền thay đổi!",
                icon: "warning",
                timer: 3000,
                timerProgressBar: true
            });
        }
    });
    
})