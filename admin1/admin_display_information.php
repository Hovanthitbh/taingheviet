<?php
    session_start();
    ob_start();
    include 'connect.php';
    if (!isset($_SESSION['ckadmin'])) {
        session_destroy();
        header('Location: admin_login/admin_login.php'); } ?>
     <?php if(isset($_GET['logout'])) {
        session_destroy();
        header('Location: dashboard.php');
    }
?>
<?php 
        if(isset($_SESSION['ckadmin'])){
            $ac=$_SESSION['ckadmin'];
            $s="SELECT * FROM accountad WHERE AccoutName = '$ac'";
            $q=mysqli_query($conn, $s) or die("khong the truy van s");
            $r=mysqli_fetch_array($q);
            if($r['Lever'] == 2){
                header('Location: dashboard.php');
                $_SESSION['lever'] = "$ac";
            }
             if($r['Lever']== 3){
                header('Location: admin_display_order.php');
                $_SESSION['lever'] = "$ac";
            }
        }
     ?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="icon" type="image/png" href="assets/img/favicon.ico">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Admin - taingheviet</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


    <!-- Bootstrap core CSS     -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Animation library for notifications   -->
    <link href="assets/css/animate.min.css" rel="stylesheet"/>

    <!--  Light Bootstrap Table core CSS    -->
    <link href="assets/css/light-bootstrap-dashboard.css?v=1.4.0" rel="stylesheet"/>


    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="assets/css/demo.css" rel="stylesheet" />


    <!--     Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link href="assets/css/pe-icon-7-stroke.css" rel="stylesheet" />

</head>
<body <?php if(isset($_SESSION['thongbao'])) : ?> onload="alert('<?= $_SESSION['thongbao'] ?>')" <?php endif ; unset($_SESSION['thongbao']); ?> >

