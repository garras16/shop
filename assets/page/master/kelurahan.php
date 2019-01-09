<?php
if (isset($tambah_kelurahan_post)){
	$nama_kel=explode(",",$kelurahan);
	for ($i=0;$i < count($nama_kel);$i++){
		$sql = "INSERT INTO kelurahan VALUES(null,'$id_kec','$nama_kel[$i]')";
		$q = mysqli_query($con, $sql);
		if ($q){
			_buat_pesan("Input Berhasil","green");
		} else {
			_buat_pesan("Input Gagal","red");
		}
	}
}
if (isset($edit_kelurahan_post)){
	$sql = "UPDATE kelurahan SET nama_kel='$kelurahan' WHERE id_kel=$id_kel";
	$q = mysqli_query($con, $sql);
	if ($q){
		_buat_pesan("Input Berhasil","green");
	} else {
		_buat_pesan("Input Gagal","red");
	}
}
?>
<!-- page content -->
<div class="right_col" role="main">
	<div class="">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<h3>MASTER KELURAHAN</h3>
							<?php
							if (isset($pesan)){
								echo '<span class="badge bg-' .$warna. '">' .$pesan. '</span>';
							}
							?>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
					<div class="alert alert-info">
					  <strong>Klik kolom pada tabel untuk ubah.</strong>
					</div>
				<p align="right"><button class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Tambah</button></p>
			
			<table id="table1" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>No.</th>
						<th>Negara</th>
						<th>Provinsi</th>
						<th>Kabupaten</th>
						<th>Kecamatan</th>
						<th>Kelurahan</th>
					</tr>
				</thead>
				<tbody>
<?php
$sql=mysqli_query($con, "SELECT
    provinsi.nama_prov
    , kabupaten.nama_kab
    , negara.nama_negara
    , kecamatan.nama_kec
	, kelurahan.id_kel
    , kelurahan.nama_kel
FROM
    kabupaten
    INNER JOIN provinsi 
        ON (kabupaten.id_prov = provinsi.id_prov)
    INNER JOIN kecamatan 
        ON (kabupaten.id_kab = kecamatan.id_kab)
    INNER JOIN negara 
        ON (negara.id_negara = provinsi.id_negara)
    INNER JOIN kelurahan 
        ON (kecamatan.id_kec = kelurahan.id_kec)
ORDER BY kelurahan.id_kel DESC");
$i=0;
while($row=mysqli_fetch_array($sql)){
	$i+=1;
	echo '			<tr>
						<td><a data-toggle="modal" data-target="#myModal2" data-id="' .$row['id_kel']. '">' .$i. '</td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id="' .$row['id_kel']. '">' .$row['nama_negara']. '</td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id="' .$row['id_kel']. '">' .$row['nama_prov']. '</td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id="' .$row['id_kel']. '">' .$row['nama_kab']. '</td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id="' .$row['id_kel']. '">' .$row['nama_kec']. '</td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id="' .$row['id_kel']. '">' .$row['nama_kel']. '</td>
					</tr>';
}
?>
					
				</tbody>
			</table>
			</div>
			</div>
			</div>
		</div>
		<!-- /page content -->

        
      </div>
    </div>

	<!-- modal input -->
<div id="myModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Tambah Data Kelurahan
			</div>
			<div class="modal-body">				
				<form action="" method="post">
					<input type="hidden" name="tambah_kelurahan_post" value="true">
					<div class="form-group col-sm-12">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-flag fa-fw"></i><br><small>Negara</small></span>
							<input id="add_negara" class="form-control" style="padding: 20px 15px;" placeHolder="Nama Negara" value="" maxlength="40" readonly>
							<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
						</div>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-flag fa-fw" style="width: 38px;"></i><br><small>Prov.</small></span>
							<input id="add_prov" class="form-control" style="padding: 20px 15px;" placeHolder="Nama Provinsi" value="" maxlength="40" readonly>
							<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
						</div>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-flag fa-fw" style="width: 38px;"></i><br><small>Kab.</small></span>
							<input id="add_kab" style="padding: 20px 15px;" class="form-control" placeHolder="Nama Kabupaten" value="" maxlength="40" readonly>
							<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
						</div>
						<div class="input-group">
							<span class="input-group-addon" style="padding: 2px 12px;"><i class="fa fa-tag fa-fw" style="width: 38px;"></i><br><small>Kec.</small></span>
							<select class="form-control select" id="id_kec" name="id_kec" required>
								<option value="" disabled selected>Pilih Kecamatan</option>
							<?php
								$sql=mysqli_query($con, "SELECT 
									negara.nama_negara , provinsi.id_prov , provinsi.nama_prov, kabupaten.nama_kab, kabupaten.id_kab, kecamatan.nama_kec, kecamatan.id_kec
								FROM 
									negara 
								INNER JOIN 
									provinsi 
									ON 
										(negara.id_negara = provinsi.id_negara) 
								INNER JOIN 
									kabupaten 
									ON (kabupaten.id_prov = provinsi.id_prov)
								INNER JOIN
									kecamatan
									ON (kecamatan.id_kab = kabupaten.id_kab) 
								ORDER BY 
									kecamatan.nama_kec");
								while ($row=mysqli_fetch_array($sql)){
									echo '<option negara="' .$row['nama_negara']. '" prov="' .$row['nama_prov']. '" kab="' .$row['nama_kab']. '" value="' .$row['id_kec']. '">' .$row['nama_kec']. '</option>';
								}
							?>
							</select>
							<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
						</div>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-tag fa-fw" style="width: 38px;"></i><br><small>Nama</small></span>
							<input id="tags_me" name="kelurahan" class="form-control" value="" required />
							<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
						</div>
						<p>Tekan "TAB" atau "koma" untuk menambah kelurahan.</p>
					</div>									
					<div class="modal-footer">
						<input type="submit" class="btn btn-primary" value="Simpan">
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- modal input -->
<div id="myModal2" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Ubah Data Kelurahan</h4>
			</div>
			<div class="modal-body">				
				<form action="" method="post">
					<input type="hidden" name="edit_kelurahan_post" value="true">
					<div id="get_kelurahan" class="col-md-12">
						
					</div>
					<div class="modal-footer">
						<input type="submit" class="btn btn-primary" value="Simpan">
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script>
$(document).ready(function(){
	$('#myModal2').on('show.bs.modal', function(e){
		var id = $(e.relatedTarget).data('id');
		$('#get_kelurahan').load('api/web/get-kelurahan.php?id=' + id,function(){
		
		});
	})
	$('#id_kec').on('change', function(e){
		var element = $(this).find('option:selected');
		var negara = element.attr("negara");
		var prov = element.attr("prov");
		var kab = element.attr("kab");
		$('#add_negara').val(negara);
		$('#add_prov').val(prov);
		$('#add_kab').val(kab);
	})
	$('#tags_me').tagsInput({
		maxChars: 40,
		minWidth: '400px',
		defaultText: 'Kelurahan',
		width: 'auto'	  
	});
});
</script>