<?php
//$_SESSION['id_karyawan']=1;
$id_karyawan=$_SESSION['id_karyawan'];
$id_pelanggan=$_GET['id_pelanggan'];
if (isset($tambah_setoran_post)){
	_direct("?page=collector&mode=tagihan_3&id_jual=" .$id_jual. "&id_p_detail=" .$id_penagihan_detail. "&jenis=" .$jenis);
}
if (isset($_GET['del'])){
	$sql = mysqli_query($con, "UPDATE penagihan_detail SET bayar=null,setor=null,status_bayar=3,tgl_janji_next=null,tgl_bayar=null WHERE id_penagihan_detail=" .$_GET['del']);
	if ($sql){
		_alert("Input Berhasil.");
	} else {
		_alert("Input Gagal.");
	}
	$sql = mysqli_query($con, "DELETE FROM penagihan_retur_detail WHERE id_penagihan_detail=" .$_GET['del']);
	_direct("?page=collector&mode=tagihan_2&id_pelanggan=" .$id_pelanggan);
}
?>
<div class="right_col loading" role="main">
	<div class="">
	
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<h3>TAGIHAN DEBT COLLECTOR</h3>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<div class="table-responsive">
							<table class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>Tgl Nota Jual</th>
										<th>No Nota Jual</th>
										<th>Nama Sales</th>
										<th>Nama Pelanggan</th>
										<th>Jumlah Jual (Rp)</th>
										<th>Sisa Piutang (Rp)</th>
										<th>Tgl Jatuh Tempo</th>
										<th>Jumlah Bayar</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
								<?php
								$sql=mysqli_query($con, "SELECT *,SUM(bayar) AS bayar
FROM
    penagihan
    INNER JOIN penagihan_detail 
        ON (penagihan.id_penagihan = penagihan_detail.id_penagihan)
	INNER JOIN jual 
        ON (penagihan_detail.id_jual = jual.id_jual)
    INNER JOIN pelanggan 
        ON (jual.id_pelanggan = pelanggan.id_pelanggan)
WHERE penagihan.id_karyawan=$id_karyawan AND pelanggan.id_pelanggan='$id_pelanggan'
GROUP BY jual.id_jual");
while ($row=mysqli_fetch_array($sql)){
$total_jual=0;
if ($row['status_konfirm']>=5){
	$sql2=mysqli_query($con, "SELECT jual.id_jual,invoice,tgl_nota,tenor,nama_karyawan,nama_pelanggan, SUM(qty_ambil*(harga-diskon_rp-diskon_rp_2-diskon_rp_3)) AS total
FROM
    jual
    INNER JOIN jual_detail 
        ON (jual.id_jual = jual_detail.id_jual)
	INNER JOIN pelanggan 
        ON (jual.id_pelanggan = pelanggan.id_pelanggan)
    INNER JOIN karyawan 
        ON (jual.id_karyawan = karyawan.id_karyawan)
    INNER JOIN canvass_siap_kirim_detail 
        ON (jual_detail.id_jual_detail = canvass_siap_kirim_detail.id_jual_detail)
WHERE jual.id_jual=" .$row['id_jual']);
		while ($row2=mysqli_fetch_array($sql2)){
			$total_jual+=$row2['total'];
			$id_jual=$row2['id_jual'];
			$tgl_nota=$row2['tgl_nota'];
			$tenor=$row2['tenor'];
			$invoice=$row2['invoice'];
			$nama_sales=$row2['nama_karyawan'];
			$nama_pelanggan=$row2['nama_pelanggan'];
		}
} else {
	$sql2=mysqli_query($con, "SELECT jual.id_jual,invoice,tgl_nota,tenor,nama_karyawan,nama_pelanggan, SUM(qty_ambil*(harga-diskon_rp-diskon_rp_2-diskon_rp_3)) AS total
FROM
    jual
    INNER JOIN jual_detail 
        ON (jual.id_jual = jual_detail.id_jual)
	INNER JOIN pelanggan 
        ON (jual.id_pelanggan = pelanggan.id_pelanggan)
    INNER JOIN karyawan 
        ON (jual.id_karyawan = karyawan.id_karyawan)
    INNER JOIN nota_siap_kirim_detail 
        ON (jual_detail.id_jual_detail = nota_siap_kirim_detail.id_jual_detail)
WHERE jual.id_jual=" .$row['id_jual']);
		while ($row2=mysqli_fetch_array($sql2)){
			$total_jual+=$row2['total'];
			$id_jual=$row2['id_jual'];
			$tgl_nota=$row2['tgl_nota'];
			$tenor=$row2['tenor'];
			$invoice=$row2['invoice'];
			$nama_sales=$row2['nama_karyawan'];
			$nama_pelanggan=$row2['nama_pelanggan'];
		}
}
	$sql2=mysqli_query($con, "SELECT SUM(bayar) AS total_bayar FROM penagihan_detail WHERE id_penagihan=" .$row['id_penagihan']. " AND id_jual=$id_jual");
	$row2=mysqli_fetch_array($sql2);
	$total_bayar=$row2['total_bayar'];
	
	$sql2=mysqli_query($con, "SELECT SUM(jumlah_retur) AS jumlah_bayar
FROM
    penagihan_detail
    INNER JOIN penagihan_retur_detail 
        ON (penagihan_detail.id_penagihan_detail = penagihan_retur_detail.id_penagihan_detail)
WHERE id_penagihan=" .$row['id_penagihan']. " AND id_jual=" .$row['id_jual']);
$row2=mysqli_fetch_array($sql2);
$total_bayar+=$row2['jumlah_bayar'];
	
	$sql2=mysqli_query($con, "SELECT SUM(jumlah) AS jumlah_bayar
FROM
    bayar_nota_jual
    INNER JOIN jual 
        ON (bayar_nota_jual.no_nota_jual = jual.invoice)
WHERE jual.id_jual=" .$row['id_jual']);
$row2=mysqli_fetch_array($sql2);
$jumlah_bayar=$row2['jumlah_bayar'];

$sql2=mysqli_query($con, "SELECT SUM(bayar) AS jumlah_bayar
FROM
    penagihan_detail
    INNER JOIN jual 
        ON (penagihan_detail.id_jual = jual.id_jual)
WHERE jual.id_jual=" .$row['id_jual']);
$row2=mysqli_fetch_array($sql2);
$jumlah_bayar+=$row2['jumlah_bayar'];

$sql2=mysqli_query($con, "SELECT SUM(jumlah_retur) AS jumlah_bayar
FROM
    penagihan_detail
    INNER JOIN penagihan_retur_detail 
        ON (penagihan_detail.id_penagihan_detail = penagihan_retur_detail.id_penagihan_detail)
WHERE id_jual=" .$row['id_jual']);
$row2=mysqli_fetch_array($sql2);
$jumlah_bayar+=$row2['jumlah_bayar'];

$sisa_piutang=$total_jual-$jumlah_bayar;
if ($sisa_piutang==0) continue;
		$tgl_jt_tempo=date('Y-m-d', strtotime($tgl_nota. ' + ' .$tenor. ' days'));;
	echo '								<tr>
											<td>' .date('d-m-Y',strtotime($tgl_nota)). '</td>
											<td>' .$invoice. '</td>
											<td>' .$nama_sales. '</td>
											<td>' .$nama_pelanggan. '</td>
											<td>' .format_uang($total_jual). '</td>
											<td>' .format_uang($sisa_piutang). '</td>
											<td>' .date('d-m-Y',strtotime($tgl_jt_tempo)). '</td>
											<td>' .format_uang($total_bayar). '</td>';
	if ($total_bayar==0){
		echo '								<td><a data-toggle="modal" data-target="#myModal" data-id-penagihan-detail="' .$row['id_penagihan_detail']. '" data-id-jual="' .$id_jual. '" data-invoice="' .$invoice. '" data-jumlah-jual="' .$total_jual. '" data-total-bayar="' .$total_bayar. '" class="btn btn-xs btn-warning"><i class="fa fa-check"></i> Tagih</a></td>';
	} else {
		echo '								<td><a href="?page=collector&mode=tagihan_2&id_pelanggan=' .$id_pelanggan. '&del=' .$row['id_penagihan_detail']. '&id=' .$row['id_jual']. '" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Hapus</a></td>';
	}
	echo '								</tr>';
}
										
									?>
									</tbody>
								</table>
							</div>
							
						<div id="dummy" style="display:none"></div>
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
				<h4 class="modal-title">Metode Bayar</h4>
			</div>
			<div class="modal-body">				
				<form action="" method="post">
					<input type="hidden" name="tambah_setoran_post" value="true">
					<input type="hidden" id="id_jual" name="id_jual" value="">
					<input type="hidden" id="invoice" value="">
					<input type="hidden" id="id_penagihan_detail" name="id_penagihan_detail" value="">
					<input type="hidden" id="total_bayar" name="total_bayar" value="">
					<div class="col-xs-6">
						<input id="1" type="radio" name="jenis" value="Transfer" required> <label for="1"><font size="5px">Transfer</font></label><br>
						<input id="2" type="radio" name="jenis" value="Tunai"> <label for="2"><font size="5px">Tunai</font></label><br>
					</div>
					<div class="col-xs-6">
						<input id="3" type="radio" name="jenis" value="Retur"> <label for="3"><font size="5px">Retur</font></label><br>
						<input id="4" type="radio" name="jenis" value="Giro"> <label for="4"><font size="5px">Giro</font></label><br>
					</div>
			</div>
			<div class="modal-footer">
				<input id="simpan" type="submit" class="btn btn-primary" value="Lanjutkan" style="display:none">
			</div>
				</form>
		</div>
	</div>
</div>

<script>
function getBack(){
	if ($('#myModal').is(':visible')){
		$('#myModal').modal('hide');
	} else {
		window.location="?page=collector&mode=home";
	}
}
function batal_scan(){
	getBack();
}
function cek_scan_nota(barcode){
	var invoice = $('#invoice').val();
	if (invoice == barcode){
		
	} else {
		$('#myModal').modal('hide');
		AndroidFunction.showToast('Barcode Nota salah.');
	}
}
$(document).ready(function(){
	$('#scan_nota').hide();
	$('#jumlah_jual').inputmask('decimal', {allowMinus: false, autoGroup: true, groupSeparator: '.', rightAlign: false, removeMaskOnSubmit: true});
	$('#bayar').inputmask('decimal', {allowMinus: false, autoGroup: true, groupSeparator: '.', rightAlign: false, removeMaskOnSubmit: true});
	$('#myModal').on('show.bs.modal', function(e){
		var id_penagihan_detail = $(e.relatedTarget).data('id-penagihan-detail');
		var id_jual = $(e.relatedTarget).data('id-jual');
		var invoice = $(e.relatedTarget).data('invoice');
		var jumlah_jual = $(e.relatedTarget).data('jumlah-jual');
		var total_bayar = $(e.relatedTarget).data('total-bayar');
		$('#id_penagihan_detail').val(id_penagihan_detail);
		$('#id_jual').val(id_jual);
		$('#invoice').val(invoice);
		$('#jumlah_jual').val(jumlah_jual);
		$('#total_bayar').val(total_bayar);
	});
	$("input[name='jenis']").change(function(){
		$('#simpan').click();
	});
})
</script>