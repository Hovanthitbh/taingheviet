<?php
	session_start();
	include 'connect.php';
	include 'menu.php';
	include 'banner.php';
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
<?php
	//tim tong so san pham
	if(!isset($_GET['pr'])){
		$result = mysqli_query($conn, "select count(ProductID) as total from product where CategoryID = 3 or CategoryID =4");
		$rowpage= mysqli_fetch_assoc($result);
		$total_record = $rowpage['total'];

		//tim limit va curent_page
		$curent_page =isset($_GET['page']) ? $_GET['page'] : 1;
		$limit = 15;

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
		if(!isset($_GET['sapxep'])){
			$query_page = "SELECT * FROM product WHERE CategoryID = 3 OR CategoryID = 4 LIMIT $start, $limit";	
		}
		if(isset($_GET['sapxep'])){
			$sx= $_GET['sapxep'];
			if($sx == 1){
				$query_page = "SELECT * FROM product WHERE CategoryID = 3 OR CategoryID = 4 ORDER  BY UnitPrice DESC LIMIT $start, $limit";	
			}
			if ($sx==2) {
				$query_page = "SELECT * FROM product WHERE CategoryID = 1 OR CategoryID = 4 ORDER  BY UnitPrice LIMIT $start, $limit";	
			}
			if ($sx==3) {
				$query_page = "SELECT * FROM product WHERE CategoryID = 3 OR CategoryID = 4 LIMIT $start, $limit";	
			}
		}
	}
	if(isset($_GET['pr'])){
		$id= $_GET['pr'];
		if(!isset($_GET['sapxep'])){
			$query_page = "SELECT * FROM product WHERE ProducerID = $id";
		}
		if (isset($_GET['sapxep'])) {
			$sx= $_GET['sapxep'];
			if($sx == 1){
				$query_page = "SELECT * FROM product ORDER BY UnitPrice DESC WHERE ProducerID = $id";
			}
			if ($sx==2) {
				$query_page = "SELECT * FROM product ORDER BY UnitPrice WHERE ProducerID = $id";
			}
			if ($sx==3) {
				$query_page = "SELECT * FROM product WHERE CategoryID = 3 OR CategoryID = 4 LIMIT $start, $limit";	
			}
		}
	}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link href="Product.css" rel="stylesheet">	
