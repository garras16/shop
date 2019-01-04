<?php
date_default_timezone_set('Asia/Jakarta');
require_once('../../../assets/inc/config.php');
	$id_beli=$_GET['id_beli'];
	$id_supplier=$_GET['id_supplier'];
?>

<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-building fa-fw"></i></span>
						<select class="form-control" id="select_barang" name="id_barang_supplier" required>
							<option value="" disabled selected>Pilih Barang</option>
							<?php
								$sql=mysqli_query($con, "SELECT
    barang_supplier.id_barang_supplier
    , barang.nama_barang
FROM
    barang_supplier
    INNER JOIN barang 
        ON (barang_supplier.id_barang = barang.id_barang) 
WHERE 
	barang_supplier.id_supplier=$id_supplier");
								while($row=mysqli_fetch_array($sql)){
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
					

