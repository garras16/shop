<?php
date_default_timezone_set('Asia/Jakarta');
require_once('../../../assets/inc/config.php');
require_once('../../../assets/inc/publicfunc.php');
//if (! isset($_GET['id'])) die();
$id=explode(',',$_GET['id']);
$id_supplier=$_GET['id_supplier'];
?>
<div class="input-group">
	<span class="input-group-addon"><i class="fa fa-file fa-fw"></i></span>
	<select id="select_retur" name="no_retur_beli" class="select2 form-control">
		<option value="" disabled selected>-= Pilih Retur Beli =-</option>
		<?php
			$sql=mysqli_query($con, "SELECT
    retur_beli.id_retur_beli
    , retur_beli.no_retur_beli
FROM
    retur_beli
    INNER JOIN beli 
        ON (retur_beli.id_beli = beli.id_beli)
WHERE STATUS=1 AND id_supplier=$id_supplier AND no_retur_beli NOT IN (SELECT no_retur_beli FROM bayar_nota_beli_detail)");
			while($b=mysqli_fetch_array($sql)){
				if (in_array($b['no_retur_beli'], $id)){
					
				} else {
					$tmp_id_retur=$b['id_retur_beli'];
					$sql2=mysqli_query($con, "SELECT SUM(qty_keluar * harga_retur) AS jumlah FROM retur_beli_detail WHERE id_retur_beli=$tmp_id_retur");
					$b2=mysqli_fetch_array($sql2);
					if ($b2['jumlah']!=''){
						echo '<option data-jumlah="' .$b2['jumlah']. '" value="' .$b['no_retur_beli']. '">' .$b['no_retur_beli']. ' | Rp ' .format_uang($b2['jumlah']). '</option>';
					}
				}
			}
		?>
	</select>
	<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
</div>

<script>
$(document).ready(function(){
	$('#select_retur').select2({
		placeholderOption: "first",
		allowClear: true,
		width: '100%'
	});
});
</script>