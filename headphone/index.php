<?php session_start(); ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<!--<link href="Thi.css" rel="stylesheet">-->
</head>

<body>
	<div id="php_main">
		<div id="php_menu">
			<?php
				include 'menu.php';
			?>
		</div>
		<div>
			<?php
				include 'banner.php';
			?>
		</div>
		<div id="php_content">
			<?php
				include 'display_product.php';
				if(isset($_POST['btnsearch'])){
					include 'display_product.php';
				}
			?>
		</div>
		<div>
			<?php include 'footer.php'; ?>
		</div>
	</div>
</body>
</html>