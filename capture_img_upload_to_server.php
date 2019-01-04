<?php
if($_SERVER['REQUEST_METHOD'] == 'POST') { 
$DefaultId = 0; 
$ImageData = $_POST['image_path']; 
$ImageName = $_POST['image_name']; 
$DefaultId = 1;
$ImagePath = "images/uploader/$ImageName";

file_put_contents($ImagePath,base64_decode($ImageData)); 
echo "Your Image Has Been Uploaded.";
}
?>