<?php
    class receptionist{
        //Phương thức lấy tất cả 
        function getAllRec(){
            $db = new connect();
            $select = "SELECT * FROM receptionist as r, part, shift WHERE r.rec_part = part.part_id AND r.rec_shift = shift.shift_id AND r.deleted_at IS NULL ORDER BY r.rec_id DESC";
            $result = $db->getList($select);
            return $result;
        }

        //Phương thức lấy ra tất cả các tiếp tân có phân trang
        function getAllRecPage($start, $limit){
            $db = new connect();
            $select = "SELECT * FROM receptionist as r, part, shift WHERE r.rec_part = part.part_id AND r.rec_shift = shift.shift_id AND r.deleted_at IS NULL ORDER BY r.rec_id DESC LIMIT ".$start.", ".$limit;
            $result = $db->getList($select);
            return $result;
        }

        //Phương thức lấy ra tất cả các tiếp tân đã bị xoá
        function getAllRecDeleted(){
            $db = new connect();
            $select = "SELECT * FROM receptionist as r, part, shift WHERE r.rec_part = part.part_id AND r.rec_shift = shift.shift_id AND r.deleted_at IS NOT NULL ORDER BY r.rec_id DESC";
            $result = $db->getList($select);
            return $result;
        }

        //Phương thức tạo mới tiếp tân
        function createRec($name){
            $db = new connect();
            $rand = rand(0, 99999999);
            $str = "REC_";
            $str_rand = $str.$rand;
            $query = "INSERT INTO receptionist VALUES(NULL, '$str_rand', '$name', 1, 1, NULL, NULL, NULL, NULL, 1, 0, 0, NULL, NULL, NULL)";
            $result = $db->exec($query);
            return $result;
        }

        function getRecs($id){
            $db = new connect();
            $select = "SELECT * FROM receptionist as r WHERE r.rec_id = $id";
            $result = $db->getList($select);
            return $result;
        }

        //Phương thức lấy ra tất cả chức vụ
        function getAllPart(){
            $db = new connect();
            $select = "SELECT * FROM part";
            $result = $db->getList($select);
            return $result;
        }

        //Phương thức lấy ra tất cả ca làm việc
        function getAllShift(){
            $db = new connect();
            $select = "SELECT * FROM shift";
            $result = $db->getList($select);
            return $result;
        }

        //Phương thức thay đổi tên nhân viên
        function changeRecName($id, $name){
            $db = new connect();
            $query = "UPDATE receptionist as r SET r.rec_name = '$name' WHERE r.rec_id = $id";
            $result = $db->exec($query);
            return $result;
        }

        //Phương thức thay đổi chức vụ của nhân viên
        function changeRecPart($rec_id, $rec_part){
            $db = new connect();
            $query = "UPDATE receptionist as r SET r.rec_part = $rec_part WHERE r.rec_id = $rec_id";
            $result = $db->execp($query);
            return $result;
        }

        //Phương thức thay đổi ca làm việc của nhân viên
        function changeRecShift1($rec_id){
            $db = new connect();
            $query = "UPDATE receptionist as r SET r.rec_shift = 1 WHERE r.rec_id = $rec_id";
            $result = $db->execp($query);
            return $result;
        }
        function changeRecShift2($rec_id){
            $db = new connect();
            $query = "UPDATE receptionist as r SET r.rec_shift = 2 WHERE r.rec_id = $rec_id";
            $result = $db->execp($query);
            return $result;
        }
        function changeRecShift3($rec_id){
            $db = new connect();
            $query = "UPDATE receptionist as r SET r.rec_shift = 3 WHERE r.rec_id = $rec_id";
            $result = $db->execp($query);
            return $result;
        }

        //Phương thức lấy thông tin chi tiết của một cá nhân
        function getDetailRec($rec_id){
            $db = new connect();
            $select = "SELECT * FROM receptionist as r WHERE r.rec_id = $rec_id";
            $result = $db->getInstance($select);
            return $result;
        }

        //Phương thức thay đổi số điện thoại
        function changeRecTel($id, $rec_tel){
            $db = new connect();
            $query = "UPDATE receptionist as r SET r.rec_tel = '$rec_tel' WHERE r.rec_id = $id";
            $result = $db->exec($query);
            return $result;
        }

        //Phương thức thay đổi email
        function changeRecEmail($id, $rec_email){
            $db = new connect();
            $query = "UPDATE receptionist as r SET r.rec_email = '$rec_email' WHERE r.rec_id = $id";
            $result = $db->exec($query);
            return $result;
        }

        //Phương thức thay đổi birthday
        function changeRecBirthday($id, $rec_birthday){
            $db = new connect();
            $query = "UPDATE receptionist as r SET r.rec_birthday = '$rec_birthday' WHERE r.rec_id = $id";
            $result = $db->exec($query);
            return $result;
        }

        //Phương thức thay đổi ngày làm việc
        function changeRecStartWork($id, $rec_startWork){
            $db = new connect();
            $query = "UPDATE receptionist as r SET r.rec_startWork = '$rec_startWork' WHERE r.rec_id = $id";
            $result = $db->execp($query);
            return $result;
        }

        //Phương thức thay đổi thời gian làm việc
        function changeRecTimeWork($id, $rec_timeWork){
            $db = new connect();
            $query = "UPDATE receptionist as r SET r.rec_timeWork = $rec_timeWork WHERE r.rec_id = $id";
            $result = $db->execp($query);
            return $result;
        }

        //Phương thức thay đổi thưởng
        function changeRecBonus($id, $rec_bonus){
            $db = new connect();
            $query = "UPDATE receptionist as r SET r.rec_bonus = $rec_bonus WHERE r.rec_id = $id";
            $result = $db->exec($query);
            return $result;
        }

        //Phương thức thay đổi phạt
        function changeRecFine($id, $rec_fine){
            $db = new connect();
            $query = "UPDATE receptionist as r SET r.rec_fine = $rec_fine WHERE r.rec_id = $id";
            $result = $db->exec($query);
            return $result;
        }

        //Phương thức thay đổi lương
        function changeRecSalary($id, $rec_salary){
            $db = new connect();
            $query = "UPDATE receptionist as r SET r.rec_salary = $rec_salary WHERE r.rec_id = $id";
            $result = $db->exec($query);
            return $result;
        }

        //Phương thức nhận lương
        function claimSalary($id){
            $db = new connect();
            $query = "UPDATE receptionist as r SET r.rec_timeSalary = CURRENT_TIMESTAMP WHERE r.rec_id = $id";
            $result = $db->exec($query);
            return $result;
        }

        //Phương thức thay đổi hệ số
        function changeRecFactor($id, $factor_value){
            $db = new connect();
            $query = "UPDATE receptionist as r SET r.rec_factor = $factor_value WHERE r.rec_id = $id";
            $result = $db->exec($query);
            return $result;
        }

        //Phương thức huỷ nhận lương
        function unClaimSalary($id){
            $db = new connect();
            $query = "UPDATE receptionist as r SET r.rec_timeSalary = NULL WHERE r.rec_id = $id";
            $result = $db->exec($query);
            return $result;
        }

        //Phương thức xoá thông tin nhân viên (soft delete)
        function deleteRec($rec_code){
            $db = new connect();
            $query = "UPDATE receptionist as r SET r.deleted_at = CURRENT_TIMESTAMP WHERE r.rec_code = '$rec_code'";
            $result = $db->exec($query);
            return $result;
        }

        //Phương thức xoá thông tin nhân viên (delete)
        function cplDeleteRec($rec_code){
            $db = new connect();
            $query = "DELETE FROM receptionist as r WHERE r.rec_code = '$rec_code'";
            $result = $db->exec($query);
            return $result;
        }

        //Phương thức khôi phục thông tin nhân viên
        function restoreRec($rec_code){
            $db = new connect();
            $query = "UPDATE receptionist as r SET r.deleted_at = NULL WHERE r.rec_code = '$rec_code'";
            $result = $db->exec($query);
            return $result;
        }
    }
?>