<?php
$id_karyawan=1;//$_SESSION['id_karyawan'];
$id_pelanggan=$_GET['id_pelanggan'];
if (isset($tambah_setoran_post)){
	//0=belum bayar
	//1=terbayar sebagian
	//2=lunas
	if ($bayar>0) $status_bayar=1;
	if (($total_bayar+$bayar)==0) $status_bayar=0;
	if (($total_bayar+$bayar)==$jumlah_jual) $status_bayar=2;
	
	($status_bayar==2 ? $status_nota=2 : $status_nota=0 );
	if ($status_bayar==2) {
		$sql = mysqli_query($con, "UPDATE penagihan_detail SET bayar=$bayar,status_bayar=$status_bayar,status_nota_kembali=$status_nota,tgl_janji_next=null WHERE id_penagihan_detail=$id_penagihan_detail");
	} else {
		$tgl = explode("/", $tgl_janji_next);
		$tgl_janji_next = $tgl[2] ."-". $tgl[1] ."-". $tgl[0];
		$sql = mysqli_query($con, "UPDATE penagihan_detail SET bayar=$bayar,status_bayar=$status_bayar,status_nota_kembali=$status_nota,tgl_janji_next='$tgl_janji_next' WHERE id_penagihan_detail=$id_penagihan_detail");
	}
	
	if ($sql){
		_alert("Input Berhasil.");
	} else {
		_alert("Input Gagal.");
	}
	_direct("?page=collector&mode=tagihan_2&id_pelanggan=" .$id_pelanggan);
}
if (isset($_GET['del'])){
	$sql = mysqli_query($con, "UPDATE penagihan_detail SET bayar=0,setor=null,status_bayar=0,tgl_janji_next=null WHERE id_penagihan=" .$_GET['del']. " AND id_jual=" .$_GET['id']);
	if ($sql){
		_alert("Input Berhasil.");
	} else {
		_alert("Input Gagal.");
	}
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

	$sql2=mysqli_query($con, "SELECT jual.id_jual,invoice,tgl_nota,tenor,nama_karyawan,nama_pelanggan, SUM(qty_ambil*(harga-diskon_rp)) AS total
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
$total_jual=0;
		while ($row2=mysqli_fetch_array($sql2)){
			$total_jual+=$row2['total'];
			$id_jual=$row2['id_jual'];
			$tgl_nota=$row2['tgl_nota'];
			$tenor=$row2['tenor'];
			$invoice=$row2['invoice'];
			$nama_sales=$row2['nama_karyawan'];
			$nama_pelanggan=$row2['nama_pelanggan'];
		}
	$sql2=mysqli_query($con, "SELECT SUM(bayar) AS total_bayar FROM penagihan_detail WHERE id_penagihan=" .$row['id_penagihan']. " AND id_jual=$id_jual");
	$row2=mysqli_fetch_array($sql2);
	$total_bayar=$row2['total_bayar'];
/*	$sql2=mysqli_query($con, "SELECT *
FROM
    penagihan
    INNER JOIN penagihan_detail 
        ON (penagihan.id_penagihan = penagihan_detail.id_penagihan)
WHERE id_karyawan=$id_karyawan
GROUP BY id_jual");
	$row=mysqli_fetch_array($sql2);*/
		$tgl_jt_tempo=date('Y-m-d', strtotime($tgl_nota. ' + ' .$tenor. ' days'));;
	echo '								<tr>
											<td>' .date('d-m-Y',strtotime($tgl_nota)). '</td>
											<td>' .$invoice. '</td>
											<td>' .$nama_sales. '</td>
											<td>' .$nama_pelanggan. '</td>
											<td>' .format_uang($total_jual). '</td>
											<td>' .date('d-m-Y',strtotime($tgl_jt_tempo)). '</td>
											<td>' .format_uang($total_bayar). '</td>';
	if ($total_bayar==0){
		echo '								<td><a data-toggle="modal" data-target="#myModal" data-id-penagihan-detail="' .$row['id_penagihan_detail']. '" data-id-jual="' .$id_jual. '" data-invoice="' .$invoice. '" data-jumlah-jual="' .$total_jual. '" data-total-bayar="' .$total_bayar. '" class="btn btn-xs btn-warning"><i class="fa fa-barcode"></i> Scan Nota</a></td>';
	} else {
		echo '								<td><a href="?page=collector&mode=tagihan_2&id_pelanggan=' .$id_pelanggan. '&del=' .$row['id_penagihan']. '&id=' .$row['id_jual']. '" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Hapus</a></td>';
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
				<h4 class="modal-title">Pembayaran</h4>
			</div>
			<div class="modal-body">				
				<form action="" method="post" onsubmit="return cek_valid();">
					<input type="hidden" name="tambah_setoran_post" value="true">
					<input type="hidden" id="id_jual" name="id_jual" value="">
					<input type="hidden" id="invoice" value="">
					<input type="hidden" id="id_penagihan_detail" name="id_penagihan_detail" value="">
					<input type="hidden" id="total_bayar" name="total_bayar" value="">
					<div class="text-center" style="margin-bottom:10px"><a id="scan_nota" class="btn btn-primary" onClick="AndroidFunction.scanNota();">Scan Nota</a></div>
					<div class="form-group col-sm-12">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-money fa-fw"></i></span>
							<select id="jenis" name="jenis" class="select2 form-control" required="true">
								<option value="" disabled selected>-= Pilih Jenis Bayar =-</option>
								<option value="Transfer">Transfer</option>
								<option value="Tunai">Tunai</option>
								<option value="Retur">Hanya Retur</option>
								<option value="Giro">Cek / Giro</option>
							</select>
							<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
						</div>
						<div class="input-group">
							<span class="input-group-addon">Jumlah Jual (Rp)</span>
							<input class="form-control" id="jumlah_jual" name="jumlah_jual" placeholder="Jumlah Jual" value="" readonly>
						</div>
						<div class="input-group">
							<span class="input-group-addon">Jumlah Bayar (Rp)</span>
							<input class="form-control" type="tel" id="bayar" name="bayar" placeholder="Jumlah Bayar" value="" required>
							<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
						</div>
						<div class="input-group">
							<span class="input-group-addon">Tanggal Janji Berikutnya</span>
							<input class="form-control" id="janji" type="tel" name="janji" placeholder="Tgl Janji Berikutnya" value="">
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
function getBack(){
	if ($('#myModal').is(':visible')){
		$('#myModal').modal('hide');
	} else {
		AndroidFunction.closeApp();
	}
}
function batal_scan(){
	getBack();
}
function cek_valid(){
	var total_bayar = $('#total_bayar').inputmask('unmaskedvalue');
	var jumlah_bayar = $('#bayar').inputmask('unmaskedvalue');
	var jumlah_jual = $('#jumlah_jual').inputmask('unmaskedvalue');
	var janji = $('#janji').val();
	var x = new Date();
		var today = x.getDate() + "/" + parseInt(x.getMonth()+1) + "/" + x.getFullYear();
		var x = new Date(x.getFullYear() + "/" + parseInt(x.getMonth()+1) + "/" + x.getDate());
		var i = janji.split("/");	
		var y = new Date(i[2] + "/" + i[1] + "/" + i[0]);
		if (y >= x){
		} else {
			janji='';
		}
	var bayar=Number(total_bayar)+Number(jumlah_bayar);
	
	if (((total_bayar+jumlah_bayar) == 0) && (janji == '')){
		AndroidFunction.showToast("Jika jumlah bayar 0, maka harus mengisi tanggal janji berikutnya");
		return false;
	} else if ((bayar < jumlah_jual) && (janji == '')){
		AndroidFunction.showToast("Jika belum lunas, maka harus mengisi tanggal janji berikutnya");
		return false;
	} else if (bayar > jumlah_jual){
		AndroidFunction.showToast("Jumlah Bayar lebih besar dari jumlah jual");
		return false;
	} else {
		return true;
	}
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
		$('#scan_nota').click();
	})
	$('#janji').inputmask("datetime",{inputFormat: "dd/mm/yyyy",oncomplete: function(){
		var x = new Date();
		var today = x.getDate() + "/" + parseInt(x.getMonth()+1) + "/" + x.getFullYear();
		var x = new Date(x.getFullYear() + "/" + parseInt(x.getMonth()+1) + "/" + x.getDate());
		var input = $(this).val();
		var i = input.split("/");	
		var y = new Date(i[2] + "/" + i[1] + "/" + i[0]);
		if (y > x){
			
		} else {
			$(this).val('');
			AndroidFunction.showToast('Tanggal harus > ' + today + '.');
		}
	}});
})
</script>