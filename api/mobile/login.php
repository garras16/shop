<?php
date_default_timezone_set('Asia/Jakarta');
require_once('../../assets/inc/config.php');
$USERNAME=$_POST['USERNAME'];
$PASSWORD=$_POST['PASSWORD'];
$sql=mysqli_query($con, "SELECT * FROM users WHERE user='$USERNAME' AND password='$PASSWORD'");
if (mysqli_num_rows($sql) > 0){
	echo "sukses";
} else {
	echo "gagal";
}
?>