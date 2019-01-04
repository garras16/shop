<?php
$sql=mysqli_query($con, "UPDATE pesan SET status_pesan=1 WHERE id_pesan=" .$id);
?>
<!-- page content -->
<div class="right_col" role="main">
	<div class="">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
					<div class="x_title">
						<h3>PESAN DETAIL</h3>
					</div>
					<div class="clearfix"></div>
					<a href="?page=pesan&mode=pesan"><button style="margin-bottom:10px" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Kembali</button></a>

			<table class="table table-bordered table-striped">
				<tbody>
<?php
$sql=mysqli_query($con, "SELECT * FROM pesan WHERE id_pesan=" .$id. " ORDER BY tanggal DESC");
$row=mysqli_fetch_array($sql);
if ($row['status_pesan']=='0'){$status='BELUM DIBACA'; $style='badge bg-red';}
if ($row['status_pesan']=='1'){$status='TERBACA'; $style='badge bg-green';}
	echo '			<tr><td width="30%">Tanggal Pesan</td><td width="70%">' .date("d F Y, H:i", strtotime($row['tanggal'])). '</td></tr>
					<tr><td width="30%">Judul</td><td width="70%">' .$row['judul']. '</td></tr>
					<tr><td width="30%">Pesan</td><td width="70%"><textarea readonly style="width:100%" rows="10">' .$row['pesan']. '</textarea></td></tr>';
?>
					
				</tbody>
			</table>
			</div>
			</div>
		</div>
		<!-- /page content -->

        
      </div>
    </div>

<script>
$(document).ready(function(){
	
});
</script>