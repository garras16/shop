<?php
    date_default_timezone_set('Asia/Jakarta');
    require_once('../assets/inc/config.php');
    $sql=mysqli_query($con, "SELECT COUNT(id_jual) AS MaxID FROM jual WHERE MONTH(tgl_nota)=" .date('m'). " AND YEAR(tgl_nota)=" .date('Y'). "");
    $row=mysqli_fetch_array($sql);
    $id=$row["MaxID"]+1;
    $num=sprintf('%04d', $id);
    $bln=Array("A","B","C","D","E","F","G","H","I","J","K","L");
    $inv="INV-" .date('y') . $bln[date('m')-1] . $num;
    echo $inv;
?>