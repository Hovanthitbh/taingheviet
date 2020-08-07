<?php
		session_start();
		include 'connect.php';
?>
<?php
	//lay id cua san pham duoc them
	if(isset($_GET['prid'])){
		// echo $prID= isset($_GET['prid']) ? (int)$_GET['prid'] : '';
		$prID= $_GET['prid'];
		$sql= "SELECT * FROM product WHERE ProductID = $prID";
		$query= mysqli_query($conn, $sql) or die("khong the truy van");
		$row = mysqli_fetch_array($query);
		// kiem tra session va khoi tao
		if($query){
			if(isset($_SESSION['cart'])){
				if(isset($_SESSION['cart'][$prID])){
					$_SESSION['cart'][$prID]['Quantity'] +=1;
				}
				else{
					$_SESSION['cart'][$prID]['Quantity']=1;
				}
				$_SESSION['success']='Cap nhap gio hang thanh cong';
				$_SESSION['cart'][$prID]['ProductID'] = $row['ProductID'];
				$_SESSION['cart'][$prID]['ProductImage']= $row['ProductImage'];
				$_SESSION['cart'][$prID]['ProductName']= $row['ProductName'];
				$_SESSION['cart'][$prID]['UnitPrice']= $row['UnitPrice'];
				$_SESSION['cart'][$prID]['Promotion']= $row['Promotion'];
				$_SESSION['cart'][$prID]['QuantityDF']= $row['Quantity'];

				header('location: detail_product.php?detail='.$prID);exit();
			}
			else{
				$_SESSION['cart'][$prID]['Quantity']=1;
				$_SESSION['cart'][$prID]['ProductID'] = $row['ProductID'];
				$_SESSION['cart'][$prID]['ProductImage']= $row['ProductImage'];
				$_SESSION['cart'][$prID]['ProductName']= $row['ProductName'];
				$_SESSION['cart'][$prID]['UnitPrice']= $row['UnitPrice'];
				$_SESSION['cart'][$prID]['Promotion']= $row['Promotion'];
				$_SESSION['cart'][$prID]['QuantityDF']= $row['Quantity'];
				$_SESSION['success']='Them san pham thanh cong';
				header('location: detail_product.php?detail='.$prID);exit();
			}
		}
		else{
			$_SESSION['success']='khong ton tai sp trong csdl';	
		}
	}
	if(isset($_GET['prID'])){
				// echo $prID= isset($_GET['prid']) ? (int)$_GET['prid'] : '';
		$prID= $_GET['prID'];
		$sql= "SELECT * FROM product WHERE ProductID = $prID";
		$query= mysqli_query($conn, $sql) or die("khong the truy van");
		$row = mysqli_fetch_array($query);
		// kiem tra session va khoi tao
		if($query){
			if(isset($_SESSION['cart'])){
			if(isset($_SESSION['cart'][$prID])){
				$_SESSION['cart'][$prID]['Quantity'] +=1;
			}
			else{
				$_SESSION['cart'][$prID]['Quantity']=1;
			}
			$_SESSION['success']='Cap nhap gio hang thanh cong';
			$_SESSION['cart'][$prID]['ProductID'] = $row['ProductID'];
			$_SESSION['cart'][$prID]['ProductImage']= $row['ProductImage'];
			$_SESSION['cart'][$prID]['ProductName']= $row['ProductName'];
			$_SESSION['cart'][$prID]['UnitPrice']= $row['UnitPrice'];
			$_SESSION['cart'][$prID]['Promotion']= $row['Promotion'];
			$_SESSION['cart'][$prID]['QuantityDF']= $row['Quantity'];
			header('location: shopping_cart.php');exit();
			}
			else{
				$_SESSION['cart'][$prID]['Quantity']=1;
				$_SESSION['cart'][$prID]['ProductID'] = $row['ProductID'];
				$_SESSION['cart'][$prID]['ProductImage']= $row['ProductImage'];
				$_SESSION['cart'][$prID]['ProductName']= $row['ProductName'];
				$_SESSION['cart'][$prID]['UnitPrice']= $row['UnitPrice'];
				$_SESSION['cart'][$prID]['Promotion']= $row['Promotion'];
				$_SESSION['cart'][$prID]['QuantityDF']= $row['Quantity'];
				$_SESSION['success']='Them san pham thanh cong';
				header('location: shopping_cart.php');exit();
			}
		}
	}
?>