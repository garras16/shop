<?php
date_default_timezone_set('Asia/Jakarta');
require_once('../../inc/config.php');
require_once('../../inc/publicfunc.php');

if (isset($_GET['id'])){
	$id=$_GET['id'];
} else {
	die();
}
?>
<table class="table table-bordered table-striped table9">
    <thead>
        <tr>
            <th>Tgl Nota Jual</th>
            <th>No Nota Jual</th>
            <th>Nama Pelanggan</th>
            <th>Total Jual (Rp)</th>
        </tr>
    </thead>
    <tbody>
        <?php
		$sql=mysqli_query($con, "SELECT jual.id_jual,tgl_nota,invoice,nama_pelanggan,SUM(qty_ambil*harga) AS total_jual
		FROM
		    canvass_keluar
		    INNER JOIN canvass_siap_kirim 
		        ON (canvass_keluar.id_canvass_keluar = canvass_siap_kirim.id_canvass_keluar)
		    INNER JOIN jual 
		        ON (canvass_siap_kirim.id_jual = jual.id_jual)
		    INNER JOIN canvass_siap_kirim_detail 
		        ON (canvass_siap_kirim.id_canvass_siap_kirim = canvass_siap_kirim_detail.id_canvass_siap_kirim)
		    INNER JOIN pelanggan 
		        ON (jual.id_pelanggan = pelanggan.id_pelanggan)
		    INNER JOIN jual_detail 
		        ON (canvass_siap_kirim_detail.id_jual_detail = jual_detail.id_jual_detail)
		WHERE canvass_keluar.id_canvass_keluar=$id
		GROUP BY canvass_keluar.id_canvass_keluar=$id");
		while ($row=mysqli_fetch_array($sql)){
			echo '<tr>
					<td><a target="_blank" href="?page=penjualan&mode=view_detail&id=' .$row['id_jual']. '"><div style="min-width:70px">' .date("d-m-Y", strtotime($row['tgl_nota'])). '</div></a></td>
					<td><a target="_blank" href="?page=penjualan&mode=view_detail&id=' .$row['id_jual']. '"><div style="min-width:70px">' .$row['invoice']. '</div></a></td>
					<td><a target="_blank" href="?page=penjualan&mode=view_detail&id=' .$row['id_jual']. '"><div style="min-width:70px">' .$row['nama_pelanggan']. '</div></a></td>
					<td><a target="_blank" href="?page=penjualan&mode=view_detail&id=' .$row['id_jual']. '"><div style="min-width:70px">' .format_uang($row['total_jual']). '</div></a></td>
				</tr>';
		}
		?>
    </tbody>
</table>