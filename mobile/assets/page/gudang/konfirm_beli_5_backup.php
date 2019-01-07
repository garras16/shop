<?php
if (isset($edit_konfirm_beli_5_post)){
	$sql = "SELECT
    beli_detail.id_beli
    , beli_detail.qty
    , barang_masuk.qty_datang
    , barang_masuk_rak.qty_di_rak
FROM
    barang_masuk
    INNER JOIN beli_detail 
        ON (barang_masuk.id_beli_detail = beli_detail.id_beli_detail)
    LEFT JOIN barang_masuk_rak 
        ON (barang_masuk_rak.id_barang_masuk = barang_masuk.id_barang_masuk)
	WHERE beli_detail.id_beli_detail=$id";
	$q = mysqli_query($con, $sql);
	$r=mysqli_fetch_array($q);
	$qty1=$r['qty'];
	($r['qty_di_rak']=='' ? $qty2=0 : $qty2=$r['qty_di_rak']);
	if ($qty1 >= $qty2+$qty_di_rak){
		$tgl=explode("/",$expire);
		$expire=$tgl[2]. '/' .$tgl[1]. '/' .$tgl[0];
		$expire=date("Y-m-d", strtotime($expire));
		$sql = "INSERT INTO barang_masuk_rak VALUES(null,$id_barang_masuk,$qty_di_rak,$id_gudang,$id_rak,'$expire')";
		$q = mysqli_query($con, $sql);
		if ($q){
			$pesan="Input Berhasil";
			$warna="green";
		} else {
			$pesan="Input Gagal";
			$warna="red";
		}
	} else {
		$pesan="Input Gagal. Qty di rak melebihi Qty beli";
		$warna="red";
	}
}



//----------------------------------------------------------------------

$sql = "SELECT id_beli, qty FROM beli_detail WHERE id_beli_detail=$id";
$q = mysqli_query($con, $sql);
$r=mysqli_fetch_array($q);
$qty1=$r['qty'];
$id_beli=$r['id_beli'];

$sql = "SELECT id_barang_masuk, qty_datang FROM barang_masuk WHERE id_beli_detail=$id AND edit=1 ORDER BY id_barang_masuk ASC";
$q = mysqli_query($con, $sql);
$r=mysqli_fetch_array($q);
$id_barang_masuk=$r['id_barang_masuk'];
$qty_datang=$r['qty_datang'];

$sql = "SELECT SUM(qty_di_rak) AS qty_di_rak FROM barang_masuk_rak WHERE id_barang_masuk=$id_barang_masuk";
$q = mysqli_query($con, $sql);
$r=mysqli_fetch_array($q);
$qty2=$r['qty_di_rak'];
if ($qty2=='') $qty2=0;
$x=$qty_datang-$qty2;

$sql = "SELECT
    SUM(barang_masuk_rak.qty_di_rak) AS qty_di_rak
FROM
    barang_masuk_rak
    INNER JOIN barang_masuk 
        ON (barang_masuk_rak.id_barang_masuk = barang_masuk.id_barang_masuk) WHERE id_beli_detail=$id";
$q = mysqli_query($con, $sql);
$r=mysqli_fetch_array($q);

if ($qty1==$r['qty_di_rak']){
	$sql = "UPDATE beli_detail SET status_barang=1 WHERE id_beli_detail=$id";
	$q = mysqli_query($con, $sql);
} else {
	$sql = "UPDATE beli_detail SET status_barang=2 WHERE id_beli_detail=$id";
	$q = mysqli_query($con, $sql);
}

//---------------------------------------------------------------------------------------------
$sql = "SELECT id_beli, status_barang FROM beli_detail WHERE id_beli=$id_beli";
$q = mysqli_query($con, $sql);
$jml_baris=mysqli_num_rows($q);
$baris_sukses=0;
$baris_pending=0;
while ($r=mysqli_fetch_array($q)){
	if ($r['status_barang']==1) $baris_sukses+=1;
	if ($r['status_barang']==2) $baris_pending+=1;
}
$status_konfirm=0;
if ($baris_sukses==$jml_baris){
	$status_konfirm=1;
} else if ($baris_pending>0 || $baris_sukses>0){
	$status_konfirm=2;
}
$sql = "UPDATE beli SET status_konfirm=$status_konfirm WHERE id_beli=$id_beli";
$q = mysqli_query($con, $sql);

//---------------------------------------------------------------------------------------------
if ($qty1==$qty2){
	_clearHistory();
	_direct("?page=gudang&mode=konfirm_beli_3&landscape&id=" .$id_beli);
}
if (isset($edit_konfirm_beli_5_post) && $qty_datang==$qty2){
	$sql = "UPDATE barang_masuk SET edit=0 WHERE id_barang_masuk=$id_barang_masuk";
	$q = mysqli_query($con, $sql);
	_clearHistory();
	_direct("?page=gudang&mode=konfirm_beli_3&landscape&id=" .$id_beli);
}
//-----------------------------------------------------------------------------------------------

