<?php
if (isset($edit_konfirm_beli_3_post)){
	$id_beli_detail[] = implode(',',$id_beli_detail);
	$berat_volume[] = implode(',',$berat_volume);
	$val_berat_volume[] = implode(',',$val_berat_volume);
	$total_berat=0; $total_volume=0;
	for ($i=0;$i<count($id_beli_detail)-1;$i++) {
		if ($berat_volume[$i]=='berat'){
			$berat=$val_berat_volume[$i];
			$volume='null';
			$total_berat+=$berat;
		} else {
			$berat='null';
			$volume=$val_berat_volume[$i];
			$total_volume+=$volume;
		}
		$sql = mysqli_query($con, "UPDATE barang_masuk SET berat=$berat,volume=$volume WHERE id_beli_detail=$id_beli_detail[$i]");
	}
	if($tarif<>''){
		$sql = mysqli_query($con, "UPDATE beli SET berat_ekspedisi=$total_berat,volume_ekspedisi=$total_volume,tarif_ekspedisi=$tarif,status_konfirm=1 WHERE id_beli=$id");
	} else {
		$sql = mysqli_query($con, "UPDATE beli SET berat_ekspedisi=$total_berat,volume_ekspedisi=$total_volume WHERE id_beli=$id");
	}
	if ($sql){
		_buat_pesan("Input Berhasil.","green");
	} else {
		_buat_pesan("Input Gagal","red");
	}
	_direct("?page=gudang&mode=konfirm_beli");
}

