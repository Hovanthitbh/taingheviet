<?php
	include 'connect.php';
	$sql = "SELECT slider.SliderID, slider.SliderImage, product.ProductName, product.ProductImage, product.UnitPrice, product.Promotion
				FROM slider
				INNER JOIN product ON slider.ProductID = product.ProductID ";
	$query = mysqli_query($conn, $sql) or die("khong the truy van");
	if (isset($_GET['deletecslider'])) {
		$id_delete= $_GET['deletecslider'];
		$sql2="DELETE from slider where SliderID =".$id_delete;	
		$query2=mysqli_query($conn,$sql2);
		$_SESSION['success']="Xoa thanh cong";
		header('location: dashboard.php?slider=yes');
	}
?>
<?php
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
?>
<div>
	<a href="dashboard.php?addslider=yes" class="btn btn success" style="color: red;">Thêm slider quảng cáo</a>
	<?php if(isset($_SESSION['success'])) :?>
		<p><?= $_SESSION['success'] ?></p>
	<?php endif ; ?>
	<table class="table">
		<tr>
			<th>Mã Slider</th>
			<th>Hình slider</th>
			<th>Tên sản phẩm</th>
			<th>Hình ảnh sản phẩm</th>
			<th>Giá</th>
			<th>Giảm Giá</th>
			<th>Xóa</th>
		</tr>
		<?php
			while ($row=mysqli_fetch_array($query)) { ?>
				<tr>
					<td><?= $row['SliderID'] ?></td>
					<td><img src="banner_image/<?= $row['SliderImage'] ?>" style="width: 100px; height: 50;"></td>
					<td><?= $row['ProductName'] ?></td>
					<td><img src="product_image/<?= $row['ProductImage'] ?>" style="width: 50px; height: 50;"></td>
					<td><?= adddotstring($row['UnitPrice']) ?></td>
					<td><?= $row['Promotion'] ?>%	</td>
					<td><a href="admin_display_slider.php?deletecslider=<?= $row['SliderID'] ?>" onclick="return confirm('Bạn có chắc chắn xóa slider này?')" class="fa fa-trash btn btn-danger"></a></td>
					<!-- <td><a href="admin_alter_slider.php?alterslider=<?= $row['SliderID'] ?>" class="fa fa-cogs btn btn-warning"></a></td> -->
				</tr>	
		<?php	}
		?>
	</table>
</div>