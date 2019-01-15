<?php
if (isset($_GET['del'])){
	$id_b_masuk_rak=$_GET['del'];
	$sql=mysqli_query($con, "SELECT id_barang_masuk FROM barang_masuk_rak WHERE id_barang_masuk_rak=$id_b_masuk_rak");
	$r=mysqli_fetch_array($sql);
	$id_b_masuk=$r['id_barang_masuk'];
	$sql="DELETE FROM barang_masuk_rak WHERE id_barang_masuk_rak=$id_b_masuk_rak";
	$q=mysqli_query($con, $sql);
	if ($q) $sql=mysqli_query($con, "UPDATE barang_masuk SET edit=1 WHERE id_barang_masuk=$id_b_masuk");
	
	$sql=mysqli_query($con, "SELECT * FROM barang_masuk_rak WHERE id_barang_masuk=$id_b_masuk");
	if (mysqli_num_rows($sql)==0){
		$sql2="DELETE FROM barang_masuk WHERE id_barang_masuk=$id_b_masuk";
		$q2=mysqli_query($con, $sql2);
	}
}
if (isset($_GET['del_qty_datang'])){
	$id_barang_masuk=$_GET['del_qty_datang'];
	$sql=mysqli_query($con, "DELETE FROM barang_masuk_rak WHERE id_barang_masuk=$id_barang_masuk");
	$sql=mysqli_query($con, "DELETE FROM barang_masuk WHERE id_barang_masuk=$id_barang_masuk");
}
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
		$sql = "INSERT INTO barang_masuk_rak VALUES(null,$id_barang_masuk,$qty_di_rak,$id_rak,'$expire',0)";
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

if (! isset($_GET['id_barang_masuk'])){
	include "custom_get_code_1.php";
} else {
	include "custom_get_code_2.php";
}
//include "custom_get_code_3.php";

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
						<p align="center"><a id="scan" onClick="AndroidFunction.scan_rak();" class="btn btn-primary">SCAN RAK</a>
						<a onClick="selesai_in();" id="selesai" class="btn btn-warning">SELESAI</a></p>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-tags fa-fw"></i></span>
							<input class="form-control" id="qty_di_rak" type="tel" name="qty_di_rak" placeholder="Qty di Rak" value="" maxlength="50" disabled="disabled" required>
							<span class="input-group-addon"><?php echo $nama_satuan ?></span>
							<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
						</div>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
							<input class="form-control" id="expire" type="tel" name="expire" placeholder="Tgl Exp." disabled="disabled" required>
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
									<th>Tgl Exp.</th>
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
    , barang_masuk_rak.id_barang_masuk_rak
    , barang_masuk_rak.id_barang_masuk
    , barang_masuk_rak.qty_di_rak
    , barang_masuk_rak.expire
    , satuan.nama_satuan
    , gudang.nama_gudang
    , rak.nama_rak
FROM
    barang_masuk_rak
    LEFT JOIN barang_masuk 
        ON (barang_masuk_rak.id_barang_masuk = barang_masuk.id_barang_masuk)
    LEFT JOIN rak 
        ON (barang_masuk_rak.id_rak = rak.id_rak)
    LEFT JOIN gudang 
        ON (rak.id_gudang = gudang.id_gudang)
    INNER JOIN beli_detail 
        ON (barang_masuk.id_beli_detail = beli_detail.id_beli_detail)
    INNER JOIN barang_supplier 
        ON (beli_detail.id_barang_supplier = barang_supplier.id_barang_supplier)
    INNER JOIN barang 
        ON (barang_supplier.id_barang = barang.id_barang)
    INNER JOIN satuan 
        ON (barang.id_satuan = satuan.id_satuan) 
