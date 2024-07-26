$(document).ready(function(){
    //Các flag xác định lỗi
    var smValid = false;
    var quantityValid = false;
    var svValid = false;
    var desValid = false;
    var reqValid = false;

    // Lấy ID file input
    var fileImg = ['#img', '#img1', '#img2', '#img3'];
    // Phần gán hiển thị cho ảnh 
    var showImg = ['#preview_img', '#preview_img1', '#preview_img2', '#preview_img3'];
    // Thẻ small báo lỗi
    var showError = ['#img_error', '#img_error1', '#img_error2', '#img_error3'];
    // Kiểm tra đúng sai để cho vào submit
    var isValid = [false, false, false, false];


    //Validate hình ảnh
    fileImg.forEach((arr, index) => {
        console.log(isValid);
        $(document).on('change', arr, function() {
            var id = $("#detail_id").data("detail_id");
            // Lấy ra files
            var file_data = $(fileImg[index]).prop('files')[0];
            // Lấy ra kiểu file
            var type = file_data.type;
            var match = ["image/gif", "image/png", "image/jpg", "image/jpeg", "image/webp"];

            if (match.includes(type)) {
                var form_data = new FormData();
                form_data.append('file', file_data);
                form_data.append("id", id);
                // console.log();
                $.ajax({
                    url: 'Controller/admin/admin_room_list.php?act=check_img',
                    contentType: false,
                    processData: false,
                    data: form_data,
                    type: 'post',
                    dataType: "JSON",
                    success: function(res) {
                        if (res.status == 200) {
                            $(showImg[index]).attr('src', res.data);
                            $(showError[index]).text('');
                            isValid[index] = true;
                        } else if(res.status == 403){
                            $(showError[index]).text(res.message);
                            isValid[index] = false;
                        }else{
                            $(showError[index]).text(res.message);
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

    $(document).on("submit", "#changeForm", async function(e){
        e.preventDefault();
        var form = $("#changeForm")[0];
        var formData = new FormData(form);
        var matchEx = ["image/gif", "image/png", "image/jpg", "image/jpeg", "image/webp"];

        // Các giá trị hình ảnh cũ
        var img_main_old = $("#img_main_old").data("img_main_value");
        var img_sub_1_old = $("#img_sub_1_old").data("img_sub_1_value");
        var img_sub_2_old = $("#img_sub_2_old").data("img_sub_2_value");
        var img_sub_3_old = $("#img_sub_3_old").data("img_sub_3_value");
        // img_sub_1_old == '' ? console.log(img_sub_1_old) : "hello";return;

        // Lấy giá trị từ các input file 
        var img_main_new = $("#img")[0].files[0] || '';
        var img_sub_1_new = $("#img1")[0].files[0] || '';
        var img_sub_2_new = $("#img2")[0].files[0] || '';
        var img_sub_3_new = $("#img3")[0].files[0] || '';

        // Kiểm tra và thay thế giá trị nếu input rỗng
        try{
            formData.set("img_main", img_main_new ?  img_main_new : await urlToFile(`Content/images/${img_main_old}`, img_main_old, matchEx));
            formData.set("img_sub_1", img_sub_1_new ?  img_sub_1_new : await urlToFile(`Content/images/${img_sub_1_old}`, img_sub_1_old, matchEx));
            formData.set("img_sub_2", img_sub_2_new ?  img_sub_2_new : await urlToFile(`Content/images/${img_sub_2_old}`, img_sub_2_old, matchEx));
            formData.set("img_sub_3", img_sub_3_new ?  img_sub_3_new : await urlToFile(`Content/images/${img_sub_3_old}`, img_sub_3_old, matchEx));           
        }catch(error){
            console.log("Lỗi chuyển url thành file: "+error.message);            
            return;
        }
         
        $.ajax({
            url: "Controller/admin/admin_room_list.php?act=change_detail_img",
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
        
    })


    //Validate diện tích
    $(document).on("change", "#square_meter_create", function(){
        var $input = $(this);
        var sm_value = $input.val();
        var id = $input.data("detail_id");

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

        if(smValid){
            $.ajax({
                url: "Controller/admin/admin_room_list.php?act=change_sm",
                method: "POST",
                data: {id, sm_value},
                dataType: "JSON",
                success: function(res){
                    if(res.status == 200){
                        Swal.fire({                                    
                            title: "Thay đổi thành công!",
                            text: res.message,
                            icon: "success",
                            timer: 900,
                            timerProgressBar: true
                        });
                        $input.closest("#sm_change").find("span").html(res.data+"m²");
                        $input.val('');
                    }else if(res.status == 403){
                        Swal.fire({                                    
                            title: "Thay đổi thất bại!",
                            text: res.message,
                            icon: "error",
                            timer: 3200,
                            timerProgressBar: true
                        });
                    }else if(res.status == "duplicate"){
                        Swal.fire({                                    
                            title: "Nhắc nhở!",
                            text: res.message,
                            icon: "info",
                            timer: 3200,
                            timerProgressBar: true
                        });
                        $input.val('');
                    }else{
                        Swal.fire({                                    
                            title: "Thay đổi thất bại!",
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
                        text: "Lỗi không xác định!",
                        icon: "error",
                        timer: 3200,
                        timerProgressBar: true
                    });
                }
            })
        }
    });

    //Validate số khách
    $(document).on("change", "#quantity_create", function(){
        var $input = $(this);
        var quantity_value = $input.val();
        var id = $input.data("detail_id");

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

        if(quantityValid){
            $.ajax({
                url: "Controller/admin/admin_room_list.php?act=change_quantity",
                method: "POST",
                data: {id, quantity_value},
                dataType: "JSON",
                success: function(res){
                    if(res.status == 200){
                        Swal.fire({                                    
                            title: "Thay đổi thành công!",
                            text: res.message,
                            icon: "success",
                            timer: 900,
                            timerProgressBar: true
                        });
                        $input.closest("#quantity_change").find("span").html(res.data+" khách");
                        $input.val('');
                    }else if(res.status == 403){
                        Swal.fire({                                    
                            title: "Thay đổi thất bại!",
                            text: res.message,
                            icon: "error",
                            timer: 3200,
                            timerProgressBar: true
                        });
                    }else if(res.status == "duplicate"){
                        Swal.fire({                                    
                            title: "Nhắc nhở!",
                            text: res.message,
                            icon: "info",
                            timer: 3200,
                            timerProgressBar: true
                        });
                        $input.val('');
                    }else{
                        Swal.fire({                                    
                            title: "Thay đổi thất bại!",
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
                        text: "Lỗi không xác định!",
                        icon: "error",
                        timer: 3200,
                        timerProgressBar: true
                    });
                }
            })
        }
    });

    //Validate tiện ích
    $(document).on("change", "#service_create", function(){
        var $input = $(this);
        var id = $input.closest(".row").find("#delete_sv_name").data("detail_id");
        //Lấy ra số lượng thẻ li để khi thêm sẽ thêm đúng
        var sv_num = $('#ul_sv li').length;
        var sv_value = $input.val();

        if(sv_value == ''){
            $("#sv_error").html("Không được để trống!");
            svValid = false;
            return false;
        }else{
            $("#sv_error").html("");
            svValid = true;
        }

        //Thực hiện thêm
        if(svValid){
            $.ajax({
                url: "Controller/admin/admin_room_list.php?act=add_service",
                method: "POST",
                data: {id, sv_value},
                dataType: "JSON",
                success: function(res){
                    if(res.status == 200){
                        // Swal.fire({                                    
                        //     title: "Thêm thành công!",
                        //     text: res.message,
                        //     icon: "success",
                        //     timer: 900,
                        //     timerProgressBar: true
                        // });
                        //Ghép phần tử mới vào li
                        $input.closest(".row").find("#ul_sv").append(`
                            <li class="sv${sv_num}">
                                <div class="d-flex flex-nowrap align-items-center mt-1">
                                    <span>${sv_value}</span>
                                    <button class="btn btn-danger ml-auto dl_sv" id="delete_sv_name" 
                                        data-service="${sv_value}"
                                        data-detail_id="${id}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>                                                     
                            </li>`);
                        //Reset input nhập
                        $input.val('');
                    }else if(res.status == 403){
                        Swal.fire({                                    
                            title: "Thêm thất bại!",
                            text: res.message,
                            icon: "error",
                            timer: 3200,
                            timerProgressBar: true
                        });
                    }else{
                        Swal.fire({                                    
                            title: "Thêm thất bại!",
                            text: res.message,
                            icon: "error",
                            timer: 3200,
                            timerProgressBar: true
                        });
                    }
                },
                erro: function(){
                    Swal.fire({                                    
                        title: "Lỗi!",
                        text: "Lỗi không xác định",
                        icon: "error",
                        timer: 3200,
                        timerProgressBar: true
                    });
                }
            })
        }
    });
    //Xoá một tiện ích
    $(document).on("click", "#delete_sv_name", function(){
        var $input = $(this);
        var id = $input.data("detail_id");
        //Lấy ra số lượng thẻ li để thực hiện xoá đúng vị trí
        var sv_max = $('#ul_sv li').length;
        var sv_remove_name = $input.data("service");

        Swal.fire({
            title: "Xoá tiện ích này?",
            text: "Sau khi xoá sẽ không thể khôi phục!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes!"
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "Controller/admin/admin_room_list.php?act=delete_service",
                    method: "POST",
                    data: {id,sv_max, sv_remove_name},
                    dataType: "JSON",
                    success: function(res){
                        if(res.status == 200){
                            // Swal.fire({                                    
                            //     title: "Xoá thành công!",
                            //     text: res.message,
                            //     icon: "success",
                            //     timer: 900,
                            //     timerProgressBar: true
                            // });
                            //Xoá phần tử đã chọn mà không reload
                            $input.closest("li").remove();                            
                        }else if(res.status == 403){
                            Swal.fire({                                    
                                title: "Xoá thất bại!",
                                text: res.message,
                                icon: "error",
                                timer: 3200,
                                timerProgressBar: true
                            });                           
                        }else{
                            Swal.fire({                                    
                                title: "Xoá thất bại!",
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
                            text: "Có lỗi xảy ra!",
                            icon: "error",
                            timer: 3200,
                            timerProgressBar: true
                        });
                    }
                })
            }
        });
    })

    //Validate yêu cầu
    $(document).on("change", "#requirement_create", function(){
        var $input = $(this);
        var id = $input.closest(".row").find("#delete_req_name").data("detail_id");
        //Lấy ra số lượng thẻ li để khi thêm sẽ thêm đúng
        var req_num = $('#ul_req li').length;
        var req_value = $input.val();

        if(req_value == ''){
            $("#req_error").html("Không được để trống!");
            reqValid = false;
            return false;
        }else{
            $("#req_error").html("");
            reqValid = true;
        }

        //Thực hiện thêm
        if(reqValid){
            $.ajax({
                url: "Controller/admin/admin_room_list.php?act=add_requirement",
                method: "POST",
                data: {id, req_value},
                dataType: "JSON",
                success: function(res){
                    if(res.status == 200){
                        // Swal.fire({                                    
                        //     title: "Thêm thành công!",
                        //     text: res.message,
                        //     icon: "success",
                        //     timer: 900,
                        //     timerProgressBar: true
                        // });
                        //Ghép phần tử mới vào li
                        $input.closest(".row").find("#ul_req").append(`
                            <li class="req${req_num}">
                                <div class="d-flex flex-nowrap align-items-center mt-1">
                                    <span>${req_value}</span>
                                    <button class="btn btn-danger ml-auto" id="delete_req_name" 
                                        data-requirement="${req_value}"
                                        data-detail_id="${id}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>                                                     
                            </li>`);                            
                        //Reset input nhập
                        $input.val('');
                    }else if(res.status == 403){
                        Swal.fire({                                    
                            title: "Thêm thất bại!",
                            text: res.message,
                            icon: "error",
                            timer: 3200,
                            timerProgressBar: true
                        });
                    }else{
                        Swal.fire({                                    
                            title: "Thêm thất bại!",
                            text: res.message,
                            icon: "error",
                            timer: 3200,
                            timerProgressBar: true
                        });
                    }
                },
                erro: function(){
                    Swal.fire({                                    
                        title: "Lỗi!",
                        text: "Lỗi không xác định",
                        icon: "error",
                        timer: 3200,
                        timerProgressBar: true
                    });
                }
            })
        }
    });
    //Xoá một yêu cầu
    $(document).on("click", "#delete_req_name", function(){
        var $input = $(this);
        var id = $input.data("detail_id");
        //Lấy ra số lượng thẻ li để thực hiện xoá đúng vị trí
        var req_max = $('#ul_req li').length;
        var req_remove_name = $input.data("requirement");

        Swal.fire({
            title: "Xoá yêu cầu này?",
            text: "Sau khi xoá sẽ không thể khôi phục!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes!"
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "Controller/admin/admin_room_list.php?act=delete_requirement",
                    method: "POST",
                    data: {id,req_max, req_remove_name},
                    dataType: "JSON",
                    success: function(res){
                        if(res.status == 200){
                            // Swal.fire({                                    
                            //     title: "Xoá thành công!",
                            //     text: res.message,
                            //     icon: "success",
                            //     timer: 900,
                            //     timerProgressBar: true
                            // });
                            //Xoá phần tử đã chọn mà không reload
                            $input.closest("li").remove();                            
                        }else if(res.status == 403){
                            Swal.fire({                                    
                                title: "Xoá thất bại!",
                                text: res.message,
                                icon: "error",
                                timer: 3200,
                                timerProgressBar: true
                            });                           
                        }else{
                            Swal.fire({                                    
                                title: "Xoá thất bại!",
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
                            text: "Có lỗi xảy ra!",
                            icon: "error",
                            timer: 3200,
                            timerProgressBar: true
                        });
                    }
                })
            }
        });
    })

    //Validate mô tả
    $(document).on("change", "#description_create", function(){
        var $input = $(this);
        var des_value = $input.val();
        var id = $input.closest(".row").find("#delete_des_name").data("detail_id");
        //Lấy ra số lượng thẻ li để khi thêm sẽ thêm đúng
        var des_num = $('#ul_des li').length;

        if(des_value == ''){
            $("#des_error").html("Không được để trống!");
            desValid = false;
            return false;
        }else{
            $("#des_error").html("");
            desValid = true;
        }

        //Thực hiện thêm
        if(desValid){
            $.ajax({
                url: "Controller/admin/admin_room_list.php?act=add_description",
                method: "POST",
                data: {id, des_value},
                dataType: "JSON",
                success: function(res){
                    if(res.status == 200){
                        // Swal.fire({                                    
                        //     title: "Thêm thành công!",
                        //     text: res.message,
                        //     icon: "success",
                        //     timer: 900,
                        //     timerProgressBar: true
                        // });
                        //Ghép phần tử mới vào li
                        $input.closest(".row").find("#ul_des").append(`
                            <li class="des${des_num}">
                                <div class="d-flex flex-nowrap align-items-center mt-1">
                                    <span>${des_value}</span>
                                    <button class="btn btn-danger ml-auto" id="delete_des_name" 
                                        data-description="${des_value}"
                                        data-detail_id="${id}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>                                                     
                            </li>`);                            
                        //Reset input nhập
                        $input.val('');
                    }else if(res.status == 403){
                        Swal.fire({                                    
                            title: "Thêm thất bại!",
                            text: res.message,
                            icon: "error",
                            timer: 3200,
                            timerProgressBar: true
                        });
                    }else{
                        Swal.fire({                                    
                            title: "Thêm thất bại!",
                            text: res.message,
                            icon: "error",
                            timer: 3200,
                            timerProgressBar: true
                        });
                    }
                },
                erro: function(){
                    Swal.fire({                                    
                        title: "Lỗi!",
                        text: "Lỗi không xác định",
                        icon: "error",
                        timer: 3200,
                        timerProgressBar: true
                    });
                }
            })
        }
    });
    //Xoá một yêu cầu
    $(document).on("click", "#delete_des_name", function(){
        var $input = $(this);
        var id = $input.data("detail_id");
        //Lấy ra số lượng thẻ li để thực hiện xoá đúng vị trí
        var des_max = $('#ul_des li').length;
        var des_remove_name = $input.data("description");

        Swal.fire({
            title: "Xoá yêu cầu này?",
            text: "Sau khi xoá sẽ không thể khôi phục!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes!"
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "Controller/admin/admin_room_list.php?act=delete_description",
                    method: "POST",
                    data: {id,des_max, des_remove_name},
                    dataType: "JSON",
                    success: function(res){
                        if(res.status == 200){
                            // Swal.fire({                                    
                            //     title: "Xoá thành công!",
                            //     text: res.message,
                            //     icon: "success",
                            //     timer: 900,
                            //     timerProgressBar: true
                            // });
                            //Xoá phần tử đã chọn mà không reload
                            $input.closest("li").remove();                            
                        }else if(res.status == 403){
                            Swal.fire({                                    
                                title: "Xoá thất bại!",
                                text: res.message,
                                icon: "error",
                                timer: 3200,
                                timerProgressBar: true
                            });                           
                        }else{
                            Swal.fire({                                    
                                title: "Xoá thất bại!",
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
                            text: "Có lỗi xảy ra!",
                            icon: "error",
                            timer: 3200,
                            timerProgressBar: true
                        });
                    }
                })
            }
        });
    })

    // Hàm kiểm tra tất cả isValid
    function checkAllValid() {
        if (isValid.every(v => v === true)) {
        console.log("Tất cả isValid:", isValid);
        // Thực hiện các hành động tiếp theo nếu tất cả đều hợp lệ
        }
    }

    //Hàm giả lập một url thành file (tải lên một tệp từ url cho trước và chuyển đổi nó thành một đối tượng file)
    async function urlToFile(url, filename, match) {
        //đợi fetch hoàn thành việc tải tệp từ url
        const response = await fetch(url);
        //đợi response đọc toàn bộ dữ liệu từ response và chuyển đổi nó thành một mảng đệm
        const buffer = await response.arrayBuffer();
        //Multipurpose Internet Mail Extensions (MIME) 
        //mimeType trả về loại loại dữ liệu của tệp: image/jpeg cho các hình ảnh JPEG, text/plain cho văn bản không định dạng
        //truy cập vào header và lấy giá trị Content-Type từ response, thường chứa loại dữ liệu của tệp
        const mimeType = response.headers.get("content-type");
        
        if (!match.includes(mimeType)) {
            throw new Error(`MIME type của tệp ${filename} không hợp lệ: ${mimeType}`);
        }
        //trả về một đối tượng file mới từ mảng đệm buffer, có tên là filename và loại tệp là mimeType
        return new File([buffer], filename, { type: mimeType });
    }
})