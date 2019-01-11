<?php
if (isset($tambah_beli_detail_post)){
	$sql=mysqli_query($con, "INSERT INTO beli_detail VALUES(null,$id,$id_barang_supplier,$qty,$harga,0,$diskon_persen_1,$diskon_rp_1,$diskon_persen_2,$diskon_rp_2,$diskon_persen_3,$diskon_rp_3)");
	if ($sql){
		_buat_pesan("Input Berhasil","green");
	} else {
		_buat_pesan("Input Gagal","red");
	}
	_direct("?page=pembelian&mode=view_add&id=" .$id);
}
if (isset($edit_diskon_nota_beli)){
	$sql=mysqli_query($con, "UPDATE beli SET diskon_all_persen=$diskon_all_persen WHERE id_beli=$id");
	_direct("?page=pembelian&mode=view_add&id=" .$id);
}
$sql3=mysqli_query($con, "SELECT
    harga,qty_di_rak,diskon_persen,diskon_persen_2,diskon_persen_3,diskon_rp,diskon_rp_2,diskon_rp_3
FROM
    beli_detail
    INNER JOIN beli 
        ON (beli_detail.id_beli = beli.id_beli)
    LEFT JOIN barang_masuk 
        ON (barang_masuk.id_beli_detail = beli_detail.id_beli_detail)
    LEFT JOIN barang_masuk_rak 
        ON (barang_masuk_rak.id_barang_masuk = barang_masuk.id_barang_masuk)
WHERE beli.id_beli=$id");
$total_datang=0;
while ($row=mysqli_fetch_array($sql3)){
	$diskon1=$row['harga']*$row['diskon_persen']/100;
	$tot_set_disk_1=$row['qty_di_rak']*($row['harga']-$diskon1);
	$diskon2=($row['harga']-$diskon1)*$row['diskon_persen_2']/100;
	$tot_set_disk_2=$row['qty_di_rak']*($row['harga']-$diskon1-$diskon2);
	$diskon3=($row['harga']-$diskon1-$diskon2)*$row['diskon_persen_3']/100;
	$tot_set_disk_3=$row['qty_di_rak']*($row['harga']-$diskon1-$diskon2-$diskon3);
	$total_datang+=$tot_set_disk_3;
}
$sql2=mysqli_query($con, "SELECT diskon_all_persen,ppn_all_persen FROM beli WHERE id_beli=$id");
$row2=mysqli_fetch_array($sql2);
$diskon_all_persen=$row2['diskon_all_persen'];
$ppn_all_persen=$row2['ppn_all_persen'];
	$sql=mysqli_query($con, "SELECT * FROM beli WHERE id_beli=$id");
	$row=mysqli_fetch_array($sql);
	$id_supplier=$row['id_supplier'];
	$diskon_nota=$row['diskon_all_persen']/100;
?>

<div class="right_col" role="main">
	<div class="">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<h3>RINCIAN NOTA PEMBELIAN</h3>
						<?php
							if (isset($pesan)){
								echo '<span class="badge bg-' .$warna. '">' .$pesan. '</span>';
							}
						?>
					<div class="clearfix"></div>
					</div>
					<div class="x_content">
			
			<a href="?page=pembelian&mode=pembelian"><button class="btn btn-danger"><i class="fa fa-arrow-left"></i> Kembali</button></a>
			<div class="clearfix"></div><br/>
			
			<form action="" method="post">
				<input type="hidden" name="edit_pembelian_post" value="true">
				<div class="form-group">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-calendar fa-fw" style="width: 51px;"></i><br><small>Tgl. Nota</small></span>
						<input class="form-control" id="tanggal" style="padding: 20px 15px;" name="tanggal" type="date" value="<?php echo $row['tanggal']; ?>" readonly>
						<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
					</div>									
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-file fa-fw" style="width: 51px;"></i><br><small>No. Nota</small></span>
						<input id="no_nota" name="no_nota" style="padding: 20px 15px;" class="form-control" placeholder="No Nota Beli" value="<?php echo $row['no_nota_beli']; ?>" maxlength="15" readonly>
						<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
					</div>
					<div class="input-group">
						<span class="input-group-addon" style="padding: 2px 12px;"><i class="fa fa-building fa-fw" style="width: 51px;"></i><br><small>Supplier</small></span>
						<select name="id_pelanggan" class="form-control" disabled>
							<option value="0" disabled selected>-= Pilih Supplier =-</option>
							<?php 
								$cust=mysqli_query($con, "SELECT id_supplier, nama_supplier FROM supplier");
								while($b=mysqli_fetch_array($cust)){
									$selected = ($b['id_supplier'] == $row['id_supplier'] ? 'selected' : '');
									echo '<option value="' .$b['id_supplier']. '" ' .$selected. '>' .$b['nama_supplier']. '</option>';
								}
							?>
						</select>
						<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
					</div>
					<div class="clearfix"></div><br/>
					<div class="input-group">
						<span class="input-group-addon" style="padding: 2px 12px;"><i class="fa fa-truck fa-fw"></i><br><small>Ekspedisi</small></span>
						<select name="id_ekspedisi" class="form-control" disabled>
							<option>-= Pilih Ekspedisi =-</option>
							<?php 
								$eks=mysqli_query($con, "SELECT id_ekspedisi, nama_ekspedisi FROM ekspedisi");
								while($b=mysqli_fetch_array($eks)){
									$selected = ($b['id_ekspedisi'] == $row['id_ekspedisi'] ? 'selected="selected"' : '');
									echo '<option value="' .$b['id_ekspedisi']. '" ' .$selected. '>' .$b['nama_ekspedisi']. '</option>';
								}
							?>
						</select>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-balance-scale fa-fw" style="width: 51px;"></i><br><small>Berat</small></span>
						<input class="form-control" placeholder="Berat Ekspedisi (gr)" style="padding: 20px 15px;" value="<?php echo format_angka($row['berat_ekspedisi']); ?> gr" readonly>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-balance-scale fa-fw" style="width: 51px;"></i><br><small>Vol.</small></span>
						<input class="form-control" placeholder="Volume Ekspedisi (cm3)" style="padding: 20px 15px;" value="<?php echo format_angka($row['volume_ekspedisi']); ?> cm3" readonly>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-money fa-fw" style="width: 51px;"></i><br><small>Tarif</small></span>
						<input class="form-control" placeholder="Tarif Ekspedisi (Rp)" style="padding: 20px 15px;" value="Rp <?php echo format_uang($row['tarif_ekspedisi']); ?>" readonly>
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
				<p align="right"><a data-toggle="modal" data-target="#myModal" data-id-beli="<?php echo $id ?>" data-id-supplier="<?php echo $id_supplier ?>" class="btn btn-warning"><i class="fa fa-plus"></i> Tambah Data</a></p>
				<div class="table responsive">
				<table id="table1" class="table table-bordered table-striped" style="width: 1950px;">
				<thead>
					<tr>
						<th>Nama Barang</th>
						<th>Qty Beli</th>
						<th>Berat (gr)</th>
						<th>Volume (cm3)</th>
						<th>Harga Modal (Rp)</th>
						<th>Tot. Seb. Diskon (Rp)</th>
						<th>Disc 1 (Rp)</th>
						<th>Tot. set. disc 1 (Rp)</th>
						<th>Disc 2 (Rp)</th>
						<th>Tot. set. disc 2 (Rp)</th>
						<th>Disc 3 (Rp)</th>
						<th>Tot. set. disc 3 (Rp)</th>
						<th>Tgl Datang</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>
				<?php
$sql=mysqli_query($con, "SELECT
    beli_detail.id_beli_detail
    , beli_detail.qty
    , beli_detail.harga
	, beli_detail.diskon_persen
	, beli_detail.diskon_persen_2
    , beli_detail.diskon_persen_3
    , beli_detail.diskon_rp
    , beli_detail.diskon_rp_2
    , beli_detail.diskon_rp_3
	, beli_detail.status_barang
	, barang_masuk.tgl_datang
    , barang_masuk.berat
    , barang_masuk.volume
    , barang.nama_barang
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
	WHERE
		beli_detail.id_beli=$id AND barang.status=1");
$berat=0;
$volume=0;
$jumlah=0;
while($row=mysqli_fetch_array($sql)){
$berat+=$row['berat'];
$volume+=$row['volume'];
($row['tgl_datang']=='' ? $tgl_datang="BELUM LENGKAP" : $tgl_datang=date("d-m-Y", strtotime($row['tgl_datang'])));

	$diskon1=($row['harga']*$row['diskon_persen']/100);
	$tot_set_disk_1=$row['qty']*($row['harga']-$diskon1);
	$diskon2=($row['harga']-$diskon1)*$row['diskon_persen_2']/100;
	$tot_set_disk_2=$row['qty'] * ($row['harga']-$diskon1-$diskon2);
	$diskon3=($row['harga']-$diskon1-$diskon2)*$row['diskon_persen_3']/100;
	$tot_set_disk_3=$row['qty'] * ($row['harga']-$diskon1-$diskon2-$diskon3);
	$jumlah+=$tot_set_disk_3;
	
	echo '			<tr>
						<td style="width: 120px;">' .$row['nama_barang']. '</td>
						<td style="width: 90px;">' .format_angka($row['qty']). ' ' .$row['nama_satuan']. '</td>
						<td style="width: 90px;">' .format_angka($row['berat']). '</td>
						<td style="width: 120px;">' .format_angka($row['volume']). '</td>
						<td style="width: 140px;">' .format_uang($row['harga']). '</td>
						<td style="width: 160px;">' .format_uang($row['qty']*$row['harga']). '</td>
						<td style="width: 120px;">' .format_uang($row['qty']*$diskon1). '</td>
						<td style="width: 150px;">' .format_uang($tot_set_disk_1). '</td>
						<td style="width: 120px;">' .format_uang($row['qty']*$diskon2). '</td>
						<td style="width: 150px;">' .format_uang($tot_set_disk_2). '</td>
						<td style="width: 120px;">' .format_uang($row['qty']*$diskon3). '</td>
						<td style="width: 150px;">' .format_uang($tot_set_disk_3). '</td>
						<td style="width: 150px;">' .$tgl_datang. '</td>
						<td style="width: 20px;"><a class="label label-warning" onClick="deleteRow(this,' .$row['id_beli_detail']. ')" ><i class="fa fa-trash"></i> HAPUS</a></td>';
	echo '			</tr>';
}
$diskon_all_rp=$jumlah*($diskon_all_persen/100);
$ppn_all_rp=($jumlah-$diskon_all_rp)*($ppn_all_persen/100);
$jumlah=$jumlah+$ppn_all_rp-$diskon_all_rp;
?>
					
				</tbody>
			</table>
			<div class="col-md-12">
				<div class="col-md-5 text-right">
					<div class="input-group">
						<span class="input-group-addon" style="width:200px;text-align:left;color:#000;background: #fff; outline: none; border: none;">Berat Datang (gr)</span>
						<input class="form-control text-right" style="background: #fff; outline: none; border: none;" id="berat_2" name="berat" value="<?php echo format_angka($berat) ?>" readonly>
					</div>
					<div class="input-group">
						<span class="input-group-addon" style="width:200px;text-align:left;color:#000;background: #fff; outline: none; border: none;">Volume Datang (cm3)</span>
						<input stle="width:256px" class="form-control text-right" style="background: #fff; outline: none; border: none;" id="volume_2" name="volume" value="<?php echo format_angka($volume) ?>" readonly>
					</div>
					<div class="input-group">
						<span data-toggle="modal" data-target="#myModal2" class="input-group-addon" style="width:200px;text-align:left;color:#000;background: #fff; outline: none; border: none;"><small style="color: red;">Diskon Nota Beli (Rp)</small><a title=""><small style="font-size: 10px; color: blue;"> [UBAH]</small></a></span>
						<input class="form-control text-right" id="diskon" style="background: #fff; outline: none; border: none;" name="total" value="<?php echo format_uang($diskon_all_rp) ?>" readonly>
					</div>
					<div class="input-group">
						<span class="input-group-addon" style="width:200px;text-align:left;color:#000;background: #fff; outline: none; border: none;">PPN (Rp)</span>
						<input class="form-control text-right" id="diskon" style="background: #fff; outline: none; border: none;" name="total" value="<?php echo format_uang($ppn_all_rp) ?>" readonly>
					</div>
					<div class="input-group">
						<span class="input-group-addon" style="width:200px;text-align:left;color:#000;background: #fff; outline: none; border: none;">Total Nota Beli (Rp)</span>
						<input class="form-control text-right" id="total_2" style="background: #fff; outline: none; border: none;" name="total" value="<?php echo format_uang($jumlah) ?>" readonly>
					</div>
					<div class="input-group">
						<span class="input-group-addon" style="width:200px;text-align:left;color:#000;background: #fff; outline: none; border: none;">Total Datang (Rp)</span>
						<input class="form-control text-right" id="total_3" style="background: #fff; outline: none; border: none;" name="total" value="<?php echo format_uang($total_datang) ?>" readonly>
					</div>
				</div>
			</div>
			</div>
			</div>
			<div id="dummy"></div>
			
		</div>	
	</div>
</div>

<!-- modal input -->
<div id="myModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><div style="min-width:50px">&times;</div></button>
				<h4 class="modal-title">Tambah Data Detail Pembelian</h4>
			</div>
			<div class="modal-body">				
				<form action="" method="post">
					<input type="hidden" name="tambah_beli_detail_post" value="true">
					<div id="add_beli_detail" class="col-md-12">
						<div class="input-group">
						<span class="input-group-addon" style="padding: 2px 12px;"><i class="fa fa-archive fa-fw"></i><br><small>Barang</small></span>
						<select id="select_barang" class="form-control select2"  name="id_barang_supplier" required>
							<option value="" disabled selected>Pilih Barang</option>
<?php
$sql=mysqli_query($con, "SELECT
    barang_supplier.id_barang_supplier
    , barang.nama_barang
	, satuan.nama_satuan
FROM
    barang_supplier
    INNER JOIN barang 
        ON (barang_supplier.id_barang = barang.id_barang)
	INNER JOIN satuan
		ON (satuan.id_satuan=barang.id_satuan)
WHERE 
	barang_supplier.id_supplier=$id_supplier
	AND barang.status=1");
								while($row=mysqli_fetch_array($sql)){
									echo '<option data-satuan="' .$row['nama_satuan']. '" value="' .$row['id_barang_supplier']. '">' .$row['nama_barang']. '</option>';
								}
							?>
						</select>
						<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-shopping-cart fa-fw" style="width: 38px;"></i><br><small>Qty</small></span>
						<input id="qty_2" name="qty" type="text" style="padding: 20px 15px;" class="form-control" placeholder="Qty Beli" required>
						<span class="input-group-addon" id="satuan"></span>
						<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-money fa-fw" style="width: 38px;"></i><br><small>Harga</small></span>
						<input class="form-control" id="harga_2" style="padding: 20px 15px;" name="harga" type="text" placeholder="Harga Modal (Rp)" required>
						<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><div style="min-width:70px;text-align:left">Diskon 1 (%)</div></span>
						<input class="form-control" id="diskon_persen_2_1" name="diskon_persen_1" onchange="handleChange();" type="text" placeholder="Diskon 1" value="0" required>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><div style="min-width:70px;text-align:left">Diskon 2 (%)</div></span>
						<input class="form-control" id="diskon_persen_2_2" name="diskon_persen_2" type="text" onchange="handleChange();" placeholder="Diskon 2" value="0" required>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><div style="min-width:70px;text-align:left">Diskon 3 (%)</div></span>
						<input class="form-control" id="diskon_persen_2_3" name="diskon_persen_3" type="text" onchange="handleChange();" placeholder="Diskon 3" value="0" required>
					</div>
					</div>
					<div class="modal-footer">
						<input type="submit" class="btn btn-primary" value="Simpan">
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- modal input -->
<div id="myModal2" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><div style="min-width:50px">&times;</div></button>
				<h4 class="modal-title">Ubah Data Diskon Nota Beli</h4>
			</div>
			<div class="modal-body">				
				<form action="" method="post">
					<input type="hidden" name="edit_diskon_nota_beli" value="true">
					<div class="input-group">
						<span class="input-group-addon" style="font-size: 12px;"><i class="fa fa-cut fa-fw"></i><br><small>Disc. Nota</small></span>
						<input type="number" id="diskon_nota_persen" onchange="handleChange();" name="diskon_all_persen" style="padding: 20px 15px;" class="form-control" placeholder="Diskon Nota Beli (%)" title="Diskon Nota Beli (%)" value="<?php echo $diskon_nota*100 ?>" min="0" max="100">
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-cut fa-fw" style="width: 47px;"></i><br><small>Nominal</small></span>
						<input id="diskon_nota_rp" class="form-control" placeholder="Diskon Nota Beli (Rp)" style="padding: 20px 15px;" title="Diskon Nota Beli (Rp)" value="<?php echo $diskon_all_rp ?>" readonly>
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
function deleteRow(r,ID) {
	$('#dummy').load('assets/page/pembelian/del-beli-detail.php?id-beli=<?php echo $id ?>&id=' + ID + '&mode=<?php echo $_GET['mode'] ?>');
//    var i = r.parentNode.parentNode.rowIndex;
//    document.getElementById("table1").deleteRow(i);
}
function handleChange(input) {
    if (input.value < 0) input.value = 0;
    if (input.value > 100) input.value = 100;
}
$(document).ready(function(){
	$('#ekspedisi').inputmask('decimal', {allowMinus:false, autoGroup: true, groupSeparator: '.', rightAlign: false, autoUnmask: true, removeMaskOnSubmit: true});
	$('#qty').inputmask('decimal', {allowMinus:false, autoGroup: true, groupSeparator: '.', rightAlign: false, autoUnmask: true, removeMaskOnSubmit: true});
	$('#berat').inputmask('decimal', {allowMinus:false, autoGroup: true, groupSeparator: '.', rightAlign: false, autoUnmask: true, removeMaskOnSubmit: true});
	$('#volume').inputmask('decimal', {allowMinus:false, autoGroup: true, groupSeparator: '.', rightAlign: false, autoUnmask: true, removeMaskOnSubmit: true});
	$('#harga').inputmask('currency', {prefix: "Rp ", allowMinus:false, autoGroup: true, groupSeparator: '.', rightAlign: false, autoUnmask: true, removeMaskOnSubmit: true});
	$('#qty_2').inputmask('decimal', {allowMinus:false, autoGroup: true, groupSeparator: '.', rightAlign: false, autoUnmask: true, removeMaskOnSubmit: true});
	$('#harga_2').inputmask('currency', {prefix: "Rp ", allowMinus:false, autoGroup: true, groupSeparator: '.', rightAlign: false, autoUnmask: true, removeMaskOnSubmit: true});
	$('#diskon_persen').inputmask('decimal', {allowMinus:false, autoGroup: true, groupSeparator: '.', rightAlign: false, autoUnmask: true, removeMaskOnSubmit: true});/*
	$('#diskon_persen_2_1').inputmask('decimal', {allowMinus:false, autoGroup: true, groupSeparator: '.', rightAlign: false, autoUnmask: true, removeMaskOnSubmit: true});
	$('#diskon_persen_2_2').inputmask('decimal', {allowMinus:false, autoGroup: true, groupSeparator: '.', rightAlign: false, autoUnmask: true, removeMaskOnSubmit: true});
	$('#diskon_persen_2_3').inputmask('decimal', {allowMinus:false, autoGroup: true, groupSeparator: '.', rightAlign: false, autoUnmask: true, removeMaskOnSubmit: true});
	$('#diskon_nota_rp').inputmask('decimal', {allowMinus:false, autoGroup: true, groupSeparator: '.', rightAlign: false, autoUnmask: true, removeMaskOnSubmit: true});
	*/
	$('#diskon_persen_2_2').numeric({decimalPlaces: 2, negative:false});
	$('#diskon_persen_2_3').numeric({decimalPlaces: 2, negative:false});
	$('#diskon_persen_2_1').numeric({decimalPlaces: 2, negative:false});
	$(".select2").select2({
		placeholderOption: "first",
		allowClear: true,
		width: '100%'
	});
	$('#select_barang').on('change', function(){
		var sat = $(this).find(":selected").data('satuan');
		$('#satuan').html(sat);
	})
	$('#myModal2').on('show.bs.modal', function(e){
		$('#diskon_nota_persen').val(<?php echo $diskon_nota*100 ?>);
		rp=Number($('#diskon_nota_persen').val()/100*<?php echo $jumlah ?>);
		$('#diskon_nota_rp').val(rp);
	});
	$('#diskon_nota_persen').on('input', function(){
		rp=Number($('#diskon_nota_persen').val()/100*<?php echo $jumlah ?>);
		$('#diskon_nota_rp').val(rp);
	});
});
</script>
