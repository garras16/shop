<?php
$sql=mysql_query("UPDATE retur_jual SET status=2 WHERE id_retur_jual=$id");
$sql=mysql_query("SELECT
    pelanggan.nama_pelanggan
	, jual.id_jual
    , jual.invoice
    , retur_jual.no_retur_jual
	, retur_jual.status
    , retur_jual.tgl_retur
    , bayar_nota_jual.status AS status_bayar
FROM
    jual
    INNER JOIN pelanggan 
        ON (jual.id_pelanggan = pelanggan.id_pelanggan)
    INNER JOIN retur_jual 
        ON (retur_jual.id_jual = jual.id_jual)
	LEFT JOIN bayar_nota_jual 
        ON (jual.invoice = bayar_nota_jual.no_nota_jual)
WHERE retur_jual.id_retur_jual=$id");
$row=mysql_fetch_array($sql);
$id_jual=$row['id_jual'];
$status=$row['status'];
$status_retur="";
if ($status=='1') $status_retur="SELESAI";
if ($status=='2') $status_retur="SUDAH CETAK";
if ($row['status_bayar']=='1'){
	$status_bayar="LUNAS";
} else if ($row['status_bayar']=='2'){
	$status_bayar="TERBAYAR SEBAGIAN";
} else {
	$status_bayar="BELUM TERBAYAR";
}
?>
<style type="text/css" media="print">
    @page 
    {
        size:  portrait;   /* auto is the initial value */
        margin: 10mm 0mm 10mm 0mm;  /* this affects the margin in the printer settings */
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
<!-- page content -->
<div class="right_col" role="main">
	<div class="">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_content">
					<h3>RETUR PENJUALAN DETAIL</h3>
					<table class="table table-bordered table-striped">
					<tbody>
						<tr><td width="30%">Nama Pelanggan</td><td><?php echo $row['nama_pelanggan'] ?></td></tr>
						<tr><td width="30%">No Nota Jual</td><td><?php echo $row['invoice'] ?></td></tr>
						<tr><td width="30%">No Nota Retur</td><td><?php echo $row['no_retur_jual'] ?></td></tr>
						<tr><td width="30%">Tanggal Retur</td><td><?php echo date("d-m-Y", strtotime($row['tgl_retur'])) ?></td></tr>
						<tr><td width="30%">Status Bayar</td><td><?php echo $status_bayar ?></td></tr>
						<tr><td width="30%">Status Retur</td><td><?php echo $status_retur ?></td></tr>
					</tbody>
					</table>
			<div class="clearfix"></div>
			<div class="row-fluid" id="print-body-wrapper">
			<table class="table table-bordered table-striped" id="table_data">
				<thead>
					<tr>
						<th>Nama Barang</th>
						<th>Qty Retur Jual</th>
						<th>Harga Retur Jual (Rp)</th>
						<th>Qty Masuk</th>
						<th>Jumlah Retur Jual (Rp)</th>
					</tr>
				</thead>
				<tbody>
<?php
$sql=mysql_query("SELECT *
FROM
    retur_jual_detail
    INNER JOIN jual_detail 
        ON (retur_jual_detail.id_jual_detail = jual_detail.id_jual_detail)
    INNER JOIN harga_jual 
        ON (jual_detail.id_harga_jual = harga_jual.id_harga_jual)
    INNER JOIN barang_supplier 
        ON (harga_jual.id_barang_supplier = barang_supplier.id_barang_supplier)
    INNER JOIN barang 
        ON (barang_supplier.id_barang = barang.id_barang)
    INNER JOIN satuan 
        ON (barang.id_satuan = satuan.id_satuan)
 WHERE retur_jual_detail.id_retur_jual=$id
 GROUP BY retur_jual_detail.id_jual_detail");
$total_retur=0;
while($row=mysql_fetch_array($sql)){
if ($row['qty_masuk']==''){
	$total_retur+=$row['harga_retur']*$row['qty_retur'];
	$jml_retur=$row['harga_retur']*$row['qty_retur'];
} else {
	$total_retur+=$row['harga_retur']*$row['qty_masuk'];
	$jml_retur=$row['harga_retur']*$row['qty_masuk'];
}
echo '			<tr>
						<td>' .$row['nama_barang']. '</td>
						
						<td>' .$row['qty_retur']. ' ' .$row['nama_satuan']. '</td>
						<td>' .format_uang($row['harga_retur']). '</td>
						<td>' .format_angka($row['qty_masuk']). ' ' .$row['nama_satuan']. '</td>
						<td align="right">' .format_uang($jml_retur). '</td>
					</tr>';
}
echo '			<tr>
					<td colspan="4" align="right"><b>Total Jumlah Retur Jual</b></td>
					<td align="right"><b>Rp. ' .format_uang($jml_retur). '</b></td>
				</tr>';
?>
					
				</tbody>
			</table>
			<div id="lastDataTable"></div>
			</div>
			
			
			</div>
			</div>
			</div>
		</div>
		<!-- /page content -->

        
      </div>
    </div>
	
<script>
$(document).ready(function(){
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