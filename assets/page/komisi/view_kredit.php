<?php
$sql = "SELECT MAX(hari) AS MaxVal FROM komisi_kredit WHERE id_komisi=$id";
$q = mysqli_fetch_array(mysqli_query($con, $sql));
$MaxVal = $q['MaxVal'];

if (isset($tambah_komisi_kredit_post)){
	if ($hari > $MaxVal ){
		$sql = "INSERT INTO komisi_kredit VALUES(null,$id,$kredit,$hari)";
		$q = mysqli_query($con, $sql);
		if ($q){
			_buat_pesan("Input Berhasil","green");
		} else {
			_buat_pesan("Input Gagal","red");
		}
	} else {
		_buat_pesan("Input Gagal","red");
	}
	_direct("?page=komisi&mode=view_kredit");
}
if (isset($edit_komisi_kredit_post)){
	$sql = "UPDATE komisi_kredit SET kredit=$kredit,hari=$hari WHERE id_komisi_kredit=$id_komisi_kredit";
	$q = mysqli_query($con, $sql);
	if ($q){
		_buat_pesan("Input Berhasil","green");
	} else {
		_buat_pesan("Input Gagal","red");
	}
	_direct("?page=komisi&mode=view_kredit");
}
$sql=mysqli_query($con, "SELECT
    komisi_kredit.id_komisi_kredit
    , komisi_kredit.id_komisi
    , komisi_kredit.kredit
    , komisi_kredit.hari
    , komisi.id_karyawan
    , karyawan.nama_karyawan
FROM
    komisi
    INNER JOIN komisi_kredit 
        ON (komisi.id_komisi = komisi_kredit.id_komisi)
    INNER JOIN karyawan 
        ON (komisi.id_karyawan = karyawan.id_karyawan)
WHERE komisi_kredit.id_komisi=$id");
$row=mysqli_fetch_array($sql);
?>
<!-- page content -->
<div class="right_col" role="main">
	<div class="">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<h3>LIHAT KOMISI PENJUALAN KREDIT</h3>
						<?php
							if (isset($pesan)){
								echo '<span class="badge bg-' .$warna. '">' .$pesan. '</span><br/><br/>';
							}
							?>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
			
			<a class="btn btn-danger" href="javascript:history.back()"><i class="fa fa-arrow-left"></i> Kembali</a><br/><br/>
			<!--<a class="btn btn-danger" href="?page=komisi&mode=view_detail&id="<?php echo $row['id_karyawan'] ?>""><i class="fa fa-arrow-left"></i> Kembali</a><br/><br/>-->
			
			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
				<input class="form-control" placeholder="<?php echo $row['nama_karyawan'] ?>" readonly>
			</div>
			<br/><br/>
			<div class="col-md-12 bg-blue">
				<div class="col-md-6">
					<h5>Komisi Jual Kredit (%)</h5>
				</div>
				<div class="col-md-5">
					<h5>Jumlah Hari Kredit Maks</h5>
				</div>
				<div class="col-md-1">
					<h5></h5>
				</div>
			</div>
			<div class="clearfix"></div><br/>
			<div id="kredit_content" class="col-md-12">
				
			</div>
			<div id="input_kredit" class="col-md-12">
				
			</div>
			<div class="clearfix"></div><br/>
			<div class="col-md-12 text-right">
				<a id="tambah" class="btn btn-primary" onClick="addRow()"><i class="fa fa-plus"></i> Tambah</a>
			</div>
			</div>
			</div>
			</div>
		</div>
		<!-- /page content -->

        
      </div>
    </div>
<script>
function addRow(){
	$('#input_kredit').load('assets/page/komisi/input_kredit.php?id=<?php echo $id ?>');
	$('#tambah').attr('style','display:none');
}
function clearRow(){
	$('#input_kredit').empty();
	$('#tambah').removeAttr('style');
}
$(document).ready(function(){
	$('#kredit_content').load('assets/page/komisi/content_kredit.php?id=<?php echo $id ?>');
});
</script>