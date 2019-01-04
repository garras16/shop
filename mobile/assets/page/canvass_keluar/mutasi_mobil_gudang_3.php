<?php
$id_karyawan=$_SESSION['id_karyawan'];
if (isset($sukses_mutasi_mobil_gudang_post)){
	$sql3=mysql_query("UPDATE canvass_keluar SET status=5 WHERE id_canvass_keluar=$id");
	_direct("?page=canvass_keluar&mode=mutasi_mobil_gudang");
}
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
?>
<div class="right_col loading" role="main">
	<div class="">
	
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<div class="col-md-6">
							<h3>MUTASI DARI MOBIL KE GUDANG (CANVASS)</h3>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<table class="table table-bordered table-striped">
						<tbody>
<?php
	echo '					<tr><td width="40%">Tanggal Canvass</td><td>' .date("d-m-Y", strtotime($tgl_canvass)). '</td></tr>
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
									<th>Qty Ambil</th>
									<th>Qty Jual</th>
									<th>Qty Sisa</th>
									<th>Qty Periksa</th>
								</tr>
							</thead>
							<tbody>
<?php
	$sql=mysql_query("SELECT *,SUM(qty) as qty, SUM(qty_cek) as qty_cek
FROM
    canvass_keluar_barang
    INNER JOIN barang 
        ON (canvass_keluar_barang.id_barang = barang.id_barang)
    INNER JOIN satuan 
        ON (barang.id_satuan = satuan.id_satuan)
WHERE id_canvass_keluar=$id
GROUP BY canvass_keluar_barang.id_barang,canvass_keluar_barang.id_rak");
	while ($row=mysql_fetch_array($sql)){
	($row['qty_cek']==$row['qty'] ? $style="" : $style="color:red;");
	echo '<tr>
				<td style="vertical-align:middle;text-align:center;' .$style. '">' .$row['nama_barang']. '</td>
				<td style="vertical-align:middle;text-align:center;' .$style. '">' .format_angka($row['qty_cek']). ' ' .$row['nama_satuan']. '</td>';
	$sql2=mysql_query("SELECT SUM(qty_ambil) AS qty_ambil
FROM
    canvass_siap_kirim
    INNER JOIN canvass_siap_kirim_detail 
        ON (canvass_siap_kirim.id_canvass_siap_kirim = canvass_siap_kirim_detail.id_canvass_siap_kirim)
    INNER JOIN jual_detail 
        ON (canvass_siap_kirim_detail.id_jual_detail = jual_detail.id_jual_detail)
    INNER JOIN harga_jual 
        ON (jual_detail.id_harga_jual = harga_jual.id_harga_jual)
    INNER JOIN barang_supplier 
        ON (harga_jual.id_barang_supplier = barang_supplier.id_barang_supplier)
WHERE barang_supplier.id_barang=" .$row['id_barang']. " AND id_canvass_keluar=$id");
	$row2=mysql_fetch_array($sql2);
	$sql3=mysql_query("SELECT SUM(qty_cek2) AS qty_cek2 FROM canvass_mutasi_mobil_gudang WHERE id_canvass_keluar=$id AND id_barang=" .$row['id_barang']. "");
	$row3=mysql_fetch_array($sql3);
	echo '<td style="vertical-align:middle;text-align:center;' .$style. '" align="center">' .format_angka($row2['qty_ambil']). ' ' .$row['nama_satuan']. '</td>';
	$qty_sisa=$row['qty_cek']-$row2['qty_ambil'];
	echo '		<td align="center" style="vertical-align:middle;text-align:center;' .$style. '">' .format_angka($qty_sisa). ' ' .$row['nama_satuan']. '</td>
						<td style="vertical-align:middle;text-align:center;' .$style. '" align="center">' .format_angka($row3['qty_cek2']). ' ' .$row['nama_satuan']. '</td>';
	echo '		</tr>';
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
	window.location='index.php?page=canvass_keluar&mode=mutasi_mobil_gudang';
}
$(document).ready(function(){
	
})
</script>
