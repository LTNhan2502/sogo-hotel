<div class="container-fluid">
    <?php
        $checkout = new checkout();
        $fmt = new formatter();
        $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
        $limit = 12; //Giới hạn số bill trong 1 trang
        $page = new page();
        if($keyword && $keyword != ''){
            $count = $checkout->getBillSearch($keyword)->rowCount();
            $trang = $page->findPage($count, $limit);
            $start = $page->findStart($limit);
            $result = $checkout->getBillSearchPage($keyword, $start, $limit);
        }else{
            $count = $checkout->getBill()->rowCount(); //Tổng bill
            $trang = $page->findPage($count, $limit); //Lấy được số trang cần có
            $start = $page->findStart($limit); //Lấy được sản phẩm bắt đầu trong 1 trang
            $result = $checkout->getBillPage($start, $limit);
        }
        $current_page = isset($_GET['page']) ? $_GET['page'] : 1; //Lấy được trang hiện tại
        $checkout = new checkout();
        
    ?>
    <h5>Danh sách hoá đơn</h5>
    <!-- Topbar Search -->
    <!-- <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search"> -->
    <div class="input-group m-4" style="width: 300px !important">
            <input type="text" class="form-control bg-light border-0 small" placeholder="Tìm kiếm theo tên khách hàng" id="search">
            <div class="input-group-append">
                <button class="btn btn-primary" type="button">
                    <i class="fas fa-search fa-sm"></i>
                </button>
            </div>
        </div>
    <!-- </form> -->
    <div class="row row-cols-1 row-cols-md-4 g-4" id="bill_list">
        <div class="d-none" id="limit" data-limit="<?php echo $limit; ?>"></div>
    <?php 
        if($count == 0){
            echo "<h4 class='text-decoration-underline pt-4'>Không có thông tin!</h4>";
        }else{
            while ($set = $result->fetch()):
    ?>
        <div class="col">
            <div class="card h-100 shadow bg-body-tertiary rounded">
                <div class="card-body">
                    <h5 class="card-title">ID đặt phòng: <span class="badge badge-primary" style="float: right;"><?php echo $set['booked_room_id']; ?></span></h5>
                    <h5 class="card-title">ID KH: <span class="badge badge-primary" style="float: right;"><?php echo $set['customer_booked_id']; ?></span></h5>
                    <div class="card-text">
                        <div>Khách hàng: <span><?php echo $set['customer_name']; ?></span></div>
                        <div>Phòng: <span id="bill_customer_name"><?php echo $set['room_name']; ?></span></div>
                        <div>Tổng: <span><?php echo $fmt->formatCurrency($set['bill_price'])."đ"; ?></span></div>
                        <div>Ngày nhận: <span><?php echo $set['bill_arrive']; ?></span></div>
                        <div>Ngày trả: <span><?php echo $set['bill_leave']; ?></span></div>
                        <div>Thanh toán: <span><?php echo $set['bill_checkout_at']; ?></span></div>
                    </div>
                </div>
            </div>
        </div>
    <?php endwhile; } ?>
    </div>
    
    <?php 
        if($trang <= 1){
            echo '';
        }else{
    ?>
    <div class="row mt-4" id="div_nav">
        <nav aria-label="Page navigation example mt-3">
            <?php
                $link = "admin_index.php?action=admin_bill_list&act=pages&page=[i]";
                echo page::pagination($trang, $current_page, $link);
            ?>
        </nav>
    </div>
    <?php } ?>
</div>

<!-- <script src="ajax/bill/bill_page.js"></script> -->
<script src="ajax/search/search_bill.js"></script>