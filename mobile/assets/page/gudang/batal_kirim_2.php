<?php
if (isset($batal_kirim_barang_post)){
	$sql=mysql_query("SELECT * FROM barang_masuk_rak WHERE id_barang_masuk_rak=$id_barang_masuk_rak");
	$row=mysql_fetch_array($sql);
	$id_barang_masuk=$row['id_barang_masuk'];
	$sql=mysql_query("INSERT INTO barang_masuk_rak VALUES(null,$id_barang_masuk,0,$id_rak,'$expire',$qty_balik)");
	$id_barang_masuk_rak=mysql_insert_id();
	$sql=mysql_query("INSERT INTO batal_kirim_detail_2 VALUES(null,$id_batal_kirim_detail,$id_rak,$qty_balik,$id_barang_masuk_rak)");
	_direct("?page=gudang&mode=batal_kirim_2&id=".$id);
}
if (isset($selesai_batal_kirim_post)){
	$sql=mysql_query("UPDATE batal_kirim SET status=1 WHERE id_jual=$id");
	$sql=mysql_query("UPDATE jual SET status_konfirm=0 WHERE id_jual=$id");
	$sql=mysql_query("UPDATE nota_sudah_cek SET status='0' WHERE id_jual=$id");
	$sql=mysql_query("SELECT id_nota_siap_kirim FROM nota_siap_kirim WHERE id_jual=$id");
	$row=mysql_fetch_array($sql);
	$id_nota_siap_kirim=$row['id_nota_siap_kirim'];
	$sql=mysql_query("UPDATE nota_siap_kirim SET status='0' WHERE id_nota_siap_kirim=$id_nota_siap_kirim");
	_direct("?page=gudang&mode=batal_kirim");
}
if (isset($_GET['del'])){
	$sql=mysql_query("SELECT * FROM batal_kirim_detail_2 WHERE id_batal_kirim_detail_id=" .$_GET['del']);
	$row=mysql_fetch_array($sql);
	$id_bmr=$row['id_bmr'];
	$sql2=mysql_query("DELETE FROM barang_masuk_rak WHERE id_barang_masuk_rak=$id_bmr");
	$sql=mysql_query("DELETE FROM batal_kirim_detail_2 WHERE id_batal_kirim_detail_id=" .$_GET['del']);
	_direct("?page=gudang&mode=batal_kirim_2&id=".$id);
}
$sql=mysql_query("SELECT *
FROM
    jual
    INNER JOIN pelanggan 
        ON (jual.id_pelanggan = pelanggan.id_pelanggan)
    INNER JOIN karyawan 
        ON (jual.id_karyawan = karyawan.id_karyawan)
	WHERE id_jual=$id");
	$row=mysql_fetch_array($sql);
	$no_nota=$row['invoice'];
	$tgl_nota=$row['tgl_nota'];
	$id_pelanggan=$row['id_pelanggan'];
	$nama_pelanggan=$row['nama_pelanggan'];
	$nama_karyawan=$row['nama_karyawan'];
	$jenis_bayar=$row['jenis_bayar'];
	$tenor=$row['tenor'];
	$plafon=$row['plafon'];
	$sql=mysql_query("SELECT nama_karyawan,id_batal_kirim,tanggal
FROM
    batal_kirim
    INNER JOIN karyawan 
        ON (batal_kirim.id_karyawan = karyawan.id_karyawan) WHERE id_jual=$id");
	$row=mysql_fetch_array($sql);
	$id_batal_kirim=$row['id_batal_kirim'];
	$tgl_batal=$row['tanggal'];
	$nama_batal=$row['nama_karyawan'];
	$selesai=false;
	
	$sql3=mysql_query("SELECT SUM(qty*(harga-diskon_rp-diskon_rp_2-diskon_rp_3)) AS jumlah_nota
FROM
    jual
    INNER JOIN jual_detail 
        ON (jual.id_jual = jual_detail.id_jual)
WHERE jual.id_pelanggan=" .$id_pelanggan);
$row3=mysql_fetch_array($sql3);
$jumlah_nota=$row3['jumlah_nota'];
		$sql3=mysql_query("SELECT SUM(jumlah) AS jumlah_bayar
FROM
    bayar_nota_jual
    INNER JOIN jual 
        ON (bayar_nota_jual.no_nota_jual = jual.invoice)
WHERE jual.id_pelanggan=" .$id_pelanggan);
$row3=mysql_fetch_array($sql3);
$jumlah_gantung=$jumlah_nota-$row3['jumlah_bayar'];
if ($jumlah_gantung>$plafon) _alert("Nota sudah melebihi plafon");
$sql4=mysql_query("SELECT * FROM jual WHERE invoice NOT IN (SELECT no_nota_jual FROM bayar_nota_jual WHERE STATUS=1) AND id_pelanggan=" .$id_pelanggan);
$jml_nota=format_angka(mysql_num_rows($sql4));
$sisa_plafon=$plafon-$jumlah_gantung;
($sisa_plafon < 0 ? $style="color:red" : $style="");
?>

<div class="right_col loading" role="main">
	<div class="">
	
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<div class="col-md-6">
							<h3>PEMBATALAN KIRIMAN</h3>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
					<table class="table table-bordered table-striped">
						<tbody>
<?php
	echo '					<tr><td width="40%">Tanggal Batal</td><td>' .date("d-m-Y", strtotime($tgl_batal)). '</td></tr>
							<tr><td width="40%">Dibatalkan Oleh</td><td>' .$nama_batal. '</td></tr>
							<tr><td width="40%">Tanggal Nota Jual</td><td>' .date("d-m-Y", strtotime($tgl_nota)). '</td></tr>
							<tr><td width="40%">Nama Sales</td><td>' .$nama_karyawan. '</td></tr>
							<tr><td width="40%">Nama Pelanggan</td><td>' .$nama_pelanggan. '</td></tr>
							<tr><td width="40%">Jenis Bayar</td><td>' .$jenis_bayar. '</td></tr>
							<tr><td width="40%">Tenor</td><td>' .$tenor. ' hari</td></tr>
							<tr><td width="40%">Jumlah Nota Gantung</td><td>Rp. ' .format_uang($jumlah_gantung). ' (' .$jml_nota. ' nota)</td></tr>
							<tr><td width="40%">Plafon</td><td>Rp. ' .format_uang($plafon). '</td></tr>
							<tr><td width="40%">Sisa Plafon</td><td style="' .$style. '">Rp. ' .format_uang($sisa_plafon). '</td></tr>';
?>
						</tbody>
					</table>
					<div class="table-responsive">
				<table class="table table-bordered table-striped">
				<thead>
					<tr>
						<th><div style="min-width:100px">Nama Barang</div></th>
						<th><div style="min-width:70px">Qty</div></th>
						<th><div style="min-width:70px">Tgl Exp.</div></th>
						<th><div style="min-width:70px">Gudang</div></th>
						<th><div style="min-width:70px">Rak</div></th>
						<th><div style="min-width:70px">Qty Kembali</div></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
				<?php
$sql=mysql_query("SELECT id_jual,id_batal_kirim_detail,nama_barang,qty_ambil,expire,nama_satuan,barcode,id_barang_masuk_rak
FROM
    batal_kirim_detail
    INNER JOIN jual_detail 
        ON (batal_kirim_detail.id_jual_detail = jual_detail.id_jual_detail)
    INNER JOIN harga_jual 
        ON (jual_detail.id_harga_jual = harga_jual.id_harga_jual)
    INNER JOIN barang_supplier 
        ON (harga_jual.id_barang_supplier = barang_supplier.id_barang_supplier)
    INNER JOIN barang 
        ON (barang_supplier.id_barang = barang.id_barang)
    INNER JOIN satuan 
        ON (barang.id_satuan = satuan.id_satuan)
 WHERE id_jual=$id
 GROUP BY batal_kirim_detail.id_jual_detail,expire");
$total_baris=0;$total_scan=0;
while($row=mysql_fetch_array($sql)){
$sql2=mysql_query("SELECT *
FROM
    batal_kirim_detail_2
    INNER JOIN rak 
        ON (batal_kirim_detail_2.id_rak = rak.id_rak)
    INNER JOIN gudang 
        ON (rak.id_gudang = gudang.id_gudang)
WHERE id_batal_kirim_detail=" .$row['id_batal_kirim_detail']);
(mysql_num_rows($sql2)=='0' ? $n=1 : $n=mysql_num_rows($sql2));
$x=mysql_num_rows($sql2);
	echo '			<tr>
						<td rowspan="' .$n. '">' .$row['nama_barang']. '</td>
						<td rowspan="' .$n. '">' .$row['qty_ambil']. ' ' .$row['nama_satuan']. '</td>
						<td rowspan="' .$n. '">' .date("d-m-Y",strtotime($row['expire'])). '</td>';

$sql3=mysql_query("SELECT SUM(qty_balik) AS tot_qty_balik FROM batal_kirim_detail_2 WHERE id_batal_kirim_detail=" .$row['id_batal_kirim_detail']);
$row3=mysql_fetch_array($sql3);
$tot_qty_balik=$row3['tot_qty_balik'];

while($row2=mysql_fetch_array($sql2)){
$total_baris+=1;
($row2['qty_balik']=='' ? $qty_kembali='' : $qty_kembali=$row2['qty_balik']. ' ' .$row['nama_satuan']);						
	echo '				<td>' .$row2['nama_gudang']. '</td>
						<td>' .$row2['nama_rak']. '</td>
						<td>' .$qty_kembali. '</td>';
	if ($row2['id_bmr']==''){
		echo '			<td><a data-toggle="modal" data-target="#myModal" data-qty="' .$row['qty_ambil']. '" data-satuan="' .$row['nama_satuan']. '" data-barcode="' .$row['barcode']. '" data-expire="' .$row['expire']. '" data-id-bmr="' .$row['id_barang_masuk_rak']. '" data-id-bkd="' .$row['id_batal_kirim_detail']. '" data-tot-balik="' .$tot_qty_balik. '" class="btn btn-primary btn-xs"><i class="fa fa-barcode"></i> SCAN</a></td>';
	} else {
		$total_scan+=1;
		echo '			<td>
							<a data-toggle="modal" data-target="#myModal" data-qty="' .$row['qty_ambil']. '" data-satuan="' .$row['nama_satuan']. '" data-barcode="' .$row['barcode']. '" data-expire="' .$row['expire']. '" data-id-bmr="' .$row['id_barang_masuk_rak']. '" data-id-bkd="' .$row['id_batal_kirim_detail']. '" data-tot-balik="' .$tot_qty_balik. '" class="btn btn-primary btn-xs"><i class="fa fa-barcode"></i> SCAN</a>
							<a href="?page=gudang&mode=batal_kirim_2&id=' .$id. '&del=' .$row2['id_batal_kirim_detail_id']. '" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> HAPUS</a>
						</td>';
	}
	echo '			</tr>';
}
if ($x==0){
	echo '<td></td><td></td><td></td>
	<td><a data-toggle="modal" data-target="#myModal" data-qty="' .$row['qty_ambil']. '" data-satuan="' .$row['nama_satuan']. '" data-barcode="' .$row['barcode']. '" data-expire="' .$row['expire']. '" data-id-bmr="' .$row['id_barang_masuk_rak']. '" data-id-bkd="' .$row['id_batal_kirim_detail']. '" data-tot-balik="' .$tot_qty_balik. '" class="btn btn-primary btn-xs"><i class="fa fa-barcode"></i> SCAN</a></td>
	</tr>';
}
}
?>
					
				</tbody>
			</table>
			</div>
			<?php
//if ($total_baris==$total_scan) 
	echo '<form method="post">
		<input type="hidden" name="selesai_batal_kirim_post" value="true">
		<center><input type="submit" class="btn btn-primary" value="SELESAI"></center>
		</form>';
			?>
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
					<input type="hidden" name="batal_kirim_barang_post" value="true">
					<input type="hidden" id="id_batal_kirim_detail" name="id_batal_kirim_detail" value="">
					<input type="hidden" id="id_barang_masuk_rak" name="id_barang_masuk_rak" value="">
					<input type="hidden" id="expire" name="expire" value="">
					<input type="hidden" id="barcode_barang" value="">
					<input type="hidden" id="tot_qty_balik" value="">
					<div id="div_gudang_rak" class="form-group col-sm-12"></div>
					<div class="text-center" style="margin-bottom:10px"><a id="scan_barang" class="btn btn-primary" onClick="AndroidFunction.scan_barang();">Scan Barang</a></div>
					<div class="form-group col-sm-12">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-tags fa-fw"></i> Qty Batal Kirim</span>
							<input class="form-control" id="qty_ambil" name="qty_ambil" placeholder="Qty Ambil" value="" readonly required>
							<span class="input-group-addon satuan"></span>
							<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
						</div>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-bookmark fa-fw"></i></span>
							<input class="form-control" type="tel" id="qty_balik" name="qty_balik" placeholder="Qty Kembali" value="" required>
							<span class="input-group-addon satuan"></span>
							<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
						</div>
					</div>
			</div>
			<div class="modal-footer">
				<input id="simpan" type="submit" class="btn btn-primary" value="Simpan">
			</div>
			</form>
		</div>
	</div>
</div>

<script>
function getBack(){
	window.location='index.php?page=gudang&mode=batal_kirim';
}
function cek_scan_rak(barcode1){
	$('#scan_barang').attr("style","display:none");
	$('#div_gudang_rak').html('<center><i class="fa fa-spinner fa-spin" style="font-size:24px"></i></center>');
	$('#div_gudang_rak').load('assets/page/gudang/get-rak.php?id=' + barcode1, function(){
		if ($.trim($('#div_gudang_rak').html()) == ''){
			$('#scan_barang').attr("style","");
			AndroidFunction.showToast("Barcode Rak tidak ditemukan.");
		} else {
			$('#qty_balik').removeAttr("disabled");
			$('#simpan').attr("style","");
		}
	})
}
function cek_scan_barang(barcode1){
	var barcode2 = $('#barcode_barang').val();
	if (barcode1 == barcode2){
		AndroidFunction.scan_rak();
	} else {
		AndroidFunction.showToast("Barcode Barang tidak sama.");
	}
}
function cek_valid(){
	var tot_qty_balik = Number($('#tot_qty_balik').val());
	var qty_balik = Number($('#qty_balik').inputmask('unmaskedvalue'));
	var qty_ambil = Number($('#qty_ambil').val());
	
	if ((tot_qty_balik + qty_balik) > qty_ambil){
		AndroidFunction.showToast("Qty Kembali tidak boleh melebihi Qty Batal Kirim.");
		return false;
	}
	if (qty_balik == 0){
		AndroidFunction.showToast("Qty Kembali Stok harus lebih dari 0.");
		return false;
	}
	return true;
}
$(document).ready(function(){
	$('#qty_balik').inputmask('numeric', {allowMinus: false, autoGroup: true, groupSeparator: '.', rightAlign: false, removeMaskOnSubmit: true});
	$('#myModal').on('show.bs.modal', function(e){
		var satuan = $(e.relatedTarget).data('satuan');
		var expire = $(e.relatedTarget).data('expire');
		var id_batal_kirim_detail = $(e.relatedTarget).data('id-bkd');
		var id_barang_masuk_rak = $(e.relatedTarget).data('id-bmr');
		var qty_ambil = $(e.relatedTarget).data('qty');
		var barcode_barang = $(e.relatedTarget).data('barcode');
		var tot_qty_balik = $(e.relatedTarget).data('tot-balik');
		$('#qty_ambil').val(qty_ambil);
		$('#id_batal_kirim_detail').val(id_batal_kirim_detail);
		$('#id_barang_masuk_rak').val(id_barang_masuk_rak);
		$('#barcode_barang').val(barcode_barang);
		$('#tot_qty_balik').val(tot_qty_balik);
		$('#expire').val(expire);
		$('.satuan').html(satuan);
		$('#div_gudang_rak').empty();
		$('#scan_barang').attr("style","");
		$('#qty_balik').attr("disabled","disabled");
		$('#simpan').attr("style","display:none");
		$('#scan_barang').click();
	});
})
</script>
