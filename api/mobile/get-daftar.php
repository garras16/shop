<?php
date_default_timezone_set('Asia/Jakarta');
require_once('../../assets/inc/config.php');
if (isset($_POST['query'])){
	$q=$_POST['query'];
} else {
	$q="SELECT
    beli.id_beli
    , beli.no_nota_beli
    , beli.tanggal 
FROM beli 
WHERE status_konfirm=0";
}

$sql=mysqli_query($con, $q);
$response["datas"] = array();
while ($row=mysqli_fetch_array($sql)){
	$data=array();
	$data["id_beli"]=$row["id_beli"];
	$data["no_nota_beli"]=$row["no_nota_beli"];
	$data["tanggal"]=$row["tanggal"];
	$response["success"]=1;
	array_push($response["datas"], $data);
}
echo json_encode($response);
?>