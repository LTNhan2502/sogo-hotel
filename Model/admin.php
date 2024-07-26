<?php
    class admin{
        //Phương thức lấy ra tất cả tài khoản admin
        function getAllAdmin(){
            $db = new connect();
            $select = "SELECT * FROM admin";
            $result = $db->getList($select);
            return $result;
        }

        //PHương thức tạo admin mới
        function createNewAdmin($fullname, $username, $pass){
            $db = new connect();
            $query = "INSERT INTO admin VALUES (NULL, '$fullname', '$username', '$pass', 5)";
            $result = $db->exec($query);
            return $result;
        }

        //Phương thức lấy ra tài khoản admin
        function getAdmin($username, $pass){
            $db = new connect();
            $select = "SELECT * FROM admin WHERE admin.username='$username' AND admin.pass='$pass'";
            $result = $db->getList($select);
            return $result;
        }

        //Phương thức kiểm tra mật khẩu admin
        function getAdminNotUsingPass($username){
            $db = new connect();
            $select = "SELECT * FROM admin WHERE admin.username = '$username'";
            $result = $db->getInstance($select);
            return $result;
        }

        //Phương thức thay đổi mật khẩu admin
        function changePassAdmin($username, $hashed_pass){
            $db = new connect();
            $query = "UPDATE admin as a SET a.pass = '$hashed_pass' WHERE a.username = '$username'";
            $result = $db->exec($query);
            return $result; 
        }

        //Phương thức lấy ra thông tin của tài khoản admin được phân quyền
        function getAccountAuth($id){
            $db = new connect();
            $select = "SELECT * FROM user_authority AS ua INNER JOIN authority as a ON ua.user_auth_auth_id = a.auth_id WHERE ua.user_auth_admin_id = $id";
            $result = $db->getList($select);
            return $result;
        }

        //Phương thức lấy ra authority_group chứa các danh mục cha 
        function getAuthGroup(){
            $db = new connect();
            $select = "SELECT * FROM authority_group";
            $result = $db->getList($select);
            return $result;
        }

        //Phương thức lấy ra authority chức các chức năng con của authority_group
        function getAuth(){
            $db = new connect();
            $select = "SELECT * FROM authority";
            $result = $db->getList($select);
            return $result;
        }

        //Phương thức xoá tất cả quyền đã có của đối tượng chỉ định
        function deleteOldAuth($id){
            $db = new connect();
            $query = "DELETE FROM user_authority WHERE user_auth_admin_id = $id ";
            $result = $db->exec($query);
            return $result;
        }

        //Phương thức thêm quyền mới cho đối tượng chỉ định
        function addNewAuth($insertAuth){
            $db = new connect();
            $query = "INSERT INTO user_authority VALUES $insertAuth";
            $result = $db->exec($query);
            return $result;
        }

        //Phương thức lấy ra priority của người dùng chỉ định
        function getCurrentPriority($user_id){
            $db = new connect();
            $select = "SELECT * FROM admin WHERE admin.id = $user_id";
            $result = $db->getInstance($select);
            return $result;
        }

        //Phương thức thay đổi priority cho người dùng chỉ địng
        function changePriority($user_id, $priority){
            $db = new connect();
            $query = "UPDATE admin SET admin.priority = $priority WHERE admin.id = $user_id";
            $result = $db->exec($query);
            return $result;
        }
        
        //Phương thức lấy ra tất cả thông tin tài khoản trong web
        function getAllMember(){
            $db = new connect();
            $select = "SELECT 
                        user_id, 
                        name, 
                        per_id, 
                        per_name, 
                        user_type, 
                        GROUP_CONCAT(action_code ORDER BY action_code SEPARATOR ' - ') AS actions, 
                        GROUP_CONCAT(check_action ORDER BY action_code SEPARATOR ' - ') AS checks
                    FROM (
                        SELECT 
                            a.id AS user_id, 
                            a.name AS name, 
                            up_admin.admin_id, 
                            p.per_id, 
                            p.per_name, 
                            pd.per_id AS pd_per_id, 
                            pd.action_code, 
                            pd.check_action, 
                            'admin' AS user_type
                        FROM admin AS a
                        JOIN user_per AS up_admin ON a.id = up_admin.admin_id
                        JOIN permission AS p ON up_admin.per_id = p.per_id
                        JOIN per_detail AS pd ON p.per_id = pd.per_id

                        UNION

                        SELECT 
                            r.rec_id AS user_id, 
                            r.rec_name AS name, 
                            up_rec.rec_id AS admin_id, 
                            p.per_id, 
                            p.per_name, 
                            pd.per_id AS pd_per_id, 
                            pd.action_code, 
                            pd.check_action, 
                            'receptionist' AS user_type
                        FROM receptionist AS r
                        JOIN user_per AS up_rec ON r.rec_id = up_rec.rec_id
                        JOIN permission AS p ON up_rec.per_id = p.per_id
                        JOIN per_detail AS pd ON p.per_id = pd.per_id
                    ) AS combined
                    GROUP BY user_id, name, per_id, per_name, user_type";
            $result = $db->getList($select);
            return $result;        
        }

        //Phương thức lấy ra tất cả các role
        function getPermission(){
            $db = new connect();
            $select = "SELECT * FROM permission";
            $result = $db->getList($select);
            return $result;   
        }

        //Phương thức lấy ra thông tin của một thành viên
        function getMember($user_id, $user_type){
            $db = new connect();
            $select = "SELECT 
                        user_id, 
                        name, 
                        per_id, 
                        per_name, 
                        user_type, 
                        GROUP_CONCAT(action_code ORDER BY action_code SEPARATOR ' - ') AS actions, 
                        GROUP_CONCAT(check_action ORDER BY action_code SEPARATOR ' - ') AS checks
                    FROM (
                        SELECT 
                            a.id AS user_id, 
                            a.name AS name, 
                            up_admin.admin_id, 
                            p.per_id, 
                            p.per_name, 
                            pd.per_id AS pd_per_id, 
                            pd.action_code, 
                            pd.check_action, 
                            'admin' AS user_type
                        FROM admin AS a
                        JOIN user_per AS up_admin ON a.id = up_admin.admin_id
                        JOIN permission AS p ON up_admin.per_id = p.per_id
                        JOIN per_detail AS pd ON p.per_id = pd.per_id

                        UNION

                        SELECT 
                            r.rec_id AS user_id, 
                            r.rec_name AS name, 
                            up_rec.rec_id AS admin_id, 
                            p.per_id, 
                            p.per_name, 
                            pd.per_id AS pd_per_id, 
                            pd.action_code, 
                            pd.check_action, 
                            'receptionist' AS user_type
                        FROM receptionist AS r
                        JOIN user_per AS up_rec ON r.rec_id = up_rec.rec_id
                        JOIN permission AS p ON up_rec.per_id = p.per_id
                        JOIN per_detail AS pd ON p.per_id = pd.per_id
                    ) AS combined
                    GROUP BY user_id, name, per_id, per_name, user_type
                    HAVING user_id = '$user_id' AND user_type = '$user_type'";
            $result = $db->getInstance($select);
            return $result;
        }
    }
?>