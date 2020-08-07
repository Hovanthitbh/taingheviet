<?php
	session_start();
	// session_destroy();
	// include '../menu.php';
	include '../connect.php';
	if(isset($_SESSION['loginuser'])){
		// unset($_SESSION['loginuser']);
		header('location: ../customer.php');
	}
	if(isset($_GET['logout'])){
		session_destroy(); 
	}
	if(isset($_POST['login']) && !isset($_SESSION['loginuser'])){
		$sql1 = "SELECT * FROM user where Email like '".$_POST['email']."'";
		$sql2 = "SELECT * FROM user where PhoneNumber like '".$_POST['email']."'";
		$sql3 =	"SELECT * FROM user where PassWord like '".$_POST['userpass']."' AND (Email like '".$_POST['email']."' or 
		PhoneNumber like '".$_POST['email']."')";
		$query1 = mysqli_query($conn, $sql1)or die("khong the truy van 3");
		$query2 =	mysqli_query($conn, $sql2)or die("khong the truy van 4");
		$query3 =	mysqli_query($conn, $sql3)or die("khong the truy van 5");
		$row = mysqli_num_rows($query1);
		$row2 = mysqli_num_rows($query2);
		$row3 = mysqli_num_rows($query3);
		$row4 = mysqli_fetch_array($query3);
		$username = $row4['UserName'];
		if($row==1 || $row2==1){
			if($row3==1){
				if(isset($_SESSION['checkout'])){
					$_SESSION['UserID'] = $row4['UserID'];
					$_SESSION['loginuser']= $username;
					unset($_SESSION['checkout']);
					header('location: ../checkout.php');exit();
				}
				else {
					$_SESSION['UserID'] = $row4['UserID'];
					$_SESSION['loginuser']= $username;
					header('location: ../customer.php');exit();
				}
			}
			else{
				$_SESSION['success']="Sai mật khẩu";
			}
		}
		else{
			$_SESSION['success']="Sai Email hoặc hoặc mật khẩu";
		}
	}
	if(isset($_SESSION['loginuser'])){
		header('location: ../customer.php');exit();
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>TAI NGHE VIET - Đăng nhập</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<form class="login100-form validate-form" method="post" action="#">
					<span class="login100-form-title p-b-26">
						<a href="../index.php"><i class="zmdi" style="font-size:30px; border: 1px solid gray; padding: 7px; ">TAI NGHE VIET</i></a>
					</span>
					<span class="login100-form-title p-b-48">
						<a href="../index.php"><i class="zmdi" style="font-size: 25px;">Đăng nhập</i></a>
					</span>

					<div class="wrap-input100 validate-input" data-validate = "Valid email is: a@b.c">
						<input class="input100" type="text" name="email">
						<span class="focus-input100" data-placeholder="Email"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Enter password">
						<span class="btn-show-pass">
							<i class="zmdi zmdi-eye"></i>
						</span>
						<input class="input100" type="password" name="userpass">
						<span class="focus-input100" data-placeholder="Mật khẩu"></span>
					</div>
					<?php if (isset($_SESSION['success'])) :?>
						<p class="btn btn-danger"><?= $_SESSION['success'] ?></p><br>
					<?php endif ; unset($_SESSION['success']) ?>

					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<button class="login100-form-btn" type="submit" name="login">
								Đăng nhập
							</button>
						</div>
					</div>

					<div class="text-center p-t-10">
						<span class="txt1">
							Bạn chưa có tài khoản? 
						</span>

						<a class="txt2" href="../regist.php">
							Đăng ký
						</a>
					</div>
					<div class="text-center p-t-10" >
						<span class="login100-form-title p-b-26">
						<a href="../index.php"><i class="zmdi" style="font-size:20px;">Quay về trang chủ</i></a>
					</span>
					</div>

				</form>
			</div>
		</div>
	</div>
	

	<div id="dropDownSelect1"></div>
	
<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>