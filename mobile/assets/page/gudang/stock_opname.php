
<div class="right_col loading" role="main">
	<div class="">
	
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<div class="col-md-6">
							<h3>STOCK OPNAME GUDANG</h3>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
				<div class="col-sm-6" style="float: left">
					<div class="row">
						<table>
							<tr>
								<td style="padding-right:0px;padding-right:10px">Periode :</td>
								<td><input class="form-control" style="width:100px" id="tgl_dari" type="text" value="" placeholder="Tanggal" readonly></td>
								<td>&nbsp; - &nbsp;</td>
								<td><input class="form-control" style="width:100px" id="tgl_sampai" type="text" value="" placeholder="Tanggal" readonly></td>
								<td>&nbsp;&nbsp;</td>
								<td><a class="btn btn-primary" id="btn_dari_sampai" onClick="submit();"><i class="fa fa-search"></i></a></td>
							</tr>
						</table>
					</div>
				</div>
				<div class="col-sm-6" style="float: right">
					<p align="right"><a href="?page=gudang&mode=stock_opname_2" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</a></p>
				</div>
				<div class="clearfix"></div>
				<table id="table1" class="table table-bordered table-striped" style="table-layout:fixed">
				<thead>
					<tr>
						<th>Tgl. Stock Opname</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody>
				<?php
if (isset($_GET['dari'])){
	$dari=date("Y-m-d", strtotime($_GET['dari']));
	$sampai=date("Y-m-d", strtotime($_GET['sampai']));
	$val="(tanggal_so BETWEEN '$dari' AND '$sampai') ORDER BY id_so DESC";
} else {
	$val="MONTH(tanggal_so)=MONTH(CURRENT_DATE()) AND YEAR(tanggal_so)=YEAR(CURRENT_DATE()) ORDER BY id_so DESC";
}

$sql=mysqli_query($con, "SELECT * FROM stock_opname WHERE $val");
while($row=mysqli_fetch_array($sql)){
if ($row['status_so']==0){
	$status="";	$url="stock_opname_2";
} else if ($row['status_so']==1){
	$status="SELESAI"; $warna='1E824C'; $url="stock_opname_4";
} else if ($row['status_so']==2){
	$status="MENUNGGU"; $warna='337AB7'; $url="stock_opname_2";
}

	echo '			<tr>
						<td><a href="?page=gudang&mode=' .$url. '&id=' .$row['id_so']. '"><div style="min-width:70px">&nbsp;' .date("d-m-Y",strtotime($row['tanggal_so'])). '</div></a></td>';
	if ($status==""){
		echo '			<td><a href="?page=gudang&mode=' .$url. '&id=' .$row['id_so']. '"><div style="min-width:70px">&nbsp;</div></a></td>';
	} else {
		echo '			<td><a href="?page=gudang&mode=' .$url. '&id=' .$row['id_so']. '" class="badge btn-xs bg-xs" style="background-color: #' .$warna. '"><div style="min-width:70px">&nbsp;' .$status. '</div></a></td>';
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
	window.location="?page=gudang&mode=stock_opname&dari=" + $('#tgl_dari').val() + "&sampai=" + $('#tgl_sampai').val() + "&landscape";
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
