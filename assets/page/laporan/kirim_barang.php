<?php
if (isset($edit_histori_kirim_barang_post)){
	if ($berat_volume=='berat') {$volume="null"; $berat=$val_berat_volume;}
	if ($berat_volume=='volume') {$berat="null"; $volume=$val_berat_volume;}
	if ($berat_volume=='null') {$berat="null"; $volume="null";}
	($id_ekspedisi=='null' ? $tipe_kirim='Kirim Sendiri' : $tipe_kirim='Via Ekspedisi');
	if ($jenis=='DALAM KOTA'){
		$sql=mysqli_query($con, "UPDATE nota_sudah_cek SET tipe_kirim='$tipe_kirim' WHERE id_jual=$id_jual");
		$sql=mysqli_query($con, "UPDATE pengiriman SET tanggal_kirim='$tanggal',jenis='DALAM KOTA',id_karyawan=$id_supir,id_ekspedisi=$id_ekspedisi,berat=$berat,volume=$volume,tarif=$tarif WHERE id_pengiriman=$id_pengiriman");
	} else {
		$sql=mysqli_query($con, "UPDATE pengiriman SET tanggal_kirim='$tanggal',jenis='LUAR KOTA',id_karyawan=$id_supir,id_ekspedisi=$id_ekspedisi,berat=$berat,volume=$volume,tarif=$tarif WHERE id_pengiriman=$id_pengiriman");
	}
	_direct("?page=laporan&mode=kirim_barang");
}
if (isset($_GET['cari'])){
	$tgl = explode("-", $_GET['cari']);
	$bln = $tgl[0]; $bln_sql=$bln;
	$thn = $tgl[1]; $thn_sql=$thn;
	$bulan_ini=$thn .'-'. $bln . "-01";
} else {
	$bln = date("m"); $bln_sql="MONTH(CURRENT_DATE())";
	$thn = date("Y"); $thn_sql="YEAR(CURRENT_DATE())";
	$bulan_ini=date("Y-m") . "-01";
}
?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="x_panel">
                    <div class="x_content">
                        <div class="col-xs-12" style="text-align:right">
                            <input
                                type="text"
                                id="datepicker"
                                placeholder="Bulan & Tahun"
                                style="width:100px"
                                readonly="readonly" />
                            <input type="button" id="cari" onclick="cari()" value="Cari">
                            <input type="button" id="reset" onclick="reset()" value="Reset">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h3>LAPORAN RIWAYAT PENGIRIMAN BARANG</h3>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="table responsive">
                            <table id="table1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Tanggal Kirim</th>
                                        <th>No Nota Jual</th>
                                        <th>Nama Supir</th>
                                        <th>Jenis</th>
                                        <th>Nama Ekspedisi</th>
                                        <th>Berat (Gr)</th>
                                        <th>Volume (CM3)</th>
                                        <th>Tarif (Rp)</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
