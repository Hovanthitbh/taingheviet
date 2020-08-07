<?php
	ob_start();
	include 'connect.php';
	$qr=mysqli_query($conn, "SELECT CategoryID FROM categoris")or die("khong the truy van3");
	$r=mysqli_num_rows($qr);
	$r++;
?>
<div align="center">
	<h3>Thêm Loại sản phẩm</h3><br><br>
	<form action="#" method="post">
		<label for="cateID">Mã loại</label>
		<input type="number" name="CategoryID" id="cateID" value="<?= $r ?>" min="<?= $r ?>" class="form-control"style="width: 200px;" ><br>
		<label for="cateName">Tên loại</label>
		<input type="text" name="CategoryName" id="cateName" class="form-control" style="width: 200px;" ><br>
		<input type="submit" name="submit" value="Thêm" class="btn btn-success" style="width: 200px;" >
	</form>
</div>
<?php
	if(isset($_POST['submit'])){
		$CategoryID=$_POST['CategoryID'];
		$CategoryName=$_POST['CategoryName'];
		$sql="SELECT * FROM categoris WHERE CategoryID = '".$CategoryID."'";
		$query=mysqli_query($conn, $sql)or die("khong the truy van");
		$row= mysqli_num_rows($query);
		if($row!=1){
			$sql1="INSERT INTO categoris ( CategoryID, CategoryName ) VALUE('$CategoryID','$CategoryName')";
			$query1=mysqli_query($conn,$sql1)or die("khong the truy van 2");
			$_SESSION['thongbao']="Thêm thành công";
			header('location: dashboard.php?cate=yes');
		}
		else{
			$_SESSION['success']="Mã loại đã được sử dụng";
		}
	}
?>
<?php if(isset($_SESSION['success'])) : ?>
	<br><div align="center">
		<p><?= $_SESSION['success'] ?></p>
		<a href="dashboard.php?cate=yes">Quay lại</a>
	</div>
	<?php endif ;unset($_SESSION['success']);	 ?>