<?php
    set_include_path(get_include_path() . PATH_SEPARATOR . '../../Model/');
    spl_autoload_extensions('.php');    
    spl_autoload_register();

    $act = "admin_room_undo_list";
    if(isset($_GET['act'])){
        $act = $_GET['act'];
    }

    switch ($act) {
        case 'admin_room_undo_list':
            include_once "View/admin/admin_room_undo_list.php";
            break;
        case "undo_list":
            if(isset($_GET['booked_room_id'])){
                $_booked_room_id = $_GET['booked_room_id'];
                $room = new room();
                $undo_booked = $room->getUndoRoom();
                $result = array();
                $result = $undo_booked->fetch(PDO::FETCH_ASSOC);
                echo json_encode($result);
            }
            break;
        case "do_checkout":
            $booked_room_id = $_POST['booked_room_id'];
            $customer_booked_id = $_POST['customer_booked_id'];
            $email = $_POST['email'];
            $customer_sum = $_POST['customer_sum'];
            $arrive = $_POST['arrive'];
            $leave = $_POST['quit'];
            $left_at = $_POST['left_at'];
            $room_name = $_POST['room_name'];
            $customer_name = $_POST['customer_name'];
            $tel = $_POST['tel'];
            $checkout = new checkout();
 
            $result1 = $checkout->doCheckout($booked_room_id, $customer_booked_id, $email, $customer_sum, $arrive, $leave, $left_at, $room_name, $customer_name, $tel);
            // $result2 = $checkout->resetAfterCheckout($booked_room_id);
            if($result1){
                $res = array(
                    'status'=> 'success',
                    'message'=> 'Hãy xem hoá đơn tại Danh sách hoá đơn!'
                );
            }else{
                $res = array(
                    'status'=> 'fail',
                    'message'=> 'Thanh toán thất bại! Kiểm tra lại doCheckout và resetAfterCheckout!'
                );
            }
            echo json_encode($res);
            break;
    }
?>