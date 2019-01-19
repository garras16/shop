<?php
if (isset($tambah_input_kas_kecil_post)){
	$sql = "INSERT INTO kas_kecil VALUES(null,'$tanggal','$komponen','$jenis','$keterangan',$jumlah)";
	$q = mysqli_query($con, $sql);
	if ($q){
		_buat_pesan("Input Berhasil","green");
	} else {
		_buat_pesan("Input Gagal","red");
	}
	_direct("?page=keuangan&mode=kas_kecil");
}

if (isset($_GET['del'])){
	$sql = "DELETE FROM kas_kecil WHERE id_kas_kecil=" .$_GET['del']. "";
	$q = mysqli_query($con, $sql);
	if ($q){
		_buat_pesan("Input Berhasil","green");
	} else {
		_buat_pesan("Input Gagal","red");
	}
	_direct("?page=keuangan&mode=kas_kecil");
}
$bln_sql="MONTH(CURRENT_DATE())";
$thn_sql="YEAR(CURRENT_DATE())";
?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h3>KAS KECIL</h3>
                        <?php
							if (isset($pesan)){
								echo '<span class="badge bg-' .$warna. '">' .$pesan. '</span>';
							}
							?>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="col-xs-12" style="text-align:right;margin-bottom:10px">
                            <input
                                type="text"
                                id="datepicker"
                                placeholder="Bulan & Tahun"
                                style="width:100px"
                                readonly="readonly"></input>
                            <input type="button" id="cari" onclick="cari()" value="Cari"></input>
                            <input type="button" id="reset" onclick="reset()" value="Reset"></input>
                        </div>
                        <p align="right">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                <i class="fa fa-plus"></i>
                                Tambah</button>
                        </p>
                        <div class="clearfix"></div>
                        <div class="table-responsive">
                            <table id="table1" class="table table-bordered table-striped" style="min-width: 900px;">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Komponen</th>
                                        <th>Uang Masuk</th>
                                        <th>Uang Keluar</th>
                                        <th>Keterangan</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
$jumlah_masuk=0;$jumlah_keluar=0;
if (isset($_GET['cari'])){
	$tgl = explode("-", $_GET['cari']);
	$bln = $tgl[0];	$thn = $tgl[1];
	$val="MONTH(tanggal)=$bln AND YEAR(tanggal)=$thn";
} else {
	$val="MONTH(tanggal)=$bln_sql AND YEAR(tanggal)=$thn_sql";
}

$sql=mysqli_query($con, "SELECT * FROM kas_kecil WHERE $val AND jenis='KELUAR' ORDER BY id_kas_kecil DESC");
if (mysqli_num_rows($sql)>0) echo '<tr style="background: red">
			<td colspan="6"><font color="white">PENGELUARAN</font></td>
		</tr>';
while($row=mysqli_fetch_array($sql)){
$jumlah_keluar+=$row['jumlah'];
	echo '			<tr>
						<td><div>' .date("d-m-Y", strtotime($row['tanggal'])). '</div></td>
						<td><div>' .$row['komponen']. '</div></td>
						<td><div></div></td>
						<td><div align="right" class="uang">' .$row['jumlah']. '</div></td>
						<td><div>' .$row['keterangan']. '</div></td>';
	if ($_SESSION['posisi']=='OWNER'){
		echo '			<td align="center"><a class="btn btn-primary btn-xs" href="?page=keuangan&mode=kas_kecil&del=' .$row['id_kas_kecil']. '"><i class="fa fa-trash"></i> HAPUS</a></td>';
	} else {
		echo '			<td></td>';
	}
	echo '				</tr>';
}
$sql2=mysqli_query($con, "SELECT * FROM kas_kecil WHERE $val AND jenis='MASUK' ORDER BY id_kas_kecil DESC");
if (mysqli_num_rows($sql2)>0) echo '<tr style="background: blue">
			<td colspan="6"><font color="white">PEMASUKAN</font></td>
		</tr>';
while($row=mysqli_fetch_array($sql2)){
$jumlah_masuk+=$row['jumlah'];
	echo '			<tr>
						<td><div>' .date("d-m-Y", strtotime($row['tanggal'])). '</div></td>
						<td><div>' .$row['komponen']. '</div></td>
						<td><div align="right" class="uang">' .$row['jumlah']. '</div></td>
						<td><div></div></td>
						<td><div>' .$row['keterangan']. '</div></td>';
	if ($_SESSION['posisi']=='OWNER'){
		echo '			<td align="center"><a class="btn btn-primary btn-xs" href="?page=keuangan&mode=kas_kecil&del=' .$row['id_kas_kecil']. '"><i class="fa fa-trash"></i> HAPUS</a></td>';
	} else {
		echo '			<td></td>';
	}
	echo '			</tr>';
}
if (mysqli_num_rows($sql)>0 || mysqli_num_rows($sql2)>0) {
	echo '<tr style="background: aqua">
			<td colspan="2"><b>TOTAL</b></td>
			<td align="right" class="uang">' .$jumlah_masuk. '</td>
			<td align="right" class="uang">' .$jumlah_keluar. '</td>
			<td colspan="2"></td>
		  </tr>';
}
?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /page content -->

                </div>
            </div>
        </div>
    </div>
