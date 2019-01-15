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

<option value="" disabled="disabled" selected="selected">Pilih Varian</option>
<?php
	$sql=mysqli_query($con, "SELECT * FROM varian_kendaraan WHERE nama_jenis='$id'");
	while($rows=mysqli_fetch_array($sql)){
		echo '<option value="' .$rows['id_varian']. '">' .$rows['nama_varian']. '</option>';
	}
?>