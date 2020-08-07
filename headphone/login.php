<?php
	session_start();
	// session_destroy();
	include 'banner.php';
	// include 'menu.php';
	include 'connect.php';
?>
<?php
	if(isset($_POST['login']) && !isset($_SESSION['loginuser'])){
		$sql1 = "SELECT * FROM user where Email like '".$_POST['email']."'";
		$sql2 = "SELECT * FROM user where PhoneNumber like '".$_POST['email']."'";
		$sql3 =	"SELECT * FROM user where PassWord like '".$_POST['userpass']."'";
		$query1 = mysqli_query($conn, $sql1)or die("khong the truy van 3");
		$query2 =	mysqli_query($conn, $sql2)or die("khong the truy van 4");
		$query3 =	mysqli_query($conn, $sql3)or die("khong the truy van 5");
		$row = mysqli_num_rows($query1);
		$row2 = mysqli_num_rows($query2);
		$row3 = mysqli_num_rows($query3);
		$row4 = mysqli_fetch_array($query3);
		if($row==1 || $row2==1){
			if($row3==1){
				$_SESSION['loginuser']=$row4['UserName'];
				header('location: customer.php');exit();
			}
			else{
				$_SESSION['success']="Sai mật khẩu";
			}
		}
		else{
			$_SESSION['success']="Sai Email hoặc số điện thoại";
		}
	}
	if(isset($_SESSION['loginuser'])){
		header('location: customer.php');exit();
	}
?>
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.7.0/css/all.css' integrity='sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ' crossorigin='anonymous'>
<style type="text/css">
	#login form input{
		width: 500px;	
	}
	#login span i{
		height: 30px;
		width: 30px;
		text-align: center;
		font-size: 25px;
	}
</style>
<div id="login">
	<form method="post" action="login.php">
		<span><i class="fas fa-envelope	"></i></span>
		<input type="text" name="email" placeholder="Email hoặc số điện thoại"><br>
		<span><i class="fas fa-lock"></i></span>
		<input type="text" name="userpass" placeholder="Mật khẩu"><br>
		<?php if (isset($_SESSION['success'])) :?>
			<p class="btn btn-danger"><?= $_SESSION['success'] ?></p><br>
		<?php endif ; unset($_SESSION['success']) ?>
		<br><input type="submit" name="login" value="Đăng nhập" class="btn btn-success">
	</form>
</div>
