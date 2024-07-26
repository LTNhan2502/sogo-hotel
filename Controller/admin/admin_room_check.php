<?php
    set_include_path(get_include_path() . PATH_SEPARATOR . '../../Model/');
    spl_autoload_extensions('.php');    
    spl_autoload_register();

    $act = "admin_room_check";
    if(isset($_GET['act'])){
        $act = $_GET['act'];
    }
    switch ($act) {
        case 'admin_room_check':
            include_once "View/admin/admin_room_check.php";
            break;
        case "approve_arrive":
            if(isset($_POST['booked_room_id'])){
                $booked_room_id = $_POST['booked_room_id'];

                $customer = new customers(); 
                $receive = $customer->confirmReceive($booked_room_id);
                if($receive){
                    $res = array(
                        "status" => "success",
                        "message" => "Xác nhận thành công!"
                    );
                }else{
                    $res = array(
                        "status" => "fail",
                        "message" => "Hàm confirmReceive gặp vấn đề!"
                    );
                }
                echo json_encode($res);
            }
            break;
        case "undo_approve_arrive":
            if(isset($_POST['booked_room_id'])){
                $booked_room_id = $_POST['booked_room_id'];
                // print_r($customer_booked_id);exit;

                $customer = new customers(); 
                $receive = $customer->undoReceive($booked_room_id);
                // print($receive);exit;
                if($receive){
                    $res = array(
                        "status" => "success",
                        "message" => "Huỷ nhận phòng thành công!"
                    );
                }else{
                    $res = array(
                        "status" => "fail",
                        "message" => "Hàm undoReceive gặp vấn đề!"
                    );
                }
                echo json_encode($res);
            }
            break;
        case "approve_leave":
            if(isset($_POST['booked_room_id'])){
                $booked_room_id = $_POST['booked_room_id'];
                // print_r($customer_booked_id);exit;

                $customer = new customers(); 
                $receive = $customer->confirmLeave($booked_room_id);
                // print($receive);exit;
                if($receive){
                    $res = array(
                        "status" => "success",
                        "message" => "Xác nhận thành công!"
                    );
                }else{
                    $res = array(
                        "status" => "fail",
                        "message" => "Hàm confirmLeave gặp vấn đề hoặc do id của thẻ!"
                    );
                }
                echo json_encode($res);
            }
            break;
        case "undo_approve_leave":
            if(isset($_POST['booked_room_id'])){
                $booked_room_id = $_POST['booked_room_id'];
                // print_r($customer_booked_id);exit;

                $customer = new customers(); 
                $receive = $customer->undoLeave($booked_room_id);
                // print($receive);exit;
                if($receive){
                    $res = array(
                        "status" => "success",
                        "message" => "Huỷ trả phòng thành công!"
                    );
                }else{
                    $res = array(
                        "status" => "fail",
                        "message" => "Hàm undoLeave gặp vấn đề hoặc do id của thẻ!"
                    );
                }
                echo json_encode($res);
            }
            break;
        case "undo_book":
            if(isset($_POST["booked_room_id"])){
                $booked_room_id = $_POST["booked_room_id"];
                $room = new room();
        
                $undo = $room->undoBookedRoom($booked_room_id);
                if ($undo) {
                    $res = [
                        'status' => 'success',
                        'message' => "Hãy vào quản lí hoá đơn để xem hoá đơn thanh toán!"
                    ];
                } else {
                    $res = array(
                        "status" => "fail",
                        "message" => "Xem lại hàm undoBookedRoom, left_at, url, id thẻ!"
                    );
                }
                echo json_encode($res);
            }
            break; 
        case "cancel_book":
            if(isset($_POST["booked_room_id"])){
                $booked_room_id = $_POST["booked_room_id"];
                $room = new room();
        
                $undo = $room->cancelBookedRoom($booked_room_id);
                if ($undo) {
                    $res = [
                        'status' => 'success',
                        'message' => "Phòng đã bị huỷ!"
                    ];
                } else {
                    $res = array(
                        "status" => "fail",
                        "message" => "Xem lại hàm cancelBookedRoom, left_at, url, id thẻ!"
                    );
                }
                echo json_encode($res);
            }
            break; 
        case "undo_cancel":
            if(isset($_POST["booked_room_id"])){
                $booked_room_id = $_POST["booked_room_id"];
                $room = new room();
        
                $undo = $room->undoCancelBookedRoom($booked_room_id);
                if ($undo) {
                    $res = [
                        'status' => 'success',
                        'message' => "Hoàn tác huỷ phòng thành công!"
                    ];
                } else {
                    $res = array(
                        "status" => "fail",
                        "message" => "Xem lại hàm undoCancelBookedRoom, left_at, url, id thẻ!"
                    );
                }
                echo json_encode($res);
            }
            break; 
        case "pages":
            if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['page'])) {
                $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
                $items_per_page = 5;
                $start = ($page - 1) * $items_per_page;
    
                $room = new room();
                $fmt = new formatter();
                $result = $room->getBookedRoomsPage($start, $items_per_page);
    
                $count = $start + 1; // Bắt đầu đếm từ trang hiện tại
                while ($set = $result->fetch()) {
                    echo '<tr style="max-height: 100px">';
                    echo '<td>' . $count . '</td>';
                    echo '<td>';
                    echo '<div>ID đặt phòng: <span class="badge badge-pill badge-primary booked_room_id" data-id="' . $set['booked_room_id'] . '">' . $set['booked_room_id'] . '</span></div>';
                    echo '<div>ID khách hàng: <span class="badge badge-pill badge-primary customer_booked_id" data-customer_booked_id="' . $set['booked_customer_id'] . '">' . $set['booked_customer_id'] . '</span></div>';
                    echo '<div class="customer_name" data-customer_name="' . $set['booked_customer_name'] . '"><span class="text-decoration-underline" style="font-weight: 900">Tên KH:</span> ' . $set['booked_customer_name'] . '</div>';
                    echo '<div class="tel" data-tel="' . $set['booked_tel'] . '">Số điện thoại: ' . $set['booked_tel'] . '</div>';
                    echo '<div id="customer_email" data-email="' . $set['booked_email'] . '">Email: ' . $set['booked_email'] . '</div>';
                    echo '</td>';
                    echo '<td>';
                    echo '<div class="room_name" data-room_name="' . $set['booked_room_name'] . '"><span class="text-decoration-underline" style="font-weight: 900">Phòng:</span> ' . $set['booked_room_name'] . '</div>';
                    echo '<div>Giá: ' . $fmt->formatCurrency($set['booked_price']) . 'đ</div>';
                    echo '<div class="customer_sum" data-customer_sum="' . $set['booked_sum'] . '"><span class="text-decoration-underline" style="font-weight: 900">Tổng:</span> ' . $fmt->formatCurrency($set['booked_sum']) . 'đ</div>';
                    echo '</td>';
                    echo '<td>';
                    echo '<div class="arrive" data-arrive="' . $set['booked_arrive'] . '">Ngày vào: ' . $set['booked_arrive'] . '</div>';
                    echo '<div class="quit" data-quit="' . $set['booked_quit'] . '">Ngày trả: ' . $set['booked_quit'] . '</div>';
                    echo '<div><span class="text-decoration-underline" style="font-weight: 900">Tình trạng:</span>';
                    if ($set['booked_session'] == 1 && $set['booked_done_session'] == 0) {
                        echo '<span class="badge badge-pill badge-info" id="badge_receive">Đã nhận</span>';
                    } else if ($set['booked_session'] == 0 && $set['booked_done_session'] == 1) {
                        echo '<span class="badge badge-pill badge-success" id="badge_receive">Đã trả</span>';
                    } else if ($set['booked_session'] == 0 && $set['booked_done_session'] == 0) {
                        echo '<span class="badge badge-pill badge-warning" id="badge_receive">Chưa nhận</span>';
                    }
                    echo '</div>';
                    echo '</td>';
                    echo '<td>';
                    if ($set['booked_session'] == 0 && $set['booked_done_session'] == 0) {
                        echo '<button class="btn btn-outline-primary btn-same text-start mb-2 button_receive" id="receive"><i class="far fa-check-circle"></i> Xác nhận nhận phòng</button><br>';
                        echo '<button class="btn btn-outline-primary btn-same text-start mb-2 button_leave" id="leave" disabled><i class="far fa-check-circle"></i> Xác nhận trả phòng</button><br>';
                    } else if ($set['booked_session'] == 1 && $set['booked_done_session'] == 0) {
                        echo '<button class="btn btn-danger btn-same text-start mb-2 button_receive" id="undo_receive"><i class="far fa-times-circle"></i> Huỷ nhận phòng</button><br>';
                        echo '<button class="btn btn-outline-primary btn-same text-start mb-2 button_leave" id="leave"><i class="far fa-check-circle"></i> Xác nhận trả phòng</button><br>';
                    } else if ($set['booked_session'] == 0 && $set['booked_done_session'] == 1) {
                        echo '<button class="btn btn-outline-primary btn-same text-start mb-2 button_receive" id="receive" disabled><i class="far fa-check-circle"></i> Xác nhận nhận phòng</button><br>';
                        echo '<button class="btn btn-danger btn-same text-start mb-2 button_leave" id="undo_leave"><i class="far fa-check-circle"></i> Huỷ trả phòng</button><br>';
                    }
    
                    if ($set['booked_session'] == 0 && $set['booked_done_session'] == 1) {
                        echo '<button class="btn btn-outline-danger btn-same text-start button_recover" id="undo_book"><i class="fas fa-reply"></i> Thu hồi phòng</button>';
                    } else {
                        echo '<button class="btn btn-outline-danger btn-same text-start button_recover" disabled id="undo_book"><i class="fas fa-reply"></i> Thu hồi phòng</button>';
                    }
                    echo '</td>';
                    echo '</tr>';
                    $count++;
                }
    
    
            }
            break; 
    }
            
        
?>