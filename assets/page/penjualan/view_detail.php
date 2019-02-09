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
                        <a href="<?php echo $url ?>">
                            <button style="margin-bottom:10px" class="btn btn-danger">
                                <i class="fa fa-arrow-left"></i>
                                Kembali</button>
                        </a>

                        <form action="" method="post">
                            <input type="hidden" name="edit_penjualan_post" value="true">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar fa-fw" style="width: 94px;"></i>
                                        <small><br>Tgl Nota Jual</small>
                                    </span>
                                    <input
                                        class="form-control"
																				style="padding: 20px 10px;"
                                        id="tgl_nota"
                                        name="tgl_nota"
                                        title="Tgl Nota Jual"
                                        value="<?php echo date("d-m-Y",strtotime($row['tgl_nota'])); ?>"
                                        readonly="readonly">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-file fa-fw" style="width: 94px;"></i>
                                        <small><br>No Nota Jual</small>
                                    </span>
                                    <input
                                        id="invoice"
                                        name="invoice"
																				style="padding: 20px 10px;"
                                        class="form-control"
                                        placeholder="No Nota Jual"
                                        title="No Nota Jual"
                                        value="<?php echo $row['invoice']; ?>"
                                        readonly="readonly">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-building fa-fw" style="width: 94px;"></i>
                                        <small><br>Pelanggan</small>
                                    </span>
                                    <input
                                        name="pelanggan"
                                        class="form-control"
                                        placeholder="Pelanggan"
                                        title="Pelanggan"
																				style="padding: 20px 10px;"
                                        value="<?php echo $row['nama_pelanggan']; ?>"
                                        readonly="readonly">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-user fa-fw" style="width: 94px;"></i>
                                        <small><br>Sales</small>
                                    </span>
                                    <input
                                        name="sales"
                                        class="form-control"
                                        placeholder="Sales"
																				style="padding: 20px 10px;"
                                        title="Sales"
                                        value="<?php echo $row['nama_karyawan']; ?>"
                                        readonly="readonly">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-dollar fa-fw" style="width: 94px;"></i>
                                        <small><br>Jenis Bayar</small>
                                    </span>
                                    <input
                                        id="jenis_bayar"
                                        name="jenis_bayar"
                                        class="form-control"
																				style="padding: 20px 10px;"
                                        placeholder="Jenis Bayar"
                                        title="Jenis Bayar"
                                        value="<?php echo $row['jenis_bayar']; ?>"
                                        readonly="readonly">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-tags fa-fw" style="width: 94px;"></i>
                                        <small><br>Tenor</small>
                                    </span>
                                    <input
                                        id="tenor"
                                        name="tenor"
                                        class="form-control"
                                        placeholder="TENOR"
																				style="padding: 20px 10px;"
                                        title="TENOR"
                                        value="<?php echo $row['tenor']; ?> hari"
                                        readonly="readonly">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-tags fa-fw" style="width: 94px;"></i>
                                        <small style="font-size: 11px;"><br>Tot. Jual Sementara</small>
                                    </span>
                                    <input
                                        id="total_jual"
                                        class="form-control"
                                        placeholder="Total Jual Sementara"
                                        title="Total Jual Sementara"
                                        value=""
																				style="padding: 20px 10px;"
                                        readonly="readonly">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-hashtag fa-fw" style="width: 94px;"></i>
                                        <small><br>Tgl Jatuh Tempo</small>
                                    </span>
                                    <input
                                        id="tgl_jatuh_tempo"
                                        class="form-control"
                                        placeholder="Tanggal Jatuh Tempo"
                                        title="Tanggal Jatuh Tempo"
																				style="padding: 20px 10px;"
                                        value="<?php echo $tgl_jt_tempo; ?>"
                                        readonly="readonly">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-cut fa-fw" style="width: 94px;"></i>
                                        <small style="font-size: 11px;"><br>Disc. Nota Jual</small>
                                    </span>
                                    <input
                                        id="diskon_nota"
                                        class="form-control"
                                        placeholder="Diskon Nota Jual"
                                        title="Diskon Nota Jual"
																				style="padding: 20px 10px;"
                                        value=""
                                        readonly="readonly">
                                    <span class="input-group-btn">
                                        <a data-toggle="modal" data-target="#myModal" class="btn btn-primary" style="padding: 10px 12px;">Edit</a>
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

                        <table
                            id="table1"
                            class="table table-bordered table-striped"
                            style="min-width: 1500px;">
                            <thead>
                                <tr>
                                    <th>Barcode</th>
                                    <th>Nama Barang</th>
                                    <th>Qty Jual</th>
                                    <th>Harga Jual</th>
                                    <th>Tot. Seb. Diskon</th>
                                    <th>Disc 1</th>
                                    <th>Tot. set. disc 1</th>
                                    <th>Disc 2</th>
                                    <th>Tot. set. disc 2</th>
                                    <th>Disc 3</th>
                                    <th>Tot. set. disc 3</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
