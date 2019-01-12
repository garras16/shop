<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h3>LAPORAN PEMAKAIAN MOBIL CANVASS</h3>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="col-xs-12" style="text-align:right">
                            <input
                                type="text"
                                id="datepicker"
                                placeholder="Bulan & Tahun"
                                style="width:100px"
                                value="<?php if (isset($_GET['cari'])) echo $_GET['cari'] ?>"
                                readonly="readonly"></input>
                            <input type="button" id="cari" onclick="cari()" value="Cari"></input>
                            <input type="button" id="reset" onclick="reset()" value="Reset"></input>
                        </div>
                        <table id="table1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Tgl Canvass</th>
                                    <th>Nama Kendaraan</th>
                                    <th>No Pol</th>
                                    <th>Nama Karyawan</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
if (isset($_GET['cari'])){
	$tgl = explode("-", $_GET['cari']);
	$bln = $tgl[0];	$thn = $tgl[1];
	$val="MONTH(tanggal_canvass)=$bln AND YEAR(tanggal_canvass)=$thn";
} else {
	$val="canvass_keluar.status=4 AND MONTH(tanggal_canvass)=MONTH(CURRENT_DATE()) AND YEAR(tanggal_canvass)=YEAR(CURRENT_DATE())";
}

$sql=mysqli_query($con, "SELECT *
FROM
    canvass_keluar
    INNER JOIN kendaraan 
        ON (canvass_keluar.id_mobil = kendaraan.id_kendaraan)
WHERE $val
ORDER BY id_canvass_keluar DESC");
while($row=mysqli_fetch_array($sql)){
	echo '			<tr>
						<td><a data-toggle="modal" data-target="#myModal" data-id-canvass="' .$row['id_canvass_keluar']. '"><div style="min-width:70px">' .date("d-m-Y",strtotime($row['tanggal_canvass'])). '</div></a></td>
						<td><a data-toggle="modal" data-target="#myModal" data-id-canvass="' .$row['id_canvass_keluar']. '"><div style="min-width:70px">' .$row['nama_kendaraan']. '</div></a></td>
						<td><a data-toggle="modal" data-target="#myModal" data-id-canvass="' .$row['id_canvass_keluar']. '"><div style="min-width:70px">' .$row['plat']. '</div></a></td>
						<td><a data-toggle="modal" data-target="#myModal" data-id-canvass="' .$row['id_canvass_keluar']. '"><div style="min-width:70px">';
	$sql2=mysqli_query($con, "SELECT nama_karyawan, nama_jabatan
FROM
    canvass_keluar_karyawan
    INNER JOIN karyawan 
        ON (canvass_keluar_karyawan.id_karyawan = karyawan.id_karyawan)
    INNER JOIN jabatan 
        ON (karyawan.id_jabatan = jabatan.id_jabatan)
WHERE id_canvass_keluar=" .$row['id_canvass_keluar']);
	while ($row2=mysqli_fetch_array($sql2)){
		echo "- " .$row2['nama_karyawan']. " (" .$row2['nama_jabatan']. ")<br>";
	}
	echo '</div></a></td></tr>';
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
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&times;</button>
                <h4 class="modal-title">Lihat Nota Jual</h4>
            </div>
            <div class="modal-body">
                <div id="get_nota" class="col-xs-12"></div>
            </div>
            <div class="clearfix"></div><br/>
            <div class="modal-footer"></div>
        </form>
    </div>
</div>
</div>

<script>
function cari() {
    var tanggal = $('#datepicker').val();
    var url = "?page=laporan&mode=mobil_canvass&cari=" + tanggal;
    if (tanggal != '') 
        window.location = url;
    }
function reset() {
    var url = "?page=laporan&mode=mobil_canvass&reset";
    window.location = url;
}
function getDataTable() {
    $(".table9")
        .DataTable()
        .destroy();
    $(".table9").DataTable({
        "order": [],
        "pageLength": 10,
        "bPaginate": true,
        "bLengthChange": false,
        "scrollX": true,
        "drawCallback": function (settings) {
            $(".dataTables_scrollHeadInner").css({"width": "100%"});
            $(".table ").css({"width": "100%"});
            $(".table9").resize();
        }
    });
}
$(document).ready(function () {
    $('#datepicker').datepicker(
        {orientation: "bottom auto", format: "mm-yyyy", startView: 1, minViewMode: 1, autoclose: true}
    );
    $('#myModal').on('show.bs.modal', function (e) {
        var id_canvass = $(e.relatedTarget).data('id-canvass');
        $('#get_nota').html(
            '<center><i class="fa fa-spinner fa-spin" style="font-size:24px"></i></center>'
        );
        $('#get_nota').load(
            'assets/page/laporan/get-canvass-jual.php?id=' + id_canvass,
            function () {
                getDataTable();
            }
        );
    });
})
</script>