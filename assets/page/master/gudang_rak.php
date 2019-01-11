<?php
if (isset($tambah_gudang_post)){
	$sql = "INSERT INTO gudang VALUES(null,'$nama_gudang')";
	$q = mysqli_query($con, $sql);
	if ($q){
		_buat_pesan("Input Berhasil","green");
	} else {
		_buat_pesan("Input Gagal","red");
	}
	_direct("?page=master&mode=gudang_rak");
}
if (isset($edit_gudang_post)){
	$sql = "UPDATE gudang SET nama_gudang='$nama_gudang' WHERE id_gudang=$id_gudang";
	$q = mysqli_query($con, $sql);
	if ($q){
		_buat_pesan("Input Berhasil","green");
	} else {
		_buat_pesan("Input Gagal","red");
	}
	_direct("?page=master&mode=gudang_rak");
}
if (isset($tambah_rak_post)){
	$sql = "INSERT INTO rak VALUES(null,$id_gudang,'$nama_rak')";
	$q = mysqli_query($con, $sql);
	if ($q){
		_buat_pesan("Input Berhasil","green");
	} else {
		_buat_pesan("Input Gagal","red");
	}
	_direct("?page=master&mode=gudang_rak");
}
if (isset($edit_rak_post)){
	$sql = "UPDATE rak SET id_gudang=$id_gudang, nama_rak='$nama_rak' WHERE id_rak=$id_rak";
	$q = mysqli_query($con, $sql);
	if ($q){
		_buat_pesan("Input Berhasil","green");
	} else {
		_buat_pesan("Input Gagal","red");
	}
	_direct("?page=master&mode=gudang_rak");
}
?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h3>MASTER GUDANG & RAK</h3>
                        <?php
						if (isset($pesan)){
							echo '<span class="badge bg-' .$warna. '">' .$pesan. '</span>';
						}
						?>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="alert alert-info">
                            <strong>Info! Nama Gudang dan Rak tidak boleh sama.</strong><br>
                            Klik kolom pada tabel untuk detail/ubah.</strong>
                    </div>
                    <p align="right">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                            <i class="fa fa-plus"></i>
                            Tambah Gudang</button>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#myModal2">
                            <i class="fa fa-plus"></i>
                            Tambah Rak</button>
                    </p>

                    <table id="table1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Gudang</th>
                                <th>Nama Rak</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
$sql=mysqli_query($con, "SELECT * FROM gudang LEFT JOIN rak ON (gudang.id_gudang = rak.id_gudang) ORDER BY rak.id_rak DESC");
$i=0;
while($row=mysqli_fetch_array($sql)){
$i+=1;
	echo '			<tr>
						<td>' .$i. '</a></td>
						<td><a data-toggle="modal" data-target="#myModal3" data-id="' .$row['id_gudang']. '" data-nama="' .$row['nama_gudang']. '">' .$row['nama_gudang']. '</a></td>
						<td><a data-toggle="modal" data-target="#myModal4" data-id="' .$row['id_rak']. '">' .$row['nama_rak']. '</a></td>
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
            <h4 class="modal-title">Tambah Data Gudang</h4>
        </div>
        <div class="modal-body">
            <form action="" method="post">
                <input type="hidden" name="tambah_gudang_post" value="true">
                <div class="col-md-12">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-building fa-fw"></i><br>
                            <small>Nama</small>
                        </span>
                        <input
                            class="form-control"
                            type="text"
                            name="nama_gudang"
                            style="padding: 20px 15px;"
                            placeholder="Nama Gudang"
                            maxlength="20"
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
            <h4 class="modal-title">Tambah Data Rak</h4>
        </div>
        <div class="modal-body">
            <form action="" method="post">
                <input type="hidden" name="tambah_rak_post" value="true">
                <div class="col-md-12">
                    <div class="input-group">
                        <span class="input-group-addon" style="padding:2px 12px;">
                            <i class="fa fa-building fa-fw"></i><br>
                            <small>Gudang</small>
                        </span>
                        <select
                            class="form-control select"
                            id="select_gudang"
                            name="id_gudang"
                            required="required">
                            <option value="" disabled="disabled" selected="selected">Pilih Gudang</option>
                            <?php
									$sql=mysqli_query($con, "SELECT * FROM gudang");
									while($row=mysqli_fetch_array($sql)){
										echo '<option value="' .$row['id_gudang']. '">' .$row['nama_gudang']. '</option>';
									}
								?>
                        </select>
                        <span class="input-group-addon">
                            <i class="fa fa-star fa-fw" style="color:red"></i>
                        </span>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-archive fa-fw" style="width: 42px;"></i><br>
                            <small>Nama</small>
                        </span>
                        <input
                            class="form-control"
                            type="text"
                            name="nama_rak"
                            style="padding: 20px 15px;"
                            placeholder="Nama Rak"
                            maxlength="20"
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
<div id="myModal3" class="modal fade">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Ubah Data Gudang</h4>
        </div>
        <div class="modal-body">
            <form action="" method="post">
                <input type="hidden" name="edit_gudang_post" value="true">
                <input type="hidden" id="id_gudang" name="id_gudang" value="">
                <div class="col-md-12">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-building fa-fw"></i><br>
                            <small>Nama</small>
                        </span>
                        <input
                            class="form-control"
                            id="gudang"
                            name="nama_gudang"
                            style="padding: 20px 15px;"
                            placeholder="Nama Gudang"
                            maxlength="20"
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
<div id="myModal4" class="modal fade">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Ubah Data Rak</h4>
        </div>
        <div class="modal-body">
            <form action="" method="post">
                <input type="hidden" name="edit_rak_post" value="true">
                <div id="get_rak" class="col-md-12"></div>
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
    $('#myModal3').on('show.bs.modal', function (e) {
        var id = $(e.relatedTarget).data('id');
        var nama = $(e.relatedTarget).data('nama');
        $('#gudang').val(nama);
        $('#id_gudang').val(id);
    });
    $('#myModal4').on('show.bs.modal', function (e) {
        var id = $(e.relatedTarget).data('id');
        $('#get_rak').load('api/web/get-rak.php?id=' + id);
    });
});
</script>