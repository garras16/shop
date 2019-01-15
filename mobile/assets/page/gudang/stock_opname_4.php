<?php
$id_karyawan=$_SESSION['id_karyawan'];
	$sql=mysqli_query($con, "SELECT *
FROM
    stock_opname
    INNER JOIN karyawan 
        ON (stock_opname.id_karyawan = karyawan.id_karyawan)
	WHERE id_so=$id");
	$row=mysqli_fetch_array($sql);
	$tgl_so=$row['tanggal_so'];
	$nama=$row['nama_karyawan'];
?>
<div class="right_col loading" role="main">
	<div class="">
	
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<div class="col-md-6">
							<h3>RINGKASAN STOCK OPNAME GUDANG</h3>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<table class="table table-bordered table-striped">
						<tbody>
<?php
	echo '					<tr><td width="40%">Tanggal Stock Opname</td><td>' .date("d-m-Y", strtotime($tgl_so)). '</td></tr>
							<tr><td width="40%">Nama Karyawan</td><td>' .$nama. '</td></tr>';
?>
						</tbody>
						</table>
						
						<div class="table-responsive">
						<table class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>Nama Barang</th>
									<th>Rak</th>
									<th>Qty Periksa Rak</th>
									<th>Qty Periksa Total</th>
									<th>Qty Seharusnya di Rak</th>
									<th>Qty Seharusnya Total</th>
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
WHERE stok>0 AND barang.status=1
GROUP BY barang.id_barang");
	while ($row=mysqli_fetch_array($sql)){
	$sql2=mysqli_query($con, "SELECT *,SUM(jumlah_barang) as jumlah_barang
FROM
    stock_opname_detail
    INNER JOIN barang 
        ON (stock_opname_detail.id_barang = barang.id_barang)
    INNER JOIN rak 
        ON (stock_opname_detail.id_rak = rak.id_rak)
	INNER JOIN gudang
		ON (rak.id_gudang = gudang.id_gudang)
WHERE stock_opname_detail.id_barang=" .$row['id_barang']. "	AND id_so=$id
GROUP BY rak.id_rak");
	(mysqli_num_rows($sql2)>0 ? $n=mysqli_num_rows($sql2) : $n=1);
	(mysqli_num_rows($sql2)>0 ? $x=true : $x=false);
	echo '<tr>
			<td style="vertical-align:middle;text-align:center" rowspan="' .$n. '">' .$row['nama_barang']. '</td>';
	$sql3=mysqli_query($con, "SELECT SUM(jumlah_barang) as total_rak FROM stock_opname_detail WHERE id_barang=" .$row['id_barang']. "	AND id_so=$id");
	$row3=mysqli_fetch_array($sql3);
	$total_rak=$row3['total_rak'];
	$fix=false;
		while ($row2=mysqli_fetch_array($sql2)){
		$sql4=mysqli_query($con, "SELECT *,SUM(stok) AS stok_seharusnya
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
WHERE barang.id_barang=" .$row2['id_barang']. " AND barang_masuk_rak.id_rak=" .$row2['id_rak']);
$row4=mysqli_fetch_array($sql4);
$stok_seharusnya=$row4['stok_seharusnya'];
($total_rak==$row['stok'] ? $color='color: black' : $color='color: red');
			echo '		<td style="vertical-align:middle;text-align:center;' .$color. '">' .$row2['nama_rak']. '</td>
						<td style="vertical-align:middle;text-align:center;' .$color. '">' .format_angka($row2['jumlah_barang']). ' ' .$row['nama_satuan']. '</td>';
			if (!$fix) echo '<td style="vertical-align:middle;text-align:center;' .$color. '" rowspan="' .$n. '">' .format_angka($total_rak). ' ' .$row['nama_satuan']. '</td>';
			echo '		<td style="vertical-align:middle;text-align:center;' .$color. '">' .format_angka($stok_seharusnya). ' ' .$row['nama_satuan']. '</td>';
			if (!$fix) echo '<td style="vertical-align:middle;text-align:center;' .$color. '" rowspan="' .$n. '">' .format_angka($row['stok']). ' ' .$row['nama_satuan']. '</td>';
			echo '	</tr>';
			$fix=true;
		}
		if (!$x){
			echo '		<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td style="vertical-align:middle;text-align:center;color:red">' .format_angka($row['stok']). ' ' .$row['nama_satuan']. '</td>
					</tr>';
		}
	}

?>
							</tbody>
						</table>
						</div>
					</div>
				</div>
			<div id="dummy"></div>
			</div>
		</div>	
	</div>
</div>

<script>
function getBack(){
	window.location='index.php?page=gudang&mode=stock_opname';
}

$(document).ready(function(){
	
})
</script>
