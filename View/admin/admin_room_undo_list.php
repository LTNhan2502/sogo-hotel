<div class="container-fluid">
    <h5>Hồ sơ thanh toán</h5>
    <div class="row row-cols-1 row-cols-md-4 g-4">
        <?php
            $room = new room();
            $fmt = new formatter();
            $result = $room->getUndoRoom();
            $rowCount = $result->rowCount();
            if( $rowCount == 0){
                echo "<h5 class='text-decoration-underline pt-4'>Chưa có thông tin!</h5>";
            }else{
                while($set = $result->fetch()):
        ?>

        <div class="col">
            <div class="card h-100 shadow bg-body-tertiary rounded">
                <div class="card-body">
                    <h5 class="card-title">ID đặt phòng: <span class="badge badge-primary"><?php echo $set['booked_room_id']; ?></span></h5>
                    <div class="card-text">
                        <div>Khách hàng: <?php echo $set['customer_name']; ?></div>
                        <div>Phòng: <?php echo $set['name']; ?></div>
                        <div>Tổng: <?php echo $fmt->formatCurrency($set['sum'])."đ"; ?></div>
                        <div class="d-none booked_room_id" data-id="<?php echo $set['booked_room_id']; ?>"></div>
                        <div class="d-none customer_booked_id" data-customer_id="<?php echo $set['customer_booked_id']; ?>"></div>
                        <div class="d-none email" data-email="<?php echo $set['email'] == null ? $set['email_guest'] : $set['email']; ?>"></div>
                        <div class="d-none customer_sum" data-customer_sum="<?php echo $set['sum']; ?>"></div>
                        <div class="d-none arrive" data-arrive="<?php echo $set['arrive']; ?>"></div>
                        <div class="d-none quit" data-quit="<?php echo $set['quit'] ?>"></div>
                        <div class="d-none left" data-left_at="<?php echo $set['left_at']; ?>"></div>
                        <div class="d-none room_name" data-room_name="<?php echo $set['name']; ?>"></div>
                        <div class="d-none customer_name" data-customer_name="<?php echo $set['customer_name']; ?>"></div>
                        <div class="d-none tel" data-tel="<?php echo $set['tel']; ?>"></div>
                        <div>Trạng thái: 
                            <?php
                                if($set['session'] == 1 && $set['done_session'] == 0){
                                    echo "<span class='badge badge-info'>Đã nhận phòng</span>";
                                }else if($set['session'] == 0 && $set['done_session'] == 1){
                                    echo "<span class='badge badge-success'>Đã trả phòng</span>";
                                    echo "<button class='btn btn-primary mt-2 d-block mx-auto' id='do_checkout'>Thanh toán → Xem hoá đơn</button>";
                                }else if($set['session'] == 0 && $set['done_session'] == 0){
                                    echo "<span class='badge badge-warning'>Chưa nhận phòng</span>";
                                };
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>  
        <?php endwhile; } ?>      
    </div>
</div>

<script src="ajax/room/checkout.js"></script>