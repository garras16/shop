<?php
if (isset($tambah_user_post)){
	$sql = "INSERT INTO users VALUES(null,$id_karyawan,'$posisi','$nama_user','$user_pass',$status)";
	$q = mysql_query($sql);
	if ($q){
		_buat_pesan("Input Berhasil","green");
	} else {
		_buat_pesan("Input Gagal","red");
	}
}

if (isset($edit_user_post)){
	$sql = "UPDATE users SET posisi='$posisi',password='$user_pass',status=$status WHERE id_user='$id_user'";
	$q = mysql_query($sql);
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
						<h3>MASTER USER</h3>
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
						<th>Nama Karyawan</th>
						<th>Posisi</th>
						<th>Username</th>
						<th>Password</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody>
<?php
$sql=mysql_query("SELECT 
    karyawan.nama_karyawan
	, users.posisi
	, users.id_user
    , users.user
    , users.password
    , users.status
FROM
    users
    INNER JOIN karyawan 
        ON (users.id_karyawan = karyawan.id_karyawan)
    WHERE karyawan.status=1 AND posisi <> 'OWNER'
	ORDER BY id_user DESC");
$i=0;
while($row=mysql_fetch_array($sql)){
	$i+=1;
	$status=($row['status']==1 ? 'Aktif' : 'Non Aktif');
	echo '		<tr>
					<td><a href="#myModal2" data-toggle="modal" data-nama="' .$row['nama_karyawan']. '" data-user="' .$row['user']. '" data-posisi="' .$row['posisi']. '" data-id="' .$row['id_user']. '" data-pass="' .$row['password']. '" data-status="' .$row['status']. '">' .$i. '</a></td>
					<td><a href="#myModal2" data-toggle="modal" data-nama="' .$row['nama_karyawan']. '" data-user="' .$row['user']. '" data-posisi="' .$row['posisi']. '" data-id="' .$row['id_user']. '" data-pass="' .$row['password']. '" data-status="' .$row['status']. '">' .$row['nama_karyawan']. '</a></td>
					<td><a href="#myModal2" data-toggle="modal" data-nama="' .$row['nama_karyawan']. '" data-user="' .$row['user']. '" data-posisi="' .$row['posisi']. '" data-id="' .$row['id_user']. '" data-pass="' .$row['password']. '" data-status="' .$row['status']. '">' .$row['posisi']. '</a></td>
					<td><a href="#myModal2" data-toggle="modal" data-nama="' .$row['nama_karyawan']. '" data-user="' .$row['user']. '" data-posisi="' .$row['posisi']. '" data-id="' .$row['id_user']. '" data-pass="' .$row['password']. '" data-status="' .$row['status']. '">' .$row['user']. '</a></td>
					<td><a href="#myModal2" data-toggle="modal" data-nama="' .$row['nama_karyawan']. '" data-user="' .$row['user']. '" data-posisi="' .$row['posisi']. '" data-id="' .$row['id_user']. '" data-pass="' .$row['password']. '" data-status="' .$row['status']. '">' .$row['password']. '</a></td>
					<td><a href="#myModal2" data-toggle="modal" data-nama="' .$row['nama_karyawan']. '" data-user="' .$row['user']. '" data-posisi="' .$row['posisi']. '" data-id="' .$row['id_user']. '" data-pass="' .$row['password']. '" data-status="' .$row['status']. '">' .$status. '</a></td>
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
				<h4 class="modal-title">Tambah Data User</h4>
			</div>
			<div class="modal-body">				
				<form action="" method="post">
					<input type="hidden" name="tambah_user_post" value="true">
					<div class="col-md-12">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-users fa-fw"></i></span>
							<select class="select2 form-control" id="select_karyawan" name="id_karyawan" required>
								<option value="" disabled selected>Pilih Karyawan</option>
								<?php 
									$brg=mysql_query("SELECT id_karyawan,nama_karyawan FROM karyawan WHERE id_karyawan NOT IN(SELECT id_karyawan FROM users) AND STATUS=1");
									while($b=mysql_fetch_array($brg)){
								?>	
								<option value="<?php echo $b['id_karyawan']; ?>"><?php echo $b['nama_karyawan'];?></option>
								<?php 
									}
								?>
							</select>
							<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
						</div>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-briefcase fa-fw"></i></span>
							<select class="select2 form-control" id="select_posisi" name="posisi" required>
								<option value="" disabled selected>Pilih Posisi</option>
								<option value="DIREKSI">DIREKSI</option>
								<option value="DRIVER">DRIVER</option>
								<option value="SALES">SALES</option>
								<option value="GUDANG">GUDANG</option>
								<option value="CHECKER">CHECKER</option>
								<option value="ADMINISTRASI">ADMINISTRASI</option>
								<option value="COLLECTOR">COLLECTOR</option>
							</select>
							<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
						</div>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
							<input class="form-control" type="text" id="nama_user" name="nama_user" placeholder="Username" maxlength="30" required>
							<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
						</div>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-lock fa-fw"></i></span>
							<input class="form-control" type="text" id="user_pass" name="user_pass" placeholder="Password" maxlength="30" required>
							<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
						</div>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-flag fa-fw"></i></span>
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
				<h4 class="modal-title">Ubah Password</h4>
			</div>
			<div class="modal-body">				
				<form action="" method="post">
					<input type="hidden" name="edit_user_post" value="true">
					<input type="hidden" name="id_user" value="">
					<div class="col-md-12">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-users fa-fw"></i></span>
							<input class="form-control" id="nama_karyawan" name="nama_karyawan" placeholder="Nama Karyawan" maxlength="50" readonly>
							<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
						</div>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
							<input class="form-control" id="nama_user" name="nama_user" placeholder="Username" maxlength="30" readonly>
							<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
						</div>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-briefcase fa-fw"></i></span>
							<select class="form-control" id="select_posisi" name="posisi" required>
								<option value="" disabled selected>Pilih Posisi</option>
								<option value="DIREKSI" <?php echo ($row['']=='DIREKSI' ? ' selected' : '') ?> >DIREKSI</option>
								<option value="DRIVER" <?php echo ($row['']=='DIREKSI' ? ' selected' : '') ?> >DRIVER</option>
								<option value="SALES" <?php echo ($row['']=='DIREKSI' ? ' selected' : '') ?> >SALES</option>
								<option value="GUDANG" <?php echo ($row['']=='DIREKSI' ? ' selected' : '') ?> >GUDANG</option>
								<option value="CHECKER" <?php echo ($row['']=='DIREKSI' ? ' selected' : '') ?> >CHECKER</option>
								<option value="ADMINISTRASI" <?php echo ($row['']=='DIREKSI' ? ' selected' : '') ?> >ADMINISTRASI</option>
								<option value="COLLECTOR" <?php echo ($row['']=='DIREKSI' ? ' selected' : '') ?> >COLLECTOR</option>
							</select>
							<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
						</div>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-lock fa-fw"></i></span>
							<input class="form-control" id="user_pass" name="user_pass" placeholder="Password" maxlength="30" required>
							<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
						</div>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-flag fa-fw"></i></span>
							<select class="form-control" id="select_status" name="status" required>
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

<script>
$('#myModal2').on('show.bs.modal', function(e){
	var id = $(e.relatedTarget).data('id');
	var nama = $(e.relatedTarget).data('nama');
	var user = $(e.relatedTarget).data('user');
	var posisi = $(e.relatedTarget).data('posisi');
	var pass = $(e.relatedTarget).data('pass');
	var status = $(e.relatedTarget).data('status');
	$(e.currentTarget).find('input[name="id_user"]').val(id);
	$(e.currentTarget).find('select[name="posisi"]').val(posisi);
	$(e.currentTarget).find('input[name="nama_user"]').val(user);
	$(e.currentTarget).find('input[name="nama_karyawan"]').val(nama);
	$(e.currentTarget).find('input[name="user_pass"]').val(pass);
	$(e.currentTarget).find('select[name="status"]').val(status);
})
</script>