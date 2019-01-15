<?php
$id_karyawan=$_SESSION['id_karyawan'];
if (isset($cek_nota_siap_kirim_post)){
	if ($qty_ambil==$qty_cek){
		$sql=mysqli_query($con, "UPDATE nota_siap_kirim_detail SET cek=1 WHERE id_jual_detail=$id_jual_detail");
	} else {
		_alert("Qty Periksa tidak boleh kurang dari Qty Ambil");
	}
	_direct("?page=gudang&mode=konfirm_jual_3&id=$id");
}
if (isset($_GET['del'])){
	$sql=mysqli_query($con, "UPDATE nota_sudah_cek SET status='0' WHERE id_jual=$id");
	$sql=mysqli_query($con, "UPDATE nota_siap_kirim_detail SET cek=0 WHERE id_jual_detail=" .$_GET['del']);
	_direct("?page=gudang&mode=konfirm_jual_3&id=$id");
}
if (isset($buat_nota_sudah_cek_post)){
	$sql=mysqli_query($con, "DELETE FROM nota_sudah_cek WHERE id_jual=$id");
	$sql=mysqli_query($con, "INSERT INTO nota_sudah_cek VALUES(null,'$tanggal',$id,$jumlah,'1',$id_karyawan,null,'$jenis_kirim')");
	$sql=mysqli_query($con, "UPDATE jual SET status_konfirm='1' WHERE id_jual=$id");
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
	$plafon=$row['plafon'];
	$sql3=mysqli_query($con, "SELECT SUM(qty*(harga-diskon_rp-diskon_rp_2-diskon_rp_3)) AS jumlah_nota
FROM
    jual
    INNER JOIN jual_detail 
        ON (jual.id_jual = jual_detail.id_jual)
WHERE jual.id_pelanggan=" .$row['id_pelanggan']);
$row3=mysqli_fetch_array($sql3);
$jumlah_nota=$row3['jumlah_nota'];
		$sql3=mysqli_query($con, "SELECT SUM(jumlah) AS jumlah_bayar
FROM
    bayar_nota_jual
    INNER JOIN jual 
        ON (bayar_nota_jual.no_nota_jual = jual.invoice)
WHERE jual.id_pelanggan=" .$row['id_pelanggan']);
$row3=mysqli_fetch_array($sql3);
$jumlah_gantung=$jumlah_nota-$row3['jumlah_bayar'];
if ($jumlah_gantung>$plafon) _alert("Nota sudah melebihi plafon");
$sql4=mysqli_query($con, "SELECT * FROM jual WHERE invoice NOT IN (SELECT no_nota_jual FROM bayar_nota_jual WHERE STATUS=1) AND id_pelanggan=" .$row['id_pelanggan']);
$jml_nota=format_angka(mysqli_num_rows($sql4));
$sql4=mysqli_query($con, "SELECT nama_karyawan FROM nota_siap_kirim INNER JOIN karyawan ON (nota_siap_kirim.id_karyawan=karyawan.id_karyawan)");
$row4=mysqli_fetch_array($sql4);
$disiapkan=$row4['nama_karyawan'];
$sql4=mysqli_query($con, "SELECT status,tipe_kirim FROM nota_sudah_cek WHERE id_jual=$id");
$row4=mysqli_fetch_array($sql4);
($row4['status']=='1' || $row4['status']=='2' || $row4['status']=='3'? $locked=true : $locked=false);
($row4['tipe_kirim']=='' ? $tipe_kirim='' : $tipe_kirim=$row4['tipe_kirim']);
($plafon-$jumlah_gantung>0 ? $style="" : $style="color:red");
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
						<form action="" method="post">
						<table class="table table-bordered table-striped">
						<tbody>
<?php
	echo '					<tr><td width="40%">No Nota</td><td>' .$no_nota. '</td></tr>
							<tr><td width="40%">Tanggal Nota Jual</td><td>' .date("d-m-Y", strtotime($tgl_nota)). '</td></tr>
							<tr><td width="40%">Nama Sales</td><td>' .$nama_karyawan. '</td></tr>
							<tr><td width="40%">Disiapkan Oleh</td><td>' .$disiapkan. '</td></tr>
							<tr><td width="40%">Nama Pelanggan</td><td>' .$nama_pelanggan. '</td></tr>
							<tr><td width="40%">Jenis Bayar</td><td>' .$jenis_bayar. '</td></tr>
							<tr><td width="40%">Tenor</td><td>' .$tenor. ' hari</td></tr>
							<tr><td width="40%">Jumlah Nota Gantung</td><td>Rp. ' .format_uang($jumlah_gantung). ' (' .$jml_nota. ' nota)</td></tr>
							<tr><td width="40%">Plafon</td><td>Rp. ' .format_uang($plafon). '</td></tr>
							<tr><td width="40%">Sisa Plafon</td><td style="' .$style. '">Rp. ' .format_uang($plafon-$jumlah_gantung). '</td></tr>';
$sql=mysqli_query($con, "SELECT *
FROM
    nota_siap_kirim
    INNER JOIN nota_siap_kirim_detail 
        ON (nota_siap_kirim.id_nota_siap_kirim = nota_siap_kirim_detail.id_nota_siap_kirim)
WHERE id_jual=$id AND cek=0");
$row=mysqli_fetch_array($sql);
	if (!$locked && mysqli_num_rows($sql)==0) {
echo '						<tr><td width="40%">Pengiriman</td>
								<td><input type="radio" name="jenis_kirim" value="Kirim Sendiri" ';
	if($tipe_kirim=='Kirim Sendiri') echo 'checked';
	echo						' required> Kirim Sendiri
								<input type="radio" name="jenis_kirim" value="Via Ekspedisi" ';
	if($tipe_kirim=='Via Ekspedisi') echo 'checked'; 
	echo						' style="margin-left:10px" required> Via Ekspedisi</td>
								</tr>';
}
?>
						</tbody>
						</table>
						<div class="table-responsive">
						<table class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>Nama Barang</th>
									<th>Jumlah</th>
									<th>Harga (Rp)</th>
									<th>Diskon 1 (Rp)</th>
									<th>Diskon 2 (Rp)</th>
									<th>Diskon 3 (Rp)</th>
									<th>Qty Ambil</th>
									<th>Sub Total (Rp)</th>
									<th>Periksa</th>
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
WHERE id_jual=$id AND barang.status=1");
$total=0;
$total_berat=0;
$total_volume=0;
	while ($row=mysqli_fetch_array($sql)){
		$sql2=mysqli_query($con, "SELECT cek, SUM(qty_ambil) as qty_ambil
FROM
    nota_siap_kirim
    INNER JOIN nota_siap_kirim_detail 
        ON (nota_siap_kirim.id_nota_siap_kirim = nota_siap_kirim_detail.id_nota_siap_kirim)
WHERE id_jual_detail=" .$row['id_jual_detail']. "");
		$row2=mysqli_fetch_array($sql2);
		if ($row2['qty_ambil'] <> ''){
			echo '<tr>
					<td style="vertical-align:middle;text-align:center">' .$row['nama_barang']. '</td>
					<td style="vertical-align:middle;text-align:center">' .$row['qty']. ' ' .$row['nama_satuan']. '</td>
					<td style="vertical-align:middle;text-align:center">' .format_uang($row['harga']). '</td>
					<td style="vertical-align:middle;text-align:center">' .format_uang($row['diskon_rp']). '</td>
					<td style="vertical-align:middle;text-align:center">' .format_uang($row['diskon_rp_2']). '</td>
					<td style="vertical-align:middle;text-align:center">' .format_uang($row['diskon_rp_3']). '</td>';
			$total+=$row2['qty_ambil']*($row['harga']-$row['diskon_rp']-$row['diskon_rp_2']-$row['diskon_rp_3']);
			echo '	<td align="center">' .$row2['qty_ambil']. ' ' .$row['nama_satuan']. '</td>
					<td align="right">' .format_uang($row2['qty_ambil']*($row['harga']-$row['diskon_rp']-$row['diskon_rp_2']-$row['diskon_rp_3'])). '</td>';
			if ($row2['cek']=='1'){
				echo '<td align="center"><i class="fa fa-check"></i></td>';
				if (!$locked) {
					echo '<td align="center"><a href="?page=gudang&mode=konfirm_jual_3&id=' .$id. '&del=' .$row['id_jual_detail']. '" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> BATAL</a></td>';
				} else {
					echo '<td></td>';
				}
			} else {
				echo '<td align="center"></td>
					<td align="center"><a data-toggle="modal" data-target="#myModal" data-id="' .$row['id_jual_detail']. '" data-qty="' .$row2['qty_ambil']. '" data-satuan="' .$row['nama_satuan']. '" data-barcode="' .$row['barcode']. '" class="btn btn-primary btn-xs"><i class="fa fa-barcode"></i> SCAN</a></td>';
			}
			echo '</tr>';
		}
	}
	echo '<tr>
			<td colspan="4" align="center"><b>TOTAL (RP)</b></td>
			<td align="right"><b>' .format_uang($total). '</b></td>
		 </tr>';
?>
							</tbody>
						</table>
						</div>
						
							<input type="hidden" name="buat_nota_sudah_cek_post" value="true">
							<input type="hidden" name="total_harga" value="<?php echo $total ?>">
<?php
	$sql=mysqli_query($con, "SELECT *
FROM
    nota_siap_kirim
    INNER JOIN nota_siap_kirim_detail 
        ON (nota_siap_kirim.id_nota_siap_kirim = nota_siap_kirim_detail.id_nota_siap_kirim)
WHERE id_jual=$id AND cek=0");
$row=mysqli_fetch_array($sql);
	if (!$locked && mysqli_num_rows($sql)==0) echo '<center><button type="submit" class="btn btn-primary"><i class="fa fa-thumbs-o-up"></i> SELESAI</button></center>';
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
					<input type="hidden" name="cek_nota_siap_kirim_post" value="true">
					<input type="hidden" id="id_jual_detail" name="id_jual_detail" value="">
					<input type="hidden" id="barcode_barang" value="">
					<div class="text-center" style="margin-bottom:10px"><a id="scan_barang" class="btn btn-primary" onClick="AndroidFunction.scan_barang();">Scan Barang</a></div>
					<div class="form-group col-sm-12">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-tags fa-fw"></i> Qty Ambil</span>
							<input class="form-control" id="qty_ambil" name="qty_ambil" placeholder="Qty Ambil" value="" readonly required>
							<span class="input-group-addon satuan"></span>
							<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
						</div>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-bookmark fa-fw"></i></span>
							<input class="form-control" type="tel" id="qty_cek" name="qty_cek" placeholder="Qty Periksa" value="" required>
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
function cek_scan_barang(barcode1){
	var barcode2 = $('#barcode_barang').val();
	if (barcode1 == barcode2){
		$('#scan_barang').attr("style","display:none");
		$('#qty_cek').removeAttr("disabled");
		$('#simpan').attr("style","");
	} else {
		AndroidFunction.showToast("Barcode Barang tidak sama.");
	}
}
function cek_valid(){
	var qty_cek = Number($('#qty_cek').val());
	var qty_ambil = Number($('#qty_ambil').val());
	if (qty_cek == '0') {
		AndroidFunction.showToast("Qty Periksa harus lebih dari 0.");
		return false;
	} else if (qty_cek > qty_ambil){
		AndroidFunction.showToast("Qty Periksa tidak boleh melebihi Qty Ambil.");
		return false;
	}
	return true;
}
function batal_scan(){
	getBack();
}
$(document).ready(function(){
	$('#qty_ambil').inputmask('numeric', {allowMinus: false, autoGroup: true, groupSeparator: '.', rightAlign: false, removeMaskOnSubmit: true});
	$('#qty_cek').inputmask('numeric', {allowMinus: false, autoGroup: true, groupSeparator: '.', rightAlign: false, removeMaskOnSubmit: true});
	$('#myModal').on('show.bs.modal', function(e){
		var satuan = $(e.relatedTarget).data('satuan');
		var id_jual_detail = $(e.relatedTarget).data('id');
		var qty_ambil = $(e.relatedTarget).data('qty');
		var barcode_barang = $(e.relatedTarget).data('barcode');
		$('#qty_ambil').val(qty_ambil);
		$('#id_jual_detail').val(id_jual_detail);
		$('#barcode_barang').val(barcode_barang);
		$('.satuan').html(satuan);
		$('#scan_barang').attr("style","");
		$('#qty_cek').attr("disabled","disabled");
		$('#simpan').attr("style","display:none");
		$('#scan_barang').click();
	});
})
</script>
