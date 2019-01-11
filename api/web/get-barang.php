<?php
date_default_timezone_set('Asia/Jakarta');
require_once('../../assets/inc/config.php');
require_once('../../assets/inc/publicfunc.php');

if (isset($_GET['id'])){
	$id=$_GET['id'];
} else {
	die();
}
$sql=mysqli_query($con, "SELECT * FROM barang WHERE id_barang='$id'");
$row=mysqli_fetch_array($sql);
?>
<input type="hidden" name="id_barang" value="<?php echo $id ?>">
<div class="input-group">
    <span class="input-group-addon">
        <i class="fa fa-bookmark fa-fw" style="width: 55px;"></i><br>
        <small>Nama</small>
    </span>
    <input
        class="form-control"
        id="nama_barang"
        style="padding: 20px 15px;"
        name="nama_barang"
        value="<?php echo $row['nama_barang']; ?>"
        maxlength="100"
        required="required">
    <span class="input-group-addon">
        <i class="fa fa-star fa-fw" style="color:red"></i>
    </span>
</div>
<div class="input-group">
    <span class="input-group-addon">
        <i class="fa fa-barcode fa-fw" style="width: 55px;"></i><br>
        <small>Barcode</small>
    </span>
    <input
        id="barcode"
        name="barcode"
        style="padding: 20px 15px;"
        class="form-control"
        placeholder="Barcode"
        value="<?php echo $row['barcode']; ?>"
        maxlength="30"
        required="required">
    <span class="input-group-addon">
        <i class="fa fa-star fa-fw" style="color:red"></i>
    </span>
</div>
<div class="input-group">
    <span class="input-group-addon" style="padding: 2px 12px;">
        <i class="fa fa-tag fa-fw" style="width: 55px;"></i><br>
        <small>Satuan</small>
    </span>
    <select
        class="select2 form-control"
        id="select_satuan"
        name="id_satuan"
        required="required">
        <option value="" disabled="disabled" selected="selected">Pilih Satuan</option>
        <?php 
			$brg=mysqli_query($con, "select * from satuan");
			while($b=mysqli_fetch_array($brg)){
		?>
        <option
            value="<?php echo $b['id_satuan']; ?>"
            <?php echo ($b['id_satuan'] == $row['id_satuan'] ? 'selected' : '') ?>><?php echo $b['nama_satuan'];?></option>
        <?php 
			}
		?>
    </select>
    <span class="input-group-addon">
        <i class="fa fa-star fa-fw" style="color:red"></i>
    </span>
</div>
<div class="input-group">
    <span class="input-group-addon">
        <i class="fa fa-warning fa-fw" style="width: 55px;"></i><br>
        <small>Min. Jual</small>
    </span>
    <input
        id="min_order_2"
        name="min_order"
        class="form-control"
        style="padding: 20px 15px;"
        placeholder="Minimal Jual"
        min="1"
        onkeypress="if(this.value.length==6) return false;"
        value="<?php echo $row['min_order']; ?>"
        required="required">
    <span class="input-group-addon">
        <i class="fa fa-star fa-fw" style="color:red"></i>
    </span>
</div>
<div class="input-group">
    <span class="input-group-addon">
        <i class="fa fa-warning fa-fw" style="width: 55px;"></i><br>
        <small>Stok Min.</small>
    </span>
    <input
        id="stok_min_2"
        name="stok_minimal"
        class="form-control"
        style="padding: 20px 15px;"
        placeholder="Stok Minimal"
        min="1"
        onkeypress="if(this.value.length==6) return false;"
        value="<?php echo $row['stok_minimal']; ?>"
        required="required">
    <span class="input-group-addon">
        <i class="fa fa-star fa-fw" style="color:red"></i>
    </span>
</div>
<div class="input-group">
    <span class="input-group-addon">
        <i class="fa fa-certificate fa-fw" style="width: 55px;"></i><br>
        <small>No. Ijin</small>
    </span>
    <input
        id="ijin"
        name="ijin"
        class="form-control"
        style="padding: 20px 15px;"
        placeholder="No. Ijin"
        value="<?php echo $row['no_ijin']; ?>"
        maxlength="25"
        required="required">
    <span class="input-group-addon">
        <i class="fa fa-star fa-fw" style="color:red"></i>
    </span>
</div>
<div class="input-group">
    <span class="input-group-addon" style="padding: 2px 12px;">
        <i class="fa fa-flag fa-fw" style="width: 55px;"></i><br>
        <small>Status</small>
    </span>
    <select
        class="form-control"
        id="select_status"
        name="status"
        required="required">
        <option value="" disabled="disabled">Pilih Status</option>
        <option value="0" <?php echo ($row['status'] == 0 ? 'selected' : '') ?>>NON AKTIF</option>
        <option value="1" <?php echo ($row['status'] == 1 ? 'selected' : '') ?>>AKTIF</option>
    </select>
    <span class="input-group-addon">
        <i class="fa fa-star fa-fw" style="color:red"></i>
    </span>
</div>
<div class="input-group">
    <span class="input-group-addon" style="padding: 2px 12px;">
        <i class="fa fa-flag fa-fw"></i><br>
        <small>Tampilkan</small>
    </span>
    <select
        class="form-control"
        id="select_tampil"
        name="tampil"
        required="required">
        <option value="" disabled="disabled" selected="selected">Tampilkan ke semua user ?</option>
        <option value="0" <?php echo ($row['tampil'] == 0 ? 'selected' : '') ?>>TIDAK</option>
        <option value="1" <?php echo ($row['tampil'] == 1 ? 'selected' : '') ?>>YA</option>
    </select>
    <span class="input-group-addon">
        <i class="fa fa-star fa-fw" style="color:red"></i>
    </span>
</div>

<script>
    $(".select2").select2({placeholderOption: "first", allowClear: true, width: '100%'});
</script>