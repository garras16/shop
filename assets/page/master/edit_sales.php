<?php
if (isset($edit_sales_post)){
	$sql=mysqli_query($con, "UPDATE sales SET nama='$nama_sales' WHERE id_sales='$id'");
	if ($sql){
		_buat_pesan("Input Berhasil","green");
	} else {
		_buat_pesan("Input Gagal","red");
	}
	_direct("index.php?page=master&mode=sales");
}
	$sql=mysqli_query($con, "SELECT * FROM sales WHERE id_sales=$id");
	$row=mysqli_fetch_array($sql);
?>

<div class="right_col" role="main">
	<div class="">
		<div class="row">
			<h3>UBAH SALES</h3>
			<?php
			if (isset($pesan)){
				echo '<span class="badge bg-' .$warna. '">' .$pesan. '</span>';
			}
			?>
			<a href="?page=sales"><button class="btn btn-danger"><i class="fa fa-arrow-left"></i> Kembali</button></a>
			<form action="" method="post">
				<div class="form-group col-sm-12">
					<label>Nama Sales</label>
					<input type="hidden" name="edit_sales_post" value="true">
					<input class="form-control" id="nama_sales" name="nama_sales" value="<?php echo $row['nama']; ?>" maxlength="30">
				</div>									
				<div class="modal-footer">												
					<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
				</div>
			</form>
		</div>
	</div>
</div>