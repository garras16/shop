<?php
//$_SESSION['id_pelanggan']='1';
//$_SESSION['nama_pelanggan']='TOKO ANGIN RIBUT';
//$sql=mysqli_query($con, "SELECT * FROM nota_siap_kirim WHERE id_jual=$id AND status=1");
$sql=mysqli_query($con, "SELECT * FROM nota_siap_kirim WHERE id_jual=$id AND status=1");
(mysqli_num_rows($sql)>0 ? $locked=true : $locked=false);
if (isset($edit_penjualan_post) && !$locked){
	$sql=mysqli_query($con, "SELECT *
	FROM
		harga_jual
		INNER JOIN barang_supplier 
			ON (harga_jual.id_barang_supplier = barang_supplier.id_barang_supplier)
		INNER JOIN barang 
			ON (barang_supplier.id_barang = barang.id_barang)
	WHERE id_harga_jual=" .$id_harga_jual. " AND status=1");
		if (mysqli_num_rows($sql)=='0'){
			_alert("Ada barang yang tidak disimpan.");
/*			_direct("?page=sales&mode=edit_penjualan");
			break;*/
		} else {
			$sql = "INSERT INTO jual_detail VALUES(null,$id,$id_harga_jual,$qty,$harga,$diskon_persen_1,$diskon_rp_1,$diskon_persen_2,$diskon_rp_2,$diskon_persen_3,$diskon_rp_3)";
			$q = mysqli_query($con, $sql);
			if ($q){
				_buat_pesan("Input Berhasil","green");
			} else {
				_buat_pesan("Input Gagal","red");
			}
		}
	_direct("?page=sales&mode=edit_penjualan&id=$id");
}
if (isset($_GET['del']) && !$locked){
	$sql=mysqli_query($con, "SELECT id_karyawan FROM users WHERE posisi='OWNER'");
	$row=mysqli_fetch_array($sql);
	$id_owner=$row['id_karyawan'];
	
	$sql=mysqli_query($con, "SELECT tgl_nota, invoice, nama_pelanggan, nama_barang, nama_satuan, qty
FROM
    jual
    INNER JOIN jual_detail 
        ON (jual.id_jual = jual_detail.id_jual)
    INNER JOIN harga_jual 
        ON (jual_detail.id_harga_jual = harga_jual.id_harga_jual)
	INNER JOIN pelanggan 
        ON (jual.id_pelanggan = pelanggan.id_pelanggan)
    INNER JOIN barang_supplier 
        ON (harga_jual.id_barang_supplier = barang_supplier.id_barang_supplier)
    INNER JOIN barang 
        ON (barang_supplier.id_barang = barang.id_barang)
    INNER JOIN satuan 
        ON (barang.id_satuan = satuan.id_satuan)
	WHERE jual_detail.id_jual_detail=" .$_GET['del']);
	$row=mysqli_fetch_array($sql);
	
	$judul='Ada barang yang dihapus sales.';
	$pesan='Tipe: Dalam Kota\r\nTgl Nota Jual : ' .date("d-m-Y",strtotime($row['tgl_nota'])). '\r\nNo Nota Jual : ' .$row['invoice']. '\r\nNama Pelanggan : ' .$row['nama_pelanggan']. '\r\n';
	$pesan.='Nama Sales : ' .$_SESSION['user']. '\r\nNama Barang : ' .$row['nama_barang']. '\r\n\t' .$row['qty']. ' ' .$row['nama_satuan']. '\r\n';
	$tanggal=date("Y-m-d H:i:s");
	$sql=mysqli_query($con, "INSERT INTO pesan VALUES(null,'$tanggal',$id_owner,'$judul','$pesan',0)");
	$sql=mysqli_query($con, "DELETE FROM jual_detail WHERE id_jual_detail=" .$_GET['del']. "");
	$sql=mysqli_query($con, "DELETE FROM nota_siap_kirim_detail WHERE id_jual_detail=" .$_GET['del']. "");
	_direct("?page=sales&mode=edit_penjualan&id=$id");
}
if (isset($edit_diskon_nota_jual) && !$locked){
	$sql=mysqli_query($con, "UPDATE jual SET diskon_all_persen=$diskon_all_persen WHERE id_jual=$id");
	_direct("?page=sales&mode=edit_penjualan&id=$id");
}
$id_karyawan=$_SESSION['id_karyawan'];
$sql=mysqli_query($con, "SELECT
    jual.id_jual
    , jual.tgl_nota
    , jual.invoice
    , jual.jenis_bayar
	, jual.tenor
    , jual.status_konfirm
    , jual.diskon_all_persen
    , pelanggan.id_pelanggan
    , pelanggan.nama_pelanggan
FROM
    jual
    INNER JOIN pelanggan 
        ON (jual.id_pelanggan = pelanggan.id_pelanggan)
WHERE id_jual=$id");
$row=mysqli_fetch_array($sql);
$jenis_bayar=$row['jenis_bayar'];
$diskon_all_persen=$row['diskon_all_persen'];
?>
<div class="right_col loading" role="main">
	<div class="">
	
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<h3>UBAH NOTA PENJUALAN</h3>
					</div>
					<div class="x_content">
						<div id="content">
							<input type="hidden" id="id_pelanggan" name="id_pelanggan" value="<?php echo $_SESSION['id_pelanggan'] ?>">
							<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
									<input id="tanggal" name="tanggal" title="Tanggal Nota Jual" type="text" class="form-control" placeholder="Tanggal" value="<?php echo date("d-m-Y", strtotime($row['tgl_nota'])) ?>" readonly>
									<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
								</div>
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-building fa-fw"></i></span>
									<input id="nama_pelanggan" name="nama_pelanggan" title="Nama Pelanggan" type="text" class="form-control" placeholder="Nama Toko" value="<?php echo $row['nama_pelanggan'] ?>" readonly>
									<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
								</div>
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-file fa-fw"></i></span>
									<input id="invoice" name="invoice" title="No Nota Jual" type="text" class="form-control" placeholder="Invoice" value="<?php echo $row['invoice'] ?>" readonly>
									<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
								</div>
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-dollar fa-fw"></i></span>
									<select class="select2 form-control" id="select_jenis" disabled required>
										<option value="" disabled selected>Pilih Jenis Bayar</option>
										<option value="Lunas">Lunas</option>
										<option value="Kredit">Kredit</option>
									</select>
									<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
								</div>
								<input id="tenor" name="tenor" type="hidden" value="<?php echo $row['tenor'] ?>" >
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-tags fa-fw"></i></span>
									<input id="tenor_view" name="tenor_view" title="Tenor" type="text" class="form-control" placeholder="Tenor" value="<?php echo $row['tenor'] ?> hari" readonly>
									<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
								</div>
								<form method="post" onsubmit="return cek_valid()">
								<div class="input-group">
									<span class="input-group-addon">Diskon Nota Jual (%)</span>
									<input type="number" max="100" min="0" class="form-control" id="diskon" name="diskon_all_persen" value="<?php echo $row['diskon_all_persen'] ?>" readonly required>
									<span class="input-group-btn">
										<input type="hidden" name="edit_diskon_nota_jual" value="true">
										<input id="btn_save" type="submit" class="btn btn-primary" value="Edit Diskon Nota Jual">
									</span>
								</div>
								</form>
								<div class="text-right">
								<?php
								if (!$locked)
									echo '<a onClick="cek_jenis();" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Barang</a>';
								?>
								</div>
								<div id="input_brg" class="col-xs-12">
									<div style="overflow-x: auto">
									<table class="table table-bordered table-striped">
										<thead>
											<th>Nama Barang</th>
											<th>Qty</th>
											<th>Harga Jual (Rp)</th>
											<th>Tot. Seb. Diskon (Rp)</th>
											<th>Disc 1 (Rp)</th>
											<th>Tot. set. disc 1 (Rp)</th>
											<th>Disc 2 (Rp)</th>
											<th>Tot. set. disc 2 (Rp)</th>
											<th>Disc 3 (Rp)</th>
											<th>Tot. set. disc 3 (Rp)</th>
											<th></th>
										</thead>
										<tbody>
<?php
	$sql=mysqli_query($con, "SELECT
    jual_detail.id_jual_detail
    , jual_detail.id_harga_jual
    , jual_detail.qty
	, jual_detail.harga
	, jual_detail.diskon_persen
	, jual_detail.diskon_rp
	, jual_detail.diskon_persen_2
	, jual_detail.diskon_rp_2
	, jual_detail.diskon_persen_3
	, jual_detail.diskon_rp_3
    , harga_jual.harga_jual
    , barang.nama_barang
    , satuan.nama_satuan
FROM
    jual_detail
    INNER JOIN harga_jual 
        ON (jual_detail.id_harga_jual = harga_jual.id_harga_jual)
    INNER JOIN barang_supplier 
        ON (harga_jual.id_barang_supplier = barang_supplier.id_barang_supplier)
    INNER JOIN barang 
        ON (barang_supplier.id_barang = barang.id_barang)
	INNER JOIN satuan 
        ON (barang.id_satuan = satuan.id_satuan)
WHERE id_jual=$id");
$total=0;
while ($row=mysqli_fetch_array($sql)){
	$diskon1=$row['harga_jual']*$row['diskon_persen']/100;
	$tot_set_disk_1=$row['qty']*($row['harga_jual']-$diskon1);
	$diskon2=($row['harga_jual']-$diskon1)*$row['diskon_persen_2']/100;
	$tot_set_disk_2=$row['qty']*($row['harga_jual']-$diskon1-$diskon2);
	$diskon3=($row['harga_jual']-$diskon1-$diskon2)*$row['diskon_persen_3']/100;
	$tot_set_disk_3=$row['qty']*($row['harga_jual']-$diskon1-$diskon2-$diskon3);
$total+=$tot_set_disk_3;
$st=$tot_set_disk_3;
	echo '<tr id="list">
			<input type="hidden" name="id_harga_jual[]" value="' .$row['id_harga_jual']. '">
			<input type="hidden" name="qty[]" value="' .$row['qty']. '">
			<input type="hidden" name="harga[]" value="' .$row['harga']. '">
			<input type="hidden" name="diskon_persen_1[]" value="' .$row['diskon_persen']. '">
			<input type="hidden" name="diskon_rp_1[]" value="' .$row['diskon_rp']. '">
			<input type="hidden" name="diskon_persen_2[]" value="' .$row['diskon_persen_2']. '">
			<input type="hidden" name="diskon_rp_2[]" value="' .$row['diskon_rp_2']. '">
			<input type="hidden" name="diskon_persen_3[]" value="' .$row['diskon_persen_3']. '">
			<input type="hidden" name="diskon_rp_3[]" value="' .$row['diskon_rp_3']. '">
			<td style="min-width:150px">' .$row['nama_barang']. '</td>
			<td style="min-width:100px">' .$row['qty']. ' ' .$row['nama_satuan']. '</td>
			<td style="min-width:70px">' .format_uang($row['harga_jual']). '</td>
			<td style="min-width:70px">' .format_uang($row['qty']*$row['harga_jual']). '</td>
			<td style="min-width:70px">' .format_uang($diskon1). '</td>
			<td style="min-width:70px">' .format_uang($tot_set_disk_1). '</td>
			<td style="min-width:70px">' .format_uang($diskon2). '</td>
			<td style="min-width:70px">' .format_uang($tot_set_disk_2). '</td>
			<td style="min-width:70px">' .format_uang($diskon3). '</td>
			<td id="st" data-st="' .$st. '">' .format_uang($st). '</td>';
	if (!$locked) {
		echo '	<td><a href="?page=sales&mode=edit_penjualan&id=' .$id. ' &del=' .$row['id_jual_detail']. '" class="btn btn-primary btn-xs">Hapus</a></td>';
	} else {
		echo '	<td></td>';
	}
	echo '  </tr>';
}
$diskon_all_rp=($diskon_all_persen/100)*$total;
?>
											<tr id="info2">
												<td colspan="9">Diskon Nota Jual (Rp)</td>
												<td id="info_diskon_all"><?php echo format_uang($diskon_all_rp) ?></td>
												<td></td>
											</tr>
											<tr id="info">
												<td colspan="9">Total Jual(Rp)</td>
												<td id="info_total"><?php echo format_uang($total) ?></td>
												<td></td>
											</tr>
										</tbody>
									</table>
									</div>
								</div>
								<div class="clearfix"></div>
								<div id="dummy" style="display:none"></div>
							</form>
						</div>
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
				<h4 class="modal-title">Pilih Barang</h4>
			</div>
			<div class="modal-body">
				<form action="" method="post" onsubmit="return cek_add_barang();">
				<input type="hidden" name="edit_penjualan_post" value="true">
				<input type="hidden" id="id_harga_jual" name="id_harga_jual" value="">
				<div id="get_barang" class="col-xs-12">
					
				</div>
			</div>
			<div class="clearfix"></div><br/>
			<div class="modal-footer">
				<input id="btn_simpan" type="submit" class="btn btn-primary" value="Simpan">
			</div>
				</form>
		</div>
	</div>
</div>

<script>
var total = <?php echo $total ?>;
function cek_jenis(){
	if ($('#select_jenis').val()==null){
		AndroidFunction.showToast("Silahkan Pilih Jenis Pembayaran.");
		alert('Silahkan Pilih Jenis Pembayaran.');
	} else {
		if ($('#select_jenis').val()=='Kredit' && $('#tenor').val() > 0){
			$('#jenis_bayar').val($('#select_jenis').val());
			$('#select_jenis').attr("disabled","disabled");
			$('#tenor').attr("disabled","disabled");
			$('#myModal').modal('show');
		} else if ($('#select_jenis').val()=='Lunas'){
			$('#jenis_bayar').val($('#select_jenis').val());
			$('#select_jenis').attr("disabled","disabled");
			$('#tenor').attr("disabled","disabled");
			$('#myModal').modal('show');
		} else {
			alert('Silahkan Pilih Tenor.');
			AndroidFunction.showToast("Silahkan Pilih Tenor.");
		}
	}
}

function cek_add_barang(){
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
	$('#id_harga_jual').val(id_harga_jual);
	
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
	return valid;
}

function getBack(){
	if ($('#myModal').is(':visible')){
		$('#myModal').modal('hide');
	} else {
		window.location="?page=sales&mode=view_penjualan";
	}
}

function cek_valid(){
	if ($('#btn_save').val()=='Edit Diskon Nota Jual'){
		$('#btn_save:submit').val('Simpan Diskon Nota Jual');
		$('#diskon').removeAttr('readonly');
		return false;
	} else {
		return true;
	}
}

$(document).ready(function(){
	$('#select_jenis').val('<?php echo $jenis_bayar ?>');
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
})
</script>
