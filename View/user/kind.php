<link rel="stylesheet" href="Content/user/css/user-kind.css">
<link rel="stylesheet" href="Content/user/css/user-search.css">


<?php
  $room = new room();
  $fmt = new formatter();
  $ac = 0;
  if (isset($_GET['act']) && $_GET['act'] == "single") {
    $ac = 1;
  }
  if (isset($_GET['act']) && $_GET['act'] == "family") {
    $ac = 2;
  }
  if (isset($_GET['act']) && $_GET['act'] == "presidential") {
    $ac = 3;
  }
?>

<section class="site-hero overlay" style="background-image: url(Content/images/hero_4.jpg)"
  data-stellar-background-ratio="0.5">
  <div class="container">
    <div class="row site-hero-inner justify-content-center align-items-center">
      <div class="col-md-10 text-center" data-aos="fade-up">
        <span class="custom-caption text-white d-block  mb-3"><a href="index.php">Loại phòng</a></span>        
        <?php
          if ($ac == 1) {
            echo '<h1 class="heading">Single Room</h1>';
          }else if ($ac == 2) {
            echo '<h1 class="heading">Family Room</h1>';
          }else if ($ac == 3) {
            echo '<h1 class="heading">Presidential Room</h1>';
          }
        ?>
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


<!-- Start session card info -->
<section class="section">
  <div class="container">
    <div class="row">
      <?php
      if ($ac == 1) {
        $kind = $room->getSingle();
      }else if ($ac == 2) {
        $kind = $room->getFamily();
      }else if ($ac == 3) {
        $kind = $room->getPresidential();
      }
      while ($set = $kind->fetch()):
        ?>
        <div class="col-lg-12 col-md-12 mb-5" data-aos="fade-up">
          <div class="card rounded-table">
            <div class="card-body">
              <h5 class="card-title"><?php echo $set['name']; ?></h5>
              <p class="card-text">
              <div class="row">
                <div class="col-lg-4 col-md-4">
                  <img src="Content/images/<?php echo $set['img']; ?>" alt="Free website template"
                    class="img-fluid mb-3 rounded-img" width="700px" height="700px">
                  <button class="btn btn-primary rounded-btn" data-toggle="modal" data-target="#exampleModal<?php echo $set['id']; ?>">Xem chi tiết</button>
                </div>
                <div class="col-lg-8 col-md-8">
                  <table class="table table-bordered rounded-table">
                    <thead>
                      <tr>
                        <th class="width">Thông tin sơ bộ</th>
                        <th class="text-center">Khách</th>
                        <th class="text-right">Giá/phòng/đêm</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <!-- Thông tin sơ bộ -->
                        <td class="width">
                          <?php
                            $square_meter = $set['square_meter'];
                            $item = $set['requirement'];
                            $requirement = explode(" - ", $item);
                            $set_sv = count($requirement);
                          ?>
                          <ul>
                            <li><?php echo $square_meter; ?>m²</li>
                            <?php for ($i = 0; $i < $set_sv; $i++): ?>
                              <li><?php echo $requirement[$i]; ?></li>
                            <?php endfor; ?>
                          </ul>
                        </td>

                        <!-- Số khách -->
                        <td class="text-center"><?php echo $set['quantity']; ?></td>

                        <!-- Giá phòng/đêm -->
                        <td class="text-right">
                          <span class="text-line-through">
                            <?php echo $fmt->formatCurrency($set['price']); ?>đ
                          </span><br>
                          <span class="text-primary letter-spacing-1">
                            <?php echo $fmt->formatCurrency($set['sale']); ?>đ
                          </span>
                        </td>
                        <td class="text-center">
                          <a href="index.php?action=booking"
                            class="room btn btn-primary rounded-btn">Đặt phòng</a>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              </p>
            </div>
          </div>
        </div>

        <!-- Modal -->
      <div class="modal fade" id="exampleModal<?php echo $set['id']; ?>" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">
                Xem chi tiết phòng <span class="detail_name fs-3 fw-3"><?php echo $set['name']; ?></span>
              </h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <?php
                $id = $set['id'];
                $detail = $room->getDetailRooms($id);
                $detail = $detail->fetch()
              ?>
              <div class="row">
                <!-- Ảnh -->
                <?php if (isset($detail['id'])) { ?>
                  <div class="col-lg-8 bg-dark card image-container col-custom">
                    <div class="image-wrapper">
                        <img src="Content/images/<?php echo $detail['img']; ?>" class="image-big m-4">
                    </div>
                    <div class="image-row">
                      <?php
                        $item_img = $detail['img_name'];
                        $img_arr = explode(' - ', $item_img);
                        $img_num = count($img_arr);
                        echo "<img src='Content/images/" . $detail['img'] . "' class='image-small mb-4 selected'";
                        for ($i = 0; $i < $img_num; $i++) {
                          echo "<img src='Content/images/" . $img_arr[$i] . "' class='image-small mb-4' 
                                data-img-show='Content/images/" . $img_arr[$i] . "'>";
                        }
                      ?>
                    </div>
                  </div>
                  <!-- Mét vuông và số lượng người/phòng -->
                  <div class="col-lg-4 pl-4 scrollable-column">
                    <div class="row">
                      <h4>Thông tin chung</h4>
                      <div>
                        <ul>
                          <li><?php echo " " . $detail['square_meter'] . "m²"; ?></li>
                          <li><?php echo " " . $detail['quantity'] . " khách"; ?></li>
                        </ul>
                      </div>
                    </div>
                    <div class="row">
                      <div>
                        <hr>
                        <!-- Tiện ích -->
                        <h4>Tiện ích</h4>
                        <?php
                          $item = $detail['service_name'];
                          $service = explode(" - ", $item);
                          $set_sv = count($service);
                        ?>
                        <ul>
                          <?php for ($i = 0; $i < $set_sv; $i++): ?>
                            <li><?php echo $service[$i]; ?></li>
                          <?php endfor; ?>
                        </ul>
                        <hr>

                        <!-- Mô tả -->
                        <h4>Về phòng này</h4>
                        <?php
                          $item_des = $detail['description'];
                          $des = explode(' - ', $item_des);
                          $des_num = count($des);
                        for ($i = 0; $i < $des_num; $i++) {
                          echo "- $des[$i] </br>";
                        }
                        ?>
                        <br>
                        <div class="shadow-inset-md bg-body-tertiary p-3 text-center fw-bolder fs-6">
                          <?php
                          echo "Khởi điểm từ <span style='color: rgb(255, 94, 31);'>" . $fmt->formatCurrency($detail['sale']) . "</span> đ/phòng/đêm";
                          ?>
                          <a class="btn btn-primary"  href="index.php?action=booking&selected_room_id=<?php echo $set['id']; ?>">Chọn phòng này</a>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php } else {
                  echo "<h3 class='text-center'>Chưa có thông tin chi tiết của phòng này</h3>";
                } 
                ?>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- End Modal -->
    <?php endwhile; ?>
  </div>
  </div>
