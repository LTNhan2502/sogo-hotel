$(document).ready(function(){
    let nameFlag = $("#customer_name").val() ? false : true
    let numberFlag = $("#customer_tel").val() ? false : true
    let genderFlag = $("#customer_gender").val() ? false : true
    let dateFlag = $("#customer_birthday").val() ? false : true
    let passOldFlag = true;
    let passNewFlag = true;
    let passConfFlag = true;

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
                    url: "Controller/user/login.php?act=logout_action",
                    dataType: "JSON",
                    success: function (res) {
                        if (res.status == 200) {
                            Swal.fire({
                                title: "Đăng xuất thành công!",
                                icon: "success",
                                timer: 900,
                                timerProgressBar: true
                            }).then(function () {
                                window.location.href = "index.php";
                            });
                        } else {
                            Swal.fire({
                                title: "Đăng xuất thất bại!",
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

    //Xoá tài khoản
    $(document).on("click", "#delete_account", function () {
        let customer_booked_id = $("#customer_booked_id").data("customer_booked_id")
        Swal.fire({
            title: "Xoá tài khoản?",
            text: "Tài khoản sẽ bất hoạt trong 7 ngày trước khi bị xoá hoàn toàn!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Có",
            cancelButtonText: "Không"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "Controller/user/user_info.php?act=delete_action",
                    method: "POST",
                    data: {customer_booked_id},
                    dataType: "JSON",
                    success: function (res) {
                        if (res.status == 200) {
                            Swal.fire({
                                title: "Xoá tài khoản thành công!",
                                icon: "success",
                                timer: 900,
                                timerProgressBar: true
                            }).then(function () {
                                window.location.href = "index.php";
                            });
                        } else {
                            Swal.fire({
                                title: "Xoá tài khoản thất bại!",
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

    //Chỉnh sửa cus_name
    $(document).on('change', '#customer_name', function(){
        let name_value  =$(this).val();

        let regex_name_special = /[~!@#$%^&*()_+`\-={}[\]:;"'<>,.?/\\|]/;
        let regex_name_number = /\d/;

        //Kiểm tra trống
        if(name_value == '' && name_value.trim() == ''){
            nameFlag = true
            $("#customer_name_error").html("Không được để trống!")
            return
        }
        //Kiểm tra kí tự đặc biệt
        else if(regex_name_special.test(name_value)){
            nameFlag = true
            $("#customer_name_error").html("Không được chứa các kí tự đặc biệt!")
            return
        }
        //Kiểm tra số
        else if(regex_name_number.test(name_value)){
            nameFlag = true
            $("#customer_name_error").html("Không được chứa số!")
            return
        }
        //Kiểm tra độ dài phải từ 2-45
        else if(name_value.length < 2 || name_value.length > 45){
            nameFlag = true
            $("#customer_name_error").html("Độ dài phải từ 2-45 kí tự!")
            return
        }
        //Đều ổn
        else{
            nameFlag = false
            $("#customer_name_error").html("")
        }        
    });

    //Chỉnh sửa số điện thoại
    $(document).on('change', '#customer_tel', function(){
        let tel_value  =$(this).val();
        let first_0 = tel_value.charAt(0) == 0 ? true : false;

        //Kiểm tra trống
        if(tel_value == '' && tel_value.trim() == ''){
            numberFlag = true
            $("#customer_tel_error").html("Không được để trống!")
            return
        }        
        //Kiểm tra là số
        else if(isNaN(tel_value)){
            numberFlag = true
            $("#customer_tel_error").html("Phải là số!")
            return
        }
        //Kiểm tra phải có 10 chữ số
        else if(tel_value.length != 10 && first_0){
            numberFlag = true
            $("#customer_tel_error").html("Phải có 10 chữ số!")
            return
        }
        //Kiểm tra bắt đầu bằng số 0
        else if(!first_0 && tel_value.length == 10){
            numberFlag  =true
            $("#customer_tel_error").html("Phải bắt đầu bằng số 0!")
            return
        }
        //Kiểm tra hợp lệ
        else if(!first_0 && tel_value.length != 10){
            numberFlag =true
            $("#customer_tel_error").html("Số điện thoại không hợp lệ!")
            return
        }
        else{
            numberFlag = false
            $("#customer_tel_error").html("")
        }        
    });

    //Chỉnh sửa giới tính
    $(document).on('change', '#customer_gender', function(){
        let tel_value  =$(this).val();

        //Kiểm tra trống
        if(tel_value == '' && tel_value.trim() == ''){
            genderFlag = true
            $("#customer_gender_error").html("Không được để trống!")
            return
        }        
        //Kiểm tra khác 0
        else if(tel_value == 0){
            genderFlag = true
            $("#customer_gender_error").html("Hãy chọn giới tính!")
            return
        }
        //Đều ổn
        else{
            $("#customer_gender_error").html("")
            genderFlag = false
        }        
    });

    //Chỉnh sửa ngày sinh
    $(document).on('change', '#customer_birthday', function(){
        let tel_value  =$(this).val();

        //Kiểm tra trống
        if(tel_value == '' && tel_value.trim() == ''){
            dateFlag = true
            $("#customer_birthday_error").html("Không được để trống!")
            return
        }        
        //Kiểm tra khác 0
        else if(tel_value == 0){
            dateFlag = true
            $("#customer_birthday_error").html("Hãy chọn ngày sinh!")
            return
        }
        //Đều ổn
        else{
            $("#customer_birthday_error").html("")
            dateFlag = false
        }        
    });

    
    //Nhập password cũ
    $(document).on("change", "#password_user_old", function(){
        let password_user_old = $(this).val();
        let email = $("#customer_email").data("customer_email");

        //Kiểm tra rỗng
        if(!password_user_old || password_user_old.trim() == ''){
            $("#password_old_error").html("Không được để trống!");
            passOldFlag = true;
        }

        $.ajax({
            url: "Controller/user/user_info.php?act=check_pass",
            method: "POST",
            data: {password_user_old, email},
            dataType: "JSON",
            success: function(res){
                if(res.status == 200){
                    $("#password_old_error").html('');
                    passOldFlag = false;
                }else{
                    $("#password_old_error").html(res.message);
                    passOldFlag = true;
                }
            }
        })
    })

    //Kiểm tra password mới
    $(document).on("change", "#password_user_new", function(){
        let password = $(this).val();
        let repassword = $("#password_user_confirm");
        let passwordold = $("#password_user_old").val();

        //Kiểm tra rỗng
        if(!password || password.trim() == ''){
            $("#password_new_error").html("Không được để trống!");
            passNewFlag = true;
        }

        //Kiểm tra độ dài
        else if(password.length < 6){
            $("#password_new_error").html("Mật khẩu phải trên 5 kí tự!");
            passNewFlag = true;
        }

        //Kiểm tra nhập lại password
        else if(password != repassword && password.length > 5 && repassword != '' && passwordold != ''){
            $("#password_confirm_error").html("Mật khẩu và xác nhận mật khẩu không khớp!");
            $("#password_new_error").html('');
            passNewFlag = false;
        }

        //Kiểm tra password cũ 
        else if(password == repassword && password.length > 5 && repassword != '' && passwordold == ''){
            $("#password_old_error").html("Hãy nhập mật khẩu cũ!");
            $("#password_new_error").html('');
            passNewFlag = false;
        }

        //Đều ổn
        else{
            $("#password_error").html('');
            passNewFlag = false;
        }
    });

    //Kiểm tra retype password
    $(document).on("change", "#password_user_confirm", function(){
        let repassword = $(this).val();
        let password = $("#password_user_new").val();
        let passwordold = $("#password_user_old").val();            

        //Kiểm tra trùng
        if(repassword != password && password != ''){
            $("#password_confirm_error").html("Mật khẩu không khớp!");
            passConfFlag = true;
        }

        //Kiểm tra mật khẩu chưa nhập
        else if(repassword != password && password == ''){
            $("#password_confirm_error").html("Hãy nhập mật khẩu!");
            passConfFlag = true;
        }

        //Kiểm tra password cũ 
        else if(password == repassword && password.length > 5 && repassword != '' && passwordold == ''){
            $("#password_old_error").html("Hãy nhập mật khẩu cũ!");
            $("#password_confirm_error").html('');
            passConfFlag = false;
        }

        //Kiểm tra trống
        else if(!repassword || repassword.trim() == ''){
            $("#password_confirm_error").html("Mật khẩu không khớp!");
            passConfFlag = true;
        }

        //Đều ổn
        else{
            $("#password_confirm_error").html("");
            passConfFlag = false;
        }
    })

    
    $("#customer_birthday").datetimepicker({
        autoclose: true,
        timepicker: false,
        datepicker: true,
        format: "d/m/Y",
        weeks: true,
    });

    $.datetimepicker.setLocale('vi');

    //Thay đổi thông tin cá nhân
    $(document).on("submit", "#changeInfoForm", function(e){
        e.preventDefault();
        console.log(nameFlag, numberFlag, genderFlag, dateFlag);
        if(nameFlag || numberFlag || genderFlag || dateFlag){
            $("#info_all_error").html("Hãy nhập đầy đủ các thông tin hợp lệ!")
            return
        }else{
            $("#info_all_error").html("")
            let customer_email = $("#customer_email").data("customer_email");
            let form = $("#changeInfoForm")[0];
            let formData = new FormData(form);
            //Cách xem dữ liệu của formdata
            // formData.append("customer_birthday", customer_birthday);
            formData.append("customer_email", customer_email);
    
            $.ajax({
                url: "Controller/user/user_info.php?act=change_info",
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
                            window.location.reload();
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

    //Submit thay đổi mật khẩu
    $(document).on("submit", "#changePassForm", function(e){
        e.preventDefault();

        if(passOldFlag || passNewFlag || passConfFlag){
            $("#password_all_error").html("Nếu muốn thay đổi mật khẩu, hãy nhập đầy đủ thông tin!");
            return;
        }else if($("#password_user_old").val() == '' || $("#password_user_new").val() == '' || $("#password_user_confirm").val() == ''){
            $("#password_all_error").html("Nếu muốn thay đổi mật khẩu, hãy nhập đầy đủ thông tin!");
            return;
        }else if(!passOldFlag && !passNewFlag && !passConfFlag &&
                 $("#password_user_old").val() == $("#password_user_new").val()){
            $("#password_all_error").html("Mật khẩu mới không được trùng với mật khẩu cũ!");
        }else{
            $("#password_all_error").html("");
            let customer_email = $("#customer_email").data("customer_email");
            let form = $("#changePassForm")[0];
            let formData = new FormData(form);
            //Cách xem dữ liệu của formdata
            // formData.append("customer_birthday", customer_birthday);
            formData.append("customer_email", customer_email);

            Swal.fire({
                text: "Sau khi thay đổi mật khẩu, bạn sẽ phải đăng nhập lại một lần nữa!",
                icon: "info",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Chấp nhận",
                cancelButtonText: 'Từ chối'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "Controller/user/user_info.php?act=change_pass",
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
                                    window.location.href = 'index.php?action=login';
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
            });
        }
    })
})