WHERE barang_masuk.id_beli_detail=$id
ORDER BY barang_masuk_rak.id_barang_masuk");
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
						<td style="vertical-align:middle"><a href="?page=gudang&mode=konfirm_beli_5&id=' .$id. '&id_barang_masuk=' .$row['id_barang_masuk']. '"><div style="min-width:70px; ' .$val3. '">' .date("d-m-Y", strtotime($row['tgl_datang'])). '</div></a></td>
						<td style="vertical-align:middle"><a href="?page=gudang&mode=konfirm_beli_5&id=' .$id. '&id_barang_masuk=' .$row['id_barang_masuk']. '"><div style="min-width:70px; ' .$val3. '">' .$row['nama_gudang']. '</div></a></td>
						<td style="vertical-align:middle"><a href="?page=gudang&mode=konfirm_beli_5&id=' .$id. '&id_barang_masuk=' .$row['id_barang_masuk']. '"><div style="min-width:70px; ' .$val3. '">' .$row['nama_rak']. '</div></a></td>';
	if ($test != $row['id_barang_masuk']){
		echo '			<td style="vertical-align:middle;text-align:center" rowspan="' . $r . '">' .$row['qty_datang']. ' ' .$row['nama_satuan']. '<br><a href="?page=gudang&mode=konfirm_beli_5&id=' .$id. '&del_qty_datang=' .$row['id_barang_masuk']. '" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Hapus</a></td>';
		$test = $row['id_barang_masuk'];
	}
	($row['qty_di_rak']=='' ? $qty_rak='' : $qty_rak=$row['qty_di_rak']. ' ' .$row['nama_satuan']);
	echo '				<td style="vertical-align:middle"><a href="?page=gudang&mode=konfirm_beli_5&id=' .$id. '&id_barang_masuk=' .$row['id_barang_masuk']. '"><div style="min-width:70px; ' .$val3. '">' .$qty_rak. '</div></a></td>
						<td style="vertical-align:middle"><a href="?page=gudang&mode=konfirm_beli_5&id=' .$id. '&id_barang_masuk=' .$row['id_barang_masuk']. '"><div style="min-width:70px; ' .$val3. '">' .date("d-m-Y", strtotime($row['expire'])). '</div></a></td>
						<td style="vertical-align:middle"><a href="?page=gudang&mode=konfirm_beli_5&id=' .$id. '&id_barang_masuk=' .$row['id_barang_masuk']. '&del=' .$row['id_barang_masuk_rak']. '" class="btn btn-primary btn-xs"><div style="min-width:70px;"><i class="fa fa-trash"></i></div</a></td>
					</tr>';
}
//untuk qty_datang tanpa rak
$sql=mysqli_query($con, "SELECT
    barang_masuk.id_barang_masuk
    , beli_detail.id_beli
    , barang_masuk.tgl_datang
    , barang_masuk.qty_datang
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
	LEFT JOIN barang_masuk_rak 
        ON (barang_masuk_rak.id_barang_masuk = barang_masuk.id_barang_masuk)
WHERE barang_masuk.id_beli_detail=$id AND barang_masuk_rak.id_barang_masuk IS NULL AND edit=1");
if (mysqli_num_rows($sql)>0){
	$row=mysqli_fetch_array($sql);
	echo '			<tr>
						<td style="vertical-align:middle"><div style="min-width:70px; color: red; font-weight:bold">' .date("d-m-Y", strtotime($row['tgl_datang'])). '</div></td>
						<td style="vertical-align:middle"><div style="min-width:70px; color: red; font-weight:bold"></div></td>
						<td style="vertical-align:middle"><div style="min-width:70px; color: red; font-weight:bold"></div></a></td>
						<td style="vertical-align:middle;text-align:center"><div style="min-width:70px; color: red; font-weight:bold">' .$row['qty_datang']. ' ' .$row['nama_satuan']. '<br>
							<a href="?page=gudang&mode=konfirm_beli_5&id=' .$id. '&del_qty_datang=' .$row['id_barang_masuk']. '" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Hapus</a>
						</div></td>
						<td style="vertical-align:middle"><div style="min-width:70px; color: red; font-weight:bold"></div></td>
						<td style="vertical-align:middle"><div style="min-width:70px; color: red; font-weight:bold"></div></td>
						<td></td>
					</tr>';
}
?>
					
				</tbody>
			</table>
			<!--div id="dummy"></div-->
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
/*function del_rak(id){
	$('#dummy').load('assets/page/gudang/del-rak.php?id_barang_masuk_rak=' + id);
	location = location['href'];
}*/
function enable_scan(){
	$('#scan').removeAttr('style');
}
function disable_scan(){
	$('#scan').attr('style','display:none');
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
//	AndroidFunction.clearAllHistory();
	window.location='index.php?page=gudang&mode=konfirm_beli_3&id=<?php echo $id_beli ?>';
}
function getBack(){
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
	$('#expire').inputmask("datetime",{inputFormat: "dd/mm/yyyy",oncomplete: function(){
		var x = new Date();
		var today = x.getDate() + "/" + parseInt(x.getMonth()+1) + "/" + x.getFullYear();
		var x = new Date(x.getFullYear() + "/" + parseInt(x.getMonth()+1) + "/" + x.getDate());
		var input = $(this).val();
		var i = input.split("/");	
		var y = new Date(i[2] + "/" + i[1] + "/" + i[0]);
		if (y >= x){
			$('#alert_me').empty();
		} else {
			$(this).val('');
			$('#alert_me').html('<span class="badge bg-red">Input gagal, tanggal harus &ge; ' + today + '.</span>');
			$('html, body').animate({
				scrollTop: $('#alert_me').offset().top
			}, 1000);
		}
	}});
	AndroidFunction.scan_rak();
});
</script>
