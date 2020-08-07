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
            }
             if($r['Lever']== 3){
                // header('Location: admin_display_order.php');
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
                $pro= ($UnitPrice/100)*$Promotion;
                $result = $UnitPrice - $pro;
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
                        <p>Tài khoản quản lý</p>
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
                        <p>Doanh thu</p>
                    </a>
                </li>
                <li>
                    <a href="admin_display_information">
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
                    <a class="navbar-brand" href="dashboard.php">Dashboard</a>
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
                              <!-- <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-globe"></i>
                                    <b class="caret hidden-lg hidden-md"></b>
									<p class="hidden-lg hidden-md">
										5 Notifications
										<b class="caret"></b>
									</p>
                              </a>
                              <ul class="dropdown-menu">
                                <li><a href="#">Notification 1</a></li>
                                <li><a href="#">Notification 2</a></li>
                                <li><a href="#">Notification 3</a></li>
                                <li><a href="#">Notification 4</a></li>
                                <li><a href="#">Another notification</a></li>
                              </ul> -->
                        </li>
                        <li>
                           <!-- <a href="">
                                <i class="fa fa-search"></i>
								<p class="hidden-lg hidden-md">Search</p>
                            </a> -->
                            <form action="admin_display_order.php" method="get" name="form" style="margin-top: 10px;">
                                <input type="text" name="txtsearch" class="form-control" placeholder="nhập từ khóa" 
                                style="float: left; width: 200px;">
                                <select name="keys" class="form-control" style="width: 110px; float: left;" onchange="form.submit()" >
                                    <option class="form-control">Tìm theo</option>
                                    <option class="form-control" value="1">Mã đơn hàng</option>
                                    <option class="form-control" value="2">Email </option>
                                    <option class="form-control" value="3">Số điện thoại</option>
                                </select>
                            </form>
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


        <div class="content" style="min-height: 800px; ">
            <?php
            if(isset($_SESSION['success'])){
                    echo $_SESSION['success']; unset($_SESSION['success']); } ?>
            <div id="title">
                <nav class="navbar navbar-inverse">
                  <div class="container-fluid">
                    <div class="navbar-header">
                      <a class="navbar-brand" href="admin_display_order.php">Tình trạng: </a>
                    </div>
                    <ul class="nav navbar-nav">
                        <li <?php if(isset($_GET['bill'])){ if ($_GET['bill']==1) {
                          echo "class='active'";
                      } }?> ><a href="admin_display_order.php?bill=1">Đang Xác nhận</a></li>
                      <li <?php if(isset($_GET['bill'])){ if ($_GET['bill']==2) {
                          echo "class='active'";
                      } }?> ><a href="admin_display_order.php?bill=1">Đang đóng gói</a></li>
                      <li <?php if(isset($_GET['bill'])){ if ($_GET['bill']==3) {
                          echo "class='active'";
                      } }?> ><a href="admin_display_order.php?bill=2">Đang giao</a></li>
                      <li <?php if(isset($_GET['bill'])){ if ($_GET['bill']==4) {
                          echo "class='active'";
                      } }?> ><a href="admin_display_order.php?bill=3">Đã giao hàng</a></li>
                    </ul>
                  </div>
                </nav>
            </div>
            <div>
				<table class="table" style="font-size: 13px;">
					<tr>
						<th>Mã hóa đơn</th>
						<th>Email</th>
						<th>Số điện thoại</th>
						<th>Tên khách hàng</th>
						<th>Địa chỉ</th>
						<th>Tình trạng</th>
						<th>Mã sản phẩm</th>
						<th>Số lượng</th>
						<th>Giá</th>
					</tr>
					<?php 
                        if(isset($_POST['datetime'])){
                            $year = $_POST['year'];
                            $month = $_POST['month'];
                            $day = $_POST['day'];
                            $yeargo = $_POST['yeargo'];
                            $monthgo = $_POST['monthgo'];
                            $daygo = $_POST['daygo'];
                            //tim tong so san pham
                            // $result = mysqli_query($conn, "SELECT count(BillID) as total from bill WHERE TimeOrder BETWEEN '$year-$month-$day' AND '$yeargo-$monthgo-$daygo' ");
                            // $rowpage= mysqli_fetch_assoc($result);
                            // $total_record = $rowpage['total'];
                            // //tim limit va curent_page
                            // $curent_page =isset($_GET['page']) ? $_GET['page'] : 1;
                            // $limit = 5;

                            // //tinh tong so trang va trang bat dau
                            // $total_page = ceil($total_record/$limit);

                            // //gioi han page do nguoi dung nhap
                            // if($curent_page> $total_page){
                            //     $curent_page =$total_page;
                            // }
                            // else
                            //     if($curent_page<1){
                            //         $curent_page=1;
                            //     }
                            // //tim start
                            // $start = ($curent_page - 1)  * $limit;

                            //truy van lay danh sach san pham
                            $query_page = "SELECT * FROM bill 
                            WHERE TimeOrder BETWEEN '$year-$month-$day' AND '$yeargo-$monthgo-$daygo'";
                            // $result= mysqli_query($conn,$query_page);
                            // $sql1 = "SELECT * FROM bill";
                        }
						$query1 = mysqli_query($conn, $query_page) or die("khong the truy van 1");
                        $n = mysqli_num_rows($query1);
                        if ($n==0) {
                            echo "<p align='center' class='text-warning'>Không có hóa đơn nào</p>"; die();
                        }
						while ($row1=mysqli_fetch_array($query1)) { 
							$sql2 = "SELECT * FROM orderdetail WHERE BillID = '".$row1['BillID']."'";
							$query2 = mysqli_query($conn, $sql2) or die("khong the truy van");
							$num = mysqli_num_rows($query2);
                            $sql3 = "SELECT * FROM bill WHERE BillID = '".$row1['BillID']."'";
                            $query3 = mysqli_query($conn, $sql3) or die("khong the truy va3");
                            $r=mysqli_fetch_array($query3); ?>
							<tr>
								<td rowspan="<?= $num ?>"><a href="admin_display_orderdetail.php?BillID=<?= $row1['BillID'] ?>" class="btn btn-danger">
                                    <?= $row1['BillID'] ?></a></td>
								<td rowspan="<?= $num ?>"><?= $row1['Email'] ?></td>
								<td rowspan="<?= $num ?>">0<?= $row1['PhoneNumber'] ?></td>
								<td rowspan="<?= $num ?>"><?= $row1['CustomerName'] ?></td>
								<td rowspan="<?= $num ?>"><?= $row1['CustomerAddress'] ?></td>
								<td rowspan="<?= $num ?>">
									<form method="post" action="admin_display_order_search.php" name="form" style="width: 150px;">
									<select name="status[<?= $row1['BillID'] ?>]" onchange="form.submit()" class="form-control">
                                        <option value="1" <?php if($row1['Status']==1) : ?> selected="selected" <?php endif ; ?>>Đang Xác nhận</option>
										<option value="2" <?php if($row1['Status']==2) : ?> selected="selected" <?php endif ; ?>>Đang đóng gói</option>
										<option value="3" <?php if($row1['Status']==3) : ?> selected="selected" <?php endif ; ?>>Đang giao hàng</option>
										<option value="4" <?php if($row1['Status']==4) : ?> selected="selected" <?php endif ; ?>>Đã giao hàng</option>
									</select>
								</td>
								<?php 
									while ($row2 = mysqli_fetch_array($query2)) { ?>
										<td><?= $row2['ProductID'] ?></td>
										<td><?= $row2['Quantity'] ?></td>
										<td><?= adddotstring(Promotion($row2['UnitPrice'],$row2['Promotion'])) ?></td>
									</tr>
								<?php } ?>
						<?php } ?>
				</table>
			</div>
		</div>
        <!-- <?php 
            if(isset($_POST['datetime'])){ ?>
            <div align="center">
             <ul class="pagination">
                <?php if($curent_page>1 && $total_page>1){
                    echo "<li><a href='admin_display_order_search.php?page=".($curent_page - 1)."'>Back</a></li>";
                    }
                    for($i =1; $i<=$total_page;$i++){
                        if($i == $curent_page)
                            echo "<li><span style='background-color: pink;'>".$i."</span</li>";
                        else echo "<li><a href='admin_display_order_search.php?page=".$i."'> ".$i." </a></li>";
                    }
                    if($curent_page<$total_page && $total_page>1){
                        echo "<li><a href='admin_display_order_search.php?page=".($curent_page + 1)."'>Next</a></li>";
                    }
                ?>
            </ul>
        </div>
            <?php }
        ?> -->
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