<?php
	ob_start();
    include 'connect.php';
	session_start();
?>
<?php if(isset($_GET['logout'])) {
    session_destroy();
    header('Location: dashboard.php');
} ?>
<html>
<head>
<meta charset="utf-8">
	<link href="admin.css" rel="stylesheet">
	<script src="ckeditor/ckeditor.js"></script>
		<style>
		#top img{
		width: 150px;
		height: 150px;
		padding-left:400px;
		}
	</style>
	<link rel="icon" type="image/png" href="assets/img/favicon.ico">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>admin - Taingheviet</title>

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

<body>
	<div class="sidebar" data-color="purple" data-image="assets/img/sidebar-5.jpg">

    <!--

        Tip 1: you can change the color of the sidebar using: data-color="blue | azure | green | orange | red | purple"
        Tip 2: you can also add an image using data-image tag

    -->

    	<div class="sidebar-wrapper">
            <div class="logo">
                <a class="simple-text">
                    Công cụ quản lý
                </a>
            </div>

            <ul class="nav">
                <li class="active">
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
                        <p>Doanh thu</p>
                    </a>
                </li>
                <li>
                    <a href="admin_display_information.php">
                        <i class="pe-7s-map-marker"></i>
                        <p>Thông tin website</p>
                    </a>
                </li>
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
                    <ul class="nav navbar-nav navbar-left">
                    </ul>

                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="admin_alter_categoris.php?logout=yes">
                                <p>Đăng xuất</p>
                            </a>
                        </li>
						<li class="separator hidden-lg"></li>
                    </ul>
                </div>
            </div>
        </nav>


        <div class="content" style="min-height: 800px; ">
            <?php
            if(isset($_SESSION['success'])) :?>
                    <p><?= $_SESSION['success'] ?></p>
            <?php endif ; ?>
            <div id="title">
                <nav class="navbar navbar-inverse">
                  <div class="container-fluid">
                    <div class="navbar-header">
                      <a class="navbar-brand" href="">Thêm: </a>
                    </div>
                    <ul class="nav navbar-nav">
                      <li><a href="dashboard.php?pr=yes">Sản Phẩm</a></li>
                      <li><a href="dashboard.php?cate=yes">Loại</a></li>
                      <li><a href="dashboard.php?producer=yes">Hãng</a></li>
                    </ul>
                    <!-- <button class="btn btn-danger navbar-btn">Button</button> -->
                  </div>
                </nav>
            </div>
	<?php
	if(isset($_GET['altercate'])){
		$CategoryID= $_GET['altercate'];
		$sql="SELECT * FROM categoris WHERE CategoryID = '$CategoryID'";
		$query=mysqli_query($conn, $sql)or die("khong the truy van");
		$row=mysqli_fetch_array($query);
		$CategoryName=$row['CategoryName'];
	}
?>
<div align="center">
    <h3>Cập nhập loại</h3>
	<form action="#" method="post">
		<label for="cateID">Mã Loại: </label>
		<input type="number" name="CategoryID" id="cateID" value="<?= $CategoryID ?>" class="form-control" style="width: 200px;"><br>
		<label for="cateName">Tên loại: </label>
		<input type="text" name="CategoryName" id="cateName" value="<?= $CategoryName ?>" class="form-control" style="width: 200px;"><br>
		<input type="submit" name="submit" value="Cập nhập" class="btn btn-success" style="width: 200px;">
	</form>
</div>
<?php
	if(isset($_POST['submit'])){
		$CategoryID=$_POST['CategoryID'];
		$CategoryName=$_POST['CategoryName'];
		$sql1="UPDATE categoris SET 
		CategoryID='$CategoryID', 
		CategoryName='$CategoryName' WHERE 
		CategoryID = '$CategoryID'";
		$query1=mysqli_query($conn, $sql1) or die("khong the truy van 2");
		$_SESSION['thongbao']="Cập nhập thành công";
		header('location: dashboard.php?cate=yes');
	}

?>
<?php if(isset($_SESSION['success'])) : ?>
    <br><div align="center">
        <p><?= $_SESSION['success'] ?></p>
        <a href="dashboard.php?cate=yes">Quay lại</a>
    </div>
    <?php endif ; unset($_SESSION['success']); ?>
</body>
</html>