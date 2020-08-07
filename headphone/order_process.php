<?php
	session_start();
	include 'connect.php';
	function current_datetime(){
		date_default_timezone_set("Asia/Bangkok");
		$data= [
			'created_at'=>date('Y-m-d'),
			'update_at'=>date('Y-m-d H:i:s'),
		];
		return $data;
	}
	$UserID = $_SESSION['UserID'];
	$current_time= current_datetime();
	$datetime = $current_time['created_at'];
	if(isset($_POST['order'])){
		if(!empty($_POST['email']) && !empty($_POST['username']) && !empty($_POST['phonenumber']) && !empty($_POST['address']) 
			&& !empty($_POST['city']) && !empty($_POST['district']) && !empty($_POST['wards'])){
			$Email=$_POST['email'];
			$CustomerName = $_POST['username'];
			$PhoneNumber = $_POST['phonenumber'];
			$idcity = $_POST['city'];
			$iddistrict = $_POST['district'];
			$idwards = $_POST['wards']; 
			echo $sqladd = "SELECT devvn_tinhthanhpho.name AS tinhthanhpho, devvn_quanhuyen.name AS quanhuyen, devvn_xaphuongthitran.name AS xaphuong   FROM ((devvn_quanhuyen
                        INNER JOIN devvn_tinhthanhpho ON devvn_tinhthanhpho.matp = devvn_quanhuyen.matp)
                        INNER JOIN devvn_xaphuongthitran ON devvn_quanhuyen.maqh = devvn_xaphuongthitran.maqh)
                        WHERE devvn_tinhthanhpho.matp = '$idcity' 
                        AND devvn_quanhuyen.maqh = '$iddistrict' AND devvn_xaphuongthitran.xaid = '$idwards' ";
            $queryadd = mysqli_query($conn, $sqladd);
            $rowadd = mysqli_fetch_array($queryadd);
            $namecity = $rowadd['tinhthanhpho'];
			$namedistrict = $rowadd['quanhuyen'];
			$namewards = $rowadd['xaphuong']; 
			$Address = $_POST['address']."/ ".$namecity."/ ".$namedistrict."/ ".$namewards;
			$Status = 1;
		}
		else{
			$_SESSION['thongbao']="Vui lòng điền đầy đủ thông tin!";
			header('location: checkout.php');exit();
		}
	}
	echo $sql="INSERT INTO bill( UserID, TimeOrder, Email, PhoneNumber, CustomerName, CustomerAddress, Status )
			VALUES( '$UserID', '$datetime', '$Email', '$PhoneNumber', '$CustomerName', '$Address', '$Status' )";
	// $query = mysqli_query($conn, $sql) or die("khong the truy van");
	if (mysqli_query($conn, $sql)){
		$billID = mysqli_insert_id($conn);
	}else{
		echo "khong the truy van";die();
	}
	foreach ($_SESSION['cart'] as $key => $value){
		$ProductID = $value['ProductID'];
		$Quantity = $value['Quantity'];
		$QuantityDF = $value['QuantityDF'] - $Quantity;
		$UnitPrice = $value['UnitPrice'] * $Quantity;
		$Promotion = $value['Promotion'];
		$sql2 = "INSERT INTO orderdetail (BillID, ProductID, Quantity, UnitPrice, Promotion)
				VALUES( '$billID', '$ProductID', '$Quantity', '$UnitPrice', '$Promotion' )";
		$sql3 = "UPDATE product SET Quantity = $QuantityDF WHERE ProductID = $ProductID";
		$query2 = mysqli_query($conn, $sql2) or die("khong the truy van 2");
		$query3 = mysqli_query($conn, $sql3) or die("khong the truy van 3");
		unset($_SESSION['cart']);
	}
	header('location: thankyou.php');
?>