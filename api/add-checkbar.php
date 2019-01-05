<?php
date_default_timezone_set('Asia/Jakarta');
require_once('../assets/inc/config.php');
$tanggal=date('Y-m-d H:i:s');
$gps=$_POST['gps'];
$sales=$_POST['sales'];
$kota=$_POST['kota'];
$barcode=$_POST['barcode'];
$nama_customer=$_POST['nama'];
$sql=mysql_query("INSERT INTO checkin (tanggal, barcode, customer, sales, gps, kota) VALUES('$tanggal','$barcode','$nama_customer','$sales','$gps','$kota')");
if ($sql) {
	echo "sukses";
} else {
	echo "gagal";
}

?>