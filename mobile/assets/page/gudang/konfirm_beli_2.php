<?php
if (isset($edit_konfirm_beli_2_post)){
	$sql = "UPDATE beli SET id_karyawan=$id_karyawan,id_ekspedisi=$id_ekspedisi WHERE id_beli=$id";
	$q = mysqli_query($con, $sql);
	if ($q){
		$pesan="Input Berhasil";
		$warna="green";
		_direct("?page=gudang&mode=konfirm_beli_3&id=" .$id);
	} else {
		$pesan="Input Gagal";
		$warna="red";
	}
}
$brg=mysqli_query($con, "SELECT
	beli.no_nota_beli
	, beli.tanggal
	, beli.id_karyawan
    , supplier.nama_supplier
    , ekspedisi.id_ekspedisi
    , users.user
FROM
    beli
    LEFT JOIN supplier 
        ON (beli.id_supplier = supplier.id_supplier)
    LEFT JOIN ekspedisi 
        ON (beli.id_ekspedisi = ekspedisi.id_ekspedisi)
    LEFT JOIN users 
        ON (beli.id_karyawan = users.id_karyawan)
    LEFT JOIN beli_detail 
        ON (beli_detail.id_beli = beli.id_beli) WHERE beli.id_beli=$id");
$row=mysqli_fetch_array($brg);
if ($row['id_ekspedisi']!=null){
	_direct("?page=gudang&mode=konfirm_beli_3&id=" .$id);
}
if ($row['user']==null){
	$user=$_SESSION['user'];
	$id_user=$_SESSION['id_karyawan'];
} else {
	$user=$row['user'];
	$id_user=$row['id_karyawan'];
}
?>

<div class="right_col loading" role="main">
	<div class="">
	
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<h3>KONFIRMASI NOTA BELI</h3>
						<?php
							if (isset($pesan)){
								echo '<span class="badge bg-' .$warna. '">' .$pesan. '</span>';
							}
						?>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<form action="" method="post">
						<input type="hidden" name="edit_konfirm_beli_2_post" value="true">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-tags fa-fw"></i></span>
							<input class="form-control" id="no_nota_beli" type="text" name="no_nota_beli" placeholder="No Nota Beli" value="<?php echo $row['no_nota_beli'] ?>" maxlength="50" readonly>
							<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
						</div>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
							<input class="form-control" id="tanggal" name="tanggal" placeholder="Tanggal Nota Beli" value="<?php echo date("d-m-Y",strtotime($row['tanggal'])) ?>" maxlength="50" readonly>
							<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
						</div>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-building fa-fw"></i></span>
							<input class="form-control" id="supplier" type="text" name="supplier" placeholder="Supplier" value="<?php echo $row['nama_supplier'] ?>" maxlength="50" readonly>
							<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
						</div>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
							<input type="hidden" name="id_karyawan" value="<?php echo $id_user ?>">
							<input class="form-control" id="penerima" type="text" name="penerima" placeholder="Penerima Barang" value="<?php echo $user ?>" maxlength="50" readonly>
							<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
						</div>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-truck fa-fw"></i></span>
							<select class="select2 form-control" id="select_ekspedisi" name="id_ekspedisi" required>
								<option value="" disabled selected>Pilih Ekspedisi</option>
								<?php 
									$brg=mysqli_query($con, "SELECT * FROM ekspedisi");
									while($b=mysqli_fetch_array($brg)){
								?>	
								<option value="<?php echo $b['id_ekspedisi']; ?>"><?php echo $b['nama_ekspedisi'];?></option>
								<?php 
									}
								?>
							</select>
							<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
						</div>
						<p align="center"><button type="submit" class="btn btn-primary"><i class="fa fa-save fa-fw"></i> SIMPAN</button></p>
						</form>
					</div>
				</div>
			</div>
			</div>
		</div>	
	</div>
</div>

<script>
function getBack(){
	window.location='index.php?page=gudang&mode=konfirm_beli';
}
$(document).ready(function(){
	$('#select_ekspedisi').val('<?php echo $row["id_ekspedisi"] ?>');
	$('#berat').inputmask('decimal', {allowMinus:false, autoGroup: true, groupSeparator: '.', rightAlign: false, autoUnmask: true, removeMaskOnSubmit: true});
	$('#tarif').inputmask('decimal', {allowMinus:false, autoGroup: true, groupSeparator: '.', rightAlign: false, autoUnmask: true, removeMaskOnSubmit: true});
	$(".select2").select2({
		placeholderOption: "first",
		allowClear: true,
		width: '100%'
	});
});
</script>
