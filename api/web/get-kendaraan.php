<?php
    date_default_timezone_set('Asia/Jakarta');
    require_once('../../assets/inc/config.php');
    require_once('../../assets/inc/publicfunc.php');

    if (isset($_GET['id'])){
        $id=$_GET['id'];
    } else {
        die();
    }
    $sql=mysqli_query($con, "SELECT * FROM kendaraan WHERE id_kendaraan='$id'");
    $row=mysqli_fetch_array($sql);
?>
<input type="hidden" name="id_kendaraan" value="<?php echo $id ?>">
<div class="input-group">
    <span class="input-group-addon">
        <i class="fa fa-car fa-fw" style="width: 48px;"></i><br>
        <small>Nama</small>
    </span>
    <input
        class="form-control"
        name="nama_kendaraan"
        style="padding: 20px 15px;"
        placeholder="Nama Kendaraan"
        value="<?php echo $row['nama_kendaraan'] ?>"
        maxlength="25"
        readonly="readonly">
    <span class="input-group-addon">
        <i class="fa fa-star fa-fw" style="color:red"></i>
    </span>
</div>
<div class="input-group">
    <span class="input-group-addon" style="padding: 2px 12px;">
        <i class="fa fa-truck fa-fw" style="width: 48px;"></i><br>
        <small>Jenis</small>
    </span>
    <select
        class="form-control"
        id="select_jenis_2"
        name="jenis_kendaraan"
        readonly="readonly">
        <option value="" disabled="disabled" selected="selected">Pilih Jenis</option>
        <option
            value="MOBIL"
            <?php echo ($row['jenis_kendaraan']=='MOBIL' ? ' selected' : '') ?>>MOBIL</option>
        <option
            value="MOTOR"
            <?php echo ($row['jenis_kendaraan']=='MOTOR' ? ' selected' : '') ?>>MOTOR</option>
    </select>
    <span class="input-group-addon">
        <i class="fa fa-star fa-fw" style="color:red"></i>
    </span>
</div>
<div class="input-group">
    <span class="input-group-addon" style="padding: 2px 12px;">
        <i class="fa fa-check fa-fw" style="width: 48px;"></i><br>
        <small>Varian</small>
    </span>
    <select
        class="form-control"
        id="select_varian_2"
        name="id_varian"
        readonly="readonly">
        <option value="" disabled="disabled" selected="selected">Pilih Varian</option>
        <?php
			$sql=mysqli_query($con, "SELECT * FROM varian_kendaraan WHERE nama_jenis='" .$row['jenis_kendaraan']. "'");
			while ($b=mysqli_fetch_array($sql)){
				echo '<option value="' .$b['id_varian']. '"' .($b['id_varian']==$row['id_varian'] ? ' selected' : ''). '>' .$b['nama_varian']. '</option>';
			}
		?>
    </select>
    <span class="input-group-addon">
        <i class="fa fa-star fa-fw" style="color:red"></i>
    </span>
</div>
<div class="input-group">
    <label>
        <b>NO POL
            <b>
                <font size="4" color="red">*</font>
            </b>
            : &nbsp;</b>
    </label>
    <?php
		$plat=explode(" ", $row['plat']);
	?>
    <input
        style="width: 30px"
        id="plat1_2"
        name="no_plat_1"
        maxlength="2"
        placeholder="BE"
        value="<?php echo $plat[0] ?>"
        required="required"
        readonly="readonly">&nbsp;
    <input
        style="width: 50px"
        id="plat2_2"
        name="no_plat_2"
        onkeypress="if(this.value.length==4) return false;"
        type="number"
        placeholder="9999"
        value="<?php echo $plat[1] ?>"
        required="required"
        readonly="readonly">&nbsp;
    <input
        style="width: 40px"
        id="plat3_2"
        name="no_plat_3"
        maxlength="3"
        placeholder="IDX"
        value="<?php echo $plat[2] ?>"
        required="required"
        readonly="readonly">&nbsp;
    <a id="add" class="btn btn-warning btn-xs" onclick="addPlat()">Tambah No Pol</a>
    <a
        id="save"
        class="btn btn-warning btn-xs"
        onclick="savePlat()"
        style="display: none;">Simpan No Pol</a>
</div>
<div class="input-group" style="display:none" id="datepicker">
    <span class="input-group-addon">Berlaku Mulai</span>
    <input
        class="form-control"
        id="berlaku"
        name="berlaku"
        value="<?php echo date('Y-m-d') ?>"
        required="">
    <span class="input-group-addon">
        <i class="fa fa-star fa-fw" style="color:red"></i>
    </span>
