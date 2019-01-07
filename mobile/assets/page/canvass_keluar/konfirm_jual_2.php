<?php
$id_karyawan=$_SESSION['id_karyawan'];
$sql=mysqli_query($con, "SELECT * FROM jual WHERE id_jual=$id");
if (mysqli_num_rows($sql)=='0'){
	_alert("Nota Jual sudah dihapus. Proses dibatalkan.");
	_direct("?page=canvass_keluar&mode=konfirm_jual");
	break;
}
if (isset($buat_canvass_siap_kirim_post)){
	$sql=mysqli_query($con, "SELECT * FROM jual_detail WHERE id_jual_detail=$id_jual_detail");
	if (mysqli_num_rows($sql)=='0'){
		_alert("Barang sudah dihapus. Proses dibatalkan.");
		_direct("?page=canvass_keluar&mode=konfirm_jual_2&id=$id");
		break;
	}
	$sql=mysqli_query($con, "SELECT *
FROM
    jual_detail
    INNER JOIN harga_jual 
        ON (jual_detail.id_harga_jual = harga_jual.id_harga_jual)
    INNER JOIN barang_supplier 
        ON (harga_jual.id_barang_supplier = barang_supplier.id_barang_supplier)
    INNER JOIN barang 
        ON (barang_supplier.id_barang = barang.id_barang)
 WHERE id_jual_detail=$id_jual_detail AND barang.status=0");
	if (mysqli_num_rows($sql)>0){
		_alert("Input gagal karena barang sudah tidak aktif.");
		_direct("?page=canvass_keluar&mode=konfirm_jual_2&id=$id");
		break;
	}
	$tgl = explode("/", $expire);
	$expire = $tgl[2] ."-". $tgl[1] ."-". $tgl[0];
	$sql2=mysqli_query($con, "INSERT INTO canvass_siap_kirim VALUES(null,$id_canvass_keluar,'$tanggal',$id,'0',$id_karyawan)");
	$sql2=mysqli_query($con, "SELECT * FROM canvass_siap_kirim WHERE id_jual=$id");
	$row=mysqli_fetch_array($sql2);
	$id_canvass_siap_kirim=$row['id_canvass_siap_kirim'];
	
	$sql2=mysqli_query($con, "SELECT *
FROM
    canvass_keluar
    INNER JOIN canvass_keluar_barang 
        ON (canvass_keluar.id_canvass_keluar = canvass_keluar_barang.id_canvass_keluar)
	INNER JOIN barang 
        ON (canvass_keluar_barang.id_barang = barang.id_barang)
WHERE canvass_keluar.id_canvass_keluar=$id_canvass_keluar AND barang.id_barang=$id_barang AND barang.status=1 AND expire='$expire'
 AND id_barang_masuk_rak NOT IN (SELECT id_barang_masuk_rak FROM canvass_siap_kirim_detail WHERE id_canvass_siap_kirim=$id_canvass_siap_kirim)
 HAVING SUM(stok)>=$qty_ambil");

		if (mysqli_num_rows($sql2)>0){
			$total_qty_ambil=0;
			$tmp_qty_ambil=$qty_ambil;
			$sql2=mysqli_query($con, "SELECT *
FROM
    canvass_keluar
    INNER JOIN canvass_keluar_barang 
        ON (canvass_keluar.id_canvass_keluar = canvass_keluar_barang.id_canvass_keluar)
	INNER JOIN barang 
        ON (canvass_keluar_barang.id_barang = barang.id_barang)
WHERE canvass_keluar.id_canvass_keluar=$id_canvass_keluar AND barang.id_barang=$id_barang AND barang.status=1 AND expire='$expire' AND stok>0
 AND id_barang_masuk_rak NOT IN (SELECT id_barang_masuk_rak FROM canvass_siap_kirim_detail WHERE id_canvass_siap_kirim=$id_canvass_siap_kirim)");
			while ($row2=mysqli_fetch_array($sql2)){
				$id_barang_masuk_rak=$row2['id_barang_masuk_rak'];
				$stok=$row2['stok'];
				if ($total_qty_ambil==$qty_ambil) break;
				if ($tmp_qty_ambil>=$stok){
					$qty_ambil_=$stok;
					$sql3=mysqli_query($con, "INSERT INTO canvass_siap_kirim_detail VALUES(null,$id_canvass_siap_kirim,$id_jual_detail,$id_barang_masuk_rak,$qty_ambil_,0,'$expire')");
					$total_qty_ambil+=$stok;
					$tmp_qty_ambil-=$stok;
				} else {
					if ($tmp_qty_ambil<$stok){
						$qty_ambil_=$tmp_qty_ambil;
						$sql3=mysqli_query($con, "INSERT INTO canvass_siap_kirim_detail VALUES(null,$id_canvass_siap_kirim,$id_jual_detail,$id_barang_masuk_rak,$qty_ambil_,0,'$expire')");
						$total_qty_ambil+=$tmp_qty_ambil;
						$tmp_qty_ambil-=$stok;
					}
				}
			}
		} else {
			_alert("Input Salah. Silakan input kembali.");
		}
	_direct("?page=canvass_keluar&mode=konfirm_jual_2&id=$id");
}
if (isset($_GET['del'])){
	$sql=mysqli_query($con, "SELECT * FROM canvass_siap_kirim_detail WHERE id_canvass_siap_kirim_detail=" .$_GET['del']. "");
	$row=mysqli_fetch_array($sql);
	$id_jual_detail=$row['id_jual_detail'];
	$sql=mysqli_query($con, "DELETE FROM canvass_siap_kirim_detail WHERE id_jual_detail=$id_jual_detail");
	_direct("?page=canvass_keluar&mode=konfirm_jual_2&id=$id");
}
if (isset($selesai_canvass_siap_kirim_post)){
$sql=mysqli_query($con, "SELECT *,SUM(qty_ambil) AS qty_ambil
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
    INNER JOIN barang 
        ON (barang_supplier.id_barang = barang.id_barang)
    INNER JOIN satuan 
        ON (barang.id_satuan = satuan.id_satuan)
WHERE canvass_siap_kirim.id_jual=$id AND barang.status=0
GROUP BY barang.id_barang");
if (mysqli_num_rows($sql)>0){
	$sql2=mysqli_query($con, "SELECT * FROM jual INNER JOIN pelanggan ON (jual.id_pelanggan = pelanggan.id_pelanggan) WHERE id_jual=$id");
	$row2=mysqli_fetch_array($sql2);
	$id_sales=$row2['id_karyawan'];
	$pelanggan=$row2['nama_pelanggan'];
	$invoice=$row2['invoice'];
	$tanggal=date("Y-m-d H:i:s");
	
	$judul='Ada barang yang tidak disimpan karena non aktif';
	$pesan='Nama Toko : ' .$pelanggan. '\r\nNo Nota Jual : ' .$invoice. '\r\nTipe: Canvass\r\n\r\n';
	
	while ($row=mysqli_fetch_array($sql)){
		$pesan.=$row['nama_barang']. '\r\n\t' .$row['qty_ambil']. ' ' .$row['nama_satuan']. '\r\n' ;
	}
	$sql2=mysqli_query($con, "INSERT INTO pesan VALUES (null,'$tanggal',$id_sales,'$judul','$pesan',0)");
	$sql2=mysqli_query($con, "DELETE FROM canvass_siap_kirim_detail WHERE id_jual_detail=" .$row['id_jual_detail']);
	_alert("Ada barang yang tidak disimpan karena non aktif");
}
	$sql=mysqli_query($con, "SELECT * FROM canvass_siap_kirim INNER JOIN canvass_siap_kirim_detail 
		ON (canvass_siap_kirim.id_canvass_siap_kirim = canvass_siap_kirim_detail.id_canvass_siap_kirim) WHERE id_jual=$id");
	while ($row=mysqli_fetch_array($sql)){
		$sql2=mysqli_query($con, "SELECT * FROM canvass_keluar_barang WHERE id_canvass_keluar=" .$row['id_canvass_keluar']. " AND id_barang_masuk_rak=" .$row['id_barang_masuk_rak']. "");
		$row2=mysqli_fetch_array($sql2);
		$stok=$row2['stok']-$row['qty_ambil'];
		$sql2=mysqli_query($con, "UPDATE canvass_keluar_barang SET stok=$stok WHERE id_canvass_keluar=" .$row['id_canvass_keluar']. " AND id_barang_masuk_rak=" .$row['id_barang_masuk_rak']. "");
	}
	$sql=mysqli_query($con, "UPDATE jual SET status_konfirm=6 WHERE id_jual=$id");
	$sql=mysqli_query($con, "UPDATE canvass_siap_kirim SET status='1' WHERE id_jual=$id");
	_direct("?page=canvass_keluar&mode=konfirm_jual");
}

$sql=mysqli_query($con, "SELECT *
FROM
    canvass_siap_kirim
    INNER JOIN canvass_siap_kirim_detail 
        ON (canvass_siap_kirim.id_canvass_siap_kirim = canvass_siap_kirim_detail.id_canvass_siap_kirim)
WHERE id_jual=$id");
if (mysqli_num_rows($sql)=='0'){
	$sql2=mysqli_query($con, "DELETE FROM canvass_siap_kirim WHERE id_jual=$id");
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
	$barang_expire=false;
	$selesai=false;
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
$sisa_plafon=$plafon-$jumlah_gantung;
($sisa_plafon<0 ? $style="color:red" : $style="");

?>
<div class="right_col loading" role="main">
	<div class="">
	
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<div class="col-md-6">
							<h3>KONFIRMASI NOTA JUAL (CANVASS)</h3>
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
							<tr><td width="40%">Sisa Plafon</td><td style="' .$style. '">Rp. ' .format_uang($sisa_plafon). '</td></tr>';
?>
						</tbody>
						</table>
						<div class="alert alert-info">
						  <strong>Jika ada selisih barang, lalu scan barang kembali, dan input jumlah kekurangannya.</strong><br>
						</div>
						<div class="clearfix"></div>
						<a class="btn btn-danger btn-xs" style="width:10px;height:10px">&nbsp;</a><font color="red">Qty Jual dan Qty Ambil tidak sama</font>
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
									<th>Qty Ambil</th>
									<th>Sub Total Ambil (Rp)</th>
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
$total=0;$total_=0;
	while ($row=mysqli_fetch_array($sql)){
	$sql4=mysqli_query($con, "SELECT SUM(qty_ambil) AS qty_ambil
		FROM
			canvass_siap_kirim
			INNER JOIN canvass_siap_kirim_detail 
				ON (canvass_siap_kirim.id_canvass_siap_kirim = canvass_siap_kirim_detail.id_canvass_siap_kirim)
		WHERE id_jual_detail=" .$row['id_jual_detail']. "");
	$row4=mysqli_fetch_array($sql4);
	$total_ambil=$row4['qty_ambil'];
	($total_ambil!=$row['qty'] ? $color="color:red" : $color="");
	$sql2=mysqli_query($con, "SELECT *, SUM(stok) as stok
FROM
    canvass_belum_siap
    INNER JOIN canvass_keluar_barang 
        ON (canvass_belum_siap.id_canvass_keluar = canvass_keluar_barang.id_canvass_keluar)
WHERE canvass_keluar_barang.id_barang=" .$row['id_barang']. " AND id_jual=" .$row['id_jual']. " AND stok>0");
	$total+=($row['harga']-$row['diskon_rp']-$row['diskon_rp_2']-$row['diskon_rp_3'])*$row['qty'];
	echo '<tr>
				<td style="vertical-align:middle;text-align:center;' .$color. '">' .$row['nama_barang']. '</td>
				<td style="vertical-align:middle;text-align:center;' .$color. '">' .$row['qty']. ' ' .$row['nama_satuan']. '</td>
				<td style="vertical-align:middle;text-align:center;' .$color. '">' .format_uang($row['harga']). '</td>
				<td style="vertical-align:middle;text-align:center;' .$color. '">' .format_uang($row['diskon_rp']). '</td>
				<td style="vertical-align:middle;text-align:center;' .$color. '">' .format_uang($row['diskon_rp_2']). '</td>
				<td style="vertical-align:middle;text-align:center;' .$color. '">' .format_uang($row['diskon_rp_3']). '</td>
				<td style="vertical-align:middle;text-align:center;' .$color. '">' .format_uang(($row['harga']-$row['diskon_rp']-$row['diskon_rp_2']-$row['diskon_rp_3'])*$row['qty']). '</td>';
	while ($row2=mysqli_fetch_array($sql2)){
		$sql3=mysqli_query($con, "SELECT id_canvass_siap_kirim_detail, SUM(qty_ambil) AS qty_ambil
		FROM
			canvass_siap_kirim
			INNER JOIN canvass_siap_kirim_detail 
				ON (canvass_siap_kirim.id_canvass_siap_kirim = canvass_siap_kirim_detail.id_canvass_siap_kirim)
		WHERE id_jual_detail=" .$row['id_jual_detail']. "");
		$row3=mysqli_fetch_array($sql3);
		
		echo '		<td align="center" style="vertical-align:middle;' .$color. '">' .format_angka($row2['stok']). ' ' .$row['nama_satuan']. '</td>';
		
		if ($row3['qty_ambil']==''){
				echo '		<td></td>
							<td></td>
							<td align="center"><a data-toggle="modal" data-target="#myModal" data-barcode="' .$row['barcode']. '" data-id-canvass="' .$row2['id_canvass_keluar']. '" data-stok="' .$row2['stok']. '" data-qty-jual="' .$row['qty']. '" data-harga="' .$row['harga']. '" data-id-bmr="' .$row2['id_barang_masuk_rak']. '" data-id-barang="' .$row2['id_barang']. '" data-satuan="' .$row['nama_satuan']. '" data-tot-ambil="0" data-id-jd="' .$row['id_jual_detail']. '" class="btn btn-primary btn-xs"><i class="fa fa-barcode"></i> Scan</a></td>';
		} else {
			$total_+=($row['harga']-$row['diskon_rp']-$row['diskon_rp_2']-$row['diskon_rp_3'])*$row3['qty_ambil'];
			echo '	<td align="center" style="vertical-align:middle;' .$color. '">' .$row3['qty_ambil']. ' ' .$row['nama_satuan']. '</td>';
			echo '		<td align="center" style="vertical-align:middle;' .$color. '">' .format_uang($row3['qty_ambil']*$row['harga']). '</td>';
			if ($row3['qty_ambil']==$row['qty']){
				echo '	<td align="center"><a href="?page=canvass_keluar&mode=konfirm_jual_2&id=' .$id. '&del=' .$row3['id_canvass_siap_kirim_detail']. '" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Hapus</a></td>';
			} else {
				echo '	<td align="center" style="vertical-align:middle;' .$color. '">
					<a data-toggle="modal" data-target="#myModal" data-barcode="' .$row['barcode']. '" data-id-canvass="' .$row2['id_canvass_keluar']. '" data-stok="' .$row2['stok']. '" data-qty-jual="' .$row['qty']. '" data-harga="' .$row['harga']. '" data-id-bmr="' .$row2['id_barang_masuk_rak']. '" data-id-barang="' .$row2['id_barang']. '" data-satuan="' .$row['nama_satuan']. '" data-tot-ambil="' .$row3['qty_ambil']. '" data-id-jd="' .$row['id_jual_detail']. '" class="btn btn-primary btn-xs"><i class="fa fa-barcode"></i> Scan</a>
					<a href="?page=canvass_keluar&mode=konfirm_jual_2&id=' .$id. '&del=' .$row3['id_canvass_siap_kirim_detail']. '" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Hapus</a>
					</td>';
			}
		}
echo '		</tr>';
	}	
}
echo '<tr>
		<td colspan="3"><b>Total</b></td>
		<td align="center"><b>' .format_uang($total). '</b></td>
		<td colspan="2"></td>
		<td align="center"><b>' .format_uang($total_). '</b></td>
		<td colspan="2"></td>
	</tr>';

?>
							</tbody>
						</table>
						</div>
						<form method="post">
							<input type="hidden" name="selesai_canvass_siap_kirim_post" value="true">
							<?php
							$sql=mysqli_query($con, "SELECT *
FROM
    jual_detail
    LEFT JOIN canvass_siap_kirim_detail 
        ON (jual_detail.id_jual_detail = canvass_siap_kirim_detail.id_jual_detail)
    INNER JOIN harga_jual 
        ON (jual_detail.id_harga_jual = harga_jual.id_harga_jual)
    INNER JOIN barang_supplier 
        ON (harga_jual.id_barang_supplier = barang_supplier.id_barang_supplier)
    INNER JOIN barang 
        ON (barang_supplier.id_barang = barang.id_barang) WHERE id_jual=$id AND barang.status=1 AND jual_detail.id_jual_detail NOT IN 
		(SELECT id_jual_detail FROM canvass_siap_kirim_detail)");
							(mysqli_num_rows($sql)>0 ? $selesai=false : $selesai=true);
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
					<input type="hidden" name="buat_canvass_siap_kirim_post" value="true">
					<input type="hidden" id="id_jual" name="id_jual" value="<?php echo $id ?>">
					<input type="hidden" id="id_jual_detail" name="id_jual_detail" value="">
					<input type="hidden" id="id_canvass_keluar" name="id_canvass_keluar" value="">
					<input type="hidden" id="id_barang" name="id_barang" value="">
					<input type="hidden" id="id_barang_masuk_rak" name="id_barang_masuk_rak" value="">
					<input type="hidden" id="barcode_barang" value="">
					<div class="text-center" style="margin-bottom:10px"><a id="scan_barang" class="btn btn-primary" onClick="AndroidFunction.scan_barang();">Scan Barang</a></div>
					<div class="form-group col-sm-12">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-book fa-fw"></i> Qty Jual</span>
							<input class="form-control" id="qty_jual" placeholder="Qty Jual" value="" readonly>
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
							<span class="input-group-addon"><i class="fa fa-book fa-fw"></i> Total Qty Ambil</span>
							<input class="form-control" id="tot_qty_ambil" name="tot_qty_ambil" placeholder="Total Qty Ambil" value="" readonly>
							<span class="input-group-addon satuan"></span>
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
		$('#dummy').load('assets/page/canvass_keluar/konfirm_jual_del.php?id=<?php echo $id ?>', function(){
			window.location='index.php?page=canvass_keluar&mode=konfirm_jual';
		});
	}
}
function cek_valid(){
	var tot_qty_ambil = Number($('#tot_qty_ambil').val());
	var qty_ambil = Number($('#qty_ambil').val());
	var stok = Number($('#stok').val());
	if (qty_ambil == '0') {
		AndroidFunction.showToast("Qty Ambil harus lebih dari 0.");
		return false;
	} else if ((qty_ambil + tot_qty_ambil) > stok){
		AndroidFunction.showToast(" Total Qty Ambil tidak boleh melebihi stok.");
		return false;
	}
	return true;
}

function cek_scan_barang(barcode1){
	var barcode2 = $('#barcode_barang').val();
	if (barcode1 == barcode2){
		$('#scan_barang').attr("style","display:none");
		$('#qty_ambil').removeAttr("disabled");
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
	$('#stok').inputmask('decimal', {allowMinus: false, autoGroup: true, groupSeparator: '.', rightAlign: false, removeMaskOnSubmit: true});
	$('#qty_ambil').inputmask('numeric', {allowMinus: false, autoGroup: true, groupSeparator: '.', rightAlign: false, removeMaskOnSubmit: true});
	$('#myModal').on('show.bs.modal', function(e){
		var tot_ambil = $(e.relatedTarget).data('tot-ambil');
		var qty_jual = $(e.relatedTarget).data('qty-jual');
		var stok = $(e.relatedTarget).data('stok');
		var satuan = $(e.relatedTarget).data('satuan');
		var id_canvass = $(e.relatedTarget).data('id-canvass');
		var id_jual_detail = $(e.relatedTarget).data('id-jd');
		var id_bmr = $(e.relatedTarget).data('id-bmr');
		var id_barang = $(e.relatedTarget).data('id-barang');
		var barcode_barang = $(e.relatedTarget).data('barcode');
		$('#tot_qty_ambil').val(tot_ambil);
		$('#qty_jual').val(qty_jual);
		$('#stok').val(stok);
		$('#qty_ambil').val("");
		$('#id_jual_detail').val(id_jual_detail);
		$('#id_barang').val(id_barang);
		$('#id_barang_masuk_rak').val(id_bmr);
		$('#id_canvass_keluar').val(id_canvass);
		$('#barcode_barang').val(barcode_barang);
		$('.satuan').html(satuan);
		$('#scan_barang').attr("style","");
		$('#qty_ambil').attr("disabled","disabled");
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
