<?php
	ob_start();
?>

<?php
	session_start();
	// session_destroy();
	// include 'banner.php';
	// include 'menu.php';
	include 'connect.php';
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
		if(isset($_POST['update'])){
			foreach ($_POST['updatesl'] as $key => $value) {
				$_SESSION['cart'][$key]['Quantity']=$value;
			}
			header('location: shoping_cart.php');exit();
		}
		function status($status){
			if($status==1){
				$result="Đang xác nhận"; 
			}
			if($status==2){
				$result="Đang đóng gói"; 
			}
			if($status==3){
				$result="Đang giao hàng"; 
			}
			if($status==4){
				$result="Đã giao hàng"; 
			}
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
	if(!isset($_SESSION['loginuser'])){
		header('location: login_user/login_user.php');
	}
	if (isset($_GET['delete'])) {
		$id = $_GET['delete'];
		$sql2 = "UPDATE orderdetail SET hiden = '1' WHERE BillID = $id";
		$query2 = mysqli_query($conn, $sql2);
	}
	if (isset($_GET['dropb']) && isset($_GET['dropp'])) {
		$idb = $_GET['dropb'];
		$idp = $_GET['dropp'];
		$sql4 = "SELECT * FROM orderdetail WHERE BillID = $idb AND ProductID = $idp ";
		$query4 = mysqli_query($conn, $sql4);
		$row4 =  mysqli_fetch_array($query4);
		$Quantity = $row4['Quantity'];
		$ProductID = $row4['ProductID'];
		$sql5 = "UPDATE product SET Quantity = Quantity + '$Quantity' WHERE ProductID = '$ProductID'" ;
		$query5 = mysqli_query($conn, $sql5);
		$sql2 = "DELETE FROM orderdetail WHERE BillID = $idb AND ProductID = $idp";
		$sql6 = "SELECT * FROM orderdetail WHERE BillID = $idb";
		$query2 = mysqli_query($conn, $sql2);
		$query6 = mysqli_query($conn, $sql6);
		$num6 = mysqli_num_rows($query6);
		if($num6==0){
			$sql3 = "DELETE FROM bill WHERE BillID = $idb";
			$query3 = mysqli_query($conn, $sql3);
		}
	}
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
<body <?php if(isset($_SESSION['thongbao'])) : ?> onload="alert('<?= $_SESSION['thongbao'] ?>')" <?php endif ; unset($_SESSION['thongbao']); ?>>
<?php include 'menu.php'; ?>
<div id="logout_admin"  style="float: right; margin-right: 100px;">
	<?php if(isset($_GET['user'])) : ?><a href="customer.php"class="btn btn-success" style="height: 33px;">Quay lại</a><?php endif ; ?>
	<a href="customer.php?user=yes"class="btn btn-info" style="height: 33px;">Thông tin cá nhân</a>
	<a href="login_user/login_user.php?logout=yes"class="btn btn-danger" style="height: 33px;">Đăng xuất</a>
</div><br><br>
<?php
	if(isset($_POST['updateuser'])){
		$userid = $_SESSION['UserID'];
		$username = $_POST['username'];
		$phonenumber = $_POST['phonenumber'];
		$email = $_POST['email'];
		$address = $_POST['address'];
		if(!empty($username) && !empty($phonenumber) && !empty($email) && !empty($address)){
			$sql = "UPDATE user SET UserName = '$username', PhoneNumber = '$phonenumber', Email = '$email', Address = '$address' 
			WHERE UserID = '$userid'";
			$query = mysqli_query($conn, $sql) or die("khong the truy van");
			$_SESSION['thongbao'] = "Cap nhap thong tin thanh cong"; 
			header('location: customer.php?user=yes');
		}
		else{
			$_SESSION['thongbao'] = "Khong duoc bo trong"; 	
			header('location: customer.php?user=yes');
		}
	}
	if(isset($_POST['udpass'])){
		if(!empty($_POST['newpass']) && !empty($_POST['repass']) && !empty($_POST['oldpass'])){
			$newpass = $_POST['newpass'];
			$repass = $_POST['repass'];
			$oldpass = $_POST['oldpass'];
			if($newpass == $repass){
				$UserID = $_SESSION['UserID'];
				$sql = "SELECT PassWord FROM user WHERE UserID = '$UserID'";
				$query = mysqli_query($conn, $sql)or die("khong the truy van pass");
				$row = mysqli_fetch_array($query);
				if($oldpass == $row['PassWord']){
					echo $sql1 = "UPDATE user SET PassWord = '$newpass' WHERE UserID = '$UserID'";
					$query1 = mysqli_query($conn, $sql1) or die("khong the truy van pass 1");
					echo $_SESSION['thongbao'] = "Thay đổi mật khẩu thành công";
					header('location: customer.php?user=yes&udpass=yes');

				}
				else{
					$_SESSION['thongbao'] = "Sai mật khẩu cũ";
					header('location: customer.php?user=yes&udpass=yes');	
				}
			}
			else{
				$_SESSION['thongbao'] = "Mật khẩu không khớp";
				header('location: customer.php?user=yes&udpass=yes');
			}
		}
		else{
			$_SESSION['thongbao'] = "Không được bỏ trống";
			header('location: customer.php?user=yes&udpass=yes');
		}
	}
?>
<div style="clear: all;">
	<?php
		if(isset($_SESSION['UserID']) && isset($_GET['user'])){
			$UserID = $_SESSION['UserID'];	
			$sql1 = "SELECT * FROM user WHERE UserID like '".$UserID."'";
			$query1 = mysqli_query($conn, $sql1) or die("khong the truy van 1");
			$row1 = mysqli_fetch_array($query1); ?>
			<div style="margin-left: 300px; padding-right:50px;  float: left; border-right: 1px solid gray;  ">
			<form action="#" method="post">
				<label>Họ và tên</label>
				<input class="form-control" style="width: 300px;" type="text" name="username" value="<?= $row1['UserName'] ?>">
				<label>Số điện thoại</label>
				<input class="form-control" style="width: 300px;" type="number" name="phonenumber" value="0<?= $row1['PhoneNumber'] ?>">
				<label>Email</label>
				<input class="form-control" style="width: 300px;" type="text" name="email" value="<?= $row1['Email'] ?>">
				<label>Địa chỉ</label>
				<input class="form-control" style="width: 300px;" type="text" name="address" value="<?= $row1['Address'] ?>"><br>
				<input type="submit" name="updateuser" value="Cập nhập" class="form-control btn btn-success">
			</form>
		</div>
		<style type="text/css">
					.repass input[type = "password"]{
						width: 200px;
						transition: 0.25s;
					}
					.repass input[type = "password"]:focus{
						width: 300px;
					}
					.repass input[type = "submit"]{
						width: 200px;
					}
				</style>
		<div class="repass" style="float: left; padding-left: 50px; width: 400px;" align="center">
			<?php if(!isset($_GET['udpass'])){ ?>
			<a href="customer.php?user=yes&udpass=yes" class="btn btn-warning" style="height: 30px;">Thay đổi mật khẩu</a>
			<?php }else { ?>
			<a href="customer.php?user=yes" class="btn btn-warning" style="height: 30px;"> Đóng</a>
			<?php } ?>
			<?php if(isset($_GET['udpass'])) :?>
				<form action="#" method="post">
					<br><input class="form-control" type="password" name="newpass" placeholder="Nhập mật khẩu mới"><br>
					<input class="form-control" type="password" name="repass" placeholder="Nhập lại mật khẩu mới"><br>
					<input class="form-control" type="password" name="oldpass" placeholder="Nhập mật khẩu cũ"><br>
					<input class="form-control btn-success" type="submit" name="udpass" value="Thay đổi">
				</form>
			<?php endif ; ?>
		</div>
		<?php } ?>
	<?php if(isset($_SESSION['UserID']) && !isset($_GET['user'])){
		$UserID = $_SESSION['UserID'];
		$sl="SELECT * FROM bill WHERE UserID = '".$UserID."'";
		$qr=mysqli_query($conn, $sl);
		$r=mysqli_num_rows($qr);
		if ($r == 0) {
			echo "bạn không có sản phẩm nào";
		}
		if($r>0){

						$sql = "SELECT orderdetail.hiden, product.ProductID,product.ProductName , product.ProductImage, bill.Status, orderdetail.Quantity, orderdetail.UnitPrice, orderdetail.Promotion,
						bill.BillID FROM ((orderdetail 
								INNER JOIN product ON product.ProductID = orderdetail.ProductID)
								INNER JOIN bill ON bill.BillID = orderdetail.BillID)
								WHERE UserID = '".$UserID."'";
						$query = mysqli_query($conn, $sql) or die("khong the truy van");
					} ?>
					<h2 align="center">Đơn hàng của bạn</h2>
					<table class="table" style="width: 100%;">
						<tr>
							<th>Tên sản phẩm</th>
							<th>Hình ảnh</th>
							<th>Số lượng</th>
							<th>Giá </th>
							<!-- <?php if($row['Promotion']>0) :?><th>Giảm giá</th><?php endif ; ?> -->
							<th>Tình trạng</th>
							<th>Thao tác</th>
						</tr>
						<?php while ($row=mysqli_fetch_array($query)) { ?>
							<tr>
								<?php if ($row['hiden']==0) { ?>
									<td><?= $row['ProductName'] ?><br><a href="customer_detail.php?billid=<?= $row['BillID'] ?>">( Xem chi tiết hóa đơn )</a></td>
									<td><img src="../admin1/product_image/<?= $row['ProductImage'] ?>" style="height: 100px; width: 100px;"></td>
									<td><?= $row['Quantity'] ?></td>
									<td><?= adddotstring(Promotion($row['UnitPrice'], $row['Promotion'])) ?>
										<?php if($row['Promotion']>0) :?><p>Đã giảm <?= $row['Promotion'] ?>%</p><?php endif ; ?>
									</td>
									<td><p <?php 
										if($row['Status']==1){
											echo "class='btn btn-danger'";
										}
										if($row['Status']==2){
											echo "class='btn btn-info'";
										}
										if($row['Status']==3){
											echo "class='btn btn-warning'";
										}
										if($row['Status']==4){
											echo "class='btn btn-success'";
										}
										?> style="height: 33px;" ><?= status($row['Status']) ?></p></td>
										<?php if($row['Status']==4 && $row['hiden']==0) {?><td><a href="customer.php?delete=<?= $row['BillID'] ?>" class="fa fa-trash btn btn-danger" style="height: 33px;"></a></td><?php } ?>
										<?php if($row['Status']==1) {?><td><a href="customer.php?dropb=<?= $row['BillID'] ?>&dropp=<?= $row['ProductID'] ?>" class="btn btn-danger" style="height: 33px;" onclick="return confirm('Bạn có chắc muốn hủy đơn hàng?')">Hủy đơn hàng
										</a></td><?php } ?>	
								<?php } ?>
							</tr>
						<?php $BillID = $row['BillID']; } ?>
					</table>
					<!-- <h2 align="center">Thông tin giao hàng của bạn</h2>
					<?php
						if(isset($_SESSION['UserID']) && isset($BillID)){
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
						<?php } 
		 ?> -->
	</table>
		<?php } ?>
</div>
<?php
	include 'footer.php';
?>
</body>