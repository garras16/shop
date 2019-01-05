<?php
if (isset($_GET['act'])){
	$act=0;
	if ($_GET['act']=='1') $act=1;
	if ($_GET['act']=='2') $act=2;
	
	$sql=mysql_query("UPDATE penagihan_retur_detail SET status_retur=$act WHERE id_penagihan_retur_detail=$id");
	if ($sql){
		$pesan="INPUT BERHASIL";
	} else {
		$pesan="INPUT GAGAL";
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
						<th>Tanggal Retur Jual</th>
						<th>No Retur Jual</th>
						<th>Jumlah Retur (Rp)</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
				<?php
$sql=mysql_query("SELECT *
FROM
    penagihan_retur_detail
    INNER JOIN penagihan_detail 
        ON (penagihan_retur_detail.id_penagihan_detail = penagihan_detail.id_penagihan_detail)
WHERE status_retur=0");
while($row=mysql_fetch_array($sql)){
	echo '			<tr>
						<td>' .date("d-m-Y",strtotime($row['tgl_bayar'])). '</td>
						<td>' .$row['no_retur_jual']. '</td>
						<td>' .format_uang($row['jumlah_retur']). '</td>
						<td><a href="?page=penjualan&mode=pencairan_giro&id=' .$row['id_penagihan_retur_detail']. '&act=1" class="btn btn-primary btn-xs"><i class="fa fa-check"></i> Cair</a>
						<a href="?page=penjualan&mode=pencairan_giro&id=' .$row['id_penagihan_retur_detail']. '&act=2" class="btn btn-danger btn-xs"><i class="fa fa-times"></i> Tolak</a></td>
					</tr>';
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
$(document).ready(function(){
	$('#total_jual').inputmask('decimal', {allowMinus: false, autoGroup: true, groupSeparator: '.', rightAlign: false, removeMaskOnSubmit: true});
	$('#diskon_nota').inputmask('decimal', {allowMinus: false, autoGroup: true, groupSeparator: '.', rightAlign: false, removeMaskOnSubmit: true});
	$('#diskon_nota_rp').inputmask('decimal', {allowMinus: false, autoGroup: true, groupSeparator: '.', rightAlign: false, removeMaskOnSubmit: true});
	$('#myModal').on('show.bs.modal', function(e){
		
	});
	
});
</script>