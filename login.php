<?php
session_start();
date_default_timezone_set('Asia/Jakarta');
require_once('assets/inc/config.php');
require_once('assets/inc/publicfunc.php');

if(isset($_GET['do'])){
	if ($_GET['do']=='logout') {
		session_destroy();
	}
}

if (isset($_POST['login'])){
	$user=strip_word_html(strtoupper($_POST['username']));
	$pass=strip_word_html(strtoupper($_POST['password']));
	$protection=false;
	if (substr($user,-2)=="-2"){
		$user=substr($user,0,count($user)-3);
		$protection=true;
	}
	$sql=mysql_query("SELECT * FROM users WHERE user='$user' AND password='$pass'");
	$row=mysql_fetch_array($sql);
	if (mysql_num_rows($sql) > 0){
		$_SESSION['user_shop']=$user;
		$_SESSION['user']=$user;
		$_SESSION['posisi']=$row['posisi'];
		$_SESSION['id_karyawan']=$row['id_karyawan'];
		$_SESSION['protection']=$protection;
		$_SESSION['timestamp_shop']=time();
		_direct("index.php");
	} else {
		$pesan="Login gagal. Coba lagi.";
		$warna="red";
	}
}

if(isset($_SESSION['user_shop'])) _direct("index.php");
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>DISTRIBUTOR | LOGIN</title>

    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="vendors/animate.css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="css/custom.min.css" rel="stylesheet">
  </head>

  <body class="login">
    <div>

      <div class="login_wrapper">
        <div class="animate form login_form text-center">
			<?php
				if (isset($pesan)){
					echo '<span class="badge bg-' .$warna. '">' .$pesan. '</span>';
				}
			?>
            <form action="" method="post">
			  <input type="hidden" name="login" value="true">
              <h1>Login</h1>
			  <div class="form-group">
				  <div class="input-group">
					<span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
					<input type="text" class="form-control" name="username" placeholder="Username" autocomplete="off"required />
					<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
				  </div>
				  <div class="input-group">
					<span class="input-group-addon"><i class="fa fa-lock fa-fw"></i></span>
					<input type="password" class="form-control" name="password" placeholder="Password" required />
					<span class="input-group-addon"><i class="fa fa-star fa-fw" style="color:red"></i></span>
				  </div>
			  </div>
              <div>
                <button type="submit" class="btn btn-default">Log in</button>
              </div>
            </form>

              <div class="clearfix"></div>

              <div class="separator">
                <div class="clearfix"></div>
                <br />

                <div>
                  <p>©2018 All Rights Reserved.</p>
                </div>
              </div>
        </div>

        
      </div>
    </div>
  </body>
</html>
