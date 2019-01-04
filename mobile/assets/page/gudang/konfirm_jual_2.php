<?php
$id_karyawan=$_SESSION['id_karyawan'];
$sql=mysql_query("SELECT * FROM jual WHERE id_jual=$id");
if (mysql_num_rows($sql)=='0'){
	_alert("Nota Jual sudah dihapus. Proses dibatalkan.");
	_direct("?page=gudang&mode=konfirm_jual");
	break;
}
if (isset($buat_nota_siap_kirim_post)){
	$sql=mysql_query("SELECT * FROM jual_detail WHERE id_jual_detail=$id_jual_detail");
	if (mysql_num_rows($sql)=='0'){
		_alert("Barang sudah dihapus. Proses dibatalkan.");
		_direct("?page=gudang&mode=konfirm_jual_2&id=$id");
		break;
	}
	$sql=mysql_query("SELECT *
FROM
    jual_detail
    INNER JOIN harga_jual 
        ON (jual_detail.id_harga_jual = harga_jual.id_harga_jual)
    INNER JOIN barang_supplier 
        ON (harga_jual.id_barang_supplier = barang_supplier.id_barang_supplier)
    INNER JOIN barang 
        ON (barang_supplier.id_barang = barang.id_barang)
 WHERE id_jual_detail=$id_jual_detail AND barang.status=0");
	if (mysql_num_rows($sql)>0){
		_alert("Input gagal karena barang sudah tidak aktif.");
		_direct("?page=gudang&mode=konfirm_jual_2&id=$id");
		break;
	}
	$tgl = explode("/", $expire);
	$expire = $tgl[2] ."-". $tgl[1] ."-". $tgl[0];
	$sql=mysql_query("INSERT INTO nota_siap_kirim VALUES(null,'$tanggal',$id,'0',$id_karyawan)");
	$sql=mysql_query("SELECT * FROM nota_siap_kirim WHERE id_jual=$id");
	$row=mysql_fetch_array($sql);
	$id_nota_siap_kirim=$row['id_nota_siap_kirim'];
	$sql=mysql_query("SELECT *
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
WHERE barang.id_barang=" .$id_barang. " AND barang_masuk_rak.id_rak=" .$id_rak. " AND barang.status=1 AND expire='" .$expire. "' AND barang.status=1
ORDER BY expire, nama_gudang, nama_rak, tgl_datang");

	if (mysql_num_rows($sql)>0){
		$total_qty_ambil=0;
		$tmp_qty_ambil=$qty_ambil;
		while ($row=mysql_fetch_array($sql)){
			$id_barang_masuk_rak=$row['id_barang_masuk_rak'];
			$stok=$row['stok'];
			if ($tmp_qty_ambil>=$stok){
				if ($total_qty_ambil<=$qty_ambil && $stok > 0){
					$sql2=mysql_query("INSERT INTO nota_siap_kirim_detail VALUES(null,$id_nota_siap_kirim,$id_jual_detail,$id_barang_masuk_rak,$stok,'$expire',$id_rak,0)");
					$total_qty_ambil+=$stok;
					$tmp_qty_ambil-=$stok;
				}
			} else {
				if ($total_qty_ambil<$qty_ambil && $stok > 0){
					$sql2=mysql_query("INSERT INTO nota_siap_kirim_detail VALUES(null,$id_nota_siap_kirim,$id_jual_detail,$id_barang_masuk_rak,$tmp_qty_ambil,'$expire',$id_rak,0)");
					$total_qty_ambil+=$tmp_qty_ambil;
					$tmp_qty_ambil-=$stok;
				}
			}
		}
	} else {
		_alert("Input Salah. Silakan input kembali.");
	}
	_direct("?page=gudang&mode=konfirm_jual_2&id=$id");
}
if (isset($_GET['del'])){
	$sql=mysql_query("SELECT * FROM nota_siap_kirim_detail WHERE id_nota_siap_kirim_detail=" .$_GET['del']. "");
	$row=mysql_fetch_array($sql);
	$id_jual_detail=$row['id_jual_detail'];
	$id_rak=$row['id_rak'];
	$expire=$row['expire'];
	$sql=mysql_query("DELETE FROM nota_siap_kirim_detail
		WHERE id_jual_detail=$id_jual_detail AND id_rak=$id_rak AND expire='$expire'");
	_direct("?page=gudang&mode=konfirm_jual_2&id=$id");
}
if (isset($selesai_nota_siap_kirim_post)){
	$sql=mysql_query("SELECT *,SUM(qty_ambil) AS qty_ambil
FROM
    nota_siap_kirim
    INNER JOIN nota_siap_kirim_detail 
        ON (nota_siap_kirim.id_nota_siap_kirim = nota_siap_kirim_detail.id_nota_siap_kirim)
    INNER JOIN jual_detail 
        ON (nota_siap_kirim_detail.id_jual_detail = jual_detail.id_jual_detail)
    INNER JOIN harga_jual 
        ON (jual_detail.id_harga_jual = harga_jual.id_harga_jual)
    INNER JOIN barang_supplier 
        ON (harga_jual.id_barang_supplier = barang_supplier.id_barang_supplier)
    INNER JOIN barang 
        ON (barang_supplier.id_barang = barang.id_barang)
	INNER JOIN satuan 
        ON (barang.id_satuan = satuan.id_satuan)
WHERE nota_siap_kirim.id_jual=$id AND barang.status=0
GROUP BY barang.id_barang");
if (mysql_num_rows($sql)>0){
	$sql2=mysql_query("SELECT * FROM jual INNER JOIN pelanggan ON (jual.id_pelanggan = pelanggan.id_pelanggan) WHERE id_jual=$id");
	$row2=mysql_fetch_array($sql2);
	$id_sales=$row2['id_karyawan'];
	$pelanggan=$row2['nama_pelanggan'];
	$invoice=$row2['invoice'];
	$tanggal=date("Y-m-d H:i:s");
	$judul='Ada barang yang tidak disimpan karena non aktif';
	$pesan='Nama Toko : ' .$pelanggan. '\r\nNo Nota Jual : ' .$invoice. '\r\nTipe: Dalam Kota\r\n\r\n';
	
	while ($row=mysql_fetch_array($sql)){
		$pesan.=$row['nama_barang']. '\r\n\t' .$row['qty_ambil']. ' ' .$row['nama_satuan']. '\r\n' ;
	}
	$sql2=mysql_query("INSERT INTO pesan VALUES (null,'$tanggal',$id_sales,'$judul','$pesan',0)");
	$sql2=mysql_query("DELETE FROM nota_siap_kirim_detail WHERE id_jual_detail=" .$row['id_jual_detail']);
	_alert("Ada barang yang tidak disimpan karena non aktif");
}
	$sql=mysql_query("SELECT * FROM nota_siap_kirim INNER JOIN nota_siap_kirim_detail 
		ON (nota_siap_kirim.id_nota_siap_kirim = nota_siap_kirim_detail.id_nota_siap_kirim) WHERE id_jual=$id");
	while ($row=mysql_fetch_array($sql)){
		$sql2=mysql_query("SELECT * FROM barang_masuk_rak WHERE id_barang_masuk_rak=" .$row['id_barang_masuk_rak']. "");
		$row2=mysql_fetch_array($sql2);
		$stok=$row2['stok']-$row['qty_ambil'];
		if ($stok<0){
			tulis_log(date('d-m-Y H:i'). ' Stok minus selesai nota siap kirim konfirm_jual_2 id_jual=' .$id. '\r\n');
			tulis_log('stok=' .$row2['stok']. ' qty_ambil=' .$row['qty_ambil']. '\r\n');
			tulis_log("UPDATE barang_masuk_rak SET stok=" .$stok. " WHERE id_barang_masuk_rak=" .$id_barang_masuk_rak. '\r\n');
		}
		$sql2=mysql_query("UPDATE barang_masuk_rak SET stok=$stok WHERE id_barang_masuk_rak=" .$row['id_barang_masuk_rak']. "");
	}
	$sql=mysql_query("UPDATE nota_siap_kirim SET status='1' WHERE id_jual=$id");
	$sql=mysql_query("UPDATE jual SET status_konfirm=1 WHERE id_jual=$id");
	_direct("?page=gudang&mode=konfirm_jual");
}

$sql=mysql_query("SELECT *
FROM
    nota_siap_kirim
    INNER JOIN nota_siap_kirim_detail 
        ON (nota_siap_kirim.id_nota_siap_kirim = nota_siap_kirim_detail.id_nota_siap_kirim)
WHERE id_jual=$id");
if (mysql_num_rows($sql)=='0'){
	$sql2=mysql_query("DELETE FROM nota_siap_kirim WHERE id_jual=$id");
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
	$nama_pelanggan=$row['nama_pelanggan'];
	$nama_karyawan=$row['nama_karyawan'];
	$jenis_bayar=$row['jenis_bayar'];
	$tenor=$row['tenor'];
	$plafon=$row['plafon'];
	$barang_expire=false;
	$selesai=false;
	$sql3=mysql_query("SELECT SUM(qty*(harga-diskon_rp-diskon_rp_2-diskon_rp_3)) AS jumlah_nota
FROM
    jual
    INNER JOIN jual_detail 
        ON (jual.id_jual = jual_detail.id_jual)
WHERE jual.id_pelanggan=" .$row['id_pelanggan']);
$row3=mysql_fetch_array($sql3);
$jumlah_nota=$row3['jumlah_nota'];
		$sql3=mysql_query("SELECT SUM(jumlah) AS jumlah_bayar
FROM
    bayar_nota_jual
    INNER JOIN jual 
        ON (bayar_nota_jual.no_nota_jual = jual.invoice)
WHERE jual.id_pelanggan=" .$row['id_pelanggan']);
$row3=mysql_fetch_array($sql3);
$jumlah_gantung=$jumlah_nota-$row3['jumlah_bayar'];
if ($jumlah_gantung>$plafon) _alert("Nota sudah melebihi plafon");
$sql4=mysql_query("SELECT * FROM jual WHERE invoice NOT IN (SELECT no_nota_jual FROM bayar_nota_jual WHERE STATUS=1) AND id_pelanggan=" .$row['id_pelanggan']);
$jml_nota=format_angka(mysql_num_rows($sql4));
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
						<table class="table table-bordered table-striped">
						<tbody>
<?php
	echo '					<tr><td width="40%">No Nota Jual</td><td>' .$no_nota. '</td></tr>
							<tr><td width="40%">Tanggal Nota Jual</td><td>' .date("d-m-Y", strtotime($tgl_nota)). '</td></tr>
							<tr><td width="40%">Nama Sales</td><td>' .$nama_karyawan. '</td></tr>
							<tr><td width="40%">Nama Pelanggan</td><td>' .$nama_pelanggan. '</td></tr>
							<tr><td width="40%">Jenis Bayar</td><td>' .$jenis_bayar. '</td></tr>
							<tr><td width="40%">Tenor</td><td>' .$tenor. ' hari</td></tr>
							<tr><td width="40%">Jumlah Nota Gantung</td><td>Rp. ' .format_uang($jumlah_gantung). ' (' .$jml_nota. ' nota)</td></tr>
							<tr><td width="40%">Plafon</td><td>Rp. ' .format_uang($plafon). '</td></tr>
							<tr><td width="40%">Sisa Plafon</td><td style="' .$style. '">Rp. ' .format_uang($plafon-$jumlah_gantung). '</td></tr>';
?>
						</tbody>
						</table>
						<div class="col-xs-6">
							<a class="btn btn-danger btn-xs" style="width:10px;height:10px">&nbsp;</a><font color="red">Qty Jual dan Qty Ambil tidak sama</font>
						</div>
						<div class="col-xs-6">
							<p align="right"><a href="?page=gudang&mode=edit_jual_detail&id=<?php echo $id ?>" class="btn btn-primary">Edit Nota</a></p>
						</div>
						<div class="clearfix"></div>
						<div class="table-responsive">
						<table class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>Nama Barang</th>
									<th>Qty Jual</th>
									<th>Harga (Rp)</th>
									<th>Diskon 1 (Rp)</th>
									<th>Diskon 2 (Rp)</th>
									<th>Diskon 3 (Rp)</th>
									<th>SubTotal (Rp)</th>
									<th>Stok</th>
									<th>Gudang</th>
									<th>Rak</th>
									<th>Tgl Exp.</th>
									<th>Qty Ambil</th>
									<th>Sub Total Ambil (Rp)</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
<?php
	$sql=mysql_query("SELECT *
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
$total=0;$total_=0;
	while ($row=mysql_fetch_array($sql)){
	$sql4=mysql_query("SELECT SUM(qty_ambil) AS qty_ambil
		FROM
			nota_siap_kirim
			INNER JOIN nota_siap_kirim_detail 
				ON (nota_siap_kirim.id_nota_siap_kirim = nota_siap_kirim_detail.id_nota_siap_kirim)
		WHERE id_jual_detail=" .$row['id_jual_detail']. "");
	$row4=mysql_fetch_array($sql4);
	$total_ambil=$row4['qty_ambil'];
	($total_ambil!=$row['qty'] ? $color="color:red" : $color="");
	$sql2=mysql_query("SELECT *, SUM(stok) as stok
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
WHERE barang.id_barang=" .$row['id_barang']. " AND barang.status=1 AND stok>0
GROUP BY barang_masuk_rak.id_rak, barang_masuk_rak.expire 
ORDER BY expire, nama_gudang, nama_rak, tgl_datang");
	(mysql_num_rows($sql2)==0 ? $n=1 : $n=mysql_num_rows($sql2));
	$total+=($row['harga']-$row['diskon_rp']-$row['diskon_rp_2']-$row['diskon_rp_3'])*$row['qty'];
	echo '<tr>
				<td style="vertical-align:middle;text-align:center;' .$color. '" rowspan="' .$n. '">' .$row['nama_barang']. '</td>
				<td style="vertical-align:middle;text-align:center;min-width:85px;' .$color. '" rowspan="' .$n. '">' .$row['qty']. ' ' .$row['nama_satuan']. '</td>
				<td style="vertical-align:middle;text-align:center;' .$color. '" rowspan="' .$n. '">' .format_uang($row['harga']). '</td>
				<td style="vertical-align:middle;text-align:center;' .$color. '" rowspan="' .$n. '">' .format_uang($row['diskon_rp']). '</td>
				<td style="vertical-align:middle;text-align:center;' .$color. '" rowspan="' .$n. '">' .format_uang($row['diskon_rp_2']). '</td>
				<td style="vertical-align:middle;text-align:center;' .$color. '" rowspan="' .$n. '">' .format_uang($row['diskon_rp_3']). '</td>
				<td style="vertical-align:middle;text-align:center;' .$color. '" rowspan="' .$n. '">' .format_uang(($row['harga']-$row['diskon_rp']-$row['diskon_rp_2']-$row['diskon_rp_3'])*$row['qty']). '</td>';
	
	while ($row2=mysql_fetch_array($sql2)){
		$sql3=mysql_query("SELECT id_nota_siap_kirim_detail, SUM(qty_ambil) AS qty_ambil
		FROM
			nota_siap_kirim
			INNER JOIN nota_siap_kirim_detail 
				ON (nota_siap_kirim.id_nota_siap_kirim = nota_siap_kirim_detail.id_nota_siap_kirim)
		WHERE id_jual_detail=" .$row['id_jual_detail']. " AND id_rak=" .$row2['id_rak']. " AND expire='" .$row2['expire']. "'");
		$row3=mysql_fetch_array($sql3);
		$expire=strtotime($row2['expire']);
		$now=strtotime(date("Y-m-d"));
		$days=ceil(($expire-$now)/86400);
		
		if ($row2['stok']==0 && mysql_num_rows($sql2)>1) {
			break;
		}
		if ($days<1) $barang_expire=true;
		echo '		<td align="center" style="min-width:85px;' .$color. '">' .$row2['stok']. ' ' .$row['nama_satuan']. '</td>
					<td align="center" style="' .$color. '">' .$row2['nama_gudang']. '</td>
					<td align="center" style="' .$color. '">' .$row2['nama_rak']. '</td>
					<td align="center" style="' .$color. '">' .date("d-m-Y",strtotime($row2['expire'])). '</td>';
		
		if ($row3['qty_ambil']==''){
				echo '		<td></td>
							<td></td>';
			if ($row2['stok']<>0) {
				echo '		<td align="center"><a data-toggle="modal" data-target="#myModal" data-rak="' .$row2['nama_rak']. '" data-id-rak="' .$row2['id_rak']. '" data-qty-jual="' .$row['qty']. '" data-expire="' .$row2['expire']. '" data-barcode="' .$row['barcode']. '" data-id-barang="' .$row['id_barang']. '" data-nama-barang="' .$row['nama_barang']. '" data-stok="' .$row2['stok']. '" data-satuan="' .$row['nama_satuan']. '" data-id-jd="' .$row['id_jual_detail']. '" data-id-bmr="' .$row2['id_barang_masuk_rak']. '" class="btn btn-primary btn-xs"><i class="fa fa-barcode"></i> Scan</a></td>';
			} else {
				echo '<td></td>';
			}
		} else {
			$selesai=true;
			$total_+=($row['harga']-$row['diskon_rp']-$row['diskon_rp_2']-$row['diskon_rp_3'])*$row3['qty_ambil'];
			echo '		<td align="center" style="' .$color. '">' .$row3['qty_ambil']. ' ' .$row['nama_satuan']. '</td>
						<td align="center" style="' .$color. '">' .format_uang($row3['qty_ambil']*$row['harga']). '</td>
						<td align="center"><a href="?page=gudang&mode=konfirm_jual_2&id=' .$id. '&del=' .$row3['id_nota_siap_kirim_detail']. '" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Hapus</a></td>';
		}
echo '		</tr>';
	}
}
echo '<tr>
		<td colspan="4"><b>Total (Rp)</b></td>
		<td align="center"><b>' .format_uang($total). '</b></td>
		<td colspan="5"></td>
		<td align="center"><b>' .format_uang($total_). '</b></td>
		<td></td>
	</tr>';
if ($barang_expire) _alert("Ada barang yang akan / sudah expire.");
?>
							</tbody>
						</table>
						</div>
						<form method="post">
							<input type="hidden" name="selesai_nota_siap_kirim_post" value="true">
						<?php
						echo '<center><input type="submit" class="btn btn-primary" value="SELESAI" ' .($selesai ? '' : 'disabled'). '></center>';
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
					<input type="hidden" name="buat_nota_siap_kirim_post" value="true">
					<input type="hidden" id="id_jual" name="id_jual" value="<?php echo $id ?>">
					<input type="hidden" id="id_jual_detail" name="id_jual_detail" value="">
					<input type="hidden" id="id_barang" name="id_barang" value="">
					<input type="hidden" id="id_barang_masuk_rak" name="id_barang_masuk_rak" value="">
					<input type="hidden" id="id_rak" name="id_rak" value="">
					<input type="hidden" id="barcode_rak" value="">
					<input type="hidden" id="barcode_barang" value="">
					<div class="text-center" style="margin-bottom:10px"><a id="scan_rak" class="btn btn-primary" onClick="AndroidFunction.scan_rak();">Scan Rak</a></div>
					<div class="form-group col-sm-12">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-file fa-fw"></i> Qty Jual</span>
							<input class="form-control" id="qty_jual" name="qty_jual" placeholder="Qty Jual" value="" readonly>
							<span class="input-group-addon satuan"></span>
							<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
						</div>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-bookmark fa-fw"></i> Stok</span>
							<input class="form-control" id="stok" name="stok" placeholder="Stok" value="" readonly>
							<span class="input-group-addon satuan"></span>
							<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
						</div>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-file fa-fw"></i> Nama Rak</span>
							<input class="form-control" id="nama_rak" placeholder="Nama Rak" value="" readonly>
							<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
						</div>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-file fa-fw"></i> Nama Barang</span>
							<input class="form-control" id="nama_barang" placeholder="Nama Barang" value="" readonly>
							<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
						</div>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-tags fa-fw"></i></span>
							<input class="form-control" type="tel" id="qty_ambil" name="qty_ambil" placeholder="Qty Ambil" value="" required>
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
		$('#dummy').load('assets/page/gudang/konfirm_jual_del.php?id=<?php echo $id ?>', function(){
			window.location='index.php?page=gudang&mode=konfirm_jual';
		});
	}
}
function cek_valid(){
	var qty_ambil = Number($('#qty_ambil').val());
	var stok = Number($('#stok').val());
	if (qty_ambil == '0') {
		AndroidFunction.showToast("Qty Ambil harus lebih dari 0.");
		return false;
	} else if (qty_ambil > stok){
		AndroidFunction.showToast("Qty Ambil tidak boleh melebihi stok.");
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
		$('#qty_ambil').removeAttr("disabled");
		$('#simpan').attr("style","");
	} else {
		AndroidFunction.showToast("Barcode Barang tidak sama.");
	}
}
function batal_scan(){
	getBack();
}
$(document).ready(function(){
	$('#stok').inputmask('decimal', {allowMinus: false, autoGroup: true, groupSeparator: '.', rightAlign: false, removeMaskOnSubmit: true});
	$('#qty_ambil').inputmask('numeric', {allowMinus: false, autoGroup: true, groupSeparator: '.', rightAlign: false, removeMaskOnSubmit: true});
	$('#myModal').on('show.bs.modal', function(e){
		var stok = $(e.relatedTarget).data('stok');
		var satuan = $(e.relatedTarget).data('satuan');
		var id_jual_detail = $(e.relatedTarget).data('id-jd');
		var id_barang = $(e.relatedTarget).data('id-barang');
		var nama_barang = $(e.relatedTarget).data('nama-barang');
		var id_barang_masuk_rak = $(e.relatedTarget).data('id-bmr');
		var id_rak = $(e.relatedTarget).data('id-rak');
		var nama_rak = $(e.relatedTarget).data('rak');
		var qty_jual = $(e.relatedTarget).data('qty-jual');
		var barcode_rak = $(e.relatedTarget).data('rak');
		var barcode_barang = $(e.relatedTarget).data('barcode');
		$('#stok').val(stok);
		$('#qty_ambil').val("");
		$('#qty_jual').val(qty_jual);
		$('#id_barang').val(id_barang);
		$('#nama_barang').val(nama_barang);
		$('#id_jual_detail').val(id_jual_detail);
		$('#id_barang_masuk_rak').val(id_barang_masuk_rak);
		$('#id_rak').val(id_rak);
		$('#nama_rak').val(nama_rak);
		$('#barcode_rak').val(barcode_rak);
		$('#barcode_barang').val(barcode_barang);
		$('.satuan').html(satuan);
		$('#scan_rak').attr("style","");
		$('#qty_ambil').attr("disabled","disabled");
		$('#simpan').attr("style","display:none");
		$('#scan_rak').click();
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
