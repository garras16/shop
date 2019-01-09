<?php
if (isset($tambah_kecamatan_post)){
	$nama_kec=explode(",",$kecamatan);
	for ($i=0;$i < count($nama_kec);$i++){
		$sql = "INSERT INTO kecamatan VALUES(null,'$id_kab','$nama_kec[$i]')";
		$q = mysqli_query($con, $sql);
		if ($q){
			_buat_pesan("Input Berhasil","green");
		} else {
			_buat_pesan("Input Gagal","red");
		}
	}
}
if (isset($edit_kecamatan_post)){
	$sql = "UPDATE kecamatan SET nama_kec='$kecamatan' WHERE id_kec=$id_kec";
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
						<h3>MASTER KECAMATAN</h3>
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
					</tr>
				</thead>
				<tbody>
<?php
$sql=mysqli_query($con, "SELECT
    provinsi.nama_prov
    , kabupaten.nama_kab
    , negara.nama_negara
	, kecamatan.id_kec
    , kecamatan.nama_kec
FROM
    kabupaten
    INNER JOIN provinsi 
        ON (kabupaten.id_prov = provinsi.id_prov)
    INNER JOIN kecamatan 
        ON (kabupaten.id_kab = kecamatan.id_kab)
    INNER JOIN negara 
        ON (negara.id_negara = provinsi.id_negara)
ORDER BY kecamatan.id_kec DESC");
$i=0;
while($row=mysqli_fetch_array($sql)){
	$i+=1;
	echo '			<tr>
						<td><a data-toggle="modal" data-target="#myModal2" data-id="' .$row['id_kec']. '">' .$i. '</a></td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id="' .$row['id_kec']. '">' .$row['nama_negara']. '</a></td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id="' .$row['id_kec']. '">' .$row['nama_prov']. '</a></td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id="' .$row['id_kec']. '">' .$row['nama_kab']. '</a></td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id="' .$row['id_kec']. '">' .$row['nama_kec']. '</a></td>
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
				<h4 class="modal-title">Tambah Data Kecamatan
			</div>
			<div class="modal-body">				
				<form action="" method="post">
					<input type="hidden" name="tambah_kecamatan_post" value="true">
					<div class="form-group col-sm-12">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-flag fa-fw" style="width: 37px;"></i><br><small>Negara</small></span>
							<input id="add_negara" class="form-control" style="padding: 20px 15px;" placeHolder="Nama Negara" value="" maxlength="40" readonly>
							<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
						</div>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-flag fa-fw" style="width: 37px;"></i><br><small>Prov.</small></span>
							<input id="add_prov" class="form-control" style="padding: 20px 15px;" placeHolder="Nama Provinsi" value="" maxlength="40" readonly>
							<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
						</div>
						<div class="input-group">
							<span class="input-group-addon" style="padding: 2px 12px;"><i class="fa fa-flag fa-fw" style="width: 37px;"></i><br><small>Kab.</small></span>
							<select class="form-control select" id="id_kab" name="id_kab" required>
								<option value="" disabled selected>Pilih Kabupaten</option>
							<?php
								$sql=mysqli_query($con, "SELECT 
									negara.nama_negara , provinsi.id_prov , provinsi.nama_prov, kabupaten.nama_kab, kabupaten.id_kab
								FROM 
									negara 
								INNER JOIN 
									provinsi 
									ON 
										(negara.id_negara = provinsi.id_negara) 
								INNER JOIN 
									kabupaten 
									ON (kabupaten.id_prov = provinsi.id_prov) 
								ORDER BY 
									provinsi.id_prov");
								while ($row=mysqli_fetch_array($sql)){
									echo '<option negara="' .$row['nama_negara']. '" prov="' .$row['nama_prov']. '" value="' .$row['id_kab']. '">' .$row['nama_kab']. '</option>';
								}
							?>
							</select>
							<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
						</div>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-tag fa-fw" style="width: 37px;"></i><br><small>Nama</small></span>
							<input id="tags_me" name="kecamatan" class="form-control" value="" required />
							<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
						</div>
						<p>Tekan "TAB" atau "koma" untuk menambah kecamatan.</p>
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
				<h4 class="modal-title">Ubah Data Kecamatan</h4>
			</div>
			<div class="modal-body">				
				<form action="" method="post">
					<input type="hidden" name="edit_kecamatan_post" value="true">
					<div id="get_kecamatan" class="col-md-12">
						
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
		$('#get_kecamatan').load('api/web/get-kecamatan.php?id=' + id,function(){
			
		});
	})
	$('#id_kab').on('change', function(e){
		var element = $(this).find('option:selected');
		var negara = element.attr("negara");
		var prov = element.attr("prov");
		$('#add_negara').val(negara);
		$('#add_prov').val(prov);
	})
	$('#tags_me').tagsInput({
		maxChars: 40,
		minWidth: '400px',
		defaultText: 'Kecamatan',
		width: 'auto'	  
	});
});
</script>