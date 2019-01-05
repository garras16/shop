<?php
date_default_timezone_set('Asia/Jakarta');
require_once('../../../assets/inc/config.php');
if (isset($edit_penjualan_post)){
	$sql=mysql_query("UPDATE jual SET tgl_nota='$tgl_nota',invoice='$invoice',id_pelanggan=$id_pelanggan,id_karyawan=$id_karyawan,keterangan='$keterangan' WHERE id_jual='$id'");
	if ($sql){
		_buat_pesan("Input Berhasil","green");
	} else {
		_buat_pesan("Input Gagal","red");
	}
	_direct("index.php?page=penjualan");
}
	$id_beli=$_GET['id_beli'];
	$id_supplier=$_GET['id_supplier'];
?>

<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-building fa-fw"></i></span>
						<select class="form-control" id="select_barang" name="id_barang_supplier" required>
							<option value="" disabled selected>Pilih Ekspedisi</option>
							<?php
								$sql=mysql_query("SELECT
    barang_supplier.id_barang_supplier
    , barang.nama_barang
FROM
    barang_supplier
    INNER JOIN barang 
        ON (barang_supplier.id_barang = barang.id_barang) 
WHERE 
	barang_supplier.id_supplier=$id_supplier");
								while($row=mysql_fetch_array($sql)){
									echo '<option value="' .$row['id_barang_supplier']. '">' .$row['nama_barang']. '</option>';
								}
							?>
						</select>
						<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-barcode fa-fw"></i></span>
						<input name="qty" class="form-control" placeholder="Qty" required>
						<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-barcode fa-fw"></i></span>
						<input name="berat" class="form-control" placeholder="Berat (gr)">
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-barcode fa-fw"></i></span>
						<input name="volume" class="form-control" placeholder="Volume (cm3)">
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-credit-card fa-fw"></i></span>
						<input class="form-control" name="harga" placeholder="Harga" required>
						<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
					</div>
					

