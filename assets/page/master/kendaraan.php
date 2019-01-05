<?php
if (isset($tambah_kendaraan_post)){
	$sql = "INSERT INTO kendaraan VALUES(null,'$nama_kendaraan','$jenis_kendaraan',$id_varian,'$no_plat',$perbandingan,$km_awal,$status,$canvass)";
	$q = mysql_query($sql);
	if ($q){
		_buat_pesan("Input Berhasil","green");
	} else {
		_buat_pesan("Input Gagal","red");
	}
	_direct("?page=master&mode=kendaraan");
}
if (isset($edit_kendaraan_post)){
	$sql = "UPDATE kendaraan SET nama_kendaraan='$nama_kendaraan',jenis_kendaraan='$jenis_kendaraan',id_varian=$id_varian,plat='$no_plat',perbandingan=$perbandingan,km_awal=$km_awal,status=$status,canvass='$canvass' WHERE id_kendaraan='$id_kendaraan'";
	$q = mysql_query($sql);
	if ($q){
		_buat_pesan("Input Berhasil","green");
	} else {
		_buat_pesan("Input Gagal","red");
	}
	_direct("?page=master&mode=kendaraan");
}
?>
<!-- page content -->
<div class="right_col" role="main">
	<div class="">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<h3>MASTER KENDARAAN</h3>
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
			<p align="right">
				<a class="btn btn-warning" href="?page=kendaraan&mode=riwayat"><i class="fa fa-file"></i> Riwayat No Pol</a>
				<button class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Tambah</button>
			</p>
			
			<table id="table1" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>No.</th>
						<th>Nama Kendaraan</th>
						<th>Jenis</th>
						<th>Varian</th>
						<th>No Pol</th>
						<th>Perbandingan KM / 1 L</th>
						<th>KM awal</th>
						<th>Status</th>
						<th>Canvass</th>
					</tr>
				</thead>
				<tbody>
