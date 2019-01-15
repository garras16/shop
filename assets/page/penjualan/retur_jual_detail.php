<?php
$sql=mysqli_query($con, "SELECT * FROM retur_jual_detail WHERE id_retur_jual=$id AND qty_masuk IS NOT NULL");
(mysqli_num_rows($sql)>0 ? $locked=true : $locked=false);
if (isset($tambah_retur_jual_detail_post)){
	if ($locked) {
		_buat_pesan("Input Gagal. Barang sudah diproses di gudang.","red");
		_direct("?page=penjualan&mode=retur_jual_detail&id=$id");
		return;
	}
	$sql = mysqli_query($con, "SELECT * FROM retur_jual_detail WHERE id_retur_jual=$id AND id_jual_detail=$id_jual_detail");
	if (mysqli_num_rows($sql)==0){
		$sql2 = mysqli_query($con, "SELECT SUM(qty_retur) AS qty_retur FROM retur_jual_detail WHERE id_jual_detail=$id_jual_detail");
		$row2=mysqli_fetch_array($sql2);
		$total_qty_retur=$row2['qty_retur'];
		$sql2 = mysqli_query($con, "SELECT SUM(qty_ambil) AS qty_ambil FROM nota_siap_kirim_detail WHERE id_jual_detail=$id_jual_detail");
		$row2=mysqli_fetch_array($sql2);
		$total_qty_ambil=$row2['qty_ambil'];
		if ($total_qty_retur+$qty_retur <= $total_qty_ambil){
			$sql = "INSERT INTO retur_jual_detail VALUES(null,$id,$id_jual_detail,$qty_retur,$harga_retur,null,null,null,null)";
			$q = mysqli_query($con, $sql);
			if ($q){
				_buat_pesan("Input Berhasil","green");
			} else {
				_buat_pesan("Input Gagal","red");
			}
		} else {
			_buat_pesan("Input Gagal. Jumlah Total Barang Retur melebihi Total Barang Jual Pada Nota Ini.","red");
		}
	} else {
		_buat_pesan("Input Gagal. Barang sudah pernah dipilih.","red");
	}
	_direct("?page=penjualan&mode=retur_jual_detail&id=$id");
}	
if (isset($edit_retur_jual_detail_post)){
	if ($locked) {
		_buat_pesan("Input Gagal. Barang sudah diproses di gudang.","red");
		_direct("?page=penjualan&mode=retur_jual_detail&id=$id");
		return;
	}
	$sql = "UPDATE retur_jual_detail SET qty_retur=$qty_retur,harga_retur=$harga_retur WHERE id_retur_jual_detail=$id_retur_jual_detail";
	$q = mysqli_query($con, $sql);
	if ($q){
		_buat_pesan("Input Berhasil","green");
	} else {
		_buat_pesan("Input Gagal","red");
	}
	_direct("?page=penjualan&mode=retur_jual_detail&id=$id");
}
if (isset($_GET['del'])){
	if ($locked) {
		_buat_pesan("Input Gagal. Barang sudah diproses di gudang.","red");
		_direct("?page=penjualan&mode=retur_jual_detail&id=$id");
		return;
	}
	$sql = "DELETE FROM retur_jual_detail WHERE id_retur_jual_detail=" .$_GET['del'];
	$q = mysqli_query($con, $sql);
	if ($q){
		_buat_pesan("Input Berhasil","green");
	} else {
		_buat_pesan("Input Gagal","red");
	}
	_direct("?page=penjualan&mode=retur_jual_detail&id=$id");
}
$sql=mysqli_query($con, "SELECT
    pelanggan.nama_pelanggan
	, jual.id_jual
    , jual.invoice
    , retur_jual.no_retur_jual
	, retur_jual.status
    , retur_jual.tgl_retur
    , bayar_nota_jual.status AS status_bayar
FROM
    jual
    INNER JOIN pelanggan 
        ON (jual.id_pelanggan = pelanggan.id_pelanggan)
    INNER JOIN retur_jual 
        ON (retur_jual.id_jual = jual.id_jual)
	LEFT JOIN bayar_nota_jual 
        ON (jual.invoice = bayar_nota_jual.no_nota_jual)
WHERE retur_jual.id_retur_jual=$id");
$row=mysqli_fetch_array($sql);
$id_jual=$row['id_jual'];
$no_nota_jual=$row['invoice'];
$status=$row['status'];
$status_retur="";
if ($status=='1') $status_retur="SELESAI";
if ($status=='2') $status_retur="SUDAH CETAK";
if ($row['status_bayar']=='1'){
	$status_bayar="LUNAS";
} else if ($row['status_bayar']=='2'){
	$status_bayar="TERBAYAR SEBAGIAN. (klik untuk detail).";
} else {
	$status_bayar="BELUM TERBAYAR";
}
?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h3>RETUR PENJUALAN DETAIL</h3>
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
                                <span class="input-group-addon">
                                    <i class="fa fa-building fa-fw" style="width: 68px;"></i><br>
                                    <small>Pelanggan</small>
                                </span>
                                <input
                                    class="form-control"
                                    id="pelanggan"
                                    style="padding: 20px 15px;"
                                    name="pelanggan"
                                    placeholder="Nama Pelanggan"
                                    title="Nama Pelanggan"
                                    value="<?php echo $row['nama_pelanggan'] ?>"
                                    disabled="disabled"
                                    required="required">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-file fa-fw" style="width: 68px;"></i><br>
                                    <small>No. Nota</small>
                                </span>
                                <input
                                    class="form-control"
                                    id="no_nota_jual"
                                    name="no_nota_jual"
                                    style="padding: 20px 15px;"
                                    placeholder="No Nota Jual"
                                    title="No Nota Jual"
                                    value="<?php echo $row['invoice'] ?>"
                                    disabled="disabled"
                                    required="required">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-file-excel fa-fw"></i><br>
                                    <small style="font-size: 10px;">No. Nota Retur</small>
                                </span>
                                <input
                                    class="form-control"
                                    id="no_nota_retur"
                                    name="no_nota_retur"
                                    style="padding: 20px 15px;"
                                    placeholder="No Nota Retur Jual"
                                    title="No Nota Retur Jual"
                                    value="<?php echo $row['no_retur_jual'] ?>"
                                    disabled="disabled"
                                    required="required">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar fa-fw" style="width: 68px;"></i><br>
                                    <small>Tgl. Retur</small>
                                </span>
                                <input
                                    class="form-control"
                                    id="tgl_retur"
                                    name="tgl_retur"
                                    style="padding: 20px 15px;"
                                    placeholder="Tanggal Retur"
                                    title="Tanggal Retur"
                                    value="<?php echo date("d-m-Y", strtotime($row['tgl_retur'])) ?>"
                                    disabled="disabled"
                                    required="required">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-tags fa-fw" style="width: 68px;"></i><br>
                                    <small>Stat. Bayar</small>
                                </span>
                                <?php if ($row['status_bayar']=='2') echo '<a data-toggle="modal" data-target="#myModal3">'; ?>
                                <input
                                    class="form-control"
                                    id="status_bayar"
                                    name="status_bayar"
                                    style="padding: 20px 15px;"
                                    placeholder="Status Bayar"
                                    title="Status Bayar"
                                    value="<?php echo $status_bayar ?>"
                                    readonly="readonly"
                                    required="required">
                                <?php if ($row['status_bayar']=='2') echo '</a>'; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-bookmark fa-fw" style="width: 68px"></i><br>
                                    <small>Stat. Retur</small>
                                </span>
                                <input
                                    class="form-control"
                                    id="status_retur"
                                    name="status_retur"
                                    style="padding: 20px 15px;"
                                    placeholder="Status Retur"
                                    title="Status Retur"
                                    value="<?php echo $status_retur ?>"
                                    disabled="disabled"
                                    required="required">
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-xs-6">
                            <p align="left">
                                <a class="btn btn-danger" href="?page=penjualan&mode=retur_jual">
                                    <i class="fa fa-arrow-left"></i>
                                    Kembali</a>
                            </p>
                        </div>
                        <div class="col-xs-6">
                        <?php
			if ($status=='1' || $status=='2' || $locked) {
				if ($status=='1' || $status=='2' || !$locked) echo '<p align="right"><a target="_blank" href="?page=penjualan&mode=cetak_retur_jual&frameless&id=' .$id. '" class="btn btn-primary"><i class="fa fa-print"></i> Cetak</a></p>';
			} else {
				echo '<p align="right"><button class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Tambah</button></p>';
			}
			?>
                        </div>
                        <div class="clearfix" style="margin-bottom: 50px;"></div>
                        <table
                            id="table1"
                            class="table table-bordered table-striped"
                            style="width: 2200px;">
                            <thead>
                                <tr>
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
                                    <th>Qty Retur Jual</th>
                                    <th>Harga Retur Jual (Rp)</th>
                                    <th>Qty Masuk</th>
                                    <th>Jumlah Retur Jual (Rp)</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
$sql=mysqli_query($con, "SELECT status_konfirm
FROM
    retur_jual
    INNER JOIN jual 
        ON (retur_jual.id_jual = jual.id_jual)
 WHERE id_retur_jual=$id");
$row=mysqli_fetch_array($sql);
if ($row['status_konfirm']>=0 && $row['status_konfirm']<=2) $tipe='nota_siap_kirim_detail';
if ($row['status_konfirm']>=5 && $row['status_konfirm']<=7) $tipe='canvass_siap_kirim_detail';
		
$sql=mysqli_query($con, "SELECT *, SUM(qty_ambil) AS qty
FROM
    jual_detail
    LEFT JOIN retur_jual_detail 
        ON (jual_detail.id_jual_detail = retur_jual_detail.id_jual_detail)
    INNER JOIN harga_jual 
        ON (jual_detail.id_harga_jual = harga_jual.id_harga_jual)
    INNER JOIN $tipe 
        ON (retur_jual_detail.id_jual_detail = $tipe.id_jual_detail)
    INNER JOIN barang_supplier 
        ON (harga_jual.id_barang_supplier = barang_supplier.id_barang_supplier)
    INNER JOIN barang 
        ON (barang_supplier.id_barang = barang.id_barang)
    INNER JOIN satuan 
        ON (barang.id_satuan = satuan.id_satuan)
 WHERE retur_jual_detail.id_retur_jual=$id AND cek=1
 GROUP BY retur_jual_detail.id_jual_detail");
$total_retur=0;
while($row=mysqli_fetch_array($sql)){
if ($row['qty_masuk']==''){
	$total_retur+=$row['harga_retur']*$row['qty_retur'];
	$jml_retur=$row['harga_retur']*$row['qty_retur'];
} else {
	$total_retur+=$row['harga_retur']*$row['qty_masuk'];
	$jml_retur=$row['harga_retur']*$row['qty_masuk'];
}
($row['qty_masuk']=='' ? $qty_masuk='' : $qty_masuk=$row['qty_masuk']. ' ' .$row['nama_satuan']);
	$tot_seb_disk=$row['qty']*$row['harga_jual'];
	$diskon1=$row['harga_jual']*$row['diskon_persen']/100;
	$tot_set_disk_1=$row['qty']*($row['harga_jual']-$diskon1);
	$diskon2=($row['harga_jual']-$diskon1)*$row['diskon_persen_2']/100;
	$tot_set_disk_2=$row['qty']*($row['harga_jual']-$diskon1-$diskon2);
	$diskon3=($row['harga_jual']-$diskon1-$diskon2)*$row['diskon_persen_3']/100;
	$tot_set_disk_3=$row['qty']*($row['harga_jual']-$diskon1-$diskon2-$diskon3);
	if($tot_set_disk_1 < 0 || $tot_set_disk_2 < 0 || $tot_set_disk_3 < 0) {
		$val = "color: red;";
	}else{
		$val = "color: black;";
	}
if ($status=="1" or $locked){
	echo '			<tr>
						<td style="'.$val.'">' .$row['nama_barang']. '</td>
						<td style="'.$val.'">' .$row['qty']. ' ' .$row['nama_satuan']. '</td>
						<td style="'.$val.'">' .format_uang($row['harga']). '</td>
						<td style="'.$val.'">' .format_uang($tot_seb_disk). '</td>
						<td style="'.$val.'">' .format_uang($diskon1). '</td>
						<td style="'.$val.'">' .format_uang($tot_set_disk_1). '</td>
						<td style="'.$val.'">' .format_uang($diskon2). '</td>
						<td style="'.$val.'">' .format_uang($tot_set_disk_2). '</td>
						<td style="'.$val.'">' .format_uang($diskon3). '</td>
						<td style="'.$val.'">' .format_uang($tot_set_disk_3). '</td>
						<td style="'.$val.'">' .$row['qty_retur']. ' ' .$row['nama_satuan']. '</td>
						<td style="'.$val.'">' .format_uang($row['harga_retur']). '</td>
						<td style="'.$val.'">' .$qty_masuk. '</td>
						<td style="'.$val.'">' .format_uang($jml_retur). '</td>';
	if ($qty_masuk!='') {
		echo '<td><i class="fa fa-check"></i></td>';
	} else {
		echo '<td></td>';
	}
	echo '				</tr>';
} else {
	echo '			<tr>
						<td><a data-toggle="modal" data-target="#myModal2" data-id-rjd="' .$row['id_retur_jual_detail']. '" data-qty="' .$row['qty_retur']. '" data-harga="' .$row['harga_retur']. '"><div style="min-width:50px;'.$val.'">' .$row['nama_barang']. '</div></a></td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id-rjd="' .$row['id_retur_jual_detail']. '" data-qty="' .$row['qty_retur']. '" data-harga="' .$row['harga_retur']. '"><div style="min-width:50px;'.$val.'">' .$row['qty']. ' ' .$row['nama_satuan']. '</div></a></td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id-rjd="' .$row['id_retur_jual_detail']. '" data-qty="' .$row['qty_retur']. '" data-harga="' .$row['harga_retur']. '"><div style="min-width:50px;'.$val.'">' .format_uang($row['harga']). '</div></a></td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id-rjd="' .$row['id_retur_jual_detail']. '" data-qty="' .$row['qty_retur']. '" data-harga="' .$row['harga_retur']. '"><div style="min-width:50px;'.$val.'">' .format_uang($tot_seb_disk). '</div></a></td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id-rjd="' .$row['id_retur_jual_detail']. '" data-qty="' .$row['qty_retur']. '" data-harga="' .$row['harga_retur']. '"><div style="min-width:50px;'.$val.'">' .format_uang($diskon1). '</div></a></td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id-rjd="' .$row['id_retur_jual_detail']. '" data-qty="' .$row['qty_retur']. '" data-harga="' .$row['harga_retur']. '"><div style="min-width:50px;'.$val.'">' .format_uang($tot_set_disk_1). '</div></a></td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id-rjd="' .$row['id_retur_jual_detail']. '" data-qty="' .$row['qty_retur']. '" data-harga="' .$row['harga_retur']. '"><div style="min-width:50px;'.$val.'">' .format_uang($diskon2). '</div></a></td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id-rjd="' .$row['id_retur_jual_detail']. '" data-qty="' .$row['qty_retur']. '" data-harga="' .$row['harga_retur']. '"><div style="min-width:50px;'.$val.'">' .format_uang($tot_set_disk_2). '</div></a></td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id-rjd="' .$row['id_retur_jual_detail']. '" data-qty="' .$row['qty_retur']. '" data-harga="' .$row['harga_retur']. '"><div style="min-width:50px;'.$val.'">' .format_uang($diskon3). '</div></a></td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id-rjd="' .$row['id_retur_jual_detail']. '" data-qty="' .$row['qty_retur']. '" data-harga="' .$row['harga_retur']. '"><div style="min-width:50px;'.$val.'">' .format_uang($tot_set_disk_3). '</div></a></td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id-rjd="' .$row['id_retur_jual_detail']. '" data-qty="' .$row['qty_retur']. '" data-harga="' .$row['harga_retur']. '"><div style="min-width:50px;'.$val.'">' .$row['qty_retur']. ' ' .$row['nama_satuan']. '</div></a></td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id-rjd="' .$row['id_retur_jual_detail']. '" data-qty="' .$row['qty_retur']. '" data-harga="' .$row['harga_retur']. '"><div style="min-width:50px;'.$val.'">' .format_uang($row['harga_retur']). '</div></a></td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id-rjd="' .$row['id_retur_jual_detail']. '" data-qty="' .$row['qty_retur']. '" data-harga="' .$row['harga_retur']. '"><div style="min-width:50px;'.$val.'">' .$qty_masuk. '</div></a></td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id-rjd="' .$row['id_retur_jual_detail']. '" data-qty="' .$row['qty_retur']. '" data-harga="' .$row['harga_retur']. '"><div style="min-width:50px;'.$val.'">' .format_uang($jml_retur). '</div></a></td>
						<td><a href="?page=penjualan&mode=retur_jual_detail&id=' .$id. '&del=' .$row['id_retur_jual_detail']. '" class="btn btn-warning btn-xs" title="Hapus"><i class="fa fa-trash"></i></a></td>
					</tr>';
}
}
?>

                            </tbody>
                        </table>

                        <div class="col-md-12" style="margin-top: 50px; padding-left: 0px;">
                            <div class="col-md-4 text-right" style="padding-left: 0px;">
                                <div class="input-group">
                                    <span
                                        class="input-group-addon"
                                        style="padding-left:0px;width:90px;text-align:left; background: #fff;color:#000;border: none; outline: none;">Total Jumlah Retur</span>
                                    <span
                                        class="input-group-addon"
                                        style="padding:10px 0px;width:2px;text-align:left; background: #fff;color:#000;border: none; outline: none;">:</span>
                                    <input
                                        class="form-control"
                                        id="total_retur"
                                        style="border: none; background: #fff; outline: none;"
                                        name="total_retur"
                                        value="<?php echo format_uang($total_retur) ?>"
                                        readonly="readonly">
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
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <div style="min-width:50px">&times;</div>
                </button>
                <h4 class="modal-title">Tambah Retur Jual Detail</h4>
            </div>
            <div class="modal-body">
                <form action="" method="post" onsubmit="return valid();">
                    <input type="hidden" name="tambah_retur_jual_detail_post" value="true">
                    <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon" style="padding: 2px 12px;">
                                <i class="fa fa-file fa-fw"></i><br>
                                <small>Barang</small>
                            </span>
                            <select
                                id="select_barang"
                                name="id_jual_detail"
                                class="select2 form-control"
                                required="true">
                                <option value="" disabled="disabled" selected="selected">-= Pilih Barang Retur =-</option>
                                <?php 
								$cust=mysqli_query($con, "SELECT *
FROM
    jual_detail
    INNER JOIN harga_jual 
        ON (jual_detail.id_harga_jual = harga_jual.id_harga_jual)
    INNER JOIN barang_supplier 
        ON (harga_jual.id_barang_supplier = barang_supplier.id_barang_supplier)
    INNER JOIN barang 
        ON (barang_supplier.id_barang = barang.id_barang)
    INNER JOIN satuan 
        ON (barang.id_satuan = satuan.id_satuan)
WHERE id_jual=$id_jual");
								while($b=mysqli_fetch_array($cust)){
									echo '<option data-qty-jual="' .$b['qty']. '" data-satuan="' .$b['nama_satuan']. '" value="' .$b['id_jual_detail']. '">' .$b['nama_barang']. ' | Qty Jual : ' .$b['qty']. ' ' .$b['nama_satuan']. '</option>';
								}
							?>
                            </select>
                            <span class="input-group-addon">
                                <i class="fa fa-star fa-fw" style="color:red"></i>
                            </span>
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-shopping-cart fa-fw" style="width: 39px;"></i><br>
                                <small>Qty.</small>
                            </span>
                            <input
                                id="qty_retur"
                                name="qty_retur"
                                type="tel"
                                style="padding: 20px 15px;"
                                class="form-control"
                                placeholder="Qty Retur"
                                min="0"
                                required="required">
                            <span class="input-group-addon" id="det_satuan"></span>
                            <span class="input-group-addon">
                                <i class="fa fa-star fa-fw" style="color:red"></i>
                            </span>
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-dollar fa-fw" style="width: 39px;"></i><br>
                                <small>Harga</small>
                            </span>
                            <input
                                id="harga_retur"
                                name="harga_retur"
                                style="padding: 20px 15px;"
                                type="tel"
                                class="form-control"
                                placeholder="Harga Retur"
                                required="required">
                            <span class="input-group-addon">
                                <i class="fa fa-star fa-fw" style="color:red"></i>
                            </span>
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
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <div style="min-width:50px">&times;</div>
                </button>
                <h4 class="modal-title">Ubah Retur Jual Detail</h4>
            </div>
            <div class="modal-body">
                <form action="" method="post" onsubmit="return valid2()">
                    <input type="hidden" name="edit_retur_jual_detail_post" value="true">
                    <input
                        type="hidden"
                        id="id_retur_jual_detail"
                        name="id_retur_jual_detail"
                        value="">
                    <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon" style="padding: 2px 12px;">
                                <i class="fa fa-file fa-fw"></i><br>
                                <small>Barang</small>
                            </span>
                            <select
                                id="select_barang_2"
                                class="select2 form-control"
                                disabled="disabled"
                                required="true">
                                <option value="" disabled="disabled" selected="selected">-= Pilih Barang Retur =-</option>
                                <?php 
								$cust=mysqli_query($con, "SELECT 
    barang.nama_barang
	, jual_detail.qty
    , satuan.nama_satuan
    , retur_jual_detail.id_retur_jual_detail
FROM
    retur_jual_detail
    INNER JOIN jual_detail 
        ON (retur_jual_detail.id_jual_detail = jual_detail.id_jual_detail)
    INNER JOIN harga_jual 
        ON (jual_detail.id_harga_jual = harga_jual.id_harga_jual)
    INNER JOIN barang_supplier 
        ON (harga_jual.id_barang_supplier = barang_supplier.id_barang_supplier)
    INNER JOIN barang 
        ON (barang_supplier.id_barang = barang.id_barang)
    INNER JOIN satuan 
        ON (barang.id_satuan = satuan.id_satuan)
WHERE id_jual=$id_jual");
								while($b=mysqli_fetch_array($cust)){
									echo '<option data-qty-jual="' .$b['qty']. '" data-satuan="' .$b['nama_satuan']. '" data-id-rjd="' .$b['id_retur_jual_detail']. '" value="' .$b['id_retur_jual_detail']. '">' .$b['nama_barang']. ' | Qty Jual : ' .$b['qty']. ' ' .$b['nama_satuan']. '</option>';
								}
							?>
                            </select>
                            <span class="input-group-addon">
                                <i class="fa fa-star fa-fw" style="color:red"></i>
                            </span>
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-shopping-cart fa-fw" style="width: 39px;"></i><br>
                                <small>Qty.</small>
                            </span>
                            <input
                                id="qty_retur_2"
                                name="qty_retur"
                                style="padding: 20px 15px;"
                                type="tel"
                                class="form-control"
                                placeholder="Qty Retur"
                                min="0"
                                required="required">
                            <span class="input-group-addon" id="det_satuan_2"></span>
                            <span class="input-group-addon">
                                <i class="fa fa-star fa-fw" style="color:red"></i>
                            </span>
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-dollar fa-fw" style="width: 39px;"></i><br>
                                <small>Harga</small>
                            </span>
                            <input
                                id="harga_retur_2"
                                name="harga_retur"
                                type="tel"
                                style="padding: 20px 15px;"
                                class="form-control"
                                placeholder="Harga Retur"
                                required="required">
                            <span class="input-group-addon">
                                <i class="fa fa-star fa-fw" style="color:red"></i>
                            </span>
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
<div id="myModal3" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <div style="min-width:50px">&times;</div>
                </button>
                <h4 class="modal-title">DETAIL PEMBAYARAN
                    <b><?php echo $no_nota_jual ?></b></h4>
            </div>
            <div class="modal-body">
                <?php
					// $sql2=mysqli_query($con, "SELECT jumlah FROM nota_sudah_cek WHERE status='2' AND id_jual=$id_jual");
					// $b2=mysqli_fetch_array($sql2);
                    // $jumlah_nota=$b2['jumlah'];

                    $tmp_id_jual=$row['id_jual'];
                    $sql2=mysqli_query($con, "SELECT SUM(qty*(harga-diskon_rp-diskon_rp_2-diskon_rp_3)) AS jumlah_nota FROM jual_detail WHERE id_jual=$id_jual");
                    $b2=mysqli_fetch_array($sql2);
                    
                    $sqll = mysqli_query($con, "SELECT ppn_all_persen FROM jual WHERE id_jual=$id_jual");
                    $bb = mysqli_fetch_array($sqll);
                    $set_dis=$b2['jumlah_nota']-($b2['jumlah_nota']*$row['diskon_all_persen']/100);
                    $ppn = $set_dis*($bb['ppn_all_persen']/100);
                    $jumlah_nota = $set_dis+$ppn;
				?>
                <div class="input-group">
                    <span class="input-group-addon">Jumlah Nota Jual</span>
                    <input
                        style="text-align:right;"
                        id="jumlah_nota"
                        name="jumlah_nota"
                        class="form-control"
                        placeholder="Jumlah Nota Jual"
                        title="Jumlah Nota Jual"
                        value="<?php echo 'Rp. ' .format_uang($jumlah_nota) ?>"
                        readonly="readonly">
                </div>
                <table id="table1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Tanggal Bayar</th>
                            <th>Jenis Bayar</th>
                            <th>Jumlah Bayar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
							$sql=mysqli_query($con, "SELECT * FROM bayar_nota_jual WHERE no_nota_jual='$no_nota_jual'");
							$total_bayar=0;
							while($row=mysqli_fetch_array($sql)){
								$total_bayar+=$row['jumlah'];
								echo '<tr>
										<td align="center">' .date("d-m-Y",strtotime($row['tgl_bayar'])). '</td>
										<td align="center">' .$row['jenis']. '</td>
										<td align="right">Rp. ' .format_uang($row['jumlah']). '</td>
									</tr>';
							}
						?>
                    </tbody>
                </table>
                <?php
					$sisa_nota=$jumlah_nota-$total_bayar;
				?>
                <div class="input-group">
                    <span class="input-group-addon">Sisa Nota Jual</span>
                    <input
                        style="text-align:right;"
                        id="sisa_nota"
                        name="sisa_nota"
                        class="form-control"
                        placeholder="Sisa Nota Jual"
                        title="Sisa Nota Jual"
                        value="<?php echo 'Rp. ' .format_uang($sisa_nota) ?>"
                        readonly="readonly">
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function valid() {
        var max = Number($('#qty_retur').attr("max"));
        if ($('#qty_retur').val() > 0 && $('#qty_retur').val() <= max && $('#harga_retur').val() >= 0) {
            return true;
        } else {
            $('#qty_retur').val('');
            $('#harga_retur').val('');
            alert(
                'Qty retur > 0, Qty retur <= ' + max + ' dan Harga Retur harus >= 0'
            );
            return false;
        }
    }
    function valid2() {
        var max = Number($('#qty_retur_2').attr("max"));
        if ($('#qty_retur_2').val() > 0 && $('#qty_retur_2').val() <= max && $('#harga_retur_2').val() >= 0) {
            return true;
        } else {
            $('#qty_retur_2').val('');
            $('#harga_retur_2').val('');
            alert(
                'Qty retur > 0, Qty retur <= ' + max + ' dan Harga Retur harus >= 0'
            );
            return false;
        }
    }
    $(document).ready(function () {
        $('#qty_retur').inputmask('decimal', {
            allowMinus: false,
            autoGroup: true,
            groupSeparator: '.',
            rightAlign: false,
            autoUnmask: true,
            removeMaskOnSubmit: true
        });
        $('#total_retur').inputmask('currency', {
            prefix: "Rp ",
            allowMinus: false,
            autoGroup: true,
            groupSeparator: '.',
            rightAlign: false,
            removeMaskOnSubmit: true
        });
        $('#harga_retur').inputmask('currency', {
            prefix: "Rp ",
            allowMinus: false,
            autoGroup: true,
            groupSeparator: '.',
            rightAlign: false,
            autoUnmask: true,
            removeMaskOnSubmit: true
        });
        $('#qty_retur_2').inputmask('decimal', {
            allowMinus: false,
            autoGroup: true,
            groupSeparator: '.',
            rightAlign: false,
            autoUnmask: true,
            removeMaskOnSubmit: true
        });
        $('#harga_retur_2').inputmask('currency', {
            prefix: "Rp ",
            allowMinus: false,
            autoGroup: true,
            groupSeparator: '.',
            rightAlign: false,
            autoUnmask: true,
            removeMaskOnSubmit: true
        });
        $('#select_barang').on('change', function () {
            var qty_jual = $(this)
                .find(":selected")
                .data('qty-jual');
            var sat = $(this)
                .find(":selected")
                .data('satuan');
            $('#qty_retur').attr("max", qty_jual);
            $('#det_satuan').html(sat);
        })
        $('#select_barang_2').on('change', function () {
            var qty_jual = $(this)
                .find(":selected")
                .data('qty-jual');
            var sat = $(this)
                .find(":selected")
                .data('satuan');
            $('#qty_retur_2').attr("max", qty_jual);
            $('#det_satuan_2').html(sat);
        })
        $('#myModal2').on('show.bs.modal', function (e) {
            var id = $(e.relatedTarget).data('id-rjd');
            var qty = $(e.relatedTarget).data('qty');
            var harga = $(e.relatedTarget).data('harga');
            $('#qty_retur_2').val(qty);
            $('#harga_retur_2').val(harga);
            $('#id_retur_jual_detail').val(id);
            $('#select_barang_2')
                .val(id)
                .change();
        })
    });
</script>