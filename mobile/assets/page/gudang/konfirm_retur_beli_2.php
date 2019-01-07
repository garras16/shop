<?php
if (isset($edit_konfirm_retur_beli_2_post)){
	$sql=mysqli_query($con, "SELECT * FROM retur_beli_detail WHERE id_retur_beli=$id AND qty_keluar IS NULL");
	$c=mysqli_num_rows($sql);
	if ($c > 0){
		$pesan="MASIH ADA BARANG YANG BELUM DI SCAN";
	} else {
		$sql=mysqli_query($con, "SELECT
			barang_masuk_rak.stok
			, SUM(retur_beli_detail.qty_keluar) AS total_qty
			, barang_masuk_rak.id_barang_masuk_rak
			, retur_beli_detail.id_retur_beli
		FROM
			retur_beli_detail
			INNER JOIN barang_masuk_rak 
				ON (retur_beli_detail.id_barang_masuk_rak = barang_masuk_rak.id_barang_masuk_rak) 
		WHERE id_retur_beli=$id
		GROUP BY id_barang_masuk_rak");
		while ($row=mysqli_fetch_array($sql)){
			$stok=$row['stok']-$row['total_qty'];
			if ($stok<0){
				tulis_log(date('d-m-Y H:i'). ' Stok minus edit konfim retur beli konfirm_retur_beli_2 id_retur_beli=' .$id);
				tulis_log('stok=' .$row['stok']. ' total_qty=' .$row['total_qty']);
				tulis_log("UPDATE barang_masuk_rak SET stok=" .$stok. " WHERE id_barang_masuk_rak=" .$row['id_barang_masuk_rak']);
			}
			$sql2=mysqli_query($con, "UPDATE barang_masuk_rak SET stok=" .$stok. " WHERE id_barang_masuk_rak=" .$row['id_barang_masuk_rak']. "");
		}
		$sql3=mysqli_query($con, "UPDATE retur_beli SET status=1 WHERE id_retur_beli=$id");
		_direct("?page=gudang&mode=konfirm_retur_beli");
	}
}
$sql=mysqli_query($con, "SELECT * FROM retur_beli_detail WHERE id_retur_beli=$id AND qty_keluar IS NULL");
(mysqli_num_rows($sql)>0 ? $locked='disabled' : $locked='');
$sql=mysqli_query($con, "SELECT
    supplier.nama_supplier
	, beli.id_beli
    , beli.no_nota_beli
    , retur_beli.no_retur_beli
    , retur_beli.tgl_retur
	, retur_beli.status
FROM
    beli
    INNER JOIN supplier 
        ON (beli.id_supplier = supplier.id_supplier)
    INNER JOIN retur_beli 
        ON (retur_beli.id_beli = beli.id_beli)
WHERE retur_beli.id_retur_beli=$id
");
$row=mysqli_fetch_array($sql);
$status=$row['status'];
?>
<div class="right_col loading" role="main">
	<div class="">
	
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<h3>KONFIRMASI RETUR BELI</h3>
						<?php
							if (isset($pesan)){
								echo '<span class="badge bg-red">' .$pesan. '</span>';
							}
						?>
						<div id="alert_me"></div>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-building fa-fw"></i></span>
							<input class="form-control" id="supplier" name="supplier" placeholder="Nama Supplier" title="Nama Supplier" value="<?php echo $row['nama_supplier'] ?>" disabled="disabled" required>
						</div>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-file fa-fw"></i></span>
							<input class="form-control" id="no_nota_beli" name="no_nota_beli" placeholder="No Nota Beli" title="No Nota Beli" value="<?php echo $row['no_nota_beli'] ?>" disabled="disabled" required>
						</div>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-file-excel fa-fw"></i></span>
							<input class="form-control" id="no_nota_retur" name="no_nota_retur" placeholder="No Nota Retur" title="No Nota Retur" value="<?php echo $row['no_retur_beli'] ?>" disabled="disabled" required>
						</div>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
							<input class="form-control" id="tgl_retur" name="tgl_retur" placeholder="Tanggal Retur" title="Tanggal Retur" value="<?php echo date("d-m-Y", strtotime($row['tgl_retur'])) ?>" disabled="disabled" required>
						</div>
				<?php
				if ($status!="1"){
					echo '	<form action="" method="post">
							<input type="hidden" name="edit_konfirm_retur_beli_2_post" value="true">
							<p align="center"><button id="lanjut" type="submit" class="btn btn-primary" ' .$locked. '>SIMPAN & UPDATE STOK</button></p>
						</form>';
				}
				?>
				<table id="table1" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>Nama Barang</th>
						<th>Qty Beli</th>
						<th>Gudang</th>
						<th>Rak</th>
						<th>Stok</th>
						<th>Qty Retur</th>
						<th>Qty Keluar</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
				<?php

$sql=mysqli_query($con, "SELECT
    retur_beli_detail.id_retur_beli
    , barang.nama_barang
	, barang.barcode
	, beli_detail.id_beli_detail
    , beli_detail.qty
    , satuan.nama_satuan
FROM
    retur_beli_detail
    INNER JOIN beli_detail 
        ON (retur_beli_detail.id_beli_detail = beli_detail.id_beli_detail)
    INNER JOIN barang_supplier 
        ON (beli_detail.id_barang_supplier = barang_supplier.id_barang_supplier)
    INNER JOIN barang 
        ON (barang_supplier.id_barang = barang.id_barang)
    INNER JOIN satuan 
        ON (barang.id_satuan = satuan.id_satuan)
 WHERE retur_beli_detail.id_retur_beli=$id
 GROUP BY id_beli_detail");
while($row=mysqli_fetch_array($sql)){
$tmp_id_beli_detail=$row['id_beli_detail'];
$sql2=mysqli_query($con, "SELECT
    barang_masuk_rak.stok
	, barang_masuk_rak.id_barang_masuk_rak
	, retur_beli_detail.id_retur_beli_detail
	, retur_beli_detail.qty_retur
    , retur_beli_detail.qty_keluar
    , rak.nama_rak
    , gudang.nama_gudang
FROM
    retur_beli_detail
    INNER JOIN barang_masuk_rak 
        ON (retur_beli_detail.id_barang_masuk_rak = barang_masuk_rak.id_barang_masuk_rak)
    INNER JOIN barang_masuk 
        ON (barang_masuk_rak.id_barang_masuk = barang_masuk.id_barang_masuk)
    INNER JOIN rak 
        ON (barang_masuk_rak.id_rak = rak.id_rak)
    INNER JOIN gudang 
        ON (rak.id_gudang = gudang.id_gudang)
WHERE barang_masuk.id_beli_detail=$tmp_id_beli_detail");
while($r=mysqli_fetch_array($sql2)){
($r['qty_keluar']=='' ? $qty_keluar='' : $qty_keluar=$r['qty_keluar']. ' ' .$row['nama_satuan']);
	echo '			<tr>
						<td>' .$row['nama_barang']. '</td>
						<td>' .$row['qty']. ' ' .$row['nama_satuan']. '</td>
						<td>' .$r['nama_gudang']. '</td>
						<td>' .$r['nama_rak']. '</td>
						<td>' .$r['stok']. ' ' .$row['nama_satuan']. '</td>
						<td>' .$r['qty_retur']. ' ' .$row['nama_satuan']. '</td>
						<td>' .$qty_keluar. '</td>';
	if ($status=="1"){
		echo '			<td><div style="text-align:center"><i class="fa fa-check"></i></div></td>';
	} else {
		echo '			<td><div style="text-align:center"><a data-barcode="' .$row['barcode']. '" class="btn btn-primary btn-xs barcode" onClick="AndroidFunction.scan_barang(&quot;' .$row['barcode']. '&quot;,&quot;' .$r['id_retur_beli_detail']. '&quot;);"><i class="fa fa-barcode"></i> Scan</a></div></td>';
	}	
	echo '				</tr>';
}
}
?>
					
				</tbody>
			</table>
			
			</div>
			</div>
			<div id="dummy"></div>
			</div>
			</div>
		</div>	
	</div>
</div>

<script>
function barcode(kode1,kode2,id_retur_beli_detail){
	if (kode1==kode2){
		window.location='?page=gudang&mode=konfirm_retur_beli_3&id=' + id_retur_beli_detail;
	} else {
		$('#alert_me').html('<span class="badge bg-red">Barcode tidak sama</span>');
		$('html, body').animate({
			scrollTop: $('#alert_me').offset().top
		}, 1000);
	}
}
function getBack(){
	window.location='index.php?page=gudang&mode=konfirm_retur_beli';
}
$(document).ready(function(){
	
})
</script>
