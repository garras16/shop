<?php
$id_karyawan=$_SESSION['id_karyawan'];
?>
<div class="right_col loading" role="main">
	<div class="">
	
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<div class="col-md-6">
							<h3>RINGKASAN STOCK OPNAME (CANVASS)</h3>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<div class="table-responsive">
						<table class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>Tgl Canvass</th>
									<th>Tgl Stock Opname</th>
									<th>Nama Mobil</th>
									<th>No Pol</th>
									<th>Nama Karyawan</th>
								</tr>
							</thead>
							<tbody>
<?php
	$sql=mysql_query("SELECT canvass_keluar.id_canvass_keluar,tgl_lap,tanggal_canvass,nama_kendaraan,plat
FROM
    lap_stock_opname
    INNER JOIN canvass_keluar 
        ON (lap_stock_opname.id_canvass_keluar = canvass_keluar.id_canvass_keluar)
    INNER JOIN kendaraan 
        ON (canvass_keluar.id_mobil = kendaraan.id_kendaraan)
GROUP BY lap_stock_opname.id_canvass_keluar
ORDER BY lap_stock_opname.id_canvass_keluar DESC");
	while ($row=mysql_fetch_array($sql)){
	$sql2=mysql_query("SELECT nama_karyawan,nama_jabatan
FROM
    canvass_keluar_karyawan
    INNER JOIN karyawan 
        ON (canvass_keluar_karyawan.id_karyawan = karyawan.id_karyawan)
    INNER JOIN jabatan 
        ON (karyawan.id_jabatan = jabatan.id_jabatan)
WHERE id_canvass_keluar=" .$row['id_canvass_keluar']);
	echo '<tr>
				<td style="vertical-align:middle;text-align:center;"><a href="?page=laporan&mode=lap_stock_opname_2&id=' .$row['id_canvass_keluar']. '"><div style="min-width:70px">' .date("d-m-Y",strtotime($row['tanggal_canvass'])). '</div></a></td>
				<td style="vertical-align:middle;text-align:center;"><a href="?page=laporan&mode=lap_stock_opname_2&id=' .$row['id_canvass_keluar']. '"><div style="min-width:70px">' .date("d-m-Y",strtotime($row['tgl_lap'])). '</div></a></td>
				<td style="vertical-align:middle;text-align:center;"><a href="?page=laporan&mode=lap_stock_opname_2&id=' .$row['id_canvass_keluar']. '"><div style="min-width:70px">' .$row['nama_kendaraan']. '</div></a></td>
				<td style="vertical-align:middle;text-align:center;"><a href="?page=laporan&mode=lap_stock_opname_2&id=' .$row['id_canvass_keluar']. '"><div style="min-width:70px">' .$row['plat']. '</div></a></td>
				<td style="vertical-align:middle;text-align:left;"><a href="?page=laporan&mode=lap_stock_opname_2&id=' .$row['id_canvass_keluar']. '"><div style="min-width:70px">';
	while ($row2=mysql_fetch_array($sql2)){
		echo '- ' .$row2['nama_karyawan']. ' (' .$row2['nama_jabatan']. ')<br>';
	}
	echo '</div></a></td>
			</tr>';
	}	

?>
							</tbody>
						</table>
						</div>
					</div>
				</div>
			<div id="dummy"></div>
			</div>
		</div>	
	</div>
</div>

<script>
function getBack(){
	AndroidFunction.closeApp();
}
$(document).ready(function(){
	
})
</script>
