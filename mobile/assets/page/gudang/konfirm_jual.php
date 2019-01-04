<?php
if (isset($batal_cek_barang_post)){
	foreach ($id_nota_siap_kirim as $key => $value) {
		$sql = "UPDATE nota_siap_kirim SET status='0' WHERE id_nota_siap_kirim=$value";
		$q = mysql_query($sql);
		$sql=mysql_query("SELECT id_jual FROM nota_siap_kirim WHERE id_nota_siap_kirim=$value");
		$row=mysql_fetch_array($sql);
		$sql = mysql_query("UPDATE jual SET status_konfirm=0 WHERE id_jual=" .$row['id_jual']);
		$sql=mysql_query("SELECT qty_ambil,id_barang_masuk_rak FROM nota_siap_kirim_detail WHERE id_nota_siap_kirim=$value");
		while($row=mysql_fetch_array($sql)){
			$qty_ambil=$row['qty_ambil'];
			$id_barang_masuk_rak=$row['id_barang_masuk_rak'];
			$sql2=mysql_query("SELECT stok FROM barang_masuk_rak WHERE id_barang_masuk_rak=$id_barang_masuk_rak");
			$row2=mysql_fetch_array($sql2);
			$stok=$row2['stok']+$qty_ambil;
			if ($stok<0){
				tulis_log(date('d-m-Y H:i'). ' Stok minus batal cek barang konfirm_jual id_jual=' .$row['id_jual']);
				tulis_log('stok=' .$row2['stok']. ' qty_ambil=' .$qty_ambil);
				tulis_log("UPDATE barang_masuk_rak SET stok=" .$stok. " WHERE id_barang_masuk_rak=" .$id_barang_masuk_rak);
			}
			$sql2=mysql_query("UPDATE barang_masuk_rak SET stok=$stok WHERE id_barang_masuk_rak=$id_barang_masuk_rak");
		}
	}
	_direct("?page=gudang&mode=konfirm_jual");
}
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
				
						<div class="" role="tabpanel">
						  <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
							<li role="presentation" class="active"><a href="#tab_content1" id="tab1" role="tab" data-toggle="tab" aria-expanded="true">Nota Jual</a>
							</li>
							<li role="presentation" class=""><a href="#tab_content2" role="tab" id="tab2" data-toggle="tab" aria-expanded="false">Pemeriksaan Nota Jual</a>
							</li>
						  </ul>
						  <div id="myTabContent" class="tab-content">
							<div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="tab1">
							<a class="btn btn-danger btn-xs" style="width:10px;height:10px">&nbsp;</a><font color="red">Sisa Plafon < Jumlah Jual</font>
								<div class="table-responsive">
								<table id="table_belum_siap" class="table table-bordered table-striped">
									<thead>
										<tr>
											<th>Tgl Nota Jual</th>
											<th>No Nota Jual</th>
											<th>Nama Sales</th>
											<th>Nama Pelanggan</th>
											<th>Jenis Bayar</th>
											<th>Tenor</th>
											<th>Jml Nota Gantung (Rp)</th>
											<th>Plafon (Rp)</th>
											<th>Sisa Plafon (Rp)</th>
											<th>Jumlah Jual (Rp)</th>
										</tr>
									</thead>
									<tbody>
