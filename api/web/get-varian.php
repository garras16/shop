<?php
date_default_timezone_set('Asia/Jakarta');
require_once('../../assets/inc/config.php');
require_once('../../assets/inc/publicfunc.php');

if (isset($_GET['id'])){
	$id=$_GET['id'];
} else {
	die();
}

?>

		<option value="" disabled selected>Pilih Varian</option>
		<?php
			$sql=mysql_query("SELECT * FROM varian_kendaraan WHERE nama_jenis='$id'");
			while($rows=mysql_fetch_array($sql)){
				echo '<option value="' .$rows['id_varian']. '">' .$rows['nama_varian']. '</option>';
			}
		?>
	

