<?php
date_default_timezone_set('Asia/Jakarta');
require_once('../../../assets/inc/config.php');
$barcode=$_GET['kode'];
$sql=mysqli_query($con, "SELECT nama_pelanggan FROM pelanggan WHERE barcode='$barcode'");
$row=mysqli_fetch_array($sql);
$nama=$row["nama_pelanggan"];
echo $nama;
?>