<?php
$id_karyawan=$_SESSION['id_karyawan'];
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
	$baris=mysqli_num_rows($sql2);
	if (isset($_GET['direct'])){
		$url="?page=canvass_keluar&mode=stock_opname";
	} else {
		$url="?page=canvass_keluar&mode=lap_stock_opname";
	}
?>
<div class="right_col loading" role="main">
    <div class="">

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <div class="col-md-6">
                            <h3>RINGKASAN STOCK OPNAME (CANVASS)</h3>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <?php
	echo '					<tr><td width="40%">Tanggal Canvass</td><td>' .date("d-m-Y", strtotime($tgl_canvass)). '</td></tr>
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
                                        <th>Qty Sisa<br>(Seharusnya)</th>
                                        <th>Qty Sisa<br>(Stock Opname)</th>
                                        <th>Qty Selisih</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
	$sql=mysqli_query($con, "SELECT *,SUM(qty_sisa) AS qty_sisa, SUM(qty_cek) AS qty_cek
FROM
    lap_stock_opname
    INNER JOIN barang 
        ON (lap_stock_opname.id_barang = barang.id_barang)
    INNER JOIN satuan 
        ON (barang.id_satuan = satuan.id_satuan)
 WHERE id_canvass_keluar=$id
 GROUP BY barang.id_barang");
	while ($row=mysqli_fetch_array($sql)){
	$sql2=mysqli_query($con, "SELECT SUM(stok) AS stok FROM canvass_keluar_barang WHERE id_canvass_keluar=$id AND id_barang=" .$row['id_barang']);
	$row2=mysqli_fetch_array($sql2);
	($row2['stok']==$row['qty_cek'] ? $style="" : $style="color:red;");
	(($row2['stok']-$row['qty_cek'])==0 ? $send=false : $send=true);
	echo '<tr>
				<td style="vertical-align:middle;text-align:center;' .$style. '"><a data-toggle="modal" data-target="#myModal" data-id-barang="' .$row['id_barang']. '" data-nama="' .$row['nama_barang']. '">' .$row['nama_barang']. '<i style="padding-left:10px" class="fa fa-external-link"></i></a></td>
				<td style="vertical-align:middle;text-align:center;' .$style. '">' .format_angka($row2['stok']). ' ' .$row['nama_satuan']. '</td>
				<td style="vertical-align:middle;text-align:center;' .$style. '">' .format_angka($row['qty_cek']). ' ' .$row['nama_satuan']. '</td>
				<td style="vertical-align:middle;text-align:center;' .$style. '">' .format_angka($row2['stok']-$row['qty_cek']). ' ' .$row['nama_satuan']. '</td>
			</tr>';
	}	
	if (isset($_GET['direct'])) {
		$sql=mysqli_query($con, "SELECT * FROM lap_stock_opname WHERE id_canvass_keluar=$id AND selisih <> 0");
		if (mysqli_num_rows($sql)>0){
			$sql2=mysqli_query($con, "INSERT INTO konfirm_owner VALUES(null,'$tanggal','Ada perbedaan antara hasil perhitungan qty stock opname dan qty seharusnya.','canvass_stock_opname',0,'?page=konfirmasi&mode=konfirm_so_canvass&id=$id'')");
		}
	}
?>
                                </tbody>
                            </table>
                        </div>
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
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&times;</button>
                <h4 class="modal-title" id="nama_barang"></h4>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <div id="get_expire" class="col-xs-12"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function getBack() {
        window.location = '<?php echo $url ?>';
    }
    $(document).ready(function () {
        $('#myModal').on('show.bs.modal', function (e) {
            var nama = $(e.relatedTarget).data('nama');
            var id_barang = $(e.relatedTarget).data('id-barang');
            $('#nama_barang').html(nama);
            $('#get_expire').html(
                '<center><i class="fa fa-spinner fa-spin" style="font-size:24px"></i></center>'
            );
            $('#get_expire').load(
                'assets/page/canvass_keluar/get-expire-so.php?barang=' + id_barang + '&canvass=' +
                        '<?php echo $id ?>',
                function () {}
            );
        });
    })
</script>