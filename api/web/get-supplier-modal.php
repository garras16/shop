<?php
    date_default_timezone_set('Asia/Jakarta');
    require_once('../../assets/inc/config.php');
    require_once('../../assets/inc/publicfunc.php');

    if (isset($_GET['id_supplier'])){
        $id_supplier=$_GET['id_supplier'];
        $id_negara=$_GET['id_negara'];
        $id_prov=$_GET['id_prov'];
        $id_kab=$_GET['id_kab'];
        $id_kec=$_GET['id_kec'];
        $id_kel=$_GET['id_kel'];
    } else {
        die();
    }
    $sql=mysqli_query($con, "SELECT * FROM supplier WHERE id_supplier='$id_supplier'");
    $row=mysqli_fetch_array($sql);
?>
<input type="hidden" name="id_supplier" value="<?php echo $id_supplier ?>">
<div class="col-sm-12">
    <div class="input-group">
        <span class="input-group-addon">
            <i class="fa fa-building fa-fw" style="width:51px;"></i><br>
            <small>Nama</small>
        </span>
        <input
            class="form-control"
            id="nama"
            name="nama_supplier"
            style="padding: 20px 15px;"
            placeholder="Nama Supplier"
            value="<?php echo $row['nama_supplier']; ?>"
            maxlength="50"
            required="required">
        <span class="input-group-addon">
            <i class="fa fa-star fa-fw" style="color:red"></i>
        </span>
    </div>
    <div class="input-group">
        <span class="input-group-addon">
            <i class="fa fa-map-marker fa-fw" style="width:51px;"></i><br>
            <small>Alamat</small>
        </span>
        <input
            name="alamat"
            class="form-control"
            style="padding: 20px 15px;"
            placeholder="Alamat Supplier"
            value="<?php echo $row['alamat']; ?>"
            maxlength="200"
            required="required">
        <span class="input-group-addon">
            <i class="fa fa-star fa-fw" style="color:red"></i>
        </span>
    </div>
</div>
<div class="col-sm-6">
    <div class="input-group">
        <span class="input-group-addon" style="padding: 2px 12px;">
            <i class="fa fa-map-marker fa-fw" style="width:51px;"></i><br>
            <small>Negara</small>
        </span>
        <select
            id="select_negara_2"
            class="select2 form-control"
            name="id_negara"
            required="required">
            <option value="" disabled="disabled" selected="selected">Pilih Negara</option>
            <?php
						$sql=mysqli_query($con, "SELECT * FROM negara");
						while ($rows=mysqli_fetch_array($sql)){
							echo '<option value="' .$rows['id_negara']. '" ' .($row['id_negara'] == $rows['id_negara'] ? 'selected' : ''). '>' .$rows['nama_negara']. '</option>';
						}
					?>
        </select>
        <span class="input-group-addon">
            <i class="fa fa-star fa-fw" style="color:red"></i>
        </span>
    </div>
</div>
<div class="col-sm-6">
    <div class="input-group">
        <span class="input-group-addon" style="padding: 2px 12px;">
            <i class="fa fa-map-marker fa-fw" style="width:51px;"></i><br>
            <small>Prov.</small>
        </span>
        <select
            id="select_prov_2"
            class="select2 form-control"
            name="id_prov"
            required="required">
            <?php
					$sql=mysqli_query($con, "SELECT * FROM provinsi WHERE id_negara=" .$id_negara);
					while ($rows=mysqli_fetch_array($sql)){
						echo '<option value="' .$rows['id_prov']. '" ' .($row['id_prov'] == $rows['id_prov'] ? 'selected' : ''). '>' .$rows['nama_prov']. '</option>';
					}
				?>
        </select>
        <span class="input-group-addon">
            <i class="fa fa-star fa-fw" style="color:red"></i>
        </span>
    </div>
</div>
<div class="col-sm-6">
    <div class="input-group">
        <span class="input-group-addon" style="padding: 2px 12px;">
            <i class="fa fa-map-marker fa-fw" style="width:51px;"></i><br>
            <small>Kab.</small>
        </span>
        <select
            id="select_kab_2"
            class="select2 form-control"
            name="id_kab"
            required="required">
            <?php
					$sql=mysqli_query($con, "SELECT * FROM kabupaten WHERE id_prov=" .$id_prov);
					while ($rows=mysqli_fetch_array($sql)){
						echo '<option value="' .$rows['id_kab']. '" ' .($row['id_kab'] == $rows['id_kab'] ? 'selected' : ''). '>' .$rows['nama_kab']. '</option>';
					}
				?>
        </select>
        <span class="input-group-addon">
            <i class="fa fa-star fa-fw" style="color:red"></i>
        </span>
    </div>
