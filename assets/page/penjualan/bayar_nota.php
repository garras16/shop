<?php
	if (isset($tambah_bayar_nota_jual_post)) {
		_direct("?page=penjualan&mode=bayar_nota_2&no_nota_jual=$no_nota_jual&jenis=$jenis");
	}

	if (isset($_GET['del'])) {
		$del=$_GET['del'];
		$sql=mysqli_query($con, "SELECT * FROM bayar_nota_jual WHERE id_bayar=$del");
		$row=mysqli_fetch_array($sql);
		$no_nota_beli=$row['no_nota_jual'];
		$sql=mysqli_query($con, "DELETE FROM bayar_nota_jual_detail WHERE id_bayar=$del");
		$sql=mysqli_query($con, "DELETE FROM bayar_nota_jual WHERE id_bayar=$del");
		$sql=mysqli_query($con, "UPDATE bayar_nota_jual SET now=2 WHERE no_nota_jual='$no_nota_beli'");
		_direct("?page=penjualan&mode=bayar_nota");
	}
?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h3>PEMBAYARAN NOTA JUAL</h3>
                        <?php
							if (isset($pesan)){
								echo '<span class="badge bg-' .$warna. '">' .$pesan. '</span><br/><br/>';
							}
						?>
                        <div class="clearfix"></div>
                    </div>
                    <!-- <div class="x_content"> <div class="alert alert-info"> <strong>Klik kolom
                    pada tabel untuk detail.</strong> </div> -->
                    <div class="clearfix"></div>
                    <div
                        class="col-xs-12"
                        style="margin-bottom:30px; background:gray; padding-top:10px;padding-bottom:10px">
                        <font color="white">Cari Tanggal Bayar :
                        </font><br/>
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
                    <div class="col-md-12">
                        <p align="right">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                <i class="fa fa-plus"></i>
                                Tambah</button>
                        </p>
                    </div>
                    <div class="clearfix"></div><br/>
                    <div class="table-responsive">
                        <table
                            id="table1"
                            class="table table-bordered table-striped"
                            style="width: 1600px;">
                            <thead>
                                <tr>
                                    <th>Tgl. Nota Jual</th>
                                    <th>No Nota Jual</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Jenis</th>
                                    <th>Tgl. Bayar Terakhir</th>
                                    <th>Jumlah Bayar Per Tgl</th>
                                    <th>Sisa Piutang Nota</th>
                                    <th>Status</th>
									<th>Stat. Giro</th>
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
	$val="WHERE tgl_bayar > DATE_SUB(now(), INTERVAL 6 MONTH)";
}
$sql=mysqli_query($con, "SELECT
    bayar_nota_jual.id_bayar
		, bayar_nota_jual.sisa
    , bayar_nota_jual.tgl_bayar
    , bayar_nota_jual.no_nota_jual
    , bayar_nota_jual.jenis
	, bayar_nota_jual.status_giro
	, bayar_nota_jual.jumlah
    , bayar_nota_jual.status
    , pelanggan.nama_pelanggan
	, jual.id_jual
	, jual.tgl_nota
	, jual.diskon_all_persen
FROM
    bayar_nota_jual
    INNER JOIN jual
        ON (bayar_nota_jual.no_nota_jual = jual.invoice)
    INNER JOIN pelanggan
        ON (jual.id_pelanggan = pelanggan.id_pelanggan)
$val
ORDER BY id_bayar DESC");
while($row=mysqli_fetch_array($sql)){
	$tmp_id_jual=$row['id_jual'];
	$sql2=mysqli_query($con, "SELECT SUM(qty*(harga-diskon_rp-diskon_rp_2-diskon_rp_3)) AS jumlah_nota FROM jual_detail WHERE id_jual=$tmp_id_jual");
	$b2=mysqli_fetch_array($sql2);

	$sqll = mysqli_query($con, "SELECT ppn_all_persen FROM jual WHERE id_jual=$tmp_id_jual");
	$bb = mysqli_fetch_array($sqll);
	$set_dis=$b2['jumlah_nota']-($b2['jumlah_nota']*$row['diskon_all_persen']/100);
	$ppn = $set_dis*($bb['ppn_all_persen']/100);
	$jumlah_nota = $set_dis+$ppn;
//-----------------------------------------------------------------------------------------
	$tmp_nota_jual=$row['no_nota_jual'];
	$sql3=mysqli_query($con, "SELECT SUM(jumlah) AS jumlah_bayar FROM bayar_nota_jual WHERE no_nota_jual='$tmp_nota_jual'");
	$b3=mysqli_fetch_array($sql3);
	$jumlah_bayar=$b3['jumlah_bayar'];

	$sql3=mysqli_query($con, "SELECT SUM(jumlah) AS jumlah_bayar FROM bayar_nota_jual WHERE no_nota_jual='$tmp_nota_jual' AND jenis='Giro' AND status_giro<>1");
	$b3=mysqli_fetch_array($sql3);
	$jumlah_bayar-=$b3['jumlah_bayar'];
//-------------------------------------------------------------------------------------------
	$sql3=mysqli_query($con, "SELECT SUM(bayar) AS jumlah_bayar FROM penagihan_detail WHERE id_jual=$tmp_id_jual");
	$b3=mysqli_fetch_array($sql3);
	$jumlah_bayar+=$b3['jumlah_bayar'];

	$sql3=mysqli_query($con, "SELECT SUM(bayar) AS jumlah_bayar FROM penagihan_detail WHERE id_jual=$tmp_id_jual AND jenis='Giro' AND status_giro<>1");
	$b3=mysqli_fetch_array($sql3);
	$jumlah_bayar-=$b3['jumlah_bayar'];
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
}else if ($row['status']=='3') {
	$status="PENDING";
}else if ($row['status']=='3') {
	$status="DIBATALKAN";
}else if ($row['status']=='4') {
	$status="BELUM TERBAYAR";
} else {
	$status="";
}
	echo '			<tr>
						<td align="center" style="width: 120px;">' .date("d-m-Y", strtotime($row['tgl_nota'])). '</td>
						<td align="center" style="width: 120px;">' .$row['no_nota_jual']. '</td>
						<td align="center" style="width: 180px;">' .$row['nama_pelanggan']. '</td>
						<td align="center" style="width: 100px;">' .$row['jenis']. '</td>
						<td align="center" style="width: 120px;">' .date("d-m-Y", strtotime($row['tgl_bayar'])). '</td>
						<td align="right" style="width: 150px;" class="uang">' .$row['jumlah']. '</td>
						<td align="right" style="width: 130px;" class="uang">' .$row['sisa']. '</td>
						<td align="center" style="width: 160px;">' .$status. '</td>
						<td align="center" style="width: 110px;">'.$nilai.'</td>
						<td align="center" style="width: 20px;"><a href="?page=penjualan&mode=bayar_nota&del=' .$row['id_bayar']. '" class="btn btn-primary btn-xs"><i class="fa fa-trash"></i></a></td>
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
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                <div style="min-width:50px">&times;</div>
            </button>
            <h4 class="modal-title">Tambah Pembayaran Nota Jual</h4>
        </div>
        <div class="modal-body">
            <form action="" method="post">
                <input type="hidden" name="tambah_bayar_nota_jual_post" value="true">
                <input type="hidden" id="jumlah_bayar" name="jumlah_bayar" value="">
                <div class="col-md-12">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-file fa-fw"></i><br>
                            <small>No. Nota Jual</small>
                        </span>
                        <select
                            id="select_nota"
                            name="no_nota_jual"
                            class="select2 form-control"
                            required="true">
                            <option value="" disabled="disabled" selected="selected">-= No Nota Jual | Nama Pelanggan | Jumlah Nota (Rp) =-</option>
                            <?php
								$sql=mysqli_query($con, "SELECT
    id_jual
    , jual.invoice
    , jual.diskon_all_persen
    , nama_pelanggan
FROM
    bayar_nota_jual
    RIGHT JOIN jual
        ON (bayar_nota_jual.no_nota_jual = jual.invoice)
    INNER JOIN pelanggan
        ON (jual.id_pelanggan = pelanggan.id_pelanggan)
WHERE (bayar_nota_jual.status IS NULL OR bayar_nota_jual.status=2 OR bayar_nota_jual.status=0) AND jual.status_konfirm < 5
GROUP BY id_jual");
								while($b=mysqli_fetch_array($sql)){
									$tmp_id_jual=$b['id_jual'];
									$sql2=mysqli_query($con, "SELECT SUM(qty*(harga-diskon_rp-diskon_rp_2-diskon_rp_3)) AS jumlah_nota
										FROM
											jual
											INNER JOIN jual_detail
												ON (jual.id_jual = jual_detail.id_jual)
									WHERE jual.id_jual=" .$b['id_jual']);
									$row2=mysqli_fetch_array($sql2);
									$jumlah_nota=$row2['jumlah_nota']-($row2['jumlah_nota']*$b['diskon_all_persen']/100);
									$ppn = $jumlah_nota*($row2['ppn_all_persen']/100);
									$sisaan = $jumlah_nota+$ppn;

									$sql2=mysqli_query($con, "SELECT SUM(jumlah) AS jumlah_bayar
									FROM
										bayar_nota_jual
										INNER JOIN jual
											ON (bayar_nota_jual.no_nota_jual = jual.invoice)
									WHERE jual.id_jual=" .$b['id_jual']);
									$row2=mysqli_fetch_array($sql2);
									$jumlah_bayar=$row2['jumlah_bayar'];

									$sql2=mysqli_query($con, "SELECT invoice,SUM(bayar) AS jumlah_bayar
									FROM
										penagihan_detail
										INNER JOIN jual
											ON (penagihan_detail.id_jual = jual.id_jual)
									WHERE jual.id_jual=" .$b['id_jual']);
									$row2=mysqli_fetch_array($sql2);
									$jumlah_bayar+=$row2['jumlah_bayar'];
									$no_nota = $row2['invoice'];
									$ci =mysqli_query($con, "SELECT sisa FROM bayar_nota_jual WHERE no_nota_jual='$no_nota' ORDER BY id_bayar DESC LIMIT 1");
									$so = mysqli_fetch_array($ci);

									$sisa_piutang=$sisaan-$jumlah_bayar;
									$sql2=mysqli_query($con, "SELECT SUM(qty*(harga-diskon_rp-diskon_rp_2-diskon_rp_3)) AS jumlah_nota FROM jual_detail WHERE id_jual=$tmp_id_jual");
									$b2=mysqli_fetch_array($sql2);
									$sqll = mysqli_query($con, "SELECT diskon_all_persen, ppn_all_persen FROM jual WHERE id_jual=$tmp_id_jual");
									$bb = mysqli_fetch_array($sqll);
									$set_dis=$b2['jumlah_nota']-($b2['jumlah_nota']*$bb['diskon_all_persen']/100);
									$ppn = $set_dis*($bb['ppn_all_persen']/100);
									$jumlah_nota = $set_dis+$ppn;
									$piutang = $jumlah_nota-$jumlah_bayar;
									if($so['sisa']==0) {
										$so['sisa']=$jumlah_nota;
									}
									if ($sisa_piutang>0) echo '<option data-piutang="' .$so['sisa']. '" data-jumlah="' .$b2['jumlah']. '" value="' .$b['invoice']. '">' .$b['invoice']. ' | ' .$b['nama_pelanggan']. ' | Rp ' .format_uang($jumlah_nota). '</option>';
								}
							?>
                        </select>
                        <span class="input-group-addon">
                            <i class="fa fa-star fa-fw" style="color:red"></i>
                        </span>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-money fa-fw"></i><br>
                            <small>Jenis</small>
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
                    <div class="input-group">
                        <span class="input-group-addon">Sisa Piutang (Rp)</span>
                        <input
                            class="form-control"
                            id="piutang"
                            value=""
                            title="Sisa Piutang"
                            readonly="readonly">
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
    window.location = "?page=penjualan&mode=bayar_nota&dari=" + $('#tgl_dari').val() +
            "&sampai=" + $('#tgl_sampai').val();
}
$(document).ready(function () {
    $('#piutang').inputmask('currency', {
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
    $('#select_nota').on('change', function () {
        var jumlah = $(this)
            .find(":selected")
            .data('jumlah');
        var piutang = $(this)
            .find(":selected")
            .data('piutang');

        $('#piutang').val(piutang);
        if ($('#jenis').val() != 'Retur') {
            $('#jumlah_bayar').val(jumlah);
        }
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
