<?php
$id_karyawan=$_SESSION['id_karyawan'];
function getTipe($tipe){
	$hasil="";
	if($tipe=="canvass_stock_opname"){
		$hasil="Canvass Stock Opname";
	}
	return $hasil;
}
?>
<div class="right_col loading" role="main">
	<div class="">
	
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<div class="col-md-6">
							<h3>KONFIRMASI OWNER</h3>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="x_content"><div class="alert alert-info">
					  <strong>Klik kolom pada tabel untuk detail.</strong>
					</div>
					
						<div class="table-responsive">
						<table class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>Tgl Konfirmasi</th>
									<th>Tipe</th>
									<th>Deskripsi</th>
								</tr>
							</thead>
							<tbody>
<?php
	$sql=mysqli_query($con, "SELECT *,konfirm_owner.id_konfirm_owner
FROM
    konfirm_owner
    LEFT JOIN konfirm_owner_detail 
        ON (konfirm_owner.id_konfirm_owner = konfirm_owner_detail.id_konfirm_owner)
WHERE STATUS=0
ORDER BY konfirm_owner.id_konfirm_owner DESC");
	while ($row=mysqli_fetch_array($sql)){
	echo '<tr>
				<td><div style="min-width:70px"><a href="' .$row['url']. '&id_konfirm=' .$row['id_konfirm_owner']. '">' .date("d-m-Y",strtotime($row['tgl_konfirm'])). '</div></a></td>
				<td><div style="min-width:70px"><a href="' .$row['url']. '&id_konfirm=' .$row['id_konfirm_owner']. '">' .getTipe($row['tipe']). '</div></a></td>
				<td><div style="min-width:70px"><a href="' .$row['url']. '&id_konfirm=' .$row['id_konfirm_owner']. '">' .$row['deskripsi']. '</div></a></td>
			</tr>';
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

<script>
$(document).ready(function(){
	
})
</script>