</div>
<div class="col-sm-6">
    <div class="input-group">
        <span class="input-group-addon" style="padding: 2px 12px;">
            <i class="fa fa-map-marker fa-fw" style="width:51px;"></i><br>
            <small>Kec.</small>
        </span>
        <select id="select_kec_2" class="select2 form-control" name="id_kec">
            <?php
					$sql=mysqli_query($con, "SELECT * FROM kecamatan WHERE id_kab=" .$id_kab);
					while ($rows=mysqli_fetch_array($sql)){
						echo '<option value="' .$rows['id_kec']. '" ' .($row['id_kec'] == $rows['id_kec'] ? 'selected' : ''). '>' .$rows['nama_kec']. '</option>';
					}
				?>
        </select>
    </div>
</div>
<div class="col-sm-6">
    <div class="input-group">
        <span class="input-group-addon" style="padding: 2px 12px;">
            <i class="fa fa-map-marker fa-fw" style="width:51px;"></i><br>
            <small>Kec.</small>
        </span>
        <select id="select_kel_2" class="select2 form-control" name="id_kel">
            <?php
					$sql=mysqli_query($con, "SELECT * FROM kelurahan WHERE id_kec=" .$id_kec);
					while ($rows=mysqli_fetch_array($sql)){
						echo '<option value="' .$rows['id_kel']. '" ' .($row['id_kel'] == $rows['id_kel'] ? 'selected' : ''). '>' .$rows['nama_kel']. '</option>';
					}
				?>
        </select>
    </div>
</div>
<div class="col-sm-6">
    <div class="input-group">
        <span class="input-group-addon">
            <i class="fa fa-map-marker fa-fw" style="width:51px;"></i><br>
            <small>Kode Pos</small>
        </span>
        <input
            name="kode_pos"
            type="number"
            class="form-control"
            style="padding: 20px 15px;"
            placeholder="Kode Pos"
            value="<?php echo $row['kode_pos']; ?>"
            onkeypress="if(this.value.length==7) return false;">
    </div>
</div>
<div class="col-sm-12">
    <div class="input-group">
        <span class="input-group-addon">
            <i class="fa fa-phone fa-fw" style="width:51px;"></i><br>
            <small>Tlp</small>
        </span>
        <input
            name="telepon_supplier"
            style="padding: 20px 15px;"
            type="number"
            class="form-control"
            placeholder="Telepon Supplier"
            value="<?php echo $row['telepon_supplier']; ?>"
            onkeypress="if(this.value.length==20) return false;"
            required="required">
        <span class="input-group-addon">
            <i class="fa fa-star fa-fw" style="color:red"></i>
        </span>
    </div>
</div>
<div class="col-sm-12">
    <div class="input-group">
        <span class="input-group-addon">
            <i class="fa fa-user fa-fw" style="width:51px;"></i><br>
            <small>Kontak</small>
        </span>
        <input
            name="kontak"
            class="form-control"
            style="padding: 20px 15px;"
            placeholder="Kontak Person"
            value="<?php echo $row['kontakperson']; ?>"
            maxlength="50"
            required="required">
    </div>
    <div class="input-group">
        <span class="input-group-addon">
            <i class="fa fa-phone fa-fw" style="width:51px;"></i><br>
            <small></small>Telepon</span>
        <input
            name="telepon_kontak"
            style="padding: 20px 15px;"
            type="number"
            class="form-control"
            placeholder="Telepon Kontak Person"
            value="<?php echo $row['telepon_kontak']; ?>"
            onkeypress="if(this.value.length==20) return false;"
            required="required">
    </div>
    <div class="input-group">
        <span class="input-group-addon" style="padding: 2px 12px;">
            <i class="fa fa-flag fa-fw" style="width:51px;"></i><br>
            <small>Status</small>
        </span>
        <select
            class="form-control"
            id="select_status"
            name="status"
            required="required">
            <option value="" disabled="disabled" selected="selected">Pilih Status</option>
            <option value="0" <?php echo ($row['status'] == 0 ? 'selected' : '') ?>>NON AKTIF</option>
            <option value="1" <?php echo ($row['status'] == 1 ? 'selected' : '') ?>>AKTIF</option>
        </select>
        <span class="input-group-addon">
            <i class="fa fa-star fa-fw" style="color:red"></i>
        </span>
    </div>
</div>

<script>
    $(".select2").select2({placeholderOption: "first", allowClear: true, width: '100%'});
</script>