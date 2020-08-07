<?php
    session_start();
    include 'connect.php';
    if (!isset($_SESSION['ckadmin'])) {
        session_destroy();
        header('Location: admin_login/admin_login.php'); } ?>
    <?php 
        if(isset($_SESSION['ckadmin'])){
            $ac=$_SESSION['ckadmin'];
            $s="SELECT * FROM accountad WHERE AccoutName = '$ac'";
            $q=mysqli_query($conn, $s) or die("khong the truy van s");
            $r=mysqli_fetch_array($q);
            if($r['Lever'] == 2){
                header('Location: dashboard.php');
            }
             if($r['Lever']== 3){
                header('Location: admin_display_order.php');
            }
        }
     ?>
     <?php if(isset($_GET['logout'])) {
        session_destroy();
        header('Location: dashboard.php');
    }
?>
 <?php
            if(isset($_POST['addadmin'])){
                $username = $_SESSION['ckadmin'];
                $repass = $_POST['repass'];
                $sql="SELECT * FROM accountad WHERE AccoutName like '$username' 
                and AccoutPass like '$repass' and lever = 1";
                $query = mysqli_query($conn, $sql) or die("khong the truy van");
                $row=mysqli_num_rows($query);
                if($row==1){
                    $adminuser= $_POST['adminuser'];
                    $adminpass= $_POST['adminpass'];
                    $lever =$_POST['lever'];
                    $sql3="SELECT * FROM accountad WHERE AccoutName like '$adminuser'";
                    $query3 = mysqli_query($conn, $sql3) or die("khong the truy van3");
                    $row3=mysqli_num_rows($query3);
                    if($row3==0){
                        $sql2 ="INSERT INTO accountad (AccoutName, AccoutPass, Lever) VALUES ( '$adminuser','$adminpass' ,'$lever')";
                        $query2=mysqli_query($conn, $sql2) or die("khong the truy van 2");
                        $_SESSION['addadmin']="Đăng ký thành công"; 
                        header('Location:admin_display_account.php');
                    }
                    else{
                        $_SESSION['addadmin']="Tên tài khoản đã tồn tại";
                    }
                }
                else{
                    $_SESSION['addadmin']="Sai mật khẩu admin";
                }
            }
        ?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="icon" type="image/png" href="assets/img/favicon.ico">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Light Bootstrap Dashboard by Creative Tim</title>

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
<body style="background-color: white;" >

<div class="wrapper">
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
                <li>
                    <a href="dashboard.php">
                        <i class="pe-7s-graph"></i>
                        <p>THÊM SẢN PHẨM</p>
                    </a>
                </li>
                <li class="active">
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
                    <a href="admin_manager_reveue.php">
                        <i class="pe-7s-science"></i>
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
                            <a href="dashboard.php?logout=yes">
                                <p>Đăng xuất</p>
                            </a>
                        </li>
						<li class="separator hidden-lg"></li>
                    </ul>
                </div>
            </div>
        </nav>
        <style type="text/css">
            .content{
                border: 1px solid gray;
                width: 600px;
                margin-left: 200px;
                margin-top: 50px;
                margin-bottom: 50px;
                border-radius: 10px;
                background-color: #F2F2F2;
            }
            .add{
                margin-bottom: 10px;

            } 
            .add span{
                font-size: 15px;
            }
            .add input{
                height: 30px;
                width: 300px;
                border:1px solid gray;
                border-radius: 5px;
                margin-bottom: 20px;
                font-size: 15px;
                padding-left: 10px;
            } 
            .add select{
                height: 30px;
                width: 150px;
                border:1px solid gray;
                border-radius: 5px;
                margin-bottom: 20px;
                font-size: 15px;
            }  
            .add button{
                width: 200px;
                height: 35px;
                border:1px solid gray;
                border-radius: 5px;
                color: white;
                background-color: #21610B;
            }  
        </style>

        <div class="content" align="center" style="min-height: 400px; ">
            <form action="admin_add_account.php" method="post">
                <h3 style="margin-bottom: 40px; font-size: 30px;">Thêm tài khoản quản trị</h3>
                <div class="add">
                    <span style="margin-left: 60px;">Tên tài khoản:</span>
                    <input type="text" name="adminuser"><br>
                </div>
                <div class="add">
                    <span style="margin-left: 85px;">Mật khẩu:</span>
                    <input type="password" name="adminpass"><br>
                </div>
                <div class="add">
                    <span style="margin-left: -97px;">Cấp độ quản lý:</span>
                    <select name="lever">
                        <option value="2">Quản lý sản phẩm</option>
                        <option value="3">Quản lý đơn hàng</option>
                        <!-- <option value="4">Quản lý doanh thu</option> -->
                    </select><br>
                </div>
                <div class="add">
                    <span style="margin-left: -50px;">Nhập mật khẩu quản lý hiện tại:</span>
                    <input type="password" name="repass"><br>
                </div>
                <?php if(isset($_SESSION['addadmin'])) {?>
                    <p><?= $_SESSION['addadmin'] ?></p>
                <?php unset($_SESSION['addadmin']); } ?>
                <div class="add"><button style="submit" class="btn btn-success" name="addadmin">Thêm tài khoản</button></div>
            </form>
		</div>
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