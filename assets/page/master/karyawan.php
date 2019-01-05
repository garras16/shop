<?php
if (isset($tambah_karyawan_post)){
	$sql = "INSERT INTO karyawan VALUES(null,'$nama_karyawan','$barcode','$ktp','$no_hp',$jabatan,$gaji,$harian,$lembur,$status)";
	$q = mysql_query($sql);
	if ($q){
		_buat_pesan("Input Berhasil","green");
	} else {
		_buat_pesan("Input Gagal","red");
	}
}
if (isset($edit_karyawan_post)){
	$sql = "UPDATE karyawan SET nama_karyawan='$nama_karyawan',barcode='$barcode',ktp='$ktp',no_hp='$no_hp',id_jabatan=$jabatan,gaji=$gaji,harian=$harian,lembur=$lembur,status=$status WHERE id_karyawan='$id_karyawan'";
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
						<h3>MASTER KARYAWAN</h3>
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
			<div class="clearfix"></div>
			<div class="table responsive">
			<table id="table1" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>No.</th>
						<th>Nama Karyawan</th>
						<th>Barcode</th>
						<th>No KTP</th>
						<th>No HP</th>
						<th>Jabatan</th>
						<th>Gaji (Rp)</th>
						<th>Harian (Rp)</th>
						<th>Lembur (Rp)</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody>
<?php
$sql=mysql_query("SELECT * 
FROM
    karyawan
    INNER JOIN jabatan 
        ON (karyawan.id_jabatan = jabatan.id_jabatan)
ORDER BY karyawan.id_karyawan DESC");
$i=0;
while($row=mysql_fetch_array($sql)){
$i+=1;
$status = ($row['status'] == 1 ? 'Aktif' : 'Non Aktif');
	echo '			<tr>
						<td><a data-toggle="modal" data-target="#myModal2" data-id="' .$row['id_karyawan']. '">' .$i. '</a></td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id="' .$row['id_karyawan']. '">' .$row['nama_karyawan']. '</a></td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id="' .$row['id_karyawan']. '">' .$row['barcode']. '</a></td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id="' .$row['id_karyawan']. '">' .$row['ktp']. '</a></td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id="' .$row['id_karyawan']. '">' .$row['no_hp']. '</a></td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id="' .$row['id_karyawan']. '">' .$row['nama_jabatan']. '</a></td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id="' .$row['id_karyawan']. '">' .format_uang($row['gaji']). '</a></td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id="' .$row['id_karyawan']. '">' .format_uang($row['harian']). '</a></td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id="' .$row['id_karyawan']. '">' .format_uang($row['lembur']). '</a></td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id="' .$row['id_karyawan']. '">' .$status. '</a></td>
					</tr>';
}
?>
					
				</tbody>
			</table>
			</div>
		</div>
		<!-- /page content -->

        
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

	<!-- modal input -->
<div id="myModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Tambah Data Karyawan</h4>
			</div>
			<div class="modal-body">				
				<form action="" method="post">
					<input type="hidden" name="tambah_karyawan_post" value="true">
					<div class="col-md-12">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
						<input class="form-control" id="nama" type="text" name="nama_karyawan" placeholder="Nama Karyawan" title="Nama Karyawan" maxlength="50" required>
						<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-barcode fa-fw"></i></span>
						<input name="barcode" class="form-control" type="text" placeholder="Barcode" title="Barcode" maxlength="10" required>
						<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-credit-card fa-fw"></i></span>
						<input class="form-control" type="number" name="ktp" placeholder="No. KTP" title="No. KTP" onKeyPress="if(this.value.length==16) return false;" required>
						<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-phone fa-fw"></i></span>
						<input class="form-control" type="number" name="no_hp" placeholder="No. HP" title="No. HP" onKeyPress="if(this.value.length==15) return false;" required>
						<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-briefcase fa-fw"></i></span>
						<select class="select2 form-control" id="select_jabatan" name="jabatan" required>
							<option value="" disabled selected>Pilih Jabatan</option>
							<?php 
								$brg=mysql_query("select * from jabatan");
								while($b=mysql_fetch_array($brg)){
							?>	
							<option value="<?php echo $b['id_jabatan']; ?>"><?php echo $b['nama_jabatan'];?></option>
							<?php 
								}
							?>
						</select>
						<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-money fa-fw"></i></span>
						<input class="form-control" type="text" id="gaji" name="gaji" title="Gaji" placeholder="Gaji (Rp)" required>
						<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-money fa-fw"></i></span>
						<input class="form-control" type="text" id="harian" name="harian" title="Harian" placeholder="Harian (Rp)" required>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-money fa-fw"></i></span>
						<input class="form-control" type="text" id="lembur" name="lembur" title="Lembur" placeholder="Lembur (Rp)" required>
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
				<h4 class="modal-title">Ubah Data Karyawan</h4>
			</div>
			<div class="modal-body">				
				<form action="" method="post">
					<input type="hidden" name="edit_karyawan_post" value="true">
					<div id="get_karyawan" class="col-md-12">
						
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
	$('#gaji').inputmask('decimal', {autoGroup: true, groupSeparator: '.', rightAlign: false, autoUnmask: true, removeMaskOnSubmit: true});
	$('#harian').inputmask('decimal', {autoGroup: true, groupSeparator: '.', rightAlign: false, autoUnmask: true, removeMaskOnSubmit: true});
	$('#lembur').inputmask('decimal', {autoGroup: true, groupSeparator: '.', rightAlign: false, autoUnmask: true, removeMaskOnSubmit: true});
	$('#myModal2').on('show.bs.modal', function(e){
		var id = $(e.relatedTarget).data('id');
		$('#get_karyawan').load('assets/page/master/get-karyawan.php?id=' + id,function(){
			$('#gaji_2').inputmask('decimal', {autoGroup: true, groupSeparator: '.', rightAlign: false, autoUnmask: true, removeMaskOnSubmit: true});
			$('#harian_2').inputmask('decimal', {autoGroup: true, groupSeparator: '.', rightAlign: false, autoUnmask: true, removeMaskOnSubmit: true});
			$('#lembur_2').inputmask('decimal', {autoGroup: true, groupSeparator: '.', rightAlign: false, autoUnmask: true, removeMaskOnSubmit: true});
		});
	})
});
</script>