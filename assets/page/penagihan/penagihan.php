<?php
$id_karyawan=$_SESSION['id_karyawan'];
if (isset($batal_penagihan_post)){
	foreach ($id_penagihan as $key => $value) {
		$sql=mysqli_query($con, "SELECT * FROM penagihan_detail WHERE id_penagihan=" .$value. " AND status_bayar<3");
		if (mysqli_num_rows($sql)==0){
			$sql=mysqli_query($con, "DELETE FROM penagihan WHERE id_penagihan=" .$value);
			$sql=mysqli_query($con, "DELETE FROM penagihan_detail WHERE id_penagihan=" .$value);
		} else {
			_alert("Input Gagal. Ada tagihan yang sudah diproses.");
		}
	}
	_direct("?page=penagihan&mode=penagihan&reset");
}
?>
<div class="right_col loading" role="main">
    <div class="">

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <div class="col-md-6">
                            <h3>PENAGIHAN</h3>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                        <div class="" role="tabpanel">
                            <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                <li role="presentation" class="active">
                                    <a
                                        href="#tab_content1"
                                        id="tab1"
                                        role="tab"
                                        data-toggle="tab"
                                        aria-expanded="true">Nota Jual Jatuh Tempo</a>
                                </li>
                                <li role="presentation" class="">
                                    <a
                                        href="#tab_content2"
                                        role="tab"
                                        id="tab2"
                                        data-toggle="tab"
                                        aria-expanded="false">Penagihan</a>
                                </li>
                            </ul>
                            <div id="myTabContent" class="tab-content">
                                <div
                                    role="tabpanel"
                                    class="tab-pane fade active in"
                                    id="tab_content1"
                                    aria-labelledby="tab1">

                                    <div class="table-responsive">
                                        <table
                                            id="table1"
                                            class="table table-bordered table-striped"
                                            style="min-width: 1500px;">
                                            <thead>
                                                <tr>
                                                    <th>Tgl Nota Jual</th>
                                                    <th>No Nota Jual</th>
                                                    <th>Nama Sales</th>
                                                    <th>Nama Driver</th>
                                                    <th>Nama Pelanggan</th>
                                                    <th>Jumlah Jual</th>
                                                    <th>Sisa Plafon</th>
                                                    <th>Tipe Nota</th>
                                                    <th>Tgl Jatuh Tempo</th>
                                                    <th>Tgl Kunjungan Berikutnya</th>
                                                    <th>Sisa Piutang</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
	$sql=mysqli_query($con, "SELECT *
FROM
    jual
    INNER JOIN pelanggan
        ON (jual.id_pelanggan = pelanggan.id_pelanggan)
    INNER JOIN karyawan
        ON (jual.id_karyawan = karyawan.id_karyawan)
WHERE status_konfirm=2 AND id_jual NOT IN (SELECT id_jual FROM penagihan INNER JOIN penagihan_detail
    ON (penagihan.id_penagihan=penagihan_detail.id_penagihan) WHERE status_tagih<>2)");
	//0=belum bayar
	//1=terbayar sebagian
	//2=lunas
	//3=belum tagih
	while ($row=mysqli_fetch_array($sql)){
		if ($row['status_konfirm']>=0 && $row['status_konfirm']<=2) $tipe='DALAM KOTA';
		if ($row['status_konfirm']>=5 && $row['status_konfirm']<=7) $tipe='LUAR KOTA';

		$sql2=mysqli_query($con, "SELECT nama_karyawan
FROM
    pengiriman
    INNER JOIN karyawan
        ON (pengiriman.id_karyawan = karyawan.id_karyawan)
WHERE id_jual=" .$row['id_jual']);
		$row2=mysqli_fetch_array($sql2);
		$nama_driver=$row2['nama_karyawan'];

		$sql2=mysqli_query($con, "SELECT plafon FROM pelanggan WHERE id_pelanggan=" .$row['id_pelanggan']);
		$row2=mysqli_fetch_array($sql2);
		$plafon=$row['plafon'];
		$sql2=mysqli_query($con, "SELECT SUM(qty*(harga-diskon_rp-diskon_rp_2-diskon_rp_3)) AS jumlah_nota
FROM
    jual
    INNER JOIN jual_detail
        ON (jual.id_jual = jual_detail.id_jual)
WHERE jual.id_jual=" .$row['id_jual']);
$row2=mysqli_fetch_array($sql2);
$jumlah_nota=$row2['jumlah_nota'];

		$sql2=mysqli_query($con, "SELECT *
FROM
    bayar_nota_jual
    INNER JOIN jual
        ON (bayar_nota_jual.no_nota_jual = jual.invoice)
WHERE jual.id_jual=" .$row['id_jual']);
$jumlah_bayar=0;
while ($row2=mysqli_fetch_array($sql2)){
	if ($row2['jenis']=='Giro'){
		if ($row2['status_giro']=='1') $jumlah_bayar+=$row2['jumlah'];
	} else {
		$jumlah_bayar+=$row2['jumlah'];
	}
}

$sql2=mysqli_query($con, "SELECT *
FROM
    penagihan_detail
    INNER JOIN jual
        ON (penagihan_detail.id_jual = jual.id_jual)
WHERE jual.id_jual=" .$row['id_jual']);
while ($row2=mysqli_fetch_array($sql2)){
	if ($row2['jenis']=='Giro'){
		if ($row2['status_giro']=='1') $jumlah_bayar+=$row2['bayar'];
	} else {
		$jumlah_bayar+=$row2['bayar'];
	}
}

$sql2=mysqli_query($con, "SELECT SUM(jumlah_retur) AS jumlah_bayar
FROM
    penagihan_detail
    INNER JOIN penagihan_retur_detail
        ON (penagihan_detail.id_penagihan_detail = penagihan_retur_detail.id_penagihan_detail)
WHERE id_jual=" .$row['id_jual']);
$row2=mysqli_fetch_array($sql2);
$jumlah_bayar+=$row2['jumlah_bayar'];

$sisa_piutang=$jumlah_nota-$jumlah_bayar;
$sisa_plafon=$plafon-$sisa_piutang;

if ($sisa_piutang=='0') continue;

		$sql2=mysqli_query($con, "SELECT SUM(qty_ambil*(harga-diskon_rp-diskon_rp_2-diskon_rp_3)) AS total_jual
			FROM
				jual_detail
				INNER JOIN nota_siap_kirim_detail
					ON (jual_detail.id_jual_detail = nota_siap_kirim_detail.id_jual_detail)
			WHERE id_jual=" .$row['id_jual']);
		$r=mysqli_fetch_array($sql2);
		$total_jual=$r['total_jual'];
		$sql2=mysqli_query($con, "SELECT SUM(qty_ambil*(harga-diskon_rp-diskon_rp_2-diskon_rp_3)) AS total_jual
			FROM
				jual_detail
				INNER JOIN canvass_siap_kirim_detail
					ON (jual_detail.id_jual_detail = canvass_siap_kirim_detail.id_jual_detail)
			WHERE id_jual=" .$row['id_jual']);
		$r=mysqli_fetch_array($sql2);
		$total_jual+=$r['total_jual'];
if ($total_jual==0) break;

$tgl_jt_tempo=date('Y-m-d', strtotime($row['tgl_nota']. ' + ' .$row['tenor']. ' days'));;
$sql2=mysqli_query($con, "SELECT tgl_janji_next FROM penagihan_detail WHERE id_jual=" .$row['id_jual']. " ORDER BY id_penagihan_detail DESC LIMIT 1");
$row2=mysqli_fetch_array($sql2);
($row2['tgl_janji_next']!='' ? $tgl_janji_next=date('Y-m-d', strtotime($row2['tgl_janji_next'])) : $tgl_janji_next='');

($sisa_plafon<0 ? $color1='red' : $color1='black');
(strtotime($tgl_jt_tempo)<=strtotime(date("Y-m-d")) ? $color2='red' : $color2='black');
$color3='black';
if ($row2['tgl_janji_next']!=''){
	(strtotime($row2['tgl_janji_next'])<=strtotime(date("Y-m-d")) ? $color3='red' : $color3='black');
}

		echo '<tr>
				<td align="center"><div style="min-width:70px">' .date("d-m-Y",strtotime($row['tgl_nota'])). '</div></td>
				<td align="center"><div style="min-width:70px">' .$row['invoice']. '</div></td>
				<td align="center"><div style="min-width:70px">' .$row['nama_karyawan']. '</div></td>
				<td align="center"><div style="min-width:70px">' .$nama_driver. '</div></td>
				<td align="center"><div style="min-width:70px">' .$row['nama_pelanggan']. '</div></td>
				<td align="center"><div style="min-width:70px" class="uang">' .format_uang($total_jual). '</div></td>
				<td align="center"><div style="min-width:70px;color:' .$color1. '" class="uang">' .format_uang($sisa_plafon). '</div></td>
				<td align="center"><div style="min-width:70px">' .$tipe. '</div></td>
				<td align="center"><div style="min-width:70px;color:' .$color2. '">' .date("d-m-Y",strtotime($tgl_jt_tempo)). '</div></td>
				<td align="center"><div style="min-width:70px;color:' .$color3. '">' .$tgl_janji_next. '</div></td>
				<td align="center"><div style="min-width:70px" class="uang">' .format_uang($sisa_piutang). '</div></td>
			</tr>';
	}
?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div
                                    role="tabpanel"
                                    class="tab-pane fade"
                                    id="tab_content2"
                                    aria-labelledby="tab2">
                                    <form method="post" onsubmit="return cek_valid2()">
                                        <input type="hidden" name="batal_penagihan_post" value="true">
                                        <center><input class="btn btn-primary" type="submit" value="Batalkan Penagihan"></center><br/>

                                        <div class="table-responsive">
                                            <table id="table_siap_tagih" class="table table-bordered table-striped" style="min-width: 700px;">
                                                <thead>
                                                    <tr>
                                                        <th>Pilih</th>
                                                        <th>Tgl Tagih</th>
                                                        <th>Total Nilai Tagihan</th>
                                                        <th>Debt Collector</th>
                                                        <th>Total Bayar</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php

	$sql=mysqli_query($con, "SELECT *,SUM(bayar) AS bayar
FROM
    penagihan
    INNER JOIN karyawan
        ON (penagihan.id_karyawan = karyawan.id_karyawan)
    INNER JOIN penagihan_detail
        ON (penagihan.id_penagihan = penagihan_detail.id_penagihan)
	INNER JOIN jual
        ON (penagihan_detail.id_jual = jual.id_jual)
WHERE status_tagih<>2
GROUP BY penagihan.id_penagihan");
	while ($row=mysqli_fetch_array($sql)){
	($row['status_konfirm']>=0 && $row['status_konfirm']<=4 ? $tipe="dalam_kota" : $tipe="canvass");

	if ($tipe=="dalam_kota"){
	$sql2=mysqli_query($con, "SELECT SUM(qty_ambil*(harga-diskon_rp-diskon_rp_2-diskon_rp_3)) AS total
FROM
    penagihan
    INNER JOIN penagihan_detail
        ON (penagihan.id_penagihan = penagihan_detail.id_penagihan)
    INNER JOIN jual_detail
        ON (penagihan_detail.id_jual = jual_detail.id_jual)
    INNER JOIN nota_siap_kirim_detail
        ON (jual_detail.id_jual_detail = nota_siap_kirim_detail.id_jual_detail)
WHERE penagihan.id_penagihan=" .$row['id_penagihan']);
	} else {
	$sql2=mysqli_query($con, "SELECT SUM(qty_ambil*(harga-diskon_rp-diskon_rp_2-diskon_rp_3)) as total
FROM
    penagihan
    INNER JOIN penagihan_detail
        ON (penagihan.id_penagihan = penagihan_detail.id_penagihan)
    INNER JOIN jual_detail
        ON (penagihan_detail.id_jual = jual_detail.id_jual)
    INNER JOIN canvass_siap_kirim_detail
        ON (jual_detail.id_jual_detail = canvass_siap_kirim_detail.id_jual_detail);
WHERE penagihan.id_penagihan=" .$row['id_penagihan']);
	}
$total_jual=0;
	while ($row2=mysqli_fetch_array($sql2)){
		$total_jual+=$row2['total'];
	}
	$tgl_jt=date('Y/m/d',strtotime($row["tgl_nota"]. '+' .$row['tenor']. ' days'));
	($row['tgl_janji_next']=='' ? $tgl_jb='' : $tgl_jb=date('d-m-Y',strtotime($row['tgl_janji_next'])));
		echo '<tr>
				<td align="center"><input style="width: 20px; height: 20px;" type="checkbox" id="id_penagihan" name="id_penagihan[]" value="' .$row['id_penagihan']. '"></td>
				<td align="center"><a href="?page=penagihan&mode=penagihan_2&id=' .$row['id_penagihan']. '"><div style="min-width:70px">' .date("d-m-Y",strtotime($row['tanggal_tagih'])). '</div></a></td>
				<td align="center"><a href="?page=penagihan&mode=penagihan_2&id=' .$row['id_penagihan']. '"><div style="min-width:70px" class="uang">' .$total_jual. '</div></a></td>
				<td align="center"><a href="?page=penagihan&mode=penagihan_2&id=' .$row['id_penagihan']. '"><div style="min-width:70px">' .$row['nama_karyawan']. '</div></a></td>
				<td align="center"><a href="?page=penagihan&mode=penagihan_2&id=' .$row['id_penagihan']. '"><div style="min-width:70px" class="uang">' .$row['bayar']. '</div></a></td>
			</tr>';

	}
?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div id="dummy"></div>
            </div>
        </div>
    </div>
</div>
</div>

<script>
function getBack() {
    AndroidFunction.closeApp();
}
function cek_valid2() {
    var len = $('#table_siap_tagih')
        .find("input:checkbox:checked")
        .length;
    if (len == 0) {
        alert("Belum pilih nota.");
        return false;
    } else {
        return true;
    }
}
$(document).ready(function () {
    $('#table_siap_tagih').DataTable(
        {"pageLength": 30, "bPaginate": true, "bLengthChange": false, "scrollX": false, "aaSorting": []}
    );
    $('.uang').inputmask('currency', {
        prefix: "Rp ",
        autoGroup: true,
        allowMinus: false,
        groupSeparator: '.',
        rightAlign: false,
        autoUnmask: true,
        removeMaskOnSubmit: true
    });
    <?php if (isset($_GET['reset'])) echo "$('#tab2').click()"; ?>
})
</script>
