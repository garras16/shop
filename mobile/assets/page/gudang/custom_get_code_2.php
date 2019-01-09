<?php
//----------------------------------------------------------------------
$id_barang_masuk=$_GET['id_barang_masuk'];
$sql = "SELECT id_beli, qty, status_barang FROM beli_detail WHERE id_beli_detail=$id";
$q = mysqli_query($con, $sql);
$r=mysqli_fetch_array($q);
$qty1=$r['qty'];
$id_beli=$r['id_beli'];
$status_barang=$r['status_barang'];

$sql = "SELECT qty_datang FROM barang_masuk WHERE id_barang_masuk=$id_barang_masuk";
$q = mysqli_query($con, $sql);
$r=mysqli_fetch_array($q);
$qty_datang=$r['qty_datang'];

$sql = "SELECT SUM(qty_di_rak) AS qty_di_rak FROM barang_masuk_rak WHERE id_barang_masuk=$id_barang_masuk";
$q = mysqli_query($con, $sql);
$r=mysqli_fetch_array($q);
$qty2=$r['qty_di_rak'];
if ($qty2=='') $qty2=0;
$x=$qty_datang-$qty2;

$sql = "SELECT
    SUM(barang_masuk_rak.qty_di_rak) AS qty_di_rak
FROM
    barang_masuk_rak
    INNER JOIN barang_masuk 
        ON (barang_masuk_rak.id_barang_masuk = barang_masuk.id_barang_masuk) WHERE id_beli_detail=$id";
$q = mysqli_query($con, $sql);
$r=mysqli_fetch_array($q);

if ($qty1==$r['qty_di_rak']){
	if ($status_barang!="1"){
		$sqlX = "SELECT
    barang_masuk_rak.id_barang_masuk_rak
    , barang_masuk_rak.qty_di_rak
FROM
    barang_masuk
    INNER JOIN beli_detail 
        ON (barang_masuk.id_beli_detail = beli_detail.id_beli_detail)
    INNER JOIN barang_masuk_rak 
        ON (barang_masuk_rak.id_barang_masuk = barang_masuk.id_barang_masuk)
	WHERE barang_masuk.id_beli_detail=$id";
		$qX = mysqli_query($con, $sqlX);
		while ($abc=mysqli_fetch_array($qX)){
			$tmp_id_barang_masuk_rak=$abc['id_barang_masuk_rak'];
			$tmp_qty_di_rak=$abc['qty_di_rak'];
			if ($tmp_qty_di_rak<0){
				tulis_log(date('d-m-Y H:i'). ' Stok minus custom_get_code_2 id_beli_detail=' .$id);
				tulis_log("UPDATE barang_masuk_rak SET stok=" .$tmp_qty_di_rak. " WHERE id_barang_masuk_rak=" .$tmp_id_barang_masuk_rak);
			}
			$sqlY = "UPDATE barang_masuk_rak SET stok=$tmp_qty_di_rak WHERE id_barang_masuk_rak=$tmp_id_barang_masuk_rak";
			$qY = mysqli_query($con, $sqlY);
		}
	}
	$sql = "UPDATE beli_detail SET status_barang=1 WHERE id_beli_detail=$id";
	$q = mysqli_query($con, $sql);
} else {
	$sql = "UPDATE beli_detail SET status_barang=2 WHERE id_beli_detail=$id";
	$q = mysqli_query($con, $sql);
}

//---------------------------------------------------------------------------------------------
$sql = "SELECT id_beli, status_barang FROM beli_detail WHERE id_beli=$id_beli";
$q = mysqli_query($con, $sql);
$jml_baris=mysqli_num_rows($q);
$baris_sukses=0;
$baris_pending=0;
while ($r=mysqli_fetch_array($q)){
	if ($r['status_barang']==1) $baris_sukses+=1;
	if ($r['status_barang']==2) $baris_pending+=1;
}
$status_konfirm=0;
if ($baris_sukses==$jml_baris){
	$status_konfirm=2;
} else if ($baris_pending>0 || $baris_sukses>0){
	$status_konfirm=2;
}
$sql = "UPDATE beli SET status_konfirm=$status_konfirm WHERE id_beli=$id_beli";
$q = mysqli_query($con, $sql);

//---------------------------------------------------------------------------------------------
if ($qty1==$qty2){
	_clearHistory();
	_direct("?page=gudang&mode=konfirm_beli_3&id=" .$id_beli);
}
if ($qty_datang==$qty2){
//if (isset($edit_konfirm_beli_5_post) && $qty_datang==$qty2){
	$sql = "UPDATE barang_masuk SET edit=0 WHERE id_barang_masuk=$id_barang_masuk";
	$q = mysqli_query($con, $sql);
	_clearHistory();
	_direct("?page=gudang&mode=konfirm_beli_5&id=" .$id);
//	_direct("?page=gudang&mode=konfirm_beli_3&id=" .$id_beli);
}
//-----------------------------------------------------------------------------------------------

$sql=mysqli_query($con, "SELECT
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
WHERE barang_masuk.id_barang_masuk=$id_barang_masuk
ORDER BY barang_masuk.id_barang_masuk ASC");
$row=mysqli_fetch_array($sql);
$nama_satuan=$row['nama_satuan'];
//$id_barang_masuk=$row['id_barang_masuk'];
$qty_datang=$row['qty_datang'];
$total_qty_di_rak=$row['qty_di_rak'];
?>