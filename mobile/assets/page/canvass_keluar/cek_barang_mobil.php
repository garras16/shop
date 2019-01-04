<?php
if (isset($batal_cek_barang_mobil_post)){
	foreach ($id_canvass_keluar as $key => $value) {
		$sql = mysql_query("UPDATE canvass_keluar SET status=9 WHERE id_canvass_keluar=$value");
	}
	_direct("?page=canvass_keluar&mode=cek_barang_mobil");
} elseif (isset($batal_cek_kembali_gudang_post)){
	foreach ($id_canvass_keluar as $key => $value) {
		$sql = "UPDATE canvass_keluar SET status=0 WHERE id_canvass_keluar=$value";
		$q = mysql_query($sql);
		$sql=mysql_query("SELECT qty,id_barang_masuk_rak FROM canvass_keluar_barang WHERE id_canvass_keluar=$value");
		while($row=mysql_fetch_array($sql)){
			$qty=$row['qty'];
			$id_barang_masuk_rak=$row['id_barang_masuk_rak'];
			$sql2=mysql_query("SELECT stok FROM barang_masuk_rak WHERE id_barang_masuk_rak=$id_barang_masuk_rak");
			$row2=mysql_fetch_array($sql2);
			$stok=$row2['stok']+$qty;
			if ($stok<0){
				tulis_log(date('d-m-Y H:i'). ' Stok minus batal cek_kembali_gudang&id=' .$id);
				tulis_log('stok=' .$row2['stok']. ' qty=' .$qty);
				tulis_log("UPDATE barang_masuk_rak SET stok=" .$stok. " WHERE id_barang_masuk_rak=" .$id_barang_masuk_rak);
			}
			$sql2=mysql_query("UPDATE barang_masuk_rak SET stok=$stok WHERE id_barang_masuk_rak=$id_barang_masuk_rak");
			$sql2=mysql_query("UPDATE canvass_keluar_barang SET stok=null,qty_cek=null WHERE id_canvass_keluar=$value AND id_barang_masuk_rak=$id_barang_masuk_rak");
		}
	}
	_direct("?page=canvass_keluar&mode=cek_barang_mobil");
} else {
	$sql = mysql_query("DELETE FROM canvass_keluar 
		WHERE id_canvass_keluar NOT IN (SELECT id_canvass_keluar FROM canvass_keluar_barang)
		OR id_canvass_keluar NOT IN (SELECT id_canvass_keluar FROM canvass_keluar_karyawan)");
	$sql = mysql_query("DELETE FROM canvass_keluar_karyawan 
		WHERE id_canvass_keluar NOT IN (SELECT id_canvass_keluar FROM canvass_keluar)");
	$sql = mysql_query("DELETE FROM canvass_keluar_barang 
		WHERE id_canvass_keluar NOT IN (SELECT id_canvass_keluar FROM canvass_keluar)");
}
?>
<div class="right_col loading" role="main">
	<div class="">
	
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<div class="col-md-6">
							<h3>PERIKSA BARANG DI MOBIL (CANVASS)</h3>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
				
						<div class="" role="tabpanel">
						  <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
							<li role="presentation" class="active"><a href="#tab_content1" id="tab1" role="tab" data-toggle="tab" aria-expanded="true">Belum Periksa</a>
							</li>
							<li role="presentation" class=""><a href="#tab_content2" role="tab" id="tab2" data-toggle="tab" aria-expanded="false">Sudah Periksa</a>
							</li>
						  </ul>
						  <div id="myTabContent" class="tab-content">
							<div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="tab1">
								<form method="post" onsubmit="return cek_valid2()">
								<input type="hidden" name="batal_cek_kembali_gudang_post" value="true">
								<center><input class="btn btn-primary" type="submit" value="Kembalikan Barang Ke Gudang"></center><br/>
								<div class="table-responsive">
								<table id="table_belum_cek" class="table table-bordered table-striped">
									<thead>
										<tr>
											<th>Pilih</th>
											<th>Tgl Canvass</th>
											<th>Nama Mobil</th>
											<th>No Pol</th>
										</tr>
									</thead>
									<tbody>
<?php
	$sql=mysql_query("SELECT *
FROM
    canvass_keluar
    INNER JOIN kendaraan 
        ON (canvass_keluar.id_mobil = kendaraan.id_kendaraan)
WHERE canvass_keluar.status=9
ORDER BY id_canvass_keluar DESC");
	while ($row=mysql_fetch_array($sql)){
		echo '<tr>
				<td align="center"><input style="width: 20px; height: 20px;" type="checkbox" id="id_canvass_keluar" name="id_canvass_keluar[]" value="' .$row['id_canvass_keluar']. '"></td>
				<td align="center"><a href="?page=canvass_keluar&mode=cek_barang_mobil_2&id=' .$row['id_canvass_keluar']. '"><div style="min-width:70px">' .date("d-m-Y",strtotime($row['tanggal_canvass'])). '</div></a></td>
				<td align="center"><a href="?page=canvass_keluar&mode=cek_barang_mobil_2&id=' .$row['id_canvass_keluar']. '"><div style="min-width:70px">' .$row['nama_kendaraan']. '</div></a></td>
				<td align="center"><a href="?page=canvass_keluar&mode=cek_barang_mobil_2&id=' .$row['id_canvass_keluar']. '"><div style="min-width:70px">' .$row['plat']. '</div></a></td>
			</tr>';
	}
?>
									</tbody>
								</table>
								</div>
								</form>
							</div>
							<div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="tab2">
							<div class="col-xs-12" style="text-align:right">
								<input type="text" id="datepicker" PlaceHolder="Bulan & Tahun" style="width:100px" readonly></input>
								<input type="button" id="cari" onClick="cari()" value="Cari"></input>
								<input type="button" id="reset" onClick="reset()" value="Reset"></input>
							</div>
							<form method="post" onsubmit="return cek_valid()">
			  <input type="hidden" name="batal_cek_barang_mobil_post" value="true">
			  <?php
			  if (!isset($_GET['cari'])){
					echo '<center><input class="btn btn-primary" type="submit" value="Batalkan Periksa Barang"></center><br/>';
				} else {
					echo '<center><input class="btn btn-primary" type="submit" value="Batalkan Periksa Barang" disabled></center><br/>';
				}
			  ?>
								
								<div class="table-responsive">
							  <table id="table_sudah_cek" class="table table-bordered table-striped">
									<thead>
										<tr>
											<th>Pilih</th>
											<th>Tgl Canvass</th>
											<th>Nama Mobil</th>
											<th>No Pol</th>
										</tr>
									</thead>
									<tbody>
<?php
if (isset($_GET['cari'])){
	$tgl = explode("-", $_GET['cari']);
	$bln = $tgl[0];	$thn = $tgl[1];
	$val="MONTH(tanggal_canvass)=$bln AND YEAR(tanggal_canvass)=$thn";
} else {
	$val="canvass_keluar.status=1 AND kendaraan.canvass=1";
}

	$sql=mysql_query("SELECT *
FROM
    canvass_keluar
    INNER JOIN kendaraan 
        ON (canvass_keluar.id_mobil = kendaraan.id_kendaraan)
WHERE $val
ORDER BY id_canvass_keluar DESC");
	while ($row=mysql_fetch_array($sql)){
		echo '<tr>
				<td align="center"><input style="width: 20px; height: 20px;" type="checkbox" id="id_canvass_keluar" name="id_canvass_keluar[]" value="' .$row['id_canvass_keluar']. '"></td>
				<td align="center"><a href="?page=canvass_keluar&mode=cek_barang_mobil_3&id=' .$row['id_canvass_keluar']. '"><div style="min-width:70px">' .date("d-m-Y",strtotime($row['tanggal_canvass'])). '</div></a></td>
				<td align="center"><a href="?page=canvass_keluar&mode=cek_barang_mobil_3&id=' .$row['id_canvass_keluar']. '"><div style="min-width:70px">' .$row['nama_kendaraan']. '</div></a></td>
				<td align="center"><a href="?page=canvass_keluar&mode=cek_barang_mobil_3&id=' .$row['id_canvass_keluar']. '"><div style="min-width:70px">' .$row['plat']. '</div></a></td>
			</tr>';
	}
?>										
									</tbody>
								</table>
								</div>
								</form>
							</div>
						  </div>
						</div>
			
					</div>
				</div>
			<div id="dummy"></div>
			</div>
			</div>
		</div>	
	</div>
</div>

<script>
function getBack(){
	AndroidFunction.closeApp();
}
function cari(){
	var tanggal = $('#datepicker').val();
	var url = "?page=canvass_keluar&mode=cek_barang_mobil&cari=" + tanggal;
	if (tanggal!='') window.location=url;
}
function reset(){
	var url = "?page=canvass_keluar&mode=cek_barang_mobil&reset";
	window.location=url;
}
function cek_valid(){
	var len = $('#table_sudah_cek').find("input:checkbox:checked").length;
	if (len == 0){
		alert("Belum pilih nota.");
		return false;
	} else {
		return true;
	}
}
function cek_valid2(){
	var len = $('#table_belum_cek').find("input:checkbox:checked").length;
	if (len == 0){
		alert("Belum pilih nota.");
		return false;
	} else {
		return true;
	}
}
$(document).ready(function(){
	$('#datepicker').datepicker({
		orientation: "bottom auto",
		format: "mm-yyyy",
		startView: 1,
		minViewMode: 1,
		autoclose: true
	});
	<?php
		if (isset($_GET['cari']) or isset($_GET['reset'])) echo '$("#tab2").click();';
	?>
})
</script>
