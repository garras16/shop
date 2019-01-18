<?php
$id_karyawan=$_SESSION['id_karyawan'];
if (isset($simpan_canvass_siap_kirim_post)){
	$sql = mysqli_query($con, "UPDATE canvass_siap_kirim SET status='2' WHERE id_canvass_siap_kirim=$id");
	$sql = mysqli_query($con, "SELECT id_jual FROM canvass_siap_kirim WHERE id_canvass_siap_kirim=$id");
	$row=mysqli_fetch_array($sql);
	$sql = mysqli_query($con, "UPDATE jual SET status_konfirm=7 WHERE id_jual=" .$row['id_jual']. "");
	
	$sql = mysqli_query($con, "SELECT id_jual FROM pengiriman WHERE id_jual=" .$row['id_jual']);
	if (mysqli_num_rows($sql)>0){
		$sql2 = mysqli_query($con, "UPDATE pengiriman SET status=1,jenis='LUAR KOTA',tanggal_kirim='$tanggal',id_karyawan=$id_karyawan WHERE id_jual=" .$row['id_jual']. "");
	} else {
		$sql2 = mysqli_query($con, "INSERT INTO pengiriman VALUES(null, " .$row['id_jual']. ", 1, '$tanggal',$id_karyawan,null,null,null,null,'LUAR KOTA')");
	}
	
	$sql=mysqli_query($con, "SELECT * FROM checkin WHERE tanggal='$tanggal' AND id_pelanggan='$id_pelanggan' AND id_karyawan=$id_karyawan");
	$c=mysqli_num_rows($sql);
	$row=mysqli_fetch_array($sql);
	$id_checkin=$row['id_checkin'];
	if ($c==0){
		$sql=mysqli_query($con, "INSERT INTO checkin VALUES(null,'$tanggal','$jam','$barcode',$id_pelanggan,$id_karyawan,'$lokasi_gps','$lokasi_kota',$akurasi,'$mock',$distance)");
		if ($sql){
			_buat_pesan("Input Berhasil","green");
		} else {
			_buat_pesan("Input Gagal","red");
		}
	} else {
		$sql=mysqli_query($con, "UPDATE checkin SET gps='$lokasi_gps',kota='$lokasi_kota',akurasi=$akurasi,mock='$mock',distance=$distance WHERE id_checkin=$id_checkin");
		if ($sql){
			_buat_pesan("Input Berhasil","green");
		} else {
			_buat_pesan("Input Gagal","red");
		}
	}
	_direct("?page=canvass_keluar&mode=kirim_canvass");
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
				<div id="table_info" class="table responsive" style="display:none">
					<table class="table table-bordered table-striped">
						<tbody>
<?php
	$sql=mysqli_query($con, "SELECT id_jual FROM canvass_siap_kirim WHERE id_canvass_siap_kirim=$id");
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
				</tbody>
			</table>
			</div>
			<div id="scan_toko" style="display:none">
			<form method="post">
				<input type="hidden" name="simpan_canvass_siap_kirim_post" value="true">
				<input type="hidden" name="lokasi_gps" id="lokasi_gps" value="">
				<input type="hidden" name="lokasi_kota" id="lokasi_kota" value="">
				<input type="hidden" name="akurasi" id="akurasi" value="">
				<input type="hidden" name="mock" id="mock" value="">
				<input type="hidden" name="distance" id="distance" value="">
				<input type="hidden" name="id_pelanggan" id="id_pelanggan" value="<?php echo $row['id_pelanggan'] ?>">	
				<input type="hidden" name="barcode" id="barcode_toko" value="<?php echo $row['barcode'] ?>">
				<center><a id="scan" class="btn btn-primary" onClick="AndroidFunction.scanToko()" style="margin-bottom:10px"><i class="fa fa-barcode"></I> SCAN TOKO</a></center>
			</div>
			
			<div id="table_content" style="display:none">
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
    INNER JOIN canvass_siap_kirim_detail 
        ON (jual_detail.id_jual_detail = canvass_siap_kirim_detail.id_jual_detail)
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
							<td align="right">' .format_uang($row['harga']). '</td>
							<td align="right">' .format_uang($row['diskon_rp']). '</td>
							<td align="right">' .format_uang($row['diskon_rp_2']). '</td>
							<td align="right">' .format_uang($row['diskon_rp_3']). '</td>
							<td align="right">' .format_uang(($row['harga']-$row['diskon_rp']-$row['diskon_rp_2']-$row['diskon_rp_3'])*$row['jumlah']). '</td>
						</tr>';
				}
					echo '<tr><td colspan="6" align="right"><b>Total</b></td><td align="right"><b>Rp. ' .format_uang($total). '</b></td></tr>';
				?>
				</tbody>
			</table>
			</div>
			
			<center><div id="pic_info" class="popup-gallery" style="display:none">
			<?php
			$cap="FOTO BARANG";
			if (file_exists("../images/uploader/" .$id_jual. ".jpg")){
				$selesai=true;
				$acak=rand(0,10000);
				$cap="FOTO ULANG BARANG";
				echo '<a href="../images/uploader/' .$id_jual. '.jpg?' .$acak. '"><img src="../images/uploader/' .$id_jual. '.jpg?' .$acak. '" width="240"></a>';
			}
			?>
			</div>
			<div id="foto" style="display:none">
				<a onClick="AndroidFunction.getFoto(<?php echo $id_jual ?>)" class="btn btn-primary" style="margin-top:10px;margin-bottom:10px"><i class="fa fa-camera"></i> <?php echo $cap ?></a>
				<button type="submit" id="simpan" class="btn btn-primary" style="margin-top:10px;margin-bottom:10px;<?php if (!$selesai) echo 'display:none' ?>"><i class="fa fa-thumbs-up"></i> SELESAI</button>
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
	window.location='index.php?page=canvass_keluar&mode=kirim_canvass';
}
function batal_scan(){
	getBack();
}
function cek_scan_toko(barcode1){
	var barcode2 = $('#barcode_toko').val();
	if (barcode1 == barcode2){
		$('#foto').attr("style","");
		$('#pic_info').attr("style","");
		$('#table_info').attr("style","");
		$('#table_content').attr("style","");
	} else {
		AndroidFunction.showToast("Barcode Toko tidak sama.");
		getBack();
	}
}
function updateFoto(){
	var acak=Math.random().toString(36).substring(7);
	$('#pic_info').html('<a href="../images/uploader/<?php echo $id_jual ?>.jpg?' + acak + '"><img src="../images/uploader/<?php echo $id_jual ?>.jpg?' + acak + '" width="240"></a>');
	$('#simpan').attr("style","margin-top:10px;margin-bottom:10px");
}
function set_lokasi(gps,kota,akurasi,mock){
	$('#lokasi_gps').val(gps);
	var lokasi=gps.split(",");
	var lng = lokasi[0].replace("Longitude: ","");
	var lat = lokasi[1].replace("Latitude: ","");
	curLng=lng; curLat=lat;
	$('#lokasi_kota').val(kota);
	$('#akurasi').val(akurasi);
	$('#mock').val(mock);
	compare_lokasi();
}
function compare_lokasi(){
	var id = $('#id_pelanggan').val();
	$('#dummy').load('assets/page/canvass_keluar/get-lokasi.php?id=' + id + '&lat=' + curLat + '&lng=' + curLng, function(){
		var lokasi=$(this).html();
		var lat = lokasi.split(",")[0];
		var lng = lokasi.split(",")[1];
		AndroidFunction.compare(lat,lng,curLat,curLng);
	});
}
function setDistance(jarak){
	AndroidFunction.removeLokasi();
	var test = Math.round(jarak);
	$('#distance').val(test);
	$('#scan').click();
}
$(document).ready(function(){
	AndroidFunction.getLokasi();
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
});
</script>
