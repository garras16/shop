<?php
if (isset($tambah_ekspedisi_post)){
	$sql = "INSERT INTO ekspedisi VALUES(null,'$nama_ekspedisi','$telepon','$kontakperson','$telepon_kontak',$status)";
	$q = mysql_query($sql);
	if ($q){
		_buat_pesan("Input Berhasil","green");
	} else {
		_buat_pesan("Input Gagal","red");
	}
}
if (isset($edit_ekspedisi_post)){
	$sql = "UPDATE ekspedisi SET nama_ekspedisi='$nama_ekspedisi',telepon='$telepon',kontakperson='$kontakperson',telepon_kontak='$telepon_kontak',status=$status WHERE id_ekspedisi='$id_ekspedisi'";
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
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<h3>MASTER EKSPEDISI</h3>
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
						<th>Nama Ekspedisi</th>
						<th>Telepon Ekspedisi</th>
						<th>Kontak Person</th>
						<th>Telepon Kontak Person</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody>
<?php
$sql=mysql_query("SELECT * FROM ekspedisi ORDER BY id_ekspedisi DESC");
$i=0;
while($row=mysql_fetch_array($sql)){
$i+=1;
$status = ($row['status'] == 1 ? 'Aktif' : 'Non Aktif');
	echo '			<tr>
						<td><a data-toggle="modal" data-target="#myModal2" data-id="' .$row['id_ekspedisi']. '">' .$i. '</a></td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id="' .$row['id_ekspedisi']. '">' .$row['nama_ekspedisi']. '</a></td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id="' .$row['id_ekspedisi']. '">' .$row['telepon']. '</a></td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id="' .$row['id_ekspedisi']. '">' .$row['kontakperson']. '</a></td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id="' .$row['id_ekspedisi']. '">' .$row['telepon_kontak']. '</a></td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id="' .$row['id_ekspedisi']. '">' .$status. '</a></td>
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
				<h4 class="modal-title">Tambah Data Ekspedisi</h4>
			</div>
			<div class="modal-body">				
				<form action="" method="post">
					<input type="hidden" name="tambah_ekspedisi_post" value="true">
					<div class="col-md-12">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-truck fa-fw"></i></span>
						<input class="form-control" type="text" id="nama" name="nama_ekspedisi" placeholder="Nama Ekspedisi" maxlength="50" required>
						<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-phone fa-fw"></i></span>
						<input name="telepon" type="number" class="form-control" placeholder="Telepon Ekspedisi" onKeyPress="if(this.value.length==20) return false;" required>
						<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
						<input class="form-control" type="text" name="kontakperson" placeholder="Kontak Person" maxlength="50">
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-phone fa-fw"></i></span>
						<input class="form-control" type="number" name="telepon_kontak" placeholder="Telepon Kontak Person" onKeyPress="if(this.value.length==20) return false;">
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
				<h4 class="modal-title">Ubah Data Ekspedisi</h4>
			</div>
			<div class="modal-body">				
				<form action="" method="post">
					<input type="hidden" name="edit_ekspedisi_post" value="true">
					<div id="get_ekspedisi" class="col-md-12">
						
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
		$('#get_ekspedisi').load('api/web/get-ekspedisi.php?id=' + id,function(){
			
		});
	})
});
</script>