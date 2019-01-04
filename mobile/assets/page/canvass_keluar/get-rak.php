<?php
session_start();
date_default_timezone_set('Asia/Jakarta');
require_once('../../../assets/inc/config.php');
require_once('../../../assets/inc/publicfunc.php');
if (!isset($_GET['id'])) die();
$barcode=$_GET['id'];
$sql = mysql_query("SELECT * 
FROM
    gudang
    INNER JOIN rak 
        ON (gudang.id_gudang = rak.id_gudang) WHERE nama_rak='$barcode'");
if (mysql_num_rows($sql)=='0'){
	die();
} else {
	$row=mysql_fetch_array($sql);
}
?>
<input type="hidden" id="id_rak" name="id_rak" value="<?php echo $row['id_rak'] ?>" >
<div class="input-group">
	<span class="input-group-addon"><i class="fa fa-building fa-fw"></i></span>
	<input class="form-control" type="text" id="nama_gudang" name="nama_gudang" value="<?php echo $row['nama_gudang'] ?>" placeHolder="Nama Gudang" readonly required>
	<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
</div>
<div class="input-group">
	<span class="input-group-addon"><i class="fa fa-archive fa-fw"></i></span>
	<input class="form-control" type="text" id="nama_rak" name="nama_rak" value="<?php echo $row['nama_rak'] ?>" placeHolder="Nama Rak" readonly required>
	<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
</div>
