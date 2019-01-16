<?php
if (isset($_GET['act'])){
	$act=0;
	if ($_GET['act']=='1') $act=1;
	if ($_GET['act']=='2') $act=2;

	if (isset($_GET['tbl']) && $_GET['tbl']=='1'){
		$sql=mysqli_query($con, "UPDATE bayar_nota_jual SET status_giro=$act WHERE id_bayar=$id");
		if ($sql){
			$pesan="INPUT BERHASIL";
		} else {
			$pesan="INPUT GAGAL";
		}
	} else {
		$sql=mysqli_query($con, "UPDATE penagihan_detail SET status_giro=$act WHERE id_penagihan_detail=$id");
		if ($sql){
			$pesan="INPUT BERHASIL";
		} else {
			$pesan="INPUT GAGAL";
		}
	}
	_alert($pesan);
	_direct("?page=penjualan&mode=pencairan_giro");
}
?>

<div class="right_col" role="main">
    <div class="">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h3>PENCAIRAN GIRO</h3>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="x_panel">
                                    <div class="x_content">

                                        <table id="table1" class="table table-bordered table-striped table-responsive">
                                            <thead>
                                                <tr>
                                                    <th>Tanggal Nota Jual</th>
                                                    <th>No Nota Jual</th>
                                                    <th>Nama Pelanggan</th>
                                                    <th>Tgl Jatuh Tempo</th>
																										<th>Nominal</th>
                                                    <th>Status Giro</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
$sql=mysqli_query($con, "SELECT *
FROM
    bayar_nota_jual
    INNER JOIN jual
        ON (bayar_nota_jual.no_nota_jual = jual.invoice)
    INNER JOIN pelanggan
        ON (jual.id_pelanggan = pelanggan.id_pelanggan)
WHERE jenis='Giro' AND tgl_bayar BETWEEN NOW() - INTERVAL 30 DAY AND NOW()");
while($row=mysqli_fetch_array($sql)){
    //STATUS GIRO:
    if ($row['status_giro']==0) $status_giro='GANTUNG';
    if ($row['status_giro']==1) $status_giro='TERIMA';
    if ($row['status_giro']==2) $status_giro='TOLAK';
        echo '<tr>
                <td>' .date("d-m-Y",strtotime($row['tgl_nota'])). '</td>
                <td>' .$row['no_nota_jual']. '</td>
                <td>' .$row['nama_pelanggan']. '</td>
                <td>' .date("d-m-Y",strtotime($row['jatuh_tempo'])). '</td>
								<td class="uang">'.$row['jumlah'].'</td>
                <td>' .$status_giro. '</td>';
    if ($row['status_giro']==0){
        echo '<td><a href="?page=penjualan&mode=pencairan_giro&id=' .$row['id_bayar']. '&act=1&tbl=1" class="btn btn-primary btn-xs"><i class="fa fa-times"></i> Terima</a>
                <a href="?page=penjualan&mode=pencairan_giro&id=' .$row['id_bayar']. '&act=2&tbl=1" class="btn btn-danger btn-xs"><i class="fa fa-times"></i> Tolak</a></td>';
    } else {
        echo '<td></td>';
    }
    echo '</tr>';
}

$sql=mysqli_query($con, "SELECT *
FROM
    penagihan_detail
    INNER JOIN jual
        ON (penagihan_detail.id_jual = jual.id_jual)
    INNER JOIN pelanggan
        ON (jual.id_pelanggan = pelanggan.id_pelanggan)
WHERE jenis='Giro' AND tgl_bayar BETWEEN NOW() - INTERVAL 30 DAY AND NOW()");
while($row=mysqli_fetch_array($sql)){
//STATUS GIRO:
if ($row['status_giro']==0) $status_giro='GANTUNG';
if ($row['status_giro']==1) $status_giro='TERIMA';
if ($row['status_giro']==2) $status_giro='TOLAK';
	echo '			<tr>
						<td>' .date("d-m-Y",strtotime($row['tgl_nota'])). '</td>
						<td>' .$row['invoice']. '</td>
						<td>' .$row['nama_pelanggan']. '</td>
						<td>' .date("d-m-Y",strtotime($row['jatuh_tempo'])). '</td>
						<td>' .$status_giro. '</td>';
if ($row['status_giro']==0){
	echo '				<td><a href="?page=penjualan&mode=pencairan_giro&id=' .$row['id_penagihan_detail']. '&act=1&tbl=2" class="btn btn-primary btn-xs"><i class="fa fa-times"></i> Terima</a>
						<a href="?page=penjualan&mode=pencairan_giro&id=' .$row['id_penagihan_detail']. '&act=2&tbl=2" class="btn btn-danger btn-xs"><i class="fa fa-times"></i> Tolak</a></td>';
} else {
	echo '				<td></td>';
}
echo '				</tr>';
}
?>

                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
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
      $('#total_jual').inputmask('decimal', {
          allowMinus: false,
          autoGroup: true,
          groupSeparator: '.',
          rightAlign: false,
          removeMaskOnSubmit: true
      });
      $('#diskon_nota').inputmask('decimal', {
          allowMinus: false,
          autoGroup: true,
          groupSeparator: '.',
          rightAlign: false,
          removeMaskOnSubmit: true
      });
      $('#diskon_nota_rp').inputmask('decimal', {
          allowMinus: false,
          autoGroup: true,
          groupSeparator: '.',
          rightAlign: false,
          removeMaskOnSubmit: true
      });
      $('#myModal').on('show.bs.modal', function (e) {});
    });
</script>
