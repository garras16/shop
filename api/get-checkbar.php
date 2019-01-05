<?php
date_default_timezone_set('Asia/Jakarta');
require_once('../assets/inc/config.php');
$barcode=$_POST['barcode'];
$sql=mysql_query("SELECT nama FROM customer WHERE barcode='$barcode'");
$row=mysql_fetch_array($sql);
$nama=$row["nama"];
echo $nama;
?>