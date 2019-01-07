<?php
if (isset($tambah_pembelian_post)){
	$sql = mysqli_query($con, "SELECT * FROM beli WHERE no_nota_beli='$no_nota_beli'");
	$c = mysqli_num_rows($sql);
	if ($c>0){
		_buat_pesan("Input Gagal. No Nota Beli sudah ada.","red");
		_direct("?page=pembelian&mode=pembelian");
	} else {
		$sql = "INSERT INTO beli VALUES(null,'$no_nota_beli','$tanggal','$id_supplier',null,null,null,null,null,null,0,$diskon_all,$ppn_all)";
		$q = mysqli_query($con, $sql);
		$e_id = mysqli_insert_id($con);
		if ($q){
			_buat_pesan("Input Berhasil","green");
		} else {
			_buat_pesan("Input Gagal","red");
		}
		_direct("?page=pembelian&mode=view_add&id=" .$e_id);
	}
} else {
	$sql = "DELETE FROM beli WHERE id_beli NOT IN (SELECT id_beli FROM beli_detail)";
	$q = mysqli_query($con, $sql);
}
?>
<!-- page content -->
<div class="right_col" role="main">
	<div class="">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<h3>PEMBELIAN</h3>
						<?php
							if (isset($pesan)){
								echo '<span class="badge bg-' .$warna. '">' .$pesan. '</span>';
							}
						?>
					<div class="clearfix"></div>
					</div>
					<div class="x_content">
					<div class="alert alert-info">
					  <strong>Klik kolom pada tabel untuk detail.</strong>
					</div>
			<div class="col-md-4">
				<table>
					<tr>
						<td>Cari Tanggal :<br><input class="form-control" style="width:100px" id="tgl_dari" type="text" value="" placeholder="Tanggal" readonly></td>
						<td><br>&nbsp; - &nbsp;</td>
						<td><br><input class="form-control" style="width:100px" id="tgl_sampai" type="text" value="" placeholder="Tanggal" readonly></td>
						<td>&nbsp;&nbsp;</td>
						<td><br><a class="btn btn-primary" id="btn_dari_sampai" onClick="submit();"><i class="fa fa-search"></i></a></td>
					</tr>
				</table>
			</div>
			<div class="col-md-4">
				<table>
					<tr>
						<td>Cari Barang :<br><input class="form-control" style="width:200px" id="cari" type="text" value="" placeholder="Nama Barang"></td>
						<td>&nbsp;&nbsp;</td>
						<td><br><a class="btn btn-primary" onClick="cari_barang();"><i class="fa fa-search"></i></a></td>
					</tr>
				</table>
			</div>
			<div class="col-md-4" style="float: right">
				<p align="right"><br><button class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Tambah</button></p>
			</div>
			<div class="clearfix"></div>
			<table id="table1" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>Tgl. Nota Beli</th>
						<th>No Nota Beli</th>
						<th>Supplier</th>
						<th>Total Nota Beli (Rp)</th>
						<th>Total Datang (Rp)</th>
						<th>Ekspedisi</th>
					</tr>
				</thead>
				<tbody>
<?php
if (isset($_GET['dari'])){
	$dari=date("Y-m-d", strtotime($_GET['dari']));
	$sampai=date("Y-m-d", strtotime($_GET['sampai']));
	$val="WHERE (beli.tanggal BETWEEN '$dari' AND '$sampai')";
} else if (isset($_GET['cari'])){
	$cari=$_GET['cari'];
	if ($cari==''){
		$val="";
	} else {
		$val="WHERE barang.nama_barang LIKE '%$cari%'";
	}
} else {
	$val="WHERE MONTH(beli.tanggal)=MONTH(CURRENT_DATE()) AND YEAR(beli.tanggal)=YEAR(CURRENT_DATE())";
}

