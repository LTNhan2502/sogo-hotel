<?php
    session_start();
    // session_destroy();
    include_once "auth/auth.php";
    include_once "auth/authorize.php";
    include_once "router/router.php";    
    // unset($_SESSION['admin']);    
    spl_autoload_register("myModelClass");
    function myModelClass($classname){
        $path = "Model/";
        include $path.$classname.'.php';
    }

    // Kiểm tra xem người dùng đã đăng nhập hay chưa
    if (!isAuthenticated()) {
        // Người dùng chưa xác thực
        if (!isset($_GET['action']) || $_GET['action'] !== 'admin_login') {
            // Chuyển hướng đến trang đăng nhập nếu không phải là trang đăng nhập
            redirectToLogin();
        }
    } else {
        // Người dùng đã xác thực
        if (!isset($_GET['action']) || $_GET['action'] === 'admin_login') {
            // Chuyển hướng đến trang chủ quản trị nếu đã đăng nhập và truy cập trang đăng nhập
            redirectToAdminHome();
            return;
        }
    }
    //https://www.traveloka.com/vi-vn/hotel/vietnam/the-malibu-hotel-1000000592992?spec=12-06-2024.13-06-2024..1.HOTEL.1000000592992..1&currency=VND&contexts=%7B%22sourceHotelDetail%22%3A%22VNMCHHYGIENE2%20Desktop%22%2C%22accessCode%22%3A%22%22%7D
    
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- SweetAlert2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.2/sweetalert2.all.min.js"></script>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin Sogo Hotel - Dashboard</title>    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Custom fonts for this template-->
    <link href="Content/admin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <script src="Content/admin/vendor/jquery/jquery.min.js"></script>

    <!-- Custom styles for this template-->
    <link href="Content/admin/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Datetimepicker css -->
    <link rel="stylesheet" href="Content/admin/datetimepicker-master/build/jquery.datetimepicker.min.css">   
    <!-- Current time function -->
    <script src="ajax/current_time/datetime.js"></script>
</head>

<body id="page-top">
    <!-- Authorize -->
        <?php
            //Kiểm tra quyền thành viên
            if(isset($_SESSION['current_user'])){
                $result_auth = checkAuthority();
                if(!$result_auth){
                    echo 'Không có quyền truy cập';
                    // print_r($_SESSION['current_user']);
                    exit;
                }
            }
        ?>
    <!-- End authorize -->

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php
            if(isAuthenticated()){
                include_once "View/admin/admin_sidebar.php";
            }
        ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php
                    if(isAuthenticated()){
                        include_once "View/admin/admin_topbar.php";
                    }
                ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <?php
                    //Load controller
                    $action = isset($_GET['action']) ? $_GET['action'] : 'admin_login';
                    route($action);
                ?>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php
                if(isAuthenticated()){
                    include_once "View/admin/admin_footer.php";
                }
            ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="admin_index.php?action=admin_login&act=logout">Logout</a>
                </div>
            </div>
        </div>
    </div>

    
    <!-- Bootstrap core JavaScript-->
    <script src="Content/admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="Content/admin/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="Content/admin/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="Content/admin/vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="Content/admin/js/demo/chart-area-demo.js"></script>
    <script src="Content/admin/js/demo/chart-pie-demo.js"></script>

    <!-- Datetimepicker JS -->
    <script src="Content/admin/datetimepicker-master/build/jquery.datetimepicker.full.min.js"></script>
    
</body>


</html>