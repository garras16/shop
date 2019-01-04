<?php
$scan=true;
if (isset($edit_konfirm_retur_jual_3_post)){
	$tgl = explode("/", $expire);
	$expire = $tgl[2] ."-". $tgl[1] ."-". $tgl[0];
	$expire=date("Y-m-d", strtotime($expire));
	$sql=mysql_query("SELECT *
FROM
    nota_siap_kirim
    INNER JOIN nota_siap_kirim_detail 
        ON (nota_siap_kirim.id_nota_siap_kirim = nota_siap_kirim_detail.id_nota_siap_kirim)
    INNER JOIN barang_masuk_rak 
        ON (nota_siap_kirim_detail.id_barang_masuk_rak = barang_masuk_rak.id_barang_masuk_rak)
WHERE nota_siap_kirim.status='1' AND nota_siap_kirim_detail.id_jual_detail=$id_jual_detail LIMIT 1");
	$row=mysql_fetch_array($sql);
	$id_barang_masuk=$row['id_barang_masuk'];
	$sql=mysql_query("SELECT id_bmr FROM retur_jual_detail WHERE id_retur_jual_detail=$id");
	$row=mysql_fetch_array($sql);
	$id_bmr=$row['id_bmr'];
	if ($id_bmr==''){
		$sql=mysql_query("INSERT INTO barang_masuk_rak VALUES(null,$id_barang_masuk,0,$id_rak,'$expire',$qty_masuk)");
		$id_barang_masuk_rak=mysql_insert_id();
		$sql=mysql_query("UPDATE retur_jual_detail SET id_rak=$id_rak, expire='$expire', qty_masuk=$qty_masuk, id_bmr=$id_barang_masuk_rak WHERE id_retur_jual_detail=$id");
	} else {
		$sql=mysql_query("UPDATE retur_jual_detail SET id_rak=$id_rak, expire='$expire', qty_masuk=$qty_masuk WHERE id_retur_jual_detail=$id");
	}
	$scan=false;
}
$sql=mysql_query("SELECT
    retur_jual_detail.id_retur_jual_detail
    , retur_jual_detail.id_retur_jual
    , retur_jual_detail.id_jual_detail
    , retur_jual_detail.qty_retur
    , retur_jual_detail.qty_masuk
    , retur_jual_detail.expire
	, gudang.nama_gudang
	, rak.nama_rak
    , satuan.nama_satuan
FROM
    retur_jual_detail
    INNER JOIN jual_detail 
        ON (retur_jual_detail.id_jual_detail = jual_detail.id_jual_detail)
    LEFT JOIN rak 
        ON (retur_jual_detail.id_rak = rak.id_rak)
    INNER JOIN harga_jual 
        ON (jual_detail.id_harga_jual = harga_jual.id_harga_jual)
    INNER JOIN barang_supplier 
        ON (harga_jual.id_barang_supplier = barang_supplier.id_barang_supplier)
    INNER JOIN barang 
        ON (barang_supplier.id_barang = barang.id_barang)
    INNER JOIN satuan 
        ON (barang.id_satuan = satuan.id_satuan)
    LEFT JOIN gudang 
        ON (rak.id_gudang = gudang.id_gudang)
WHERE id_retur_jual_detail=$id");
$row=mysql_fetch_array($sql);
if ($row['qty_retur']==''){
	_alert("Retur detail mungkin sudah dihapus. Kembali ke menu sebelumnya.");
	_direct("?page=gudang&mode=konfirm_retur_jual");
}
$id_retur_jual=$row['id_retur_jual'];

if (isset($edit_konfirm_retur_jual_3_post)) _direct("?page=gudang&mode=konfirm_retur_jual_2&id=" .$id_retur_jual);

$id_jual_detail=$row['id_jual_detail'];
if ($row['expire']==''){
	$tgl=explode("-",date("Y-m-d"));
} else {
	$tgl=explode("-",$row['expire']);
}
$expire=$tgl[2]. '-' .$tgl[1]. '-' .$tgl[0];
$expire=date("d-m-Y", strtotime($expire));
?>
<div class="right_col loading" role="main">
	<div class="">
	
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<div class="col-md-6">
							<h3>KONFIRMASI RETUR JUAL</h3>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<form action="" method="post" onsubmit="return cek_valid();">
							<input type="hidden" name="edit_konfirm_retur_jual_3_post" value="true">
							<input type="hidden" name="id_jual_detail" value="<?php echo $id_jual_detail ?>">
							<p align="center"><a id="scan" onClick="AndroidFunction.scan_rak();" class="btn btn-primary">SCAN RAK</a>
							<a id="selesai" onClick="getBack();" class="btn btn-warning">SELESAI</a></p>
							<div id="div_gudang_rak"></div>
							<div class="input-group">
								<span class="input-group-addon" style="width:105px"><font size="1"><div class="text-left">Qty Retur</div></font></span>
								<input class="form-control" id="qty_retur" type="text" name="qty_retur" placeholder="Qty Retur" value="<?php echo $row['qty_retur'] ?>" disabled="disabled" readonly>
								<span class="input-group-addon"><?php echo $row['nama_satuan'] ?></span>
							</div>
							<div class="input-group">
								<span class="input-group-addon" style="width:105px"><font size="1"><div class="text-left">Qty Masuk</div></font></span>
								<input class="form-control" id="qty_masuk" type="tel" name="qty_masuk" placeholder="Qty Masuk" value="<?php echo $row['qty_masuk'] ?>" disabled="disabled" required>
								<span class="input-group-addon"><?php echo $row['nama_satuan'] ?></span>
							</div>
							<div class="input-group">
								<span class="input-group-addon" style="width:105px"><font size="1"><div class="text-left">Exp.</div></font></span>
								<input class="form-control" id="expire" type="tel" name="expire" placeholder="Tgl Exp." value="<?php echo $expire ?>" readonly="readonly" required>
								<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
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
function cek_scan_rak(barcode1){
	$('#scan').attr("style","display:none");
	$('#selesai').attr('style','display:none');
	$('#div_gudang_rak').load('assets/page/gudang/get-rak.php?id=' + barcode1, function(){
		if ($.trim($('#div_gudang_rak').html()) == ''){
			$('#scan').attr("style","");
			$('#selesai').attr("style","");
			AndroidFunction.showToast("Barcode Rak tidak ditemukan.");
		} else {
			$('#alert_me').empty();
			$('#scan').attr('style','display:none');
			$('#selesai').attr('style','display:none');
			$('#lanjut').removeAttr('style');
			$('#qty_masuk').removeAttr("disabled");
			$('#expire').removeAttr("readonly");
		}
	})
}
function barcode(kode1,kode2){
	if (kode1==kode2){
		$('#alert_me').empty();
		$('#scan').attr('style','display:none');
		$('#selesai').attr('style','display:none');
		$('#lanjut').removeAttr('style');
		$('#qty_masuk').removeAttr('disabled');
	} else {
		$('#alert_me').html('<span class="badge bg-red">Rak salah.</span>');
		$('html, body').animate({
			scrollTop: $('#alert_me').offset().top
		}, 1000);
	}
}
function cek_valid(){
	max = $('#qty_retur').val();
	me = $('#qty_masuk').val();
	if (me>=0 && me<=max){
		return true;
	}
	AndroidFunction.showToast('Qty Masuk tidak boleh melebihi Qty Retur');
	return false;
}
function getBack(){
	window.location='index.php?page=gudang&mode=konfirm_retur_jual_2&id=<?php echo $id_retur_jual ?>';
}

$(document).ready(function(){
	$('#qty_retur').inputmask('numeric', {allowMinus:false, autoGroup: true, groupSeparator: '.', rightAlign: false, autoUnmask: true, removeMaskOnSubmit: true});
	$('#qty_masuk').inputmask('numeric', {allowMinus:false, autoGroup: true, groupSeparator: '.', rightAlign: false, autoUnmask: true, removeMaskOnSubmit: true});
	$('#expire').inputmask("datetime",{inputFormat: "dd/mm/yyyy",oncomplete: function(){
		var x = new Date();
		var today = x.getDate() + "/" + parseInt(x.getMonth()+1) + "/" + x.getFullYear();
		var x = new Date(x.getFullYear() + "/" + parseInt(x.getMonth()+1) + "/" + x.getDate());
		var input = $(this).val();
		var i = input.split("/");	
		var y = new Date(i[2] + "/" + i[1] + "/" + i[0]);
		if (y >= x){
			
		} else {
			$(this).val('');
			AndroidFunction.showToast('Tanggal harus \u2265 ' + today + '.');
		}
	}});
	<?php if ($scan) echo "$('#scan').click();"; ?>
})
</script>
