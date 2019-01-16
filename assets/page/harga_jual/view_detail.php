<?php
if (isset($tambah_harga_jual_tunai_post)){
	$sql = "INSERT INTO harga_jual VALUES(null,'$id_barang_supplier','$id','$harga_jual')";
	$q = mysqli_query($con, $sql);
	if ($q){
		_buat_pesan("Input Berhasil. Sekarang Anda dapat melakukan transaksi pembelian.","green");
	} else {
		_buat_pesan("Input Gagal","red");
	}
	$tgl = date("Y-m-d");
	$sql = mysqli_query($con, "INSERT INTO hj_tunai_detail VALUES(null,$id_barang_supplier,$id,'$tgl',$harga_jual)");
	_direct("?page=harga_jual&mode=view_detail&id=$id");
}

	$sql=mysqli_query($con, "SELECT nama_pelanggan FROM pelanggan WHERE id_pelanggan=$id");
	$row=mysqli_fetch_array($sql);
	$nama_pelanggan = $row['nama_pelanggan'];
?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h3>MASTER HARGA JUAL -
                            <?php echo $nama_pelanggan ?></h3>
                        <?php
							if (isset($pesan)){
								echo '<span class="badge bg-' .$warna. '">' .$pesan. '</span><br/><br/>';
							}
							?>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="col-md-6">
                            <a href="?page=master&mode=harga_jual">
                                <button class="btn btn-danger">
                                    <i class="fa fa-arrow-left"></i>
                                    Kembali</button>
                            </a><br/><br/>
                        </div>
                        <div class="col md-6 text-right">
                            <a class="btn btn-primary" data-toggle="modal" data-target="#myAHJTModal">
                                <i class="fa fa-plus"></i>
                                Tambah Harga Jual Tunai</a>
                        </div>

                        <div class="table_wrap">
                            <table id="table1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>No.</th>
                                        <th>Nama Barang</th>
                                        <th>Nama Supplier</th>
                                        <th>Harga Jual Tunai</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
$sql=mysqli_query($con, "SELECT
    harga_jual.id_harga_jual
    , harga_jual.harga_jual
    , supplier.nama_supplier
	, pelanggan.id_pelanggan
    , barang.nama_barang
	, barang_supplier.id_barang_supplier
FROM
    harga_jual
    INNER JOIN barang_supplier 
        ON (harga_jual.id_barang_supplier = barang_supplier.id_barang_supplier)
    INNER JOIN pelanggan 
        ON (harga_jual.id_pelanggan = pelanggan.id_pelanggan)
    INNER JOIN supplier 
        ON (barang_supplier.id_supplier = supplier.id_supplier)
    INNER JOIN barang 
        ON (barang_supplier.id_barang = barang.id_barang)
WHERE 
	harga_jual.id_pelanggan=$id");
$i=0;
while($row=mysqli_fetch_array($sql)){
$i+=1;
	echo '			<tr>
						<td>
							<div class="btn-group">
								<button data-toggle="dropdown" class="btn btn-primary dropdown-toggle btn-xs" type="button" aria-expanded="false"><span class="caret"></span></button>
								<ul role="menu" class="dropdown-menu">
								  <li><a href="?page=harga_jual&mode=riwayat_hjt&back=' .$row['id_pelanggan']. '&id=' .$row['id_barang_supplier']. '">Lihat Riwayat Harga Jual Tunai</a></li>
								  <li class="separator"></li>
								  <li><a href="?page=harga_jual&mode=view_hjk&id=' .$row['id_harga_jual']. '">Lihat Harga Jual Kredit</a></li>
								  <li><a href="?page=harga_jual&mode=riwayat_hjk&id=' .$row['id_barang_supplier']. '">Lihat Riwayat Harga Jual Kredit</a></li>
								</ul>
							</div>
						</td>
						<td><div style="min-width:50px">' .$i. '</div></td>
						<td><div style="min-width:50px">' .$row['nama_barang']. '</div></td>
						<td><div style="min-width:50px">' .$row['nama_supplier']. '</div></td>
						<td><div style="min-width:50px" class="uang">' .$row['harga_jual']. '</div></td>
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
    </div>
    <!-- /page content -->

</div>
</div>

<!-- modal input -->
<div id="myAHJTModal" class="modal fade">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Tambah Data Harga Jual Tunai</h4>
        </div>
        <div class="modal-body">
            <form action="" method="post">
                <input type="hidden" name="tambah_harga_jual_tunai_post" value="true">
                <div class="col-md-12">
                    <div class="input-group">
                        <span class="input-group-addon" style="padding: 2px 12px;">
                            <i class="fa fa-bookmark fa-fw"></i><br>
                            <small>Barang</small>
                        </span>
                        <select
                            class="select2 form-control"
                            id="select_barang"
                            name="id_barang_supplier"
                            required="required">
                            <option value="" disabled="disabled" selected="selected">Pilih Barang & Supplier</option>
                            <?php 
$brg=mysqli_query($con, "SELECT
    barang.nama_barang
    , supplier.nama_supplier
    , barang_supplier.id_barang_supplier
FROM
    barang_supplier
    INNER JOIN barang 
        ON (barang_supplier.id_barang = barang.id_barang)
    INNER JOIN supplier 
        ON (barang_supplier.id_supplier = supplier.id_supplier)
WHERE
	id_barang_supplier NOT IN (SELECT id_barang_supplier FROM harga_jual)");
		while($b=mysqli_fetch_array($brg)){
?>
                            <option value="<?php echo $b['id_barang_supplier']; ?>"><?php echo $b['nama_barang']. ' - ' .$b['nama_supplier'];?></option>
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
                            <i class="fa fa-money fa-fw" style="width: 39px;"></i><br>
                            <small>Harga</small>
                        </span>
                        <input
                            id="harga_jual"
                            type="text"
                            name="harga_jual"
                            style="padding: 20px 15px;"
                            class="form-control"
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

<script>
$(document).ready(function () {
    $('#harga_jual').inputmask('currency', {
        prefix: "Rp ",
        allowMinus: false,
        autoGroup: true,
        groupSeparator: '.',
        rightAlign: false,
        autoUnmask: true,
        removeMaskOnSubmit: true
    });
    $('.uang').inputmask('currency', {
        prefix: "Rp ",
        autoGroup: true,
        allowMinus: false,
        groupSeparator: '.',
        rightAlign: false,
        autoUnmask: true,
        removeMaskOnSubmit: true
    });
})
</script>