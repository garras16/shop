<?php
    date_default_timezone_set('Asia/Jakarta');
    require_once('../../assets/inc/config.php');
    require_once('../../assets/inc/publicfunc.php');

    if (isset($_GET['id'])){
        $id=$_GET['id'];
    } else {
        die();
    }
    $sql=mysqli_query($con, "SELECT * 
    FROM
        provinsi
        INNER JOIN negara 
            ON (provinsi.id_negara = negara.id_negara) WHERE id_prov='$id'");
    $row=mysqli_fetch_array($sql);
?>
<input type="hidden" name="id_prov" value="<?php echo $id ?>">
<div class="input-group">
    <span class="input-group-addon">
        <i class="fa fa-flag fa-fw"></i><br>
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
        <i class="fa fa-tag fa-fw" style="width: 38px;"></i><br>
        <small>Nama</small>
    </span>
    <input
        class="form-control"
        placeholder="Nama Provinsi"
        name="provinsi"
        style="padding: 20px 15px;"
        value="<?php echo $row['nama_prov']; ?>"
        maxlength="40"
        required="required">
    <span class="input-group-addon">
        <i class="fa fa-star fa-fw" style="color:red"></i>
    </span>
</div>