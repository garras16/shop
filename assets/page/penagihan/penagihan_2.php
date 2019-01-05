<?php
$bln_sql="MONTH(CURRENT_DATE())";
$thn_sql="YEAR(CURRENT_DATE())";
?>
<!-- page content -->
<div class="right_col" role="main">
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
					<div class="x_title">
						<h3>PENAGIHAN</h3>
							<?php
							if (isset($pesan)){
								echo '<span class="badge bg-' .$warna. '">' .$pesan. '</span>';
							}
							?>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
					<p><a href="?page=penagihan&mode=penagihan&reset" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Kembali</a></p>
			<div class="table responsive">
			<table id="table1" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>Nama Pelanggan</th>
						<th>No Nota Jual</th>
						<th>Jumlah Jual (Rp)</th>
						<th>Plafon (Rp)</th>
						<th>Sisa Plafon (Rp)</th>
						<th>Sales</th>
						<th>Driver</th>
						<th>Debt Collector</th>
						<th>Tgl Jatuh Tempo</th>
						<th>Tgl Tagih</th>
						<th>Jumlah Tagih (Rp)</th>
						<th>Jumlah Bayar (Rp)</th>
						<th>Sisa Piutang (Rp)</th>
						<th>Tgl Kunjungan Berikutnya</th>
						<th>Status Bayar</th>
						<th>Status Kembali Nota</th>
					</tr>
				</thead>
				<tbody>
