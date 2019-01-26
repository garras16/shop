<?php
if (isset($edit_konfirm_beli_4_post)){
	$sql = "INSERT INTO barang_masuk VALUES(null,$id,'$tanggal',$qty_datang,null,null,1)";
	$q = mysqli_query($con, $sql);
	_direct("?page=gudang&mode=konfirm_beli_5&id=$id");
}

$sql = "SELECT
    barang_masuk.edit
FROM
    barang_masuk
    INNER JOIN beli_detail
        ON (barang_masuk.id_beli_detail = beli_detail.id_beli_detail)
WHERE beli_detail.id_beli_detail=$id AND barang_masuk.edit=1";
$q = mysqli_query($con, $sql);
$r=mysqli_num_rows($q);
if ($r>0){
	_direct("?page=gudang&mode=konfirm_beli_5&id=$id");
}

$sql = mysqli_query($con, "SELECT
    beli_detail.id_beli_detail
	, beli_detail.id_beli
    , beli_detail.qty
    , barang_masuk.id_barang_masuk
    , barang_masuk.qty_datang
    , barang_masuk_rak.qty_di_rak
FROM
    beli_detail
    LEFT JOIN barang_masuk
        ON (barang_masuk.id_beli_detail = beli_detail.id_beli_detail)
    LEFT JOIN barang_masuk_rak
        ON (barang_masuk_rak.id_barang_masuk = barang_masuk.id_barang_masuk)
WHERE beli_detail.id_beli_detail=$id
ORDER BY barang_masuk.id_barang_masuk ASC");
$qty2=0;
if (mysqli_num_rows($sql)=='0'){
	_alert("Barang sudah dihapus. Proses digagalkan.");
	_direct("?page=gudang&mode=konfirm_beli");
}
while ($r=mysqli_fetch_array($sql)){
$qty1=$r['qty'];
$id_barang_masuk=$r['id_barang_masuk'];
$qty_datang=$r['qty_datang'];
$qty2+=$r['qty_di_rak'];
$id_beli=$r['id_beli'];
}
//---------------------------------------------------------------------------------

if ($id_barang_masuk==''){
	$qty3=0;
} else {
	$sql = "SELECT SUM(qty_di_rak) AS qty_di_rak FROM barang_masuk_rak WHERE id_barang_masuk=$id_barang_masuk";
	$q = mysqli_query($con, $sql);
	$r=mysqli_fetch_array($q);
	$qty3=$r['qty_di_rak'];
}
$x=$qty1-$qty2;

/*if($qty_datang>$qty3){
	_direct("?page=gudang&mode=konfirm_beli_5&id=$id");
}*/

$sql = "SELECT
    satuan.nama_satuan
FROM
    beli_detail
    INNER JOIN barang_supplier
        ON (beli_detail.id_barang_supplier = barang_supplier.id_barang_supplier)
    INNER JOIN barang
        ON (barang_supplier.id_barang = barang.id_barang)
    INNER JOIN satuan
        ON (barang.id_satuan = satuan.id_satuan)
WHERE id_beli_detail=$id";
$q = mysqli_query($con, $sql);
$r=mysqli_fetch_array($q);
?>

<div class="right_col loading" role="main">
	<div class="">

		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<h3>KONFIRMASI NOTA BELI</h3>
						<?php
							if (isset($pesan)){
								echo '<span class="badge bg-' .$warna. '">' .$pesan. '</span>';
							}
						?>
						<div id="alert_me"></div>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
					<form action="" method="post" onsubmit="cek_valid();">
					<input type="hidden" name="edit_konfirm_beli_4_post" value="true">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-tags fa-fw"></i></span>
							<input class="form-control" id="qty_datang" type="tel" name="qty_datang" placeholder="Qty Datang" value="" maxlength="50" required>
							<span class="input-group-addon"><?php echo $r['nama_satuan'] ?></span>
							<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
						</div>
						<p align="center"><button type="submit" class="btn btn-primary">LANJUT</button></p>
					</form>
					</div>
				</div>
			</div>
			</div>
		</div>
	</div>
</div>

<script>
function cek_valid(){
	max = <?php echo $x ?>;
	me = $('#qty_di_rak').val();
	if (me>0 && me<=max){
		return true;
	}
	return false;
}
function getBack(){
	window.location='index.php?page=gudang&mode=konfirm_beli_3&id=<?php echo $id_beli ?>';
}
$(document).ready(function(){
	$('#qty_datang').inputmask('decimal', {allowMinus:false, autoGroup: true, groupSeparator: '.', rightAlign: false, autoUnmask: true, removeMaskOnSubmit: true});
	$('#qty_datang').change(function(e) {
		max = <?php echo $x ?>;
		me = $('#qty_datang').val();
		if (me>0 && me<=max){
			$('#alert_me').empty();
		} else {
			$('#qty_datang').val('');
			$('#alert_me').html('<span class="badge bg-red">Input gagal, qty datang harus > 0 dan &le; ' + max + '.</span>');
			$('html, body').animate({
				scrollTop: $('#alert_me').offset().top
			}, 1000);
		}
    });
});
</script>
