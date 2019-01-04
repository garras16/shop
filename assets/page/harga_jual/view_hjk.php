<?php
	if (isset($tambah_harga_jual_kredit_post)){
		$sql=mysqli_query($con, "SELECT * FROM harga_jual_kredit WHERE id_harga_jual=$id AND hari=$hari");
		$c=mysql_num_rows($sql);
		if (!$c>0){
			$sql = "INSERT INTO harga_jual_kredit VALUES(null,$id,$harga_jual,$hari)";
			$q = mysqli_query($con, $sql);
			if ($q){
				_buat_pesan("Input Berhasil. Sekarang Anda dapat melakukan transaksi pembelian.","green");
			} else {
				_buat_pesan("Input Gagal","red");
			}
		} else {
			_buat_pesan("Input Gagal","red");
		}
		_direct("?page=harga_jual&mode=view_hjk&id=$id");
	}
	if (isset($edit_harga_jual_kredit_post)){
		$sql=mysqli_query($con, "SELECT * FROM harga_jual_kredit WHERE id_harga_jual=$id AND hari=$hari");
		$c=mysql_num_rows($sql);
		if ($c=1){
			$sql = "UPDATE harga_jual_kredit SET harga_kredit=$harga_jual,hari=$hari WHERE id_harga_jual_kredit=$id_harga_jual_kredit";
			$q = mysqli_query($con, $sql);
			if ($q){
				_buat_pesan("Input Berhasil","green");
			} else {
				_buat_pesan("Input Gagal","red");
			}
		} else {
			_buat_pesan("Input Gagal","red");
		}
		_direct("?page=harga_jual&mode=view_hjk&id=$id");
	}
	$sql=mysqli_query($con, "SELECT
	    barang.nama_barang
	    , supplier.nama_supplier
		, pelanggan.id_pelanggan
	    , pelanggan.nama_pelanggan
	FROM
	    harga_jual
	    INNER JOIN barang_supplier 
	        ON (harga_jual.id_barang_supplier = barang_supplier.id_barang_supplier)
	    INNER JOIN barang 
	        ON (barang_supplier.id_barang = barang.id_barang)
	    INNER JOIN supplier 
	        ON (barang_supplier.id_supplier = supplier.id_supplier)
	    INNER JOIN pelanggan 
	        ON (harga_jual.id_pelanggan = pelanggan.id_pelanggan)
	WHERE id_harga_jual=$id");
	$row=mysqli_fetch_array($sql);
?>

<!-- page content -->
<div class="right_col" role="main">
	<div class="">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<h3>LIHAT HARGA JUAL KREDIT</h3>
						<?php
							if (isset($pesan)) echo '<span class="badge bg-' .$warna. '">' .$pesan. '</span><br/><br/>';
						?>
						<div class="clearfix"></div>
						</div>
						<div class="x_content">
						<div class="col-xs-6">
							<a class="btn btn-danger" href="?page=harga_jual&mode=view_detail&id=<?php echo $row['id_pelanggan'] ?>"><i class="fa fa-arrow-left"></i> Kembali</a><br/><br/>
						</div>
						<div class="col-xs-6">
							<p align="right"><a class="btn btn-primary" onClick="reset();"><i class="fa fa-warning"></i> Reset</a><br/><br/></p>
						</div>
						<div id="dummy"></div>
						<div class="clearfix"></div>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-user fa-fw"></i><br><small>Pelanggan</small></span>
							<input class="form-control" style="padding: 20px 15px;" value="<?php echo $row['nama_pelanggan'] ?>" readonly="readonly">
						</div>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-archive fa-fw" style="width: 56px;"></i><br><small>Barang</small></span>
							<input class="form-control" style="padding: 20px 15px;" value="<?php echo $row['nama_barang'] ?>" readonly="readonly" style="color:black">
						</div>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-building fa-fw" style="width: 56px;"></i><br><small>Supplier</small></sup></span>
							<input class="form-control" style="padding: 20px 15px;" value="<?php echo $row['nama_supplier'] ?>" readonly="readonly">
						</div>
						<br/><br/>
						<div class="col-xs-12 bg-blue">
							<div class="col-xs-6">
								<h5>Harga Jual Kredit (Rp)</h5>
							</div>
							<div class="col-xs-5">
								<h5>Jangka Waktu Maks (hari)</h5>
							</div>
							<div class="col-xs-1">
								<h5></h5>
							</div>
						</div>
						
							<div class="clearfix"></div><br/>
						<div id="hjk_content" class="col-xs-12">
							
						</div>
						<div id="input_hjk" class="col-xs-12">
							
						</div>
						<div class="clearfix"></div><br/>
						<div class="col-xs-12 text-right">
							<a id="tambah" class="btn btn-primary" onClick="addRow()"><i class="fa fa-plus"></i> Tambah</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /page content -->
	</div>
</div>




<script>
function addRow(){
	$('#input_hjk').load('assets/page/harga_jual/input_hjk.php?id=<?php echo $id ?>');
	$('#tambah').attr('style','display:none');
}
function clearRow(){
	$('#input_hjk').empty();
	$('#tambah').removeAttr('style');
}
function reset(){
	$('#dummy').load('assets/page/harga_jual/add-hjk-detail.php?id=<?php echo $id ?>', function(){
		$(this).empty();
		$('#hjk_content').empty();
	});
}
$(document).ready(function(){
	$('#hjk_content').load('assets/page/harga_jual/content_hjk.php?id=<?php echo $id ?>');
});
</script>