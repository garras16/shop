<?php
if (isset($_GET['cari'])){
	$tgl = explode("-", $_GET['cari']);
	$bln = $tgl[0]; $bln_sql=$bln;
	$thn = $tgl[1]; $thn_sql=$thn;
	$bulan_ini=$thn .'-'. $bln . "-01";
	$val="WHERE MONTH(tgl_retur)=$bln_sql AND YEAR(tgl_retur)=$thn_sql";
} else {
	$bln = date("m"); $bln_sql="MONTH(CURRENT_DATE())";
	$thn = date("Y"); $thn_sql="YEAR(CURRENT_DATE())";
	$bulan_ini=date("Y-m") . "-01";
	$val="WHERE retur_beli.status=0 OR tgl_retur BETWEEN NOW() - INTERVAL 30 DAY AND NOW()";
}
if (isset($tambah_retur_beli_post)){
	$sql=mysqli_query($con, "SELECT COUNT(id_beli) AS cID FROM retur_beli WHERE tgl_retur='" .date('Y-m-d'). "'");
	$r=mysqli_fetch_array($sql);
	$no_retur="RB-" .date("ymd"). '-' .sprintf("%03d",$r['cID']+1);
	$sql = "INSERT INTO retur_beli VALUES(null,'$tanggal','$no_retur',$id_beli,0)";
	$q = mysqli_query($con, $sql);
	$last_id = mysqli_insert_id($con);
	if ($sql){
		_buat_pesan("Input Berhasil","green");
	} else {
		_buat_pesan("Input Gagal","red");
	}
	_direct("?page=pembelian&mode=retur_beli_detail&id=" .$last_id);
} else {
	$sql = mysqli_query($con, "DELETE FROM retur_beli WHERE id_retur_beli NOT IN (SELECT id_retur_beli FROM retur_beli_detail)");
}
?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h3>RETUR PEMBELIAN</h3>
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
                        <div class="col-xs-6">
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
                        <div class="col-xs-6" style="text-align:right">
                            <p align="right">
                                <button class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                    <i class="fa fa-plus"></i>
                                    Tambah</button>
                            </p>
                        </div>
                        <div class="clearfix" style="margin-bottom: 20px;"></div>
                        <table id="table1" class="table table-bordered table-striped" style="min-width:800px;">
                            <thead>
                                <tr>
                                    <th>Tgl. Retur</th>
                                    <th>No Retur</th>
                                    <th>No Nota Beli</th>
                                    <th>Nama Supplier</th>
                                    <th>Jumlah Beli</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
$sql=mysqli_query($con, "SELECT
    retur_beli.tgl_retur
    , retur_beli.id_retur_beli
    , retur_beli.no_retur_beli
    , retur_beli.status
	, beli.id_beli
    , beli.no_nota_beli
    , beli.diskon_all_persen
    , beli.ppn_all_persen
    , supplier.nama_supplier
FROM
    retur_beli
    INNER JOIN beli
        ON (retur_beli.id_beli = beli.id_beli)
    INNER JOIN supplier
        ON (beli.id_supplier = supplier.id_supplier)
$val
ORDER BY retur_beli.id_retur_beli DESC");

while($row=mysqli_fetch_array($sql)){
$sql2=mysqli_query($con, "SELECT SUM(qty * (harga-diskon_rp-diskon_rp_2-diskon_rp_3)) AS jumlah FROM beli_detail WHERE id_beli=" .$row['id_beli']);
$r=mysqli_fetch_array($sql2);
$jumlah_beli=$r['jumlah']+($r['jumlah']*$row['ppn_all_persen']/100);//-($r['jumlah']*$row['diskon_all_persen']/100);
if ($row['status']=='1'){
	$status="SELESAI";
	$style="badge bg-green";
} else {
	$status="";
	$style="";
}
	echo '			<tr>
						<td><a href="?page=pembelian&mode=retur_beli_detail&id=' .$row['id_retur_beli']. '"><div style="min-width:70px">' .date("d-m-Y", strtotime($row['tgl_retur'])). '</div></a></td>
						<td><a href="?page=pembelian&mode=retur_beli_detail&id=' .$row['id_retur_beli']. '"><div style="min-width:70px">' .$row['no_retur_beli']. '</div></a></td>
						<td><a href="?page=pembelian&mode=retur_beli_detail&id=' .$row['id_retur_beli']. '"><div style="min-width:70px">' .$row['no_nota_beli']. '</div></a></td>
						<td><a href="?page=pembelian&mode=retur_beli_detail&id=' .$row['id_retur_beli']. '"><div style="min-width:70px">' .$row['nama_supplier']. '</div></a></td>
						<td><a href="?page=pembelian&mode=retur_beli_detail&id=' .$row['id_retur_beli']. '"><div style="min-width:70px" class="uang">' .$jumlah_beli. '</div></a></td>
						<td><a href="?page=pembelian&mode=retur_beli_detail&id=' .$row['id_retur_beli']. '" class="' .$style. '"><div style="min-width:70px;">' .$status. '</div></a></td>
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
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <div style="min-width:50px">&times;</div>
                </button>
                <h4 class="modal-title">Tambah Retur Beli</h4>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <input type="hidden" name="tambah_retur_beli_post" value="true">
                    <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon" style="padding: 2px 12px;">
                                <i class="fa fa-file fa-fw"></i><br>
                                <small>Nota Beli</small>
                            </span>
                            <select name="id_beli" class="select2 form-control" required="true">
                                <option value="" disabled="disabled" selected="selected">-= Pilih Nota Beli =-</option>
                                <?php
								$sql=mysqli_query($con, "SELECT
    beli.id_beli
    , beli.no_nota_beli
    , beli.ppn_all_persen
    , beli.diskon_all_persen
    , supplier.nama_supplier
FROM
    beli
    INNER JOIN supplier
        ON (beli.id_supplier = supplier.id_supplier)
WHERE beli.id_beli NOT IN (SELECT id_beli FROM retur_beli)
ORDER BY beli.id_beli ASC");
								while($b=mysqli_fetch_array($sql)){
									$tmp_id_beli=$b['id_beli'];
									$sql2=mysqli_query($con, "SELECT SUM(qty * (harga-diskon_rp-diskon_rp_2-diskon_rp_3)) AS jumlah FROM beli_detail WHERE id_beli=$tmp_id_beli");
									$b2=mysqli_fetch_array($sql2);
									$jumlah=$b2['jumlah']+($b2['jumlah']*$b['ppn_all_persen']/100)-($b2['jumlah']*$b['diskon_all_persen']/100);
									echo '<option value="' .$b['id_beli']. '">' .$b['no_nota_beli']. ' | ' .$b['nama_supplier']. ' | Rp ' .format_uang($jumlah). '</option>';
								}
							?>
                            </select>
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
        var url = "?page=pembelian&mode=retur_beli&cari=" + tanggal;
        if (tanggal != '')
            window.location = url;
        }
    function reset() {
        var url = "?page=pembelian&mode=retur_beli";
        window.location = url;
    }
    $(document).ready(function () {
        $('.uang').inputmask('currency', {
            prefix: "Rp ",
            autoGroup: true,
            allowMinus: false,
            groupSeparator: '.',
            rightAlign: false,
            autoUnmask: true,
            removeMaskOnSubmit: true
        });
        $('#datepicker').datepicker(
            {orientation: "bottom auto", format: "mm-yyyy", startView: 1, minViewMode: 1, autoclose: true}
        );
    });
</script>
