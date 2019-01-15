
<div class="right_col loading" role="main">
	<div class="">
	
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<div class="col-md-6">
							<h3>KONFIRMASI NOTA BELI</h3>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
					<?php
							if (isset($pesan)){
								echo '<span class="badge bg-' .$warna. '">' .$pesan. '</span><br><br>';
							}
					?>
					
					<div style="margin-bottom:50px">
							<table align="left">
								<tr>
									<td style="padding-right:10px">Periode :</td>
									<td><input class="form-control" style="width:100px" id="tgl_dari" type="text" value="" placeholder="Tanggal" readonly></td>
									<td>&nbsp; - &nbsp;</td>
									<td><input class="form-control" style="width:100px" id="tgl_sampai" type="text" value="" placeholder="Tanggal" readonly></td>
									<td>&nbsp;&nbsp;</td>
									<td><a class="btn btn-primary" id="btn_dari_sampai" onClick="submit();"><i class="fa fa-search"></i></a></td>
								</tr>
							</table>
					</div>
				<!--div id="isi"></div-->
				<table id="table1" class="table table-bordered table-striped" style="table-layout:fixed">
				<thead>
					<tr>
						<th>Tgl. Nota Beli</th>
						<th>No Nota Beli</th>
						<th>Nama Ekspedisi</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody>
				<?php
if (isset($_GET['dari'])){
	$dari=date("Y-m-d", strtotime($_GET['dari']));
	$sampai=date("Y-m-d", strtotime($_GET['sampai']));
	$val="(tanggal BETWEEN '$dari' AND '$sampai') ORDER BY id_beli DESC";
} else {
	$val="MONTH(tanggal)=MONTH(CURRENT_DATE()) AND YEAR(tanggal)=YEAR(CURRENT_DATE()) ORDER BY id_beli DESC";
}

$sql=mysqli_query($con, "SELECT
    beli.id_beli
    , beli.no_nota_beli
    , beli.tanggal
	, beli.status_konfirm
	, ekspedisi.nama_ekspedisi
FROM
    beli
	LEFT JOIN ekspedisi 
        ON (beli.id_ekspedisi = ekspedisi.id_ekspedisi) 
WHERE $val");
$i=0;
while($row=mysqli_fetch_array($sql)){
$i+=1;
if ($row['status_konfirm']==0){
	$status="";
} else if ($row['status_konfirm']==1){
	$status="SELESAI"; $warna='1E824C';
} else if ($row['status_konfirm']==2){
	$status="MENUNGGU"; $warna='337AB7';
}
	echo '			<tr>
						<td><a href="?page=gudang&mode=konfirm_beli_2&id=' .$row['id_beli']. '"><div style="min-width:70px">&nbsp;' .date("d-m-Y",strtotime($row['tanggal'])). '</div></a></td>
						<td><a href="?page=gudang&mode=konfirm_beli_2&id=' .$row['id_beli']. '"><div style="min-width:70px">&nbsp;' .$row['no_nota_beli']. '</div></a></td>
						<td><a href="?page=gudang&mode=konfirm_beli_2&id=' .$row['id_beli']. '"><div style="min-width:70px">&nbsp;' .$row['nama_ekspedisi']. '</div></a></td>';
	if ($status==""){
		echo '			<td><a href="?page=gudang&mode=konfirm_beli_2&id=' .$row['id_beli']. '"><div style="min-width:70px">&nbsp;</div></a></td>';
	} else {
		echo '			<td><a href="?page=gudang&mode=konfirm_beli_2&id=' .$row['id_beli']. '" class="badge btn-xs bg-xs" style="background-color: #' .$warna. '"><div style="min-width:70px">&nbsp;' .$status. '</div></a></td>';
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
	window.location="?page=gudang&mode=konfirm_beli&dari=" + $('#tgl_dari').val() + "&sampai=" + $('#tgl_sampai').val() + "&landscape";
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
