<?php
$id_karyawan=$_SESSION['id_karyawan'];
if (isset($buat_penagihan_post)){
	$sql = mysql_query("INSERT INTO penagihan VALUES(null,$penagih,'$tanggal','DALAM KOTA',0,$id_karyawan)");
	$id_tagih=mysql_insert_id();
	
	foreach ($id_jual as $key => $value) {
		$sql=mysql_query("INSERT INTO penagihan_detail VALUES(null,$id_tagih,$value,null,3,null,0,0,null,null,null,null,null,null,null,null,null,null,null)");
		echo mysql_error();
	}
	if ($sql){
		_alert("Penyimpanan data nota tagihan berhasil.");
		_direct("?page=admin&mode=home");
	} else {
		_alert("Input Gagal.");
	}
}
?>
<div class="right_col loading" role="main">
	<div class="">
	
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<h3>PENAGIHAN</h3>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<form method="post" onsubmit="return cek_valid()">
							<input type="hidden" name="buat_penagihan_post" value="true">
							<div class="input-group">
								<select class="form-control select2" id="select_karyawan" name="id_karyawan" required>
									<option value="" disabled selected>Pilih Debt Collector</option>
									<?php
									$sql=mysql_query("SELECT * FROM karyawan WHERE status=1");
									while ($row=mysql_fetch_array($sql)){
										echo '<option value="' .$row['id_karyawan']. '">' .$row['nama_karyawan']. '</option>';
									}
									?>
								</select>
								<span class="input-group-btn">
									<a onClick="AndroidFunction.scan_nota()" class="btn btn-primary"><i class="fa fa-barcode"></i> Scan Nota</a>
									<a data-toggle="modal" data-target="#myModal" class="btn btn-warning"><i class="fa fa-edit"></i> Input No Nota Jual</a>
								</span>
							</div>
							<div class=="clearfix"></div>
							<div class="table-responsive">
								<table class="table table-bordered table-striped">
									<thead>
										<tr>
											<th>Tgl Nota Jual</th>
											<th>No Nota Jual</th>
											<th>Nama Sales</th>
											<th>Nama Driver</th>
											<th>Nama Pelanggan</th>
											<th>Nama Administrator</th>
											<th>Jumlah Jual (Rp)</th>
											<th>Tgl Jatuh Tempo</th>
											<th>Tgl Kunjungan Berikutnya</th>
											<th>Sisa Piutang (Rp)</th>
											<th></th>
										</tr>
									</thead>
									<tbody id="tabel"></tbody>
								</table>
							</div>
							<p align="center">
								<input style="margin-top:10px" class="btn btn-primary" type="submit" value="Simpan">
							</p>
						</form>
						<div id="dummy" style="display:none"></div>
					</div>
				</div>
			</div>
		</div>	
	</div>
</div>

<!-- modal input -->
<div id="myModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><div style="min-width:50px">&times;</div></button>
				<h4 class="modal-title">Input No Nota Jual</h4>
			</div>
			<div class="modal-body">				
				<div class="input-group">
					<span class="input-group-addon">No Nota Jual</span>
					<input class="form-control" id="invoice" placeholder="No Nota Jual" value="">
					<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
				</div>
				<div class="modal-footer">
					<a onClick="check_this()" class="btn btn-primary">Pilih</a>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- modal input -->
<div id="myModal2" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><div style="min-width:50px">&times;</div></button>
				<h4 class="modal-title">Scan Nota Jual</h4>
			</div>
			<div class="modal-body">				
				<div class="input-group">
					<span class="input-group-addon">No Nota Jual</span>
					<input class="form-control" id="invoice" placeholder="No Nota Jual" value="">
					<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
				</div>
				<div class="modal-footer">
					<a onClick="check_this()" class="btn btn-primary">Pilih</a>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
function getBack(){
	if ($('#myModal').is(':visible')) {
		$('#myModal').modal('hide');
	} else {
		AndroidFunction.closeApp();
	}
}
function batal_scan(){
//	getBack();
}
function check_this(){
	var inv = $('#invoice').val();
	cek_scan_nota(inv);
	$('#myModal').modal('hide');
}
function cek_valid(){
	var len = $('#tabel').html();
	if (len == 0){
		AndroidFunction.showToast("Belum pilih nota.");
		return false;
	} else {
		return true;
	}
}
function cek_scan_nota(barcode){
	$('#dummy').load('assets/page/admin/get-nota.php?id=' + barcode,function(){
		if ($('#dummy').html()==''){
			AndroidFunction.showToast('Nota tidak ditemukan.');
		} else {
			var isi=$('#dummy').html();
			var cari = $('#tabel').html().search(barcode);
			
			if (cari=='-1') {$('#tabel').prepend(isi);}
			$('#dummy').html('');
		}
	});
}
$(document).ready(function(){
	$('#tabel').on('click', '.remove_cart', function(e) {
		e.preventDefault();
		$(this).parent().closest('#list').remove();		
	});
	$('#myModal').on('show.bs.modal', function(e){
		$('#invoice').val('');
	});
})
</script>