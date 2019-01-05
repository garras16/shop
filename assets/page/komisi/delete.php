<?php
require_once('../../../assets/inc/config.php');
$id=$_GET['id'];
$sql=mysql_query("DELETE FROM komisi WHERE id_komisi='$id'");
?>