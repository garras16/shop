<?php
date_default_timezone_set('Asia/Jakarta');
require_once('../inc/config.php');
?>
<table id="table1" class="table table-bordered table-striped" style="table-layout:fixed">
	<thead>
		<tr>
			<th>Tgl. Nota Beli</th>
			<th>No Nota Beli</th>
			<th>Nama Ekspedisi</th>
			<th>Status</th>
		</tr>
	</thead>
<tbody>
<?php
if (isset($_GET['dari'])){
	$dari=date("Y-m-d", strtotime($_GET['dari']));
	$sampai=date("Y-m-d", strtotime($_GET['sampai']));
	$val="(tanggal BETWEEN '$dari' AND '$sampai')";
} else {
	$val="MONTH(tanggal)=MONTH(CURRENT_DATE()) AND YEAR(tanggal)=YEAR(CURRENT_DATE())";
}

$sql=mysqli_query($con, "SELECT
    beli.id_beli
    , beli.no_nota_beli
    , beli.tanggal
	, beli.status_konfirm
	, ekspedisi.nama_ekspedisi
FROM
    beli
	LEFT JOIN ekspedisi 
        ON (beli.id_ekspedisi = ekspedisi.id_ekspedisi) 
WHERE $val");
while($row=mysqli_fetch_array($sql)){
if ($row['status_konfirm']==0){
	$status="";
} else if ($row['status_konfirm']==1){
	$status="SELESAI"; $warna='1E824C';
} else if ($row['status_konfirm']==2){
	$status="MENUNGGU"; $warna='337AB7';
}
	echo '			<tr>
						<td><a href="?page=gudang&mode=konfirm_beli_2&id=' .$row['id_beli']. '"><div style="min-width:70px">&nbsp;' .date("d-m-Y",strtotime($row['tanggal'])). '</div></a></td>
						<td><a href="?page=gudang&mode=konfirm_beli_2&id=' .$row['id_beli']. '"><div style="min-width:70px">&nbsp;' .$row['no_nota_beli']. '</div></a></td>
						<td><a href="?page=gudang&mode=konfirm_beli_2&id=' .$row['id_beli']. '"><div style="min-width:70px">&nbsp;' .$row['nama_ekspedisi']. '</div></a></td>';
	if ($status==""){
		echo '			<td><a href="?page=gudang&mode=konfirm_beli_2&id=' .$row['id_beli']. '"><div style="min-width:70px">&nbsp;</div></a></td>';
	} else {
		echo '			<td><a href="?page=gudang&mode=konfirm_beli_2&id=' .$row['id_beli']. '" class="badge btn-xs bg-xs" style="background-color: #' .$warna. '"><div style="min-width:70px">&nbsp;' .$status. '</div></a></td>';
	}
	echo '				</tr>';
}
?>
	</tbody>
</table>