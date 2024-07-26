<link rel="stylesheet" href="Content/user/css/user-search.css">

<section class="site-hero overlay" style="background-image: url(Content/images/hero_4.jpg)"
  data-stellar-background-ratio="0.5">
  <div class="container" id="container">
    <div class="row site-hero-inner justify-content-center align-items-center">
      <div class="col-md-10 text-center" data-aos="fade-up">
        <span class="custom-caption text-white d-block  mb-3">Chào mừng bạn đến với</span>
        <h1 class="heading">SogoHotel</h1>
      </div>
    </div>
  </div>

  <a class="mouse smoothscroll" href="#next">
    <div class="mouse-icon">
      <span class="mouse-wheel"></span>
    </div>
  </a>
</section>
<!-- END section Carousel -->

<section class="section bg-light pb-0">
  <div class="overlayy" id="overlayy"></div>
  <div class="container" id="container">
    <div class="row check-availabilty" id="next">
      <div class="block-32" data-aos="fade-up" data-aos-offset="-200">        
          <div class="row">
            <div class="col-md-12 mb-6 mb-lg-0 col-lg-9">
              <label for="checkin_date" class="font-weight-bold text-black">Tên phòng</label>
              <div class="field-icon-wrap">
                <div class="icon"><span class="icon-calendar"></span></div>
                <input type="text" class="input-box" placeholder="" id="searchInput" readonly>
                <div class="dropdown" id="dropdownMenu">
                  <?php                  
                  $room = new room();
                  $rooms = $room->getEmptyRoom();
                  while ($sets = $rooms->fetch()):
                    ?>
                    <div class="item" data-selected_room_id="<?php echo $sets['id']; ?>"><?php echo $sets['name']; ?></div>
                  <?php endwhile; ?>
                </div>
              </div>
            </div>            
            <div class="col-md-6 col-lg-3 align-self-end">
              <button class="btn btn-primary btn-block text-white" id="redirectToBooking">Chọn phòng nhanh</button>
            </div>
          </div>
        
      </div>


    </div>
  </div>
</section>
<!-- End Section Search -->

<section class="section">
  <div class="container" id="container">

    <div class="row justify-content-center text-center mb-5">
      <div class="col-md-7">
        <h2 class="heading" data-aos="fade-up">Loại phòng</h2>
        <p data-aos="fade-up" data-aos-delay="100">Tại đây, bạn có thể chọn loại phòng muốn đặt.</p>
        <p class="mt" data-aos="fade-up" data-aos-delay="100">Single Room sẽ có từ 1-2 người. </p>
        <p class="mt" data-aos="fade-up" data-aos-delay="100">Family Room sẽ có từ 2 người trở lên. </p>
        <p class="mt" data-aos="fade-up" data-aos-delay="100">Presidential Room là phòng đặc biệt, không gian rộng rãi,
          dịch vụ đa dạng và sang trọng cùng nhiều tiện ích độc đáo. </p>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6 col-lg-4" data-aos="fade-up">
        <a href="index.php?action=kind&act=single" class="room">
          <figure class="img-wrap">
            <img src="Content/images/standard_double.jpg" alt="Single Room" class="img-fluid mb-3">
          </figure>
          <div class="p-3 text-center room-info">
            <h2>Single Room</h2>
            <span class="text-uppercase letter-spacing-1">Chỉ từ 488.000đ/đêm</span>
          </div>
        </a>
      </div>

      <div class="col-md-6 col-lg-4" data-aos="fade-up">
        <a href="index.php?action=kind&act=family" class="room">
          <figure class="img-wrap">
            <img src="Content/images/family.jpg" alt="Family Room" class="img-fluid mb-3">
          </figure>
          <div class="p-3 text-center room-info">
            <h2>Family Room</h2>
            <span class="text-uppercase letter-spacing-1">Chỉ từ 389.000đ/đêm</span>
          </div>
        </a>
      </div>

      <div class="col-md-6 col-lg-4" data-aos="fade-up">
        <a href="index.php?action=kind&act=presidential" class="room">
          <figure class="img-wrap">
            <img src="Content/images/mia_suite_river_front.jpg" alt="Presidential Room" class="img-fluid mb-3">
          </figure>
          <div class="p-3 text-center room-info">
            <h2>Presidential Room</h2>
            <span class="text-uppercase letter-spacing-1">Chỉ từ 1.790.000đ/đêm</span>
          </div>
        </a>
      </div>


    </div>
  </div>
</section>
<!-- End Section Kind -->

<script>
  const inputBox = document.getElementById('searchInput');
  const dropdownMenu = document.getElementById('dropdownMenu');
  const overlay = document.getElementById('overlayy');
  const searchCard = document.querySelector('.block-32');
  const dropdownItems = document.querySelectorAll('.dropdown .item');

  inputBox.addEventListener('focus', () => {
    dropdownMenu.style.display = 'block';  //Hiển thị dropdownMenu
    setTimeout(() => dropdownMenu.classList.add('show'), 10); //Delay 10ms rồi mới thực hiện
    overlay.style.display = 'block';
  });

  //Click vào overlay thì thoát overlay và chuyển thành trạng thái bình thường
  overlay.addEventListener('click', () => {
    dropdownMenu.classList.remove('show');
    overlay.style.display = 'none';
  });

  // Khi chọn giá trị trong dropdown
  dropdownMenu.addEventListener("click", function(event) {
    // Kiểm tra xem phần tử được nhấp có phải là một mục trong dropdown không
    if (event.target.classList.contains("item")) {
        // Lấy giá trị của mục đã chọn
        var selectedValue = event.target.textContent;
        // Gán giá trị đã chọn vào ô input
        inputBox.value = selectedValue; // Thay đổi tại đây từ searchInput thành inputBox
        
        // Chuyển giá trị data-selected_room_id sang data-transfered_room_id
        var selectedRoomId = $(event.target).data('selected_room_id');
        $(inputBox).attr('data-transfered_room_id', selectedRoomId);
        
        // Ẩn dropdown sau khi chọn
        dropdownMenu.classList.remove('show');
        overlay.style.display = 'none';
    }
});


  //
  document.addEventListener('click', (event) => {
    if (!searchCard.contains(event.target) && !dropdownMenu.contains(event.target) && !inputBox.contains(event.target)) {
      dropdownMenu.classList.remove('show');
      overlay.style.display = 'none';
    }
  });

  // Thay đổi trạng thái khi dropdown đã được nhấn
  dropdownMenu.addEventListener('transitionend', () => {
    if (!dropdownMenu.classList.contains('show')) {
      dropdownMenu.style.display = 'none';
    }
  });

  inputBox.addEventListener('blur', () => {
    setTimeout(() => {
      if (!document.activeElement.classList.contains('item')) {
        dropdownMenu.classList.remove('show');
        overlay.style.display = 'none';
      }
    }, 100);
  });

  $(document).ready(function() {
    $(document).on("click", "#redirectToBooking", function() {
        let selected_room_id = $('#searchInput').data("transfered_room_id");
        if (selected_room_id) {
            window.location.href = `index.php?action=booking&selected_room_id=${selected_room_id}`;
        } else {
            Swal.fire({
              text: "Hãy chọn phòng trước!",
              icon: "info",
              timer: 3200,
              timerProgressBar: true
            });
        }
    });
});


</script>

<style>
  .mt {
    margin-top: -15px;
  }

  figure img {
    width: 360px;
    max-height: 230px;
  }
</style>