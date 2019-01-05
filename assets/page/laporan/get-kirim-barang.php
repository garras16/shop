<?php
date_default_timezone_set('Asia/Jakarta');
require_once('../../inc/config.php');
require_once('../../inc/publicfunc.php');

if (isset($_GET['id'])){
	$id=$_GET['id'];
} else {
	die();
}
$sql=mysqli_query($con, "SELECT invoice,pengiriman.id_jual,pengiriman.status,tanggal_kirim,pengiriman.jenis,pengiriman.id_karyawan,pengiriman.id_ekspedisi,berat,volume,tarif
FROM
    pengiriman
    INNER JOIN karyawan 
        ON (pengiriman.id_karyawan = karyawan.id_karyawan)
    LEFT JOIN ekspedisi 
        ON (pengiriman.id_ekspedisi = ekspedisi.id_ekspedisi)
    INNER JOIN jual 
        ON (pengiriman.id_jual = jual.id_jual)
WHERE id_pengiriman=$id");
$row=mysqli_fetch_array($sql);
($row['id_ekspedisi']=='' ? $locked='disabled' : $locked='');
($row['jenis']=='LUAR KOTA' ? $lock='disabled' : $lock='');
if ($row['id_ekspedisi']!=''){
	if ($row['berat']==''){
		$tipe="volume";
		$val=$row['volume'];
	} else {
		$tipe="berat";
		$val=$row['berat'];
	}
}
?>
<input type="hidden" name="id_jual" value="<?php echo $row['id_jual'] ?>">
<input type="hidden" name="id_pengiriman" value="<?php echo $id ?>">
<div class="input-group">
	<span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
	<input class="form-control" id="tanggal" name="tanggal" placeholder="Tanggal Kirim" value="<?php echo date("d-m-Y",strtotime($row['tanggal_kirim'])) ?>" readonly>
	<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
</div>
<div class="input-group">
	<span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
	<select class="form-control select2" id="select_karyawan" name="id_karyawan" required>
		<option value="" disabled selected>Pilih Karyawan</option>
<?php
	$sql2=mysqli_query($con, "SELECT * FROM karyawan WHERE status=1");
	while ($row2=mysqli_fetch_array($sql2)){
		echo '<option value="' .$row2['id_karyawan']. '">' .$row2['nama_karyawan']. '</option>';
	}
?>
	</select>
	<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
</div>
<div class="input-group">
	<span class="input-group-addon"><i class="fa fa-map-marker fa-fw"></i></span>
	<select class="form-control select2" id="select_jenis" name="jenis">
		<option value="DALAM KOTA" selected>Dalam Kota</option>
		<option value="LUAR KOTA" selected>Luar Kota</option>
	</select>
	<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
</div>
<div class="input-group">
	<span class="input-group-addon"><i class="fa fa-truck fa-fw"></i></span>
	<select class="form-control select2" id="select_ekspedisi" name="id_ekspedisi" <?php echo $lock ?> >
		<option value="" selected>Kirim Sendiri</option>
<?php
	$sql2=mysqli_query($con, "SELECT * FROM ekspedisi WHERE status=1");
	while ($row2=mysqli_fetch_array($sql2)){
		echo '<option value="' .$row2['id_ekspedisi']. '">' .$row2['nama_ekspedisi']. '</option>';
	}
?>
	</select>
	<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
</div>
<div class="input-group">
	<span class="input-group-addon"><i class="fa fa-anchor fa-fw"></i></span>
	<select class="form-control locked" id="berat_volume" name="berat_volume" <?php echo $locked ?> >
		<option value="berat" selected>BERAT (GRAM)</option>
		<option value="volume">VOLUME (CM3)</option>
	</select>
	<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
</div>
<div class="input-group">
	<span class="input-group-addon"><i class="fa fa-info fa-fw"></i></span>
	<input class="form-control locked mask" id="val_berat_volume" type="text" name="val_berat_volume" placeholder="Berat/Volume" <?php echo $locked ?> >
	<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
</div>
<div class="input-group">
	<span class="input-group-addon"><i class="fa fa-dollar fa-fw"></i></span>
	<input class="form-control locked mask" id="tarif" type="tel" name="tarif" placeholder="Tarif (Rp)" value="<?php echo $row['tarif'] ?>" <?php echo $locked ?> >
	<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
</div>

<script>
$('#tanggal').daterangepicker({
	locale: {
		format: 'DD-MM-YYYY'
	},
	singleDatePicker: true
});;
$(".select2").select2({
	placeholderOption: "first",
	allowClear: true,
	width: '100%'
});
$('.mask').inputmask('decimal', {autoGroup: true, allowMinus: false, groupSeparator: '.', rightAlign: false, autoUnmask: true, removeMaskOnSubmit: true});
$("#select_jenis").val("<?php echo $row['jenis'] ?>").trigger("change");
$("#select_karyawan").val("<?php echo $row['id_karyawan'] ?>").trigger("change");
$("#select_ekspedisi").val("<?php echo $row['id_ekspedisi'] ?>").trigger("change");
<?php 
if(isset($tipe)) {
	echo '$("#berat_volume").val("' .$tipe. '");';
	echo '$("#val_berat_volume").val("' .$val. '");';
}
?>
$("#select_jenis").on("change", function(e){
	if ($(this).val()=='DALAM KOTA'){
		$("#select_ekspedisi").attr('disabled','disabled');
		$(".locked").attr('disabled','disabled');
	} else {
		$("#select_ekspedisi").removeAttr('disabled');
		$(".locked").removeAttr('disabled');
	}
})
$("#select_ekspedisi").on("change", function(e){
	if ($(this).val()==''){
		$(".locked").attr('disabled','disabled');
	} else {
		$(".locked").removeAttr('disabled');
	}
})
</script>