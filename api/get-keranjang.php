<?php
	date_default_timezone_set('Asia/Jakarta');
	require_once('../assets/inc/config.php');
	require_once('../assets/inc/publicfunc.php');
	$id_session=$_POST['id_session'];
	$sql=mysqli_query($con, "SELECT * FROM keranjang WHERE id_session='$id_session'");
	$response["datas"] = array();
	while ($row=mysqli_fetch_array($sql)){
		$data=array();
		$data["id_keranjang"]=$row["id_keranjang"];
		$data["id_produk"]=$row["id_produk"];
		$id_produk=$row["id_produk"];
		$sql2=mysqli_query($con, "SELECT * FROM barang WHERE id_barang='$id_produk'");
		$row2=mysqli_fetch_array($sql2);
		$data["nama_barang"]=$row2["nama_barang"];
		$data["harga"]=$row["harga"];
		$data["jumlah"]=$row["jumlah"];
		$data["total"]=$row["jumlah"]*$row["harga"];
		$data["id_session"]=$row["id_session"];
		$response["success"]=1;
		array_push($response["datas"], $data);
	}
	$sql=mysqli_query($con, "SELECT SUM(jumlah*harga) AS total FROM keranjang WHERE id_session='$id_session'");
	$response["total_keranjang"] = array();
	$row=mysqli_fetch_array($sql);
	$data=array();
	$data["total_rupiah"]="Rp. " .number_format($row["total"], 0, ",", ".");
	$data["total_data"]=$row["total"];
	array_push($response["total_keranjang"], $data);
	echo json_encode($response);
?>