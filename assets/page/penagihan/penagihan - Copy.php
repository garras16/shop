<?php
$id_karyawan=$_SESSION['id_karyawan'];
if (isset($buat_penagihan_post)){
	$sql = mysql_query("INSERT INTO penagihan VALUES(null,$penagih,'$tanggal','DALAM KOTA',0)");
	$id_tagih=mysql_insert_id();
	foreach ($id_jual as $key => $value) {
		$sql=mysql_query("INSERT INTO penagihan_detail VALUES(null,$id_tagih,$value,0,0,null)");
	}
	_direct("?page=penagihan&mode=dalam_kota");
}
if (isset($batal_penagihan_post)){
	foreach ($id_penagihan as $key => $value) {
		$sql=mysql_query("DELETE FROM penagihan WHERE id_penagihan=" .$value);
		$sql=mysql_query("DELETE FROM penagihan_detail WHERE id_penagihan=" .$value);
	}
	_direct("?page=penagihan&mode=dalam_kota");
}
?>
<div class="right_col loading" role="main">
	<div class="">
	
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<div class="col-md-6">
							<h3>PENAGIHAN</h3>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
				
						<div class="" role="tabpanel">
						  <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
							<li role="presentation" class="active"><a href="#tab_content1" id="tab1" role="tab" data-toggle="tab" aria-expanded="true">Nota Jual</a>
							</li>
							<li role="presentation" class=""><a href="#tab_content2" role="tab" id="tab2" data-toggle="tab" aria-expanded="false">Penagihan</a>
							</li>
						  </ul>
						  <div id="myTabContent" class="tab-content">
							<div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="tab1">
								<form method="post" onsubmit="return cek_valid()">
								<input type="hidden" name="buat_penagihan_post" value="true">
								<div class="input-group">
								<select class="form-control select2" id="select_karyawan" name="id_karyawan" required>
									<option value="" disabled selected>Pilih Karyawan</option>
									<?php
									$sql=mysql_query("SELECT * FROM karyawan WHERE status=1");
									while ($row=mysql_fetch_array($sql)){
										echo '<option value="' .$row['id_karyawan']. '">' .$row['nama_karyawan']. '</option>';
									}
									?>
								</select>
								<span class="input-group-btn">
								<input class="btn btn-primary" type="submit" value="Buat Penagihan">
								</span>
								</div>
								<div class="table-responsive">
								<table id="table_belum_siap" class="table table-bordered table-striped">
									<thead>
										<tr>
											<th>Pilih</th>
											<th>Tgl Nota Jual</th>
											<th>No Nota Jual</th>
											<th>Nama Sales</th>
											<th>Nama Pelanggan</th>
											<th>Jumlah Jual (Rp)</th>
										</tr>
									</thead>
									<tbody>
