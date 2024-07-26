<?php
    set_include_path(get_include_path() . PATH_SEPARATOR . '../../Model/');
    spl_autoload_extensions('.php');    
    spl_autoload_register();


    $act = "booking";
    if (isset($_GET["act"])) {
        $act = $_GET["act"];
    }
    switch ($act) {
        case "booking":
            include_once "View/user/booking.php";
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
            //Kiểm tra tồn tại email_guest
            $exist = $validate->checkEmail($email);//Bên model chỉ trả về câu lệnh SQL
            $exist->execute();//Thực thi câu lệnh SQL ở trên
            //Kiểm tra đăng kí email
            $signup = $validate->checkSignup($email);
            $signup->execute();
            //Trả về số cột
            $countExist = $exist->fetchColumn();
            $countSignup = $signup->fetchColumn();
           
            $res = array(
                'countExist' => $countExist,
                'countSignup' => $countSignup
            );
            echo json_encode($res);
            break;
        case 'book_room':
            if(isset($_POST['select_room']) && isset($_POST['name']) && isset($_POST['room_name']) && isset( $_POST['email_guest']) && isset($_POST['tel']) &&
             isset($_POST['from']) && isset($_POST['to']) && isset($_POST['stay_sum']) && isset($_POST['act']) && isset($_POST['current_time'])){
                $id = $_POST['select_room'];
                $name = $_POST['name'];
                $room_name = $_POST['room_name'];
                $email_guest = $_POST['email_guest'];
                $tel = $_POST['tel'];
                $arrive = $_POST['from'];
                $quit = $_POST['to'];
                $stay_sum = $_POST['stay_sum'];
                $act = $_POST['act'];
                $current_time = $_POST['current_time'];
                $col = 'room_id';
                $col_history = 'history';
                $col_member = 'email'; 
                $col_guest = 'email_guest';
                $room = new room();
                $customers = new customers(); 
                $room = new room();

                //Lấy ra price của phòng
                $getRoom = $room->getPrice($id);
                $price = $getRoom['price'];

                //Nếu là khách và là lần đầu tiên đặt phòng
                if($act == 0){
                    $getCustomer = $customers->addCustomer($name, $email_guest, $tel);    
                    if($getCustomer){
                        //Thêm room_id vào customers
                        // $booked_room = $room->addRoomID($id, $customer_id, $col);
                        $customer = $customers->getLastInsert();
                        $customer_id = $customer['customer_id'];
                        $customer_name = $customer['customer_name'];
                        $customer_booked_id = $customer['customer_booked_id'];
                        //Thêm thông tin vào table booked_room
                        $addBookedRoom = $room->bookRoom($id, $customer_id, $customer_booked_id, $customer_name, $tel, $email_guest, $room_name, $price, $stay_sum, $current_time, $arrive, $quit);
                        //Cập nhật thêm lịch sử đặt phòng
                        $booked_history = $room->addRoomID($id, $customer_id, $col_history);
                        //Thêm sum vào sau khi đặt phòng
                        // $customer_sum = $customers->updateSum($stay_sum, $customer_id);
                        if($addBookedRoom && $booked_history){
                            $res = array(
                                "status" => "success",
                                "message" => "Đặt phòng thành công!",
                                "customer_id" => $customer_id,
                            );
                        }else{
                            $res = array(
                                "status" => "booked",
                                "message" => "Đặt phòng hoặc thêm lịch sử đặt phòng gặp lỗi!",
                            );
                        }                    
                    }else{
                        $res = array(
                            "status" => "fail",
                            "message" => "Không thể thêm khách hàng mới!",
                            "customer_id" => $getCustomer
                        );
                    }
                }
                //Nếu là khách và đã từng đặt phòng             
                else if($act == 1){
                    // $result_room = $room->updateTime($id, $arrive, $quit);
                    // $customer = $customers->updateGuest($name, $email_guest, $tel); 
                    $cust = $customers->getCustomer($email_guest, $col_guest); 
                    $customer_id = $cust['customer_id'];
                    $customer_name = $cust['customer_name'];
                    $customer_booked_id = $cust['customer_booked_id'];

                    //Thêm id của phòng vào room_id của customer
                    if($cust['history'] == null){
                        $id_history = $id;
                    }else{
                        $id_history = $cust['history'].' - '.$id;
                    }
                    //Thực hiện đặt phòng
                    $addBookedRoom = $room->bookRoom($id, $customer_id, $customer_booked_id, $customer_name, $tel, $email_guest, $room_name, $price, $stay_sum, $current_time, $arrive, $quit);

                    //Cập nhật thêm lịch sử đặt phòng
                    $booked_history = $room->addRoomID($id_history, $customer_id, $col_history);
                    // $customer_sum = $customers->updateSum($stay_sum, $customer_id);

                    if($addBookedRoom && $booked_history){
                        $res = array(
                            "status" => "success",
                            "message" => "Đặt phòng thành công!",
                            "customer_id" => $customer_id,
                        );
                    }else{
                        $res = array(
                            "status" => "booked",
                            "message" => "Đặt phòng hoặc thêm lịch sử đặt phòng gặp lỗi!",
                        );
                    }                    
                    
                }
                //Nếu khách là member                
                else if($act == 2){
                    // $result_room = $room->updateTime($id, $arrive, $quit);
                    // $customer = $customers->updateMember($email_guest); 
                    $cust = $customers->getCustomer($email_guest, $col_member); 
                    $customer_name = $cust['customer_name'];
                    $customer_booked_id = $cust['customer_booked_id'];
                    $customer_id = $cust['customer_id'];                      
                    //Thêm id của phòng vào room_id, history của customer và tính sum
                    if($cust['history'] == null){
                        $id_history = $id;
                    }else{
                        $id_history = $cust['history'].' - '.$id;
                    }
                    //Thực hiện đặt phòng
                    $addBookedRoom = $room->bookRoom($id, $customer_id, $customer_booked_id, $customer_name, $tel, $email_guest, $room_name, $price, $stay_sum, $current_time, $arrive, $quit);
                    //Thêm lịch sử đặt phòng
                    $booked_history = $room->addRoomID($id_history, $customer_id, $col_history);
                    //Tính tổng
                    // $customer_sum = $customers->updateSum($stay_sum, $customer_id);

                    if($addBookedRoom && $booked_history){
                        // $setFull = $room->moveRoom($id);
                        $res = array(
                            "status" => "success",
                            "message" => "Đặt phòng thành công!",
                            "customer_id" => $customer_id,
                        );
                    }else{
                        $res = array(
                            "status" => "booked",
                            "message" => "Đặt phòng hoặc thêm lịch sử đặt phòng gặp lỗi!",
                        );
                    } 
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