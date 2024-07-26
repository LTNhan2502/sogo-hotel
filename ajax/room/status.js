$(document).ready(function(){
    let error_empty = 'Không được để trống!';
    let error_special = 'Không được có kí tự đặc biệt!';
    let error_number = 'Không được có kí tự số!';
    let error_length = 'Độ dài kí tự từ 2-45!';

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
    
    //Chỉnh sửa name
    $(document).on('change', 'input[name="name"]', function(){
        let $input = $(this); // Lưu trữ tham chiếu đến phần tử input
        let id = $(this).data('id');
        let name_value  =$(this).val();
        let prevName = $input.data("value"); //Dùng $input để khi đem xuống AJAX không bị lỗi
        let action = "update_name";
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
                url: 'Controller/admin/admin_room_list.php?act=update_name',
                method: "POST",
                data: {
                    id,
                    name_value,
                    action
                },
                success: function(res){
                    let data = JSON.parse(res);
                    if(data.status == 'success'){                                     
                        $(".detail_name").html(name_value);
                        $("#name-text-"+id).html(name_value)
                        $input.data("value", name_value); // Cập nhật giá trị prevName sau khi thành công
                    }else if(data.status == 'fail'){
                        Swal.fire({                         
                            title: "Thất bại!",
                            text: "Thay đổi thất bại! Kiểm tra lại!",
                            icon: "error",
                            timer: 3000,
                            timerProgressBar: true
                        });
                    }else if(data.status == 'name'){
                        Swal.fire({                         
                            title: "Thất bại!",
                            text: data.message,
                            icon: "error",
                            timer: 3000,
                            timerProgressBar: true
                        });
                        $input.val(prevName); //Quay lại giá trị cũ
                    }else{
                        Swal.fire({                         
                            title: "Thất bại!",
                            text: "Thay đổi thất bại!",
                            icon: "error",
                            timer: 3000,
                            timerProgressBar: true
                        });
                    }
                },
                error: function(){
                    Swal.fire({                     
                        title: "Thất bại!",
                        text: "Lỗi khác ở hệ thống, CSDL, connect, đường dẫn",
                        icon: "error",
                        timer: 3200,
                        timerProgressBar: true
                    })
                }
            })
        }
    });

    //Vừa nhập vừa định dạng
    let value = ['input[name="price"]', 'input[name="sale"]'];
    for(let i = 0; i < value.length; i++ ){
        $(document).on('input',value[i], function() {
            let number_input = $(this).val().replace(/[^0-9]/g, ""); // Lấy giá trị hiện tại của ô input và loại bỏ các ký tự không phải số
            const formattedNumber = new Intl.NumberFormat('vi-VI', {
                numberStyle: 'decimal',
                maximumFractionDigits: 2,
            }).format(parseFloat(number_input)); // Định dạng giá trị theo chuẩn VND
    
            // Cập nhật giá trị ô input với giá trị đã định dạng
            $(this).val(formattedNumber);
        });
    }
    
    //Chỉnh sửa price
    $(document).on('change', 'input[name="price"]', function(){
        let $input = $(this); // Lưu trữ tham chiếu đến phần tử input
        let price_value = $(this).val().replace(/[^0-9]/g, "");
        let price_value_format = $(this).val()
        let sale_value = $(this).closest("tr").find('input[name="sale"]').val().replace(/[^0-9]/g, "");
        let prevPrice = $input.data('value'); //Dùng $input để khi đem xuống AJAX không bị lỗi
        let id = $(this).data('id');
        
        $.ajax({
            url: 'Controller/admin/admin_room_list.php?act=update_price',
            method: "POST",
            data: {
                price_value,
                id,
                sale_value
            },
            success: function(res){
                let data = JSON.parse(res);
                if(data.status == 'success'){
                    $("#price-text-"+id).html(price_value_format)
                    $input.data("value", price_value_format); // Cập nhật giá trị prevPrice sau khi thành công
                }else if(data.status == 'price'){
                    Swal.fire({                         
                        title: "Thất bại!",
                        text: data.message,
                        icon: "error",
                        timer: 3200,
                        timerProgressBar: true
                    });
                    $input.val(prevPrice); //Quay lại giá trị cũ                    
                    // $(this).val(); //Sai vì this sẽ trỏ tới AJAX chứ không còn trỏ tới bên input html, log sẽ ra undefined
                    console.log(prevPrice);
                }else{
                    Swal.fire({                         
                        title: "Thất bại!",
                        text: "Thay đổi thất bại! Kiểm tra lại!",
                        icon: "error",
                        timer: 3200,
                        timerProgressBar: true
                    });
                }
            },
            error: function(){
                Swal.fire({                     
                    title: "Thất bại!",
                    text: "Lỗi khác ở hệ thống, connect, CSDL, đường dẫn",
                    icon: "error",
                    timer: 3000,
                    timerProgressBar: true
                });
            }
        })
    });

    //Chỉnh sửa sale
    $(document).on('change', 'input[name="sale"]', function(){
        let $input = $(this); // Lưu trữ tham chiếu đến phần tử input
        let sale_value = $(this).val().replace(/[^0-9]/g, "");
        let sale_value_format = $(this).val()
        let id = $(this).data('id');
        let price_value = $(this).closest('tr').find('input[name="price"]').val().replace(/[^0-9]/g, ""); //Tìm tới chỗ có id là price gần nhất trong thẻ tr
        let prevSale = $input.data("value"); //Dùng $input để khi đem xuống AJAX không bị lỗi
        $.ajax({
            url: 'Controller/admin/admin_room_list.php?act=update_sale',
            method: "POST",
            data: {
                sale_value,
                id,
                price_value
            },
            success: function(res){
                let data = JSON.parse(res);
                if(data.status == 'success'){
                    $('#sale-text-'+id).html(sale_value_format)
                    $input.data("value", sale_value_format); // Cập nhật giá trị prevSale sau khi thành công
                }else if(data.status == 'sale'){
                    Swal.fire({                         
                        title: "Thất bại!",
                        text: data.message,
                        icon: "error",
                        timer: 3200,
                        timerProgressBar: true
                    });
                    $input.val(prevSale); //Quay lại giá trị cũ
                    console.log(prevSale);
                }else{
                    Swal.fire({                         
                        title: "Thất bại!",
                        text: "Thay đổi thất bại! Kiểm tra lại!",
                        icon: "error",
                        timer: 3200,
                        timerProgressBar: true
                    });
                }
            },
            error: function(){
                Swal.fire({                     
                    title: "Thất bại!",
                    text: "Lỗi khác ở hệ thống, connect, CSDL, đường dẫn",
                    icon: "error",
                    timer: 3000,
                    timerProgressBar: true
                });
            }
        })
    });

    //Chỉnh sửa status
   $(document).on('change', 'select[name="status"]', function() {
        let status_id = $(this).val();
        let id = $(this).find(":selected").data('id'); //Lấy ra data-id của option đang chọn
        let act = $(this).find(":selected").data('act');
        $.ajax({
            url: 'Controller/admin/admin_room_list.php?act='+act,
            method: 'POST',
            data: {status_id, id},
            success: function(res){ 
                let data = JSON.parse(res) //Vì res đang ở dạng chuỗi JSON chứ không phải là JSON thật sự nên phải parse
                console.log(data);
                if(data.status == "success"){  
                    if(status_id == 1){
                        $("#status-text-"+id).html("Empty")
                    }else if(status_id == 2){
                        $("#status-text-"+id).html("Full")
                    }else{
                        $("#status-text-"+id).html("Maintained")
                    }
                }else{
                    Swal.fire({                         
                        title: "Thất bại",
                        text: "Thay đổi thất bại! Kiểm tra lại",
                        icon: "error",
                        timer: 2500,
                        timerProgressBar: true
                    })
                }
            },
            error: function(){
                Swal.fire({                     
                    title: "Thất bại!",
                    text: "Lỗi khác ở hệ thống, connect, CSDL",
                    icon: "error",
                    timer: 3000,
                    timerProgressBar: true
                });
            }
        })
   });

   //Chỉnh sửa kind
   $(document).on('change', 'select[name="kind"]', function(){
        let kind_id_ = $(this).val();
        let id = $(this).find(":selected").data("id");
        let kind_name = $(this).find(":selected").data("act");    
        $.ajax({
            url: "Controller/admin/admin_room_list.php?act="+kind_name,
            method: "POST",
            data: {
                kind_id_,
                id,
                kind_name
            },
            success: function(res){
                let data = JSON.parse(res);
                console.log(data);
                if(data.status == "success"){
                    $("#kind-text-"+id).html(kind_name)
                }else if(data.status == 'price'){
                    Swal.fire({                         
                        title: "Thất bại!",
                        text: data.message,
                        icon: "error",
                        timer: 2500
                    });
                }else if(data.message == 'fail'){
                    Swal.fire({                         
                        title: "Thất bại!",
                        text: "Thay đổi không thành công! Kiểm tra lại!",
                        icon: "error",
                        timer: 2500
                    });
                }
            },
            error: function(){
                Swal.fire({                     
                    title: "Lỗi",
                    text: "Lỗi khác ở hệ thống, connect, CSDL!",
                    icon: "error",
                    timer: 3000
                });
            }
        })
   });   
})