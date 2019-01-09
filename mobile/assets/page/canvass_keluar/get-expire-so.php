<?php
session_start();
date_default_timezone_set('Asia/Jakarta');
require_once('../../../assets/inc/config.php');
require_once('../../../assets/inc/publicfunc.php');
if (!isset($_GET['barang'])) die();
$id_barang=$_GET['barang'];
$id_canvass=$_GET['canvass'];
$sql = mysqli_query($con, "SELECT * FROM lap_stock_opname WHERE id_canvass_keluar=$id_canvass AND id_barang=$id_barang GROUP BY expire");
if (mysqli_num_rows($sql)=='0') die();
?>
<table class="table table-bordered table-striped">
	<thead>
		<tr>
			<th>Tgl. Exp.</th>
		</tr>
	</thead>
	<tbody>
	<?php
	while ($row=mysqli_fetch_array($sql)){
		echo '<tr><td>' .date("d-m-Y",strtotime($row['expire'])). '</td></tr>';
	}
	?>
	</tbody>
</table>
