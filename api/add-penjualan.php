<?php
date_default_timezone_set('Asia/Jakarta');
require_once('../assets/inc/config.php');
$id_session=$_POST['id_session'];
$invoice=$_POST['invoice'];
$customer=$_POST['customer'];
$sales=$_POST['sales'];
$total=$_POST['total'];
//$bayar=$_POST['bayar'];
$keterangan=$_POST['keterangan'];
$tgl_nota=date("Y/m/d");
$sql=mysql_query("INSERT INTO jual (tgl_nota,invoice, customer, sales, total, keterangan) VALUES('$tgl_nota','$invoice','$customer','$sales','$total','$keterangan')");
$id_jual=mysql_insert_id();

$sql=mysql_query("SELECT * FROM keranjang WHERE id_session='$id_session'");
while ($row=mysql_fetch_array($sql)){
	$id_produk=$row['id_produk'];
	$jumlah=$row['jumlah'];
	$harga=$row['harga'];
	$jumlah_bayar=$jumlah * $harga;
	
	$sql2=mysql_query("SELECT * FROM barang WHERE id_barang='$id_produk'");
	$row2=mysql_fetch_array($sql2);
	$nama_barang=$row2['nama_barang'];
	$barcode=$row2['barcode'];
	$satuan=$row2['satuan'];
	
	$sql3=mysql_query("INSERT INTO jual_detail (id_jual,barcode,nama,satuan,qty,harga,jumlah) VALUES($id_jual,'$barcode','$nama_barang','$satuan',$jumlah,$harga,$jumlah_bayar)");
	if ($sql3){
		echo "sukses";
	} else {
		echo "gagal";
	}
}
$sql=mysql_query("DELETE FROM keranjang WHERE id_session='$id_session'");
?>