<?php
session_start();
date_default_timezone_set('Asia/Jakarta');
require_once('../../../assets/inc/config.php');
require_once('../../../assets/inc/publicfunc.php');
?>
<div class="input-group">
	<span class="input-group-addon" style="padding: 2px 12px;"><i class="fa fa-file fa-fw"></i><br><small>Barang</small></span>
	<select class="select2 form-control" id="select_barang_2" name="id_barang" required>
		<option value="" disabled selected>Nama Barang | Stok | Harga Jual Kredit</option>
		<?php
		$sql = mysqli_query($con, "SELECT DISTINCT(hari)
FROM
    barang_masuk_rak
    INNER JOIN barang_masuk 
        ON (barang_masuk_rak.id_barang_masuk = barang_masuk.id_barang_masuk)
    INNER JOIN beli_detail 
        ON (barang_masuk.id_beli_detail = beli_detail.id_beli_detail)
    INNER JOIN barang_supplier 
        ON (beli_detail.id_barang_supplier = barang_supplier.id_barang_supplier)
    INNER JOIN barang 
        ON (barang_supplier.id_barang = barang.id_barang)
    INNER JOIN harga_jual 
        ON (harga_jual.id_barang_supplier = barang_supplier.id_barang_supplier)
    INNER JOIN harga_jual_kredit 
        ON (harga_jual.id_harga_jual = harga_jual_kredit.id_harga_jual)
	INNER JOIN satuan 
        ON (barang.id_satuan = satuan.id_satuan)
WHERE barang_masuk_rak.stok > 0 AND barang.status=1 AND id_pelanggan=" .$_GET['id']. "
GROUP BY id_harga_jual_kredit");
	while ($row=mysqli_fetch_array($sql)){
		if ($_GET['tenor']<$row['hari']) {
			$tenor=$row['hari'];
			break;
		}
	}
		$sql = mysqli_query($con, "SELECT *
    , SUM(barang_masuk_rak.stok) AS total_stok
FROM
    barang_masuk_rak
    INNER JOIN barang_masuk 
        ON (barang_masuk_rak.id_barang_masuk = barang_masuk.id_barang_masuk)
    INNER JOIN beli_detail 
        ON (barang_masuk.id_beli_detail = beli_detail.id_beli_detail)
    INNER JOIN barang_supplier 
        ON (beli_detail.id_barang_supplier = barang_supplier.id_barang_supplier)
    INNER JOIN barang 
        ON (barang_supplier.id_barang = barang.id_barang)
    INNER JOIN harga_jual 
        ON (harga_jual.id_barang_supplier = barang_supplier.id_barang_supplier)
    INNER JOIN harga_jual_kredit 
        ON (harga_jual.id_harga_jual = harga_jual_kredit.id_harga_jual)
	INNER JOIN satuan 
        ON (barang.id_satuan = satuan.id_satuan)
WHERE barang_masuk_rak.stok > 0 AND id_pelanggan=" .$_GET['id']. " AND hari>" .$_GET['tenor']. " AND hari <= $tenor
GROUP BY id_harga_jual_kredit");
	while ($row=mysqli_fetch_array($sql)){
		$sql2 = mysqli_query($con, "SELECT * FROM harga_jual_kredit WHERE id_harga_jual=" .$row['id_harga_jual']. " AND hari>=" .$_GET['tenor']. "");
		$r=mysqli_fetch_array($sql2);
		$sql3=mysqli_query($con, "SELECT SUM(qty) as qty
FROM
    jual
    INNER JOIN jual_detail 
        ON (jual.id_jual = jual_detail.id_jual)
WHERE status_konfirm=0 AND id_harga_jual=" .$row['id_harga_jual']. "");
		$r3=mysqli_fetch_array($sql3);
		$total_stok=$row['total_stok']-$r3['qty'];
			if ($total_stok>=$row['stok_minimal']) echo '<option data-harga="'.$r['harga_kredit'].'" data-tenor="'.$r['hari'].'" data-nama="'.$row['nama_barang'].'" data-stok="'.$total_stok.'" data-min="'.$row['min_order'].'" data-satuan="' .$row['nama_satuan']. '" value="' .$row['id_harga_jual']. '">' .$row['nama_barang']. ' | Stok : ' .$total_stok. ' ' .$row['nama_satuan']. ' | Rp. ' .format_uang($r['harga_kredit']). '</option>';
	}
		?>
	</select>
	<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
</div>
<div class="input-group">
	<span class="input-group-addon"><i class="fa fa-tags fa-fw" style="width: 37px"></i><br><small>Qty</small></span>
	<input class="form-control" style="padding: 20px 15px;" data-min="" type="tel" id="qty" name="qty" value="" autocomplete="off" placeHolder="Qty"  required>
	<span id="sat" class="input-group-addon"></span>
	<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
</div>
<div class="input-group">
	<span class="input-group-addon"><i class="fa fa-money fa-fw" style="width: 37px"></i><br><small>Harga</small></span>
	<input class="form-control" id="harga_jual" style="padding: 20px 15px;" name="harga_jual" value="" autocomplete="off" placeHolder="Harga Jual"  readonly required>
	<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
</div>
<div class="input-group">
	<span class="input-group-addon"><i class="fa fa-cut fa-fw"></i> Diskon 1</span>
	<input class="form-control" type="tel" id="diskon_persen_1" name="diskon_persen_1" value="" autocomplete="off" placeHolder="Diskon Barang 1 (%)" required>
	<span class="input-group-addon">%</span>
</div>
<div class="input-group">
	<span class="input-group-addon"><i class="fa fa-cut fa-fw"></i> Diskon 2</span>
	<input class="form-control" type="tel" id="diskon_persen_2" name="diskon_persen_2" value="" autocomplete="off" placeHolder="Diskon Barang 2 (%)" required>
	<span class="input-group-addon">%</span>
</div>
<div class="input-group">
	<span class="input-group-addon"><i class="fa fa-cut fa-fw"></i> Diskon 3</span>
	<input class="form-control" type="tel" id="diskon_persen_3" name="diskon_persen_3" value="" autocomplete="off" placeHolder="Diskon Barang 3 (%)" required>
	<span class="input-group-addon">%</span>
</div>
<input type="hidden" id="tenor" name="tenor" value="" required>

<script>
$(document).ready(function(){
	$('#qty').inputmask('decimal', {allowMinus:false, autoGroup: true, groupSeparator: '.', rightAlign: false, autoUnmask: true, removeMaskOnSubmit: true});
	$('#diskon_persen_1').inputmask('decimal', {allowMinus:false, autoGroup: true, groupSeparator: '.', rightAlign: false, autoUnmask: true, removeMaskOnSubmit: true});
	$('#diskon_persen_2').inputmask('decimal', {allowMinus:false, autoGroup: true, groupSeparator: '.', rightAlign: false, autoUnmask: true, removeMaskOnSubmit: true});
	$('#diskon_persen_3').inputmask('decimal', {allowMinus:false, autoGroup: true, groupSeparator: '.', rightAlign: false, autoUnmask: true, removeMaskOnSubmit: true});
	$('#harga_jual').inputmask('decimal', {allowMinus:false, autoGroup: true, groupSeparator: '.', rightAlign: false, autoUnmask: true, removeMaskOnSubmit: true});
	$('#select_barang_2').on('change', function(e){
		var cari_data = $(this).find(':selected');
		var stok = cari_data.data('stok');
		var satuan = cari_data.data('satuan');
		var harga = cari_data.data('harga');
		var min = cari_data.data('min');
		$('#harga_jual').val(harga);
		$('#qty').attr('data-min',min);
		$('#sat').html(satuan);
	});
	$('#select_barang_2').select2({
		placeholderOption: "first",
		allowClear: true,
		width: '100%'
	});
});
</script>