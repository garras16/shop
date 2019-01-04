<?php
if (isset($edit_penjualan_post)){
	$sql=mysqli_query($con, "UPDATE jual SET tgl_nota='$tgl_nota',invoice='$invoice',id_pelanggan=$id_pelanggan,id_karyawan=$id_karyawan,keterangan='$keterangan' WHERE id_jual='$id'");
	if ($sql){
		$pesan="INPUT BERHASIL";
	} else {
		$pesan="INPUT GAGAL";
	}
	_direct("index.php?page=penjualan");
}
if (isset($edit_diskon_nota_jual)){
	$sql=mysqli_query($con, "UPDATE jual SET diskon_all_persen=$diskon_all_persen WHERE id_jual=$id");
	_direct("index.php?page=penjualan&mode=view_detail&id=$id");
}
	
	$sql=mysqli_query($con, "SELECT status_konfirm FROM jual WHERE id_jual=$id");
	$row=mysqli_fetch_array($sql);
	(($row['status_konfirm']>=0) && ($row['status_konfirm']<=4) ? $dalam_kota=true : $dalam_kota=false); 
	if ($dalam_kota){
		$sql4=mysqli_query($con, "SELECT status FROM nota_sudah_cek WHERE id_jual=$id");
		$row4=mysqli_fetch_array($sql4);
		($row4['status']=='1' || $row4['status']=='2' || $row4['status']=='3' ? $print=true : $print=false);
	} else {
		$sql4=mysqli_query($con, "SELECT status_konfirm FROM jual WHERE id_jual=$id");
		$row4=mysqli_fetch_array($sql4);
		($row4['status_konfirm']>=7 ? $print=true : $print=false);
	}
	$sql=mysqli_query($con, "SELECT *
FROM
    jual
    INNER JOIN pelanggan 
        ON (jual.id_pelanggan = pelanggan.id_pelanggan)
    INNER JOIN karyawan 
        ON (jual.id_karyawan = karyawan.id_karyawan)
WHERE id_jual=$id");
	$row=mysqli_fetch_array($sql);
	$tgl_jt_tempo=date('d-m-Y', strtotime($row['tgl_nota']. ' + ' .$row['tenor']. ' days'));
	$diskon_nota=$row['diskon_all_persen']/100;
?>

<div class="right_col" role="main">
	<div class="">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
					<div class="x_title">
						<h3>LIHAT DETAIL PENJUALAN</h3>
					<div class="clearfix"></div>
					</div>
					<div class="x_content">
					<?php (isset($_GET['direct']) ? $url="?page=laporan&mode=kirim_barang" : $url="?page=penjualan&mode=penjualan"); ?>
			<a href="<?php echo $url ?>"><button style="margin-bottom:10px" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Kembali</button></a>
			
			<form action="" method="post">
				<input type="hidden" name="edit_penjualan_post" value="true">
				<div class="col-sm-6">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i> <small>Tgl Nota Jual</small></span>
						<input class="form-control" id="tgl_nota" name="tgl_nota" title="Tgl Nota Jual" value="<?php echo date("d-m-Y",strtotime($row['tgl_nota'])); ?>" readonly>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-file fa-fw"></i> <small>No Nota Jual</small></span>
						<input id="invoice" name="invoice" class="form-control" placeholder="No Nota Jual" title="No Nota Jual" value="<?php echo $row['invoice']; ?>" readonly>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-building fa-fw"></i> <small>Pelanggan</small></span>
						<input name="pelanggan" class="form-control" placeholder="Pelanggan" title="Pelanggan" value="<?php echo $row['nama_pelanggan']; ?>" readonly>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-user fa-fw"></i> <small>Sales</small></span>
						<input name="sales" class="form-control" placeholder="Sales" title="Sales" value="<?php echo $row['nama_karyawan']; ?>" readonly>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-dollar fa-fw"></i> <small>Jenis Bayar</small></span>
						<input id="jenis_bayar" name="jenis_bayar" class="form-control" placeholder="Jenis Bayar" title="Jenis Bayar" value="<?php echo $row['jenis_bayar']; ?>" readonly>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-tags fa-fw"></i> <small>Tenor</small></span>
						<input id="tenor" name="tenor" class="form-control" placeholder="TENOR" title="TENOR" value="<?php echo $row['tenor']; ?> hari" readonly>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-tags fa-fw"></i> <small>Tot. Jual Sementara</small></span>
						<input id="total_jual" class="form-control" placeholder="Total Jual Sementara" title="Total Jual Sementara" value="" readonly>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-hashtag fa-fw"></i> <small>Tgl Jatuh Tempo</small></span>
						<input id="tgl_jatuh_tempo" class="form-control" placeholder="Tanggal Jatuh Tempo" title="Tanggal Jatuh Tempo" value="<?php echo $tgl_jt_tempo; ?>" readonly>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-cut fa-fw"></i> <small>Disc. Nota Jual (Rp)</small></span>
						<input id="diskon_nota" class="form-control" placeholder="Diskon Nota Jual (Rp)" title="Diskon Nota Jual" value="" readonly>
						<span class="input-group-btn">
							<a data-toggle="modal" data-target="#myModal" class="btn btn-primary">Edit</a>
						</span>
					</div>
				</div>
			</form>
			</div>
			</div>
		</div>
	</div>
	
	<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
					<div class="x_content">
				
				<table id="table1" class="table table-bordered table-striped table-responsive">
				<thead>
					<tr>
						<th>Barcode</th>
						<th>Nama Barang</th>
						<th>Qty Jual</th>
						<th>Harga Jual (Rp)</th>
						<th>Tot. Seb. Diskon (Rp)</th>
						<th>Disc 1 (Rp)</th>
						<th>Tot. set. disc 1 (Rp)</th>
						<th>Disc 2 (Rp)</th>
						<th>Tot. set. disc 2 (Rp)</th>
						<th>Disc 3 (Rp)</th>
						<th>Tot. set. disc 3 (Rp)</th>
					</tr>
				</thead>
				<tbody>
				<?php
$sql=mysqli_query($con, "SELECT
    barang.nama_barang
    , barang.barcode
    , satuan.nama_satuan
    , jual_detail.diskon_persen
    , jual_detail.diskon_rp
	, jual_detail.diskon_persen_2
    , jual_detail.diskon_rp_2
	, jual_detail.diskon_persen_3
    , jual_detail.diskon_rp_3
    , jual_detail.id_jual_detail
    , jual_detail.qty
    , harga_jual.harga_jual
FROM
    jual_detail
    INNER JOIN harga_jual 
        ON (jual_detail.id_harga_jual = harga_jual.id_harga_jual)
    , barang_supplier
	INNER JOIN barang 
        ON (barang_supplier.id_barang = barang.id_barang)
    INNER JOIN satuan 
        ON (barang.id_satuan = satuan.id_satuan) WHERE (harga_jual.id_barang_supplier = barang_supplier.id_barang_supplier) AND jual_detail.id_jual='$id'");
$total_jual=0;
while($row=mysqli_fetch_array($sql)){
	$diskon1=$row['harga_jual']*$row['diskon_persen']/100;
	$tot_set_disk_1=$row['qty']*($row['harga_jual']-$diskon1);
	$diskon2=($row['harga_jual']-$diskon1)*$row['diskon_persen_2']/100;
	$tot_set_disk_2=$row['qty']*($row['harga_jual']-$diskon1-$diskon2);
	$diskon3=($row['harga_jual']-$diskon1-$diskon2)*$row['diskon_persen_3']/100;
	$tot_set_disk_3=$row['qty']*($row['harga_jual']-$diskon1-$diskon2-$diskon3);
	$total_jual+=$tot_set_disk_3;
	echo '			<tr>
						<td>' .$row['barcode']. '</td>
						<td>' .$row['nama_barang']. '</td>
						<td>' .$row['qty']. ' ' .$row['nama_satuan']. '</td>
						<td>' .format_uang($row['harga_jual']). '</td>
						<td>' .format_uang($row['qty']*$row['harga_jual']). '</td>
						<td>' .format_uang($diskon1). '</td>
						<td>' .format_uang($tot_set_disk_1). '</td>
						<td>' .format_uang($diskon2). '</td>
						<td>' .format_uang($tot_set_disk_2). '</td>
						<td>' .format_uang($diskon3). '</td>
						<td>' .format_uang($tot_set_disk_3). '</td>
					</tr>';
}
$diskon_all_rp=($diskon_nota/100)*$total_jual;
?>
					
				</tbody>
			</table>
			<div class="col-md-12">
				<div class="col-md-6">
				</div>
				
				<div class="col-md-6 text-right">
					<div class="input-group">
						<span class="input-group-addon" style="width:200px;text-align:left;color:#000"><small>Tot. Jual Set. Disc. (Rp)</small></span>
						<input class="form-control" id="berat_2" name="berat" value="<?php echo format_uang($total_jual) ?>" readonly>
					</div>
				</div>
			</div>
			<?php
				if ($print) echo '<center><a target="_blank" href="?page=penjualan&mode=cetak_nota_jual&frameless&id=' .$id. '" class="btn btn-primary"><i class="fa fa-print"></i> CETAK</a></center>';
			?>
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
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><div style="min-width:50px">&times;</div></button>
				<h4 class="modal-title">Ubah Data Diskon Nota Jual</h4>
			</div>
			<div class="modal-body">				
				<form action="" method="post">
					<input type="hidden" name="edit_diskon_nota_jual" value="true">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-cut fa-fw"></i></span>
						<input type="number" id="diskon_nota_persen" name="diskon_all_persen" class="form-control" placeholder="Diskon Nota Jual (%)" title="Diskon Nota Jual (%)" value="<?php echo $diskon_nota*100 ?>" min="0" max="100">
						<span class="input-group-addon">%</span>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-cut fa-fw"></i> Rp </span>
						<input id="diskon_nota_rp" class="form-control" placeholder="Diskon Nota Jual (Rp)" title="Diskon Nota Jual (Rp)" value="<?php echo $diskon_all_rp ?>" readonly>
					</div>
					<div class="modal-footer">
						<input type="submit" class="btn btn-primary" value="Simpan">
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<script>
$(document).ready(function(){
	$('#total_jual').inputmask('decimal', {allowMinus: false, autoGroup: true, groupSeparator: '.', rightAlign: false, removeMaskOnSubmit: true});
	$('#diskon_nota').inputmask('decimal', {allowMinus: false, autoGroup: true, groupSeparator: '.', rightAlign: false, removeMaskOnSubmit: true});
	$('#diskon_nota_rp').inputmask('decimal', {allowMinus: false, autoGroup: true, groupSeparator: '.', rightAlign: false, removeMaskOnSubmit: true});
	$('#total_jual').val(<?php echo $total_jual ?>);	
	$('#diskon_nota').val(<?php echo $diskon_nota*$total_jual ?>);
	$('#myModal').on('show.bs.modal', function(e){
		$('#diskon_nota_persen').val(<?php echo $diskon_nota*100 ?>);
		rp=Number($('#diskon_nota_persen').val()/100*<?php echo $total_jual ?>);
		$('#diskon_nota_rp').val(rp);
	});
	$('#diskon_nota_persen').on('input', function(){
		rp=Number($('#diskon_nota_persen').val()/100*<?php echo $total_jual ?>);
		$('#diskon_nota_rp').val(rp);
	});
});
</script>