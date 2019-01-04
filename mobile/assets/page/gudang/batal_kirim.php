
<div class="right_col loading" role="main">
	<div class="">
	
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<div class="col-md-6">
							<h3>PEMBATALAN KIRIMAN</h3>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
				
				<table id="table1" class="table table-bordered table-striped" style="table-layout:fixed">
				<thead>
					<tr>
						<th>Tgl. Batal</th>
						<th>Nama Karyawan</th>
						<th>No Nota Jual</th>
					</tr>
				</thead>
				<tbody>
				<?php
$sql=mysql_query("SELECT *
FROM
    batal_kirim
    INNER JOIN jual 
        ON (batal_kirim.id_jual = jual.id_jual)
    INNER JOIN karyawan 
        ON (batal_kirim.id_karyawan = karyawan.id_karyawan) WHERE batal_kirim.status=0
ORDER BY id_batal_kirim DESC");
while($row=mysql_fetch_array($sql)){
	echo '			<tr>
						<td><a href="?page=gudang&mode=batal_kirim_2&id=' .$row['id_jual']. '"><div style="min-width:70px">' .date("d-m-Y",strtotime($row['tanggal'])). '</div></a></td>
						<td><a href="?page=gudang&mode=batal_kirim_2&id=' .$row['id_jual']. '"><div style="min-width:70px">' .$row['nama_karyawan']. '</div></a></td>
						<td><a href="?page=gudang&mode=batal_kirim_2&id=' .$row['id_jual']. '"><div style="min-width:70px">' .$row['invoice']. '</div></a></td>
						
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

<script>
function getBack(){
	AndroidFunction.closeApp();
}
$(document).ready(function(){
	
})
</script>