<?php
	$sql=mysql_query("SELECT *
FROM
    jual
    INNER JOIN pelanggan 
        ON (jual.id_pelanggan = pelanggan.id_pelanggan)
    INNER JOIN karyawan 
        ON (jual.id_karyawan = karyawan.id_karyawan)
WHERE status_konfirm=2 AND id_jual NOT IN (SELECT id_jual FROM penagihan INNER JOIN penagihan_detail 
    ON (penagihan.id_penagihan=penagihan_detail.id_penagihan) WHERE status_tagih=0)");
	while ($row=mysql_fetch_array($sql)){
		$sql2=mysql_query("SELECT SUM(qty_ambil*harga) AS total_jual
			FROM
				jual_detail
				INNER JOIN nota_siap_kirim_detail 
					ON (jual_detail.id_jual_detail = nota_siap_kirim_detail.id_jual_detail)
			WHERE id_jual=" .$row['id_jual']);
		$r=mysql_fetch_array($sql2);
		$sql3=mysql_query("SELECT SUM(qty_ambil*harga) AS jumlah_nota
FROM
    jual
    INNER JOIN jual_detail 
        ON (jual.id_jual = jual_detail.id_jual)
	INNER JOIN nota_siap_kirim_detail 
		ON (jual_detail.id_jual_detail = nota_siap_kirim_detail.id_jual_detail)
WHERE jual.id_pelanggan=" .$row['id_pelanggan']);
$row3=mysql_fetch_array($sql3);
$jumlah_nota=$row3['jumlah_nota'];
		$sql3=mysql_query("SELECT SUM(jumlah) AS jumlah_bayar
FROM
    bayar_nota_jual
    INNER JOIN jual 
        ON (bayar_nota_jual.no_nota_jual = jual.invoice)
WHERE jual.id_pelanggan=" .$row['id_pelanggan']);
$row3=mysql_fetch_array($sql3);
$jumlah_gantung=$jumlah_nota-$row3['jumlah_bayar'];
$sql4=mysql_query("SELECT * FROM jual WHERE invoice NOT IN (SELECT no_nota_jual FROM bayar_nota_jual WHERE STATUS=1) AND id_pelanggan=" .$row['id_pelanggan']);
$jml_nota=format_angka(mysql_num_rows($sql4));
(($row['plafon']-$jumlah_gantung) < $r['total_jual'] ? $style="color:red" : $style="");

		echo '<tr>
				<td align="center"><input style="width: 20px; height: 20px;" type="checkbox" id="id_jual" name="id_jual[]" value="' .$row['id_jual']. '"></td>
				<td align="center"><div style="min-width:70px">' .date("d-m-Y",strtotime($row['tgl_nota'])). '</div></td>
				<td align="center"><div style="min-width:70px">' .$row['invoice']. '</div></td>
				<td align="center"><div style="min-width:70px">' .$row['nama_karyawan']. '</div></td>
				<td align="center"><div style="min-width:70px">' .$row['nama_pelanggan']. '</div></td>
				<td align="center"><div style="min-width:70px">' .format_uang($r['total_jual']). '</div></td>
			</tr>';
	}
?>
									</tbody>
								</table>
								</div>
								</form>
							</div>
							<div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="tab2">
							<div class="col-xs-12" style="text-align:right">
								<input type="text" id="datepicker" PlaceHolder="Bulan & Tahun" style="width:100px" value="<?php if (isset($_GET['cari'])) echo $_GET['cari'] ;?>" readonly></input>
								<input type="button" id="cari" onClick="cari()" value="Cari"></input>
								<input type="button" id="reset" onClick="reset()" value="Reset"></input>
							</div>
							<form method="post" onsubmit="return cek_valid2()">
			  <input type="hidden" name="batal_penagihan_post" value="true">
			  <center><input class="btn btn-primary" type="submit" value="Batalkan Penagihan"></center><br/>
								<a class="btn btn-danger btn-xs" style="width:10px;height:10px">&nbsp;</a><font color="red">Sisa Plafon < Jumlah Jual</font>
							  <div class="table-responsive">
							  <table id="table_siap_tagih" class="table table-bordered table-striped">
									<thead>
										<tr>
											<th>Pilih</th>
											<th>Tgl Tagih</th>
											<th>Jatuh Tempo</th>
											<th>Nama Pelanggan</th>
											<th>Jml Jual (Rp)</th>
											<th>Debt Collector</th>
											<th>Total Bayar (Rp)</th>
											<th>Status</th>
											<th>Janji Berikutnya</th>
										</tr>
									</thead>
									<tbody>
<?php
if (isset($_GET['cari'])){
	$tgl = explode("-", $_GET['cari']);
	$bln = $tgl[0];	$thn = $tgl[1];
	$val="MONTH(tanggal_tagih)=$bln AND YEAR(tanggal_tagih)=$thn";
} else {
	$val="status_tagih<>2";
}

	$sql=mysql_query("SELECT *,SUM(bayar) AS bayar
FROM
    penagihan
    INNER JOIN karyawan 
        ON (penagihan.id_karyawan = karyawan.id_karyawan)
    INNER JOIN penagihan_detail 
        ON (penagihan.id_penagihan = penagihan_detail.id_penagihan)
    INNER JOIN jual 
        ON (penagihan_detail.id_jual = jual.id_jual)
    INNER JOIN pelanggan 
        ON (jual.id_pelanggan = pelanggan.id_pelanggan)
	INNER JOIN jual_detail 
        ON (jual.id_jual = jual_detail.id_jual)
    INNER JOIN harga_jual_kredit 
        ON (jual_detail.id_harga_jual = harga_jual_kredit.id_harga_jual)
WHERE $val
GROUP BY penagihan.id_penagihan,jual.id_jual");
	while ($row=mysql_fetch_array($sql)){
	$sql2=mysql_query("SELECT (qty_ambil*harga) AS total
FROM
    jual_detail
    INNER JOIN nota_siap_kirim_detail 
        ON (jual_detail.id_jual_detail = nota_siap_kirim_detail.id_jual_detail)
WHERE id_jual=" .$row['id_jual']);
$total_jual=0;
	while ($row2=mysql_fetch_array($sql2)){
		$total_jual+=$row2['total'];
	}
	$status='';
	if ($row['status_bayar']=='0') $status='BELUM BAYAR';
	if ($row['status_bayar']=='1') $status='CICIL';
	if ($row['status_bayar']=='2') $status='SUDAH LUNAS';
	$tgl_jt=date('Y/m/d',strtotime($row["tgl_nota"]. '+' .$row['hari']. ' days'));
	($row['tgl_janji_next']=='' ? $tgl_jb='' : $tgl_jb=date('d-m-Y',strtotime($row['tgl_janji_next'])));
		echo '<tr>
				<td align="center"><input style="width: 20px; height: 20px;" type="checkbox" id="id_penagihan" name="id_penagihan[]" value="' .$row['id_penagihan']. '"></td>
				<td align="center"><a href="?page=penagihan&mode=dalam_kota_2&id=' .$row['id_penagihan']. '"><div style="min-width:70px">' .date("d-m-Y",strtotime($row['tanggal_tagih'])). '</div></a></td>
				<td align="center"><a href="?page=penagihan&mode=dalam_kota_2&id=' .$row['id_penagihan']. '"><div style="min-width:70px">' .date("d-m-Y",strtotime($tgl_jt)). '</div></a></td>
				<td align="center"><a href="?page=penagihan&mode=dalam_kota_2&id=' .$row['id_penagihan']. '"><div style="min-width:70px">' .$row['nama_pelanggan']. '</div></a></td>
				<td align="center"><a href="?page=penagihan&mode=dalam_kota_2&id=' .$row['id_penagihan']. '"><div style="min-width:70px">' .format_uang($total_jual). '</div></a></td>
				<td align="center"><a href="?page=penagihan&mode=dalam_kota_2&id=' .$row['id_penagihan']. '"><div style="min-width:70px">' .$row['nama_karyawan']. '</div></a></td>
				<td align="center"><a href="?page=penagihan&mode=dalam_kota_2&id=' .$row['id_penagihan']. '"><div style="min-width:70px">' .format_uang($row['bayar']). '</div></a></td>
				<td align="center"><a href="?page=penagihan&mode=dalam_kota_2&id=' .$row['id_penagihan']. '"><div style="min-width:70px">' .$status. '</div></a></td>
				<td align="center"><a href="?page=penagihan&mode=dalam_kota_2&id=' .$row['id_penagihan']. '"><div style="min-width:70px">' .$tgl_jb. '</div></a></td>
			</tr>';
		
	}
?>										
									</tbody>
								</table>
								</div>
								</form>
							</div>
						  </div>
						</div>
			
					</div>
				</div>
			<div id="dummy"></div>
			</div>
			</div>
		</div>	
	</div>
</div>

<script>
function getBack(){
	AndroidFunction.closeApp();
}
function cari(){
	var tanggal = $('#datepicker').val();
	var url = "?page=penagihan&mode=dalam_kota&cari=" + tanggal;
	if (tanggal!='') window.location=url;
}
function reset(){
	var url = "?page=penagihan&mode=dalam_kota&reset";
	window.location=url;
}
function cek_valid(){
	var len = $('#table_belum_siap').find("input:checkbox:checked").length;
	if (len == 0){
		alert("Belum pilih nota.");
		return false;
	} else {
		return true;
	}
}
function cek_valid2(){
	var len = $('#table_siap_tagih').find("input:checkbox:checked").length;
	if (len == 0){
		alert("Belum pilih nota.");
		return false;
	} else {
		return true;
	}
}
$(document).ready(function(){
	$('#datepicker').datepicker({
		orientation: "bottom auto",
		format: "mm-yyyy",
		startView: 1,
		minViewMode: 1,
		autoclose: true
	});
	<?php if (isset($_GET['cari']) || isset($_GET['reset'])) echo "$('#tab2').click();" ;?>
})
</script>
