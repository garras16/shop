<?php
if (isset($tambah_jabatan_post)){
	$sql = "INSERT INTO jabatan VALUES(null,'$jabatan',$status)";
	$q = mysqli_query($con, $sql);
	if ($q){
		_buat_pesan("Input Berhasil","green");
	} else {
		_buat_pesan("Input Gagal","red");
	}
}
if (isset($edit_jabatan_post)){
	$sql = "UPDATE jabatan SET nama_jabatan='$jabatan',status=$status WHERE id_jabatan=$id_jabatan";
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
                        <h3>MASTER JABATAN</h3>
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
                                    <th>Jabatan</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
$sql=mysqli_query($con, "SELECT * FROM jabatan ORDER BY id_jabatan DESC");
$i=0;
while($row=mysqli_fetch_array($sql)){
	$i+=1;
	$status = ($row['status'] == 1 ? 'Aktif' : 'Non Aktif');
	echo '			<tr>
						<td><a data-toggle="modal" data-target="#myModal2" data-id="' .$row['id_jabatan']. '">' .$i. '</a></td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id="' .$row['id_jabatan']. '">' .strtoupper($row['nama_jabatan']). '</a></td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id="' .$row['id_jabatan']. '">' .strtoupper($status). '</a></td>
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
                <h4 class="modal-title">Tambah Data Jabatan
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <input type="hidden" name="tambah_jabatan_post" value="true">
                        <div class="form-group col-sm-12">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-briefcase fa-fw"></i><br>
                                    <small>Jabatan</small>
                                </span>
                                <input
                                    class="form-control"
                                    style="padding:20px 15px;"
                                    type="text"
                                    placeholder="Nama Jabatan"
                                    name="jabatan"
                                    maxlength="20"
                                    required="required">
                                <span class="input-group-addon">
                                    <i class="fa fa-star fa-fw" style="color:red"></i>
                                </span>
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon" style="width:68px; padding: 2px 12px;">
                                    <i class="fa fa-flag fa-fw"></i><br>
                                    <small>Status</small>
                                </span>
                                <select
                                    class="form-control select"
                                    id="select_status"
                                    name="status"
                                    required="required">
                                    <option value="" disabled="disabled" selected="selected">Pilih Status</option>
                                    <option value="0">NON AKTIF</option>
                                    <option value="1">AKTIF</option>
                                </select>
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

    <!-- modal input -->
    <div id="myModal2" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Ubah Data Jabatan
                    </div>
                    <div class="modal-body">
                        <form action="" method="post">
                            <input type="hidden" name="edit_jabatan_post" value="true">
                            <div id="get_jabatan" class="col-sm-12"></div>
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
                    $('#get_jabatan').load('api/web/get-jabatan.php?id=' + id, function () {});
                })
            });
        </script>