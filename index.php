<?php
session_start();
date_default_timezone_set('Asia/Jakarta');
require_once('assets/inc/config.php');
require_once('assets/inc/publicfunc.php');
require_once('assets/inc/check.php');

if (isset($_POST['tambah_karyawan_post']) or isset($_POST['edit_karyawan_post'])){
	if (isset($_POST['tambah_karyawan_post'])) $tambah_karyawan_post=true;
	if (isset($_POST['edit_karyawan_post'])) $edit_karyawan_post=true;
	if (isset($_POST['id_karyawan'])) $id_karyawan=$_POST['id_karyawan'];
	$nama_karyawan=$_POST['nama_karyawan'];
	$barcode=$_POST['barcode'];
	$ktp=$_POST['ktp'];
	$no_hp=$_POST['no_hp'];
	$jabatan=$_POST['jabatan'];
	$gaji=$_POST['gaji'];
	$harian=$_POST['harian'];
	$lembur=$_POST['lembur'];
	$status=$_POST['status'];
}
if (isset($_POST['tambah_beli_detail_post']) or isset($_POST['hapus_beli_detail_post'])){
	if (isset($_POST['tambah_beli_detail_post'])) $tambah_beli_detail_post=true;
	if (isset($_POST['hapus_beli_detail_post'])) $hapus_beli_detail_post=true;
	if (isset($_POST['id_beli_detail'])) $id_beli_detail=$_POST['id_beli_detail'];
	$id_barang_supplier=$_POST['id_barang_supplier'];
	$qty=$_POST['qty'];
	$harga=$_POST['harga'];
	if ($_POST['diskon_persen_1']=='') {
		$diskon_persen_1=0;
	} else {
		$diskon_persen_1=$_POST['diskon_persen_1'];
	}
	if ($_POST['diskon_persen_2']=='') {
		$diskon_persen_2=0;
	} else {
		$diskon_persen_2=$_POST['diskon_persen_2'];
	}
	if ($_POST['diskon_persen_3']=='') {
		$diskon_persen_3=0;
	} else {
		$diskon_persen_3=$_POST['diskon_persen_3'];
	}
	$diskon_rp_1=($harga*$diskon_persen_1/100);
	$diskon_rp_2=($harga-$diskon_rp_1)*($diskon_persen_2/100);
	$diskon_rp_3=($harga-$diskon_rp_1-$diskon_rp_2)*($diskon_persen_3/100);
	$jumlah=$qty*$harga;
}
if (isset($_POST['edit_beli_detail_post'])){
	$edit_beli_detail_post=true;
	$id_beli_detail=$_POST['id_beli_detail'];
	$qty=$_POST['qty'];
	$harga=$_POST['harga'];
	if ($_POST['diskon_persen_1']=='') {
		$diskon_persen_1=0;
	} else {
		$diskon_persen_1=$_POST['diskon_persen_1'];
	}
	if ($_POST['diskon_persen_2']=='') {
		$diskon_persen_2=0;
	} else {
		$diskon_persen_2=$_POST['diskon_persen_2'];
	}
	if ($_POST['diskon_persen_3']=='') {
		$diskon_persen_3=0;
	} else {
		$diskon_persen_3=$_POST['diskon_persen_3'];
	}
	$diskon_rp_1=($harga*$diskon_persen_1/100);
	$diskon_rp_2=($harga-$diskon_rp_1)*($diskon_persen_2/100);
	$diskon_rp_3=($harga-$diskon_rp_1-$diskon_rp_2)*($diskon_persen_3/100);
	$jumlah=$qty*$harga;
}
if (isset($_POST['tambah_retur_beli_post']) or isset($_POST['hapus_retur_beli_post'])){
	if (isset($_POST['tambah_retur_beli_post'])) $tambah_retur_beli_post=true;
	if (isset($_POST['hapus_retur_beli_post'])) $hapus_retur_beli_post=true;
	$tanggal=date("Y-m-d");
	$id_beli=$_POST['id_beli'];
}
if (isset($_POST['tambah_retur_beli_detail_post']) or isset($_POST['edit_retur_beli_detail_post'])){
	if (isset($_POST['tambah_retur_beli_detail_post'])) $tambah_retur_beli_detail_post=true;
	if (isset($_POST['edit_retur_beli_detail_post'])) $edit_retur_beli_detail_post=true;
	if (isset($_POST['id_beli_detail'])) $id_beli_detail=$_POST['id_beli_detail'];
	if (isset($_POST['id_retur_beli_detail'])) $id_retur_beli_detail=$_POST['id_retur_beli_detail'];
	if (isset($_POST['id_barang_masuk_rak'])) $id_barang_masuk_rak=$_POST['id_barang_masuk_rak'];
	$qty_retur=$_POST['qty_retur'];
	$harga_retur=$_POST['harga_retur'];
}
if (isset($_POST['tambah_bayar_nota_beli_post']) or isset($_POST['edit_bayar_nota_beli_post'])){
	if (isset($_POST['tambah_bayar_nota_beli_post'])) $tambah_bayar_nota_beli_post=true;
	if (isset($_POST['edit_bayar_nota_beli_post'])) $edit_bayar_nota_beli_post=true;
	if (isset($_POST['id_bayar'])) $id_bayar=$_POST['id_bayar'];
	if (isset($_POST['no_retur_beli'])) $no_retur_beli=$_POST['no_retur_beli'];
	if (isset($_POST['no_retur'])) $no_retur=$_POST['no_retur'];
	if (isset($_POST['jumlah_retur'])) $jumlah_retur=$_POST['jumlah_retur'];
	if (isset($_POST['sisa_nota'])) $sisa_nota=$_POST['sisa_nota'];
	$tanggal=date("Y-m-d");
	$no_nota_beli=$_POST['no_nota_beli'];
	$jenis=$_POST['jenis'];
	$jumlah_bayar=$_POST['jumlah_bayar'];
	if (isset($_POST['pengirim_nama_bank'])) $pengirim_nama_bank=$_POST['pengirim_nama_bank'];
	if (isset($_POST['pengirim_nama_rekening'])) $pengirim_nama_rekening=$_POST['pengirim_nama_rekening'];
	if (isset($_POST['pengirim_no_rekening'])) $pengirim_no_rekening=$_POST['pengirim_no_rekening'];
	if (isset($_POST['penerima_nama_bank'])) $penerima_nama_bank=$_POST['penerima_nama_bank'];
	if (isset($_POST['penerima_nama_rekening'])) $penerima_nama_rekening=$_POST['penerima_nama_rekening'];
	if (isset($_POST['penerima_no_rekening'])) $penerima_no_rekening=$_POST['penerima_no_rekening'];
	if (isset($_POST['jatuh_tempo'])) $jatuh_tempo=$_POST['jatuh_tempo'];
	if (isset($_POST['keterangan'])) $keterangan=$_POST['keterangan'];
}
if (isset($_POST['tambah_retur_jual_post']) or isset($_POST['hapus_retur_jual_post'])){
	if (isset($_POST['tambah_retur_jual_post'])) $tambah_retur_jual_post=true;
	if (isset($_POST['hapus_retur_jual_post'])) $hapus_retur_jual_post=true;
	$tanggal=date("Y-m-d");
	$id_jual=$_POST['id_jual'];
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
if (isset($_POST['tambah_bayar_nota_jual_post']) or isset($_POST['edit_bayar_nota_jual_post'])){
	if (isset($_POST['tambah_bayar_nota_jual_post'])) $tambah_bayar_nota_jual_post=true;
	if (isset($_POST['edit_bayar_nota_jual_post'])) $edit_bayar_nota_jual_post=true;
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
	if (isset($_POST['keterangan'])) $keterangan=$_POST['keterangan'];
}
if (isset($_POST['tambah_komisi_post']) or isset($_POST['edit_komisi_post'])){
	if (isset($_POST['tambah_komisi_post'])) $tambah_komisi_post=true;
	if (isset($_POST['edit_komisi_post'])) $edit_komisi_post=true;
	$id_karyawan=$_POST['id_karyawan'];
}
if (isset($_POST['tambah_jenjang_post']) or isset($_POST['edit_jenjang_post'])){
	if (isset($_POST['tambah_jenjang_post'])) $tambah_jenjang_post=true;
	if (isset($_POST['edit_jenjang_post'])) $edit_jenjang_post=true;
	if (isset($_POST['id_komisi'])) $id_komisi=$_POST['id_komisi'];
	$target_awal=$_POST['target_awal'];
	$target_akhir=$_POST['target_akhir'];
	$tunai=$_POST['tunai'];
}
if (isset($_POST['tambah_komisi_kredit_post']) or isset($_POST['edit_komisi_kredit_post'])){
	if (isset($_POST['tambah_komisi_kredit_post'])) $tambah_komisi_kredit_post=true;
	if (isset($_POST['edit_komisi_kredit_post'])) $edit_komisi_kredit_post=true;
	if (isset($_POST['id_komisi_kredit'])) $id_komisi_kredit=$_POST['id_komisi_kredit'];
	$kredit=$_POST['kredit'];
	$hari=$_POST['hari'];
}
if (isset($_POST['tambah_user_post'])){
	$tambah_user_post=true;
	$id_karyawan=$_POST['id_karyawan'];
	$posisi=strtoupper($_POST['posisi']);
	$nama_user=strtoupper($_POST['nama_user']);
	$user_pass=strtoupper($_POST['user_pass']);
	$status=$_POST['status'];
}
if (isset($_POST['edit_user_post'])){
	$edit_user_post=true;
	$id_user=$_POST['id_user'];
	$posisi=strtoupper($_POST['posisi']);
	$user_pass=strtoupper($_POST['user_pass']);
	$status=$_POST['status'];
}
if (isset($_POST['tambah_barang_post']) or isset($_POST['edit_barang_post'])){
	if (isset($_POST['tambah_barang_post'])) $tambah_barang_post=true;
	if (isset($_POST['edit_barang_post'])) $edit_barang_post=true;
	if (isset($_POST['id_barang'])) $id_barang=$_POST['id_barang'];
	$barcode=$_POST['barcode'];
	$nama=$_POST['nama_barang'];
	$id_satuan=$_POST['id_satuan'];
	$ijin=$_POST['ijin'];
	$min_order=$_POST['min_order'];
	$stok_minimal=$_POST['stok_minimal'];
	$status=$_POST['status'];
	$tampil=$_POST['tampil'];
}
if (isset($_POST['tambah_barang_supplier_post']) or isset($_POST['hapus_barang_supplier_post'])){
	if (isset($_POST['tambah_barang_supplier_post'])) $tambah_barang_supplier_post=true;
	if (isset($_POST['hapus_barang_supplier_post'])) $hapus_barang_supplier_post=true;
	$id_barang=$_POST['id_barang'];
	$id_supplier=$_POST['id_supplier'];
}
if (isset($_POST['tambah_harga_jual_tunai_post']) or isset($_POST['edit_harga_jual_tunai_post'])){
	if (isset($_POST['tambah_harga_jual_tunai_post'])) $tambah_harga_jual_tunai_post=true;
	if (isset($_POST['edit_harga_jual_tunai_post'])) $edit_harga_jual_tunai_post=true;
	if (isset($_POST['id_harga_jual'])) $id_harga_jual=$_POST['id_harga_jual'];
	if (isset($_POST['id_barang_supplier'])) $id_barang_supplier=$_POST['id_barang_supplier'];
	$harga_jual=$_POST['harga_jual'];
}
if (isset($_POST['tambah_harga_jual_kredit_post']) or isset($_POST['edit_harga_jual_kredit_post'])){
	if (isset($_POST['tambah_harga_jual_kredit_post'])) $tambah_harga_jual_kredit_post=true;
	if (isset($_POST['edit_harga_jual_kredit_post'])) $edit_harga_jual_kredit_post=true;
	if (isset($_POST['id_harga_jual'])) $id_harga_jual=$_POST['id_harga_jual'];
	if (isset($_POST['id_harga_jual_kredit'])) $id_harga_jual_kredit=$_POST['id_harga_jual_kredit'];
	$harga_jual=$_POST['harga_jual'];
	$hari=$_POST['hari'];
}
if (isset($_POST['tambah_satuan_post']) or isset($_POST['edit_satuan_post'])){
	if (isset($_POST['tambah_satuan_post'])) $tambah_satuan_post=true;
	if (isset($_POST['edit_satuan_post'])) $edit_satuan_post=true;
	if (isset($_POST['id_satuan'])) $id_satuan=$_POST['id_satuan'];
	$nama_satuan=$_POST['nama_satuan'];
}
if (isset($_POST['tambah_gudang_post']) or isset($_POST['edit_gudang_post'])){
	if (isset($_POST['tambah_gudang_post'])) $tambah_gudang_post=true;
	if (isset($_POST['edit_gudang_post'])) $edit_gudang_post=true;
	if (isset($_POST['id_gudang'])) $id_gudang=$_POST['id_gudang'];
	$nama_gudang=$_POST['nama_gudang'];
}
if (isset($_POST['tambah_rak_post']) or isset($_POST['edit_rak_post'])){
	if (isset($_POST['tambah_rak_post'])) $tambah_rak_post=true;
	if (isset($_POST['edit_rak_post'])) $edit_rak_post=true;
	if (isset($_POST['id_rak'])) $id_rak=$_POST['id_rak'];
	$id_gudang=$_POST['id_gudang'];
	$nama_rak=$_POST['nama_rak'];
}
if (isset($_POST['edit_perusahaan_post'])){
	$edit_perusahaan_post=true;
	$nama_pt=$_POST['nama_pt'];
	$alamat=$_POST['alamat'];
	$id_negara=$_POST['id_negara'];
	$id_prov=$_POST['id_prov'];
	$id_kab=$_POST['id_kab'];
	(isset($_POST['id_kec']) ? $id_kec=$_POST['id_kec'] : $id_kec=0);
	(isset($_POST['id_kel']) ? $id_kel=$_POST['id_kel'] : $id_kel=0);
	(isset($_POST['kode_pos']) ? $kode_pos=$_POST['kode_pos'] : $kode_pos="");
	$telepon=$_POST['telepon'];
}

if (isset($_POST['tambah_jabatan_post']) or isset($_POST['edit_jabatan_post'])){
	if (isset($_POST['tambah_jabatan_post'])) $tambah_jabatan_post=true;
	if (isset($_POST['edit_jabatan_post'])) $edit_jabatan_post=true;
	if (isset($_POST['id_jabatan'])) $id_jabatan=$_POST['id_jabatan'];
	$jabatan=$_POST['jabatan'];
	$status=$_POST['status'];
}
if (isset($_POST['tambah_kendaraan_post']) or isset($_POST['edit_kendaraan_post'])){
	if (isset($_POST['tambah_kendaraan_post'])) $tambah_kendaraan_post=true;
	if (isset($_POST['edit_kendaraan_post'])) $edit_kendaraan_post=true;
	if (isset($_POST['id_kendaraan'])) $id_kendaraan=$_POST['id_kendaraan'];
	$nama_kendaraan=$_POST['nama_kendaraan'];
	$jenis_kendaraan=$_POST['jenis_kendaraan'];
	$id_varian=$_POST['id_varian'];
	$no_plat=$_POST['no_plat_1']. " " .$_POST['no_plat_2']. " " .$_POST['no_plat_3'];
	$perbandingan=$_POST['perbandingan'];
	$km_awal=$_POST['km_awal'];
	$status=$_POST['status'];
	$canvass=$_POST['canvass'];
}
if (isset($_POST['tambah_ekspedisi_post']) or isset($_POST['edit_ekspedisi_post'])){
	if (isset($_POST['tambah_ekspedisi_post'])) $tambah_ekspedisi_post=true;
	if (isset($_POST['edit_ekspedisi_post'])) $edit_ekspedisi_post=true;
	if (isset($_POST['id_ekspedisi'])) $id_ekspedisi=$_POST['id_ekspedisi'];
	$nama_ekspedisi=$_POST['nama_ekspedisi'];
	$telepon=$_POST['telepon'];
	$kontakperson=$_POST['kontakperson'];
	$telepon_kontak=$_POST['telepon_kontak'];
	$status=$_POST['status'];
}
if (isset($_POST['tambah_varian_post']) or isset($_POST['edit_varian_post'])){
	if (isset($_POST['tambah_varian_post'])) $tambah_varian_post=true;
	if (isset($_POST['edit_varian_post'])) $edit_varian_post=true;
	if (isset($_POST['id_varian'])) $id_varian=$_POST['id_varian'];
	$nama_jenis=$_POST['nama_jenis'];
	$nama_varian=$_POST['nama_varian'];
}
if (isset($_POST['tambah_negara_post']) or isset($_POST['edit_negara_post'])){
	if (isset($_POST['tambah_negara_post'])) $tambah_negara_post=true;
	if (isset($_POST['edit_negara_post'])) $edit_negara_post=true;
	if (isset($_POST['id_negara'])) $id_negara=$_POST['id_negara'];
	$negara=$_POST['negara'];
}
if (isset($_POST['tambah_provinsi_post']) or isset($_POST['edit_provinsi_post'])){
	if (isset($_POST['tambah_provinsi_post'])) $tambah_provinsi_post=true;
	if (isset($_POST['edit_provinsi_post'])) $edit_provinsi_post=true;
	if (isset($_POST['id_negara'])) $id_negara=$_POST['id_negara'];
	if (isset($_POST['id_prov'])) $id_prov=$_POST['id_prov'];
	$provinsi=$_POST['provinsi'];
}
if (isset($_POST['tambah_kabupaten_post']) or isset($_POST['edit_kabupaten_post'])){
	if (isset($_POST['tambah_kabupaten_post'])) $tambah_kabupaten_post=true;
	if (isset($_POST['edit_kabupaten_post'])) $edit_kabupaten_post=true;
	if (isset($_POST['id_prov'])) $id_prov=$_POST['id_prov'];
	if (isset($_POST['id_kab'])) $id_kab=$_POST['id_kab'];
	$kabupaten=$_POST['kabupaten'];
}
if (isset($_POST['tambah_kecamatan_post']) or isset($_POST['edit_kecamatan_post'])){
	if (isset($_POST['tambah_kecamatan_post'])) $tambah_kecamatan_post=true;
	if (isset($_POST['edit_kecamatan_post'])) $edit_kecamatan_post=true;
	if (isset($_POST['id_kab'])) $id_kab=$_POST['id_kab'];
	if (isset($_POST['id_kec'])) $id_kec=$_POST['id_kec'];
	$kecamatan=$_POST['kecamatan'];
}
if (isset($_POST['tambah_kelurahan_post']) or isset($_POST['edit_kelurahan_post'])){
	if (isset($_POST['tambah_kelurahan_post'])) $tambah_kelurahan_post=true;
	if (isset($_POST['edit_kelurahan_post'])) $edit_kelurahan_post=true;
	if (isset($_POST['id_kec'])) $id_kec=$_POST['id_kec'];
	if (isset($_POST['id_kel'])) $id_kel=$_POST['id_kel'];
	$kelurahan=$_POST['kelurahan'];
}

if (isset($_POST['tambah_supplier_post']) or isset($_POST['edit_supplier_post'])){
	if (isset($_POST['tambah_supplier_post'])) $tambah_supplier_post=true;
	if (isset($_POST['edit_supplier_post'])) $edit_supplier_post=true;
	if (isset($_POST['id_supplier'])) $id_supplier=$_POST['id_supplier'];
	$nama_supplier=$_POST['nama_supplier'];
	$alamat=$_POST['alamat'];
	$id_negara=$_POST['id_negara'];
	$id_prov=$_POST['id_prov'];
	$id_kab=$_POST['id_kab'];
	(isset($_POST['id_kec']) ? $id_kec=$_POST['id_kec'] : $id_kec=0);
	(isset($_POST['id_kel']) ? $id_kel=$_POST['id_kel'] : $id_kel=0);
	(isset($_POST['kode_pos']) ? $kode_pos=$_POST['kode_pos'] : $kode_pos="");
	$telepon_supplier=$_POST['telepon_supplier'];
	$kontak=$_POST['kontak'];
	$telepon_kontak=$_POST['telepon_kontak'];
	$status=$_POST['status'];
}
if (isset($_POST['tambah_pelanggan_post']) or isset($_POST['edit_pelanggan_post'])){
	if (isset($_POST['tambah_pelanggan_post'])) $tambah_pelanggan_post=true;
	if (isset($_POST['edit_pelanggan_post'])) $edit_pelanggan_post=true;
	if (isset($_POST['id_pelanggan'])) $id_pelanggan=$_POST['id_pelanggan'];
	$nama_pelanggan=$_POST['nama_pelanggan'];
	$alamat=$_POST['alamat'];
	$lat=$_POST['lat'];
	$lng=$_POST['lng'];
	$plafon=$_POST['plafon'];
	$barcode=$_POST['barcode'];
	$telepon_pelanggan=$_POST['telepon_pelanggan'];
	$kontak=$_POST['kontak'];
	$telepon_kontak=$_POST['telepon_kontak'];
	$status=$_POST['status'];
	$blacklist=$_POST['blacklist'];
}
if (isset($_POST['tambah_komponen_kas_post']) or isset($_POST['edit_komponen_kas_post'])){
	if (isset($_POST['tambah_komponen_kas_post'])) $tambah_komponen_kas_post=true;
	if (isset($_POST['edit_komponen_kas_post'])) $edit_komponen_kas_post=true;
	if (isset($_POST['id_kas_kecil'])) $id_kas_kecil=$_POST['id_kas_kecil'];
	$nama_kas_kecil=$_POST['nama_kas_kecil'];
	$jenis=$_POST['jenis'];
	$status=$_POST['status'];
}
if (isset($_POST['tambah_penjualan_post']) or isset($_POST['edit_penjualan_post'])){
	$tambah_penjualan_post=true;
	$edit_penjualan_post=true;
	$tgl_nota=$_POST['tgl_nota'];
	$invoice=$_POST['invoice'];
	$id_pelanggan=$_POST['id_pelanggan'];
	$id_karyawan=$_POST['id_karyawan'];
	$keterangan=$_POST['keterangan'];
}
if (isset($_POST['edit_diskon_nota_jual'])){
	$edit_diskon_nota_jual=true;
	$diskon_all_persen=$_POST['diskon_all_persen'];
}
if (isset($_POST['tambah_pembelian_post']) or isset($_POST['edit_pembelian_post'])){
	if (isset($_POST['tambah_pembelian_post'])) $tambah_pembelian_post=true;
	if (isset($_POST['edit_pembelian_post'])) $edit_pembelian_post=true;
	$tanggal=date("Y-m-d");
	$no_nota_beli=$_POST['no_nota_beli'];
	$id_supplier=$_POST['id_supplier'];
	if ($_POST['diskon_all']=='') {
		$diskon_all=0;
	} else {
		$diskon_all=$_POST['diskon_all'];
	}
	$ppn_all=$_POST['ppn_all'];
}
if (isset($_POST['edit_diskon_nota_beli'])){
	$edit_diskon_nota_beli=true;
	$diskon_all_persen=$_POST['diskon_all_persen'];
}
if (isset($_POST['tambah_input_kas_kecil_post'])){
	if (isset($_POST['tambah_input_kas_kecil_post'])) $tambah_input_kas_kecil_post=true;
	$tanggal=$_POST['tanggal'];
	$komponen=$_POST['komponen'];
	$keterangan=$_POST['keterangan'];
	$jenis=$_POST['jenis'];
	$jumlah=$_POST['jumlah'];
}
if (isset($_POST['tambah_mobil_canvass_post'])){
	$tambah_mobil_canvass_post=true;
	$nama_mobil=strtoupper($_POST['nama_mobil']);
	$no_plat=strtoupper($_POST['no_plat_1']). " " .$_POST['no_plat_2']. " " .strtoupper($_POST['no_plat_3']);
}
if (isset($_POST['edit_histori_kirim_barang_post'])){
	$edit_histori_kirim_barang_post=true;
	$id_jual=$_POST['id_jual'];
	$id_pengiriman=$_POST['id_pengiriman'];
	$id_ekspedisi="null";$berat_volume="null";$val_berat_volume="null";$tarif="null";
	$tanggal=date("Y-m-d",strtotime($_POST['tanggal']));
	$id_supir=$_POST['id_karyawan'];
	$jenis=$_POST['jenis'];
	if (isset($_POST['id_ekspedisi']) && $_POST['id_ekspedisi']!='') $id_ekspedisi=$_POST['id_ekspedisi'];
	if (isset($_POST['berat_volume'])) $berat_volume=$_POST['berat_volume'];
	if (isset($_POST['val_berat_volume'])) $val_berat_volume=$_POST['val_berat_volume'];
	if (isset($_POST['tarif']) && $_POST['tarif']!='') $tarif=$_POST['tarif'];
}
if (isset($_POST['edit_lap_stock_opname_post'])){
	$edit_lap_stock_opname_post=true;
	$id_laporan_stock_opname=$_POST['id_laporan_stock_opname'];
	$qty_sisa=$_POST['qty_sisa'];
	$qty_cek=$_POST['qty_cek'];
	$selisih=$qty_cek-$qty_sisa;
}
if (isset($_POST['buat_penagihan_post'])){
	$buat_penagihan_post=true;
	$id_jual=$_POST['id_jual'];
	$tanggal=date("Y-m-d");
	$penagih=$_POST['id_karyawan'];
}
if (isset($_POST['batal_penagihan_post'])){
	$batal_penagihan_post=true;
	$id_penagihan=$_POST['id_penagihan'];
}
if (isset($_POST['tambah_bayar_ekspedisi_post'])){
	$tambah_bayar_ekspedisi_post=true;
	$id_beli=$_POST['id_beli'];
	$tanggal=date("Y-m-d");
	$jumlah_bayar=$_POST['jumlah_bayar'];
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
} else {
	$mode="";
}
if (! $frameless) include "assets/inc/sidebar.php";
if (! $frameless) include "assets/inc/top.php";
if (isset($_SESSION['pesan'])){
	$pesan=$_SESSION['pesan'];
	$warna=$_SESSION['warna'];
	unset($_SESSION['pesan']);
	unset($_SESSION['warna']);
}

if(!isset($_GET['page'])){
	include "assets/page/home.php";
} else {
	$page = $_GET['page'];
	if(isset($_GET['mode'])){
		$mode=$_GET['mode'];
		include "assets/page/" . $page . "/" .$mode. ".php";
	} else {
		if (file_exists("assets/page/" . $page . ".php")){
			include "assets/page/" . $page . ".php";
		} else {
			include "assets/page/404.php";
		}
	}
}
include "assets/inc/footer.php";
?>
