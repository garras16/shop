<?php
$sql = "DELETE FROM retur_jual WHERE id_retur_jual NOT IN (SELECT id_retur_jual FROM retur_jual_detail)";
$q = mysqli_query($con, $sql);
?>
<!-- page content -->
<div class="right_col" role="main">
	<div class="">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<h3>Retur Penjualan Oleh Debt Collector</h3>
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
			<p align="right"><a class="btn btn-primary" href="?page=collector&mode=cari_nota_retur"><i class="fa fa-plus"></i> Tambah</a></p>

					<div class="col-xs-12" style="background:gray; padding-top:10px;padding-bottom:10px">
						<font color="white">Cari Tanggal Retur : </font><br/>
						<input style="width:100px;height:30px" id="tgl_dari" type="text" value="" placeholder="Tanggal" readonly><font color="white"> - </font><input style="width:100px;height:30px" id="tgl_sampai" type="text" value="" placeholder="Tanggal" readonly>&nbsp;<a class="btn btn-primary" id="btn_dari_sampai" onClick="submit();"><i class="fa fa-search"></i> CARI</a><a class="btn btn-primary" id="btn_dari_sampai" onClick="reset();"><i class="fa fa-refresh"></i> RESET</a>
					</div>
			<div class="clearfix"></div><br/>
			<table id="table1" class="table table-bordered table-striped" style="min-width: 1000px;">
				<thead>
					<tr>
						<th>Tgl. Retur</th>
						<th>No Retur</th>
						<th>No Nota Jual</th>
						<th>Nama Pelanggan</th>
						<th>Nama Sales</th>
						<th>Jumlah Jual</th>
						<th>Jumlah Retur</th>
						<th>Status Retur</th>
					</tr>
				</thead>
				<tbody>
<?php
if (isset($_GET['dari'])){
	$dari=date("Y-m-d", strtotime($_GET['dari']));
	$sampai=date("Y-m-d", strtotime($_GET['sampai']));
	$val="WHERE (tgl_retur BETWEEN '$dari' AND '$sampai')";
} else {
	$val="WHERE retur_jual.status = 9"; //status jika retur dibuat oleh debt collector
}
$sql=mysqli_query($con, "SELECT
    retur_jual.tgl_retur
    , retur_jual.id_retur_jual
    , retur_jual.no_retur_jual
    , retur_jual.status
	, jual.id_jual
    , jual.invoice
    , pelanggan.nama_pelanggan
    , karyawan.nama_karyawan
FROM
    retur_jual
    INNER JOIN jual
        ON (retur_jual.id_jual = jual.id_jual)
    INNER JOIN pelanggan
        ON (jual.id_pelanggan = pelanggan.id_pelanggan)
    INNER JOIN karyawan
        ON (jual.id_karyawan = karyawan.id_karyawan)
$val
ORDER BY jual.id_jual DESC");
while($row=mysqli_fetch_array($sql)){
$sql2=mysqli_query($con, "SELECT SUM(qty * (harga-diskon_rp-diskon_rp_2-diskon_rp_3)) AS jumlah FROM jual_detail WHERE id_jual=" .$row['id_jual']);
$r=mysqli_fetch_array($sql2);
$jumlah_jual=$r['jumlah'];
$sql2=mysqli_query($con, "SELECT SUM(qty_retur * harga_retur) AS jumlah
FROM
    retur_jual
    INNER JOIN retur_jual_detail
        ON (retur_jual.id_retur_jual = retur_jual_detail.id_retur_jual)
WHERE retur_jual.id_retur_jual=" .$row['id_retur_jual']);
$r=mysqli_fetch_array($sql2);
$jumlah_retur=$r['jumlah'];
if ($row['status']=='1'){
	$status="SELESAI";
} else if ($row['status']=='2'){
	$status="SUDAH CETAK";
} else {
	$status="";
}
	echo '			<tr>
						<td><a href="?page=collector&mode=retur_jual_detail&id=' .$row['id_retur_jual']. '"><div style="min-width:70px">' .date("d-m-Y", strtotime($row['tgl_retur'])). '</div></a></td>
						<td><a href="?page=collector&mode=retur_jual_detail&id=' .$row['id_retur_jual']. '"><div style="min-width:70px">' .$row['no_retur_jual']. '</div></a></td>
						<td><a href="?page=collector&mode=retur_jual_detail&id=' .$row['id_retur_jual']. '"><div style="min-width:70px">' .$row['invoice']. '</div></a></td>
						<td><a href="?page=collector&mode=retur_jual_detail&id=' .$row['id_retur_jual']. '"><div style="min-width:70px">' .$row['nama_pelanggan']. '</div></a></td>
						<td><a href="?page=collector&mode=retur_jual_detail&id=' .$row['id_retur_jual']. '"><div style="min-width:70px">' .$row['nama_karyawan']. '</div></a></td>
						<td><a href="?page=collector&mode=retur_jual_detail&id=' .$row['id_retur_jual']. '"><div style="min-width:70px" class="uang">' .$jumlah_jual. '</div></a></td>
						<td><a href="?page=collector&mode=retur_jual_detail&id=' .$row['id_retur_jual']. '"><div style="min-width:70px" class="uang">' .$jumlah_retur. '</div></a></td>
						<td><a href="?page=collector&mode=retur_jual_detail&id=' .$row['id_retur_jual']. '"><div style="min-width:70px" class="badge bg-green">' .$status. '</div></a></td>
					</tr>';
}
?>

				</tbody>
			</table>
			</div>
			</div>
			</div>
		</div>
		<!-- /page content -->


      </div>
    </div>

<script>
function validasi(){
	var startDate = new Date.parse(get_global_tanggal($('#tgl_dari').val()));
	var endDate = new Date.parse(get_global_tanggal($('#tgl_sampai').val()));
	if (startDate > endDate){
		$('#tgl_dari').val('');
		$('#tgl_sampai').val('');
		$('#btn_dari_sampai').attr('style','display:none');
		alert("Terjadi kesalahan penulisan tanggal");
	} else {
		$('#btn_dari_sampai').removeAttr('style');
	}
}
function submit(){
	window.location="?page=collector&mode=retur_jual&dari=" + $('#tgl_dari').val() + "&sampai=" + $('#tgl_sampai').val();
}
function reset(){
	window.location="?page=collector&mode=retur_jual";
}
$(document).ready(function(){
	$('.uang').inputmask('currency', {
			prefix: "Rp ",
			autoGroup: true,
			allowMinus: false,
			groupSeparator: '.',
			rightAlign: false,
			autoUnmask: true,
			removeMaskOnSubmit: true
	});
	$('#tgl_dari').daterangepicker({
		locale: {
			format: 'DD-MM-YYYY'
		},
		singleDatePicker: true
	});
	$('#tgl_sampai').daterangepicker({
		locale: {
			format: 'DD-MM-YYYY'
		},
		singleDatePicker: true
	});
	$("#tgl_dari").on('change', function(){
		validasi();
	});
	$("#tgl_sampai").on('change', function(){
		validasi();
	});
})
</script>
