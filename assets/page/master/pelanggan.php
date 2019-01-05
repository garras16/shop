<?php
if (isset($tambah_pelanggan_post)){
	$sql = "INSERT INTO pelanggan VALUES(null,'$nama_pelanggan','$alamat','$lat','$lng','$telepon_pelanggan','$kontak','$telepon_kontak',$plafon,$barcode,$status,$blacklist)";
	$q = mysql_query($sql);
	if ($q){
		_buat_pesan("Input Berhasil","green");
	} else {
		_buat_pesan("Input Gagal","red");
	}
}
if (isset($edit_pelanggan_post)){
	$sql=mysql_query("UPDATE pelanggan SET nama_pelanggan='$nama_pelanggan',alamat='$alamat',lat='$lat',lng='$lng',telepon_pelanggan='$telepon_pelanggan',kontakperson='$kontak',telepon_kontak='$telepon_kontak',plafon=$plafon,barcode='$barcode',status=$status,blacklist=$blacklist WHERE id_pelanggan=$id_pelanggan");
	_alert($plafon);
	if ($sql){
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
						<h3>MASTER PELANGGAN</h3>
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
						<th>Nama Pelanggan</th>
						<th>Alamat</th>
						<th>Latitude</th>
						<th>Longitude</th>
						<th>Telepon Pelanggan</th>
						<th>Kontak Person</th>
						<th>Telepon Kontak Person</th>
						<th>Plafon (Rp)</th>
						<th>Barcode Pelanggan</th>
						<th>Status</th>
						<th>Blacklist</th>
					</tr>
				</thead>
				<tbody>
<?php
$sql=mysql_query("SELECT * FROM pelanggan ORDER BY id_pelanggan DESC");
$i=0;
while($row=mysql_fetch_array($sql)){
$i+=1;
$status = ($row['status'] == 1 ? 'Aktif' : 'Non Aktif');
$blacklist = ($row['blacklist'] == 1 ? 'Ya' : 'Tidak');
	echo '			<tr>
						<td><a data-toggle="modal" data-target="#myModal2" data-id="' .$row['id_pelanggan']. '">' .$i. '</a></td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id="' .$row['id_pelanggan']. '">' .$row['nama_pelanggan']. '</a></td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id="' .$row['id_pelanggan']. '">' .$row['alamat']. '</a></td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id="' .$row['id_pelanggan']. '">' .$row['lat']. '</a></td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id="' .$row['id_pelanggan']. '">' .$row['lng']. '</a></td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id="' .$row['id_pelanggan']. '">' .$row['telepon_pelanggan']. '</a></td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id="' .$row['id_pelanggan']. '">' .$row['kontakperson']. '</a></td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id="' .$row['id_pelanggan']. '">' .$row['telepon_kontak']. '</a></td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id="' .$row['id_pelanggan']. '">' .format_angka($row['plafon']). '</a></td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id="' .$row['id_pelanggan']. '">' .$row['barcode']. '</a></td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id="' .$row['id_pelanggan']. '">' .$status. '</a></td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id="' .$row['id_pelanggan']. '">' .$blacklist. '</a></td>
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
				<h4 class="modal-title">Tambah Data Pelanggan</h4>
			</div>
			<div class="modal-body">				
				<form action="" method="post">
					<input type="hidden" name="tambah_pelanggan_post" value="true">
					<div class="col-md-12">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-building fa-fw"></i></span>
						<input class="form-control" type="text" id="nama" name="nama_pelanggan" placeholder="Nama Pelanggan" maxlength="50" required>
						<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-map-marker fa-fw"></i></span>
						<input name="alamat" type="text" class="form-control" placeholder="Alamat" maxlength="100" required>
						<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-map-marker fa-fw"></i></span>
						<input name="lat" type="text" class="form-control" placeholder="Latitude" maxlength="50" readonly>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-map-marker fa-fw"></i></span>
						<input name="lng" type="text" class="form-control" placeholder="Longitude" maxlength="50" readonly>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-phone fa-fw"></i></span>
						<input class="form-control" type="number" name="telepon_pelanggan" placeholder="Telepon Pelanggan" onKeyPress="if(this.value.length==20) return false;" required>
						<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
						<input name="kontak" type="text" class="form-control" placeholder="Kontak Person" maxlength="30" required>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-phone fa-fw"></i></span>
						<input class="form-control" type="number" name="telepon_kontak" placeholder="Telepon Kontak Person" onKeyPress="if(this.value.length==20) return false;" required>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-arrows-v fa-fw"></i></span>
						<input id="plafon" type="text" name="plafon" class="form-control" placeholder="Plafon (Rp)" required>
						<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-barcode fa-fw"></i></span>
						<input name="barcode" type="text" class="form-control" placeholder="Barcode" maxlength="20" required>
						<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-flag fa-fw"></i></span>
						<select class="form-control select" name="status" required>
							<option value="" disabled selected>Pilih Status</option>
							<option value="0">NON AKTIF</option>
							<option value="1">AKTIF</option>
						</select>
						<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-flag fa-fw"></i></span>
						<select class="form-control select" name="blacklist" required>
							<option value="" disabled selected>Blacklist ?</option>
							<option value="0">TIDAK</option>
							<option value="1">YA</option>
						</select>
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

<!-- modal input -->
<div id="myModal2" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Ubah Data Pelanggan</h4>
			</div>
			<div class="modal-body">				
				<form action="" method="post">
					<input type="hidden" name="edit_pelanggan_post" value="true">
					<div id="get_pelanggan" class="col-md-12">
						
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
	$('#plafon').inputmask('decimal', {allowMinus: false, autoGroup: true, groupSeparator: '.', rightAlign: false, autoUnmask: true, removeMaskOnSubmit: true});
	$('#myModal2').on('show.bs.modal', function(e){
		var id = $(e.relatedTarget).data('id');
		$('#get_pelanggan').load('api/web/get-pelanggan.php?id=' + id,function(){
			$('#plafon_2').inputmask('decimal', {allowMinus: false, autoGroup: true, groupSeparator: '.', rightAlign: false, autoUnmask: true, removeMaskOnSubmit: true});
		});
	})
});
</script>