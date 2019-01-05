<?php
if (isset($id)){
	$sql=mysql_query("SELECT COUNT(id_jual) AS cID FROM retur_jual WHERE tgl_retur='" .date('Y-m-d'). "'");
	$r=mysql_fetch_array($sql);
	$no_retur="RJ-" .date("ymd"). '-' .sprintf("%03d",$r['cID']+1);
	$tanggal=date("Y-m-d");
	$sql = mysql_query("INSERT INTO retur_jual VALUES(null,'$tanggal','$no_retur',$id,0)");
	$last_id=mysql_insert_id();
	_direct("?page=penjualan&mode=retur_jual_detail&id=" .$last_id);
}
?>
<!-- page content -->
<div class="right_col" role="main">
	<div class="">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<h3>CARI NOTA PENJUALAN</h3>
						<?php
							if (isset($pesan)){
								echo '<span class="badge bg-' .$warna. '">' .$pesan. '</span>';
							}
						?>
					<div class="clearfix"></div>
					</div>
					<div class="x_content">
			
			<center>
				<form action="" method="post">
				<input type="hidden" name="cari_nota_retur_jual_post" value="true">
				<div class="col-xs-6">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-building fa-fw"></i></span>
						<input class="form-control" type="text" name="pelanggan" placeHolder="Cari Pelanggan" value="<?php if (isset($pelanggan)) echo $pelanggan ?>" required>
						<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
					</div>
				</div>
				<div class="col-xs-6">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-file fa-fw"></i></span>
						<input class="form-control" type="text" name="tgl_nota" placeHolder="Cari Tanggal Nota Jual" value="<?php if (isset($tgl_nota)) echo $tgl_nota ?>">
					</div>
				</div>
				<div class="col-xs-6">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-truck fa-fw"></i></span>
						<input class="form-control" type="text" name="tgl_kirim" placeHolder="Cari Tanggal Kirim" value="<?php if (isset($tgl_kirim)) echo $tgl_kirim ?>">
					</div>
				</div>
				<div class="col-xs-6">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-bookmark fa-fw"></i></span>
						<input class="form-control" type="text" name="barang" placeHolder="Cari Barang" value="<?php if (isset($barang)) echo $barang ?>">
					</div>
				</div>
				<div class="clearfix"></div>
				<button class="btn btn-primary" type="submit"><i class="fa fa-search"></i> CARI NOTA</button>
				</form>
			</center>
			<div class="clearfix"></div>
			</div>
			</div>
			</div>
		</div>
		<!-- /page content -->
		
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div id="table_content" class="x_content">
						<table id="table2" class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>Tgl. Nota Jual</th>
									<th>No Nota Jual</th>
									<th>Nama Pelanggan</th>
									<th>Pemeriksa Barang</th>
									<th>Pengirim Barang</th>
									<th>Tanggal Kirim</th>
									<th>Status Pembayaran</th>
									<th>Status Retur</th>
								</tr>
							</thead>
							<tbody>
<?php
if (isset($cari_nota_retur_jual_post)){
$val="pelanggan.nama_pelanggan LIKE '%" .$pelanggan. "%'";

if ($tgl_nota!=''){
	$tgl=explode("-",$tgl_nota);
	if (count($tgl)==3){
		$tgl_nota=$tgl[2]. "-" .$tgl[1]. "-" .$tgl[0];
	} else {
		$tgl_nota=$tgl[1]. "-" .$tgl[0];
	}
	$val.=" AND jual.tgl_nota LIKE '%" .$tgl_nota. "%'";
}
if ($tgl_kirim!=''){
	$tgl=explode("-",$tgl_kirim);
	if (count($tgl)==3){
		$tgl_kirim=$tgl[2]. "-" .$tgl[1]. "-" .$tgl[0];
	} else {
		$tgl_kirim=$tgl[1]. "-" .$tgl[0];
	}
	$val.=" AND pengiriman.tanggal_kirim LIKE '%" .$tgl_kirim. "%'";
}
$val.=" AND barang.nama_barang LIKE '%" .$barang. "%'";

$sql=mysql_query("SELECT *
FROM
    jual
    INNER JOIN pelanggan 
        ON (jual.id_pelanggan = pelanggan.id_pelanggan)
    LEFT JOIN pengiriman 
        ON (pengiriman.id_jual = jual.id_jual)
    INNER JOIN jual_detail 
        ON (pengiriman.id_jual = jual_detail.id_jual)
    INNER JOIN harga_jual 
        ON (harga_jual.id_pelanggan = pelanggan.id_pelanggan) AND (jual_detail.id_harga_jual = harga_jual.id_harga_jual)
    INNER JOIN barang_supplier 
        ON (harga_jual.id_barang_supplier = barang_supplier.id_barang_supplier)
    INNER JOIN barang 
        ON (barang_supplier.id_barang = barang.id_barang)
 WHERE $val  
 GROUP BY jual.id_jual
 ORDER BY jual.id_jual DESC");
	while ($row=mysql_fetch_array($sql)){
		$sql2=mysql_query("SELECT nama_karyawan FROM nota_sudah_cek INNER JOIN karyawan ON (nota_sudah_cek.id_karyawan=karyawan.id_karyawan);");
		$row2=mysql_fetch_array($sql2);
		$pemeriksa=$row2['nama_karyawan'];
		$sql2=mysql_query("SELECT nama_karyawan FROM pengiriman INNER JOIN karyawan ON (pengiriman.id_karyawan=karyawan.id_karyawan);");
		$row2=mysql_fetch_array($sql2);
		$pengirim=$row2['nama_karyawan'];
		$sql2=mysql_query("SELECT status FROM bayar_nota_jual WHERE no_nota_jual='" .$row['invoice']. "'");
		$row2=mysql_fetch_array($sql2);
		if ($row2['status']=='1'){
			$status_bayar="LUNAS";
		} else if ($row2['status']=='2'){
			$status_bayar="TERBAYAR SEBAGIAN";
		} else {
			$status_bayar="BELUM TERBAYAR";
		}
		$sql2=mysql_query("SELECT status FROM retur_jual WHERE id_jual=" .$row['id_jual']. "");
		$row2=mysql_fetch_array($sql2);
		if ($row2['status']=='1'){
			$status_retur="SELESAI";
		} else {
			$status_retur="";
		}
		echo '<tr>
				<td><a href="?page=penjualan&mode=cari_nota_retur&id=' .$row['id_jual']. '">' .date("d-m-Y",strtotime($row['tgl_nota'])). '</a></td>
				<td><a href="?page=penjualan&mode=cari_nota_retur&id=' .$row['id_jual']. '">' .$row['invoice']. '</a></td>
				<td><a href="?page=penjualan&mode=cari_nota_retur&id=' .$row['id_jual']. '">' .$row['nama_pelanggan']. '</a></td>
				<td><a href="?page=penjualan&mode=cari_nota_retur&id=' .$row['id_jual']. '">' .$pemeriksa. '</a></td>
				<td><a href="?page=penjualan&mode=cari_nota_retur&id=' .$row['id_jual']. '">' .$pengirim. '</a></td>
				<td><a href="?page=penjualan&mode=cari_nota_retur&id=' .$row['id_jual']. '">' .date("d-m-Y",strtotime($row['tanggal_kirim'])). '</a></td>
				<td><a href="?page=penjualan&mode=cari_nota_retur&id=' .$row['id_jual']. '">' .$status_bayar. '</a></td>
				<td><a href="?page=penjualan&mode=cari_nota_retur&id=' .$row['id_jual']. '">' .$status_retur. '</a></td>
			</tr>';
	}
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


	
