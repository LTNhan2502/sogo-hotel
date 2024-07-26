<form enctype="multipart/form-data" method="POST" id="formBook">
    <div class="row m-3 row-stay margin">    
        <div class="col-lg-8 mb-3 mb-sm-0">        
            <div class="card" id="customer">
                <div class="card-body">
                    <div class="card-title">
                        <h4 class="text-bolder">Thông tin khách hàng</h4>
                    </div>
                    <div class="card-text">
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" 
                                    name="email_guest" id="email_user">
                                <small class="text-danger" name="email_error" id="email_user_error"></small>  
                                
                            </div>
                        </div>                     
                        <div class="row mt-3">
                            <div class="col-lg-6">
                                <label for="name">Họ và tên</label>
                                <input type="text" class="form-control" 
                                    name="name" id="name_user">
                                <small class="text-danger" name="name_error" id="name_user_error"></small>
                            </div>
                            <div class="col-lg-6">
                                <label for="tel">Số điện thoại</label>
                                <input type="text" class="form-control" 
                                    name="tel" id="tel_user">
                                <small class="text-danger" name="tel_error" id="tel_user_error"></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-4" id="general_info">
                <div class="card-body">
                    <div class="card-title">
                        <h4 class="text-bolder">Thông tin chung</h4>
                    </div>
                    <div class="card-text">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <th scope="row">Tiện ích chung</th>
                                    <td>Máy lạnh, thang máy, lễ tân 24h, WiFi, nhà hàng</td>                                
                                </tr>                            
                                <tr>
                                    <th scope="row">Bữa sáng</th>
                                    <td colspan="2">Được phục vụ tại cơ sở lưu trú từ 6:30 tới 9:30.</td>
                                </tr>
                                <tr>
                                    <th scope="row">Thời gian nhận/trả phòng</th>
                                    <td>Từ 14:00 hôm nay tới trước 12:00 hôm sau.</td>
                                </tr>
                                <tr>
                                    <th scope="row">Hút thuốc</th>
                                    <td colspan="2">Chỉ được phép hút thuộc tại các nơi chỉ định.</td>
                                </tr>
                                <tr>
                                    <th scope="row">Thú cưng</th>
                                    <td colspan="2">Không được mang theo thú cứng.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card mt-4" id="selected_detail_price">
                <div class="card-body">
                    <div class="card-title">
                        <h4>Chi tiết giá</h4>
                    </div>
                    <div class="card-text">
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <div class="d-flex justify-content-between mb-3">
                                    <span>Giá phòng</span>
                                    <span class="fs-5" id="selected_price" data-price=""></span>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="d-flex justify-content-between mb-3">
                                    <span>Ngày ở</span>
                                    <span id="stay-time"></span>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="d-flex justify-content-between mb-3" style="border-top: 1px solid #ced4da">
                                    <span class="mt-3">
                                        <h5>Tổng giá</h5>
                                    </span>
                                    <span class="mt-3">
                                        <h3 class="fw-bold fs-3" style="color: rgb(255, 94, 31);" id="selected_sum"></h3>
                                    </span>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 d-flex justify-content-center flex-wrap">
                                <button type="submit" class="btn btn-primary text-center checkout">Tiếp tục thanh toán</button> </br>                            
                                <small class="text-danger mt-3 text-center checkout_error"></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>        
        </div>
        <div class="col-lg-4">
            <h4>Thông tin phòng</h4>
            <div class="container mt-1" style="width: 100%;">
                <div class="overlay" id="overlay"></div>
                    <div id="show_cards_btn" class="btn btn-primary" style="width: 100%;">Xem các phòng</div>
                    <div id="room_cards" class="card-container">
                    <?php
                        $room = new room();
                        $fmt = new formatter();
                        $detail_room = $room->getDetail_room();
                        $rooms = $room->getEmptyRoom();
                        while ($sets = $rooms->fetch()):
                    ?>
                        <div class="card mb-3 room_card_list" data-room_select_id="<?php echo $sets['id']; ?>">
                        <div class="d-none" id="selected_room_id" data-selected_room_id="<?php echo isset($_GET['selected_room_id']) ? $_GET['selected_room_id'] : 0; ?>"></div>
                            <div class="row g-0">
                            <div class="col-md-4">
                                <img src="Content/images/<?php echo $sets['img']; ?>" class="img-fluid rounded-start" alt="...">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h6 class="card-title pt-2 room_name" data-room_name="<?php echo $sets['name']; ?>"><?php echo $sets['name']; ?></h6>
                                    <p><?php echo $sets['square_meter']; ?>m²</p>
                                    <p><?php echo $sets['quantity']; ?> khách</p>
                                    <p><strong>Bắt đầu từ <?php echo $fmt->formatCurrency($sets['sale']); ?>VND</strong></p>
                                </div>
                            </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                    </div>

                <input class="form-control" name="select_room" id="select_room" style="display:none;">
            </div>            

            <div class="mt-3" id="selected_message">
                <h5>Chưa đưa vào hoạt động.</h5>
                <h5>Vui lòng chọn phòng khác!</h5>
            </div>
            <div class="card card_info mt-3" id="selected_info">            
                <div class="card-body">
                    <div class="card-title">
                        <h3 class="text-bolder">
                            <h5 id="selected_name"></h5>
                            <img src="" width="100%" id="selected_img" alt="">
                        </h3>
                    </div>
                    <div class="card-text">
                        <div class="row mt-3 mb-3">
                            <div class="col-lg-6">
                                <label for="from">Nhận phòng</label>
                                <div class="input-group flex-nowrap">
                                    <span class="input-group-text" id="addon-wrapping"><i class="far fa-calendar-alt"></i></span>
                                    <input type="datetime" id="from" class="form-control" aria-describedby="addon-wrapping">                                
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label for="from">Trả phòng</label>
                                <div class="input-group flex-nowrap">
                                    <span class="input-group-text" id="addon-wrapping"><i class="far fa-calendar-alt"></i></span>
                                    <input type="datetime" id="to" class="form-control" aria-describedby="addon-wrapping">                                
                                </div>
                            </div>
                            <div class="row">
                                <small class="text-danger text-center mt-2" id="time_error"></small>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <h5>Các dịch vụ</h5>
                            <div>
                                <ul>
                                    <div id="service_list"></div>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <h5>Các yêu cầu</h5>
                            <div>
                                <ul>
                                    <div id="requirement_list"></div>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<style>
    .margin{
        margin: 65px !important;
    }
    .checkout{
        min-width: 700px ;
    }
    
    .card_info {
        border-radius: 10px;
        box-shadow: 3px 4px 8px rgba(255, 0, 0, 0.155);
    }

    #show_cards_btn {
        width: 100%;
    }

    .container {
        width: 100%;
    }

    .card-container {
        display: none;
        position: absolute;
        background-color: white;
        border: 1px solid #ccc;
        border-radius: 17px;
        z-index: 10;
        height: 500px;
        overflow-y: auto;
        padding: 10px;
        margin-top: 10px;
        width: 94%;
    }

    .overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 9;
    }

    .room_card_list {
        border: 1px solid #ccc;
        border-radius: 17px;
        margin: 10px;
        cursor: pointer;
        transition: transform 0.2s;
        display: flex;
        flex-direction: row;
        align-items: center;
        overflow: hidden;
        width: 93%;
        max-height: 150px;
    }

    .room_card_list:hover {
        transform: scale(1.01);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .room_card_list.selected {
        border-color: #007bff;
        background-color: #f0f8ff;
    }

    .room_card_list img {
        width: 150px;
        height: 150px;
        object-fit: cover;
        /* margin-right: 10px; */
    }

    .room_card_list .card-body {
        display: flex;
        flex-direction: column;
        font-size: 0.8em;
        object-fit: contain;
    }

    .room_card_list .card-body p{
        margin: 0px !important;
    }

    .show-cards-btn {
        margin: 20px 0;
        position: relative;
    }
</style>

<script src="ajax/room/show_selected_room.js"></script>
<!-- <script src="ajax/room/validate.js"></script> -->
<!-- <script src="Content/datetimepicker-master/build/jquery.datetimepicker.full.min.js"></script> -->
<script>
    $(document).ready(function(){
        var nameflag = true;
        var emailflag = true;
        var telflag = true;
        var fromflag = true;
        var toflag = true;
        var time_arrive = 0;
        var time_left = 0;
        var stay_from_day = 0;
        var stay_to_day = 0;
        var stay_time = 0;
        var stay_sum = 0;
        var guestFlag = 0;
        var act = '';

        var form = $("#formBook")[0];
        var formTimeData = new FormData(form);

        // Lấy ra thời gian miligiay của ngày hôm nay
        var date = new Date();
        var nowDay = date.getDate();
        var nowMonth = date.getMonth()+1;
        var nowYear = date.getFullYear();
        var newDate = new Date(nowYear, nowMonth, nowDay);
        var now = newDate.getTime();

        //Validate datetimepicker
        $("#from, #to").datetimepicker({
            autoclose: true,
            timepicker: false,
            datepicker: true,
            format: "d/m/Y",
            weeks: true,
            minDate: 0,
        }).on("change", function(){
            let from_to = $(this).val();
            let from_to_arr = from_to.split("/");
            let from_to_day = parseInt(from_to_arr[0]);
            let from_to_month = parseInt(from_to_arr[1]);
            let from_to_year = parseInt(from_to_arr[2]);
            let dateTime = new Date(from_to_year, from_to_month, from_to_day);
            let time = dateTime.getTime();

            //Nếu chọn ngày nhận phòng thì time sẽ là time_arrive, ngược lại
            if($(this).attr("id") == "from"){            
                time_arrive = time;
                stay_from_day = from_to_day;
            }else{
                time_left = time;
                stay_to_day = from_to_day;
            }

            // console.log(time_arrive, time_left);
            //Xác thực thời gian nhận phòng
            if(time_arrive > time_left){            
                $("#time_error").html("Ngày nhận phòng phải nhỏ hơn ngày trả phòng!");  
                fromflag = true;
                toflag = true; 
                return false;         
            }else if(time_arrive == time_left){
                $("#time_error").html("Ngày nhận phòng không được trùng với ngày trả phòng!");
                fromflag = true;
                toflag = true;
                return false;
            }

            //Kiểm tra thời gian nhận phòng
            //Kiểm tra rỗng
            else if(!time_arrive && time_left){
                $("#time_error").html("Không được để trống ngày nhận phòng!");
                fromflag = true;
                return false;
            }

            //Kiểm tra thời gian trả phòng
            //Kiểm tra rỗng
            else if(!time_left && time_arrive){
                $("#time_error").html("Không được để trống ngày trả phòng!");                
                toflag = true;
                return false;
            }

            //Cả 2 ngày nhận/trả phòng không có giá trị
            else if(!time_arrive && !time_left){
                $("#time_error").html("Không được để trống ngày nhận/trả phòng!"); 
                fromflag = true;               
                toflag = true;
                return false;
            }

            //Kiểm tra thời gian nhận phòng ít nhất phải là ngày hôm nay
            else if(time_arrive && time_arrive < now){
                $("#time_error").html("Ngày nhận phòng ít nhất phải là ngày hôm nay!"); 
                fromflag = true;               
                return false;
            }

            //Đều ổn
            else{
                $("#time_error").html("");
                fromflag = false;
                toflag = false;
            }

            //Đưa dữ liệu từ input thuộc datetimepicker vào FormData
            //Thêm dữ liệu vào FormData khi 2 flag đều false
            if(!fromflag && !toflag) {
                var fromData = $("#from").val();
                var toData = $("#to").val();

                //Tính ngày ở lại
                console.log(time_arrive, time_left);
                if(time_arrive < time_left && time_arrive >= now){
                    stay_time = Math.floor((time_left - time_arrive)/(1000 * 60 * 60 * 24));
                    console.log(stay_time);
                    stay_sum = stay_time*($("#selected_price").data("price"));
                    let formattedSum = stay_sum.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
                    console.log(stay_time);
                    $("#stay-time").html(stay_time);
                    $("#selected_sum").html(formattedSum);
                }else{
                    stay_time = 0;
                    stay_sum = 0;
                }
                
                // Kiểm tra xem giá trị `from` đã tồn tại trong FormData chưa
                if (!formTimeData.has("from")) {
                    formTimeData.append("from", fromData);
                }
                // Kiểm tra xem giá trị `to` đã tồn tại trong FormData chưa
                if (!formTimeData.has("to")) {
                    formTimeData.append("to", toData);
                }
            }
        })

        $.datetimepicker.setLocale('vi');
    
        //Kiểm tra name
        $(document).on("change", "#name_user", function(){
            let name = $(this).val();        
            let regex_name_special = /[~!@#$%^&*()_+`\-={}[\]:;"'<>,.?/\\|]/;
            let regex_name_number = /\d/;

            //Kiểm tra rỗng
            if(!name || name.trim() == ''){
                $("#name_user_error").html("Không được để trống!");
                nameflag = true;
                return false;
            }

            //Kiểm tra số kí tự
            else if(name.length < 2 || name.length > 45){
                $("#name_user_error").html("Họ và tên phải từ 2 tới 45 kí tự!");
                nameflag = true;
                return false;
            }

            //Kiểm tra kí tự đặc biệt
            else if(regex_name_special.test(name)){
                $("#name_user_error").html("Họ và tên không được có kí tự đặc biệt!");
                nameflag = true;
                return false;
            }

            //Kiểm tra chứa số
            else if(regex_name_number.test(name)){
                $("#name_user_error").html("Họ và tên không được có số!");
                nameflag = true;
                return false;
            }

            //Đều ổn
            else{
                $("#name_user_error").html('');
                nameflag = false;
            }
        });

        //Kiểm tra email
        $(document).on("change", "#email_user", function() {
            let email = $(this).val();
            let regex_email = /^[a-zA-Z0-9._%+-]+@gmail+\.com$/;
            
        
            //Kiểm tra rỗng
            if (!email || email.trim() == '') {
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
                    url: "Controller/admin/admin_room_book.php?act=check_email",
                    method: "POST",
                    data: { email },
                    dataType: "JSON",
                    success: function(res) {
                        console.log(res);                        
                        if ((res.countExist != 0 && res.countSignup == 0)) {                            
                            guestFlag = 1;
                            emailflag = false;

                            $("#name_user").val(res.data_customer_name)
                            $('#tel_user').val(res.data_customer_tel)

                            $("#name_flag").val() != '' ? nameflag = false : nameflag = true
                            $("#tel_user").val() != '' ? telflag = false : telflag = true
                        }
                        //Đã tồn tại (email)
                        else if((res.countExist == 0 && res.countSignup != 0)){
                            $("#email_user_error").html('');
                            guestFlag = 2;
                            $("#name_user").val(res.data_customer_name)
                            $('#tel_user').val(res.data_customer_tel)
                            emailflag = false;
                            $("#name_flag").val() != '' ? nameflag = false : nameflag = true
                            $("#tel_user").val() != '' ? telflag = false : telflag = true
                        }
                        //Email chưa tồn tại
                        else if(res.countExist == 0 && res.countSignup == 0){
                            $("#email_user_error").html('');
                            $("#name_user").val('')
                            $('#tel_user').val('')
                            $("#name_flag").val() != '' ? nameflag = false : nameflag = true
                            $("#tel_user").val() != '' ? telflag = false : telflag = true
                            guestFlag = 0;
                            emailflag = false;
                        }
                    }
                });
            }
        });
        

        //Kiểm tra số điện thoại
        $(document).on("change", "#tel_user", function(){
            let tel = $(this).val();
            let tel_slice = tel.slice(0,1);
            console.log(tel.length);

            //Kiểm tra rỗng
            if(!tel || tel.trim() == ''){
                $("#tel_user_error").html("Không được để trống!");
                telflag = true;
                return false;
            }

            //Kiểm tra số
            if(isNaN(tel)){
                $("#tel_user_error").html("Phải là số!");
                telflag = true;
                return false;
            }

            //Kiểm tra số hợp lệ
            else if(tel_slice != 0 && tel.length == 10){
                $("#tel_user_error").html("Số điện thoại phải bắt đầu bằng số 0!");
                telflag = true;
                return false;
            }   
            else if(tel_slice == 0 && tel.length != 10){
                $("#tel_user_error").html("Số điện thoại phải có 10 số!");
                telflag = true;
                return false;
            }     
            else if(tel_slice != 0 && tel.length != 10){
                $("#tel_user_error").html("Số điện thoại không hợp lệ!");
                telflag = true;
                return false;
            }

            //Đểu ổn
            else{
                $("#tel_user_error").html("");
                telflag = false;
            }
        });                       

        //{name, email, tel, from_time, to_time, id}
        $("#formBook").on("submit", function(e){
            e.preventDefault();
            if(nameflag || emailflag || telflag || fromflag || toflag){
                $(".checkout_error").html("Hãy nhập đầy đủ các thông tin hợp lệ!");
                console.log( emailflag, nameflag, telflag, fromflag, toflag, now);
            
            }else if($("#name_user").val() == "" || $("#email_user").val() == "" || 
                    $("#tel_user").val() == "" || $("#from").val() == "" || $("#to").val() == ""){
                $(".checkout_error").html("Hãy nhập đầy đủ các thông tin hợp lệ!");
                console.log(nameflag, emailflag, telflag, fromflag, toflag);
            }else{
                $(".checkout_error").html("");
                console.log(nameflag, emailflag, telflag, fromflag, toflag);
                let name = $("#name_user").val();
                let email = $("#email_user").val();
                let tel = $("#tel_user").val();
                let room_name = $(".room_name").data("room_name");
                let currentTime = getLocalTimeString();
                
                //Vì datetimepicker và input bình thường không trả về giá trị đúng cho formdata
                //nên phải tách ra một bên formdata của datetimepick, một bên formdata của input thường
                //rồi gộp chúng lại
                let id = $("#select_room").val();
                let formData = new FormData(form);
                formData.append("select_room", id);
                let lastTwoEntries = [];

                //Gán tất cả trường vào lastTwoEntries
                for (let entry of formTimeData.entries()) {
                    lastTwoEntries.push(entry); 
                }

                // Lấy ra 2 trường dữ liệu cuối trong lastTwoEntries và gán vào formData
                for (let i = lastTwoEntries.length -2; i < lastTwoEntries.length; i++) {
                    let entry = lastTwoEntries[i];
                    let key = entry[0];
                    let value = entry[1];
                    // Chuyển giá trị của trường dữ liệu thành kiểu date
                    let valueSplit = value.split("/");
                    let valueYear = valueSplit[2];
                    let valueMonth = valueSplit[1] -1;
                    let valueDay = valueSplit[0];
                    // let dateValue = new Date(valueMonth, valueDay, valueYear);

                    const fromTime = '12:00:00';
                    const toTime = '14:00:00';

                    // Gán tên trường dữ liệu cùng với giá trị của nó sau định dạng
                    // Thêm from với giá trị định dạng
                    if (key === 'from') {
                        let fromDate = new Date(valueYear, valueMonth, valueDay);
                        let formattedFromDate = fromDate.toLocaleDateString('en-US', {
                            year: 'numeric',
                            month: '2-digit',
                            day: '2-digit'
                        }).split("/"); //Cắt nó ra thành mảng
                        let fromYear = formattedFromDate[2];
                        let fromMonth = formattedFromDate[0];
                        let fromDay = formattedFromDate[1];
                        //Gộp lại để được năm-tháng-ngày
                        formData.append(key, `${fromYear}-${fromMonth}-${fromDay} ${fromTime}`);
                    } else if (key === 'to') {
                        let toDate = new Date(valueYear, valueMonth, valueDay);
                        let formattedToDate = toDate.toLocaleDateString('en-US', {
                            year: 'numeric',
                            month: '2-digit',
                            day: '2-digit'
                    }).split("/"); //Cắt ra thành mảng
                        let toYear = formattedToDate[2];
                        let toMonth = formattedToDate[0];
                        let toDay = formattedToDate[1];
                        //Gộp lại để được năm-tháng-ngày
                        formData.append(key, `${toYear}-${toMonth}-${toDay} ${toTime}`);
                    } else {
                        // Thêm các trường khác như bình thường
                        formData.append(key, value);
                    }
                    formData.append("stay_sum", stay_sum);
                }
                formData.append("room_name", room_name);
                formData.append("act", guestFlag);
                formData.append("current_time", currentTime);

                $.ajax({
                    url: "Controller/user/booking.php?act=book_room",
                    method: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,                        
                    dataType: "JSON",
                    success: function(res){
                        console.log(res);
                        if(res.status == "success"){
                            Swal.fire({                                 
                                title: "Thành công!",
                                text: res.message,
                                icon: "success",
                                timer: 900,
                                timerProgressBar: true
                            }).then(function(){
                                window.location.reload();
                            });
                        }else if(res.status == 'booked'){
                            Swal.fire({                                 
                                title: "Thất bại!",
                                text: res.message,
                                icon: "error",
                                timer: 3200,
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
                            text: "Không thể chỉnh sửa, thêm mới",
                            icon: "error",
                            timer: 3200,
                            timerProgressBar: true
                        });
                    }
                })
            }
        });            
    })
</script>
