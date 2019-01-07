<?php
if (isset($edit_konfirm_retur_jual_2_post)){
	$sql=mysqli_query($con, "SELECT * FROM retur_jual_detail WHERE id_retur_jual=$id AND qty_masuk IS NULL");
	$c=mysqli_num_rows($sql);
	if ($c > 0){
		$pesan="MASIH ADA BARANG YANG BELUM DI SCAN";
	} else {
		$sql=mysqli_query($con, "UPDATE retur_jual SET status=1 WHERE id_retur_jual=$id");
		_direct("?page=gudang&mode=konfirm_retur_jual");
	}
}
$sql=mysqli_query($con, "SELECT * FROM retur_jual_detail WHERE id_retur_jual=$id AND qty_masuk IS NULL");
(mysqli_num_rows($sql)>0 ? $locked='disabled' : $locked='');
$sql=mysqli_query($con, "SELECT
    pelanggan.nama_pelanggan
	, jual.id_jual
    , jual.invoice
    , retur_jual.no_retur_jual
    , retur_jual.tgl_retur
	, retur_jual.status
FROM
    jual
    INNER JOIN pelanggan 
        ON (jual.id_pelanggan = pelanggan.id_pelanggan)
    INNER JOIN retur_jual 
        ON (retur_jual.id_jual = jual.id_jual)
WHERE retur_jual.id_retur_jual=$id
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
						<h3>KONFIRMASI RETUR JUAL</h3>
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
							<input class="form-control" id="pelanggan" name="pelanggan" placeholder="Nama Pelanggan" title="Nama Pelanggan" value="<?php echo $row['nama_pelanggan'] ?>" disabled="disabled" required>
						</div>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-file fa-fw"></i></span>
							<input class="form-control" id="no_nota_jual" name="no_nota_jual" placeholder="No Nota Jual" title="No Nota Jual" value="<?php echo $row['invoice'] ?>" disabled="disabled" required>
						</div>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-file-excel fa-fw"></i></span>
							<input class="form-control" id="no_nota_retur" name="no_nota_retur" placeholder="No Nota Retur" title="No Nota Retur" value="<?php echo $row['no_retur_jual'] ?>" disabled="disabled" required>
						</div>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
							<input class="form-control" id="tgl_retur" name="tgl_retur" placeholder="Tanggal Retur" title="Tanggal Retur" value="<?php echo date("d-m-Y", strtotime($row['tgl_retur'])) ?>" disabled="disabled" required>
						</div>
				<?php
				if ($status!="1"){
					echo '	<form action="" method="post">
							<input type="hidden" name="edit_konfirm_retur_jual_2_post" value="true">
							<button id="lanjut" type="submit" style="display:none">SELESAI</button>
						</form>
						<p align="center"><button onClick="cek_valid();" class="btn btn-primary" ' .$locked. '><i class="fa fa-thumbs-o-up"></i> SELESAI</button></p>';
				} else {
					echo '<p align="center"><a class="btn btn-primary" href="?page=gudang&mode=cetak_retur_jual&id=' .$id. '" target="_blank"><i class="fa fa-print"></i> CETAK</a></p>';
				}
				?>
				<table id="table1" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>Nama Barang</th>
						<th>Qty Jual</th>
						<th>Gudang</th>
						<th>Rak</th>
						<th>Qty Retur</th>
						<th>Qty Masuk</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
				<?php

$sql=mysqli_query($con, "SELECT *
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
 WHERE retur_jual_detail.id_retur_jual=$id
 GROUP BY retur_jual_detail.id_jual_detail");
 echo mysqli_error();
while($row=mysqli_fetch_array($sql)){
($row['qty_masuk']=='' ? $qty_masuk='' : $qty_masuk=$row['qty_masuk']. ' ' .$row['nama_satuan']);
	echo '			<tr>
						<td>' .$row['nama_barang']. '</td>
						<td>' .$row['qty']. ' ' .$row['nama_satuan']. '</td>
						<td>' .$row['nama_gudang']. '</td>
						<td>' .$row['nama_rak']. '</td>
						<td>' .$row['qty_retur']. ' ' .$row['nama_satuan']. '</td>
						<td>' .$qty_masuk. '</td>';
	if ($status=="1"){
		echo '			<td><div style="text-align:center"><i class="fa fa-check"></i></div></td>';
	} else {
		echo '			<td><div style="text-align:center"><a data-barcode="' .$row['barcode']. '" class="btn btn-primary btn-xs barcode" onClick="AndroidFunction.scan_barang(&quot;' .$row['barcode']. '&quot;,&quot;' .$row['id_retur_jual_detail']. '&quot;);"><div style="width:70px"><i class="fa fa-barcode"></i> SCAN</div></a></div></td>';
	}	
	echo '				</tr>';
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
function barcode(kode1,kode2,id_retur_jual_detail){
	if (kode1==kode2){
		window.location='?page=gudang&mode=konfirm_retur_jual_3&id=' + id_retur_jual_detail;
	} else {
		$('#alert_me').html('<span class="badge bg-red">Barcode tidak sama</span>');
		$('html, body').animate({
			scrollTop: $('#alert_me').offset().top
		}, 1000);
	}
}
function cek_valid(){
	AndroidFunction.confirm();
}
function submit(){
	$('#lanjut').click();
}
function getBack(){
	window.location='index.php?page=gudang&mode=konfirm_retur_jual';
}
$(document).ready(function(){
	
})
</script>
