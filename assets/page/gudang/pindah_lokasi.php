<div class="right_col" role="main">
	<div class="">
	
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<h3>PINDAH LOKASI</h3>
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
					<div class="clearfix" style="margin-bottom: 20px;"></div>
				<div class="table responsive">
				<table id="table1" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>Nama Barang</th>
						<th>Total Stok</th>
					</tr>
				</thead>
				<tbody>
				<?php
$sql=mysqli_query($con, "SELECT
    barang.id_barang
    , barang.nama_barang
    , satuan.nama_satuan
FROM
    barang
    INNER JOIN satuan 
        ON (barang.id_satuan = satuan.id_satuan)
WHERE barang.status=1");
while($row=mysqli_fetch_array($sql)){
$id_barang=$row['id_barang'];
$sql2=mysqli_query($con, "SELECT
    SUM(barang_masuk_rak.stok) AS total
FROM
    barang_supplier
    INNER JOIN barang 
        ON (barang_supplier.id_barang = barang.id_barang)
    INNER JOIN beli_detail 
        ON (beli_detail.id_barang_supplier = barang_supplier.id_barang_supplier)
    INNER JOIN barang_masuk 
        ON (barang_masuk.id_beli_detail = beli_detail.id_beli_detail)
    INNER JOIN barang_masuk_rak 
        ON (barang_masuk_rak.id_barang_masuk = barang_masuk.id_barang_masuk)
WHERE barang.id_barang=$id_barang AND barang_masuk_rak.stok>0");
$r=mysqli_fetch_array($sql2);
$total=$r['total'];
if ($total!='')
	echo '			<tr>
						<td><a data-toggle="modal" data-target="#myModal" data-nama="' .$row['nama_barang']. '" data-id="' .$row['id_barang']. '"><div style="min-width:70px">' .$row['nama_barang']. '</div></a></td>
						<td><a data-toggle="modal" data-target="#myModal" data-nama="' .$row['nama_barang']. '" data-id="' .$row['id_barang']. '"><div style="min-width:70px">' .$total. ' ' .$row['nama_satuan']. '</div></a></td>
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
</div>

<!-- modal input -->
<div id="myModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><div style="min-width:50px">&times;</div></button>
				<h4 id="judul" class="modal-title">Detail Stok Barang</h4>
			</div>
			<div class="modal-body">				
				<form action="" method="post">
					<input type="hidden" name="edit_gudang_konfirm_beli_post" value="true">
					<div style="overflow-x: auto">
						<div id="get_content" class="col-md-12">
							
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>


<script>
$(document).ready(function(){
	$('#myModal').on('show.bs.modal', function(e){
		var id = $(e.relatedTarget).data('id');
		var nama = $(e.relatedTarget).data('nama');
		$('#judul').html('Detail Stok Barang - ' + nama);
		$('#get_content').load('assets/page/gudang/stok_detail.php?id=' + id,function(){
			
		});
	});
});
</script>
