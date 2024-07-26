$(document).ready(function(){
    let error_empty = 'Không được để trống!';
    let error_special = 'Không được có kí tự đặc biệt!';
    let error_number = 'Không được có kí tự số!';
    let error_length = 'Độ dài kí tự từ 2-45!';
    let error_email = 'Không đúng định dạng email!';
    let error_email_exist = 'Email này đã tồn tại!';
    let error_first_0 = 'Bắt đầu phải là số 0!';
    let error_number_length = 'Phải có 10 số!';
    let error_NaN = 'Không phải là số!';
    let error_invalid = 'Không hợp lệ!';
    


    //Function chứa sweetalert để hiện thông báo khi thay đổi giá trị của input
    function SweetAlrt(name_error){
        return Swal.fire({                         
            title: "Thất bại!",
            text: name_error,
            icon: "error",
            timer: 3200,
            timerProgressBar: true
        });
    }

    //Chỉnh sửa cus_name
    $(document).on('change', 'input[name="customer_name"]', function(){
        let $input = $(this); // Lưu trữ tham chiếu đến phần tử input
        let id = $(this).data('customer_id');
        let name_value  =$(this).val();
        let prevName = $input.data("customer_value"); //Dùng $input để khi đem xuống AJAX không bị lỗi

        let regex_name_special = /[~!@#$%^&*()_+`\-={}[\]:;"'<>,.?/\\|]/;
        let regex_name_number = /\d/;

        //Kiểm tra trống
        if(name_value == '' && name_value.trim() == ''){
            SweetAlrt(error_empty);
            $input.val(prevName); //Quay lại giá trị cũ
            return;
        }
        //Kiểm tra kí tự đặc biệt
        else if(regex_name_special.test(name_value)){
            SweetAlrt(error_special);
            $input.val(prevName);
            return;
        }
        //Kiểm tra số
        else if(regex_name_number.test(name_value)){
            SweetAlrt(error_number);
            $input.val(prevName);
            return;
        }
        //Kiểm tra độ dài phải từ 2-45
        else if(name_value.length < 2 || name_value.length > 45){
            SweetAlrt(error_length);
            $input.val(prevName);
            return;
        }
        //Đều ổn
        else{
            $.ajax({
                url: 'Controller/admin/admin_cus_list.php?act=update_name',
                method: "POST",
                data: {
                    id,
                    name_value,                    
                },
                dataType: "JSON",
                success: function(res){
                    if(res.status == 200){
                        $(".detail_customer_name").html(name_value);
                        $("#customer_name_text_"+id).html(name_value)
                        $input.data("customer_value", name_value)
                    }else{
                        Swal.fire({                             
                            title: "Thất bại!",
                            text: "Thay đổi thất bại!",
                            icon: "error",
                            timer: 3200,
                            timerProgressBar: true
                        });
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

    //Chỉnh sửa email thành viên
    $(document).on('change', 'input[name="email"]', function(){
        let $input = $(this); // Lưu trữ tham chiếu đến phần tử input
        let id = $(this).data('customer_id');
        let email  =$(this).val();
        let prevEmail = $input.data("email_value"); //Dùng $input để khi đem xuống AJAX không bị lỗi

        let regex_email = /^[a-zA-Z0-9._%+-]+@gmail+\.com$/;

        //Kiểm tra trống
        if(email == '' && email.trim() == ''){
            SweetAlrt(error_empty);
            $input.val(prevEmail); //Quay lại giá trị cũ
            return;
        }        
        //Kiểm tra định dạng
        else if(!regex_email.test(email)){
            SweetAlrt(error_email);
            $input.val(prevEmail);
            return;
        }
        //Kiểm tra trùng
        else{
            $.ajax({
                url: "Controller/user/booking.php?act=check_email",
                method: "POST",
                data: { email },
                dataType: "JSON",
                success: function(res) {
                    let isExist = (res.countExist == 0 && res.countSignup == 0) ? false : true;
                    if (isExist) {
                        SweetAlrt(error_email_exist);
                        $input.val(prevEmail);
                        return;
                    }
                    //Đều ổn
                    else {
                        let act = 'member'
                        $.ajax({
                            url: 'Controller/admin/admin_cus_list.php?act=update_email',
                            method: "POST",
                            data: {
                                id,
                                email,  
                                act                  
                            },
                            dataType: "JSON",
                            success: function(res){
                                if(res.status == 200){
                                    $("#email_text_"+id).html(email)
                                    $input.data("email_value", email)
                                }else{
                                    Swal.fire({                             
                                        title: "Thất bại!",
                                        text: "Thay đổi thất bại!",
                                        icon: "error",
                                        timer: 3200,
                                        timerProgressBar: true
                                    });
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
                }
            });
        }        
    });

    //Chỉnh sửa email khách
    $(document).on('change', 'input[name="email_guest"]', function(){
        let $input = $(this); // Lưu trữ tham chiếu đến phần tử input
        let id = $(this).data('customer_id');
        let email  =$(this).val();
        let prevEmail = $input.data("email"); //Dùng $input để khi đem xuống AJAX không bị lỗi

        let regex_email = /^[a-zA-Z0-9._%+-]+@gmail+\.com$/;

        //Kiểm tra trống
        if(email == '' && email.trim() == ''){
            SweetAlrt(error_empty);
            $input.val(prevEmail); //Quay lại giá trị cũ
            return;
        }        
        //Kiểm tra định dạng
        else if(!regex_email.test(email)){
            SweetAlrt(error_email);
            $input.val(prevEmail);
            return;
        }
        //Kiểm tra trùng
        else{
            $.ajax({
                url: "Controller/admin/admin_room_book.php?act=check_email",
                method: "POST",
                data: { email },
                success: function(res) {
                    let isExist = ((res.countExist == 0 && res.countSignup == 0)) ? false : true;
                    if (isExist) {
                        SweetAlrt(error_email_exist);
                        $input.val(prevEmail);
                        return;
                    }
                    //Đều ổn
                    else {
                        let act = 'guest'
                        $.ajax({
                            url: 'Controller/admin/admin_cus_list.php?act=update_email',
                            method: "POST",
                            data: {
                                id,
                                email, 
                                act                   
                            },
                            dataType: "JSON",
                            success: function(res){
                                if(res.status == 200){
                                    $("#email_guest_text_"+id).html(email)
                                    $input.data("email", email)
                                }else{
                                    Swal.fire({                             
                                        title: "Thất bại!",
                                        text: "Thay đổi thất bại!",
                                        icon: "error",
                                        timer: 3200,
                                        timerProgressBar: true
                                    });
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
                }
            });
        }        
    });

    //Chỉnh sửa số điện thoại
    $(document).on('change', 'input[name="tel"]', function(){
        let $input = $(this); // Lưu trữ tham chiếu đến phần tử input
        let id = $(this).data('customer_id');
        let tel_value  =$(this).val();
        let first_0 = tel_value.charAt(0) == 0 ? true : false;
        let prevTel = $input.data("tel_value"); //Dùng $input để khi đem xuống AJAX không bị lỗi

        //Kiểm tra trống
        if(tel_value == '' && tel_value.trim() == ''){
            SweetAlrt(error_empty);
            $input.val(prevTel); //Quay lại giá trị cũ
            retur;
        }        
        //Kiểm tra là số
        else if(isNaN(tel_value)){
            SweetAlrt(error_NaN);
            $input.val(prevTel);
            return;
        }
        //Kiểm tra phải có 10 chữ số
        else if(tel_value.length != 10 && first_0){
            SweetAlrt(error_number_length);
            $input.val(prevTel);
            return;
        }
        //Kiểm tra bắt đầu bằng số 0
        else if(!first_0 && tel_value.length == 10){
            SweetAlrt(error_first_0);
            $input.val(prevTel);
            return;
        }
        //Kiểm tra hợp lệ
        else if(!first_0 && tel_value.length != 10){
            SweetAlrt(error_invalid);
            $input.val(prevTel);
            return;
        }
        else{
            $.ajax({
                url: 'Controller/admin/admin_cus_list.php?act=update_tel',
                method: "POST",
                data: {
                    id,
                    tel_value,                    
                },
                dataType: "JSON",
                success: function(res){
                    if(res.status == 200){
                        $("#tel_text_"+id).html(tel_value)
                        $input.data("tel_value", tel_value)
                    }else{
                        Swal.fire({                             
                            title: "Thất bại!",
                            text: "Thay đổi thất bại!",
                            icon: "error",
                            timer: 3200,
                            timerProgressBar: true
                        });
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
})