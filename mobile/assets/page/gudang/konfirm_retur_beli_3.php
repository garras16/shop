<?php
$scan=true;
if (isset($edit_konfirm_retur_beli_3_post)){
	$sql=mysqli_query($con, "UPDATE retur_beli_detail SET qty_keluar=$qty_keluar WHERE id_retur_beli_detail=$id");
	$scan=false;
}
$sql=mysqli_query($con, "SELECT
    retur_beli_detail.id_retur_beli_detail
    , gudang.nama_gudang
    , rak.nama_rak
	, retur_beli_detail.id_retur_beli
    , retur_beli_detail.qty_retur
    , retur_beli_detail.qty_keluar
    , satuan.nama_satuan
FROM
    retur_beli_detail
    INNER JOIN barang_masuk_rak
        ON (retur_beli_detail.id_barang_masuk_rak = barang_masuk_rak.id_barang_masuk_rak)
    INNER JOIN beli_detail
        ON (retur_beli_detail.id_beli_detail = beli_detail.id_beli_detail)
    INNER JOIN barang_supplier
        ON (beli_detail.id_barang_supplier = barang_supplier.id_barang_supplier)
    INNER JOIN barang
        ON (barang_supplier.id_barang = barang.id_barang)
    INNER JOIN satuan
        ON (barang.id_satuan = satuan.id_satuan)
    INNER JOIN rak
        ON (barang_masuk_rak.id_rak = rak.id_rak)
    INNER JOIN gudang
        ON (rak.id_gudang = gudang.id_gudang)
WHERE id_retur_beli_detail=$id");
$row=mysqli_fetch_array($sql);
$id_retur_beli=$row['id_retur_beli'];
if ($row['qty_retur']==''){
	_alert("Retur detail mungkin sudah dihapus. Kembali ke menu sebelumnya.");
	_direct("?page=gudang&mode=konfirm_retur_beli");
}
?>
<div class="right_col loading" role="main">
	<div class="">

		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<div class="col-md-6">
							<h3>KONFIRMASI RETUR BELI</h3>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<form action="" method="post" onsubmit="return cek_valid();">
							<input type="hidden" name="edit_konfirm_retur_beli_3_post" value="true">
							<p align="center"><a id="scan" onClick="AndroidFunction.scan_rak('<?php echo $row['nama_rak'] ?>');" class="btn btn-primary">SCAN RAK</a>
							<a id="selesai" onClick="getBack();" class="btn btn-warning">SELESAI</a></p>
							<div id="div_gudang" class="input-group">
								<span class="input-group-addon"><i class="fa fa-tags fa-fw"></i><br><small>Gudang</small></span>
								<input class="form-control" id="gudang" type="text" name="gudang" style="padding: 19px 10px;" placeholder="Gudang" value="<?php echo $row['nama_gudang'] ?>" readonly>
								<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
							</div>
							<div id="div_rak" class="input-group">
								<span class="input-group-addon"><i class="fa fa-tags fa-fw" style="width: 34px;"></i><br><small>Rak</small></span>
								<input class="form-control" id="rak" type="text" name="rak" style="padding: 19px 10px;" placeholder="Rak" value="<?php echo $row['nama_rak'] ?>" readonly>
								<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
							</div>
							<div class="input-group">
								<span class="input-group-addon" style="width:105px"><font size="1"><div class="text-left">Qty Retur</div></font></span>
								<input class="form-control" id="qty_retur" type="text" name="qty_retur" placeholder="Qty Retur" value="<?php echo $row['qty_retur'] ?>" disabled="disabled" readonly>
								<span class="input-group-addon"><?php echo $row['nama_satuan'] ?></span>
							</div>
							<div class="input-group">
								<span class="input-group-addon" style="width:105px"><font size="1"><div class="text-left">Qty Keluar</div></font></span>
								<input class="form-control" id="qty_keluar" type="tel" name="qty_keluar" placeholder="Qty Keluar" value="<?php echo $row['qty_keluar'] ?>" disabled="disabled" required>
								<span class="input-group-addon"><?php echo $row['nama_satuan'] ?></span>
							</div>
							<div id="alert_me"></div>
							<p align="center"><button id="lanjut" type="submit" class="btn btn-primary" style="display:none">SIMPAN</button></p>
						</form>




				</div>
				<div id="dummy"></div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
function barcode(kode1,kode2){
	if (kode1==kode2){
		$('#alert_me').empty();
		$('#scan').attr('style','display:none');
		$('#selesai').attr('style','display:none');
		$('#lanjut').removeAttr('style');
		$('#qty_keluar').removeAttr('disabled');
	} else {
		$('#alert_me').html('<span class="badge bg-red">Rak salah.</span>');
		$('html, body').animate({
			scrollTop: $('#alert_me').offset().top
		}, 1000);
	}
}
function cek_valid(){
	max = Number($('#qty_retur').val());
	me = Number($('#qty_keluar').val());
	if (me>0 && me<=max){
		return true;
	} else {
		if (me==0) AndroidFunction.showToast('Qty Keluar harus lebih dari 0');
		if (me>max) AndroidFunction.showToast('Qty Keluar tidak boleh melebihi Qty Retur');
		return false;
	}
}
function getBack(){
	window.location='index.php?page=gudang&mode=konfirm_retur_beli_2&id=<?php echo $id_retur_beli ?>';
}

$(document).ready(function(){
	$('#qty_retur').inputmask('decimal', {allowMinus:false, autoGroup: true, groupSeparator: '.', rightAlign: false, autoUnmask: true, removeMaskOnSubmit: true});
	$('#qty_keluar').inputmask('decimal', {allowMinus:false, autoGroup: true, groupSeparator: '.', rightAlign: false, autoUnmask: true, removeMaskOnSubmit: true});
	<?php if ($scan) echo "$('#scan').click();"; ?>
})
</script>
