<?php
date_default_timezone_set('Asia/Jakarta');
require_once('../../assets/inc/config.php');

$id=$_GET['id'];

?>
<input type="hidden" name="id_barang" value="<?php echo $id ?>"/>
<select
    class="select2 form-control"
    id="select_supplier"
    name="id_supplier"
    required="required">
    <option value="" disabled="disabled" selected="selected">Pilih Supplier</option>
    <?php 
		$brg=mysqli_query($con, "SELECT id_supplier,nama_supplier FROM supplier WHERE id_supplier IN (SELECT id_supplier FROM barang_supplier WHERE id_barang=$id)");
		while($b=mysqli_fetch_array($brg)){
			$spl=$b['id_supplier'];
			$q=mysqli_query($con, "SELECT id_barang_supplier FROM barang_supplier WHERE id_barang=$id AND id_supplier=$spl AND id_barang_supplier NOT IN (SELECT id_barang_supplier FROM harga_jual)");
			if (mysqli_num_rows($q)>0){
				echo '<option value="' .$b['id_supplier']. '">' .$b['nama_supplier']. '</option>';
			}
		}
	?>

</select>