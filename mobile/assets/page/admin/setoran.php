<?php
	if (isset($edit_setoran_post)){
		$sql = mysqli_query($con, "SELECT status_bayar FROM penagihan_detail WHERE id_penagihan_detail=$id_penagihan_detail");
		$row=mysqli_fetch_array($sql);
		($row['status_bayar']==2 ? $status_nota=2 : $status_nota=1);
		if ($setor=='') $setor=0;
		if ($tgl_janji_next==''){
			$sql = mysqli_query($con, "UPDATE penagihan_detail SET setor=$setor,status_nota_kembali=$status_nota,tgl_janji_next=null WHERE id_penagihan_detail=$id_penagihan_detail");
		} else {
			$tgl = explode("/", $tgl_janji_next);
			$tgl_janji_next = $tgl[2] ."-". $tgl[1] ."-". $tgl[0];
			$sql = mysqli_query($con, "UPDATE penagihan_detail SET setor=$setor,status_nota_kembali=$status_nota,tgl_janji_next='$tgl_janji_next' WHERE id_penagihan_detail=$id_penagihan_detail");
		}

		if ($sql){
			_buat_pesan("Input Berhasil.","green");
		} else {
			_buat_pesan("Input Gagal.","red");
		}
		_direct("?page=admin&mode=setoran");
	}
	if (isset($_GET['del'])){
		$sql = mysqli_query($con, "UPDATE penagihan_detail SET setor=0,status_nota_kembali=0,tgl_janji_next=null WHERE id_penagihan_detail=" .$_GET['del']);
		if ($sql){
			_buat_pesan("Input Berhasil.","green");
		} else {
			_buat_pesan("Input Gagal.","red");
		}
		_direct("?page=admin&mode=setoran");
	}
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
					<h3>SETORAN TANGGAL
						<?php echo date("d-m-Y");?></h3>
					<?php
						if (isset($pesan)){
							echo '<span class="badge bg-' .$warna. '">' .$pesan. '</span>';
						}
					?>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div class="table-responsive">
						<table id="table1" class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>Nama Pelanggan</th>
									<th>No Nota Jual</th>
									<th>Jumlah Jual (Rp)</th>
									<th>Debt Collector</th>
									<th>Tgl Tagih</th>
									<th>Jml Tagih (Rp)</th>
									<th>Jml Bayar (Rp)</th>
									<th>Tgl Bayar</th>
									<th>Sisa Piutang (Rp)</th>
									<th>Tgl Kunjungan Berikutnya</th>
									<th>Status Bayar</th>
									<th>Status Kembali Nota</th>
									<th>Setor (Rp)</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
