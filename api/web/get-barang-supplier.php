<?php
    date_default_timezone_set('Asia/Jakarta');
    require_once('../../assets/inc/config.php');

    $id=$_GET['id'];

    $sql=mysqli_query($con, "SELECT
        supplier.nama_supplier 
    FROM
        barang_supplier
        INNER JOIN supplier 
            ON (barang_supplier.id_supplier = supplier.id_supplier)
        INNER JOIN barang 
            ON (barang_supplier.id_barang = barang.id_barang) WHERE barang_supplier.id_barang=$id");

    echo '<table id="table1" class="table">
        <tbody>';
    while ($row=mysqli_fetch_array($sql)){
        echo '<tr><td>' .$row['nama_supplier']. '</td></tr>';
    }
    echo ' </tbody></table>';
?>