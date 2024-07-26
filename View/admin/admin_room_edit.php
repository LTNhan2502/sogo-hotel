<?php
    $fmt = new formatter();
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    }
    $room = new room();
    $detail_room = $room->getDetailRooms($id);
    $detail = $detail_room->fetch();
    $item_img = $detail['img_name'];
    $img_arr = explode(' - ', $item_img);
?>

<div class="container-fluid">
    <!-- Page Heading -->

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between">
            <span class="m-0 font-weight-bold text-primary">Table Room - Thay đổi chi tiết phòng</span>
            <a class="btn m-0 font-weight-bold btn-primary" href="admin_index.php?action=admin_room_list"><i
                    class="fas fa-long-arrow-alt-left"></i></a>
        </div>
        <div class="card-body d-flex justify-content-center">
            <div class="" style="width: 90%;">
            <div class="d-none" id="detail_id" data-detail_id="<?php echo $id; ?>"></div>                
                <div class="row">                    
                    <div class="col-lg-7 col-md-7 card image-container">
                        <form enctype='multipart/form-data' id='changeForm' method='post'>
                            <div class="d-flex flex-column align-items-center">
                                <input type="number" class="d-none" value="<?php echo $id; ?>" name="id">
                                <!-- Ảnh lớn -->
                                <img src="Content/images/<?php echo $detail['img']; ?>" class="image-big m-4 preview_img" id="preview_img" width="90%" height="450px">                                                            
                                <div class="input-group d-flex flex-nowrap">
                                    <input type="file" id="img" class="form-control img" 
                                        accept=".png,.jpeg,.jpg,.gif" name="img_main">
                                    <!-- Nếu không chọn ảnh mới thì lấy ảnh cũ -->
                                    <div type="text" class="d-none"  data-img_main_value="<?php echo $detail['img']; ?>" id="img_main_old"></div>
                                </div>                                                           
                                <small id="img_error" class="text-danger img_error"></small>
                                <!-- 3 ảnh nhỏ -->
                                <div class="row upload-row mt-5 justify-content-center">
                                    <div class="col-md-4 custom-column d-flex flex-column align-items-center">
                                        <img src="Content/images/<?php echo $img_arr[1]; ?>" class="image-small-1 imgs" id="preview_img1" width="150px"
                                            height="125px">
                                        <input type="file" id="img1" class="form-control my-3"
                                            accept=".png,.jpeg,.jpg,.gif" name="img_sub_1">
                                        <!-- Nếu không chọn ảnh mới thì lấy ảnh cũ -->
                                        <div type="text" class="d-none"  data-img_sub_1_value="<?php echo $img_arr[1]; ?>" id="img_sub_1_old"></div>
                                        <small id="img_error1" class="text-danger"></small>
                                    </div>
                                    <div class="col-md-4 custom-column d-flex flex-column align-items-center">
                                        <img src="Content/images/<?php echo $img_arr[2]; ?>" class="image-small-2 imgs" id="preview_img2" width="150px"
                                            height="125px">
                                        <input type="file" id="img2" class="form-control my-3"
                                            accept=".png,.jpeg,.jpg,.gif" name="img_sub_2">
                                        <!-- Nếu không chọn ảnh mới thì lấy ảnh cũ -->
                                        <div type="text" class="d-none"  data-img_sub_2_value="<?php echo $img_arr[2]; ?>" id="img_sub_2_old"></div>
                                        <small id="img_error2" class="text-danger"></small>
                                    </div>
                                    <div class="col-md-4 custom-column d-flex flex-column align-items-center">
                                        <img src="Content/images/<?php echo $img_arr[3]; ?>" class="image-small-3 imgs" id="preview_img3" width="150px"
                                            height="125px">
                                        <input type="file" id="img3" class="form-control my-3"
                                            accept=".png,.jpeg,.jpg,.gif" name="img_sub_3">
                                        <!-- Nếu không chọn ảnh mới thì lấy ảnh cũ -->
                                        <div type="text" class="d-none"  data-img_sub_3_value="<?php echo $img_arr[3]; ?>" id="img_sub_3_old"></div>
                                        <small id="img_error3" class="text-danger"></small>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button class="btn btn-primary mt-3" type="submit">Cập nhật</button>
                            </div>
                        </form>
                    </div>                    
                    <div class="col-lg-5 col-md-3">
                        <div class="row d-flex justify-content-between">
                            <input class="d-none" name="id_create" value="<?php echo $id; ?>"></input>
                            <div>                                    
                                <h4>Thông tin sơ bộ</h4>
                                <div>
                                    <ul id="ul_sm_q">
                                        <!-- Diện tích -->
                                        <li>
                                            <div class="d-flex flex-nowrap align-items-center" id="sm_change">
                                                <span><?php echo " " . $detail['square_meter'] . "m²"; ?></span>
                                                <div class="ml-3 ml-auto d-flex flex-column">
                                                    <input type="text" class="form-control same-input" 
                                                        name="square_meter_create" id="square_meter_create"
                                                        data-detail_id="<?php echo $id; ?>" placeholder="Thay đổi diện tích">
                                                    <small id="sm_error" class="text-danger mt-1"></small>
                                                </div>
                                            </div>

                                            <!-- <input type="text" class="form-control ml-3 ml-auto" name="square_meter_create"
                                                id="square_meter_create" placeholder="Thay đổi diện tích">
                                            <small id="sm_error" class="text-danger"></small> -->
                                        </li>

                                        <!-- Số khách -->
                                        <li>
                                            <div class="d-flex flex-nowrap align-items-center mt-3" id="quantity_change">
                                                <span><?php echo " " . $detail['quantity'] . " khách"; ?></span>
                                                <div class="ml-3 ml-auto d-flex flex-column">
                                                    <input type="text" class="form-control ml-auto" 
                                                        name="quantity_create" id="quantity_create" 
                                                        data-detail_id="<?php echo $id; ?>" placeholder="Thay đổi số khách">
                                                    <small id="quantity_error" class="text-danger mt-1"></small>
                                                </div>                                                    
                                            </div>                                                
                                        </li>
                                    </ul>
                                </div> 
                                <hr>                                   
                            </div>
                        </div>
                        <div class="row">
                            <div>
                                <!-- Tiện ích -->
                                <h4>Tiện ích</h4>
                                <?php  
                                    $item = $detail['service_name'];
                                    $service = explode(" - ", $item);
                                    $set_sv = count($service);    
                                ?>
                                <ul id="ul_sv">
                                    <?php for($i = 0; $i < $set_sv; $i++): ?>
                                        <li class="sv<?php echo $i; ?>">
                                            <div class="d-flex flex-nowrap align-items-center mt-1">
                                                <span><?php echo $service[$i]; ?></span>
                                                <button class="btn btn-danger ml-auto dl_sv" id="delete_sv_name" 
                                                    data-service="<?php echo $service[$i]; ?>"
                                                    data-detail_id="<?php echo $id; ?>">                                                        
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>                                                     
                                        </li>
                                    <?php endfor; ?>                                        
                                </ul>
                                <div>
                                    <input type="text" class="form-control mt-3" 
                                        id="service_create" name="service_create" placeholder="Thêm tiện ích">
                                    <small id="sv_error" class="text-danger"></small>
                                </div>
                                <hr>                                    

                                <!-- Yêu cầu -->
                                <h4>Yêu cầu</h4>
                                <?php  
                                    $reqs = $detail['requirement'];
                                    $req = explode(" - ", $reqs);
                                    $set_req = count($req);    
                                ?>
                                    <ul id="ul_req">
                                        <?php for($i = 0; $i < $set_req; $i++): ?>
                                            <li class="req<?php echo $i; ?>">
                                                <div class="d-flex flex-nowrap align-items-center mt-1">
                                                    <span><?php echo $req[$i]; ?></span>
                                                    <button class="btn btn-danger ml-auto" id="delete_req_name"
                                                        data-requirement="<?php echo $req[$i]; ?>"
                                                        data-detail_id="<?php echo $id; ?>">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>   
                                            </li>
                                        <?php endfor; ?>                                            
                                    </ul>
                                    <input type="text" class="form-control mt-3" 
                                        id="requirement_create" name="requirement_create" placeholder="Thêm yêu cầu">
                                    <small id="req_error" class="text-danger"></small>
                                <hr>

                                <!-- Mô tả -->
                                <h4>Về phòng này</h4>
                                <?php
                                    $item_des  = $detail['description'];
                                    $des = explode(' - ', $item_des);
                                    $des_num = count($des);
                                ?> 
                                    <ul id="ul_des">
                                        <?php for($i = 0; $i < $des_num; $i++): ?>
                                            <li class="des<?php echo $i; ?>">
                                                <div class="d-flex flex-nowrap align-items-center mt-1">
                                                    <span style="width: 330px;"><?php echo $des[$i]; ?></span>
                                                    <button class="btn btn-danger ml-auto" id="delete_des_name"
                                                        data-description="<?php echo $des[$i]; ?>"
                                                        data-detail_id="<?php echo $id; ?>">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>   
                                            </li>
                                        <?php endfor; ?>                                            
                                    </ul>
                                    <textarea class="form-control mt-3" 
                                        id="description_create" name="description_create" placeholder="Thêm mô tả"></textarea>                                    
                                    <small id="des_error" class="text-danger"></small>
                                <br>                                  
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
<!-- /.container-fluid -->

<script src="ajax/room/edit_detail.js"></script>

<style>
    .image-container {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .image-big {
        border-radius: 10px;
        max-height: 650px;
    }

    .upload-row .custom-column {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .imgs{
        border-radius: 10px;
        width: 150px;
        height: 125px;
    }

    small{
        margin-top: -15px;
    }

    .ml-auto{
        max-width: 180px;
        margin-left: auto;
    }
</style>