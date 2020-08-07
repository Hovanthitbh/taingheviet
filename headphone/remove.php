<?php
	session_start();
	if(!isset($_GET['key'])){
		header('location: index.php');exit();
	}
	$key= isset($_GET['key']) ? (int)$_GET['key'] : '';
	if($key){
		if(array_key_exists($key,$_SESSION['cart'])){
			unset($_SESSION['cart'][$key]);
			$_SESSION['success']="Xóa thành công";
		}
	}
	header('location: shopping_cart.php');exit();
?>