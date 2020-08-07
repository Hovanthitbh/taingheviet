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
<?php
	if(isset($_POST['submit'])){
		$email = $_POST['email'];
		$phonenumber = $_POST['phonenumber'];
		$customername = $_POST['customername'];
		$customeraddress = $_POST['customeraddress'];
		$billid = $_GET['billid']; 
		if(!empty($_POST['email']) && !empty($_POST['phonenumber']) && !empty($_POST['customername']) && !empty($_POST['customeraddress']) ){
			$sql = "UPDATE bill SET Email = '$email',PhoneNumber = '$phonenumber',CustomerName = '$customername',
			CustomerAddress = '$customeraddress' WHERE BillID = '$billid'";
			$query = mysqli_query($conn, $sql);
			$_SESSION['thongbao'] = "Thông tin giao hàng đã được cập nhập";
		}
		else{
			$_SESSION['thongbao'] = "Không được bỏ trống";
		}
	}
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
<body <?php if(isset($_SESSION['thongbao'])) : ?> onload="alert('<?= $_SESSION['thongbao'] ?>')" <?php endif ; unset($_SESSION['thongbao']); ?> >
<?php include 'menu.php'; ?>
<div id="logout_admin"  style="float: right; margin-right: 100px;">
	<a href="customer.php"class="btn btn-success" style="height: 33px;">Quay lại</a>
	<a href="customer.php?user=yes"class="btn btn-info" style="height: 33px;">Thông tin cá nhân</a>
	<a href="login_user/login_user.php?logout=yes"class="btn btn-danger" style="height: 33px;">Đăng xuất</a>
</div><br><br>
<div style="clear: all;">
	<?php if(isset($_GET['billid'])){
                $BillID = $_GET['billid'];
                $sql = "SELECT orderdetail.BillID, product.ProductName , product.ProductImage, bill.Status, orderdetail.Quantity, orderdetail.UnitPrice, bill.UserID, orderdetail.Promotion, bill.TimeOrder FROM ((orderdetail
                        INNER JOIN product ON orderdetail.ProductID = product.ProductID)
                        INNER JOIN bill ON orderdetail.BillID = bill.BillID)
                        WHERE orderdetail.BillID = '".$BillID."'";
                $query = mysqli_query($conn, $sql) or die("khong the truy van");
            } ?>
            <h2 align="center">Đơn hàng</h2>
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
                        <td><img src="../admin1/product_image/<?= $row['ProductImage'] ?>" style="height: 100px; width: 100px;"></td>
                        <td><?= $row['Quantity'] ?></td>
                        <td><?= adddotstring(Promotion($row['UnitPrice'], $row['Promotion'])) ?></td>
                        <?php if($row['Promotion']>0) : ?><td>Đã giảm <?= $row['Promotion'] ?>%</td><?php endif ;?>
                    </tr>
                <?php $t=$t + Promotion($row['UnitPrice'], $row['Promotion']); $date=$row['TimeOrder']; $st = $row['Status']; } ?>
                    <tr style="font-size: 20px;">
                        <th colspan="3">Tổng tiền hóa đơn</th>
                        <th><?= adddotstring($t) ?></th>
                    </tr>
                    <tr style="font-size: 20px;">
                        <th colspan="3">Thời gian đặt hàng</th>
                        <th><?= $date ?></th>
                    </tr>
                    <tr>
                    	<th colspan="3">Tình trạng đơn hàng</th>
                        <th  <?php 
								if($st==1){
									echo "class='btn btn-danger'";
								}
								if($st==2){
									echo "class='btn btn-info'";
								}
								if($st==3){
									echo "class='btn btn-warning'";
								}
								if($st==4){
									echo "class='btn btn-success'";
								}
								?>><?= status($st) ?></th>
                    </tr>
            </table>
            <h2 align="center">Thông tin giao hàng</h2>
            <?php
                if(isset($_GET['billid'])){
                    $BillID = $_GET['billid'];
                    $sql1 = "SELECT * FROM bill WHERE BillID like '".$BillID."'";
                    $query1 = mysqli_query($conn, $sql1) or die("khong the truy van 1");
            } ?>
            <?php if(!isset($_GET['update'])) { ?>
            <table class="table">
                <tr>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                    <th>Tên</th>
                    <th>Địa chỉ giao hàng</th>
                    <!-- <?php if($st ==1 || $st==2) :?><th>Sửa</th><?php endif ; ?> -->
                </tr>
                <?php while ($row=mysqli_fetch_array($query1)) { ?>
                    <tr>
                        <td><?= $row['Email'] ?></td>
                        <td>0<?= $row['PhoneNumber'] ?></td>
                        <td><?= $row['CustomerName'] ?></td>
                        <td><?= $row['CustomerAddress'] ?></td>
                        <?php if($st ==1 || $st==2) :?><th><a href="customer_detail.php?billid=<?= $BillID ?>&update=yes">Sửa</a></th><?php endif ; ?>
                    </tr>
                <?php } ?>
            </table>
        <?php } else { ?>
        	<table class="table">
        		<form action="#" method="post">
	                <tr>
	                    <th>Email</th>
	                    <th>Số điện thoại</th>
	                    <th>Tên</th>
	                    <th>Địa chỉ giao hàng</th>
	                    <!-- <?php if($st ==1 || $st==2) :?><th>Sửa</th><?php endif ; ?> -->
	                </tr>
	                <?php while ($row=mysqli_fetch_array($query1)) { ?>
	                    <tr>
	                        <td><input class="form-control" type="text" name="email" value="<?= $row['Email'] ?>"></td>
	                        <td><input class="form-control" type="number" name="phonenumber" value="0<?= $row['PhoneNumber'] ?>"></td>
	                        <td><input class="form-control" type="text" name="customername" value="<?= $row['CustomerName'] ?>"></td>
	                        <td><input class="form-control" type="text" name="customeraddress" value="<?= $row['CustomerAddress'] ?>"></td>
	                        <td><input class="form-control btn btn-success" type="submit" name="submit" value="Cập nhật"></td>
	                    </tr>
	                <?php } ?>
                </form>
            </table>
        <?php } ?>
</div>
<?php
	include 'footer.php';
?>
</body>