<?php
date_default_timezone_set('Asia/Jakarta');
require_once('../../../assets/inc/config.php');
require_once('../../../assets/inc/publicfunc.php');
$id=$_GET['id'];
$sql=mysqli_query($con, "SELECT * FROM harga_jual_kredit WHERE id_harga_jual=$id");
while($row=mysqli_fetch_array($sql)){
	echo '		<div class="col-md-6">
					<input class="form-control" value="' .format_uang($row['harga_kredit']). '" readonly>
				</div>
				<div class="col-md-5">
					<input class="form-control" value="' .format_angka($row['hari']). '" readonly>
				</div>
				<div class="col-md-1">
					<a data-toggle="modal" data-target="#myEHJKModal" data-id="' .$row['id_harga_jual_kredit']. '" data-harga="' .$row['harga_kredit']. '" data-hari="' .$row['hari']. '" class="form-control btn btn-warning"><i class="fa fa-edit fa-fw"></i></a>
				</div>';
}
?>

<!-- modal input -->
<div id="myEHJKModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Ubah Data Harga Jual Kredit</h4>
			</div>
			<div class="modal-body">				
				<form action="" method="post">
					<input type="hidden" name="edit_harga_jual_kredit_post" value="true">
					<input type="hidden" id="id_harga_jual_kredit" name="id_harga_jual_kredit" value="">
					<div class="col-md-12">
					<div class="input-group">
						<span class="input-group-addon">Rp</span>
						<input id="harga_jual" name="harga_jual" class="form-control" placeholder="Harga Jual Kredit (Rp)" required>
						<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
						<input id="hari" name="hari" type="number" min="0" class="form-control" placeholder="Hari" required>
						<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
					</div>
					</div>
					<div class="modal-footer">
						<input type="submit" class="btn btn-primary" value="Simpan">
					</div>
				</form>
			</div>
		</div>
	</div>
</div>	

<script>
$(document).ready(function(){
	$('#harga_jual').inputmask('currency', {prefix: "Rp ", allowMinus:false, autoGroup: true, groupSeparator: '.', rightAlign: false, autoUnmask: true, removeMaskOnSubmit: true});
	$('#myEHJKModal').on('show.bs.modal', function(e){
		var id_harga_jual_kredit = $(e.relatedTarget).data('id');
		var harga = $(e.relatedTarget).data('harga');
		var hari = $(e.relatedTarget).data('hari');
		$('#id_harga_jual_kredit').val(id_harga_jual_kredit);
		$('#harga_jual').val(harga);
		$('#hari').val(hari);
	})
});
</script>