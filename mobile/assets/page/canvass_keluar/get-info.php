<?php
date_default_timezone_set('Asia/Jakarta');
require_once('../../../assets/inc/config.php');
$barcode=$_GET['kode'];
$sql=mysqli_query($con, "SELECT id_pelanggan,nama_pelanggan FROM pelanggan WHERE barcode='$barcode'");
$row=mysqli_fetch_array($sql);
$id=$row["id_pelanggan"];
echo $id;
?>