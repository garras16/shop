<?php
date_default_timezone_set('Asia/Jakarta');
require_once('../../assets/inc/config.php');

$id=$_GET['id'];
$plat=$_GET['plat1']. ' ' .$_GET['plat2']. ' ' .$_GET['plat3'];
$berlaku = $_GET['berlaku'];
$sql = "UPDATE kendaraan SET plat='$plat' WHERE id_kendaraan=$id";
$q = mysqli_query($con, $sql);
if ($q){
	echo '<span class="badge bg-green">No Pol berhasil disimpan</span>';
} else {
	echo '<span class="badge bg-green">No Pol gagal disimpan</span>';
}
$sql = "INSERT INTO plat_detail VALUES(null,'$berlaku',$id,'$plat')";
$q = mysqli_query($con, $sql);
?>