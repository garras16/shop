<?php
	if (isset($_GET['del'])){
		$sql=mysqli_query($con, "DELETE FROM canvass_belum_siap WHERE id_jual=" .$_GET['del']. "");
		$sql=mysqli_query($con, "DELETE FROM jual_detail WHERE id_jual=" .$_GET['del']. "");
		$sql=mysqli_query($con, "DELETE FROM jual WHERE id_jual=" .$_GET['del']. "");
		_direct("?page=penjualan&mode=penjualan");
	}
?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h3>PENJUALAN</h3>
                    </div>
                    <div class="clearfix"></div>
                    <div class="x_content">
                        <div class="alert alert-info">
                            <strong>Klik kolom pada tabel untuk detail.</strong>
                        </div>
                        <div class="col-md-4" style="margin-bottom: 35px;">
                            <table>
                                <tr>
                                    <td>Periode :<br><input
                                        class="form-control"
                                        style="width:100px"
                                        id="tgl_dari"
                                        type="text"
                                        value=""
                                        placeholder="Tanggal"
                                        readonly="readonly"></td>
                                    <td><br>&nbsp; - &nbsp;</td>
                                    <td><br><input
                                        class="form-control"
                                        style="width:100px"
                                        id="tgl_sampai"
                                        type="text"
                                        value=""
                                        placeholder="Tanggal"
                                        readonly="readonly"></td>
                                    <td>&nbsp;&nbsp;</td>
                                    <td><br>
                                        <a class="btn btn-primary" id="btn_dari_sampai" onclick="submit();">
                                            <i class="fa fa-search"></i>
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-4" style="margin-top:-2px" align="right">
                            <table>
                                <tr>
                                    <td>Cari Barang :<br><input
                                        class="form-control"
                                        style="width:180px"
                                        id="cari"
                                        type="text"
                                        value=""
                                        placeholder="Nama Barang"></td>
                                    <td>&nbsp;&nbsp;</td>
                                    <td><br>
                                        <a class="btn btn-primary" onclick="cari_barang();">
                                            <i class="fa fa-search"></i>
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <!-- <div class="col-md-4" style="float: right"> <p align="right"><br><button
                        class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa
                        fa-plus"></i> Tambah</button></p> </div> -->
                        <div class="clearfix"></div>
                        <table id="table1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Tgl. Nota Jual</th>
                                    <th>Invoice</th>
                                    <th>Pelanggan</th>
                                    <th>Sales</th>
                                    <th>Status Cetak</th>
                                    <th>Status Nota</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
if (isset($_GET['dari'])){
	$dari=date("Y-m-d", strtotime($_GET['dari']));
	$sampai=date("Y-m-d", strtotime($_GET['sampai']));
	$val="WHERE (jual.tgl_nota BETWEEN '$dari' AND '$sampai')";
} else if (isset($_GET['cari'])){
	$cari=$_GET['cari'];
	if ($cari==''){
		$val="";
	} else {
		$val="WHERE barang.nama_barang LIKE '%$cari%'";
	}
} else {
	$val="WHERE MONTH(jual.tgl_nota)=MONTH(CURRENT_DATE()) AND YEAR(jual.tgl_nota)=YEAR(CURRENT_DATE())";
}

