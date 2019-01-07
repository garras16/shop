<?php
if (isset($batal_mutasi_mobil_gudang_post)){
	foreach ($id_canvass_keluar as $key => $value) {
		$sql = "UPDATE canvass_keluar SET status=3 WHERE id_canvass_keluar=$value";
		$q = mysqli_query($con, $sql);
		$sql=mysqli_query($con, "SELECT id_rak,expire,qty_cek2,id_barang_masuk_rak FROM canvass_mutasi_mobil_gudang WHERE id_canvass_keluar=$value");
		while($row=mysqli_fetch_array($sql)){
			$qty_cek=$row['qty_cek2'];
			$id_barang_masuk_rak=$row['id_barang_masuk_rak'];
			$id_rak=$row['id_rak'];
			$expire=$row['expire'];
			$sql2=mysqli_query($con, "SELECT id_barang_masuk FROM barang_masuk_rak WHERE id_barang_masuk_rak=$id_barang_masuk_rak");
			$row2=mysqli_fetch_array($sql2);
			$id_barang_masuk=$row2['id_barang_masuk'];
			$sql2=mysqli_query($con, "DELETE FROM barang_masuk_rak WHERE id_barang_masuk=$id_barang_masuk AND id_rak=$id_rak AND qty_di_rak=0 AND expire='$expire'");
		}
	}
	_direct("?page=canvass_keluar&mode=mutasi_mobil_gudang");
}
?>
<div class="right_col loading" role="main">
	<div class="">
	
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<div class="col-md-6">
							<h3>MUTASI DARI MOBIL KE GUDANG (CANVASS)</h3>
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
							
								<div class="table-responsive">
								<table id="table_belum_cek" class="table table-bordered table-striped">
									<thead>
										<tr>
											<th>Tgl Canvass</th>
											<th>Nama Mobil</th>
											<th>No Pol</th>
										</tr>
									</thead>
									<tbody>
<?php
	$sql=mysqli_query($con, "SELECT *
FROM
    canvass_keluar
    INNER JOIN kendaraan 
        ON (canvass_keluar.id_mobil = kendaraan.id_kendaraan)
WHERE canvass_keluar.status=3
ORDER BY id_canvass_keluar DESC");
	while ($row=mysqli_fetch_array($sql)){
		echo '<tr>
				<td align="center"><a href="?page=canvass_keluar&mode=mutasi_mobil_gudang_2&id=' .$row['id_canvass_keluar']. '"><div style="min-width:70px">' .date("d-m-Y",strtotime($row['tanggal_canvass'])). '</div></a></td>
				<td align="center"><a href="?page=canvass_keluar&mode=mutasi_mobil_gudang_2&id=' .$row['id_canvass_keluar']. '"><div style="min-width:70px">' .$row['nama_kendaraan']. '</div></a></td>
				<td align="center"><a href="?page=canvass_keluar&mode=mutasi_mobil_gudang_2&id=' .$row['id_canvass_keluar']. '"><div style="min-width:70px">' .$row['plat']. '</div></a></td>
			</tr>';
	}
?>
									</tbody>
								</table>
								</div>
							</div>
							<div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="tab2">
							<div class="col-xs-12" style="text-align:right">
								<input type="text" id="datepicker" PlaceHolder="Bulan & Tahun" style="width:100px" readonly></input>
								<input type="button" id="cari" onClick="cari()" value="Cari"></input>
								<input type="button" id="reset" onClick="reset()" value="Reset"></input>
							</div>
							<div class="clearfix"></div><br>
							<form method="post" onsubmit="return cek_valid()">
			  <input type="hidden" name="batal_mutasi_mobil_gudang_post" value="true">
			  <?php
			  if (!isset($_GET['cari'])){
			//		echo '<center><input class="btn btn-primary" type="submit" value="Batalkan Mutasi Barang"></center><br/>';
				} else {
			//		echo '<center><input class="btn btn-primary" type="submit" value="Batalkan Mutasi Barang" disabled></center><br/>';
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
	$val="canvass_keluar.status=4";
}

	$sql=mysqli_query($con, "SELECT *
FROM
    canvass_keluar
    INNER JOIN kendaraan 
        ON (canvass_keluar.id_mobil = kendaraan.id_kendaraan)
WHERE $val
ORDER BY id_canvass_keluar DESC");
	while ($row=mysqli_fetch_array($sql)){
		echo '<tr>
				<td align="center"><input style="width: 20px; height: 20px;" type="checkbox" id="id_canvass_keluar" name="id_canvass_keluar[]" value="' .$row['id_canvass_keluar']. '"></td>
				<td align="center"><a href="?page=canvass_keluar&mode=mutasi_mobil_gudang_3&id=' .$row['id_canvass_keluar']. '"><div style="min-width:70px">' .date("d-m-Y",strtotime($row['tanggal_canvass'])). '</div></a></td>
				<td align="center"><a href="?page=canvass_keluar&mode=mutasi_mobil_gudang_3&id=' .$row['id_canvass_keluar']. '"><div style="min-width:70px">' .$row['nama_kendaraan']. '</div></a></td>
				<td align="center"><a href="?page=canvass_keluar&mode=mutasi_mobil_gudang_3&id=' .$row['id_canvass_keluar']. '"><div style="min-width:70px">' .$row['plat']. '</div></a></td>
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
	var url = "?page=canvass_keluar&mode=mutasi_mobil_gudang&cari=" + tanggal;
	if (tanggal!='') window.location=url;
}
function reset(){
	var url = "?page=canvass_keluar&mode=mutasi_mobil_gudang&reset";
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
