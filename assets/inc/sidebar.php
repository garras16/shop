
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
                  <li <?php echo ($page=='home' ? ' class="current-page"' : '') ?> ><a href="index.php"><i class="fa fa-home"></i> DASHBOARD </a>
				  </li>
				  <li <?php echo ($mode=='konfirmasi' && $page=='konfirmasi' ? ' class="current-page"' : '') ?> ><a href="?page=konfirmasi&mode=konfirmasi"><i class="fa fa-home"></i> KONFIRMASI OWNER </a>
				  </li>
				  <li <?php echo ($page=='master' ? ' class="active"' : '') ?> ><a><i class="fa fa-home"></i> MASTER <span class="fa fa-chevron-down"></span></a>
					<ul class="nav child_menu" style="<?php echo ($page=='master' ? 'display: block' : 'display: none') ?>">
						<li <?php echo ($page=='master' && $mode=='karyawan' ? ' class="current-page"' : '') ?> ><a href="?page=master&mode=karyawan">Karyawan</a></li>
						<li <?php echo ($page=='master' && $mode=='jabatan' ? ' class="current-page"' : '') ?> ><a href="?page=master&mode=jabatan">Jabatan</a></li>
						<li <?php echo ($page=='master' && $mode=='users' ? ' class="current-page"' : '') ?> ><a href="?page=master&mode=users">User</a></li>
						<li <?php echo ($page=='master' && $mode=='pelanggan' ? ' class="current-page"' : '') ?> ><a href="?page=master&mode=pelanggan">Pelanggan</a></li>
						<li <?php echo ($page=='master' && $mode=='supplier' ? ' class="current-page"' : '') ?> ><a href="?page=master&mode=supplier">Supplier</a></li>
						<li <?php echo ($page=='master' && $mode=='barang' ? ' class="current-page"' : '') ?> ><a href="?page=master&mode=barang">Barang</a></li>
						<li <?php echo ($page=='master' && $mode=='satuan' ? ' class="current-page"' : '') ?> ><a href="?page=master&mode=satuan">Satuan</a></li>
						<li <?php echo ($page=='master' && $mode=='komisi' ? ' class="current-page"' : '') ?> ><a href="?page=master&mode=komisi">Komisi Sales</a></li>
						<li <?php echo ($page=='master' && $mode=='gudang_rak' ? ' class="current-page"' : '') ?> ><a href="?page=master&mode=gudang_rak">Gudang & Rak</a></li>
						<li <?php echo ($page=='master' && $mode=='kendaraan' ? ' class="current-page"' : '') ?> ><a href="?page=master&mode=kendaraan">Kendaraan</a></li>
						<li <?php echo ($page=='master' && $mode=='varian' ? ' class="current-page"' : '') ?> ><a href="?page=master&mode=varian">Varian Kendaraan</a></li>
						<li <?php echo ($page=='master' && $mode=='kas_kecil' ? ' class="current-page"' : '') ?> ><a href="?page=master&mode=kas_kecil">Kas Kecil</a></li>
						<li <?php echo ($page=='master' && $mode=='perusahaan' ? ' class="current-page"' : '') ?> ><a href="?page=master&mode=perusahaan">Perusahaan</a></li>
						<li <?php echo ($page=='master' && $mode=='negara' ? ' class="current-page"' : '') ?> ><a href="?page=master&mode=negara">Negara</a></li>
						<li <?php echo ($page=='master' && $mode=='provinsi' ? ' class="current-page"' : '') ?> ><a href="?page=master&mode=provinsi">Provinsi</a></li>
                        <li <?php echo ($page=='master' && $mode=='kabupaten' ? ' class="current-page"' : '') ?> ><a href="?page=master&mode=kabupaten">Kabupaten</a></li>
						<li <?php echo ($page=='master' && $mode=='kecamatan' ? ' class="current-page"' : '') ?> ><a href="?page=master&mode=kecamatan">Kecamatan</a></li>
						<li <?php echo ($page=='master' && $mode=='kelurahan' ? ' class="current-page"' : '') ?> ><a href="?page=master&mode=kelurahan">Kelurahan</a></li>
						<li <?php echo ($page=='master' && $mode=='harga_jual' ? ' class="current-page"' : '') ?> ><a href="?page=master&mode=harga_jual">Harga Jual</a></li>
						<li <?php echo ($page=='master' && $mode=='ekspedisi' ? ' class="current-page"' : '') ?> ><a href="?page=master&mode=ekspedisi">Ekspedisi</a></li>
                    </ul>
				  </li>
				  <li <?php echo ($page=='penjualan' ? ' class="active"' : '') ?> ><a><i class="fa fa-home"></i> PENJUALAN <span class="fa fa-chevron-down"></span></a>
					<ul class="nav child_menu" style="<?php echo ($page=='penjualan' ? 'display: block' : 'display: none') ?>">
						<li <?php echo ($page=='penjualan' && $mode=='penjualan' ? ' class="current-page"' : '') ?> ><a href="?page=penjualan&mode=penjualan">Transaksi</a></li>
						<li <?php echo ($page=='penjualan' && $mode=='retur_jual' ? ' class="current-page"' : '') ?> ><a href="?page=penjualan&mode=retur_jual">Retur Jual</a></li>
						<li <?php echo ($page=='penjualan' && $mode=='bayar_nota' ? ' class="current-page"' : '') ?> ><a href="?page=penjualan&mode=bayar_nota">Bayar Nota Jual</a></li>
						<li <?php echo ($page=='penjualan' && $mode=='pencairan_giro' ? ' class="current-page"' : '') ?> ><a href="?page=penjualan&mode=pencairan_giro">Pencairan Giro</a></li>
						<li <?php echo ($page=='penjualan' && $mode=='konfirmasi_admin_retur_jual' ? ' class="current-page"' : '') ?> ><a href="?page=penjualan&mode=konfirmasi_admin_retur_jual">Konfirmasi Retur Jual</a></li>
					</ul>
				  </li>
				  <li <?php echo ($page=='pembelian' ? ' class="active"' : '') ?> ><a><i class="fa fa-home"></i> PEMBELIAN <span class="fa fa-chevron-down"></span></a>
					<ul class="nav child_menu" style="<?php echo ($page=='pembelian' ? 'display: block' : 'display: none') ?>">
						<li <?php echo ($page=='pembelian' && $mode=='pembelian' ? ' class="current-page"' : '') ?> ><a href="?page=pembelian&mode=pembelian">Transaksi Beli</a></li>
						<li <?php echo ($page=='pembelian' && $mode=='retur_beli' ? ' class="current-page"' : '') ?> ><a href="?page=pembelian&mode=retur_beli">Retur Beli</a></li>
						<li <?php echo ($page=='pembelian' && $mode=='bayar_nota' ? ' class="current-page"' : '') ?> ><a href="?page=pembelian&mode=bayar_nota">Bayar Nota Beli</a></li>
					</ul>
				  </li>
				  <li <?php echo ($page=='gudang' ? ' class="active"' : '') ?> ><a><i class="fa fa-home"></i> GUDANG <span class="fa fa-chevron-down"></span></a>
					<ul class="nav child_menu" style="<?php echo ($page=='gudang' ? 'display: block' : 'display: none') ?>">
						<li <?php echo ($page=='gudang' && $mode=='stok' ? ' class="current-page"' : '') ?> ><a href="?page=gudang&mode=stok">Lihat Stok</a></li>
						<li <?php echo ($page=='gudang' && $mode=='pindah_lokasi' ? ' class="current-page"' : '') ?> ><a href="?page=gudang&mode=pindah_lokasi">Pindah Lokasi</a></li>
					</ul>
				  </li>
				  <li <?php echo ($page=='penagihan' ? ' class="active"' : '') ?> ><a><i class="fa fa-home"></i> PENAGIHAN <span class="fa fa-chevron-down"></span></a>
					<ul class="nav child_menu" style="<?php echo ($page=='penagihan' ? 'display: block' : 'display: none') ?>">
						<li <?php echo ($page=='penagihan' && $mode=='penagihan' ? ' class="current-page"' : '') ?> ><a href="?page=penagihan&mode=penagihan">Penagihan</a></li>
					</ul>
				  </li>
				  <li <?php echo ($page=='keuangan' ? ' class="active"' : '') ?> ><a><i class="fa fa-home"></i> KEUANGAN <span class="fa fa-chevron-down"></span></a>
					<ul class="nav child_menu" style="<?php echo ($page=='keuangan' ? 'display: block' : 'display: none') ?>">
						<li <?php echo ($page=='keuangan' && $mode=='kas_kecil' ? ' class="current-page"' : '') ?> ><a href="?page=keuangan&mode=kas_kecil">Kas Kecil</a></li>
					</ul>
				  </li>
				  <li <?php echo ($page=='ekspedisi' ? ' class="active"' : '') ?> ><a><i class="fa fa-home"></i> EKSPEDISI <span class="fa fa-chevron-down"></span></a>
					<ul class="nav child_menu" style="<?php echo ($page=='ekspedisi' ? 'display: block' : 'display: none') ?>">
						<li <?php echo ($page=='ekspedisi' && $mode=='bayar_hutang' ? ' class="current-page"' : '') ?> ><a href="?page=ekspedisi&mode=bayar_hutang">Bayar Hutang</a></li>
					</ul>
				  </li>
				  <li <?php echo ($page=='canvass' ? ' class="active"' : '') ?> ><a><i class="fa fa-home"></i> CANVASS <span class="fa fa-chevron-down"></span></a>
					<ul class="nav child_menu" style="<?php echo ($page=='canvass' ? 'display: block' : 'display: none') ?>">
						<li <?php echo ($page=='canvass' && $mode=='stok' ? ' class="current-page"' : '') ?> ><a href="?page=canvass&mode=stok">Lihat Stok</a></li>
					</ul>
				  </li>
				  <li <?php echo ($page=='laporan' ? ' class="active"' : '') ?> ><a><i class="fa fa-home"></i> LAPORAN <span class="fa fa-chevron-down"></span></a>
					<ul class="nav child_menu" style="<?php echo ($page=='laporan' ? 'display: block' : 'display: none') ?>">
						<li <?php echo ($page=='laporan' && $mode=='arus_kas' ? ' class="current-page"' : '') ?> ><a href="?page=laporan&mode=arus_kas">Arus Kas</a></li>
						<li <?php echo ($page=='laporan' && $mode=='kirim_barang' ? ' class="current-page"' : '') ?> ><a href="?page=laporan&mode=kirim_barang">Pengiriman Barang</a></li>
						<li <?php echo ($page=='laporan' && $mode=='lap_stock_opname' ? ' class="current-page"' : '') ?> ><a href="?page=laporan&mode=lap_stock_opname">Stock Opname Canvass</a></li>
						<li <?php echo ($page=='laporan' && $mode=='checkin' ? ' class="current-page"' : '') ?> ><a href="?page=laporan&mode=checkin">Check In</a></li>
						<li <?php echo ($page=='laporan' && $mode=='mobil_canvass' ? ' class="current-page"' : '') ?> ><a href="?page=laporan&mode=mobil_canvass">Pemakaian Mobil Canvass</a></li>
						<li <?php echo ($page=='laporan' && $mode=='lap_histori_penagihan' ? ' class="current-page"' : '') ?> ><a href="?page=laporan&mode=lap_histori_penagihan">Riwayat Penagihan</a></li>
						<li <?php echo ($page=='laporan' && $mode=='lap_histori_setoran' ? ' class="current-page"' : '') ?> ><a href="?page=laporan&mode=lap_histori_setoran">Riwayat Setoran</a></li>
					</ul>
				  </li>
                </ul>
              </div>
            </div>  
            <!-- /sidebar menu -->

          </div>
        </div>
