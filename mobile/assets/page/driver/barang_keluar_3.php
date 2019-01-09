<?php
$id_karyawan=$_SESSION['id_karyawan'];
if (isset($_GET['del'])){
	$sql = mysqli_query($con, "SELECT * FROM nota_sudah_cek WHERE id_jual=" .$_GET['del']);
	$row=mysqli_fetch_array($sql);
	$jumlah=$row['jumlah'];
	$tanggal=date("Y-m-d");
	$sql = mysqli_query($con, "INSERT INTO batal_kirim VALUES(null,$id_karyawan," .$_GET['del']. ",$jumlah,0,'$tanggal')");
	$sql = mysqli_query($con, "SELECT * FROM batal_kirim WHERE id_jual=" .$_GET['del']. "");
	$row=mysqli_fetch_array($sql);
	$id_batal_kirim=$row['id_batal_kirim'];
	$sql=mysqli_query($con, "SELECT *
FROM
    nota_siap_kirim
    INNER JOIN nota_siap_kirim_detail 
        ON (nota_siap_kirim.id_nota_siap_kirim = nota_siap_kirim_detail.id_nota_siap_kirim)
WHERE id_jual=" .$_GET['del']);
	while ($row=mysqli_fetch_array($sql)){
		$sql2 = mysqli_query($con, "INSERT INTO batal_kirim_detail VALUES(null,$id_batal_kirim," .$row['id_jual_detail']. "," .$row['id_barang_masuk_rak']. "," .$row['qty_ambil']. ",'" .$row['expire']. "',null,null,null)");
	}
	_direct("?page=driver&mode=barang_keluar");
}
if (isset($simpan_nota_sudah_cek_post)){
	if ($berat_volume=='berat') {$berat=$val_berat_volume;$volume="null";}
	if ($berat_volume=='volume') {$berat="null";$volume=$val_berat_volume;}
	$sql = mysqli_query($con, "UPDATE nota_sudah_cek SET status='3' WHERE id_nota_sudah_cek=$id");
	$sql = mysqli_query($con, "SELECT id_jual FROM nota_sudah_cek WHERE id_nota_sudah_cek=$id");
	$row=mysqli_fetch_array($sql);
	$sql = mysqli_query($con, "SELECT id_jual FROM pengiriman WHERE id_jual=" .$row['id_jual']);
	if (mysqli_num_rows($sql)>0){
		$sql2 = mysqli_query($con, "UPDATE pengiriman SET status=1,jenis='DALAM KOTA',tanggal_kirim='$tanggal',id_karyawan=$id_karyawan,id_ekspedisi=$id_ekspedisi,berat=$berat,volume=$volume,tarif=$tarif WHERE id_jual=" .$row['id_jual']. "");
	} else {
		$sql2 = mysqli_query($con, "INSERT INTO pengiriman VALUES(null, " .$row['id_jual']. ", 1, '$tanggal',$id_karyawan,$id_ekspedisi,$berat,$volume,$tarif,'DALAM KOTA')");
	}
	
	$sql=mysqli_query($con, "SELECT * FROM checkin WHERE tanggal='$tanggal' AND id_pelanggan='$id_pelanggan' AND id_karyawan=$id_karyawan");
	$c=mysqli_num_rows($sql);
	$row=mysqli_fetch_array($sql);
	$id_checkin=$row['id_checkin'];
	if ($c==0){
		$sql=mysqli_query($con, "INSERT INTO checkin VALUES(null,'$tanggal','$jam','$barcode',$id_pelanggan,$id_karyawan,'$lokasi_gps','$lokasi_kota',$akurasi,'$mock',$distance)");
	} else {
		$sql=mysqli_query($con, "UPDATE checkin SET gps='$lokasi_gps',kota='$lokasi_kota',akurasi=$akurasi,mock='$mock',distance=$distance WHERE id_checkin=$id_checkin");
	}
	if ($sql){
		_buat_pesan("Input Berhasil","green");
	} else {
		_buat_pesan("Input Gagal","red");
	}
	_direct("?page=driver&mode=barang_keluar");
}
$selesai=false;
?>
<div class="right_col" role="main">
	<div class="">
	
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<h3>KIRIM BARANG</h3>
						<?php
							if (isset($pesan)){
								echo '<span class="badge bg-' .$warna. '">' .$pesan. '</span>';
							}
						?>
					<div class="clearfix"></div>
					</div>
					<div class="x_content">
					<form method="post">
				<div id="table_info" class="table responsive">
					<table class="table table-bordered table-striped">
						<tbody>
<?php
	$sql=mysqli_query($con, "SELECT id_jual FROM nota_sudah_cek WHERE id_nota_sudah_cek=$id");
	$row=mysqli_fetch_array($sql);
	$id_jual=$row['id_jual'];
	$sql2=mysqli_query($con, "SELECT
    jual.id_jual
	, jual.tgl_nota
    , jual.invoice
	, pelanggan.id_pelanggan
	, pelanggan.barcode
	, pelanggan.nama_pelanggan
	, karyawan.nama_karyawan
FROM
    jual
    INNER JOIN pelanggan 
        ON (jual.id_pelanggan = pelanggan.id_pelanggan)
	INNER JOIN karyawan 
        ON (jual.id_karyawan = karyawan.id_karyawan)
WHERE jual.id_jual=" .$id_jual. "
GROUP BY jual.id_jual");
$row=mysqli_fetch_array($sql2);
echo '<tr><td width="30%">Tgl. Nota Jual</td><td>' .date("d-m-Y", strtotime($row['tgl_nota'])). '</td></tr>
		<tr><td width="30%">Nama Sales</td><td>' .$row['nama_karyawan']. '</td></th>
		<tr><td width="30%">No Nota Jual</td><td>' .$row['invoice']. '</td></tr>
		<tr><td width="30%">Pelanggan</td><td>' .$row['nama_pelanggan']. '</td></tr>';
?>
					<tr><td>Ekspedisi</td>
					<td><select class="select2 form-control" id="select_ekspedisi" name="id_ekspedisi" required>
						<option value="" disabled selected>Pilih Ekspedisi</option>
							<?php 
								$brg=mysqli_query($con, "SELECT * FROM ekspedisi");
								while($b=mysqli_fetch_array($brg)){
							?>	
						<option value="<?php echo $b['id_ekspedisi']; ?>"><?php echo $b['nama_ekspedisi'];?></option>
							<?php 
								}
							?>
					</select></td></tr>
					<tr><td>Pilih Tipe</td>
					<td><select class="form-control" name="berat_volume" required>
						<option value="berat" selected>BERAT (GRAM)</option>
						<option value="volume">VOLUME (CM3)</option>
					</select></td></tr>
					<tr><td>Berat/Volume</td>
					<td><input class="form-control" type="tel" id="berat" name="val_berat_volume" placeholder="Berat/Volume" value="" required></td></tr>
					<tr><td>Tarif (Rp)</td>
					<td><input class="form-control" type="tel" id="tarif" name="tarif" placeholder="Tarif" value="" required></td></tr>
				</tbody>
			</table>
			</div>
			<div id="scan_toko">
				<input type="hidden" name="simpan_nota_sudah_cek_post" value="true">
				<input type="hidden" name="lokasi_gps" id="lokasi_gps" value="">
				<input type="hidden" name="lokasi_kota" id="lokasi_kota" value="">
				<input type="hidden" name="akurasi" id="akurasi" value="">
				<input type="hidden" name="mock" id="mock" value="">
				<input type="hidden" name="distance" id="distance" value="">
				<input type="hidden" name="id_pelanggan" id="id_pelanggan" value="<?php echo $row['id_pelanggan'] ?>">	
				<input type="hidden" name="barcode" id="barcode_toko" value="<?php echo $row['barcode'] ?>">
			</div>
			
			<div id="table_content">
			<table class="table table-bordered table-striped" style="margin-top:10px">
				<thead>
					<tr>
						<th>Nama Barang</th>
						<th>Qty</th>
						<th>Harga (Rp)</th>
						<th>Diskon 1 (Rp)</th>
						<th>Diskon 2 (Rp)</th>
						<th>Diskon 3 (Rp)</th>
						<th>Sub Total (Rp)</th>
					</tr>
				</thead>
				<tbody>
				<?php
				$sql=mysqli_query($con, "SELECT nama_barang, nama_satuan, SUM(qty_ambil) AS jumlah, harga, diskon_rp, diskon_rp_2, diskon_rp_3
FROM
    jual_detail
    INNER JOIN harga_jual 
        ON (jual_detail.id_harga_jual = harga_jual.id_harga_jual)
    INNER JOIN nota_siap_kirim_detail 
        ON (jual_detail.id_jual_detail = nota_siap_kirim_detail.id_jual_detail)
    INNER JOIN barang_supplier 
        ON (harga_jual.id_barang_supplier = barang_supplier.id_barang_supplier)
    INNER JOIN barang 
        ON (barang_supplier.id_barang = barang.id_barang)
    INNER JOIN satuan 
        ON (barang.id_satuan = satuan.id_satuan)
 WHERE id_jual=$id_jual
 GROUP BY jual_detail.id_jual_detail");
				$total=0;
				while ($row=mysqli_fetch_array($sql)){
					$total+=($row['harga']-$row['diskon_rp']-$row['diskon_rp_2']-$row['diskon_rp_3'])*$row['jumlah'];
					echo '<tr>
							<td>' .$row['nama_barang']. '</td>
							<td>' .$row['jumlah']. ' ' .$row['nama_satuan']. '</td>
							<td align="right">Rp. ' .format_uang($row['harga']). '</td>
							<td align="right">Rp. ' .format_uang($row['diskon_rp']). '</td>
							<td align="right">Rp. ' .format_uang($row['diskon_rp_2']). '</td>
							<td align="right">Rp. ' .format_uang($row['diskon_rp_3']). '</td>
							<td align="right">Rp. ' .format_uang(($row['harga']-$row['diskon_rp']-$row['diskon_rp_2']-$row['diskon_rp_3'])*$row['jumlah']). '</td>
						</tr>';
				}
					echo '<tr><td colspan="3" align="right"><b>Total</b></td><td align="right"><b>Rp. ' .format_uang($total). '</b></td></tr>';
				?>
				</tbody>
			</table>
			</div>
			
			<center><div id="pic_info" class="popup-gallery">
			<?php
			$cap="FOTO BARANG";
			if (file_exists("../images/uploader/" .$id_jual. ".jpg")){
				$selesai=true;
				$cap="FOTO ULANG BARANG";
				$acak=rand(0,10000);
				echo '<a href="../images/uploader/' .$id_jual. '.jpg?' .$acak. '"><img src="../images/uploader/' .$id_jual. '.jpg?' .$acak. '" width="240"></a>';
			}
			?>
			</div>
			<div id="foto">
				<a onClick="AndroidFunction.getFoto(<?php echo $id_jual ?>)" class="btn btn-primary" style="margin-top:10px;margin-bottom:10px"><i class="fa fa-camera"></i> <?php echo $cap ?></a>
				<button type="submit" id="simpan" class="btn btn-primary" style="margin-top:10px;margin-bottom:10px;" <?php if (!$selesai) echo 'disabled' ?> ><i class="fa fa-thumbs-up"></i> SELESAI</button>
			</div>
			</form>
			</center>
			
			</div>
			<div id="dummy" style="display:none"></div>
			</div>
			</div>
		</div>	
	</div>
</div>

<script>
function getBack(){
	AndroidFunction.removeLokasi();
	window.location='index.php?page=driver&mode=barang_keluar';
}
function updateFoto(){
	var acak=Math.random().toString(36).substring(7);
	$('#pic_info').html('<a href="../images/uploader/<?php echo $id_jual ?>.jpg?' + acak + '"><img src="../images/uploader/<?php echo $id_jual ?>.jpg?' + acak + '" width="240"></a>');
	$('#simpan').removeAttr("disabled");
}
function set_lokasi(gps,kota,akurasi,mock){
	$('#lokasi_gps').val(gps);
	var lokasi=gps.split(",");
	var lng = lokasi[0].replace("Longitude: ","");
	var lat = lokasi[1].replace("Latitude: ","");
	curLng=lng; curLat=lat;
	compare_lokasi();
	$('#lokasi_kota').val(kota);
	$('#akurasi').val(akurasi);
	$('#mock').val(mock);
}
function compare_lokasi(){
	var id = $('#id_pelanggan').val();
	$('#dummy').load('assets/page/driver/get-lokasi.php?id=' + id + '&lat=' + curLat + '&lng=' + curLng, function(){
		var lokasi=$(this).html();
		var lat = lokasi.split(",")[0];
		var lng = lokasi.split(",")[1];
		AndroidFunction.compare(lat,lng,curLat,curLng);
	});
}
function setDistance(jarak){
	var test = Math.round(jarak);
	$('#distance').val(test);
}
$(document).ready(function(){
	$('#berat').inputmask('decimal', {allowMinus:false, autoGroup: true, groupSeparator: '.', rightAlign: false, autoUnmask: true, removeMaskOnSubmit: true});
	$('#tarif').inputmask('decimal', {allowMinus:false, autoGroup: true, groupSeparator: '.', rightAlign: false, autoUnmask: true, removeMaskOnSubmit: true});
	$('.popup-gallery').magnificPopup({
        delegate: 'a',
        type: 'image',
        tLoading: 'Loading image #%curr%...',
        mainClass: 'mfp-img-mobile',
        gallery: {
            enabled: true,
            navigateByImgClick: true,
            preload: [0, 1] // Will preload 0 - before current, and 1 after the current image
        },
        image: {
            tError: '<a href="%url%">The image #%curr%</a> could not be loaded.'
        }
    });
	AndroidFunction.getLokasi();
});
</script>
