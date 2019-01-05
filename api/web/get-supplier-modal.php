<?php
date_default_timezone_set('Asia/Jakarta');
require_once('../../assets/inc/config.php');
require_once('../../assets/inc/publicfunc.php');

if (isset($_GET['id_supplier'])){
	$id_supplier=$_GET['id_supplier'];
	$id_negara=$_GET['id_negara'];
	$id_prov=$_GET['id_prov'];
	$id_kab=$_GET['id_kab'];
	$id_kec=$_GET['id_kec'];
	$id_kel=$_GET['id_kel'];
} else {
	die();
}
$sql=mysql_query("SELECT * FROM supplier WHERE id_supplier='$id_supplier'");
$row=mysql_fetch_array($sql);
?>
<input type="hidden" name="id_supplier" value="<?php echo $id_supplier ?>">
<div class="col-sm-12">
	<div class="input-group">
		<span class="input-group-addon"><i class="fa fa-building fa-fw"></i></span>
		<input class="form-control" id="nama" name="nama_supplier" placeholder="Nama Supplier" value="<?php echo $row['nama_supplier']; ?>" maxlength="50" required>
		<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
	</div>
	<div class="input-group">
		<span class="input-group-addon"><i class="fa fa-map-marker fa-fw"></i></span>
		<input name="alamat" class="form-control" placeholder="Alamat Supplier" value="<?php echo $row['alamat']; ?>" maxlength="200" required>
		<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
	</div>
</div>
	<div class="col-sm-6">
		<div class="input-group">
			<span class="input-group-addon"><i class="fa fa-map-marker fa-fw"></i></span>
			<select id="select_negara_2" class="select2 form-control" name="id_negara" required>
				<option value="" disabled selected>Pilih Negara</option>
					<?php
						$sql=mysql_query("SELECT * FROM negara");
						while ($rows=mysql_fetch_array($sql)){
							echo '<option value="' .$rows['id_negara']. '" ' .($row['id_negara'] == $rows['id_negara'] ? 'selected' : ''). '>' .$rows['nama_negara']. '</option>';
						}
					?>
			</select>
			<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="input-group">
			<span class="input-group-addon"><i class="fa fa-map-marker fa-fw"></i></span>
			<select id="select_prov_2" class="select2 form-control" name="id_prov" required>
				<?php
					$sql=mysql_query("SELECT * FROM provinsi WHERE id_negara=" .$id_negara);
					while ($rows=mysql_fetch_array($sql)){
						echo '<option value="' .$rows['id_prov']. '" ' .($row['id_prov'] == $rows['id_prov'] ? 'selected' : ''). '>' .$rows['nama_prov']. '</option>';
					}
				?>
			</select>
			<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="input-group">
			<span class="input-group-addon"><i class="fa fa-map-marker fa-fw"></i></span>
			<select id="select_kab_2" class="select2 form-control" name="id_kab" required>
				<?php
					$sql=mysql_query("SELECT * FROM kabupaten WHERE id_prov=" .$id_prov);
					while ($rows=mysql_fetch_array($sql)){
						echo '<option value="' .$rows['id_kab']. '" ' .($row['id_kab'] == $rows['id_kab'] ? 'selected' : ''). '>' .$rows['nama_kab']. '</option>';
					}
				?>
			</select>
			<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="input-group">
			<span class="input-group-addon"><i class="fa fa-map-marker fa-fw"></i></span>
			<select id="select_kec_2" class="select2 form-control" name="id_kec">
				<?php
					$sql=mysql_query("SELECT * FROM kecamatan WHERE id_kab=" .$id_kab);
					while ($rows=mysql_fetch_array($sql)){
						echo '<option value="' .$rows['id_kec']. '" ' .($row['id_kec'] == $rows['id_kec'] ? 'selected' : ''). '>' .$rows['nama_kec']. '</option>';
					}
				?>
			</select>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="input-group">
			<span class="input-group-addon"><i class="fa fa-map-marker fa-fw"></i></span>
			<select id="select_kel_2" class="select2 form-control" name="id_kel">
				<?php
					$sql=mysql_query("SELECT * FROM kelurahan WHERE id_kec=" .$id_kec);
					while ($rows=mysql_fetch_array($sql)){
						echo '<option value="' .$rows['id_kel']. '" ' .($row['id_kel'] == $rows['id_kel'] ? 'selected' : ''). '>' .$rows['nama_kel']. '</option>';
					}
				?>
			</select>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="input-group">
			<span class="input-group-addon"><i class="fa fa-map-marker fa-fw"></i></span>
			<input name="kode_pos" type="number" class="form-control" placeholder="Kode Pos" value="<?php echo $row['kode_pos']; ?>" onKeyPress="if(this.value.length==7) return false;">
		</div>
	</div>
	<div class="col-sm-12">
		<div class="input-group">
			<span class="input-group-addon"><i class="fa fa-phone fa-fw"></i></span>
			<input name="telepon_supplier" type="number" class="form-control" placeholder="Telepon Supplier" value="<?php echo $row['telepon_supplier']; ?>" onKeyPress="if(this.value.length==20) return false;" required>
			<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
		</div>
	</div>
	<div class="col-sm-12">
		<div class="input-group">
			<span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
			<input name="kontak" class="form-control" placeholder="Kontak Person" value="<?php echo $row['kontakperson']; ?>" maxlength="50" required>
		</div>
	<div class="input-group">
		<span class="input-group-addon"><i class="fa fa-phone fa-fw"></i></span>
		<input name="telepon_kontak" type="number" class="form-control" placeholder="Telepon Kontak Person" value="<?php echo $row['telepon_kontak']; ?>" onKeyPress="if(this.value.length==20) return false;" required>
	</div>
	<div class="input-group">
		<span class="input-group-addon"><i class="fa fa-flag fa-fw"></i></span>
		<select class="form-control" id="select_status" name="status" required>
			<option value="" disabled selected>Pilih Status</option>
			<option value="0" <?php echo ($row['status'] == 0 ? 'selected' : '') ?> >NON AKTIF</option>
			<option value="1" <?php echo ($row['status'] == 1 ? 'selected' : '') ?> >AKTIF</option>
		</select>
		<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
	</div>
</div>

<script>
$(".select2").select2({
	placeholderOption: "first",
	allowClear: true,
	width: '100%'
});
</script>