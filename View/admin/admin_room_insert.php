<?php
    $fmt = new formatter();
    $ac = 0;
    if(isset($_GET['id'])){
        $ac = 1;
    }else{
        $ac = 2;
    }

    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $room = new room();
        $result = $room->getRoomID($id);
        $info = $result->fetch();
        $name = $info['name'];
        $price = $info['price'];
        $kind_id = $info['kind_id'];
        $sale = $info['sale'];
        $status_id = $info['status_id'];
        $img = $info['img'];
    }
?>

<div class="container-fluid">
    <!-- Page Heading -->
    
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between">
            <span class="m-0 font-weight-bold text-primary">Table Room - Thêm mới</span>
            <a class="btn m-0 font-weight-bold btn-primary" href="admin_index.php?action=admin_room_list"><i class="fas fa-long-arrow-alt-left"></i></a>
        </div>
        <div class="card-body d-flex justify-content-center">
            <div class="card" style="width: 75%;">
                <div class="card-body">
                    <form enctype='multipart/form-data' id='roomForm' method='post'>                        
                        <div id="success_message"></div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <label for="id">ID</label>
                                <input type="number" class="form-control" name="id" id="id" readonly>

                                <!-- Name -->
                                <div class="row d-flex justify-content-between">
                                    <div>
                                        <label for="name">Tên phòng</label>
                                        <input type="text" class="form-control" name="name" id="name">
                                        <small id="name_error" class="text-danger"></small>
                                    </div>
                                </div>

                                <!-- Price/Sale -->
                                <div class="row d-flex justify-content-between">
                                    <div>
                                        <label for="price">Đơn giá</label>
                                        <input type="text" class="form-control" name="price" id="price">
                                        <small id="price_error" class="text-danger"></small>
                                    </div>
                                    <div>
                                        <label for="sale">Giảm giá</label>
                                        <input type="text" class="form-control" name="sale" id="sale">
                                        <small id="sale_error" class="text-danger"></small>
                                    </div>
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="col-lg-3 col-md-3">
                                <div>
                                    <label for="kind">Trạng thái</label>
                                    <select class="form-select" name="status_id" id="status_id" <?php echo isset($status_id) ? 'readonly' : ''; ?>>
                                        <?php
                                                $selected = -1;
                                                $room = new room();
                                                $status = $room->getStatus();
                                                if(isset($status_id)){
                                                    $selected = $status_id;
                                                }
                                                while($set = $status->fetch()):
                                            ?>
                                        <option value="<?php echo $set['status_id']; ?>"
                                            <?php echo $set['status_id'] == $selected ? 'selected' : ''; ?>>
                                            <?php echo $set['name']; ?>
                                        </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>

                                <!-- Kind -->
                                <div>
                                    <label for="kind">Loại phòng</label>
                                    <select class="form-select" name="kind" id="kind" <?php echo isset($kind_id) ? 'readonly' : ''; ?>>
                                        <?php
                                                $selected = -1;
                                                $room = new room();
                                                $kind = $room->getKind();
                                                if(isset($kind_id)){
                                                    $selected = $kind_id;
                                                }
                                                while($set = $kind->fetch()):
                                            ?>
                                        <option value="<?php echo $set['kind_id']; ?>"
                                            <?php echo $set['kind_id'] == $selected ? 'selected' : ''; ?>>
                                            <?php echo $set['kind_name']; ?>
                                        </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>

                                <!-- Image -->
                                <label for="img">Ảnh</label>
                                <input type="file" class="form-control" name="img" id="img">
                                <?php if(isset($img)): ?>
                                    <img src="Content/images/<?php echo $img; ?>" alt="" width="130px" height="130px">
                                <?php endif; ?>
                                <small id="img_error" class="text-danger"></small>
                            </div>
                            <div class="col-lg-3 col-md-3">
                                <label for=""></label>
                                <div class="col custom-column d-flex flex-column align-items-center">
                                    <img src="" class="image-small-2 imgs" id="preview_img" width="150px"
                                        height="125px">
                                </div>
                            </div>
                        </div>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <small id="all_error" class="text-danger mt-4 me-md-2"></small>
                            <button class="mt-3 btn btn-primary me-md-2" type="submit"  name="submit" id="submitBtn">
                                Thêm
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .imgs{
        border-radius: 10px;
        width: 170px;
        height: 145px;
        padding: 0 !important;
    }
