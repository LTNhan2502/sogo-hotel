<?php
    $act = 'admin_login';
    if(isset($_GET['act'])){
        $act = $_GET['act'];
    }

    if($act == 'admin_login'){
?>
    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                    </div>
                                    <form class="user" id="loginAdmin">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user"
                                                placeholder="Username" name="username_admin">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                placeholder="Password" name="pass_admin">
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">Đăng nhập</button>
                                    </form>                                   
                                    <!-- Form đăng nhập -->
                                    <!-- <form class="user" id="adminLoginForm ">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Username" name="username">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                id="exampleInputPassword" placeholder="Password" name="pass">
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Đăng nhập
                                        </button>
                                        <hr>
                                        <a href="index.html" class="btn btn-google btn-user btn-block">
                                            <i class="fab fa-google fa-fw"></i> Login with Google
                                        </a>
                                        <a href="index.html" class="btn btn-facebook btn-user btn-block">
                                            <i class="fab fa-facebook-f fa-fw"></i> Login with Facebook
                                        </a>
                                    </form> -->
                                    <!-- End form đăng nhập -->
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="admin_index.php?action=admin_login&act=admin_change_password">Thay đổi mật khẩu!</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="admin_index.php?action=admin_login&act=create_anew">Tạo tài khoản mới!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
<?php
    }else if($act == 'admin_change_password'){
?>
<div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Thay đổi mật khẩu</h1>
                                    </div>
                                    <!-- Form đổi pass -->
                                    <form class="user" id="changePassForm">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user"
                                                id="username_admin" name="username" aria-describedby="emailHelp"
                                                placeholder="Username">
                                            <small class="text-danger" id="username_error"></small>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                id="old_pass" aria-describedby="emailHelp"
                                                placeholder="Mật khẩu cũ">
                                            <small class="text-danger" id="old_pass_error"></small>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                id="new_pass" placeholder="Mật khẩu mới" name="new_pass">
                                            <small class="text-danger" id="new_pass_error"></small>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                id="new_pass_conf" placeholder="Mật khẩu mới" name="new_pass">
                                            <small class="text-danger" id="new_pass_conf_error"></small>
                                        </div>

                                        
                                        <button type="submit" name="submit" class="btn btn-primary btn-user btn-block">
                                            Thay đổi
                                        </button>
                                        <small class="text-danger text-center" id="all_error_admin_change_pass" style="display: block; text-align: center;"></small>
                                    </form>
                                    <!-- End form đổi pass -->
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="admin_index.php?action=admin_login">Đi tới Đăng nhập!</a>
                                    </div>                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
<?php }else{ ?>
    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Tạo tài khoản mới</h1>
                                    </div>
                                    <!-- Form tạo mới -->
                                    <form class="user" id="createNewForm">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user"
                                                id="fullname_create" name="fullname_create" aria-describedby="emailHelp"
                                                placeholder="Họ và tên">
                                            <small class="text-danger" id="fullname_create_error"></small>
                                        </div>   
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user"
                                                id="username_create" name="username_create" aria-describedby="emailHelp"
                                                placeholder="Username">
                                            <small class="text-danger" id="username_create_error"></small>
                                        </div>                                        
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                id="new_pass_create" placeholder="Mật khẩu" name="new_pass_create">
                                            <small class="text-danger" id="new_pass_create_error"></small>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                id="new_pass_create_conf" placeholder="Nhập lại mật khẩu" name="new_pass_create_conf">
                                            <small class="text-danger" id="new_pass_create_conf_error"></small>
                                        </div>

                                        
                                        <button type="submit" name="submit" class="btn btn-primary btn-user btn-block">
                                            Thay đổi
                                        </button>
                                        <small class="text-danger text-center" id="all_error_admin_create" style="display: block; text-align: center;"></small>
                                    </form>
                                    <!-- End form tạo mới -->
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="admin_index.php?action=admin_login">Đi tới Đăng nhập!</a>
                                    </div>                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
<?php } ?>

<script src="ajax/account/admin.js"></script>