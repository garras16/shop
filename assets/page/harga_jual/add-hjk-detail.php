<?php
date_default_timezone_set('Asia/Jakarta');
require_once('../../../assets/inc/config.php');
require_once('../../../assets/inc/publicfunc.php');
$id=$_GET['id'];
$tanggal=date("Y-m-d");
$sql=mysql_query("SELECT * FROM harga_jual_kredit WHERE id_harga_jual=$id");
while($row=mysql_fetch_array($sql)){
	$harga_kredit=$row['harga_kredit'];
	$hari=$row['hari'];
	$sql2=mysql_query("INSERT INTO hj_kredit_detail VALUES(null,$id,'$tanggal',$harga_kredit,$hari)");
}
$sql=mysql_query("DELETE FROM harga_jual_kredit WHERE id_harga_jual=$id");
?>