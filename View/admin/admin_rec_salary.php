<div class="container-fluid">
    <?php
        $rec = new receptionist();
        $fmt = new formatter();
        $count = $rec->getAllRec()->rowCount(); //Tổng đối tượng
        $limit = 6; //Giới hạn số đối tượng trong 1 trang
        $page = new page();
        $trang = $page->findPage($count, $limit); //Lấy được số trang cần có
        $start = $page->findStart($limit); //Lấy được sản phẩm bắt đầu trong 1 trang
        $current_page = isset($_GET['page']) ? $_GET['page'] : 1; //Lấy được trang hiện tại
    ?>
    <div class="card shadow mb-4 mt-4">
        <div class="d-none" id="limit" data-limit="<?php echo $limit; ?>"></div>
        <div class="card-header py-3 d-flex justify-content-between">
            <span class="m-0 font-weight-bold text-primary">Table Receptionist - Danh sách lương</span>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Mã nhân viên</th>
                            <th>Tên</th>
                            <th>Lương (đ)</th>
                            <th>Thưởng (đ)</th>
                            <th>Phạt (đ)</th>
                            <th>Hệ số</th>
                            <th>Thực nhận</th>
                            <th class="text-end">Hành động</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Mã nhân viên</th>
                            <th>Tên</th>
                            <th>Lương (đ)</th>
                            <th>Thưởng (đ)</th>
                            <th>Phạt (đ)</th>
                            <th>Hệ số</th>
                            <th>Thực nhận</th>
                            <th class="text-end">Hành động</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                            $r = $rec->getAllRecPage($start, $limit);
                            $count = 1;
                            while($set = $r->fetch()):
                        ?>
                        <tr id="currency">
                            <!-- STT -->
                            <td><div id="rec_id" data-id="<?php echo $set['rec_id']; ?>"><?php echo $count; ?></div></td>
                            <!-- Mã nhân viên -->
                            <td><h3><span class="badge badge-primary fs-6" id="rec_code"><?php echo $set['rec_code']; ?></span></h3></td>
                            <!-- Tên nhân viên -->
                            <td style="min-width: 160px;">
                                <input type="text" class="form-control" name="rec_name" id="rec_name" 
                                        value="<?php echo $set['rec_name']; ?>"
                                        data-rec_id="<?php echo $set['rec_id']; ?>"
                                        data-rec_value="<?php echo $set['rec_name']; ?>">
                            </td>

                            <!-- Lương -->
                            <td>
                                <input type="text" class="form-control" name="rec_salary" id="rec_salary" 
                                    value="<?php echo $fmt->formatCurrency($set['rec_salary']); ?>"
                                    data-rec_id="<?php echo $set['rec_id']; ?>"
                                    data-rec_value="<?php echo $fmt->formatCurrency($set['rec_salary']); ?>">
                            </td>

                            <!-- Thưởng -->
                            <td>
                                <input type="text" class="form-control" name="rec_bonus" id="rec_bonus" 
                                    value="<?php echo $fmt->formatCurrency($set['rec_bonus']); ?>"
                                    data-rec_id="<?php echo $set['rec_id']; ?>"
                                    data-rec_value="<?php echo $fmt->formatCurrency($set['rec_bonus']); ?>">
                            </td>

                            <!-- Phạt -->
                            <td>
                                <input type="text" class="form-control" name="rec_fine" id="rec_fine" 
                                    value="<?php echo $fmt->formatCurrency($set['rec_fine']); ?>"
                                    data-rec_id="<?php echo $set['rec_id']; ?>"
                                    data-rec_value="<?php echo $fmt->formatCurrency($set['rec_fine']); ?>">
                            </td>

                            <!-- Hệ số -->
                            <td width="80px">
                                <input type="text" class="form-control" name="rec_factor" id="rec_factor" 
                                    value="<?php echo $set['rec_factor']; ?>"
                                    data-rec_id="<?php echo $set['rec_id']; ?>"
                                    data-rec_value="<?php echo $set['rec_factor']; ?>">
                            </td>

                            <!-- Thực nhận -->
                            <td>
                                <input type="text" class="form-control" name="rec_receive" id="rec_receive" disabled
                                    value="<?php echo $fmt->formatCurrency((($set['rec_salary']*$set['rec_factor'])+$set['rec_bonus'])-$set['rec_fine']); ?>"
                                    data-rec_id="<?php echo $set['rec_id']; ?>"
                                    data-rec_value="<?php echo $fmt->formatCurrency((($set['rec_salary']*$set['rec_factor'])+$set['rec_bonus'])-$set['rec_fine']); ?>">
                            </td>
                    
                            <td class="text-end" width="120px">   
                                <?php 
                                    if(!$set['rec_timeSalary']){                                                            
                                        echo '<button type="button" class="btn btn-primary btn-sm" id="claimSalary_"><i class="fas fa-dollar-sign"></i> Nhận</button>';                                
                                    }else{
                                        echo '<button type="button" class="btn btn-danger btn-sm" id="unClaimSalary_"><i class="fas fa-ban"></i> Huỷ nhận</button>';
                                    }
                                ?>
                            </td>

                        </tr>                        
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
                <div class="row mt-4">
                    <nav aria-label="Page navigation example mt-3">
                        <?php
                            $link = "admin_index.php?action=admin_rec_salary&act=pages&page=[i]";
                            echo page::pagination($trang, $current_page, $link);
                        ?>
                    </nav>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<script src="ajax/receptionist/status.js"></script>
<script src="ajax/receptionist/salary_page.js"></script>
<script>
    $(document).ready(function(){        
        $(document).on('click',"#delete_room_id", function(){
            let delete_room_id = $(this).closest('tr').find('#id').data("id");
            Swal.fire({
                title: "Xoá phòng này?",
                text: "Sau khi xoá phòng có thể vào Khôi phục để xem!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Có",
                cancelButtonText: "Không"
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "Controller/admin/admin_room_list.php?act=delete_room",
                        method: "POST",
                        data: {delete_room_id},
                        dataType: "JSON",
                        success: function(res){
                            if(res.status == 'success'){                                
                                window.location.reload();                                
                            }else{
                                Swal.fire({                                    
                                    title: "Xoá phòng thất bại!",
                                    text: res.message,
                                    icon: "error",
                                    timer: 3200,
                                    timerProgressBar: true
                                });                           
                            }
                        },
                        error: function(){
                            Swal.fire({                                
                                title: "Lỗi!",
                                text: "Có lỗi xảy ra!",
                                icon: "error",
                                timer: 3200,
                                timerProgressBar: true
                            });
                        }
                    })
                }
            });
        })
    })
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


</script>
<style>
    .image-container {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .image-row {
        display: flex;
        justify-content: space-around;
        width: 100%; /* Match width of the parent container */
    }

    .image-big{
        border-radius: 10px;
        max-height: 650px;
    }

    .image-small {
        width: 150px; /* Adjust width of each small image */
        height: 125px;
        border-radius: 10px;
        opacity: 0.4;
    }

    .shadow-inset-md{
        border-radius: 9px;
        background-color: #f2f2f2;
        box-shadow: inset 1px 2px 4px rgba(255, 0, 0, 0.155) !important;
    }

    .selected{
        border: 2px solid #0d6efd;
        opacity: 1.2;
    }

    .btn-sm{
        width: 100px !important;
    }
</style>