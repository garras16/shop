<?php
	date_default_timezone_set('Asia/Jakarta');
	require_once('../assets/inc/config.php');
	$id_keranjang=$_POST['id_keranjang'];
	$sql=mysqli_query($con, "DELETE FROM keranjang WHERE id_keranjang='$id_keranjang'");
	if ($sql) {
		echo "sukses";
	} else {
		echo "gagal";
	}
?>