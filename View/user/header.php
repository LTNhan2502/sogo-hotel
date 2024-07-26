<header class="site-header js-site-header">
  <div class="container-fluid">
    <div class="row align-items-center row-content-header mx-auto">
      <div class="col-6 col-lg-4 site-logo">
        <a class="text-black" href="index.php">Sogo Hotel</a>
      </div>
      <div class="col-6 col-lg-8 d-flex justify-content-end align-items-center">
        <div class="button-group">
          <?php
            if(isset($_SESSION['customer_id'])){
          ?>
              <a href="index.php?action=user_info" class="btn-user-info mr-2">
                <i class="fas fa-user"></i> <?php echo $_SESSION['customer_name']; ?>
              </a>
              <!-- <a href="index.php?action=logout" class="btn btn-outline-primary me-2 mr-1">
                Đăng xuất
              </a> -->
          <?php  }else{ ?>
            <a href="index.php?action=login" class="btn btn-outline-primary me-2 mr-1">Đăng nhập</a>
            <a href="index.php?action=signup" class="btn btn-primary">Đăng kí</a>
          <?php } ?>
        </div>
        <div class="site-menu-toggle js-site-menu-toggle bg-black ms-3" data-aos="fade">
          <span></span>
          <span></span>
          <span></span>
        </div>
        <!-- END menu-toggle -->
      </div>
    </div>
    <div class="site-navbar js-site-navbar">
      <nav role="navigation">
        <div class="container">
          <div class="row full-height align-items-center">
            <div class="col-md-6 mx-auto">
              <ul class="list-unstyled menu">
                <li class="active"><a href="index.php">Trang chủ</a></li>
                <li><a href="index.php?action=home&act=all_room">Tất cả phòng</a></li>
                <li><a href="index.php?action=booking">Đặt phòng</a></li>
                <li><a href="index.php?action=user_info">Tài khoản</a></li>
                <li><a href="index.php?action=contact">Liên hệ</a></li>
                <li><a href="admin_index.php">Đi tới trang quản trị</a></li>
              </ul>
            </div>
          </div>
        </div>
      </nav>
    </div>

  </div>
</header>
<!-- END head -->

<style>
  header {
    background-color: #fff !important;
    box-shadow: 0 0 6px 0 rgba(255, 0, 0, 0.155);
    max-height: 100px;
    z-index: 1000 !important;
  }

  .site-header{
    padding: 0 !important;
  }

  .row-content-header{
    min-height: 100px !important;
    /* padding-top: 20px; */
  }

  .container-fluid{
    margin-bottom: 50%;
  }

  .text-black {
    color: #000000 !important;
  }

  .bg-black span {
    background-color: #000000 !important;
  }

  .button-group {
    display: flex;
    align-items: center;
  }

  .site-menu-toggle {
    margin-left: 1rem;
    height: 20px !important;
  }

  @media (max-width: 767.98px) {
    .col-6.col-lg-8 {
      justify-content: flex-end;
    }
  }

  .btn-user-info{
    color: black;
    padding: 3px 15px;
  }

  .btn-user-info:hover{
    background-color: rgb(255, 170, 52);
    padding: 3px 15px;
    border-radius: 30px;
    color: white;
  }
</style>