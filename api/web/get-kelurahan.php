<?php
date_default_timezone_set('Asia/Jakarta');
require_once('../../assets/inc/config.php');
require_once('../../assets/inc/publicfunc.php');

if (isset($_GET['id'])){
	$id=$_GET['id'];
} else {
	die();
}
$sql=mysqli_query($con, "SELECT
    provinsi.nama_prov
    , kabupaten.nama_kab
    , negara.nama_negara
    , kecamatan.nama_kec
	, kelurahan.id_kel
    , kelurahan.nama_kel
FROM
    kabupaten
    INNER JOIN provinsi 
        ON (kabupaten.id_prov = provinsi.id_prov)
    INNER JOIN kecamatan 
        ON (kabupaten.id_kab = kecamatan.id_kab)
    INNER JOIN negara 
        ON (negara.id_negara = provinsi.id_negara)
    INNER JOIN kelurahan 
        ON (kecamatan.id_kec = kelurahan.id_kec) WHERE id_kel='$id'");
$row=mysqli_fetch_array($sql);
?>
<input type="hidden" name="id_kel" value="<?php echo $id ?>">
<div class="input-group">
    <span class="input-group-addon">
        <i class="fa fa-flag fa-fw" style="width: 38px;"></i><br>
        <small>Negara</small>
    </span>
    <input
        class="form-control"
        placeholder="Nama Negara"
        style="padding: 20px 15px;"
        value="<?php echo $row['nama_negara']; ?>"
        maxlength="40"
        readonly="readonly">
    <span class="input-group-addon">
        <i class="fa fa-star fa-fw" style="color:red"></i>
    </span>
</div>
<div class="input-group">
    <span class="input-group-addon">
        <i class="fa fa-flag fa-fw" style="width: 38px;"></i><br>
        <small>Prov.</small>
    </span>
    <input
        class="form-control"
        placeholder="Nama Provinsi"
        style="padding: 20px 15px;"
        value="<?php echo $row['nama_prov']; ?>"
        maxlength="40"
        readonly="readonly">
    <span class="input-group-addon">
        <i class="fa fa-star fa-fw" style="color:red"></i>
    </span>
</div>
<div class="input-group">
    <span class="input-group-addon">
        <i class="fa fa-flag fa-fw" style="width: 38px;"></i><br>
        <small>Kab.</small>
    </span>
    <input
        class="form-control"
        placeholder="Nama Kabupaten"
        style="padding: 20px 15px;"
        value="<?php echo $row['nama_kab']; ?>"
        maxlength="40"
        readonly="readonly">
    <span class="input-group-addon">
        <i class="fa fa-star fa-fw" style="color:red"></i>
    </span>
</div>
<div class="input-group">
    <span class="input-group-addon">
        <i class="fa fa-flag fa-fw" style="width: 38px;"></i><br>
        <small>Kec.</small>
    </span>
    <input
        class="form-control"
        placeholder="Nama Kecamatan"
        style="padding: 20px 15px;"
        value="<?php echo $row['nama_kec']; ?>"
        maxlength="40"
        readonly="readonly">
    <span class="input-group-addon">
        <i class="fa fa-star fa-fw" style="color:red"></i>
    </span>
</div>
<div class="input-group">
    <span class="input-group-addon">
        <i class="fa fa-tag fa-fw" style="width: 38px;"></i><br>
        <small>Nama</small>
    </span>
    <input
        class="form-control"
        placeholder="Nama Kelurahan"
        style="padding: 20px 15px;"
        name="kelurahan"
        value="<?php echo $row['nama_kel']; ?>"
        maxlength="40"
        required="required">
    <span class="input-group-addon">
        <i class="fa fa-star fa-fw" style="color:red"></i>
    </span>
</div>