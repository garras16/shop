<?php
date_default_timezone_set('Asia/Jakarta');
require_once('../../assets/inc/config.php');
require_once('../../assets/inc/publicfunc.php');

if (isset($_GET['id'])){
	$id=$_GET['id'];
} else {
	die();
}
$sql=mysql_query("SELECT * FROM pelanggan WHERE id_pelanggan='$id'");
$row=mysql_fetch_array($sql);
?>
<input type="hidden" name="id_pelanggan" value="<?php echo $id ?>">
<div class="input-group">
	<span class="input-group-addon"><i class="fa fa-building fa-fw"></i></span>
	<input class="form-control" id="nama" name="nama_pelanggan" placeholder="Nama Pelanggan" value="<?php echo $row['nama_pelanggan']; ?>" maxlength="50" required>
	<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
</div>
<div class="input-group">
	<span class="input-group-addon"><i class="fa fa-map-marker fa-fw"></i></span>
	<input name="alamat" class="form-control" placeholder="Alamat" value="<?php echo $row['alamat']; ?>" maxlength="100" required>
	<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
</div>
<div class="input-group">
	<span class="input-group-addon"><i class="fa fa-map-marker fa-fw"></i></span>
	<input name="lat" class="form-control" placeholder="Latitude" value="<?php echo $row['lat']; ?>" maxlength="50" readonly>
</div>
<div class="input-group">
	<span class="input-group-addon"><i class="fa fa-map-marker fa-fw"></i></span>
	<input name="lng" class="form-control" placeholder="Longitude" value="<?php echo $row['lng']; ?>" maxlength="50" readonly>
</div>
<div class="input-group">
	<span class="input-group-addon"><i class="fa fa-phone fa-fw"></i></span>
	<input class="form-control" type="number" name="telepon_pelanggan" placeholder="Telepon Pelanggan" value="<?php echo $row['telepon_pelanggan']; ?>" onKeyPress="if(this.value.length==20) return false;" required>
	<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
</div>
<div class="input-group">
	<span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
	<input name="kontak" class="form-control" placeholder="Kontak Person" value="<?php echo $row['kontakperson']; ?>" maxlength="30" required>
</div>
<div class="input-group">
	<span class="input-group-addon"><i class="fa fa-phone fa-fw"></i></span>
	<input class="form-control" type="number" name="telepon_kontak" placeholder="Telepon Kontak Person" value="<?php echo $row['telepon_kontak']; ?>" onKeyPress="if(this.value.length==20) return false;" required>
</div>
<div class="input-group">
	<span class="input-group-addon"><i class="fa fa-arrows-v fa-fw"></i></span>
	<input id="plafon_2" name="plafon" class="form-control" placeholder="Plafon (Rp)" value="<?php echo $row['plafon']; ?>" required>
	<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
</div>
<div class="input-group">
	<span class="input-group-addon"><i class="fa fa-barcode fa-fw"></i></span>
	<input name="barcode" class="form-control" placeholder="Barcode" value="<?php echo $row['barcode']; ?>" maxlength="20" required>
	<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
</div>
<div class="input-group">
	<span class="input-group-addon"><i class="fa fa-flag fa-fw"></i></span>
	<select class="form-control" name="status" required>
		<option value="" disabled selected>Pilih Status</option>
		<option value="0" <?php echo ($row['status'] == '0' ? 'selected' : '') ?> >NON AKTIF</option>
		<option value="1" <?php echo ($row['status'] == '1' ? 'selected' : '') ?> >AKTIF</option>
	</select>
	<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
</div>
<div class="input-group">
	<span class="input-group-addon"><i class="fa fa-flag fa-fw"></i></span>
	<select class="form-control" name="blacklist" required>
		<option value="" disabled selected>Blacklist ?</option>
		<option value="0" <?php echo ($row['blacklist'] == '0' ? 'selected' : '') ?> >TIDAK</option>
		<option value="1" <?php echo ($row['blacklist'] == '1' ? 'selected' : '') ?> >YA</option>
	</select>
	<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
</div>
