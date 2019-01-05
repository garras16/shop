<?php
if (isset($edit_supplier_post)){
	$sql=mysql_query("UPDATE supplier SET nama_supplier='$nama_supplier',alamat='$alamat',id_negara=$id_negara,id_prov=$id_prov,id_kab=$id_kab,id_kec=$id_kec,id_kel=$id_kel,kode_pos='$kode_pos',telepon_supplier='$telepon_supplier',kontakperson='$kontak',telepon_kontak='$telepon_kontak',status='$status' WHERE id_supplier=$id");
	if ($sql){
		_buat_pesan("Input Berhasil","green");
	} else {
		_buat_pesan("Input Gagal","red");
	}
	_direct("index.php?page=master&mode=supplier");
}
	$sql=mysql_query("SELECT * FROM supplier WHERE id_supplier=$id");
	$row=mysql_fetch_array($sql);
?>

<div class="right_col" role="main">
	<div class="">
		<div class="row">
			<h3>UBAH DATA SUPPLIER</h3>
			<?php
			if (isset($pesan)){
				echo '<span class="badge bg-' .$warna. '">' .$pesan. '</span>';
			}
			?>
			<a href="?page=supplier"><button class="btn btn-danger"><i class="fa fa-arrow-left"></i> Kembali</button></a>
			<form action="" method="post">
				<input type="hidden" name="edit_supplier_post" value="true">
				<div class="form-group col-sm-12">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-building fa-fw"></i></span>
						<input class="form-control" id="nama" name="nama_supplier" placeholder="Nama Supplier" value="<?php echo $row['nama_supplier']; ?>" maxlength="50">
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-map-marker fa-fw"></i></span>
						<input name="alamat" class="form-control" placeholder="Alamat Supplier" maxlength="200" value="<?php echo $row['alamat']; ?>" required>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-map-marker fa-fw"></i></span>
						<select id="select_negara" class="form-control" name="id_negara" required>
							<option value="" disabled selected>Pilih Negara</option>
								<?php
									$sql=mysql_query("SELECT * FROM negara");
									while ($rows=mysql_fetch_array($sql)){
										echo '<option value="' .$rows['id_negara']. '" ' .($row['id_negara'] == $rows['id_negara'] ? 'selected' : ''). '>' .$rows['nama_negara']. '</option>';
									}
								?>
						</select>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-map-marker fa-fw"></i></span>
						<select id="select_prov" class="form-control" name="id_prov" required>
							<option value="" disabled selected>Pilih Provinsi</option>
								<?php
									$sql=mysql_query("SELECT * FROM provinsi");
									while ($rows=mysql_fetch_array($sql)){
										echo '<option value="' .$rows['id_prov']. '" ' .($row['id_prov'] == $rows['id_prov'] ? 'selected' : ''). '>' .$rows['nama_prov']. '</option>';
									}
								?>
						</select>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-map-marker fa-fw"></i></span>
						<select id="select_kab" class="form-control" name="id_kab" required>
							<option value="" disabled selected>Pilih Kabupaten</option>
								<?php
									$sql=mysql_query("SELECT * FROM kabupaten");
									while ($rows=mysql_fetch_array($sql)){
										echo '<option value="' .$rows['id_kab']. '" ' .($row['id_kab'] == $rows['id_kab'] ? 'selected' : ''). '>' .$rows['nama_kab']. '</option>';
									}
								?>
						</select>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-map-marker fa-fw"></i></span>
						<select id="select_kec" class="form-control" name="id_kec" required>
							<option value="" disabled selected>Pilih Kecamatan</option>
								<?php
									$sql=mysql_query("SELECT * FROM kecamatan");
									while ($rows=mysql_fetch_array($sql)){
										echo '<option value="' .$rows['id_kec']. '" ' .($row['id_kec'] == $rows['id_kec'] ? 'selected' : ''). '>' .$rows['nama_kec']. '</option>';
									}
								?>
						</select>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-map-marker fa-fw"></i></span>
						<select id="select_kel" class="form-control" name="id_kel" required>
							<option value="" disabled selected>Pilih Kelurahan</option>
								<?php
									$sql=mysql_query("SELECT * FROM kelurahan");
									while ($rows=mysql_fetch_array($sql)){
										echo '<option value="' .$rows['id_kel']. '" ' .($row['id_kel'] == $rows['id_kel'] ? 'selected' : ''). '>' .$rows['nama_kel']. '</option>';
									}
								?>
						</select>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-map-marker fa-fw"></i></span>
						<input name="kode_pos" class="form-control" type="number" placeholder="Kode Pos" value="<?php echo $row['kode_pos']; ?>" onKeyPress="if(this.value.length==7) return false;" required>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-phone fa-fw"></i></span>
						<input name="telepon_supplier" class="form-control" type="number" placeholder="Telepon Supplier" value="<?php echo $row['telepon_supplier']; ?>" max="99999999999999999999" required>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
						<input name="kontak" class="form-control" placeholder="Kontak Person" value="<?php echo $row['kontakperson']; ?>" maxlength="50" required>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-phone fa-fw"></i></span>
						<input name="telepon_kontak" class="form-control" type="number" placeholder="Telepon Kontak Person" value="<?php echo $row['telepon_kontak']; ?>" max="99999999999999999999" required>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-flag fa-fw"></i></span>
						<select class="form-control" id="select_status" name="status" required>
							<option value="" disabled selected>Pilih Status</option>
							<option value="0" <?php echo ($row['status'] == 0 ? 'selected' : '') ?> >NON AKTIF</option>
							<option value="1" <?php echo ($row['status'] == 1 ? 'selected' : '') ?> >AKTIF</option>
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
$('#select_negara').change(function(){
	var id=$(this).val();
	$('#select_prov').load('api/get-select.php?id_negara=' + id);
	$('#select_kab').empty();
	$('#select_kec').empty();
	$('#select_kel').empty();
});
$('#select_prov').change(function(){
	var id=$(this).val();
	$('#select_kab').load('api/get-select.php?id_prov=' + id);
	$('#select_kec').empty();
	$('#select_kel').empty();
});
$('#select_kab').change(function(){
	var id=$(this).val();
	$('#select_kec').load('api/get-select.php?id_kab=' + id);
	$('#select_kel').empty();
});
$('#select_kec').change(function(){
	var id=$(this).val();
	$('#select_kel').load('api/get-select.php?id_kec=' + id);
});
</script>