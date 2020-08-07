
<link rel="stylesheet" href="css/bootstrap.min.css">
<body <?php if(isset($_SESSION['thongbao'])) : ?> onload="alert('<?= $_SESSION['thongbao'] ?>')" <?php unset($_SESSION['thongbao']); endif ; ?> >
<div> 
	<?php
	include 'connect.php';
	$sql="SELECT * FROM categoris";
	$query= mysqli_query($conn, $sql)or die("khong the truy van");
	if (isset($_GET['deletecate'])) {
		$id_delete= $_GET['deletecate'];
		$sql3="DELETE from product where CategoryID =".$id_delete;
		$query3=mysqli_query($conn,$sql3);
		$sql2="DELETE from categoris where CategoryID =".$id_delete;	
		$query2=mysqli_query($conn,$sql2);
		$_SESSION['thongbao']="Xóa thành công";
		header('Location: dashboard.php?cate=yes');
	}
?>
	<a href="dashboard.php?addcate=yes" class="btn btn success" style="color: red;">Thêm loại sản phẩm	</a>
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
					<td><?= $row['CategoryID'] ?></td>
					<td><?= $row['CategoryName'] ?></td>
					<td><a href="admin_display_categoris.php?deletecate=<?= $row['CategoryID'] ?>" onclick="return confirm('Xóa tất cả những sản phẩm thuộc loại này!\nBạn chắc chứ?')" class="fa fa-trash btn btn-danger"></a></td>
					<td><a href="admin_alter_categoris.php?altercate=<?= $row['CategoryID'] ?>" class="fa fa-cogs btn btn-warning"></a></td>
				</tr>	
		<?php	}
		?>
	</table>
</div>
</body>