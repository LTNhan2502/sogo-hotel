<?php
    set_include_path(get_include_path() . PATH_SEPARATOR . '../../Model/');
    spl_autoload_extensions('.php');    
    spl_autoload_register();


    $act = "admin_room_book";
    if (isset($_GET["act"])) {
        $act = $_GET["act"];
    }
    switch ($act) {
        case "admin_room_book":
            include_once "View/admin/admin_room_book.php";
            break;
        case "show_detail":
            if(isset($_GET["value_id"])){
                $id = $_GET['value_id'];
                $room = new room();
                $result = $room->getDetailRooms($id);
                $results = array();
                //fetchAll(): Thực hiện câu lệnh SQL ở trên và trả ra mảng kết hợp [{...}] => cần truy cập vào mảng -> đối tượng
                //fetch(): Thực hiện câu lệnh SQL ở trên và trả ra đối tượng
                $results = $result->fetch(PDO::FETCH_ASSOC);
                echo json_encode($results); //Chuyển thành kiểu JSON trả về cho AJAX
            }
            if(isset($_GET['service_id'])){
                $id = $_GET['service_id'];
                $room = new room();
                $result = $room->getDetailRooms($id);
                $results = array();
                //fetchAll(): Thực hiện câu lệnh SQL ở trên và trả ra mảng kết hợp [{...}] => cần truy cập vào mảng -> đối tượng
                //fetch(): Thực hiện câu lệnh SQL ở trên và trả ra đối tượng
                $results = $result->fetch(PDO::FETCH_ASSOC);
                echo json_encode($results); //Chuyển thành kiểu JSON trả về cho AJAX
            }            
            break;
        case 'check_email':
            $email = $_POST['email'];
            $validate = new validate();
            $customers = new customers();
            $col_email = 'email';
            $col_guest = 'email_guest';
            //Kiểm tra tồn tại email_guest
            $exist = $validate->checkEmail($email);//Bên model chỉ trả về câu lệnh SQL
            $exist->execute();//Thực thi câu lệnh SQL ở trên
            //Kiểm tra đăng kí email (đã có email hay chưa)
            $signup = $validate->checkSignup($email);
            $signup->execute();
            //Trả về số cột
            $countExist = $exist->fetchColumn();
            $countSignup = $signup->fetchColumn();
           
            if($countExist == 1 && $countSignup == 0){
                $customer = $customers->getCustomer($email, $col_guest);
                $res = array(
                    'countExist' => $countExist,
                    'countSignup' => $countSignup,
                    'data_customer_name' => $customer['customer_name'],
                    'data_customer_tel' => $customer['tel']
                );
            }else if($countExist == 0 && $countSignup == 1){
                $customer = $customers->getCustomer($email, $col_email);
                $res = array(
                    'countExist' => $countExist,
                    'countSignup' => $countSignup,
                    'data_customer_name' => $customer['customer_name'],
                    'data_customer_tel' => $customer['tel']
                );
            }else{
                $res = array(
                    'countExist' => $countExist,
                    'countSignup' => $countSignup,
                    'data_customer_name' => '',
                    'data_customer_tel' => ''
                );
            }
            // echo json_encode($customer);
            echo json_encode($res);
            break;
        case 'book_room':
            if(isset($_POST['select_room']) && isset($_POST['name']) && isset( $_POST['email']) && 
            isset($_POST['tel']) && isset($_POST['from']) && isset($_POST['to'])){
                $id = $_POST['select_room'];
                $name = $_POST['name'];
                $email = $_POST['email'];
                $tel = $_POST['tel'];
                $arrive = $_POST['from'];
                $quit = $_POST['to'];
                $room = new room();
                $customer = new customers(); 
                $col = 'room_id';
                $result_room = $room->updateTime($id, $arrive, $quit);
                $customer_id = $customer->addCustomer($name, $email, $tel);
                // print_r($customer_id);exit;

                //Nhớ chỉnh lại addRoomID check phòng đã đưa vào hoạt động

                if($result_room && $customer_id){
                    $booked_room = $room->addRoomID($id, $customer_id, $col);
                    $res = array(
                        "status" => "success",
                        "message" => "Đặt phòng thành công!",
                        "customer_id" => $customer_id
                    );
                }else{
                    $res = array(
                        "status" => "fail",
                        "message" => "Chưa thêm KH hoặc chưa chỉnh sửa lại thời gian trong room!",
                        "customer_id" => $customer_id
                    );
                }
                echo json_encode($res);
            }   
            break;
        case "update_sum":
            $stay_sum =  $_POST['stay_sum'];
            $customers = new customers();
            $customer = $customers->getLastInsert();
            $customer_id = $customer['customer_id'];
            $customer_sum = $customers->updateSum($stay_sum, $customer_id);
            // print_r($customer_sum);exit;
            if($customer_sum){
                $res = array(
                    'status' => 'success',
                    'message'=> 'Tổng tiền đã có!'
                );
            }else{
                $res = array(
                    'status'=> 'fail',
                    'message'=> 'Tổng tiền chưa có!'
                );
            }
            echo json_encode($res);
            break;
    }
?>