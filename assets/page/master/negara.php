<?php
if (isset($tambah_negara_post)){
	$sql = "INSERT INTO negara VALUES(null,'$negara')";
	$q = mysqli_query($con, $sql);
	if ($q){
		_buat_pesan("Input Berhasil","green");
	} else {
		_buat_pesan("Input Gagal","red");
	}
}
if (isset($edit_negara_post)){
	$sql = "UPDATE negara SET nama_negara='$negara' WHERE id_negara='$id_negara'";
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
                        <h3>MASTER NEGARA</h3>
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
                                </tr>
                            </thead>
                            <tbody>
                                <?php
$sql=mysqli_query($con, "SELECT * FROM negara ORDER BY id_negara");
$i=0;
while($row=mysqli_fetch_array($sql)){
	$i+=1;
	echo '			<tr>
						<td><a data-toggle="modal" data-target="#myModal2" data-id="' .$row['id_negara']. '">' .$i. '</a></td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id="' .$row['id_negara']. '">' .$row['nama_negara']. '</a></td>
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
                <h4 class="modal-title">Tambah Data Negara
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <input type="hidden" name="tambah_negara_post" value="true">
                        <div class="form-group col-sm-12">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-tag fa-fw"></i><br>
                                    <small>Nama</small>
                                </span>
                                <input
                                    class="form-control"
                                    type="text"
                                    placeholder="Nama Negara"
                                    style="padding: 20px 15px;"
                                    name="negara"
                                    maxlength="40"
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

    <!-- modal input -->
    <div id="myModal2" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Ubah Data Negara</h4>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <input type="hidden" name="edit_negara_post" value="true">
                        <div id="get_negara" class="col-md-12"></div>
                        <div class="modal-footer">
                            <input type="submit" class="btn btn-primary" value="Simpan">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('#myModal2').on('show.bs.modal', function (e) {
            var id = $(e.relatedTarget).data('id');
            $('#get_negara').load('api/web/get-negara.php?id=' + id, function () {});
        })
    </script>