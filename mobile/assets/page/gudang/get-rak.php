<?php
$id=$_GET['id'];
require_once('../../../assets/inc/config.php');
$sql=mysqli_query($con, "SELECT * 
FROM
    gudang
    INNER JOIN rak 
        ON (gudang.id_gudang = rak.id_gudang) WHERE nama_rak='$id'");
if (mysqli_num_rows($sql) > 0 ){
$r=mysqli_fetch_array($sql);
?>
	<input type="hidden" name="id_gudang" value="<?php echo $r['id_gudang'] ?>" >
	<input type="hidden" name="id_rak" value="<?php echo $r['id_rak'] ?>" >
	<div id="div_gudang" class="input-group">
		<span class="input-group-addon"><i class="fa fa-building fa-fw"></i></span>
		<input class="form-control" id="gudang" type="text" name="gudang" placeholder="Gudang" value="<?php echo $r['nama_gudang'] ?>" maxlength="50" readonly>
		<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
	</div>
	<div id="div_rak" class="input-group">
		<span class="input-group-addon"><i class="fa fa-tasks fa-fw"></i></span>
		<input class="form-control" id="rak" type="text" name="rak" placeholder="Rak" value="<?php echo $r['nama_rak'] ?>" maxlength="50" readonly>
		<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
	</div>
<?php
}
?>