if (isset($_GET['cari'])){
$sql=mysqli_query($con, "SELECT
    beli.id_beli
    , beli.no_nota_beli
    , beli.tanggal
    , beli.berat_ekspedisi
    , beli.tarif_ekspedisi
    , beli.keterangan
    , ekspedisi.nama_ekspedisi
    , supplier.nama_supplier
    , barang.nama_barang
FROM
    beli
    LEFT JOIN supplier 
        ON (beli.id_supplier = supplier.id_supplier)
    LEFT JOIN ekspedisi 
        ON (beli.id_ekspedisi = ekspedisi.id_ekspedisi)
    LEFT JOIN beli_detail 
        ON (beli_detail.id_beli = beli.id_beli)
    LEFT JOIN barang_supplier 
        ON (beli_detail.id_barang_supplier = barang_supplier.id_barang_supplier)
    LEFT JOIN barang 
        ON (barang_supplier.id_barang = barang.id_barang)
    $val
    GROUP BY beli.id_beli
	ORDER BY beli.id_beli DESC");
} else {
$sql=mysqli_query($con, "SELECT
    beli.id_beli
    , beli.no_nota_beli
    , beli.tanggal
	, beli.berat_ekspedisi
    , beli.tarif_ekspedisi
    , beli.keterangan
    , supplier.nama_supplier
    , ekspedisi.nama_ekspedisi
FROM
    beli
    INNER JOIN supplier 
        ON (beli.id_supplier = supplier.id_supplier)
	LEFT JOIN ekspedisi 
        ON (beli.id_ekspedisi = ekspedisi.id_ekspedisi)
$val
ORDER BY beli.id_beli DESC");
}

while($row=mysqli_fetch_array($sql)){
$id_beli=$row['id_beli'];
$sql2=mysqli_query($con, "SELECT
    ppn_all_persen,SUM(qty * (harga-diskon_rp-diskon_rp_2-diskon_rp_3)) AS total_beli
FROM
    beli_detail
    INNER JOIN beli 
        ON (beli_detail.id_beli = beli.id_beli)
WHERE beli.id_beli=$id_beli");
$r=mysqli_fetch_array($sql2);
$total_beli=$r['total_beli']+($r['total_beli']*$r['ppn_all_persen']/100);
$sql3=mysqli_query($con, "SELECT
    ppn_all_persen,SUM(qty_di_rak * (harga-diskon_rp-diskon_rp_2-diskon_rp_3)) AS total_datang
FROM
    beli_detail
    INNER JOIN beli 
        ON (beli_detail.id_beli = beli.id_beli)
    LEFT JOIN barang_masuk 
        ON (barang_masuk.id_beli_detail = beli_detail.id_beli_detail)
    LEFT JOIN barang_masuk_rak 
        ON (barang_masuk_rak.id_barang_masuk = barang_masuk.id_barang_masuk)
WHERE beli.id_beli=$id_beli");
$s=mysqli_fetch_array($sql3);
$total_datang=$s['total_datang']+($s['total_datang']*$s['ppn_all_persen']/100);
	echo '			<tr>
						<td><a href="?page=pembelian&mode=view_detail&id=' .$row['id_beli']. '"><div style="min-width:70px">' .date("d-m-Y", strtotime($row['tanggal'])). '</div></a></td>
						<td><a href="?page=pembelian&mode=view_detail&id=' .$row['id_beli']. '"><div style="min-width:70px">' .$row['no_nota_beli']. '</div></a></td>
						<td><a href="?page=pembelian&mode=view_detail&id=' .$row['id_beli']. '"><div style="min-width:70px">' .$row['nama_supplier']. '</div></a></td>
						<td align="right"><a href="?page=pembelian&mode=view_detail&id=' .$row['id_beli']. '"><div style="min-width:70px">' .format_uang($total_beli). '</div></a></td>
						<td align="right"><a href="?page=pembelian&mode=view_detail&id=' .$row['id_beli']. '"><div style="min-width:70px">' .format_uang($total_datang). '</div></a></td>
						<td><a href="?page=pembelian&mode=view_detail&id=' .$row['id_beli']. '"><div style="min-width:70px">' .$row['nama_ekspedisi']. '</div></a></td>
						<!--td align="right"><a href="?page=pembelian&mode=view_detail&id=' .$row['id_beli']. '"><div style="min-width:70px">' .format_angka($row['berat_ekspedisi']). '</div></a></td>
						<td align="right"><a href="?page=pembelian&mode=view_detail&id=' .$row['id_beli']. '"><div style="min-width:70px">' .format_uang($row['tarif_ekspedisi']). '</div></a></td-->
					</tr>';
}
?>
					
				</tbody>
			</table>
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
				<h4 class="modal-title">Tambah Nota Pembelian</h4>
			</div>
			<div class="modal-body">
				<form action="" method="post">
					<input type="hidden" name="tambah_pembelian_post" value="true">
					<div class="col-md-12">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-file fa-fw"></i><br><small>No. Nota</small></span>
						<input id="no_nota" name="no_nota_beli" style="padding: 20px 15px;" type="text" class="form-control" placeholder="No Nota Beli" maxlength="15" required>
						<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
					</div>
					<div class="input-group">
						<span class="input-group-addon" style="padding: 2px 12px;"><i class="fa fa-building fa-fw" style="width: 46px;"></i><br><small>Supplier</small></span>
						<select name="id_supplier" class="select2 form-control" required="true">
							<option value="" disabled selected>-= Pilih Supplier =-</option>
							<?php 
								$cust=mysqli_query($con, "SELECT id_supplier, nama_supplier FROM supplier");
								while($b=mysqli_fetch_array($cust)){
									echo '<option value="' .$b['id_supplier']. '">' .$b['nama_supplier']. '</option>';
								}
							?>
						</select>
						<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><div style="min-width:90px;text-align:left">Diskon Nota (%)</div></span>
						<input id="diskon_all" onchange="handleChange(this)" maxlength="6" name="diskon_all" type="text" class="form-control" placeholder="Diskon Nota" value="0" required><br>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><div style="min-width:102px;text-align:left">PPN (%)</div></span>
						<input id="ppn_all" onchange="handleChange(this)" maxlength="6" name="ppn_all" type="text" class="form-control" placeholder="PPN" value="0" required>
					</div>
					</div>
					<div class="modal-footer">
						<input type="submit" class="btn btn-primary" value="Simpan">
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<script>
/*$(function($) {
      
});*/
function validasi(){
	var startDate = new Date.parse(get_global_tanggal($('#tgl_dari').val()));
	var endDate = new Date.parse(get_global_tanggal($('#tgl_sampai').val()));
	if (startDate > endDate){
		$('#tgl_dari').val('');
		$('#tgl_sampai').val('');
		$('#btn_dari_sampai').attr('style','display:none');
		alert("Terjadi kesalahan penulisan tanggal");
		AndroidFunction.showToast("Terjadi kesalahan penulisan tanggal");
	} else {
		$('#btn_dari_sampai').removeAttr('style');
	}
}
function submit(){
	window.location="?page=pembelian&mode=pembelian&dari=" + $('#tgl_dari').val() + "&sampai=" + $('#tgl_sampai').val();
}
function cari_barang(){
	window.location="?page=pembelian&mode=pembelian&cari=" + $('#cari').val();
}
function handleChange(input) {
    if (input.value < 0) input.value = 0;
    if (input.value > 100) input.value = 100;
 }
$(document).ready(function(){
	//$('#diskon_all').inputmask('decimal', {autoGroup: true, groupSeparator: '.', rightAlign: false, autoUnmask: true, removeMaskOnSubmit: true});x
	$('#diskon_ppn').inputmask('decimal', {autoGroup: true, groupSeparator: '.', rightAlign: false, autoUnmask: true, removeMaskOnSubmit: true});
	$('#myModal').on('show.bs.modal', function(e){
		var id = $(e.relatedTarget).data('id');
		$('#get_karyawan').load('api/web/get-karyawan.php?id=' + id,function(){
			$('#gaji_2').inputmask('decimal', {autoGroup: true, groupSeparator: '.', rightAlign: false, autoUnmask: true, removeMaskOnSubmit: true});
			$('#harian_2').inputmask('decimal', {autoGroup: true, groupSeparator: '.', rightAlign: false, autoUnmask: true, removeMaskOnSubmit: true});
			$('#lembur_2').inputmask('decimal', {autoGroup: true, groupSeparator: '.', rightAlign: false, autoUnmask: true, removeMaskOnSubmit: true});
		});
	})

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
	$("#tgl_dari").on('change', function(){
		validasi();
	});
	$("#tgl_sampai").on('change', function(){
		validasi();
	});

	$('#diskon_all').numeric({decimalPlaces: 2, negative:false});
	$('#ppn_all').numeric({decimalPlaces: 2, negative:false});
});
</script>