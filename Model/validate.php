<?php
    // session_start();
    class validate{
        //Phương thức check email_guest đã tồn tại hay chưa
        function checkEmail($email){
            $db = new connect();
            $select = "SELECT COUNT(*) FROM customers WHERE customers.email_guest = '$email'";
            $result = $db->execp($select);
            return $result;
        }

        //Phương thức kiểm tra email đã đăng kí hay chưa
        function checkSignup($email){
            $db = new connect();
            $select = "SELECT COUNT(*) FROM customers as c 
                       WHERE c.password IS NOT NULL AND c.email = '$email'";
            $result = $db->execp($select);
            return $result;
        }

        //Phương thức kiểm tra password có đúng không
        function checkExist($email){
            $db = new connect();
            $select = "SELECT * FROM customers as c WHERE c.email = '$email'";
            $result = $db->getInstance($select);
            return $result;
        }

        //Phương thức kiểm tra tài khoản có đang bị vô hiệu hoá hay không
        function checkBan($email){
            $db = new connect();
            $select = "SELECT * FROM customers as c WHERE c.email = '$email' AND c.deleted_at IS NOT NULL";
            $result = $db->getInstance($select);
            return $result;
        }

        //Phương thức kiểm tra password có đúng không (admin)
        function checkExistAdmin($username){
            $db = new connect();
            $select = "SELECT * FROM admin as a WHERE a.username = '$username'";
            $result = $db->getInstance($select);
            return $result;
        }
    }
    
?>