<?php
session_start();
date_default_timezone_set('Asia/Jakarta');
require_once('../../../assets/inc/config.php');
require_once('../../../assets/inc/publicfunc.php');

$id=$_GET['id'];

function del_nota($id){
$sql=mysqli_query($con, "SELECT * FROM jual INNER JOIN pelanggan ON (jual.id_pelanggan = pelanggan.id_pelanggan) WHERE id_jual=$id");
$row=mysqli_fetch_array($sql);

$id_sales=$row['id_karyawan'];
$pelanggan=$row['nama_pelanggan'];
$tanggal=date("Y-m-d H:i:s");
$judul='Ada nota jual yang dihapus secara otomatis';
$pesan='Tipe\t\t: Dalam Kota\r\nNama Toko\t: ' .$pelanggan. '\r\n';

$sql=mysqli_query($con, "SELECT *
FROM
    jual_detail
    INNER JOIN harga_jual 
        ON (jual_detail.id_harga_jual = harga_jual.id_harga_jual)
    INNER JOIN barang_supplier 
        ON (harga_jual.id_barang_supplier = barang_supplier.id_barang_supplier)
    INNER JOIN barang 
        ON (barang_supplier.id_barang = barang.id_barang)
    INNER JOIN satuan 
        ON (barang.id_satuan = satuan.id_satuan)
WHERE id_jual=$id");

if (mysqli_num_rows($sql)>0){
	$pesan.='Alasan\t\t: Nota menjadi kosong karena semua barang tidak aktif\r\n\r\n';
	$pesan.='Rincian Barang\t: \r\n';
} else {
	$pesan.='Alasan\t\t: Nota kosong.\r\n\r\n';
}
while ($row=mysqli_fetch_array($sql)){
	$pesan.=$row['nama_barang']. '\r\n\t' .$row['qty']. ' ' .$row['nama_satuan']. '\r\n' ;
}

$sql=mysqli_query($con, "INSERT INTO pesan VALUES (null,'$tanggal',$id_sales,'$judul','$pesan',0)");

$sql=mysqli_query($con, "DELETE FROM jual_detail WHERE id_jual=$id");
$sql=mysqli_query($con, "DELETE FROM jual WHERE id_jual=$id");

_alert("Ada nota yang dihapus karena semua barang tidak aktif");
}
$sqlx=mysqli_query($con, "SELECT *
FROM
    jual
    INNER JOIN jual_detail 
        ON (jual.id_jual = jual_detail.id_jual)
    INNER JOIN harga_jual 
        ON (jual_detail.id_harga_jual = harga_jual.id_harga_jual)
    INNER JOIN barang_supplier 
        ON (harga_jual.id_barang_supplier = barang_supplier.id_barang_supplier)
    INNER JOIN barang 
        ON (barang_supplier.id_barang = barang.id_barang)
 WHERE jual.id_jual=$id AND barang.status=1");
$del_on_exit=false;
if (mysqli_num_rows($sqlx)=='0') $del_on_exit=true;
$sqlx=mysqli_query($con, "SELECT * FROM jual_detail WHERE id_jual=$id");
if (mysqli_num_rows($sqlx)=='0') $del_on_exit=true;
if ($del_on_exit) del_nota($id);
?>