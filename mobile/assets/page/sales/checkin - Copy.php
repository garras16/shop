<?php
if (isset($checkin_post)){
	$sql=mysqli_query($con, "INSERT INTO beli_detail VALUES(null,$id,$id_barang_supplier,$qty,$harga,0)");
	if ($sql){
		$pesan="Input Berhasil";
		$warna="green";
	} else {
		$pesan="Input Gagal";
		$warna="red";
	}
}
?>
<div class="right_col loading" role="main">
	<div class="">
	
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<h3>CHECKIN</h3>
						<?php
							if (isset($pesan)){
								echo '<span class="badge bg-' .$warna. '">' .$pesan. '</span>';
							}
						?>
						<div id="alert_me"></div>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<p align="center"><a id="scan" onClick="scan.scanToko();" class="btn btn-primary">SCAN TOKO</a>
						<div id="toko"></div>
						<div id="lokasi"></div>
						<form method="post">
							<input type="hidden" id="checkin_post" name="checkin_post" value="true"></input>
							<input type="hidden" id="id_karyawan" name="id_karyawan" value="<?php echo $_SESSION['id_karyawan'] ?>"></input>
							<input type="hidden" id="nama_toko" name="nama_toko" value=""></input>
							<input type="hidden" id="lokasi_gps" name="lokasi_gps" value=""></input>
							<input type="hidden" id="lokasi_kota" name="lokasi_kota" value=""></input>
							<p align="center"><input id="checkin" type="submit" class="btn btn-primary" value="CHECK IN" style="display:none"></input></p>
						</form>
					</div>
					<div id="dummy" style="display:none"></div>
				</div>
			</div>
		</div>	
	</div>
</div>

<script>
function get_toko(barcode){
	$('#dummy').load('assets/page/sales/get-checkbar.php?kode=' + barcode, function(){
		var toko=$(this).html();
		if (toko==''){
			$('#toko').html('<p align="center"><b>BARCODE TIDAK DITEMUKAN</b></p>');
		} else {
			$('#toko').html('<p align="center"><b>' + toko + '</b></p>');
			$('#scan').attr('style', 'display:none');
			$('#nama_toko').val(toko);
		}
	});
}
function get_lokasi(lokasi){
	$('#lokasi').html('<p align="center"><b>' + lokasi + '</b></p>');
}
function set_lokasi(gps,kota){
	$('#lokasi_gps').val(gps);
	$('#lokasi_kota').val(kota);
}
function cek_valid(){
	var toko=$('#nama_toko').val();
	var lokasi=$('#nama_lokasi').val();
	if (toko!='' && lokasi!=''){
		$('#checkin').removeAttr('style');
	} else {
		setTimeout(cek_valid, 500);
	}
}
$('document').ready(function(){
	setTimeout(cek_valid, 500);
});
</script>

