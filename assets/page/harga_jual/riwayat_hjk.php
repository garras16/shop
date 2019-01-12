<?php
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
		barang_supplier.id_barang_supplier=$id");
	$row=mysqli_fetch_array($sql);
	$id_pelanggan=$row['id_pelanggan'];
?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h3>RIWAYAT HARGA JUAL KREDIT</h3>
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
                                <i class="fa fa-archive fa-fw" style="width: 55px;"></i><br>
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
                                <i class="fa fa-building fa-fw" style="width: 55px;"></i><br>
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
                                    <th>Harga Jual Kredit (Rp)</th>
                                    <th>Jangka Waktu Maks (Hari)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
								$sql=mysqli_query($con, "SELECT tanggal, harga_kredit, hari 
								FROM 
									hj_kredit_detail
								    INNER JOIN harga_jual 
								        ON (hj_kredit_detail.id_harga_jual = harga_jual.id_harga_jual)
								WHERE harga_jual.id_barang_supplier=$id");

								while($row=mysqli_fetch_array($sql)){
									echo '			<tr>
														<td align="center">' .date("d-m-Y", strtotime($row['tanggal'])). '</a></td>
														<td align="right">' .format_uang($row['harga_kredit']). '</a></td>
														<td align="center">' .format_angka($row['hari']). '</a></td>
													</tr>';
								}
								?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /page content -->
    </div>
</div>