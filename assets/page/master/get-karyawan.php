<?php
date_default_timezone_set('Asia/Jakarta');
require_once('../../inc/config.php');
require_once('../../inc/publicfunc.php');

if (isset($_GET['id'])){
	$id=$_GET['id'];
} else {
	die();
}
$sql=mysqli_query($con, "SELECT * FROM karyawan WHERE id_karyawan='$id'");
$row=mysqli_fetch_array($sql);
?>
<input type="hidden" name="id_karyawan" value="<?php echo $id ?>">
<div class="input-group" style="margin-bottom: 5px;">
	<span class="input-group-addon"><i class="fa fa-user fa-fw" style="width: 63px;"></i><br><small>Nama</small></span>
	<input class="form-control" id="nama" name="nama_karyawan" placeholder="Nama Karyawan" title="Nama Karyawan" value="<?php echo $row['nama_karyawan']; ?>" maxlength="50" required style="padding: 20px 10px;">
	<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
</div>
<div class="input-group" style="margin-bottom: 5px;">
	<span class="input-group-addon"><i class="fa fa-barcode fa-fw" style="width: 63px;"></i><br><small>Barcode</small></span>
	<input name="barcode" class="form-control" placeholder="Barcode" title="Barcode" value="<?php echo $row['barcode']; ?>" maxlength="10" required style="padding: 20px 10px;">
	<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
</div>
<div class="input-group" style="margin-bottom: 5px;">
	<span class="input-group-addon"><i class="fa fa-credit-card fa-fw" style="width: 63px;"></i><br><small>No. KTP</small></span>
	<input class="form-control" type="number" name="ktp" placeholder="No. KTP" title="No. KTP" value="<?php echo $row['ktp']; ?>" onKeyPress="if(this.value.length==16) return false;" required  style="padding: 20px 10px;">
	<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
</div>
<div class="input-group" style="margin-bottom: 5px;">
	<span class="input-group-addon"><i class="fa fa-phone fa-fw" style="width: 63px;"></i><br><small>No. HP</small></span>
	<input class="form-control" type="number" name="no_hp" placeholder="No. HP" title="No. HP" value="<?php echo $row['no_hp']; ?>" onKeyPress="if(this.value.length==15) return false;" required style="padding: 20px 10px;">
	<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
</div>
<div class="input-group" style="margin-bottom: 5px;">
	<span class="input-group-addon" style="padding: 3px 12px;"><i class="fa fa-briefcase fa-fw" style="width: 63px;"></i><br><small>Jabatan</small></span>
	<select class="form-control" id="select_jabatan" name="jabatan" required>
		<option value="" disabled selected >Pilih Jabatan</option>
			<?php 
				$sql=mysqli_query($con, "select * from jabatan");
				while($b=mysqli_fetch_array($sql)){
			?>	
		<option value="<?php echo $b['id_jabatan']; ?>" <?php echo select_opsi($row['id_jabatan'], $b['id_jabatan']) ?>><?php echo $b['nama_jabatan'];?></option>
			<?php 
				}
			?>
	</select>
	<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
</div>
<div class="input-group" style="margin-bottom: 5px;">
	<span class="input-group-addon"><i class="fa fa-money fa-fw" style="width: 63px;"></i><br><small>Gaji Rp.</small></span>
	<input class="form-control" id="gaji_2" name="gaji" placeHolder="Gaji (Rp)" title="Gaji" value="<?php echo $row['gaji']; ?>" required style="padding: 20px 10px;">
	<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
</div>
<div class="input-group" style="margin-bottom: 5px;">
	<span class="input-group-addon"><i class="fa fa-money fa-fw" style="width: 63px;"></i><br><small>Harian Rp.</small></span>
	<input class="form-control" id="harian_2" name="harian" placeHolder="Harian (Rp)" title="Harian" value="<?php echo $row['harian']; ?>"  style="padding: 20px 10px;">
</div>
<div class="input-group" style="margin-bottom: 5px;">
	<span class="input-group-addon"><i class="fa fa-money fa-fw"></i><br><small> Lembur Rp.</small></span>
	<input class="form-control" id="lembur_2" name="lembur" placeHolder="Lembur(Rp)" title="Lembur" value="<?php echo $row['lembur']; ?>"  style="padding: 20px 10px;">
</div>
<div class="input-group" style="margin-bottom: 5px;">
	<span class="input-group-addon" style="padding: 2px 12px;"><i class="fa fa-flag fa-fw" style="width: 62px;"></i><br><small>Status</small></span>
	<select class="form-control" id="select_status" name="status" required>
		<option value="" disabled>Pilih Status</option>
		<option value="0" <?php if($row['status']==0) { echo "selected";}else{ } ?> >NON AKTIF</option>
		<option value="1" <?php if($row['status']==1) { echo "selected";}else{ } ?> >AKTIF</option>
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