<?php
	$sql=mysql_query("SELECT *
FROM
    jual
    INNER JOIN pelanggan 
        ON (jual.id_pelanggan = pelanggan.id_pelanggan)
    INNER JOIN karyawan 
        ON (jual.id_karyawan = karyawan.id_karyawan) WHERE id_jual NOT IN (SELECT id_jual FROM nota_siap_kirim
WHERE status='1') AND status_konfirm=0
ORDER BY id_jual DESC");
	while ($row=mysql_fetch_array($sql)){
		if ($row['jenis_bayar']=='Lunas'){
				$sql2=mysql_query("SELECT SUM(qty*(harga_jual-diskon_rp-diskon_rp_2-diskon_rp_3)) AS total_harga
			FROM
				jual_detail
				INNER JOIN harga_jual 
					ON (jual_detail.id_harga_jual = harga_jual.id_harga_jual)
				INNER JOIN barang_supplier 
					ON (harga_jual.id_barang_supplier = barang_supplier.id_barang_supplier)
				INNER JOIN barang 
					ON (barang_supplier.id_barang = barang.id_barang)
			WHERE id_jual=" .$row['id_jual']. " AND barang.status=1");
		} else {
			$sql2=mysql_query("SELECT SUM(qty*(harga_kredit-diskon_rp-diskon_rp_2-diskon_rp_3)) AS total_harga
			FROM
				jual_detail
				INNER JOIN harga_jual 
					ON (jual_detail.id_harga_jual = harga_jual.id_harga_jual)
				INNER JOIN harga_jual_kredit 
					ON (harga_jual.id_harga_jual = harga_jual_kredit.id_harga_jual)
				INNER JOIN barang_supplier 
					ON (harga_jual.id_barang_supplier = barang_supplier.id_barang_supplier)
				INNER JOIN barang 
					ON (barang_supplier.id_barang = barang.id_barang)
			WHERE id_jual=" .$row['id_jual']. " AND barang.status=1");
		}
		$r=mysql_fetch_array($sql2);
		$sql3=mysql_query("SELECT SUM(qty*(harga-diskon_rp-diskon_rp_2-diskon_rp_3)) AS jumlah_nota
FROM
    jual
    INNER JOIN jual_detail 
        ON (jual.id_jual = jual_detail.id_jual)
	INNER JOIN harga_jual 
		ON (jual_detail.id_harga_jual = harga_jual.id_harga_jual)
	INNER JOIN barang_supplier 
		ON (harga_jual.id_barang_supplier = barang_supplier.id_barang_supplier)
	INNER JOIN barang 
		ON (barang_supplier.id_barang = barang.id_barang)
WHERE jual.id_pelanggan=" .$row['id_pelanggan']. " AND barang.status=1");
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
$sql4=mysql_query("SELECT * FROM jual WHERE invoice NOT IN (SELECT no_nota_jual FROM bayar_nota_jual WHERE STATUS=1) AND id_pelanggan=" .$row['id_pelanggan']);
$jml_nota=format_angka(mysql_num_rows($sql4));
(($row['plafon']-$jumlah_gantung) < $r['total_harga'] ? $style="color:red" : $style="");
		echo '<tr>
				<td align="center"><a style="' .$style. '" href="?page=gudang&mode=konfirm_jual_2&id=' .$row['id_jual']. '"><div style="min-width:70px">' .date("d-m-Y",strtotime($row['tgl_nota'])). '</div></a></td>
				<td align="center"><a style="' .$style. '" href="?page=gudang&mode=konfirm_jual_2&id=' .$row['id_jual']. '"><div style="min-width:70px">' .$row['invoice']. '</div></a></td>
				<td align="center"><a style="' .$style. '" href="?page=gudang&mode=konfirm_jual_2&id=' .$row['id_jual']. '"><div style="min-width:70px">' .$row['nama_karyawan']. '</div></a></td>
				<td align="center"><a style="' .$style. '" href="?page=gudang&mode=konfirm_jual_2&id=' .$row['id_jual']. '"><div style="min-width:70px">' .$row['nama_pelanggan']. '</div></a></td>
				<td align="center"><a style="' .$style. '" href="?page=gudang&mode=konfirm_jual_2&id=' .$row['id_jual']. '"><div style="min-width:70px">' .$row['jenis_bayar']. '</div></a></td>
				<td align="center"><a style="' .$style. '" href="?page=gudang&mode=konfirm_jual_2&id=' .$row['id_jual']. '"><div style="min-width:70px">' .$row['tenor']. ' hari</div></a></td>
				<td align="center"><a style="' .$style. '" href="?page=gudang&mode=konfirm_jual_2&id=' .$row['id_jual']. '"><div style="min-width:70px">' .format_uang($jumlah_gantung). '<br/> (' .$jml_nota. ' nota)</div></a></td>
				<td align="center"><a style="' .$style. '" href="?page=gudang&mode=konfirm_jual_2&id=' .$row['id_jual']. '"><div style="min-width:70px">' .format_uang($row['plafon']). '</div></a></td>
				<td align="center"><a style="' .$style. '" href="?page=gudang&mode=konfirm_jual_2&id=' .$row['id_jual']. '"><div style="min-width:70px">' .format_uang($row['plafon']-$jumlah_gantung). '</div></a></td>
				<td align="center"><a style="' .$style. '" href="?page=gudang&mode=konfirm_jual_2&id=' .$row['id_jual']. '"><div style="min-width:70px">' .format_uang($r['total_harga']). '</div></a></td>
			</tr>';
	}
?>
									</tbody>
								</table>
								</div>
							</div>
							<div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="tab2">
							<div class="col-xs-12" style="text-align:right">
								<input type="text" id="datepicker" PlaceHolder="Bulan & Tahun" style="width:100px" readonly></input>
								<input type="button" id="cari" onClick="cari()" value="Cari"></input>
								<input type="button" id="reset" onClick="reset()" value="Reset"></input>
							</div>
							<form method="post" onsubmit="return cek_valid()">
			  <input type="hidden" name="batal_cek_barang_post" value="true">
			  <?php
			  (isset($_GET['cari']) ? $batal="disabled" : $batal=""); 
			  ?>
			  <center><input class="btn btn-primary" type="submit" value="Batalkan Periksa Barang" <?php echo $batal ?> ></center><br/>
								<a class="btn btn-danger btn-xs" style="width:10px;height:10px">&nbsp;</a><font color="red">Sisa Plafon < Jumlah Jual</font>
							  <div class="table-responsive">
							  <table id="table_belum_cek" class="table table-bordered table-striped">
									<thead>
										<tr>
											<th>Pilih</th>
											<th>Tgl Nota Jual</th>
											<th>No Nota Jual</th>
											<th>Nama Pelanggan</th>
											<th>Jenis Bayar</th>
											<th>Tenor</th>
											<th>Jml Nota Gantung (Rp)</th>
											<th>Plafon (Rp)</th>
											<th>Sisa Plafon (Rp)</th>
											<th>Jumlah Jual (Rp)</th>
											<th>Nama Sales</th>
											<th>Disiapkan Oleh</th>
											<th>Diperiksa Oleh</th>
											<th>Status</th>
										</tr>
									</thead>
									<tbody>
<?php
if (isset($_GET['cari'])){
	$tgl = explode("-", $_GET['cari']);
	$bln = $tgl[0];	$thn = $tgl[1];
	$val="MONTH(tgl_nota)=$bln AND YEAR(tgl_nota)=$thn";
} else {
	$val="nota_siap_kirim.id_jual NOT IN (SELECT id_jual FROM nota_sudah_cek WHERE status='1' or status='2' or status='3') AND nota_siap_kirim.status='1'";
}

	$sql=mysql_query("SELECT *
FROM
    jual
    INNER JOIN nota_siap_kirim 
        ON (jual.id_jual = nota_siap_kirim.id_jual)
    INNER JOIN pelanggan 
        ON (jual.id_pelanggan = pelanggan.id_pelanggan)
    INNER JOIN karyawan 
        ON (jual.id_karyawan = karyawan.id_karyawan)
    INNER JOIN nota_siap_kirim_detail 
        ON (nota_siap_kirim.id_nota_siap_kirim = nota_siap_kirim_detail.id_nota_siap_kirim)
    INNER JOIN jual_detail 
        ON (nota_siap_kirim_detail.id_jual_detail = jual_detail.id_jual_detail)
WHERE $val
GROUP BY jual.id_jual
ORDER BY jual.id_jual DESC");
	while ($row=mysql_fetch_array($sql)){
	$sql6=mysql_query("SELECT SUM(qty_ambil*(harga-diskon_rp-diskon_rp_2-diskon_rp_3)) as total_harga
FROM
    jual
    INNER JOIN nota_siap_kirim 
        ON (jual.id_jual = nota_siap_kirim.id_jual)
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
WHERE jual.id_jual=" .$row['id_jual']. " AND barang.status=1");
$row6=mysql_fetch_array($sql6);
$total_harga=$row6['total_harga'];
		if ($row['id_jual']!=''){
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
	$sql4=mysql_query("SELECT * FROM jual WHERE invoice NOT IN (SELECT no_nota_jual FROM bayar_nota_jual WHERE STATUS=1) AND id_pelanggan=" .$row['id_pelanggan']);
	$jml_nota=format_angka(mysql_num_rows($sql4));
	(($row['plafon']-$jumlah_gantung) < $total_harga ? $style="color:red" : $style="");
	$sql4=mysql_query("SELECT nama_karyawan as nama_siap FROM nota_siap_kirim INNER JOIN karyawan ON (nota_siap_kirim.id_karyawan=karyawan.id_karyawan)");
	$row4=mysql_fetch_array($sql4);
	$sql5=mysql_query("SELECT nama_karyawan as nama_pemeriksa, nota_sudah_cek.status FROM nota_sudah_cek INNER JOIN karyawan ON (nota_sudah_cek.id_karyawan=karyawan.id_karyawan) WHERE id_jual=" .$row['id_jual']);
	$row5=mysql_fetch_array($sql5);
	$status='';
	if ($row5['status']=='1') $status='SUDAH DIPERIKSA';
	if ($row5['status']=='2') $status='SUDAH DICETAK';
	if ($row5['status']=='3') $status='SUDAH DIKIRIM';
		echo '<tr>
				<td align="center"><input style="width: 20px; height: 20px;" type="checkbox" id="id_nota_siap_kirim" name="id_nota_siap_kirim[]" value="' .$row['id_nota_siap_kirim']. '"></td>
				<td align="center"><a style="' .$style. '" href="?page=gudang&mode=konfirm_jual_3&id=' .$row['id_jual']. '"><div style="min-width:70px">' .date("d-m-Y",strtotime($row['tgl_nota'])). '</div></a></td>
				<td align="center"><a style="' .$style. '" href="?page=gudang&mode=konfirm_jual_3&id=' .$row['id_jual']. '"><div style="min-width:70px">' .$row['invoice']. '</div></a></td>
				<td align="center"><a style="' .$style. '" href="?page=gudang&mode=konfirm_jual_3&id=' .$row['id_jual']. '"><div style="min-width:70px">' .$row['nama_pelanggan']. '</div></a></td>
				<td align="center"><a style="' .$style. '" href="?page=gudang&mode=konfirm_jual_3&id=' .$row['id_jual']. '"><div style="min-width:70px">' .$row['jenis_bayar']. '</div></a></td>
				<td align="center"><a style="' .$style. '" href="?page=gudang&mode=konfirm_jual_3&id=' .$row['id_jual']. '"><div style="min-width:70px">' .$row['tenor']. ' hari</div></a></td>
				<td align="center"><a style="' .$style. '" href="?page=gudang&mode=konfirm_jual_3&id=' .$row['id_jual']. '"><div style="min-width:70px">' .format_uang($jumlah_gantung). '<br/> (' .$jml_nota. ' nota)</div></a></td>
				<td align="center"><a style="' .$style. '" href="?page=gudang&mode=konfirm_jual_3&id=' .$row['id_jual']. '"><div style="min-width:70px">' .format_uang($row['plafon']). '</div></a></td>
				<td align="center"><a style="' .$style. '" href="?page=gudang&mode=konfirm_jual_3&id=' .$row['id_jual']. '"><div style="min-width:70px">' .format_uang($row['plafon']-$jumlah_gantung). '</div></a></td>
				<td align="center"><a style="' .$style. '" href="?page=gudang&mode=konfirm_jual_3&id=' .$row['id_jual']. '"><div style="min-width:70px">' .format_uang($total_harga). '</div></a></td>
				<td align="center"><a style="' .$style. '" href="?page=gudang&mode=konfirm_jual_3&id=' .$row['id_jual']. '"><div style="min-width:70px">' .$row['nama_karyawan']. '</div></a></td>
				<td align="center"><a style="' .$style. '" href="?page=gudang&mode=konfirm_jual_3&id=' .$row['id_jual']. '"><div style="min-width:70px">' .$row4['nama_siap']. '</div></a></td>
				<td align="center"><a style="' .$style. '" href="?page=gudang&mode=konfirm_jual_3&id=' .$row['id_jual']. '"><div style="min-width:70px">' .$row5['nama_pemeriksa']. '</div></a></td>
				<td align="center"><a style="' .$style. '" href="?page=gudang&mode=konfirm_jual_3&id=' .$row['id_jual']. '"><div style="min-width:70px">' .$status. '</div></a></td>
			</tr>';
		}
	}
?>										
									</tbody>
								</table>
								</div>
								</form>
							</div>
						  </div>
						</div>
			
					</div>
				</div>
			<div id="dummy"></div>
			</div>
			</div>
		</div>	
	</div>
</div>

<script>
function getBack(){
	AndroidFunction.closeApp();
}
function cari(){
	var tanggal = $('#datepicker').val();
	var url = "?page=gudang&mode=konfirm_jual&cari=" + tanggal;
	if (tanggal!='') window.location=url;
}
function reset(){
	var url = "?page=gudang&mode=konfirm_jual&reset";
	window.location=url;
}
function cek_valid(){
	var len = $('#table_belum_cek').find("input:checkbox:checked").length;
	if (len == 0){
		alert("Belum pilih nota.");
		return false;
	} else {
		return true;
	}
}

$(document).ready(function(){
	$('#datepicker').datepicker({
		orientation: "bottom auto",
		format: "mm-yyyy",
		startView: 1,
		minViewMode: 1,
		autoclose: true
	});
	<?php if (isset($_GET['cari']) or isset($_GET['reset'])) echo "$('#tab2').click();"; ?>
})
</script>
