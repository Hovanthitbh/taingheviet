<?php
	session_start();
	// session_destroy();
?>

<!doctype html>
<?php
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
			header('location: shopping_cart.php');exit();
		}
?>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="css/bootstrap.min.css">
<link href="display_product.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
	<div id="php_main">
		<div id="php_menu">
			<?php
				include 'menu.php';
			?>
		</div>
		<div id="php_banner">
			<?php
				// include 'banner.php';
			?>
		</div>
		<div id="php_content">
			<?php if (isset($_SESSION['success'])) :?>
				<p><?= $_SESSION['success'] ?></p>
			<?php endif ; unset($_SESSION['success']) ?>
			<?php if(isset($_SESSION['cart'])) : ?>
				<table class="table">
					<thead>
						<tr>
							<th>STT</th>
							<th>Hình ảnh</th>
							<th>Tên sản phẩm</th>	
							<th>Số lượng</th>
							<th>Giá</th>
							<th></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php $i=1; $total=0; foreach ($_SESSION['cart'] as $key => $value) : ?>
							<tr><form name="fupdatesl" method="post" action="shopping_cart.php" >
								<td><?= $i ?></td>
								<td><?php echo "<img src='../admin1/product_image/".$value['ProductImage']."' style='width: 100px; height: 100px;'>"; ?></td>
								<td><?= $value['ProductName'] ?></td>
								<td><input type="number" name="updatesl[<?php echo $key; ?>]" value="<?= $value['Quantity']?>" class="form-control" min="1" max="<?= $value['QuantityDF'] ?>"
									style="width:100px; " >
								</td>
								<td><?= adddotstring(Promotion($value['UnitPrice']*$value['Quantity'], $value['Promotion'])) ?></td>
								<td><input type="submit" name="update" class="btn btn-info" value="Cập nhập"></td> 
								<td><a href="remove.php?key=<?= $key ?>" class="fa fa-trash btn btn-danger" 
									style="width: 50px; height: 50px; text-align: center; font-size: 25px;" ></a></td>
								<?php $i++; $total+=Promotion($value['UnitPrice']*$value['Quantity'], $value['Promotion']);
										@$sl+=$value['Quantity']; ?>
							</tr>
						<?php endforeach ; ?>
					</tbody>
					<?php if(@$sl>=1) { ?><tr>
						<th colspan="4">Tổng tiền:</th>
						<th><?= adddotstring($total) ?></th>
						<th colspan="2"><a href="checkout.php" class="btn btn-success">Bắt đầu mua hàng</a></th>
					</tr><?php }else { ?>
						<p  align="center">Bản đã xóa hết sản phẩm trong giỏ hàng<a href="index.php">, đi chọn sản phẩm khác nào.</a></p><?php } ?>
				</table></form>
			<?php else : ?>
				<p  align="center">Bản chưa thêm sản phẩm nào vảo giỏ hàng<a href="index.php">, đi chọn sản phẩm nào.</a></p>
			<?php endif; ?>	
		</div>	
		<div id="php_footer">
			<?php
				include 'footer.php';
			?>
		</div>					
	</div>
</body>
</html>