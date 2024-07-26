<?php
    class customers{
        //Phương thức thêm thông tin người dùng
        //Nhớ làm thêm phần check nếu người dùng đã từng đặt phòng 1 lần thì từ lần sau nếu đặt nữa thì hỏi đăng nhập
         //người dùng hoặc đăng nhập để nhận thêm voucher hoặc không đăng nhập, bỏ validate email đã tồn tại đối người đối tượng này

         //Phương thức lấy ra tất cả customers
         function getAllCus(){
            $db = new connect();
            $select = "SELECT * FROM customers ORDER BY customers.customer_id DESC";
            $result = $db->getList($select);
            return $result;
         }

         //Phương thấy ra tất cả các customers nhưng k lấy những customers đã bị xoá có phân trang
         function getAllCusNotDeletedPage($start, $limit){
            $db = new connect();
            $select = "SELECT * FROM customers WHERE customers.deleted_at IS NULL ORDER BY customers.customer_id DESC LIMIT ".$start.", ".$limit;
            $result = $db->getList($select);
            return $result;
         }

         //Phương thức lấy ra tất cả các customer đã bị xoá
         function getAllCusDeleted(){
            $db = new connect();
            $select = "SELECT * FROM customers WHERE customers.deleted_at IS NOT NULL ORDER BY customers.customer_id DESC";
            $result = $db->getList($select);
            return $result;
         }

        //Phương thức tạo mới khách hàng
        function createCus($name){
            $db = new connect();
            $rand = rand(0, 99999999);
            $str = "CTM_";
            $str_rand = $str.$rand;
            $query = "INSERT INTO customers VALUES(NULL, 0, '$str_rand', '$name', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)";
            $result = $db->exec($query);
            return $result;
        }

        //Phương thức thay đổi thông tin khách hàng (trang user-info)
        function changeUserInfo($email, $customer_name, $customer_tel, $customer_gender, $customer_birthday){
            $db = new connect();
            $query = "UPDATE customers as c SET c.customer_name = '$customer_name', c.tel = '$customer_tel', c.customer_gender = '$customer_gender', c.customer_birthday = '$customer_birthday' WHERE c.email = '$email'";
            $result = $db->exec($query);
            return $result;
        }

        //Phương thức xoá account khách hàng (soft delete)
        function deleteCus($customer_booked_id){
            $db = new connect();
            $query = "UPDATE customers as c SET c.deleted_at = CURRENT_TIMESTAMP WHERE c.customer_booked_id = '$customer_booked_id'";
            $result = $db->exec($query);
            return $result;
        }

        //Phương thức xoá account khách hàng (delete)
        function cplDeleteCus($customer_booked_id){
            $db = new connect();
            $query = "DELETE c, b FROM customers as c JOIN booked_room as b ON c.customer_id = b.customer_id WHERE c.customer_booked_id = '$customer_booked_id'";
            $result = $db->exec($query);
            return $result;
        }

        //Phương thức khôi phục account khách hàng
        function restoreCus($customer_booked_id){
            $db = new connect();
            $query = "UPDATE customers as c SET c.deleted_at = NULL WHERE c.customer_booked_id = '$customer_booked_id'";
            $result = $db->exec($query);
            return $result;
        }

        //Phương thức thay đổi password khách hàng
        function changePassword($email, $password){
            $db = new connect();
            $query = "UPDATE customers as c SET c.password = '$password' WHERE c.email = '$email'";
            $result = $db->exec($query);
            return $result;
        }

         //Phương thức lấy ra customer chỉ định bằng email/email_guest)
        function getCustomer($email, $col){
            $db = new connect();
            $select = "SELECT * FROM customers WHERE customers.$col = '$email'";
            $result = $db->getInstance($select);
            return $result;
        }

        //Phương thức lấy ra giới tính
        function getGender(){
            $db = new connect();
            $select = "SELECT * FROM gender";
            $result = $db->getList($select);
            return $result;
        }

         //Phương thức thêm KH khi đặt phòng mà không phải là thành viên
        function addCustomer($name, $email_guest, $tel){
            $db = new connect();
            $str = "CTM_";
            $random = rand(0, 99999999);
            $str_rand = $str.$random;
            $query = "INSERT INTO customers(customer_booked_id, customer_name, email_guest, tel) VALUES('$str_rand', '$name', '$email_guest', '$tel')";
            $result = $db->exec($query);
            if($result){
                $customer_id = $db->db->lastInsertId();
                return $customer_id;
            }else{
                return false;
            }
        }

        //Phương thức cập nhật lại thông tin khách hàng guest khi guest đặt phòng
        function updateGuest($name, $email_guest, $tel){
            $db = new connect();
            $str = "CTM_";
            $random = rand(0, 99999999);
            $str_rand = $str.$random;
            $query = "UPDATE customers as c SET c.customer_booked_id = '$str_rand', c.customer_name = '$name', c.tel = '$tel' WHERE c.email_guest = '$email_guest'";
            $result = $db->exec($query);
            if($result){
                return $result;
            }else{
                return false;
            }
        }
        //Phương thức cập nhật lại thông tin khách hàng member
        function updateMember($email){
            $db = new connect();
            $str = "CTM_";
            $random = rand(0, 99999999);
            $str_rand = $str.$random;
            $query = "UPDATE customers as c SET c.customer_booked_id = '$str_rand' WHERE c.email = '$email'";
            $result = $db->exec($query);
            if($result){
                return $result;
            }else{
                return false;
            }
        }
        //Phương thức lấy ra dòng dữ liệu mới nhất của customers
        function getLastInsert(){
            $db = new connect();
            $select = "SELECT * FROM customers ORDER BY customer_id DESC LIMIT 1";
            $result = $db->getInstance($select);
            return $result;
        }

        //Phương thức cập nhật lại sum trong table booked_room
        function updateSum($stay_sum, $customer_id){
            $db = new connect();
            $query = "UPDATE booked_room as b SET b.booked_sum = $stay_sum WHERE b.customer_id = $customer_id";
            $result = $db->exec($query);
            return $result;
        }

        //Phương thức xác nhận nhận phòng
        function confirmReceive($booked_room_id){
            $db = new connect();
            $query = "UPDATE booked_room as b JOIN room as r ON r.id = b.room_id
                      SET b.booked_session = 1, r.status_id = 2
                      WHERE b.booked_room_id = '$booked_room_id'";
            $result = $db->exec($query);
            return $result;
        }

        //Phương thức huỷ nhận phòng
        function undoReceive($booked_room_id){
            $db = new connect();
            $query = "UPDATE booked_room as b JOIN room as r ON r.id = b.room_id
                      SET b.booked_session = 0, r.status_id = 1
                      WHERE b.booked_room_id = '$booked_room_id'";
            $result = $db->exec($query);
            return $result;
        }

        //Phương thức trả phòng
        function confirmLeave($booked_room_id){
            $db = new connect();
            $query = "UPDATE booked_room as b JOIN room as r ON r.id = b.room_id
                      SET b.booked_done_session = 1, b.booked_session = 0, r.status_id = 1 
                      WHERE b.booked_room_id = '$booked_room_id'";
            $result = $db->exec($query);
            return $result;
        }

        //Phương thức huỷ trả phòng
        function undoLeave($booked_room_id){
            $db = new connect();
            $query = "UPDATE booked_room as b JOIN room as r ON r.id = b.room_id
                      SET b.booked_done_session = 0, b.booked_session = 1, r.status_id = 2
                      WHERE b.booked_room_id = '$booked_room_id'";
            $result = $db->exec($query);
            return $result;
        }

        //Phương thức thực hiện đăng kí nếu chưa có email_guest
        function signUp($name, $email, $password){
            $db = new connect();
            $str = "CTM_";
            $random = rand(0, 99999999);
            $str_rand = $str.$random;
            $query = "INSERT INTO customers(customer_booked_id, customer_name, email, password) VALUES('$str_rand', '$name', '$email', '$password')";
            $result = $db->exec($query);
            return $result;
        }

        //Phương thức thực hiện đăng kí nếu đã có email_guest
        function signUpWithGuest($email_guest, $password){
            $db = new connect();
            $query = "UPDATE customers as c SET c.email_guest = NULL, c.email = '$email_guest', c.password = '$password' WHERE c.email_guest = '$email_guest'";
            $result = $db->exec($query);
            return $result;
        }

        //Phương thức thay đổi customer_name
        function changeCusName($id, $name_value){
            $db = new connect();
            $query = "UPDATE customers as c SET c.customer_name = '$name_value' WHERE c.customer_id = $id";
            $result = $db->exec($query);
            return $result;
        }

        //Phương thức thay đổi email thành viên
        function changeEmailMember($id, $email_value){
            $db = new connect();
            $query = "UPDATE customers as c SET c.email = '$email_value' WHERE c.customer_id = $id";
            $result = $db->exec($query);
            return $result;
        }

        //Phương thức thay đổi email khách
        function changeEmailGuest($id, $email_value){
            $db = new connect();
            $query = "UPDATE customers as c SET c.email_guest = '$email_value' WHERE c.customer_id = $id";
            $result = $db->exec($query);
            return $result;
        }

        //Phương thức thay đổi số điện thoại
        function changeCusTel($id, $tel_value){
            $db = new connect();
            $query = "UPDATE customers as c SET c.tel = '$tel_value' WHERE c.customer_id = $id";
            $result = $db->exec($query);
            return $result;
        }
    }
?>