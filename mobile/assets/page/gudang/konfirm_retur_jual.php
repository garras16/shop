
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
					</div>
					<div class="x_content">
						<table>
							<tr>
								<td style="padding-right:10px">Periode :</td>
								<td><input class="form-control" style="width:100px" id="tgl_dari" type="text" value="" placeholder="Tanggal" readonly></td>
								<td>&nbsp; - &nbsp;</td>
								<td><input class="form-control" style="width:100px" id="tgl_sampai" type="text" value="" placeholder="Tanggal" readonly></td>
								<td>&nbsp;&nbsp;</td>
								<td><a class="btn btn-primary" id="btn_dari_sampai" onClick="submit();"><i class="fa fa-search"></i></a></td>
							</tr>
						</table>
					<br>
				<table id="table1" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>Tgl. Retur</th>
						<th>No Retur</th>
						<th>No Nota Jual</th>
						<th>Nama Pelanggan</th>
						<th>Jumlah Jual (Rp)</th>
					</tr>
				</thead>
				<tbody>
				<?php
if (isset($_GET['dari'])){
	$dari=date("Y-m-d", strtotime($_GET['dari']));
	$sampai=date("Y-m-d", strtotime($_GET['sampai']));
	$val="(tgl_retur BETWEEN '$dari' AND '$sampai')";
} else {
	$val="MONTH(tgl_retur)=MONTH(CURRENT_DATE()) AND YEAR(tgl_retur)=YEAR(CURRENT_DATE())";
}
$sql=mysql_query("SELECT
    retur_jual.tgl_retur
    , retur_jual.id_retur_jual
    , retur_jual.no_retur_jual
    , retur_jual.status
	, jual.id_jual
    , jual.invoice
    , pelanggan.nama_pelanggan
FROM
    retur_jual
    INNER JOIN jual 
        ON (retur_jual.id_jual = jual.id_jual)
    INNER JOIN pelanggan 
        ON (jual.id_pelanggan = pelanggan.id_pelanggan) 
WHERE $val AND retur_jual.status=0
ORDER BY id_retur_jual DESC");
while($row=mysql_fetch_array($sql)){
$sql2=mysql_query("SELECT SUM(qty * (harga-diskon_rp-diskon_rp_2-diskon_rp_3)) AS jumlah FROM jual_detail WHERE id_jual=" .$row['id_jual']);
$r=mysql_fetch_array($sql2);
if ($row['status']==0){
	$status="";
} else if ($row['status']==1){
	$status="SELESAI"; $warna='1E824C';
}
	echo '			<tr>
						<td><a href="?page=gudang&mode=konfirm_retur_jual_2&id=' .$row['id_retur_jual']. '"><div style="min-width:70px">&nbsp;' .date("d-m-Y",strtotime($row['tgl_retur'])). '</div></a></td>
						<td><a href="?page=gudang&mode=konfirm_retur_jual_2&id=' .$row['id_retur_jual']. '"><div style="min-width:70px">&nbsp;' .$row['no_retur_jual']. '</div></a></td>
						<td><a href="?page=gudang&mode=konfirm_retur_jual_2&id=' .$row['id_retur_jual']. '"><div style="min-width:70px">&nbsp;' .$row['invoice']. '</div></a></td>
						<td><a href="?page=gudang&mode=konfirm_retur_jual_2&id=' .$row['id_retur_jual']. '"><div style="min-width:70px">&nbsp;' .$row['nama_pelanggan']. '</div></a></td>
						<td><a href="?page=gudang&mode=konfirm_retur_jual_2&id=' .$row['id_retur_jual']. '"><div style="min-width:70px">&nbsp;' .format_uang($r['jumlah']). '</div></a></td>
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
function validasi(){
	var startDate = new Date.parse(get_global_tanggal($('#tgl_dari').val()));
	var endDate = new Date.parse(get_global_tanggal($('#tgl_sampai').val()));
	if (startDate > endDate){
		$('#tgl_dari').val('');
		$('#tgl_sampai').val('');
		$('#btn_dari_sampai').attr('style','display:none');
		alert("Terjadi kesalahan penulisan tanggal");
		AndroidFunction.showToast("Terjadi kesalahan penulisan tanggal");
	} else {
		$('#btn_dari_sampai').removeAttr('style');
	}
}
function submit(){
	window.location="?page=gudang&mode=konfirm_retur_jual&dari=" + $('#tgl_dari').val() + "&sampai=" + $('#tgl_sampai').val();
}
function getBack(){
	AndroidFunction.closeApp();
}
$(document).ready(function(){
	var now = new Date();
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
