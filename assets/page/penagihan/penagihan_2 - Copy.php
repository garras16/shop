<?php
if (isset($tambah_input_kas_kecil_post)){
	$sql = "INSERT INTO kas_kecil VALUES(null,'$tanggal','$komponen','$jenis','$keterangan',$jumlah)";
	$q = mysql_query($sql);
	if ($q){
		_buat_pesan("Input Berhasil","green");
	} else {
		_buat_pesan("Input Gagal","red");
	}
	_direct("?page=keuangan&mode=kas_kecil");
}
if (isset($_GET['del'])){
	$sql = "DELETE FROM kas_kecil WHERE id_kas_kecil=" .$_GET['del']. "";
	$q = mysql_query($sql);
	if ($q){
		_buat_pesan("Input Berhasil","green");
	} else {
		_buat_pesan("Input Gagal","red");
	}
	_direct("?page=keuangan&mode=kas_kecil");
}
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
						<h3>PENAGIHAN DALAM KOTA</h3>
							<?php
							if (isset($pesan)){
								echo '<span class="badge bg-' .$warna. '">' .$pesan. '</span>';
							}
							?>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
			<div class="table responsive">
			<table id="table1" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>Nama Pelanggan</th>
						<th>No Nota Jual</th>
						<th>Jumlah (Rp)</th>
						<th>Debt Collector</th>
						<th>Tgl Tagih</th>
						<th>Tgl Bayar</th>
						<th>Jml Tagih (Rp)</th>
						<th>Jml Bayar (Rp)</th>
						<th>Sisa (Rp)</th>
						<th>Tgl Tagih Berikutnya</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody>
<?php
$sql=mysql_query("SELECT *,SUM(bayar) AS bayar
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
    INNER JOIN harga_jual_kredit 
        ON (jual_detail.id_harga_jual = harga_jual_kredit.id_harga_jual)
WHERE penagihan.id_penagihan=$id
GROUP BY penagihan.id_penagihan,jual.id_jual");
while ($row=mysql_fetch_array($sql)){
	$sql2=mysql_query("SELECT (qty_ambil*harga) AS total
FROM
    jual_detail
    INNER JOIN nota_siap_kirim_detail 
        ON (jual_detail.id_jual_detail = nota_siap_kirim_detail.id_jual_detail)
WHERE id_jual=" .$row['id_jual']);
$total_jual=0;
	while ($row2=mysql_fetch_array($sql2)){
		$total_jual+=$row2['total'];
	}
	$status='';
	if ($row['status_bayar']=='0') $status='BELUM BAYAR';
	if ($row['status_bayar']=='1') $status='CICIL';
	if ($row['status_bayar']=='2') $status='SUDAH LUNAS';
	($row['tgl_janji_next']=='' ? $tgl_jb='' : $tgl_jb=date('d-m-Y',strtotime($row['tgl_janji_next'])));
	echo '<tr>
			<td align="center">' .$row['nama_pelanggan']. '</td>
			<td align="center">' .$row['invoice']. '</td>
			<td align="center">' .format_uang($total_jual). '</td>
			<td align="center">' .$row['nama_karyawan']. '</td>
			<td align="center">' .date("d-m-Y",strtotime($row['tanggal_tagih'])). '</td>
			<td align="center"></td>
			<td align="center">' .format_uang($total_jual). '</td>
			<td align="center">' .format_uang($row['bayar']). '</td>
			<td align="center">' .format_uang($total_jual-$row['bayar']). '</td>
			<td align="center">' .$tgl_jb. '</td>
			<td align="center">' .$status. '</td>
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
	var url = "?page=penagihan&mode=dalam_kota_2&id=<?php echo $id; ?>&cari=" + tanggal;
	if (tanggal!='') window.location=url;
}
function reset(){
	var url = "?page=penagihan&mode=dalam_kota_2&id=<?php echo $id; ?>&reset";
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