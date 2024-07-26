<div class="container-fluid">
    <?php
        $rec = new receptionist();
        $fmt = new formatter();
        $r_count = $rec->getAllRecDeleted()->rowCount(); //Tổng đối tượng
        $limit = 6; //Giới hạn số đối tượng trong 1 trang
        $page = new page();
        $trang = $page->findPage($r_count, $limit); //Lấy được số trang cần có
        $start = $page->findStart($limit); //Lấy được sản phẩm bắt đầu trong 1 trang
        $current_page = isset($_GET['page']) ? $_GET['page'] : 1; //Lấy được trang hiện tại
    ?>
    <div class="d-none" id="limit" data-limit="<?php echo $limit; ?>"></div>
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between">
            <span class="m-0 font-weight-bold text-primary">Table Receptionist - Khôi phục</span>
        </div>
        
        <div class="card-body">
            <div class="table-responsive">
                <?php
                    if($r_count != 0){
                ?>
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Mã nhân viên</th>
                            <th>Tên</th>
                            <th>Chức vụ</th>
                            <th>Ca làm việc</th>
                            <th class="text-end">Hành động</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>STT</th>
                            <th>Mã nhân viên</th>
                            <th>Tên</th>
                            <th>Chức vụ</th>
                            <th>Ca làm việc</th>
                            <th class="text-end">Hành động</th>
                        </tr>
                    </tfoot>
                    <tbody id="rec_list">
                        <?php
                            $r = $rec->getAllRecDeleted();
                            $count = 1;
                            while($set = $r->fetch()):
                        ?>
                        <tr>
                            <!-- STT -->
                            <td><div id="rec_id" data-id="<?php echo $set['rec_id']; ?>"><?php echo $count; ?></div></td>
                            <!-- Mã nhân viên -->
                            <td><h3><span class="badge badge-primary fs-6" id="rec_code" data-rec_code="<?php echo $set['rec_code']; ?>"><?php echo $set['rec_code']; ?></span></h3></td>
                            <!-- Tên nhân viên -->
                            <td>
                                <input type="text" class="form-control" name="rec_name" id="rec_name" 
                                        value="<?php echo $set['rec_name']; ?>"
                                        data-rec_id="<?php echo $set['rec_id']; ?>"
                                        data-rec_value="<?php echo $set['rec_name']; ?>">
                            </td>
                            <!-- Chức vụ -->
                            <td>
                                <select name="part" class="form-control" id="part">
                                    <?php 
                                        $part = $rec->getAllPart();
                                        while($set_part = $part->fetch()):
                                    ?>
                                    <option value="<?php echo $set_part['part_id']; ?>" 
                                            <?php echo $set['rec_part'] == $set_part['part_id'] ? 'selected' : ''; ?>
                                            data-rec_id="<?php echo $set['rec_id']; ?>"
                                            data-part_act="<?php echo $set_part['part_id']; ?>"
                                        ><?php echo $set_part['part_name'] ?>
                                    </option>
                                    <?php endwhile; ?>
                                </select>
                            </td>
                            <!-- Ca làm việc -->
                            <td>
                                <select name="shift" class="form-control" id="shift">
                                    <?php 
                                        $shift = $rec->getAllShift();
                                        while($set_shift = $shift->fetch()):
                                    ?>
                                    <option value="<?php echo $set_shift['shift_id']; ?>" 
                                            <?php echo $set['rec_shift'] == $set_shift['shift_id'] ? 'selected' : ''; ?>
                                            data-rec_id="<?php echo $set['rec_id']; ?>"
                                            data-shift_act="<?php echo $set_shift['shift_name']; ?>"
                                        ><?php echo $set_shift['shift_name'] ?>
                                    </option>
                                    <?php endwhile; ?>
                                </select>
                            </td>
                    
                            <td class="text-end">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal<?php echo $set['rec_id']; ?>">
                                    <i class="far fa-eye"></i>
                                </button>
                                <button type="button" class="btn btn-secondary mr-1" id="restore_btn"><i class="fas fa-redo"></i></button>
                                <button type="button" class="btn btn-danger" id="delete_btn"><i class="fas fa-trash"></i></button>

                            </td>
                        </tr>
                        
                        <!-- Modal xem chi tiết-->
                        <div class="modal fade" id="exampleModal<?php echo $set['rec_id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl">*
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Xem thông tin cá nhân <span class="detail_rec_name"><?php echo $set['rec_name']; ?></span></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        <div class="d-none rec_id_raw" data-rec_id_raw="<?php echo $set['rec_id']; ?>"></div>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <!-- Số điện thoại -->
                                            <div class="col">
                                                <label for="#rec_tel">Số điện thoại</label>
                                                <div class="input-group flex-nowrap">
                                                    <span class="input-group-text" id="addon-wrapping"><i class="fas fa-phone-alt"></i></span>
                                                    <input type="text" class="form-control" name="rec_tel" id="rec_tel" 
                                                        value="<?php echo $set['rec_tel']; ?>"
                                                        data-rec_id="<?php echo $set['rec_id']; ?>"
                                                        data-rec_value="<?php echo $set['rec_tel']; ?>">
                                                </div>                                                
                                            </div>

                                            <!-- Email -->
                                            <div class="col">
                                                <label for="#rec_email">Email</label>
                                                <div class="input-group flex-nowrap">
                                                    <span class="input-group-text" id="addon-wrapping"><i class="fas fa-envelope"></i></span>
                                                    <input type="text" class="form-control" name="rec_email" id="rec_email" 
                                                        value="<?php echo $set['rec_email']; ?>"
                                                        data-rec_id="<?php echo $set['rec_id']; ?>"
                                                        data-rec_value="<?php echo $set['rec_email']; ?>">
                                                </div>                                                
                                            </div>

                                            <!-- Ngày sinh -->
                                            <div class="col">
                                                <label for="#rec_birthday">Ngày sinh</label>
                                                <div class="input-group flex-nowrap">
                                                    <span class="input-group-text" id="addon-wrapping"><i class="far fa-calendar-alt"></i></span>
                                                    <input type="datetime" id="birthday<?php echo $set['rec_id'] ?>" class="form-control birthday" aria-describedby="addon-wrapping"
                                                        value="<?php echo $set['rec_birthday']; ?>"
                                                        data-rec_id="<?php echo $set['rec_id']; ?>"
                                                        data-rec_value="<?php echo $set['rec_birthday']; ?>">
                                                </div>                                                
                                            </div>
                                        </div>
                                        <div class="row mm mt-4">
                                            <input type="hidden" value="<?php echo $set['rec_id']?>" id="rec_timeWork_id">
                                            <!-- Ngày bắt đầu làm việc -->
                                            <div class="col">
                                                <label for="#rec_startWork">Ngày bắt đầu làm việc</label>
                                                <div class="input-group flex-nowrap">
                                                    <span class="input-group-text" id="addon-wrapping"><i class="fas fa-clock"></i></span>
                                                    <input type="datetime" id="rec_startWork<?php echo $set['rec_id']; ?>" class="form-control rec_startWork" 
                                                        value="<?php echo $set['rec_startWork']; ?>"
                                                        data-rec_id="<?php echo $set['rec_id']; ?>"
                                                        data-rec_value="<?php echo $set['rec_startWork']; ?>">
                                                </div>                                                
                                            </div>

                                            <!-- Số ngày làm việc -->
                                            <div class="col">
                                                <label for="#rec_timeWork">Thời gian làm việc (ngày)</label>
                                                <div class="input-group flex-nowrap">
                                                    <span class="input-group-text" id="addon-wrapping"><i class="fas fa-user-clock"></i></span>
                                                    <input type="text" class="form-control rec_timeWork" name="rec_timeWork" id="rec_timeWork<?php echo $set['rec_id']; ?>" disabled
                                                        value="<?php echo $set['rec_timeWork']; ?>"
                                                        data-rec_id="<?php echo $set['rec_id']; ?>"
                                                        data-rec_value="<?php echo $set['rec_timeWork']; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <!-- Thưởng -->
                                            <div class="col">
                                                <label for="#rec_bonus">Thưởng</label>
                                                <div class="input-group flex-nowrap">
                                                    <span class="input-group-text" id="addon-wrapping"><i class="fas fa-money-check-alt"></i></span>
                                                    <input type="text" class="form-control" name="rec_bonus" id="rec_bonus" 
                                                        value="<?php echo $fmt->formatCurrency($set['rec_bonus']); ?>"
                                                        data-rec_id="<?php echo $set['rec_id']; ?>"
                                                        data-rec_value="<?php echo $set['rec_bonus']; ?>">
                                                </div>                                                
                                            </div>

                                            <!-- Phạt -->
                                            <div class="col">
                                                <label for="#rec_fine">Phạt</label>
                                                <div class="input-group flex-nowrap">
                                                    <span class="input-group-text" id="addon-wrapping"><i class="fas fa-money-check-alt"></i></span>
                                                    <input type="text" class="form-control" name="rec_fine" id="rec_fine" 
                                                        value="<?php echo $fmt->formatCurrency($set['rec_fine']); ?>"
                                                        data-rec_id="<?php echo $set['rec_id']; ?>"
                                                        data-rec_value="<?php echo $set['rec_fine']; ?>">
                                                </div>                                                
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <!-- Lương -->
                                            <div class="col">
                                                <label for="#rec_salary">Lương</label>
                                                <div class="input-group flex-nowrap">
                                                    <span class="input-group-text" id="addon-wrapping"><i class="fas fa-money-bill-alt"></i></span>
                                                    <input type="text" class="form-control" name="rec_salary" id="rec_salary" 
                                                        value="<?php echo $fmt->formatCurrency($set['rec_salary']); ?>"
                                                        data-rec_id="<?php echo $set['rec_id']; ?>"
                                                        data-rec_value="<?php echo $set['rec_salary']; ?>">
                                                </div>                                                
                                            </div>

                                            <!-- Thời điểm nhận lương -->
                                            <div class="col">
                                                <label for="#rec_timeSalary">Thời điểm nhận lương</label>
                                                <?php
                                                    if($set['rec_timeSalary'] == null){                                                    
                                                ?>
                                                    <div class="badge badge-secondary fs-7 mr-1" id="badge">Chưa nhận</div>
                                                    <button class="btn btn-primary btn-sm" id="claimSalary">Nhận lương</button>
                                                    <button class="btn btn-danger btn-sm d-none" id="unClaimSalary">Huỷ nhận</button>
                                                <?php
                                                    }else{
                                                ?>
                                                    <div class="badge badge-secondary fs-7 mr-1" id="badge">Đã nhận</div>
                                                    <button class="btn btn-primary btn-sm d-none" id="claimSalary">Nhận lương</button>
                                                    <button class="btn btn-danger btn-sm" id="unClaimSalary">Huỷ nhận</button>
                                                <?php } ?>
                                                <div class="input-group flex-nowrap">
                                                    <span class="input-group-text" id="addon-wrapping"><i class="fas fa-business-time"></i></span>
                                                    <input type="text" class="form-control" name="rec_timeSalary" id="rec_timeSalary" disabled
                                                        value="<?php echo $set['rec_timeSalary']; ?>"
                                                        data-rec_id="<?php echo $set['rec_id']; ?>"
                                                        data-rec_value="<?php echo $set['rec_timeSalary']; ?>">
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>    
                        <!-- End modal -->
                        <?php 
                            $count++;
                            endwhile;
                        ?>
                    </tbody>
                </table>
                <?php
                    }else{
                        echo "<h4 class='text-decoration-underline'>Chưa có thông tin!</h4>";
                    }
                ?>
            </div>
        </div>
    </div>
</div>


<!-- /.container-fluid -->
<style>
    .btn-sm{
        border-radius: 10px !important;
        font-weight: bold;
    }
</style>

<script src="ajax/receptionist/restore.js"></script>
