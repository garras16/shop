<?php
if (isset($tambah_bayar_ekspedisi_post)){
	$sql = mysql_query("SELECT * FROM bayar_ekspedisi WHERE id_beli=$id_beli");
	if (mysql_num_rows($sql)>0){
		$row=mysql_fetch_array($sql);
		$id_bayar_ekspedisi=$row['id_bayar_ekspedisi'];
	} else {
		$sql2 = mysql_query("INSERT INTO bayar_ekspedisi VALUES(null,$id_beli,0)");
		$id_bayar_ekspedisi=mysql_insert_id();
	}
	$sql = mysql_query("INSERT INTO bayar_ekspedisi_detail VALUES(null,$id_bayar_ekspedisi,'$tanggal',$jumlah_bayar)");
	if ($sql){
		_buat_pesan("Input Berhasil","green");
	} else {
		_buat_pesan("Input Gagal","red");
	}
	$sql = mysql_query("SELECT SUM(jumlah_bayar) AS total_bayar FROM bayar_ekspedisi_detail WHERE id_bayar_ekspedisi=$id_bayar_ekspedisi");
	$row=mysql_fetch_array($sql);
	$total_bayar=$row['total_bayar'];
	
	$sql = mysql_query("SELECT tarif_ekspedisi FROM beli WHERE id_beli=$id_beli");
	$row=mysql_fetch_array($sql);
	$tarif=$row['tarif_ekspedisi'];
	
	$status=0;
	if ($total_bayar>0) $status=1;
	if ($tarif == $total_bayar) $status=2;
	
	$sql = mysql_query("UPDATE bayar_ekspedisi SET status=$status WHERE id_bayar_ekspedisi=$id_bayar_ekspedisi");
	_direct("?page=ekspedisi&mode=bayar_hutang");
}
if (isset($_GET['del'])){
	$sql = mysql_query("DELETE FROM bayar_ekspedisi_detail WHERE id_bayar_ekspedisi_detail=" .$_GET['del']);
	if ($sql){
		_buat_pesan("Input Berhasil","green");
	} else {
		_buat_pesan("Input Gagal","red");
	}
	$sql=mysql_query("SELECT * FROM bayar_ekspedisi_detail WHERE id_bayar_ekspedisi=" .$_GET['id']);
	(mysql_num_rows($sql)>0 ? $status=1 : $status=0);
	$sql = mysql_query("UPDATE bayar_ekspedisi SET status=$status WHERE id_bayar_ekspedisi=" .$_GET['id']);
	_direct("?page=ekspedisi&mode=bayar_hutang");
}
?>
<!-- page content -->
<div class="right_col" role="main">
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
					<div class="x_title">
						<h3>BAYAR HUTANG KE EKSPEDISI</h3>
							<?php
							if (isset($pesan)){
								echo '<span class="badge bg-' .$warna. '">' .$pesan. '</span>';
							}
							?>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
			<p align="right"><button class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Tambah</button></p>
			<div class="clearfix"></div>
			<div class="table responsive">
			<table id="table1" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>Tgl. Nota Beli</th>
						<th>No Nota Beli</th>
						<th style="min-width:100px">Nama Ekspedisi</th>
						<th>Tgl. Bayar Terakhir</th>
						<th>Jumlah Bayar Per Tgl (Rp)</th>
						<th>Sisa Hutang (Rp)</th>
						<th style="min-width:100px">Status</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
