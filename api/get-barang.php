<?php
date_default_timezone_set('Asia/Jakarta');
require_once('../assets/inc/config.php');
if (isset($_POST['query'])){
	$q=$_POST['query'];
} else {
	$q="SELECT * FROM barang";
}
$sql=mysql_query($q);
$response["datas"] = array();
while ($row=mysql_fetch_array($sql)){
	$data=array();
	$data["id_barang"]=$row["id_barang"];
	$data["kode_barang"]=$row["kode_barang"];
	$data["barcode"]=$row["barcode"];
	$data["nama_barang"]=$row["nama_barang"];
	$data["satuan"]=$row["satuan"];
	$data["no_ijin"]=$row["no_ijin"];
	$data["min_order"]=$row["min_order"];
	$data["harga"]=$row["harga"];
	$response["success"]=1;
	array_push($response["datas"], $data);
}
echo json_encode($response);
?>