<?php
require_once('../../../assets/inc/config.php');
$id_barang_masuk_rak=$_GET['id_barang_masuk_rak'];
$sql=mysqli_query($con, "SELECT id_barang_masuk FROM barang_masuk_rak WHERE id_barang_masuk_rak=$id_barang_masuk_rak");
$r=mysqli_fetch_array($sql);
$id_barang_masuk=$r['id_barang_masuk'];
$sql="DELETE FROM barang_masuk_rak WHERE id_barang_masuk_rak=$id_barang_masuk_rak";
$q=mysqli_query($con, $sql);
if ($q) $sql=mysqli_query($con, "UPDATE barang_masuk SET edit=1 WHERE id_barang_masuk=$id_barang_masuk");
?>