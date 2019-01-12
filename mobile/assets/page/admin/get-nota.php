<?php
	session_start();
	date_default_timezone_set('Asia/Jakarta');
	require_once('../../../assets/inc/config.php');
	require_once('../../../assets/inc/publicfunc.php');
	if (!isset($_GET['id'])) die();
	$invoice=$_GET['id'];
	$id_karyawan=$_SESSION['id_karyawan'];

	$sql = mysqli_query($con, "SELECT jual.id_jual,invoice,tgl_nota,tenor,nama_karyawan,pelanggan.id_pelanggan,nama_pelanggan,(qty_ambil*(harga-diskon_rp-diskon_rp_2-diskon_rp_3)) AS total
			FROM
				jual
				INNER JOIN jual_detail 
					ON (jual.id_jual = jual_detail.id_jual)
				INNER JOIN pelanggan 
					ON (jual.id_pelanggan = pelanggan.id_pelanggan)
				INNER JOIN karyawan 
					ON (jual.id_karyawan = karyawan.id_karyawan)
				INNER JOIN nota_siap_kirim_detail 
					ON (jual_detail.id_jual_detail = nota_siap_kirim_detail.id_jual_detail)
			WHERE invoice='$invoice'");
	if (mysqli_num_rows($sql)=='0') die();
	$total_jual=0;
		while ($row=mysqli_fetch_array($sql)){
			$total_jual+=$row['total'];
			$id_jual=$row['id_jual'];
			$tgl_nota=$row['tgl_nota'];
			$tenor=$row['tenor'];
			$invoice=$row['invoice'];
			$nama_sales=$row['nama_karyawan'];
			$nama_pelanggan=$row['nama_pelanggan'];
			$id_pelanggan=$row['id_pelanggan'];
		}
	if ($total_jual==0) {
		echo '<script>AndroidFunction.showToast("Total jual Rp. 0. Nota tidak dapat masuk ke daftar penagihan.")</script>';
		die();
	}
	$sql2=mysqli_query($con, "SELECT nama_karyawan
			FROM
				pengiriman
				INNER JOIN karyawan 
					ON (pengiriman.id_karyawan = karyawan.id_karyawan)
			WHERE id_jual=$id_jual");
	$row2=mysqli_fetch_array($sql2);
	$nama_driver=$row2['nama_karyawan'];
			
	$sql2=mysqli_query($con, "SELECT nama_karyawan
			FROM
				karyawan
			WHERE id_karyawan=$id_karyawan");
					$row2=mysqli_fetch_array($sql2);
					$nama_admin=$row2['nama_karyawan'];
					
					$tgl_jt_tempo=date('Y-m-d', strtotime($tgl_nota. ' + ' .$tenor. ' days'));
					(strtotime($tgl_jt_tempo)<strtotime(date("Y-m-d")) ? $color="color: red" : $color="");
					
					$sql2=mysqli_query($con, "SELECT SUM(qty*(harga-diskon_rp-diskon_rp_2-diskon_rp_3)) AS jumlah_nota
			FROM
				jual
				INNER JOIN jual_detail 
					ON (jual.id_jual = jual_detail.id_jual)
			WHERE jual.id_jual=$id_jual");
	$row2=mysqli_fetch_array($sql2);
	$jumlah_nota=$row2['jumlah_nota'];

	$sql2=mysqli_query($con, "SELECT *
			FROM
				bayar_nota_jual
				INNER JOIN jual 
					ON (bayar_nota_jual.no_nota_jual = jual.invoice)
			WHERE jual.id_jual=$id_jual");
	$jumlah_bayar=0;
	while ($row2=mysqli_fetch_array($sql2)){
		if ($row2['jenis']=='Giro'){
			if ($row2['status_giro']=='1') $jumlah_bayar+=$row2['jumlah'];
		} else {
			$jumlah_bayar+=$row2['jumlah'];
		}
	}

	$sql2=mysqli_query($con, "SELECT *,SUM(bayar) AS jumlah_bayar
			FROM
				penagihan_detail
				INNER JOIN jual 
					ON (penagihan_detail.id_jual = jual.id_jual)
			WHERE jual.id_jual=$id_jual");
	while ($row2=mysqli_fetch_array($sql2)){
		if ($row2['jenis']=='Giro'){
			if ($row2['status_giro']=='1') $jumlah_bayar+=$row2['bayar'];
		} else {
			$jumlah_bayar+=$row2['bayar'];
		}
	}

	$sql2=mysqli_query($con, "SELECT SUM(jumlah_retur) AS jumlah_bayar
			FROM
				penagihan_detail
				INNER JOIN penagihan_retur_detail 
					ON (penagihan_detail.id_penagihan_detail = penagihan_retur_detail.id_penagihan_detail)
			WHERE id_jual=" .$id_jual);
	$row2=mysqli_fetch_array($sql2);
	$jumlah_bayar+=$row2['jumlah_bayar'];

	$sisa_piutang=$jumlah_nota-$jumlah_bayar;
	if ($sisa_piutang==0) {
		echo '<script>AndroidFunction.showToast("Nota sudah lunas.")</script>';
		die();
	}
			$sql2=mysqli_query($con, "SELECT MAX(tgl_janji_next) AS tgl_janji FROM penagihan_detail WHERE id_jual=$id_jual");
			$row2=mysqli_fetch_array($sql2);
			($row2['tgl_janji']=='' ? $tgl_janji='' : $tgl_janji=date("d-m-Y",strtotime($row2['tgl_janji'])));
			echo '<tr id="list">
					<td style="' .$color. '">' .date("d-m-Y",strtotime($tgl_nota)). '</td>
					<td style="' .$color. '">' .$invoice. '</td>
					<td style="' .$color. '">' .$nama_sales. '</td>
					<td style="' .$color. '">' .$nama_driver. '</td>
					<td style="' .$color. '">' .$nama_pelanggan. '</td>
					<td style="' .$color. '">' .$nama_admin. '</td>
					<td style="' .$color. '">' .format_uang($total_jual). '</td>
					<td style="' .$color. '">' .date('d-m-Y',strtotime($tgl_jt_tempo)). '</td>
					<td style="' .$color. '">' .$tgl_janji. '</td>
					<td style="' .$color. '">' .format_uang($sisa_piutang). '</td>
					<td><a href="#" class="btn btn-primary btn-xs remove_cart">Hapus</a></td>
					<input type="hidden" id="id_jual" name="id_jual[]" value="' .$id_jual. '">
				</tr>';
?>

<script>
    $(document).ready(function () {});
</script>