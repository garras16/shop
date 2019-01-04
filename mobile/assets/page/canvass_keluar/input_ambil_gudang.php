<?php
$sql=mysql_query("SELECT * FROM canvass_keluar WHERE id_canvass_keluar=$id AND (status=0 OR status=9)");
if (mysql_num_rows($sql)=='0'){
	_alert("Input Gagal. Barang sudah selesai diperiksa.");
	_direct("?page=canvass_keluar&mode=ambil_gudang");
	break;
}
if (isset($tambah_ambil_gudang_mobil_post)){
	$sql = mysql_query("UPDATE canvass_keluar SET id_mobil=$id_mobil WHERE id_canvass_keluar=$id");
	$sql = mysql_query("SELECT id_canvass_keluar_barang
FROM
    canvass_keluar_barang
    INNER JOIN barang 
        ON (canvass_keluar_barang.id_barang = barang.id_barang)
WHERE id_canvass_keluar=$id AND barang.status=0");
$nonaktif=false;
	while ($row=mysql_fetch_array($sql)){
		if (mysql_num_rows($sql)>0) $nonaktif=true;
		$sql2=mysql_query("DELETE FROM canvass_keluar_barang WHERE id_canvass_keluar_barang=" .$row['id_canvass_keluar_barang']. "");
	}
	if ($nonaktif) _alert("Ada barang yang tidak disimpan.");
	
	$sql=mysql_query("SELECT * FROM canvass_keluar_barang WHERE id_canvass_keluar=$id");
	while ($row=mysql_fetch_array($sql)){
		$id_barang=$row['id_barang'];
		$id_barang_masuk_rak=$row['id_barang_masuk_rak'];
		$stok_mobil=$row['qty'];
		$sql2=mysql_query("SELECT stok FROM barang_masuk_rak WHERE id_barang_masuk_rak=$id_barang_masuk_rak");
		$row2=mysql_fetch_array($sql2);
		$stok=$row2['stok']-$stok_mobil;
		
		if ($stok<0){
			tulis_log(date('d-m-Y H;i'). ' Stok minus selesai imput_ambil_gudang&id=' .$id);
			tulis_log('stok=' .$row2['stok']. ' stok_mobil=' .$stok_mobil);
			tulis_log("UPDATE barang_masuk_rak SET stok=" .$stok. " WHERE id_barang_masuk_rak=" .$id_barang_masuk_rak);
		}
		$sql3=mysql_query("UPDATE barang_masuk_rak SET stok=$stok WHERE id_barang_masuk_rak=$id_barang_masuk_rak");
	}
	$sql=mysql_query("UPDATE canvass_keluar SET status='9' WHERE id_canvass_keluar=$id");
	_direct("?page=canvass_keluar&mode=ambil_gudang");
}
if (isset($tambah_ambil_gudang_karyawan_post)){
	$sql = mysql_query("INSERT INTO canvass_keluar_karyawan VALUES(null,$id,$id_karyawan)");
}
if (isset($tambah_ambil_gudang_barang_post)){
	$sql=mysql_query("SELECT *
FROM
    barang_supplier
    INNER JOIN barang 
        ON (barang_supplier.id_barang = barang.id_barang)
    INNER JOIN beli_detail 
        ON (beli_detail.id_barang_supplier = barang_supplier.id_barang_supplier)
    INNER JOIN barang_masuk 
        ON (barang_masuk.id_beli_detail = beli_detail.id_beli_detail)
    INNER JOIN barang_masuk_rak 
        ON (barang_masuk_rak.id_barang_masuk = barang_masuk.id_barang_masuk)
    INNER JOIN rak 
        ON (barang_masuk_rak.id_rak = rak.id_rak)
    INNER JOIN gudang 
        ON (rak.id_gudang = gudang.id_gudang)
WHERE stok > 0 AND barang.id_barang=" .$id_barang. " AND barang.status=1 AND barang_masuk_rak.id_rak=" .$id_rak. " AND barang_masuk_rak.expire='$expire'");// AND barang_masuk_rak.id_barang_masuk_rak >= $id_barang_masuk_rak");
	$total_qty_ambil=0;
	$tmp_qty_ambil=$qty;
	while ($row=mysql_fetch_array($sql)){
		$id_barang_masuk_rak=$row['id_barang_masuk_rak'];
		$expire=$row['expire'];
		$stok=$row['stok'];
		if ($tmp_qty_ambil>=$stok){
			if ($total_qty_ambil<=$qty){
				$sql2=mysql_query("INSERT INTO canvass_keluar_barang VALUES(null,$id,'$tanggal',$id_barang_masuk_rak,$id_barang,$id_rak,'$expire',$stok,null,null)");
				$total_qty_ambil+=$stok;
				$tmp_qty_ambil-=$stok;
			}
		} else {
			if ($total_qty_ambil<$qty){
				$sql2=mysql_query("INSERT INTO canvass_keluar_barang VALUES(null,$id,'$tanggal',$id_barang_masuk_rak,$id_barang,$id_rak,'$expire',$tmp_qty_ambil,null,null)");
				$total_qty_ambil+=$tmp_qty_ambil;
				$tmp_qty_ambil-=$stok;
			}
		}
	}
}
if (isset($update_ambil_gudang_barang_post)){
	$sql=mysql_query("SELECT *
FROM
    barang_supplier
    INNER JOIN barang 
        ON (barang_supplier.id_barang = barang.id_barang)
    INNER JOIN beli_detail 
        ON (beli_detail.id_barang_supplier = barang_supplier.id_barang_supplier)
    INNER JOIN barang_masuk 
        ON (barang_masuk.id_beli_detail = beli_detail.id_beli_detail)
    INNER JOIN barang_masuk_rak 
        ON (barang_masuk_rak.id_barang_masuk = barang_masuk.id_barang_masuk)
    INNER JOIN rak 
        ON (barang_masuk_rak.id_rak = rak.id_rak)
    INNER JOIN gudang 
        ON (rak.id_gudang = gudang.id_gudang)
WHERE stok > 0 AND barang.id_barang=" .$id_barang. " AND barang.status=1 AND barang_masuk_rak.id_rak=" .$id_rak. " AND barang_masuk_rak.expire='$expire'");// AND barang_masuk_rak.id_barang_masuk_rak >= $id_barang_masuk_rak");
	$total_qty_ambil=0;
	$tmp_qty_ambil=$qty;
	while ($row=mysql_fetch_array($sql)){
		$id_barang_masuk_rak=$row['id_barang_masuk_rak'];
		$expire=$row['expire'];
		$stok=$row['stok'];
		if ($tmp_qty_ambil>=$stok){
			if ($total_qty_ambil<=$qty){
				$updater=($stok-$stok);
				$sql2=mysql_query("INSERT INTO canvass_keluar_barang VALUES(null,$id,'$tanggal',$id_barang_masuk_rak,$id_barang,$id_rak,'$expire',$stok,null,null)");
				$total_qty_ambil+=$stok;
				$tmp_qty_ambil-=$stok;
				$sql3=mysql_query("UPDATE barang_masuk_rak SET stok=$updater WHERE id_barang_masuk_rak=$id_barang_masuk_rak");
			}
		} else {
			if ($total_qty_ambil<$qty){
				$updater=($stok-$tmp_qty_ambil);
				$sql2=mysql_query("INSERT INTO canvass_keluar_barang VALUES(null,$id,'$tanggal',$id_barang_masuk_rak,$id_barang,$id_rak,'$expire',$tmp_qty_ambil,null,null)");
				$total_qty_ambil+=$tmp_qty_ambil;
				$tmp_qty_ambil-=$stok;
				$sql3=mysql_query("UPDATE barang_masuk_rak SET stok=$updater WHERE id_barang_masuk_rak=$id_barang_masuk_rak");
			}
		}
	}
}
if (isset($kembali_barang_ke_gudang_post)){
	$tgl = explode("/", $expire);
	$expire = $tgl[2] ."-". $tgl[1] ."-". $tgl[0];
	$sql=mysql_query("SELECT *,SUM(qty) as qty FROM canvass_keluar_barang WHERE id_canvass_keluar=$id AND id_barang=$id_barang AND expire='$expire' HAVING SUM(qty)>=$qty_balik");
	if (mysql_num_rows($sql)>0){
		$sql=mysql_query("SELECT * FROM canvass_keluar_barang WHERE id_canvass_keluar=$id AND id_barang=$id_barang AND expire='$expire'");
		$total_qty_balik=0;
		$tmp_qty_balik=$qty_balik;
		while ($row=mysql_fetch_array($sql)){
			$id_barang_masuk_rak=$row['id_barang_masuk_rak'];
			$stok=$row['stok'];
			if ($total_qty_balik==$qty_balik) break;
			if ($tmp_qty_balik>=$stok){
				$qty_kembali=$stok;
				//$sql2=mysql_query("UPDATE canvass_keluar_barang SET qty=0,qty_cek=0,stok=0 WHERE id_canvass_keluar=$id AND id_barang_masuk_rak=$id_barang_masuk_rak");
				$sql2=mysql_query("DELETE FROM canvass_keluar_barang WHERE id_canvass_keluar=$id AND id_barang_masuk_rak=$id_barang_masuk_rak");
				$sql3=mysql_query("SELECT stok FROM barang_masuk_rak WHERE id_barang_masuk_rak=$id_barang_masuk_rak");
				$row3=mysql_fetch_array($sql3);
				$stok_gudang=$row3['stok']+$qty_kembali;
				$sql2=mysql_query("UPDATE barang_masuk_rak SET stok=$stok_gudang WHERE id_barang_masuk_rak=$id_barang_masuk_rak");
				$total_qty_balik+=$stok;
				$tmp_qty_balik-=$stok;
			} else {
				$qty_kembali=$stok-$tmp_qty_balik;
				$sql2=mysql_query("UPDATE canvass_keluar_barang SET qty=$qty_kembali,qty_cek=$qty_kembali,stok=$qty_kembali WHERE id_canvass_keluar=$id AND id_barang_masuk_rak=$id_barang_masuk_rak");
				$sql3=mysql_query("SELECT stok FROM barang_masuk_rak WHERE id_barang_masuk_rak=$id_barang_masuk_rak");
				$row3=mysql_fetch_array($sql3);
				$stok_gudang=$row3['stok']+$tmp_qty_balik;
				$sql2=mysql_query("UPDATE barang_masuk_rak SET stok=$stok_gudang WHERE id_barang_masuk_rak=$id_barang_masuk_rak");
				$total_qty_balik+=$tmp_qty_balik;
				$tmp_qty_balik-=$stok;
			}
		}
	} else {
		_alert("Input Salah. Silakan input kembali.");
	}
	_direct("?page=canvass_keluar&mode=input_ambil_gudang&id=$id");
}
if (isset($_GET['del_karyawan'])){
	$sql=mysql_query("DELETE FROM canvass_keluar_karyawan WHERE id_canvass_keluar_karyawan=" .$_GET['del_karyawan']. "");
	_direct("?page=canvass_keluar&mode=input_ambil_gudang&id=$id");
}
if (isset($_GET['del_barang'])){
	$sql=mysql_query("SELECT * FROM canvass_keluar_barang WHERE id_canvass_keluar_barang=" .$_GET['del_barang']. "");
	$row=mysql_fetch_array($sql);
	$sql2=mysql_query("DELETE FROM canvass_keluar_barang WHERE id_canvass_keluar=$id AND id_barang=" .$row['id_barang']. " AND id_rak=" .$row['id_rak']. " AND expire='" .$row['expire']. "'");
	_direct("?page=canvass_keluar&mode=input_ambil_gudang&id=$id");
}
$sql = mysql_query("SELECT * FROM canvass_keluar WHERE id_canvass_keluar=$id");
$row=mysql_fetch_array($sql);
$id_mobil=$row['id_mobil'];
$status=$row['status'];
$sql2 = mysql_query("SELECT * FROM canvass_keluar_karyawan WHERE id_canvass_keluar=$id");
$sql3 = mysql_query("SELECT * FROM canvass_keluar_barang WHERE id_canvass_keluar=$id");
(mysql_num_rows($sql2)>0 && mysql_num_rows($sql3)>0 ? $locked=false : $locked=true);
?>
<!-- page content -->
<div class="right_col" role="main">
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
					<div class="x_title">
						<h3>MUTASI DARI GUDANG KE MOBIL</h3>
							<?php
							if (isset($pesan)){
								echo '<span class="badge bg-' .$warna. '">' .$pesan. '</span>';
							}
							?>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<form action="" method="post">
							<input type="hidden" name="tambah_ambil_gudang_mobil_post" value="true">
							<div class="col-md-12">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-truck fa-fw"></i></span>
									<select class="form-control" id="select_mobil" name="id_mobil" required>
										<option value="" disabled selected>Pilih Mobil Canvass</option>
										<?php 
											$sql=mysql_query("SELECT * FROM kendaraan WHERE status=1 AND canvass=1");
											while($row=mysql_fetch_array($sql)){
										?>	
										<option value="<?php echo $row['id_kendaraan']; ?>" <?php echo ($row['id_kendaraan']==$id_mobil ? 'selected' : '') ?> ><?php echo $row['nama_kendaraan']. ' | ' .$row['plat'];?></option>
										<?php 
											}
										?>
									</select>
									<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
								</div>
								<table id="input_karyawan" class="table table-bordered table-striped">
									<thead>
										<tr>
											<th>Nama Karyawan</th>
											<th>Posisi</th>
											<?php
											if ($status==9){
												echo '<th></th>';
											} else {
												echo '<th><a data-toggle="modal" data-target="#myModal" class="btn btn-primary btn-xs"><i class="fa fa-search-plus"></i> Tambah Karyawan</a></th>';
											}
											?>
										</tr>
									</thead>
									<tbody>
										<?php
											$sql=mysql_query("SELECT *
FROM
    canvass_keluar_karyawan
    INNER JOIN karyawan 
        ON (canvass_keluar_karyawan.id_karyawan = karyawan.id_karyawan)
    INNER JOIN users 
        ON (karyawan.id_karyawan = users.id_karyawan) WHERE id_canvass_keluar=$id");
											while ($row=mysql_fetch_array($sql)){
												echo '<input type="hidden" name="id_karyawan" value="' .$row['id_karyawan']. '">';
												echo '<tr>
													<td>' .$row['nama_karyawan']. '</td>
													<td>' .$row['posisi']. '</td>';
												if ($status==9){
													echo '<td></td>';
												} else {
													echo '<td><a class="btn btn-danger btn-xs" href="?page=canvass_keluar&mode=input_ambil_gudang&id=' .$id. '&del_karyawan=' .$row['id_canvass_keluar_karyawan']. '"><i class="fa fa-trash"></i> HAPUS</a></td>';
												}
												echo '</tr>';
												
											}
										?>
									</tbody>
								</table>
								<table id="input_barang" class="table table-bordered table-striped">
									<thead>
										<tr>
											<th>Nama Barang</th>
											<th>Gudang</th>
											<th>Rak</th>
											<th>Tgl Exp.</th>
											<th>Qty</th>
											<th><a data-toggle="modal" data-target="#myModal2" class="btn btn-primary btn-xs"><i class="fa fa-search-plus"></i> Tambah Barang</a></th>
										</tr>
									</thead>
									<tbody>
										<?php
											$sql=mysql_query("SELECT *, SUM(qty) AS qty, SUM(qty_cek) AS qty_cek
FROM
    canvass_keluar_barang
    INNER JOIN rak 
        ON (canvass_keluar_barang.id_rak = rak.id_rak)
	INNER JOIN barang 
        ON (canvass_keluar_barang.id_barang = barang.id_barang)
    INNER JOIN gudang 
        ON (rak.id_gudang = gudang.id_gudang)
	INNER JOIN satuan 
        ON (barang.id_satuan = satuan.id_satuan)
WHERE id_canvass_keluar=$id
GROUP BY canvass_keluar_barang.id_barang,canvass_keluar_barang.id_rak,canvass_keluar_barang.expire");
											while ($row=mysql_fetch_array($sql)){
												echo '<input type="hidden" name="check_valid_barang" value="' .$row['id_barang']. '-' .$row['id_rak']. '">';
												echo '<tr>
													<td>' .$row['nama_barang']. '</td>
													<td>' .$row['nama_gudang']. '</td>
													<td>' .$row['nama_rak']. '</td>
													<td>' .date("d-m-Y",strtotime($row['expire'])). '</td>
													<td>' .$row['qty']. ' ' .$row['nama_satuan']. '</td>';
													if ($status==9){
														echo '<td>';
														if ($row['qty']==$row['qty_cek']) echo '<a data-toggle="modal" data-target="#myModal3" data-id-barang="' .$row['id_barang']. '" data-barcode="' .$row['barcode']. '" data-id-canvass="' .$row['id_canvass_keluar_barang']. '" data-satuan="' .$row['nama_satuan']. '" data-tot-ambil="' .$row['qty']. '" class="btn btn-warning btn-xs"><i class="fa fa-barcode"></i> Kembalikan Ke Gudang</a>';
														echo '</td>';
													} else {
														echo '<td><a class="btn btn-danger btn-xs" href="?page=canvass_keluar&mode=input_ambil_gudang&id=' .$id. '&del_barang=' .$row['id_canvass_keluar_barang']. '"><i class="fa fa-trash"></i> HAPUS</a></td>';
													}
													echo '</tr>';
											}
										?>
									</tbody>
								</table>
							</div>
							<?php
if ($status!=9){
	if (!$locked) {
		echo '			<center><button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button></center>';
	} else {
		echo '			<center><button type="submit" class="btn btn-primary" disabled><i class="fa fa-save"></i> Simpan</button></center>';
	}
}
?>
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
				<h4 class="modal-title">Pilih Karyawan</h4>
			</div>
			<div class="modal-body">
				<form method="post" action="" onsubmit="return cek_valid_karyawan()">
				<input type="hidden" name="tambah_ambil_gudang_karyawan_post" value="true">
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
					<select class="form-control" id="select_karyawan" name="id_karyawan" required>
						<option value="" disabled selected>Pilih Karyawan</option>
						<?php 
							$sql=mysql_query("SELECT * FROM karyawan INNER JOIN users ON (karyawan.id_karyawan = users.id_karyawan) WHERE karyawan.id_karyawan NOT IN (SELECT id_karyawan FROM canvass_keluar_karyawan WHERE id_canvass_keluar=$id)");
							while($row=mysql_fetch_array($sql)){
							$sql2=mysql_query("SELECT *
FROM
    canvass_keluar
    INNER JOIN canvass_keluar_karyawan 
        ON (canvass_keluar.id_canvass_keluar = canvass_keluar_karyawan.id_canvass_keluar)
WHERE STATUS <> 4 AND id_karyawan=". $row['id_karyawan']);
							if (mysql_num_rows($sql2)==0){
						?>	
						<option data-nama="<?php echo $row['nama_karyawan'];?>" data-posisi="<?php echo $row['posisi'];?>" value="<?php echo $row['id_karyawan']; ?>"><?php echo $row['nama_karyawan']. ' | ' .$row['posisi'];?></option>
						<?php 
							}
							}
						?>
					</select>
					<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
				</div>
			</div>
			<div class="clearfix"></div><br/>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary">Tambah</a>
			</div>
			</form>
		</div>
	</div>
</div>

<!-- modal input -->
<div id="myModal2" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&times;</button>
				<h4 class="modal-title">Pilih Barang</h4>
			</div>
			<div class="modal-body">
				<form method="post" action="" onsubmit="return cek_valid_barang()">
				<?php
					if ($status==9){
						echo '<input type="hidden" name="update_ambil_gudang_barang_post" value="true">';
					} else {
						echo '<input type="hidden" name="tambah_ambil_gudang_barang_post" value="true">';
					}
				?>
				
				<div id="get_rak" class="col-xs-12">
					
				</div>
				<div id="get_barang" class="col-xs-12">
					
				</div>
			</div>
			<div class="clearfix"></div><br/>
			<div class="modal-footer">
				<button id="simpan" type="submit" class="btn btn-primary" style="display:none">Tambah</a>
			</div>
			</form>
		</div>
	</div>
</div>

<!-- modal input -->
<div id="myModal3" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&times;</button>
				<h4 class="modal-title">Kembalikan Barang Ke Gudang</h4>
			</div>
			<div class="modal-body">
				<form method="post" action="" onsubmit="return cek_valid_barang2()">
				<input type="hidden" name="kembali_barang_ke_gudang_post" value="true">
				<input type="hidden" id="id_barang_2" name="id_barang" value="">
				<input type="hidden" id="id_canvass_keluar_barang_2" name="id_canvass_keluar_barang" value="">
				<input type="hidden" id="qty_ambil_2" name="qty_ambil" value="">
				<input type="hidden" id="barcode_barang_2" value="">
				<div id="get_rak_2" class="col-xs-12">
					
				</div>
				<div class="form-group col-sm-12">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-bookmark fa-fw"></i> Total Qty Ambil</span>
						<input class="form-control" id="tot_qty_ambil" placeholder="Total Qty Ambil" value="" readonly>
						<span class="input-group-addon satuan"></span>
						<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-tags fa-fw"></i></span>
						<input class="form-control" type="tel" id="qty_balik" name="qty_balik" placeholder="Qty Kembali Ke Gudang" value="" required>
						<span class="input-group-addon satuan"></span>
						<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
						<input class="form-control" id="expire_2" type="tel" name="expire" placeholder="Tgl Exp." value="" required>
						<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
					</div>
				</div>
			</div>
			<div class="clearfix"></div><br/>
			<div class="modal-footer">
				<button id="simpan_2" type="submit" class="btn btn-primary" style="display:none">Simpan</a>
			</div>
			</form>
		</div>
	</div>
</div>

<script>
function cek_valid_barang2(){
	var tot_qty_ambil = Number($('#tot_qty_ambil').val());
	var qty_balik = Number($('#qty_balik').val());
	
	if (qty_balik == '0') {
		AndroidFunction.showToast("Qty Kembali Ke Gudang harus lebih dari 0.");
		return false;
	} else if (tot_qty_ambil < qty_balik){
		AndroidFunction.showToast("Total Qty Ambil tidak boleh melebihi Qty Kembali Ke Gudang.");
		return false;
	}
	return true;
}
function cek_valid_karyawan(){
	var cari_data_add = $('#select_karyawan').find(':selected');
	var id = cari_data_add.val();
	if ($('#input_karyawan').html().search('name="id_karyawan" value="' + id + '"')=='-1' && id !==''){
		return true;
	} else {
		if (id==''){
			alert("Silahkan pilih karyawan.");
			AndroidFunction.showToast("Silahkan pilih karyawan.");
		} else {
			alert("Karyawan sudah pernah dipilih.");
			AndroidFunction.showToast("Karyawan sudah pernah dipilih.");
		}
		return false;
	}
}
function cek_valid_barang(){
	var id_rak = $('#get_rak').find('#id_rak').val();
	var nama = $('#get_barang').find('#select_barang').find(':selected').data('nama');
	var stok = $('#get_barang').find('#stok').val();
	var min_order = $('#get_barang').find('#min').val();
	var id = $('#get_barang').find('#select_barang').val();
	var qty = $('#get_barang').find('#qty').val();
	
	if (Number(stok) >= Number(qty) && Number(qty) >= Number(min_order)){
		return true;
	} else {
		if (Number(qty) > Number(stok)) {
			alert("Qty melebihi stok.");
			AndroidFunction.showToast("Qty melebihi stok.");
		} else if (Number(min_order) > Number(qty)) {
			alert("Qty harus melebihi Minimal Order.");
			AndroidFunction.showToast("Qty harus melebihi Minimal Order.");
		}
		return false;
	}
}
function getBack(){
	if ($('#myModal').is(':visible')){
		$('#myModal').modal('hide');
	} else if ($('#myModal2').is(':visible')){
		$('#myModal2').modal('hide');
	} else {
		window.location="?page=canvass_keluar&mode=ambil_gudang";
	}
}
function batal_scan(){
	if ($('#myModal2').is(':visible')){
		$('#myModal2').modal("hide");
	}
	if ($('#myModal3').is(':visible')){
		$('#myModal3').modal("hide");
	}
}
function cek_scan_rak(barcode1){
	$('#get_rak').html('<center><i class="fa fa-spinner fa-spin" style="font-size:24px"></i></center>');
	$('#get_rak').load('assets/page/canvass_keluar/get-rak.php?id=' + barcode1,function(){
		if($('#get_rak').html()==''){
			alert("Rak tidak ditemukan.");
			AndroidFunction.showToast("Rak tidak ditemukan.");
			batal_scan();
		} else {
			AndroidFunction.scan_barang();
		}
	});
}
function cek_scan_rak2(barcode1){
	$('#get_rak_2').html('<center><i class="fa fa-spinner fa-spin" style="font-size:24px"></i></center>');
	$('#get_rak_2').load('assets/page/canvass_keluar/get-rak.php?id=' + barcode1,function(){
		if($('#get_rak_2').html()==''){
			alert("Rak tidak ditemukan.");
			AndroidFunction.showToast("Rak tidak ditemukan.");
			batal_scan();
		} else {
			AndroidFunction.scan_barang2();
		}
	});
}
function cek_scan_barang(barcode1){
	var id_rak = $('#get_rak').find('#id_rak').val();
	$('#get_barang').html('<center><i class="fa fa-spinner fa-spin" style="font-size:24px"></i></center>');
	$('#get_barang').load('assets/page/canvass_keluar/get-barang.php?rak=' + id_rak + '&id=' + barcode1 + '&canvass=<?php echo $id ?>',function(){
		if($('#get_barang').html()==''){
			alert("Barang tidak ditemukan.");
			AndroidFunction.showToast("Barang tidak ditemukan.");
			batal_scan();
			$('#simpan').attr("style","display:none");
		} else {
			$('#simpan').attr("style","");
		}
	});
}
function cek_scan_barang2(barcode1){
	var barcode2 = $('#barcode_barang_2').val();
	if (barcode1 == barcode2){
		$('#qty_balik').removeAttr("disabled");
		$('#simpan_2').attr("style","");
	} else {
		AndroidFunction.showToast("Barcode Barang tidak sama.");
		batal_scan();
	}
}

$(document).ready(function(){
	$('#myModal').on('show.bs.modal', function(e){
		$('#select_karyawan').val('').trigger("change");
	})
	$('#myModal2').on('show.bs.modal', function(e){
		AndroidFunction.scan_rak();
	})
	$('#myModal3').on('show.bs.modal', function(e){
		var id_barang = $(e.relatedTarget).data('id-barang');
		var barcode_barang = $(e.relatedTarget).data('barcode');
		var tot_ambil = $(e.relatedTarget).data('tot-ambil');
		var satuan = $(e.relatedTarget).data('satuan');
		$('#id_barang_2').val(id_barang);
		$('#barcode_barang_2').val(barcode_barang);
		$('#tot_qty_ambil').val(tot_ambil);
		$('#qty_balik').attr("disabled","disabled");
		$('#simpan_2').attr("style","display:none");
		$('.satuan').html(satuan);
		AndroidFunction.scan_rak2();
	})
	$('#input_karyawan').on('click', '.remove_cart', function(e) {
		e.preventDefault();
		$(this).parent().closest('#list').remove();		
	});
	$('#input_barang').on('click', '.remove_cart', function(e) {
		e.preventDefault();
		$(this).parent().closest('#list').remove();		
	});
	$('#expire_2').inputmask("datetime",{inputFormat: "dd/mm/yyyy",oncomplete: function(){
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
});
</script>