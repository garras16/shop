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
echo $r['id_rak'];
}
?>