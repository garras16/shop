<?php
	if (!isset($_SESSION['user_shop'])) {
		_direct("login.php");
		exit();
	}
	if(time() - $_SESSION['timestamp_shop'] > 60*60) {
		session_destroy();
		header("Location: login.php");
		exit;
	} else {
		$_SESSION['timestamp_shop'] = time();
	}

	if ($_SESSION['posisi']=='DIREKSI'){
		$sql=mysql_query("SELECT * FROM penagihan WHERE status_tagih<>2 AND DATE(tanggal_tagih) <> DATE(NOW())");
		if (mysql_num_rows($sql)>0){
			if (strpos($_SERVER['REQUEST_URI'], 'page=penagihan&mode=penagihan') == false) _direct("?page=penagihan&mode=penagihan");
		}
	}
?>