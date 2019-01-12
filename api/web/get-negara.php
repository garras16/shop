<?php
date_default_timezone_set('Asia/Jakarta');
require_once('../../assets/inc/config.php');
require_once('../../assets/inc/publicfunc.php');

if (isset($_GET['id'])){
	$id=$_GET['id'];
} else {
	die();
}
$sql=mysqli_query($con, "SELECT * FROM negara WHERE id_negara='$id'");
$row=mysqli_fetch_array($sql);
?>
<input type="hidden" name="id_negara" value="<?php echo $id ?>">
<div class="input-group">
    <span class="input-group-addon">
        <i class="fa fa-tag fa-fw"></i><br>
        <small>Nama</small>
    </span>
    <input
        class="form-control"
        placeholder="Nama Negara"
        name="negara"
        style="padding: 20px 15px;"
        value="<?php echo $row['nama_negara']; ?>"
        maxlength="40"
        required="required">
    <span class="input-group-addon">
        <i class="fa fa-star fa-fw" style="color:red"></i>
    </span>
</div>