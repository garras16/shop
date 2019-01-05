<?php
date_default_timezone_set('Asia/Jakarta');
require_once('../../assets/inc/config.php');
$USERNAME=$_POST['USERNAME'];
$PASSWORD=$_POST['PASSWORD'];
$sql=mysql_query("SELECT * FROM users WHERE user='$USERNAME' AND password='$PASSWORD'");
if (mysql_num_rows($sql) > 0){
	echo "sukses";
} else {
	echo "gagal";
}
?>