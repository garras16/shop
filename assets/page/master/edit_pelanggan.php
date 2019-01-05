<?php
if (isset($edit_pelanggan_post)){
	$sql=mysqli_query($con, "UPDATE pelanggan SET nama_pelanggan='$nama_pelanggan',alamat='$alamat',telepon_pelanggan='$telepon_pelanggan',kontakperson='$kontak',telepon_kontak='$telepon_kontak',plafon=$plafon,barcode='$barcode',status=$status,blacklist=$blacklist WHERE id_pelanggan='$id'");
	if ($sql){
		_buat_pesan("Input Berhasil","green");
	} else {
		_buat_pesan("Input Gagal","red");
	}
	_direct("index.php?page=master&mode=pelanggan");
}
	$sql=mysqli_query($con, "SELECT * FROM pelanggan WHERE id_pelanggan=$id");
	$row=mysqli_fetch_array($sql);
?>

<div class="right_col" role="main">
	<div class="">
		<div class="row">
			<h3>UBAH PELANGGAN</h3>
			<?php
			if (isset($pesan)){
				echo '<span class="badge bg-' .$warna. '">' .$pesan. '</span>';
			}
			?>
			<a href="?page=pelanggan"><button class="btn btn-danger"><i class="fa fa-arrow-left"></i> Kembali</button></a>
			<form action="" method="post">
				<input type="hidden" name="edit_pelanggan_post" value="true">
				<div class="form-group col-sm-12">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-building fa-fw"></i></span>
						<input class="form-control" id="nama" name="nama_pelanggan" placeholder="Nama Pelanggan" value="<?php echo $row['nama_pelanggan']; ?>" maxlength="50" required>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-map-marker fa-fw"></i></span>
						<input name="alamat" class="form-control" placeholder="Alamat" value="<?php echo $row['alamat']; ?>" maxlength="100" required>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-phone fa-fw"></i></span>
						<input class="form-control" type="number" name="telepon_pelanggan" placeholder="Telepon Pelanggan" value="<?php echo $row['telepon_pelanggan']; ?>" onKeyPress="if(this.value.length==20) return false;" required>
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
						<input id="plafon" name="plafon" class="form-control" placeholder="Plafon" value="<?php echo $row['plafon']; ?>" min="0" required>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-barcode fa-fw"></i></span>
						<input name="barcode" class="form-control" placeholder="Barcode" value="<?php echo $row['barcode']; ?>" maxlength="20" required>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-flag fa-fw"></i></span>
						<select class="form-control" name="status" required>
							<option value="" disabled selected>Pilih Status</option>
							<option value="0" <?php echo ($row['status'] == '0' ? 'selected' : '') ?> >NON AKTIF</option>
							<option value="1" <?php echo ($row['status'] == '1' ? 'selected' : '') ?> >AKTIF</option>
						</select>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-flag fa-fw"></i></span>
						<select class="form-control" name="blacklist" required>
							<option value="" disabled selected>Blacklist ?</option>
							<option value="0" <?php echo ($row['blacklist'] == '0' ? 'selected' : '') ?> >TIDAK</option>
							<option value="1" <?php echo ($row['blacklist'] == '1' ? 'selected' : '') ?> >YA</option>
						</select>
					</div>
				</div>
				<div class="modal-footer">
					<input type="submit" class="btn btn-primary" value="Simpan">
				</div>
			</form>
		</div>
	</div>
</div>
<script>
$(document).ready(function(){
	$('#plafon').inputmask('currency', {prefix: '', rightAlign: false, autoUnmask: true, removeMaskOnSubmit:true});
});
</script>