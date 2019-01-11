<?php
if (isset($tambah_provinsi_post)){
	$nama_prov=explode(",",$provinsi);
	for ($i=0;$i < count($nama_prov);$i++){
		$sql = "INSERT INTO provinsi VALUES(null,'$id_negara','$nama_prov[$i]')";
		$q = mysqli_query($con, $sql);
		if ($q){
			_buat_pesan("Input Berhasil","green");
		} else {
			_buat_pesan("Input Gagal","red");
		}
	}
}
if (isset($edit_provinsi_post)){
	$sql = "UPDATE provinsi SET nama_prov='$provinsi' WHERE id_prov=$id_prov";
	$q = mysqli_query($con, $sql);
	if ($q){
		_buat_pesan("Input Berhasil","green");
	} else {
		_buat_pesan("Input Gagal","red");
	}
}
?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h3>MASTER PROVINSI</h3>
                        <?php
							if (isset($pesan)){
								echo '<span class="badge bg-' .$warna. '">' .$pesan. '</span>';
							}
							?>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="alert alert-info">
                            <strong>Klik kolom pada tabel untuk ubah.</strong>
                        </div>
                        <p align="right">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                <i class="fa fa-plus"></i>
                                Tambah</button>
                        </p>

                        <table id="table1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Negara</th>
                                    <th>Provinsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
$sql=mysqli_query($con, "SELECT
	negara.nama_negara
	, provinsi.id_prov
    , provinsi.nama_prov 
FROM
    negara
    INNER JOIN provinsi 
        ON (negara.id_negara = provinsi.id_negara)
ORDER BY provinsi.id_prov DESC");
$i=0;
while($row=mysqli_fetch_array($sql)){
	$i+=1;
	echo '			<tr>
						<td><a data-toggle="modal" data-target="#myModal2" data-id="' .$row['id_prov']. '">' .$i. '</a></td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id="' .$row['id_prov']. '">' .$row['nama_negara']. '</a></td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id="' .$row['id_prov']. '">' .$row['nama_prov']. '</a></td>
					</tr>';
}
?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /page content -->

    </div>
</div>

<!-- modal input -->
<div id="myModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Tambah Data Provinsi
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <input type="hidden" name="tambah_provinsi_post" value="true">
                        <div class="form-group col-sm-12">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-flag fa-fw"></i><br>
                                    <small>Negara</small>
                                </span>
                                <select class="form-control select" name="id_negara" required="required">
                                    <option value="" disabled="disabled" selected="selected">Pilih Negara</option>
                                    <?php
								$sql=mysqli_query($con, "SELECT * FROM negara");
								while ($row=mysqli_fetch_array($sql)){
									echo '<option value="' .$row['id_negara']. '">' .$row['nama_negara']. '</option>';
								}
							?>
                                </select>
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
                                    id="tags_me"
                                    class="form-control"
                                    type="text"
                                    data-text="provinsi"
                                    placeholder="Nama Provinsi"
                                    name="provinsi"
                                    maxlength="40">
                                <span class="input-group-addon">
                                    <i class="fa fa-star fa-fw" style="color:red"></i>
                                </span>
                            </div>
                            <p>Tekan "TAB" atau "koma" untuk menambah provinsi.</p>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" class="btn btn-primary" value="Simpan">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- modal input -->
    <div id="myModal2" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Ubah Data Provinsi</h4>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <input type="hidden" name="edit_provinsi_post" value="true">
                        <div id="get_provinsi" class="col-md-12"></div>
                        <div class="modal-footer">
                            <input type="submit" class="btn btn-primary" value="Simpan">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#myModal2').on('show.bs.modal', function (e) {
                var id = $(e.relatedTarget).data('id');
                $('#get_provinsi').load('api/web/get-provinsi.php?id=' + id, function () {});
            })
            $('#tags_me').tagsInput(
                {maxChars: 40, minWidth: '400px', defaultText: 'Provinsi', width: 'auto'}
            );
        });
    </script>