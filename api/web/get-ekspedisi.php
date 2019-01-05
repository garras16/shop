<?php
date_default_timezone_set('Asia/Jakarta');
require_once('../../assets/inc/config.php');
require_once('../../assets/inc/publicfunc.php');

if (isset($_GET['id'])){
	$id=$_GET['id'];
} else {
	die();
}
$sql=mysql_query("SELECT * FROM ekspedisi WHERE id_ekspedisi='$id'");
$row=mysql_fetch_array($sql);
?>
<input type="hidden" name="id_ekspedisi" value="<?php echo $id ?>">
<div class="input-group">
	<span class="input-group-addon"><i class="fa fa-truck fa-fw"></i></span>
	<input class="form-control" id="nama" name="nama_ekspedisi" placeholder="Nama Ekspedisi" maxlength="50" value="<?php echo $row['nama_ekspedisi'] ?>" required>
	<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
</div>
<div class="input-group">
	<span class="input-group-addon"><i class="fa fa-phone fa-fw"></i></span>
	<input name="telepon" type="number" class="form-control" placeholder="Telepon Ekspedisi" value="<?php echo $row['telepon'] ?>" onKeyPress="if(this.value.length==20) return false;" required>
	<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
</div>
<div class="input-group">
	<span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
	<input class="form-control" name="kontakperson" placeholder="Kontak Person" value="<?php echo $row['kontakperson'] ?>"  maxlength="50">
</div>
<div class="input-group">
	<span class="input-group-addon"><i class="fa fa-phone fa-fw"></i></span>
	<input class="form-control" type="number" name="telepon_kontak" placeholder="Telepon Kontak Person" value="<?php echo $row['telepon_kontak'] ?>"  onKeyPress="if(this.value.length==20) return false;">
</div>
<div class="input-group">
	<span class="input-group-addon"><i class="fa fa-flag fa-fw"></i></span>
	<select class="form-control" id="select_status" name="status" required>
		<option value="" disabled selected>Pilih Status</option>
		<option value="0" <?php echo ($row['status']==0 ? ' selected' : '') ?> >NON AKTIF</option>
		<option value="1" <?php echo ($row['status']==1 ? ' selected' : '') ?> >AKTIF</option>
	</select>
	<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
</div>