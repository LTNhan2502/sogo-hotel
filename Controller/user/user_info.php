<?php
    set_include_path(get_include_path() . PATH_SEPARATOR . '../../Model/');
    spl_autoload_extensions('.php');    
    spl_autoload_register();

    $act = 'user_info';
    if(isset($_GET['act'])){
        $act = $_GET['act'];
    }

    switch($act){
        case "user_info":
            include_once "View/user/user_info.php";
            break;
        case "delete_action":
            session_start();
            if($_POST['customer_booked_id']){
                $customer_booked_id = $_POST['customer_booked_id'];
                $customers = new customers();
                $result = $customers->deleteCus($customer_booked_id);
                
                if($result){
                    unset($_SESSION['customer_id']);
                    unset($_SESSION['customer_email']);
                    unset($_SESSION['customer_booked_id']);
                    unset($_SESSION['customer_name']);
                    unset($_SESSION['customer_tel']);
                    $res = array(
                        'status' => 200,
                        'message' => "Xoá tài khoản thành công!"
                    );
                }else{
                    $res = array(
                        'status' => 403,
                        'message' => "Xoá tài khoản thất bại!"
                    );
                }
                echo json_encode($res);
            }
            break;
        case "change_info":            
            $customer_name = isset($_POST['customer_name']) ? $_POST['customer_name'] : '' ;
            $customer_tel = isset($_POST['customer_tel']) ? $_POST['customer_tel'] : '' ;
            $customer_gender = isset($_POST['customer_gender']) ? $_POST['customer_gender'] : '' ;
            $customer_birthday = isset($_POST['customer_birthday']) ? $_POST['customer_birthday'] : '' ;
            $customer_email = $_POST['customer_email'];
            $customers = new customers();
            $result = $customers->changeUserInfo($customer_email, $customer_name, $customer_tel, $customer_gender, $customer_birthday);

            if($result){
                $res = array(
                    'status' => 200,
                    'message' => 'Cập nhật thông tin mới thành công!'
                );
            }else{
                $res = array(
                    'status' => 403,
                    'message' => 'Cập nhật thông tin thất bại!'
                );
            }
            echo json_encode($res);
            break;
        case 'check_pass':
            if(isset($_POST['password_user_old']) && isset($_POST['email'])){
                $password = $_POST['password_user_old'];
                $email = $_POST['email'];
                $col = 'email';
                $customers = new customers();
                $customer = $customers->getCustomer($email, $col);
                $result = password_verify($password, $customer['password']);

                if($result){
                    $res = array(
                        'status' => 200,
                        'message' => 'Passed'
                    );
                }else{
                    $res = array(
                        'status' => 403,
                        'message' => 'Mật khẩu không đúng!'
                    );
                }
                echo json_encode($res);
            }
            break;
        case 'change_pass':
            if(isset($_POST['password_user_new']) && isset($_POST['customer_email'])){
                $password = $_POST['password_user_new'];
                $email = $_POST['customer_email'];
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $customers = new customers();
                $result = $customers->changePassword($email, $hashed_password);

                if($result){
                    unset($_SESSION['customer_id']);
                    unset($_SESSION['customer_email']);
                    unset($_SESSION['customer_booked_id']);
                    unset($_SESSION['customer_name']);
                    unset($_SESSION['customer_tel']);
                    $res = array(
                        'status' => 200,
                        'message' => 'Thay đổi  mật khẩu thành công'
                    );
                }else{
                    $res = array(
                        'status' => 403,
                        'message' => 'Không thể thay đổi mật khẩu!'
                    );
                }
                echo json_encode($res);
            }
            break;
    }
?>