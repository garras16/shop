<?php
if (isset($tambah_bayar_nota_beli_post)){
	_direct("?page=pembelian&mode=bayar_nota_2&no_nota_beli=$no_nota_beli&jenis=$jenis");
}
if (isset($_GET['del'])){
	$del=$_GET['del'];
	$sql=mysqli_query($con, "SELECT * FROM bayar_nota_beli WHERE id_bayar=$del");
	$row=mysqli_fetch_array($sql);
	$no_nota_beli=$row['no_nota_beli'];
	$sql=mysqli_query($con, "DELETE FROM bayar_nota_beli_detail WHERE id_bayar=$del");
	$sql=mysqli_query($con, "DELETE FROM bayar_nota_beli WHERE id_bayar=$del");
	$sql=mysqli_query($con, "UPDATE bayar_nota_beli SET status=2 WHERE no_nota_beli='$no_nota_beli'");
/*	$del=$_GET['del'];
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
	}*/
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
								echo '<span class="badge bg-' .$warna. '">' .$pesan. '</span><br/><br/>';
							}
						?>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="clearfix"></div>
                        <div
                            class="col-xs-12"
                            style="background:gray; padding-top:10px;padding-bottom:10px">
                            <font color="white">Cari Tanggal Bayar :</font><br/>
                            <input
                                style="width:100px"
                                id="tgl_dari"
                                type="text"
                                value=""
                                placeholder="Tanggal"
                                readonly="readonly">
                            <font color="white">
                                -
                            </font><input
                                style="width:100px"
                                id="tgl_sampai"
                                type="text"
                                value=""
                                placeholder="Tanggal"
                                readonly="readonly">&nbsp;<a class="btn btn-primary btn-xs" id="btn_dari_sampai" onclick="submit();">
                                <i class="fa fa-search"></i>
                            </a>
                        </div>
                        <div class="clearfix" style="margin-bottom: 20px;"></div><br/>
                        <div class="col-md-12">
                            <p align="right">
                                <button class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                    <i class="fa fa-plus"></i>
                                    Tambah</button>
                            </p>
                        </div>
                        <table
                            id="table1"
                            class="table table-bordered table-striped"
                            style="width: 1500px;">
                            <thead>
                                <tr>
                                    <th>Tgl. Nota Beli</th>
                                    <th>No Nota Beli</th>
                                    <th>Nama Supplier</th>
                                    <th>Jenis</th>
                                    <th>Tgl. Bayar Terakhir</th>
                                    <th>Jumlah Bayar Per Tgl</th>
                                    <th>Sisa Nota</th>
                                    <th>Status</th>
																		<th>Status Giro</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
