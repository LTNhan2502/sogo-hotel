<?php
  $detail = new room();
  $ac = 0;
  if(isset($_GET['id']) && $_GET['id']==1){
    $ac = 1;
  }
  if(isset($_GET['id']) && $_GET['id']==2){
    $ac = 2;
  }
  if(isset($_GET['id']) && $_GET['id']==3){
    $ac= 3;
  }
?>

<section class="site-hero inner-page overlay" style="background-image: url(Content/images/hero_4.jpg)" data-stellar-background-ratio="0.5">
      <div class="container">
        <div class="row site-hero-inner justify-content-center align-items-center">
          <div class="col-md-10 text-center" data-aos="fade">
            <h1 class="heading mb-3">Detail Room</h1>
            <ul class="custom-breadcrumbs mb-4">
              <li><a href="index.php">Home</a></li>
              <li>&bullet;</li>
              <li>Rooms</li>
            </ul>
          </div>
        </div>
      </div>

      <a class="mouse smoothscroll" href="#next">
        <div class="mouse-icon">
          <span class="mouse-wheel"></span>
        </div>
      </a>
    </section>
    <!-- END section -->
    
    <section class="section">
      <div class="container">        
        <div class="row">
          <?php
            if($ac == 1){
              $result = $detail->getDetailRoom($ac);
              $name = $result['name'];
              $img = $result['img'];
              $description = $result['description'];
              $price = $result['price'];
              $sale = $result['sale'];
            }
            
          ?>
          <div class="col-md-4 col-lg-4 mb-5" data-aos="fade-up">
            <div class="card">Hiển thị các function</div>
          </div>
          <div class="col-md-8 col-lg-8 mb-5">            
              <div class="row">
                <div class="col-md-5 col-lg-5">
                  <figure class="img-wrap">
                    <img src="Content/images/<?php echo $img; ?>" alt="Free website template" class="img-fluid mb-3">
                  </figure>
                  <div class="p-3 text-start room-info">
                    <h2><?php echo $name; ?></h2>
                    <span class="text-uppercase letter-spacing-1"><?php echo $price ?>$ / per night</span>
                  </div>
                </div>
                <div class="col-md-7 col-lg-7">
                <h3>
                  <?php
                  $item = explode(' - ', $description);
                  if (count($item) >= 3) {
                      echo "$item[0] <br/> - $item[1] <br/> - $item[2]";
                  } else {
                      echo $description;
                  }
                  ?>
                </h3>

                  <a class="btn btn-secondary" href="index.php?action=cart">Add to cart</a>
                </div>
              </div>
          </div>
        </div>
      </div>
    </section>
    
    <section class="section bg-light">
      <div class="container">
        <div class="row justify-content-center text-center mb-5">
          <div class="col-md-7">
            <h2 class="heading" data-aos="fade">Great Offers</h2>
            <p data-aos="fade">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.</p>
          </div>
        </div>
      
        <div class="site-block-half d-block d-lg-flex bg-white" data-aos="fade" data-aos-delay="100">
          <a href="#" class="image d-block bg-image-2" style="background-image: url('images/img_1.jpg');"></a>
          <div class="text">
            <span class="d-block mb-4"><span class="display-4 text-primary">$199</span> <span class="text-uppercase letter-spacing-2">/ per night</span> </span>
            <h2 class="mb-4">Family Room</h2>
            <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.</p>
            <p><a href="#" class="btn btn-primary text-white">Book Now</a></p>
          </div>
        </div>
        <div class="site-block-half d-block d-lg-flex bg-white" data-aos="fade" data-aos-delay="200">
          <a href="#" class="image d-block bg-image-2 order-2" style="background-image: url('images/img_2.jpg');"></a>
          <div class="text order-1">
            <span class="d-block mb-4"><span class="display-4 text-primary">$299</span> <span class="text-uppercase letter-spacing-2">/ per night</span> </span>
            <h2 class="mb-4">Presidential Room</h2>
            <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.</p>
            <p><a href="#" class="btn btn-primary text-white">Book Now</a></p>
          </div>
        </div>

      </div>
    </section>

    <section class="section bg-image overlay" style="background-image: url('images/hero_4.jpg');">
      <div class="container" >
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