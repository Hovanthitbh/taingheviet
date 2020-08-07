 
<?php
	include '../connect.php';
	function current_datetime(){
		date_default_timezone_set("Asia/Bangkok");
		$data= [
			'created_at'=>date('Y-m-d H:i:s'),
			'update_at'=>date('Y-m-d H:i:s'),
		];
		return $data;
	}
	 $current_time= current_datetime();
	$created_at = $current_time['created_at'];
	$update_at = $current_time['update_at'];
	$sql = "SELECT * from bill GRUOP";
	$query = mysqli_query($conn, $sql);
	// echo $time = date_parse_from_format('Y-m-d', $created_at);
	$date = "24/08/2016 13:35:22";
	// echo "<pre>";
	    $t = print_r(date_parse_from_format("Y-m-d H:i:s", $created_at));
	// echo "</pre>";
?>
<table>
	<?php while ($row=mysqli_fetch_array($query)) {
		// echo strtotime(date($row['TimeOrder']));
		?>

		<tr>
			<td><?= $row['TimeOrder'] ?></td>
		</tr>
	<?php } ?>
</table>