if (isset($_GET['dari'])){
	$dari=date("Y-m-d", strtotime($_GET['dari']));
	$sampai=date("Y-m-d", strtotime($_GET['sampai']));
	$val="WHERE (tgl_bayar BETWEEN '$dari' AND '$sampai')";
} else {
	$val="WHERE tgl_bayar > DATE_SUB(now(), INTERVAL 12 MONTH)";
}
$sql=mysqli_query($con, "SELECT
    bayar_nota_beli.id_bayar
		, bayar_nota_beli.status_giro
		, bayar_nota_beli.sisa
    , bayar_nota_beli.tgl_bayar
    , bayar_nota_beli.no_nota_beli
    , bayar_nota_beli.jenis
	, bayar_nota_beli.jumlah
    , bayar_nota_beli.status
    , supplier.nama_supplier
	, beli.id_beli
	, beli.tanggal
	, beli.diskon_all_persen
	, beli.ppn_all_persen
FROM
    bayar_nota_beli
    INNER JOIN beli
        ON (bayar_nota_beli.no_nota_beli = beli.no_nota_beli)
    INNER JOIN supplier
        ON (beli.id_supplier = supplier.id_supplier)
$val
ORDER BY id_bayar DESC");
while($row=mysqli_fetch_array($sql)){
	$tmp_id_beli=$row['id_beli'];
	$sql2=mysqli_query($con, "SELECT SUM((harga-diskon_rp-diskon_rp_2-diskon_rp_3)*qty) AS jumlah_nota
		FROM
			beli_detail
		WHERE id_beli=$tmp_id_beli");
	$b2=mysqli_fetch_array($sql2);

	$sqll = mysqli_query($con, "SELECT ppn_all_persen FROM beli WHERE id_beli=$tmp_id_beli");
	$bb = mysqli_fetch_array($sqll);
	$set_dis=$b2['jumlah_nota']-($b2['jumlah_nota']*$row['diskon_all_persen']/100);
	$ppn = $set_dis*($bb['ppn_all_persen']/100);
	$jumlah_nota = $set_dis+$ppn;

//-----------------------------------------------------------------------------------------
	$tmp_nota_beli=$row['no_nota_beli'];
	$sql3=mysqli_query($con, "SELECT SUM(jumlah) AS jumlah_bayar FROM bayar_nota_beli WHERE no_nota_beli='$tmp_nota_beli'");
	$b3=mysqli_fetch_array($sql3);
	$jumlah_bayar=$b3['jumlah_bayar'];
//-------------------------------------------------------------------------------------------
$sisa_nota=$jumlah_nota-$jumlah_bayar;
if($row['jenis'] == "Giro" && $row['status_giro'] == 1) {
	$nilai = "DITERIMA";
}else if($row['jenis'] == "Giro" && $row['status_giro'] == 2) {
	$nilai = "DITOLAK";
}else if($row['jenis'] == "Giro" && $row['status_giro'] == 0) {
	$nilai = "BELUM DICAIRKAN";
}else{
	$nilai = "-";
}
if ($row['status']=='1'){
	$status="LUNAS";
} else if ($row['status']=='2'){
	$status="TERBAYAR SEBAGIAN";
} else {
	$status="";
}
	echo '<tr>
			<td align="center" style="width: 150px;">' .date("d-m-Y", strtotime($row['tanggal'])). '</td>
            <td align="center" style="width: 160px;">' .$row['no_nota_beli']. '</td>
            <td align="center" style="width: 200px;">' .$row['nama_supplier']. '</td>
            <td align="center" style="width: 100px;">' .$row['jenis']. '</td>
            <td align="center" style="width: 170px;">' .date("d-m-Y", strtotime($row['tgl_bayar'])). '</td>
            <td align="right" style="width: 190px;" class="uang">' .$row['jumlah']. '</td>
            <td align="right" style="width: 190px;" class="uang">' .$row['sisa']. '</td>
            <td align="center" style="width: 150px;">' .$status. '</td>
						<td align="center" style="width: 150px;">' .$nilai. '</td>
            <td align="center" style="width: 20px;"><a href="?page=pembelian&mode=bayar_nota&del=' .$row['id_bayar']. '" class="btn btn-primary btn-xs"><i class="fa fa-trash"></i></a></td>
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
                            <span class="input-group-addon" style="padding: 2px 12px;">
                                <i class="fa fa-file fa-fw" style="width: 58px;"></i><br>
                                <small>Nota Beli</small>
                            </span>
                            <select
                                id="select_nota"
                                name="no_nota_beli"
                                class="select2 form-control"
                                required="true">
                                <option value="" disabled="disabled" selected="selected">-= No Nota Beli | Nama Supplier | Jumlah Nota (Rp) =-</option>
                                <?php
								$sql=mysqli_query($con, "SELECT
    beli.id_beli
    , beli.no_nota_beli
    , beli.diskon_all_persen
    , beli.ppn_all_persen
    , nama_supplier
FROM
    bayar_nota_beli
    RIGHT JOIN beli
        ON (bayar_nota_beli.no_nota_beli = beli.no_nota_beli)
    INNER JOIN supplier
        ON (beli.id_supplier = supplier.id_supplier)
	INNER JOIN beli_detail
        ON (beli_detail.id_beli = beli.id_beli)
    INNER JOIN barang_masuk
        ON (barang_masuk.id_beli_detail = beli_detail.id_beli_detail)
WHERE bayar_nota_beli.status IS NULL OR bayar_nota_beli.status=2 OR bayar_nota_beli.status=0
GROUP BY beli.id_beli");
								while($b=mysqli_fetch_array($sql)){
									$tmp_id_beli=$b['id_beli'];
									$sql2=mysqli_query($con, "SELECT SUM((harga*qty)-diskon_rp-diskon_rp_2-diskon_rp_3) AS jumlah FROM beli_detail  WHERE id_beli=$tmp_id_beli");
									$b2=mysqli_fetch_array($sql2);
									$sqll = mysqli_query($con, "SELECT diskon_all_persen, ppn_all_persen FROM beli WHERE id_beli=$tmp_id_beli");
									$bb = mysqli_fetch_array($sqll);
									$set_dis=$b2['jumlah']-($b2['jumlah']*$bb['diskon_all_persen']/100);
									$ppn = $set_dis*($bb['ppn_all_persen']/100);
									$jumlah_nota = $set_dis+$ppn;
									$total= $jumlah_nota;

									if ($total!=''){
										echo '<option data-jumlah="' .$total. '" value="' .$b['no_nota_beli']. '">' .$b['no_nota_beli']. ' | ' .$b['nama_supplier']. ' | Rp ' .format_uang($total). '</option>';
									}
								}
							?>
                            </select>
                            <span class="input-group-addon">
                                <i class="fa fa-star fa-fw" style="color:red"></i>
                            </span>
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon" style="font-size: 12px;">
                                <i class="fa fa-money fa-fw"></i><br>
                                <small>Pembayaran</small>
                            </span>
                            <select id="jenis" name="jenis" class="select2 form-control" required="true">
                                <option value="" disabled="disabled" selected="selected">-= Pilih Jenis Bayar =-</option>
                                <option value="Transfer">Transfer</option>
                                <option value="Tunai">Tunai</option>
                                <option value="Retur">Hanya Retur</option>
                                <option value="Giro">Cek / Giro</option>
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
    function validasi() {
        var startDate = new Date.parse(get_global_tanggal($('#tgl_dari').val()));
        var endDate = new Date.parse(get_global_tanggal($('#tgl_sampai').val()));
        if (startDate > endDate) {
            $('#tgl_dari').val('');
            $('#tgl_sampai').val('');
            $('#btn_dari_sampai').attr('style', 'display:none');
            alert("Terjadi kesalahan penulisan tanggal");
        } else {
            $('#btn_dari_sampai').removeAttr('style');
        }
    }
    function submit() {
        window.location = "?page=pembelian&mode=bayar_nota&dari=" + $('#tgl_dari').val() +
                "&sampai=" + $('#tgl_sampai').val();
    }
    $(document).ready(function () {
        $('#select_nota').on('change', function () {
            var jumlah = $(this)
                .find(":selected")
                .data('jumlah');
            if ($('#jenis').val() != 'Retur') {
                $('#jumlah_bayar').val(jumlah);
            }
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
        $('#tgl_dari').daterangepicker({
            locale: {
                format: 'DD-MM-YYYY'
            },
            singleDatePicker: true
        });
        $('#tgl_sampai').daterangepicker({
            locale: {
                format: 'DD-MM-YYYY'
            },
            singleDatePicker: true
        });
        $("#tgl_dari").on('change', function () {
            validasi();
        });
        $("#tgl_sampai").on('change', function () {
            validasi();
        });
    })
</script>
