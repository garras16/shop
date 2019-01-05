<?php
date_default_timezone_set('Asia/Jakarta');
require_once('../assets/inc/config.php');
$id_session=$_POST['id_session'];
$id_produk=$_POST['id_produk'];
$jumlah=$_POST['jumlah'];
$harga=$_POST['harga'];
$sql=mysql_query("INSERT INTO keranjang (id_produk, jumlah, harga, id_session) VALUES('$id_produk','$jumlah','$harga','$id_session')");
if ($sql) {
	echo "sukses";
} else {
	echo "gagal";
}

?>