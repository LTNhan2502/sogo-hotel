<?php
    class room{
        //Phương thức thống kê booked_sum 
        function getThongKeAdmin(){
            $db = new connect();
            $select = "SELECT room.name, SUM(booked_room.booked_sum) as tongtien FROM room, booked_room WHERE room.id = booked_room.room_id GROUP BY room.id";
            $result = $db->getList($select);
            return $result;
        }
        //Phương thức tìm kiếm
        function searchRoom($value){
            $db = new connect();
            $select = "SELECT * FROM room WHERE room.name LIKE '%$value%'";
            $result = $db->getList($select);
            return $result;
        }
        //Phương thức lấy tất cả thông tin của tất cả các phòng
        function getRoom(){
            $db = new connect();
            $select = "SELECT * FROM room, detail_room, kind WHERE room.id = detail_room.room_id AND room.kind_id = kind.kind_id";
            $result = $db->getList($select);
            return $result;
        }

        //Phương thức lấy ra img_main để thêm vào thông tin chi tiết phòng
        function getImgMain($id){
            $db = new connect();
            $select = "SELECT room.img FROM room WHERE room.id = $id";
            $result = $db->getInstance($select);
            return $result;
        }

        //Phương thức lấy ra các img trong detail_room
        function getImgName(){
            $db = new connect();
            $select = "SELECT d.img_name FROM detail_room as d";
            $result = $db->getList($select);
            return $result;
        }

        //Phương thức kiểm tra image đã tồn tại trong room chưa
        function checkImage($file){
            $db = new connect();
            $select = "SELECT COUNT(*) FROM room WHERE room.img = '$file'";
            $result = $db->execp($select);
            return $result;
        }

        //Phương thức thêm thông tin chi tiết cho phòng
        function insertDetailRoom($id, $img_main, $img_sub_1, $img_sub_2, $img_sub_3, $sm, $quantity, $sv, $req, $des){
            $db = new connect();
            $query = "INSERT INTO detail_room VALUES(NULL, $id, '$sv', '$req', '$img_main - $img_sub_1 - $img_sub_2 - $img_sub_3', '$quantity', '$sm', '$des')";
            $result = $db->exec($query);
            return $result;
        }

        //Phương thức lấy ra tất cả các phòng thuộc kind single
        function getSingle(){
            $db = new connect();
            $select = "SELECT * FROM room, kind, detail_room WHERE kind.kind_id=room.kind_id AND room.id = detail_room.room_id AND room.kind_id= 1";
            $result = $db->getList($select);
            return $result;
        }

        //Phương thức lấy ra tất cả các phòng thuộc family
        function getFamily(){
            $db = new connect();
            $select = "SELECT * FROM room, kind, detail_room WHERE kind.kind_id=room.kind_id AND room.id = detail_room.room_id AND room.kind_id= 2";
            $result = $db->getList($select);
            return $result;
        }

        //Phương thức lấy ra tất cả các phòng thuộc kind presidential
        function getPresidential(){
            $db = new connect();
            $select = "SELECT * FROM room, kind, detail_room WHERE kind.kind_id=room.kind_id AND room.id = detail_room.room_id AND room.kind_id= 3";
            $result = $db->getList($select);
            return $result;
        }

        //Phương thức lấy 1 room
        function getDetailRoom($id){
            $db = new connect();
            $select = "SELECT * FROM detail_room, room WHERE room.id = detail_room.detail_id AND detail_room.room_id = $id";
            $result = $db->getInstance($select);
            return $result;
        }

        //Phương thức lấy tiền của room chỉ định 
        function getPrice($id){
            $db = new connect();
            $select = "SELECT r.price FROM room as r WHERE r.id = '$id'";
            $result = $db->getInstance($select);
            return $result;
        }

        //Phương thức lấy tất cả room
        function getRooms(){
            $db = new connect();
            $select = "SELECT * FROM room WHERE room.deleted_at IS NULL ORDER BY room.id ";
            $result = $db->getList($select);
            return $result;
        }

        //Phương thức lấy tất cả các room đã xoá
        function getDeleteRooms(){
            $db = new connect();
            $select = "SELECT * FROM room WHERE room.deleted_at IS NOT NULL";
            $result = $db->getList($select);
            return $result;
        }

        //Phương thức lấy tất cả room có phân trang
        function getRoomsPage($start, $limit){
            $db = new connect();
            $select = "SELECT * FROM room WHERE room.deleted_at IS NULL ORDER BY room.id DESC LIMIT ".$start.", ".$limit;
            $result = $db->getList($select);
            return $result;
        }

        //Phương thức lấy room tìm kiếm
        function getRoomsSearch($search_value){
            $db = new connect();
            $select = "SELECT * FROM room WHERE room.deleted_at IS NULL AND room.name LIKE '%$search_value%' ORDER BY room.id DESC";
            $result = $db->getList($select);
            return $result;
        }

        //Phương thức lấy room vừa phân trang vừa tìm kiếm
        function getRoomsSearchPage($search_value, $start, $limit){
            $db = new connect();
            $select = "SELECT * FROM room WHERE room.deleted_at IS NULL AND room.name LIKE '%$search_value%' ORDER BY room.id DESC LIMIT $start, $limit";
            $result = $db->getList($select);
            return $result;
        }

        //Phương thức lấy ra các room chưa đặt
        function getEmptyRoom(){
            $db = new connect();
            $select = "SELECT * FROM room, detail_room WHERE room.id = detail_room.room_id AND room.deleted_at IS NULL AND room.status_id = 1";
            $result = $db->getList($select);
            return $result;
        }

        //Phương thức lấy ra chi tiết một room (admin)
        function getDetailRooms($id){
            $db = new connect();
            $select = "SELECT * FROM room, detail_room WHERE room.id = detail_room.room_id AND room.id = $id";
            $result = $db->getList($select);
            return $result;
        }

        //Phương thức lấy ra chi tiết phòng có trong history table booked_room
        function getHistoryRooms($id) {
            $db = new connect();
            $select = "SELECT r.img, r.name, r.sale, d.square_meter, d.quantity, b.booked_arrive, b.booked_quit, b.booked_left_at, b.booked_sum
                       FROM room as r
                       JOIN detail_room as d ON r.id = d.room_id
                       JOIN booked_room as b ON r.id = b.room_id
                       WHERE r.id = $id";
            $result = $db->getList($select);
            return $result;
        }

        //Phương thức lấy ra chi tiết phòng có trong history table booked_room
        function getHistoryRoomsForUser($id, $booked_customer_id) {
            $db = new connect();
            $select = "SELECT r.img, r.name, r.sale, d.square_meter, d.quantity, b.booked_arrive, b.booked_quit, b.booked_left_at, b.booked_sum
                       FROM room as r
                       JOIN detail_room as d ON r.id = d.room_id
                       JOIN booked_room as b ON r.id = b.room_id
                       WHERE r.id = $id AND b.booked_customer_id = '$booked_customer_id'";
            $result = $db->getList($select);
            return $result;
        }
        

        //Phương thức lấy ra các phòng vừa đặt (user)
        function getRoomsJustBooked($customer_id){
            $db = new connect();
            $select = "SELECT DISTINCT r.img, r.name, d.square_meter, d.quantity, b.booked_arrive, b.booked_quit, b.booked_time_book, b.booked_sum
                       FROM room AS r
                       JOIN detail_room AS d ON r.id = d.room_id
                       JOIN booked_room AS b ON r.id = b.room_id
                       WHERE b.booked_left_at IS NULL AND b.booked_unbook = 0 AND b.booked_session = 0 
                             AND b.booked_done_session = 0 AND b.customer_id = '$customer_id'";
            $result = $db->getList($select);
            return $result;
        }

        //Phương thức lấy ra các phòng đã huỷ (user)
        function getRoomsCanceled($customer_id){
            $db = new connect();
            $select = "SELECT DISTINCT r.img, r.name, d.square_meter, d.quantity, b.booked_arrive, b.booked_quit, b.booked_cancel_time, b.booked_sum
                       FROM room AS r
                       JOIN detail_room AS d ON r.id = d.room_id
                       JOIN booked_room AS b ON r.id = b.room_id
                       WHERE b.booked_unbook = 1 AND b.customer_id = '$customer_id'";
            $result = $db->getList($select);
            return $result;
        }

        //Phương thức lấy dòng cuối của table booked_room
        function getLastInsert(){
            $db = new connect();
            $select = "SELECT * FROM booked_room ORDER BY booked_id DESC LIMIT 1";
            $result = $db->getInstance($select);
            return $result;
        }

        //Phương thức thay đổi ảnh chính
        function changeImg($id, $img_main){
            $db = new connect();
            $query = "UPDATE room as r SET r.img = '$img_main' WHERE r.id = $id";
            $result = $db->exec($query);
            return $result;
        }

        //Phương thức thay đổi ảnh chính và ảnh phụ
        function changeImgName($id, $img_main, $img_name){
            $db = new connect();
            $query = "UPDATE room as r JOIN detail_room as d ON r.id = d.room_id
                      SET r.img = '$img_main', d.img_name = '$img_name' WHERE d.room_id = $id";
            $result = $db->exec($query);
            return $result;
        }

        //Phương thức thay đổi diện tích
        function changeSM($id, $sm_value){
            $db = new connect();
            $query = "UPDATE detail_room as d SET d.square_meter = '$sm_value' WHERE d.room_id = $id";
            $result = $db->exec($query);
            return $result;
        }

        //Phương thức thay đổi số khách
        function changeQuantity($id, $quantity_value){
            $db = new connect();
            $query = "UPDATE detail_room as d SET d.quantity = '$quantity_value' WHERE d.room_id = $id";
            $result = $db->exec($query);
            return $result;
        }

        //Phương thức thêm một tiện ích/yêu cầu/mô tả
        function addDetail($id, $new_sv_name, $col){
            $db = new connect();
            $query = "UPDATE detail_room as d SET d.$col = '$new_sv_name' WHERE d.room_id = $id";
            $result = $db->exec($query);
            return $result;
        }

        //Phương thức thêm/xoá một tiện ích/yêu cầu/mô tả được chỉ định
        function addOrDeleteDetail($id, $new_name, $col){
            $db = new connect();
            $query = "UPDATE detail_room as d SET d.$col = '$new_name' WHERE d.room_id = $id";
            $result = $db->exec($query);
            return $result;
        }

        //Phương thức lấy ra tất cả detail_room
        function getDetail_room(){
            $db = new connect();
            $select = "SELECT * FROM detail_room";
            $result = $db->getList($select);
            return $result;
        }

        //Phương thức lấy ra tất cả, như getDetailRooms nhưng không cần ID
        function getAllDetailRoom(){
            $db = new connect();
            $select = "SELECT * FROM room, detail_room WHERE room.id = detail_room.room_id";
            $result = $db->getList($select);
            return $result;
        }

        //Phương thức thay đổi name
        function changeName($id, $value_name){
            $db = new connect();
            $query = "UPDATE room SET room.name = '$value_name' WHERE room.id = $id";
            $result = $db->exec($query);
            return $result;
        }

        //Phương thức lấy kind
        function getKind(){
            $db = new connect();
            $select = "SELECT * FROM kind";
            $result = $db->getList($select);
            return $result;
        }

        //Phương thức thay đổi kind
        function changeKind($id, $kind_id){
            $db = new connect();
            $query = "UPDATE room SET room.kind_id = $kind_id WHERE room.id = $id";
            $result = $db->exec($query);
            return $result;
        }

        //Phương thức thay đổi price
        function changePrice($id, $price_value){
            $db = new connect();
            $query = "UPDATE room SET room.price = $price_value WHERE room.id = $id";
            $result = $db->exec($query);
            return $result;
        }

        //Phương thức thay đổi sale
        function changeSale($id, $sale_value){
            $db = new connect();
            $query = "UPDATE room SET room.sale = $sale_value WHERE room.id = $id";
            $result = $db->exec($query);
            return $result;
        }

        //Phương thức lấy ra status
        function getStatus(){
            $db = new connect();
            $select = "SELECT * FROM status";
            $result = $db->getList($select);
            return $result;
        }

        //Phương thức thêm room mới vào database (thêm chi tiết)
        function createRoom($name, $kind, $price, $sale, $status_id, $img){
            $db = new connect();
            $query = "INSERT INTO room(id, name, kind_id, price, sale, status_id, img) VALUES(NULL, '$name', $kind, $price, $sale, $status_id, '$img')";
            $result = $db->exec($query);
            return $result;
        }

        //Phương thức lấy ra thông tin của một room thông qua id (xem chi tiết)
        function getRoomID($id){
            $db = new connect();
            $select = "SELECT * FROM room WHERE room.id = $id";
            $result = $db->getList($select);
            return $result;
        }

        //Phương thức chỉnh sửa thông tin
        function updateRoom($id, $name, $kind_id, $price, $sale, $status_id, $img){
            $db = new connect();
            $query = "UPDATE room SET name = '$name', kind_id = $kind_id, price = $price, sale = $sale, status_id = $status_id, img = '$img' WHERE room.id = $id";
            $result = $db->exec($query);
            return $result;
        }

        //Phương thức đưa room vào diện trống, có thể đặt room
        function setEmpty($id){
            $db = new connect();
            $query = "UPDATE room as r SET r.status_id = 1, r.booked_room_id = null WHERE r.id = '$id'";
            $result = $db->execp($query);   //Hiển thị ra câu lệnh và đưa nó qua cho controller
            return $result;
        }

        //Phương thức đưa room vào diện đầy
        function moveRoom($id){
            $db = new connect();
            $query = "UPDATE room SET room.status_id = 2 WHERE room.id = $id";
            $result = $db->exec($query);
            return $result;
        }

        //Phương thức đưa room vào quá trình bảo trì, nâng cấp, trùng tu
        function maintainRoom($id){
            $db = new connect();
            $query = "UPDATE room SET room.status_id = 3 WHERE room.id = $id";
            $result = $db->exec($query);
            return $result;
        }

        //Phương thức đóng room ngừng cho thuê
        function deleteRoom($id){
            $db = new connect();
            $query = "UPDATE room SET room.deleted_at = CURRENT_TIMESTAMP WHERE room.id = $id";
            $result = $db->exec($query);
            return $result;
        }

        //Phương thức xoá room hoàn toàn
        function cplDeleteRoom($id){
            $db = new connect();
            $query = "DELETE FROM room WHERE room.id = $id";
            $result = $db->exec($query);
            return $result;
        }

        //Phương thức khôi phục room
        function restoreRoom($id){
            $db = new connect();
            $query = "UPDATE room SET room.deleted_at = NULL WHERE room.id = $id";
            $result = $db->exec($query);
            return $result;
        }
        
        //Phương thức đặt phòng
        function bookRoom($room_id, $customer_id, $customer_booked_id, $booked_customer_name, $booked_tel, $booked_email, $booked_room_name, $booked_price, $booked_sum, $booked_time_book, $booked_arrive, $booked_quit){
            $db = new connect();
            $str = "ORD_";
            $random = rand(0, 99999999);
            $str_rand_room = $str . $random;
            $query = "INSERT INTO booked_room VALUES(NULL, $room_id, $customer_id, '$str_rand_room', '$customer_booked_id', '$booked_customer_name', '$booked_tel', '$booked_email', '$booked_room_name', '$booked_price', '$booked_sum', '$booked_time_book', NULL, '$booked_arrive', '$booked_quit', NULL, 0, 0, 0)";
            $result = $db->exec($query);
            return $result;
        }

        //Phương thức lấy ra thông tin khách hàng đã đặt phòng và chi tiết phòng đã đặt
        // function getBookdedRoom(){
        //     $db = new connect();
        //     $select = "";
        //     $result = $db->exec($select);
        //     return $result;
        // }

        //Phương thức set thời gian nhận/trả phòng và set full cho room
        function updateTime($id, $arrive, $quit){
            $db = new connect();
            $str = "ORD_";
            $random = rand(0, 99999999);
            $str_rand = $str . $random;
            $query = "UPDATE room SET room.arrive = '$arrive', room.quit = '$quit', room.status_id = 2, room.booked_room_id = '$str_rand' WHERE room.id = $id";
            $result = $db->exec($query);
            return $result;
        }

        //Phương thức thêm id của phòng đã đặt vào customers (đặt phòng)
        function addRoomID($id, $customer_id, $col){
            $db = new connect();
            $select = "UPDATE customers SET customers.$col = '$id' WHERE customers.customer_id = $customer_id";
            $result = $db->exec($select);
            return $result;
        }      

        //Phương thức hiển thị thông tin tất cả phòng đã đặt (trong trang hồ sơ đặt phòng)
        function getBookedRooms(){
            $db = new connect();
            $select = "SELECT * FROM booked_room as b WHERE b.booked_left_at IS NULL";
            $result = $db->getList($select);
            return $result;
        }
        
        //Phương thức hiển thị tất cả các phòng đã đặt có phân trang
        function getBookedRoomsPage($start, $limit){
            $db = new connect();
            $select = "SELECT * FROM booked_room as b WHERE b.booked_left_at IS NULL LIMIT ".$start.", ".$limit;
            $result = $db->getList($select);
            return $result;
        }

        //Phương thức hiển thi thông tin tất cả phòng đã huỷ
        function getCanceledRooms(){
            $db = new connect();
            $select = "SELECT * FROM booked_room as b WHERE b.booked_unbook = 1";
            $result = $db->getList($select);
            return $result;
        }

        //Phương thức hiển thị tất cả các phòng đã huỷ có phân trang
        function getCanceledRoomsPage($start, $limit){
            $db = new connect();
            $select = "SELECT * FROM booked_room as b WHERE b.booked_unbook = 1 LIMIT ".$start.", ".$limit;
            $result = $db->getList($select);
            return $result;
        }

        //Phương thức thu hồi phòng đã đặt
        function undoBookedRoom($booked_room_id){
            $db = new connect();
            $query = "UPDATE booked_room as b JOIN room as r ON b.room_id = r.id
                      SET b.booked_left_at = CURRENT_TIMESTAMP, r.status_id = 1 WHERE b.booked_room_id = '$booked_room_id'";
            $result = $db->exec($query);
            return $result;
        }

        //Phương thức huỷ đặt phòng
        function cancelBookedRoom($booked_room_id){
            $db = new connect();
            $query = "UPDATE booked_room as b JOIN room as r ON b.room_id = r.id
                      SET b.booked_unbook = 1, r.status_id = 1, b.booked_cancel_time = CURRENT_TIMESTAMP WHERE b.booked_room_id = '$booked_room_id'";
            $result = $db->exec($query);
            return $result;
        }

        //Phương thức hoàn tác huỷ đặt phòng
        function undoCancelBookedRoom($booked_room_id){
            $db = new connect();
            $query = "UPDATE booked_room as b JOIN room as r ON b.room_id = r.id
                      SET b.booked_unbook = 0, r.status_id = 2, b.booked_cancel_time = NULL WHERE b.booked_room_id = '$booked_room_id'";
            $result = $db->exec($query);
            return $result;
        }

        //Phương thức lấy ra tất cả các phòng đã thu hồi đặt
        function getUndoRoom(){
            $db = new connect();
            $select = "SELECT * FROM booked_room as b 
                       WHERE b.booked_left_at IS NOT NULL AND b.booked_done_session = 1
                       ORDER BY room.id DESC LIMIT 8";
            $result = $db->getList($select);
            return $result;
        }
    }
?>