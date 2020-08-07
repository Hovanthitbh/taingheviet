<?php
	ob_start();
	include 'connect.php';
	session_start();
?>
<?php if(isset($_GET['logout'])) {
    session_destroy();
    header('Location: dashboard.php');
} ?>
<html>
<head>
<meta charset="utf-8">
	<!-- <link href="admin.css" rel="stylesheet"> -->
	<script src="ckeditor/ckeditor.js"></script>
		<style>
		#top img{
		width: 150px;
		height: 150px;
		padding-left:400px;
		}
	</style>
	<link rel="icon" type="image/png" href="assets/img/favicon.ico">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Admin - taingheviet</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


    <!-- Bootstrap core CSS     -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Animation library for notifications   -->
    <link href="assets/css/animate.min.css" rel="stylesheet"/>

    <!--  Light Bootstrap Table core CSS    -->
    <link href="assets/css/light-bootstrap-dashboard.css?v=1.4.0" rel="stylesheet"/>


    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="assets/css/demo.css" rel="stylesheet" />


    <!--     Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link href="assets/css/pe-icon-7-stroke.css" rel="stylesheet" />
</head>

<body onload="thongbao();">
	<div class="sidebar" data-color="purple" data-image="assets/img/sidebar-5.jpg">

    <!--

        Tip 1: you can change the color of the sidebar using: data-color="blue | azure | green | orange | red | purple"
        Tip 2: you can also add an image using data-image tag

    -->

    	<div class="sidebar-wrapper">
            <div class="logo">
                <a class="simple-text">
                    Công cụ quản lý
                </a>
            </div>

            <ul class="nav">
                <li class="active">
                    <a href="dashboard.php">
                        <i class="pe-7s-graph"></i>
                        <p>THÊM SẢN PHẨM</p>
                    </a>
                </li>
                <li>
                    <a href="admin_display_account.php">
                        <i class="pe-7s-user"></i>
                        <p>Tài khoản quản lý</p>
                    </a>
                </li>
                <li>
                    <a href="admin_display_order.php">
                        <i class="pe-7s-note2"></i>
                        <p>Đơn hàng</p>
                    </a>
                </li>
                <li>
                    <a href="admin_manager_revenue.php">
                        <i class="pe-7s-news-paper"></i>
                        <p>Doanh thu</p>
                    </a>
                </li>
                <li>
                    <a href="admin_display_information">
                        <i class="pe-7s-map-marker"></i>
                        <p>Thông tin website</p>
                    </a>
                </li> 	
            </ul>
    	</div>
    </div>

    <div class="main-panel">
        <nav class="navbar navbar-default navbar-fixed">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="dashboard.php">Trang chủ</a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="admin_alterproduct.php?logout=yes">
                                <p>Đăng xuất</p>
                            </a>
                        </li>
						<li class="separator hidden-lg"></li>
                    </ul>
                </div>
            </div>
        </nav>


        <div class="content" style="min-height: 800px; ">
            <div id="title">
                <nav class="navbar navbar-inverse">
                  <div class="container-fluid">
                    <div class="navbar-header">
                      <a class="navbar-brand" href="">Thêm: </a>
                    </div>
                    <ul class="nav navbar-nav">
                      <li><a href="dashboard.php?pr=yes">Sản Phẩm</a></li>
                      <li><a href="#">Loại</a></li>
                      <li><a href="#">Hãng</a></li>
                    </ul>
                    <!-- <button class="btn btn-danger navbar-btn">Button</button> -->
                  </div>
                </nav>
            </div>
	<?php
			$ProductID = $_GET['update'];
			$sql = "select * from product where ProductID=".$ProductID;
			$query = mysqli_query($conn,$sql) or die('khong the truy van');
			$row = mysqli_fetch_array($query);
			$ProductName = $row['ProductName'];
			$ProductImage = $row['ProductImage'];
			$ProductI4 = $row['ProductI4'];	
			$ProducerID = $row ['ProducerID'];
			$Quantity = $row ['Quantity'];
			$UnitPrice = $row ['UnitPrice'];
			$Promotion = $row['Promotion'];
			$CategoryID = $row['CategoryID'];
	?>
	<!-- <script src="//tinymce.cachefly.net/4.2/tinymce.min.js">
	</script>
	<script>tinymce.init({selector:'textarea'});</script> -->
	<div id='AddProduct'>
		<form	action="#" method="POST" enctype="multipart/form-data">
			<input type="file" name='taptin' id="chonanh" class="form-control">
			<div>
				<?php echo "<img style='width: 200px; height: 200px;' src='product_image/".$row['ProductImage']."'><br>" ?>
			<div class="p-3 p-lg-5 border">
                <div class="form-group row">
                  <div class="col-md-6">
					<label class="text-black">Tên sản phẩm: </label>
					<input type="text" name="product_name" id="textbox" class="form-control" <?php echo "value=".$ProductName ?>><br>
				</div>
				<div class="col-md-6">
					<label class="text-black">Nhà cung cấp: </lable><br>
						<select name="producer" class="form-control">
						<?php
							$sql1="SELECT * FROM producer";
							$query2=mysqli_query($conn, $sql1) or die('khong the truy van 2');
							while ($row2=mysqli_fetch_array($query2)) { ?>
									<option value="<?= $row2['ProducerID'] ?>"
										<?php if($row2['ProducerID']==$ProducerID) :?>
										selected="selected"<?php endif ; ?>
									 ><?= $row2['ProducerName'] ?></option>
						<?php }
						?>
					</select><br>
				</div>
				<div class="col-md-6">
					<label class="text-black">Loại sản phẩm: </lable><br>
						<select name="categoris" class="form-control">
						<?php
							$sql2="SELECT * FROM categoris";
							$query3=mysqli_query($conn, $sql2) or die('khong the truy van 3');
							while ($row4=mysqli_fetch_array($query3)) { ?>
									<option value="<?= $row4['CategoryID'] ?>"
										<?php if($row4['CategoryID']==$CategoryID) :?>
										selected="selected"<?php endif ; ?>
									 ><?= $row4['CategoryName'] ?></option>
						<?php }
						?>
					</select>
				</div>
				<div class="col-md-6">
					<label class="text-black">Số lượng: </label>
					<input type="number" name="quantity" id="textbox" class="form-control" <?php echo "value=".$Quantity ?>><br>
				</div>
				<div class="col-md-6">
					<label class="text-black" >Giá sản phẩm: </label>
					<input type="number" name="unitprice" id="textbox" class="form-control" <?php echo "value=".$UnitPrice ?>><br>
				</div>
				<div class="col-md-6">
					<label class="text-black">Phần trăm khuyến mãi: </label>
					<input type="number" name="promotion" id="textbox" class="form-control" <?php echo "value=".$Promotion ?>><br>
				</div>
				<div class="col-md-6">
					<label for="ckeditor" class="text-black">Mô tả sản phẩm</label><br>	
					<textarea name="image_text" id="ckeditor" rows="10" cols="80" class="form-control" ><?= $ProductI4 ?></textarea><br> 
				</div>
			</div><br>
			<input type="submit" name="submit" class="btn btn-primary btn-lg" value="Tải lên" id="submit"
			style="margin-left: 130px; width: 200px;">
		</form>
	<?php
		if(isset($_POST['submit'])){
			$strfile='taptin';
			$strpath='product_image./';
			$ketqua="";
			if(isset($_FILES[$strfile]))
			{
				if ($_FILES[$strfile]['error']== UPLOAD_ERR_OK) {
					$name = $_FILES[$strfile]['name'];
					if(move_uploaded_file($_FILES[$strfile]['tmp_name'], $strpath.$name))
						if(file_exists('product_image/'.$ProductImage)){
						unlink('product_image/'.$ProductImage);
						// $_SESSION['success']="cap nhap thanh cong";
				}	
					else
						$s="Không di chuyển được file";
				}else
				$_SESSION['imgdp'] = $ProductImage;
			}
			if(isset($_SESSION['imgdp'])){
				$image = $_SESSION['imgdp'];
			}else{
				$image=$_FILES[$strfile]['name'];
			}
			$image_text=$_POST['image_text'];
			$product_name=$_POST['product_name'];
			$producer=$_POST['producer'];
			$quantity=$_POST['quantity'];
			$unitprice=$_POST['unitprice'];
			$promotion = $_POST['promotion'];
			$categoris = $_POST['categoris'];
			$sql= "UPDATE product
					SET
					ProductName = '$product_name',
					ProductImage = '$image',
					ProductI4 = '$image_text',
					ProducerID = '$producer',
					Quantity = '$quantity',
					UnitPrice = '$unitprice',
					Promotion = '$promotion',
					CategoryID = '$categoris'
					WHERE ProductID = '$ProductID'";
			$query= mysqli_query($conn, $sql) or die("khong the truy van 100");
			$_SESSION['thongbao']="Cập nhập thành công!";
			header('Location:dashboard.php');
		}
	?>
	<?php
            if(isset($_SESSION['success'])) :?>
                    <p style="margin-top: -1080px;"><?= $_SESSION['success'] ?>, <a href="dashboard.php">Quay lại</a></p>
            <?php endif ;unset($_SESSION['success']); ?>
<script>
	CKEDITOR.replace( 'image_text' );
</script>
</body>
</html>