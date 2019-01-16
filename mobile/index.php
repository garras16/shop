<?php
	session_start();
	date_default_timezone_set('Asia/Jakarta');
	require_once('assets/inc/config.php');
	require_once('assets/inc/publicfunc.php');
	require_once('assets/inc/check.php');

	if (isset($_POST['edit_konfirm_beli_2_post'])){
		if (isset($_POST['edit_konfirm_beli_2_post'])) $edit_konfirm_beli_2_post=true;
		$id_ekspedisi=$_POST['id_ekspedisi'];
		$id_karyawan=$_POST['id_karyawan'];
	}
	if (isset($_POST['edit_konfirm_beli_3_post'])){
		if (isset($_POST['edit_konfirm_beli_3_post'])) $edit_konfirm_beli_3_post=true;
		$berat_volume=$_POST['berat_volume'];
		$val_berat_volume=$_POST['val_berat_volume'];
		$tarif=$_POST['tarif'];
		$id_beli_detail=$_POST['id_beli_detail'];
	}
	if (isset($_POST['edit_konfirm_beli_4_post'])){
		if (isset($_POST['edit_konfirm_beli_4_post'])) $edit_konfirm_beli_4_post=true;
		$qty_datang=$_POST['qty_datang'];
		$tanggal=date("Y-m-d");
	}
	if (isset($_POST['edit_konfirm_beli_5_post'])){
		if (isset($_POST['edit_konfirm_beli_5_post'])) $edit_konfirm_beli_5_post=true;
	//	$qty_datang=$_POST['qty_datang'];
	//	$berat_volume=$_POST['berat_volume'];
	//	$val_berat_volume=$_POST['val_berat_volume'];
		$id_barang_masuk=$_POST['id_barang_masuk'];
		$id_gudang=$_POST['id_gudang'];
		$id_rak=$_POST['id_rak'];
		$qty_di_rak=$_POST['qty_di_rak'];
		$expire=$_POST['expire'];
		$tanggal=date("Y-m-d");
	}
	if (isset($_POST['edit_konfirm_retur_beli_2_post'])){
		if (isset($_POST['edit_konfirm_retur_beli_2_post'])) $edit_konfirm_retur_beli_2_post=true;
		
	}
	if (isset($_POST['edit_konfirm_retur_beli_3_post'])){
		if (isset($_POST['edit_konfirm_retur_beli_3_post'])) $edit_konfirm_retur_beli_3_post=true;
		$qty_keluar=$_POST['qty_keluar'];
	}
	if (isset($_POST['edit_konfirm_retur_jual_2_post'])){
		if (isset($_POST['edit_konfirm_retur_jual_2_post'])) $edit_konfirm_retur_jual_2_post=true;	
	}
	if (isset($_POST['edit_konfirm_retur_jual_3_post'])){
		if (isset($_POST['edit_konfirm_retur_jual_3_post'])) $edit_konfirm_retur_jual_3_post=true;
		$id_jual_detail=$_POST['id_jual_detail'];
		$id_rak=$_POST['id_rak'];
		$qty_masuk=$_POST['qty_masuk'];
		$expire=$_POST['expire'];
	}
	if (isset($_POST['checkin_post'])){
		$checkin_post=true;
		$tanggal=date("Y-m-d");
		$jam=date("H:i:s");
		$barcode=$_POST['barcode'];
		$id_pelanggan=$_POST['id_pelanggan'];
		$id_karyawan=$_SESSION['id_karyawan'];
		$nama_toko=$_POST['nama_toko'];
		$lokasi_gps=$_POST['lokasi_gps'];
		$lokasi_kota=$_POST['lokasi_kota'];
		$akurasi=$_POST['akurasi'];
		$mock=$_POST['mock'];
		$distance=$_POST['distance'];
	}

	if (isset($_POST['tambah_penjualan_post'])){
		$tambah_penjualan_post=true;
		$tanggal=date("Y-m-d");
		$id_karyawan=$_SESSION['id_karyawan'];
		$id_pelanggan=$_POST['id_pelanggan'];
		$jenis_bayar=$_POST['jenis_bayar'];
		$id_harga_jual=$_POST['id_harga_jual'];
		$harga=$_POST['harga'];
		$qty=$_POST['qty'];
		$diskon_persen_1=$_POST['diskon_persen_1'];
		$diskon_rp_1=$_POST['diskon_rp_1'];
		$diskon_persen_2=$_POST['diskon_persen_2'];
		$diskon_rp_2=$_POST['diskon_rp_2'];
		$diskon_persen_3=$_POST['diskon_persen_3'];
		$diskon_rp_3=$_POST['diskon_rp_3'];
		$diskon_all_persen=$_POST['diskon_all_persen'];
		$ppn_all_persen=$_POST['ppn_all_persen'];
		$tenor=$_POST['tenor'];
		if (isset($_POST['id_canvass_keluar'])) $id_canvass_keluar=$_POST['id_canvass_keluar'];
	}
	if (isset($_POST['edit_diskon_nota_jual'])){
		$edit_diskon_nota_jual=true;
		$diskon_all_persen=$_POST['diskon_all_persen'];
	}
	if (isset($_POST['edit_ppn_nota_jual'])){
		$edit_ppn_nota_jual=true;
		$ppn_all_persen=$_POST['ppn_all_persen'];
	}
	if (isset($_POST['tambah_gudang_jual_detail'])){
		$tambah_gudang_jual_detail=true;
		$id_harga_jual=$_POST['id_harga_jual'];
		$harga=$_POST['harga_jual'];
		$qty=$_POST['qty'];
	}
	if (isset($_POST['edit_penjualan_post'])){
		$edit_penjualan_post=true;
		$id_harga_jual=$_POST['id_harga_jual'];
		$harga=$_POST['harga_jual'];
		$qty=$_POST['qty'];
		$diskon_persen_1=$_POST['diskon_persen_1'];
		$diskon_rp_1=$harga*$diskon_persen_1/100;
		$diskon_persen_2=$_POST['diskon_persen_2'];
		$diskon_rp_2=($harga-$diskon_rp_1)*$diskon_persen_2/100;
		$diskon_persen_3=$_POST['diskon_persen_3'];
		$diskon_rp_3=($harga-$diskon_rp_1-$diskon_rp_2)*$diskon_persen_3/100;
	}
	if (isset($_POST['buat_nota_siap_kirim_post'])){
		$buat_nota_siap_kirim_post=true;
		$id_jual=$_POST['id_jual'];
		$tanggal=date("Y-m-d");
		$id_barang=$_POST['id_barang'];
		$id_jual_detail=$_POST['id_jual_detail'];
		$id_barang_masuk_rak=$_POST['id_barang_masuk_rak'];
		$id_rak=$_POST['id_rak'];
		$expire=$_POST['expire'];
		$qty_ambil=$_POST['qty_ambil'];
	}
	if (isset($_POST['cek_nota_siap_kirim_post'])){
		$cek_nota_siap_kirim_post=true;
		$qty_ambil=$_POST['qty_ambil'];
		$qty_cek=$_POST['qty_cek'];
		$id_jual_detail=$_POST['id_jual_detail'];
	}
	if (isset($_POST['batal_cek_barang_post'])){
		$batal_cek_barang_post=true;
		$id_nota_siap_kirim=$_POST['id_nota_siap_kirim'];
	}
	if (isset($_POST['batal_kirim_barang_post'])){
		$batal_kirim_barang_post=true;
		$id_batal_kirim_detail=$_POST['id_batal_kirim_detail'];
		$id_barang_masuk_rak=$_POST['id_barang_masuk_rak'];
		$id_rak=$_POST['id_rak'];
		$qty_balik=$_POST['qty_balik'];
		$expire=$_POST['expire'];
	}
	if (isset($_POST['selesai_nota_siap_kirim_post'])){
		$selesai_nota_siap_kirim_post=true;
	}
	if (isset($_POST['selesai_batal_kirim_post'])){
		$selesai_batal_kirim_post=true;
	}
	if (isset($_POST['buat_nota_sudah_cek_post'])){
		$buat_nota_sudah_cek_post=true;
		$tanggal=date("Y-m-d");
		$jumlah=$_POST['total_harga'];
		$jenis_kirim=$_POST['jenis_kirim'];
	}
	if (isset($_POST['simpan_nota_sudah_cek_post'])){
		$simpan_nota_sudah_cek_post=true;
		$tanggal=date("Y-m-d");
		$jam=date("H:i:s");
		$barcode=$_POST['barcode'];
		$id_pelanggan=$_POST['id_pelanggan'];
		$id_karyawan=$_SESSION['id_karyawan'];
		$lokasi_gps=$_POST['lokasi_gps'];
		$lokasi_kota=$_POST['lokasi_kota'];
		$akurasi=$_POST['akurasi'];
		$mock=$_POST['mock'];
		$distance=$_POST['distance'];
		if (isset($_POST['id_ekspedisi'])) $id_ekspedisi=$_POST['id_ekspedisi'];
		if (isset($_POST['berat_volume'])) $berat_volume=$_POST['berat_volume'];
		if (isset($_POST['val_berat_volume'])) $val_berat_volume=$_POST['val_berat_volume'];
		if (isset($_POST['tarif'])) $tarif=$_POST['tarif'];
	}
	if (isset($_POST['tambah_ambil_gudang_mobil_post'])){
		$tambah_ambil_gudang_mobil_post=true;
		$tanggal=date("Y-m-d");
		$id_mobil=$_POST['id_mobil'];
	}
	if (isset($_POST['tambah_ambil_gudang_karyawan_post'])){
		$tambah_ambil_gudang_karyawan_post=true;
		$id_karyawan=$_POST['id_karyawan'];
	}
	if (isset($_POST['tambah_ambil_gudang_barang_post'])){
		$tambah_ambil_gudang_barang_post=true;
		$tanggal=date("Y-m-d");
		$id_barang_masuk_rak=$_POST['id_barang_masuk_rak'];
		$id_barang=$_POST['id_barang'];
		$id_rak=$_POST['id_rak'];
		$expire=$_POST['expire'];
		$qty=$_POST['qty'];
	}
	if (isset($_POST['update_ambil_gudang_barang_post'])){
		$update_ambil_gudang_barang_post=true;
		$tanggal=date("Y-m-d");
		$id_barang_masuk_rak=$_POST['id_barang_masuk_rak'];
		$id_barang=$_POST['id_barang'];
		$id_rak=$_POST['id_rak'];
		$expire=$_POST['expire'];
		$qty=$_POST['qty'];
	}
	if (isset($_POST['tambah_cek_barang_mobil_post'])){
		$tambah_cek_barang_mobil_post=true;
		$id_canvass_keluar_barang=$_POST['id_canvass_keluar_barang'];
		$id_barang=$_POST['id_barang'];
		$expire=$_POST['expire'];
		$qty_cek=$_POST['qty_cek'];
	}
	if (isset($_POST['selesai_cek_barang_mobil_post'])){
		$selesai_cek_barang_mobil_post=true;
		$id_barang=$_POST['id_barang'];
		$qty_cek=$_POST['qty_cek'];
	}
	if (isset($_POST['batal_cek_barang_mobil_post'])){
		$batal_cek_barang_mobil_post=true;
		$id_canvass_keluar=$_POST['id_canvass_keluar'];
	}
	if (isset($_POST['batal_cek_kembali_gudang_post'])){
		$batal_cek_kembali_gudang_post=true;
		$id_canvass_keluar=$_POST['id_canvass_keluar'];
	}
	if (isset($_POST['buat_canvass_siap_kirim_post'])){
		$buat_canvass_siap_kirim_post=true;
		$id_jual=$_POST['id_jual'];
		$tanggal=date("Y-m-d");
		$id_canvass_keluar=$_POST['id_canvass_keluar'];
		$id_barang=$_POST['id_barang'];
		$id_barang_masuk_rak=$_POST['id_barang_masuk_rak'];
		$id_jual_detail=$_POST['id_jual_detail'];
		$expire=$_POST['expire'];
		$qty_ambil=$_POST['qty_ambil'];
	}
	if (isset($_POST['batal_canvass_cek_barang_post'])){
		$batal_canvass_cek_barang_post=true;
		$id_canvass_siap_kirim=$_POST['id_canvass_siap_kirim'];
	}
	if (isset($_POST['selesai_canvass_siap_kirim_post'])){
		$selesai_canvass_siap_kirim_post=true;
	}
	if (isset($_POST['simpan_canvass_siap_kirim_post'])){
		$simpan_canvass_siap_kirim_post=true;
		$tanggal=date("Y-m-d");
		$jam=date("H:i:s");
		$barcode=$_POST['barcode'];
		$id_pelanggan=$_POST['id_pelanggan'];
		$id_karyawan=$_SESSION['id_karyawan'];
		$lokasi_gps=$_POST['lokasi_gps'];
		$lokasi_kota=$_POST['lokasi_kota'];
		$akurasi=$_POST['akurasi'];
		$mock=$_POST['mock'];
		$distance=$_POST['distance'];
	}
	if (isset($_POST['tambah_stock_opname_canvass'])){
		$tambah_stock_opname_canvass=true;
		$tanggal=date("Y-m-d");
		$id_canvass_keluar_barang=$_POST['id_canvass_keluar_barang'];
		$id_barang=$_POST['id_barang'];
		$qty_cek=$_POST['qty_cek'];
		$qty_sisa=$_POST['qty_sisa'];
		$expire=$_POST['expire'];
		$total_cek=$_POST['tot_qty_cek2']+$qty_cek;
		$selisih=$total_cek-$qty_sisa;
	}
	if (isset($_POST['batal_canvass_stock_opname'])){
		$batal_canvass_stock_opname=true;
		$id_canvass_keluar=$_POST['id_canvass_keluar'];
	}
	if (isset($_POST['selesai_canvass_stock_opname'])){
		$selesai_canvass_stock_opname=true;
	}
	if (isset($_POST['tambah_mutasi_mobil_gudang_post'])){
		$tambah_mutasi_mobil_gudang_post=true;
		$tanggal=date("Y-m-d");
		$id_barang_masuk_rak=$_POST['id_barang_masuk_rak'];
		$id_barang=$_POST['id_barang'];
		$id_rak=$_POST['id_rak'];
		$expire=$_POST['expire'];
		$qty_cek2=$_POST['qty_cek2'];
	}
	if (isset($_POST['selesai_mutasi_mobil_gudang_post'])){
		$selesai_mutasi_mobil_gudang_post=true;
	}
	if (isset($_POST['batal_mutasi_mobil_gudang_post'])){
		$batal_mutasi_mobil_gudang_post=true;
		$id_canvass_keluar=$_POST['id_canvass_keluar'];
	}
	if (isset($_POST['sukses_mutasi_mobil_gudang_post'])){
		$sukses_mutasi_mobil_gudang_post=true;
	}
	if (isset($_POST['tambah_stock_opname_gudang'])){
		$tambah_stock_opname_gudang=true;
		$tanggal=date("Y-m-d");
		$id_barang=$_POST['id_barang'];
		$id_rak=$_POST['id_rak'];
		$qty_cek=$_POST['qty_cek'];
		$expire=$_POST['expire'];
	}
	if (isset($_POST['selesai_stock_opname_gudang'])){
		$selesai_stock_opname_gudang=true;
	}

	if (isset($_POST['kembali_barang_ke_gudang_post'])){
		$kembali_barang_ke_gudang_post=true;
		$id_barang=$_POST['id_barang'];
		$expire=$_POST['expire'];
		$qty_balik=$_POST['qty_balik'];
	}
	if (isset($_POST['buat_penagihan_post'])){
		$buat_penagihan_post=true;
		$id_jual=$_POST['id_jual'];
		$tanggal=date("Y-m-d");
		$penagih=$_POST['id_karyawan'];
	}
	if (isset($_POST['tambah_setoran_post'])){
		$tambah_setoran_post=true;
		$id_jual=$_POST['id_jual'];
		$id_penagihan_detail=$_POST['id_penagihan_detail'];
	//	$total_bayar=$_POST['total_bayar'];
	//	$jumlah_jual=$_POST['jumlah_jual'];
	//	$bayar=$_POST['bayar'];
		$jenis=$_POST['jenis'];
		if (isset($_POST['janji'])) $tgl_janji_next=$_POST['janji'];
	}
	if (isset($_POST['edit_setoran_post'])){
		$edit_setoran_post=true;
		$id_penagihan_detail=$_POST['id_penagihan_detail'];
		$setor=$_POST['setor'];
		$bayar=$_POST['bayar'];
		$tgl_janji_next=$_POST['tgl_janji_next'];
	}
	if (isset($_POST['tambah_bayar_tagih_nota_jual_post']) or isset($_POST['edit_bayar_tagih_nota_jual_post'])){
		if (isset($_POST['tambah_bayar_tagih_nota_jual_post'])) $tambah_bayar_tagih_nota_jual_post=true;
		if (isset($_POST['edit_bayar_tagih_nota_jual_post'])) $edit_bayar_tagih_nota_jual_post=true;
		if (isset($_POST['id_bayar'])) $id_bayar=$_POST['id_bayar'];
		if (isset($_POST['no_retur_jual'])) $no_retur_jual=$_POST['no_retur_jual'];
		if (isset($_POST['no_retur'])) $no_retur=$_POST['no_retur'];
		if (isset($_POST['jumlah_retur'])) $jumlah_retur=$_POST['jumlah_retur'];
		if (isset($_POST['sisa_nota'])) $sisa_nota=$_POST['sisa_nota'];
		$tanggal=date("Y-m-d");
		$no_nota_jual=$_POST['no_nota_jual'];
		$jenis=$_POST['jenis'];
		$jumlah_bayar=$_POST['jumlah_bayar'];
		if (isset($_POST['pengirim_nama_bank'])) $pengirim_nama_bank=$_POST['pengirim_nama_bank'];
		if (isset($_POST['pengirim_nama_rekening'])) $pengirim_nama_rekening=$_POST['pengirim_nama_rekening'];
		if (isset($_POST['pengirim_no_rekening'])) $pengirim_no_rekening=$_POST['pengirim_no_rekening'];
		if (isset($_POST['penerima_nama_bank'])) $penerima_nama_bank=$_POST['penerima_nama_bank'];
		if (isset($_POST['penerima_nama_rekening'])) $penerima_nama_rekening=$_POST['penerima_nama_rekening'];
		if (isset($_POST['penerima_no_rekening'])) $penerima_no_rekening=$_POST['penerima_no_rekening'];
		if (isset($_POST['jatuh_tempo'])) $jatuh_tempo=$_POST['jatuh_tempo'];
		if (isset($_POST['tgl_janji_next'])) $tgl_janji_next=$_POST['tgl_janji_next'];
		if (isset($_POST['keterangan'])) $keterangan=$_POST['keterangan'];
	}
	if (isset($_POST['batal_penagihan_post'])){
		$batal_penagihan_post=true;
		$id_penagihan=$_POST['id_penagihan'];
	}
	if (isset($_POST['tambah_retur_jual_detail_post']) or isset($_POST['edit_retur_jual_detail_post'])){
		if (isset($_POST['tambah_retur_jual_detail_post'])) $tambah_retur_jual_detail_post=true;
		if (isset($_POST['edit_retur_jual_detail_post'])) $edit_retur_jual_detail_post=true;
		if (isset($_POST['id_jual_detail'])) $id_jual_detail=$_POST['id_jual_detail'];
		if (isset($_POST['id_retur_jual_detail'])) $id_retur_jual_detail=$_POST['id_retur_jual_detail'];
		$qty_retur=$_POST['qty_retur'];
		$harga_retur=$_POST['harga_retur'];
	}
	if (isset($_POST['cari_nota_retur_jual_post'])){
		$cari_nota_retur_jual_post=true;
		$pelanggan=$_POST['pelanggan'];
		$tgl_nota=$_POST['tgl_nota'];
		$tgl_kirim=$_POST['tgl_kirim'];
		$barang=$_POST['barang'];
	}
	if (isset($_GET['id'])){
		$id=$_GET['id'];
	}

	(isset($_GET['frameless']) ? $frameless=true : $frameless=false);

	include "assets/inc/header.php";

	if(isset($_GET['page'])){
		$page = $_GET['page'];
	} else {
		$page="home";
	}
	if(isset($_GET['mode'])){
		$mode=$_GET['mode'];
	}

	if (! $frameless) include "assets/inc/sidebar.php";
	//include "assets/inc/top.php";

	if (isset($_SESSION['pesan'])){
		$pesan=$_SESSION['pesan'];
		$warna=$_SESSION['warna'];
		unset($_SESSION['pesan']);
		unset($_SESSION['warna']);
	}

	if(!isset($_GET['page'])){
		include "assets/page/gudang/konfirm_beli.php";
	} else {
		$page = $_GET['page'];
		if(isset($_GET['mode'])){
			$mode=$_GET['mode'];
			include "assets/page/" . $page . "/" .$mode. ".php";
		} else {
			if (file_exists("../assets/page/" . $page . ".php")){
				include "assets/page/" . $page . ".php";
			} else {
				include "assets/page/404.php";
			}
		}
	}
	include "assets/inc/footer.php";
?>