<?php 
	session_start();
    // session_destroy();
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
<?php
	function adddotstring($strNum) {
			if($strNum<1){
				$result="Giá liên hệ";
				return $result;
			}
        	$len = strlen($strNum);
        	$counter = 3;
        	$result = "";
        	while ($len - $counter >= 0)
        	{
        	    $con = substr($strNum, $len - $counter , 3);
        	    $result = '.'.$con.$result;
        	    $counter+= 3;
        	}
        	$con = substr($strNum, 0 , 3 - ($counter - $len) );
        	$result = $con.$result;
        	if(substr($result,0,1)=='.'){
        	    $result=substr($result,1,$len+1);   
        	}
        	$result=$result." VNĐ";
        	return $result;
		}
        function Promotion($UnitPrice, $Promotion){
            if($Promotion == 0){
                $result = $UnitPrice;
            }
            if($Promotion >0){
                $result= ($UnitPrice/100)*$Promotion;
                // $result = $UnitPrice - $pro;
            }
            return $result;
        }	
        if(isset($_POST['search'])){
            $year = $_POST['year'];
            $month = $_POST['month'];
            $day = $_POST['day'];
            $yeargo = $_POST['yeargo'];
            $monthgo = $_POST['monthgo'];
            $daygo = $_POST['daygo'];
            $sql4 = "SELECT COUNT(BillID) as total FROM bill 
            WHERE TimeOrder BETWEEN '$year-$month-$day' AND '$yeargo-$monthgo-$daygo'";
            $sql5 = "SELECT BillID FROM bill 
            WHERE TimeOrder BETWEEN '$year-$month-$day' AND '$yeargo-$monthgo-$daygo' ";
            $query4=mysqli_query($conn, $sql4) or die("khong the truy van 4");
            $row4 = mysqli_fetch_array($query4);
            $totalbill1 = $row4['total'];
            $Quantity= 0;
            $UnitPrice = 0;
            $query5 = mysqli_query($conn, $sql5);
            while ($row5=mysqli_fetch_array($query5)) {
                $BillID = $row5['BillID'];
                $sql6 = "SELECT SUM(Quantity) as Quantitytt, SUM(UnitPrice) as UnitPricett FROM orderdetail WHERE BillID = $BillID";
                $query6 = mysqli_query($conn, $sql6) or die("khong the truy van 6");
                $row6 = mysqli_fetch_array($query6);
                $Quantity += $row6['Quantitytt'];
                $UnitPrice += $row6['UnitPricett'];
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
<body>

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
                <li  class="active">
                    <a href="admin_manager_revenue.php">
                        <i class="pe-7s-news-paper"></i>
                        <p>Doanh thu</p>
                    </a>
                </li>
                <li>
                    <a href="admin_display_information.php">
                        <i class="pe-7s-map-marker"></i>
                        <p>Thông tin Website</p>
                    </a>
                </li>
                <!-- <li>
                    <a href="notifications.html">
                        <i class="pe-7s-bell"></i>
                        <p>Notifications</p>
                    </a>
                </li>
				<li class="active-pro">
                    <a href="upgrade.html">
                        <i class="pe-7s-rocket"></i>
                        <p>Upgrade to PRO</p>
                    </a>
                </li>
            </ul> -->
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
                        <li>
                            <!-- <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-dashboard"></i>
								<p class="hidden-lg hidden-md">Dashboard</p>
                            </a> -->
                        </li>
                        <li class="dropdown">
                        </li>
                        <li>
                        </li>
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
            table tr th{
                text-align: center;
                font-size: 20px;
            }
            table tr td{
                text-align: center;
                font-size: 20px;
            }
        </style>
        <div class="content" style="min-height: 800px; ">
            <h3 align="center" >DOANH THU</h3>
            <table class="table">
                <tr>
                    <th>Tổng hóa đơn</th>
                    <th>Tổng Số lượng sản phẩm đã bán</th>
                    <th>Tổng Doanh thu</th>
                </tr>
                <?php 
                    $sql = "SELECT COUNT(BillID) as total FROM bill";
                    $query=mysqli_query($conn, $sql) or die("khong the truy van");
                    $row = mysqli_fetch_array($query);
                    $totalbill = $row['total'];
                    $sql2 = "SELECT SUM(Quantity)as totalQuantity, SUM(UnitPrice) as totalUnitPrices FROM orderdetail";
                    $query2 =mysqli_query($conn, $sql2) or die("khong the truy van 2");
                    $row2 =mysqli_fetch_array($query2);?>
                    <tr>
                        <td><?= $totalbill ?></td>
                        <td><?= $row2['totalQuantity'] ?></td>
                        <td><?= number_format($row2['totalUnitPrices']) ?> VNĐ</td>
                    </tr>
            </table>
            <style type="text/css">
                #time input{
                    width: 110px;
                }
            </style>
            <div>
                <p>Được tính từ 2019-05-20 đến nay</p>
                <?php if(!isset($_GET['search'])) { ?>
                    <a href="admin_manager_revenue.php?search=1" class="btn btn-info btn-fill"  >Tính doanh thu</a>
                <?php } ?>
                <?php if(isset($_GET['search'])){ ?>
                    <a href="admin_manager_revenue.php" class="btn btn-info btn-fill" style="float: left;">Đóng</a>
                    <div id="time">
                        <form action="admin_manager_revenue.php" method="post" >
                            <button type="submit" class="btn btn-success btn-fill" style="float: left; margin-left: 10px;" name="search">Tìm kiếm</button>
                            <div class="row" style="clear: left;">
                                <div class="col-md-5">
                                    <label>TừNăm</label>
                                    <input type="number" class="form-control" placeholder="Năm" name="year" value="2019" min="2019">
                                </div>
                                <div class="col-md-3" style="margin-left: -280px;">
                                    <label>Từ Tháng</label>
                                    <input type="number" class="form-control" placeholder="Tháng" name="month" min="05" value="05">
                                </div>
                                <div class="col-md-4" style="margin-left: -160px;">
                                    <label>Từ Ngày</label>
                                    <input type="number" class="form-control" placeholder="ngày" name="day" min="20" value="20">
                                </div>
                                <div class="col-md-5">
                                    <label>Đến Năm</label>
                                    <input type="number" class="form-control" placeholder="Năm" name="yeargo" value="2019" min="2019">
                                </div>
                                <div class="col-md-3" style="margin-left: -280px;">
                                    <label>Đến Tháng</label>
                                    <input type="number" class="form-control" placeholder="Tháng" name="monthgo">
                                </div>
                                <div class="col-md-4" style="margin-left: -160px;">
                                    <label>Đến Ngày</label>
                                    <input type="number" class="form-control" placeholder="ngày" name="daygo">
                                </div>
                            </div>
                        </form>
                    </div> <?php } ?>
                    <?php if(isset($_POST['search'])){ ?>
                        <p align="center" style="font-size: 25px;">Doanh thu từ <a><?= $year ?>/<?= $month ?>/<?= $day ?></a> Đến <a><?= $yeargo ?>/<?= $monthgo ?>/<?= $daygo ?></a></p>
                        <table class="table">
                             <tr>
                                <th>Tổng hóa đơn</th>
                                <th>Tổng Số lượng sản phẩm đã bán</th>
                                <th>Tổng Doanh thu</th>
                            </tr>
                            <tr>
                                <td><?= $totalbill1 ?></td>
                                <td><?= $Quantity ?></td>
                                <td><?= number_format($UnitPrice) ?> VNĐ</td>
                            </tr>
                        </table>
                    <?php } ?>
            </div>
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

	<!-- <script type="text/javascript">
    	$(document).ready(function(){

        	demo.initChartist();

        	$.notify({
            	icon: 'pe-7s-gift',
            	message: "Chào bạn đén với <b>Admin editor</b> - Có một ngày làm việc tuyệt vời nhé."

            },{
                type: 'info',
                timer: 4000
            });

    	});
	</script> -->

</html>