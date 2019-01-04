<?php
if (isset($tambah_varian_post)){
	$sql = "INSERT INTO varian_kendaraan VALUES(null,'$nama_jenis','$nama_varian')";
	$q = mysqli_query($con, $sql);
	if ($q){
		_buat_pesan("Input Berhasil","green");
	} else {
		_buat_pesan("Input Gagal","red");
	}
}
if (isset($edit_varian_post)){
	$sql = "UPDATE varian_kendaraan SET nama_jenis='$nama_jenis',nama_varian='$nama_varian' WHERE id_varian='$id_varian'";
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
						<h3>MASTER VARIAN KENDARAAN</h3>
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
						<th>Jenis Kendaraan</th>
						<th>Varian</th>
					</tr>
				</thead>
				<tbody>
<?php
$sql=mysqli_query($con, "SELECT * FROM varian_kendaraan ORDER BY id_varian DESC");
$i=0;
while($row=mysqli_fetch_array($sql)){
$i+=1;
	echo '			<tr>
						<td><a data-toggle="modal" data-target="#myModal2" data-id="' .$row['id_varian']. '" data-jenis="' .$row['nama_jenis']. '" data-varian="' .$row['nama_varian']. '">' .$i. '</a></td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id="' .$row['id_varian']. '" data-jenis="' .$row['nama_jenis']. '" data-varian="' .$row['nama_varian']. '">' .$row['nama_jenis']. '</a></td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id="' .$row['id_varian']. '" data-jenis="' .$row['nama_jenis']. '" data-varian="' .$row['nama_varian']. '">' .$row['nama_varian']. '</a></td>
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
				<h4 class="modal-title">Tambah Data Varian Kendaraan</h4>
			</div>
			<div class="modal-body">				
				<form action="" method="post">
					<input type="hidden" name="tambah_varian_post" value="true">
					<div class="col-md-12">
					<div class="input-group">
						<span class="input-group-addon" style="padding: 2px 12px;"><i class="fa fa-truck fa-fw" style="width: 32px;"></i><br><small>Jenis</small></span>
						<select class="form-control select" id="select_jenis" name="nama_jenis" required>
							<option value="" disabled selected>Pilih Jenis</option>
							<option value="MOBIL">MOBIL</option>
							<option value="MOTOR">MOTOR</option>
						</select>
						<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-car fa-fw"></i><br><small>Nama</small></span>
						<input class="form-control" type="text" name="nama_varian" style="padding: 20px 15px;" placeholder="Nama Varian" maxlength="20" required>
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
				<h4 class="modal-title">Ubah Data Kendaraan</h4>
			</div>
			<div class="modal-body">				
				<form action="" method="post">
					<input type="hidden" name="edit_varian_post" value="true">
					<input id="id_varian" type="hidden" name="id_varian" value="">
					<div class="input-group">
						<span class="input-group-addon" style="padding: 2px 12px;"><i class="fa fa-truck fa-fw" style="width: 32px;"></i><br><small>Jenis</small></span>
						<select class="form-control" id="select_jenis_2" name="nama_jenis" required>
							<option value="" disabled selected>Pilih Jenis</option>
							<option value="MOBIL">MOBIL</option>
							<option value="MOTOR">MOTOR</option>
						</select>
						<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-car fa-fw"></i><br><small>Nama</small></span>
						<input id="nama_varian" class="form-control" style="padding: 20px 15px;" name="nama_varian" placeholder="Nama Varian" maxlength="20" required>
						<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
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
		var jenis = $(e.relatedTarget).data('jenis');
		var varian = $(e.relatedTarget).data('varian');
		$('#select_jenis_2').val(jenis);
		$('#nama_varian').val(varian);
		$('#id_varian').val(id);
	})
});
</script>