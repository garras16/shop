<?php
$id_karyawan=$_SESSION['id_karyawan'];
if (isset($_GET['terima'])){
	$sql=mysqli_query($con, "UPDATE retur_jual SET status=0 WHERE id_retur_jual=" .$_GET['terima']);
	if ($sql){
		_buat_pesan("Input Berhasil","green");
	} else {
		_buat_pesan("Input Gagal","red");
	}
	_direct("?page=penjualan&mode=konfirmasi_admin_retur_jual");
}
if (isset($_GET['tolak'])){
	$sql=mysqli_query($con, "DELETE FROM retur_jual WHERE id_retur_jual=" .$_GET['tolak']);
	if ($sql){
		_buat_pesan("Input Berhasil","green");
	} else {
		_buat_pesan("Input Gagal","red");
	}
	_direct("?page=penjualan&mode=konfirmasi_admin_retur_jual");
}
?>
<div class="right_col loading" role="main">
	<div class="">
	
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<div class="col-md-6">
							<h3>KONFIRMASI RETUR JUAL</h3>
						</div>
						<div class="clearfix"></div>
						<?php
							if (isset($pesan)){
								echo '<span class="badge bg-' .$warna. '">' .$pesan. '</span>';
							}
						?>
					</div>
					<div class="x_content"><div class="alert alert-info">
					  <strong>Klik kolom pada tabel untuk detail.</strong>
					</div>
					
						<div class="table-responsive">
						<table class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>Tgl Retur</th>
									<th>Nama Pelanggan</th>
									<th>No Retur Jual</th>
									<th>No Nota Jual</th>
									<th>Status Bayar</th>
									<th>Jumlah Jual (Rp)</th>
									<th>Jumlah Retur Jual (Rp)</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
<?php
	$sql=mysqli_query($con, "SELECT * FROM retur_jual WHERE status=9 GROUP BY id_jual ORDER BY tgl_retur DESC");
	while ($row=mysqli_fetch_array($sql)){
	$sql2=mysqli_query($con, "SELECT * FROM jual WHERE id_jual=" .$row['id_jual']. " GROUP BY id_jual ORDER BY id_jual DESC");
	$row2=mysqli_fetch_array($sql2);
	$invoice=$row2['invoice'];
	
	$sql2=mysqli_query($con, "SELECT nama_pelanggan
FROM
    jual
    INNER JOIN pelanggan 
        ON (jual.id_pelanggan = pelanggan.id_pelanggan)
	WHERE id_jual=" .$row['id_jual']. "");
	$row2=mysqli_fetch_array($sql2);
	$nama_pelanggan=$row2['nama_pelanggan'];
	
		$sql2=mysqli_query($con, "SELECT SUM(qty_ambil*(harga-diskon_rp-diskon_rp_2-diskon_rp_3)) AS total_jual
			FROM
				jual_detail
				INNER JOIN nota_siap_kirim_detail 
					ON (jual_detail.id_jual_detail = nota_siap_kirim_detail.id_jual_detail)
			WHERE id_jual=" .$row['id_jual']);
		$r=mysqli_fetch_array($sql2);
		$total_jual=$r['total_jual'];
		$sql2=mysqli_query($con, "SELECT SUM(qty_ambil*(harga-diskon_rp-diskon_rp_2-diskon_rp_3)) AS total_jual
			FROM
				jual_detail
				INNER JOIN canvass_siap_kirim_detail 
					ON (jual_detail.id_jual_detail = canvass_siap_kirim_detail.id_jual_detail)
			WHERE id_jual=" .$row['id_jual']);
		$r=mysqli_fetch_array($sql2);
		$total_jual+=$r['total_jual'];
		
		$sql2=mysqli_query($con, "SELECT * FROM retur_jual_detail WHERE id_retur_jual=" .$row['id_retur_jual']);
		$total_retur=0;
		while ($r=mysqli_fetch_array($sql2)){
			if ($r['qty_masuk']==''){
				$total_retur+=$r['harga_retur']*$r['qty_retur'];
			} else {
				$total_retur+=$r['harga_retur']*$r['qty_masuk'];
			}
		}
		
	$sql2=mysqli_query($con, "SELECT status_bayar
FROM
    penagihan
    INNER JOIN penagihan_detail 
        ON (penagihan.id_penagihan = penagihan_detail.id_penagihan)
WHERE id_jual=" .$row['id_jual']);
	$r=mysqli_fetch_array($sql2);
	if ($r['status_bayar']=='0') {$status='Belum Bayar'; $color='red';}
	if ($r['status_bayar']=='1') {$status='Sedang Mengangsur'; $color='red';}
	if ($r['status_bayar']=='2') {$status='Lunas'; $color='black';}
	if ($r['status_bayar']=='3') {$status='Belum Tagih'; $color='black';}
	
	echo '<tr>
				<td><div style="min-width:70px;text-align:center"><a target="_blank" href="?page=penjualan&mode=retur_jual_detail&id=' .$row['id_retur_jual']. '">' .date("d-m-Y",strtotime($row['tgl_retur'])). '</div></a></td>
				<td><div style="min-width:70px;text-align:center"><a target="_blank" href="?page=penjualan&mode=retur_jual_detail&id=' .$row['id_retur_jual']. '">' .$nama_pelanggan. '</div></a></td>
				<td><div style="min-width:70px;text-align:center"><a target="_blank" href="?page=penjualan&mode=retur_jual_detail&id=' .$row['id_retur_jual']. '">' .$row['no_retur_jual']. '</div></a></td>
				<td><div style="min-width:70px;text-align:center"><a target="_blank" href="?page=penjualan&mode=retur_jual_detail&id=' .$row['id_retur_jual']. '">' .$invoice. '</div></a></td>
				<td><div style="min-width:70px;text-align:center"><a target="_blank" href="?page=penjualan&mode=retur_jual_detail&id=' .$row['id_retur_jual']. '">' .$status. '</div></a></td>
				<td><div style="min-width:70px;text-align:center"><a target="_blank" href="?page=penjualan&mode=retur_jual_detail&id=' .$row['id_retur_jual']. '">' .format_uang($total_jual). '</div></a></td>
				<td><div style="min-width:70px;text-align:center"><a target="_blank" href="?page=penjualan&mode=retur_jual_detail&id=' .$row['id_retur_jual']. '">' .format_uang($total_retur). '</div></a></td>
				<td style="text-align:center"><a class="btn btn-xs btn-warning" href="?page=konfirmasi&mode=konfirmasi_admin&terima=' .$row['id_retur_jual']. '">Terima</a>
				<a class="btn btn-xs btn-danger" href="?page=konfirmasi&mode=konfirmasi_admin&tolak=' .$row['id_retur_jual']. '">Tolak</a></td>
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
$(document).ready(function(){
	
})
</script>
