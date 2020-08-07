<?php 
	include 'connect.php';
?>
<div align="center">
	<h3>Thêm slider</h3>
	<form action="#" method="post" enctype="multipart/form-data" >
		<label for="pro">Mã sản phẩm: </label>
		<input type="number" name="productID" id="pro" class="form-control" style="width: 280px;"><br>
		<input type="file" name="slider_image" id="chonanh" style="padding-bottom: 50px;"><br>
		<input type="submit" name="submit" value="Thêm slider" class="btn btn-success" style="width: 280px;" >
	</form>
	<p>Bạn có thế lấy mã qua <a href="dashboard.php" target="_blank">đây</a></p>
	<?php
		if(isset($_POST['submit'])){
			$productID=$_POST['productID'];
			$sql1="SELECT * FROM product where ProductID = $productID";
			$query1=mysqli_query($conn, $sql1);
			$dem=mysqli_num_rows($query1);
			if($dem==1){
				$strfile='slider_image';
				$strpath='banner_image./';
				$ketqua="";
				if(isset($_FILES[$strfile]))
				{
					if ($_FILES[$strfile]['error']== UPLOAD_ERR_OK) {
						$name = $_FILES[$strfile]['name'];
						if(move_uploaded_file($_FILES[$strfile]['tmp_name'], $strpath.$name))
							$ketqua="Ok";
						else
							$ketqua="Không di chuyển được file";
					}else
					$ketqua="File bị lỗi";
				}else
				$ketqua= "Không tồn tại file upload";
				$image=$_FILES[$strfile]['name'];
				$sql= "INSERT INTO slider
					(
					SliderLink,
					ProductID,
					SliderImage
					)
					VALUES
					(
					'detail_product.php?detail=$productID','$productID','$image'
					)";
				$query= mysqli_query($conn, $sql) or die("khong the truy van");
				$_SESSION['success']="Thêm slider thành công";
			}
		else{
				echo "Mã sản phẩm không tồn tại";
			}
		}
	?>
	<?php if(isset($_SESSION['success'])) : ?>
	<br><div align="center">
		<p><?= $_SESSION['success'] ?></p>
		<a href="dashboard.php?slider=yes">Quay lại</a>
	</div>
	<?php endif ;unset($_SESSION['success']);	 ?>
</div>