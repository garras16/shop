<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h3>RIWAYAT PEMBELIAN</h3>
                        <?php
							if (isset($pesan)){
								echo '<span class="badge bg-' .$warna. '">' .$pesan. '</span>';
							}
						?>
                        <div class="input-group">
                            <input
                                class="form-control"
                                style="width:100px"
                                id="tgl_dari"
                                type="text"
                                value=""
                                placeholder="Tanggal"
                                readonly="readonly">
                            <input
                                class="form-control"
                                style="width:100px"
                                id="tgl_sampai"
                                type="text"
                                value=""
                                placeholder="Tanggal"
                                readonly="readonly">
                            <a class="btn btn-primary" id="btn_dari_sampai" onclick="submit();">
                                <i class="fa fa-search"></i>
                            </a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                        <table id="table1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Tgl. Nota Beli</th>
                                    <th>No Nota Beli</th>
                                    <th>Supplier</th>
                                    <th>Ekspedisi</th>
                                    <th>Berat Ekspedisi (gr)</th>
                                    <th>Volume Ekspedisi (cm3)</th>
                                    <th>Tarif Ekspedisi (Rp)</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
if (isset($_GET['dari'])){
	$dari=date("Y-m-d", strtotime($_GET['dari']));
	$sampai=date("Y-m-d", strtotime($_GET['sampai']));
	$val="(beli.tanggal BETWEEN '$dari' AND '$sampai')";
} else {
	$val="MONTH(beli.tanggal)=MONTH(CURRENT_DATE()) AND YEAR(beli.tanggal)=YEAR(CURRENT_DATE())";
}
$sql=mysqli_query($con, "SELECT
    beli.id_beli
    , beli.no_nota_beli
    , beli.tanggal
    , SUM(barang_masuk.berat) AS berat
    , SUM(barang_masuk.volume) AS volume
    , supplier.nama_supplier
    , ekspedisi.nama_ekspedisi
    , beli.tarif_ekspedisi
FROM
    beli
    INNER JOIN supplier 
        ON (beli.id_supplier = supplier.id_supplier)
    LEFT JOIN ekspedisi 
        ON (beli.id_ekspedisi = ekspedisi.id_ekspedisi)
    INNER JOIN beli_detail 
        ON (beli_detail.id_beli = beli.id_beli)
    LEFT JOIN barang_masuk 
        ON (barang_masuk.id_beli_detail = beli_detail.id_beli_detail) 
WHERE $val 
GROUP BY beli.id_beli");
while($row=mysqli_fetch_array($sql)){
	echo '			<tr>
						<td><a href="?page=pembelian&mode=view_detail&id=' .$row['id_beli']. '">' .date("d-m-Y", strtotime($row['tanggal'])). '</a></td>
						<td><a href="?page=pembelian&mode=view_detail&id=' .$row['id_beli']. '">' .$row['no_nota_beli']. '</a></td>
						<td><a href="?page=pembelian&mode=view_detail&id=' .$row['id_beli']. '">' .$row['nama_supplier']. '</a></td>
						<td><a href="?page=pembelian&mode=view_detail&id=' .$row['id_beli']. '">' .$row['nama_ekspedisi']. '</a></td>
						<td><a href="?page=pembelian&mode=view_detail&id=' .$row['id_beli']. '">' .format_angka($row['berat']). '</a></td>
						<td><a href="?page=pembelian&mode=view_detail&id=' .$row['id_beli']. '">' .format_angka($row['volume']). '</a></td>
						<td><a href="?page=pembelian&mode=view_detail&id=' .$row['id_beli']. '">' .format_uang($row['tarif_ekspedisi']). '</a></td>
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

<script>
    function validasi() {
        var startDate = new Date.parse(get_global_tanggal($('#tgl_dari').val()));
        var endDate = new Date.parse(get_global_tanggal($('#tgl_sampai').val()));
        if (startDate > endDate) {
            $('#tgl_dari').val('');
            $('#tgl_sampai').val('');
            $('#btn_dari_sampai').attr('style', 'display:none');
            alert("Terjadi kesalahan penulisan tanggal");
            AndroidFunction.showToast("Terjadi kesalahan penulisan tanggal");
        } else {
            $('#btn_dari_sampai').removeAttr('style');
        }
    }
    function submit() {
        window.location = "?page=riwayat_beli&dari=" + $('#tgl_dari').val() +
                "&sampai=" + $('#tgl_sampai').val();
    }
    $(document).ready(function () {
        var now = new Date();
        $('#tgl_dari').daterangepicker({
            locale: {
                format: 'DD-MM-YYYY'
            },
            singleDatePicker: true
        });
        $('#tgl_sampai').daterangepicker({
            locale: {
                format: 'DD-MM-YYYY'
            },
            singleDatePicker: true
        });
        $("#tgl_dari").on('change', function () {
            validasi();
        });
        $("#tgl_sampai").on('change', function () {
            validasi();
        });
    });
</script>