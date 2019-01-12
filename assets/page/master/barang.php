<?php
if (isset($tambah_barang_post)){
	$sql = mysqli_query($con, "SELECT COUNT(id_barang) AS MaxID FROM barang WHERE kode_barang like '%" .date('ymd'). "%'");
	$row = mysqli_fetch_array($sql);
	$idx=$row["MaxID"]+1;
	$num=sprintf('%04d', $idx);
	$kode=date('ymd'). $num;
	$sql = "INSERT INTO barang VALUES(null,'$kode','$barcode','$nama',$id_satuan,'$ijin',$min_order,$stok_minimal,$status,$tampil)";
	$q = mysqli_query($con, $sql);
	if ($q){
		_buat_pesan("Input Berhasil. Sekarang Anda dapat menambahkan barang supplier.","green");
	} else {
		_buat_pesan("Input Gagal","red");
	}
	_direct("?page=master&mode=barang");
}
if (isset($edit_barang_post)){
	$sql = "UPDATE barang SET barcode='$barcode',nama_barang='$nama',id_satuan=$id_satuan,no_ijin='$ijin',min_order='$min_order',stok_minimal='$stok_minimal',status='$status',tampil='$tampil' WHERE id_barang=$id_barang";
	$q = mysqli_query($con, $sql);
	if ($q){
		_buat_pesan("Input Berhasil","green");
	} else {
		_buat_pesan("Input Gagal","red");
	}
	_direct("?page=master&mode=barang");
}
if (isset($tambah_barang_supplier_post)){
	$sql = "INSERT INTO barang_supplier VALUES(null,$id_barang,$id_supplier)";
	$q = mysqli_query($con, $sql);
	if ($q){
		_buat_pesan("Input Berhasil. Sekarang Anda dapat menambahkan harga jual.","green");
	} else {
		_buat_pesan("Input Gagal","red");
	}
	_direct("?page=master&mode=barang");
}
if (isset($hapus_barang_supplier_post)){
	$sql = "DELETE FROM barang_supplier WHERE id_barang=$id_barang AND id_supplier=$id_supplier";
	$q = mysqli_query($con, $sql);
	if ($q){
		_buat_pesan("Input Berhasil","green");
	} else {
		_buat_pesan("GAGAL DIHAPUS. SUPPLIER SUDAH ADA DI MASTER HARGA JUAL","red");
	}
	_direct("?page=master&mode=barang");
}
?>

<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h3>MASTER BARANG</h3>
                        <?php
							if (isset($pesan)){
								echo '<span class="badge bg-' .$warna. '">' .$pesan. '</span>';
							}
							?>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="alert alert-info">
                            <strong>Info! Bila tampil=tidak, maka userid-1 tidak dapat melihat barang tersebut</strong><br>
                            <strong>Klik kolom pada tabel untuk ubah.</strong>
                        </div>
                        <p align="right">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                <i class="fa fa-plus"></i>
                                Tambah</button>
                        </p>
                        <div class="table-responsive">
                            <table id="table1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>No.</th>
                                        <th>Barcode</th>
                                        <th>Nama Barang</th>
                                        <th>Sat</th>
                                        <th>Supplier</th>
                                        <th>No. Ijin</th>
                                        <th>Min. Jual</th>
                                        <th>Stok Minimal</th>
                                        <th>Status</th>
                                        <th>Tampil</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
