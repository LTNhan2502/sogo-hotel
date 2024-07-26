<?php
set_include_path(get_include_path() . PATH_SEPARATOR . '../../Model/');
spl_autoload_extensions('.php');    
spl_autoload_register();

    $act = 'admin_authorize';
    if(isset($_GET['act'])){
        $act = $_GET['act'];
    }

    switch($act){
        case 'admin_authorize':
            include_once 'View/admin/admin_authorize.php';
            break;
        case 'get_permission':
            session_start();
            $user_id = $_POST['user_id'];
            $isEnoughPriority = false;
            $admin = new admin();
            $auth_group = $admin->getAuthGroup()->fetchAll();
            $auth = $admin->getAuth()->fetchAll();
            $getAccoutAuth = $admin->getAccountAuth($user_id)->fetchAll();
            $getCurrentPriority = $admin->getCurrentPriority($_SESSION['admin']);
            $getTargetPriority = $admin->getCurrentPriority($user_id);
            $authList = array();

            if($getCurrentPriority['priority'] >= $getTargetPriority['priority']){
                $isEnoughPriority = false;
            }else{
                $isEnoughPriority = true;
            }

            if(!empty($getAccoutAuth)){
                foreach($getAccoutAuth as $accountAuth)
                $authList[] = $accountAuth['user_auth_auth_id'];
            }
            foreach ($auth_group as $set){                
                echo '<div class="permission">';
                echo    '<h3>'.$set['auth_gr_name'].'</h3>';
                echo    '<div class="checkbox-group">';                        
                foreach ($auth as $set_auth){
                    if ($set['auth_gr_id'] == $set_auth['auth_gr_id']) {
                        echo '<div class="checkbox-item">';
                        echo     '<input type="checkbox" value="'.$set_auth['auth_id'].'" '.(!$isEnoughPriority ? "disabled" : "").'
                                    id="'.$set_auth['auth_id'].'"'.($user_id == 1 ? "disabled" : "").' 
                                    name="authorities[]" '.(in_array($set_auth['auth_id'], $authList) ? "checked" : "").'>';
                        echo     '<label for="'.$set_auth['auth_id'].'">'.$set_auth['auth_name'].'</label>';
                        echo '</div>';
                    }
                }
                echo    '</div>';
                echo '</div>';
            }
            break;  
        case 'get_priority':
            if(isset($_POST['user_id'])){
                $user_id = $_POST['user_id'];
                $admin = new admin();
                $getCurrentPriority = $admin->getCurrentPriority($user_id);
                echo json_encode($getCurrentPriority['priority']);
            }
            break;          
        case 'authorize':
            session_start();
            if(isset($_POST['user_id'])){
                $data = isset($_POST['authorities']) ? $_POST['authorities'] : [];
                $user_id = $_POST['user_id'];
                $target_priority = $_POST['priority'];
                $admin = new admin();
                $insertString = "";

                $getCurrentPriority = $admin->getCurrentPriority($_SESSION['admin']);
                $getTargetPriority = $admin->getCurrentPriority($user_id);
                if($getCurrentPriority['priority'] >= $getTargetPriority['priority']){
                    $res = array(
                        'status' => 403,
                        'message' => 'Không đủ thẩm quyền để thay đổi!'
                    );
                }else{
                    foreach($data as $insertAuthority){
                        //Nếu insertString rỗng thì khi nối chuỗi sẽ không có dấu phẩy, ngược lại
                        $insertString .= !empty($insertString) ? ', ' : '';
                        $insertString .= "(NULL, $user_id, $insertAuthority)";
                    }
            
                    // Kiểm tra nếu user_id là 1 và không có quyền nào được chọn, bỏ qua việc xóa quyền
                    if($user_id == 1 && empty($data)){
                        $res = array(
                            'status' => 403,
                            'message' => 'Không thể thay đổi quyền của người dùng này!'
                        );
                    }else{
                        // Xóa quyền cũ và thêm quyền mới
                        $deleteOldAuth = $admin->deleteOldAuth($user_id);
                        if(!empty($data)){                            
                            $insertAuth = $admin->addNewAuth($insertString);
                            //Thay đổi độ ưu tiên (priority)
                            $changePriority = $admin->changePriority($user_id, $target_priority);
                        
                            if($insertAuth && $changePriority){
                                $res = array(
                                    'status' => 200,
                                    'message' => "Thay đổi quyền thành công!"
                                );
                            }else{
                                $res = array(
                                    'status' => 403,
                                    'message' => "Thay đổi quyền thất bại!"
                                );
                            }                            
                        }else{
                            // Nếu không có quyền nào được chọn và user_id không phải là 1
                            $res = array(
                                'status' => 200,
                                'message' => "Thay đổi quyền thành công!"
                            );
                        }
                    }
                }
                
                echo json_encode($res);
            }
            break;
    } 
        //INSERT INTO `user_authority` (`user_auth_id`, `user_auth_admin_id`, `user_auth_auth_id`) VALUES (NULL, '1', '1'), (NULL, '1', '2'), (NULL, '1', '3'), (NULL, '1', '4'), (NULL, '1', '5'), (NULL, '1', '6'), (NULL, '1', '7'), (NULL, '1', '8'), (NULL, '1', '9'), (NULL, '1', '10'), (NULL, '1', '11'), (NULL, '1', '12'), (NULL, '1', '13'), (NULL, '1', '14'), (NULL, '1', '15'), (NULL, '1', '16'), (NULL, '1', '17');
?>