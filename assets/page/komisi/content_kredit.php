<?php
date_default_timezone_set('Asia/Jakarta');
require_once('../../../assets/inc/config.php');
require_once('../../../assets/inc/publicfunc.php');
$id=$_GET['id'];
$sql=mysql_query("SELECT * FROM komisi_kredit WHERE id_komisi=$id");
while($row=mysql_fetch_array($sql)){
	echo '		<div class="col-md-6">
					<input class="form-control" value="' .format_uang($row['kredit']). '" readonly>
				</div>
				<div class="col-md-5">
					<input class="form-control" value="' .format_angka($row['hari']). '" readonly>
				</div>
				<div class="col-md-1">
					<a data-toggle="modal" data-target="#myEKreditModal" data-id="' .$row['id_komisi_kredit']. '" data-kredit="' .$row['kredit']. '" data-hari="' .$row['hari']. '" class="form-control btn btn-warning"><i class="fa fa-edit fa-fw"></i></a>
				</div>';
}
?>

<!-- modal input -->
<div id="myEKreditModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Ubah Data Komisi Jual Kredit</h4>
			</div>
			<div class="modal-body">				
				<form action="" method="post">
					<input type="hidden" name="edit_komisi_kredit_post" value="true">
					<input type="hidden" id="id_komisi_kredit" name="id_komisi_kredit" value="">
					<div class="col-md-12">
					<div class="input-group">
						<span class="input-group-addon">%</span>
						<input id="kredit" type="text" maxlength="5" name="kredit" class="form-control" placeholder="Komisi Jual Kredit (%)" required>
						<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
						<input id="hari" name="hari" class="form-control" placeholder="Hari" required>
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
	$('#kredit').inputmask('decimal', {autoGroup: true, groupSeparator: '.', rightAlign: false, autoUnmask: true, removeMaskOnSubmit: true});
	$('#myEKreditModal').on('show.bs.modal', function(e){
		var id_komisi_kredit = $(e.relatedTarget).data('id');
		var kredit = $(e.relatedTarget).data('kredit');
		var hari = $(e.relatedTarget).data('hari');
		$('#id_komisi_kredit').val(id_komisi_kredit);
		$('#kredit').val(kredit);
		$('#hari').val(hari);
	})
});
</script>