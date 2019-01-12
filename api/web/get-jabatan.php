<?php
date_default_timezone_set('Asia/Jakarta');
require_once('../../assets/inc/config.php');
require_once('../../assets/inc/publicfunc.php');

if (isset($_GET['id'])){
	$id=$_GET['id'];
} else {
	die();
}
$sql=mysqli_query($con, "SELECT * FROM jabatan WHERE id_jabatan='$id'");
$row=mysqli_fetch_array($sql);
?>
<input type="hidden" name="id_jabatan" value="<?php echo $id ?>">
<div class="input-group">
    <span class="input-group-addon">
        <i class="fa fa-briefcase fa-fw"></i><br>
        <small>Jabatan</small>
    </span>
    <input
        class="form-control"
        placeholder="Nama Jabatan"
        name="jabatan"
        style="padding:20px 15px;"
        value="<?php echo $row['nama_jabatan']; ?>"
        maxlength="20"
        required="required">
    <span class="input-group-addon">
        <i class="fa fa-star fa-fw" style="color:red"></i>
    </span>
</div>
<div class="input-group">
    <span class="input-group-addon" style="padding: 2px 12px;">
        <i class="fa fa-flag fa-fw" style="width:44px;"></i><br>
        <small>Status</small>
    </span>
    <select
        class="form-control"
        id="select_status"
        name="status"
        required="required">
        <option value="" disabled="disabled" selected="selected">Pilih Status</option>
        <option value="0" <?php echo ($row['status']==0 ? 'selected' : '') ?>>NON AKTIF</option>
        <option value="1" <?php echo ($row['status']==1 ? 'selected' : '') ?>>AKTIF</option>
    </select>
    <span class="input-group-addon">
        <i class="fa fa-star fa-fw" style="color:red"></i>
    </span>
</div>