$sql=mysqli_query($con, "SELECT
    beli_detail.id_beli_detail
    , beli_detail.qty
    , satuan.nama_satuan
    , barang_masuk.id_barang_masuk
    , barang_masuk.qty_datang
    , SUM(barang_masuk_rak.qty_di_rak) AS qty_di_rak
FROM
    beli_detail
    INNER JOIN barang_supplier 
        ON (beli_detail.id_barang_supplier = barang_supplier.id_barang_supplier)
    INNER JOIN barang 
        ON (barang_supplier.id_barang = barang.id_barang)
    INNER JOIN satuan 
        ON (barang.id_satuan = satuan.id_satuan)
    LEFT JOIN barang_masuk 
        ON (barang_masuk.id_beli_detail = beli_detail.id_beli_detail)
    LEFT JOIN barang_masuk_rak 
        ON (barang_masuk_rak.id_barang_masuk = barang_masuk.id_barang_masuk)
WHERE beli_detail.id_beli_detail=$id AND barang_masuk.edit=1
ORDER BY barang_masuk.id_barang_masuk ASC");
$row=mysqli_fetch_array($sql);
$nama_satuan=$row['nama_satuan'];
$id_barang_masuk=$row['id_barang_masuk'];
$qty_datang=$row['qty_datang'];
$total_qty_di_rak=$row['qty_di_rak'];
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
					<form action="" method="post" onsubmit="return cek_valid();">
					<input type="hidden" name="edit_konfirm_beli_5_post" value="true">
					<input type="hidden" name="id_barang_masuk" value="<?php echo $id_barang_masuk ?>">
						<div id="div_gudang_rak">
						</div>
						<p align="center"><a id="scan" onClick="scan_rak.performClick();" class="btn btn-primary">SCAN RAK</a>
						<a onClick="selesai_in();" id="selesai" class="btn btn-warning">SELESAI</a></p>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-tags fa-fw"></i></span>
							<input class="form-control" id="qty_di_rak" type="tel" name="qty_di_rak" placeholder="Qty di Rak" value="" maxlength="50" disabled="disabled" required>
							<span class="input-group-addon"><?php echo $nama_satuan ?></span>
							<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
						</div>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
							<input class="form-control" id="expire" type="tel" name="expire" placeholder="Tgl Expired" disabled="disabled" required>
							<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
						</div>
						<div class="input-group">
							<span class="input-group-addon" style="width:105px"><font size="1"><div class="text-left">Qty Datang</div></font></span>
							<input class="form-control" id="qty_datang" type="text" name="qty_datang" placeholder="Qty Datang" value="<?php echo $qty_datang ?>" disabled="disabled" readonly>
							<span class="input-group-addon"><?php echo $nama_satuan ?></span>
						</div>
						<div class="input-group">
							<span class="input-group-addon" style="width:105px"><font size="1"><div class="text-left">Qty Masuk Di Rak</div></font></span>
							<input class="form-control" id="total_qty_di_rak" type="text" name="total_qty_di_rak" placeholder="Qty Masuk di Rak" value="<?php echo $qty2 ?>" maxlength="50" readonly>
							<span class="input-group-addon"><?php echo $nama_satuan ?></span>
						</div>
						<div id="alert_me"></div>
						<p align="center"><button id="lanjut" type="submit" class="btn btn-primary" style="display:none">SIMPAN</button></p>
					</form>
					</div>
				</div>
				<div class="x_panel">
					<div class="x_content">
						<div clas="col-xs-2">
							<a class="btn btn-xs" style="width:10px;height:10px;background-color: yellow">&nbsp;</a><font color="red">Sedang proses input</font>
							<a class="btn btn-xs" style="width:10px;height:10px;margin-left:20px;background-color:red">&nbsp;</a><font color="red">Belum Lengkap</font>
						</div>
						<div style="overflow-x: auto">
						<table class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>Tgl Datang</th>
									<th>Gudang</th>
									<th>Rak</th>
									<th>Qty Datang</th>
									<th>Qty di Rak</th>
									<th>Sat</th>
									<th>Kadaluarsa</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<?php
$sql=mysqli_query($con, "SELECT
    barang_masuk.id_barang_masuk
	, barang_masuk.edit
    , barang_masuk.tgl_datang
	, barang_masuk.qty_datang
	, barang_masuk_rak.id_barang_masuk
	, barang_masuk_rak.id_barang_masuk_rak
    , barang_masuk_rak.qty_di_rak
    , barang_masuk_rak.expire
    , gudang.nama_gudang
    , rak.nama_rak
    , satuan.nama_satuan
FROM
    barang_masuk
    INNER JOIN beli_detail 
        ON (barang_masuk.id_beli_detail = beli_detail.id_beli_detail)
    INNER JOIN barang_supplier 
        ON (beli_detail.id_barang_supplier = barang_supplier.id_barang_supplier)
    INNER JOIN barang 
        ON (barang_supplier.id_barang = barang.id_barang)
    INNER JOIN satuan 
        ON (barang.id_satuan = satuan.id_satuan)
    INNER JOIN barang_masuk_rak 
        ON (barang_masuk_rak.id_barang_masuk = barang_masuk.id_barang_masuk)
    INNER JOIN gudang 
        ON (barang_masuk_rak.id_gudang = gudang.id_gudang)
    INNER JOIN rak 
        ON (barang_masuk_rak.id_rak = rak.id_rak) WHERE barang_masuk.id_beli_detail=$id");
$test='';
while($row=mysqli_fetch_array($sql)){
$id_barang_masuk_query=$row['id_barang_masuk'];
$sql2=mysqli_query($con, "SELECT
	barang_masuk.id_barang_masuk
    , barang_masuk.qty_datang
    , barang_masuk_rak.qty_di_rak
FROM
    barang_masuk_rak
    INNER JOIN barang_masuk 
        ON (barang_masuk_rak.id_barang_masuk = barang_masuk.id_barang_masuk)
WHERE barang_masuk.id_barang_masuk=$id_barang_masuk_query");
$r=mysqli_num_rows($sql2);
$val=""; $val2=""; $val3="";
if ($row['edit']=='1') $val3="color: red; font-weight:bold";
if ($row['id_barang_masuk']==$id_barang_masuk) $val="font-color: black; background-color: yellow;";
	echo '			<tr style="' .$val. '">
						<td><div style="min-width:70px; ' .$val3. '">' .date("d-m-Y", strtotime($row['tgl_datang'])). '</div></td>
						<td><div style="min-width:70px; ' .$val3. '">' .$row['nama_gudang']. '</div></td>
						<td><div style="min-width:70px; ' .$val3. '">' .$row['nama_rak']. '</div></td>';
	if ($test != $row['id_barang_masuk']){
		echo '			<td style="vertical-align:middle;text-align:center" rowspan="' . $r . '"><div style="min-width:70px; ' .$val3. '">' .$row['qty_datang']. '</div></td>';
		$test = $row['id_barang_masuk'];
	}
	echo '				<td><div style="min-width:70px; ' .$val3. '">' .$row['qty_di_rak']. '</div></td>
						<td><div style="min-width:70px; ' .$val3. '">' .$row['nama_satuan']. '</div></td>
						<td><div style="min-width:70px; ' .$val3. '">' .date("d-m-Y", strtotime($row['expire'])). '</div></td>
						<td><a onClick="del_rak(' .$row['id_barang_masuk_rak']. ');" class="btn btn-primary btn-xs"><i class="fa fa-trash"></i></a></td>';
	echo '			</tr>';
}
?>
					
				</tbody>
			</table>
			<div id="dummy"></div>
				</div>
					</div>
				</div>
			</div>
		</div>	
	</div>
</div>

<script>
function barcode(kode){
	$('#div_gudang_rak').load('assets/page/gudang/get-rak.php?id=' + kode, function(){
		if ($.trim($('#div_gudang_rak').html()) == ''){
			$('#alert_me').html('<span class="badge bg-red">Rak tidak ada.</span>');
			$('html, body').animate({
				scrollTop: $('#alert_me').offset().top
			}, 1000);
			//AndroidFunction.showToast("Rak tidak ada.");
		} else {
			$('#alert_me').empty();
			$('#scan').attr('style','display:none');
			$('#selesai').attr('style','display:none');
			$('#lanjut').removeAttr('style');
			$('#qty_di_rak').removeAttr('disabled');
			$('#expire').removeAttr('disabled');
		}
	});	
}
function del_rak(id){
	$('#dummy').load('assets/page/gudang/del-rak.php?id_barang_masuk_rak=' + id);
	location.reload();
}
function cek_valid(){
	max = <?php echo $x ?>;
	me = $('#qty_di_rak').val();
	if (me>0 && me<=max){
		return true;
	}
	return false;
}
function selesai_in(){
	AndroidFunction.clearHistory();
	window.location='index.php?page=gudang&mode=konfirm_beli_3&id=<?php echo $id_beli ?>';
}
$(document).ready(function(){
	$('#qty_di_rak').inputmask('decimal', {allowMinus:false, autoGroup: true, groupSeparator: '.', rightAlign: false, autoUnmask: true, removeMaskOnSubmit: true});
	$('#qty_di_rak').change(function(e) {
		max = <?php echo $x ?>;
		me = $('#qty_di_rak').val();
		if (me>0 && me<=max){
			$('#alert_me').empty();
		} else {
			$('#qty_di_rak').val('');
			$('#alert_me').html('<span class="badge bg-red">Input gagal, qty di rak harus > 0 dan &le; ' + max + '.</span>');
			$('html, body').animate({
				scrollTop: $('#alert_me').offset().top
			}, 1000);
		}
    });
	var now = new Date();
/*	$('#expire').daterangepicker({
		locale: {
			format: 'DD-MM-YYYY'
		},
		minDate: now,
		singleDatePicker: true
	});*/
	$('#expire').inputmask("alias","dd/mm/yyyy");
});
</script>
