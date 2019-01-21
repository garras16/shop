<?php
if (isset($_GET['act'])){
	$act=0;
	if ($_GET['act']=='1') $act=1;
	if ($_GET['act']=='2') $act=2;
	$no = $_GET['no'];
	if (isset($_GET['tbl']) && $_GET['tbl']=='1' && $act =='1'){
		$jml = $_GET['jml'];
		$bom = mysqli_query($con, "SELECT sisa FROM bayar_nota_beli WHERE no_nota_beli='$no' ORDER BY id_bayar DESC LIMIT 1");
		$data = mysqli_fetch_array($bom);
		$update = $data['sisa']-$jml;
		if($update == 0) {
			$stat = 1;
			$now = 1;
			$sql=mysqli_query($con, "UPDATE bayar_nota_beli SET now=$now WHERE no_nota_beli='$no'");
		}else{
			$stat = 2;
		}
		$sql=mysqli_query($con, "UPDATE bayar_nota_beli SET status_giro=$act, sisa=$update, status=$stat WHERE id_bayar=$id");
		if ($sql){
			$pesan="INPUT BERHASIL";
		} else {
			$pesan="INPUT GAGAL";
		}

	}else if(isset($_GET['tbl']) && $_GET['tbl']=='1' && $act =='2'){
		$validasi = mysqli_query($con, "SELECT status FROM bayar_nota_beli WHERE no_nota_beli='$no'");
		$result = mysqli_num_rows($validasi);
		if($result == 0) {
			$status = 4;
		}else{
			$bb = mysqli_query($con, "SELECT sisa FROM bayar_nota_beli WHERE no_nota_beli='$no' ORDER BY id_bayar DESC LIMIT 1");
			$cc = mysqli_fetch_array($bb);
			if($cc['sisa']==NULL) {
				$status =4;
			}else{
				$sql=mysqli_query($con, "SELECT id_beli FROM beli WHERE no_nota_beli='$no'");
				$row=mysqli_fetch_array($sql);
				$id_beli=$row['id_beli'];
				$sql2=mysqli_query($con, "SELECT *, SUM(qty*(harga-diskon_rp-diskon_rp_2-diskon_rp_3)) AS total
					FROM
			    		beli
			    	INNER JOIN beli_detail
			        	ON (beli.id_beli = beli_detail.id_beli)
					WHERE beli.no_nota_beli = '$no'
					GROUP BY beli_detail.id_beli");
				$row = mysqli_fetch_array($sql2);
				$id_beli = $row['id_beli'];
				$total_nota = $row['total']-($row['total']*$row['diskon_all_persen']/100);
				$grand = $total_nota+($total_nota*($row['ppn_all_persen']/100));
				$jumlah_nota = $grand;

				if($jumlah_nota-$cc['sisa'] != 0) {
					$status = 2;
				}else{
					$status = 4;
				}
			}
		}
		$sql=mysqli_query($con, "UPDATE bayar_nota_beli SET status=$status, status_giro=$act WHERE id_bayar='$id'");
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
	_direct("?page=pembelian&mode=pencairan_giro");
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

                                        <table id="table1" class="table table-bordered table-striped table-responsive" style="min-width: 950px;">
                                            <thead>
                                                <tr>
                                                    <th>Tanggal Nota Jual</th>
                                                    <th>No Nota Jual</th>
                                                    <th>Nama Supplier</th>
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
    bayar_nota_beli
    INNER JOIN beli
        ON (bayar_nota_beli.no_nota_beli = beli.no_nota_beli)
    INNER JOIN supplier
        ON (beli.id_supplier = supplier.id_supplier)
WHERE jenis='Giro' AND tgl_bayar BETWEEN NOW() - INTERVAL 30 DAY AND NOW()");
while($row=mysqli_fetch_array($sql)){
    //STATUS GIRO:
    if ($row['status_giro']==0) $status_giro='BELUM DICAIRKAN';
    if ($row['status_giro']==1) $status_giro='DITERIMA';
    if ($row['status_giro']==2) $status_giro='DITOLAK';
        echo '<tr>
                <td>' .date("d-m-Y",strtotime($row['tgl_bayar'])). '</td>
                <td>' .$row['no_nota_beli']. '</td>
                <td>' .$row['nama_supplier']. '</td>
                <td>' .date("d-m-Y",strtotime($row['jatuh_tempo'])). '</td>
								<td class="uang">'.$row['jumlah'].'</td>
                <td>' .$status_giro. '</td>';
    if ($row['status_giro']==0){
        echo '<td><a href="?page=pembelian&mode=pencairan_giro&id=' .$row['id_bayar']. '&act=1&tbl=1&no='.$row['no_nota_beli'].'&jml='.$row['jumlah'].'" class="btn btn-primary btn-xs"><i class="fa fa-times"></i> Terima</a>
                <a href="?page=pembelian&mode=pencairan_giro&id=' .$row['id_bayar']. '&act=2&tbl=1&no='.$row['no_nota_beli'].'" class="btn btn-danger btn-xs"><i class="fa fa-times"></i> Tolak</a></td>';
    } else {
        echo '<td></td>';
    }
    echo '</tr>';
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
