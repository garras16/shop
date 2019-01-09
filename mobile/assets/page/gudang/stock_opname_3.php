<?php
$id_karyawan=$_SESSION['id_karyawan'];
$nama_user=$_SESSION['user'];
$id_rak=$_GET['rak'];
if (isset($tambah_stock_opname_gudang)){
	$tgl = explode("/", $expire);
	$expire = $tgl[2] ."-". $tgl[1] ."-". $tgl[0];
	$sql=mysqli_query($con, "UPDATE stock_opname SET status_so=2 WHERE id_so=$id");
/*	$sql=mysqli_query($con, "SELECT *
FROM
    barang_masuk_rak
    INNER JOIN barang_masuk 
        ON (barang_masuk_rak.id_barang_masuk = barang_masuk.id_barang_masuk)
    INNER JOIN beli_detail 
        ON (barang_masuk.id_beli_detail = beli_detail.id_beli_detail)
    INNER JOIN barang_supplier 
        ON (beli_detail.id_barang_supplier = barang_supplier.id_barang_supplier)
    INNER JOIN barang 
        ON (barang_supplier.id_barang = barang.id_barang)
WHERE barang.id_barang=$id_barang AND expire='$expire' AND id_rak=$id_rak AND stok>0 HAVING SUM(stok)>=$qty_cek");
	if (mysqli_num_rows($sql)>0){
		$row=mysqli_fetch_array($sql);*/
		$sql2=mysqli_query($con, "INSERT INTO stock_opname_detail VALUES(null,$id,$id_barang,$id_rak,'$expire',$qty_cek)");
/*	} else {
		_alert("Input Salah. Silakan input kembali.");
	}*/
	_direct("?page=gudang&mode=stock_opname_3&id=$id&rak=$id_rak");
}
if (isset($_GET['del'])){
	$sql=mysqli_query($con, "SELECT * FROM stock_opname_detail WHERE id_so_detail=" .$_GET['del']);
	$row=mysqli_fetch_array($sql);
	$sql2=mysqli_query($con, "DELETE FROM stock_opname_detail WHERE id_so=$id AND id_barang=" .$row['id_barang']. " AND id_rak=" .$row['id_rak']. " AND expire='" .$row['expire']. "'");
	_direct("?page=gudang&mode=stock_opname_3&id=$id&rak=$id_rak");
}
if (isset($selesai_stock_opname_gudang)){
	$sql=mysqli_query($con, "UPDATE stock_opname SET status_so=1 WHERE id_so=$id");
	_direct("?page=gudang&mode=stock_opname_4&id=$id&rak=$id_rak");
}
$sql=mysqli_query($con, "SELECT *
FROM
    stock_opname
    INNER JOIN karyawan 
        ON (stock_opname.id_karyawan = karyawan.id_karyawan)
	WHERE id_so=$id");
	$row=mysqli_fetch_array($sql);
	$tgl_so=$row['tanggal_so'];
	$nama=$row['nama_karyawan'];
	$status_so=$row['status_so'];
	
	$sql=mysqli_query($con, "SELECT * FROM rak INNER JOIN gudang ON (rak.id_gudang = gudang.id_gudang) WHERE rak.id_rak=$id_rak");
	$row=mysqli_fetch_array($sql);
	$nama_gudang=$row['nama_gudang'];
	$nama_rak=$row['nama_rak'];
?>
<div class="right_col loading" role="main">
	<div class="">
	
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<div class="col-md-6">
							<h3>STOCK OPNAME GUDANG</h3>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<table class="table table-bordered table-striped">
						<tbody>
<?php
	echo '					<tr><td width="40%">Tanggal Stock Opname</td><td>' .date("d-m-Y",strtotime($tgl_so)). '</td></tr>';
	echo '					<tr><td>Nama Gudang</td><td>' .$nama_gudang. '</td></tr>
							<tr><td>Nama Rak</td><td>' .$nama_rak. '</td></tr>
							<tr><td>Nama Karyawan</td><td>' .$nama. '</td></tr>';
?>
						</tbody>
						</table>
						
						<div class="table-responsive">
						<table class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>Nama Barang</th>
									<th>Tgl. Exp.</th>
									<th>Qty Periksa</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
<?php
	$sql=mysqli_query($con, "SELECT *,SUM(stok) AS stok
FROM
    barang_masuk_rak
    INNER JOIN barang_masuk 
        ON (barang_masuk_rak.id_barang_masuk = barang_masuk.id_barang_masuk)
    INNER JOIN beli_detail 
        ON (barang_masuk.id_beli_detail = beli_detail.id_beli_detail)
    INNER JOIN barang_supplier 
        ON (beli_detail.id_barang_supplier = barang_supplier.id_barang_supplier)
    INNER JOIN barang 
        ON (barang_supplier.id_barang = barang.id_barang)
    INNER JOIN satuan 
        ON (barang.id_satuan = satuan.id_satuan)
WHERE stok>0 AND barang_masuk_rak.id_rak=$id_rak AND barang.status=1
GROUP BY barang.id_barang");
	while ($row=mysqli_fetch_array($sql)){
	$sql2=mysqli_query($con, "SELECT *,SUM(jumlah_barang) as jumlah_barang
FROM
    stock_opname_detail
    INNER JOIN barang 
        ON (stock_opname_detail.id_barang = barang.id_barang)
WHERE stock_opname_detail.id_barang=" .$row['id_barang']. "	AND id_so=$id AND stock_opname_detail.id_rak=$id_rak
GROUP BY stock_opname_detail.id_barang,stock_opname_detail.id_rak,stock_opname_detail.expire");
	(mysqli_num_rows($sql2)=='0' ? $n='1' : $n=mysqli_num_rows($sql2));
	echo '<tr>
				<td rowspan="'.$n.'" style="vertical-align:middle;text-align:center;">' .$row['nama_barang']. '</td>';
	$detail=false;
	while ($row2=mysqli_fetch_array($sql2)){
		$detail=true;
		echo '	<td style="vertical-align:middle;text-align:center" align="center">' .date("d-m-Y",strtotime($row2['expire'])). '</td>
				<td style="vertical-align:middle;text-align:center" align="center">' .format_angka($row2['jumlah_barang']). ' ' .$row['nama_satuan']. '</td>
				<td style="vertical-align:middle;text-align:center" align="center">';
		if ($status_so<>1)
		echo '		<a data-toggle="modal" data-target="#myModal" data-nama="' .$row['nama_barang']. '" data-barcode="' .$row['barcode']. '" data-id-barang="' .$row['id_barang']. '" data-satuan="' .$row['nama_satuan']. '" class="btn btn-primary btn-xs"><i class="fa fa-barcode"></i> Scan</a>
					<a href="?page=gudang&mode=stock_opname_3&id=' .$id. '&del=' .$row2['id_so_detail']. '&rak=' .$id_rak. '" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Hapus</a>';
		echo '	</td></tr>';
	}
	if (!$detail){
		echo '	<td></td>
				<td></td>';
		if ($status_so<>1){
			echo '	<td style="vertical-align:middle;text-align:center" align="center"><a data-toggle="modal" data-target="#myModal" data-nama="' .$row['nama_barang']. '" data-barcode="' .$row['barcode']. '" data-id-barang="' .$row['id_barang']. '" data-satuan="' .$row['nama_satuan']. '" class="btn btn-primary btn-xs"><i class="fa fa-barcode"></i> Scan</a></td>';
		} else {
			echo '<td></td>';
		}
		echo '</tr>';
	}
	
}
?>
							</tbody>
						</table>
						</div>
						<form id="selesai" method="post">
							<input type="hidden" name="selesai_stock_opname_gudang" value="true">
							<center><input type="button" onClick="$('#myModal2').modal('show');" class="btn btn-primary" value="SELESAI" <?php if ($status_so==1) echo 'disabled' ?> ></input>
							<a href="?page=gudang&mode=stock_opname_2&id=<?php echo $id ?>" class="btn btn-danger" value="SCAN RAK" <?php if ($status_so==1) echo 'disabled' ?> >SCAN RAK</a></center>
						</form>
					</div>
				</div>
			<div id="dummy" style="display:none"></div>
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
					<input type="hidden" name="tambah_stock_opname_gudang" value="true">
					<input type="hidden" id="id_barang" name="id_barang" value="">
					<input type="hidden" id="id_rak" name="id_rak" value="<?php echo $id_rak ?>">
					<input type="hidden" id="barcode_barang" value="">
					<div class="text-center" style="margin-bottom:10px"><a id="scan_barang" class="btn btn-primary" onClick="AndroidFunction.scan_barang();">Scan Barang</a></div>
					<div class="form-group col-sm-12">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-tag fa-fw"></i></span>
							<input class="form-control" id="nama_barang" placeholder="Nama Barang" value="" readonly>
							<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
						</div>
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
		window.location='index.php?page=gudang&mode=stock_opname';
	}
}
function cek_valid(){
	var qty_cek = Number($('#qty_cek').val());
	if (qty_cek == '0') {
		AndroidFunction.showToast("Qty Periksa harus lebih dari 0.");
		return false;
	}
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
	$('#qty_cek').inputmask('decimal', {allowMinus: false, autoGroup: true, groupSeparator: '.', rightAlign: false, removeMaskOnSubmit: true});
	$('#myModal').on('show.bs.modal', function(e){
		var qty_cek = $(e.relatedTarget).data('cek');
		var satuan = $(e.relatedTarget).data('satuan');
		var id_barang = $(e.relatedTarget).data('id-barang');
		var nama = $(e.relatedTarget).data('nama');
		var barcode_barang = $(e.relatedTarget).data('barcode');
		$('#qty_cek').val("");
		$('#nama_barang').val(nama);
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
	$('#tidak').on('click', function(e){
		$('#myModal2').modal('hide');
	});
	$('#ya_2').on('click', function(e){
		$('#selesai').submit();
	});
	$('#tidak_2').on('click', function(e){
		$('#myModal3').modal('hide');
	});
})
</script>
