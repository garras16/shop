<?php
if (isset($tambah_satuan_post)){
	$sql = "INSERT INTO satuan VALUES(null,'$nama_satuan')";
	$q = mysqli_query($con, $sql);
	if ($q){
		_buat_pesan("Input Berhasil","green");
	} else {
		_buat_pesan("Input Gagal","red");
	}
}
if (isset($edit_satuan_post)){
	$sql = "UPDATE satuan SET nama_satuan='$nama_satuan' WHERE id_satuan=$id_satuan";
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
                        <h3>MASTER SATUAN BARANG</h3>
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
                                    <th>Nama Satuan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
$sql=mysqli_query($con, "SELECT * FROM satuan ORDER BY id_satuan DESC");
$i=0;
while($row=mysqli_fetch_array($sql)){
	$i+=1;
	echo '			<tr>
						<td><a data-toggle="modal" data-target="#myModal2" data-id="' .$row['id_satuan']. '" data-nama="' .$row['nama_satuan']. '">' .$i. '</a></td>
						<td><a data-toggle="modal" data-target="#myModal2" data-id="' .$row['id_satuan']. '" data-nama="' .$row['nama_satuan']. '">' .$row['nama_satuan']. '</a></td>
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
                <h4 class="modal-title">Tambah Data Satuan Barang</h4>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <input type="hidden" name="tambah_satuan_post" value="true">
                    <div class="form-group col-sm-12">
                        <div class="input-group">
                            <span class="input-group-addon" style="padding: 2px 12px;">
                                <i class="fa fa-tag fa-fw"></i><br>
                                <small>Nama</small>
                            </span>
                            <input
                                class="form-control"
                                type="text"
                                id="nama_satuan"
                                placeholder="Nama Satuan"
                                name="nama_satuan"
                                maxlength="10"
                                required="required">
                            <span class="input-group-addon">
                                <i class="fa fa-star fa-fw" style="color:red"></i>
                            </span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary" id="post_jual" value="Simpan">
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
                <h4 class="modal-title">Ubah Data Satuan Barang</h4>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <input type="hidden" name="edit_satuan_post" value="true">
                    <input id="id_satuan" type="hidden" name="id_satuan" value="">
                    <div class="form-group col-sm-12">
                        <div class="input-group">
                            <span class="input-group-addon" style="padding: 2px 12px;">
                                <i class="fa fa-tag fa-fw"></i><br>
                                <small>Nama</small>
                            </span>
                            <input
                                class="form-control"
                                id="nama_satuan_2"
                                placeholder="Nama Satuan"
                                name="nama_satuan"
                                maxlength="10"
                                required="required">
                            <span class="input-group-addon">
                                <i class="fa fa-star fa-fw" style="color:red"></i>
                            </span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary" id="post_jual" value="Simpan">
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
            var nama = $(e.relatedTarget).data('nama');
            $('#id_satuan').val(id);
            $('#nama_satuan_2').val(nama);
        });
    });
</script>