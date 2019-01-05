<?php
$sql=mysql_query("DELETE FROM canvass_keluar_barang WHERE qty=0 AND qty_cek=0 AND stok=0");
?>
<div class="right_col" role="main">
	<div class="">
	
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<h3>LIHAT STOK CANVASS</h3>
						<?php
							if (isset($pesan)){
								echo '<span class="badge bg-' .$warna. '">' .$pesan. '</span>';
							}
						?>
					<div class="clearfix"></div>
					</div>
					<div class="x_content">
					<div class="alert alert-info">
					  <strong>Klik kolom pada tabel untuk detail.</strong>
					</div>
				<div class="table responsive">
				<table id="table1" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>Tgl Canvass</th>
						<th>Nama Kendaraan</th>
						<th>No Pol</th>
					</tr>
				</thead>
				<tbody>
				<?php
$sql=mysql_query("SELECT canvass_keluar.id_canvass_keluar,tanggal_canvass,nama_kendaraan,plat,canvass_keluar.status
FROM
    canvass_keluar
    INNER JOIN kendaraan 
        ON (canvass_keluar.id_mobil = kendaraan.id_kendaraan)
	INNER JOIN canvass_keluar_barang 
        ON (canvass_keluar.id_canvass_keluar = canvass_keluar_barang.id_canvass_keluar)
	LEFT JOIN lap_stock_opname 
        ON (canvass_keluar.id_canvass_keluar = lap_stock_opname.id_canvass_keluar)
WHERE canvass_keluar.status>0 AND canvass_keluar.status<=4
GROUP BY canvass_keluar.id_canvass_keluar
HAVING SUM(selisih)<>0 OR canvass_keluar.status<4
ORDER BY canvass_keluar.id_canvass_keluar DESC");
while($row=mysql_fetch_array($sql)){
	echo '			<tr>
						<td><a href="?page=canvass&mode=stok_barang&id=' .$row['id_canvass_keluar']. '"><div style="min-width:70px">' .date("d-m-Y",strtotime($row['tanggal_canvass'])). '</div></a></td>
						<td><a href="?page=canvass&mode=stok_barang&id=' .$row['id_canvass_keluar']. '"><div style="min-width:70px">' .$row['nama_kendaraan']. '</div></a></td>
						<td><a href="?page=canvass&mode=stok_barang&id=' .$row['id_canvass_keluar']. '"><div style="min-width:70px">' .$row['plat']. '</div></a></td>
					</tr>';
}
?>
					
				</tbody>
			</table>
			
			</div>
			</div>
			<div id="dummy"></div>
			</div>
			</div>
		</div>	
	</div>
</div>

<script>
$(document).ready(function(){
	
});
</script>
