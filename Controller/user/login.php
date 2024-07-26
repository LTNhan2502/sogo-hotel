<?php
    session_start();
    set_include_path(get_include_path() . PATH_SEPARATOR . '../../Model/');
    spl_autoload_extensions('.php');    
    spl_autoload_register();

    $act = "login";
    if(isset($_GET['act'])){
        $act = $_GET['act'];
    }

    switch($act){
        case "login":
            include_once "View/user/login.php";
            break;
        case "login_action":
            if(isset($_POST['email']) && isset($_POST['password'])){
                $email = $_POST['email'];
                $password = $_POST['password'];
                $validate = new validate();
                //Lấy ra thông tin của user có email đã nhập
                $isExist = $validate->checkExist($email);
                //Kiểm tra tài khoản có đang bị vô hiệu hoá hay không
                $isBaned = $validate->checkBan($email);
                //Kiểm tra tài khi khoản không tồn tại
                if(!$isExist){
                    $res = array(
                        'status' => 404,
                        'message' => "Tài khoản không tồn tại!"
                    );
                    echo json_encode($res);
                }else{
                    $hashed_password = $isExist['password'];
                    //Kiểm tra trùng password
                    $isTruePass = password_verify($password, $hashed_password);
                    if($isTruePass){
                        if(isset($_SESSION['id'])){
                            $res = array(
                                //Yêu cầu không thành công do thất bại của yêu cầu trước đó - Failed Dependency.
                                'status' => 424,
                                'message' => "Phiên của bạn vẫn chưa hết hạn!"
                            );
                            echo json_encode($res);
                        }else{
                            if($isBaned){
                                $res = array(
                                    'status' => 403,
                                    'message' => "Tài khoản này hiện đang bị bất hoạt! Nếu muốn kích hoạt lại hãy liên hệ quản trị website!"
                                );
                                echo json_encode($res);
                            }else{
                                $_SESSION['customer_id'] = $isExist['customer_id'];
                                $_SESSION['customer_email'] = $isExist['email'];
                                $_SESSION['customer_booked_id'] = $isExist['customer_booked_id'];
                                $_SESSION['customer_name'] = $isExist['customer_name'];
                                $_SESSION['customer_tel'] = $isExist['tel'];
                                $res = array(
                                    'status' => 200,
                                    'message' => 'Đăng nhập thành công!'
                                );
                                echo json_encode($res);                            
                            }
                        }
                    }
                    //Kiểm tra nếu không trùng password
                    else{
                        $res = array(
                            'status' => 403,
                            'message' => "Sai mật khẩu hoặc tài khoản!"
                        );
                        echo json_encode($res);
                    }
                }
            }
            break;
        case "logout_action":
            unset($_SESSION['customer_id']);
            unset($_SESSION['customer_email']);
            unset($_SESSION['customer_booked_id']);
            unset($_SESSION['customer_name']);
            unset($_SESSION['customer_tel']);
            $res = array(
                'status' => 200,
                'message' => 'Đăng xuất thành công!'
            );
            echo json_encode($res);
            break;
    }    
?>