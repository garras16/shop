<?php
date_default_timezone_set('Asia/Jakarta');
require_once('../../../assets/inc/config.php');
$id=$_GET['id'];
$canvass=$_GET['canvass'];
?>
	<table class="table table-bordered table-striped">
		<thead>
			<tr>
				<th>Tgl Exp.</th>
				<th>Qty</th>
				<th>Qty Total</th>
			</tr>
		</thead>
		<tbody>
<?php
$test2="";
//-----------------------------------------------------------------------------------------

$sql=mysqli_query($con, "SELECT SUM(stok) AS stok
FROM
    canvass_keluar
    INNER JOIN canvass_keluar_barang 
        ON (canvass_keluar.id_canvass_keluar = canvass_keluar_barang.id_canvass_keluar)
WHERE canvass_keluar.id_canvass_keluar=$canvass AND canvass_keluar_barang.id_barang=$id AND stok>0
GROUP BY canvass_keluar_barang.id_barang,expire");
$qty_total=0;$count_qty=0;
while($r=mysqli_fetch_array($sql)){
	$qty_total+=$r['stok'];
	$count_qty+=1;
}
$sql=mysqli_query($con, "SELECT SUM(qty_cek) AS qty_cek FROM lap_stock_opname WHERE id_canvass_keluar=$canvass AND id_barang=$id");
$r=mysqli_fetch_array($sql);
$total_qty_cek=$r['qty_cek'];

$sql=mysqli_query($con, "SELECT barang.id_barang,expire,nama_satuan,SUM(stok) AS total
FROM
    canvass_keluar
    INNER JOIN canvass_keluar_barang 
        ON (canvass_keluar.id_canvass_keluar = canvass_keluar_barang.id_canvass_keluar)
    INNER JOIN barang 
        ON (canvass_keluar_barang.id_barang = barang.id_barang)
    INNER JOIN satuan 
        ON (barang.id_satuan = satuan.id_satuan)
WHERE canvass_keluar.id_canvass_keluar=$canvass AND barang.id_barang=$id
GROUP BY barang.id_barang,expire");
while($r=mysqli_fetch_array($sql)){
$sql2=mysqli_query($con, "SELECT SUM(qty_cek) AS qty_cek FROM lap_stock_opname WHERE id_canvass_keluar=$canvass AND id_barang=" .$r['id_barang']. " AND expire='" .$r['expire']. "'");
$row2=mysqli_fetch_array($sql2);
	echo '<tr>
			<td><div style="min-width:70px">' .date("d-m-Y",strtotime($r['expire'])). '</div></td>
			<td><div style="min-width:70px">' .($r['total']-$row2['qty_cek']). ' ' .$r['nama_satuan']. '</div></td>';
	if ($test2==''){
		echo '	<td style="vertical-align:middle;text-align:center" rowspan="' .$count_qty. '">' .($qty_total-$total_qty_cek). '</td>';
		$test2="1";
	}
	echo '</tr>';
}

?>
						
		</tbody>
	</table>