$brg=mysqli_query($con, "SELECT
	beli.no_nota_beli
	, beli.tanggal
	, beli.id_karyawan
	, beli.berat_ekspedisi
	, beli.volume_ekspedisi
	, beli.tarif_ekspedisi
	, beli.status_konfirm
    , supplier.nama_supplier
    , ekspedisi.nama_ekspedisi
    , users.user
FROM
    beli
    LEFT JOIN supplier
        ON (beli.id_supplier = supplier.id_supplier)
    LEFT JOIN ekspedisi
        ON (beli.id_ekspedisi = ekspedisi.id_ekspedisi)
    LEFT JOIN users
        ON (beli.id_karyawan = users.id_karyawan)
    LEFT JOIN beli_detail
        ON (beli_detail.id_beli = beli.id_beli) WHERE beli.id_beli=$id");
$row=mysqli_fetch_array($brg);
$status_konfirm=$row['status_konfirm'];
$total_berat=$row['berat_ekspedisi'];
$total_volume=$row['volume_ekspedisi'];
$tarif=$row['tarif_ekspedisi'];
if ($row['user']==null){
	$user=$_SESSION['user'];
	$id_user=$_SESSION['id_karyawan'];
} else {
	$user=$row['user'];
	$id_user=$row['id_karyawan'];
}
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
						<div class="col-xs-6">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-tags fa-fw"></i></span>
								<input class="form-control" id="no_nota_beli" type="text" name="no_nota_beli" placeholder="No Nota Beli" value="<?php echo $row['no_nota_beli'] ?>" maxlength="50" readonly>
								<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
							</div>
						</div>
						<div class="col-xs-6">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
								<input class="form-control" id="tanggal" name="tanggal" placeholder="Tanggal Nota Beli" value="<?php echo date("d-m-Y",strtotime($row['tanggal'])) ?>" maxlength="50" readonly>
								<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
							</div>
						</div>
						<div class="col-xs-6">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-building fa-fw"></i></span>
							<input class="form-control" id="supplier" type="text" name="supplier" placeholder="Supplier" value="<?php echo $row['nama_supplier'] ?>" maxlength="50" readonly>
							<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
						</div>
						</div>
						<div class="col-xs-6">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
							<input class="form-control" id="penerima" type="text" name="penerima" placeholder="Penerima Barang" value="<?php echo $user ?>" maxlength="50" readonly>
							<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
						</div>
						</div>
						<div class="col-xs-6">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-truck fa-fw"></i></span>
							<input class="form-control" id="ekspedisi" type="text" name="ekspedisi" placeholder="Nama Ekspedisi" value="<?php echo $row['nama_ekspedisi'] ?>" maxlength="50" readonly>
							<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
						</div>
						</div>
						<div class="clearfix"></div>
						<div class="col-xs-12">
							<a class="btn btn-primary btn-xs" style="width:10px;height:10px">&nbsp;</a><font color="red">Belum pernah scan</font>
							<a class="btn btn-warning btn-xs" style="width:10px;height:10px;margin-left:20px">&nbsp;</a><font color="red">Sudah pernah scan</font>
						</div>
						<div class="clearfix"></div>
						<form action="" method="post">
							<input type="hidden" name="edit_konfirm_beli_3_post" value="true">
						<div class="table-responsive">
						<table class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>Nama Barang</th>
									<th>Qty Beli</th>
									<th>Qty Datang</th>
									<th>Scan Barang</th>
									<?php
									if ($status_konfirm <> 1){
										echo '<th>Berat / Volume</th>';
									} else {
										echo '<th>Berat</th>
											<th>Volume</th>';
									}
									?>
								</tr>
							</thead>
							<tbody>
								<?php
$sql=mysqli_query($con, "SELECT
    beli_detail.id_beli
    , beli_detail.id_beli_detail
    , beli_detail.status_barang
    , SUM(barang_masuk_rak.qty_di_rak) AS qty_datang
    , barang.nama_barang
    , barang.barcode
	, barang_masuk.berat
	, barang_masuk.volume
    , beli_detail.qty
    , satuan.nama_satuan
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
WHERE id_beli=$id
GROUP BY beli_detail.id_beli_detail");
/*
	STATUS BARANG
	0 = KOSONG
	1 = SELESAI
	2 = MENUNGGU
*/
$n=mysqli_num_rows($sql);
$x=0;
while($row=mysqli_fetch_array($sql)){
/*if ($row['status_barang']==0){
	$status=''
} else if ($row['status_barang']==1){
	$status='SELESAI';
} else {
	$status='MENUNGGU';
}*/
if ($row['qty_datang']>0) $x+=1;
($row['qty_datang']=='' ? $qty_datang='' : $qty_datang=$row['qty_datang']. ' ' .$row['nama_satuan']);
	echo '			<tr>
						<td><a data-toggle="modal" data-target="#myModal" data-id="' .$row['id_beli_detail']. '"><div style="height:100%;width:100%">&nbsp;' .$row['nama_barang']. '</div></a></td>
						<td><a data-toggle="modal" data-target="#myModal" data-id="' .$row['id_beli_detail']. '"><div style="height:100%;width:100%">&nbsp;' .$row['qty']. ' ' .$row['nama_satuan']. '</div></a></td>
						<td><a data-toggle="modal" data-target="#myModal" data-id="' .$row['id_beli_detail']. '"><div style="height:100%;width:100%">&nbsp;' .$qty_datang. '</div></a></td>';
if ($row['status_barang']==0 && $status_konfirm <> 1){
// AndroidFunction.scan_barang();
echo '<td><div style="text-align:center"><a data-barcode="' .$row['barcode']. '" class="btn btn-primary btn-xs barcode" onClick="AndroidFunction.scan_barang(&quot;' .$row['barcode']. '&quot;,&quot;' .$row['id_beli_detail']. '&quot;);"><div style="width:70px"><i class="fa fa-barcode"></i></div></a></div></td>';
} else if ($row['status_barang']==2 && $status_konfirm <> 1){
	echo '<td><div style="text-align:center"><a data-barcode="' .$row['barcode']. '" class="btn btn-warning btn-xs barcode" onClick="AndroidFunction.scan_barang(&quot;' .$row['barcode']. '&quot;,&quot;' .$row['id_beli_detail']. '&quot;);"><div style="width:70px"><i class="fa fa-barcode"></i></div></a></div></td>';
} else {
	echo '<td><div style="text-align:center"><i class="fa fa-check fa-fw" style="color:green"></i><div style="height:100%;width:100%"></div></div></td>';
}
	if ($status_konfirm <> 1){
	if($row['berat']<>'') {
		$berat_volume='berat';
		$val_berat_volume=$row['berat'];
	} elseif($row['volume']<>'') {
		$berat_volume='volume';
		$val_berat_volume=$row['volume'];
	} else {
		$berat_volume='berat';
		$val_berat_volume='';
	}
	echo '<td width="315px" class="td_berat" style="display:none"><select name="berat_volume[]" style="height:24px" value="volume" required>
			<option value="berat" '.($berat_volume=='berat' ? 'selected' : ''). '>BERAT (GRAM)</option>
			<option value="volume" '.($berat_volume=='volume' ? 'selected' : ''). '>VOLUME (CM3)</option>
		</select>
		<input type="tel" class="mask" name="val_berat_volume[]" placeholder="Berat/Volume Qty Datang" value="' .$val_berat_volume. '" maxlength="50" style="height:24px" autocomplete="off" required>
		<input type="hidden" name="id_beli_detail[]" value="' .$row['id_beli_detail']. '">
		</td></tr>';
	} else {
	($row['berat']<>'' ? $berat=format_angka($row['berat']). ' gr' : $berat='');
	($row['volume']<>'' ? $volume=format_angka($row['volume']). ' cm<sup>3</sup>' : $volume='');

		echo '<td align="right">' .$berat. '</td>
			<td align="right">' .$volume. '</td>
		</tr>';
	}
}
			if ($status_konfirm=='1'){
				($total_berat<>'0' ? $total_berat=format_angka($total_berat). ' gr' : $total_berat='');
				($total_volume<>'0' ? $total_volume=format_angka($total_volume). ' cm<sup>3</sup>' : $total_volume='');
				echo '<tr>
						<td colspan="4">Total</td>
						<td align="right">' .$total_berat. '</td>
						<td align="right">' .$total_volume. '</td>
					</tr>';
				echo '<tr>
						<td colspan="5">Tarif Ekspedisi</td>
						<td align="right">Rp. ' .format_uang($tarif). '</td>
					</tr>';
			}
?>
				</tbody>
			</table>
			</div>
			<?php
			if ($n==$x && $status_konfirm <> 1){
				echo "<script>$('.td_berat').attr('style','');</script>";
				echo '<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-money fa-fw"></i></span>
							<input class="form-control mask" id="tarif" type="tel" name="tarif" placeholder="Tarif Ekspedisi Berdasarkan Qty Datang (Rp)" value="" autocomplete="off">
							<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
						</div>
						<p align="center"><button type="submit" class="btn btn-primary">SIMPAN</button></p>';
			}
			?>
			</form>
					</div>
				</div>
			</div>
			</div>
		</div>
	</div>
</div>

<!-- modal input -->
<div id="myModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&times;</button>
				<h4 class="modal-title">LIHAT DETAIL RAK</h4>
			</div>
			<div class="modal-body">
				<form action="" method="">
					<div style="overflow-x: auto">
						<div id="get_detail" class="col-md-12">

						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script>
function barcode(kode1,kode2,id_beli_detail){
	if (kode1==kode2){
		window.location='?page=gudang&mode=konfirm_beli_4&id=' + id_beli_detail;
	} else {
		$('#alert_me').html('<span class="badge bg-red">Barcode tidak sama</span>');
		$('html, body').animate({
			scrollTop: $('#alert_me').offset().top
		}, 1000);
	}
}
function getBack(){
	window.location='index.php?page=gudang&mode=konfirm_beli';
}
$(document).ready(function(){
	$('#select_ekspedisi').val('<?php echo $row["id_ekspedisi"] ?>');
	$('.mask').inputmask('numeric', {allowMinus: false, autoGroup: true, groupSeparator: '.', rightAlign: false, removeMaskOnSubmit: true});
	$('#myModal').on('show.bs.modal', function(e){
		var id = $(e.relatedTarget).data('id');
			$('#get_detail').html('<center><i class="fa fa-spinner fa-spin" style="font-size:24px"></i></center>');
			$('#get_detail').load('assets/page/gudang/get-rak-detail.php?id_beli_detail=' + id,function(){
		});
	});
});
</script>