</style>

<script>
    $(document).ready(function(){
        var imgValid = false;
        var nameValid = false;
        var priceValid = false;
        var saleValid = false;

        //Định dạng
        let value = ['#price', '#sale'];
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

        //Kiểm tra file
        $("#img").on("change", function() {
            var file = this.files[0];
            var file_name = file.name;
            var $file_url = "Content/images/"+file_name;
            console.log(file.name);
            var fileType = file.type;
            var match = ['image/jpeg', 'image/jpg', 'image/png'];
            if (match.indexOf(fileType) < 0) {
                $("#img_error").html("Ảnh phải là jpeg/jpg/png!");
                $("#img").replaceWith($("#img").val('').clone(true));//Xoá ảnh trong input
                imgValid = false; // cập nhật trạng thái của hình ảnh
                return false;
            } else {
                //Kiểm tra đã có ảnh trong database chưa
                $.ajax({
                    url: "Controller/admin/admin_room_list.php?act=check_image",
                    method: "POST",
                    data: {file_name},
                    dataType: "JSON",
                    success: function(res){
                        //Đã trùng
                        if(res.status == 'is in array'){
                            $("#img_error").html(res.message);
                            $("#img").replaceWith($("#img").val('').clone(true));
                            imgValid = false;
                            $("#preview_img").attr('src', '');
                            return false;
                        }
                        //Cho phép upload
                        else if(res.status == 'is not in array'){
                            $("#img_error").html("");
                            $("#preview_img").attr('src', $file_url);
                            imgValid = true; // cập nhật trạng thái của hình ảnh
                        }
                        //Cho phép upload
                        else if(res.data && res.data == 0 && res.status == 200){
                            $("#img_error").html("");
                            $("#preview_img").attr('src', $file_url);
                            imgValid = true;
                        }
                        //Đã trùng
                        else if(res.data && res.data != 0 && res.status == 200){
                            $("#img_error").html('Ảnh đã tồn tại!');
                            $("#img").replaceWith($("#img").val('').clone(true));
                            imgValid = false;
                            $("#preview_img").attr('src', '');
                            return false;
                        }
                        //Lỗi truy vấn
                        else{
                            $("#img_error").html('Lỗi trong lúc kiểm tra ảnh!');
                            $("#img").replaceWith($("#img").val('').clone(true));
                            imgValid = false;
                            $("#preview_img").attr('src', '');
                            return false;
                        }
                    },
                    errro: function(){
                        console.log("Lỗi");
                    }
                })
            }
        });

        // Kiểm tra name
        $(document).on('change','#name',function(){
            var value = $(this).val();
            var regex = /[~!@#$%^&*()_+`\-={}[\]:;"'<>,.?/\\|]/;
            var regex_number = /\d/;

            // Kiểm tra rỗng
            if(value == ''){
                $('#name_error').html('Không được để trống!');
                nameValid = false; 
                return false;            
            }

            // Kiểm tra độ dài 2 < name < 50
            else if(value.length < 2 || value.length > 50){
                $('#name_error').html('Tên phải từ 2 tới 50 kí tự!');
                nameValid = false; 
                return false;
            }

            // Kiểm tra kí tự đặc biệt
            else if(regex.test(value)){
                $('#name_error').html('Tên không được bao gồm kí tự đặc biệt!');
                nameValid = false; 
                return false;
            }

            //Kiểm tra chứa số
            else if(regex_number.test(value)){
                $('#name_error').html('Tên không được bao gồm số!');
                nameValid = false; 
                return false;
            }

            // Đều đúng
            else{
                $('#name_error').html('');
                nameValid = true; 
            }
            console.log(nameValid);
        });

        // Kiểm tra giá
        $(document).on('change', '#price', function(){
            var value = $(this).val();
            var value_formatted = $(this).val().replace(/[^0-9]/g, "");
            var regex = /^[0-9.]*$/;
            var sale = parseFloat($("#sale").val().replace(/[^0-9]/g, ""));

            // Kiểm tra rỗng
            if(value == ''){
                $('#price_error').html('Không được để trống!');
                priceValid = false; 
                return false;
            }

            // Kiểm tra có phải là số
            else if(!regex.test(value)){
                $('#price_error').html('Giá phải là một số!');
                priceValid = false; 
                return false;
            }

            // Kiểm tra sale thấp hơn price
            else if(value < sale){
                $('#price_error').html('Giá phải lớn hơn giảm giá!');
                priceValid = false; 
                return false;
            }

            // Đều ổn
            else{
                $('#price_error').html('');
                priceValid = true;
            }
            console.log(priceValid);
        });

        // Kiểm tra giảm giá
        $(document).on('change', '#sale', function(){
            var value = $(this).val();
            var value_formatted = $(this).val().replace(/[^0-9]/g, "");
            var regex = /^[0-9.]*$/;
            var price = parseFloat($('#price').val().replace(/[^0-9]/g, ""));

            // Kiểm tra rỗng
            if(value == ''){
                $('#sale_error').html('Không được để trống!');
                saleValid = false; 
                return false;
            }

            // Kiểm tra có phải là số
            else if(!regex.test(value)){
                $('#sale_error').html('Giảm giá phải là một số!');
                saleValid = false; 
                return false;
            }

            // Kiểm tra sale thấp hơn price
            else if(value >= price){
                $('#sale_error').html('Giảm giá phải nhỏ hơn giá gốc!');
                saleValid = false; 
                return false;
            }

            // Đều ổn
            else{
                $('#sale_error').html('');
                saleValid = true;
            }
            console.log(saleValid);
        });      
        
        $("#roomForm").on("submit", function(e){
            e.preventDefault();
            if (!imgValid || !nameValid || !priceValid || !saleValid) { // kiểm tra trạng thái của input
                $("#all_error").html("Hãy nhập đầy đủ thông tin hợp lệ!");
                return false;
            }else if($("#name").val() == '' || $("#price").val() == '' || $("#sale").val() == ''){
                $("#all_error").html("Hãy nhập đầy đủ thông tin hợp lệ!");
            }else{
                var form = $("#roomForm")[0]; //Truy cập vào đối tượng DOM
                var formData = new FormData(form);

                $("#all_error").html("");
                console.log(imgValid, nameValid, saleValid, priceValid);

                //Sửa lại giá trị của key price và sale trong FormData
                let price_unFormatted = $("#price").val().replace(/[^0-9]/g, "");
                let sale_unFormatted = $("#sale").val().replace(/[^0-9]/g, "");
                formData.set("price", price_unFormatted);
                formData.set("sale", sale_unFormatted);
                
                $.ajax({
                    type: "POST",
                    url: "Controller/admin/admin_room_list.php?act=create_action",
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
                            }).then(function() {
                                window.location.href = 'admin_index.php?action=admin_room_list';
                            });                            
                        }else{
                            Swal.fire({
                                 
                                title: 'Thất bại!',
                                text: res.message,
                                icon: 'error',
                                timer: 3000,
                                timerProgressBar: true
                            });
                            // setTimeout(() => {
                            //     window.location.href = './admin_index.php?action=admin_room_list&act=room_create';
                            // }, 1600);
                        }                    
                    }
                })
            }
            return false;
        });


    });

 
</script>

<style>
    .disabled{
        opacity: 0.65;
        pointer-events: none;        
    }
</style>

