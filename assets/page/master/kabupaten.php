<?php
if (isset($tambah_kabupaten_post)){
	$nama_kab=explode(",",$kabupaten);
	for ($i=0;$i < count($nama_kab);$i++){
		$sql = "INSERT INTO kabupaten VALUES(null,'$id_prov','$nama_kab[$i]')";
		$q = mysqli_query($con, $sql);
		if ($q){
			_buat_pesan("Input Berhasil","green");
		} else {
			_buat_pesan("Input Gagal","red");
		}
	}
}
if (isset($edit_kabupaten_post)){
	$sql = "UPDATE kabupaten SET nama_kab='$kabupaten' WHERE id_kab=$id_kab";
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
						<h3>MASTER KABUPATEN</h3>
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
					</tr>
				</thead>
				<tbody>
<?php
$sql=mysqli_query($con, "SELECT
    provinsi.nama_prov
	, kabupaten.id_kab
    , kabupaten.nama_kab
    , negara.nama_negara
FROM
    kabupaten
    INNER JOIN provinsi 
        ON (kabupaten.id_prov = provinsi.id_prov)
    INNER JOIN negara 
        ON (negara.id_negara = provinsi.id_negara)
ORDER BY kabupaten.id_kab DESC");
$i=0;
while($row=mysqli_fetch_array($sql)){
	$i+=1;
	echo '			<tr>
						<td><a data-toggle="modal" data-target="#myModal2" data-id="' .$row['id_kab']. '">' .$i. '</a></td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id="' .$row['id_kab']. '">' .$row['nama_negara']. '</a></td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id="' .$row['id_kab']. '">' .$row['nama_prov']. '</a></td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id="' .$row['id_kab']. '">' .$row['nama_kab']. '</a></td>
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
				<h4 class="modal-title">Tambah Data Kabupaten
			</div>
			<div class="modal-body">				
				<form action="" method="post">
					<input type="hidden" name="tambah_kabupaten_post" value="true">
					<div class="form-group col-sm-12">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-flag fa-fw"></i><br><small>Negara</small></span>
							<input id="add_negara" class="form-control" style="padding: 20px 15px;" placeHolder="Nama Negara" value="" maxlength="40" readonly>
							<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
						</div>
						<div class="input-group">
							<span class="input-group-addon" style="padding: 2px 12px;"><i class="fa fa-flag fa-fw" style="width: 38px;"></i><br><small>Prov.</small></span>
							<select class="form-control select" id="id_prov" name="id_prov" required>
								<option value="" disabled selected>Pilih Provinsi</option>
							<?php
								$sql=mysqli_query($con, "SELECT
    provinsi.nama_prov
	, kabupaten.id_kab
	, kabupaten.id_prov
    , kabupaten.nama_kab
    , negara.nama_negara
FROM
    kabupaten
    INNER JOIN provinsi 
        ON (kabupaten.id_prov = provinsi.id_prov)
    INNER JOIN negara 
        ON (negara.id_negara = provinsi.id_negara) GROUP BY nama_prov");
								while ($row=mysqli_fetch_array($sql)){
									echo '<option negara="' .$row['nama_negara']. '" value="' .$row['id_prov']. '">' .$row['nama_prov']. '</option>';
								}
							?>
							</select>
							<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
						</div>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-tag fa-fw" style="width: 38px;"></i><br><small>Nama</small></span>
							<input id="tags_me" name="kabupaten" class="form-control" value="" required />
							<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
						</div>
					</div>
					<p>Tekan "TAB" atau "koma" untuk menambah kabupaten.</p>					
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
				<h4 class="modal-title">Ubah Data Kabupaten</h4>
			</div>
			<div class="modal-body">				
				<form action="" method="post">
					<input type="hidden" name="edit_kabupaten_post" value="true">
					<div id="get_kabupaten" class="col-md-12">
						
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
		$('#get_kabupaten').load('api/web/get-kabupaten.php?id=' + id,function(){
			
		});
	})
	$('#id_prov').on('change', function(e){
		var element = $(this).find('option:selected');
		var negara = element.attr("negara");
		$('#add_negara').val(negara);
	})
	$('#tags_me').tagsInput({
		maxChars: 40,
		minWidth: '400px',
		defaultText: 'Kabupaten',
		width: 'auto'	  
	});
});
</script>