<?php
$sql=mysqli_query($con, "SELECT *
FROM
    penagihan
    INNER JOIN karyawan 
        ON (penagihan.id_karyawan = karyawan.id_karyawan)
    INNER JOIN penagihan_detail 
        ON (penagihan.id_penagihan = penagihan_detail.id_penagihan)
    INNER JOIN jual 
        ON (penagihan_detail.id_jual = jual.id_jual)
    INNER JOIN pelanggan 
        ON (jual.id_pelanggan = pelanggan.id_pelanggan)
    INNER JOIN jual_detail 
        ON (jual.id_jual = jual_detail.id_jual)
WHERE penagihan.id_penagihan=$id
GROUP BY jual.id_jual");
while ($row=mysqli_fetch_array($sql)){
	$sql2=mysqli_query($con, "SELECT plafon FROM pelanggan WHERE id_pelanggan=" .$row['id_pelanggan']);
		$row2=mysqli_fetch_array($sql2);
		$plafon=$row['plafon'];
		$sql2=mysqli_query($con, "SELECT tenor, tgl_nota, SUM(qty*(harga-diskon_rp-diskon_rp_2-diskon_rp_3)) AS jumlah_nota
FROM
    jual
    INNER JOIN jual_detail 
        ON (jual.id_jual = jual_detail.id_jual)
WHERE jual.id_jual=" .$row['id_jual']);
$row2=mysqli_fetch_array($sql2);
$jumlah_nota=$row2['jumlah_nota'];
$tgl_nota=$row2['tgl_nota'];
$tenor=$row2['tenor'];
$tgl_jt_tempo=date('d-m-Y', strtotime($tgl_nota. ' + ' .$tenor. ' days'));

		$sql2=mysqli_query($con, "SELECT SUM(jumlah) AS jumlah_bayar
FROM
    bayar_nota_jual
    INNER JOIN jual 
        ON (bayar_nota_jual.no_nota_jual = jual.invoice)
WHERE jual.id_jual=" .$row['id_jual']);
$row2=mysqli_fetch_array($sql2);
$jumlah_bayar=$row2['jumlah_bayar'];

$sql2=mysqli_query($con, "SELECT SUM(bayar) AS jumlah_bayar
FROM
    penagihan_detail
    INNER JOIN jual 
        ON (penagihan_detail.id_jual = jual.id_jual)
WHERE jual.id_jual=" .$row['id_jual']);
$row2=mysqli_fetch_array($sql2);
$jumlah_bayar+=$row2['jumlah_bayar'];

	$sql2=mysqli_query($con, "SELECT (qty_ambil*(harga-diskon_rp-diskon_rp_2-diskon_rp_3)) AS total
FROM
    jual_detail
    INNER JOIN nota_siap_kirim_detail 
        ON (jual_detail.id_jual_detail = nota_siap_kirim_detail.id_jual_detail)
WHERE id_jual=" .$row['id_jual']);
$total_jual=0;
	while ($row2=mysqli_fetch_array($sql2)){
		$total_jual+=$row2['total'];
	}
	$sisa_plafon=$plafon-($total_jual-$row['bayar']);
	$status='';
	if ($row['status_bayar']=='0') {$status='Belum Bayar'; $color='red';}
	if ($row['status_bayar']=='1') {$status='Sedang Mengangsur'; $color='red';}
	if ($row['status_bayar']=='2') {$status='Lunas'; $color='black';}
	if ($row['status_bayar']=='3') {$status='Belum Tagih'; $color='black';}
	if ($row['status_nota_kembali']=='0') $status_nota='Dibawa Debt Collector';
	if ($row['status_nota_kembali']=='1') $status_nota='Diterima Admin';
	if ($row['status_nota_kembali']=='2') $status_nota='Lunas';
	($row['tgl_janji_next']=='' ? $tgl_jb='' : $tgl_jb=date('d-m-Y',strtotime($row['tgl_janji_next'])));
	
	$sql3=mysqli_query($con, "SELECT nama_karyawan FROM jual INNER JOIN karyawan ON (jual.id_karyawan = karyawan.id_karyawan) WHERE id_jual=" .$row['id_jual']);
	$row3=mysqli_fetch_array($sql3);
	$nama_sales=$row3['nama_karyawan'];
	$sql3=mysqli_query($con, "SELECT nama_karyawan FROM pengiriman INNER JOIN karyawan ON (pengiriman.id_karyawan = karyawan.id_karyawan) WHERE id_jual=" .$row['id_jual']);
	$row3=mysqli_fetch_array($sql3);
	$nama_driver=$row3['nama_karyawan'];
	($sisa_plafon<0 ? $color1='red' : $color1='black');
	(strtotime($row['tgl_janji_next'])<=strtotime(date("Y-m-d")) ? $color2='red' : $color2='black');
	
	if ($total_jual-$row['bayar']==0) continue;
	echo '<tr>
			<td align="center">' .$row['nama_pelanggan']. '</td>
			<td align="center">' .$row['invoice']. '</td>
			<td align="center">' .format_uang($total_jual). '</td>
			<td align="center">' .format_uang($plafon). '</td>
			<td align="center" style="color:' .$color1. '">' .format_uang($sisa_plafon). '</td>
			<td align="center">' .$nama_sales. '</td>
			<td align="center">' .$nama_driver. '</td>
			<td align="center">' .$row['nama_karyawan']. '</td>
			<td align="center">' .$tgl_jt_tempo. '</td>
			<td align="center">' .date("d-m-Y",strtotime($row['tanggal_tagih'])). '</td>
			<td align="center">' .format_uang($total_jual). '</td>
			<td align="center">' .format_uang($row['bayar']). '</td>
			<td align="center">' .format_uang($total_jual-$row['bayar']). '</td>
			<td align="center" style="color:' .$color2. '">' .$tgl_jb. '</td>
			<td align="center" style="color: ' .$color. '">' .$status. '</td>
			<td align="center">' .$status_nota. '</td>
		</tr>';
}
?>
					
				</tbody>
			</table>
			</div>
		</div>
		<!-- /page content -->

        
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
function cari(){
	var tanggal = $('#datepicker').val();
	var url = "?page=penagihan&mode=penagihan_2&id=<?php echo $id; ?>&cari=" + tanggal;
	if (tanggal!='') window.location=url;
}
function reset(){
	var url = "?page=penagihan&mode=penagihan_2&id=<?php echo $id; ?>&reset";
	window.location=url;
}
$(document).ready(function(){
	$('#datepicker').datepicker({
		orientation: "bottom auto",
		format: "mm-yyyy",
		startView: 1,
		minViewMode: 1,
		autoclose: true
	});
});
</script>