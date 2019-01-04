<?php
$sql=mysqli_query($con, "SELECT * FROM retur_beli_detail WHERE id_retur_beli=$id AND qty_keluar IS NOT NULL");
(mysqli_num_rows($sql)>0 ? $locked=true : $locked=false);
if (isset($tambah_retur_beli_detail_post)){
	if ($locked) {
		_buat_pesan("Input Gagal. Barang sudah diproses di gudang.","red");
		_direct("?page=pembelian&mode=retur_beli_detail&id=$id");
		return;
	}
	$sql = "INSERT INTO retur_beli_detail VALUES(null,$id,$id_beli_detail,$id_barang_masuk_rak,$qty_retur,$harga_retur,null)";
	$q = mysqli_query($con, $sql);
	$e_id = mysqli_insert_id();
	if ($q){
		_buat_pesan("Input Berhasil","green");
	} else {
		_buat_pesan("Input Gagal","red");
	}
	_direct("?page=pembelian&mode=retur_beli_detail&id=$id");
}
if (isset($edit_retur_beli_detail_post)){
	if ($locked) {
		_buat_pesan("Input Gagal. Barang sudah diproses di gudang.","red");
		_direct("?page=pembelian&mode=retur_beli_detail&id=$id");
		return;
	}
	$sql = "UPDATE retur_beli_detail SET qty_retur=$qty_retur,harga_retur=$harga_retur WHERE id_retur_beli_detail=$id_retur_beli_detail";
	$q = mysqli_query($con, $sql);
	$e_id = mysqli_insert_id();
	if ($q){
		_buat_pesan("Input Berhasil","green");
	} else {
		_buat_pesan("Input Gagal","red");
	}
	_direct("?page=pembelian&mode=retur_beli_detail&id=$id");
}
if (isset($_GET['del'])){
	if ($locked) {
		_buat_pesan("Input Gagal. Barang sudah diproses di gudang.","red");
		_direct("?page=pembelian&mode=retur_beli_detail&id=$id");
		return;
	}
	$sql = "DELETE FROM retur_beli_detail WHERE id_retur_beli_detail=" .$_GET['del'];
	$q = mysqli_query($con, $sql);
	if ($q){
		_buat_pesan("Input Berhasil","green");
	} else {
		_buat_pesan("Input Gagal","red");
	}
	_direct("?page=pembelian&mode=retur_beli_detail&id=$id");
}
$sql=mysqli_query($con, "SELECT
    supplier.nama_supplier
	, beli.id_beli
    , beli.no_nota_beli
    , beli.ppn_all_persen
    , beli.diskon_all_persen
    , retur_beli.no_retur_beli
	, retur_beli.status
    , retur_beli.tgl_retur
FROM
    beli
    INNER JOIN supplier 
        ON (beli.id_supplier = supplier.id_supplier)
    INNER JOIN retur_beli 
        ON (retur_beli.id_beli = beli.id_beli)
WHERE retur_beli.id_retur_beli=$id");
$row=mysqli_fetch_array($sql);
$id_beli=$row['id_beli'];
$status=$row['status'];
$diskon_all_persen=$row['diskon_all_persen'];
$ppn_all_persen=$row['ppn_all_persen'];
?>
<!-- page content -->
<div class="right_col" role="main">
	<div class="">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<h3>RETUR PEMBELIAN DETAIL</h3>
						<?php
							if (isset($pesan)){
								echo '<span class="badge bg-' .$warna. '">' .$pesan. '</span>';
							}
						?>
					<div class="clearfix"></div>
					</div>
					<div class="x_content">
					<div class="alert alert-info">
					  <strong>Klik kolom pada tabel untuk ubah.</strong>
					</div>
			<div class="col-md-6">
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-building fa-fw" style="width: 68px;"></i><br><small>Supplier</small></span>
					<input class="form-control" id="supplier" name="supplier" style="padding: 20px 15px;" placeholder="Nama Supplier" title="Nama Supplier" value="<?php echo $row['nama_supplier'] ?>" disabled="disabled" required>
				</div>
			</div>
			<div class="col-md-6">
				<div class="input-group">
					<span class="input-group-addon" style="font-size: 13px;"><i class="fa fa-file fa-fw" style="width: 68px;"></i><br><small>No. Nota Beli</small></span>
					<input class="form-control" id="no_nota_beli" name="no_nota_beli" style="padding: 20px 15px;" placeholder="No Nota Beli" title="No Nota Beli" value="<?php echo $row['no_nota_beli'] ?>" disabled="disabled" required>
				</div>
			</div>
			<div class="col-md-6">
				<div class="input-group">
					<span class="input-group-addon" style="font-size: 12px;"><i class="fa fa-file-excel fa-fw" style="width: 68px;"></i><br><small>No. Nota Retur</small></span>
					<input class="form-control" id="no_nota_retur" name="no_nota_retur" placeholder="No Nota Retur" style="padding: 20px 15px;" title="No Nota Retur" value="<?php echo $row['no_retur_beli'] ?>" disabled="disabled" required>
				</div>
			</div>
			<div class="col-md-6">
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-calendar fa-fw" style="width: 68px;"></i><br><small>Tgl. Retur</small></span>
					<input class="form-control" id="tgl_retur" style="padding: 20px 15px;" name="tgl_retur" placeholder="Tanggal Retur" title="Tanggal Retur" value="<?php echo date("d-m-Y", strtotime($row['tgl_retur'])) ?>" disabled="disabled" required>
				</div>
			</div>
			
			<div class="clearfix"></div>
			<div class="col-xs-6">
				<p align="left"><a class="btn btn-danger" href="?page=pembelian&mode=retur_beli"><i class="fa fa-arrow-left"></i> Kembali</a></p>
			</div>
			<div class="col-xs-6">
				<?php if ($status!='1' && !$locked) echo '<p align="right"><button class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Tambah Retur</button></p>'; ?>
			</div>
			<i class="fa fa-check"></i> Barang sudah diproses oleh gudang<br><br>
			
			<table id="table1" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>Nama Barang</th>
						<th>Qty Beli</th>
						<th>Harga Beli (Rp)</th>
						<th>Diskon 1 (Rp)</th>
						<th>Diskon 2 (Rp)</th>
						<th>Diskon 3 (Rp)</th>
						<th>Jumlah Beli (Rp)</th>
						<th>Gudang</th>
						<th>Rak</th>
						<th>Stok</th>
						<th>Qty Retur</th>
						<th>Harga Retur (Rp)</th>
						<th>Qty Keluar</th>
						<th>Jumlah Retur (Rp)</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
<?php
$sql=mysqli_query($con, "SELECT
    retur_beli_detail.id_retur_beli
    , barang.nama_barang
    , beli_detail.id_beli_detail
    , SUM(barang_masuk_rak.qty_di_rak) AS qty
    , satuan.nama_satuan
    , beli_detail.harga
    , beli_detail.diskon_rp
    , beli_detail.diskon_rp_2
    , beli_detail.diskon_rp_3
FROM
    beli_detail
    LEFT JOIN retur_beli_detail 
        ON (retur_beli_detail.id_beli_detail = beli_detail.id_beli_detail)
    INNER JOIN barang_masuk 
        ON (barang_masuk.id_beli_detail = beli_detail.id_beli_detail)
    INNER JOIN barang_masuk_rak 
        ON (barang_masuk_rak.id_barang_masuk = barang_masuk.id_barang_masuk)
    INNER JOIN barang_supplier 
        ON (beli_detail.id_barang_supplier = barang_supplier.id_barang_supplier)
    INNER JOIN barang 
        ON (barang_supplier.id_barang = barang.id_barang)
    INNER JOIN satuan 
        ON (barang.id_satuan = satuan.id_satuan)
 WHERE retur_beli_detail.id_retur_beli=$id
 GROUP BY id_beli_detail");
$total_retur=0;
while($row=mysqli_fetch_array($sql)){
$tmp_id_beli_detail=$row['id_beli_detail'];
$sql2=mysqli_query($con, "SELECT
    barang_masuk_rak.stok
	, barang_masuk_rak.id_barang_masuk_rak
	, retur_beli_detail.id_retur_beli_detail
	, retur_beli_detail.qty_retur
	, retur_beli_detail.harga_retur
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
$total_retur+=$r['harga_retur']*$r['qty_retur'];
($r['qty_keluar']=='' ? $qty_keluar='' : $qty_keluar=$r['qty_keluar']. ' ' .$row['nama_satuan']);
$total_jual=$row['qty']*($row['harga']-$row['diskon_rp']-$row['diskon_rp_2']-$row['diskon_rp_3']);
$total_jual=$total_jual+($total_jual*$ppn_all_persen/100);//-($total_jual*$diskon_all_persen/100);
if ($status=="1" || $locked){
	echo '			<tr>
						<td>' .$row['nama_barang']. '</td>
						<td>' .$row['qty']. ' ' .$row['nama_satuan']. '</td>
						<td>' .format_uang($row['harga']). '</td>
						<td>' .format_uang($row['diskon_rp']). '</td>
						<td>' .format_uang($row['diskon_rp_2']). '</td>
						<td>' .format_uang($row['diskon_rp_3']). '</td>
						<td>' .format_uang($total_jual). '</td>
						<td>' .$r['nama_gudang']. '</td>
						<td>' .$r['nama_rak']. '</td>
						<td>' .$r['stok']. ' ' .$row['nama_satuan']. '</td>
						<td>' .$r['qty_retur']. ' ' .$row['nama_satuan']. '</td>
						<td>' .format_uang($r['harga_retur']). '</td>
						<td>' .$qty_keluar. '</td>
						<td>' .format_uang($r['harga_retur']*$r['qty_retur']). '</td>';
	if ($qty_keluar!='') {
		echo '<td><i class="fa fa-check"></i></td>';
	} else {
		echo '<td></td>';
	}
	echo '				</tr>';
} else {
	echo '			<tr>
						<td><a data-toggle="modal" data-target="#myModal2" data-id-rbd="' .$r['id_retur_beli_detail']. '" data-qty="' .$r['qty_retur']. '" data-harga="' .$r['harga_retur']. '"><div style="min-width:50px">' .$row['nama_barang']. '</div></a></td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id-rbd="' .$r['id_retur_beli_detail']. '" data-qty="' .$r['qty_retur']. '" data-harga="' .$r['harga_retur']. '"><div style="min-width:50px">' .$row['qty']. ' ' .$row['nama_satuan']. '</div></a></td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id-rbd="' .$r['id_retur_beli_detail']. '" data-qty="' .$r['qty_retur']. '" data-harga="' .$r['harga_retur']. '"><div style="min-width:50px">' .format_uang($row['harga']). '</div></a></td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id-rbd="' .$r['id_retur_beli_detail']. '" data-qty="' .$r['qty_retur']. '" data-harga="' .$r['harga_retur']. '"><div style="min-width:50px">' .format_uang($row['diskon_rp']). '</div></a></td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id-rbd="' .$r['id_retur_beli_detail']. '" data-qty="' .$r['qty_retur']. '" data-harga="' .$r['harga_retur']. '"><div style="min-width:50px">' .format_uang($row['diskon_rp_2']). '</div></a></td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id-rbd="' .$r['id_retur_beli_detail']. '" data-qty="' .$r['qty_retur']. '" data-harga="' .$r['harga_retur']. '"><div style="min-width:50px">' .format_uang($row['diskon_rp_3']). '</div></a></td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id-rbd="' .$r['id_retur_beli_detail']. '" data-qty="' .$r['qty_retur']. '" data-harga="' .$r['harga_retur']. '"><div style="min-width:50px">' .format_uang($total_jual). '</div></a></td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id-rbd="' .$r['id_retur_beli_detail']. '" data-qty="' .$r['qty_retur']. '" data-harga="' .$r['harga_retur']. '"><div style="min-width:50px">' .$r['nama_gudang']. '</div></a></td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id-rbd="' .$r['id_retur_beli_detail']. '" data-qty="' .$r['qty_retur']. '" data-harga="' .$r['harga_retur']. '"><div style="min-width:50px">' .$r['nama_rak']. '</div></a></td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id-rbd="' .$r['id_retur_beli_detail']. '" data-qty="' .$r['qty_retur']. '" data-harga="' .$r['harga_retur']. '"><div style="min-width:50px">' .$r['stok']. ' ' .$row['nama_satuan']. '</div></a></td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id-rbd="' .$r['id_retur_beli_detail']. '" data-qty="' .$r['qty_retur']. '" data-harga="' .$r['harga_retur']. '"><div style="min-width:50px">' .$r['qty_retur']. ' ' .$row['nama_satuan']. '</div></a></td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id-rbd="' .$r['id_retur_beli_detail']. '" data-qty="' .$r['qty_retur']. '" data-harga="' .$r['harga_retur']. '"><div style="min-width:50px">' .format_uang($r['harga_retur']). '</div></a></td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id-rbd="' .$r['id_retur_beli_detail']. '" data-qty="' .$r['qty_retur']. '" data-harga="' .$r['harga_retur']. '"><div style="min-width:50px">' .$qty_keluar. '</div></a></td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id-rbd="' .$r['id_retur_beli_detail']. '" data-qty="' .$r['qty_retur']. '" data-harga="' .$r['harga_retur']. '"><div style="min-width:50px">' .format_uang($r['harga_retur']*$r['qty_retur']). '</div></a></td>
						<td><a href="?page=pembelian&mode=retur_beli_detail&id=' .$id. '&del=' .$r['id_retur_beli_detail']. '" class="btn btn-warning btn-xs" title="Hapus"><i class="fa fa-trash"></i></a></td>
					</tr>';
}
}
}
?>
					
				</tbody>
			</table>
			
			<div class="col-md-12">
				<div class="col-md-4">
				</div>
				<div class="col-md-4">
				</div>
				<div class="col-md-4 text-right">
					<div class="input-group">
						<span class="input-group-addon" style="width:160px;text-align:left;color:#000">Total Jumlah Retur (Rp)</span>
						<input class="form-control text-right" id="total_retur" name="total_retur" value="<?php echo format_uang($total_retur) ?>" readonly>
					</div>
				</div>
			</div>
			
			</div>
			</div>
			</div>
		</div>
		<!-- /page content -->

        
      </div>
    </div>


	
<!-- modal input -->
<div id="myModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><div style="min-width:50px">&times;</div></button>
				<h4 class="modal-title">Tambah Retur Beli Detail</h4>
			</div>
			<div class="modal-body">				
				<form action="" method="post" onsubmit="return valid();">
					<input type="hidden" name="tambah_retur_beli_detail_post" value="true">
					<input type="hidden" id="id_barang_masuk_rak" name="id_barang_masuk_rak" value="">
					<div class="col-md-12">
					<div class="input-group">
						<span class="input-group-addon" style="font-size: 12px;"><i class="fa fa-file fa-fw"></i><br><small>Barang</small></span>
						<select id="select_barang" name="id_beli_detail" class="select2 form-control" required="true">
							<option value="" disabled selected>-= Pilih Barang Retur =-</option>
							<?php 
								$cust=mysqli_query($con, "SELECT
    barang.nama_barang
    , barang_masuk.id_beli_detail
	, barang_masuk_rak.stok
	, barang_masuk_rak.id_barang_masuk_rak
	, satuan.nama_satuan
FROM
    barang_masuk
    INNER JOIN beli_detail 
        ON (barang_masuk.id_beli_detail = beli_detail.id_beli_detail)
    INNER JOIN barang_masuk_rak 
        ON (barang_masuk_rak.id_barang_masuk = barang_masuk.id_barang_masuk)
    INNER JOIN rak 
        ON (barang_masuk_rak.id_rak = rak.id_rak)
    INNER JOIN gudang 
        ON (rak.id_gudang = gudang.id_gudang)
    INNER JOIN barang_supplier 
        ON (beli_detail.id_barang_supplier = barang_supplier.id_barang_supplier)
    INNER JOIN barang 
        ON (barang_supplier.id_barang = barang.id_barang)
	INNER JOIN satuan 
        ON (barang.id_satuan = satuan.id_satuan)
WHERE id_beli=$id_beli");
								while($b=mysqli_fetch_array($cust)){
									$tmp_id=$b['id_barang_masuk_rak'];
									$sql=mysqli_query($con, "SELECT SUM(qty_retur) AS jumlah FROM retur_beli_detail WHERE id_barang_masuk_rak=" .$b['id_barang_masuk_rak']);
									$r=mysqli_fetch_array($sql);
									if ($b['stok']>$r['jumlah']){
										echo '<option data-stok="' .$b['stok']. '" data-jumlah="' .$r['jumlah']. '" data-satuan="' .$b['nama_satuan']. '" data-id-bm="' .$b['id_barang_masuk_rak']. '" value="' .$b['id_beli_detail']. '">' .$b['nama_barang']. ' | Stok : ' .$b['stok']. ' ' .$b['nama_satuan']. '</option>';
									}
								}
							?>
						</select>
						<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-shopping-cart fa-fw" style="width: 33px;"></i><br><small>Qty.</small></span>
						<input id="qty_retur" name="qty_retur" type="tel" class="form-control" placeholder="Qty Retur" min="0" required>
						<span class="input-group-addon" id="det_satuan"></span>
						<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-dollar fa-fw" style="width: 33px;"></i><br><small>Harga</small></span>
						<input id="harga_retur" name="harga_retur" type="tel" class="form-control" placeholder="Harga Retur" required>
						<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
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
				<h4 class="modal-title">Ubah Retur Beli Detail</h4>
			</div>
			<div class="modal-body">				
				<form action="" method="post" onsubmit="return valid2()">
					<input type="hidden" name="edit_retur_beli_detail_post" value="true">
					<input type="hidden" id="id_retur_beli_detail" name="id_retur_beli_detail" value="">
					<div class="col-md-12">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-file fa-fw"></i></span>
						<select id="select_barang_2" name="id_retur_beli_detail" class="select2 form-control" disabled required="true">
							<option value="" disabled selected>-= Pilih Barang Retur =-</option>
							<?php 
								$cust=mysqli_query($con, "SELECT
    barang_masuk_rak.stok
    , retur_beli_detail.id_barang_masuk_rak
	, barang.nama_barang
    , satuan.nama_satuan
    , retur_beli_detail.id_retur_beli_detail
FROM
    retur_beli_detail
    INNER JOIN beli_detail 
        ON (retur_beli_detail.id_beli_detail = beli_detail.id_beli_detail)
    INNER JOIN barang_masuk_rak 
        ON (retur_beli_detail.id_barang_masuk_rak = barang_masuk_rak.id_barang_masuk_rak)
    INNER JOIN barang_supplier 
        ON (beli_detail.id_barang_supplier = barang_supplier.id_barang_supplier)
    INNER JOIN barang 
        ON (barang_supplier.id_barang = barang.id_barang)
    INNER JOIN satuan 
        ON (barang.id_satuan = satuan.id_satuan)
WHERE id_beli=$id_beli");
								while($b=mysqli_fetch_array($cust)){
									$sql=mysqli_query($con, "SELECT SUM(qty_retur) AS jumlah FROM retur_beli_detail WHERE id_barang_masuk_rak=" .$b['id_barang_masuk_rak']);
									$r=mysqli_fetch_array($sql);
									if ($b['stok']>=$r['jumlah']){
										echo '<option data-stok="' .$b['stok']. '" data-jumlah="' .$r['jumlah']. '" data-satuan="' .$b['nama_satuan']. '" data-id-rbd="' .$b['id_retur_beli_detail']. '" value="' .$b['id_retur_beli_detail']. '">' .$b['nama_barang']. ' | Stok : ' .$b['stok']. ' ' .$b['nama_satuan']. '</option>';
									}
								}
							?>
						</select>
						<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-shopping-cart fa-fw"></i></span>
						<input id="qty_retur_2" name="qty_retur" type="tel" class="form-control" placeholder="Qty Retur" min="0" required>
						<span class="input-group-addon" id="det_satuan_2"></span>
						<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-dollar fa-fw"></i></span>
						<input id="harga_retur_2" name="harga_retur" type="tel" class="form-control" placeholder="Harga Retur" required>
						<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
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

<script>
function valid(){
	var max = Number($('#qty_retur').attr("max"));
	if (($('#qty_retur').val() > 0) && ($('#qty_retur').val() <= max) && ($('#harga_retur').val() >= 0)) {
		return true;
	} else {
		$('#qty_retur').val('');
		$('#harga_retur').val('');
		alert('Qty retur > 0, Qty retur <= ' + max + ' dan Harga Retur harus >= 0');
		return false;
	}
}
function valid2(){
	var max = Number($('#qty_retur_2').attr("max"));
	if ($('#qty_retur_2').val() > 0 && $('#qty_retur_2').val() <= max && $('#harga_retur_2').val() >= 0) {
		return true;
	} else {
		$('#qty_retur_2').val('');
		$('#harga_retur_2').val('');
		alert('Qty retur > 0, Qty retur <= ' + max + ' dan Harga Retur harus >= 0');
		return false;
	}
}
$(document).ready(function(){
	$('#qty_retur').inputmask('decimal', {allowMinus:false, autoGroup: true, groupSeparator: '.', rightAlign: false, autoUnmask: true, removeMaskOnSubmit: true});
	$('#harga_retur').inputmask('decimal', {allowMinus:false, autoGroup: true, groupSeparator: '.', rightAlign: false, autoUnmask: true, removeMaskOnSubmit: true});
	$('#qty_retur_2').inputmask('decimal', {allowMinus:false, autoGroup: true, groupSeparator: '.', rightAlign: false, autoUnmask: true, removeMaskOnSubmit: true});
	$('#harga_retur_2').inputmask('decimal', {allowMinus:false, autoGroup: true, groupSeparator: '.', rightAlign: false, autoUnmask: true, removeMaskOnSubmit: true});
	$('#select_barang').on('change', function(){
		var stok = $(this).find(":selected").data('stok');
		var jumlah = $(this).find(":selected").data('jumlah');
		var id_bm = $(this).find(":selected").data('id-bm');
		var sat = $(this).find(":selected").data('satuan');
		$('#qty_retur').attr("max", stok-jumlah);
		$('#id_barang_masuk_rak').val(id_bm);
		$('#det_satuan').html(sat);
	})
	$('#select_barang_2').on('change', function(){
		var stok = $(this).find(":selected").data('stok');
		var jumlah = $(this).find(":selected").data('jumlah');
		var id_rbd = $(this).find(":selected").data('id-rbd');
		var sat = $(this).find(":selected").data('satuan');
		var qty = parseInt($('#qty_retur_2').val());
		$('#qty_retur_2').attr("max", stok-jumlah+qty);
		$('#id_retur_beli_detail').val(id_rbd);
		$('#det_satuan_2').html(sat);
	})
	$('#myModal2').on('show.bs.modal', function(e){
		var id = $(e.relatedTarget).data('id-rbd');
		var qty = $(e.relatedTarget).data('qty');
		var harga = $(e.relatedTarget).data('harga');
		$('#qty_retur_2').val(qty);
		$('#harga_retur_2').val(harga);
		$('#select_barang_2').val(id).change();
	})
});
</script>