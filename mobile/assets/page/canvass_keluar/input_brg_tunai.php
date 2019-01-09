<?php
session_start();
date_default_timezone_set('Asia/Jakarta');
require_once('../../../assets/inc/config.php');
require_once('../../../assets/inc/publicfunc.php');
$id=$_GET['id'];
$id_karyawan=$_SESSION['id_karyawan'];
?>
<div class="input-group">
	<span class="input-group-addon" style="padding: 3px 12px;"><i class="fa fa-file fa-fw" style="width: 47px;"></i><br><small>Barang</small></span>
	<select class="select2 form-control" id="select_barang" name="id_barang" required>
		<option value="" disabled selected>Nama Barang | Stok | Harga Jual</option>
		<?php
		$sql = mysqli_query($con, "SELECT *
    , SUM(canvass_keluar_barang.stok) AS total_stok
FROM
    canvass_keluar
    INNER JOIN canvass_keluar_barang 
        ON (canvass_keluar.id_canvass_keluar = canvass_keluar_barang.id_canvass_keluar)
    INNER JOIN canvass_keluar_karyawan 
        ON (canvass_keluar.id_canvass_keluar = canvass_keluar_karyawan.id_canvass_keluar)
    INNER JOIN barang_masuk_rak 
        ON (canvass_keluar_barang.id_barang_masuk_rak = barang_masuk_rak.id_barang_masuk_rak)
    INNER JOIN barang 
        ON (canvass_keluar_barang.id_barang = barang.id_barang)
    INNER JOIN barang_masuk 
        ON (barang_masuk_rak.id_barang_masuk = barang_masuk.id_barang_masuk)
    INNER JOIN beli_detail 
        ON (barang_masuk.id_beli_detail = beli_detail.id_beli_detail)
    INNER JOIN harga_jual 
        ON (beli_detail.id_barang_supplier = harga_jual.id_barang_supplier)
    INNER JOIN satuan 
        ON (barang.id_satuan = satuan.id_satuan)
WHERE canvass_keluar_barang.qty_cek > 0 AND barang.status=1 AND id_pelanggan=" .$_GET['id']. " AND canvass_keluar_karyawan.id_karyawan=" .$id_karyawan. " AND (canvass_keluar.status=1 OR canvass_keluar.status=2)
GROUP BY barang.id_barang");
	while ($row=mysqli_fetch_array($sql)){
	// STATUS KONFIRM 5 UNTUK CANVASS YG BLM KONFIRM
		$sql2=mysqli_query($con, "SELECT SUM(qty) as qty
FROM
    jual
	INNER JOIN canvass_belum_siap 
        ON (jual.id_jual = canvass_belum_siap.id_jual)
    INNER JOIN jual_detail 
        ON (jual.id_jual = jual_detail.id_jual)
WHERE status_konfirm=5 AND id_harga_jual=" .$row['id_harga_jual']. "");
		$r=mysqli_fetch_array($sql2);
		$total_stok=$row['total_stok']-$r['qty'];
		if ($total_stok>0) echo '<option data-harga="'.$row['harga_jual'].'" data-nama="'.$row['nama_barang'].'" data-stok="'.$total_stok.'" data-min="'.$row['min_order'].'" data-satuan="' .$row['nama_satuan']. '" data-id-canvass="' .$row['id_canvass_keluar']. '" value="' .$row['id_harga_jual']. '">' .$row['nama_barang']. ' | Stok : ' .$total_stok. ' ' .$row['nama_satuan']. ' | Rp.' .format_uang($row['harga_jual']). '</option>';
	}
		?>
	</select>
	<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
</div>
<input type="hidden" id="id_canvass" name="id_canvass_keluar" value="">
<div class="input-group">
	<span class="input-group-addon"><i class="fa fa-tags fa-fw" style="width: 47px;"></i><br><small>Qty</small></span>
	<input class="form-control" data-min="" type="tel" id="qty" name="qty" style="padding: 20px 15px;" value="" autocomplete="off" placeHolder="Qty" required>
	<span id="sat" class="input-group-addon"></span>
	<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
</div>
<div class="input-group">
	<span class="input-group-addon"><i class="fa fa-money fa-fw" style="width: 47px;"></i><br><small>Harga</small></span>
	<input class="form-control" style="padding: 20px 15px;" id="harga_jual" name="harga_jual" value="" autocomplete="off" placeHolder="Harga Jual" readonly required>
	<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
</div>
<div class="input-group">
	<span class="input-group-addon"><i class="fa fa-cut fa-fw"></i><br><small>Diskon 1</small></span>
	<input class="form-control" type="tel" style="padding: 20px 15px;" id="diskon_persen_1" name="diskon_persen_1" value="" autocomplete="off" placeHolder="Diskon Barang 1 (%)" required>
	<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
</div>
<div class="input-group">
	<span class="input-group-addon"><i class="fa fa-cut fa-fw"></i><br><small>Diskon 2</small></span>
	<input class="form-control" type="tel" id="diskon_persen_2" style="padding: 20px 15px;" name="diskon_persen_2" value="" autocomplete="off" placeHolder="Diskon Barang 2 (%)" required>
	<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
</div>
<div class="input-group">
	<span class="input-group-addon"><i class="fa fa-cut fa-fw"></i><br><small>Diskon 3</small></span>
	<input class="form-control" type="tel" id="diskon_persen_3" style="padding: 20px 15px;" name="diskon_persen_3" value="" autocomplete="off" placeHolder="Diskon Barang 3 (%)" required>
	<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
</div>
<input type="hidden" id="tenor" name="tenor" value="0">

<script>
$(document).ready(function(){
	$('#qty').inputmask('decimal', {allowMinus:false, autoGroup: true, groupSeparator: '.', rightAlign: false, autoUnmask: true, removeMaskOnSubmit: true});
	$('#diskon_persen_1').inputmask('decimal', {allowMinus:false, autoGroup: true, groupSeparator: '.', rightAlign: false, autoUnmask: true, removeMaskOnSubmit: true});
	$('#diskon_persen_2').inputmask('decimal', {allowMinus:false, autoGroup: true, groupSeparator: '.', rightAlign: false, autoUnmask: true, removeMaskOnSubmit: true});
	$('#diskon_persen_3').inputmask('decimal', {allowMinus:false, autoGroup: true, groupSeparator: '.', rightAlign: false, autoUnmask: true, removeMaskOnSubmit: true});
	$('#harga_jual').inputmask('decimal', {allowMinus:false, autoGroup: true, groupSeparator: '.', rightAlign: false, autoUnmask: true, removeMaskOnSubmit: true});
	$('#select_barang').on('change', function(e){
		var cari_data = $(this).find(':selected');
		var stok = cari_data.data('stok');
		var satuan = cari_data.data('satuan');
		var harga = cari_data.data('harga');
		var min = cari_data.data('min');
		$('#harga_jual').val(harga);
		$('#qty').attr('data-min',min);
		$('#sat').html(satuan);
	});
	$('#select_barang').select2({
		placeholderOption: "first",
		allowClear: true,
		width: '100%'
	});
});
</script>