<?php
	$sql=mysqli_query($con, "SELECT *, SUM(bayar) as bayar
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
		$sql2=mysqli_query($con, "SELECT SUM(bayar) as bayar
			FROM
				penagihan
			INNER JOIN penagihan_detail
				ON (penagihan.id_penagihan = penagihan_detail.id_penagihan)
			WHERE id_jual=" .$row['id_jual']);
		$row2=mysqli_fetch_array($sql2);
		$total_bayar=$row2['bayar'];
		$total_jual=0;
		if ($row['status_konfirm']>=5){
			$sql2=mysqli_query($con, "SELECT (qty_ambil*(harga-diskon_rp-diskon_rp_2-diskon_rp_3)) AS total
					FROM
						jual_detail
					INNER JOIN canvass_siap_kirim_detail
						ON (jual_detail.id_jual_detail = canvass_siap_kirim_detail.id_jual_detail)
					WHERE id_jual=" .$row['id_jual']);
			while ($row2=mysqli_fetch_array($sql2)){
				$total_jual+=$row2['total'];
			}
		} else {
			$sql2=mysqli_query($con, "SELECT (qty_ambil*(harga-diskon_rp-diskon_rp_2-diskon_rp_3)) AS total
					FROM
						jual_detail
					INNER JOIN nota_siap_kirim_detail
						ON (jual_detail.id_jual_detail = nota_siap_kirim_detail.id_jual_detail)
					WHERE id_jual=" .$row['id_jual']);
			while ($row2=mysqli_fetch_array($sql2)){
				$total_jual+=$row2['total'];
			}
		}

		/*	$sql2=mysqli_query($con, "SELECT *
		FROM
		penagihan_detail
		WHERE id_jual=" .$row['id_jual']. " AND jenis<>'Retur'");
		$row2=mysqli_fetch_array($sql2);*/

		$status='';$color='black';
		if ($row['status_bayar']=='0') {$status='Belum Bayar'; $color='red';}
		if ($row['status_bayar']=='1') {$status='Sedang Mengangsur'; $color='red';}
		if ($row['status_bayar']=='2') {$status='Lunas'; $color='black';}
		if ($row['status_bayar']=='3') {$status='Belum Tagih'; $color='black';}
		if ($row['status_nota_kembali']=='0') $status_nota='Dibawa Debt Collector';
		if ($row['status_nota_kembali']=='1') $status_nota='Diterima Admin';
		if ($row['status_nota_kembali']=='2') $status_nota='Lunas';
		($row['status_nota_kembali']=='2' ? $cmd='Setor' : $cmd='Scan Nota');
		($row['tgl_bayar']=='' ? $tgl_bayar='' : $tgl_bayar=date("d-m-Y",strtotime($row['tgl_bayar'])));
		($row['tgl_janji_next']=='' ? $tgl_jb='' : $tgl_jb=date('d-m-Y',strtotime($row['tgl_janji_next'])));
		if ($row['tgl_janji_next']!=''){
			$tglx1=strtotime($row['tgl_janji_next']);
			$tglx2=strtotime(date('Y-m-d'));
			($tglx1<=$tglx2 ? $color2='red' : $color2='black');
		} else {
			$color2='black';
		}
		echo '<tr>
				<td align="center">' .$row['nama_pelanggan']. '</td>
				<td align="center">' .$row['invoice']. '</td>
				<td align="center">' .format_uang($total_jual). '</td>
				<td align="center">' .$row['nama_karyawan']. '</td>
				<td align="center">' .date("d-m-Y",strtotime($row['tanggal_tagih'])). '</td>
				<td align="center">' .format_uang($total_jual). '</td>
				<td align="center">' .format_uang($total_bayar). '</td>
				<td align="center">' .$tgl_bayar. '</td>
				<td align="center">' .format_uang($total_jual-$total_bayar). '</td>
				<td align="center" style="color: ' .$color2. '">' .$tgl_jb. '</td>
				<td align="center" style="color: ' .$color. '">' .$status. '</td>
				<td align="center">' .$status_nota. '</td>
				<td align="center">' .format_uang($row['setor']). '</td>
				<td align="center">';
					if ($row['status_nota_kembali']==0) {
						echo '<a data-toggle="modal" data-target="#myModal" data-status-nota="' .$row['status_nota_kembali']. '" data-status-bayar="' .$row['status_bayar']. '" data-id-penagihan-detail="' .$row['id_penagihan_detail']. '" data-invoice="' .$row['invoice']. '" data-bayar="' .$total_bayar. '" data-tgl-janji="' .$tgl_jb. '" class="btn btn-xs btn-primary"><i class="fa fa-barcode"></i> ' .$cmd. '</a>';
					} else {
						echo '<a href="?page=admin&mode=setoran&del=' .$row['id_penagihan_detail']. '" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Hapus</a>';
					}
				echo '</td>
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
                                <input type="hidden" id="status_bayar" value="">
                                    <div class="text-center" style="margin-bottom:10px">
                                        <a id="scan_nota" class="btn btn-primary" onclick="AndroidFunction.scanNota();">Scan Nota</a>
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-book fa-fw"></i>
                                                Jumlah Bayar (Rp)</span>
                                            <input
                                                class="form-control"
                                                id="bayar"
                                                name="bayar"
                                                placeholder="Jumlah Bayar"
                                                value=""
                                                readonly="readonly"></div>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-tags fa-fw"></i>
                                                    Jumlah Setor (Rp)&nbsp</span>
                                                <input
                                                    class="form-control"
                                                    type="tel"
                                                    id="setor"
                                                    name="setor"
                                                    placeholder="Jumlah Setor"
                                                    value=""></div>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-calendar fa-fw"></i>
                                                        Kunjungan berikutnya</span>
                                                    <input
                                                        class="form-control"
                                                        id="tgl_janji_next"
                                                        name="tgl_janji_next"
                                                        value=""
                                                        placeholder="Tanggal Kunjungan Berikutnya"
                                                        title="Tanggal Janji Berikutnya"></div>
                                                </div>
                                                <div class="modal-footer">
                                                    <input id="simpan" type="submit" class="btn btn-primary" value="Simpan"></div>
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
    var jumlah_bayar = parseFloat($('#bayar').val());
    var jumlah_setor = parseFloat($('#setor').val());
    var inv1 = $('#invoice').val();
    var inv2 = $('#invoice_2').val();
    var bypass = $('#bypass').val();
    var status_bayar = $('#status_bayar').val();

    if (jumlah_setor > jumlah_bayar) {
        AndroidFunction.showToast("Jumlah setor tidak boleh melebihi jumlah bayar.");
        return false;
    } else if (status_bayar == 2 && $('#tgl_janji_next').val().length > 0) {
        AndroidFunction.showToast("Tanggal kunjungan berikutnya harus kosong.");
        $('#tgl_janji_next').val('');
        return false;
    } else if (jumlah_bayar == 0 && $('#tgl_janji_next').val().length < 10) {
        AndroidFunction.showToast("Anda harus mengisi tanggal kunjungan berikutnya.");
        return false;
    } else if (inv1 != inv2 && bypass == 'true') {
        AndroidFunction.showToast("Input No Nota Jual salah.");
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
    $('#setor').inputmask('decimal', {
        allowMinus: false,
        autoGroup: true,
        groupSeparator: '.',
        rightAlign: false,
        removeMaskOnSubmit: true
    });
    $('#bayar').inputmask('decimal', {
        allowMinus: false,
        autoGroup: true,
        groupSeparator: '.',
        rightAlign: false,
        removeMaskOnSubmit: true
    });
    $('#myModal').on('show.bs.modal', function (e) {
        var id_penagihan_detail = $(e.relatedTarget).data('id-penagihan-detail');
        var invoice = $(e.relatedTarget).data('invoice');
        var bayar = $(e.relatedTarget).data('bayar');
        var status_nota = $(e.relatedTarget).data('status-nota');
        var status_bayar = $(e.relatedTarget).data('status-bayar');
        var tgl_jb = $(e.relatedTarget).data('tgl-janji');
        $('#id_penagihan_detail').val(id_penagihan_detail);
        $('#invoice_2').val(invoice);
        $('#invoice').val(invoice);
        $('#bayar').val(bayar);
        $('#tgl_janji_next').val(tgl_jb);

        if (status_nota != 2)
            $('#scan_nota').click();
        if (status_bayar == 3) {
            $('#bayar').val('0');
            $('#setor').val('0');
            $('#setor').attr('disabled', 'disabled');
        } else {
            $('#setor').removeAttr('disabled');
        }
        $('#status_bayar').val(status_bayar);
    })
    $('#tgl_janji_next').inputmask("datetime", {
        inputFormat: "dd/mm/yyyy",
        oncomplete: function () {
            var x = new Date();
            var today = x.getDate() + "/" + parseInt(x.getMonth() + 1) + "/" + x.getFullYear();
            var x = new Date(
                x.getFullYear() + "/" + parseInt(x.getMonth() + 1) + "/" + x.getDate()
            );
            var input = $(this).val();
            var i = input.split("/");
            var y = new Date(i[2] + "/" + i[1] + "/" + i[0]);
            if (y > x) {} else {
                $(this).val('');
                AndroidFunction.showToast('Tanggal harus > ' + today + '.');
            }
        }
    });
});
</script>