($_SESSION['protection']=true ? $pro='WHERE tampil=1' : $pro='');
$sql=mysqli_query($con, "SELECT
    barang.id_barang
    , barang.kode_barang
    , barang.barcode
    , barang.nama_barang
    , barang.no_ijin
    , barang.min_order
    , barang.stok_minimal
    , barang.status
    , barang.tampil
    , satuan.nama_satuan
FROM
    barang
    INNER JOIN satuan 
        ON (barang.id_satuan = satuan.id_satuan) $pro
ORDER BY barang.id_barang DESC");
$i=0;
while($row=mysqli_fetch_array($sql)){
$i+=1;
$status = ($row['status'] == 1 ? 'Aktif' : 'Non Aktif');
$tampil = ($row['tampil'] == 1 ? 'Ya' : 'Tidak');
$sql2=mysqli_query($con, "SELECT id_barang FROM barang_supplier WHERE id_barang=" .$row['id_barang']. "");
	echo '			<tr>
						<td>
							<div class="btn-group">
								<button data-toggle="dropdown" class="btn btn-primary dropdown-toggle btn-xs" type="button" aria-expanded="false"><span class="caret"></span></button>
								<ul role="menu" class="dropdown-menu">
								  <li><a data-toggle="modal" data-target="#addSuppModal" data-id="' .$row['id_barang']. '">Tambah Supplier</a></li>
								  <li><a data-toggle="modal" data-target="#delSuppModal" data-id="' .$row['id_barang']. '">Hapus Supplier</a></li>
								</ul>
							</div>
						</td>
						<td><a data-toggle="modal" data-target="#editBarangModal" data-id="' .$row['id_barang']. '">' .$i. '</a></td>
						<td><a data-toggle="modal" data-target="#editBarangModal" data-id="' .$row['id_barang']. '">' .$row['barcode']. '</a></td>
						<td><a data-toggle="modal" data-target="#editBarangModal" data-id="' .$row['id_barang']. '">' .$row['nama_barang']. '</a></td>
						<td><a data-toggle="modal" data-target="#editBarangModal" data-id="' .$row['id_barang']. '">' .$row['nama_satuan']. '</a></td>';
	if (mysqli_num_rows($sql2)>0){
		echo '<td><center><a data-toggle="modal" data-target="#mySupplier" data-id="' .$row['id_barang']. '" class="btn btn-primary btn-xs"><i class="fa fa-search-plus"></i> LIHAT</a></center></td>';
	} else {
		echo '<td></td>';
	}
	echo '				<td><a data-toggle="modal" data-target="#editBarangModal" data-id="' .$row['id_barang']. '">' .$row['no_ijin']. '</a></td>
						<td><a data-toggle="modal" data-target="#editBarangModal" data-id="' .$row['id_barang']. '">' .$row['min_order']. '</a></td>
						<td><a data-toggle="modal" data-target="#editBarangModal" data-id="' .$row['id_barang']. '">' .$row['stok_minimal']. '</a></td>
						<td><a data-toggle="modal" data-target="#editBarangModal" data-id="' .$row['id_barang']. '">' .$status. '</a></td>
						<td><a data-toggle="modal" data-target="#editBarangModal" data-id="' .$row['id_barang']. '">' .$tampil. '</a></td>
					</tr>';
}
?>

                                </tbody>
                            </table>
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
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Tambah Data Barang</h4>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <input type="hidden" name="tambah_barang_post" value="true">
                    <div class="form-group col-sm-12">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-bookmark fa-fw" style="width: 55px;"></i><br>
                                <small>Nama</small>
                            </span>
                            <input
                                class="form-control"
                                style="padding: 20px 15px;"
                                type="text"
                                id="nama_barang"
                                name="nama_barang"
                                placeholder="Nama Barang"
                                maxlength="100"
                                required="required">
                            <span class="input-group-addon">
                                <i class="fa fa-star fa-fw" style="color:red"></i>
                            </span>
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-barcode fa-fw" style="width: 55px;"></i><br>
                                <small>Barcode</small>
                            </span>
                            <input
                                class="form-control"
                                type="text"
                                style="padding: 20px 15px;"
                                id="barcode"
                                name="barcode"
                                placeholder="Barcode"
                                maxlength="30"
                                required="required">
                            <span class="input-group-addon">
                                <i class="fa fa-star fa-fw" style="color:red"></i>
                            </span>
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon" style="padding: 2px 12px;">
                                <i class="fa fa-tag fa-fw" style="width: 55px;"></i><br>
                                <small>Satuan</small>
                            </span>
                            <select class="select2 form-control" id="select_satuan" name="id_satuan">
                                <option value="" disabled="disabled" selected="selected">Pilih Satuan</option>
                                <?php 
									$brg=mysqli_query($con, "select * from satuan");
									while($b=mysqli_fetch_array($brg)){
								?>
                                <option value="<?php echo $b['id_satuan']; ?>"><?php echo $b['nama_satuan'];?></option>
                                <?php 
									}
								?>
                            </select>
                            <span class="input-group-addon">
                                <i class="fa fa-star fa-fw" style="color:red"></i>
                            </span>
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-warning fa-fw" style="width: 55px;"></i><br>
                                <small>Min. Jual</small>
                            </span>
                            <input
                                id="min_order"
                                type="text"
                                name="min_order"
                                style="padding: 20px 15px;"
                                class="form-control"
                                placeholder="Minimal Jual"
                                maxlength="7"
                                required="required">
                            <span class="input-group-addon">
                                <i class="fa fa-star fa-fw" style="color:red"></i>
                            </span>
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-warning fa-fw" style="width: 55px;"></i><br>
                                <small>Stok Min.</small>
                            </span>
                            <input
                                id="stok_min"
                                type="text"
                                name="stok_minimal"
                                style="padding: 20px 15px;"
                                class="form-control"
                                placeholder="Stok Minimal"
                                maxlength="7"
                                required="required">
                            <span class="input-group-addon">
                                <i class="fa fa-star fa-fw" style="color:red"></i>
                            </span>
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-certificate fa-fw" style="width: 55px;"></i><br>
                                <small>No. Ijin</small>
                            </span>
                            <input
                                id="ijin"
                                type="text"
                                name="ijin"
                                style="padding: 20px 15px;"
                                class="form-control"
                                placeholder="No. Ijin"
                                maxlength="25"
                                required="required">
                            <span class="input-group-addon">
                                <i class="fa fa-star fa-fw" style="color:red"></i>
                            </span>
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon" style="padding: 2px 12px;">
                                <i class="fa fa-flag fa-fw" style="width: 55px;"></i><br>
                                <small>Status</small>
                            </span>
                            <select
                                class="form-control select"
                                id="select_status"
                                name="status"
                                required="required">
                                <option value="" disabled="disabled" selected="selected">Pilih Status</option>
                                <option value="0">NON AKTIF</option>
                                <option value="1">AKTIF</option>
                            </select>
                            <span class="input-group-addon">
                                <i class="fa fa-star fa-fw" style="color:red"></i>
                            </span>
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon" style="padding: 2px 12px;">
                                <i class="fa fa-flag fa-fw" style="width: 55px;"></i><br>
                                <small>Tampilkan</small>
                            </span>
                            <select
                                class="form-control select"
                                id="select_tampil"
                                name="tampil"
                                required="required">
                                <option value="" disabled="disabled" selected="selected">Tampilkan ke semua user ?</option>
                                <option value="0">TIDAK</option>
                                <option value="1">YA</option>
                            </select>
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

<!-- modal view -->
<div id="mySupplier" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Supplier</h4>
            </div>
            <div class="modal-body">
                <div id="get_supplier"></div>
            </div>
        </div>
    </div>
</div>

<!-- modal input -->
<div id="addSuppModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Tambah Supplier</h4>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <input type="hidden" name="tambah_barang_supplier_post" value="true">
                    <div class="form-group col-sm-12">
                        <div id="get_supplier_2"></div>
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
<div id="delSuppModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Hapus Supplier</h4>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <input type="hidden" name="hapus_barang_supplier_post" value="true">
                    <input type="hidden" name="id_supplier" value="">
                    <div class="form-group col-sm-12">
                        <div id="get_supplier_3"></div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary" value="Hapus">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- modal input -->
<div id="editBarangModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Ubah Data Barang</h4>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <input type="hidden" name="edit_barang_post" value="true">
                    <div class="form-group col-sm-12">
                        <div id="get_barang"></div>
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
    $(document).ready(function () {
        $('#min_order').inputmask('decimal', {
            allowMinus: false,
            autoGroup: true,
            groupSeparator: '.',
            rightAlign: false,
            autoUnmask: true,
            removeMaskOnSubmit: true
        });
        $('#stok_min').inputmask('decimal', {
            allowMinus: false,
            autoGroup: true,
            groupSeparator: '.',
            rightAlign: false,
            autoUnmask: true,
            removeMaskOnSubmit: true
        });
        $('#mySupplier').on('show.bs.modal', function (e) {
            var id = $(e.relatedTarget).data('id');
            $('#get_supplier').load('api/web/get-barang-supplier.php?id=' + id);
        })
        $('#addSuppModal').on('show.bs.modal', function (e) {
            var id = $(e.relatedTarget).data('id');
            $('#get_supplier_2').load('api/web/add-barang-supplier.php?id=' + id);
        })
        $('#delSuppModal').on('show.bs.modal', function (e) {
            var id = $(e.relatedTarget).data('id');
            $('#get_supplier_3').load('api/web/del-barang-supplier.php?id=' + id);
        })
        $('#editBarangModal').on('show.bs.modal', function (e) {
            var id = $(e.relatedTarget).data('id');
            $('#get_barang').load('api/web/get-barang.php?id=' + id, function () {
                $('#min_order_2').inputmask('decimal', {
                    allowMinus: false,
                    autoGroup: true,
                    groupSeparator: '.',
                    rightAlign: false,
                    autoUnmask: true,
                    removeMaskOnSubmit: true
                });
                $('#stok_min_2').inputmask('decimal', {
                    allowMinus: false,
                    autoGroup: true,
                    groupSeparator: '.',
                    rightAlign: false,
                    autoUnmask: true,
                    removeMaskOnSubmit: true
                });
            });
        })
    });
</script>