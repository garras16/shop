<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h3>RIWAYAT NO POL KENDARAAN</h3>
                        <?php
							if (isset($pesan)){
								echo '<span class="badge bg-' .$warna. '">' .$pesan. '</span>';
							}
							?>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <a class="btn btn-danger" href="?page=master&mode=kendaraan">
                            <i class="fa fa-arrow-left"></i>
                            Kembali</a>
                        <div class="clearfix" style="margin-top: 30px;"></div>
                        <table id="table1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Nama Kendaraan</th>
                                    <th>No Pol</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
$sql=mysqli_query($con, "SELECT
    kendaraan.nama_kendaraan
    , plat_detail.tanggal
	, plat_detail.plat
FROM
    plat_detail
    INNER JOIN kendaraan 
        ON (plat_detail.id_kendaraan = kendaraan.id_kendaraan)");

while($row=mysqli_fetch_array($sql)){
	echo '			<tr>
						<td>' .$row['tanggal']. '</a></td>
						<td>' .$row['nama_kendaraan']. '</a></td>
						<td>' .$row['plat']. '</a></td>
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