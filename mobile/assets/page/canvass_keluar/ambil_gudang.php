<?php
	if (isset($tambah_ambil_gudang_mobil_post)){
		$sql = "INSERT INTO canvass_keluar VALUES(null,'$tanggal','$id_mobil',0)";
		$q = mysqli_query($con, $sql);
		$id_canvass=mysqli_insert_id($con);
		if ($q){
			_buat_pesan("Input Berhasil","green");
			_direct("?page=canvass_keluar&mode=input_ambil_gudang&id=" .$id_canvass);
		} else {
			_buat_pesan("Input Gagal","red");
			_direct("?page=canvass_keluar&mode=ambil_gudang");
		}
	} else {
		$sql = mysqli_query($con, "DELETE FROM canvass_keluar 
			WHERE id_canvass_keluar NOT IN (SELECT id_canvass_keluar FROM canvass_keluar_barang)
			OR id_canvass_keluar NOT IN (SELECT id_canvass_keluar FROM canvass_keluar_karyawan)");
		$sql = mysqli_query($con, "DELETE FROM canvass_keluar_karyawan 
			WHERE id_canvass_keluar NOT IN (SELECT id_canvass_keluar FROM canvass_keluar)");
		$sql = mysqli_query($con, "DELETE FROM canvass_keluar_barang 
			WHERE id_canvass_keluar NOT IN (SELECT id_canvass_keluar FROM canvass_keluar)");
	}

?>
<!-- page content -->
<div class="right_col" role="main">
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
					<div class="x_title">
						<h3>MUTASI DARI GUDANG KE MOBIL</h3>
							<?php
							if (isset($pesan)){
								echo '<span class="badge bg-' .$warna. '">' .$pesan. '</span>';
							}
							?>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
			<p align="right"><a data-toggle="modal" data-target="#myModal" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Data</a></p>
			<div class="clearfix"></div>
			<div class="table responsive">
			<table id="table1" class="table table-bordered table-striped" style="table-layout:fixed">
				<thead>
					<tr>
						<th>Tanggal Canvass</th>
						<th>Nama Mobil</th>
						<th>No Pol</th>
					</tr>
				</thead>
				<tbody>
<?php
$sql=mysqli_query($con, "SELECT * FROM canvass_keluar INNER JOIN kendaraan ON (canvass_keluar.id_mobil = kendaraan.id_kendaraan) WHERE canvass_keluar.status=0 OR canvass_keluar.status=9 ORDER BY id_canvass_keluar DESC");
while($row=mysqli_fetch_array($sql)){
	echo '			<tr>
						<td><a href="?page=canvass_keluar&mode=input_ambil_gudang&id=' .$row['id_canvass_keluar']. '"><div style="min-width:70px">' .date("d-m-Y",strtotime($row['tanggal_canvass'])). '</div></a></td>
						<td><a href="?page=canvass_keluar&mode=input_ambil_gudang&id=' .$row['id_canvass_keluar']. '"><div style="min-width:70px">' .$row['nama_kendaraan']. '</div></a></td>
						<td><a href="?page=canvass_keluar&mode=input_ambil_gudang&id=' .$row['id_canvass_keluar']. '"><div style="min-width:70px">' .$row['plat']. '</div></a></td>
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
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&times;</button>
				<h4 class="modal-title">Pilih Mobil Canvass</h4>
			</div>
			<div class="modal-body">
				<form method="post" action="">
				<input type="hidden" name="tambah_ambil_gudang_mobil_post" value="true">
				<div class="input-group">
					<span class="input-group-addon" style="padding: 2px 12px;"><i class="fa fa-truck fa-fw"></i><br><small>Mobil</small></span>
					<select class="form-control" id="select_mobil" name="id_mobil" required>
						<option value="" disabled selected>Pilih Mobil Canvass</option>
						<?php 
							$sql=mysqli_query($con, "SELECT * FROM kendaraan WHERE STATUS=1 AND canvass=1 AND id_kendaraan NOT IN (SELECT id_mobil FROM canvass_keluar WHERE STATUS <> 4)");
							while($row=mysqli_fetch_array($sql)){
						?>	
							<option value="<?php echo $row['id_kendaraan']; ?>"><?php echo $row['nama_kendaraan']. ' | ' .$row['plat'];?></option>
						<?php 
							}
						?>
					</select>
					<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
				</div>
			</div>
			<div class="clearfix"></div><br/>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary">Tambah</a>
			</div>
			</form>
		</div>
	</div>
</div>

<script>
$(document).ready(function(){
	
});
</script>