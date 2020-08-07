
<?php
	ob_start();
	include 'connect.php';
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
<?php
	//tim tong so san pham
	$result = mysqli_query($conn, "select count(ProductID) as total from product");
	$rowpage= mysqli_fetch_assoc($result);
	$total_record = $rowpage['total'];

	//tim limit va curent_page
	$curent_page =isset($_GET['page']) ? $_GET['page'] : 1;
	$limit = 9;

	//tinh tong so trang va trang bat dau
	$total_page = ceil($total_record/$limit);

	//gioi han page do nguoi dung nhap
	if($curent_page> $total_page){
		$curent_page =$total_page;
	}
	else
		if($curent_page<1){
			$curent_page=1;
		}
	//tim start
	$start = ($curent_page - 1)  * $limit;

	//truy van lay danh sach san pham
	$query_page = "SELECT * FROM product LIMIT $start, $limit";
	$result= mysqli_query($conn,$query_page);
?>
<?php
		if(isset($_GET['delete'])){
			$id_delete= $_GET['delete'];
			$sql2="DELETE from product where ProductID =".$id_delete;	
			$sql3="select * from product where ProductID =".$id_delete;
			$query3= mysqli_query($conn,$sql3) or die('khong the truy van 3');
			$row2 = mysqli_fetch_array($query3);
			//xoa hinh anh trong file goc
			if(file_exists('product_image/'.$row2['ProductImage'])){
				@unlink('product_image/'.$row2['ProductImage']);
			}
			$query2= mysqli_query($conn,$sql2) or die('khong the truy van 2');
			$_SESSION['thongbao']="Xóa thành công!";
		}
	?>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<style>
		*{
			margin: 0px;
			padding: 0px;
		}
		table tr td{
			border-collapse: separate;
			border: 1px solid;
		}
	 #top img{
	width: 150px;
	height: 150px;
	padding-left:400px;
}
	table tr td img{
		width: 50px;	
		height: 50px;
	}
	</style>
<title>Untitled Document</title>
</head>

<body <?php if(isset($_SESSION['thongbao'])) : ?> onload="alert('<?= $_SESSION['thongbao'] ?>')" <?php endif ; unset($_SESSION['thongbao']); ?> >
	<div>
		<!-- <?php include 'admin.php'; ?> -->
	</div>
	<div id="loc_delete">
		<form action="dashboard.php" method="get" name="form" style="float: left;">
			<label for="select">Hãng Sản Xuất:</label>
			<select name="producerID" onchange="form.submit()" class="form-control" style="width: 200px;">
				<?php
					$sql4="select * from producer";
					$query4= mysqli_query($conn,$sql4) or die('khong the truy van 4');
					$num = mysqli_num_rows($query4);
					$tam=0;
					for($i=1;$i<=$num;$i++){
						$row3 = mysqli_fetch_array($query4);
						if($tam==0) $tam=$row3['ProducerID'];?>
						<option value="<?php echo $row3['ProducerID']; ?>" 
						   <?php if(isset($_GET['producerID']) && $_GET['producerID']==$row3['ProducerID'])
							  echo "selected='selected'"; ?> > 
						<?php echo $row3['ProducerName']; ?></option>
				<?php
					}
				?>
			</select>
			<!-- <input type="submit" name="submit_categoryID" value="Loc" class="btn btn-success"> -->
		</form>
		<a href="dashboard.php?pr=yes" class="btn btn-success" style="float: left; margin-top: 25px; margin-left: 10px;">Thêm sản phẩm</a>
		 <?php
			if(isset($_GET['producerID'])){
				$sql5="select * from product where ProducerID = ".$_GET['producerID'];
				$query5= mysqli_query($conn,$sql5) or die('khong the truy van 5');
				$num = mysqli_num_rows($query5);?>
				<a href="dashboard.php" class="btn btn-success" style="float: left;margin-top: 25px; margin-left: 10px;">Tất cả sản phẩm</a>
				<table class="table" style="width: 950px;">
					<tr>
					<th>ID</th>
					<th>Tên sản phẩm</th>
					<th>Hình ảnh</th>
					<th>Số lượng</th>
					<th>Giá</th>
					<th>Giảm giá</th>
					<th>Xóa</th>
					<th>Sửa</th>
					</tr>
				<?php while($row4 = mysqli_fetch_assoc($query5)){ ?>
					<tr>
					<td><?=$row4['ProductID']?></td>
					<td><?=$row4['ProductName']?></td>
					<td><img src="product_image/<?=$row4['ProductImage']?>"></td>
					<td><?=$row4['Quantity']?></td>
					<td><?= adddotstring($row4['UnitPrice']) ?></td>
					<td><?= $row4['Promotion'] ?>%</td>
					<td><a href="dashboard.php?delete=<?=$row4['ProductID']?>"	 
						class="fa fa-trash btn btn-danger" onClick="return confirm('Bạn có chắc xóa?')"></a></td>
					<td><a href="admin_alterproduct.php?update=<?= $row4['ProductID']?>" 
						class="fa fa-cogs btn btn-warning"></a></td>
					</tr>
					<?php }
				echo "</table>";
			}
		?>
	</div>
	<?php
		if(!isset($_GET['producerID'])){ ?>
				<table class="table" style="width: 950px;">
					<tr>
					<th>ID</th>
					<th>Tên sản phẩm</th>
					<th>Hình ảnh</th>
					<th>Số lượng</th>
					<th>Giá</th>
					<th>Giảm giá</th>
					<th>Xóa</th>
					<th>Sửa</th>
					</tr>
				<?php while($row = mysqli_fetch_assoc($result)){ ?>
					<tr>
					<td><?=$row['ProductID']?></td>
					<td><?=$row['ProductName']?></td>
					<td><img src="product_image/<?=$row['ProductImage']?>"></td>
					<td><?=$row['Quantity']?></td>
					<td><?= adddotstring($row['UnitPrice']) ?></td>
					<td><?= $row['Promotion'] ?>%</td>
					<td><a href="dashboard.php?delete=<?=$row['ProductID']?>"	 
						class="fa fa-trash btn btn-danger" onClick="return confirm('Bạn có chắc xóa?')"></a></td>
					<td><a href="admin_alterproduct.php?update=<?= $row['ProductID']?>" 
						class="fa fa-cogs btn btn-warning"></a></td>
					</tr>
					<?php }
				echo "</table>";?>
			<ul class="pagination">
			<?php if($curent_page>1 && $total_page>1){
				echo "<li><a href='dashboard.php?page=".($curent_page - 1)."'>Back</a></li>";
				}
				for($i =1; $i<=$total_page;$i++){
					if($i == $curent_page)
						echo "<li><span style='background-color: pink;'>".$i."</span</li>";
					else echo "<li><a href='dashboard.php?page=".$i."'> ".$i." </a></li>";
				}
				if($curent_page<$total_page && $total_page>1){
					echo "<li><a href='dashboard.php?page=".($curent_page + 1)."'>Next</a></li>";
				}
			}
	?>
	</ul>
	<script type="text/javascript">
		function del(){
			confirm("Bạn có chắc chắn xóa không?");
		}
	</script>
</body>
</html>