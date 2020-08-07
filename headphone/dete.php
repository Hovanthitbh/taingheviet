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