$sql=mysqli_query($con, "SELECT jual.id_jual,id_pengiriman,invoice,pengiriman.status,pengiriman.jenis,tanggal_kirim,nama_karyawan,nama_ekspedisi,berat,volume,tarif
FROM
    pengiriman
    INNER JOIN karyawan 
        ON (pengiriman.id_karyawan = karyawan.id_karyawan)
    LEFT JOIN ekspedisi 
        ON (pengiriman.id_ekspedisi = ekspedisi.id_ekspedisi)
    INNER JOIN jual 
        ON (pengiriman.id_jual = jual.id_jual)
WHERE MONTH(tanggal_kirim)=$bln_sql AND YEAR(tanggal_kirim)=$thn_sql
ORDER BY id_pengiriman DESC");
while($row=mysqli_fetch_array($sql)){
if ($row['status']=='1'){$status='SELESAI';} else if($row['status']=='2'){$status='BATAL';} else {$status='';};
if ($row['jenis']=='LUAR KOTA'){
	$jenis='CANVASS';
	$sql2=mysqli_query($con, "SELECT canvass_stock_opname.status
FROM
    canvass_belum_siap
    LEFT JOIN canvass_stock_opname 
        ON (canvass_belum_siap.id_canvass_keluar = canvass_stock_opname.id_canvass_keluar)
WHERE id_jual=" .$row['id_jual']);
$row2=mysqli_fetch_array($sql2);
$status_so=$row2['status'];
} else {
	$jenis=$row['jenis'];
	$status_so='0';
}
if ($_SESSION['posisi']=='OWNER' && $status_so<>'1'){
		echo '	<tr>
				<td align="center"><a data-toggle="modal" data-target="#myModal" data-id="' .$row['id_pengiriman']. '"><div style="min-width:70px">' .date("d-m-Y",strtotime($row['tanggal_kirim'])). '</div></a></td>
				<td align="center"><a data-toggle="modal" data-target="#myModal" data-id="' .$row['id_pengiriman']. '"><div style="min-width:70px">' .$row['invoice']. '</div></a></td>
				<td align="center"><a data-toggle="modal" data-target="#myModal" data-id="' .$row['id_pengiriman']. '"><div style="min-width:70px">' .$row['nama_karyawan']. '</div></a></td>
				<td align="center"><a data-toggle="modal" data-target="#myModal" data-id="' .$row['id_pengiriman']. '"><div style="min-width:70px">' .$jenis. '</div></a></td>
				<td align="center"><a data-toggle="modal" data-target="#myModal" data-id="' .$row['id_pengiriman']. '"><div style="min-width:70px">' .$row['nama_ekspedisi']. '</div></a></td>
				<td align="center"><a data-toggle="modal" data-target="#myModal" data-id="' .$row['id_pengiriman']. '"><div style="min-width:70px">' .format_angka($row['berat']). '</div></a></td>
				<td align="center"><a data-toggle="modal" data-target="#myModal" data-id="' .$row['id_pengiriman']. '"><div style="min-width:70px">' .format_angka($row['volume']). '</div></a></td>
				<td align="right"><a data-toggle="modal" data-target="#myModal" data-id="' .$row['id_pengiriman']. '"><div style="min-width:70px">' .format_uang($row['tarif']). '</div></a></td>
				<td align="center"><a data-toggle="modal" data-target="#myModal" data-id="' .$row['id_pengiriman']. '"><div style="min-width:70px">' .$status. '</div></a></td>
				<td align="center"><a href="?page=penjualan&mode=view_detail&id=' .$row['id_jual']. '&direct" class="btn btn-primary btn-xs">View</a></td>
			</tr>';
	} else {
		echo '	<tr>
				<td align="center"><div style="min-width:70px">' .date("d-m-Y",strtotime($row['tanggal_kirim'])). '</div></td>
				<td align="center"><div style="min-width:70px">' .$row['invoice']. '</div></td>
				<td align="center"><div style="min-width:70px">' .$row['nama_karyawan']. '</div></td>
				<td align="center"><div style="min-width:70px">' .$jenis. '</div></td>
				<td align="center"><div style="min-width:70px">' .$row['nama_ekspedisi']. '</div></td>
				<td align="center"><div style="min-width:70px">' .format_angka($row['berat']). '</div></td>
				<td align="center"><div style="min-width:70px">' .format_angka($row['volume']). '</div></td>
				<td align="right"><div style="min-width:70px">' .format_uang($row['tarif']). '</div></td>
				<td align="center"><div style="min-width:70px">' .$status. '</div></td>
				<td align="center"><a href="?page=penjualan&mode=view_detail&id=' .$row['id_jual']. '&direct" class="btn btn-primary btn-xs">View</a></td>
			</tr>';
	}
	echo '	</tr>';
}
?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /page content -->

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
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Ubah Data Riwayat Pengiriman Barang</h4>
        </div>
        <div class="modal-body">
            <form action="" method="post" onsubmit="return cek_valid();">
                <input type="hidden" name="edit_histori_kirim_barang_post" value="true">
                <div id="get_kirim_barang" class="col-md-12"></div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="Simpan">
                </div>
            </form>
        </div>
    </div>
</div>
</div>
<script>
function cari() {
    var tanggal = $('#datepicker').val();
    var url = "?page=laporan&mode=kirim_barang&cari=" + tanggal;
    if (tanggal != '') 
        window.location = url;
    }
function reset() {
    var url = "?page=laporan&mode=kirim_barang";
    window.location = url;
}
function cek_valid() {
    if ($("#select_ekspedisi").val() == '') {
        return true;
    } else {
        if ($("#val_berat_volume").nval() > 0 || $("#tarif").nval() > 0) {
            alert('Berat / Volume / Traif harus > 0');
            return false;
        } else {
            return true;
        }
    }
}
$(document).ready(function () {
    $('#datepicker').datepicker(
        {orientation: "bottom auto", format: "mm-yyyy", startView: 1, minViewMode: 1, autoclose: true}
    );
    $('#myModal').on('show.bs.modal', function (e) {
        var id = $(e.relatedTarget).data('id');
        $('#get_kirim_barang').html(
            '<center><i class="fa fa-spinner fa-spin" style="font-size:24px"></i></center>'
        );
        $('#get_kirim_barang').load(
            "assets/page/laporan/get-kirim-barang.php?id=" + id
        );
    })
});
</script>