<?php
$sql=mysql_query("SELECT
    kendaraan.id_kendaraan
    , kendaraan.nama_kendaraan
    , kendaraan.jenis_kendaraan
    , kendaraan.plat
    , kendaraan.perbandingan
    , kendaraan.km_awal
	, kendaraan.status
	, kendaraan.canvass
    , varian_kendaraan.nama_varian
FROM
    kendaraan
    INNER JOIN varian_kendaraan 
        ON (kendaraan.id_varian = varian_kendaraan.id_varian)
ORDER BY id_kendaraan DESC");
$i=0;
while($row=mysql_fetch_array($sql)){
$i+=1;
$status = ($row['status'] == 1 ? 'Aktif' : 'Non Aktif');
$canvass = ($row['canvass'] == 1 ? 'Ya' : 'Tidak');
	echo '			<tr>
						<td><a data-toggle="modal" data-target="#myModal2" data-id="' .$row['id_kendaraan']. '">' .$i. '</a></td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id="' .$row['id_kendaraan']. '">' .$row['nama_kendaraan']. '</a></td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id="' .$row['id_kendaraan']. '">' .$row['jenis_kendaraan']. '</a></td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id="' .$row['id_kendaraan']. '">' .$row['nama_varian']. '</a></td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id="' .$row['id_kendaraan']. '">' .$row['plat']. '</a></td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id="' .$row['id_kendaraan']. '">' .format_angka($row['perbandingan']). '</a></td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id="' .$row['id_kendaraan']. '">' .format_angka($row['km_awal']). '</a></td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id="' .$row['id_kendaraan']. '">' .$status. '</a></td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id="' .$row['id_kendaraan']. '">' .$canvass. '</a></td>
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
				<h4 class="modal-title">Tambah Kendaraan</h4>
			</div>
			<div class="modal-body">				
				<form action="" method="post">
					<input type="hidden" name="tambah_kendaraan_post" value="true">
					<div class="col-md-12">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-car fa-fw"></i></span>
						<input class="form-control" type="text" name="nama_kendaraan" placeholder="Nama Kendaraan" maxlength="25" required>
						<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-truck fa-fw"></i></span>
						<select class="form-control select" id="select_jenis" name="jenis_kendaraan" required>
							<option value="" disabled selected>Pilih Jenis</option>
							<option value="MOBIL">MOBIL</option>
							<option value="MOTOR">MOTOR</option>
						</select>
						<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-check fa-fw"></i></span>
						<select class="form-control select" id="select_varian" name="id_varian" required>
							<option value="" disabled selected>Pilih Varian</option>
							
						</select>
						<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
					</div>
					<div class="input-group">
						<label><b>NO POL <b><font size="4" color="red">*</font></b> : &nbsp;</b></label>
						<input style="width: 30px" type="text" id="plat1" name="no_plat_1" onKeyPress="if(this.value.length==2) return false;" placeholder="BE" required>&nbsp;
						<input style="width: 50px" name="no_plat_2" onKeyPress="if(this.value.length==4) return false;" type="number" placeholder="9999" required>&nbsp;
						<input style="width: 40px" type="text" id="plat3" name="no_plat_3" maxlength="3" onKeyPress="if(this.value.length==3) return false;" placeholder="IDX" required>&nbsp;
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-dashboard fa-fw"></i></span>
						<input class="form-control" type="text" id="perbandingan" name="perbandingan" placeholder="Perbandingan KM / 1 L" required>
						<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-bar-chart-o fa-fw"></i></span>
						<input class="form-control" type="text" id="km_awal" name="km_awal" placeholder="KM Awal" required>
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
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-compass fa-fw"></i></span>
						<select class="form-control select" id="select_canvass" name="canvass" required>
							<option value="" disabled selected>Mobil Canvass?</option>
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
				<h4 class="modal-title">Ubah Data Kendaraan</h4>
			</div>
			<div class="modal-body">				
				<form action="" method="post">
					<input type="hidden" name="edit_kendaraan_post" value="true">
					<div id="get_kendaraan" class="col-md-12">
						
					</div>
					<div class="modal-footer">
						<input id="btn_save" type="submit" class="btn btn-primary" value="Simpan">
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
		$('#get_kendaraan').load('api/web/get-kendaraan.php?id=' + id,function(){
			$('#select_jenis_2').on('change', function(e){
				var nama_jenis = $('#select_jenis_2').val();
				$('#select_varian_2').load('api/web/get-varian.php?id=' + nama_jenis);
			})
			$('#plat1_2').keypress(function(e){
				if ((e.which < 97 || e.which > 122) && (e.which < 65 || e.which > 90)){
					e.preventDefault();
				}
			})
			$('#plat3_2').keypress(function(e){
				if ((e.which < 97 || e.which > 122) && (e.which < 65 || e.which > 90)){
					e.preventDefault();
				}
			})
			$('#perbandingan_2').inputmask('decimal', {allowMinus:false, autoGroup: true, groupSeparator: '.', rightAlign: false, autoUnmask: true, removeMaskOnSubmit: true});
			$('#km_awal_2').inputmask('decimal', {allowMinus:false, autoGroup: true, groupSeparator: '.', rightAlign: false, autoUnmask: true, removeMaskOnSubmit: true});
		});
	})
	$('#select_jenis').on('change', function(e){
		var nama_jenis = $('#select_jenis').val();
		$('#select_varian').load('api/web/get-varian.php?id=' + nama_jenis);
	})
	$('#plat1').keypress(function(e){
		if ((e.which < 97 || e.which > 122) && (e.which < 65 || e.which > 90)){
			e.preventDefault();
		}
	})
	$('#plat3').keypress(function(e){
		if ((e.which < 97 || e.which > 122) && (e.which < 65 || e.which > 90)){
			e.preventDefault();
		}
	})
	$('#perbandingan').inputmask('decimal', {allowMinus:false, autoGroup: true, groupSeparator: '.', rightAlign: false, autoUnmask: true, removeMaskOnSubmit: true});
	$('#km_awal').inputmask('decimal', {allowMinus:false, autoGroup: true, groupSeparator: '.', rightAlign: false, autoUnmask: true, removeMaskOnSubmit: true});
});
</script>