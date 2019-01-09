<?php
$id_karyawan=$_SESSION['id_karyawan'];
if (isset($tambah_cek_barang_mobil_post)){
	$tgl = explode("/", $expire);
	$expire = $tgl[2] ."-". $tgl[1] ."-". $tgl[0];
	$sql=mysqli_query($con, "SELECT *,SUM(qty) as qty FROM canvass_keluar_barang WHERE id_canvass_keluar=$id AND id_barang=$id_barang AND expire='$expire' AND qty_cek IS NULL HAVING SUM(qty)>=$qty_cek");
	if (mysqli_num_rows($sql)>0){
		$sql=mysqli_query($con, "SELECT * FROM canvass_keluar_barang WHERE id_canvass_keluar=$id AND id_barang=$id_barang AND expire='$expire' AND qty_cek IS NULL");
		$total_qty_ambil=0;
		$tmp_qty_ambil=$qty_cek;
		while ($row=mysqli_fetch_array($sql)){
			$id_canvass_keluar_barang=$row['id_canvass_keluar_barang'];
			$id_barang_masuk_rak=$row['id_barang_masuk_rak'];
			$stok=$row['qty'];
			if ($total_qty_ambil==$qty_cek) break;
			if ($tmp_qty_ambil>=$stok){
				$qty_ambil=$stok;
				$sql2=mysqli_query($con, "UPDATE canvass_keluar_barang SET qty_cek=$qty_ambil,stok=$qty_ambil WHERE id_canvass_keluar_barang=$id_canvass_keluar_barang");
				$total_qty_ambil+=$stok;
				$tmp_qty_ambil-=$stok;
			} else {
				$qty_ambil=$tmp_qty_ambil;
				$sql2=mysqli_query($con, "UPDATE canvass_keluar_barang SET qty_cek=$tmp_qty_ambil,stok=$tmp_qty_ambil WHERE id_canvass_keluar_barang=$id_canvass_keluar_barang");
				$total_qty_ambil+=$tmp_qty_ambil;
				$tmp_qty_ambil-=$stok;
			}
		}
	} else {
		_alert("Input Salah. Silakan input kembali.");
	}
	_direct("?page=canvass_keluar&mode=cek_barang_mobil_2&id=$id");
}
if (isset($_GET['del'])){
	$sql=mysqli_query($con, "UPDATE canvass_keluar_barang SET qty_cek=null,stok=null WHERE id_canvass_keluar=$id AND id_barang=" .$_GET['del']. "");
	_direct("?page=canvass_keluar&mode=cek_barang_mobil_2&id=$id");
}
if (isset($selesai_cek_barang_mobil_post)){
	for ($i=0; $i<count($id_barang);$i++){
		$sql=mysqli_query($con, "SELECT * FROM canvass_keluar_barang WHERE id_canvass_keluar=$id AND id_barang=$id_barang[$i] HAVING SUM(qty_cek)=$qty_cek[$i]");
		if (mysqli_num_rows($sql)==0){
			_alert("Ada perubahan jumlah barang.");
			break;
		}
	}
	$sql=mysqli_query($con, "SELECT * FROM canvass_keluar_barang WHERE id_canvass_keluar=$id AND qty_cek IS NULL");
	if (mysqli_num_rows($sql)>0) {
		_alert("Masih ada barang yang belum discan");
	} else {
		$sql=mysqli_query($con, "UPDATE canvass_keluar SET status='1' WHERE id_canvass_keluar=$id");
		_direct("?page=canvass_keluar&mode=cek_barang_mobil");
	}
}

	$sql=mysqli_query($con, "SELECT *,canvass_keluar.status
FROM
    canvass_keluar
    LEFT JOIN kendaraan 
        ON (canvass_keluar.id_mobil = kendaraan.id_kendaraan)
	WHERE id_canvass_keluar=$id");
	$row=mysqli_fetch_array($sql);
	$tgl_canvass=$row['tanggal_canvass'];
	$nama_mobil=$row['nama_kendaraan'];
	$plat=$row['plat'];
	$status=$row['status'];
	$sql2=mysqli_query($con, "SELECT *
FROM
    canvass_keluar_karyawan
    INNER JOIN karyawan 
        ON (canvass_keluar_karyawan.id_karyawan = karyawan.id_karyawan)
	INNER JOIN users 
        ON (karyawan.id_karyawan = users.id_karyawan)
	WHERE id_canvass_keluar=$id");
	$baris=mysqli_num_rows($sql2);
	$sql=mysqli_query($con, "SELECT * FROM canvass_keluar_barang WHERE id_canvass_keluar=$id AND qty_cek IS NULL");
	(mysqli_num_rows($sql)>0 ? $locked=true : $locked=false);
?>
<div class="right_col loading" role="main">
	<div class="">
	
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<div class="col-md-6">
							<h3>PERIKSA BARANG DI MOBIL</h3>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<table class="table table-bordered table-striped">
						<tbody>
<?php
	echo '					<tr><td width="40%">Tanggal Canvass</td><td>' .date("d-m-Y", strtotime($tgl_canvass)). '</td></tr>
							<tr><td width="40%">Nama Mobil</td><td>' .$nama_mobil. '</td></tr>
							<tr><td width="40%">No Pol</td><td>' .$plat. '</td></tr>';
	
	echo '					<tr><td rowspan="' .$baris. '">Nama Karyawan</td>';
	while ($row2=mysqli_fetch_array($sql2)){
		echo '				<td>- ' .$row2['nama_karyawan']. ' ( ' .$row2['posisi']. ' )</td></tr>';
	}
	echo '</tr>';
?>
						</tbody>
						</table>
						<div class="alert alert-info">
						  <strong>Jika ada selisih barang, hapus barang, lalu scan barang kembali, dan input jumlah yang benar.</strong><br>
						</div>
						<div class="clearfix"></div>
						<a class="btn btn-danger btn-xs" style="width:10px;height:10px">&nbsp;</a><font color="red">Qty Ambil dan Qty Periksa tidak sama</font>
						<div class="table-responsive">
						<table class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>Nama Barang</th>
									<th>Qty Periksa</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
<?php
	$sql=mysqli_query($con, "SELECT *,SUM(qty) as qty, SUM(qty_cek) as qty_cek
FROM
    canvass_keluar_barang
    INNER JOIN barang 
        ON (canvass_keluar_barang.id_barang = barang.id_barang)
    INNER JOIN rak 
        ON (canvass_keluar_barang.id_rak = rak.id_rak)
    INNER JOIN gudang 
        ON (rak.id_gudang = gudang.id_gudang)
    INNER JOIN satuan 
        ON (barang.id_satuan = satuan.id_satuan)
WHERE id_canvass_keluar=$id
GROUP BY canvass_keluar_barang.id_barang,canvass_keluar_barang.id_rak");
$CEK_VALID=0;
	while ($row=mysqli_fetch_array($sql)){
	($row['qty_cek']==$row['qty'] ? $style="" : $style="color:red;");
	echo '<tr>
				<td style="vertical-align:middle;text-align:center;' .$style. '">' .$row['nama_barang']. '</td>';
	
		if ($row['qty_cek']==''){
			$CEK_VALID+=1;
			echo '		<td></td>
						<td style="vertical-align:middle;text-align:center;' .$style. '" align="center"><a data-toggle="modal" data-target="#myModal" data-id-barang="' .$row['id_barang']. '" data-barcode="' .$row['barcode']. '" data-id-rak="' .$row['id_rak']. '" data-id-canvass="' .$row['id_canvass_keluar_barang']. '" data-satuan="' .$row['nama_satuan']. '" data-ambil="' .$row['qty']. '" data-tot-cek="0" class="btn btn-primary btn-xs"><i class="fa fa-barcode"></i> Scan</a></td>';
		} else {
			if ($row['qty_cek']==$row['qty']){
				echo '	<td align="center" style="vertical-align:middle;text-align:center;' .$style. '">' .$row['qty_cek']. ' ' .$row['nama_satuan']. '</td>
						<td align="center" style="vertical-align:middle;text-align:center;' .$style. '">
							<a href="?page=canvass_keluar&mode=cek_barang_mobil_2&id=' .$id. '&del=' .$row['id_barang']. '" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Hapus</a>
						</td>';
			} else {
				$CEK_VALID+=1;
				echo '	<td align="center" style="vertical-align:middle;text-align:center;' .$style. '">' .$row['qty_cek']. ' ' .$row['nama_satuan']. '</td>
						<td align="center" style="vertical-align:middle;text-align:center;' .$style. '">
							<a data-toggle="modal" data-target="#myModal" data-id-barang="' .$row['id_barang']. '" data-barcode="' .$row['barcode']. '" data-id-rak="' .$row['id_rak']. '" data-id-canvass="' .$row['id_canvass_keluar_barang']. '" data-satuan="' .$row['nama_satuan']. '" data-ambil="' .$row['qty']. '" data-tot-cek="' .$row['qty_cek']. '" class="btn btn-primary btn-xs"><i class="fa fa-barcode"></i> Scan</a>
							<a href="?page=canvass_keluar&mode=cek_barang_mobil_2&id=' .$id. '&del=' .$row['id_barang']. '" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Hapus</a>
						</td>';
			}
		}
echo '		</tr>';
	}	

?>
							</tbody>
						</table>
						</div>
						<form method="post">
							<input type="hidden" name="selesai_cek_barang_mobil_post" value="true">
						<?php
							$sql=mysqli_query($con, "SELECT id_barang, SUM(qty_cek) AS qty_cek FROM canvass_keluar_barang WHERE id_canvass_keluar=$id GROUP BY id_barang,id_rak");
							while ($row=mysqli_fetch_array($sql)){
								echo '<input type="hidden" name="id_barang[]" value="' .$row['id_barang']. '">';
								echo '<input type="hidden" name="qty_cek[]" value="' .$row['qty_cek']. '">';
							}
							
							if ($status=='9'){
								echo '<center><input type="submit" class="btn btn-primary" value="SELESAI" ';
								if ($locked OR $CEK_VALID>0) echo 'disabled';
								echo '></center>';
							}
						?>
						</form>
					</div>
				</div>
			<div id="dummy"></div>
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
				<h4 class="modal-title">Pilih Barang</h4>
			</div>
			<div class="modal-body">				
				<form action="" method="post" onsubmit="return cek_valid();">
					<input type="hidden" name="tambah_cek_barang_mobil_post" value="true">
					<input type="hidden" id="id_canvass_keluar_barang" name="id_canvass_keluar_barang" value="">
					<input type="hidden" id="id_barang" name="id_barang" value="">
					<input type="hidden" id="qty_ambil" name="qty_ambil" value="">
					<input type="hidden" id="barcode_barang" value="">
					<div class="text-center" style="margin-bottom:10px"><a id="scan_barang" class="btn btn-primary" onClick="AndroidFunction.scan_barang();">Scan Barang</a></div>
					<div class="form-group col-sm-12">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-bookmark fa-fw"></i> Total Qty Periksa</span>
							<input class="form-control" id="tot_qty_cek2" placeholder="Total Qty Periksa" value="" readonly>
							<span class="input-group-addon satuan"></span>
							<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
						</div>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-tags fa-fw"></i></span>
							<input class="form-control" type="tel" id="qty_cek" name="qty_cek" placeholder="Qty Periksa" value="" required>
							<span class="input-group-addon satuan"></span>
							<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
						</div>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
							<input class="form-control" id="expire" type="tel" name="expire" placeholder="Tgl Exp." value="" required>
							<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
						</div>
					</div>
					<div class="modal-footer">
						<input id="simpan" type="submit" class="btn btn-primary" value="Simpan">
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<script>
function getBack(){
	if ($('#myModal').is(':visible')){
		$('#myModal').modal('hide');
	} else {	
		window.location='index.php?page=canvass_keluar&mode=cek_barang_mobil';
	}
}
function cek_valid(){
	var tot_qty_cek = Number($('#tot_qty_cek2').val());
	var qty_cek = Number($('#qty_cek').val());
	var qty_ambil = Number($('#qty_ambil').val());
	if (qty_cek == '0') {
		AndroidFunction.showToast("Qty Periksa harus lebih dari 0.");
		return false;
	} else if ((qty_cek + tot_qty_cek) > qty_ambil){
		AndroidFunction.showToast("Total Qty Periksa tidak boleh melebihi Qty Ambil.");
		return false;
	}
	return true;
}

function cek_scan_barang(barcode1){
	var barcode2 = $('#barcode_barang').val();
	if (barcode1 == barcode2){
		$('#scan_barang').attr("style","display:none");
		$('#qty_cek').removeAttr("disabled");
		$('#simpan').attr("style","");
	} else {
		AndroidFunction.showToast("Barcode Barang tidak sama.");
		batal_scan();
	}
}

function batal_scan(){
	getBack();
}
$(document).ready(function(){
	$('#qty_ambil').inputmask('decimal', {allowMinus: false, autoGroup: true, groupSeparator: '.', rightAlign: false, removeMaskOnSubmit: true});
	$('#qty_cek').inputmask('numeric', {allowMinus: false, autoGroup: true, groupSeparator: '.', rightAlign: false, removeMaskOnSubmit: true});
	$('#myModal').on('show.bs.modal', function(e){
		var tot_cek = $(e.relatedTarget).data('tot-cek');
		var qty_ambil = $(e.relatedTarget).data('ambil');
		var satuan = $(e.relatedTarget).data('satuan');
		var id_canvass = $(e.relatedTarget).data('id-canvass');
		var id_barang = $(e.relatedTarget).data('id-barang');
		var barcode_barang = $(e.relatedTarget).data('barcode');
		$('#qty_ambil').val(qty_ambil);
		$('#tot_qty_cek2').val(tot_cek);
		$('#qty_cek').val("");
		$('#id_canvass_keluar_barang').val(id_canvass);
		$('#id_barang').val(id_barang);
		$('#barcode_barang').val(barcode_barang);
		$('.satuan').html(satuan);
		$('#scan_barang').attr("style","");
		$('#qty_cek').attr("disabled","disabled");
		$('#simpan').attr("style","display:none");
		$('#scan_barang').click();
	});
	$('#expire').inputmask("datetime",{inputFormat: "dd/mm/yyyy",oncomplete: function(){
		var x = new Date();
		var today = x.getDate() + "/" + parseInt(x.getMonth()+1) + "/" + x.getFullYear();
		var x = new Date(x.getFullYear() + "/" + parseInt(x.getMonth()+1) + "/" + x.getDate());
		var input = $(this).val();
		var i = input.split("/");	
		var y = new Date(i[2] + "/" + i[1] + "/" + i[0]);
		if (y >= x){
			
		} else {
			$(this).val('');
			AndroidFunction.showToast('Tanggal harus \u2265 ' + today + '.');
		}
	}});
})
</script>
