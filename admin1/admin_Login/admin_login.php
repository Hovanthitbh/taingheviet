<?php
	session_start();
	// session_destroy();
	$host = "localhost";
	$username = "root";
	$password = "";
	$database = "template";
	$conn = mysqli_connect($host,$username,$password,$database) or die("Không thể kết nối đến sever");		
	mysqli_query($conn,"SET NAMES 'utf8'");
?>
<?php
				if(isset($_POST['login'])){
					$ac_name=$_POST['username'];
					$ac_pass=$_POST['pass'];
					$sql= "SELECT * FROM accountad";
					$query=mysqli_query($conn, $sql) or die('khong the truy van');
					$num= mysqli_num_rows($query);
					for($i=1;$i<=$num; $i++){
						$row= mysqli_fetch_array($query);
						if($ac_name==$row['AccoutName'] && $ac_pass==$row['AccoutPass']){
							$_SESSION['ckadmin']=$ac_name;
							header('Location: admin_login.php');
							if(isset($_SESSION['ckadmin'])){
					            $ac=$_SESSION['ckadmin'];
					            $s="SELECT * FROM accountad WHERE AccoutName = '$ac'";
					            $q=mysqli_query($conn, $s) or die("khong the truy van s");
					            $r=mysqli_fetch_array($q);
					            if($r['Lever'] == 2){
					                header('Location: ../dashboard.php');
					            }
					             if($r['Lever']== 3){
					                header('Location: ../admin_display_order.php');
					            }
		        			}
						}
					}
					$_SESSION['baocao']="Sai tài khoản hoặc mật khẩu";
					$_SESSION['username']=$ac_name;
				}
				if(isset($_SESSION['ckadmin'])){
					header('Location: ../dashboard.php');
				}
			?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Admin - Taingheviet</title>
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
		<div class="container-login100" style="background-image: url('images/bg-01.jpg');">
			<div class="wrap-login100">
				<form class="login100-form validate-form" method="post">
					<span class="login100-form-logo">
						<i class="zmdi zmdi-landscape"></i>
					</span>

					<span style="font-size: 30px; color: white; margin-bottom: 20px;margin-left: 115px;" >
						Đăng nhập
					</span>

					<div class="wrap-input100 validate-input" data-validate = "Enter username">
						<input class="input100" type="text" name="username" placeholder="Tên đăng nhập" 
							<?php if(isset($_SESSION['username'])) : ?>
								value="<?= $_SESSION['username'] ?>"
							<?php endif ; unset($_SESSION['username']); ?>
						>
						<span class="focus-input100" data-placeholder="&#xf207;"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Enter password">
						<input class="input100" type="password" name="pass" placeholder="Mật khẩu">
						<span class="focus-input100" data-placeholder="&#xf191;"></span>
					</div>
					<?php if(isset($_SESSION['baocao'])) : ?>
						<p style="color: white;"><?= $_SESSION['baocao'] ?></p>
					<?php endif ; unset($_SESSION['baocao']); ?>
					<!-- <div class="contact100-form-checkbox">
						<input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
						<label class="label-checkbox100" for="ckb1">
							Remember me
						</label>
					</div> -->

					<div class="container-login100-form-btn">
						<button type="submit" name="login" class="login100-form-btn"> Đăng nhập</button>
					</div>

					<!-- <div class="text-center p-t-90">
						<a class="txt1" href="#">
							Forgot Password?
						</a>
					</div> -->
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