<?php
$sql=mysql_query("SELECT *,bayar_ekspedisi.status
FROM
    bayar_ekspedisi
    INNER JOIN bayar_ekspedisi_detail 
        ON (bayar_ekspedisi.id_bayar_ekspedisi = bayar_ekspedisi_detail.id_bayar_ekspedisi)
    INNER JOIN beli 
        ON (bayar_ekspedisi.id_beli = beli.id_beli)
	INNER JOIN ekspedisi 
        ON (beli.id_ekspedisi = ekspedisi.id_ekspedisi)
ORDER BY bayar_ekspedisi_detail.id_bayar_ekspedisi_detail DESC");
while($row=mysql_fetch_array($sql)){
$sql2=mysql_query("SELECT SUM(jumlah_bayar) as total_bayar FROM bayar_ekspedisi_detail WHERE id_bayar_ekspedisi=" .$row['id_bayar_ekspedisi']);
$row2=mysql_fetch_array($sql2);
$sisa_hutang=$row['tarif_ekspedisi']-$row2['total_bayar'];
/*
STATUS 0 : KOSONG
STATUS 1 : TERBAYAR SEBAGIAN
STATUS 2 : LUNAS
*/
if ($row['status']==1){
	$status='TERBAYAR SEBAGIAN';
} else if ($row['status']==2){
	$status='LUNAS';
} else {
	$status='';
}
	echo '			<tr>
						<td>' .date("d-m-Y",strtotime($row['tanggal'])). '</td>
						<td>' .$row['no_nota_beli']. '</td>
						<td>' .$row['nama_ekspedisi']. '</td>
						<td>' .date("d-m-Y",strtotime($row['tgl_bayar'])). '</td>
						<td>' .format_uang($row['jumlah_bayar']). '</td>
						<td>' .format_uang($sisa_hutang). '</td>
						<td>' .$status. '</td>
						<td><a class="btn btn-danger btn-xs" href="?page=ekspedisi&mode=bayar_hutang&del=' .$row['id_bayar_ekspedisi_detail']. '&id=' .$row['id_bayar_ekspedisi']. '"><i class="fa fa-trash"></i> Hapus</a></td>
					</tr>';
}
?>
					
				</tbody>
			</table>
			</div>
		</div>
		<!-- /page content -->

        
					</div>
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
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Tambah Data Bayar Ekspedisi</h4>
			</div>
			<div class="modal-body">				
				<form action="" method="post" onsubmit="return cek_valid()">
					<input type="hidden" name="tambah_bayar_ekspedisi_post" value="true">
					<div class="col-md-12">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
						<input class="form-control" placeholder="Tanggal Bayar" title="Tanggal Bayar" value="<?php echo date("d-m-Y"); ?>" readonly>
						<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-file fa-fw"></i></span>
						<select class="select2 form-control" id="select_nota" name="id_beli" required>
							<option value="" disabled selected>Nota Beli | Tarif (Rp) | Sisa Hutang (Rp)</option>
							<?php 
								$brg=mysql_query("SELECT id_beli,no_nota_beli,tarif_ekspedisi
								FROM beli WHERE id_beli NOT IN (SELECT id_beli FROM bayar_ekspedisi WHERE STATUS=2)
								AND tarif_ekspedisi>0");
								while($b=mysql_fetch_array($brg)){
								$sql=mysql_query("SELECT SUM(jumlah_bayar) as total_bayar
FROM
    bayar_ekspedisi
    INNER JOIN bayar_ekspedisi_detail 
        ON (bayar_ekspedisi.id_bayar_ekspedisi = bayar_ekspedisi_detail.id_bayar_ekspedisi)
WHERE id_beli=" .$b['id_beli']);
$row2=mysql_fetch_array($sql);
$sisa_hutang=$b['tarif_ekspedisi']-$row2['total_bayar'];
							?>	
							<option data-sisa="<?php echo $sisa_hutang; ?>" value="<?php echo $b['id_beli']; ?>"><?php echo $b['no_nota_beli']. ' | Rp ' .format_uang($b['tarif_ekspedisi']). ' | Rp ' .format_uang($sisa_hutang);?></option>
							<?php 
								}
							?>
						</select>
						<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-money fa-fw"></i></span>
						<input type="tel" id="jumlah_bayar" name="jumlah_bayar" class="form-control" placeholder="Jumlah Bayar (Rp)" title="Jumlah Bayar (Rp)" value="" required>
						<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
					</div>
					</div>
					<div class="modal-footer">
						<input type="submit" class="btn btn-primary" value="Simpan">
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<script>
function cek_valid(){
	var sisa_hutang=$('#select_nota').find('option:selected').data('sisa');
	var jumlah_bayar=$('#jumlah_bayar').inputmask('unmaskedvalue');
	
	if (jumlah_bayar==0){
		alert("Jumlah Bayar harus lebih dari 0.");
		return false;
	}
	if (jumlah_bayar > sisa_hutang){
		alert("Jumlah Bayar harus kurang dari sisa hutang.");
		return false;
	}
	return true;
}
$(document).ready(function(){
	$('#jumlah_bayar').inputmask('decimal', {allowMinus: false, autoGroup: true, groupSeparator: '.', rightAlign: false, removeMaskOnSubmit: true});
});
</script>