<?php
	require("connect.php");
?>
<?php
	$idtp = $_POST['idtp'];
	$sqlqh = "select * from devvn_quanhuyen where matp = '$idtp'";
	$queryqh = mysqli_query($conn, $sqlqh);
	$num = mysqli_num_rows($queryqh);
	if($num > 0){
		while($row = mysqli_fetch_array($queryqh)){

		
?>

	<option value="<?php echo $row['maqh']?>"><?php echo $row['name']?></option>

<?php
		}
	}
?>
<?php
	$idqh = $_POST['idqh'];
	$sqlpx = "select * from devvn_xaphuongthitran where maqh = '$idqh'";
	$querypx = mysqli_query($conn, $sqlpx);
	$numpx = mysqli_num_rows($querypx);
	if($numpx > 0){
		while($rowpx = mysqli_fetch_array($querypx)){

		
?>

	<option value="<?php echo $rowpx['xaid']?>"><?php echo $rowpx['name']?></option>

<?php
		}
	}
?>