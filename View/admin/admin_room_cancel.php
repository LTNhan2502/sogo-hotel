<div class="container-fluid">
    <!-- Page Heading --> 
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between">
            <span class="m-0 font-weight-bold text-primary">Danh sách phòng đã huỷ</span>
        </div>
        <div class="card-body">
        <?php
            $room = new room();
            $fmt = new formatter();
            $count = $room->getBookedRooms()->rowCount(); //Tổng book
            $limit = 5; //Giới hạn số book trong 1 trang
            $page = new page();
            $trang = $page->findPage($count, $limit); //Lấy được số trang cần có
            $start = $page->findStart($limit); //Lấy được sản phẩm bắt đầu trong 1 trang
            $current_page = isset($_GET['page']) ? $_GET['page'] : 1; //Lấy được trang hiện tại
            $checkout = new checkout();
            $booked_room = $room->getCanceledRooms();
            $rowCount = $booked_room->rowCount();
            $booked_room_page = $room->getCanceledRoomsPage($start, $limit);
        ?>
            <div class="table-responsive">
                <?php
                    if( $rowCount == 0){
                        echo "<h4 class='text-decoration-underline'>Chưa có thông tin   !</h4>";
                    }else{
                ?>
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Thông tin khách hàng</th>
                            <th>Phòng</th>
                            <th>Thông tin phòng đặt</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Thông tin khách hàng</th>
                            <th>Phòng</th>
                            <th>Thông tin phòng đặt</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php                            
                            $count = 1;
                            while ($result = $booked_room_page->fetch()):
                        ?>
                        <tr style="max-height: 100px">
                            <td><?php echo $count; ?></td>
                            <td>
                                <div>ID đặt phòng: 
                                    <span class="badge badge-pill badge-primary booked_room_id" data-id="<?php echo $result['booked_room_id']; ?>"><?php echo $result['booked_room_id']; ?></span>
                                </div>
                                <div>ID khách hàng: 
                                    <span class="badge badge-pill badge-primary customer_booked_id" data-customer_booked_id="<?php echo $result['booked_customer_id']; ?>"><?php echo $result['booked_customer_id']; ?></span>
                                </div>
                                <div class="customer_name" data-customer_name="<?php echo $result['booked_customer_name']; ?>"><span class="text-decoration-underline" style="font-weight: 900">Tên KH:</span> <?php echo $result['booked_customer_name']; ?></div>
                                <div class="tel" data-tel="<?php echo $result['booked_tel']; ?>">Số điện thoại: <?php echo $result['booked_tel']; ?></div>
                                <div id="customer_email" data-email="<?php echo $result['booked_email']; ?>">Email: <?php echo $result['booked_email']; ?></div>
                            </td>
                            <td>
                                <div class="room_name" data-room_name="<?php echo $result['booked_room_name']; ?>"><span class="text-decoration-underline" style="font-weight: 900">Phòng:</span> <?php echo $result['booked_room_name']; ?></div>
                                <div>Giá: <?php echo $fmt->formatCurrency($result['booked_price'])."đ"; ?></div>
                                <div class="customer_sum" data-customer_sum="<?php echo $result['booked_sum']; ?>"><span class="text-decoration-underline" style="font-weight: 900">Tổng:</span> <?php echo $fmt->formatCurrency($result['booked_sum'])."đ"; ?></div>
                            </td>
                            <td id="info_book">
                                <div class="arrive" data-arrive="<?php echo $result['booked_arrive']; ?>">Ngày vào: <?php echo $result['booked_arrive']; ?></div>
                                <div class="quit" data-quit="<?php echo $result['booked_quit']; ?>">Ngày trả: <?php echo $result['booked_quit']; ?></div>
                                <div><span class="text-decoration-underline" style="font-weight: 900">Tình trạng:</span>                                    
                                    <span class="badge badge-pill badge-danger" id="badge_receive">Đã huỷ</span>                                    
                                </div>
                                <?php if($result['booked_unbook'] == 1){ ?>
                                    <div id="cancel_time">Huỷ lúc: <?php echo $result['booked_cancel_time']; ?></div>
                                <?php }else{
                                    echo '<div id="cancel_time"></div>';
                                } ?>
                            </td>                            
                        </tr>
                        <?php 
                                $count++;
                                endwhile;
                            } 
                        ?>
                    </tbody>
                </table>
                <?php 
                    if($trang <= 1){
                        echo '';
                    }else{
                ?>
                <div class="row mt-4" id="div_nav">
                    <nav aria-label="Page navigation example mt-3">
                        <?php
                            $link = "admin_index.php?action=admin_room_check&act=pages&page=[i]";
                            echo page::pagination($trang, $current_page, $link);
                        ?>
                    </nav>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<style>
    .btn-same{
        min-width: 170px;
        font-size: 0.8rem;
    }

    
</style>