<?php
$id_karyawan=$_SESSION['id_karyawan'];
if (isset($tambah_mutasi_mobil_gudang_post)){
	$tgl = explode("/", $expire);
	$expire = $tgl[2] ."-". $tgl[1] ."-". $tgl[0];
	$sql=mysqli_query($con, "SELECT * FROM canvass_keluar_barang WHERE id_canvass_keluar=$id AND id_barang=$id_barang AND expire='$expire' AND stok>0 HAVING SUM(stok)>=$qty_cek2");
	if (mysqli_num_rows($sql)>0){
		$row=mysqli_fetch_array($sql);
		$sql3=mysqli_query($con, "INSERT INTO canvass_mutasi_mobil_gudang VALUES(null,$id,'$tanggal'," .$row['id_barang_masuk_rak']. ",$id_barang,$id_rak,'$expire',$qty_cek2)");
	} else {
		_alert("Input Salah. Silakan input kembali.");
	}
	_direct("?page=canvass_keluar&mode=mutasi_mobil_gudang_2&id=$id");
}
if (isset($_GET['del'])){
	$sql=mysqli_query($con, "DELETE FROM canvass_mutasi_mobil_gudang WHERE id_canvass_keluar=$id AND id_barang=" .$_GET['del']. "");
	_direct("?page=canvass_keluar&mode=mutasi_mobil_gudang_2&id=$id");
}
if (isset($selesai_mutasi_mobil_gudang_post)){
	$sql=mysqli_query($con, "SELECT * FROM canvass_mutasi_mobil_gudang WHERE id_canvass_keluar=$id");
	while ($row=mysqli_fetch_array($sql)){
		$sql2=mysqli_query($con, "SELECT * FROM barang_masuk_rak WHERE id_barang_masuk_rak=" .$row['id_barang_masuk_rak']. "");
		$row2=mysqli_fetch_array($sql2);
		$id_barang_masuk=$row2['id_barang_masuk'];
		
		$id_rak=$row['id_rak'];
		$expire=$row['expire'];
		$stok=$row['qty_cek2'];
		
		$sql3=mysqli_query($con, "INSERT INTO barang_masuk_rak VALUES(null,$id_barang_masuk,0,$id_rak,'$expire',$stok)");
	}
	$sql3=mysqli_query($con, "UPDATE canvass_keluar SET status=4 WHERE id_canvass_keluar=$id");
	_direct("?page=canvass_keluar&mode=mutasi_mobil_gudang");
}
	$sql=mysqli_query($con, "SELECT *
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
	$sql=mysqli_query($con, "SELECT SUM(qty_cek) AS qty_cek FROM lap_stock_opname WHERE id_canvass_keluar=$id");
	$row=mysqli_fetch_array($sql);
	$qty_cek1=$row['qty_cek'];
	$sql=mysqli_query($con, "SELECT SUM(qty_cek2) AS qty_cek2 FROM canvass_mutasi_mobil_gudang WHERE id_canvass_keluar=$id");
	$row=mysqli_fetch_array($sql);
	$qty_cek2=$row['qty_cek2'];
	($qty_cek1==$qty_cek2 ? $locked=false : $locked=true);
?>
<div class="right_col loading" role="main">
	<div class="">
	
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<div class="col-md-6">
							<h3>MUTASI DARI MOBIL KE GUDANG (CANVASS)</h3>
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
						  <strong>Jika ada selisih barang, scan barang kembali, dan input jumlah kekurangannya.</strong><br>
						</div>
						<div class="table-responsive">
						<table class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>Nama Barang</th>
									<th>Qty Awal</th>
									<th>Qty Jual</th>
									<th>Qty Sisa</th>
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
    INNER JOIN satuan 
        ON (barang.id_satuan = satuan.id_satuan)
WHERE id_canvass_keluar=$id AND barang.id_barang IN (SELECT id_barang FROM lap_stock_opname WHERE qty_cek>0)
GROUP BY canvass_keluar_barang.id_barang,canvass_keluar_barang.id_rak");
	while ($row=mysqli_fetch_array($sql)){
	echo '<tr>
				<td style="vertical-align:middle;text-align:center;">' .$row['nama_barang']. '</td>
				<td style="vertical-align:middle;text-align:center;">' .$row['qty_cek']. ' ' .$row['nama_satuan']. '</td>';
	$sql2=mysqli_query($con, "SELECT SUM(qty_ambil) AS qty_ambil
FROM
    canvass_siap_kirim
    INNER JOIN canvass_siap_kirim_detail 
        ON (canvass_siap_kirim.id_canvass_siap_kirim = canvass_siap_kirim_detail.id_canvass_siap_kirim)
    INNER JOIN jual_detail 
        ON (canvass_siap_kirim_detail.id_jual_detail = jual_detail.id_jual_detail)
    INNER JOIN harga_jual 
        ON (jual_detail.id_harga_jual = harga_jual.id_harga_jual)
    INNER JOIN barang_supplier 
        ON (harga_jual.id_barang_supplier = barang_supplier.id_barang_supplier)
WHERE barang_supplier.id_barang=" .$row['id_barang']. " AND id_canvass_keluar=$id");
	while ($row2=mysqli_fetch_array($sql2)){
	$sql3=mysqli_query($con, "SELECT SUM(qty_cek2) AS qty_cek2 FROM canvass_mutasi_mobil_gudang WHERE id_canvass_keluar=$id AND id_barang=" .$row['id_barang']. "");
	$row3=mysqli_fetch_array($sql3);
	
	$sql4=mysqli_query($con, "SELECT SUM(qty_sisa) AS qty_sisa FROM lap_stock_opname WHERE id_canvass_keluar=$id AND id_barang=" .$row['id_barang']. "");
	$row4=mysqli_fetch_array($sql4);
	$qty_sisa=$row4['qty_sisa'];
	($row3['qty_cek2']!=$qty_sisa ? $style="color:red;" : $style="");
	echo '<td style="vertical-align:middle;text-align:center;" align="center">' .format_angka($row2['qty_ambil']). ' ' .$row['nama_satuan']. '</td>
		<td align="center" style="vertical-align:middle;text-align:center;">' .$qty_sisa. ' ' .$row['nama_satuan']. '</td>';
		if ($row3['qty_cek2']==''){
			echo '		<td></td>
						<td style="vertical-align:middle;text-align:center;' .$style. '" align="center"><a data-toggle="modal" data-target="#myModal" data-barcode="' .$row['barcode']. '" data-id-barang="' .$row['id_barang']. '" data-id-bmr="' .$row['id_barang_masuk_rak']. '" data-satuan="' .$row['nama_satuan']. '" data-ambil="' .$row['qty']. '" data-sisa="' .$qty_sisa. '" data-tot-cek="0" class="btn btn-primary btn-xs"><i class="fa fa-barcode"></i> Scan</a></td>';
		} else {
			echo '		<td style="vertical-align:middle;text-align:center;' .$style. '" align="center">' .$row3['qty_cek2']. ' ' .$row['nama_satuan']. '</td>';
			if ($row3['qty_cek2']!=$qty_sisa){
				echo ' <td style="vertical-align:middle;text-align:center;" align="center"><a data-toggle="modal" data-target="#myModal" data-barcode="' .$row['barcode']. '" data-id-barang="' .$row['id_barang']. '" data-id-bmr="' .$row['id_barang_masuk_rak']. '" data-satuan="' .$row['nama_satuan']. '" data-ambil="' .$row['qty']. '" data-sisa="' .$qty_sisa. '" data-tot-cek="' .$row3['qty_cek2']. '" class="btn btn-primary btn-xs"><i class="fa fa-barcode"></i> Scan</a>
						<a href="?page=canvass_keluar&mode=mutasi_mobil_gudang_2&id=' .$id. '&del=' .$row['id_barang']. '" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Hapus</a></td>';
			} else {
				echo '<td style="vertical-align:middle;text-align:center;" align="center"><a href="?page=canvass_keluar&mode=mutasi_mobil_gudang_2&id=' .$id. '&del=' .$row['id_barang']. '" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Hapus</a></td>';
			}
		}
echo '		</tr>';
	}
	}	

?>
							</tbody>
						</table>
						</div>
						<form method="post">
							<input type="hidden" name="selesai_mutasi_mobil_gudang_post" value="true">
							<?php
							if ($status<>4){
							 echo '<center><input type="submit" class="btn btn-primary" value="SELESAI" ';
							 if ($locked) echo 'disabled';
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
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&times;</button>
				<h4 class="modal-title">Pilih Barang</h4>
			</div>
			<div class="modal-body">
				<form action="" method="post" onsubmit="return cek_valid();">
					<input type="hidden" name="tambah_mutasi_mobil_gudang_post" value="true">
					<input type="hidden" id="id_barang_masuk_rak" name="id_barang_masuk_rak" value="">
					<input type="hidden" id="id_barang" name="id_barang" value="">
					<input type="hidden" id="barcode_barang" value="">
					<input type="hidden" id="barcode_rak" value="">
					<div class="text-center" style="margin-bottom:10px"><a id="scan_barang" class="btn btn-primary" onClick="AndroidFunction.scan_barang();">Scan Barang</a></div>
					<div class="form-group col-sm-12">
						<div id="get_rak" class="col-xs-12">
					
						</div>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-bookmark fa-fw"></i> Qty Sisa</span>
							<input class="form-control" id="qty_sisa" name="qty_sisa" placeholder="Qty Sisa" value="" readonly>
							<span class="input-group-addon satuan"></span>
							<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
						</div>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-bookmark fa-fw"></i> Total Qty Periksa</span>
							<input class="form-control" id="tot_qty_cek2" placeholder="Total Qty Periksa" value="" readonly>
							<span class="input-group-addon satuan"></span>
							<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
						</div>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
							<input class="form-control" id="expire" type="tel" name="expire" placeholder="Tgl Exp." value="" disabled="disabled" required>
							<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
						</div>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-tags fa-fw"></i></span>
							<input class="form-control" type="tel" id="qty_cek2" name="qty_cek2" placeholder="Qty Periksa" value="" required>
							<span class="input-group-addon satuan"></span>
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
		window.location='index.php?page=canvass_keluar&mode=mutasi_mobil_gudang';
	}
}
function cek_valid(){
	var tot_qty_cek = Number($('#tot_qty_cek2').val());
	var qty_cek = Number($('#qty_cek2').val());
	var qty_sisa = Number($('#qty_sisa').val());
	if (qty_cek == '0') {
		AndroidFunction.showToast("Qty Periksa harus lebih dari 0.");
		return false;
	} else if ((qty_cek + tot_qty_cek) > qty_sisa){
		AndroidFunction.showToast("Total Qty Periksa tidak boleh melebihi Qty Sisa.");
		return false;
	}
	return true;
}
function cek_scan_rak(barcode1){
	$('#get_rak').html('<center><i class="fa fa-spinner fa-spin" style="font-size:24px"></i></center>');
	$('#get_rak').load('assets/page/canvass_keluar/get-rak.php?id=' + barcode1,function(){
		if($('#get_rak').html()==''){
			alert("Rak tidak ditemukan.");
			AndroidFunction.showToast("Rak tidak ditemukan.");
			batal_scan();
		} else {
			$('#scan_barang').attr("style","display:none");
			$('#qty_cek2').removeAttr("disabled");
			$('#expire').removeAttr("disabled");
			$('#simpan').attr("style","");
		}
	});
}
function cek_scan_barang(barcode1){
	var barcode2 = $('#barcode_barang').val();
	if (barcode1 == barcode2){
		AndroidFunction.scan_rak();
	} else {
		AndroidFunction.showToast("Barcode Barang tidak sama.");
		batal_scan();
	}
}
function batal_scan(){
	getBack();
}
$(document).ready(function(){
	$('#qty_sisa').inputmask('decimal', {allowMinus: false, autoGroup: true, groupSeparator: '.', rightAlign: false, removeMaskOnSubmit: true});
	$('#tot_qty_cek2').inputmask('decimal', {allowMinus: false, autoGroup: true, groupSeparator: '.', rightAlign: false, removeMaskOnSubmit: true});
	$('#qty_cek2').inputmask('decimal', {allowMinus: false, autoGroup: true, groupSeparator: '.', rightAlign: false, removeMaskOnSubmit: true});
	$('#myModal').on('show.bs.modal', function(e){
		var tot_cek = $(e.relatedTarget).data('tot-cek');
		var qty_sisa = $(e.relatedTarget).data('sisa');
		var satuan = $(e.relatedTarget).data('satuan');
		var id_barang = $(e.relatedTarget).data('id-barang');
		var id_bmr = $(e.relatedTarget).data('id-bmr');
		var barcode_barang = $(e.relatedTarget).data('barcode');
		$('#qty_sisa').val(qty_sisa);
		$('#tot_qty_cek2').val(tot_cek);
		$('#qty_cek2').val("");
		$('#id_barang').val(id_barang);
		$('#id_barang_masuk_rak').val(id_bmr);
		$('#barcode_barang').val(barcode_barang);
		$('.satuan').html(satuan);
		$('#scan_barang').attr("style","");
		$('#qty_cek2').attr("disabled","disabled");
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