$sql=mysqli_query($con, "SELECT
    jual.id_jual
    , jual.tgl_nota
    , jual.invoice
    , jual.status_konfirm
    , jual.cetak
    , pelanggan.nama_pelanggan
    , karyawan.nama_karyawan
    , nota_sudah_cek.status
FROM
    jual
    INNER JOIN jual_detail 
        ON (jual.id_jual = jual_detail.id_jual)
    INNER JOIN pelanggan 
        ON (jual.id_pelanggan = pelanggan.id_pelanggan)
    INNER JOIN karyawan 
        ON (jual.id_karyawan = karyawan.id_karyawan)
	LEFT JOIN nota_sudah_cek 
        ON (jual.id_jual = nota_sudah_cek.id_jual)
    INNER JOIN harga_jual 
        ON (jual_detail.id_harga_jual = harga_jual.id_harga_jual)
    INNER JOIN barang_supplier 
        ON (harga_jual.id_barang_supplier = barang_supplier.id_barang_supplier)
    INNER JOIN barang 
        ON (barang_supplier.id_barang = barang.id_barang)
$val
GROUP BY jual.id_jual
ORDER BY jual.id_jual DESC");
$i=0;
while($row=mysqli_fetch_array($sql)){
$i+=1;
if ($row['cetak']=='1'){
	$status_cetak='SUDAH CETAK';
	$style='badge bg-green';
} else{	
	$status_cetak='';
	$style='';
}
if ($row['status_konfirm']==0 or $row['status_konfirm']==5){
	$status_nota="MENUNGGU";$style='badge bg-green';$style2='badge bg-green';
} else if ($row['status_konfirm']==1 or $row['status_konfirm']==6){
	$status_nota="PROSES KIRIM";$style='badge bg-green';$style2='badge bg-green';
} else if ($row['status_konfirm']==2 or $row['status_konfirm']==7){
	$status_nota="TERKIRIM";$style='badge bg-red';$style2='badge bg-green';
} else {
	$status_nota="";$style='';$style2='';
}
	echo '			<tr>
						<td><a href="?page=penjualan&mode=view_detail&id=' .$row['id_jual']. '">' .$i. '</a></td>
						<td><a href="?page=penjualan&mode=view_detail&id=' .$row['id_jual']. '">' .date("d-m-Y", strtotime($row['tgl_nota'])). '</a></td>
						<td><a href="?page=penjualan&mode=view_detail&id=' .$row['id_jual']. '">' .$row['invoice']. '</a></td>
						<td><a href="?page=penjualan&mode=view_detail&id=' .$row['id_jual']. '">' .$row['nama_pelanggan']. '</a></td>
						<td><a href="?page=penjualan&mode=view_detail&id=' .$row['id_jual']. '">' .$row['nama_karyawan']. '</a></td>
						<td><a class="' .$style2. '" href="?page=penjualan&mode=view_detail&id=' .$row['id_jual']. '">' .$status_cetak. '</a></td>
						<td><a class="' .$style. '" href="?page=penjualan&mode=view_detail&id=' .$row['id_jual']. '">' .$status_nota. '</a></td>';
	$sql2=mysqli_query($con, "SELECT * FROM jual WHERE id_jual NOT IN (SELECT id_jual FROM canvass_siap_kirim) AND id_jual NOT IN (SELECT id_jual FROM nota_siap_kirim) AND id_jual=" .$row['id_jual']);
	if (mysqli_num_rows($sql2)>0 && $_SESSION['posisi']=="OWNER"){
		echo '			<td align="center"><a href="?page=penjualan&mode=penjualan&del=' .$row['id_jual']. '" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> HAPUS</a></td>';
	} else {
		echo '			<td></td>';
	}
	echo '			</tr>';
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
<!-- <div id="myModal" class="modal fade"> <div class="modal-dialog"> <div
class="modal-content"> <div class="modal-header"> <button type="button"
class="close" data-dismiss="modal" aria-hidden="true"><div
style="min-width:50px">&times;</div></button> <h4 class="modal-title">Tambah
Nota Pejualan</h4> </div> <div class="modal-body"> <form action=""
method="post"> <input type="hidden" name="tambah_pejualan_post" value="true">
<div class="col-md-12"> <div class="input-group"> <span
class="input-group-addon"><i class="fa fa-file fa-fw" style="width:
57px;"></i><br><small>No. Nota</small></span> <input id="no_nota"
name="no_nota_jual" style="padding: 20px 15px;" type="text" class="form-control"
placeholder="No Nota Jual" maxlength="15" required> <span
class="input-group-addon"><i class="fa fa-star fa-fw"
style="color:red"></i></span> </div> <div class="input-group"> <span
class="input-group-addon" style="padding: 2px 12px;"><i class="fa fa-building
fa-fw" style="width: 46px;"></i><br><small>Pelanggan</small></span> <select
name="id_pelanggan" class="select2 form-control" required="true"> <option
value="" disabled selected>-= Pilih Pelanggan =-</option> <?php
$cust=mysqli_query($con, "SELECT id_pelanggan, nama_pelanggan FROM pelanggan");
while($b=mysqli_fetch_array($cust)){ echo '<option value="' .$b['id_pelanggan'].
'">' .$b['nama_pelanggan']. '</option>'; } ?> </select> <span
class="input-group-addon"><i class="fa fa-star fa-fw"
style="color:red"></i></span> </div> <div class="input-group"> <span
class="input-group-addon"><div style="min-width:90px;text-align:left">Diskon
Nota (%)</div></span> <input id="diskon_all" onchange="handleChange(this)"
maxlength="6" name="diskon_all" type="text" class="form-control"
placeholder="Diskon Nota" value="0" required><br> </div> <div
class="input-group"> <span class="input-group-addon"><div
style="min-width:102px;text-align:left">PPN (%)</div></span> <input id="ppn_all"
onchange="handleChange(this)" maxlength="6" name="ppn_all" type="text"
class="form-control" placeholder="PPN" value="0" required> </div> </div> <div
class="modal-footer"> <input type="submit" class="btn btn-primary"
value="Simpan"> </div> </form> </div> </div> </div> </div> -->

<script>
function validasi() {
    var startDate = new Date.parse(get_global_tanggal($('#tgl_dari').val()));
    var endDate = new Date.parse(get_global_tanggal($('#tgl_sampai').val()));
    if (startDate > endDate) {
        $('#tgl_dari').val('');
        $('#tgl_sampai').val('');
        $('#btn_dari_sampai').attr('style', 'display:none');
        alert("Terjadi kesalahan penulisan tanggal");
        AndroidFunction.showToast("Terjadi kesalahan penulisan tanggal");
    } else {
        $('#btn_dari_sampai').removeAttr('style');
    }
}
function submit() {
    window.location = "?page=penjualan&mode=penjualan&dari=" + $('#tgl_dari').val() +
            "&sampai=" + $('#tgl_sampai').val();
}
function cari_barang() {
    window.location = "?page=penjualan&mode=penjualan&cari=" + $('#cari').val();
}
function handleChange(input) {
    if (input.value < 0) 
        input.value = 0;
    if (input.value > 100) 
        input.value = 100;
    }
$(document).ready(function () {
    $('#diskon_all').numeric({decimalPlaces: 2, negative: false});
    $('#ppn_all').numeric({decimalPlaces: 2, negative: false});
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
});
</script>