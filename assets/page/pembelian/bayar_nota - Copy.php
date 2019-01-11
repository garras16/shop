<?php
if (isset($tambah_bayar_nota_beli_post)){
	_direct("?page=pembelian&mode=bayar_nota_2&no_nota_beli=$no_nota_beli&jenis=$jenis");
}
if (isset($_GET['del'])){
	$del=$_GET['del'];
	$sql=mysqli_query($con, "SELECT * FROM bayar_nota_beli WHERE id_bayar=$del");
	$row=mysqli_fetch_array($sql);
	$no_nota_beli=$row['no_nota_beli'];
	$tgl=$row['tgl_bayar'];
	$sql=mysqli_query($con, "SELECT * FROM bayar_nota_beli WHERE no_nota_beli='$no_nota_beli' AND tgl_bayar='$tgl'");
	while ($row=mysqli_fetch_array($sql)){
		$id_bayar[]=$row['id_bayar'];
	}
	for ($i=0;$i<count($id_bayar);$i++){
		$sql=mysqli_query($con, "DELETE FROM bayar_nota_beli_detail WHERE id_bayar=$id_bayar[$i]");
		$sql=mysqli_query($con, "DELETE FROM bayar_nota_beli WHERE id_bayar=$id_bayar[$i] AND tgl_bayar='$tgl'");
	}
	_direct("?page=pembelian&mode=bayar_nota");
}
?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h3>PEMBAYARAN NOTA BELI</h3>
                        <?php
							if (isset($pesan)){
								echo '<span class="badge bg-' .$warna. '">' .$pesan. '</span>';
							}
						?>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                        <p align="right">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                <i class="fa fa-plus"></i>
                                Tambah</button>
                        </p>
                        <div class="clearfix"></div>
                        <table id="table1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Tgl. Bayar</th>
                                    <th>No Nota Beli</th>
                                    <th>Nama Supplier</th>
                                    <th>Jenis</th>
                                    <th>Jumlah Terbayar (Rp)</th>
                                    <th>Sisa Nota (Rp)</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
$sql=mysqli_query($con, "SELECT
    bayar_nota_beli.id_bayar
    , bayar_nota_beli.tgl_bayar
    , bayar_nota_beli.no_nota_beli
    , bayar_nota_beli.jenis
    , bayar_nota_beli.jumlah
    , bayar_nota_beli.status
    , supplier.nama_supplier
FROM
    bayar_nota_beli
    INNER JOIN beli 
        ON (bayar_nota_beli.no_nota_beli = beli.no_nota_beli)
    INNER JOIN supplier 
        ON (beli.id_supplier = supplier.id_supplier)");
while($row=mysqli_fetch_array($sql)){
if ($row['status']=='1'){
	$status="LUNAS";
} else if ($row['status']=='1'){
	$status="LUNAS SEBAGIAN";
} else {
	$status="";
}
	echo '			<tr>
						<td align="center">' .date("d-m-Y", strtotime($row['tgl_bayar'])). '</td>
						<td align="center">' .$row['no_nota_beli']. '</td>
						<td align="center">' .$row['nama_supplier']. '</td>
						<td align="center">' .$row['jenis']. '</td>
						<td align="right">' .format_uang($row['jumlah']). '</td>
						<td align="right"></td>
						<td align="center">' .$status. '</td>
						<td align="center"><a href="?page=pembelian&mode=bayar_nota&del=' .$row['id_bayar']. '" class="btn btn-primary btn-xs"><i class="fa fa-trash"></i></a></td>
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

<!-- modal input -->
<div id="myModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <div style="min-width:50px">&times;</div>
                </button>
                <h4 class="modal-title">Tambah Pembayaran Nota Beli</h4>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <input type="hidden" name="tambah_bayar_nota_beli_post" value="true">
                    <input type="hidden" id="jumlah_bayar" name="jumlah_bayar" value="">
                    <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-file fa-fw"></i>
                            </span>
                            <select
                                id="select_nota"
                                name="no_nota_beli"
                                class="select2 form-control"
                                required="true">
                                <option value="" disabled="disabled" selected="selected">-= Pilih Nota Beli =-</option>
                                <?php 
								$sql=mysqli_query($con, "SELECT 
	beli.id_beli
    , beli.no_nota_beli
    , supplier.nama_supplier
FROM
    beli
	INNER JOIN supplier 
        ON (beli.id_supplier = supplier.id_supplier)
WHERE no_nota_beli NOT IN (SELECT no_nota_beli FROM bayar_nota_beli)
ORDER BY id_beli ASC");
								while($b=mysqli_fetch_array($sql)){
									$tmp_id_beli=$b['id_beli'];
									$sql2=mysqli_query($con, "SELECT SUM(harga*barang_masuk_rak.qty_di_rak) AS jumlah
										FROM
											barang_masuk
											INNER JOIN beli_detail 
												ON (barang_masuk.id_beli_detail = beli_detail.id_beli_detail)
											INNER JOIN barang_masuk_rak 
												ON (barang_masuk_rak.id_barang_masuk = barang_masuk.id_barang_masuk)
									     WHERE id_beli=$tmp_id_beli");
									$b2=mysqli_fetch_array($sql2);
									if ($b2['jumlah']!=''){
										echo '<option data-jumlah="' .$b2['jumlah']. '" value="' .$b['no_nota_beli']. '">' .$b['no_nota_beli']. ' | ' .$b['nama_supplier']. ' | Rp ' .format_uang($b2['jumlah']). '</option>';
									}
								}
							?>
                            </select>
                            <span class="input-group-addon">
                                <i class="fa fa-star fa-fw" style="color:red"></i>
                            </span>
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-money fa-fw"></i>
                            </span>
                            <select id="jenis" name="jenis" class="select2 form-control" required="true">
                                <option value="" disabled="disabled" selected="selected">-= Pilih Jenis Bayar =-</option>
                                <option value="Transfer">Transfer</option>
                                <option value="Tunai">Tunai</option>
                                <option value="Retur">Retur</option>
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

<script>
    $(document).ready(function () {
        $('#select_nota').on('change', function () {
            var jumlah = $(this)
                .find(":selected")
                .data('jumlah');
            if ($('#jenis').val() != 'Retur') {
                $('#jumlah_bayar').val(jumlah);
            }
        });
    })
</script>