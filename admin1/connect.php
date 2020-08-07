<?php
	$host = "localhost";
	$username = "root";
	$password = "";
	$database = "template";
	$conn = mysqli_connect($host,$username,$password,$database) or die("Không thể kết nối đến sever");		
	mysqli_query($conn,"SET NAMES 'utf8'");
?>