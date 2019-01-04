<?php
date_default_timezone_set('Asia/Jakarta');
require_once('../../../assets/inc/config.php');
require_once('../../../assets/inc/publicfunc.php');
$id=$_GET['id'];
$id_beli=$_GET['id-beli'];
$mode=$_GET['mode'];
$sql=mysqli_query($con, "DELETE FROM beli_detail WHERE id_beli_detail=$id");
if ($sql) {
	if ($mode=='view_detail') _direct('?page=pembelian&mode=view_detail&id=' .$id_beli);
	if ($mode=='view_add') _direct('?page=pembelian&mode=view_add&id=' .$id_beli);
} else {
	echo "GAGAL MENGHAPUS DETAIL BARANG";
}
?>