</div>
</div>

<!-- modal input -->
<div id="myModal" class="modal fade">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Tambah Data Kas Kecil</h4>
        </div>
        <div class="modal-body">
            <form action="" method="post">
                <input type="hidden" name="tambah_input_kas_kecil_post" value="true">
                <input type="hidden" name="tanggal" value="<?php echo date("Y-m-d") ?>">
                <div class="col-md-12">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-calendar fa-fw" style="width: 50px;"><br>
                                <small>Tgl</small>
                            </i>
                        </span>
                        <input
                            class="form-control"
                            style="padding: 20px 15px;"
                            placeholder="Tanggal"
                            value="<?php echo date("d-m-Y") ?>"
                            readonly="readonly">
                        <span class="input-group-addon">
                            <i class="fa fa-star fa-fw" style="color:red"></i>
                        </span>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon" style="padding: 2px 12px;">
                            <i class="fa fa-barcode fa-fw" style="width: 50px;"><br>
                                <small>Jenis</small>
                            </i>
                        </span>
                        <select
                            class="form-control select"
                            id="select_jenis"
                            name="jenis"
                            required="required">
                            <option value="" disabled="disabled" selected="selected">Pilih Jenis</option>
                            <option value="MASUK">MASUK</option>
                            <option value="KELUAR">KELUAR</option>
                        </select>
                        <span class="input-group-addon">
                            <i class="fa fa-star fa-fw" style="color:red"></i>
                        </span>
                    </div>
                    <div id="get_komponen">
                        <div class="input-group">
                            <span class="input-group-addon" style="font-size: 11px; padding: 2px 12px;">
                                <i class="fa fa-credit-card fa-fw" style="width: 50px;"></i><br>
                                <small>Komponen</small>
                            </span>
                            <select
                                class="form-control select2"
                                id="select_komponen"
                                name="komponen"
                                required="required">
                                <option value="" disabled="disabled" selected="selected">Pilih Komponen</option>
                            </select>
                            <span class="input-group-addon">
                                <i class="fa fa-star fa-fw" style="color:red"></i>
                            </span>
                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-dollar fa-fw" style="width: 50px;"></i><br>
                            <small>Jml.</small>
                        </span>
                        <input
                            class="form-control"
                            style="padding: 20px 15px;"
                            id="jumlah"
                            min="1"
                            type="text"
                            name="jumlah"
                            placeholder="Jumlah (Rp)"
                            required="required">
                        <span class="input-group-addon">
                            <i class="fa fa-star fa-fw" style="color:red"></i>
                        </span>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-info fa-fw" style="width: 50px;"></i><br>
                            <small>Ket.</small>
                        </span>
                        <input
                            class="form-control"
                            type="text"
                            id="keterangan"
                            style="padding: 20px 15px;"
                            name="keterangan"
                            placeholder="Keterangan"
                            maxlength="50"
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

<script>
function cari() {
    var tanggal = $('#datepicker').val();
    var url = "?page=keuangan&mode=kas_kecil&cari=" + tanggal;
    if (tanggal != '')
        window.location = url;
    }
function reset() {
    var url = "?page=keuangan&mode=kas_kecil&reset";
    window.location = url;
}
$(document).ready(function () {
    $('#jumlah').inputmask('currency', {
        prefix: "Rp ",
        autoGroup: true,
        allowMinus: false,
        groupSeparator: '.',
        rightAlign: false,
        autoUnmask: true,
        removeMaskOnSubmit: true
    });
    $('.uang').inputmask('currency', {
        prefix: "Rp ",
        autoGroup: true,
        allowMinus: false,
        groupSeparator: '.',
        rightAlign: false,
        autoUnmask: true,
        removeMaskOnSubmit: true
    });
    $('#select_jenis').on('change', function () {
        var jenis = $(this).val();
        $('#get_komponen').load(
            'assets/page/keuangan/get-komponen.php?jenis=' + jenis,
            function () {}
        );
    });
    $('#datepicker').datepicker(
        {orientation: "bottom auto", format: "mm-yyyy", startView: 1, minViewMode: 1, autoclose: true}
    );
});
</script>
