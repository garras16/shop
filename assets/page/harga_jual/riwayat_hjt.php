<?php
	$id_pelanggan=$_GET['back'];
	if (isset($tambah_harga_jual_tunai_post)){
		$tgl = date("Y-m-d");
		$sql = mysqli_query($con, "UPDATE harga_jual SET harga_jual=$harga_jual WHERE id_barang_supplier=$id AND id_pelanggan=$id_pelanggan");
		$sql = mysqli_query($con, "INSERT INTO hj_tunai_detail VALUES(null,$id,$id_pelanggan,'$tgl',$harga_jual)");
	}

	$sql=mysqli_query($con, "SELECT
	    barang.nama_barang
		, pelanggan.id_pelanggan
	    , pelanggan.nama_pelanggan
	    , supplier.nama_supplier
	FROM
	    hj_tunai_detail
	    INNER JOIN barang_supplier 
	        ON (hj_tunai_detail.id_barang_supplier = barang_supplier.id_barang_supplier)
	    INNER JOIN pelanggan 
	        ON (hj_tunai_detail.id_pelanggan = pelanggan.id_pelanggan)
	    INNER JOIN barang 
	        ON (barang_supplier.id_barang = barang.id_barang)
	    INNER JOIN supplier 
	        ON (barang_supplier.id_supplier = supplier.id_supplier)
	WHERE
		barang_supplier.id_barang_supplier=$id AND pelanggan.id_pelanggan=$id_pelanggan");
	$row=mysqli_fetch_array($sql);
	?>

<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h3>RIWAYAT HARGA JUAL TUNAI</h3>
                        <?php
								if (isset($pesan)){
									echo '<span class="badge bg-' .$warna. '">' .$pesan. '</span>';
								}
							?>
                        <div class="clearfix"></div>
                    </div>

                    <div class="x_content">
                        <a
                            class="btn btn-danger"
                            href="?page=harga_jual&mode=view_detail&id=<?php echo $id_pelanggan ?>">
                            <i class="fa fa-arrow-left"></i>
                            Kembali</a>
                        <div class="clearfix"></div><br/>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-user fa-fw"></i><br>
                                <small>Pelanggan</small>
                            </span>
                            <input
                                class="form-control"
                                style="padding: 20px 15px;"
                                value="<?php echo $row['nama_pelanggan'] ?>"
                                readonly="readonly">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-archive fa-fw" style="width: 56px;"></i><br>
                                <small>Barang</small>
                            </span>
                            <input
                                class="form-control"
                                style="color:black"
                                value="<?php echo $row['nama_barang'] ?>"
                                readonly="readonly">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-building fa-fw" style="width: 56px;"></i><br>
                                <small>Supplier</small>
                            </span>
                            <input
                                class="form-control"
                                style="padding: 20px 15px;"
                                value="<?php echo $row['nama_supplier'] ?>"
                                readonly="readonly">
                        </div>
                        <div class="clearfix"></div><br/>

                        <table id="table1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Tanggal Mulai Berlaku</th>
                                    <th>Harga Jual Tunai (Rp)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
									$sql=mysqli_query($con, "SELECT tanggal, harga_jual FROM hj_tunai_detail WHERE id_barang_supplier=$id AND id_pelanggan=$id_pelanggan");

									while($row=mysqli_fetch_array($sql)){
										echo '<tr>
												<td>' .date("d-m-Y", strtotime($row['tanggal'])). '</a></td>
												<td align="right" class="uang">' .$row['harga_jual']. '</a></td>
											</tr>';
									}
									?>

                            </tbody>
                        </table>
                        <form method="post">
                            <input type="hidden" name="tambah_harga_jual_tunai_post" value="true">
                            <div class="input-group">
                                <input
                                    type="tel"
                                    id="harga_jual"
                                    name="harga_jual"
                                    class="form-control"
                                    placeholder="Harga Jual Tunai (Rp)"
                                    required="required">
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-save"></i>
                                        Simpan</button>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /page content -->

    </div>
</div>

<script>
    $(document).ready(function () {
        $('.uang').inputmask('currency', {
            prefix: "Rp ",
            autoGroup: true,
            allowMinus: false,
            groupSeparator: '.',
            rightAlign: false,
            autoUnmask: true,
            removeMaskOnSubmit: true
        });
        $('#harga_jual').inputmask('currency', {
            prefix: "Rp ",
            allowMinus: false,
            autoGroup: true,
            groupSeparator: '.',
            rightAlign: false,
            autoUnmask: true,
            removeMaskOnSubmit: true
        });
    })
</script>