$sql=mysqli_query($con, "SELECT
    barang.nama_barang
    , barang.barcode
    , satuan.nama_satuan
		, jual.ppn_all_persen
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
		jual
		INNER JOIN jual_detail
				ON (jual.id_jual = jual_detail.id_jual)
    INNER JOIN harga_jual
        ON (jual_detail.id_harga_jual = harga_jual.id_harga_jual)
    , barang_supplier
	INNER JOIN barang
        ON (barang_supplier.id_barang = barang.id_barang)
    INNER JOIN satuan
        ON (barang.id_satuan = satuan.id_satuan) WHERE (harga_jual.id_barang_supplier = barang_supplier.id_barang_supplier) AND jual_detail.id_jual='$id'");
$total_jual=0;
while($row=mysqli_fetch_array($sql)){
	$diskon1=$row['qty']*$row['harga_jual']*$row['diskon_persen']/100;
	$tot_set_disk_1=($row['harga_jual']-$diskon1);
	$diskon2=$row['qty']*($row['harga_jual']-$diskon1)*$row['diskon_persen_2']/100;
	$tot_set_disk_2=($row['harga_jual']-$diskon1-$diskon2);
	$diskon3=$row['qty']*($row['harga_jual']-$diskon1-$diskon2)*$row['diskon_persen_3']/100;
	$tot_set_disk_3=($row['harga_jual']-$diskon1-$diskon2-$diskon3);
	$total_jual+=$tot_set_disk_3;
	if($tot_set_disk_1 < -1 OR $tot_set_disk_2 < -1 OR $tot_set_disk_3 < 0) {
		$val = "color: red;";
	}else{
		$val = "color: black;";
	}
	echo '			<tr>
						<td style="'.$val.'">' .$row['barcode']. '</td>
						<td style="'.$val.'">' .$row['nama_barang']. '</td>
						<td style="'.$val.'">' .$row['qty']. ' ' .$row['nama_satuan']. '</td>
						<td style="'.$val.'" class="uang">' .$row['harga_jual']. '</td>
						<td style="'.$val.'" class="uang">' .$row['qty']*$row['harga_jual']. '</td>
						<td style="'.$val.'" class="uang">' .$diskon1. '</td>
						<td style="'.$val.'" class="uang">' .$tot_set_disk_1. '</td>
						<td style="'.$val.'" class="uang">' .$diskon2. '</td>
						<td style="'.$val.'" class="uang">' .$tot_set_disk_2. '</td>
						<td style="'.$val.'" class="uang">' .$diskon3. '</td>
						<td style="'.$val.'" class="uang">' .$tot_set_disk_3. '</td>
					</tr>';
}
$diskon_all_rp=$diskon_nota*$total_jual;
$ppn_all = $diskon_all_rp*($row['ppn_all_persen']/100);
$total_all_rp = ($total_jual-$diskon_all_rp)+$ppn_all;
?>

                            </tbody>
                        </table>
                        <div class="col-md-12" style="margin-top: 50px; padding-left: 0px;">
                            <!--<div class="col-md-6"> </div> -->
                            <div class="col-md-6 text-right" style="padding-left: 0px;">
                                <div class="input-group">
																		<span
																				class="input-group-addon"
																				style="width:200px;text-align:left;color:#000;background: #fff; outline: none; border: none;">
																				<small>Tot. Set. Disc.</small>
																		</span>
																		<input
																				class="form-control"
																				id="total_jual_2"
																				name="totaljual"
																				style="background: #fff; outline: none; border: none;"
																				value="<?php echo $total_jual ?>"
																				readonly="readonly">
																</div>
																<div class="input-group">
																		<span
																				class="input-group-addon"
																				style="width:200px;text-align:left;color:#000;background: #fff; outline: none; border: none;">
																				<small>PPN</small>
																		</span>
																		<input
																				class="form-control uang"
																				id="ppn"
																				name="total"
																				style="background: #fff; outline: none; border: none;"
																				value="<?php echo $ppn_all ?>"
																				readonly="readonly">
																</div>
																<div class="input-group">
																		<span
																				class="input-group-addon"
																				style="width:200px;text-align:left;color:#000;background: #fff; outline: none; border: none;">
																				<small>Tot. N.Jual Set. Disc & PPN</small>
																		</span>
																		<input
																				class="form-control uang"
																				id="total_2"
																				style="background: #fff; outline: none; border: none;"
																				name="total"
																				value="<?php echo $total_all_rp ?>"
																				readonly="readonly">
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
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <div style="min-width:50px">&times;</div>
                </button>
                <h4 class="modal-title">Ubah Data Diskon Nota Jual</h4>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <input type="hidden" name="edit_diskon_nota_jual" value="true">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-cut fa-fw" style="width: 52px;"></i><br>
                            <small>Diskon</small>
                        </span>
                        <input
                            type="text"
                            id="diskon_nota_persen"
                            max="100"
                            min="0"
                            name="diskon_all_persen"
                            style="padding: 20px 15px;"
                            class="form-control"
                            placeholder="Diskon Nota Jual (%)"
                            title="Diskon Nota Jual (%)"
                            value="<?php echo $diskon_nota*100 ?>">
                        <span class="input-group-addon">%</span>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            Nominal
                        </span>
                        <input
                            id="diskon_nota_rp"
                            class="form-control"
                            placeholder="Diskon Nota Jual (Rp)"
                            title="Diskon Nota Jual (Rp)"
                            value="<?php echo $diskon_all_rp ?>"
                            readonly="readonly">
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
        $('.uang').inputmask('currency', {
            prefix: "Rp ",
            autoGroup: true,
            allowMinus: false,
            groupSeparator: '.',
            rightAlign: false,
            autoUnmask: true,
            removeMaskOnSubmit: true
        });
        $('#total_jual').inputmask('currency', {
            prefix: "Rp ",
            allowMinus: false,
            autoGroup: true,
            groupSeparator: '.',
            rightAlign: false,
            removeMaskOnSubmit: true
        });
        $('#total_jual_2').inputmask('currency', {
            prefix: "Rp ",
            allowMinus: false,
            autoGroup: true,
            groupSeparator: '.',
            rightAlign: false,
            removeMaskOnSubmit: true
        });
        $('#diskon_nota').inputmask('currency', {
            prefix: "Rp ",
            allowMinus: false,
            autoGroup: true,
            groupSeparator: '.',
            rightAlign: false,
            removeMaskOnSubmit: true
        });
        $('#diskon_nota_rp').inputmask('currency', {
            prefix: "Rp ",
            allowMinus: false,
            autoGroup: true,
            groupSeparator: '.',
            rightAlign: false,
            removeMaskOnSubmit: true
        });
        $('#diskon_nota_persen').inputmask('currency', {
            prefix: "",
            allowMinus: false,
            autoGroup: true,
            groupSeparator: '.',
            rightAlign: false,
            removeMaskOnSubmit: true
        });
        $('#total_jual').val(<?php echo $total_jual ?>);
        $('#diskon_nota').val(<?php echo $diskon_nota*$total_jual ?>);
        $('#myModal').on('show.bs.modal', function (e) {
            $('#diskon_nota_persen').val(<?php echo $diskon_nota*100 ?>);
            rp = Number($('#diskon_nota_persen').val() / 100 * <?php echo $total_jual ?>);
            $('#diskon_nota_rp').val(rp);
        });
        $('#diskon_nota_persen').on('input', function () {
            rp = Number($('#diskon_nota_persen').val() / 100 * <?php echo $total_jual ?>);
            $('#diskon_nota_rp').val(rp);
        });
    });
</script>
