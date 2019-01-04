<?php
$id_karyawan=$_SESSION['id_karyawan'];
	$sql=mysql_query("SELECT *
FROM
    canvass_keluar
    LEFT JOIN kendaraan 
        ON (canvass_keluar.id_mobil = kendaraan.id_kendaraan)
	WHERE id_canvass_keluar=$id");
	$row=mysql_fetch_array($sql);
	$tgl_canvass=$row['tanggal_canvass'];
	$nama_mobil=$row['nama_kendaraan'];
	$plat=$row['plat'];
	$sql2=mysql_query("SELECT *
FROM
    canvass_keluar_karyawan
    INNER JOIN karyawan 
        ON (canvass_keluar_karyawan.id_karyawan = karyawan.id_karyawan)
	INNER JOIN users 
        ON (karyawan.id_karyawan = users.id_karyawan)
	WHERE id_canvass_keluar=$id");
	$baris=mysql_num_rows($sql2);
	$sql3=mysql_query("SELECT * FROM canvass_stock_opname WHERE id_canvass_keluar=$id LIMIT 1");
	$row3=mysql_fetch_array($sql3);
	$tanggal_so=$row3['tanggal_so'];
?>
<div class="right_col loading" role="main">
	<div class="">
	
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<div class="col-md-6">
							<h3>STOCK OPNAME (CANVASS)</h3>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<table class="table table-bordered table-striped">
						<tbody>
<?php
	echo '					<tr><td width="40%">Tanggal Canvass</td><td>' .date("d-m-Y", strtotime($tgl_canvass)). '</td></tr>
							<tr><td width="40%">Tanggal Stock Opname</td><td>' .date("d-m-Y", strtotime($tanggal_so)). '</td></tr>
							<tr><td width="40%">Nama Mobil</td><td>' .$nama_mobil. '</td></tr>
							<tr><td width="40%">No Pol</td><td>' .$plat. '</td></tr>';
	
	echo '					<tr><td rowspan="' .$baris. '">Nama Karyawan</td>';
	while ($row2=mysql_fetch_array($sql2)){
		echo '				<td>- ' .$row2['nama_karyawan']. ' ( ' .$row2['posisi']. ' )</td></tr>';
	}
	echo '</tr>';
?>
						</tbody>
						</table>
						
						<div class="table-responsive">
						<table class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>Nama Barang</th>
									<th>Qty Periksa</th>
									<th>Qty Seharusnya</th>
								</tr>
							</thead>
							<tbody>
<?php
	$sql=mysql_query("SELECT barang.id_barang,nama_barang,SUM(qty_cek_2) AS qty_cek_2,nama_satuan
FROM
    canvass_stock_opname
    INNER JOIN barang 
        ON (canvass_stock_opname.id_barang = barang.id_barang)
	INNER JOIN satuan 
        ON (barang.id_satuan = satuan.id_satuan)
WHERE id_canvass_keluar=$id
GROUP BY canvass_stock_opname.id_barang");
	while ($row=mysql_fetch_array($sql)){
	$sql2=mysql_query("SELECT SUM(stok) AS stok FROM canvass_keluar_barang WHERE id_canvass_keluar=$id AND id_barang=" .$row['id_barang']);
	$row2=mysql_fetch_array($sql2);
	($row['qty_cek_2']==$row2['stok'] ? $color='black' : $color='red'); 
	echo '<tr>
				<td style="vertical-align:middle;text-align:center;color:' .$color. '">' .$row['nama_barang']. '</td>
				<td style="vertical-align:middle;text-align:center;color:' .$color. '">' .format_angka($row['qty_cek_2']). ' ' .$row['nama_satuan']. '</td>
				<td style="vertical-align:middle;text-align:center;color:' .$color. '">' .format_angka($row2['stok']). ' ' .$row['nama_satuan']. '</td>
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
	window.location='index.php?page=canvass_keluar&mode=stock_opname';
}

$(document).ready(function(){
	
})
</script>
