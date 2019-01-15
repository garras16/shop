<?php
date_default_timezone_set('Asia/Jakarta');
require_once('../../../assets/inc/config.php');
require_once('../../../assets/inc/publicfunc.php');
//if (! isset($_GET['id'])) die();
$id=explode(',',$_GET['id']);
$id_pelanggan=$_GET['id_pelanggan'];
?>
<div class="input-group">
    <span class="input-group-addon">
        <i class="fa fa-file fa-fw"></i>
    </span>
    <select id="select_retur" name="no_retur_beli" class="select2 form-control">
        <option value="" disabled="disabled" selected="selected">-= Pilih Retur Jual =-</option>
    <?php
			$sql=mysqli_query($con, "SELECT
    retur_jual.id_retur_jual
    , retur_jual.no_retur_jual
FROM
    retur_jual
    INNER JOIN jual 
        ON (retur_jual.id_jual = jual.id_jual)
WHERE status=1 AND id_pelanggan=$id_pelanggan AND no_retur_jual NOT IN (SELECT no_retur_jual FROM bayar_nota_jual_detail)");
			while($b=mysqli_fetch_array($sql)){
				if (in_array($b['no_retur_jual'], $id)){
					
				} else {
					$tmp_id_retur=$b['id_retur_jual'];
					$sql2=mysqli_query($con, "SELECT SUM(qty_masuk * harga_retur) AS jumlah FROM retur_jual_detail WHERE id_retur_jual=$tmp_id_retur");
					$b2=mysqli_fetch_array($sql2);
					if ($b2['jumlah']!=''){
						echo '<option data-jumlah="' .$b2['jumlah']. '" value="' .$b['no_retur_jual']. '">' .$b['no_retur_jual']. ' | Rp ' .format_uang($b2['jumlah']). '</option>';
					}
				}
			}
		?>
    </select>
    <span class="input-group-addon">
        <i class="fa fa-star fa-fw" style="color:red"></i>
    </span>
</div>

<script>
    $(document).ready(function () {
        $('#select_retur').select2(
            {placeholderOption: "first", allowClear: true, width: '100%'}
        );
    });
</script>