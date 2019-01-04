<?php
session_start();
date_default_timezone_set('Asia/Jakarta');
require_once('../../../assets/inc/config.php');
require_once('../../../assets/inc/publicfunc.php');
if (!isset($_GET['id'])) die();
$barcode=$_GET['id'];
$id_rak=$_GET['rak'];
$id_canvass=$_GET['canvass'];
$sql = mysql_query("SELECT *
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
	INNER JOIN satuan 
        ON (barang.id_satuan = satuan.id_satuan)
WHERE barang_masuk_rak.stok > 0 AND barang_masuk_rak.id_rak=$id_rak AND barang.barcode='$barcode' AND barang.status=1 
GROUP BY barang.id_barang, barang_masuk_rak.expire");
	if (mysql_num_rows($sql)=='0') die();
	
?>
<input type="hidden" id="id_barang_masuk_rak" name="id_barang_masuk_rak" value="">
<input type="hidden" id="expire" name="expire" value="">
<input type="hidden" id="stok" value="">
<input type="hidden" id="min" value="">
<div class="input-group">
	<span class="input-group-addon"><i class="fa fa-file fa-fw"></i></span>
	<select class="form-control" id="select_barang" name="id_barang" required>
		<option value="" disabled selected>Nama Barang | Stok | Exp.</option>
	<?php
		while ($row=mysql_fetch_array($sql)){
			$sql2=mysql_query("SELECT SUM(qty) AS qty FROM canvass_keluar_barang
WHERE id_barang=" .$row['id_barang']. " AND id_rak=" .$row['id_rak']. " AND expire='" .$row['expire']. "' AND stok IS NULL");
			$r=mysql_fetch_array($sql2);
			$total_stok=$row['total_stok']-$r['qty'];
			if ($total_stok>=$row['stok_minimal']) echo '<option data-nama="'.$row['nama_barang'].'" data-stok="'.$total_stok.'" data-min="'.$row['min_order'].'" data-id-bmr="'.$row['id_barang_masuk_rak'].'" data-expire="'.$row['expire'].'" data-satuan="' .$row['nama_satuan']. '" value="' .$row['id_barang']. '">' .$row['nama_barang']. ' | Stok : ' .$total_stok. ' ' .$row['nama_satuan']. ' | ' .date("d-m-Y",strtotime($row['expire'])). '</option>';
		}
	?>
	</select>
	<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
</div>
<div class="input-group">
	<span class="input-group-addon"><i class="fa fa-tags fa-fw"></i></span>
	<input class="form-control" data-min="" type="tel" id="qty" name="qty" value="" autocomplete="off" placeHolder="Qty" required>
	<span id="sat" class="input-group-addon"></span>
	<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
</div>

<script>
$(document).ready(function(){
	$('#qty').inputmask('decimal', {allowMinus:false, autoGroup: true, groupSeparator: '.', rightAlign: false, autoUnmask: true, removeMaskOnSubmit: true});
	$('#select_barang').on('change', function(e){
		var cari_data = $(this).find(':selected');
		var idbmr = cari_data.data('id-bmr');
		var expire = cari_data.data('expire');
		var stok = cari_data.data('stok');
		var satuan = cari_data.data('satuan');
		var min = cari_data.data('min');
		$('#qty').attr('data-min',min);
		$('#sat').html(satuan);
		$('#id_barang_masuk_rak').val(idbmr);
		$('#expire').val(expire);
		$('#stok').val(stok);
		$('#min').val(min);
	});
});
</script>