<?php
date_default_timezone_set('Asia/Jakarta');
require_once('../../assets/inc/config.php');
require_once('../../assets/inc/publicfunc.php');

if (isset($_GET['id'])){
	$id=$_GET['id'];
} else {
	die();
}
$sql=mysqli_query($con, "SELECT * 
FROM
    gudang
    INNER JOIN rak 
        ON (gudang.id_gudang = rak.id_gudang) WHERE id_rak='$id'");
$row=mysqli_fetch_array($sql);
?>
<input type="hidden" name="id_rak" value="<?php echo $id ?>">
<input type="hidden" name="id_gudang" value="<?php echo $row['id_gudang'] ?>">
<div class="input-group">
	<span class="input-group-addon" style="padding: 2px 12px;"><i class="fa fa-building fa-fw"></i><br><small>Gudang</small></span>
	<select class="form-control" id="select_gudang" name="id_gudang" required>
		<option value="" disabled selected>Pilih Gudang</option>
		<?php
			$sql=mysqli_query($con, "SELECT * FROM gudang");
			while($rows=mysqli_fetch_array($sql)){
				echo '<option value="' .$rows['id_gudang']. '"' .($rows['id_gudang']==$row['id_gudang'] ? ' selected' : '').  '>' .$rows['nama_gudang']. '</option>';
			}
		?>
	</select>
	<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
</div>
<div class="input-group">
	<span class="input-group-addon"><i class="fa fa-tag fa-fw" style="width: 43px;"></i><br><small>Rak</small></span>
	<input class="form-control" style="padding: 20px 15px;" placeHolder="Nama Rak" name="nama_rak" value="<?php echo $row['nama_rak']; ?>" maxlength="20" required>
	<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
</div>
