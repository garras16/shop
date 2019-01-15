<?php
date_default_timezone_set('Asia/Jakarta');
require_once('../../../assets/inc/config.php');
$id=$_GET['id'];
$lat_x=$_GET['lat'];
$lng_x=$_GET['lng'];
$sql=mysqli_query($con, "SELECT lat,lng FROM pelanggan WHERE id_pelanggan=$id");
$row=mysqli_fetch_array($sql);
$lat=$row["lat"];
$lng=$row["lng"];
if ($lat==''){
	$sql=mysqli_query($con, "UPDATE pelanggan SET lat='$lat_x',lng='$lng_x' WHERE id_pelanggan=$id");
	$lat=$lat_x;
	$lng=$lng_x;
}
echo $lat .",". $lng;
?>