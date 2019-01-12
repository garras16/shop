<?php
	date_default_timezone_set('Asia/Jakarta');
	require_once('../assets/inc/config.php');
	$sql=mysqli_query($con, "SELECT nama FROM customer");
	$response["datas"] = array();
	while ($row=mysqli_fetch_array($sql)){
		$data=array();
		$data["nama"]=$row["nama"];
		array_push($response["datas"], $data);
	}
	echo json_encode($response);
?>