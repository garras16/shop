<?php
$id_karyawan=$_SESSION['id_karyawan'];
if (isset($_GET['del'])){
	$sql = mysqli_query($con, "SELECT * FROM nota_sudah_cek WHERE id_jual=" .$_GET['del']);
	$row=mysqli_fetch_array($sql);
	$jumlah=$row['jumlah'];
	$tanggal=date("Y-m-d");
	$sql = mysqli_query($con, "SELECT * FROM batal_kirim WHERE id_jual=" .$_GET['del']);
	if (mysqli_num_rows($sql)>0){
		$sql = mysqli_query($con, "UPDATE batal_kirim SET id_karyawan=$id_karyawan,jumlah=$jumlah,status=0,tanggal='$tanggal' WHERE id_jual=" .$_GET['del']);
	} else {
		$sql = mysqli_query($con, "INSERT INTO batal_kirim VALUES(null,$id_karyawan," .$_GET['del']. ",$jumlah,0,'$tanggal')");
	}
	$sql = mysqli_query($con, "SELECT * FROM pengiriman WHERE id_jual=" .$_GET['del']);
	if (mysqli_num_rows($sql)>0){
		$sql = mysqli_query($con, "UPDATE pengiriman SET status=2 WHERE id_jual=" .$_GET['del']);
	} else {
		$sql = mysqli_query($con, "INSERT INTO pengiriman VALUES(null," .$_GET['del']. ",2,'$tanggal',$id_karyawan,null,null,null,null)");
	}
	$sql = mysqli_query($con, "SELECT * FROM batal_kirim WHERE id_jual=" .$_GET['del']. "");
	$row=mysqli_fetch_array($sql);
	$id_batal_kirim=$row['id_batal_kirim'];
	$sql=mysqli_query($con, "DELETE FROM batal_kirim_detail WHERE id_batal_kirim=$id_batal_kirim");
	$sql=mysqli_query($con, "SELECT *
FROM
    nota_siap_kirim
    INNER JOIN nota_siap_kirim_detail
        ON (nota_siap_kirim.id_nota_siap_kirim = nota_siap_kirim_detail.id_nota_siap_kirim)
WHERE id_jual=" .$_GET['del']. " AND qty_ambil>0");
	while ($row=mysqli_fetch_array($sql)){
		$sql2 = mysqli_query($con, "INSERT INTO batal_kirim_detail VALUES(null,$id_batal_kirim," .$row['id_jual_detail']. "," .$row['id_barang_masuk_rak']. "," .$row['qty_ambil']. ",'" .$row['expire']. "')");
	}
	_direct("?page=driver&mode=barang_keluar");
}

?>
<div class="right_col" role="main">
	<div class="">

		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<h3>KIRIM BARANG</h3>
						<?php
							if (isset($pesan)){
								echo '<span class="badge bg-' .$warna. '">' .$pesan. '</span>';
							}
						?>
					<div class="clearfix"></div>
					</div>
					<div class="x_content">
				<div class="table responsive">
				<table id="table1" class="table table-bordered table-striped" style="min-width: 1000px;">
				<thead>
					<tr>
						<th>Tgl. Nota Jual</th>
						<th>No Nota Jual</th>
						<th>Nama Sales</th>
						<th>Tgl. Cetak Nota</th>
						<th>Pelanggan</th>
						<th>Alamat</th>
						<th>Jumlah Jual</th>
						<th>Tipe Kirim</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
<?php
$sql=mysqli_query($con, "SELECT * FROM nota_sudah_cek WHERE id_jual NOT IN (SELECT id_jual FROM batal_kirim WHERE status=0) AND status='2' ORDER BY id_nota_sudah_cek DESC");
while ($row=mysqli_fetch_array($sql)){
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
	($row['tipe_kirim']=='Kirim Sendiri' ? $pilih='barang_keluar_2' : $pilih='barang_keluar_3');
		echo '<tr>
				<td><a href="?page=driver&mode=' .$pilih. '&id=' .$row['id_nota_sudah_cek']. '"><div style="min-width:70px">' .date("d-m-Y", strtotime($row2['tgl_nota'])). '</div></a></td>
				<td><a href="?page=driver&mode=' .$pilih. '&id=' .$row['id_nota_sudah_cek']. '"><div style="min-width:70px">' .$row2['invoice']. '</div></a></td>
				<td><a href="?page=driver&mode=' .$pilih. '&id=' .$row['id_nota_sudah_cek']. '"><div style="min-width:70px">' .$row2['nama_karyawan']. '</div></a></td>
				<td><a href="?page=driver&mode=' .$pilih. '&id=' .$row['id_nota_sudah_cek']. '"><div style="min-width:70px">' .date("d-m-Y", strtotime($row['tanggal_cetak'])). '</div></a></td>
				<td><a href="?page=driver&mode=' .$pilih. '&id=' .$row['id_nota_sudah_cek']. '"><div style="min-width:70px">' .$row2['nama_pelanggan']. '</div></a></td>
				<td><a href="?page=driver&mode=' .$pilih. '&id=' .$row['id_nota_sudah_cek']. '"><div style="min-width:70px">' .$row2['alamat']. '</div></a></td>
				<td><a href="?page=driver&mode=' .$pilih. '&id=' .$row['id_nota_sudah_cek']. '"><div style="min-width:70px">Rp ' .format_uang($row['jumlah']). '</div></a></td>
				<td><a href="?page=driver&mode=' .$pilih. '&id=' .$row['id_nota_sudah_cek']. '"><div style="min-width:70px">' .$row['tipe_kirim']. '</div></a></td>
				<td align="center"><a href="?page=driver&mode=barang_keluar&del=' .$row2['id_jual']. '" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Batal</a></td>
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
