<?php
if (isset($buat_nota_siap_kirim_post)){
	$sql=mysqli_query($con, "INSERT INTO nota_siap_kirim VALUES(null,'$tanggal',$id,'0')");
	$sql=mysqli_query($con, "SELECT * FROM nota_siap_kirim WHERE id_jual=$id");
	$row=mysqli_fetch_array($sql);
	$id_nota_siap_kirim=$row['id_nota_siap_kirim'];
	$sql=mysqli_query($con, "SELECT *
FROM
    barang_supplier
    INNER JOIN barang 
        ON (barang_supplier.id_barang = barang.id_barang)
    INNER JOIN beli_detail 
        ON (beli_detail.id_barang_supplier = barang_supplier.id_barang_supplier)
    INNER JOIN barang_masuk 
        ON (barang_masuk.id_beli_detail = beli_detail.id_beli_detail)
    INNER JOIN barang_masuk_rak 
        ON (barang_masuk_rak.id_barang_masuk = barang_masuk.id_barang_masuk)
    INNER JOIN rak 
        ON (barang_masuk_rak.id_rak = rak.id_rak)
    INNER JOIN gudang 
        ON (rak.id_gudang = gudang.id_gudang)
WHERE barang.id_barang=" .$id_barang. "
GROUP BY barang_masuk_rak.id_rak,barang_masuk_rak.expire
ORDER BY expire, nama_gudang, nama_rak, tgl_datang");
	$total_qty_ambil=0;
	$tmp_qty_ambil=$qty_ambil;
	while ($row=mysqli_fetch_array($sql)){
		$id_barang_masuk_rak=$row['id_barang_masuk_rak'];
		$stok=$row['stok'];
		if ($tmp_qty_ambil>=$stok){
			if ($total_qty_ambil<=$qty_ambil){
				$sql2=mysqli_query($con, "INSERT INTO nota_siap_kirim_detail VALUES(null,$id_nota_siap_kirim,$id_jual_detail,$id_barang_masuk_rak,$stok)");
				$total_qty_ambil+=$stok;
				$tmp_qty_ambil-=$stok;
			}
		} else {
			if ($total_qty_ambil<$qty_ambil){
				$sql2=mysqli_query($con, "INSERT INTO nota_siap_kirim_detail VALUES(null,$id_nota_siap_kirim,$id_jual_detail,$id_barang_masuk_rak,$tmp_qty_ambil)");
				$total_qty_ambil+=$tmp_qty_ambil;
				$tmp_qty_ambil-=$stok;
			}
		}
	}
	_direct("?page=gudang&mode=konfirm_jual_2&id=$id");
}
if (isset($_GET['del'])){
	$sql=mysqli_query($con, "DELETE FROM nota_siap_kirim_detail WHERE id_jual_detail=" .$_GET['del']. "");
	_direct("?page=gudang&mode=konfirm_jual_2&id=$id");
}
if (isset($selesai_nota_siap_kirim_post)){
	$sql=mysqli_query($con, "SELECT * FROM nota_siap_kirim INNER JOIN nota_siap_kirim_detail 
		ON (nota_siap_kirim.id_nota_siap_kirim = nota_siap_kirim_detail.id_nota_siap_kirim) WHERE id_jual=$id");
	while ($row=mysqli_fetch_array($sql)){
		$sql2=mysqli_query($con, "SELECT * FROM barang_masuk_rak WHERE id_barang_masuk_rak=" .$row['id_barang_masuk_rak']. "");
		$row2=mysqli_fetch_array($sql2);
		$stok=$row2['stok']-$row['qty_ambil'];
		$sql2=mysqli_query($con, "UPDATE barang_masuk_rak SET stok=$stok WHERE id_barang_masuk_rak=" .$row['id_barang_masuk_rak']. "");
	}
	$sql=mysqli_query($con, "UPDATE nota_siap_kirim SET status='1' WHERE id_jual=$id");
	_direct("?page=gudang&mode=konfirm_jual");
}
	$sql=mysqli_query($con, "SELECT *
FROM
    jual
    INNER JOIN pelanggan 
        ON (jual.id_pelanggan = pelanggan.id_pelanggan)
    INNER JOIN karyawan 
        ON (jual.id_karyawan = karyawan.id_karyawan)
	WHERE id_jual=$id");
	$row=mysqli_fetch_array($sql);
	$no_nota=$row['invoice'];
	$tgl_nota=$row['tgl_nota'];
	$nama_pelanggan=$row['nama_pelanggan'];
	$nama_karyawan=$row['nama_karyawan'];
	$jenis_bayar=$row['jenis_bayar'];
	$tenor=$row['tenor'];
?>
<div class="right_col loading" role="main">
	<div class="">
	
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<div class="col-md-6">
							<h3>KONFIRMASI NOTA JUAL</h3>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<table class="table table-bordered table-striped">
						<tbody>
<?php
	echo '					<tr><td width="40%">No Nota Jual</td><td>' .$no_nota. '</td></tr>
							<tr><td width="40%">Tanggal Nota Jual</td><td>' .date("d-m-Y", strtotime($tgl_nota)). '</td></tr>
							<tr><td width="40%">Nama Sales</td><td>' .$nama_karyawan. '</td></tr>
							<tr><td width="40%">Nama Pelanggan</td><td>' .$nama_pelanggan. '</td></tr>
							<tr><td width="40%">Jenis Bayar</td><td>' .$jenis_bayar. '</td></tr>
							<tr><td width="40%">Tenor</td><td>' .$tenor. ' hari</td></tr>
							';
?>
						</tbody>
						</table>
						<div class="table-responsive">
						<table class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>Nama Barang</th>
									<th>Jumlah</th>
									<th>Satuan</th>
									<th>Harga (Rp)</th>
									<th>Subtotal (Rp)</th>
									<th>Stok</th>
									<th>Gudang</th>
									<th>Rak</th>
									<th>Expire</th>
									<th>Qty Ambil</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
<?php
	$sql=mysqli_query($con, "SELECT *
FROM
    jual_detail
    INNER JOIN harga_jual 
        ON (jual_detail.id_harga_jual = harga_jual.id_harga_jual)
    INNER JOIN barang_supplier 
        ON (harga_jual.id_barang_supplier = barang_supplier.id_barang_supplier)
    INNER JOIN barang 
        ON (barang_supplier.id_barang = barang.id_barang)
	INNER JOIN satuan 
        ON (barang.id_satuan = satuan.id_satuan)
WHERE id_jual=$id");
	while ($row=mysqli_fetch_array($sql)){
	$sql2=mysqli_query($con, "SELECT *, SUM(stok) as stok
FROM
    barang_supplier
    INNER JOIN barang 
        ON (barang_supplier.id_barang = barang.id_barang)
    INNER JOIN beli_detail 
        ON (beli_detail.id_barang_supplier = barang_supplier.id_barang_supplier)
    INNER JOIN barang_masuk 
        ON (barang_masuk.id_beli_detail = beli_detail.id_beli_detail)
    INNER JOIN barang_masuk_rak 
        ON (barang_masuk_rak.id_barang_masuk = barang_masuk.id_barang_masuk)
    INNER JOIN rak 
        ON (barang_masuk_rak.id_rak = rak.id_rak)
    INNER JOIN gudang 
        ON (rak.id_gudang = gudang.id_gudang)
WHERE barang.id_barang=" .$row['id_barang']. "
GROUP BY barang_masuk_rak.id_rak, barang_masuk_rak.expire 
ORDER BY expire, nama_gudang, nama_rak, tgl_datang");
$n=mysqli_num_rows($sql2);
echo '<tr>
				<td style="vertical-align:middle;text-align:center" rowspan="' .$n. '">' .$row['nama_barang']. '</td>
				<td style="vertical-align:middle;text-align:center" rowspan="' .$n. '">' .$row['qty']. '</td>
				<td style="vertical-align:middle;text-align:center" rowspan="' .$n. '">' .$row['nama_satuan']. '</td>
				<td style="vertical-align:middle;text-align:center" rowspan="' .$n. '">' .format_uang($row['harga']). '</td>
				<td style="vertical-align:middle;text-align:center" rowspan="' .$n. '">' .format_uang($row['harga']*$row['qty']). '</td>';
	while ($row2=mysqli_fetch_array($sql2)){	
	echo '		<td align="center">' .$row2['stok']. '</td>
				<td align="center">' .$row2['nama_gudang']. '</td>
				<td align="center">' .$row2['nama_rak']. '</td>
				<td align="center">' .date("d-m-Y",strtotime($row2['expire'])). '</td>';
	$sql3=mysqli_query($con, "SELECT id_nota_siap_kirim_detail, qty_ambil
FROM
    nota_siap_kirim
    INNER JOIN nota_siap_kirim_detail 
        ON (nota_siap_kirim.id_nota_siap_kirim = nota_siap_kirim_detail.id_nota_siap_kirim)
WHERE id_jual_detail=" .$row['id_jual_detail']. " AND id_barang_masuk_rak=" .$row2['id_barang_masuk_rak']. "");
	while($row3=mysqli_fetch_array($sql3)){
if ($row3['qty_ambil']==''){
	echo '		<td align="center"><a data-toggle="modal" data-target="#myModal" data-rak="' .$row2['nama_rak']. '" data-barcode="' .$row['barcode']. '" data-id-barang="' .$row['id_barang']. '" data-stok="' .$row2['stok']. '" data-satuan="' .$row['nama_satuan']. '" data-id-jd="' .$row['id_jual_detail']. '" data-id-bmr="' .$row2['id_barang_masuk_rak']. '" class="btn btn-primary btn-xs"><i class="fa fa-barcode"></i> Scan</a></td>
				<td></td>';
} else {
	echo '		<td align="center">' .$row3['qty_ambil']. '</td>
				<td><a href="?page=gudang&mode=konfirm_jual_2&id=' .$id. '&del=' .$row['id_jual_detail']. '" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Hapus</a></td>';
}
echo '		</tr>';
	}
	}
}
?>
							</tbody>
						</table>
						</div>
						<form method="post">
							<input type="hidden" name="selesai_nota_siap_kirim_post" value="true">
							<center><input type="submit" class="btn btn-primary" value="SELESAI"></center>
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
					<input type="hidden" name="buat_nota_siap_kirim_post" value="true">
					<input type="hidden" id="id_jual" name="id_jual" value="<?php echo $id ?>">
					<input type="hidden" id="id_jual_detail" name="id_jual_detail" value="">
					<input type="hidden" id="id_barang" name="id_barang" value="">
					<input type="hidden" id="id_barang_masuk_rak" name="id_barang_masuk_rak" value="">
					<input type="hidden" id="barcode_rak" value="">
					<input type="hidden" id="barcode_barang" value="">
					<div class="text-center" style="margin-bottom:10px"><a id="scan_rak" class="btn btn-primary" onClick="AndroidFunction.scan_rak();">Scan Rak</a></div>
					<div class="form-group col-sm-12">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-bookmark fa-fw"></i> Stok</span>
							<input class="form-control" id="stok" name="stok" placeholder="Stok" value="" readonly>
							<span class="input-group-addon satuan"></span>
							<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
						</div>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-tags fa-fw"></i></span>
							<input class="form-control" type="tel" id="qty_ambil" name="qty_ambil" placeholder="Qty Ambil" value="" required>
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
		window.location='index.php?page=gudang&mode=konfirm_jual';
	}
}
function cek_valid(){
	var qty_ambil = Number($('#qty_ambil').val());
	var stok = Number($('#stok').val());
	if (qty_ambil == '0') {
		alert("Qty Ambil harus lebih dari 0.");
		return false;
	} else if (qty_ambil > stok){
		alert("Qty Ambil tidak boleh melebihi stok.");
		return false;
	}
	return true;
}
function cek_scan_rak(barcode1){
	var barcode2 = $('#barcode_rak').val();
	if (barcode1 == barcode2){
		AndroidFunction.scan_barang();
	} else {
		AndroidFunction.showToast("Barcode Rak tidak sama.");
	}
}
function cek_scan_barang(barcode1){
	var barcode2 = $('#barcode_barang').val();
	if (barcode1 == barcode2){
		$('#scan_rak').attr("style","display:none");
		$('#simpan').attr("style","");
	} else {
		AndroidFunction.showToast("Barcode Barang tidak sama.");
	}
}
$(document).ready(function(){
	$('#stok').inputmask('decimal', {allowMinus: false, autoGroup: true, groupSeparator: '.', rightAlign: false, removeMaskOnSubmit: true});
	$('#qty_ambil').inputmask('decimal', {allowMinus: false, autoGroup: true, groupSeparator: '.', rightAlign: false, removeMaskOnSubmit: true});
	$('#myModal').on('show.bs.modal', function(e){
		var stok = $(e.relatedTarget).data('stok');
		var satuan = $(e.relatedTarget).data('satuan');
		var id_jual_detail = $(e.relatedTarget).data('id-jd');
		var id_barang = $(e.relatedTarget).data('id-barang');
		var id_barang_masuk_rak = $(e.relatedTarget).data('id-bmr');
		var barcode_rak = $(e.relatedTarget).data('rak');
		var barcode_barang = $(e.relatedTarget).data('barcode');
		$('#stok').val(stok);
		$('#qty_ambil').val("");
		$('#id_barang').val(id_barang);
		$('#id_jual_detail').val(id_jual_detail);
		$('#id_barang_masuk_rak').val(id_barang_masuk_rak);
		$('#barcode_rak').val(barcode_rak);
		$('#barcode_barang').val(barcode_barang);
		$('.satuan').html(satuan);
		$('#scan_rak').attr("style","");
/*		$('#simpan').attr("style","display:none");*/
	});
})
</script>
