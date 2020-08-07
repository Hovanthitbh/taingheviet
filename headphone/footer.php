<!DOCTYPE html>
<html lang="en">
  <head>
    <title>ShopMax &mdash; Colorlib e-Commerce Template</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Mukta:300,400,700"> 
    <link rel="stylesheet" href="fonts/icomoon/style.css">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">


    <link rel="stylesheet" href="css/aos.css">

    <link rel="stylesheet" href="css/style.css">
    
  </head>
  <body>
    <footer class="site-footer custom-border-top" style=" float: left; width: 1200px;">
      <div class="container">
        <div class="row">
          <div class="col-md-6 col-lg-3 mb-4 mb-lg-0">
            <h3 class="footer-heading mb-4" align="center">TAI NGHE VIET</h3>
            <a href="#" class="block-6">
              <img src="../admin1/product_image/3kshop-philips-shp-9500-1.jpg" alt="Image placeholder" class="img-fluid rounded mb-4">
              <!-- <h3 class="font-weight-light  mb-0">Finding Your Perfect Shirts This Summer</h3> -->
              <p>Hoạt động vào ngày 24-5-2019.</p>
            </a>
          </div>
          <div class="col-lg-5 ml-auto mb-5 mb-lg-0">
            <div class="row">
              <div class="col-md-12">
                <h3 class="footer-heading mb-4">Kết nối nhanh</h3>
              </div>
              <div class="col-md-6 col-lg-4">
                <ul class="list-unstyled">
                  <li><a href="index.php">Trang chủ</a></li>
                  <li><a href="display_product_headphone.php">Tai nghe</a></li>
                  <li><a href="display_product_player.php">Máy nghe nhạc</a></li>
                  <li><a href="display_product_order.php">Phụ kiện</a></li>
                </ul>
              </div>
              <div class="col-md-6 col-lg-4">
                <ul class="list-unstyled">
                  <li><a href="login_user/login_user.php">Đăng nhập</a></li>
                  <li><a href="customer.php">Kiểm tra đơn hàng</a></li>
                  <li><a href="shopping_cart.php">Giỏ hàng</a></li>
                </ul>
              </div>
              <div class="col-md-6 col-lg-4">
                <ul class="list-unstyled">
                  <li><a href="https://www.facebook.com/messages/t/2321306354601310" target="_blank">Liên hệ Facebook</a></li>
                  <!-- <li><a href="#">Hardware</a></li> -->
                </ul>
              </div>
            </div>
          </div>
          <?php include 'connect.php';
            $sql = "SELECT * FROM contact";
            $query = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($query) or die("khong the truy van");
           ?>
          <div class="col-md-6 col-lg-3">
            <div class="block-5 mb-5">
              <h3 class="footer-heading mb-4">Thông tin liên lạc</h3>
              <ul class="list-unstyled">
                <li class="address"><?= $row['ContactAddress'] ?></li>
                <li class="phone"><a href="tel://0<?= $row['ContactPhoneNumber'] ?>">0<?= $row['ContactPhoneNumber'] ?></a></li>
                <li class="email"><?= $row['ContactMail'] ?></li>
              </ul>
            </div>

            <!-- <div class="block-7">
              <form action="#" method="post">
                <label for="email_subscribe" class="footer-heading">Subscribe</label>
                <div class="form-group">
                  <input type="text" class="form-control py-4" id="email_subscribe" placeholder="Email">
                  <input type="submit" class="btn btn-sm btn-primary" value="Send">
                </div>
              </form>
            </div> -->
          </div>
        </div>
        <div class="row pt-5 mt-5 text-center">
          <div class="col-md-12">
            <p style="margin-top: -80px;">
            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
            TAINGHEVIET &copy;<script>document.write(new Date().getFullYear());</script> Trải nghiệm âm thanh | Điểm 10 cho chất lượng <i class="icon-heart" aria-hidden="true"></i> by <a href="index.php" target="_blank" class="text-primary">TAI NGHE VIET</a>
            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
            </p>
          </div>
          
        </div>
      </div>
    </footer>
  </div>

  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/aos.js"></script>

  <script src="js/main.js"></script>
    
  </body>
</html>