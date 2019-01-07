<?php
$id_karyawan=$_SESSION['id_karyawan'];
$nama_user=$_SESSION['user'];
if (!isset($_GET['id'])){
	$tgl=date("Y-m-d");
	$sql=mysqli_query($con, "INSERT INTO stock_opname VALUES(null,'$tgl',0,$id_karyawan)");
	$id=mysqli_insert_id($con);
	_direct("?page=gudang&mode=stock_opname_2&id=" .$id);
}
?>
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
						<p align="center"><a id="scan_rak" onClick="AndroidFunction.scan_rak()" class="btn btn-primary"><i class="fa fa-barcode"></i> Scan Rak</a></p>
					</div>
				</div>
			<div id="dummy" style="display:none"></div>
			</div>
		</div>	
	</div>
</div>

<script>
function getBack(){
	window.location='index.php?page=gudang&mode=stock_opname';
}

function cek_scan_rak(barcode1){
	$('#dummy').load('assets/page/gudang/get-rak_2.php?id=' + barcode1, function(){
		if ($.trim($('#dummy').html()) == ''){
			AndroidFunction.showToast("Barcode Rak tidak ditemukan.");
		} else {
			var id_rak=$.trim($('#dummy').html());
			window.location='index.php?page=gudang&mode=stock_opname_3&id=<?php echo $id ?>&rak=' + id_rak;
		}
	});
}
function batal_scan(){
	getBack();
}
$(document).ready(function(){
	$('#scan_rak').click();
})
</script>
