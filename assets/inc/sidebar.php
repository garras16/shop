
<body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col menu_fixed" style="overflow-y:scroll">
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
                  <li <?php echo ($page=='home' ? ' class="current-page"' : '') ?> ><a href="index.php"><i class="fa fa-dashboard"></i> DASHBOARD </a>
				  </li>
				  <li <?php echo ($mode=='konfirmasi' && $page=='konfirmasi' ? ' class="current-page"' : '') ?> ><a href="?page=konfirmasi&mode=konfirmasi"><i class="fa fa-check-square-o"></i> KONFIRMASI OWNER </a>
				  </li>
				  <li <?php echo ($page=='master' ? ' class="active"' : '') ?> ><a><i class="fa fa-database"></i> MASTER <span class="fa fa-chevron-down"></span></a>
					<ul class="nav child_menu" style="<?php echo ($page=='master' ? 'display: block' : 'display: none') ?>">
						<li <?php echo ($page=='master' && $mode=='karyawan' ? ' class="current-page"' : '') ?> ><a href="?page=master&mode=karyawan"><i class="fa fa-group"></i> Karyawan</a></li>
						<li <?php echo ($page=='master' && $mode=='jabatan' ? ' class="current-page"' : '') ?> ><a href="?page=master&mode=jabatan"><i class="fa fa-briefcase"></i> Jabatan</a></li>
						<li <?php echo ($page=='master' && $mode=='users' ? ' class="current-page"' : '') ?> ><a href="?page=master&mode=users"><i class="fa fa-user"></i> User</a></li>
						<li <?php echo ($page=='master' && $mode=='pelanggan' ? ' class="current-page"' : '') ?> ><a href="?page=master&mode=pelanggan"><i class="fa fa-registered" aria-hidden="true"></i> Pelanggan</a></li>
						<li <?php echo ($page=='master' && $mode=='supplier' ? ' class="current-page"' : '') ?> ><a href="?page=master&mode=supplier"><i class="fa fa-institution" aria-hidden="true"></i> Supplier</a></li>
						<li <?php echo ($page=='master' && $mode=='barang' ? ' class="current-page"' : '') ?> ><a href="?page=master&mode=barang"><i class="fa fa-cube" aria-hidden="true"></i> Barang</a></li>
						<li <?php echo ($page=='master' && $mode=='satuan' ? ' class="current-page"' : '') ?> ><a href="?page=master&mode=satuan"><i class="fa fa-info" aria-hidden="true"></i> Satuan</a></li>
						<li <?php echo ($page=='master' && $mode=='komisi' ? ' class="current-page"' : '') ?> ><a href="?page=master&mode=komisi"><i class="fa fa-money" aria-hidden="true"></i> Komisi Sales</a></li>
						<li <?php echo ($page=='master' && $mode=='gudang_rak' ? ' class="current-page"' : '') ?> ><a href="?page=master&mode=gudang_rak"><i class="fa fa-cubes" aria-hidden="true"></i> Gudang & Rak</a></li>
						<li <?php echo ($page=='master' && $mode=='kendaraan' ? ' class="current-page"' : '') ?> ><a href="?page=master&mode=kendaraan"><i class="fa fa-cab" aria-hidden="true"></i> Kendaraan</a></li>
						<li <?php echo ($page=='master' && $mode=='varian' ? ' class="current-page"' : '') ?> ><a href="?page=master&mode=varian"><i class="fa fa-car" aria-hidden="true"></i> Varian Kendaraan</a></li>
						<li <?php echo ($page=='master' && $mode=='kas_kecil' ? ' class="current-page"' : '') ?> ><a href="?page=master&mode=kas_kecil"><i class="fa fa-book" aria-hidden="true"></i> Kas Kecil</a></li>
						<li <?php echo ($page=='master' && $mode=='perusahaan' ? ' class="current-page"' : '') ?> ><a href="?page=master&mode=perusahaan"><i class="fa fa-building" aria-hidden="true"></i> Perusahaan</a></li>
						<li <?php echo ($page=='master' && $mode=='negara' ? ' class="current-page"' : '') ?> ><a href="?page=master&mode=negara"><i class="fa fa-globe" aria-hidden="true"></i> Negara</a></li>
						<li <?php echo ($page=='master' && $mode=='provinsi' ? ' class="current-page"' : '') ?> ><a href="?page=master&mode=provinsi"><i class="fa fa-map-signs" aria-hidden="true"></i> Provinsi</a></li>
                        <li <?php echo ($page=='master' && $mode=='kabupaten' ? ' class="current-page"' : '') ?> ><a href="?page=master&mode=kabupaten"><i class="fa fa-map-o" aria-hidden="true"></i> Kabupaten</a></li>
						<li <?php echo ($page=='master' && $mode=='kecamatan' ? ' class="current-page"' : '') ?> ><a href="?page=master&mode=kecamatan"><i class="fa fa-map-marker" aria-hidden="true"></i> Kecamatan</a></li>
						<li <?php echo ($page=='master' && $mode=='kelurahan' ? ' class="current-page"' : '') ?> ><a href="?page=master&mode=kelurahan"><i class="fa fa-map-pin" aria-hidden="true"></i> Kelurahan</a></li>
						<li <?php echo ($page=='master' && $mode=='harga_jual' ? ' class="current-page"' : '') ?> ><a href="?page=master&mode=harga_jual"><i class="fa fa-dollar" aria-hidden="true"></i> Harga Jual</a></li>
						<li <?php echo ($page=='master' && $mode=='ekspedisi' ? ' class="current-page"' : '') ?> ><a href="?page=master&mode=ekspedisi"><i class="fa fa-truck" aria-hidden="true"></i> Ekspedisi</a></li>
                    </ul>
				  </li>
				  <li <?php echo ($page=='penjualan' ? ' class="active"' : '') ?> ><a><i class="fa fa-balance-scale"></i> PENJUALAN <span class="fa fa-chevron-down"></span></a>
					<ul class="nav child_menu" style="<?php echo ($page=='penjualan' ? 'display: block' : 'display: none') ?>">
						<li <?php echo ($page=='penjualan' && $mode=='penjualan' ? ' class="current-page"' : '') ?> ><a href="?page=penjualan&mode=penjualan"><i class="fa fa-exchange" aria-hidden="true"></i> Transaksi</a></li>
						<li <?php echo ($page=='penjualan' && $mode=='retur_jual' ? ' class="current-page"' : '') ?> ><a href="?page=penjualan&mode=retur_jual"><i class="fa fa-chevron-left" aria-hidden="true"></i> Retur Jual</a></li>
						<li <?php echo ($page=='penjualan' && $mode=='bayar_nota' ? ' class="current-page"' : '') ?> ><a href="?page=penjualan&mode=bayar_nota"><i class="fa fa-credit-card" aria-hidden="true"></i> Bayar Nota Jual</a></li>
						<li <?php echo ($page=='penjualan' && $mode=='pencairan_giro' ? ' class="current-page"' : '') ?> ><a href="?page=penjualan&mode=pencairan_giro"><i class="fa fa-money" aria-hidden="true"></i> Pencairan Giro</a></li>
						<li <?php echo ($page=='penjualan' && $mode=='konfirmasi_admin_retur_jual' ? ' class="current-page"' : '') ?> ><a href="?page=penjualan&mode=konfirmasi_admin_retur_jual"><i class="fa fa-check-square-o" aria-hidden="true"></i> Konfirmasi Retur Jual</a></li>
					</ul>
				  </li>
				  <li <?php echo ($page=='pembelian' ? ' class="active"' : '') ?> ><a><i class="fa fa-shopping-cart"></i> PEMBELIAN <span class="fa fa-chevron-down"></span></a>
					<ul class="nav child_menu" style="<?php echo ($page=='pembelian' ? 'display: block' : 'display: none') ?>">
						<li <?php echo ($page=='pembelian' && $mode=='pembelian' ? ' class="current-page"' : '') ?> ><a href="?page=pembelian&mode=pembelian"><i class="fa fa-exchange" aria-hidden="true"></i> Transaksi Beli</a></li>
						<li <?php echo ($page=='pembelian' && $mode=='retur_beli' ? ' class="current-page"' : '') ?> ><a href="?page=pembelian&mode=retur_beli"><i class="fa fa-chevron-right" aria-hidden="true"></i> Retur Beli</a></li>
						<li <?php echo ($page=='pembelian' && $mode=='bayar_nota' ? ' class="current-page"' : '') ?> ><a href="?page=pembelian&mode=bayar_nota"><i class="fa fa-credit-card" aria-hidden="true"></i> Bayar Nota Beli</a></li>
					</ul>
				  </li>
				  <li <?php echo ($page=='gudang' ? ' class="active"' : '') ?> ><a><i class="fa fa-cubes"></i> GUDANG <span class="fa fa-chevron-down"></span></a>
					<ul class="nav child_menu" style="<?php echo ($page=='gudang' ? 'display: block' : 'display: none') ?>">
						<li <?php echo ($page=='gudang' && $mode=='stok' ? ' class="current-page"' : '') ?> ><a href="?page=gudang&mode=stok"><i class="fa fa-eye" aria-hidden="true"></i> Lihat Stok</a></li>
						<li <?php echo ($page=='gudang' && $mode=='pindah_lokasi' ? ' class="current-page"' : '') ?> ><a href="?page=gudang&mode=pindah_lokasi"><i class="fa fa-map" aria-hidden="true"></i> Pindah Lokasi</a></li>
					</ul>
				  </li>
				  <li <?php echo ($page=='penagihan' ? ' class="active"' : '') ?> ><a><i class="fa fa-hand-lizard-o"></i> PENAGIHAN <span class="fa fa-chevron-down"></span></a>
					<ul class="nav child_menu" style="<?php echo ($page=='penagihan' ? 'display: block' : 'display: none') ?>">
						<li <?php echo ($page=='penagihan' && $mode=='penagihan' ? ' class="current-page"' : '') ?> ><a href="?page=penagihan&mode=penagihan"><i class="fa fa-hand-lizard-o" aria-hidden="true"></i> Penagihan</a></li>
					</ul>
				  </li>
				  <li <?php echo ($page=='keuangan' ? ' class="active"' : '') ?> ><a><i class="fa fa-balance-scale"></i> KEUANGAN <span class="fa fa-chevron-down"></span></a>
					<ul class="nav child_menu" style="<?php echo ($page=='keuangan' ? 'display: block' : 'display: none') ?>">
						<li <?php echo ($page=='keuangan' && $mode=='kas_kecil' ? ' class="current-page"' : '') ?> ><a href="?page=keuangan&mode=kas_kecil"><i class="fa fa-book" aria-hidden="true"></i> Kas Kecil</a></li>
					</ul>
				  </li>
				  <li <?php echo ($page=='ekspedisi' ? ' class="active"' : '') ?> ><a><i class="fa fa-plane"></i> EKSPEDISI <span class="fa fa-chevron-down"></span></a>
					<ul class="nav child_menu" style="<?php echo ($page=='ekspedisi' ? 'display: block' : 'display: none') ?>">
						<li <?php echo ($page=='ekspedisi' && $mode=='bayar_hutang' ? ' class="current-page"' : '') ?> ><a href="?page=ekspedisi&mode=bayar_hutang"><i class="fa fa-credit-card" aria-hidden="true"></i> Bayar Hutang</a></li>
					</ul>
				  </li>
				  <li <?php echo ($page=='canvass' ? ' class="active"' : '') ?> ><a><i class="fa fa-file-text-o"></i> CANVASS <span class="fa fa-chevron-down"></span></a>
					<ul class="nav child_menu" style="<?php echo ($page=='canvass' ? 'display: block' : 'display: none') ?>">
						<li <?php echo ($page=='canvass' && $mode=='stok' ? ' class="current-page"' : '') ?> ><a href="?page=canvass&mode=stok"><i class="fa fa-eye" aria-hidden="true"></i> Lihat Stok</a></li>
					</ul>
				  </li>
				  <li <?php echo ($page=='laporan' ? ' class="active"' : '') ?> ><a><i class="fa fa-folder-open-o"></i> LAPORAN <span class="fa fa-chevron-down"></span></a>
					<ul class="nav child_menu" style="<?php echo ($page=='laporan' ? 'display: block' : 'display: none') ?>">
						<li <?php echo ($page=='laporan' && $mode=='arus_kas' ? ' class="current-page"' : '') ?> ><a href="?page=laporan&mode=arus_kas"><i class="fa fa-book" aria-hidden="true"></i> Arus Kas</a></li>
						<li <?php echo ($page=='laporan' && $mode=='kirim_barang' ? ' class="current-page"' : '') ?> ><a href="?page=laporan&mode=kirim_barang"><i class="fa fa-truck" aria-hidden="true"></i> Pengiriman Barang</a></li>
						<li <?php echo ($page=='laporan' && $mode=='lap_stock_opname' ? ' class="current-page"' : '') ?> ><a href="?page=laporan&mode=lap_stock_opname"><i class="fa fa-cubes" aria-hidden="true"></i> Stock Opname Canvass</a></li>
						<li <?php echo ($page=='laporan' && $mode=='checkin' ? ' class="current-page"' : '') ?> ><a href="?page=laporan&mode=checkin"><i class="fa fa-star" aria-hidden="true"></i> Check In</a></li>
						<li <?php echo ($page=='laporan' && $mode=='mobil_canvass' ? ' class="current-page"' : '') ?> ><a href="?page=laporan&mode=mobil_canvass" style="font-size: 11px;"><i class="fa fa-car" aria-hidden="true"></i> Pemakaian Mobil Canvass</a></li>
						<li <?php echo ($page=='laporan' && $mode=='lap_histori_penagihan' ? ' class="current-page"' : '') ?> ><a href="?page=laporan&mode=lap_histori_penagihan"><i class="fa fa-list" aria-hidden="true"></i> Riwayat Penagihan</a></li>
						<li <?php echo ($page=='laporan' && $mode=='lap_histori_setoran' ? ' class="current-page"' : '') ?> ><a href="?page=laporan&mode=lap_histori_setoran"><i class="fa fa-history" aria-hidden="true"></i> Riwayat Setoran</a></li>
					</ul>
				  </li>
                </ul>
              </div>
            </div>  
            <!-- /sidebar menu -->

          </div>
        </div>
