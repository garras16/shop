<?php
//$_SESSION['id_pelanggan']='1';
//$_SESSION['nama_pelanggan']='TOKO ANGIN RIBUT';
if (isset($tambah_penjualan_post)){
	$id_harga_jual[] = implode(',',$id_harga_jual);
	for ($i=0; $i<count($id_harga_jual)-1; $i++) {
		$sql=mysqli_query($con, "SELECT *
	FROM
		harga_jual
		INNER JOIN barang_supplier 
			ON (harga_jual.id_barang_supplier = barang_supplier.id_barang_supplier)
		INNER JOIN barang 
			ON (barang_supplier.id_barang = barang.id_barang)
	WHERE id_harga_jual=" .$id_harga_jual[$i]. " AND status=1");
		if (mysqli_num_rows($sql)=='0'){
			_alert("Ada barang non-aktif yang dipilih. Proses digagalkan.");
			_direct("?page=sales&mode=add_penjualan");
			break 2;
		}
	}
	
	$sql=mysqli_query($con, "SELECT COUNT(id_jual) AS cID FROM jual WHERE tgl_nota='" .date('Y-m-d'). "'");
	$r=mysqli_fetch_array($sql);
	$invoice="NJ-" .date("ymd"). '-' .sprintf("%03d",$r['cID']+1);
	$sql = "INSERT INTO jual VALUES(null,'$tanggal','$invoice',$id_pelanggan,$id_karyawan,'$jenis_bayar',$tenor,0)";
	$q = mysqli_query($con, $sql);
	$id_jual=mysqli_insert_id($con);
	$id_harga_jual[] = implode(',',$id_harga_jual);
	$harga[] = implode(',',$harga);
	$qty[] = implode(',',$qty);
	for ($i=0; $i<count($id_harga_jual)-1; $i++) {
		$sql = "INSERT INTO jual_detail VALUES(null,$id_jual,$id_harga_jual[$i],$qty[$i],$harga[$i])";
		$q = mysqli_query($con, $sql);
		if ($q){
			_buat_pesan("Input Berhasil","green");
		} else {
			_buat_pesan("Input Gagal","red");
		}
	}
	_direct("?page=sales&mode=menu_penjualan");
}
$id_karyawan=$_SESSION['id_karyawan'];
$sql=mysqli_query($con, "SELECT plafon FROM pelanggan WHERE id_pelanggan=" .$_SESSION['id_pelanggan']. "");
$row=mysqli_fetch_array($sql);
$plafon=$row['plafon'];
?>
<div class="right_col loading" role="main">
	<div class="">
	
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<h3>TAMBAH NOTA PENJUALAN</h3>
					</div>
					<div class="x_content">
							<form action="" method="post" onsubmit="return cek_valid();">
								<input type="hidden" name="tambah_penjualan_post" value="true">
								<input type="hidden" id="jenis_bayar" name="jenis_bayar" value="">
								<div id="toko"></div>
								<input type="hidden" id="id_pelanggan" name="id_pelanggan" value="<?php echo $_SESSION['id_pelanggan'] ?>">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-building fa-fw"></i></span>
									<input id="nama_pelanggan" name="nama_pelanggan" title="Nama Pelanggan" type="text" class="form-control" placeholder="Nama Toko" value="<?php echo $_SESSION['nama_pelanggan'] ?>" readonly required>
									<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
								</div>
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
									<input id="tanggal" name="tanggal" title="Tanggal" type="text" class="form-control" placeholder="Tanggal" value="<?php echo date('d-m-Y') ?>" readonly>
									<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
								</div>
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-dollar fa-fw"></i></span>
									<select class="form-control" id="select_jenis" required>
										<option value="" disabled selected>Pilih Jenis Bayar</option>
										<option value="Lunas">Lunas</option>
										<option value="Kredit">Kredit</option>
									</select>
									<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
								</div>
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-tags fa-fw"></i> (hari)</span>
									<input id="tenor" name="tenor" title="Tenor" type="text" class="form-control" placeholder="Tenor" value="">
									<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
								</div>
								<div class="text-right">
									<a onClick="cek_jenis();"  class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Barang</a>
								</div>
								<div id="input_brg">
									<div style="overflow-x: auto">
									<table class="table table-bordered table-striped">
										<thead>
											<th>Nama Barang</th>
											<th>Qty</th>
											<th>Harga Jual (Rp)</th>
											<th>Sub Total (Rp)</th>
											<th></th>
										</thead>
										<tbody>
											<tr id="info">
												<td colspan="3">Total (Rp)</td>
												<td id="info_total">0,00</td>
												<td></td>
											</tr>
										</tbody>
									</table>
									</div>
								</div>
								<div class="clearfix"></div>
								<div class="clearfix"></div><br/>
								<div id="info"><b>Info :<br/>
								<?php
								$sql2=mysqli_query($con, "SELECT * FROM jual WHERE invoice NOT IN (SELECT no_nota_jual FROM bayar_nota_jual WHERE STATUS=1) AND id_pelanggan=" .$_SESSION['id_pelanggan']);
								echo '* Jumlah Nota Gantung : ' .format_angka(mysqli_num_rows($sql2)). ' nota'; ?>
								</b>
								</div>
								<div class="clearfix"></div><br/>
								<div id="dummy" style="display:none"></div>
								<div align="center"><input id="btn_simpan" type="submit" class="btn btn-primary" value="Simpan"></div>
							</form>
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
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&times;</button>
				<h4 class="modal-title">Pilih Barang</h4>
			</div>
			<div class="modal-body">				
				<div id="get_barang" class="col-xs-12">
					
				</div>
			</div>
			<div class="clearfix"></div><br/>
			<div class="modal-footer">
				<a onClick="add_barang();" class="btn btn-primary">Tambah</a>
			</div>			
		</div>
	</div>
</div>
<script>
var total = 0;
function cek_jenis(){
	if ($('#select_jenis').val()==null){
		alert('Silahkan Pilih Jenis Pembayaran.');
		AndroidFunction.showToast("Silahkan Pilih Jenis Pembayaran.");
	} else {
		if ($('#select_jenis').val()=='Kredit' && $('#tenor').val() > 0){
			$('#jenis_bayar').val($('#select_jenis').val());
			$('#select_jenis').attr("disabled","disabled");
			$('#tenor').attr("readonly","readonly");
			$('#myModal').modal('show');
		} else if ($('#select_jenis').val()=='Lunas'){
			$('#jenis_bayar').val($('#select_jenis').val());
			$('#select_jenis').attr("disabled","disabled");
			$('#tenor').attr("readonly","readonly");
			$('#myModal').modal('show');
		} else {
			alert('Silahkan Pilih Tenor.');
			AndroidFunction.showToast("Silahkan Pilih Tenor.");
		}
	}
}
function cek_valid(){
	if ($('#input_brg').html().search('id_harga_jual')=='-1'){
		AndroidFunction.showToast('Silahkan Pilih Barang');
		return false;
	} else {
		return true;
	}
}
function add_barang(){
if ($('#select_jenis').val()=='Kredit'){
	var cari_data_add = $('#select_barang_2').find(':selected');
} else {
	var cari_data_add = $('#select_barang').find(':selected');
}
	var id_harga_jual = cari_data_add.val();
	var nama = cari_data_add.data('nama');
	var stok = cari_data_add.data('stok');
	var min_order = cari_data_add.data('min');
	var harga = $('#harga_jual').val();
	var qty = $('#qty').val();
	var subtotal = harga*qty;
	var isi = '<tr id="list">' +
				'<input type="hidden" name="id_harga_jual[]" value="' + id_harga_jual + '">' +
				'<input type="hidden" name="harga[]" value="' + harga + '">' +
				'<input type="hidden" name="qty[]" value="' + qty + '">' +
				'<td style="min-width:150px">' + nama + '</td>' +
				'<td style="min-width:100px">' + qty + ' pcs</td>' +
				'<td style="min-width:70px">' + format_uang(harga) + '</td>' +
				'<td id="st" data-st="' + subtotal + '">' + format_uang(subtotal) + '</td>' +
				'<td><a href="#" class="btn btn-primary btn-xs remove_cart">Hapus</a></td>' +
				'</tr>';
	
	if ($('#input_brg').html().search('name="id_harga_jual[]" value="' + id_harga_jual + '"')=='-1' && $('#input_brg').html().search(nama)=='-1' && stok >= qty && qty >= min_order){
		valid=true;
	} else {
		valid=false;
		if (qty > stok) {
			alert("Qty melebihi stok.");
			AndroidFunction.showToast("Qty melebihi stok.");
		} else if (min_order > qty) {
			alert("Qty harus melebihi Minimal Order.");
			AndroidFunction.showToast("Qty harus melebihi Minimal Order.");
		} else {
			alert("Barang sudah pernah dipilih.");
			AndroidFunction.showToast("Barang sudah pernah dipilih.");
		}
	}
	
	if (valid) {
		total+=subtotal;
		$('#info_total').html(format_uang(total));
		$('#input_brg').find('tbody').prepend(isi);
		$('#myModal').modal('hide');
	}
}

function getBack(){
	if ($('#myModal').is(':visible')){
		$('#myModal').modal('hide');
	} else if ($('#select_jenis').attr("disabled")=='disabled'){
		$('#select_jenis').removeAttr("disabled");
		$('#input_brg').find('tbody').empty();
		$('#input_brg').find('tbody').prepend('<tr id="info"><td colspan="3">Total</td><td id="info_total">Rp. 0,00</td><td></td></tr>');
	} else if ($('#select_jenis').val()=='Kredit' && $('#tenor').attr("readonly")=='readonly'){
		$('#tenor').removeAttr("readonly");
	} else {
		window.location="?page=sales&mode=menu_penjualan";
	}
}

$(document).ready(function(){
	$('#myModal').on('show.bs.modal', function(e){
		var jenis=$('#select_jenis').val();
		var id=$('#id_pelanggan').val();
		var tenor=$('#tenor').val();
		$('#get_barang').html('<center><i class="fa fa-spinner fa-spin" style="font-size:24px"></i></center>');
		if (jenis=='Lunas'){
			$('#get_barang').load('assets/page/sales/input_brg_tunai.php?id=' + id,function(){
				
			});
		} else {
			$('#get_barang').load('assets/page/sales/input_brg_kredit.php?id=' + id + '&tenor=' + tenor,function(){
				
			});
		}
	})
	$('#input_brg').on('click', '.remove_cart', function(e) {
		e.preventDefault();
		var st = $(this).parent().closest('#list').find('#st').attr('data-st');
		total-=st;
		$('#info_total').html("Total : " + format_uang(total));
		$(this).parent().closest('#list').remove();		
	});
	$('#select_jenis').on('change', function(){
		if ($(this).val() == 'Lunas') {
			$('#tenor').val('0').attr("readonly","readonly");
		} else {
			$('#tenor').val('').removeAttr("readonly");
		}
	})
})
</script>
