<?php
	ob_start();
	// if (!isset($_SESSION['ckadmin'])) {
	// 	session_destroy();
	// 	header('Location: login_admin.php');exit(); }
	if(!isset($_GET['pr'])){
		header('location: dasdboard.php');exit();
	}
	include 'connect.php';
	$sql1="SELECT * FROM producer";
	$query2=mysqli_query($conn, $sql1) or die('khong the truy van 2');
	$sql3="SELECT * FROM categoris";
	$query3=mysqli_query($conn, $sql3) or die('khong the truy van 3');
?>
<!doctype html>
<html>
<head>	
<meta charset="utf-8">
<link href="admin.css" rel="stylesheet">
<script src="ckeditor/ckeditor.js"></script>
<title>Untitled Document</title>
</head>
<body>	
	<div id='AddProduct'>
		<form	action="#" method="post" enctype="multipart/form-data">
			<input type="file" name='taptin' id="chonanh" style="padding-bottom: 50px;">
			<div>
			<div class="p-3 p-lg-5 border">
                <div class="form-group row">
                 <div class="col-md-6">
				<label>Tên sản phẩm: </label>
				<input type="text" name="product_name" id="textbox" class="form-control"></div>
				<div class="col-md-6">
				<label>Nhà cung cấp: </lable>
					<select name="producer" class="form-control">
						<?php
							$tam=0;
							while ($row2=mysqli_fetch_array($query2)) {
									if($tam==0) $tam=$row2['ProducerID'];?>
									<option value="<?php echo $row2['ProducerID']; ?>" 
									   <?php if(isset($_POST['ProducerID']) && $_POST['ProducerID']==$row2['ProducerID'])
										  echo "selected='selected'"; ?> > 
									<?php echo $row2['ProducerName']; ?></option>
						<?php }
						?>
					</select></div>
					<div class="col-md-6">
					<label>Loại sản phẩm: </lable>
					<select name="categoris" class="form-control">
						<?php
							$tam=0;
							while ($row3=mysqli_fetch_array($query3)) {
									if($tam==0) $tam=$row3['CategoryID'];?>
									<option value="<?php echo $row3['CategoryID']; ?>" 
									   <?php if(isset($_POST['CategoryID']) && $_POST['CategoryID']==$row3['CategoryID'])
										  echo "selected='selected'"; ?> > 
									<?php echo $row3['CategoryName']; ?></option>
						<?php }
						?>
					</select>
					</div>
				<div class="col-md-6">
				<label>Số lượng: </label>
				<input type="number" name="quantity" id="textbox" class="form-control"></div>
				<div class="col-md-6">
				<label>Giá Sản Phẩm: </label>
				<input type="number" name="unitprice" id="textbox" class="form-control"></div>
				<div class="col-md-6">
				<label>Phần trăm khuyến mãi: </label>
				<input type="number" name="promotion" id="textbox" class="form-control"></div>
				<div class="col-md-6">
				<label for="ckeditor">Mô tả sản phẩm</label>
				<textarea name="image_text" id="ckeditor" rows="10" cols="80" placeholder="Thong tin san pham" class="form-control"></textarea></div>
			</div><br>
			<input type="submit" name="submit" value="tải lên" style="width: 200px; height: 50px;font-size: 20px; margin-left: 120px;" class="btn btn-success">
		</form>
	<?php
		$strfile='taptin';
		$strpath='product_image./';
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
	?>
<?php
	if(isset($_POST['submit'])){
		$ketqua;
		$image=$_FILES[$strfile]['name'];
		$image_text=$_POST['image_text'];
		$product_name=$_POST['product_name'];
		$producer=$_POST['producer'];
		$quantity=$_POST['quantity'];
		$unitprice=$_POST['unitprice'];
		$promotion=$_POST['promotion'];
		$categoris = $_POST['categoris'];
		$sql= "INSERT INTO product
				(
				ProductName,
				ProductImage,
				ProductI4,
				ProducerID,
				Quantity,
				UnitPrice,
				Promotion,
				CategoryID
				)
				VALUES
				(
				'$product_name','$image','$image_text','$producer','$quantity','$unitprice','$promotion','$categoris'
				)";
		$query= mysqli_query($conn, $sql) or die("khong the truy van");
		$_SESSION['thongbao']="Thêm mới thành công!";
		header('location:dashboard.php');
	}
//	else echo "ban chua chon file";
	?>
	</div>
	<?php
            if(isset($_SESSION['success'])) :?>
                    <p style="margin-top: -830px;"><?= $_SESSION['success'] ?>, <a href="dashboard.php">Quay lại</a></p>
            <?php endif ;unset($_SESSION['success']); ?>
	<script>
		CKEDITOR.replace( 'image_text' );
	</script>
</body>
</<html>