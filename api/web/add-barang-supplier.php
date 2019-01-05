<?php
date_default_timezone_set('Asia/Jakarta');
require_once('../../assets/inc/config.php');

$id=$_GET['id'];

?>
<input type="hidden" name="id_barang" value="<?php echo $id ?>" />
<select class="select2 form-control" id="select_supplier" name="id_supplier" required>
	<option value="" disabled selected>Pilih Supplier</option>
	<?php 
		$brg=mysqli_query($con, "SELECT id_supplier,nama_supplier FROM supplier WHERE id_supplier NOT IN (SELECT id_supplier FROM barang_supplier WHERE id_barang=$id)");
		while($b=mysqli_fetch_array($brg)){
	?>	
		<option value="<?php echo $b['id_supplier']; ?>"><?php echo $b['nama_supplier'];?></option>
	<?php 
		}
	?>
</select>

<script>
$(".select2").select2({
	placeholderOption: "first",
	allowClear: true,
	width: '100%'
});
</script>