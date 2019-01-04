<?php
$id_karyawan=$_SESSION['id_karyawan'];
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
			canvass_siap_kirim
			INNER JOIN canvass_siap_kirim_detail 
				ON (canvass_siap_kirim.id_canvass_siap_kirim = canvass_siap_kirim_detail.id_canvass_siap_kirim)
		WHERE id_jual_detail=" .$row['id_jual_detail']. "");
	$row4=mysql_fetch_array($sql4);
	$total_ambil=$row4['qty_ambil'];
	($total_ambil!=$row['qty'] ? $color="color:red" : $color="");
	$sql2=mysql_query("SELECT *, SUM(stok) as stok
FROM
    canvass_belum_siap
    INNER JOIN canvass_keluar_barang 
        ON (canvass_belum_siap.id_canvass_keluar = canvass_keluar_barang.id_canvass_keluar)
WHERE canvass_keluar_barang.id_barang=" .$row['id_barang']. " AND id_jual=" .$row['id_jual']. " AND stok>0");
	$total+=$row['harga']*$row['qty'];
	echo '<tr>
				<td style="vertical-align:middle;text-align:center;' .$color. '">' .$row['nama_barang']. '</td>
				<td style="vertical-align:middle;text-align:center;' .$color. '">' .$row['qty']. ' ' .$row['nama_satuan']. '</td>
				<td style="vertical-align:middle;text-align:center;' .$color. '">' .format_uang($row['harga']). '</td>
				<td style="vertical-align:middle;text-align:center;' .$color. '">' .format_uang($row['diskon_rp']). '</td>
				<td style="vertical-align:middle;text-align:center;' .$color. '">' .format_uang($row['diskon_rp_2']). '</td>
				<td style="vertical-align:middle;text-align:center;' .$color. '">' .format_uang($row['diskon_rp_3']). '</td>
				<td style="vertical-align:middle;text-align:center;' .$color. '">' .format_uang(($row['harga']-$row['diskon_rp']-$row['diskon_rp_2']-$row['diskon_rp_3'])*$row['qty']). '</td>';
	while ($row2=mysql_fetch_array($sql2)){
		$sql3=mysql_query("SELECT id_canvass_siap_kirim_detail, SUM(qty_ambil) AS qty_ambil
		FROM
			canvass_siap_kirim
			INNER JOIN canvass_siap_kirim_detail 
				ON (canvass_siap_kirim.id_canvass_siap_kirim = canvass_siap_kirim_detail.id_canvass_siap_kirim)
		WHERE id_jual_detail=" .$row['id_jual_detail']. "");
		$row3=mysql_fetch_array($sql3);
		
		echo '		<td align="center" style="' .$color. '">' .format_angka($row2['stok']). ' ' .$row['nama_satuan']. '</td>';
		
		if ($row3['qty_ambil']==''){
				echo '		<td></td>
							<td></td>';
		} else {
			$selesai=true;
			$total_+=($row['harga']-$row['diskon_rp']-$row['diskon_rp_2']-$row['diskon_rp_3'])*$row3['qty_ambil'];
			echo '	<td align="center" style="' .$color. '">' .$row3['qty_ambil']. ' ' .$row['nama_satuan']. '</td>';
			echo '	<td align="center" style="' .$color. '">' .format_uang($row3['qty_ambil']*($row['harga']-$row['diskon_rp']-$row['diskon_rp_2']-$row['diskon_rp_3'])). '</td>';
		}
echo '		</tr>';
	}	
}
echo '<tr>
		<td colspan="4"><b>Total</b></td>
		<td align="center"><b>' .format_uang($total). '</b></td>
		<td colspan="2"></td>
		<td align="center"><b>' .format_uang($total_). '</b></td>
	</tr>';

?>
							</tbody>
						</table>
						</div>
					</div>
				</div>
			<div id="dummy"></div>
			</div>
		</div>	
	</div>
</div>

<script>
function getBack(){
	window.location='index.php?page=canvass_keluar&mode=konfirm_jual';
}
$(document).ready(function(){
	
})
</script>