</section>



<section class="section bg-light">
  <div class="container">
    <div class="row justify-content-center text-center mb-5">
      <div class="col-md-7">
        <h2 class="heading" data-aos="fade">Great Offers</h2>
        <p data-aos="fade">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia,
          there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large
          language ocean.</p>
      </div>
    </div>

    <div class="site-block-half d-block d-lg-flex bg-white" data-aos="fade" data-aos-delay="100">
      <a href="#" class="image d-block bg-image-2" style="background-image: url('images/img_1.jpg');"></a>
      <div class="text">
        <span class="d-block mb-4"><span class="display-4 text-primary">$199</span> <span
            class="text-uppercase letter-spacing-2">/ per night</span> </span>
        <h2 class="mb-4">Family Room</h2>
        <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind
          texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.</p>
        <p><a href="#" class="btn btn-primary text-white">Book Now</a></p>
      </div>
    </div>
    <div class="site-block-half d-block d-lg-flex bg-white" data-aos="fade" data-aos-delay="200">
      <a href="#" class="image d-block bg-image-2 order-2" style="background-image: url('images/img_2.jpg');"></a>
      <div class="text order-1">
        <span class="d-block mb-4"><span class="display-4 text-primary">$299</span> <span
            class="text-uppercase letter-spacing-2">/ per night</span> </span>
        <h2 class="mb-4">Presidential Room</h2>
        <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind
          texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.</p>
        <p><a href="#" class="btn btn-primary text-white">Book Now</a></p>
      </div>
    </div>

  </div>
</section>

<section class="section bg-image overlay" style="background-image: url('images/hero_4.jpg');">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-12 col-md-6 text-center mb-4 mb-md-0 text-md-left" data-aos="fade-up">
        <h2 class="text-white font-weight-bold">A Best Place To Stay. Reserve Now!</h2>
      </div>
      <div class="col-12 col-md-6 text-center text-md-right" data-aos="fade-up" data-aos-delay="200">
        <a href="reservation.html" class="btn btn-outline-white-primary py-3 text-white px-5">Reserve Now</a>
      </div>
    </div>
  </div>
</section>

<script>  
  $(document).ready(function() {
    $(document).on("click", ".image-small", function() {
      let image_container = $(this).closest(".image-container");
      let image_big = image_container.find(".image-big");

      // Xoá tất cả selected class trong image-small (mỗi đối tượng mỗi khác)
      image_container.find(".image-small").removeClass("selected");

      // Thêm selected class vào image-small được click
      $(this).addClass("selected");

      // Lấy data từ data-img-show
      let newSrc = $(this).data("img-show");

      // Cập nhật lại đường link của image-big
      image_big.attr("src", newSrc);
    });

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
</script>