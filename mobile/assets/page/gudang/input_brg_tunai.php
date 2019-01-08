<?php
session_start();
date_default_timezone_set('Asia/Jakarta');
require_once('../../../assets/inc/config.php');
require_once('../../../assets/inc/publicfunc.php');
$id=$_GET['id'];
?>
<div class="input-group">
	<span class="input-group-addon" style="padding: 2px 12px;"><i class="fa fa-file fa-fw"></i><br><small>Barang</small></span>
	<select class="select2 form-control" id="select_barang" name="id_barang" required>
		<option value="" disabled selected>Nama Barang | Stok | Harga</option>
		<?php
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
	INNER JOIN satuan 
        ON (barang.id_satuan = satuan.id_satuan)
WHERE barang_masuk_rak.stok > 0 AND id_pelanggan=" .$_GET['id']. "
GROUP BY barang.id_barang");
	while ($row=mysqli_fetch_array($sql)){
		$sql2=mysqli_query($con, "SELECT SUM(qty) as qty
FROM
    jual
    INNER JOIN jual_detail 
        ON (jual.id_jual = jual_detail.id_jual)
WHERE status_konfirm=0 AND id_harga_jual=" .$row['id_harga_jual']. "");
		$r=mysqli_fetch_array($sql2);
		$total_stok=$row['total_stok']-$r['qty'];
		if ($total_stok>=$row['stok_minimal']) echo '<option data-harga="'.$row['harga_jual'].'" data-nama="'.$row['nama_barang'].'" data-stok="'.$total_stok.'" data-min="'.$row['min_order'].'" data-satuan="' .$row['nama_satuan']. '" value="' .$row['id_harga_jual']. '">' .$row['nama_barang']. ' | Stok : ' .$total_stok. ' ' .$row['nama_satuan']. ' | Rp.' .format_uang($row['harga_jual']). '</option>';
	}
		?>
	</select>
	<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
</div>
<div class="input-group">
	<span class="input-group-addon"><i class="fa fa-tags fa-fw" style="width: 38px"></i><br><small>Qty</small></span>
	<input class="form-control" data-min="" type="tel" id="qty" style="padding: 20px 15px;" name="qty" value="" autocomplete="off" placeHolder="Qty" required>
	<span class="input-group-addon" id="satuan"></span>
	<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
</div>
<div class="input-group">
	<span class="input-group-addon"><i class="fa fa-dollar fa-fw" style="width: 38px"></i><br><small>Harga</small></span>
	<input class="form-control" id="harga_jual" name="harga_jual" style="padding: 20px 15px;" value="" autocomplete="off" placeHolder="Harga Jual" readonly required>
	<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
</div>
<input type="hidden" name="tambah_gudang_jual_detail" value="true">
<input type="hidden" id="tenor" name="tenor" value="0">
<input type="hidden" id="id_harga_jual" name="id_harga_jual" value="">

<script>
$(document).ready(function(){
	$('#qty').inputmask('decimal', {allowMinus:false, autoGroup: true, groupSeparator: '.', rightAlign: false, autoUnmask: true, removeMaskOnSubmit: true});
	$('#harga_jual').inputmask('decimal', {allowMinus:false, autoGroup: true, groupSeparator: '.', rightAlign: false, autoUnmask: true, removeMaskOnSubmit: true});
	$('#select_barang').on('change', function(e){
		var cari_data = $(this).find(':selected');
		var id_hj = cari_data.val();
		var stok = cari_data.data('stok');
		var harga = cari_data.data('harga');
		var min = cari_data.data('min');
		var satuan = cari_data.data('satuan');
		$('#id_harga_jual').val(id_hj);
		$('#harga_jual').val(harga);
		$('#qty').attr('data-min',min);
		$('#satuan').html(satuan);
	});
	$('#select_barang').select2({
		placeholderOption: "first",
		allowClear: true,
		width: '100%'
	});
});
</script>