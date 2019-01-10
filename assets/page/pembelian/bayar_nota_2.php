<?php
$no_nota_beli=$_GET['no_nota_beli'];
$jenis=$_GET['jenis'];
$sql=mysqli_query($con, "SELECT id_beli FROM beli WHERE no_nota_beli='$no_nota_beli'");
$row=mysqli_fetch_array($sql);
$id_beli=$row['id_beli'];

/*UNTUK BAYAR KE EKSPEDISI BERDSRKAN QTY DATANG
$sql2=mysqli_query($con, "SELECT SUM(harga*barang_masuk_rak.qty_di_rak) AS jumlah_nota
		FROM
			barang_masuk
			INNER JOIN beli_detail 
				ON (barang_masuk.id_beli_detail = beli_detail.id_beli_detail)
			INNER JOIN barang_masuk_rak 
				ON (barang_masuk_rak.id_barang_masuk = barang_masuk.id_barang_masuk)
		WHERE id_beli=$id_beli");
	$b2=mysqli_fetch_array($sql2);
	$jumlah_nota=$b2['jumlah_nota'];*/

//UNTUK BAYAR KE SUPPLIER BERDSRKAN QTY BELI
$sql2=mysqli_query($con, "SELECT ppn_all_persen,SUM((harga-diskon_rp-diskon_rp_2-diskon_rp_3)*qty) AS jumlah_nota
FROM
    beli_detail
    INNER JOIN beli 
        ON (beli_detail.id_beli = beli.id_beli)
WHERE beli.id_beli=$id_beli");
	$b2=mysqli_fetch_array($sql2);
	$jumlah_nota=$b2['jumlah_nota']+($b2['ppn_all_persen']/100*$b2['jumlah_nota']);//-($s['total_datang']*$s['diskon_all_persen']/100);
//-----------------------------------------------------------------------------------------

	$sql3=mysqli_query($con, "SELECT SUM(jumlah) AS jumlah_bayar FROM bayar_nota_beli WHERE no_nota_beli='$no_nota_beli'");
	$b3=mysqli_fetch_array($sql3);
	$jumlah_bayar_x=$b3['jumlah_bayar'];
//-------------------------------------------------------------------------------------------
$sisa_nota=$jumlah_nota-$jumlah_bayar_x;

if (isset($jatuh_tempo)){
	$tgl = explode("/", $jatuh_tempo);
	$jatuh_tempo = $tgl[2] ."-". $tgl[1] ."-". $tgl[0];
}
if (isset($tambah_bayar_nota_beli_post)){
	if (isset($no_retur)){
		$no_retur[] = implode(',',$no_retur);
		$jumlah_retur[] = implode(',',$jumlah_retur);
		$jumlah_bayar_retur=0;
		for ($i=0;$i<count($jumlah_retur)-1;$i++) {
			$jumlah_bayar_retur+=$jumlah_retur[$i];
		}
	}

	if ($jenis !='Retur'){
		($jumlah_bayar==$sisa_nota ? $status=1 : $status=2);
		$sql=mysqli_query($con, "UPDATE bayar_nota_beli SET status=$status WHERE no_nota_beli='$no_nota_beli'");
		if ($jenis =='Transfer'){
			$sql=mysqli_query($con, "INSERT INTO bayar_nota_beli VALUES(null,'$tanggal','$no_nota_beli','$jenis',$jumlah_bayar,$status,'$pengirim_nama_bank','$pengirim_nama_rekening','$pengirim_no_rekening','$penerima_nama_bank','$penerima_nama_rekening','$penerima_no_rekening',null,null)");
		} else if ($jenis =='Giro'){
			$sql=mysqli_query($con, "INSERT INTO bayar_nota_beli VALUES(null,'$tanggal','$no_nota_beli','$jenis',$jumlah_bayar,$status,'$pengirim_nama_bank','$pengirim_nama_rekening','$pengirim_no_rekening','$penerima_nama_bank','$penerima_nama_rekening','$penerima_no_rekening','$jatuh_tempo','$keterangan')");
		} else {
			$sql=mysqli_query($con, "INSERT INTO bayar_nota_beli VALUES(null,'$tanggal','$no_nota_beli','$jenis',$jumlah_bayar,$status,null,null,null,null,null,null,null,null)");
		}
		if ($sql){
			_buat_pesan("Input Berhasil","green");
		} else {
			_buat_pesan("Input Gagal","red");
		}
	}
	
	if (isset($no_retur)){
		($jumlah_bayar+$jumlah_bayar_retur==$sisa_nota ? $status=1 : $status=2);
		$sql=mysqli_query($con, "UPDATE bayar_nota_beli SET status=$status WHERE no_nota_beli='$no_nota_beli'");
		if ($jenis =='Transfer'){
			$sql=mysqli_query($con, "INSERT INTO bayar_nota_beli VALUES(null,'$tanggal','$no_nota_beli','Retur',$jumlah_bayar_retur,$status,'$pengirim_nama_bank','$pengirim_nama_rekening','$pengirim_no_rekening','$penerima_nama_bank','$penerima_nama_rekening','$penerima_no_rekening',null)");
		} else if ($jenis =='Giro'){
			$sql=mysqli_query($con, "INSERT INTO bayar_nota_beli VALUES(null,'$tanggal','$no_nota_beli','Retur',$jumlah_bayar_retur,$status,'$pengirim_nama_bank','$pengirim_nama_rekening','$pengirim_no_rekening','$penerima_nama_bank','$penerima_nama_rekening','$penerima_no_rekening','$jatuh_tempo','$keterangan')");
		} else {
			$sql=mysqli_query($con, "INSERT INTO bayar_nota_beli VALUES(null,'$tanggal','$no_nota_beli','Retur',$jumlah_bayar_retur,$status,null,null,null,null,null,null,null.null)");
		}
		$last_id=mysqli_insert_id($con);
		for ($i=0;$i<count($no_retur)-1;$i++) {
			$sql=mysqli_query($con, "INSERT INTO bayar_nota_beli_detail VALUES(null,$last_id,'$no_retur[$i]')");
			if ($sql){
				_buat_pesan("Input Berhasil","green");
			} else {
				_buat_pesan("Input Gagal","red");
			}
		}
	}
	_direct("?page=pembelian&mode=bayar_nota");
	
}
$sql=mysqli_query($con, "SELECT 
	supplier.id_supplier
    , supplier.nama_supplier
    , beli.tanggal
	, beli.id_beli
    , SUM((harga*qty)-diskon_rp-diskon_rp_2-diskon_rp_3) AS total
FROM
    barang_masuk
    INNER JOIN beli_detail 
        ON (barang_masuk.id_beli_detail = beli_detail.id_beli_detail)
    INNER JOIN barang_masuk_rak 
        ON (barang_masuk_rak.id_barang_masuk = barang_masuk.id_barang_masuk)
    INNER JOIN beli 
        ON (beli_detail.id_beli = beli.id_beli)
    INNER JOIN supplier 
        ON (beli.id_supplier = supplier.id_supplier)
WHERE beli.no_nota_beli='$no_nota_beli' 
GROUP BY beli_detail.id_beli");
$row=mysqli_fetch_array($sql);
$id_supplier=$row['id_supplier'];
$id_beli=$row['id_beli'];
?>
<!-- page content -->
<div class="right_col" role="main">
	<div class="">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<h3>PEMBAYARAN NOTA BELI </h3>
						<?php
							if (isset($pesan)){
								echo '<span class="badge bg-' .$warna. '">' .$pesan. '</span><br/><br/>';
							}
						?>
					<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<form action="" method="post" onsubmit="return valid2();">
						<input type="hidden" name="tambah_bayar_nota_beli_post" value="true">
						<div class="col-md-6">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-building fa-fw" style="width: 48px;"></i><br><small>Supplier</small></span>
								<input class="form-control" style="padding: 20px 15px;" value="<?php echo $row['nama_supplier']; ?>" title="Nama Supplier" readonly>
							</div>
						</div>
						<div class="col-md-6">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-calendar fa-fw" style="width: 48px;"></i><br><small>Tgl.</small></span>
								<input class="form-control" style="padding: 20px 15px;" value="<?php echo date("d-m-Y", strtotime($row['tanggal'])); ?>" title="Tanggal Nota Beli" readonly>
							</div>
						</div>
						<div class="col-md-6">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-file fa-fw" style="width: 48px;"></i><br><small>No. Nota</small></span>
								<input class="form-control" style="padding: 20px 15px;" name="no_nota_beli" value="<?php echo $no_nota_beli ?>" title="No Nota Beli" readonly>
							</div>
						</div>
						<div class="col-md-6">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-money fa-fw" style="width: 48px;"></i><br><small>Jml.</small></span>
								<input class="form-control" style="padding: 20px 15px;" id="total_nota" value="<?php echo $jumlah_nota ?>" title="Total Nota Beli (Rp)" readonly>
							</div>
						</div>
						<div class="col-md-6">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-info fa-fw" style="width: 48px;"></i><br><small>Jenis</small></span>
								<input class="form-control" id="jenis" style="padding: 20px 15px;" name="jenis" value="<?php echo $jenis ?>" title="Jenis" readonly>
							</div>
						</div>
						<div class="col-md-6">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-money fa-fw" style="width: 48px;"></i><br><small>Sisa</small></span>
								<input class="form-control" id="sisa_nota" name="sisa_nota" style="padding: 20px 15px;" value="<?php echo $sisa_nota ?>" title="Sisa Nota (Rp)" readonly>
							</div>
						</div>
						<div class="col-md-12">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-money fa-fw"></i><br><small>Pembayaran</small></span>
<?php
if ($jenis=='Retur'){
	echo '						<input class="form-control" id="jumlah_bayar" style="padding: 20px 15px;" name="jumlah_bayar" value="0" placeHolder="Jumlah Bayar (Rp)" readonly>';
} else {
	echo '						<input class="form-control" id="jumlah_bayar" style="padding: 20px 15px;" name="jumlah_bayar" value=""  autofocus placeHolder="Jumlah Bayar (Rp)" required>
								<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>';
}
?>
							</div>
						</div>
<?php
if ($jenis=='Transfer' || $jenis=='Giro'){
	echo '<div class="col-md-6">
			<br><b>Pengirim :</b><br>
			<div class="input-group" style="margin-top:10px;">
			<span class="input-group-addon"><i class="fa fa-building fa-fw"></i><br><small>Nama Bank</small></span>
			<input class="form-control" id="sisa_nota" style="padding: 20px 15px;" name="pengirim_nama_bank" value="" placeHolder="Nama Bank" title="Nama Bank" maxlength="50" required>
			<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
			</div>
			<div class="input-group">
			<span class="input-group-addon"><i class="fa fa-user fa-fw" style="width: 63px"></i><br><small>Nama Rek.</small></span>
			<input class="form-control" style="padding: 20px 15px;" id="sisa_nota" name="pengirim_nama_rekening" value="" placeHolder="Nama Rekening" title="Nama Rekening" maxlength="100" required>
			<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
			</div>
			<div class="input-group">
			<span class="input-group-addon"><i class="fa fa-tag fa-fw" style="width: 63px"></i><br><small>No. Rek.</small></span>
			<input class="form-control" style="padding: 20px 15px;" id="sisa_nota" name="pengirim_no_rekening" value="" placeHolder="No Rekening" title="No Rekening" maxlength="20" required>
			<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
			</div>
		</div>';
		echo '<div class="col-md-6">
			<br><b>Penerima :</b><br>
			<div class="input-group" style="margin-top:10px;">
			<span class="input-group-addon"><i class="fa fa-building fa-fw"></i><br><small>Nama Bank</small></span>
			<input class="form-control" style="padding: 20px 15px;" id="sisa_nota" name="penerima_nama_bank" value="" placeHolder="Nama Bank" title="Nama Bank" maxlength="50" required>
			<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
			</div>
			<div class="input-group">
			<span class="input-group-addon"><i class="fa fa-user fa-fw" style="width: 63px"></i><br><small>Nama Rek.</small></span>
			<input class="form-control" style="padding: 20px 15px;" id="sisa_nota" name="penerima_nama_rekening" value="" placeHolder="Nama Rekening" title="Nama Rekening" maxlength="100" required>
			<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
			</div>
			<div class="input-group">
			<span class="input-group-addon"><i class="fa fa-tag fa-fw" style="width: 63px"></i><br><small>No. Rek.</small></span>
			<input class="form-control" style="padding: 20px 15px;" id="sisa_nota" name="penerima_no_rekening" value="" placeHolder="No Rekening" title="No Rekening" maxlength="20" required>
			<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
			</div>
		</div>';
}
if ($jenis=='Giro'){
		echo '<div class="col-md-6">
			<br><b>Giro :</b>
			<div class="input-group" style="margin-top:10px;">
			<span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i><br><small>Jth. tempo</small></span>
			<input class="form-control" style="padding: 20px 15px;" id="jatuh_tempo" name="jatuh_tempo" value="" placeHolder="Tanggal Jatuh Tempo" title="Tanggal Jatuh Tempo" required>
			<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
			</div>
			<div class="input-group">
			<span class="input-group-addon"><i class="fa fa-file fa-fw" style="width: 55px;"></i><br><small>Ket.</small></span>
			<input class="form-control" id="keterangan" style="padding: 20px 15px;" name="keterangan" value="" placeHolder="Keterangan" maxlength="100">
			</div>
		</div>';
}
?>
						<div class="clearfix"></div>
						<div style="margin-top: 50px;">
							<h4><b>NOTA RETUR BELI</b></h4>
							<div class="clearfix"></div><br/>
							<div id="retur_content" class="col-xs-12">
								<div class="col-xs-6 bg-blue">
									<h5>No Retur Beli</h5>
								</div>
								<div class="col-xs-6 bg-blue">
									<h5>Jumlah Retur (Rp)</h5>
								</div>
							</div>
							<div class="clearfix"></div><br/>
<?php
$sql=mysqli_query($con, "SELECT
    retur_beli.id_retur_beli
    , retur_beli.no_retur_beli
FROM
    retur_beli
    INNER JOIN beli 
        ON (retur_beli.id_beli = beli.id_beli)
WHERE STATUS=1 AND id_supplier=$id_supplier AND no_retur_beli NOT IN (SELECT no_retur_beli FROM bayar_nota_beli_detail)");
$c=0;
	while($b=mysqli_fetch_array($sql)){
		$tmp_id_retur=$b['id_retur_beli'];
		$sql2=mysqli_query($con, "SELECT SUM(qty_keluar * harga_retur) AS jumlah FROM retur_beli_detail WHERE id_retur_beli=$tmp_id_retur");
		$b2=mysqli_fetch_array($sql2);
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
				<h4 class="modal-title">Tambah Pembayaran Nota Beli</h4>
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
			alert('Nota Retur Beli masih kosong');
			return false;
		} else {
			return true;
		}
	}
}
function valid2(){
	var total_nota = parseInt($('#total_nota').val());
	var sisa_nota = parseInt($('#sisa_nota').val());
	var jumlah_bayar = parseInt($('#jumlah_bayar').val());
	if ($('#jenis').val()!='Retur'){
		if (jumlah_bayar+jumlah_retur <= sisa_nota && jumlah_bayar>0){
			return true;
		} else {
			if (jumlah_bayar==0) alert('Jumlah Bayar harus > 0');
			if (jumlah_bayar+jumlah_retur >= sisa_nota) alert('Jumlah Bayar tidak boleh melebihi Sisa Nota Beli');
			return false;
		}
	} else {
		if (jumlah_bayar+jumlah_retur <= sisa_nota){
			return true;
		} else {
			alert('Jumlah Bayar tidak boleh melebihi Sisa Nota Beli');
			return false;
		}
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
	$('#jumlah_bayar').inputmask('currency', {prefix: "Rp ", allowMinus:false, autoGroup: true, groupSeparator: '.', rightAlign: false, autoUnmask: true, removeMaskOnSubmit: true});
	$('#total_nota').inputmask('decimal', {allowMinus:false, autoGroup: true, groupSeparator: '.', rightAlign: false, autoUnmask: true, removeMaskOnSubmit: true});
	$('#sisa_nota').inputmask('decimal', {allowMinus:false, autoGroup: true, groupSeparator: '.', rightAlign: false, autoUnmask: true, removeMaskOnSubmit: true});
	$('#myModal').on('show.bs.modal', function(e){
		$('#content').load('assets/page/pembelian/get-retur.php?id_supplier=' + <?php echo $id_supplier ?> + '&id=' + rb);
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
			alert('Tanggal harus > ' + today + '.');
		}
	}});
});
</script>
