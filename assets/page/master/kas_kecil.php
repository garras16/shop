<?php
if (isset($tambah_komponen_kas_post)){
	$sql = "INSERT INTO mst_kas_kecil VALUES(null,'$nama_kas_kecil','$jenis',$status)";
	$q = mysqli_query($con, $sql);
	if ($q){
		_buat_pesan("Input Berhasil","green");
	} else {
		_buat_pesan("Input Gagal","red");
	}
	_direct("?page=master&mode=kas_kecil");
}
if (isset($edit_komponen_kas_post)){
	$sql = "UPDATE mst_kas_kecil SET nama_kas_kecil='$nama_kas_kecil',jenis='$jenis',status='$status' WHERE id_kas_kecil='$id_kas_kecil'";
	$q = mysqli_query($con, $sql);
	if ($q){
		_buat_pesan("Input Berhasil","green");
	} else {
		_buat_pesan("Input Gagal","red");
	}
	_direct("?page=master&mode=kas_kecil");
}
?>
<!-- page content -->
<div class="right_col" role="main">
	<div class="">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<h3>MASTER KOMPONEN KAS KECIL</h3>
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
						<th>Nama Komponen</th>
						<th>Jenis</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody>
<?php
$sql=mysqli_query($con, "SELECT * FROM mst_kas_kecil ORDER BY id_kas_kecil DESC");
while($row=mysqli_fetch_array($sql)){
$status=($row['status']=='1' ? 'AKTIF' : 'NON AKTIF');
	echo '			<tr>
						<td><a data-toggle="modal" data-target="#myModal2" data-id="' .$row['id_kas_kecil']. '"><div style="min-width:70px">' .$row['nama_kas_kecil']. '</div></a></td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id="' .$row['id_kas_kecil']. '"><div style="min-width:70px">' .$row['jenis']. '</div></a></td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id="' .$row['id_kas_kecil']. '"><div style="min-width:70px">' .$status. '</div></a></td>
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
				<h4 class="modal-title">Tambah Data Komponen Kas Kecil</h4>
			</div>
			<div class="modal-body">				
				<form action="" method="post">
					<input type="hidden" name="tambah_komponen_kas_post" value="true">
					<div class="col-md-12">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-file fa-fw" style="width: 35px;"></i><br><small>Nama</small></span>
							<input class="form-control" type="text" style="padding: 20px 15px;" name="nama_kas_kecil" placeholder="Nama Kas Kecil" maxlength="100" required>
							<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
						</div>
						<div class="input-group">
							<span class="input-group-addon" style="padding: 2px 12px;"><i class="fa fa-archive fa-fw" style="width: 35px;"></i><br><small>Jenis</small></span>
							<select class="form-control select" id="select_jenis" name="jenis" required>
								<option value="" disabled selected>Pilih Jenis</option>
								<option value="MASUK">KAS MASUK</option>
								<option value="KELUAR">KAS KELUAR</option>
							</select>
							<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
						</div>
						<div class="input-group">
							<span class="input-group-addon" style="padding: 2px 12px;"><i class="fa fa-archive fa-fw" style="width: 35px;"></i><br><small>Status</small></span>
							<select class="form-control select" id="select_status" name="status" required>
								<option value="" disabled selected>Pilih Status</option>
								<option value="0">NON AKTIF</option>
								<option value="1">AKTIF</option>
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
				<h4 class="modal-title">Ubah Data Komponen Kas Kecil</h4>
			</div>
			<div class="modal-body">				
				<form action="" method="post">
					<input type="hidden" name="edit_komponen_kas_post" value="true">
					<div id="get_kas_kecil" class="col-md-12">
						
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
		$('#get_kas_kecil').load('api/web/get-kas-kecil-modal.php?id=' + id);
	})
});
</script>