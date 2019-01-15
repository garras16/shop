<?php
$id_karyawan=$_SESSION['id_karyawan'];
if (isset($checkin_post)){
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
	$_SESSION['id_pelanggan']=$id_pelanggan;
	$_SESSION['nama_pelanggan']=$nama_toko;
	_direct("?page=collector&mode=tagihan_2&id_pelanggan=$id_pelanggan");
}
?>
<div class="right_col loading" role="main">
	<div class="">
	
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<h3>TAGIHAN DEBT COLLECTOR</h3>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<p align="center"><a id="scan" onClick="AndroidFunction.scanToko();" class="btn btn-primary" style="display:none">SCAN TOKO</a>
						<div id="toko"></div>
						<form method="post">
							<input type="hidden" id="checkin_post" name="checkin_post" value="true"></input>
							<input type="hidden" id="id_karyawan" name="id_karyawan" value="<?php echo $_SESSION['id_karyawan'] ?>"></input>
							<input type="hidden" id="id_pelanggan" name="id_pelanggan" value=""></input>
							<input type="hidden" id="nama_toko" name="nama_toko" value=""></input>
							<input type="hidden" id="barcode" name="barcode" value=""></input>
							<input type="hidden" id="lokasi_gps" name="lokasi_gps" value=""></input>
							<input type="hidden" id="lokasi_kota" name="lokasi_kota" value=""></input>
							<input type="hidden" id="akurasi" name="akurasi" value=""></input>
							<input type="hidden" id="mock" name="mock" value=""></input>
							<input type="hidden" id="distance" name="distance" value=""></input>
							<p align="center"><input id="checkin" type="submit" class="btn btn-primary" value="CHECK IN" style="display:none"></input></p>
						</form>
						
						<div id="dummy" style="display:none"></div>
					</div>
				</div>
			</div>
		</div>	
	</div>
</div>

<script>
function getBack(){
	AndroidFunction.closeApp();
}
function batal_scan(){
	getBack();
}

function get_toko(barcode){
	$('#scan').attr('style', 'display:none');
	$('#dummy').load('assets/page/collector/get-toko.php?code=' + barcode, function(){
		if ($('#dummy').html()=='success'){
			$('#toko').html('');
			get_pelanggan(barcode);
		} else {
			$('#scan').attr('style', '');
			$('#toko').html('<p align="center"><b>BARCODE TIDAK DITEMUKAN</b></p>');
		}
	});
}

function get_pelanggan(barcode){
	$('#dummy').load('assets/page/collector/get-info.php?kode=' + barcode, function(){
		var id=$(this).html();
		$('#id_pelanggan').val(id);
		compare_lokasi();
	})
}

function set_lokasi(gps,kota,akurasi,mock){
	AndroidFunction.removeLokasi();
	$('#lokasi_gps').val(gps);
	var lokasi=gps.split(",");
	var lng = lokasi[0].replace("Longitude: ","");
	var lat = lokasi[1].replace("Latitude: ","");
	curLng=lng; curLat=lat;
	$('#lokasi_kota').val(kota);
	$('#akurasi').val(akurasi);
	$('#mock').val(mock);
	$('#scan').removeAttr("style");
	$('#scan').click();
}

function compare_lokasi(){
	var id = $('#id_pelanggan').val();
	$('#dummy').load('assets/page/collector/get-lokasi.php?id=' + id + '&lat=' + curLat + '&lng=' + curLng, function(){
		var lokasi=$(this).html();
		var lat = lokasi.split(",")[0];
		var lng = lokasi.split(",")[1];
		AndroidFunction.compare(lat,lng,curLat,curLng);
	});
}
function setDistance(jarak){
	var test = Math.round(jarak);
	$('#distance').val(test);
	$('#checkin').click();
}
$(document).ready(function(){
	AndroidFunction.getLokasi();
})
</script>