<?php
	date_default_timezone_set('Asia/Jakarta');
	require_once('../../assets/inc/config.php');
	if (isset($_GET['id_negara'])){
		$id=$_GET['id_negara'];
		$table="provinsi";
		$table_id="id_negara";
		$row_id="id_prov";
		$row_nama="nama_prov";
	} else if (isset($_GET['id_prov'])){
		$id=$_GET['id_prov'];
		$table="kabupaten";
		$table_id="id_prov";
		$row_id="id_kab";
		$row_nama="nama_kab";
	} else if (isset($_GET['id_kab'])){
		$id=$_GET['id_kab'];
		$table="kecamatan";
		$table_id="id_kab";
		$row_id="id_kec";
		$row_nama="nama_kec";
	} else if (isset($_GET['id_kec'])){
		$id=$_GET['id_kec'];
		$table="kelurahan";
		$table_id="id_kec";
		$row_id="id_kel";
		$row_nama="nama_kel";
	} else {
		die();
	}
	$sql=mysqli_query($con, "SELECT * FROM $table WHERE $table_id='$id'");
	echo '<option value="" disabled selected>Pilih ' .$table. '</option>';
	while ($row=mysqli_fetch_array($sql)){
		echo '<option value="' .$row[$row_id]. '">' .$row[$row_nama]. '</option>';
	}
?>