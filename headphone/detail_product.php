<!doctype html>
<?php
	session_start();
	// session_destroy();
	include 'connect.php';	
	mysqli_query($conn,"SET NAMES 'utf8'");

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
			return adddotstring($result);
		}
?>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
<link href="display_product.css" rel="stylesheet">
</style>
<title>Untitled Document</title>
</head>

<body <?php if (isset($_SESSION['success'])) :?>
				onload = "alert('Sản phẩm đã được thêm vào giỏ hàng!')"
			<?php endif ; unset($_SESSION['success']) ?>>
	<div id="php_main">
		<div id="php_menu">
			<?php
				include 'menu.php';
			?>
		</div>
		<?php
		$ProductID=$_GET['detail'];
		$sql = "SELECT * from product where ProductID =".$ProductID;
		$query = mysqli_query($conn,$sql) or die('khong the truy van');
		$row = mysqli_fetch_array($query);
		$product_image=$row['ProductImage'];
		$product_name=$row['ProductName'];
		$product_i4=$row['ProductI4'];
		$unitprice=$row['UnitPrice'];
		$Promotion=$row['Promotion'];
		$Quantitydf = $row['Quantity'];
		?>
		<div id="php_banner">
			<?php
				include 'banner.php';
			?>
		</div>
		<div id="php_content">
			<div id="detail_pr_left">
				<?php
					if(isset($_GET['detail'])){
						echo "<img src='../admin1/product_image/".$product_image."'>";
					}
				?>
			</div>
			<div id="detail_pr_right">
				<?php
					if(isset($_GET['detail'])){?>
						<p style="color: black; font-size: 25px;"><?= $product_name ?></p>
						<p><?= $product_i4 ?></p>
						<?php 
							if($Quantitydf>0){?>
								<div>
								<span class='btn btn-danger' style="font-size: 20px;"><?= Promotion($unitprice, $Promotion) ?></span>
								<?php if ($Promotion>0) : ?>
									<span class="btn btn-warning" style="font-size: 20px;">-<?= $Promotion ?> %</span>
									<span style="font-size: 20px;text-decoration: line-through; color: gray; ma">
											<?= adddotstring($unitprice) ?></span>
									<?php endif ; ?>
							<?php }else{
								echo "<a class='btn btn-danger' style='color:white;' >Cháy hàng</a>";
							} ?></div>
					<?php }
				?>
			</div>
			<div id="detail_add_product" style="margin-top: 20px;" align="center" >
				<?php
				if($unitprice!=0 && $Quantitydf>0){
					echo "<a href='add_product_shoppingcart.php?prid=".$ProductID."' class='btn btn-info btn-lg '
					style='width: 250px; height: 50px; margin-right: 20px; font-size:20px;'>
						<span class='fas fa-cart-plus'></span> Thêm sản vào giỏ</a>";
					echo "<a href='add_product_shoppingcart.php?prID=".$ProductID."' class='btn btn-info btn-lg ' style='width: 250px; height: 50px; size:100px; font-size:20px;'> Mua ngay</a>";
				}
				?>
			</div>
		</div>
		<div id="php_footer">
			<?php
				include 'footer.php';
			?>
		</div>
	</div>
</body>
</html>