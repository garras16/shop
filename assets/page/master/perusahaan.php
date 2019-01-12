<?php
if (isset($edit_perusahaan_post)){
	$sql = "UPDATE perusahaan SET nama_pt='$nama_pt',alamat='$alamat',id_negara=$id_negara,id_prov=$id_prov,id_kab=$id_kab,id_kec=$id_kec,id_kel=$id_kel,kode_pos='$kode_pos',telepon='$telepon' WHERE id_perusahaan=1";
	$q = mysqli_query($con, $sql);
	if ($q){
		_buat_pesan("Input Berhasil","green");
	} else {
		_buat_pesan("Input Gagal","red");
	}
}
$sql=mysqli_query($con, "SELECT * FROM perusahaan WHERE id_perusahaan=1");
$row=mysqli_fetch_array($sql);
?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h3>MASTER PERUSAHAAN</h3>
                        <?php
							if (isset($pesan)){
								echo '<span class="badge bg-' .$warna. '">' .$pesan. '</span><br/><br/>';
							}
						?>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <form action="" method="post">
                            <input type="hidden" name="edit_perusahaan_post" value="true">
                            <div class="col-md-12">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-building fa-fw" style="width: 52px;"></i><br>
                                        <small>Nama</small>
                                    </span>
                                    <input
                                        class="form-control"
                                        name="nama_pt"
                                        style="padding: 20px 15px;"
                                        placeholder="Nama Perusahaan"
                                        value="<?php echo $row['nama_pt']; ?>"
                                        maxlength="50"
                                        required="required">
                                    <span class="input-group-addon">
                                        <i class="fa fa-star fa-fw" style="color:red"></i>
                                    </span>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-map-marker fa-fw" style="width: 52px;"></i><br>
                                        <small>Alamat</small>
                                    </span>
                                    <input
                                        class="form-control"
                                        name="alamat"
                                        style="padding: 20px 15px;"
                                        placeholder="Alamat Perusahaan"
                                        value="<?php echo $row['alamat']; ?>"
                                        maxlength="50"
                                        required="required">
                                    <span class="input-group-addon">
                                        <i class="fa fa-star fa-fw" style="color:red"></i>
                                    </span>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon" style="padding: 2px 12px;">
                                        <i class="fa fa-map-marker fa-fw" style="width: 52px;"></i><br>
                                        <small>Negara</small>
                                    </span>
                                    <select
                                        id="select_negara"
                                        class="select2 form-control"
                                        name="id_negara"
                                        required="required">
                                        <option value="" disabled="disabled" selected="selected">Pilih Negara</option>
                                        <?php
								$sql2=mysqli_query($con, "SELECT * FROM negara");
								while ($r=mysqli_fetch_array($sql2)){
									echo '<option value="' .$r['id_negara']. '" ' .($r['id_negara'] == $row['id_negara'] ? 'selected' : ''). '>' .$r['nama_negara']. '</option>';
								}
							?>
                                    </select>
                                    <span class="input-group-addon">
                                        <i class="fa fa-star fa-fw" style="color:red"></i>
                                    </span>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon" style="padding: 2px 12px;">
                                        <i class="fa fa-map-marker fa-fw" style="width: 52px;"></i><br>
                                        <small>Prov.</small>
                                    </span>
                                    <select
                                        id="select_prov"
                                        class="select2 form-control"
                                        name="id_prov"
                                        required="required">
                                        <option value="" disabled="disabled" selected="selected">Pilih Provinsi</option>
                                        <?php
								$sql2=mysqli_query($con, "SELECT * FROM provinsi");
								while ($r=mysqli_fetch_array($sql2)){
									echo '<option value="' .$r['id_prov']. '" ' .($r['id_prov'] == $row['id_prov'] ? 'selected' : ''). '>' .$r['nama_prov']. '</option>';
								}
							?>
                                    </select>
                                    <span class="input-group-addon">
                                        <i class="fa fa-star fa-fw" style="color:red"></i>
                                    </span>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon" style="padding: 2px 12px;">
                                        <i class="fa fa-map-marker fa-fw" style="width: 52px;"></i><br>
                                        <small>Kab.</small>
                                    </span>
                                    <select
                                        id="select_kab"
                                        class="select2 form-control"
                                        name="id_kab"
                                        required="required">
                                        <option value="" disabled="disabled" selected="selected">Pilih Kabupaten</option>
                                        <?php
								$sql2=mysqli_query($con, "SELECT * FROM kabupaten");
								while ($r=mysqli_fetch_array($sql2)){
									echo '<option value="' .$r['id_kab']. '" ' .($r['id_kab'] == $row['id_kab'] ? 'selected' : ''). '>' .$r['nama_kab']. '</option>';
								}
							?>
                                    </select>
                                    <span class="input-group-addon">
                                        <i class="fa fa-star fa-fw" style="color:red"></i>
                                    </span>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon" style="padding: 2px 12px;">
                                        <i class="fa fa-map-marker fa-fw" style="width: 52px;"></i><br>
                                        <small>Kec.</small>
                                    </span>
                                    <select id="select_kec" class="select2 form-control" name="id_kec">
                                        <option value="" disabled="disabled" selected="selected">Pilih Kecamatan</option>
                                        <?php
								$sql2=mysqli_query($con, "SELECT * FROM kecamatan");
								while ($r=mysqli_fetch_array($sql2)){
									echo '<option value="' .$r['id_kec']. '" ' .($r['id_kec'] == $row['id_kec'] ? 'selected' : ''). '>' .$r['nama_kec']. '</option>';
								}
							?>
                                    </select>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon" style="padding: 2px 12px;">
                                        <i class="fa fa-map-marker fa-fw" style="width: 52px;"></i><br>
                                        <small>Kel.</small>
                                    </span>
                                    <select id="select_kel" class="select2 form-control" name="id_kel">
                                        <option value="" disabled="disabled" selected="selected">Pilih Kelurahan</option>
                                        <?php
								$sql2=mysqli_query($con, "SELECT * FROM kelurahan");
								while ($r=mysqli_fetch_array($sql2)){
									echo '<option value="' .$r['id_kel']. '" ' .($r['id_kel'] == $row['id_kel'] ? 'selected' : ''). '>' .$r['nama_kel']. '</option>';
								}
							?>
                                    </select>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-map-marker fa-fw" style="width: 52px;"></i><br>
                                        <small>Kode Pos</small>
                                    </span>
                                    <input
                                        name="kode_pos"
                                        type="number"
                                        style="padding: 20px 15px;"
                                        class="form-control"
                                        placeholder="Kode Pos"
                                        onkeypress="if(this.value.length==7) return false;"
                                        value="<?php echo $row['kode_pos']; ?>">
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-phone fa-fw" style="width: 52px;"></i><br>
                                        <small>Tlp.</small>
                                    </span>
                                    <input
                                        class="form-control"
                                        name="telepon"
                                        style="padding: 20px 15px;"
                                        placeholder="Telepon"
                                        type="number"
                                        onkeypress="if(this.value.length==20) return false;"
                                        value="<?php echo $row['telepon']; ?>"
                                        required="required">
                                    <span class="input-group-addon">
                                        <i class="fa fa-star fa-fw" style="color:red"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="submit" class="btn btn-primary" value="Simpan">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /page content -->

    </div>
</div>

<script>
    $('#select_negara').change(function () {
        var id = $(this).val();
        $('#select_prov').load('api/web/get-select-daerah.php?id_negara=' + id);
    });
    $('#select_prov').change(function () {
        var id = $(this).val();
        $('#select_kab').load('api/web/get-select-daerah.php?id_prov=' + id);
    });
    $('#select_kab').change(function () {
        var id = $(this).val();
        $('#select_kec').load('api/web/get-select-daerah.php?id_kab=' + id);
    });
    $('#select_kec').change(function () {
        var id = $(this).val();
        $('#select_kel').load('api/web/get-select-daerah.php?id_kec=' + id);
    });
</script>