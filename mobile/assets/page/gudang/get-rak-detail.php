<?php
$id=$_GET['id_beli_detail'];
require_once('../../../assets/inc/config.php');
?>
<!--div class="table-responsive"-->
<table class="table table-bordered table-striped">
	<thead>
		<tr>
			<th>Gudang</th>
			<th>Rak</th>
			<th>Qty Datang</th>
			<th>Qty di Rak</th>
			<th>Berat (gr)</th>
			<th>Volume (cm3)</th>
			<th>Tgl Datang</th>
			<th>Tgl Exp.</th>
		</tr>
	</thead>
	<tbody>
<?php
$sql=mysql_query("SELECT
    barang_masuk.tgl_datang
    , barang_masuk.edit
    , barang_masuk.qty_datang
    , barang_masuk.id_barang_masuk
    , barang_masuk.berat
    , barang_masuk.volume
    , barang_masuk_rak.stok
    , barang_masuk_rak.expire
    , satuan.nama_satuan
    , gudang.nama_gudang
    , rak.nama_rak
FROM
    barang_masuk_rak
    INNER JOIN barang_masuk 
        ON (barang_masuk_rak.id_barang_masuk = barang_masuk.id_barang_masuk)
    INNER JOIN rak 
        ON (barang_masuk_rak.id_rak = rak.id_rak)
    INNER JOIN gudang 
        ON (rak.id_gudang = gudang.id_gudang)
    INNER JOIN beli_detail 
        ON (barang_masuk.id_beli_detail = beli_detail.id_beli_detail)
    INNER JOIN barang_supplier 
        ON (beli_detail.id_barang_supplier = barang_supplier.id_barang_supplier)
    INNER JOIN barang 
        ON (barang_supplier.id_barang = barang.id_barang)
    INNER JOIN satuan 
        ON (barang.id_satuan = satuan.id_satuan) WHERE barang_masuk.id_beli_detail=$id AND barang_masuk_rak.stok>0");
$test='';
while($row=mysql_fetch_array($sql)){
$id_barang_masuk=$row['id_barang_masuk'];
$val3="";
if ($row['edit']=='1') $val3="color: red; font-weight:bold";
$sql2=mysql_query("SELECT
    barang_masuk.qty_datang
    , barang_masuk_rak.stok
FROM
    barang_masuk_rak
    INNER JOIN barang_masuk 
        ON (barang_masuk_rak.id_barang_masuk = barang_masuk.id_barang_masuk)
WHERE barang_masuk.id_barang_masuk=$id_barang_masuk AND barang_masuk_rak.stok>0");
$r=mysql_num_rows($sql2);
	echo '			<tr>
						<td><div style="min-width:70px; ' .$val3. '">' .$row['nama_gudang']. '</div></td>
						<td><div style="min-width:70px; ' .$val3. '">' .$row['nama_rak']. '</div></td>';
	if ($test != $id_barang_masuk){
		echo '			<td style="vertical-align:middle;text-align:center; ' .$val3. '" rowspan="' . $r . '"><div style="min-width:70px">' .$row['qty_datang']. ' ' .$row['nama_satuan']. '</div></td>';
		$test = $id_barang_masuk;
	}
	echo '				<td><div style="min-width:70px; ' .$val3. '">' .$row['stok']. ' ' .$row['nama_satuan']. '</div></td>
						<td><div style="min-width:70px; ' .$val3. '">' .$row['berat']. '</div></td>
						<td><div style="min-width:70px; ' .$val3. '">' .$row['volume']. '</div></td>
						<td><div style="min-width:70px; ' .$val3. '">' .date("d-m-Y",strtotime($row['tgl_datang'])). '</div></td>
						<td><div style="min-width:70px; ' .$val3. '">' .date("d-m-Y",strtotime($row['expire'])). '</div></td>';
	echo '			</tr>';
}
?>

	</tbody>
</table>
<!--/div-->
