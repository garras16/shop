<?php
if (isset($tambah_supplier_post)){
	$sql = "INSERT INTO supplier VALUES(null,'$nama_supplier','$alamat',$id_negara,$id_prov,$id_kab,$id_kec,$id_kel,'$kode_pos','$telepon_supplier','$kontak','$telepon_kontak','$status')";
	$q = mysqli_query($con, $sql);
	if ($q){
		_buat_pesan("Input Berhasil","green");
	} else {
		_buat_pesan("Input Gagal","red");
	}
}
if (isset($edit_supplier_post)){
	$sql=mysqli_query($con, "UPDATE supplier SET nama_supplier='$nama_supplier',alamat='$alamat',id_negara=$id_negara,id_prov=$id_prov,id_kab=$id_kab,id_kec=$id_kec,id_kel=$id_kel,kode_pos='$kode_pos',telepon_supplier='$telepon_supplier',kontakperson='$kontak',telepon_kontak='$telepon_kontak',status='$status' WHERE id_supplier=$id_supplier");
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
						<h3>MASTER SUPPLIER</h3>
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
						<th>Nama Supplier</th>
						<th>Alamat</th>
						<th>Kelurahan</th>
						<th>Kecamatan</th>
						<th>Kabupaten</th>
						<th>Kode Pos</th>
						<th>Provinsi</th>
						<th>Negara</th>
						<th>Telepon Supplier</th>
						<th>Kontak Person</th>
						<th>Telepon Kontak Person</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody>
<?php
$sql=mysqli_query($con, "SELECT
    supplier.id_supplier
    , supplier.nama_supplier
    , supplier.alamat
    , supplier.kode_pos
    , supplier.telepon_supplier
    , supplier.kontakperson
    , supplier.telepon_kontak
    , supplier.status
    , kelurahan.id_kel
    , kelurahan.nama_kel
    , kecamatan.id_kec
    , kecamatan.nama_kec
    , kabupaten.id_kab
    , kabupaten.nama_kab
    , provinsi.id_prov
    , provinsi.nama_prov
    , negara.nama_negara
	, negara.id_negara
FROM
    supplier
    LEFT JOIN kelurahan 
        ON (supplier.id_kel = kelurahan.id_kel)
    LEFT JOIN kecamatan 
        ON (supplier.id_kec = kecamatan.id_kec)
    LEFT JOIN kabupaten 
        ON (supplier.id_kab = kabupaten.id_kab)
    LEFT JOIN provinsi 
        ON (supplier.id_prov = provinsi.id_prov)
    LEFT JOIN negara 
        ON (supplier.id_negara = negara.id_negara)
ORDER BY supplier.id_supplier DESC");
$i=0;
while($row=mysqli_fetch_array($sql)){
$i+=1;
$status = ($row['status'] == 1 ? 'Aktif' : 'Non Aktif');
IF ($row['nama_supplier']=='DIRI SENDIRI'){
	echo '			<tr>
						<td>' .$i. '</a></td>
						<td>' .$row['nama_supplier']. '</td>
						<td>' .$row['alamat']. '</td>
						<td>' .$row['nama_kel']. '</td>
						<td>' .$row['nama_kec']. '</td>
						<td>' .$row['nama_kab']. '</td>
						<td>' .$row['kode_pos']. '</td>
						<td>' .$row['nama_prov']. '</td>
						<td>' .$row['nama_negara']. '</td>
						<td>' .$row['telepon_supplier']. '</td>
						<td>' .$row['kontakperson']. '</td>
						<td>' .$row['telepon_kontak']. '</td>
						<td>' .$status. '</td>
					</tr>';
} ELSE {
echo '			<tr>
						<td><a data-toggle="modal" data-target="#myModal2" data-id_negara="' .$row['id_negara']. '" data-id_prov="' .$row['id_prov']. '" data-id_kab="' .$row['id_kab']. '" data-id_kec="' .$row['id_kec']. '" data-id_kel="' .$row['id_kel']. '" data-id_supplier="' .$row['id_supplier']. '">' .$i. '</a></td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id_negara="' .$row['id_negara']. '" data-id_prov="' .$row['id_prov']. '" data-id_kab="' .$row['id_kab']. '" data-id_kec="' .$row['id_kec']. '" data-id_kel="' .$row['id_kel']. '" data-id_supplier="' .$row['id_supplier']. '">' .$row['nama_supplier']. '</td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id_negara="' .$row['id_negara']. '" data-id_prov="' .$row['id_prov']. '" data-id_kab="' .$row['id_kab']. '" data-id_kec="' .$row['id_kec']. '" data-id_kel="' .$row['id_kel']. '" data-id_supplier="' .$row['id_supplier']. '">' .$row['alamat']. '</td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id_negara="' .$row['id_negara']. '" data-id_prov="' .$row['id_prov']. '" data-id_kab="' .$row['id_kab']. '" data-id_kec="' .$row['id_kec']. '" data-id_kel="' .$row['id_kel']. '" data-id_supplier="' .$row['id_supplier']. '">' .$row['nama_kel']. '</td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id_negara="' .$row['id_negara']. '" data-id_prov="' .$row['id_prov']. '" data-id_kab="' .$row['id_kab']. '" data-id_kec="' .$row['id_kec']. '" data-id_kel="' .$row['id_kel']. '" data-id_supplier="' .$row['id_supplier']. '">' .$row['nama_kec']. '</td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id_negara="' .$row['id_negara']. '" data-id_prov="' .$row['id_prov']. '" data-id_kab="' .$row['id_kab']. '" data-id_kec="' .$row['id_kec']. '" data-id_kel="' .$row['id_kel']. '" data-id_supplier="' .$row['id_supplier']. '">' .$row['nama_kab']. '</td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id_negara="' .$row['id_negara']. '" data-id_prov="' .$row['id_prov']. '" data-id_kab="' .$row['id_kab']. '" data-id_kec="' .$row['id_kec']. '" data-id_kel="' .$row['id_kel']. '" data-id_supplier="' .$row['id_supplier']. '">' .$row['kode_pos']. '</td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id_negara="' .$row['id_negara']. '" data-id_prov="' .$row['id_prov']. '" data-id_kab="' .$row['id_kab']. '" data-id_kec="' .$row['id_kec']. '" data-id_kel="' .$row['id_kel']. '" data-id_supplier="' .$row['id_supplier']. '">' .$row['nama_prov']. '</td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id_negara="' .$row['id_negara']. '" data-id_prov="' .$row['id_prov']. '" data-id_kab="' .$row['id_kab']. '" data-id_kec="' .$row['id_kec']. '" data-id_kel="' .$row['id_kel']. '" data-id_supplier="' .$row['id_supplier']. '">' .$row['nama_negara']. '</td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id_negara="' .$row['id_negara']. '" data-id_prov="' .$row['id_prov']. '" data-id_kab="' .$row['id_kab']. '" data-id_kec="' .$row['id_kec']. '" data-id_kel="' .$row['id_kel']. '" data-id_supplier="' .$row['id_supplier']. '">' .$row['telepon_supplier']. '</td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id_negara="' .$row['id_negara']. '" data-id_prov="' .$row['id_prov']. '" data-id_kab="' .$row['id_kab']. '" data-id_kec="' .$row['id_kec']. '" data-id_kel="' .$row['id_kel']. '" data-id_supplier="' .$row['id_supplier']. '">' .$row['kontakperson']. '</td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id_negara="' .$row['id_negara']. '" data-id_prov="' .$row['id_prov']. '" data-id_kab="' .$row['id_kab']. '" data-id_kec="' .$row['id_kec']. '" data-id_kel="' .$row['id_kel']. '" data-id_supplier="' .$row['id_supplier']. '">' .$row['telepon_kontak']. '</td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id_negara="' .$row['id_negara']. '" data-id_prov="' .$row['id_prov']. '" data-id_kab="' .$row['id_kab']. '" data-id_kec="' .$row['id_kec']. '" data-id_kel="' .$row['id_kel']. '" data-id_supplier="' .$row['id_supplier']. '">' .$status. '</td>
					</tr>';
}
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
				<h4 class="modal-title">Tambah Data Supplier</h4>
			</div>
			<div class="modal-body">				
				<form action="" method="post">
					<input type="hidden" name="tambah_supplier_post" value="true">
					<div class="form-group">
						<div class="col-sm-12">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-building fa-fw" style="width:51px;"></i><br><small>Nama</small></span>
								<input class="form-control" type="text" id="nama" style="padding: 20px 15px;" name="nama_supplier" placeholder="Nama Supplier" maxlength="50" required>
								<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
							</div>
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-map-marker fa-fw" style="width:51px;"></i><br><small>Alamat</small></span>
								<input name="alamat" type="text" class="form-control" style="padding: 20px 15px;" placeholder="Alamat Supplier" maxlength="200" required>
								<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="input-group">
								<span class="input-group-addon" style="padding: 2px 12px;"><i class="fa fa-map-marker fa-fw" style="width:51px;"></i><br><small>Negara</small></span>
								<select id="select_negara" class="select2 form-control" name="id_negara" required>
									<option value="" disabled selected>Pilih Negara</option>
								<?php
									$sql=mysqli_query($con, "SELECT * FROM negara");
									while ($row=mysqli_fetch_array($sql)){
										echo '<option value="' .$row['id_negara']. '">' .$row['nama_negara']. '</option>';
									}
								?>
								</select>
								<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="input-group">
								<span class="input-group-addon" style="padding: 2px 12px;"><i class="fa fa-map-marker fa-fw" style="width:51px;"></i><br><small>Prov.</small></span>
								<select id="select_prov" class="select2 form-control" name="id_prov" required>
									
								</select>
								<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="input-group">
								<span class="input-group-addon" style="padding: 2px 12px;"><i class="fa fa-map-marker fa-fw" style="width:51px;"></i><br><small>Kab.</small></span>
								<select id="select_kab" class="select2 form-control" name="id_kab" required>
									
								</select>
								<span class="input-group-addon" style="padding: 2px 12px;"><i class="fa fa-star fa-fw" style="color:red"></i></span>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="input-group">
								<span class="input-group-addon" style="padding: 2px 12px;"><i class="fa fa-map-marker fa-fw" style="width:51px;"></i><br><small>Kec.</small></span>
								<select id="select_kec" class="select2 form-control" name="id_kec">
									
								</select>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="input-group">
								<span class="input-group-addon" style="padding: 2px 12px;"><i class="fa fa-map-marker fa-fw" style="width:51px;"></i><br><small>Kel.</small></span>
								<select id="select_kel" class="select2 form-control" name="id_kel">
								
								</select>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-map-marker fa-fw" style="width:51px;"></i><br><small>Kode Pos</small></span>
								<input name="kode_pos" type="number" style="padding: 20px 15px;" class="form-control" placeholder="Kode Pos" onKeyPress="if(this.value.length==7) return false;">
							</div>
						</div>
						<div class="col-sm-12">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-phone fa-fw" style="width:51px;"></i><br><small>Tlp</small></span>
								<input name="telepon_supplier" style="padding: 20px 15px;" type="number" class="form-control" placeholder="Telepon Supplier" onKeyPress="if(this.value.length==20) return false;" required>
								<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
							</div>
						</div>
						<div class="col-sm-12">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-user fa-fw" style="width:51px;"></i><br><small>Kontak</small></span>
								<input name="kontak" type="text" class="form-control" style="padding: 20px 15px;" placeholder="Kontak Person" maxlength="50" required>
							</div>
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-phone fa-fw" style="width:51px;"></i><br><small>Telepon</small></span>
								<input name="telepon_kontak" type="number" class="form-control" style="padding: 20px 15px;" placeholder="Telepon Kontak Person" onKeyPress="if(this.value.length==20) return false;" required>
							</div>
							<div class="input-group">
								<span class="input-group-addon" style="padding: 2px 12px;"><i class="fa fa-flag fa-fw" style="width:51px;"></i><br><small>Status</small></span>
								<select class="form-control select" id="select_status" name="status" required>
									<option value="" disabled selected>Pilih Status</option>
									<option value="0">NON AKTIF</option>
									<option value="1">AKTIF</option>
								</select>
								<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
							</div>
						</div>
					</div>
					<div class="col-sm-12">
						<div class="modal-footer">
							<input type="submit" class="btn btn-primary" value="Simpan">
						</div>
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
				<h4 class="modal-title">Ubah Data Supplier</h4>
			</div>
			<div class="modal-body">				
				<form action="" method="post">
					<input type="hidden" name="edit_supplier_post" value="true">
					<div id="select_supplier">
						
					</div>
					<div class="col-sm-12">
						<div class="modal-footer">
							<input type="submit" class="btn btn-primary" value="Simpan">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<script>
	$('#myModal2').on('show.bs.modal', function(e){
		var id_supplier = $(e.relatedTarget).data('id_supplier');
		var id_negara = $(e.relatedTarget).data('id_negara');
		var id_prov = $(e.relatedTarget).data('id_prov');
		var id_kab = $(e.relatedTarget).data('id_kab');
		var id_kec = $(e.relatedTarget).data('id_kec');
		var id_kel = $(e.relatedTarget).data('id_kel');
		$('#select_supplier').load('api/web/get-supplier-modal.php?id_supplier=' + id_supplier + '&id_negara=' + id_negara + '&id_prov=' + id_prov + '&id_kab=' + id_kab + '&id_kec=' + id_kec + '&id_kel=' + id_kel, function(e){
			$('#select_negara_2').change(function(){
				var id=$(this).val();
				$('#select_prov_2').load('api/web/get-select-daerah.php?id_negara=' + id);
				$('#select_kab_2').empty();
				$('#select_kec_2').empty();
				$('#select_kel_2').empty();
			});
			$('#select_prov_2').change(function(){
				var id=$(this).val();
				$('#select_kab_2').load('api/web/get-select-daerah.php?id_prov=' + id);
				$('#select_kec_2').empty();
				$('#select_kel_2').empty();
			});
			$('#select_kab_2').change(function(){
				var id=$(this).val();
				$('#select_kec_2').load('api/web/get-select-daerah.php?id_kab=' + id);
				$('#select_kel_2').empty();
			});
			$('#select_kec_2').change(function(){
				var id=$(this).val();
				$('#select_kel_2').load('api/web/get-select-daerah.php?id_kec=' + id);
			});
		});
	})
	$('#select_negara').change(function(){
		var id=$(this).val();
		$('#select_prov').load('api/web/get-select-daerah.php?id_negara=' + id);
	});
	$('#select_prov').change(function(){
		var id=$(this).val();
		$('#select_kab').load('api/web/get-select-daerah.php?id_prov=' + id);
	});
	$('#select_kab').change(function(){
		var id=$(this).val();
		$('#select_kec').load('api/web/get-select-daerah.php?id_kab=' + id);
	});
	$('#select_kec').change(function(){
		var id=$(this).val();
		$('#select_kel').load('api/web/get-select-daerah.php?id_kec=' + id);
	});
</script>