<?php
$bln_sql="MONTH(CURRENT_DATE())";
$thn_sql="YEAR(CURRENT_DATE())";
?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h3>SETORAN</h3>
                        <?php
							if (isset($pesan)){
								echo '<span class="badge bg-' .$warna. '">' .$pesan. '</span>';
							}
							?>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="table responsive">
                            <table id="table1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Nama Pelanggan</th>
                                        <th>No Nota Jual</th>
                                        <th>Jumlah Jual</th>
                                        <th>Debt Collector</th>
                                        <th>Tgl Tagih</th>
                                        <th>Jml Tagih</th>
                                        <th>Jml Bayar</th>
                                        <th>Sisa Piutang</th>
                                        <th>Tgl Tagih Berikutnya</th>
                                        <th>Status Bayar</th>
                                        <th>Status Kembali Nota</th>
                                        <th>Setor</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
$sql=mysqli_query($con, "SELECT *
FROM
    penagihan
    INNER JOIN karyawan 
        ON (penagihan.id_karyawan = karyawan.id_karyawan)
    INNER JOIN penagihan_detail 
        ON (penagihan.id_penagihan = penagihan_detail.id_penagihan)
    INNER JOIN jual 
        ON (penagihan_detail.id_jual = jual.id_jual)
    INNER JOIN pelanggan 
        ON (jual.id_pelanggan = pelanggan.id_pelanggan)
    INNER JOIN jual_detail 
        ON (jual.id_jual = jual_detail.id_jual)
WHERE penagihan.status_tagih <>2
GROUP BY jual.id_jual");
while ($row=mysqli_fetch_array($sql)){
	$sql2=mysqli_query($con, "SELECT (qty_ambil*(harga-diskon_rp-diskon_rp_2-diskon_rp_3)) AS total
FROM
    jual_detail
    INNER JOIN nota_siap_kirim_detail 
        ON (jual_detail.id_jual_detail = nota_siap_kirim_detail.id_jual_detail)
WHERE id_jual=" .$row['id_jual']);
$total_jual=0;
	while ($row2=mysqli_fetch_array($sql2)){
		$total_jual+=$row2['total'];
	}
	$status='';
	if ($row['status_bayar']=='0') {$status='Belum Bayar'; $color='red';}
	if ($row['status_bayar']=='1') {$status='Sedang Mengangsur'; $color='red';}
	if ($row['status_bayar']=='2') {$status='Lunas'; $color='black';}
	if ($row['status_bayar']=='3') {$status='Belum Tagih'; $color='black';}
	if ($row['status_nota_kembali']=='0') $status_nota='Dibawa Debt Collector';
	if ($row['status_nota_kembali']=='1') $status_nota='Diterima Admin';
	if ($row['status_nota_kembali']=='2') $status_nota='Lunas';
	($row['tgl_janji_next']=='' ? $tgl_jb='' : $tgl_jb=date('d-m-Y',strtotime($row['tgl_janji_next'])));
	if ($row['tgl_janji_next']!=''){
		$tglx1=strtotime($row['tgl_janji_next']);
		$tglx2=strtotime(date('Y-m-d'));
		($tglx1>=$tglx2 ? $color2='red' : $color2='black');
	} else {
		$color2='black';
	}
	echo '<tr>
			<td align="center">' .$row['nama_pelanggan']. '</td>
			<td align="center">' .$row['invoice']. '</td>
			<td align="center" class="uang">' .format_uang($total_jual). '</td>
			<td align="center">' .$row['nama_karyawan']. '</td>
			<td align="center">' .date("d-m-Y",strtotime($row['tanggal_tagih'])). '</td>
			<td align="center" class="uang">' .format_uang($total_jual). '</td>
			<td align="center" class="uang">' .format_uang($row['bayar']). '</td>
			<td align="center" class="uang">' .format_uang($total_jual-$row['bayar']). '</td>
			<td align="center" style="color: ' .$color2. '">' .$tgl_jb. '</td>
			<td align="center" style="color: ' .$color. '">' .$status. '</td>
			<td align="center">' .$status_nota. '</td>
			<td align="center">' .$row['setor']. '</td>
			<td align="center"><a data-toggle="modal" data-target="#myModal" data-id-penagihan-detail="' .$row['id_penagihan_detail']. '" data-invoice="' .$row['invoice']. '" data-bayar="' .$row['bayar']. '" class="btn btn-xs btn-warning"><i class="fa fa-barcode"></i> Scan Nota</a></td>
		</tr>';
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
            <h4 class="modal-title">Setoran</h4>
        </div>
        <div class="modal-body">
            <form action="" method="post" onsubmit="return cek_valid();">
                <input type="hidden" name="edit_setoran_post" value="true">
                <input
                    type="hidden"
                    id="id_penagihan_detail"
                    name="id_penagihan_detail"
                    value="">
                <input type="hidden" id="invoice" value="">
                <div class="text-center" style="margin-bottom:10px">
                    <a id="scan_nota" class="btn btn-primary" onclick="AndroidFunction.scanNota();">Scan Nota</a>
                </div>
                <div class="form-group col-sm-12">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-book fa-fw"></i>
                            Jumlah Bayar</span>
                        <input
                            class="form-control"
                            id="bayar"
                            name="bayar"
                            placeholder="Jumlah Bayar"
                            value=""
                            readonly="readonly">
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-tags fa-fw"></i>
                            Jumlah Setor</span>
                        <input
                            class="form-control"
                            type="tel"
                            id="setor"
                            name="setor"
                            placeholder="Jumlah Setor"
                            value=""
                            required="required">
                        <span class="input-group-addon">
                            <i class="fa fa-star fa-fw" style="color:red"></i>
                        </span>
                    </div>
                </div>
                <div class="modal-footer">
                    <input id="simpan" type="submit" class="btn btn-primary" value="Simpan">
                </div>
            </form>
        </div>
    </div>
</div>
</div>

<script>
function getBack() {
    if ($('#myModal').is(':visible')) {
        $('#myModal').modal('hide');
    } else {
        AndroidFunction.closeApp();
    }
}
function batal_scan() {
    getBack();
}
function cek_valid() {
    var jumlah_bayar = $('#bayar').inputmask('unmaskedvalue');
    var jumlah_setor = $('#setor').inputmask('unmaskedvalue');

    if (jumlah_setor > jumlah_bayar) {
        AndroidFunction.showToast("Jumlah setor tidak boleh melebihi jumlah bayar.");
        return false;
    } else {
        return true;
    }
}
function cek_scan_nota(barcode) {
    var invoice = $('#invoice').val();
    if (invoice == barcode) {} else {
        $('#myModal').modal('hide');
        AndroidFunction.showToast('Barcode Nota salah.');
    }
}
$(document).ready(function () {
    
    $('#scan_nota').hide();
    $('.uang').inputmask('currency', {
        prefix: "Rp ",
        autoGroup: true,
        allowMinus: false,
        groupSeparator: '.',
        rightAlign: false,
        autoUnmask: true,
        removeMaskOnSubmit: true
    });
    $('#setor').inputmask('currency', {
        prefix: "Rp ",
        autoGroup: true,
        allowMinus: false,
        groupSeparator: '.',
        rightAlign: false,
        autoUnmask: true,
        removeMaskOnSubmit: true
    });
    $('#bayar').inputmask('currency', {
        prefix: "Rp ",
        autoGroup: true,
        allowMinus: false,
        groupSeparator: '.',
        rightAlign: false,
        autoUnmask: true,
        removeMaskOnSubmit: true
    });
    $('#myModal').on('show.bs.modal', function (e) {
        var id_penagihan_detail = $(e.relatedTarget).data('id-penagihan-detail');
        var invoice = $(e.relatedTarget).data('invoice');
        var bayar = $(e.relatedTarget).data('bayar');
        $('#id_penagihan_detail').val(id_penagihan_detail);
        $('#invoice').val(invoice);
        $('#jumlah_bayar').val(bayar);
        //$('#scan_nota').click();
    })
});
</script>