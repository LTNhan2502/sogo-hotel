<link rel="stylesheet" href="Content/admin/css/authorize.css">

<div class="containerr">
    <form class="permission-form">
        <div class="header">
            <h1>Phân Quyền Thành viên</h1>
            <select name="user_id" id="user_id" class="form-control"
                style="max-width: 300px; margin-right: auto; margin-left: 10px;">
                <?php
                $admin = new admin();
                $getAllAdmin = $admin->getAllAdmin();
                while ($set_admin = $getAllAdmin->fetch()):
                    ?>
                    <option value="<?php echo $set_admin['id'] ?>"><?php echo $set_admin['name']; ?></option>
                <?php endwhile; ?>
            </select>
            <?php
                if(isset($_SESSION["tenadmin"]) && $_SESSION["tenadmin"] == 'admin'):
            ?>
                <h1>Mức Độ Ưu Tiên</h1>
                <select name="priority" id="priority" class="form-control"
                style="max-width: 300px; margin-right: auto; margin-left: 10px;">
                    <option value="1">Admin</option>
                    <option value="2">Quản lí</option>
                    <option value="3">Nhân viên</option>
                </select>
            <?php endif; ?>
            <button type="submit" class="save-button" id="changeAuth"><i class="fas fa-save"></i> Lưu</button>
        </div>
        <div class="section" style="margin-top: -15px;">
            <?php
            $user_id = 1;
            $auth_group = $admin->getAuthGroup()->fetchAll();
            $auth = $admin->getAuth()->fetchAll();
            $getAccoutAuth = $admin->getAccountAuth($user_id)->fetchAll(PDO::FETCH_ASSOC);
            $authList = array();
            if(!empty($getAccoutAuth)){
                foreach($getAccoutAuth as $accountAuth)
                $authList[] = $accountAuth['user_auth_auth_id'];
            }
            foreach ($auth_group as $set):
                ?>
                <div class="permission">
                    <h3><?php echo $set['auth_gr_name']; ?></h3>
                    <div class="checkbox-group">
                        <?php
                        foreach ($auth as $set_auth):
                            if ($set['auth_gr_id'] == $set_auth['auth_gr_id']) {
                                ?>
                                <div class="checkbox-item">
                                    <input type="checkbox" value="<?php echo $set_auth['auth_id']; ?>"
                                        id="<?php echo $set_auth['auth_id']; ?>" name="authorities[]"
                                        <?php echo in_array($set_auth['auth_id'], $authList) ? 'checked' : '' ?>
                                        disabled
                                        <?php //echo $getAccoutAuth['priority'] == 0 ? 'disabled' : '' ?>>
                                    <label for="<?php echo $set_auth['auth_id']; ?>"><?php echo $set_auth['auth_name']; ?></label>
                                </div>
                            <?php }endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </form>

</div>

<script src="ajax/account/admin.js"></script>