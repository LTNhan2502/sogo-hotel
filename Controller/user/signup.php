<?php
    set_include_path(get_include_path() . PATH_SEPARATOR . '../../Model/');
    spl_autoload_extensions('.php');    
    spl_autoload_register();

    $act = "signup";
    if(isset($_GET['act'])){
        $act = $_GET['act'];
    }

    switch($act){
        case "signup":
            include_once "View/user/signup.php";
            break;
        case "signup_action":
            if(isset($_POST['name_user_signup']) && isset($_POST['email_user_signup']) && isset($_POST['password_user_signup'])){
                $customer_name = $_POST['name_user_signup'];
                $email = $_POST['email_user_signup'];
                $password = $_POST['password_user_signup'];
                $alreadyGuest = 0;
                
                //Mã hoá password
                $pass_hash = password_hash($password, PASSWORD_DEFAULT);
                
                $customers = new customers();
                $all_cus = $customers->getAllCus();     
                $cus = $all_cus->fetchAll(PDO::FETCH_ASSOC);

                //Kiểm tra có bất kì record nào đã có email/email_guest giống với $email
                foreach($cus as $cust){
                    if($cust['email_guest'] == $email && $cust['email'] == null){
                        //Đã có email tại email_guest
                        $alreadyGuest = 1;
                    }else if($cust['email_guest'] == null && $cust['email'] == null){
                        //Chưa có email
                        $alreadyGuest = 2;
                    }
                }
                
                //Đăng kí khi user chưa từng đặt phòng
                if($alreadyGuest == 2){
                    $signup = $customers->signUp($customer_name, $email, $pass_hash);
                    if($signup){
                        $res = array(
                            'status' => 200,
                            'message' => 'Đăng kí thành công!'
                        );
                        echo json_encode($res);
                    }else{
                        $res = array(
                            'status' => 403,
                            'message' => 'Đăng kí thất bại!'
                        );
                        echo json_encode($res);
                    }
                }
                //Đăng kí khi user đã từng đặt phòng
                else if($alreadyGuest == 1){
                    $signupWithGuest = $customers->signUpWithGuest($email, $pass_hash);
                    if($signupWithGuest){
                        $res = array(
                            'status' => 200,
                            'message' => 'Đăng kí thành công!'
                        );
                        echo json_encode($res);
                    }else{
                        $res = array(
                            'status' => 403,
                            'message' => "Đăng kí thất bại!"
                        );
                        echo json_encode($res);
                    }
                }else{
                    return;
                }
            }
            break;
    }    
?>