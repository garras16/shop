<?php
if (isset($tambah_gudang_jual_detail)){
	$sql = "INSERT INTO jual_detail VALUES(null,$id,$id_harga_jual,$qty,$harga,0,0)";
	$q = mysqli_query($con, $sql);
	if ($q){
		_buat_pesan("Input Berhasil","green");
	} else {
		_buat_pesan("Input Gagal","red");
	}
	_direct("?page=gudang&mode=edit_jual_detail&id=" .$id);
}
if (isset($_GET['del'])){
	$sql = "DELETE FROM jual_detail WHERE id_jual_detail=" .$_GET['del'];
	$q = mysqli_query($con, $sql);
	if ($q){
		_buat_pesan("Input Berhasil","green");
	} else {
		_buat_pesan("Input Gagal","red");
	}
	$sql=mysqli_query($con, "DELETE FROM nota_siap_kirim_detail WHERE id_jual_detail=" .$_GET['del']. "");
	$sql = mysqli_query($con, "SELECT * FROM jual_detail WHERE id_jual=" .$id. "");
	if (mysqli_num_rows($sql)>0){
		_direct("?page=gudang&mode=edit_jual_detail&id=" .$id);
	} else {
		$sql = mysqli_query($con, "DELETE FROM jual WHERE id_jual=" .$id. "");
		_direct("?page=gudang&mode=konfirm_jual");
	}
}
$id_karyawan=$_SESSION['id_karyawan'];
$sql=mysqli_query($con, "SELECT
    jual.id_jual
    , jual.tgl_nota
    , jual.invoice
    , jual.jenis_bayar
	, jual.tenor
    , jual.status_konfirm
    , pelanggan.id_pelanggan
    , pelanggan.nama_pelanggan
FROM
    jual
    INNER JOIN pelanggan 
        ON (jual.id_pelanggan = pelanggan.id_pelanggan)
WHERE id_jual=$id");
$row=mysqli_fetch_array($sql);
$jenis_bayar=$row['jenis_bayar'];
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
								<input type="hidden" id="jenis_bayar" name="jenis_bayar" value="<?php echo $jenis_bayar ?>">
								<input type="hidden" id="id_pelanggan" name="id_pelanggan" value="<?php echo $row['id_pelanggan'] ?>">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
									<input id="tanggal" name="tanggal" title="Tanggal Nota Jual" type="text" class="form-control" placeholder="Tanggal" value="<?php echo $row['tgl_nota'] ?>" readonly>
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
								<div class="text-right">
									<a data-toggle="modal" data-target="#myModal" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Barang</a>
								</div>
								<div id="input_brg" class="col-xs-12">
									<div style="overflow-x: auto">
									<table class="table table-bordered table-striped">
										<thead>
											<th>Nama Barang</th>
											<th>Qty</th>
											<th>Harga Jual (Rp)</th>
											<th>Diskon 1 (Rp)</th>
											<th>Diskon 2 (Rp)</th>
											<th>Diskon 3 (Rp)</th>
											<th>Subtotal (Rp)</th>
											<th></th>
										</thead>
										<tbody>
<?php
	$sql=mysqli_query($con, "SELECT
    jual_detail.id_harga_jual
    , jual_detail.id_jual_detail
    , jual_detail.qty
	, jual_detail.harga
	, jual_detail.diskon_rp
	, jual_detail.diskon_rp_2
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
$total+=$row['qty']*($row['harga_jual']-$row['diskon_rp']-$row['diskon_rp_2']-$row['diskon_rp_3']);
$st=$row['qty']*($row['harga_jual']-$row['diskon_rp']-$row['diskon_rp_2']-$row['diskon_rp_3']);
$sql5=mysqli_query($con, "SELECT * FROM nota_siap_kirim_detail WHERE id_jual_detail=" .$row['id_jual_detail']. "");
$x=mysqli_num_rows($sql5);
	echo '<tr id="list">
			<input type="hidden" name="id_harga_jual[]" value="' .$row['id_harga_jual']. '">
			<input type="hidden" name="qty[]" value="' .$row['qty']. '">
			<input type="hidden" name="harga[]" value="' .$row['harga']. '">
			<td>' .$row['nama_barang']. '</td>
			<td>' .$row['qty']. ' ' .$row['nama_satuan']. '</td>
			<td>Rp ' .format_uang($row['harga_jual']). '</td>
			<td>Rp ' .format_uang($row['diskon_rp']). '</td>
			<td>Rp ' .format_uang($row['diskon_rp_2']). '</td>
			<td>Rp ' .format_uang($row['diskon_rp_3']). '</td>
			<td id="st" data-st="' .$st. '">Rp ' .format_uang($st). '</td>';
if ($x=='0'){
	echo '		<td><a href="?page=gudang&mode=edit_jual_detail&id=' .$id. '&del=' .$row['id_jual_detail']. '" class="btn btn-primary btn-xs"><i class="fa fa-trash"></i> Hapus</a></td>';
} else {
	echo '		<td></td>';
}
echo '		  </tr>';
}	
?>
											<tr id="info">
												<td colspan="4">Total</td>
												<td id="info_total">Rp. <?php echo format_uang($total) ?></td>
												<td></td>
											</tr>
										</tbody>
									</table>
									</div>
								</div>
								<div class="clearfix"></div>
								<div id="dummy" style="display:none"></div>
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
				<form method="post" onsubmit="return add_barang()">
				<div id="get_barang" class="col-xs-12">
					
				</div>
			</div>
			<div class="clearfix"></div><br/>
			<div class="modal-footer">
				<input type="submit" class="btn btn-primary" value="Tambah">
			</div>
			</form>			
		</div>
	</div>
</div>

<script>
function cek_valid(){
	if ($('#input_brg').html().search('id_harga_jual')=='-1'){
		AndroidFunction.showToast('Silahkan Pilih Barang');
		return false;
	} else {
		return true;
	}
}
function add_barang(){
	var id_harga_jual = $('#select_barang').val();
	var nama = $('#select_barang').find(':selected').data('nama');
	var stok = $('#select_barang').find(':selected').data('stok');
	var min_order = $('#select_barang').find(':selected').data('min');
	var harga = $('#harga_jual').val();
	var qty = $('#qty').val();
	var subtotal = harga*qty;
	if ($('#input_brg').html().search('value="' + id_harga_jual + '"')=='-1' && $('#input_brg').html().search(nama)=='-1' && stok >= qty && qty >= min_order){
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
		return true;
	} else {
		return false;
	}
}

function getBack(){
	if ($('#myModal').is(':visible')){
		$('#myModal').modal('hide');
	} else {
		window.location="?page=gudang&mode=konfirm_jual_2&id=<?php echo $id ?>";
	}
}

$(document).ready(function(){
	$('#select_jenis').val('<?php echo $jenis_bayar ?>');
	$('#myModal').on('show.bs.modal', function(e){
		var jenis=$('#select_jenis').val();
		var id=$('#id_pelanggan').val();
		var tenor=$('#tenor').val();
		if (jenis=='Lunas'){
			$('#get_barang').load('assets/page/gudang/input_brg_tunai.php?id=' + id,function(){
			});
		} else {
			$('#get_barang').load('assets/page/gudang/input_brg_kredit.php?id=' + id + '&tenor=' + tenor,function(){
			});
		}
	})
})
</script>