</div>
<div class="input-group">
    <span class="input-group-addon">
        <i class="fa fa-dashboard fa-fw" style="width: 48px;"></i><br>
        <small>KM/L</small>
    </span>
    <input
        class="form-control"
        style="padding: 20px 15px;"
        id="perbandingan_2"
        name="perbandingan"
        placeholder="Perbandingan 1L / KM"
        value="<?php echo $row['perbandingan'] ?>"
        readonly="readonly">
    <span class="input-group-addon">
        <i class="fa fa-star fa-fw" style="color:red"></i>
    </span>
</div>
<div class="input-group">
    <span class="input-group-addon">
        <i class="fa fa-bar-chart-o fa-fw" style="width: 48px;"></i><br>
        <small>KM Awal</small>
    </span>
    <input
        class="form-control"
        id="km_awal_2"
        name="km_awal"
        style="padding: 20px 15px;"
        placeholder="KM Awal"
        value="<?php echo $row['km_awal'] ?>"
        required="required">
    <span class="input-group-addon">
        <i class="fa fa-star fa-fw" style="color:red"></i>
    </span>
</div>
<div class="input-group">
    <span class="input-group-addon" style="padding: 2px 12px;">
        <i class="fa fa-truck fa-fw" style="width: 48px;"></i><br>
        <small>Status</small>
    </span>
    <select
        class="form-control"
        id="select_status"
        name="status"
        required="required">
        <option value="" disabled="disabled" selected="selected">Pilih Status</option>
        <option value="0" <?php echo ($row['status']=='0' ? ' selected' : '') ?>>NON AKTIF</option>
        <option value="1" <?php echo ($row['status']=='1' ? ' selected' : '') ?>>AKTIF</option>
    </select>
    <span class="input-group-addon">
        <i class="fa fa-star fa-fw" style="color:red"></i>
    </span>
</div>
<div class="input-group">
    <span class="input-group-addon" style="padding: 2px 12px;">
        <i class="fa fa-compass fa-fw"></i><br>
        <small>Canvass</small>
    </span>
    <select
        class="form-control select"
        id="select_canvass"
        name="canvass"
        required="required">
        <option value="" disabled="disabled" selected="selected">Mobil Canvass?</option>
        <option value="0" <?php echo ($row['canvass']=='0' ? ' selected' : '') ?>>TIDAK</option>
        <option value="1" <?php echo ($row['canvass']=='1' ? ' selected' : '') ?>>YA</option>
    </select>
    <span class="input-group-addon">
        <i class="fa fa-star fa-fw" style="color:red"></i>
    </span>
</div>
<div id="dummy"></div>
<script>
    function addPlat() {
        var id = <?php echo $id ?>;

        var plat1 = $('#plat1_2').val();
        var plat2 = $('#plat2_2').val();
        var plat3 = $('#plat3_2').val();
        $('#dummy').load(
            'api/web/add-plat-detail.php?id=' + id + '&plat1=' + plat1 + '&plat2=' +
            plat2 + '&plat3=' + plat3
        );
        $('#plat1_2').val('');
        $('#plat1_2').removeAttr('readonly');
        $('#plat2_2').val('');
        $('#plat2_2').removeAttr('readonly');
        $('#plat3_2').val('');
        $('#plat3_2').removeAttr('readonly');
        $('#add').attr('style', 'display: none;');
        $('#btn_save').attr('style', 'display: none;');
        $('#datepicker').removeAttr('style');
        $('#berlaku').attr('required', 'required');
        $('#save').removeAttr('style');
    }
    function savePlat() {
        if ($('#plat1_2').val().length > 0 && $('#plat2_2').val().length > 0 && $('#plat3_2').val().length > 0) {
            var id = <?php echo $id ?>;
            var plat1 = $('#plat1_2').val();
            var plat2 = $('#plat2_2').val();
            var plat3 = $('#plat3_2').val();
            var berlaku = $('#berlaku').val();
            $('#dummy').load(
                'api/web/save-plat-detail.php?id=' + id + '&plat1=' + plat1 + '&plat2=' +
                plat2 + '&plat3=' + plat3 + '&berlaku=' + berlaku
            );
            $('#plat1_2').attr('readonly', 'readonly');
            $('#plat2_2').attr('readonly', 'readonly');
            $('#plat3_2').attr('readonly', 'readonly');
            $('#save').attr('style', 'display: none;');
            $('#berlaku').removeAttr('required');
            $('#datepicker').attr('style', 'display: none;');
            $('#add').removeAttr('style');
            $('#btn_save').removeAttr('style');
        }
    }
    $(document).ready(function () {
        $('#datepicker').daterangepicker({
            singleDatePicker: true
        }, function (label) {
            $('#berlaku').val(label.format('YYYY-MM-DD'));
        });
    });
</script>