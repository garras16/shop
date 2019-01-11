<?php
date_default_timezone_set('Asia/Jakarta');
require_once('../../assets/inc/config.php');
require_once('../../assets/inc/publicfunc.php');

if (isset($_GET['id'])){
	$id=$_GET['id'];
} else {
	die();
}
$sql=mysqli_query($con, "SELECT * FROM pelanggan WHERE id_pelanggan='$id'");
$row=mysqli_fetch_array($sql);
?>
<input type="hidden" name="id_pelanggan" value="<?php echo $id ?>">
<div class="input-group">
    <span class="input-group-addon">
        <i class="fa fa-building fa-fw" style="width:59px;"></i><br>
        <small>Nama</small>
    </span>
    <input
        class="form-control"
        id="nama"
        name="nama_pelanggan"
        style="padding: 20px 15px;"
        placeholder="Nama Pelanggan"
        value="<?php echo $row['nama_pelanggan']; ?>"
        maxlength="50"
        required="required">
    <span class="input-group-addon">
        <i class="fa fa-star fa-fw" style="color:red"></i>
    </span>
</div>
<div class="input-group">
    <span class="input-group-addon">
        <i class="fa fa-home fa-fw" style="width:59px;"></i><br>
        <small>Alamat</small>
    </span>
    <input
        name="alamat"
        class="form-control"
        placeholder="Alamat"
        style="padding: 20px 15px;"
        value="<?php echo $row['alamat']; ?>"
        maxlength="100"
        required="required">
    <span class="input-group-addon">
        <i class="fa fa-star fa-fw" style="color:red"></i>
    </span>
</div>
<div class="input-group">
    <span class="input-group-addon">
        <i class="fa fa-map-marker fa-fw" style="width:59px;"></i><br>
        <small>Latitude</small>
    </span>
    <input
        name="lat"
        class="form-control"
        placeholder="Latitude"
        style="padding: 20px 15px;"
        value="<?php echo $row['lat']; ?>"
        maxlength="50"
        readonly="readonly">
</div>
<div class="input-group">
    <span class="input-group-addon">
        <i class="fa fa-map-marker fa-fw" style="width: 59px;"></i><br>
        <small>Longitude</small>
    </span>
    <input
        name="lng"
        class="form-control"
        placeholder="Longitude"
        style="padding: 20px 15px;"
        value="<?php echo $row['lng']; ?>"
        maxlength="50"
        readonly="readonly">
</div>
<div class="input-group">
    <span class="input-group-addon">
        <i class="fa fa-phone fa-fw" style="width: 59px;"></i><br>
        <small>Telepon</small>
    </span>
    <input
        class="form-control"
        type="number"
        name="telepon_pelanggan"
        style="padding: 20px 15px;"
        placeholder="Telepon Pelanggan"
        value="<?php echo $row['telepon_pelanggan']; ?>"
        onkeypress="if(this.value.length==20) return false;"
        required="required">
    <span class="input-group-addon">
        <i class="fa fa-star fa-fw" style="color:red"></i>
    </span>
</div>
<div class="input-group">
    <span class="input-group-addon">
        <i class="fa fa-user fa-fw"></i><br>
        <small>No. Kontak</small>
    </span>
    <input
        name="kontak"
        class="form-control"
        style="padding: 20px 15px;"
        placeholder="Kontak Person"
        value="<?php echo $row['kontakperson']; ?>"
        maxlength="30"
        required="required">
</div>
<div class="input-group">
    <span class="input-group-addon">
        <i class="fa fa-phone fa-fw"></i><br>
        <small>Tlp. Kontak</small>
    </span>
    <input
        class="form-control"
        type="number"
        style="padding: 20px 15px;"
        name="telepon_kontak"
        placeholder="Telepon Kontak Person"
        value="<?php echo $row['telepon_kontak']; ?>"
        onkeypress="if(this.value.length==20) return false;"
        required="required">
</div>
<div class="input-group">
    <span class="input-group-addon">
        <i class="fa fa-arrows-v fa-fw" style="width:59px;"></i><br>
        <small>Plafon</small>
    </span>
    <input
        id="plafon_2"
        name="plafon"
        class="form-control"
        style="padding: 20px 15px;"
        value="<?php echo $row['plafon']; ?>"
        required="required">
    <span class="input-group-addon">
        <i class="fa fa-star fa-fw" style="color:red"></i>
    </span>
</div>
<div class="input-group">
    <span class="input-group-addon">
        <i class="fa fa-barcode fa-fw" style="width: 59px;"></i><br>
        <small>Barcode</small>
    </span>
    <input
        name="barcode"
        class="form-control"
        placeholder="Barcode"
        style="padding: 20px 15px;"
        value="<?php echo $row['barcode']; ?>"
        maxlength="20"
        required="required">
    <span class="input-group-addon">
        <i class="fa fa-star fa-fw" style="color:red"></i>
    </span>
</div>
<div class="input-group">
    <span class="input-group-addon" style="padding: 2px 12px;">
        <i class="fa fa-flag fa-fw" style="width: 59px;"></i><br>
        <small>Status</small>
    </span>
    <select class="form-control" name="status" required="required">
        <option value="" disabled="disabled" selected="selected">Pilih Status</option>
        <option value="0" <?php echo ($row['status'] == '0' ? 'selected' : '') ?>>NON AKTIF</option>
        <option value="1" <?php echo ($row['status'] == '1' ? 'selected' : '') ?>>AKTIF</option>
    </select>
    <span class="input-group-addon">
        <i class="fa fa-star fa-fw" style="color:red"></i>
    </span>
</div>
<div class="input-group">
    <span class="input-group-addon" style="padding: 2px 12px;">
        <i class="fa fa-ban fa-fw" style="width: 59px;"></i><br>
        <small>BlackList</small>
    </span>
    <select class="form-control" name="blacklist" required="required">
        <option value="" disabled="disabled" selected="selected">Blacklist ?</option>
        <option value="0" <?php echo ($row['blacklist'] == '0' ? 'selected' : '') ?>>TIDAK</option>
        <option value="1" <?php echo ($row['blacklist'] == '1' ? 'selected' : '') ?>>YA</option>
    </select>
    <span class="input-group-addon">
        <i class="fa fa-star fa-fw" style="color:red"></i>
    </span>
</div>