<?php
$id_karyawan=$_SESSION['id_karyawan'];
(isset($_GET['cari_barang']) ? $cari_barang=$_GET['cari_barang'] : $cari_barang="");
$sql=mysql_query("SELECT tgl_nota,invoice,nama_pelanggan,nama_karyawan,nama_pelanggan,status_konfirm
FROM
    jual
    INNER JOIN pelanggan 
        ON (jual.id_pelanggan = pelanggan.id_pelanggan)
    INNER JOIN karyawan 
        ON (jual.id_karyawan = karyawan.id_karyawan)
WHERE (status_konfirm=0 or status_konfirm=5) AND id_jual NOT IN (SELECT id_jual FROM jual_detail)");
if (mysql_num_rows($sql)>0){
	$judul='Ada nota jual yang dihapus secara otomatis karena kosong';
	$pesan='Berikut nota jual yang dihapus : \r\n\r\n';
	$tanggal=date("Y-m-d H:i:s");
	$sql3=mysql_query("SELECT * FROM users WHERE posisi='OWNER'");
	$row3=mysql_fetch_array($sql3);
	$id_owner=$row3['id_karyawan'];
	while ($row=mysql_fetch_array($sql)){
		($row['status_konfirm']==0 ? $tipe='Dalam Kota' : $tipe='Canvass');
		$pesan.='Tgl Hapus : ' .date("d-m-Y, H:i:s", strtotime($tanggal)). '\r\nTgl Nota : ' .date("d-m-Y",strtotime($row['tgl_nota'])). '\r\nNota Nota Jual : ' .$row['invoice']
			.'\r\nTipe : ' .$tipe. '\r\nNama Sales : ' .$row['nama_karyawan']. '\r\nNama Pelanggan : ' .$row['nama_pelanggan']. '\r\n\r\n';
	}
	$sql2=mysql_query("INSERT INTO pesan VALUES (null,'$tanggal',$id_owner,'$judul','$pesan',0)");
}
$sql=mysql_query("DELETE FROM jual WHERE (status_konfirm=0 or status_konfirm=5) AND id_jual NOT IN (SELECT id_jual FROM jual_detail)");
?>
<div class="right_col loading" role="main">
	<div class="">
	
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<div class="col-xs-6">
							<h3>PENJUALAN</h3>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
					<div class="col-md-6" style="background:gray; padding-top:10px;padding-bottom:10px;width:100%">
						<font color="white">Cari Tanggal : </font><br/>
						<input style="width:100px" id="tgl_dari" type="text" value="" placeholder="Tanggal" readonly><font color="white"> - </font><input style="width:100px" id="tgl_sampai" type="text" value="" placeholder="Tanggal" readonly>&nbsp;<a class="btn btn-primary btn-xs" id="btn_dari_sampai" onClick="submit();"><i class="fa fa-search"></i></a>
					</div>
					<div class="col-md-6" style="background:gray; padding-top:10px;padding-bottom:10px;width:100%">
						<font color="white">Cari Barang : </font><br/>
						<input style="width:210px" id="cari_barang" type="text" value="" placeholder="Nama Barang">&nbsp;<a class="btn btn-primary btn-xs" id="btn_acri_barang" onClick="submit2();"><i class="fa fa-search"></i></a>
					</div>
					<div class="clearfix"></div><br/>
				
				<table id="table1" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>Tgl. Nota Jual</th>
						<th>No Nota Jual</th>
						<th>Pelanggan</th>
						<th>Jenis Bayar</th>
						<th>Tenor</th>
						<th>Jumlah (Rp)</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody>
				<?php
if (isset($_GET['dari'])){
	$dari=date("Y-m-d", strtotime($_GET['dari']));
	$sampai=date("Y-m-d", strtotime($_GET['sampai']));
	if (isset($_GET['cari_barang'])) $val="WHERE nama_barang LIKE '%$cari_barang%' AND id_karyawan=$id_karyawan AND (tgl_nota BETWEEN '$dari' AND '$sampai') AND status_konfirm>=0 AND status_konfirm<5";
	if (! isset($_GET['cari_barang'])) $val="WHERE id_karyawan=$id_karyawan AND (tgl_nota BETWEEN '$dari' AND '$sampai') AND status_konfirm>=0 AND status_konfirm<5";
} else {
	if (isset($_GET['cari_barang'])) $val="WHERE nama_barang LIKE '%$cari_barang%' AND id_karyawan=$id_karyawan AND MONTH(tgl_nota)=MONTH(CURRENT_DATE()) AND YEAR(tgl_nota)=YEAR(CURRENT_DATE()) AND status_konfirm>=0 AND status_konfirm<5";
	if (! isset($_GET['cari_barang'])) $val="WHERE id_karyawan=$id_karyawan AND MONTH(tgl_nota)=MONTH(CURRENT_DATE()) AND YEAR(tgl_nota)=YEAR(CURRENT_DATE()) AND status_konfirm>=0 AND status_konfirm<5";
}

$sql=mysql_query("SELECT
    jual.id_jual
	, jual.tgl_nota
    , jual.invoice
    , jual.jenis_bayar
	, jual.tenor
    , jual.status_konfirm
	, pelanggan.nama_pelanggan
FROM
    jual
    INNER JOIN jual_detail 
        ON (jual.id_jual = jual_detail.id_jual)
    INNER JOIN pelanggan 
        ON (jual.id_pelanggan = pelanggan.id_pelanggan)
    LEFT JOIN harga_jual 
        ON (harga_jual.id_pelanggan = pelanggan.id_pelanggan) AND (jual_detail.id_harga_jual = harga_jual.id_harga_jual)
    LEFT JOIN barang_supplier 
        ON (harga_jual.id_barang_supplier = barang_supplier.id_barang_supplier)
    LEFT JOIN barang 
        ON (barang_supplier.id_barang = barang.id_barang) 
$val
GROUP BY jual.id_jual
ORDER BY jual.id_jual DESC");
while($row=mysql_fetch_array($sql)){
if ($row['status_konfirm']==0){
	$status="MENUNGGU";
} else if ($row['status_konfirm']==1){
	$status="PROSES KIRIM";
} else if ($row['status_konfirm']==2){
	$status="TERKIRIM";
} else {
	$status="";
}
if ($row['jenis_bayar']=='Lunas'){
	//$sql2=mysql_query("SELECT SUM(qty*(harga_jual-diskon_rp)) AS total_harga
	$sql2=mysql_query("SELECT SUM(qty*(harga_jual-diskon_rp-diskon_rp_2-diskon_rp_3)) AS total_harga
FROM
    jual_detail
    INNER JOIN harga_jual 
        ON (jual_detail.id_harga_jual = harga_jual.id_harga_jual)
WHERE id_jual=" .$row['id_jual']);
} else {
$sql2=mysql_query("SELECT SUM(qty*(harga_kredit-diskon_rp-diskon_rp_2-diskon_rp_3)) AS total_harga
FROM
    jual_detail
    INNER JOIN harga_jual_kredit 
        ON (jual_detail.id_harga_jual = harga_jual_kredit.id_harga_jual)
WHERE id_jual=" .$row['id_jual']);
}
$r=mysql_fetch_array($sql2);
	echo '			<tr>
						<td><a href="?page=sales&mode=edit_penjualan&id=' .$row['id_jual']. '"><div style="min-width:70px">' .date("d-m-Y",strtotime($row['tgl_nota'])). '</div></a></td>
						<td><a href="?page=sales&mode=edit_penjualan&id=' .$row['id_jual']. '"><div style="min-width:70px">' .$row['invoice']. '</div></a></td>
						<td><a href="?page=sales&mode=edit_penjualan&id=' .$row['id_jual']. '"><div style="min-width:70px">' .$row['nama_pelanggan']. '</div></a></td>
						<td><a href="?page=sales&mode=edit_penjualan&id=' .$row['id_jual']. '"><div style="min-width:70px">' .$row['jenis_bayar']. '</div></a></td>
						<td><a href="?page=sales&mode=edit_penjualan&id=' .$row['id_jual']. '"><div style="min-width:70px">' .$row['tenor']. ' hari</div></a></td>
						<td><a href="?page=sales&mode=edit_penjualan&id=' .$row['id_jual']. '"><div style="min-width:70px">' .format_uang($r['total_harga']). '</div></a></td>';
	if ($status==""){
		echo '			<td></td>';
	} else {
		echo '			<td><a href="?page=sales&mode=edit_penjualan&id=' .$row['id_jual']. '"><div style="min-width:70px" class="badge bg-green">' .$status. '</div></a></td>';
	}
	echo '				</tr>';
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

<script>
function validasi(){
	var startDate = new Date.parse(get_global_tanggal($('#tgl_dari').val()));
	var endDate = new Date.parse(get_global_tanggal($('#tgl_sampai').val()));
	if (startDate > endDate){
		$('#tgl_dari').val('');
		$('#tgl_sampai').val('');
		$('#btn_dari_sampai').attr('style','display:none');
		alert("Terjadi kesalahan penulisan tanggal");
		AndroidFunction.showToast("Terjadi kesalahan penulisan tanggal");
	} else {
		$('#btn_dari_sampai').removeAttr('style');
	}
}
function submit(){
	var dari = $('#tgl_dari').val();
	var sampai = $('#tgl_sampai').val();
	if (dari!='' & sampai!='') window.location="?page=sales&mode=view_penjualan&dari=" + $('#tgl_dari').val() + "&sampai=" + $('#tgl_sampai').val();
}
function submit2(){
	var dari = $('#tgl_dari').val();
	var sampai = $('#tgl_sampai').val();
	var barang = $('#barang').val();
	if (dari!='' && sampai!=''){
		window.location="?page=sales&mode=view_penjualan&dari=" + dari + "&sampai=" + sampai + "&cari_barang=" + $('#cari_barang').val();
	} else {
		window.location="?page=sales&mode=view_penjualan&cari_barang=" + $('#cari_barang').val();
	}
}
function getBack(){
	window.location="?page=sales&mode=menu_penjualan";
}

$(document).ready(function(){
	var now = new Date();
	$('#tgl_dari').daterangepicker({
		locale: {
			format: 'DD-MM-YYYY'
		},
		singleDatePicker: true
	});
	$('#tgl_sampai').daterangepicker({
		locale: {
			format: 'DD-MM-YYYY'
		},
		singleDatePicker: true
	});
	$("#tgl_dari").val('<?php echo (isset($_GET['dari']) ? $_GET['dari'] : '') ?>');
	$("#tgl_dari").on('change', function(){
		validasi();
	});
	$("#tgl_sampai").val('<?php echo (isset($_GET['sampai']) ? $_GET['sampai'] : '') ?>');
	$("#tgl_sampai").on('change', function(){
		validasi();
	});
	$("#cari_barang").val('<?php echo (isset($_GET['cari_barang']) ? $_GET['cari_barang'] : '') ?>');
})
</script>
