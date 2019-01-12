<div class="right_col" role="main">
    <div class="">

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h3>LIHAT STOK CANVASS</h3>
                        <?php
							if (isset($pesan)){
								echo '<span class="badge bg-' .$warna. '">' .$pesan. '</span>';
							}
						?>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="alert alert-info">
                            <strong>Klik kolom pada tabel untuk detail.</strong>
                        </div>
                        <div class="table responsive">
                            <table id="table1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Nama Barang</th>
                                        <th>Stok</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
$sql=mysqli_query($con, "SELECT barang.id_barang,nama_barang,nama_satuan,SUM(stok) AS total
FROM
    canvass_keluar
    INNER JOIN canvass_keluar_barang 
        ON (canvass_keluar.id_canvass_keluar = canvass_keluar_barang.id_canvass_keluar)
    INNER JOIN barang 
        ON (canvass_keluar_barang.id_barang = barang.id_barang)
    INNER JOIN satuan 
        ON (barang.id_satuan = satuan.id_satuan)
WHERE canvass_keluar.id_canvass_keluar=$id
GROUP BY canvass_keluar_barang.id_barang");
while($row=mysqli_fetch_array($sql)){
$sql2=mysqli_query($con, "SELECT SUM(qty_cek) AS qty_cek FROM lap_stock_opname WHERE id_canvass_keluar=$id AND id_barang=" .$row['id_barang']);
$row2=mysqli_fetch_array($sql2);
($row2['qty_cek']!='' ? $stok=$row2['qty_cek'] : $stok=$row['total']);
	echo '			<tr>
						<td><a data-toggle="modal" data-target="#myModal" data-nama="' .$row['nama_barang']. '" data-id="' .$row['id_barang']. '"><div style="min-width:70px">' .$row['nama_barang']. '</div></a></td>
						<td><a data-toggle="modal" data-target="#myModal" data-nama="' .$row['nama_barang']. '" data-id="' .$row['id_barang']. '"><div style="min-width:70px">' .format_angka($stok). ' ' .$row['nama_satuan']. '</div></a></td>
					</tr>';
}
?>

                                </tbody>
                            </table>

                        </div>
                    </div>
                    <div id="dummy"></div>
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
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <div style="min-width:50px">&times;</div>
                </button>
                <h4 id="judul" class="modal-title">Detail Stok Barang</h4>
            </div>
            <div class="modal-body">
                <div style="overflow-x: auto">
                    <div id="get_content" class="col-md-12"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#myModal').on('show.bs.modal', function (e) {
            var id = $(e.relatedTarget).data('id');
            var nama = $(e.relatedTarget).data('nama');
            $('#judul').html('Detail Stok Barang - ' + nama);
            $('#get_content').load(
                'assets/page/canvass/stok_detail.php?canvass=<?php echo $id ?>&id=' + id,
                function () {}
            );
        });
    });
</script>