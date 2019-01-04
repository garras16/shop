<?php
date_default_timezone_set('Asia/Jakarta');
require_once('../../assets/inc/config.php');
$q="SELECT * FROM ekspedisi";

$sql=mysqli_query($con, $q);
$response["datas"] = array();
while ($row=mysqli_fetch_array($sql)){
	$data=array();
	$data["id_ekspedisi"]=$row["id_ekspedisi"];
	$data["nama_ekspedisi"]=$row["nama_ekspedisi"];
	$response["success"]=1;
	array_push($response["datas"], $data);
}
echo json_encode($response);
?>