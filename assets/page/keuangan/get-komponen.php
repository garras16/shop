<?php
date_default_timezone_set('Asia/Jakarta');
require_once('../../inc/config.php');
require_once('../../inc/publicfunc.php');

if (isset($_GET['jenis'])){
	$jenis=$_GET['jenis'];
} else {
	die();
}

?>
<div class="input-group">
	<span class="input-group-addon"><i class="fa fa-credit-card fa-fw"></i></span>
	<select class="form-control select2" id="select_komponen" name="komponen" required>
		<option value="" disabled selected>Pilih Komponen</option>
<?php
$sql=mysql_query("SELECT * FROM mst_kas_kecil WHERE jenis='$jenis' AND status=1");
while ($row=mysql_fetch_array($sql)){
	echo '<option value="' .$row['nama_kas_kecil']. '">' .$row['nama_kas_kecil']. '</option>';
}
?>
	</select>
	<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
</div>