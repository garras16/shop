<?php
//----------------------------------------------------------------------

$sql = "SELECT id_beli, qty FROM beli_detail WHERE id_beli_detail=$id";
$q = mysql_query($sql);
$r=mysql_fetch_array($q);
$qty1=$r['qty'];
$id_beli=$r['id_beli'];

$sql = "SELECT id_barang_masuk, qty_datang FROM barang_masuk WHERE id_beli_detail=$id AND edit=1 ORDER BY id_barang_masuk ASC";
$q = mysql_query($sql);
$r=mysql_fetch_array($q);
$id_barang_masuk=$r['id_barang_masuk'];
$qty_datang=$r['qty_datang'];

if (mysql_num_rows($q)==0){
	_direct("?page=gudang&mode=konfirm_beli_3&id=" .$id_beli);
}

$sql = "SELECT SUM(qty_di_rak) AS qty_di_rak FROM barang_masuk_rak WHERE id_barang_masuk=$id_barang_masuk";
$q = mysql_query($sql);
$r=mysql_fetch_array($q);
$qty2=$r['qty_di_rak'];
if ($qty2=='') $qty2=0;
$x=$qty_datang-$qty2;

$sql = "SELECT
    SUM(barang_masuk_rak.qty_di_rak) AS qty_di_rak
FROM
    barang_masuk_rak
    INNER JOIN barang_masuk 
        ON (barang_masuk_rak.id_barang_masuk = barang_masuk.id_barang_masuk) 
WHERE id_beli_detail=$id";
$q = mysql_query($sql);
$r=mysql_fetch_array($q);

if ($qty1==$r['qty_di_rak']){
	$sql = "UPDATE beli_detail SET status_barang=1 WHERE id_beli_detail=$id";
	$q = mysql_query($sql);
} else {
	$sql = "UPDATE beli_detail SET status_barang=2 WHERE id_beli_detail=$id";
	$q = mysql_query($sql);
}

//---------------------------------------------------------------------------------------------
$sql = "SELECT id_beli, status_barang FROM beli_detail WHERE id_beli=$id_beli";
$q = mysql_query($sql);
$jml_baris=mysql_num_rows($q);
$baris_sukses=0;
$baris_pending=0;
while ($r=mysql_fetch_array($q)){
	if ($r['status_barang']==1) $baris_sukses+=1;
	if ($r['status_barang']==2) $baris_pending+=1;
}
$status_konfirm=0;
if ($baris_sukses==$jml_baris){
	$status_konfirm=1;
} else if ($baris_pending>0 || $baris_sukses>0){
	$status_konfirm=2;
}
$sql = "UPDATE beli SET status_konfirm=$status_konfirm WHERE id_beli=$id_beli";
$q = mysql_query($sql);

//---------------------------------------------------------------------------------------------
if ($qty1==$qty2){
	_direct("?page=gudang&mode=konfirm_beli_3&id=" .$id_beli);
}
if (isset($edit_konfirm_beli_5_post) && $qty_datang==$qty2){
	$sql = "UPDATE barang_masuk SET edit=0 WHERE id_barang_masuk=$id_barang_masuk";
	$q = mysql_query($sql);
	_direct("?page=gudang&mode=konfirm_beli_3&id=" .$id_beli);
}
//-----------------------------------------------------------------------------------------------

$sql=mysql_query("SELECT
    beli_detail.id_beli_detail
    , beli_detail.qty
    , satuan.nama_satuan
    , barang_masuk.id_barang_masuk
    , barang_masuk.qty_datang
    , SUM(barang_masuk_rak.qty_di_rak) AS qty_di_rak
FROM
    beli_detail
    INNER JOIN barang_supplier 
        ON (beli_detail.id_barang_supplier = barang_supplier.id_barang_supplier)
    INNER JOIN barang 
        ON (barang_supplier.id_barang = barang.id_barang)
    INNER JOIN satuan 
        ON (barang.id_satuan = satuan.id_satuan)
    LEFT JOIN barang_masuk 
        ON (barang_masuk.id_beli_detail = beli_detail.id_beli_detail)
    LEFT JOIN barang_masuk_rak 
        ON (barang_masuk_rak.id_barang_masuk = barang_masuk.id_barang_masuk)
WHERE beli_detail.id_beli_detail=$id AND barang_masuk.edit=1
ORDER BY barang_masuk.id_barang_masuk ASC");
$row=mysql_fetch_array($sql);
$nama_satuan=$row['nama_satuan'];
$id_barang_masuk=$row['id_barang_masuk'];
$qty_datang=$row['qty_datang'];
$total_qty_di_rak=$row['qty_di_rak'];
?>