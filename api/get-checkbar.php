<?php
    date_default_timezone_set('Asia/Jakarta');
    require_once('../assets/inc/config.php');
    $barcode=$_POST['barcode'];
    $sql=mysqli_query($con, "SELECT nama FROM customer WHERE barcode='$barcode'");
    $row=mysqli_fetch_array($sql);
    $nama=$row["nama"];
    echo $nama;
?>