<?php
date_default_timezone_set('Asia/Jakarta');
require_once('../../assets/inc/config.php');
require_once('../../assets/inc/publicfunc.php');

if (isset($_GET['id'])){
	$id=$_GET['id'];
} else {
	die();
}
$sql=mysql_query("SELECT
    provinsi.nama_prov
	, kabupaten.id_kab
    , kabupaten.nama_kab
    , negara.nama_negara
FROM
    kabupaten
    INNER JOIN provinsi 
        ON (kabupaten.id_prov = provinsi.id_prov)
    INNER JOIN negara 
        ON (negara.id_negara = provinsi.id_negara) WHERE id_kab='$id'");
$row=mysql_fetch_array($sql);
?>
<input type="hidden" name="id_kab" value="<?php echo $id ?>">
<div class="input-group">
	<span class="input-group-addon"><i class="fa fa-flag fa-fw"></i></span>
	<input class="form-control" placeHolder="Nama Negara" value="<?php echo $row['nama_negara']; ?>" maxlength="40" readonly>
	<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
</div>
<div class="input-group">
	<span class="input-group-addon"><i class="fa fa-flag fa-fw"></i></span>
	<input class="form-control" placeHolder="Nama Provinsi" value="<?php echo $row['nama_prov']; ?>" maxlength="40" readonly>
	<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
</div>
<div class="input-group">
	<span class="input-group-addon"><i class="fa fa-tag fa-fw"></i></span>
	<input class="form-control" placeHolder="Nama Kabupaten" name="kabupaten" value="<?php echo $row['nama_kab']; ?>" maxlength="40" required>
	<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
</div>