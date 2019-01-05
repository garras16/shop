<?php

?>
<!-- page content -->
<div class="right_col" role="main">
	<div class="">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<h3>MASTER HARGA JUAL</h3>
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
			<table id="table1" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>No.</th>
						<th>Nama Pelanggan</th>
					</tr>
				</thead>
				<tbody>
<?php
$sql=mysqli_query($con, "SELECT * FROM pelanggan ORDER BY id_pelanggan DESC");
$i=0;
while($row=mysqli_fetch_array($sql)){
$i+=1;
	echo '			<tr>
						<td><a href="?page=harga_jual&mode=view_detail&id=' .$row['id_pelanggan']. '"><div style="min-width:70px">' .$i. '</div></a></td>
						<td><a href="?page=harga_jual&mode=view_detail&id=' .$row['id_pelanggan']. '"><div style="min-width:70px">' .$row['nama_pelanggan']. '</div></a></td>
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