<link rel="stylesheet" href="css/bootstrap.min.css">
<title>Headphone</title>
</head>
<body>
	<div id="display">
		<div>
			<form action="display_product_orther.php" method="get">
				<select name="sapxep" class="form-control" style="width: 150px;" onchange="form.submit()">
					<option value="3">Sắp xếp</option>
					<option value="1"<?php if(isset($_GET['sapxep'])){if($_GET['sapxep']==1){echo "selected='selected'";}} ?>>Giá giảm dần</option>
					<option value="2" <?php if(isset($_GET['sapxep'])){if($_GET['sapxep']==2){echo "selected='selected'";}} ?>>Giá tăng dần</option>
				</select>
			</form>
		</div>
		<div id="display_product" align="center">
			<?php
				$query=mysqli_query($conn, $query_page);
				while($row= mysqli_fetch_array($query)){ ?>
						<div id='product'>
							<a href="detail_product.php?detail=<?=$row['ProductID']?>"><img class="img-rounded" 
								src="../admin1/product_image/<?= $row['ProductImage'] ?>"></a>
								<div id="product_i4">
									<a href="detail_product.php?detail=<?= $row['ProductID'] ?>"
										style="font-size: 15px;"><?= $row['ProductName'] ?></a><br>
									<!-- <p class='btn btn-danger'><?= adddotstring($row['UnitPrice']) ?></p> -->
									<!-- <span class='btn btn-danger' style="height: 30px;"><?= Promotion($row['UnitPrice'], $row['Promotion']) ?></span> -->
									<?php 
										if($row['Quantity']>0){ ?>
											<a href="detail_product.php?detail=<?=$row['ProductID']?>"><span class='btn btn-danger' style="height: 30px;"><?= Promotion($row['UnitPrice'], $row['Promotion']) ?></span></a>
											<?php if ($row['Promotion']>0) : ?>
													<br><span class="btn btn-warning" style="font-size: 15px; height: 30px;">-<?= $row['Promotion'] ?> %</span>
													<span style="font-size: 15px;text-decoration: line-through; color: gray;">
														<?= adddotstring($row['UnitPrice']) ?></span>
												<?php endif ; ?>
										<?php }else {
											echo "<a class='btn btn-danger' style='color:white;' 
											href='detail_product.php?detail=".$row['ProductID']."'>Cháy hàng</a>";
										}  ?>
								</div>
							</div>

				<?php } ?>
		</div>
		<div id="phantrang" style="width: 250px; height: 50px;z-index: -100; clear: left;" align="center">
			<?php
				if(!isset($_GET['pr']) && !isset($_GET['sapxep'])){ ?>
					<div class="text-center">
			                <div class="site-block-27">
			                  <ul>
					<?php if($curent_page>1 && $total_page>1){?>
						<li><a href="display_product_orther.php?page=<?=($curent_page - 1) ?>">&lt;</a><li>
					<?php }
					for($i =1; $i<=$total_page;$i++){
						if($i== $curent_page)
							echo "<li class='active'><a href='display_product_orther.php?page=".$i."'>".$i."</a><li>"; 
						else { ?><li><a href="display_product_orther.php?page=<?= $i ?>"><?= $i ?></a><li>
					<?php }}
					if($curent_page<$total_page && $total_page>1){ ?>
							<li><a href="display_product_orther.php?page=<?= ($curent_page + 1) ?>">&gt;</a><li>
								</ul>
			                </div>
			              </div>
					<?php }
				}
				if(isset($_GET['sapxep'])){
					$sx = $_GET['sapxep'];
					if ($sx == 1) { ?>
						<div class="text-center">
			                <div class="site-block-27">
			                  <ul>
						<?php if($curent_page>1 && $total_page>1){?>
							<li><a href="display_product_orther.php?sapxep=1&page=<?=($curent_page - 1) ?>">&lt;</a></li>
						<?php }
						for($i =1; $i<=$total_page;$i++){
							if($i== $curent_page)
								echo "<li class='active'><a href='display_product_orther.php?page=".$i."'>".$i."</a><li>"; 
							else { ?><li><a href="display_product_orther.php?sapxep=1&page=<?= $i ?>"><?= $i ?></a></li>
						<?php }}
						if($curent_page<$total_page && $total_page>1){ ?>
								<li><a href="display_product_orther.php?sapxep=1&page=<?= ($curent_page + 1) ?>">&gt;</a></li>
								</ul>
			                </div>
			              </div>
						<?php }
					}
					if ($sx == 2) { ?>
						<div class="text-center">
			                <div class="site-block-27">
			                  <ul>
						<?php if($curent_page>1 && $total_page>1){?>
							<li><a href="display_product_orther.php?sapxep=2&page=<?=($curent_page - 1) ?>">&lt;</a></li>
						<?php }
						for($i =1; $i<=$total_page;$i++){
							if($i== $curent_page)
								echo "<li class='active'><a href='display_product_orther.php?page=".$i."'>".$i."</a><li>"; 
							else { ?><li><a href="display_product_orther.php?sapxep=2&page=<?= $i ?>"><?= $i ?></a></li>
						<?php }}
						if($curent_page<$total_page && $total_page>1){ ?>
								<li><a href="display_product_orther.php?sapxep=2&page=<?= ($curent_page + 1) ?>">&gt;</a></li>
								</ul>
			                </div>
			              </div>
						<?php }
					}
				}
			?>
		</div>
	</div>
	<div>
		<?php include 'footer.php' ?>
	</div>
</body>
</html>