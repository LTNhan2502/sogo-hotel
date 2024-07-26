<?php

    set_include_path(get_include_path() . PATH_SEPARATOR . '../../Model/');
    spl_autoload_extensions('.php');
    spl_autoload_register();

    $act = "admin_login";
    if(isset($_GET['act'])){
        $act = $_GET['act'];
    }
    switch($act){
        case "admin_login":
            include_once "View/admin/admin_login.php";
            break;
        case 'admin_change_password':
            include_once "View/admin/admin_login.php";
            break;
        case 'create_anew':
            include_once "View/admin/admin_login.php";
            break;
        case 'login_act':
            if($_SERVER['REQUEST_METHOD'] == "POST"){
                $username = $_POST['username_admin'];
                $pass = $_POST['pass_admin'];               
                $admin = new admin();
                $validate = new validate();

                $isExist = $validate->checkExistAdmin($username);
                $hashed_password = $isExist['pass'];

                $check = $admin->getAdmin($username, $pass);
                $user = $check->fetch();

                if($check){
                    $_SESSION['admin'] = $user['id'];
                    $_SESSION['tenadmin'] = $user['username'];
                    $res = array(
                        'status' => 200,
                        'message' => 'Đăng nhập thành công!'
                    );
                }
                echo json_encode($res);
            }
            break;
        case 'check_username':
            if(isset($_POST['username'])){
                $username = $_POST['username'];
                $admin = new admin();
                $getAdmin = $admin->getAdminNotUsingPass($username);                
                if($getAdmin){
                    $res = array(
                        'status' => 200,
                        'message' => 'Passed!'
                    );
                }else{
                    $res = array(
                        'status' => 403,
                        'message' => 'Username không tồn tại'
                    );
                }
                echo json_encode($res);
            }
            break;
        case 'check_username_create':
            if(isset($_POST['username'])){
                $username = $_POST['username'];
                $admin = new admin();
                $getAdmin = $admin->getAdminNotUsingPass($username);                
                if(!$getAdmin){
                    $res = array(
                        'status' => 200,
                        'message' => 'Passed!'
                    );
                }else{
                    $res = array(
                        'status' => 403,
                        'message' => 'Username đã tồn tại!'
                    );
                }
                echo json_encode($res);
            }
            break;
        case 'check_pass':
            if(isset($_POST['password_user_old']) && isset($_POST['username'])){
                $password = $_POST['password_user_old'];
                $username = $_POST['username'];
                $admin = new admin();
                $getAdmin = $admin->getAdminNotUsingPass($username);                
                $result = password_verify($password, $getAdmin['pass']);

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
        case 'create_anew_admin':
            $fullname = $_POST['fullname_create'];
            $password = $_POST['new_pass_create'];
            $username = $_POST['username_create'];
            $hashed_pass = password_hash($password, PASSWORD_DEFAULT);
            $admin = new admin();
            $result = $admin->createNewAdmin($fullname, $username, $hashed_password);

            if($result){
                $res = array(
                    'status' => 200,
                    'message' => 'Tạo tài khoản mới thành công!'
                );
            }else{
                $res = array(
                    'status' => 403,
                    'message' => 'Mật khẩu không đúng!'
                );
            }
            echo json_encode($res);
            
            break;
        case "login_action":
            session_start();
            if($_SERVER['REQUEST_METHOD'] == "POST"){
                $username = $_POST['username_admin'];
                $pass = $_POST['pass_admin'];
                //Đem so sánh trong dbs xem có hay không
                $admin = new admin();
                $validate = new validate();
                $isExist = $validate->checkExistAdmin($username);
                //Không tồn tại
                if(!$isExist){
                    $res = array(
                        'status' => 404,
                        'message' => 'Tài khoản không tồn tại!'
                    );
                }
                //Đã tồn tại
                else{
                    $hashed_password = $isExist['pass'];
                    $isTruePass = password_verify($pass, $hashed_password);
                    //Pass nhập là đúng
                    if($isTruePass){                        
                        $check = $admin->getAdmin($username, $hashed_password);
                        $user = $check->fetch();
                        if($check){
                            $_SESSION['admin']  = $user['id'];
                            $_SESSION['tenadmin'] = $user['username'];

                            //Phân quyền
                            $user_authority = $admin->getAccountAuth($_SESSION['admin'])->fetchAll(PDO::FETCH_ASSOC);
                            $user['authorities'] = array(
                                'admin_home',
                                'admin_room_book',
                                'page'
                            );
                            if(!empty($user_authority)){
                                foreach($user_authority as $authority){
                                    $user['authorities'][] = $authority['url_match'];
                                }
                            }
                            // echo json_encode($user);exit;
                            $_SESSION['current_user'] = $user;
                            $res = array(
                                'status' => 200,
                                'message' => 'Đăng nhập thành công!',
                                'data' => $_SESSION['current_user']
                            );                            
                            // echo '<meta http-equiv="refresh" content="0;url=./admin_index.php?action=admin_home"/>';
                        }                       
                    }
                    //Sai mật khẩu
                    else{
                        $res = array(
                            'status' => 403,
                            'message' => 'Sai mật khẩu!'
                        );
                        // include_once "./View/admin/admin_login.php";
                    }
                }
                echo json_encode($res);
            }
            break;
        case 'change_pass':
            $username = $_POST['username'];
            $pass_admin = $_POST['new_pass'];
            $admin = new admin();
            $hashed = password_hash($pass_admin, PASSWORD_DEFAULT);
            $change = $admin->changePassAdmin($username, $hashed);
            if($change){
                $res = array(
                    'status' => 200,
                    'message' => "Thay đổi mật khẩu thành công!"
                );
            }
            echo json_encode($res);
            break;
        case "logout":
            session_start();
            unset($_SESSION['admin']);
            unset($_SESSION['tenadmin']);
            unset($_SESSION['current_user']);
            if(!isset($_SESSION['admin'])){
                $res = array(
                    'status' => 200,
                    'message' => 'Đăng xuất thành công!'
                );
            }else{
                $res = array(
                    'status' => 403,
                    'message' => 'Đăng xuất thất bại!'
                );
            }
            
           echo json_encode($res);  
           break;
    }
?>