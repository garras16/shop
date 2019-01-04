<?php
$id_jual=$_GET['id_jual'];
$id_penagihan_detail=$_GET['id_p_detail'];
$jenis=$_GET['jenis'];

	$sql=mysql_query("SELECT invoice,id_pelanggan FROM jual WHERE id_jual=$id_jual");
	$b=mysql_fetch_array($sql);
	$no_nota_jual=$b['invoice'];
	$id_pelanggan=$b['id_pelanggan'];
	$sql=mysql_query("SELECT id_penagihan FROM penagihan_detail WHERE id_penagihan_detail=$id_penagihan_detail");
	$b=mysql_fetch_array($sql);
	$id_penagihan=$b['id_penagihan'];
	
	$sql2=mysql_query("SELECT jumlah FROM nota_sudah_cek WHERE (status='2' or status='3') AND id_jual=$id_jual");
	$b2=mysql_fetch_array($sql2);
	$jumlah_nota=$b2['jumlah'];

//-----------------------------------------------------------------------------------------

	$sql3=mysql_query("SELECT SUM(jumlah) AS jumlah_bayar FROM bayar_nota_jual WHERE no_nota_jual='$no_nota_jual'");
	$b3=mysql_fetch_array($sql3);
	$jumlah_bayar_x=$b3['jumlah_bayar'];
//-------------------------------------------------------------------------------------------

	$sql3=mysql_query("SELECT SUM(bayar) AS jumlah_bayar FROM penagihan_detail WHERE id_jual=$id_jual");
	$b3=mysql_fetch_array($sql3);
	$jumlah_bayar_x+=$b3['jumlah_bayar'];
//-------------------------------------------------------------------------------------------

