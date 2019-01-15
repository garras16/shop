<?php
date_default_timezone_set('Asia/Jakarta');
require_once('../../../assets/inc/config.php');
require_once('../../../assets/inc/publicfunc.php');
$id=$_GET['id'];
$tanggal=date("Y-m-d");
$sql=mysqli_query($con, "SELECT * FROM harga_jual_kredit WHERE id_harga_jual=$id");
while($row=mysqli_fetch_array($sql)){
	$harga_kredit=$row['harga_kredit'];
	$hari=$row['hari'];
	$sql2=mysqli_query($con, "INSERT INTO hj_kredit_detail VALUES(null,$id,'$tanggal',$harga_kredit,$hari)");
}
$sql=mysqli_query($con, "DELETE FROM harga_jual_kredit WHERE id_harga_jual=$id");
?>