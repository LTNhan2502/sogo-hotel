<?php
    set_include_path(get_include_path() . PATH_SEPARATOR . '../../Model/');
    spl_autoload_extensions('.php');    
    spl_autoload_register();

    $act = 'admin_authority';
    if(isset($_GET['act'])){
        $act = $_GET['act'];
    }

    switch ($act){
        case 'admin_authority':
            include_once 'View/admin/admin_authority.php';
            break;
        case 'get_permission_detail':
            $user_id = $_POST['user_id'];
            $user_type = $_POST['user_type'];
            $admin = new admin();
            $getMember = $admin->getMember($user_id, $user_type);
            if($getMember){
                $res = array(
                    'status' => 200,
                    'message' => 'Lấy thành công',
                    'data' => $getMember
                );
            }
            echo json_encode($res); 
            break;
    }
?>