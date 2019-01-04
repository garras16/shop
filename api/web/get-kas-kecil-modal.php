<?php
date_default_timezone_set('Asia/Jakarta');
require_once('../../assets/inc/config.php');
require_once('../../assets/inc/publicfunc.php');

if (isset($_GET['id'])){
	$id=$_GET['id'];
} else {
	die();
}
$sql=mysqli_query($con, "SELECT * FROM mst_kas_kecil WHERE id_kas_kecil='$id'");
$row=mysqli_fetch_array($sql);
?>
<input type="hidden" name="id_kas_kecil" value="<?php echo $id ?>">
<div class="input-group">
	<span class="input-group-addon"><i class="fa fa-file fa-fw" style="width: 35px;"></i><br><small>Nama</small></span>
	<input class="form-control" name="nama_kas_kecil" style="padding: 20px 15px;" placeholder="Nama Kas Kecil" value="<?php echo $row['nama_kas_kecil']; ?>" maxlength="100" required>
	<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
</div>
<div class="input-group">
	<span class="input-group-addon" style="padding: 2px 12px;"><i class="fa fa-archive fa-fw" style="width: 35px;"></i><br><small>Jenis</small></span>
	<select class="form-control" id="select_jenis" name="jenis" required>
		<option value="" disabled selected>Pilih Jenis</option>
		<option value="INPUT" <?php echo ($row['jenis'] == 'INPUT' ? 'selected' : '') ?> >KAS MASUK</option>
		<option value="OUTPUT" <?php echo ($row['jenis'] == 'OUTPUT' ? 'selected' : '') ?> >KAS KELUAR</option>
	</select>
	<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
</div>
<div class="input-group">
	<span class="input-group-addon" style="padding: 2px 12px;"><i class="fa fa-archive fa-fw" style="width: 35px;"></i><br><small>Status</small></span>
	<select class="form-control" id="select_status" name="status" required>
		<option value="" disabled selected>Pilih Status</option>
		<option value="0" <?php echo ($row['status'] == '0' ? 'selected' : '') ?> >NON AKTIF</option>
		<option value="1" <?php echo ($row['status'] == '1' ? 'selected' : '') ?> >AKTIF</option>
	</select>
	<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
</div>
