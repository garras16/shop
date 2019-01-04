<?php
$id_karyawan=$_SESSION['id_karyawan'];
if (isset($tambah_stock_opname_canvass)){
	$tgl = explode("/", $expire);
	$expire = $tgl[2] ."-". $tgl[1] ."-". $tgl[0];
	$sql=mysql_query("SELECT * FROM canvass_keluar_barang WHERE id_canvass_keluar=$id AND id_barang=$id_barang AND expire='$expire'");
	if (mysql_num_rows($sql)>0){
		$row=mysql_fetch_array($sql);
		$sql2=mysql_query("INSERT INTO canvass_stock_opname values(null,$id," .$row['id_canvass_keluar_barang']. ",$id_barang,'$tanggal',$qty_cek,1,'$expire')");
		$sql=mysql_query("SELECT * FROM lap_stock_opname WHERE id_canvass_keluar=$id AND id_barang=$id_barang");
		if (mysql_num_rows($sql)>0){
			$sql2=mysql_query("UPDATE lap_stock_opname SET tgl_lap='$tanggal',qty_sisa=$qty_sisa,qty_cek=$total_cek,selisih=$selisih,expire='$expire' WHERE id_canvass_keluar=$id AND id_barang=$id_barang AND id_karyawan=$id_karyawan");
		} else {
			$sql2=mysql_query("INSERT INTO lap_stock_opname values(null,$id,'$tanggal',$id_barang,$qty_sisa,$total_cek,$selisih,$id_karyawan,'$expire')");
		}
	} else {
		_alert("Input Salah. Silakan input kembali.");
	}
	_direct("?page=canvass_keluar&mode=stock_opname_2&id=$id");
}
if (isset($_GET['del'])){
	$sql=mysql_query("DELETE FROM canvass_stock_opname WHERE id_canvass_keluar=$id AND id_barang=" .$_GET['del']. "");
	$sql=mysql_query("DELETE FROM lap_stock_opname WHERE id_canvass_keluar=$id AND id_barang=" .$_GET['del']. " AND id_karyawan=$id_karyawan");
	_direct("?page=canvass_keluar&mode=stock_opname_2&id=$id");
}
if (isset($selesai_canvass_stock_opname)){	
	$sql=mysql_query("UPDATE canvass_keluar SET status=3 WHERE id_canvass_keluar=$id");
	
	//jika ada yg belum scan
	$sql=mysql_query("SELECT * FROM canvass_keluar_barang WHERE id_canvass_keluar=$id AND stok>0 AND id_barang NOT IN (SELECT id_barang FROM canvass_stock_opname WHERE id_canvass_keluar=$id AND stok>0)");
	while ($row=mysql_fetch_array($sql)){
		$sql2=mysql_query("INSERT INTO canvass_stock_opname values(null,$id," .$row['id_canvass_keluar_barang']. "," .$row['id_barang']. ",'" .date("Y-m-d"). "',0,1,'" .$row['expire']. "')");
	}
	$sql=mysql_query("SELECT * FROM canvass_keluar_barang WHERE id_canvass_keluar=$id AND stok>0 AND id_barang NOT IN (SELECT id_barang FROM lap_stock_opname WHERE id_canvass_keluar=$id AND stok>0)");
	while ($row=mysql_fetch_array($sql)){
		$sql2=mysql_query("INSERT INTO lap_stock_opname values(null,$id,'" .date("Y-m-d"). "'," .$row['id_barang']. "," .$row['stok']. ",0,-" .$row['stok']. ",$id_karyawan,'" .$row['expire']. "')");
		echo mysql_error();
	}
	
	//jika ada qty yg salah
	$sql=mysql_query("SELECT canvass_keluar_barang.id_barang
FROM
    canvass_keluar_barang
    LEFT JOIN canvass_stock_opname 
        ON (canvass_keluar_barang.id_canvass_keluar_barang = canvass_stock_opname.id_canvass_keluar_barang)
WHERE canvass_stock_opname.id_canvass_keluar=$id
GROUP BY id_barang");
	$cek_error=false;
	while ($row=mysql_fetch_array($sql)){
		$sql2=mysql_query("SELECT SUM(stok) AS stok FROM canvass_keluar_barang WHERE id_canvass_keluar=$id AND id_barang=" .$row['id_barang']);
		$row2=mysql_fetch_array($sql2);
		$stok=$row2['stok'];
		$sql2=mysql_query("SELECT SUM(qty_cek_2) AS qty_cek FROM canvass_stock_opname WHERE id_canvass_keluar=$id AND id_barang=" .$row['id_barang']);
		$row2=mysql_fetch_array($sql2);
		$qty_cek=$row2['qty_cek'];
		if ($stok <> $qty_cek){
			$cek_error=true;
			break;
		}
	}
	if ($cek_error){
		$tanggal=date("Y-m-d");
		$sql=mysql_query("UPDATE canvass_keluar SET status=9 WHERE id_canvass_keluar=$id");
		$sql2=mysql_query("INSERT INTO konfirm_owner VALUES(null,'$tanggal','Ada perbedaan antara hasil perhitungan qty stock opname dan qty seharusnya.','canvass_stock_opname',0,'?page=konfirmasi&mode=konfirm_so_canvass&id=$id')");
		_alert("Ada perbedaan antara qty periksa dan qty seharusnya. Silahkan tunggu konfirmasi owner.");
	} else {
		_alert("Silahkan melakukan proses mutasi barang dari mobil ke gudang.");
	}
	_direct("?page=canvass_keluar&mode=stock_opname");
}
	$sql=mysql_query("SELECT *
FROM
    canvass_keluar
    LEFT JOIN kendaraan 
        ON (canvass_keluar.id_mobil = kendaraan.id_kendaraan)
	WHERE id_canvass_keluar=$id");
	$row=mysql_fetch_array($sql);
	$tgl_canvass=$row['tanggal_canvass'];
	$nama_mobil=$row['nama_kendaraan'];
	$plat=$row['plat'];
	$sql2=mysql_query("SELECT *
FROM
    canvass_keluar_karyawan
    INNER JOIN karyawan 
        ON (canvass_keluar_karyawan.id_karyawan = karyawan.id_karyawan)
	INNER JOIN users 
        ON (karyawan.id_karyawan = users.id_karyawan)
	WHERE id_canvass_keluar=$id");
	$baris=mysql_num_rows($sql2);
?>
<div class="right_col loading" role="main">
	<div class="">
	
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<div class="col-md-6">
							<h3>STOCK OPNAME (CANVASS)</h3>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<table class="table table-bordered table-striped">
						<tbody>
<?php
	echo '					<tr><td width="40%">Tanggal Canvass</td><td>' .date("d-m-Y", strtotime($tgl_canvass)). '</td></tr>
							<tr><td width="40%">Nama Mobil</td><td>' .$nama_mobil. '</td></tr>
							<tr><td width="40%">No Pol</td><td>' .$plat. '</td></tr>';
	
	echo '					<tr><td rowspan="' .$baris. '">Nama Karyawan</td>';
	while ($row2=mysql_fetch_array($sql2)){
		echo '				<td>- ' .$row2['nama_karyawan']. ' ( ' .$row2['posisi']. ' )</td></tr>';
	}
	echo '</tr>';
?>
						</tbody>
						</table>
						<div class="alert alert-info">
						  <strong>Jika ada selisih barang, scan barang kembali, dan input jumlah kekurangannya.</strong><br>
						</div>
						<div class="table-responsive">
						<table class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>Nama Barang</th>
									<th>Qty Periksa</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
<?php
	$sql=mysql_query("SELECT *,SUM(qty) as qty, SUM(qty_cek) as qty_cek
FROM
    canvass_keluar_barang
    INNER JOIN barang 
        ON (canvass_keluar_barang.id_barang = barang.id_barang)
    INNER JOIN satuan 
        ON (barang.id_satuan = satuan.id_satuan)
WHERE id_canvass_keluar=$id
GROUP BY canvass_keluar_barang.id_barang,canvass_keluar_barang.id_rak");
	while ($row=mysql_fetch_array($sql)){
	echo '<tr>
				<td style="vertical-align:middle;text-align:center;">' .$row['nama_barang']. '</td>';
	$sql2=mysql_query("SELECT SUM(qty_ambil) AS qty_ambil
FROM
    canvass_siap_kirim
    INNER JOIN canvass_siap_kirim_detail 
        ON (canvass_siap_kirim.id_canvass_siap_kirim = canvass_siap_kirim_detail.id_canvass_siap_kirim)
    INNER JOIN jual_detail 
        ON (canvass_siap_kirim_detail.id_jual_detail = jual_detail.id_jual_detail)
    INNER JOIN harga_jual 
        ON (jual_detail.id_harga_jual = harga_jual.id_harga_jual)
    INNER JOIN barang_supplier 
        ON (harga_jual.id_barang_supplier = barang_supplier.id_barang_supplier)
WHERE barang_supplier.id_barang=" .$row['id_barang']. "	AND id_canvass_keluar=$id");
	$row2=mysql_fetch_array($sql2);
	$sql3=mysql_query("SELECT SUM(qty_cek_2) AS qty_cek_2 FROM canvass_stock_opname WHERE id_barang=" .$row['id_barang']. " AND id_canvass_keluar=$id");
	$row3=mysql_fetch_array($sql3);
	$qty_sisa=$row['qty_cek']-$row2['qty_ambil'];
		if ($row3['qty_cek_2']==''){
			echo '		<td></td>
						<td style="vertical-align:middle;text-align:center;color:red" align="center"><a data-toggle="modal" data-target="#myModal" data-barcode="' .$row['barcode']. '" data-id-canvass="' .$row['id_canvass_keluar_barang']. '" data-id-barang="' .$row['id_barang']. '" data-sisa="' .$qty_sisa. '" data-satuan="' .$row['nama_satuan']. '" data-ambil="' .$row['qty']. '" data-tot-cek="0" class="btn btn-primary btn-xs"><i class="fa fa-barcode"></i> Scan</a></td>';
		} else {
			if ($row3['qty_cek_2']!=$qty_sisa){
				echo '	<td style="vertical-align:middle;text-align:center;color:red" align="center">' .format_angka($row3['qty_cek_2']). ' ' .$row['nama_satuan']. '</td>
						<td style="vertical-align:middle;text-align:center;color:red" align="center">
							<a data-toggle="modal" data-target="#myModal" data-barcode="' .$row['barcode']. '" data-id-canvass="' .$row['id_canvass_keluar_barang']. '" data-id-barang="' .$row['id_barang']. '" data-sisa="' .$qty_sisa. '" data-satuan="' .$row['nama_satuan']. '" data-ambil="' .$row['qty']. '" data-tot-cek="' .$row3['qty_cek_2']. '" class="btn btn-primary btn-xs"><i class="fa fa-barcode"></i> Scan</a>
							<a href="?page=canvass_keluar&mode=stock_opname_2&id=' .$id. '&del=' .$row['id_barang']. '" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Hapus</a>
						</td>';
			} else {	
				echo '	<td style="vertical-align:middle;text-align:center;" align="center">' .format_angka($row3['qty_cek_2']). ' ' .$row['nama_satuan']. '</td>
						<td style="vertical-align:middle;text-align:center;"><a href="?page=canvass_keluar&mode=stock_opname_2&id=' .$id. '&del=' .$row['id_barang']. '" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Hapus</a></td>';
			}
		}
echo '		</tr>';
	}	

?>
							</tbody>
						</table>
						</div>
						<form id="selesai" method="post">
							<input type="hidden" name="selesai_canvass_stock_opname" value="true">
							<center><input type="button" onClick="$('#myModal2').modal('show');" class="btn btn-primary" value="SELESAI"></center>
						</form>
					</div>
				</div>
			<div id="dummy"></div>
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
				<h4 class="modal-title">Pilih Barang</h4>
			</div>
			<div class="modal-body">				
				<form action="" method="post" onsubmit="return cek_valid();">
					<input type="hidden" name="tambah_stock_opname_canvass" value="true">
					<input type="hidden" id="id_canvass_keluar_barang" name="id_canvass_keluar_barang" value="">
					<input type="hidden" id="id_barang" name="id_barang" value="">
					<input type="hidden" id="barcode_barang" value="">
					<input type="hidden" id="qty_sisa" name="qty_sisa" value="">
					<input type="hidden" id="tot_qty_cek2" name="tot_qty_cek2" value="">
					<div class="text-center" style="margin-bottom:10px"><a id="scan_barang" class="btn btn-primary" onClick="AndroidFunction.scan_barang();">Scan Barang</a></div>
					<div class="form-group col-sm-12">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-tags fa-fw"></i></span>
							<input class="form-control" type="tel" id="qty_cek" name="qty_cek" placeholder="Qty Periksa" value="" required>
							<span class="input-group-addon satuan"></span>
							<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
						</div>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
							<input class="form-control" id="expire" type="tel" name="expire" placeholder="Tgl Exp." value="" required>
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
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Konfirmasi</h4>
			</div>
			<div class="modal-body">				
				<center><h4>Apakah Anda yakin? Stok Opname tidak dapat dibatalkan.</h4></center>
				<div class="modal-footer">
					<button id="ya" class="btn btn-primary">Ya</button>
					<button id="tidak" class="btn btn-primary">Tidak</button>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- modal input -->
<div id="myModal3" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Konfirmasi</h4>
			</div>
			<div class="modal-body">				
				<center><h4>Apakah Anda benar-benar yakin? Stok Opname tidak dapat dibatalkan.</h4></center>
				<div class="modal-footer">
					<button id="ya_2" class="btn btn-primary">Ya</button>
					<button id="tidak_2" class="btn btn-primary">Tidak</button>
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
		window.location='index.php?page=canvass_keluar&mode=stock_opname';
	}
}
function cek_valid(){
	var tot_qty_cek = Number($('#tot_qty_cek2').val());
	var qty_cek = Number($('#qty_cek').val());
	var qty_ambil = Number($('#qty_ambil').val());
	if (qty_cek == '0') {
		AndroidFunction.showToast("Qty Periksa harus lebih dari 0.");
		return false;
	}/* else if ((qty_cek + tot_qty_cek) > qty_ambil){
		AndroidFunction.showToast("Total Qty Periksa tidak boleh melebihi Qty Sisa.");
		return false;
	}*/
	return true;
}
function cek_valid2(){
	var r = getModal();
	return r;
}

function cek_scan_barang(barcode1){
	var barcode2 = $('#barcode_barang').val();
	if (barcode1 == barcode2){
		$('#scan_barang').attr("style","display:none");
		$('#qty_cek').removeAttr("disabled");
		$('#simpan').attr("style","");
	} else {
		AndroidFunction.showToast("Barcode Barang tidak sama.");
		batal_scan();
	}
}
function batal_scan(){
	getBack();
}
$(document).ready(function(){
	$('#qty_sisa').inputmask('decimal', {allowMinus: false, autoGroup: true, groupSeparator: '.', rightAlign: false, removeMaskOnSubmit: true});
	$('#qty_cek').inputmask('decimal', {allowMinus: false, autoGroup: true, groupSeparator: '.', rightAlign: false, removeMaskOnSubmit: true});
	$('#myModal').on('show.bs.modal', function(e){
		var tot_cek = $(e.relatedTarget).data('tot-cek');
		var qty_sisa = $(e.relatedTarget).data('sisa');
		var satuan = $(e.relatedTarget).data('satuan');
		var id_canvass = $(e.relatedTarget).data('id-canvass');
		var id_barang = $(e.relatedTarget).data('id-barang');
		var barcode_barang = $(e.relatedTarget).data('barcode');
		$('#qty_sisa').val(qty_sisa);
		$('#qty_cek').val("");
		$('#tot_qty_cek2').val(tot_cek);
		$('#id_canvass_keluar_barang').val(id_canvass);
		$('#id_barang').val(id_barang);
		$('#barcode_barang').val(barcode_barang);
		$('.satuan').html(satuan);
		$('#scan_barang').attr("style","");
		$('#qty_cek').attr("disabled","disabled");
		$('#simpan').attr("style","display:none");
		$('#scan_barang').click();
	});
	$('#expire').inputmask("datetime",{inputFormat: "dd/mm/yyyy",oncomplete: function(){
		var x = new Date();
		var today = x.getDate() + "/" + parseInt(x.getMonth()+1) + "/" + x.getFullYear();
		var x = new Date(x.getFullYear() + "/" + parseInt(x.getMonth()+1) + "/" + x.getDate());
		var input = $(this).val();
		var i = input.split("/");	
		var y = new Date(i[2] + "/" + i[1] + "/" + i[0]);
		if (y >= x){
			
		} else {
			$(this).val('');
			AndroidFunction.showToast('Tanggal harus \u2265 ' + today + '.');
		}
	}});
	$('#ya').on('click', function(e){
		$('#myModal2').modal('hide');
		$('#myModal3').modal('show');
	});
	$('#ya_2').on('click', function(e){
		$('#selesai').submit();
	});
	$('#tidak').on('click', function(e){
		$('#myModal2').modal('hide');
	});
	$('#tidak_3').on('click', function(e){
		$('#myModal3').modal('hide');
	});
})
</script>
