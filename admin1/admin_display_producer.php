<?php
	include 'connect.php';
	$sql="SELECT * FROM producer";
	$query= mysqli_query($conn, $sql)or die("khong the truy van");
	if (isset($_GET['deletecproducer'])) {
		$id_delete= $_GET['deletecproducer'];
		$sql3 = "DELETE from product where ProducerID =".$id_delete;
		$query3 = mysqli_query($conn, $sql3);
		$sql2="DELETE from producer where ProducerID =".$id_delete;	
		$query2=mysqli_query($conn,$sql2);
		$_SESSION['thongbao']="Xoa thanh cong";
		header('location: dashboard.php?producer=yes');
	}
?>
<link rel="stylesheet" href="css/bootstrap.min.css">
<body <?php if(isset($_SESSION['thongbao'])) : ?> onload="alert('<?= $_SESSION['thongbao'] ?>')" <?php unset($_SESSION['thongbao']); endif ; ?>  >
<div> 
	<a href="dashboard.php?addproducer=yes" class="btn btn success" style="color: red;">Thêm loại hãng cung cấp	</a>
	<?php if(isset($_SESSION['success'])) :?>
		<p><?php  echo $_SESSION['success'];die(); ?></p>
	<?php endif ;unset($_SESSION['success']); ?>
	<table class="table">
		<tr>
			<th>Mã loại</th>
			<th>Tên loại</th>
			<th>Xóa</th>
			<th>Sửa</th>
		</tr>
		<?php
			while ($row=mysqli_fetch_array($query)) { ?>
				<tr>
					<td><?= $row['ProducerID'] ?></td>
					<td><?= $row['ProducerName'] ?></td>
					<td><a href="admin_display_producer.php?deletecproducer=<?= $row['ProducerID'] ?>" onclick="return confirm('Xóa hết sản phẩm thuộc hãng này!\nBạn chắc chứ?')" class="fa fa-trash btn btn-danger"></a></td>
					<td><a href="admin_alter_producer.php?alterproducer=<?= $row['ProducerID'] ?>" class="fa fa-cogs btn btn-warning"></a></td>
				</tr>	
		<?php	}
		?>
	</table>
</div>
</body>