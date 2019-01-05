<?php
if (isset($edit_perusahaan_post)){
	$sql = "UPDATE perusahaan SET nama_pt='$nama_pt',alamat='$alamat',id_negara=$id_negara,id_prov=$id_prov,id_kab=$id_kab,id_kec=$id_kec,id_kel=$id_kel,kode_pos='$kode_pos',telepon='$telepon' WHERE id_perusahaan=1";
	$q = mysql_query($sql);
	if ($q){
		_buat_pesan("Input Berhasil","green");
	} else {
		_buat_pesan("Input Gagal","red");
	}
}
$sql=mysql_query("SELECT * FROM perusahaan WHERE id_perusahaan=1");
$row=mysql_fetch_array($sql);
?>
<!-- page content -->
<div class="right_col" role="main">
	<div class="">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<h3>MASTER PERUSAHAAN</h3>
						<?php
							if (isset($pesan)){
								echo '<span class="badge bg-' .$warna. '">' .$pesan. '</span><br/><br/>';
							}
						?>
					<div class="clearfix"></div>
					</div>
					<div class="x_content">
			<form action="" method="post">
				<input type="hidden" name="edit_perusahaan_post" value="true">
				<div class="col-md-12">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-building fa-fw"></i></span>
						<input class="form-control" name="nama_pt" placeholder="Nama Perusahaan" value="<?php echo $row['nama_pt']; ?>" maxlength="50" required>
						<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-map-marker fa-fw"></i></span>
						<input class="form-control" name="alamat" placeholder="Alamat Perusahaan" value="<?php echo $row['alamat']; ?>" maxlength="50" required>
						<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-map-marker fa-fw"></i></span>
						<select id="select_negara" class="select2 form-control" name="id_negara" required>
							<option value="" disabled selected>Pilih Negara</option>
							<?php
								$sql2=mysql_query("SELECT * FROM negara");
								while ($r=mysql_fetch_array($sql2)){
									echo '<option value="' .$r['id_negara']. '" ' .($r['id_negara'] == $row['id_negara'] ? 'selected' : ''). '>' .$r['nama_negara']. '</option>';
								}
							?>
						</select>
						<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-map-marker fa-fw"></i></span>
						<select id="select_prov" class="select2 form-control" name="id_prov" required>
							<option value="" disabled selected>Pilih Provinsi</option>
							<?php
								$sql2=mysql_query("SELECT * FROM provinsi");
								while ($r=mysql_fetch_array($sql2)){
									echo '<option value="' .$r['id_prov']. '" ' .($r['id_prov'] == $row['id_prov'] ? 'selected' : ''). '>' .$r['nama_prov']. '</option>';
								}
							?>
						</select>
						<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-map-marker fa-fw"></i></span>
						<select id="select_kab" class="select2 form-control" name="id_kab" required>
							<option value="" disabled selected>Pilih Kabupaten</option>
							<?php
								$sql2=mysql_query("SELECT * FROM kabupaten");
								while ($r=mysql_fetch_array($sql2)){
									echo '<option value="' .$r['id_kab']. '" ' .($r['id_kab'] == $row['id_kab'] ? 'selected' : ''). '>' .$r['nama_kab']. '</option>';
								}
							?>
						</select>
						<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-map-marker fa-fw"></i></span>
						<select id="select_kec" class="select2 form-control" name="id_kec">
							<option value="" disabled selected>Pilih Kecamatan</option>
							<?php
								$sql2=mysql_query("SELECT * FROM kecamatan");
								while ($r=mysql_fetch_array($sql2)){
									echo '<option value="' .$r['id_kec']. '" ' .($r['id_kec'] == $row['id_kec'] ? 'selected' : ''). '>' .$r['nama_kec']. '</option>';
								}
							?>
						</select>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-map-marker fa-fw"></i></span>
						<select id="select_kel" class="select2 form-control" name="id_kel">
							<option value="" disabled selected>Pilih Kelurahan</option>
							<?php
								$sql2=mysql_query("SELECT * FROM kelurahan");
								while ($r=mysql_fetch_array($sql2)){
									echo '<option value="' .$r['id_kel']. '" ' .($r['id_kel'] == $row['id_kel'] ? 'selected' : ''). '>' .$r['nama_kel']. '</option>';
								}
							?>
						</select>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-map-marker fa-fw"></i></span>
						<input name="kode_pos" type="number" class="form-control" placeholder="Kode Pos" onKeyPress="if(this.value.length==7) return false;" value="<?php echo $row['kode_pos']; ?>">
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-phone fa-fw"></i></span>
						<input class="form-control" name="telepon" placeholder="Telepon" type="number" onKeyPress="if(this.value.length==20) return false;" value="<?php echo $row['telepon']; ?>" required>
						<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
					</div>
					</div>
					<div class="modal-footer">
						<input type="submit" class="btn btn-primary" value="Simpan">
					</div>
				</form>
			</div>
			</div>
			</div>
		</div>
		<!-- /page content -->

        
      </div>
    </div>

	
<script>
	$('#select_negara').change(function(){
		var id=$(this).val();
		$('#select_prov').load('api/web/get-select-daerah.php?id_negara=' + id);
	});
	$('#select_prov').change(function(){
		var id=$(this).val();
		$('#select_kab').load('api/web/get-select-daerah.php?id_prov=' + id);
	});
	$('#select_kab').change(function(){
		var id=$(this).val();
		$('#select_kec').load('api/web/get-select-daerah.php?id_kab=' + id);
	});
	$('#select_kec').change(function(){
		var id=$(this).val();
		$('#select_kel').load('api/web/get-select-daerah.php?id_kec=' + id);
	});
</script>