<?php
date_default_timezone_set('Asia/Jakarta');
$basefolder="";
$dbhost="localhost";
$dbuser="root";
$dbpass="";
$dbname="shop";
$base_url="http://localhost/teknobus/";
$con=mysqli_connect($dbhost,$dbuser,$dbpass,$dbname) or die(mysql_error());
// $rs=mysql_select_db($dbname);
$pathfolder = "C:\xampp\htdocs";
?>