<div class="wrapper">
    <div class="sidebar" data-color="purple" data-image="assets/img/sidebar-5.jpg">

    <!--

        Tip 1: you can change the color of the sidebar using: data-color="blue | azure | green | orange | red | purple"
        Tip 2: you can also add an image using data-image tag

    -->

    	<div class="sidebar-wrapper">
            <div class="logo">
                <a href="http://www.creative-tim.com" class="simple-text">
                    Công cụ quản lý
                </a>
            </div>

            <ul class="nav">
                <li>
                    <a href="dashboard.php">
                        <i class="pe-7s-graph"></i>
                        <p>THÊM SẢN PHẨM</p>
                    </a>
                </li>
                <li>
                    <a href="admin_display_account.php">
                        <i class="pe-7s-user"></i>
                        <p>Tài khoản quản lý</p>
                    </a>
                </li>
                <li>
                    <a href="admin_display_order.php">
                        <i class="pe-7s-note2"></i>
                        <p>Đơn hàng</p>
                    </a>
                </li>
                <li>
                    <a href="admin_manager_revenue.php">
                        <i class="pe-7s-news-paper"></i>
                        <p>Doanh Thu</p>
                    </a>
                </li>
                <li class="active">
                    <a href="admin_display_information.php">
                        <i class="pe-7s-map-marker"></i>
                        <p>Thông tin website</p>
                    </a>
                </li>
				<!-- <li class="active-pro">
                    <a href="upgrade.html">
                        <i class="pe-7s-rocket"></i>
                        <p>Upgrade to PRO</p>
                    </a>
                </li> -->
            </ul>
    	</div>
    </div>

    <div class="main-panel">
        <nav class="navbar navbar-default navbar-fixed">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="dashboard.php">Trang chủ</a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="dashboard.php?logout=yes">
                                <p>Đăng xuất</p>
                            </a>
                        </li>
						<li class="separator hidden-lg"></li>
                    </ul>
                </div>
            </div>
        </nav>

        <?php 
            if(isset($_POST['update'])){
                if (!empty($_POST['address']) && !empty($_POST['phonenumber']) && !empty($_POST['mail'])) {
                    $address = $_POST['address'];
                    $phonenumber = $_POST['phonenumber'];
                    $email = $_POST['mail'];
                    $sql2 = "UPDATE contact SET ContactAddress = '$address', ContactPhoneNumber = '$phonenumber', ContactMail = '$email'";
                    $query2 = mysqli_query($conn, $sql2) or die("Khong the try van 2");
                    $_SESSION['thongbao'] = "Cập nhập thông tin thành công";
                    header('Location: admin_display_information.php');exit();
                }
                else{
                    $_SESSION['thongbao'] = "Cập nhập không thành công! Vui lòng điền đầy đủ thông tin!";
                    header('Location: admin_display_information.php?update=yes');exit();
                }
            }
         ?>
        <div class="content" style="min-height: 800px; ">
            <?php 
                $sql = "SELECT * FROM contact";
                $query = mysqli_query($conn, $sql) or die("khong the truy van");
                $row = mysqli_fetch_array($query);
             ?>
             <style type="text/css">
                 table tr td{
                    width: 316px;
                 }
             </style>
             <h3 align="center">Thông tin liên lạc hiện tại của Trang</h3>
             <table class="table" style="width: 950px;">
                 <tr>
                     <th>Địa chỉ cửa hàng</th>
                     <th>Số điện thoại</th>
                     <th>Địa chỉ Email</th>
                 </tr>
                 <tr>
                     <td><?= $row['ContactAddress'] ?></td>
                     <td>0<?= $row['ContactPhoneNumber'] ?></td>
                     <td><?= $row['ContactMail'] ?></td>
                 </tr>
             </table>
             <?php if(!isset($_GET['update'])) { ?>
             <div align="center">
                 <a class="btn btn-info btn-fill" href="admin_display_information.php?update=yes">Cập nhập thông tin mới</a>
             </div><?php } ?>
              <?php if(isset($_GET['update'])) { ?>
             <div align="center">
                 <a class="btn btn-info btn-fill" href="admin_display_information.php">Đóng bản cập nhập</a>
             </div><?php } ?>
             <?php if(isset($_GET['update'])) { ?>
                <h3 align="center">Địa chỉ mới</h3>
                <table class="table" style="width: 950px;"><form action="admin_display_information.php" method="post">
                    <tr>
                        <th>Địa chỉ cửa hàng</th>
                        <th>Số điện thoại</th>
                        <th>Địa chỉ Email</th>
                    </tr>
                    <tr>
                        <td><input type="text" name="address" placeholder="Địa chỉ" class="form-control"></td>
                        <td><input type="number" name="phonenumber" placeholder="Số điện thoại" class="form-control"></td>
                        <td><input type="text" name="mail" placeholder="Email" class="form-control"></td>
                    </tr>
                    <tr>
                        <td colspan="3" align="center"><button type="submit" name="update" class="btn btn-info btn-fill">Cập nhập</button></td>
                    </tr>
                </form></table>
            <?php } ?>
        </div>


        <!-- <footer class="footer">
            <div class="container-fluid">
                <nav class="pull-left">
                    <ul>
                        <li>
                            <a href="#">
                                Home
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Company
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Portfolio
                            </a>
                        </li>
                        <li>
                            <a href="#">
                               Blog
                            </a>
                        </li>
                    </ul>
                </nav>
                <p class="copyright pull-right">
                    &copy; <script>document.write(new Date().getFullYear())</script> <a href="http://www.creative-tim.com">Creative Tim</a>, made with love for a better web
                </p>
            </div>
        </footer> -->

    </div>
</div>


</body>

    <!--   Core JS Files   -->
    <script src="assets/js/jquery.3.2.1.min.js" type="text/javascript"></script>
	<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>

	<!--  Charts Plugin -->
	<script src="assets/js/chartist.min.js"></script>

    <!--  Notifications Plugin    -->
    <script src="assets/js/bootstrap-notify.js"></script>

    <!--  Google Maps Plugin    -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>

    <!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
	<script src="assets/js/light-bootstrap-dashboard.js?v=1.4.0"></script>

	<!-- Light Bootstrap Table DEMO methods, don't include it in your project! -->
	<script src="assets/js/demo.js"></script>

</html>
