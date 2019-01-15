
<body class="nav-md" style="min-height:100%">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="index.php" class="site_title"><i class="fa fa-paw"></i> <span>ADMIN</span></a>
            </div>

            <div class="clearfix"></div>

            

            <br />
<!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
				<ul class="nav side-menu">
				  <li <?php echo ($page=='admin' ? ' class="active"' : '') ?> ><a><i class="fa fa-home"></i> ADMIN <span class="fa fa-chevron-down"></span></a>
					<ul class="nav child_menu" style="<?php echo ($page=='admin' ? 'display: block' : 'display: none') ?>">
						<li <?php echo ($page=='admin' && $mode=='penagihan' ? ' class="current-page"' : '') ?> ><a href="?page=admin&mode=penagihan">Penagihan</a></li>
						<li <?php echo ($page=='admin' && $mode=='setoran' ? ' class="current-page"' : '') ?> ><a href="?page=admin&mode=setoran">Setoran</a></li>
						<li <?php echo ($page=='admin' && $mode=='lap_histori_penagihan' ? ' class="current-page"' : '') ?> ><a href="?page=admin&mode=lap_histori_penagihan">Riwayat Penagihan</a></li>
					</ul>
				  </li>
                </ul>
                <ul class="nav side-menu">
				  <li <?php echo ($page=='gudang' ? ' class="active"' : '') ?> ><a><i class="fa fa-home"></i> GUDANG <span class="fa fa-chevron-down"></span></a>
					<ul class="nav child_menu" style="<?php echo ($page=='gudang' ? 'display: block' : 'display: none') ?>">
						<li <?php echo ($page=='gudang' && $mode=='konfirm_beli' ? ' class="current-page"' : '') ?> ><a href="?page=gudang&mode=konfirm_beli">Konfirmasi Pembelian</a></li>
						<li <?php echo ($page=='gudang' && $mode=='konfirm_retur_beli' ? ' class="current-page"' : '') ?> ><a href="?page=gudang&mode=konfirm_retur_beli">Konfirmasi Retur Beli</a></li>
						<li <?php echo ($page=='gudang' && $mode=='konfirm_jual' ? ' class="current-page"' : '') ?> ><a href="?page=gudang&mode=konfirm_jual">Konfirmasi Penjualan</a></li>
						<li <?php echo ($page=='gudang' && $mode=='konfirm_retur_jual' ? ' class="current-page"' : '') ?> ><a href="?page=gudang&mode=konfirm_retur_jual">Konfirmasi Retur Jual</a></li>
						<li <?php echo ($page=='gudang' && $mode=='batal_kirim' ? ' class="current-page"' : '') ?> ><a href="?page=gudang&mode=batal_kirim">Batal Kirim</a></li>
						<li <?php echo ($page=='gudang' && $mode=='stock_opname' ? ' class="current-page"' : '') ?> ><a href="?page=gudang&mode=stock_opname">Stock Opname</a></li>
					</ul>
				  </li>
                </ul>
				<ul class="nav side-menu">
				  <li <?php echo ($page=='sales' ? ' class="active"' : '') ?> ><a><i class="fa fa-home"></i> SALES <span class="fa fa-chevron-down"></span></a>
					<ul class="nav child_menu" style="<?php echo ($page=='sales' ? 'display: block' : 'display: none') ?>">
						<li <?php echo ($page=='sales' && $mode=='menu_penjualan' ? ' class="current-page"' : '') ?> ><a href="?page=sales&mode=menu_penjualan">Penjualan</a></li>
						<li <?php echo ($page=='sales' && $mode=='checkin' ? ' class="current-page"' : '') ?> ><a href="?page=sales&mode=checkin">Check In</a></li>
					</ul>
				  </li>
                </ul>
				<ul class="nav side-menu">
				  <li <?php echo ($page=='driver' ? ' class="active"' : '') ?> ><a><i class="fa fa-home"></i> DRIVER <span class="fa fa-chevron-down"></span></a>
					<ul class="nav child_menu" style="<?php echo ($page=='driver' ? 'display: block' : 'display: none') ?>">
						<li <?php echo ($page=='driver' && $mode=='barang_keluar' ? ' class="current-page"' : '') ?> ><a href="?page=driver&mode=barang_keluar">Barang Keluar</a></li>
					</ul>
				  </li>
                </ul>
				<ul class="nav side-menu">
				  <li <?php echo ($page=='collector' ? ' class="active"' : '') ?> ><a><i class="fa fa-home"></i> DEBT COLLECTOR <span class="fa fa-chevron-down"></span></a>
					<ul class="nav child_menu" style="<?php echo ($page=='collector' ? 'display: block' : 'display: none') ?>">
						<li <?php echo ($page=='collector' && $mode=='tagihan' ? ' class="current-page"' : '') ?> ><a href="?page=collector&mode=tagihan">Tagihan</a></li>
						<li <?php echo ($page=='collector' && $mode=='retur_jual' ? ' class="current-page"' : '') ?> ><a href="?page=collector&mode=retur_jual">Retur Jual</a></li>
					</ul>
				  </li>
                </ul>
				<ul class="nav side-menu">
					<li <?php echo ($page=='canvass_keluar' ? ' class="active"' : '') ?> ><a><i class="fa fa-home"></i> CANVASS <span class="fa fa-chevron-down"></span></a>
						<ul class="nav child_menu" style="<?php echo ($page=='canvass_keluar' ? 'display: block' : 'display: none') ?>">
							<li <?php echo ($page=='canvass_keluar' && $mode=='ambil_gudang' ? ' class="current-page"' : '') ?> ><a href="?page=canvass_keluar&mode=ambil_gudang">Mutasi Gudang Ke Mobil</a></li>
							<li <?php echo ($page=='canvass_keluar' && $mode=='cek_barang_mobil' ? ' class="current-page"' : '') ?> ><a href="?page=canvass_keluar&mode=cek_barang_mobil">Cek Barang Di Mobil</a></li>
							<li <?php echo ($page=='canvass_keluar' && $mode=='menu_penjualan' ? ' class="current-page"' : '') ?> ><a href="?page=canvass_keluar&mode=menu_penjualan">Penjualan (Canvass)</a></li>
							<li <?php echo ($page=='canvass_keluar' && $mode=='konfirm_jual' ? ' class="current-page"' : '') ?> ><a href="?page=canvass_keluar&mode=konfirm_jual">Konfirmasi Nota Canvass</a></li>
							<li <?php echo ($page=='canvass_keluar' && $mode=='kirim_canvass' ? ' class="current-page"' : '') ?> ><a href="?page=canvass_keluar&mode=kirim_canvass">Kirim Barang Canvass</a></li>
							<li <?php echo ($page=='canvass_keluar' && $mode=='stock_opname' ? ' class="current-page"' : '') ?> ><a href="?page=canvass_keluar&mode=stock_opname">Stock Opname Canvass</a></li>
							<li <?php echo ($page=='canvass_keluar' && $mode=='mutasi_mobil_gudang' ? ' class="current-page"' : '') ?> ><a href="?page=canvass_keluar&mode=mutasi_mobil_gudang">Mutasi Mobil Ke Gudang</a></li>
							<li <?php echo ($page=='canvass_keluar' && $mode=='lap_stock_opname' ? ' class="current-page"' : '') ?> ><a href="?page=canvass_keluar&mode=lap_stock_opname">Ringkasan Stock Opname</a></li>
						</ul>
					</li>
				</ul>
              </div>
            </div>  
            <!-- /sidebar menu -->
            

          </div>
        </div>
