<?php
date_default_timezone_set('Asia/Jakarta');
require_once('../../assets/inc/config.php');
require_once('../../assets/inc/publicfunc.php');

if (isset($_GET['id'])){
	$id=$_GET['id'];
} else {
	die();
}
$sql=mysql_query("SELECT * FROM barang WHERE id_barang='$id'");
$row=mysql_fetch_array($sql);
?>
<input type="hidden" name="id_barang" value="<?php echo $id ?>">
<div class="input-group">
	<span class="input-group-addon"><i class="fa fa-bookmark fa-fw"></i></span>
	<input class="form-control" id="nama_barang" name="nama_barang" value="<?php echo $row['nama_barang']; ?>" maxlength="100" required>
	<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
</div>
<div class="input-group">
	<span class="input-group-addon"><i class="fa fa-barcode fa-fw"></i></span>
	<input id="barcode" name="barcode" class="form-control" placeholder="Barcode" value="<?php echo $row['barcode']; ?>" maxlength="30" required>
	<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
</div>
<div class="input-group">
	<span class="input-group-addon"><i class="fa fa-tag fa-fw"></i></span>
	<select class="select2 form-control" id="select_satuan" name="id_satuan" required>
		<option value="" disabled selected>Pilih Satuan</option>
		<?php 
			$brg=mysql_query("select * from satuan");
			while($b=mysql_fetch_array($brg)){
		?>
		<option value="<?php echo $b['id_satuan']; ?>" <?php echo ($b['id_satuan'] == $row['id_satuan'] ? 'selected' : '') ?> ><?php echo $b['nama_satuan'];?></option>
		<?php 
			}
		?>
	</select>
	<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
</div>
<div class="input-group">
	<span class="input-group-addon"><i class="fa fa-warning fa-fw"></i></span>
	<input id="min_order_2" name="min_order" class="form-control" placeholder="Minimal Jual" min="1" onKeyPress="if(this.value.length==6) return false;" value="<?php echo $row['min_order']; ?>" required>
	<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
</div>
<div class="input-group">
	<span class="input-group-addon"><i class="fa fa-warning fa-fw"></i></span>
	<input id="stok_min_2" name="stok_minimal" class="form-control" placeholder="Stok Minimal" min="1" onKeyPress="if(this.value.length==6) return false;" value="<?php echo $row['stok_minimal']; ?>" required>
	<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
</div>
<div class="input-group">
	<span class="input-group-addon"><i class="fa fa-certificate fa-fw"></i></span>
	<input id="ijin" name="ijin" class="form-control" placeholder="No. Ijin" value="<?php echo $row['no_ijin']; ?>" maxlength="25" required>
	<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
</div>
<div class="input-group">
	<span class="input-group-addon"><i class="fa fa-flag fa-fw"></i></span>
	<select class="form-control" id="select_status" name="status" required>
		<option value="" disabled>Pilih Status</option>
		<option value="0" <?php echo ($row['status'] == 0 ? 'selected' : '') ?> >NON AKTIF</option>
		<option value="1" <?php echo ($row['status'] == 1 ? 'selected' : '') ?> >AKTIF</option>
	</select>
	<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
</div>
<div class="input-group">
	<span class="input-group-addon"><i class="fa fa-flag fa-fw"></i></span>
	<select class="form-control" id="select_tampil" name="tampil" required>
		<option value="" disabled selected>Tampilkan ke semua user ?</option>
		<option value="0" <?php echo ($row['tampil'] == 0 ? 'selected' : '') ?> >TIDAK</option>
		<option value="1" <?php echo ($row['tampil'] == 1 ? 'selected' : '') ?> >YA</option>
	</select>
	<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
</div>

<script>
$(".select2").select2({
	placeholderOption: "first",
	allowClear: true,
	width: '100%'
});
</script>