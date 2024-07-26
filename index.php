<?php
  session_start();
  include_once "auth/auth.php";
  include_once "router/router.php";
  // unset($_SESSION['customer_name']); 
  // unset($_SESSION['customer_id']);
  spl_autoload_register("myModelClass");
  function myModelClass($classname){
      $path = "Model/";
      include $path.$classname.'.php';
  }

  // Kiểm tra xem người dùng đã đăng nhập hay chưa
  if (isAuthenUser()) {
    if (!isset($_GET['action']) || $_GET['action'] === 'login') {
      redirectToUserHome();
    }
  }
?>

<!DOCTYPE HTML>
<html>
  <head>
    <!-- SweetAlert2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.2/sweetalert2.all.min.js"></script>
    
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sogo Hotel by Colorlib.com</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="author" content="" />

    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=|Roboto+Sans:400,700|Playfair+Display:400,700">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <link rel="stylesheet" href="Content/user/css/bootstrap.min.css">
    <link rel="stylesheet" href="Content/user/css/animate.css">
    <link rel="stylesheet" href="Content/user/css/owl.carousel.min.css">
    <link rel="stylesheet" href="Content/user/css/aos.css">
    <link rel="stylesheet" href="Content/user/css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="Content/user/css/jquery.timepicker.css">
    <link rel="stylesheet" href="Content/user/css/fancybox.min.css">
    
    <link rel="stylesheet" href="fonts/ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="Content/user/fonts/font-awesome/css/all.min.css">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> -->


    <!-- Theme Style -->
    <link rel="stylesheet" href="Content/user/css/style.css">

    <!-- Datetimepicker css -->
    <link rel="stylesheet" href="Content/admin/datetimepicker-master/build/jquery.datetimepicker.min.css">   
  </head>
  <body>
    
    <!-- Header -->
    <?php
        include_once "View/user/header.php";
    ?>

    <!-- Tạo trang home -->
    <div class="mt-4">
    <?php
        $ctrl = 'home';
        if(isset($_GET['action'])){
            $ctrl = $_GET['action'];
        }
        include_once "Controller/user/$ctrl.php";
    ?>
    </div>
    
    <!-- Tạo footer -->
    <?php
        include_once "View/user/footer.php";
    ?>

    <script src="Content/user/js/jquery-3.3.1.min.js"></script>
    <script src="Content/user/js/jquery-migrate-3.0.1.min.js"></script>
    <script src="Content/user/js/popper.min.js"></script>
    <script src="Content/user/js/bootstrap.min.js"></script>
    <script src="Content/user/js/owl.carousel.min.js"></script>
    <script src="Content/user/js/jquery.stellar.min.js"></script>
    <script src="Content/user/js/jquery.fancybox.min.js"></script>
    <script src="Content/user/js/jquery-3.3.1.min.js"></script>

    
    <script src="Content/user/js/aos.js"></script>
    
    
    <script src="Content/user/js/main.js"></script>

    <!-- Datetimepicker JS -->
    <script src="Content/admin/datetimepicker-master/build/jquery.datetimepicker.full.min.js"></script>
  </body>
</html>