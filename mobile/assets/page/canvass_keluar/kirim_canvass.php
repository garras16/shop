<?php
$id_karyawan=$_SESSION['id_karyawan'];
if (isset($_GET['del'])){
	$sql = "UPDATE canvass_siap_kirim SET status='0' WHERE id_canvass_siap_kirim=" .$_GET['del']. "";
		$q = mysqli_query($con, $sql);
		$sql=mysqli_query($con, "SELECT qty_ambil,id_barang_masuk_rak FROM canvass_siap_kirim_detail WHERE id_canvass_siap_kirim=" .$_GET['del']. "");
		while($row=mysqli_fetch_array($sql)){
			$qty_ambil=$row['qty_ambil'];
			$id_barang_masuk_rak=$row['id_barang_masuk_rak'];
			$sql2=mysqli_query($con, "SELECT stok FROM canvass_keluar_barang WHERE id_barang_masuk_rak=$id_barang_masuk_rak");
			$row2=mysqli_fetch_array($sql2);
			$stok=$row2['stok']+$qty_ambil;
			$sql2=mysqli_query($con, "UPDATE canvass_keluar_barang SET stok=$stok WHERE id_barang_masuk_rak=$id_barang_masuk_rak");
		}
	_direct("?page=canvass_keluar&mode=kirim_canvass");
}

?>
<div class="right_col" role="main">
	<div class="">
	
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<h3>KIRIM BARANG (CANVASS)</h3>
						<?php
							if (isset($pesan)){
								echo '<span class="badge bg-' .$warna. '">' .$pesan. '</span>';
							}
						?>
					<div class="clearfix"></div>
					</div>
					<div class="x_content">
				<div class="table responsive">
				<table id="table1" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>Tgl. Nota Jual</th>
						<th>No Nota Jual</th>
						<th>Nama Sales</th>
						<th>Pelanggan</th>
						<th>Alamat</th>
						<th>Jumlah Jual (Rp)</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
<?php
$sql=mysqli_query($con, "SELECT *, SUM((harga-diskon_rp-diskon_rp_2-diskon_rp_3)*qty_ambil) AS jml_jual
FROM
    canvass_siap_kirim
    INNER JOIN canvass_siap_kirim_detail 
        ON (canvass_siap_kirim.id_canvass_siap_kirim = canvass_siap_kirim_detail.id_canvass_siap_kirim)
	INNER JOIN jual_detail 
        ON (canvass_siap_kirim_detail.id_jual_detail = jual_detail.id_jual_detail)
WHERE status='1'
GROUP BY canvass_siap_kirim.id_jual
ORDER BY canvass_siap_kirim.id_jual DESC");
while ($row=mysqli_fetch_array($sql)){
	if ($row['jml_jual']=='') break;
	$sql2=mysqli_query($con, "SELECT
    jual.id_jual
	, jual.tgl_nota
    , jual.invoice
    , jual.status_konfirm
	, pelanggan.nama_pelanggan
	, pelanggan.alamat
	, karyawan.nama_karyawan
FROM
    jual
    INNER JOIN jual_detail 
        ON (jual.id_jual = jual_detail.id_jual)
    INNER JOIN pelanggan 
        ON (jual.id_pelanggan = pelanggan.id_pelanggan)
	INNER JOIN karyawan 
        ON (jual.id_karyawan = karyawan.id_karyawan)
    LEFT JOIN harga_jual 
        ON (harga_jual.id_pelanggan = pelanggan.id_pelanggan) AND (jual_detail.id_harga_jual = harga_jual.id_harga_jual)
    LEFT JOIN barang_supplier 
        ON (harga_jual.id_barang_supplier = barang_supplier.id_barang_supplier)
    LEFT JOIN barang 
        ON (barang_supplier.id_barang = barang.id_barang) 
WHERE jual.id_jual=" .$row['id_jual']. "
GROUP BY jual.id_jual");
	while ($row2=mysqli_fetch_array($sql2)){
	echo '		<td><a href="?page=canvass_keluar&mode=kirim_canvass_2&id=' .$row['id_canvass_siap_kirim']. '"><div style="min-width:70px">' .date("d-m-Y", strtotime($row2['tgl_nota'])). '</div></a></td>
				<td><a href="?page=canvass_keluar&mode=kirim_canvass_2&id=' .$row['id_canvass_siap_kirim']. '"><div style="min-width:70px">' .$row2['invoice']. '</div></a></td>
				<td><a href="?page=canvass_keluar&mode=kirim_canvass_2&id=' .$row['id_canvass_siap_kirim']. '"><div style="min-width:70px">' .$row2['nama_karyawan']. '</div></a></td>
				<td><a href="?page=canvass_keluar&mode=kirim_canvass_2&id=' .$row['id_canvass_siap_kirim']. '"><div style="min-width:70px">' .$row2['nama_pelanggan']. '</div></a></td>
				<td><a href="?page=canvass_keluar&mode=kirim_canvass_2&id=' .$row['id_canvass_siap_kirim']. '"><div style="min-width:70px">' .$row2['alamat']. '</div></a></td>
				<td><a href="?page=canvass_keluar&mode=kirim_canvass_2&id=' .$row['id_canvass_siap_kirim']. '"><div style="min-width:70px">' .format_uang($row['jml_jual']). '</div></a></td>
				<td align="center"><a href="?page=canvass_keluar&mode=kirim_canvass&del=' .$row['id_canvass_siap_kirim']. '" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Batal</a></td>
			  </tr>';
	}
}
?>					
				</tbody>
			</table>
			
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
$(document).ready(function(){
	
});
</script>
