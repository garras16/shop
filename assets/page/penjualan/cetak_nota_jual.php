<?php
	require 'vendors/php-barcode/src/BarcodeGenerator.php';
	require 'vendors/php-barcode/src/BarcodeGeneratorJPG.php';
	
$id_karyawan=$_SESSION['id_karyawan'];
	$sql=mysqli_query($con, "SELECT status_konfirm FROM jual WHERE id_jual=$id");
	$row=mysqli_fetch_array($sql);
	(($row['status_konfirm']>=0) && ($row['status_konfirm']<=4) ? $dalam_kota=true : $dalam_kota=false); 
	if ($dalam_kota){
		$sql=mysqli_query($con, "SELECT * FROM nota_sudah_cek WHERE id_jual=$id");
		$row=mysqli_fetch_array($sql);
		if ($row['status']=='1') {
			$sql2=mysqli_query($con, "UPDATE nota_sudah_cek SET status='2', tanggal_cetak='" .date("Y-m-d"). "' WHERE id_jual=$id");
		} else {
			$sql2=mysqli_query($con, "UPDATE nota_sudah_cek SET tanggal_cetak='" .date("Y-m-d"). "' WHERE id_jual=$id");
		}
	}
	$sql=mysqli_query($con, "UPDATE jual SET cetak=1,tgl_cetak='" .date("Y-m-d"). "' WHERE id_jual=$id");
	$sql=mysqli_query($con, "SELECT *
FROM
    jual
    INNER JOIN pelanggan 
        ON (jual.id_pelanggan = pelanggan.id_pelanggan)
	WHERE id_jual=$id");
	$row=mysqli_fetch_array($sql);
	$no_nota=$row['invoice'];
	$tgl_nota=$row['tgl_nota'];
	$nama_pelanggan=$row['nama_pelanggan'];
	$alamat=$row['alamat'];
	if ($dalam_kota){
		$sql5=mysqli_query($con, "SELECT nama_karyawan FROM nota_sudah_cek INNER JOIN karyawan ON (nota_sudah_cek.id_karyawan=karyawan.id_karyawan) WHERE id_jual=$id");
		$row5=mysqli_fetch_array($sql5);
		$nama_pemeriksa=$row5['nama_karyawan'];
	} else {
		$sql5=mysqli_query($con, "SELECT nama_karyawan FROM canvass_siap_kirim INNER JOIN karyawan ON (canvass_siap_kirim.id_karyawan = karyawan.id_karyawan) WHERE id_jual=$id");
		$row5=mysqli_fetch_array($sql5);
		$nama_pemeriksa=$row5['nama_karyawan'];
	}
?>
<style type="text/css" media="print">
    @page 
    {
        size:  portrait;   /* auto is the initial value */
        margin: 10mm 0mm 15mm 0mm;  /* this affects the margin in the printer settings */
    }
    
    body
    {
        /*border: solid 1px blue ;*/
        margin: 0mm 0mm 0mm 0mm; /* margin you want for the content */
    }
	.spinner-icon {
		display:none;
	}
	.x_panel {
		border:0;
		border-bottom: dotted 1px black;
	}
	.table > thead > tr > th,
	.table > tbody > tr > th,
	.table > tfoot > tr > th,
	.table > thead > tr > td,
	.table > tbody > tr > td,
	.table > tfoot > tr > td {
	  padding-top: 2px;
	  padding-bottom: 2px;
	}
	@media print{
		table { page-break-after:auto;}
		tr    { page-break-inside:avoid;}
		td    { page-break-inside:auto;}
		thead { display:table-header-group }

		.row-fluid [class*="span"] {
			min-height: 20px;
		}
	}
</style>
<div id="main_content" class="right_col loading" role="main">
	<div class="">
	
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_content">
						<font size="5">NOTA JUAL</font>&nbsp;&nbsp;&nbsp;
						<font size="4"><?php echo $no_nota ?></font>
						<?php
							$generator = new Picqer\Barcode\BarcodeGeneratorJPG();
							echo '<img align="right" width="300" height="40" src="data:image/jpg;base64,' . base64_encode($generator->getBarcode($no_nota, $generator::TYPE_CODE_128)) . '">';
						?>
						<div class="clearfix"></div>
						<table width="100%" style="margin-top:10px">
						<tbody>
<?php
$tgl=date("d", strtotime($tgl_nota));
$bln=format_bulan(date("m", strtotime($tgl_nota)));
$thn=date("Y", strtotime($tgl_nota));
	echo '					<tr><td width="40%">B. Lampung, ' .$tgl. ' ' .$bln. ' ' .$thn. '</td><td align="right"><font size="4">' .$nama_pelanggan. '</font></td></tr>
							<tr><td width="40%"></td><td align="right">' .$alamat. '</td></tr>';
?>
						</tbody>
						</table>
						<div class="clearfix"></div>
						
						<div class="row-fluid" id="print-body-wrapper">
						<table class="table table-bordered" id="table_data" style="margin-top:10px">
							<thead>
								<tr>
									<th>Banyaknya</th>
									<th>Nama Barang</th>
									<th>Harga (Rp)</th>
									<th>Diskon (%)</th>
									<th>Diskon (Rp)</th>
									<th>Jumlah (Rp)</th>
								</tr>
							</thead>
							<tbody>
<?php
	$sql=mysqli_query($con, "SELECT *
FROM
    jual
    INNER JOIN jual_detail 
        ON (jual.id_jual = jual_detail.id_jual)
    INNER JOIN harga_jual 
        ON (jual_detail.id_harga_jual = harga_jual.id_harga_jual)
    INNER JOIN barang_supplier 
        ON (harga_jual.id_barang_supplier = barang_supplier.id_barang_supplier)
    INNER JOIN barang 
        ON (barang_supplier.id_barang = barang.id_barang)
	INNER JOIN satuan 
        ON (barang.id_satuan = satuan.id_satuan)
WHERE jual.id_jual=$id");
$total=0;$diskon=0;
	while ($row=mysqli_fetch_array($sql)){
		if ($row['status_konfirm']>=0 && $row['status_konfirm']<=4){
		$sql2=mysqli_query($con, "SELECT cek, SUM(qty_ambil) as qty_ambil
FROM
    nota_siap_kirim
    INNER JOIN nota_siap_kirim_detail 
        ON (nota_siap_kirim.id_nota_siap_kirim = nota_siap_kirim_detail.id_nota_siap_kirim)
WHERE id_jual_detail=" .$row['id_jual_detail']. "");
		} else {
		$sql2=mysqli_query($con, "SELECT cek, SUM(qty_ambil) as qty_ambil
FROM
    canvass_siap_kirim
    INNER JOIN canvass_siap_kirim_detail 
        ON (canvass_siap_kirim.id_canvass_siap_kirim = canvass_siap_kirim_detail.id_canvass_siap_kirim)
WHERE id_jual_detail=" .$row['id_jual_detail']. "");
		}
		$row2=mysqli_fetch_array($sql2);
		if ($row2['qty_ambil'] <> ''){
			$diskon1=$row['harga_jual']*$row['diskon_persen']/100;
			$tot_set_disk_1=$row['qty']*($row['harga_jual']-$diskon1);
			$diskon2=($row['harga_jual']-$diskon1)*$row['diskon_persen_2']/100;
			$tot_set_disk_2=$row['qty']*($row['harga_jual']-$diskon1-$diskon2);
			$diskon3=($row['harga_jual']-$diskon1-$diskon2)*$row['diskon_persen_3']/100;
			$tot_set_disk_3=$row['qty']*($row['harga_jual']-$diskon1-$diskon2-$diskon3);
			$total+=$tot_set_disk_3;
			$diskon_persen=format_uang($row['diskon_persen']);
			if ($row['diskon_persen_2']!='0') $diskon_persen.='+' .format_uang($row['diskon_persen_2']);
			if ($row['diskon_persen_3']!='0') $diskon_persen.='+' .format_uang($row['diskon_persen_3']);
			$diskon_rp=format_uang($diskon1);
			if ($diskon2!='0') $diskon_rp.='+' .format_uang($diskon2);
			if ($diskon3!='0') $diskon_rp.='+' .format_uang($diskon3);
			
			echo '<tr>
					<td align="center">' .$row2['qty_ambil']. ' ' .$row['nama_satuan']. '</td>
					<td style="vertical-align:middle;text-align:center">' .$row['nama_barang']. '</td>
					<td style="vertical-align:middle;text-align:right">' .format_uang($row['harga']). '</td>
					<td style="vertical-align:middle;text-align:right">' .$diskon_persen. '</td>
					<td style="vertical-align:middle;text-align:right">' .$diskon_rp. '</td>';
			echo '	<td align="right">' .format_uang($tot_set_disk_3). '</td>';
			echo '</tr>';
			$diskon=$row['diskon_all_persen']/100*$total;
		}
	}
	echo '<tr>
			<td colspan="5" align="right"><b>TOTAL (Rp)</b></td>
			<td align="right"><b>' .format_uang($total). '</b></td>
		 </tr>';
	echo '<tr>
			<td colspan="5" align="right"><b>Diskon Nota Jual (Rp)</b></td>
			<td align="right"><b>' .format_uang($diskon). '</b></td>
		 </tr>';
	$sql=mysqli_query($con, "SELECT nama_karyawan
FROM
    pengiriman
    INNER JOIN karyawan 
        ON (pengiriman.id_karyawan = karyawan.id_karyawan)
	WHERE id_jual=$id");
	$row=mysqli_fetch_array($sql);
	$pengirim=$row['nama_karyawan'];
?>
							</tbody>
						</table>
						<div id="lastDataTable"></div>
						</div>
						<table width="100%">
						<tbody>
						<tr>
							<td width="33%" align="center">Tanda Terima</td>
							<td width="33%" align="center">Pengirim</td>
							<td width="33%" align="center">Hormat kami,</td>
						</tr>
						<tr>
							<td width="33%">&nbsp;</td>
							<td width="33%">&nbsp;</td>
							<td width="33%">&nbsp;</td>
						</tr>
						<tr>
							<td width="33%">&nbsp;</td>
							<td width="33%">&nbsp;</td>
							<td width="33%">&nbsp;</td>
						</tr>
						<tr>
							<td width="33%">&nbsp;</td>
							<td width="33%">&nbsp;</td>
							<td width="33%">&nbsp;</td>
						</tr>
						<tr>
							<td width="33%" align="center">_________________________</td>
							<td width="33%" align="center">_________________________</td>
							<td width="33%" align="center">_________________________</td>
						</tr>
						<tr>
							<td width="33%">&nbsp;</td>
							<td width="33%" align="center"><?php echo $pengirim ?></td>
							<td width="33%" align="center"><?php echo $_SESSION['user_shop'] ?></td>
						</tr>
						</tbody>
						</table>
						<?php echo 'Diperiksa Oleh : ' .$nama_pemeriksa; ?>
					</div>
				</div>
			</div>
		</div>	
	</div>
</div>

<script>
function getBack(){
	window.location='index.php?page=gudang&mode=konfirm_jual';
}
$(document).ready(function()
{
	var div_pageBreaker = '<div style="page-break-before:always;"></div>';
	var per_page = 35;
    $('#table_data').each(function(index, element)
    {
		var pages = Math.ceil($('tbody tr').length / per_page);
		if (pages == 1) {
			return;
		}
		var table_to_split = $(element);
		var current_page   = 1;
		for (current_page = 1; current_page <= pages; current_page++) 
		{
			var cloned_table = table_to_split.clone();
			$('tbody tr', table_to_split).each(function(loop, row_element) {
				if (loop >= per_page) {
					$(row_element).remove();
				}
			});
			$('tbody tr', cloned_table).each(function(loop, row_element) {
				if (loop < per_page) {
					$(row_element).remove();
				}
			});
			if (current_page < pages) {
				$(div_pageBreaker).appendTo('#lastDataTable');
				$(cloned_table).appendTo('#lastDataTable');
			}
			table_to_split = cloned_table;
		}
	});
	window.print();
	window.close();
});
</script>
