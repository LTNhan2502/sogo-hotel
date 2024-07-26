<?php
    $fmt = new formatter();
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    }
?>

<div class="container-fluid">
    <!-- Page Heading -->

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between">
            <span class="m-0 font-weight-bold text-primary">Table Room - Thêm mới chi tiết phòng</span>
            <a class="btn m-0 font-weight-bold btn-primary" href="admin_index.php?action=admin_room_list"><i
                    class="fas fa-long-arrow-alt-left"></i></a>
        </div>
        <div class="card-body d-flex justify-content-center">
            <div class="" style="width: 90%;">
                <form enctype='multipart/form-data' id='createForm' method='post'>
                    <div class="row">
                        <div class="col-lg-8 col-md-8 card image-container">
                            <div class="d-flex flex-column align-items-center">
                                <!-- 3 ảnh nhỏ -->
                                <div class="row upload-row mt-3 justify-content-center">
                                    <div class="col-md-4 custom-column d-flex flex-column align-items-center">
                                        <img src="" class="image-small-1 imgs" id="preview_img1" width="150px"
                                            height="125px">
                                        <input type="file" id="img1" class="form-control my-3"
                                            accept=".png,.jpeg,.jpg,.gif" name="img_sub_1">
                                        <small id="img_error1" class="text-danger"></small>
                                    </div>
                                    <div class="col-md-4 custom-column d-flex flex-column align-items-center">
                                        <img src="" class="image-small-2 imgs" id="preview_img2" width="150px"
                                            height="125px">
                                        <input type="file" id="img2" class="form-control my-3"
                                            accept=".png,.jpeg,.jpg,.gif" name="img_sub_2">
                                        <small id="img_error2" class="text-danger"></small>
                                    </div>
                                    <div class="col-md-4 custom-column d-flex flex-column align-items-center">
                                        <img src="" class="image-small-3 imgs" id="preview_img3" width="150px"
                                            height="125px">
                                        <input type="file" id="img3" class="form-control my-3"
                                            accept=".png,.jpeg,.jpg,.gif" name="img_sub_3">
                                        <small id="img_error3" class="text-danger"></small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-3">
                            <div class="row d-flex justify-content-between">
                                <input class="d-none" name="id_create" value="<?php echo $id; ?>"></input>
                                <div>
                                    <!-- Diện tích -->
                                    <input type="text" class="form-control" name="square_meter_create"
                                        id="square_meter_create" placeholder="Diện tích">
                                    <small id="sm_error" class="text-danger"></small>
                                    <!-- Số khách -->
                                    <input type="text" class="form-control mt-3" name="quantity_create"
                                        id="quantity_create" placeholder="Số khách">
                                    <small id="quantity_error" class="text-danger"></small>
                                </div>
                            </div>
                            <div class="row">
                                <div>
                                    <!-- Tiện ích -->
                                    <input type="text" class="form-control mt-3" id="service_create" name="service_create" placeholder="Tiện ích">
                                    <small id="sv_error" class="text-danger"></small>

                                    <!-- Yêu cầu -->
                                    <input type="text" class="form-control mt-3" id="requirement_create" name="requirement_create" placeholder="Yêu cầu">
                                    <small id="req_error" class="text-danger"></small>

                                    <!-- Mô tả -->
                                    <textarea class="form-control mt-3" id="description_create" name="description_create" placeholder="Mô tả"></textarea>                                    
                                    <small id="des_error" class="text-danger"></small>
                                    <br>                                    
                                    <div class="text-end"> 
                                        
                                    </div>
                                    <!-- <div class="d-flex justify-content-end align-items-center">
                                        <small id="create_error" class="text-danger me-2"></small>  
                                        <button type="submit" class="btn btn-primary">Thêm</button>
                                    </div>    -->
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <small id="create_error" class="text-danger mt-4 me-md-2"></small>
                                        <button class="mt-3 btn btn-primary me-md-2" type="submit"  name="submit" id="submitBtn">
                                            Thêm
                                        </button>
                                    </div>                                                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>

</div>
<!-- /.container-fluid -->

<script src="ajax/room/create_detail.js"></script>

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
</style>