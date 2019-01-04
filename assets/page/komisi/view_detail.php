<?php
$sql = "SELECT MAX(target_akhir) AS MaxVal FROM komisi WHERE id_karyawan=$id";
$q = mysqli_fetch_array(mysqli_query($con, $sql));
$MaxVal = $q['MaxVal'];

if (isset($tambah_jenjang_post)){
	if ($target_awal > $MaxVal && $target_akhir > $target_awal){
		$sql = "INSERT INTO komisi VALUES(null,$id,$target_awal,$target_akhir,$tunai)";
		$q = mysqli_query($con, $sql);
		if ($sql){
			_buat_pesan("Input Berhasil","green");
		} else {
			_buat_pesan("Input Gagal","red");
		}
	} else {
		_buat_pesan("Input Gagal","red");
	}
	
}
if (isset($edit_jenjang_post)){
	//if (($target_awal >= $MaxVal) && ($target_akhir > $target_awal)){
		$sql = "UPDATE komisi SET target_awal=$target_awal,target_akhir=$target_akhir,tunai=$tunai WHERE id_komisi=$id_komisi";
		$q = mysqli_query($con, $sql);
		if ($q){
			$pesan="Input Berhasil";
			$warna="green";
		} else {
			$pesan="Input Gagal";
			$warna="red";
		}
	//} else {
	//	$pesan="Input Gagal";
	//	$warna="red";
	//}
}

$sql=mysqli_query($con, "SELECT
	karyawan.nama_karyawan
FROM
    komisi
    INNER JOIN karyawan 
        ON (komisi.id_karyawan = karyawan.id_karyawan)
WHERE komisi.id_karyawan=$id");
$row=mysqli_fetch_array($sql);
?>
<!-- page content -->
<div class="right_col" role="main">
	<div class="">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
					<div class="x_title">
						<h3>MASTER KOMISI SALES</h3>
						<h4>Detail Komisi - <?php echo $row['nama_karyawan'] ?></h4>
							<?php
							if (isset($pesan)){
								echo '<span class="badge bg-' .$warna. '">' .$pesan. '</span><br/><br/>';
							}
							?>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
			<p align="left"><a href="?page=master&mode=komisi class="btn btn-danger"><i class="fa fa-arrow-left"></i> Kembali</a></p>
			
			<p align="right"><button class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Tambah Jenjang</button></p>
			<table id="table1" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th></th>
						<th>PENJUALAN TOTAL (RP)</th>
						<th>KOMISI PENJUALAN TUNAI (%)</th>
					</tr>
				</thead>
				<tbody>
<?php
$sql=mysqli_query($con, "SELECT * FROM komisi WHERE komisi.id_karyawan=$id");
while ($row=mysqli_fetch_array($sql)){
echo '	<tr>
			<td>
				<div class="btn-group">
					<button data-toggle="dropdown" class="btn btn-primary dropdown-toggle btn-xs" type="button" aria-expanded="false"><span class="caret"></span></button>
					<ul role="menu" class="dropdown-menu">
					  <li><a data-toggle="modal" data-target="#myModal2" data-id="' .$row['id_komisi']. '" data-awal="' .$row['target_awal']. '" data-akhir="' .$row['target_akhir']. '" data-tunai="' .$row['tunai']. '">Ubah Komisi</a></li>
					  <li class="separator"></li>
					  <li><a href="?page=komisi&mode=view_kredit&id=' .$row['id_komisi']. '">Lihat Komisi Penjualan Kredit</a></li>
					</ul>
				</div>
			</td>
			<td>' .format_angka($row['target_awal']).' - '.format_angka($row['target_akhir']). '</a></td>
			<td>' .format_uang($row['tunai']). '</a></td>
		</tr>';
}
?>			
					
				</tbody>
			</table>
			
			<div id="dummy"></div>
			
			
			</div>
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
				<h4 class="modal-title">Tambah Jenjang Komisi Tunai</h4>
			</div>
			<div class="modal-body">				
				<form action="" method="post">
					<input type="hidden" name="tambah_jenjang_post" value="true">
					<div class="col-md-12">
					<div class="input-group">
						<span class="input-group-addon">Rp</span>
						<input id="target_awal" name="target_awal" class="form-control" type="text" placeholder="Target Penjualan Minimum (Rp)" required>
						<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
					</div>
					<div class="input-group">
						<span class="input-group-addon">Rp</span>
						<input id="target_akhir" type="text" name="target_akhir" class="form-control" placeholder="Target Penjualan Maksimum (Rp)" required>
						<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
					</div>
					<div class="input-group">
						<span class="input-group-addon">%&nbsp;</span>
						<input id="tunai" name="tunai" type="text" class="form-control" placeholder="Komisi Penjualan Tunai (%)" maxlength="5" required>
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
				<h4 class="modal-title">Ubah Data Jenjang Komisi Tunai</h4>
			</div>
			<div class="modal-body">				
				<form action="" method="post">
					<input type="hidden" name="edit_jenjang_post" value="true">
					<input type="hidden" id="id_komisi" name="id_komisi" value="">
					<div class="col-md-12">
					<div class="input-group">
						<span class="input-group-addon">Rp</span>
						<input id="target_awal_2" name="target_awal" class="form-control" type="text" placeholder="Target Penjualan Minimum (Rp)" required>
						<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
					</div>
					<div class="input-group">
						<span class="input-group-addon">Rp</span>
						<input id="target_akhir_2" name="target_akhir" class="form-control" placeholder="Target Penjualan Maksimum (Rp)" required>
						<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
					</div>
					<div class="input-group">
						<span class="input-group-addon">%&nbsp;</span>
						<input id="tunai_2" name="tunai" class="form-control" placeholder="Komisi Penjualan Tunai (%)" maxlength="5" required>
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
function deleteRow(r,ID){
	$('#dummy').load('assets/page/komisi/delete.php?id=' + ID);
    var i = r.parentNode.parentNode.rowIndex;
    document.getElementById("table1").deleteRow(i);
}
$(document).ready(function(){
	$('#target_awal').inputmask('numeric', {allowMinus: false, autoGroup: true, groupSeparator: '.', rightAlign: false, removeMaskOnSubmit: true});
	$('#target_akhir').inputmask('numeric', {allowMinus: false, autoGroup: true, groupSeparator: '.', rightAlign: false, autoUnmask: true, removeMaskOnSubmit: true});
	$('#tunai').inputmask('decimal', {allowMinus: false, autoGroup: true, groupSeparator: '.', rightAlign: false, autoUnmask: true, removeMaskOnSubmit: true, max: 100});
	$('#target_awal_2').inputmask('numeric', {allowMinus: false, autoGroup: true, groupSeparator: '.', rightAlign: false, removeMaskOnSubmit: true});
	$('#target_akhir_2').inputmask('numeric', {allowMinus: false, autoGroup: true, groupSeparator: '.', rightAlign: false, autoUnmask: true, removeMaskOnSubmit: true});
	$('#tunai_2').inputmask('decimal', {allowMinus: false, autoGroup: true, groupSeparator: '.', rightAlign: false, autoUnmask: true, removeMaskOnSubmit: true, max: 100});
	$('#myModal2').on('show.bs.modal', function(e){
		var id = $(e.relatedTarget).data('id');
		var awal = $(e.relatedTarget).data('awal');
		var akhir = $(e.relatedTarget).data('akhir');
		var tunai = $(e.relatedTarget).data('tunai');
		$('#id_komisi').val(id);
		$('#target_awal_2').val(awal);
		$('#target_akhir_2').val(akhir);
		$('#tunai_2').val(tunai);
	});
});
</script>