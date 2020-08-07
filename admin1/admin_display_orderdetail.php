<?php 
	session_start();
	if (!isset($_SESSION['ckadmin'])) {
        session_destroy();
        header('Location: admin_login/admin_login.php'); } ?>
     <?php if(isset($_GET['logout'])) {
        session_destroy();
        header('Location: dashboard.php');
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
                $pro= ($UnitPrice/100)*$Promotion;
                $result = $UnitPrice - $pro;
            }
            return $result;
        }
?>
<?php
    function status($status){
            if($status==1){
                $result="Đang đóng gói"; 
            }
            if($status==2){
                $result="Đang giao hàng"; 
            }
            if($status==3){
                $result="Đã giao hàng"; 
            }
            return $result;
        }
?>
<?php include 'connect.php'; 
		if (isset($_POST['status'])) {
			foreach ($_POST['status'] as $key => $value) {
				echo $BillID = $key;
				echo $Status =$value;
				$sl="UPDATE bill SET Status = $Status WHERE BillID = $BillID";
				$qr=mysqli_query($conn, $sl) or die("khong the truy van qr");
			}
		}
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="icon" type="image/png" href="assets/img/favicon.ico">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>admin - taingheviet</title>

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
                <li>
                    <a href="admin_display_account.php">
                        <i class="pe-7s-user"></i>
                        <p>Tài khoản người dùng</p>
                    </a>
                </li>
                <li class="active">
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


        <div class="content" style="min-height: 800px; ">
            <?php
            if(isset($_SESSION['success'])){
                    echo $_SESSION['success']; } ?>
            <div id="title">
                <nav class="navbar navbar-inverse">
                  <div class="container-fluid">
                    <div class="navbar-header">
                      <a class="navbar-brand" href="admin_display_order.php">Tình trạng: </a>
                    </div>
                    <ul class="nav navbar-nav">
                      <li><a href="dashboard.php?pr=yes">Đang đóng gói</a></li>
                      <li><a href="dashboard.php?cate=yes">Đang giao</a></li>
                      <li><a href="dashboard.php?producer=yes">Đã giao hàng</a></li>
                    </ul>
                    <!-- <button class="btn btn-danger navbar-btn">Button</button> -->
                  </div>
                </nav>
            </div>
        <div style="clear: all;">
            <?php if(isset($_GET['BillID'])){
                $BillID = $_GET['BillID'];
                $sql = "SELECT orderdetail.BillID, product.ProductName , product.ProductImage, bill.Status, orderdetail.Quantity, orderdetail.UnitPrice, bill.UserID, orderdetail.Promotion, bill.TimeOrder FROM ((orderdetail
                        INNER JOIN product ON orderdetail.ProductID = product.ProductID)
                        INNER JOIN bill ON orderdetail.BillID = bill.BillID)
                        WHERE orderdetail.BillID = '".$BillID."'";
                $query = mysqli_query($conn, $sql) or die("khong the truy van");
            } ?>
            <h2 align="center">Đơn hàng (Mã <?= $BillID ?> )</h2>
            <table class="table">
                <tr>
                    <th>Tên sản phẩm</th>
                    <th>Hình ảnh</th>
                    <th>Số lượng</th>
                    <th>Giá </th>
                    <th>Giảm giá</th>
                </tr>
                <?php $t=0; while ($row=mysqli_fetch_array($query)) { ?>
                    <tr>
                        <td><?= $row['ProductName'] ?></td>
                        <td><img src="product_image/<?= $row['ProductImage'] ?>" style="height: 100px; width: 100px;"></td>
                        <td><?= $row['Quantity'] ?></td>
                        <td><?= adddotstring(Promotion($row['UnitPrice'], $row['Promotion'])) ?></td>
                        <?php if($row['Promotion']>0) : ?><td>Đã giảm <?= $row['Promotion'] ?>%</td><?php endif ;?>
                    </tr>
                <?php $t=$t + Promotion($row['UnitPrice'], $row['Promotion']); $date=$row['TimeOrder']; } ?>
                    <tr style="font-size: 20px;">
                        <th colspan="3">Tổng tiền hóa đơn</th>
                        <th><?= adddotstring($t) ?></th>
                    </tr>
                    <tr style="font-size: 20px;">
                        <th colspan="3">Thời gian đặt hàng</th>
                        <th><?= $date ?></th>
                    </tr>
            </table>
            <h2 align="center">Thông tin Khách hàng</h2>
            <?php
                if(isset($_GET['BillID'])){
                    $BillID = $_GET['BillID'];
                    $sql1 = "SELECT * FROM bill WHERE BillID like '".$BillID."'";
                    $query1 = mysqli_query($conn, $sql1) or die("khong the truy van 1");
            } ?>
            <table class="table">
                <tr>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                    <th>Tên</th>
                    <th>Địa chỉ giao hàng</th>
                </tr>
                <?php while ($row=mysqli_fetch_array($query1)) { ?>
                    <tr>
                        <td><?= $row['Email'] ?></td>
                        <td>0<?= $row['PhoneNumber'] ?></td>
                        <td><?= $row['CustomerName'] ?></td>
                        <td><?= $row['CustomerAddress'] ?></td>
                    </tr>
                <?php } ?>
            </table>
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