<?php
if (isset($edit_satuan_post)){
	$sql=mysql_query("UPDATE satuan SET nama_satuan='$nama_satuan' WHERE id_satuan='$id'");
	if ($sql){
		_buat_pesan("Input Berhasil","green");
	} else {
		_buat_pesan("Input Gagal","red");
	}
	_direct("index.php?page=master&mode=satuan");
}
	$sql=mysql_query("SELECT * FROM satuan WHERE id_satuan=$id");
	$row=mysql_fetch_array($sql);
?>

<div class="right_col" role="main">
	<div class="">
		<div class="row">
			<h3>UBAH SATUAN BARANG</h3>
			<?php
			if (isset($pesan)){
				echo '<span class="badge bg-' .$warna. '">' .$pesan. '</span>';
			}
			?>
			<a href="?page=satuan"><button class="btn btn-danger"><i class="fa fa-arrow-left"></i> Kembali</button></a>
			<form action="" method="post">
				<input type="hidden" name="edit_satuan_post" value="true">
				<div class="form-group col-sm-12">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-tag fa-fw"></i></span>
						<input class="form-control" id="nama_satuan" name="nama_satuan" value="<?php echo $row['nama_satuan']; ?>" maxlength="10">
						<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
					</div>
				</div>									
				<div class="modal-footer">												
					<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
				</div>
			</form>
		</div>
	</div>
</div>