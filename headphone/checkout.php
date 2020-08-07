<?php
	session_start();
	// session_destroy();
	include 'menu.php';
	// include 'banner.php';

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

		if(isset($_POST['update'])){
			foreach ($_POST['updatesl'] as $key => $value) {
				$_SESSION['cart'][$key]['Quantity']=$value;
			}
			header('location: shoping_cart.php');exit();
		}
?>
<?php
	$sqltp = "SELECT * FROM devvn_tinhthanhpho";
	$quetytp = mysqli_query($conn, $sqltp);
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
<script src="ajax.js" type="text/javascript"></script>
<style type="text/css">
	*{
		margin: 0px;
		padding: 0px;
	}
	#checkout{
		float: left;
		/*margin-left: 170px; ;*/
	}
	#checkout form input{
		width: 500px;
		margin-bottom: 20px;
		height: 40px;
		border-radius: 7px;
		border: 1px solid black;
		padding: 10px;  
	}
	#checkout form select{
		width: 164px;
		margin-bottom: 20px;
		height: 40px;
		border-radius: 7px;
		border: 1px solid black;
		/*padding: 10px;  */
	}
	#coproduct table{
		float: left;
		width: 550px;
		background-color: #EEEEEE;
	}
</style>
<div class="form-group" id="checkout" style="margin-left: 10px; margin-top: 30px;">
	<h1 align="center">Thông tin giao hàng</h1>
	<div>
		<?php if(!isset($_SESSION['loginuser'])) :?>
			<?php $_SESSION['checkout']="yes"; ?>
			<span style="margin-bottom: 5px;">Đăng nhập để theo giỏi tình trạng đơn hàng, <a href="login_user/login_user.php">Đăng nhập.</a></span><br>
			<p>Bạn chưa có tài khoản, <a href="regist.php">Đăng ký.</a></p>
		<?php endif ; ?>
		<?php if(isset($_SESSION['loginuser'])) :?>
			<p style="color: blue; font-size: 18px;" >Chào <?= $_SESSION['loginuser'] ?></p>
			<p style="color: red; font-size: 18px; text-decoration: underline;" >Hãy kiểm tra lại thông tin của ban!</p>
		<?php endif ; ?>
		<?php if(isset($_SESSION['thongbao'])) :?>
			<p class="btn btn-danger"><?= $_SESSION['thongbao'] ?></p>
		<?php endif ; unset($_SESSION['thongbao']); ?>
	</div>
	<?php
		if(isset($_SESSION['UserID'])){
			$UserID= $_SESSION['UserID'];
			$sql="SELECT * FROM user WHERE UserID = '".$UserID."'";
			$query = mysqli_query($conn, $sql);
			$row=mysqli_fetch_array($query); 
		}
	?>
	<form name="form" method="post" action="order_process.php">
		<input type="text" name="username" placeholder="Tên khách hàng" <?php if(isset($_SESSION['UserID'])) : ?>
			value="<?= $row['UserName'] ?>" <?php endif ; ?>
		><br>
		<input type="text" name="email" placeholder="Email" <?php if(isset($_SESSION['UserID'])) : ?>
			value="<?= $row['Email'] ?>" <?php endif ; ?>><br>
		<input type="text" name="phonenumber" placeholder="Số điện thoai" <?php if(isset($_SESSION['UserID'])) : ?>
			value="0<?= $row['PhoneNumber'] ?>" <?php endif ; ?>><br>
		<select name="city" class="city">
			<option value="">Thành phố</option>
			<?php while ($rowtp = mysqli_fetch_array($quetytp)) { ?>
				<option value="<?= $rowtp['matp'] ?>"><?= $rowtp['name'] ?></option>
			<?php } ?>
		</select>
		<select name="district" class="district">
			<option value="">Quận huyện</option>
		</select>
		<select name="wards" class="wards">
			<option value="">Phường xã</option>
		</select><br>
		<input type="text" name="address" placeholder="Số nhà - tên đường" 
		<?php if(isset($_SESSION['UserID'])) : ?>
			value="<?= $row['Address'] ?>" <?php endif ; ?> ><br>
		<br><label>Phương thức thanh toán:</label>
		<h4>Thanh toán khi nhận hàng (COD)</h4>
		<input type="submit" name="order" value="Hoàn tất đơn hàng" class="btn btn-success" style="font-size: 28px; padding-top: 0px;
		border: none; height: 45px;" >
	</form>
</div>
<div id="coproduct">
	<?php if(isset($_SESSION['cart'])) : ?>
		<table class="table" style="width: 700px; margin-left: 15px; margin-top: 30px;">
				<?php $total=0; foreach ($_SESSION['cart'] as $key => $value) : ?>
					<tr>
						<td><?php echo "<img src='../admin1/product_image/".$value['ProductImage']."' style='width: 70px; height: 70px;'>"; ?></td>
						<td><?= $value['ProductName'] ?></td>
						<td><?= $value['Quantity'] ?></td>
						<td><?= adddotstring(Promotion($value['UnitPrice']*$value['Quantity'],$value['Promotion'])) ?></td>
						<td><?php if($value['Promotion']>0) echo "Đã giảm".$value['Promotion']."%"; ?></td>
						<?php $total+=Promotion($value['UnitPrice']*$value['Quantity'],$value['Promotion'])?>
					</tr>
				<?php endforeach ; ?>
			<tr>
				<th colspan="2">Tạm tính:</th>
				<th colspan="2"><?= adddotstring($total) ?></th>
			</tr>
			<tr>
				<th colspan="2">Phí vận chuyển:</th>
				<th colspan="2"><?= adddotstring(40000) ?></th>
			</tr>
			<tr>
				<th colspan="2">Thành tiền:</th>
				<th colspan="2"><?= adddotstring($total+40000) ?></th>
			</tr>
		</table>
	<?php else :  ?>
		<p align="center" style="margin-top: 50px;">Bạn chưa có sản phẩm nào để mua!, <a href="index.php">Quay lại trang chủ.</a></p>
	<?php endif ; ?>
</div>
<div>
	<?php
		include 'footer.php';
	?>
</div>