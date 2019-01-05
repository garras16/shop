<?php
require_once('../../../assets/inc/config.php');
$id=$_GET['id'];
$sql=mysqli_query($con, "DELETE FROM komisi WHERE id_komisi='$id'");
?>