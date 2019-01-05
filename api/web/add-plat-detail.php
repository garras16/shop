<?php
date_default_timezone_set('Asia/Jakarta');
require_once('../../assets/inc/config.php');

$id=$_GET['id'];
$plat=$_GET['plat1']. ' ' .$_GET['plat2']. ' ' .$_GET['plat3'];
$tgl = date("Y-m-d");
$sql = "INSERT INTO plat_detail VALUES(null,'$tgl',$id,'$plat')";
$q = mysql_query($sql);
?>