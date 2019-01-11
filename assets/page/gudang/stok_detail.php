<?php
date_default_timezone_set('Asia/Jakarta');
require_once('../../../assets/inc/config.php');
$id=$_GET['id'];
?>
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Gudang</th>
            <th>Rak</th>
            <th>Qty di Rak</th>
            <th>Tgl Datang</th>
            <th>Tgl Exp.</th>
            <th>Qty Total</th>
        </tr>
    </thead>
    <tbody>
        <?php
$test2="";
//-----------------------------------------------------------------------------------------

$sql4=mysqli_query($con, "SELECT
    SUM(barang_masuk_rak.stok) AS stok
FROM
    barang_masuk
    INNER JOIN beli_detail 
        ON (barang_masuk.id_beli_detail = beli_detail.id_beli_detail)
    INNER JOIN barang_supplier 
        ON (beli_detail.id_barang_supplier = barang_supplier.id_barang_supplier)
    INNER JOIN barang 
        ON (barang_supplier.id_barang = barang.id_barang)
    LEFT JOIN barang_masuk_rak 
        ON (barang_masuk_rak.id_barang_masuk = barang_masuk.id_barang_masuk)
WHERE barang.id_barang=$id AND barang_masuk_rak.stok>0
GROUP BY id_rak,expire,tgl_datang");
$qty_total=0;$count_qty=0;
while($r=mysqli_fetch_array($sql4)){
	$qty_total+=$r['stok'];
	$count_qty+=1;
}
	$sql4=mysqli_query($con, "SELECT
    *,SUM(barang_masuk_rak.stok) AS total_stok
FROM
    barang_masuk
    INNER JOIN beli_detail 
        ON (barang_masuk.id_beli_detail = beli_detail.id_beli_detail)
    INNER JOIN barang_supplier 
        ON (beli_detail.id_barang_supplier = barang_supplier.id_barang_supplier)
    INNER JOIN barang 
        ON (barang_supplier.id_barang = barang.id_barang)
    LEFT JOIN barang_masuk_rak 
        ON (barang_masuk_rak.id_barang_masuk = barang_masuk.id_barang_masuk)
	INNER JOIN rak 
        ON (barang_masuk_rak.id_rak = rak.id_rak)
    INNER JOIN gudang 
        ON (rak.id_gudang = gudang.id_gudang)
    INNER JOIN satuan 
        ON (barang.id_satuan = satuan.id_satuan)
WHERE barang.id_barang=$id AND barang_masuk_rak.stok>0
GROUP BY barang_masuk_rak.id_rak,expire,tgl_datang");
	while($r=mysqli_fetch_array($sql4)){
		echo '<tr>
				<td><div style="min-width:70px">' .$r['nama_gudang']. '</div></td>
				<td><div style="min-width:70px">' .$r['nama_rak']. '</div></td>';
		echo '	<td><div style="min-width:70px">' .$r['total_stok']. ' ' .$r['nama_satuan']. '</div></td>
				<td><div style="min-width:70px">' .date("d-m-Y",strtotime($r['tgl_datang'])). '</div></td>';
		echo '	<td><div style="min-width:70px">' .date("d-m-Y",strtotime($r['expire'])). '</div></td>';
		if ($test2==''){
			echo '	<td style="vertical-align:middle;text-align:center" rowspan="' .$count_qty. '">' .$qty_total. '</td>';
			$test2="1";
		}
		echo '</tr>';
	}

?>

    </tbody>
</table>