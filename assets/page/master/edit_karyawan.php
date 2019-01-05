<?php
if (isset($edit_karyawan_post)){
	$sql = "UPDATE karyawan SET nama_karyawan='$nama_karyawan',barcode='$barcode',ktp='$ktp',no_hp='$no_hp',id_jabatan=$jabatan,gaji=$gaji WHERE id_karyawan='$id'";
	if ($sql){
		_buat_pesan("Input Berhasil","green");
	} else {
		_buat_pesan("Input Gagal","red");
	}
	_direct("index.php?page=master&mode=karyawan");
}
$sql=mysql_query("SELECT * FROM karyawan WHERE id_karyawan=$id");
$row=mysql_fetch_array($sql);
?>
<!-- page content -->
		<div class="right_col" role="main">
			<div class="">
			<div class="row">
			<h3>UBAH KARYAWAN</h3>
			<?php
			if (isset($pesan)){
				echo '<span class="badge bg-' .$warna. '">' .$pesan. '</span>';
			}
			?>
			<a href="?page=karyawan"><button class="btn btn-danger"><i class="fa fa-arrow-left"></i> Kembali</button></a>
			<form action="" method="post">
					<input type="hidden" name="edit_karyawan_post" value="true">
					<div class="col-md-12">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
						<input class="form-control" id="nama" name="nama_karyawan" placeholder="Nama Karyawan" value="<?php echo $row['nama_karyawan']; ?>" maxlength="50" required>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-barcode fa-fw"></i></span>
						<input name="barcode" class="form-control" placeholder="Barcode" value="<?php echo $row['barcode']; ?>" maxlength="10" required>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-credit-card fa-fw"></i></span>
						<input class="form-control" type="number" name="ktp" placeholder="No. KTP" value="<?php echo $row['ktp']; ?>" onKeyPress="if(this.value.length==16) return false;" required>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-phone fa-fw"></i></span>
						<input class="form-control" type="number" name="no_hp" placeholder="No. HP" value="<?php echo $row['no_hp']; ?>" onKeyPress="if(this.value.length==15) return false;" required>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-briefcase fa-fw"></i></span>
						<select class="form-control" id="select_jabatan" name="jabatan" required>
							<option value="" disabled selected>Pilih Jabatan</option>
							<?php 
								$sql=mysql_query("select * from jabatan");
								while($b=mysql_fetch_array($sql)){
							?>	
							<option value="<?php echo $b['id_jabatan']; ?>" <?php echo select_opsi($row['id_jabatan'], $b['id_jabatan']) ?> ><?php echo $b['nama_jabatan'];?></option>
							<?php 
								}
							?>
						</select>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-money fa-fw"></i></span>
						<input class="form-control" id="gaji" name="gaji" value="<?php echo $row['gaji']; ?>" placeholder="Gaji" required>
					</div>
					</div>
					<div class="modal-footer">
						<input type="submit" class="btn btn-primary" value="Simpan">
					</div>
				</form>
			</div>
			</div>
		</div>
		<!-- /page content -->

        
      </div>
    </div>

	
<script>
$(document).ready(function(){
	$('#gaji').inputmask('currency', {prefix: '', rightAlign: false, autoUnmask: true, removeMaskOnSubmit:true});
});
</script>