<?php
	ob_start();
	session_start();
	// session_destroy();
	// include 'banner.php';
	include 'menu.php';
	include 'connect.php';
?>
<?php
	if(isset($_POST['regist'])){
		if($_POST['name']!=null && $_POST['email']!=null && $_POST['phonenumber']!=null && $_POST['address']!=null && $_POST['pass']!=null){
			$sql1 = "SELECT * FROM user where Email like '".$_POST['email']."'";
			$sql2 = "SELECT * FROM user where PhoneNumber like '".$_POST['phonenumber']."'";
			$query1 = mysqli_query($conn, $sql1)or die("khong the truy van 3");
			$query2 =	mysqli_query($conn, $sql2)or die("khong the truy van 4");
			$row = mysqli_num_rows($query1);
			$row2 = mysqli_num_rows($query2);
			if($row==1){
				$_SESSION['success']='Email đã được sử dụng';
				// header('location: regist.php');
			} 
			if($row2==1){
				$_SESSION['success']='Số điện thoại đã được sử dụng';
			}
			if($row==0 && $row2 ==0){
				$name=$_POST['name'];
				$email=$_POST['email'];
				$phonenumber=$_POST['phonenumber'];
				$address=$_POST['address'];
				$pass=$_POST['pass'];
				$time=date('Y/m/d');
				$sql="INSERT INTO user (UserName,PhoneNumber,Email,Address,PassWord,SignTime)VALUES('$name','$phonenumber','$email','$address','$pass','$time')";
				$query=mysqli_query($conn,$sql) or die("khong the truy van");
				$sql3 =	"SELECT * FROM user where PassWord like '".$pass."' AND (Email like '".$email."' or 
					PhoneNumber like '".$phonenumber."')";
				$query3=mysqli_query($conn,$sql3) or die("khong the truy van 2");
				$row3 = mysqli_fetch_array($query3);
				$_SESSION['loginuser']=$name;
				$_SESSION['UserID']=$row3['UserID'];
				$_SESSION['dangkythanhcong'] ="thi"; 
				if(isset($_SESSION['checkout'])){
					header('location:checkout.php');
				}else{
					header('location:customer.php');
				}
			}
		}
		else{
			$_SESSION['success']='Vui lòng điền đầy đủ thông tin';exit();
		}
	}
?>
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.7.0/css/all.css' integrity='sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ' crossorigin='anonymous'>
<style type="text/css">
	#regist{
		border: 1px solid gray;
		width: 600px;
		padding: 15px;
		border-radius: 10px; 
		background-color: #e5e5e5;
	}
	#regist form input{
		width: 500px;	
		border-radius: 5px;
		border: 1px solid gray;
		height: 35px;
		margin-bottom: 10px;
		padding-left: 10px;
	}
	#regist button{
		width: 200px;
		margin-bottom: 20px;

	}
	#regist span i{
		/*margin-top: 10px;*/
		color: #7f0000;
		height: 35px;
		width: 35px;
		text-align: center;
		font-size: 30px;
	}
</style>
<div align="center">
<div id="regist" align="center">
	<?php if(isset($_SESSION['dangkythanhcong'])) { ?>
		<p>Đăng ký thành công<a href="checkout.php">, quay lại mua hàng</a></p>
	<?php } unset($_SESSION['dangkythanhcong']); ?>
	<form name="form" method="post" action="regist.php">
		<h3>Tạo tài khoản</h3>
		<span><i class="fas fa-address-card	"></i></span>
		<input type="text" name="name" placeholder="Nhập họ và tên"><br>
		<span><i class="fas fa-phone-square"></i></span>
		<input type="text" name="phonenumber" id="em" placeholder="Nhập số điện thoại"><br>
		<span><i class="fas fa-envelope"></i></span>
		<input type="text" name="email" id="em" placeholder="Nhập Email"><br>
		<span><i class="fas fa-map"></i></span>
		<input type="text" name="address" id="em" placeholder="Địa chỉ nhà"><br>
		<span><i class="fa fa-lock"></i></span>
		<input type="password" name="pass" id="pas" placeholder="Nhập mật khẩu"><br>
		<?php if (isset($_SESSION['success'])) :?>
			<p class="btn btn-danger"><?= $_SESSION['success'] ?></p><br>
		<?php endif ; unset($_SESSION['success']) ?>
		<button type="submit" name="regist" value="Đăng ký" class="btn btn-success">Đăng ký</button>
	</form>
	<span>Bạn đã có tài khoản, <a href="login_user/login_user.php">Đăng nhập</a></span>
</div>
</div>
<div>
	<?php
		include 'footer.php';
	?>
</div>