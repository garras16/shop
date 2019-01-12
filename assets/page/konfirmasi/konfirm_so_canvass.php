<?php
$id_karyawan=$_SESSION['id_karyawan'];
if (isset($edit_lap_stock_opname_post)){
	$sql=mysqli_query($con, "UPDATE lap_stock_opname SET qty_cek=$qty_cek,selisih=$selisih WHERE id_laporan_stock_opname=$id_laporan_stock_opname");
	if (isset($_GET['id_konfirm'])){
		$url="?page=konfirmasi&mode=konfirm_so_canvass&id=" .$id. "&id_konfirm=" .$_GET['id_konfirm'];
	} else {
		$url="?page=konfirmasi&mode=konfirm_so_canvass&id=" .$id;
	}
	if ($sql){
		_buat_pesan("Input Berhasil","green");
	} else {
		_buat_pesan("Input Gagal","red");
	}
	_direct($url);
}
if (isset($_GET['act']) && $_GET['act']=='tolak'){
	$sql=mysqli_query($con, "UPDATE canvass_keluar SET status=2 WHERE id_canvass_keluar=$id");
	$sql=mysqli_query($con, "DELETE FROM lap_stock_opname WHERE id_canvass_keluar=$id");
	$sql=mysqli_query($con, "DELETE FROM canvass_stock_opname WHERE id_canvass_keluar=$id");
	$sql=mysqli_query($con, "UPDATE konfirm_owner SET status=1 WHERE id_konfirm_owner=" .$_GET['id_konfirm']);
	_direct("?page=konfirmasi&mode=konfirmasi");
}
if (isset($_GET['act']) && $_GET['act']=='terima'){
	$sql=mysqli_query($con, "UPDATE canvass_keluar SET status=3 WHERE id_canvass_keluar=$id");
	$sql=mysqli_query($con, "UPDATE canvass_stock_opname SET status=1 WHERE id_canvass_keluar=$id");
	$sql=mysqli_query($con, "UPDATE konfirm_owner SET status=1 WHERE id_konfirm_owner=" .$_GET['id_konfirm']);
	$sql=mysqli_query($con, "SELECT * FROM lap_stock_opname WHERE id_canvass_keluar=$id AND selisih<>0");
	while($row=mysqli_fetch_array($sql)){
		$sql2=mysqli_query($con, "UPDATE lap_stock_opname SET qty_sisa=" .$row['qty_cek']. ",selisih=0 WHERE id_canvass_keluar=$id AND id_barang=" .$row['id_barang']. " AND expire='" .$row['expire']. "'");
	}
	_direct("?page=konfirmasi&mode=konfirmasi");
}
	$sql=mysqli_query($con, "SELECT *
FROM
    canvass_keluar
    LEFT JOIN kendaraan 
        ON (canvass_keluar.id_mobil = kendaraan.id_kendaraan)
	WHERE id_canvass_keluar=$id");
	$row=mysqli_fetch_array($sql);
	$tgl_canvass=$row['tanggal_canvass'];
	$nama_mobil=$row['nama_kendaraan'];
	$plat=$row['plat'];
	$sql2=mysqli_query($con, "SELECT *
FROM
    canvass_keluar_karyawan
    INNER JOIN karyawan 
        ON (canvass_keluar_karyawan.id_karyawan = karyawan.id_karyawan)
	INNER JOIN users 
        ON (karyawan.id_karyawan = users.id_karyawan)
	WHERE id_canvass_keluar=$id");
	$baris=mysql_num_rows($sql2);
	$sql4=mysqli_query($con, "SELECT tgl_lap
FROM
    lap_stock_opname
 WHERE id_canvass_keluar=$id");
 $row4=mysqli_fetch_array($sql4);
 $tgl_so=$row4['tgl_lap'];
?>
<div class="right_col loading" role="main">
    <div class="">

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h3>KONFIRMASI STOCK OPNAME (CANVASS)</h3>
                        <?php
							if (isset($pesan)){
								echo '<span class="badge bg-' .$warna. '">' .$pesan. '</span>';
							}
						?>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <?php
	echo '					<tr><td width="40%">Tanggal Canvass</td><td>' .date("d-m-Y", strtotime($tgl_canvass)). '</td></tr>
							<tr><td width="40%">Tanggal Stock Opname</td><td>' .date("d-m-Y", strtotime($tgl_so)). '</td></tr>
							<tr><td width="40%">Nama Mobil</td><td>' .$nama_mobil. '</td></tr>
							<tr><td width="40%">No Pol</td><td>' .$plat. '</td></tr>';
	
	echo '					<tr><td rowspan="' .$baris. '">Nama Karyawan</td>';
	while ($row2=mysqli_fetch_array($sql2)){
		echo '				<td>- ' .$row2['nama_karyawan']. ' ( ' .$row2['posisi']. ' )</td></tr>';
	}
	echo '</tr>';
?>
                            </tbody>
                        </table>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Nama Barang</th>
                                        <th>Qty Sisa (Seharusnya)</th>
                                        <th>Qty Sisa (Stock Opname)</th>
                                        <th>Qty Selisih</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
	$sql=mysqli_query($con, "SELECT *
FROM
    lap_stock_opname
    INNER JOIN barang 
        ON (lap_stock_opname.id_barang = barang.id_barang)
    INNER JOIN satuan 
        ON (barang.id_satuan = satuan.id_satuan)
 WHERE id_canvass_keluar=$id");
	while ($row=mysqli_fetch_array($sql)){
	($row['qty_sisa']==$row['qty_cek'] ? $style="" : $style="color:red;");
	($row['selisih']=='0' ? $send=false : $send=true);
	echo '<tr>
				<td style="vertical-align:middle;text-align:center;' .$style. '">' .$row['nama_barang']. '</td>
				<td style="vertical-align:middle;text-align:center;' .$style. '">' .format_angka($row['qty_sisa']). ' ' .$row['nama_satuan']. '</td>';
	if ($_SESSION['posisi']=='OWNER'){
		echo '	<td style="vertical-align:middle;text-align:center;' .$style. '"><a data-toggle="modal" data-target="#myModal" data-id="' .$row['id_laporan_stock_opname']. '" data-qty_sisa="' .$row['qty_sisa']. '" data-qty_cek="' .$row['qty_cek']. '" data-satuan="' .$row['nama_satuan']. '">' .format_angka($row['qty_cek']). ' ' .$row['nama_satuan']. ' <i class="fa fa-external-link"></i> </a></td>';
	} else {
		echo '	<td style="vertical-align:middle;text-align:center;' .$style. '">' .format_angka($row['qty_cek']). ' ' .$row['nama_satuan']. '</td>';
	}
	echo '		<td style="vertical-align:middle;text-align:center;' .$style. '">' .format_angka($row['selisih']). ' ' .$row['nama_satuan']. '</td>
			</tr>';
	}	
?>
                                </tbody>
                            </table>
                        </div>
                        <center>
                            <a
                                href="?page=konfirmasi&mode=konfirm_so_canvass&act=terima&id=<?php echo $id. '&id_konfirm=' .$_GET['id_konfirm'] ?>"
                                class="btn btn-primary">
                                <i class="fa fa-thumbs-up"></i>
                                TERIMA</a>
                            <a
                                href="?page=konfirmasi&mode=konfirm_so_canvass&act=tolak&id=<?php echo $id. '&id_konfirm=' .$_GET['id_konfirm']; ?>"
                                class="btn btn-danger">
                                <i class="fa fa-thumbs-down"></i>
                                TOLAK</a>
                        </center>
                    </div>
                </div>
                <div id="dummy"></div>
            </div>
        </div>
    </div>
</div>

<!-- modal input -->
<div id="myModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <div style="min-width:50px">&times;</div>
                </button>
                <h4 class="modal-title">Ubah Data Stock Opname</h4>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <input type="hidden" name="edit_lap_stock_opname_post" value="true">
                    <input
                        type="hidden"
                        id="id_laporan_stock_opname"
                        name="id_laporan_stock_opname"
                        value="">
                    <input type="hidden" id="qty_sisa" name="qty_sisa" value="">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-shopping-cart fa-fw"></i>
                        </span>
                        <input
                            id="qty_cek"
                            name="qty_cek"
                            type="text"
                            class="form-control"
                            placeholder="Qty Periksa"
                            required="required">
                        <span class="input-group-addon" id="satuan"></span>
                        <span class="input-group-addon">
                            <i class="fa fa-star fa-fw" style="color:red"></i>
                        </span>
                    </div>
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
        $('#qty_cek').inputmask('decimal', {
            allowMinus: false,
            autoGroup: true,
            groupSeparator: '.',
            rightAlign: false,
            autoUnmask: true,
            removeMaskOnSubmit: true
        });
        $('#myModal').on('show.bs.modal', function (e) {
            var id = $(e.relatedTarget).data('id');
            var qty_cek = $(e.relatedTarget).data('qty_cek');
            var qty_sisa = $(e.relatedTarget).data('qty_sisa');
            var sat = $(e.relatedTarget).data('satuan');
            $('#id_laporan_stock_opname').val(id);
            $('#qty_cek').val(qty_cek);
            $('#qty_sisa').val(qty_sisa);
            $('#satuan').html(sat);
        })
    })
</script>