
<div class="right_col loading" role="main">
	<div class="">
	
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<div class="col-md-6">
							<h3>KONFIRMASI RETUR BELI</h3>
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
						<th>No Nota Beli</th>
						<th>Nama Supplier</th>
						<th>Jumlah Beli (Rp)</th>
						<th>Status</th>
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

$sql=mysqli_query($con, "SELECT
    retur_beli.tgl_retur
    , retur_beli.id_retur_beli
    , retur_beli.no_retur_beli
    , retur_beli.status
	, beli.id_beli
    , beli.no_nota_beli
    , beli.ppn_all_persen
    , supplier.nama_supplier
FROM
    retur_beli
    INNER JOIN beli 
        ON (retur_beli.id_beli = beli.id_beli)
    INNER JOIN supplier 
        ON (beli.id_supplier = supplier.id_supplier) 
WHERE $val
ORDER BY id_retur_beli DESC");
while($row=mysqli_fetch_array($sql)){
$sql2=mysqli_query($con, "SELECT SUM(qty * (harga-diskon_rp-diskon_rp_2-diskon_rp_3)) AS jumlah FROM beli_detail WHERE id_beli=" .$row['id_beli']. "");
$r=mysqli_fetch_array($sql2);
$total_beli=$r['jumlah']+($row['ppn_all_persen']*$r['jumlah']/100);
if ($row['status']==0){
	$status="";
} else if ($row['status']==1){
	$status="SELESAI"; $warna='1E824C';
}/* else if ($row['status_konfirm']==2){
	$status="MENUNGGU"; $warna='337AB7';
}*/
	echo '			<tr>
						<td><a href="?page=gudang&mode=konfirm_retur_beli_2&id=' .$row['id_retur_beli']. '"><div style="min-width:70px">&nbsp;' .date("d-m-Y",strtotime($row['tgl_retur'])). '</div></a></td>
						<td><a href="?page=gudang&mode=konfirm_retur_beli_2&id=' .$row['id_retur_beli']. '"><div style="min-width:70px">&nbsp;' .$row['no_retur_beli']. '</div></a></td>
						<td><a href="?page=gudang&mode=konfirm_retur_beli_2&id=' .$row['id_retur_beli']. '"><div style="min-width:70px">&nbsp;' .$row['no_nota_beli']. '</div></a></td>
						<td><a href="?page=gudang&mode=konfirm_retur_beli_2&id=' .$row['id_retur_beli']. '"><div style="min-width:70px">&nbsp;' .$row['nama_supplier']. '</div></a></td>
						<td><a href="?page=gudang&mode=konfirm_retur_beli_2&id=' .$row['id_retur_beli']. '"><div style="min-width:70px">&nbsp;' .format_uang($total_beli). '</div></a></td>';
	if ($status==""){
		echo '			<td><a href="?page=gudang&mode=konfirm_retur_beli_2&id=' .$row['id_retur_beli']. '"><div style="min-width:70px">&nbsp;</div></a></td>';
	} else {
		echo '			<td><a href="?page=gudang&mode=konfirm_retur_beli_2&id=' .$row['id_retur_beli']. '" class="badge btn-xs bg-xs" style="background-color: #' .$warna. '"><div style="min-width:70px">&nbsp;' .$status. '</div></a></td>';
	}
	echo '				</tr>';
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
	window.location="?page=gudang&mode=konfirm_retur_beli&dari=" + $('#tgl_dari').val() + "&sampai=" + $('#tgl_sampai').val();
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
//	$("#isi").load("assets/api/konfirm_beli.php");
})
</script>
