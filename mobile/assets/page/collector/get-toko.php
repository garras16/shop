<?php
session_start();
date_default_timezone_set('Asia/Jakarta');
require_once('../../../assets/inc/config.php');
require_once('../../../assets/inc/publicfunc.php');
$id_karyawan=$_SESSION['id_karyawan'];
if (!isset($_GET['code'])) die();
$barcode=$_GET['code'];

$sql = mysqli_query($con, "SELECT *,SUM(bayar) AS bayar
FROM
    penagihan
    INNER JOIN penagihan_detail 
        ON (penagihan.id_penagihan = penagihan_detail.id_penagihan)
	INNER JOIN jual 
        ON (penagihan_detail.id_jual = jual.id_jual)
    INNER JOIN pelanggan 
        ON (jual.id_pelanggan = pelanggan.id_pelanggan)
WHERE penagihan.id_karyawan=$id_karyawan AND pelanggan.barcode='$barcode'
GROUP BY jual.id_jual");
	if (mysqli_num_rows($sql)=='0') die();
	echo 'success';
	?>
