<?php
	include 'connect.php';
	$sql = "SELECT * FROM slider";
	$query = mysqli_query($conn, $sql) or die("khong the truy van");

?>
<head>
	<link rel="stylesheet" href="css/banner.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
	<script type="text/javascript" src="js/slider.js"></script>
</head>
<body>
	<div id="slider" style="margin-left: 0px;">
		<?php $i=0; while ($row=mysqli_fetch_array($query)) { ?>
			<a href="<?= $row['SliderLink'] ?>"><img src="../admin1/banner_image/<?= $row['SliderImage'] ?>" stt="<?= $i ?>" class="slide" 
				style="width: 100%; min-height: 450px; <?php if($i!=0) : ?> display: none; <?php endif ; ?> margin-left: 0px;"></a>
		<?php $i++; } ?>
		<!-- <img src="../admin1/banner_image/slide1.png" stt="0" class="slide" style="width: 1024px; min-height: 350px;">
		<img src="../admin1/banner_image/slide3.jpg" stt="1" class="slide" style="display: none; width: 1024px; min-height: 350px;">
		<img src="../admin1/banner_image/slide4.jpg" stt="2" class="slide" style="display: none; width: 1024px; min-height: 350px;">
		<img src="../admin1/banner_image/slide5.jpg" stt="3" class="slide" style="display: none; width: 1024px; min-height: 350px;">
		<img src="../admin1/banner_image/slide2.jpg" stt="4" class="slide" style="display: none; width: 1024px; min-height: 350px;"> -->
			<a href="#" id="prev" class="fa fa-chevron-left" style="font-size: 50px; text-decoration: none; color: gray;text-transform: uppercase;top:200px;left: 20px;position: absolute;"></a>
			<a href="#" id="next" class="fa fa-chevron-right" style="font-size: 50px; text-decoration: none; color: gray; text-transform: uppercase;top:200px;right:20px;position: absolute;"></a>
	</div>
</body>