<?php
	ob_start();
	include 'connect.php';
	$qr=mysqli_query($conn, "SELECT ProducerID FROM producer")or die("khong the truy van3");
	$r=mysqli_num_rows($qr);
	$r=$r+2;
?>
<div align="center">
	<h3>Thêm hãng sản xuất</h3>
	<?php if(isset($_SESSION['success'])) : ?>
		<p><?= $_SESSION['success'] ?></p>
	<?php endif ; unset($_SESSION['success']); ?>
	<form action="#" method="post">
		<label for="proID">Mã loại</label>
		<input type="number" name="ProducerID" id="proID" value="<?= $r ?>" min="<?= $r ?>" class="form-control" style="width: 200px;"><br>
		<label>Loại sản phẩm: </lable>
					<select name="categoris" class="form-control">
						<?php
							$sql3="SELECT * FROM categoris";
							$query3=mysqli_query($conn, $sql3) or die('khong the truy van 3');
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
		<label for="ProName">Tên loại</label>
		<input type="text" name="ProducerName" id="ProName" class="form-control" style="width: 200px;"><br>
		<input type="submit" name="submit" value="Thêm" class="btn btn-success" style="width: 200px;">
	</form>
</div>
<?php
	if(isset($_POST['submit'])){
		$ProducerID=$_POST['ProducerID'];
		$ProducerName=$_POST['ProducerName'];
		$CategoryID = $_POST['categoris'];
		$sql="SELECT * FROM producer WHERE ProducerID = '".$ProducerID."'";
		$query=mysqli_query($conn, $sql)or die("khong the truy van");
		$row= mysqli_num_rows($query);
		if($row!=1){
			$sql1="INSERT INTO producer ( ProducerID, ProducerName, CategoryID ) VALUE('$ProducerID','$ProducerName','$CategoryID')";
			$query1=mysqli_query($conn,$sql1)or die("khong the truy van 2");
			$_SESSION['thongbao']="Thêm thành công";
			header('location:dashboard.php?producer=yes');
		}
		else{
			$_SESSION['success']="Mã Hãng đã được sử dụng";
		}
	}
?>
<?php if(isset($_SESSION['success'])) : ?>
	<br><div align="center">
		<p><?= $_SESSION['success'] ?></p>
		<a href="dashboard.php?producer=yes">Quay lại</a>
	</div>
	<?php endif ;unset($_SESSION['success']);	 ?>