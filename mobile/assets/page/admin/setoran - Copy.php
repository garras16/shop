<?php
if (isset($edit_setoran_post)){
	$sql = mysql_query("SELECT status_bayar FROM penagihan_detail WHERE id_penagihan_detail=$id_penagihan_detail");
	$row=mysql_fetch_array($sql);
	($row['status_bayar']==2 ? $status_nota=2 : $status_nota=1);
	$sql = mysql_query("UPDATE penagihan_detail SET setor=$setor,status_nota_kembali=$status_nota WHERE id_penagihan_detail=$id_penagihan_detail");
	if ($sql){
		_alert("Input Berhasil.");
	} else {
		_alert("Input Gagal.");
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
						<th>Jumlah Jual (Rp)</th>
						<th>Debt Collector</th>
						<th>Tgl Tagih</th>
						<th>Jml Tagih (Rp)</th>
						<th>Jml Bayar (Rp)</th>
						<th>Sisa Tagihan (Rp)</th>
						<th>Tgl Tagih Berikutnya</th>
						<th>Status Bayar</th>
						<th>Status Kembali Nota</th>
						<th>Setor (Rp)</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
<?php
$sql=mysql_query("SELECT *
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
while ($row=mysql_fetch_array($sql)){
	$sql2=mysql_query("SELECT (qty_ambil*(harga-diskon_rp)) AS total
FROM
    jual_detail
    INNER JOIN nota_siap_kirim_detail 
        ON (jual_detail.id_jual_detail = nota_siap_kirim_detail.id_jual_detail)
WHERE id_jual=" .$row['id_jual']);
$total_jual=0;
	while ($row2=mysql_fetch_array($sql2)){
		$total_jual+=$row2['total'];
	}
	$status='';
	if ($row['status_bayar']=='0') $status='Belum Bayar';
	if ($row['status_bayar']=='1') $status='Sedang Mengangsur';
	if ($row['status_bayar']=='2') $status='Lunas';
	if ($row['status_nota_kembali']=='0') $status_nota='Dibawa Debt Collector';
	if ($row['status_nota_kembali']=='1') $status_nota='Diterima Admin';
	if ($row['status_nota_kembali']=='2') $status_nota='Lunas';
	($row['tgl_janji_next']=='' ? $tgl_jb='' : $tgl_jb=date('d-m-Y',strtotime($row['tgl_janji_next'])));
	($row['status_nota_kembali']=='2' ? $cmd='Setor' : $cmd='Scan Nota');
	echo '<tr>
			<td align="center">' .$row['nama_pelanggan']. '</td>
			<td align="center">' .$row['invoice']. '</td>
			<td align="center">' .format_uang($total_jual). '</td>
			<td align="center">' .$row['nama_karyawan']. '</td>
			<td align="center">' .date("d-m-Y",strtotime($row['tanggal_tagih'])). '</td>
			<td align="center">' .format_uang($total_jual). '</td>
			<td align="center">' .format_uang($row['bayar']). '</td>
			<td align="center">' .format_uang($total_jual-$row['bayar']). '</td>
			<td align="center">' .$tgl_jb. '</td>
			<td align="center">' .$status. '</td>
			<td align="center">' .$status_nota. '</td>
			<td align="center">' .format_uang($row['setor']). '</td>
			<td align="center">
				<a data-toggle="modal" data-target="#myModal" data-status-nota="' .$row['status_nota_kembali']. '" data-id-penagihan-detail="' .$row['id_penagihan_detail']. '" data-invoice="' .$row['invoice']. '" data-bayar="' .$row['bayar']. '" class="btn btn-xs btn-primary"><i class="fa fa-barcode"></i> ' .$cmd. '</a>
				<a data-toggle="modal" data-target="#myModal2" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i> Input No Nota Jual</a>
			</td>
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
					<input type="hidden" id="id_penagihan_detail" name="id_penagihan_detail" value="">
					<input type="hidden" id="invoice" value="">
					<div class="text-center" style="margin-bottom:10px"><a id="scan_nota" class="btn btn-primary" onClick="AndroidFunction.scanNota();">Scan Nota</a></div>
					<div class="form-group col-sm-12">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-book fa-fw"></i> Jumlah Bayar (Rp)</span>
							<input class="form-control" id="bayar" name="bayar" placeholder="Jumlah Bayar" value="" readonly>
						</div>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-tags fa-fw"></i> Jumlah Setor (Rp)</span>
							<input class="form-control" type="tel" id="setor" name="setor" placeholder="Jumlah Setor" value="" required>
							<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
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

<!-- modal input -->
<div id="myModal2" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><div style="min-width:50px">&times;</div></button>
				<h4 class="modal-title">Input No Nota Jual</h4>
			</div>
			<div class="modal-body">
				<input type="hidden" id="bypass_scan" value="0">
				<div class="input-group">
					<span class="input-group-addon">No Nota Jual</span>
					<input class="form-control" id="invoice" placeholder="No Nota Jual" value="">
					<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
				</div>
				<div class="modal-footer">
					<a onClick="check_this()" class="btn btn-primary">Pilih</a>
				</div>
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
function check_this(){
	var inv = $('#invoice').val();
	$('#bypass_scan').val('1');
	$('#myModal').modal('show');
	$('#myModal2').modal('hide');
}
function cek_valid(){
	var jumlah_bayar = $('#bayar').inputmask('unmaskedvalue');
	var jumlah_setor = $('#setor').inputmask('unmaskedvalue');
	
	if (jumlah_setor > jumlah_bayar){
		AndroidFunction.showToast("Jumlah setor tidak boleh melebihi jumlah bayar.");
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
	$('#setor').inputmask('decimal', {allowMinus: false, autoGroup: true, groupSeparator: '.', rightAlign: false, removeMaskOnSubmit: true});
	$('#bayar').inputmask('decimal', {allowMinus: false, autoGroup: true, groupSeparator: '.', rightAlign: false, removeMaskOnSubmit: true});
	$('#myModal').on('show.bs.modal', function(e){
		var id_penagihan_detail = $(e.relatedTarget).data('id-penagihan-detail');
		var invoice = $(e.relatedTarget).data('invoice');
		var bayar = $(e.relatedTarget).data('bayar');
		var status = $(e.relatedTarget).data('status-nota');
		var bypass = $('#bypass_scan').val();
		$('#id_penagihan_detail').val(id_penagihan_detail);
		$('#invoice').val(invoice);
		$('#bayar').val(bayar);
		if (status!=2 && bypass==0) $('#scan_nota').click();
	})
	$('#myModal2').on('show.bs.modal', function(e){
		$('#invoice').val('');
		$('#bypass_scan').val('0');
	});
});
</script>