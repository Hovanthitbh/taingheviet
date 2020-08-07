<!DOCTYPE html>
<html lang="en">
  <head>
    <title>TAI NGHE VIET</title>
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
  <div class="site-wrap">
    <div class="site-navbar bg-white py-2">
      <div class="search-wrap">
        <div class="container">
          <a href="#" class="search-close js-search-close"><span class="icon-close2"></span></a>
          <form action="#" method="post">
            <input type="text" class="form-control" placeholder="Search keyword and hit enter...">
          </form>  
        </div>
      </div>
      <?php 
        include 'connect.php';
      ?>
      <div class="container">
        <div class="d-flex align-items-center justify-content-between">
          <div class="logo">
            <div class="site-logo">
              <a href="index.php" class="js-logo-clone">Tai nghe viet</a>
            </div>
          </div>
          <div class="main-nav d-none d-lg-block">
            <nav class="site-navigation text-right text-md-center" role="navigation">
              <ul class="site-menu js-clone-nav d-none d-lg-block">
                <li><a href="index.php">Trang chủ</a></li>
                <li class="has-children ">
                  <a href="display_product_headphone.php">Tai nghe</a>
                  <ul class="dropdown">
                    <?php 
                      $sql="SELECT * FROM producer WHERE CategoryID = 1";
                      $query = mysqli_query($conn, $sql) or die("khong the ket noi");
                      while ($row=mysqli_fetch_array($query)) { ?>
                        <li><a href="display_product_headphone.php?pr=<?= $row['ProducerID'] ?>"><?= $row['ProducerName'] ?></a></li>
                     <?php } ?>
                    <!-- <li class="has-children">
                      <a href="#">Sub Menu</a>
                      <ul class="dropdown">
                        <li><a href="#">Menu One</a></li>
                        <li><a href="#">Menu Two</a></li>
                        <li><a href="#">Menu Three</a></li>
                      </ul>
                    </li> -->
                  </ul>
                </li>
                <li class="has-children ">
                  <a href="display_product_player.php">Máy nghe nhạc</a>
                  <ul class="dropdown">
                    <?php 
                      $sql="SELECT * FROM producer WHERE CategoryID = 2";
                      $query = mysqli_query($conn, $sql) or die("khong the ket noi");
                      while ($row=mysqli_fetch_array($query)) { ?>
                        <li><a href="display_product_player.php?pr=<?= $row['ProducerID'] ?>"><?= $row['ProducerName'] ?></a></li>
                     <?php } ?>
                  </ul>
                </li>
                <li class="has-children ">
                  <a href="display_product_orther.php">Phụ kiện</a>
                  <ul class="dropdown">
                    <?php 
                      $sql1="SELECT * FROM producer WHERE CategoryID = 3";
                      $query1 = mysqli_query($conn, $sql1) or die("khong the ket noi");
                      while ($row1=mysqli_fetch_array($query1)) { ?>
                        <li><a href="display_product_orther.php?pr=<?= $row1['ProducerID'] ?>"><?= $row1['ProducerName'] ?></a></li>
                     <?php } ?>
                  </ul>
                  </li>
                <li><a href="display_promotion.php">
                  <span>khuyến mãi</span>
                </a></li>
                </li>
                <li><a href="https://www.facebook.com/messages/t/2321306354601310" target="_blank">Liên hệ</a></li>
              </ul>
            </nav>
          </div>
          <div class="icons">
            <!-- <a href="#" class="icons-btn d-inline-block js-search-open"><span class="icon-search"></span></a> -->
            <?php  if (isset($_SESSION['loginuser'])) { ?>
                    <a href="customer.php" class="icons-btn d-inline-block" style="font-size: 22px;"><span class="icon-user"></span></a>
            <?php } else { ?>
                    <a href="customer.php" class="icons-btn d-inline-block" style="font-size: 22px;"><span class="icon-user-o"></span></a>
            <?php } ?>
            <a href="shopping_cart.php" class="icons-btn d-inline-block bag" style="font-size: 22px;">
              <span class="icon-shopping-bag"></span>
            <?php if(isset($_SESSION['cart'])) { $t=0;
                    foreach ($_SESSION['cart'] as $key => $value) {
                      $t=$t+$value['Quantity'];
                    }?>
                    <span class="number"><?= $t ?></span>
           <?php } ?>
            </a>
            <a href="#" class="site-menu-toggle js-menu-toggle ml-3 d-inline-block d-lg-none"><span class="icon-menu"></span></a>
          </div>
        </div>
      </div>
    </div>
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