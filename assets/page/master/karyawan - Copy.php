<?php
if (isset($tambah_karyawan_post)){
	$sql = "INSERT INTO karyawan VALUES(null,'$nama_karyawan','$barcode','$ktp','$no_hp',$jabatan,$gaji)";
	$q = mysql_query($sql);
	if ($q){
		$pesan="Input Berhasil";
		$tipe="success";
	} else {
		$pesan="Input Gagal";
		$tipe="danger";
	}
}
?>
<!-- page content -->
		<div class="right_col" role="main">
			<div class="">
			<div class="row">
			<h3>MASTER KARYAWAN</h3>
			<?php
			if (isset($pesan)){
				echo '<div class="alert alert-' .$tipe. ' text-center">
					<h4>' .$pesan. '</h4>
					</div>';
			}
			?>
			<p align="right"><button class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Tambah</button></p>
			<div style="overflow-x: scroll">
			<table id="table1" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>No.</th>
						<th>Nama Karyawan</th>
						<th>Barcode</th>
						<th>No KTP</th>
						<th>No HP</th>
						<th>Jabatan</th>
						<th>Gaji</th>
					</tr>
				</thead>
				<tbody>
<?php
$sql=mysql_query("SELECT * 
FROM
    karyawan
    INNER JOIN jabatan 
        ON (karyawan.id_jabatan = jabatan.id_jabatan)");
$i=0;
while($row=mysql_fetch_array($sql)){
$i+=1;
	echo '			<tr>
						<td><a href="?page=edit_karyawan&id=' .$row['id_karyawan']. '">' .$i. '</a></td>
						<td><a href="?page=edit_karyawan&id=' .$row['id_karyawan']. '">' .$row['nama_karyawan']. '</a></td>
						<td><a href="?page=edit_karyawan&id=' .$row['id_karyawan']. '">' .$row['barcode']. '</a></td>
						<td><a href="?page=edit_karyawan&id=' .$row['id_karyawan']. '">' .$row['ktp']. '</a></td>
						<td><a href="?page=edit_karyawan&id=' .$row['id_karyawan']. '">' .$row['no_hp']. '</a></td>
						<td><a href="?page=edit_karyawan&id=' .$row['id_karyawan']. '">' .$row['nama_jabatan']. '</a></td>
						<td><a href="?page=edit_karyawan&id=' .$row['id_karyawan']. '">' .format_uang($row['gaji']). '</a></td>
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
				<h4 class="modal-title">Tambah Karyawan</h4>
			</div>
			<div class="modal-body">				
				<form action="" method="post">
					<input type="hidden" name="tambah_karyawan_post" value="true">
					<div class="col-md-12">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
						<input class="form-control" id="nama" name="nama_karyawan" placeholder="Nama Karyawan" maxlength="50" required>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-barcode fa-fw"></i></span>
						<input name="barcode" class="form-control" placeholder="Barcode" maxlength="10" required>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-credit-card fa-fw"></i></span>
						<input class="form-control" type="number" name="ktp" placeholder="No. KTP" onKeyPress="if(this.value.length==16) return false;" required>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-phone fa-fw"></i></span>
						<input class="form-control" type="number" name="no_hp" placeholder="No. HP" onKeyPress="if(this.value.length==15) return false;" required>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-briefcase fa-fw"></i></span>
						<select class="form-control" id="select_jabatan" name="jabatan" required>
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
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-money fa-fw"></i></span>
						<input class="form-control" id="gaji" name="gaji" placeholder="Gaji" required>
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
$(document).ready(function(){
	$('#gaji').inputmask('currency', {prefix: '', rightAlign: false, autoUnmask: true, removeMaskOnSubmit: true});
});
</script>