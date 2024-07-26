<link rel="stylesheet" href="content/user/css/user-info.css">
<link rel="stylesheet" href="Content/user/css/room_card.css">

<?php
    $customers = new customers();
    $room = new room();
    $fmt = new formatter();
    $col_email = 'email';
    if(isset($_SESSION['customer_id'])){
        $getUser = $customers->getCustomer($_SESSION['customer_email'], $col_email);
        // $user = $getUser->fetch();
?>
<div class="body">
    <aside class="sidebar">
        <div class="profile">
            <div class="avatar">
                <span><i class="fas fa-user"></i></span>
            </div>
            <div class="profile-info">
                <h3><?php echo $_SESSION['customer_name']; ?></h3>
                <p id="customer_email" data-customer_email="<?php echo $_SESSION['customer_email']; ?>"><?php echo $_SESSION['customer_email']; ?></p>
                <div class="d-none" id="customer_booked_id" data-customer_booked_id="<?php echo $_SESSION['customer_booked_id']; ?>"></div>
            </div>
        </div>
        <div class="d-flex align-items-start sidebar-menu">
            <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <button class="nav-link active btn btn-custom" id="v-pills-home-tab" data-toggle="pill" data-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true"><i class="fas fa-hotel"></i> Phòng đã đặt</a></button>
                <button class="nav-link btn btn-custom" id="v-pills-profile-tab" data-toggle="pill" data-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false"><i class="fas fa-tags"></i> Khuyến mãi</a></button>
                <button class="nav-link btn btn-custom" id="v-pills-messages-tab" data-toggle="pill" data-target="#v-pills-messages" type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false"><i class="fas fa-user"></i> Tài khoản</a></button>
                <button class="nav-link btn btn-custom"><a href="#" id="logout_button" class="text-dark"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a></button>
            </div>
        </div>
        <!-- <nav class="sidebar-menu"> -->
            <!-- <ul> -->
                <!-- <li><a href="#"><i class="fas fa-star"></i> Điểm thưởng của tôi</a></li> -->
                <!-- <li><a href="#"><i class="fas fa-hotel"></i> Phòng đã đặt</a></li> -->
                <!-- <li><a href="#"><i class="fas fa-list"></i> Danh sách giao dịch</a></li> -->
                <!-- <li><a href="#"><i class="fas fa-bell"></i> Thông báo giá vé máy bay</a></li> -->
                <!-- <li><a href="#"><i class="fas fa-user-friends"></i> Thông tin hành khách đã lưu</a></li> -->
                <!-- <li><a href="#"><i class="fas fa-tags"></i> Khuyến mãi</a></li> -->
                <!-- <li class="active"><a href="#"><i class="fas fa-user"></i> Tài khoản</a></li> -->
                <!-- <li><a href="#" id="logout_button"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a></li> -->
            <!-- </ul> -->
        <!-- </nav> -->
    </aside>
    <div class="container-main">
        <main class="main-content">
            <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                <!-- Start Phòng đã đặt -->
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link active" id="nav-home-tab" data-toggle="tab" data-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Phòng vừa đặt</button>
                            <button class="nav-link" id="nav-profile-tab" data-toggle="tab" data-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Phòng đã từng đặt</button>
                            <button class="nav-link" id="nav-profile-tab" data-toggle="tab" data-target="#nav-cancel_room" type="button" role="tab" aria-controls="nav-cancel_room" aria-selected="false">Phòng đã huỷ</button>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                            <!-- Start Phòng vừa đặt -->
                            <div id="room_cards" class="card-container-user-info">
                                <?php
                                    $history_arr = explode(' - ', $getUser['history']);
                                    $history_count = count($history_arr);  
                                    
                                    $result = $room->getRoomsJustBooked($_SESSION['customer_id']);
                                    if($result->rowCount() != 0){  
                                        $history_room = $result->fetch();                                                          
                                ?>
                                        <div class="card mb-3 room_card_list">
                                            <div class="row g-0" style="width: 100%;">
                                                <div class="col-md-3">
                                                    <img src="Content/images/<?php echo $history_room['img']; ?>"
                                                        class="img-fluid rounded-start" alt="...">
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="card-body">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <h6 class="card-title pt-2"><?php echo $history_room['name']; ?></h6>
                                                            <span class="badge badge-pill badge-danger" id="button_cancel" style="padding: 4px 6px; font-size: 1em; margin-left: 10px;">Huỷ phòng</span>
                                                        </div>
                                                        <table>
                                                            <tr>
                                                                <td><p><?php echo $history_room['square_meter']; ?>m²</p></td>
                                                                <td><p><?php echo $history_room['quantity']; ?> khách</p></td>
                                                            </tr>
                                                            <tr>
                                                                <td><p>Lúc vào: <?php echo $history_room['booked_arrive']; ?></p></td>
                                                                <td><p>Lúc ra: <?php echo $history_room['booked_quit']; ?></p></td>
                                                            </tr>
                                                            <tr>
                                                                <td><p>Lúc đặt: <?php echo $history_room['booked_time_book']; ?></p></td>
                                                                <td><p><strong>Tổng: <?php echo $fmt->formatCurrency($history_room['booked_sum']); ?>VND</strong></p></td>
                                                            </tr>
                                                        </table>                                                            
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                <?php   }
                                    
                                    if($result->rowCount()==0){
                                        echo '<div><h3 class="text-center">Không có thông tin!</h3></div>';
                                    }
                                ?>
                            </div>  
                             <!-- End Phòng vừa đặt -->
                        </div>
                        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                            <!-- Start Phòng đã từng đặt -->
                            <div id="room_cards" class="card-container-user-info">
                                <?php
                                    $history_arr = array_unique(explode(' - ', $getUser['history'])); // Loại bỏ các giá trị trùng lặp
                                    $history_count = count($history_arr);
                                    $booked_customer_id = $_SESSION['customer_booked_id'];
                                    
                                    // Mảng để lưu trữ kết quả cuối cùng
                                    $final_results = [];

                                    // Thực hiện truy vấn cho mỗi ID phòng trong lịch sử
                                    foreach ($history_arr as $room_id) {
                                        $result = $room->getHistoryRoomsForUser($room_id, $booked_customer_id);
                                        if ($result) {
                                            // Fetch tất cả kết quả có thể có cho một ID phòng cụ thể
                                            while ($history_room = $result->fetch(PDO::FETCH_ASSOC)) {
                                                // Lưu kết quả vào mảng cuối cùng
                                                $final_results[] = $history_room;
                                            }
                                        }
                                    }
                                    
                                    if(count($final_results) > 0){
                                        foreach ($final_results as $rooms) {                                                        
                                ?>
                                        <div class="card mb-3 room_card_list">
                                            <div class="row g-0" style="width: 100%;">
                                                <div class="col-md-3">
                                                    <img src="Content/images/<?php echo $rooms['img']; ?>"
                                                        class="img-fluid rounded-start" alt="...">
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="card-body">
                                                        <h6 class="card-title pt-2"><?php echo $rooms['name']; ?></h6>
                                                        <table>
                                                            <tr>
                                                                <td><p><?php echo $rooms['square_meter']; ?>m²</p></td>
                                                                <td><p><?php echo $rooms['quantity']; ?> khách</p></td>
                                                            </tr>
                                                            <tr>
                                                                <td><p>Lúc vào: <?php echo $rooms['booked_arrive']; ?></p></td>
                                                                <td><p>Lúc ra: <?php echo $rooms['booked_quit']; ?></p></td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <?php
                                                                        if(isset($rooms['booked_left_at'])){
                                                                    ?>
                                                                    <p>Thanh toán: <?php echo $rooms['booked_left_at']; ?></p>
                                                                    <?php
                                                                        }else{
                                                                            echo "<p style='text-decoration: underline; font-weight: bold;'>Chưa thanh toán</p>";
                                                                        }
                                                                    ?>
                                                                </td>
                                                                <td><p><strong>Tổng: <?php echo $fmt->formatCurrency($rooms['booked_sum']); ?>VND</strong></p></td>
                                                            </tr>
                                                        </table>                                                            
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                <?php   }
                                    }else{
                                        echo '<div><h3 class="text-center">Không có thông tin!</h3></div>';
                                    }
                                ?>
                            </div>  
                            <!-- End Phòng đã từng đặt -->
                        </div>
                        <div class="tab-pane fade" id="nav-cancel_room" role="tabpanel" aria-labelledby="nav-profile-tab">
                            <!-- Start Phòng đã huỷ -->
                            <div id="room_cards" class="card-container-user-info">
                                <?php
                                    $history_arr = explode(' - ', $getUser['history']);
                                    $history_count = count($history_arr);  
                                    
                                    $result = $room->getRoomsCanceled($_SESSION['customer_id']);
                                    if($result->rowCount() != 0){  
                                        $history_room = $result->fetch();                                                          
                                ?>
                                        <div class="card mb-3 room_card_list">
                                            <div class="row g-0" style="width: 100%;">
                                                <div class="col-md-3">
                                                    <img src="Content/images/<?php echo $history_room['img']; ?>"
                                                        class="img-fluid rounded-start" alt="...">
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="card-body">
                                                        <h6 class="card-title pt-2"><?php echo $history_room['name']; ?></h6>
                                                        <table>
                                                            <tr>
                                                                <td><p><?php echo $history_room['square_meter']; ?>m²</p></td>
                                                                <td><p><?php echo $history_room['quantity']; ?> khách</p></td>
                                                            </tr>
                                                            <tr>
                                                                <td><p>Lúc vào: <?php echo $history_room['booked_arrive']; ?></p></td>
                                                                <td><p>Lúc ra: <?php echo $history_room['booked_quit']; ?></p></td>
                                                            </tr>
                                                            <tr>
                                                                <td><p>Lúc huỷ: <?php echo $history_room['booked_cancel_time']; ?></p></td>
                                                                <td><p><strong>Tổng: <?php echo $fmt->formatCurrency($history_room['booked_sum']); ?>VND</strong></p></td>
                                                            </tr>
                                                        </table>                                                            
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                <?php   }
                                    
                                    if($result->rowCount()==0){
                                        echo '<div><h3 class="text-center">Không có thông tin!</h3></div>';
                                    }
                                ?>
                            </div>  
                            <!-- End Phòng đã huỷ -->
                        </div>
                    </div>
                <!-- End Phòng đã đặt -->
                </div>
                <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                    <!-- Start Khuyến mãi -->
                        <div><h3 class="text-center">Không có thông tin!</h3></div>
                    <!-- End khuyến mãi -->
                </div>
                <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                    <!-- Start Tài khoản -->
                    <div class="settings-header">
                        <h1>Cài đặt</h1>
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="home-tab" data-toggle="tab" data-target="#home"
                                    type="button" role="tab" aria-controls="home" aria-selected="true">Thông tin tài khoản</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="profile-tab" data-toggle="tab" data-target="#profile" type="button"
                                    role="tab" aria-controls="profile" aria-selected="false">Mật khẩu</button>
                            </li>
                            <!-- <li class="nav-item" role="presentation">
                                <button class="nav-link" id="contact-tab" data-toggle="tab" data-target="#contact" type="button"
                                    role="tab" aria-controls="contact" aria-selected="false">Contact</button>
                            </li> -->
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <div class="settings-content mt-2">
                                    <div class="notification">
                                        <p>
                                            <i class="fas fa-bell"></i> Bạn muốn nhận thông báo đăng nhập mới và các hoạt động
                                            khác của tài khoản? <a href="#">Cho phép gửi thông báo trên máy tính</a>
                                        </p>
                                    </div>
                                    <form id="changeInfoForm">
                                        <h2>Dữ liệu cá nhân</h2>
                                        <!-- Tên -->
                                        <div class="form-group">
                                            <label for="full-name">Tên đầy đủ</label>
                                            <input type="text" name="customer_name" id="customer_name" value="<?php echo $_SESSION['customer_name']; ?>">
                                            <small class="text-danger" id="customer_name_error"></small>
                                        </div>

                                        <!-- Số điện thoại -->
                                        <div class="form-group">
                                            <label for="">Số điện thoại</label>
                                            <input type="text" name="customer_tel" id="customer_tel" value="<?php echo $getUser['tel'] ?>">
                                            <small class="text-danger" id="customer_tel_error"></small>
                                        </div>

                                        <!-- Giới tính -->
                                        <div class="form-group">
                                            <label for="gender">Giới tính</label>
                                            <select name="customer_gender" id="customer_gender">
                                                <option value="0">Chọn giới tính</option>
                                                <?php 
                                                    $gender = $customers->getGender();
                                                    $customer = $customers->getCustomer($_SESSION['customer_email'], $col_email);
                                                    while($set = $gender->fetch()):
                                                ?>
                                                <option value="<?php echo $set['gender_id'] ?>"
                                                    <?php echo $customer['customer_gender'] == $set['gender_id'] ? 'selected' : ''; ?>><?php echo $set['gender_name']; ?></option>
                                                <?php endwhile; ?>
                                            </select>
                                            <small class="text-danger" id="customer_gender_error"></small>
                                        </div>

                                        <!-- Ngày sinh -->
                                        <div class="form-group">
                                            <label for="birthday">Ngày sinh</label>
                                            <input type="text" name="customer_birthday" id="customer_birthday" value="<?php echo $customer['customer_birthday']; ?>">
                                            <small class="text-danger" id="customer_birthday_error"></small>
                                        </div>
                                        
                                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                            <small id="info_all_error" class="text-danger mt-4 mr-2 me-md-2"></small>
                                            <button class="mt-3 btn btn-save me-md-2" type="submit"  name="submit" id="submitInfo">
                                                Lưu
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <h2>Đổi mật khẩu</h2>
                                <form class="form" id="changePassForm">
                                    <!-- Mật khẩu cũ -->
                                    <div class="flex-column">
                                        <label>Mật khẩu cũ</label>
                                    </div>
                                    <div class="inputForm">
                                        <input type="password" class="input" id="password_user_old">
                                        <svg viewBox="0 0 576 512" height="1em" xmlns="http://www.w3.org/2000/svg" id="showPass_old"
                                            style="cursor:pointer;">
                                            <path
                                                d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z">
                                            </path>
                                        </svg>
                                    </div>
                                    <small class="text-danger" id="password_old_error"></small>

                                    <!-- Mật khẩu mới -->
                                    <div class="flex-column">
                                        <label>Mật khẩu mới</label>
                                    </div>
                                    <div class="inputForm">
                                        <input type="password" class="input" name="password_user_new" id="password_user_new">
                                        <svg viewBox="0 0 576 512" height="1em" xmlns="http://www.w3.org/2000/svg" id="showPass_new"
                                            style="cursor:pointer;">
                                            <path
                                                d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z">
                                            </path>
                                        </svg>
                                    </div>
                                    <small class="text-danger" id="password_new_error"></small>

                                    <!-- Xác nhận mật khẩu mới -->
                                    <div class="flex-column">
                                        <label>Xác nhận mật khẩu mới</label>
                                    </div>
                                    <div class="inputForm">
                                        <input type="password" class="input" id="password_user_confirm">
                                        <svg viewBox="0 0 576 512" height="1em" xmlns="http://www.w3.org/2000/svg" id="showPass_confirm"
                                            style="cursor:pointer;">
                                            <path
                                                d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z">
                                            </path>
                                        </svg>
                                    </div>
                                    <small class="text-danger" id="password_confirm_error"></small>
                                    
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <small id="password_all_error" class="text-danger mt-4 mr-2 me-md-2"></small>
                                        <button class="mt-3 btn btn-save me-md-2" type="submit"  name="submit" id="submitPass">
                                            Lưu
                                        </button>
                                    </div>
                                </form>
                                <hr>
                                <h2>Xóa tài khoản</h2>
                                <div class="delete-group">
                                    <p class="delete-account">Sau khi tài khoản của bạn bị xóa, bạn sẽ không thể lấy lại dữ liệu
                                        của mình. Hành động này không thể hoàn tác.</p>
                                    <button type="button" class="btn btn-danger" id="delete_account">Xoá</button>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">cxcxc</div> -->
                    </div>
                    <!-- End Tài khoản -->
                </div>
                <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">.sds..</div>
            </div>
            
        </main>
    </div>
</div>
<?php }else{ ?>
<div class="card text-center" style="margin: 9rem 4rem 3rem 4rem;">
    <div class="card-header">
        Yêu cầu đăng nhập
    </div>
    <div class="card-body">
        <p class="card-text">Để vào được trang này bạn cần phải đăng nhập!</p>
        <a href="index.php?action=login" class="btn btn-primary">Đăng nhập</a>
        <p>Không có tài khoản?</p>
        <a href="index.php?action=signup" class="btn btn-primary">Đăng kí</a>
    </div>
</div>
<?php } ?>

<script src="ajax/account/user_info.js"></script>
<script src="ajax/room/approve.js"></script>
<script>
    $(document).ready(function () {
        let isShow = false;
        let isreShow = false;
        //Hiển thị pass
        function showPass(btn, input) {
            $(document).on("click", btn, function () {
                if (isShow == false) {
                    $(input).attr("type", "text");
                    isShow = true;
                }
                else {
                    $(input).attr("type", "password");
                    isShow = false;
                }
            });
        }

        //Hiển thị pass cũ
        showPass("#showPass_old", "#password_user_old");
        showPass("#showPass_new", "#password_user_new");
        showPass("#showPass_confirm", "#password_user_confirm"); 
        
    })
</script>