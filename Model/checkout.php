<?php
    class checkout{
        //Phương thức reset thông tin sau khi thanh toán
        function resetAfterCheckout($booked_room_id){
            $db = new connect();
            $query = "UPDATE booked_room AS b 
                      SET b.booked_room_id = NULL, b.booked_arrive = NULL, b.booked_quit = NULL, b.booked_left_at = NULL, b.booked_done_session = 0, b.booked_sum =  NULL
                      WHERE r.id = c.room_id AND r.booked_room_id = '$booked_room_id'";
            $result = $db->exec($query);
            return $result;
        }

        //Phương thức lưu thông tin vào checkout
        function doCheckout($booked_room_id, $customer_booked_id, $customer_email, $bill_price, $bill_arrive, $bill_leave, $bill_checkout_at, $room_name, $customer_name, $customer_tel){
            $db = new connect();
            $query = "INSERT INTO bill VALUES (NULL, '$booked_room_id', '$customer_booked_id', '$customer_email', $bill_price, '$bill_arrive','$bill_leave', '$bill_checkout_at', '$room_name', '$customer_name', '$customer_tel')";
            $result = $db->exec($query);
            return $result;
        }

        //Phương thức hiển thị tất cả bill không dùng phân trang
        function getBill(){
            $db = new connect();
            $select = "SELECT * FROM bill";
            $result = $db->getList($select);
            return $result;
        }

        //Phương thức hiển thị tất cả bill dùng phân trang
        function getBillPage($start, $limit){
            $db = new connect();
            $select = "SELECT * FROM bill ORDER BY bill.bill_id DESC LIMIT ".$start.",".$limit;
            $result = $db->getList($select);
            return $result;
        }

        //Phương thức hiển thị tất cả bill dựa theo từ tìm kiếm
        function getBillSearch($keyword){
            $db = new connect();
            $select = "SELECT * FROM bill WHERE bill.customer_name LIKE '%$keyword%' ORDER BY bill.bill_id DESC";
            $result = $db->getList($select);
            return $result;
        }

        //Phương thức hiển thị tất cả bill dựa theo từ tìm kiếm và có phân trang
        function getBillSearchPage($keyword, $start, $limit){
            $db = new connect();
            $select = "SELECT * FROM bill WHERE bill.customer_name LIKE '%$keyword%' ORDER BY bill.bill_id DESC LIMIT $start, $limit";
            $result = $db->getList($select);
            return $result;
        }
    }
?>