$sisa_nota=$jumlah_nota-$jumlah_bayar_x;
if (isset($jatuh_tempo)){
	$tgl = explode("/", $jatuh_tempo);
	$jatuh_tempo = $tgl[2] ."-". $tgl[1] ."-". $tgl[0];
}
if (isset($tgl_janji_next) && $tgl_janji_next!=""){
	$tgl = explode("/", $tgl_janji_next);
	$tgl_janji_next = "'" .$tgl[2] ."-". $tgl[1] ."-". $tgl[0]. "'";
} else {
	$tgl_janji_next = 'null';
}
if (isset($tambah_bayar_tagih_nota_jual_post)){
	//0=belum bayar
	//1=terbayar sebagian
	//2=lunas
	//3=belum tagih
	
	if (isset($no_retur)){
		$no_retur[] = implode(',',$no_retur);
		$jumlah_retur[] = implode(',',$jumlah_retur);
		$jumlah_bayar_retur=0;
		
		for ($i=0;$i<count($jumlah_retur)-1;$i++) {
			$jumlah_bayar_retur+=$jumlah_retur[$i];
		}
	}

	if ($jenis !='Retur'){
		($jumlah_bayar==$sisa_nota ? $status=2 : $status=1);
		if ($jumlah_bayar==$sisa_nota) $tgl_janji_next = 'null';
		if ($jumlah_bayar=='0') $status=0;
		
		$tgl=date("Y-m-d");
		$sql=mysql_query("UPDATE penagihan_detail SET status_bayar=$status WHERE id_jual=$id_jual");
		if ($jenis =='Transfer'){
			$sql=mysql_query("UPDATE penagihan_detail SET bayar=$jumlah_bayar,tgl_bayar='$tgl',tgl_janji_next=$tgl_janji_next,pengirim_bank='$pengirim_nama_bank',pengirim_nama='$pengirim_nama_rekening',pengirim_no='$pengirim_no_rekening',penerima_bank='$penerima_nama_bank',penerima_nama='$penerima_nama_rekening',penerima_no='$penerima_no_rekening',keterangan='$keterangan',jenis='$jenis' WHERE id_penagihan_detail=$id_penagihan_detail");
		} else if ($jenis =='Giro'){
			$sql=mysql_query("UPDATE penagihan_detail SET bayar=$jumlah_bayar,tgl_bayar='$tgl',tgl_janji_next=$tgl_janji_next,pengirim_bank='$pengirim_nama_bank',pengirim_nama='$pengirim_nama_rekening',pengirim_no='$pengirim_no_rekening',penerima_bank='$penerima_nama_bank',penerima_nama='$penerima_nama_rekening',penerima_no='$penerima_no_rekening',keterangan='$keterangan',jatuh_tempo='$jatuh_tempo',jenis='$jenis' WHERE id_penagihan_detail=$id_penagihan_detail");
		} else if ($jenis =='Tunai'){
			$sql=mysql_query("UPDATE penagihan_detail SET bayar=$jumlah_bayar,tgl_bayar='$tgl',tgl_janji_next=$tgl_janji_next,keterangan='$keterangan',jenis='$jenis' WHERE id_penagihan_detail=$id_penagihan_detail");
		}
		if ($sql){
			_buat_pesan("Input Berhasil","green");
		} else {
			_buat_pesan("Input Gagal","red");
		}
	}
	
	if (isset($no_retur)){
		$tgl=date("Y-m-d");
		($jumlah_bayar+$jumlah_bayar_retur==$sisa_nota ? $status=1 : $status=2);
		if ($jumlah_bayar+$jumlah_bayar_retur=='0') $status=0;
		$sql=mysql_query("UPDATE penagihan SET status=$status WHERE id_jual=$id_jual");
		if ($jenis =='Retur'){
			$sql=mysql_query("UPDATE penagihan_detail SET tgl_bayar='$tgl',tgl_janji_next=$tgl_janji_next,keterangan='$keterangan',jenis='$jenis' WHERE id_penagihan_detail=$id_penagihan_detail");
		}
		for ($i=0;$i<count($no_retur)-1;$i++) {
			$sql=mysql_query("INSERT INTO penagihan_retur_detail VALUES(null,$id_penagihan_detail,'$no_retur[$i]',$jumlah_bayar_retur,0)");
			if ($sql){
				_buat_pesan("Input Berhasil","green");
			} else {
				_buat_pesan("Input Gagal","red");
			}
		}
	}
	_direct("?page=collector&mode=tagihan_2&id_pelanggan=" .$id_pelanggan);
	
}
$sql=mysql_query("SELECT *, SUM((harga-diskon_rp-diskon_rp_2-diskon_rp_3)*nota_siap_kirim_detail.qty_ambil) AS total1, SUM((harga-diskon_rp-diskon_rp_2-diskon_rp_3)*canvass_siap_kirim_detail.qty_ambil) AS total2
FROM
    jual
    INNER JOIN jual_detail 
        ON (jual.id_jual = jual_detail.id_jual)
	LEFT JOIN nota_siap_kirim_detail 
        ON (jual_detail.id_jual_detail = nota_siap_kirim_detail.id_jual_detail)
	LEFT JOIN canvass_siap_kirim_detail 
        ON (jual_detail.id_jual_detail = canvass_siap_kirim_detail.id_jual_detail)
    INNER JOIN pelanggan 
        ON (jual.id_pelanggan = pelanggan.id_pelanggan)
WHERE jual.invoice='$no_nota_jual'");
$row=mysql_fetch_array($sql);
$id_pelanggan=$row['id_pelanggan'];
$id_jual=$row['id_jual'];
($row['total2']>0 ? $total_piutang=$row['total2'] : $total_piutang=$row['total1']);
?>
<!-- page content -->
<div class="right_col" role="main">
	<div class="">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<h3>PEMBAYARAN TAGIHAN</h3>
						<?php
							if (isset($pesan)){
								echo '<span class="badge bg-' .$warna. '">' .$pesan. '</span><br/><br/>';
							}
							if ($jumlah_nota==0) echo '<span class="badge bg-red">Barang Belum Dikirim</span><br/><br/>';
						?>
					<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<p><a href="?page=collector&mode=tagihan_2&id_pelanggan=<?php echo $id_pelanggan ?>" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Kembali</a></p>
						<form action="" method="post" onsubmit="return valid2();">
						<input type="hidden" name="tambah_bayar_tagih_nota_jual_post" value="true">
						<div class="col-xs-12">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-building fa-fw"></i></span>
								<input class="form-control" value="<?php echo $row['nama_pelanggan']; ?>" title="Nama Pelanggan" readonly>
							</div>
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
								<input class="form-control" value="<?php echo date("d-m-Y", strtotime($row['tgl_nota'])); ?>" title="Tanggal Nota Jual" readonly>
							</div>
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-file fa-fw"></i></span>
								<input class="form-control" name="no_nota_jual" value="<?php echo $no_nota_jual ?>" title="No Nota Jual" readonly>
							</div>
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-money fa-fw"></i> Total Piutang</span>
								<input class="form-control" id="total_nota" value="<?php echo $total_piutang ?>" title="Total Nota Jual (Rp)" readonly>
							</div>
							
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-credit-card fa-fw"></i> Sisa Piutang</span>
								<input class="form-control" id="sisa_nota" name="sisa_nota" value="<?php echo $sisa_nota ?>" title="Sisa Nota (Rp)" readonly>
							</div>
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-info fa-fw"></i></span>
								<input class="form-control" id="jenis" name="jenis" value="<?php echo $jenis ?>" title="Jenis" readonly>
							</div>
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-money fa-fw"></i></span>
<?php
if ($jenis=='Retur'){
	echo '						<input class="form-control" id="jumlah_bayar" name="jumlah_bayar" value="0" placeHolder="Jumlah Bayar (Rp)" readonly>';
} else {
	echo '						<input type="tel" class="form-control" id="jumlah_bayar" name="jumlah_bayar" value=""  autofocus placeHolder="Jumlah Bayar (Rp)" required>
								<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>';
}
?>
							</div>
						</div>
						
						<?php
if ($jenis=='Transfer' || $jenis=='Giro'){
	echo '<div class="col-xs-12">
			Pengirim :<br>
			<div class="input-group">
			<span class="input-group-addon"><i class="fa fa-building fa-fw"></i></span>
			<input class="form-control" id="sisa_nota" name="pengirim_nama_bank" value="" placeHolder="Nama Bank" title="Nama Bank" maxlength="50" autocomplete="off" required>
			<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
			</div>
			<div class="input-group">
			<span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
			<input class="form-control" id="sisa_nota" name="pengirim_nama_rekening" value="" placeHolder="Nama Rekening" title="Nama Rekening" autocomplete="off" maxlength="100" required>
			<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
			</div>
			<div class="input-group">
			<span class="input-group-addon"><i class="fa fa-tag fa-fw"></i></span>
			<input class="form-control" type="number" id="sisa_nota" name="pengirim_no_rekening" value="" placeHolder="No Rekening" title="No Rekening" maxlength="20" autocomplete="off" required>
			<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
			</div>
		</div>';
		echo '<div class="col-xs-12">
			Penerima :<br>
			<div class="input-group">
			<span class="input-group-addon"><i class="fa fa-building fa-fw"></i></span>
			<input class="form-control" id="sisa_nota" name="penerima_nama_bank" value="" placeHolder="Nama Bank" title="Nama Bank" maxlength="50" autocomplete="off" required>
			<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
			</div>
			<div class="input-group">
			<span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
			<input class="form-control" id="sisa_nota" name="penerima_nama_rekening" value="" placeHolder="Nama Rekening" title="Nama Rekening" maxlength="100" autocomplete="off" required>
			<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
			</div>
			<div class="input-group">
			<span class="input-group-addon"><i class="fa fa-tag fa-fw"></i></span>
			<input class="form-control" type="number" id="sisa_nota" name="penerima_no_rekening" value="" placeHolder="No Rekening" title="No Rekening" maxlength="20" autocomplete="off" required>
			<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
			</div>
		</div>';
}
echo '<div class="col-xs-12">
			<div class="input-group">
			<span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
			<input class="form-control" id="tgl_janji_next" name="tgl_janji_next" value="" placeHolder="Tanggal Kunjungan Berikutnya" title="Tanggal Janji Berikutnya">
			</div>
		</div>';
if ($jenis=='Giro'){
		echo '<div class="col-xs-12">
			Giro :
			<div class="input-group">
			<span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
			<input class="form-control" id="jatuh_tempo" name="jatuh_tempo" value="" placeHolder="Tanggal Jatuh Tempo" title="Tanggal Jatuh Tempo" required>
			<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
			</div>
		</div>';
}
echo '<div class="col-xs-12">
			&nbsp;
			<div class="input-group">
			<span class="input-group-addon"><i class="fa fa-file fa-fw"></i></span>
			<input class="form-control" id="keterangan" name="keterangan" value="" placeHolder="Keterangan" maxlength="100">
			</div>
		</div>';
?>
						<div class="clearfix"></div>
						<div>
							<h4><b>NOTA RETUR JUAL</b></h4>
							<div class="clearfix"></div><br/>
							<div id="retur_content" class="col-xs-12">
								<div class="col-xs-6 bg-blue">
									<h5>No Retur Jual</h5>
								</div>
								<div class="col-xs-6 bg-blue">
									<h5>Jumlah Retur (Rp)</h5>
								</div>
							</div>
							<div class="clearfix"></div><br/>
<?php
$sql=mysql_query("SELECT
    retur_jual.id_retur_jual
    , retur_jual.no_retur_jual
FROM
    retur_jual
    INNER JOIN jual 
        ON (retur_jual.id_jual = jual.id_jual)
WHERE status=1 AND id_pelanggan=$id_pelanggan AND no_retur_jual NOT IN (SELECT no_retur_jual FROM bayar_nota_jual_detail)");
$c=0;
	while($b=mysql_fetch_array($sql)){
		$tmp_id_retur=$b['id_retur_jual'];
		$sql2=mysql_query("SELECT SUM(qty_masuk * harga_retur) AS jumlah FROM retur_jual_detail WHERE id_retur_jual=$tmp_id_retur");
		$b2=mysql_fetch_array($sql2);
		if ($b2['jumlah']!=''){
			$c+=1;
		}			
	}
	($c>0 ? $style="" : $style="display:none")
?>
							<div class="col-xs-12 text-right">
								<a id="tambah" class="btn btn-primary" data-toggle="modal" data-target="#myModal" style="<?php echo $style ?>"><i class="fa fa-plus"></i> Tambah Nota Retur</a>
							</div>
							<div class="clearfix"></div><br/>
							<div class="col-xs-12">
								<div class="col-xs-6 bg-blue">
									<h5>Total Retur (Rp)</h5>
								</div>
								<div class="col-xs-6 bg-blue">
									<input class="form-control" style="width:100%" id="tot_retur" value="0" readonly>
								</div>
							</div>
						</div>
						
						<div class="clearfix"></div><br/>
						<p align="center"><button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button></p>
						</form>
						
						
						
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
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><div style="min-width:50px">&times;</div></button>
				<h4 class="modal-title">Tambah Pembayaran Nota Jual</h4>
			</div>
			<div class="modal-body">				
				<input type="hidden" id="jumlah_bayar" name="jumlah_bayar" value="">
				<div id="content" class="col-md-12">
				
				</div>
				<div class="modal-footer">
					<a onClick="saveThis()" class="btn btn-primary">Simpan</a>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
var rb = '';
var jumlah_retur = 0;
function valid(){
	var test = $('.retur').html();
	var test2 = $('#retur_content').html();
	if (typeof test2 === "undefined") {
		return true;
	} else {
		if (typeof test === "undefined"){
			AndroidFunction.showToast('Nota Retur Jual masih kosong');
			return false;
		} else {
			return true;
		}
	}
}

function getBack(){
	window.location="?page=collector&mode=tagihan_2&id_pelanggan=<?php echo $id_pelanggan ?>";
}
function valid2(){
	var total_nota = parseFloat($('#total_nota').val());
	var sisa_nota = parseFloat($('#sisa_nota').val());
	var jumlah_bayar = parseFloat($('#jumlah_bayar').val());
	var tgl_janji = $('#tgl_janji_next').val();
	var sisa_piutang = sisa_nota-jumlah_bayar-jumlah_retur;
	var opsi = 0;
	
	if ($('#jenis').val()!='Retur'){
		if ((jumlah_bayar+jumlah_retur <= sisa_nota && jumlah_bayar>0) && (sisa_piutang>0 && tgl_janji.length==10) || (sisa_piutang==0 && tgl_janji.length==0)) {
			opsi=1;
		} else {
			opsi=0;
		}
		
			if (sisa_piutang>0 && tgl_janji.length<10) {
				AndroidFunction.showToast('Tanggal kunjungan berikutnya harus diisi.');
			} else if (sisa_piutang==0 && tgl_janji.length>0) {
				AndroidFunction.showToast('Tanggal kunjungan berikutnya harus kosong.');
				$('#tgl_janji_next').val('');
			} else if (jumlah_bayar==0) {
				AndroidFunction.showToast('Jumlah bayar harus > 0');
			} else if (jumlah_bayar+jumlah_retur > sisa_nota) {
				opsi=0;
				AndroidFunction.showToast('Jumlah bayar tidak boleh melebihi sisa piutang');
			}
		
	} else {
		if ((jumlah_bayar+jumlah_retur <= sisa_nota) && (sisa_piutang>0 && tgl_janji.length==10) || (sisa_piutang==0 && tgl_janji.length==0)){
			opsi=1;
		} else {
			opsi=0;
		}
			if (sisa_piutang>0 && tgl_janji.length<10) {
				AndroidFunction.showToast('Tanggal kunjungan berikutnya harus diisi.');
			} else if (sisa_piutang==0 && tgl_janji.length>0) {
				AndroidFunction.showToast('Tanggal kunjungan berikutnya harus kosong.');
				$('#tgl_janji_next').val('');
			} else if (jumlah_bayar+jumlah_retur > sisa_nota) {
				opsi=0;
				AndroidFunction.showToast('Jumlah bayar tidak boleh melebihi sisa piutang');
			}
			
	}
	
	if (opsi==0) {
		return false;
	} else {
		return true;
	}
}
function saveThis(){
	var no_retur = $('#select_retur').val();
	var jumlah = $('#select_retur').find(':selected').data('jumlah');
	if (jumlah=='') jumlah=0;
	$('#retur_content').append('<div class="col-xs-6 retur"><input class="form-control" style="width:100%" name="no_retur[]" value="' + no_retur + '" readonly></div><div class="col-xs-6"><input class="form-control selretur" style="width:100%" name="jumlah_retur[]" value="' + jumlah + '" readonly></div>');
	rb+=no_retur + ',';
	jumlah_retur+=jumlah;
	$('#tot_retur').val(jumlah_retur);
	$('.selretur').inputmask('decimal', {allowMinus:false, autoGroup: true, groupSeparator: '.', rightAlign: false, autoUnmask: true, removeMaskOnSubmit: true});
	$('#myModal').modal('hide');
}
$(document).ready(function(){
	$('#jumlah_bayar').inputmask('decimal', {allowMinus:false, autoGroup: true, groupSeparator: '.', rightAlign: false, autoUnmask: true, removeMaskOnSubmit: true});
	$('#total_nota').inputmask('decimal', {allowMinus:false, autoGroup: true, groupSeparator: '.', rightAlign: false, autoUnmask: true, removeMaskOnSubmit: true});
	$('#sisa_nota').inputmask('decimal', {allowMinus:false, autoGroup: true, groupSeparator: '.', rightAlign: false, autoUnmask: true, removeMaskOnSubmit: true});
	$('#myModal').on('show.bs.modal', function(e){
		$('#content').load('assets/page/collector/get-retur.php?id_pelanggan=' + <?php echo $id_pelanggan ?> + '&id=' + rb);
		$('#tot_retur').inputmask('decimal', {allowMinus:false, autoGroup: true, groupSeparator: '.', rightAlign: false, autoUnmask: true, removeMaskOnSubmit: true});
	});
	$('#jatuh_tempo').inputmask("datetime",{inputFormat: "dd/mm/yyyy",oncomplete: function(){
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
	$('#tgl_janji_next').inputmask("datetime",{inputFormat: "dd/mm/yyyy",oncomplete: function(){
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
	AndroidFunction.setOrientasi(1);
});
</script>
