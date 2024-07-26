<link rel="stylesheet" href="Content/admin/css/room_list.css">
<div class="container-fluid">
    <?php
        if(!checkAuthority('admin_index.php?action=admin_room_list')){
            echo 'Không có quyền truy cập!';exit;
        }
        $room = new room();
        $fmt = new formatter();
        $checkout = new checkout();
        $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
        $page = new page();
        $limit = 6; //Giới hạn số bill trong 1 trang
        if($keyword && $keyword != ''){
            $count = $room->getRoomsSearch($keyword)->rowCount();
            $trang = $page->findPage($count, $limit);
            $start = $page->findStart($limit);
        }else{
            $count = $room->getRooms()->rowCount(); //Tổng bill
            $trang = $page->findPage($count, $limit); //Lấy được số trang cần có
            $start = $page->findStart($limit); //Lấy được sản phẩm bắt đầu trong 1 trang
        }
        $current_page = isset($_GET['page']) ? $_GET['page'] : 1; //Lấy được trang hiện tại
        $checkout = new checkout();
        // $result = $room->getRoomsPage($start, $limit);
        
    ?>
    <!-- Topbar Search -->
    <!-- <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search"> -->
        <div class="input-group" style="width: 300px !important">
            <input type="text" class="form-control bg-light border-0 small" placeholder="Tìm kiếm theo tên phòng" id="search">
            <div class="input-group-append">
                <button class="btn btn-primary" type="button">
                    <i class="fas fa-search fa-sm"></i>
                </button>
            </div>
        </div>
    <!-- </form> -->

    <div class="card shadow mb-4 mt-4">
        <div class="card-header py-3 d-flex justify-content-between">
            <span class="m-0 font-weight-bold text-primary">Table Room</span>
            <?php
                if(checkAuthority('admin_room_list?act=create_room')){
                    echo '<a class="btn m-0 font-weight-bold btn-primary" href="admin_index.php?action=admin_room_list&act=create_room"><i class="fas fa-plus-circle"></i></a>';
                }
            ?>
            
        </div>
        <div class="card-body">
            <div class="d-none" id="limit" data-limit="<?php echo $limit; ?>"></div>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Ảnh</th>
                            <th>Loại</th>
                            <th>Tên phòng</th>
                            <th>Đơn giá (đ)</th>
                            <th>Giảm giá (đ)</th>
                            <th>Trạng thái</th>
                            <th class="text-end">Hành động</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Ảnh</th>
                            <th>Loại</th>
                            <th>Tên phòng</th>
                            <th>Đơn giá (đ)</th>
                            <th>Giảm giá (đ)</th>
                            <th>Trạng thái</th>
                            <th class="text-end">Hành động</th>
                        </tr>
                    </tfoot>
                    <tbody id="room_list_body">
                        <?php
                        if($keyword && $keyword != ''){
                            $results = $room->getRoomsSearchPage($keyword, $start, $limit);                            
                        }else{
                            $results = $room->getRoomsPage($start, $limit);                            
                        }
                            $count = 1;
                            while($set = $results->fetch()):
                        ?>
                        <tr id="currency-<?php echo $set['id']; ?>">
                            <!-- ID -->
                            <td width="51px">
                                <div id="id" data-id="<?php echo $set['id']; ?>"><?php echo $set['id']; ?></div>
                            </td>
                            <!-- Image -->
                            <td width="97px">
                                <img src="Content/images/<?php echo $set['img']; ?>" width="60px" height="60px" alt="">
                            </td>
                            <!-- Kind of room -->
                            <td width="156px">
                                <span class="kind-text" id="kind-text-<?php echo $set['id']; ?>">
                                    <?php 
                                        if($set['kind_id'] == 1){
                                            echo "Single";
                                        }else if($set['kind_id'] == 2){
                                            echo "Family";
                                        }else{
                                            echo "Presidential";
                                        }
                                    ?>
                                </span>
                                <select name="kind" class="form-control d-none" id="kind-<?php echo $set['id']; ?>">
                                    <?php 
                                        $kind = $room->getKind();
                                        while($set_kind = $kind->fetch()):
                                    ?>
                                    <option value="<?php echo $set_kind['kind_id']; ?>" 
                                            <?php echo $set['kind_id'] == $set_kind['kind_id'] ? 'selected' : ''; ?>
                                            data-id="<?php echo $set['id']; ?>"
                                            data-act="<?php echo $set_kind['kind_name']; ?>"
                                        ><?php echo $set_kind['kind_name'] ?>
                                    </option>
                                    <?php endwhile; ?>
                                </select>
                            </td>
                            <!-- Name of room -->
                            <td width="281px">  
                                <span class="name-text" id="name-text-<?php echo $set['id']; ?>"><?php echo $set['name']; ?></span>
                                <input type="text" class="form-control d-none" name="name" id="name-<?php echo $set['id']; ?>" 
                                        value="<?php echo $set['name']; ?>"
                                        data-id="<?php echo $set['id']; ?>"
                                        data-value="<?php echo $set['name']; ?>">
                            </td>
                            <!-- Price -->
                            <td style="width: 138px;">
                                <span class="price-text" id="price-text-<?php echo $set['id']; ?>"><?php echo $fmt->formatCurrency($set['price']); ?></span>
                                <input type="text" class="form-control d-none" name="price" id="price-<?php echo $set['id']; ?>"
                                    value="<?php echo $fmt->formatCurrency($set['price']); ?>"
                                    data-id="<?php echo $set['id']; ?>"
                                    data-value="<?php echo $fmt->formatCurrency($set['price']); ?>">
                            </td>
                            <!-- Sale -->
                            <td style="width: 138px;">
                                <span class="sale-text" id="sale-text-<?php echo $set['id']; ?>"><?php echo $fmt->formatCurrency($set['sale']); ?></span>
                                <input type="text" class="form-control d-none" name="sale" id="sale-<?php echo $set['id']; ?>"
                                    value="<?php echo $fmt->formatCurrency($set['sale']); ?>"
                                    data-id="<?php echo $set['id']; ?>"
                                    data-value="<?php echo $fmt->formatCurrency($set['sale']); ?>">
                            </td>
                            <!-- Status of room -->
                            <td width="150px">
                                <span class="status-text" id="status-text-<?php echo $set['id']; ?>">
                                    <?php 
                                        if($set['status_id'] == 1){
                                            echo "Empty";
                                        }else if($set['status_id'] == 2){
                                            echo "Full";
                                        }else{
                                            echo "Maintained";
                                        }
                                    ?>
                                </span>
                                <select name="status" class="form-control d-none" id="status-<?php echo $set['id']; ?>">
                                    <?php 
                                        $status = $room->getStatus();
                                        while($result = $status->fetch()):
                                    ?>
                                    <option value="<?php echo $result['status_id']; ?>" 
                                            data-id="<?php echo $set['id']; ?>" 
                                            data-act=<?php echo $result['act']; ?>
                                            <?php echo $result['status_id'] == $set['status_id'] ? 'selected' : '' ?>>
                                        <?php echo $result['name']; ?>
                                    </option>
                                    <?php endwhile; ?>
                                </select>
                            </td>
                            <td class="text-end">
                                <?php
                                    if(checkAuthority('admin_room_list?act=edit_detail&id')){
                                ?>
                                <button type="button" class="btn btn-self btn-secondary mr-1 edit-btn" data-id="<?php echo $set['id']; ?>">
                                    <i class="fas fa-edit"></i>
                                </button>  
                                <?php } ?>                              
                                <button type="button" class="btn btn-self btn-warning mr-1 cancel-btn d-none" data-id="<?php echo $set['id']; ?>">
                                    <i class="fas fa-times"></i>
                                </button>
                                <button type="button" class="btn btn-self btn-primary mr-1 modal_btn" data-toggle="modal" data-target="#exampleModal<?php echo $set['id']; ?>">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <?php
                                    if(checkAuthority('admin_room_list?act=delete_room')){
                                ?>
                                <button type="button" data-delete_room_id="<?php echo $set['id']; ?>" id="delete_room_id" class="btn btn-self btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <?php } ?>
                            </td>
                        </tr>
                        
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal<?php echo $set['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <?php 
                            $id = $set['id'];
                            $detail = $room->getDetailRooms($id);                                            
                            $detail = $detail->fetch();
                            if(isset($detail['id'])){
                        ?> 
                            <div class="modal-dialog modal-dialog-scrollable modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">
                                            Xem chi tiết phòng <span class="detail_name"><?php echo $set['name']; ?></span>
                                        </h5>
                                        <div class="header-buttons ml-auto">
                                            <?php
                                                if(checkAuthority('admin_room_list?act=edit_detail&id')){
                                            ?>
                                            <a href="admin_index.php?action=admin_room_list&act=edit_detail&id=<?php echo $set['id']; ?>" class="btn btn-edit"><i class="far fa-edit"></i></a>
                                            <?php } ?>
                                            <button type="button" class="btn btn-close" data-dismiss="modal" aria-label="Close">
                                                <!-- <span aria-hidden="true">&times;</span> -->
                                            </button>
                                        </div>
                                    </div>


                                    <div class="modal-body">                                        
                                        <div class="row" ">
                                            <!-- Ảnh -->
                                            <div class="col-lg-8 bg-dark card image-container">
                                                <img src="Content/images/<?php echo $detail['img']; ?>" class="image-big m-4" width="90%">
                                                <div class="image-row">
                                                    <?php 
                                                        $item_img = $detail['img_name'];
                                                        $img_arr = explode(' - ', $item_img);
                                                        $img_num = count($img_arr);
                                                        echo "<img src='Content/images/".$detail['img']."' class='image-small mb-4 selected'"; 
                                                        for($i = 0; $i < $img_num; $i++){
                                                            echo "<img src='Content/images/".$img_arr[$i]."' class='image-small mb-4' 
                                                                  data-img-show='Content/images/".$img_arr[$i]."'>"; 
                                                        }
                                                    ?>
                                                </div>                                        
                                            </div>
                                            <!-- Mét vuông và số lượng người/phòng -->
                                            <div class="col-lg-4">
                                                <div class="row d-flex justify-content-between">
                                                    <h4>Thông tin sơ bộ</h4>
                                                    <div>
                                                        <ul>
                                                            <li><?php echo " " . $detail['square_meter'] . "m²";?></li>
                                                            <li><?php echo " " . $detail['quantity'] . " khách"; ?></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div>
                                                        <hr>
                                                        <!-- Tiện ích -->
                                                        <h4>Tiện ích</h4>
                                                        <?php  
                                                            $item = $detail['service_name'];
                                                            $service = explode(" - ", $item);
                                                            $set_sv = count($service);    
                                                        ?>
                                                            <ul>
                                                                <?php for($i = 0; $i < $set_sv; $i++): ?>
                                                                    <li><?php echo $service[$i]; ?></li>
                                                                <?php endfor; ?>
                                                            </ul>
                                                        <hr>

                                                        <!-- Yêu cầu -->
                                                        <h4>Yêu cầu</h4>
                                                        <?php  
                                                            $reqs = $detail['requirement'];
                                                            $req = explode(" - ", $reqs);
                                                            $set_req = count($req);    
                                                        ?>
                                                            <ul>
                                                                <?php for($i = 0; $i < $set_req; $i++): ?>
                                                                    <li><?php echo $req[$i]; ?></li>
                                                                <?php endfor; ?>
                                                            </ul>
                                                        <hr>

                                                        <!-- Mô tả -->
                                                        <h4>Về phòng này</h4>
                                                        <?php
                                                            $item_des  = $detail['description'];
                                                            $des = explode(' - ', $item_des);
                                                            $des_num = count($des);
                                                            for($i = 0; $i < $des_num; $i++){
                                                                echo "- $des[$i] </br>";
                                                            }
                                                        ?> 
                                                        <br>
                                                        <div class="shadow-inset-md bg-body-tertiary p-3 text-center fw-bolder fs-6">
                                                            <?php
                                                                echo "Khởi điểm từ <span style='color: rgb(255, 94, 31);'>".$fmt->formatCurrency($detail['sale'])."</span> đ/phòng/đêm";
                                                            ?>
                                                            <a class="btn btn-primary" width=""100% href="admin_index.php?action=admin_room_book&selected_room_id=<?php echo $set['id']; ?>">Chọn phòng này</a>
                                                        </div>                                               
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php }else{ ?>
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Xem chi tiết phòng <span class="detail_name"><?php echo $set['name']; ?></span></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row parent text-center">
                                            <h5 class="before-open-h5 text-center">Chưa có thông tin chi tiết của phòng này</h5>
                                            <h5 class="after-open-h5 hide">Thêm mới thông tin chi tiết cho phòng <?php echo $set['name']; ?></h5>
                                            <span class="open-btn">
                                                <a href="admin_index.php?action=admin_room_list&act=create_detail&id=<?php echo $set['id']; ?>" class="btn btn-primary open-create-detail"><i class="fas fa-plus-circle"></i></a>
                                            </span>                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                        <!-- End Modal -->
                        <?php 
                            $count++;
                            endwhile;
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
                            $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
                            $link = "admin_index.php?action=admin_room_list&act=" . (isset($keyword) && $keyword != '' ? "search&keyword=$keyword" : "pages") . "&page=[i]";
                            echo page::pagination($trang, $current_page, $link);                            
                        ?>
                    </nav>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>


<script src="ajax/room/status.js"></script>
<script src="ajax/room/detail_modal.js"></script>
<script src="ajax/room/room_restore.js"></script>
<script src="ajax/search/search_room.js"></script>
<script>
    $(document).on("click", ".image-small", function(){
        let image_container = $(this).closest(".image-container");
        let image_big = image_container.find(".image-big");

        //Xoá tất cả selected class trong image-small (mỗi đối tượng mỗi khác)
        image_container.find(".image-small").removeClass("selected");

        //Thêm selected class vào image-small được click
        $(this).addClass("selected");

        //Lấy data từ data-img-show
        let newSrc = $(this).data("img-show");

        //Cập nhật lại đường link của image-big
        image_big.attr("src", newSrc);
    });

    //Thay đổi trạng thái của các input
    $(document).on('click', '.edit-btn', function() {
        var id = $(this).data('id');

        // Ẩn tất cả input và chỉ hiện text
        $('tr[id^="currency-"]').each(function() {
            var otherId = $(this).attr('id').split('-')[1];
            if (otherId != id) {
                $('#kind-' + otherId).addClass('d-none');
                $('#name-' + otherId).addClass('d-none');
                $('#price-' + otherId).addClass('d-none');
                $('#sale-' + otherId).addClass('d-none');
                $('#status-' + otherId).addClass('d-none');

                $('#kind-text-' + otherId).removeClass('d-none');
                $('#name-text-' + otherId).removeClass('d-none');
                $('#price-text-' + otherId).removeClass('d-none');
                $('#sale-text-' + otherId).removeClass('d-none');
                $('#status-text-' + otherId).removeClass('d-none');

                $(this).find('.edit-btn').removeClass('d-none');
                $(this).find('.cancel-btn').addClass('d-none');
            }
        });

        // Ẩn/Hiện giữa input và text
        $('#kind-' + id).toggleClass('d-none');
        $('#name-' + id).toggleClass('d-none');
        $('#price-' + id).toggleClass('d-none');
        $('#sale-' + id).toggleClass('d-none');
        $('#status-' + id).toggleClass('d-none');

        $('#kind-text-' + id).toggleClass('d-none');
        $('#name-text-' + id).toggleClass('d-none');
        $('#price-text-' + id).toggleClass('d-none');
        $('#sale-text-' + id).toggleClass('d-none');
        $('#status-text-' + id).toggleClass('d-none');

        // Ẩn nút edit và hiển thị nút cancel edit
        $(this).addClass('d-none');
        $(this).siblings('.cancel-btn').removeClass('d-none');
    });

    $(document).on('click', '.cancel-btn', function() {
        var id = $(this).data('id');

        // Ẩn input và hiển thị text
        $('#kind-' + id).addClass('d-none');
        $('#name-' + id).addClass('d-none');
        $('#price-' + id).addClass('d-none');
        $('#sale-' + id).addClass('d-none');
        $('#status-' + id).addClass('d-none');

        $('#kind-text-' + id).removeClass('d-none');
        $('#name-text-' + id).removeClass('d-none');
        $('#price-text-' + id).removeClass('d-none');
        $('#sale-text-' + id).removeClass('d-none');
        $('#status-text-' + id).removeClass('d-none');

        // Hiển thị nút edit và ẩn cancel edit
        $(this).addClass('d-none');
        $(this).siblings('.edit-btn').removeClass('d-none');
    });


</script>
