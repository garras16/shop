<?php
date_default_timezone_set('Asia/Jakarta');
require_once('../../../assets/inc/config.php');
require_once('../../../assets/inc/publicfunc.php');
$id=$_GET['id'];
?>
<form action="" method="post">
	<input type="hidden" name="tambah_harga_jual_kredit_post" value"true">
	<input type="hidden" name="id_harga_jual" value"<?php echo $id ?>">
	<div class="col-md-6">
		<input class="form-control" id="harga_jual_2" name="harga_jual" value="" required>
	</div>
	<div class="col-md-6">
		<input class="form-control" type="number" min="0" name="hari" value="" required>
	</div>
	<div class="clearfix"></div><br/>
	<input type="submit" class="btn btn-primary" value="Simpan">
	<a id="btnCancel" onClick="clearRow()" class="btn btn-warning">Batal</a>
</form>
<script>
$(document).ready(function(){
	$('#harga_jual_2').inputmask('decimal', {allowMinus:false, autoGroup: true, groupSeparator: '.', rightAlign: false, autoUnmask: true, removeMaskOnSubmit: true});
});
</script>