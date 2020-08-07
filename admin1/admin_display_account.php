<?php
    ob_start();
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
                $_SESSION['lever'] = "$ac";
            }
             if($r['Lever']== 3){
                header('Location: admin_display_order.php');
                $_SESSION['lever'] = "$ac";
            }
        }
     ?>
     <?php if(isset($_GET['logout'])) {
        session_destroy();
        header('Location: dashboard.php');
    }
    if (isset($_GET['deleteac'])) {
        $id_delete= $_GET['deleteac'];
        $sql2="DELETE from accountad where AccoutID =".$id_delete; 
        $query2=mysqli_query($conn,$sql2);
        $_SESSION['addadmin']="Xóa thành công";
        header('location: admin_display_account.php');
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
        <?php
            function lever($lever){
                if($lever==1){
                    $result = "Quản lý";
                }
                if($lever==2){
                    $result = "Quản lý sản phẩm";
                }
                if($lever==3){
                    $result = "Quản lý đơn hàng";
                }
                return $result;
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
<body style="background-color: white;" <?php if(isset($_SESSION['addadmin'])) : ?> onload="alert('<?= $_SESSION['addadmin'] ?>')" <?php unset($_SESSION['addadmin']); endif ; ?> >

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

        <div class="content" align="center" style="min-height: 400px; ">
            <div id="title">
                <nav class="navbar navbar-inverse">
                  <div class="container-fluid">
                    <div class="navbar-header">
                      <a class="navbar-brand" href="admin_display_order.php">Chức năng:</a>
                    </div>
                    <ul class="nav navbar-nav">
                      <li <?php if(!isset($_GET['accuser'])) : ?>  class="active" <?php endif ; ?> ><a href="admin_display_account.php" >Tài khoản quản lý</a></li>
                    </ul>
                    <ul class="nav navbar-nav">
                      <li
                      <?php if(isset($_GET['accuser'])) : ?>  class="active" <?php endif ; ?>
                      ><a href="admin_display_account.php?accuser=yes">Tài khoản người dùng</a></li>
                    </ul>
                    <!-- <button class="btn btn-danger navbar-btn">Button</button> -->
                  </div>
                </nav>
            </div>
            <div>
                <?php if(!isset($_GET['accuser'])) : ?><a href="admin_add_account.php" class="btn btn-danger" style="margin: 10px;">Thêm tài khoản quản lý</a>
                <a href="admin_display_account.php?changepass=yes" class="btn btn-danger" style="margin: 10px;">Đổi mật khẩu Quản lý</a>
                <?php endif ; ?>
            </div>
            <?php
                if(isset($_SESSION['success'])){ ?>
                    <p style="color: red;"><?= $_SESSION['success'] ?></p>
                <?php unset($_SESSION['success']); } ?>
            <?php
                if(!isset($_GET['accuser'])){
                    $sql="SELECT * FROM accountad";
                }
                else{
                    //tim tong so san pham
                    $result = mysqli_query($conn, "select count(UserID) as total from user");
                    $rowpage= mysqli_fetch_assoc($result);
                    $total_record = $rowpage['total'];

                    //tim limit va curent_page
                    $curent_page =isset($_GET['page']) ? $_GET['page'] : 1;
                    $limit = 5;

                    //tinh tong so trang va trang bat dau
                    $total_page = ceil($total_record/$limit);

                    //gioi han page do nguoi dung nhap
                    if($curent_page> $total_page){
                        $curent_page =$total_page;
                    }
                    else
                        if($curent_page<1){
                            $curent_page=1;
                        }
                    //tim start
                    $start = ($curent_page - 1)  * $limit;

                    //truy van lay danh sach san pham
                    $sql = "SELECT * FROM user LIMIT $start, $limit";
                }
                $query=mysqli_query($conn, $sql)or die("khong the truy van");
            ?>
            <table class="table">
                <?php if(!isset($_GET['accuser']) && !isset($_GET['changepass'])) : ?> 
                <tr>
                    <th>Mã tài khoản</th>
                    <th>Tên tài khoản</th>
                    <!-- <th>Mật khẩu</th> -->
                    <th>Cấp quẩn trị</th>
                </tr>
                <?php endif ;  ?>
                <?php if(isset($_GET['accuser'])) : ?> 
                <tr>
                    <th>STT</th>
                    <th>Tên người dùng</th>
                    <th>Số điện thoại</th>
                    <th>Email</th>
                    <th>Địa chỉ</th>
                    <th>Ngày tạo tài khoản</th>
                </tr>
                <?php endif ;  ?>
                <?php
                    while ($row=mysqli_fetch_array($query)) { 
                        if(!isset($_GET['accuser']) && !isset($_GET['changepass'])) : ?>   
                        <tr>
                            <td><?= $row['AccoutID'] ?></td>
                            <td><?= $row['AccoutName'] ?></td>
                            <!-- <td><?= $row['AccoutPass'] ?></td> -->
                            <td><?= lever($row['Lever']) ?></td>
                            <?php if($row['Lever']!=1) { ?>
                                <td><a href="admin_display_account.php?deleteac=<?= $row['AccoutID'] ?>" 
                                    class="fa fa-trash btn btn-danger" onclick="return confirm('Bạn có chắc chắn xóa không?')"></a></td><?php } ?>
                        </tr>   <?php endif ;  ?>
                        <?php if(isset($_GET['accuser'])) : ?>
                            <tr>
                            <td><?= ($start+1) ?></td>
                            <td><?= $row['UserName'] ?></td>
                            <td><?= $row['PhoneNumber'] ?></td>
                            <td><?= $row['Email'] ?></td>
                            <td><?= $row['Address'] ?></td>
                            <td><?= $row['SignTime'] ?></td>
                        </tr>
                        <?php $start++; endif ;  ?>
                <?php  }
                ?>
            </table>
            <?php 
        if(isset($_GET['accuser'])) : ?>
            <div align="center">
            <ul class="pagination">
                <?php if($curent_page>1 && $total_page>1){
                    echo "<li><a href='admin_display_account.php?accuser=yes&page=".($curent_page - 1)."'>Back</a></li>";
                    }
                    for($i =1; $i<=$total_page;$i++){
                        if($i == $curent_page)
                            echo "<li><span style='background-color: pink;'>".$i."</span</li>";
                        else echo "<li><a href='admin_display_account.php?accuser=yes&page=".$i."'> ".$i." </a></li>";
                    }
                    if($curent_page<$total_page && $total_page>1){
                        echo "<li><a href='admin_display_account.php?accuser=yes&page=".($curent_page + 1)."'>Next</a></li>";
                    }
                ?>
            </ul>
            </div>
    <?php endif ; ?>  
        <?php if(isset($_GET['changepass'])) : ?>
            <style type="text/css">
                form input[type = "password"]{
                    width: 200px;
                    border: 1px solid black;
                    margin-bottom: 15px;
                    transition: 0.25s;
                }
                form input[type = "password"]:focus{
                    border: 1px solid red;
                    width: 300px;
                }
            </style>
            <div>
                <h2> Thay đổi mật khẩu admin </h2>
                <form action="#" method="post">
                    <label>Mật khẩu mới:</label><input type="password" name="newpass" placeholder="nhập mật khẩu mới" class="form-control">
                    <label>Mật lại khẩu mới:</label><input type="password" name="repass" placeholder="nhập mật lại khẩu" class="form-control">
                    <label>Mật khẩu cũ:</label><input type="password" name="oldpass" placeholder="nhập mật khẩu cũ" class="form-control">
                    <input type="submit" name="changepass" value="Đổi mật khẩu" class="btn btn-success">
                </form>
            </div>
        <?php endif ; ?>
        <?php
            if(isset($_POST['changepass'])){
                $newpass = $_POST['newpass'];
                $repass = $_POST['repass'];
                $oldpass = $_POST['oldpass'];
                if($newpass == $repass){
                    $sql = "SELECT * FROM accountad WHERE lever = 1";
                    $query = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_array($query);
                    if($oldpass == $row['AccoutPass']){
                        echo $sql1 = "UPDATE accountad SET AccoutPass = '$newpass' WHERE Lever = 1";
                        $query1 = mysqli_query($conn, $sql1);
                        $_SESSION['addadmin'] = "Thay đổi mật khẩu thành công!";
                        header('Location: admin_display_account.php');exit();
                    }
                    $_SESSION['addadmin'] = "Thay đổi không thành công! Sai mật khẩu cũ!";
                    header('Location: admin_display_account.php?changepass=yes');exit();

                }
                $_SESSION['addadmin'] = "Thay đổi không thành công! mật khẩu không khớp!";
                header('Location: admin_display_account.php?changepass=yes');exit();  
            }
        ?>
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