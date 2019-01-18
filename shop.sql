-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 18, 2019 at 09:31 AM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.2.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id_barang` int(11) NOT NULL,
  `kode_barang` varchar(10) NOT NULL,
  `barcode` varchar(30) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `id_satuan` int(11) NOT NULL,
  `no_ijin` varchar(25) NOT NULL,
  `min_order` int(10) NOT NULL,
  `stok_minimal` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `tampil` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id_barang`, `kode_barang`, `barcode`, `nama_barang`, `id_satuan`, `no_ijin`, `min_order`, `stok_minimal`, `status`, `tampil`) VALUES
(1, '1712110001', '4970129727514', 'Barang 5 - 3', 1, 'sfcdcwef3454354354366', 1, 1, 1, 1),
(2, '1712110002', '4970129727514', 'Barang 5 - 1', 1, '13214', 2, 1, 1, 1),
(3, '1712110002', '4970129727514', 'Barang 5 - 4', 1, 'qdsqcsc', 1, 1, 1, 1),
(4, '1712130001', '4970129727514', 'Barang 5 - 2', 1, '1111111111111111111111111', 1, 1, 1, 1),
(5, '1712180001', '4970129727514', 'Barang 5 - 5', 1, '324324324324', 1, 1, 1, 1),
(6, '1712180002', '4970129727514', 'Barang 5 - 6', 1, '324234', 1, 1, 1, 1),
(7, '1712180003', '4970129727514', 'Barang 5 - 7', 1, 'sfcdcwef3454354354366', 1, 1, 1, 1),
(8, '1805100001', '4970129727514', 'Barang 5 - 8', 1, '1', 1, 1, 1, 1),
(9, '1805100002', '4970129727514', 'Barang 5 - 9', 1, '1', 1, 1, 1, 1),
(10, '1805100003', '4970129727514', 'Barang 5 - 10', 1, '1', 1, 1, 1, 1),
(11, '1805100004', '4970129727514', 'Barang 5 - 11', 1, '1', 1, 1, 1, 1),
(12, '1805100005', '4970129727514', 'Barang 5 - 12', 1, '1', 1, 1, 1, 1),
(13, '1805100006', '4970129727514', 'Barang 5 - 13', 1, '1', 1, 1, 1, 1),
(14, '1805100007', '4970129727514', 'Barang 5 - 14', 1, '1', 1, 1, 1, 1),
(15, '1805100008', '4970129727514', 'Barang 5 - 15', 1, '1', 1, 1, 1, 1),
(17, '1805100009', '4970129727514', 'Barang 5 - 16', 1, '1', 1, 1, 1, 1),
(18, '1805100010', '4970129727514', 'Barang 5 - 17', 1, '1', 1, 1, 1, 1),
(19, '1805100011', '4970129727514', 'Barang 5 - 18', 1, '1', 1, 1, 1, 1),
(20, '1805100012', '4970129727514', 'Barang 5 - 19', 1, '1', 1, 1, 1, 1),
(21, '1805100013', '4970129727514', 'Barang 5 - 20', 1, '1', 1, 1, 1, 1),
(22, '1901100001', '32516165', 'Barang', 3, '65161616', 33554, 100, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `barang_masuk`
--

CREATE TABLE `barang_masuk` (
  `id_barang_masuk` bigint(20) NOT NULL,
  `id_beli_detail` bigint(20) NOT NULL,
  `tgl_datang` date NOT NULL,
  `qty_datang` int(11) DEFAULT NULL,
  `berat` decimal(10,0) DEFAULT NULL,
  `volume` decimal(10,0) DEFAULT NULL,
  `edit` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barang_masuk`
--

INSERT INTO `barang_masuk` (`id_barang_masuk`, `id_beli_detail`, `tgl_datang`, `qty_datang`, `berat`, `volume`, `edit`) VALUES
(193, 90, '2018-02-15', 10, '800', NULL, 0),
(194, 91, '2018-02-15', 10, '800', NULL, 0),
(195, 92, '2018-02-15', 10, '800', NULL, 0),
(196, 93, '2018-02-15', 5, '800', NULL, 0),
(197, 94, '2018-02-15', 5, '2800', NULL, 0),
(198, 96, '2018-02-15', 1, '800', NULL, 0),
(199, 97, '2018-02-15', 1, NULL, '800', 0),
(200, 98, '2018-02-15', 1, '800', NULL, 0),
(201, 100, '2018-03-24', 50, '800', NULL, 0),
(202, 100, '2018-03-24', 50, '8000', NULL, 0),
(203, 101, '2018-03-24', 50, '800', NULL, 0),
(204, 101, '2018-03-24', 50, '800', NULL, 0),
(232, 140, '2018-05-14', 50, '800', NULL, 0),
(233, 140, '2018-05-14', 50, '800', NULL, 0),
(234, 141, '2018-05-14', 100, '800', NULL, 0),
(235, 142, '2018-05-14', 100, '800', NULL, 0),
(236, 143, '2018-05-14', 50, '800', NULL, 0),
(237, 144, '2018-05-14', 100, '800', NULL, 0),
(238, 145, '2018-05-14', 50, '800', NULL, 0),
(239, 146, '2018-05-14', 100, '800', NULL, 0),
(240, 147, '2018-05-14', 100, '800', NULL, 0),
(241, 148, '2018-05-14', 100, '800', NULL, 0),
(242, 150, '2018-05-14', 100, '800', NULL, 0),
(243, 151, '2018-05-14', 100, '800', NULL, 0),
(244, 154, '2018-05-14', 100, '800', NULL, 0),
(245, 155, '2018-05-31', 1, '600', NULL, 0),
(246, 157, '2018-05-31', 5, '60000', NULL, 0),
(247, 161, '2018-06-12', 100, '800', NULL, 0),
(248, 162, '2018-06-12', 100, '8000', NULL, 0),
(249, 165, '2018-06-22', 100, '8000', NULL, 0),
(250, 166, '2018-06-22', 10, '800', NULL, 0),
(251, 167, '2018-06-22', 5, '8000', NULL, 0),
(252, 170, '2018-06-22', 6, '8000', NULL, 0),
(253, 159, '2018-06-25', 25, '10000', NULL, 0),
(254, 160, '2018-06-25', 20, NULL, '9000', 0),
(255, 163, '2018-06-26', 2, NULL, '11000', 0),
(256, 163, '2018-06-26', 3, NULL, '11000', 0),
(257, 164, '2018-06-27', 1, NULL, NULL, 1),
(258, 175, '2018-06-29', 10, NULL, '1000000', 0),
(259, 176, '2018-06-29', 9, '300000', NULL, 0),
(260, 174, '2018-06-29', 10, NULL, NULL, 1),
(268, 177, '2018-07-03', 100, '8000', NULL, 0),
(269, 179, '2018-07-03', 100, '1000', NULL, 0),
(272, 182, '2018-07-04', 20, NULL, '8000', 0),
(275, 183, '2018-07-04', 8, '8000', NULL, 0),
(276, 184, '2018-07-04', 100, '8000', NULL, 0),
(277, 186, '2018-07-04', 100, NULL, '8000', 0),
(278, 187, '2018-07-09', 100, '8000', NULL, 0),
(279, 188, '2018-07-09', 50, '8000', NULL, 0),
(280, 188, '2018-07-09', 50, '8000', NULL, 0),
(281, 213, '2018-12-28', 50, '100000', NULL, 0),
(282, 213, '2018-12-28', 50, '100000', NULL, 0),
(283, 214, '2018-12-28', 20, '20000', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `barang_masuk_rak`
--

CREATE TABLE `barang_masuk_rak` (
  `id_barang_masuk_rak` bigint(20) NOT NULL,
  `id_barang_masuk` bigint(20) NOT NULL,
  `qty_di_rak` int(11) NOT NULL,
  `id_rak` int(11) NOT NULL,
  `expire` date NOT NULL,
  `stok` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barang_masuk_rak`
--

INSERT INTO `barang_masuk_rak` (`id_barang_masuk_rak`, `id_barang_masuk`, `qty_di_rak`, `id_rak`, `expire`, `stok`) VALUES
(16, 193, 10, 7, '2022-02-27', 10),
(17, 194, 10, 7, '2022-02-22', 0),
(18, 195, 10, 7, '2022-02-22', 0),
(19, 196, 5, 7, '2022-02-22', 0),
(20, 197, 5, 7, '2022-02-22', 0),
(21, 198, 1, 7, '2022-02-22', 0),
(22, 199, 1, 7, '2022-02-22', 0),
(23, 200, 1, 7, '2022-02-22', 0),
(24, 201, 50, 7, '2022-02-22', 0),
(25, 202, 50, 7, '2022-02-22', 0),
(26, 203, 50, 7, '2022-02-22', 0),
(27, 204, 50, 7, '2022-02-22', 14),
(56, 232, 50, 7, '2022-02-22', 0),
(57, 233, 50, 7, '2022-02-22', 0),
(58, 234, 100, 7, '2022-02-22', 100),
(59, 235, 100, 6, '2022-02-22', 100),
(60, 236, 50, 7, '2022-02-22', 50),
(61, 237, 100, 7, '2022-02-22', 91),
(62, 238, 50, 7, '2022-02-22', 50),
(63, 239, 100, 7, '2022-02-22', 100),
(64, 240, 100, 7, '2022-02-22', 99),
(65, 241, 100, 7, '2022-02-22', 100),
(66, 242, 100, 7, '2022-02-22', 100),
(67, 243, 100, 7, '2022-02-22', 98),
(68, 244, 100, 7, '2022-02-22', 100),
(71, 245, 1, 7, '2022-02-22', 1),
(72, 246, 1, 7, '2022-02-22', 1),
(73, 246, 3, 7, '2022-02-22', 1),
(74, 246, 1, 7, '2022-02-22', 1),
(77, 247, 100, 7, '2022-02-22', 100),
(78, 248, 100, 7, '2022-02-22', 100),
(84, 249, 100, 7, '2023-02-22', 100),
(85, 250, 10, 3, '2023-02-22', 10),
(86, 251, 5, 7, '2022-02-22', 5),
(87, 252, 6, 7, '2022-02-22', 6),
(98, 253, 10, 7, '2022-02-22', 0),
(99, 253, 15, 7, '2022-02-22', 1),
(100, 254, 20, 7, '2022-02-22', 20),
(101, 255, 2, 7, '2022-02-22', 2),
(102, 256, 3, 7, '2022-02-22', 3),
(103, 258, 10, 7, '2022-02-22', 10),
(104, 259, 5, 7, '2022-02-22', 5),
(105, 259, 4, 7, '2022-02-22', 4),
(107, 260, 4, 7, '2022-02-22', 4),
(112, 268, 50, 7, '2022-02-22', 50),
(116, 269, 100, 7, '2022-02-22', 98),
(120, 272, 20, 7, '2022-02-02', 20),
(124, 275, 8, 7, '2022-02-22', 8),
(129, 276, 100, 7, '2022-02-22', 100),
(130, 277, 50, 7, '2022-02-22', 50),
(131, 277, 50, 7, '2022-02-22', 50),
(132, 278, 100, 7, '2022-02-22', 100),
(133, 279, 50, 7, '2022-02-22', 50),
(134, 280, 50, 7, '2022-02-22', 50),
(135, 243, 0, 7, '2018-10-19', 1),
(136, 198, 0, 7, '2018-12-07', 1),
(137, 281, 25, 7, '2020-10-10', 25),
(138, 281, 25, 3, '2020-12-15', 25),
(139, 282, 50, 3, '2020-12-20', 50),
(140, 283, 20, 3, '2020-02-20', 20);

-- --------------------------------------------------------

--
-- Table structure for table `barang_supplier`
--

CREATE TABLE `barang_supplier` (
  `id_barang_supplier` int(11) NOT NULL,
  `id_barang` int(11) DEFAULT NULL,
  `id_supplier` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barang_supplier`
--

INSERT INTO `barang_supplier` (`id_barang_supplier`, `id_barang`, `id_supplier`) VALUES
(2, 1, 2),
(3, 2, 1),
(4, 2, 5),
(6, 1, 11),
(9, 7, 9),
(10, 4, 1),
(11, 6, 1),
(12, 3, 1),
(13, 21, 1),
(14, 20, 1),
(15, 19, 1),
(16, 18, 1),
(17, 17, 1),
(18, 15, 1),
(19, 14, 1),
(20, 11, 1),
(21, 5, 1),
(22, 1, 1),
(23, 7, 1),
(24, 8, 1),
(25, 9, 1),
(26, 10, 1),
(27, 12, 1),
(28, 13, 1),
(29, 1, 9),
(30, 1, 10),
(31, 22, 12),
(32, 21, 13);

-- --------------------------------------------------------

--
-- Table structure for table `batal_kirim`
--

CREATE TABLE `batal_kirim` (
  `id_batal_kirim` int(11) NOT NULL,
  `id_karyawan` int(11) DEFAULT NULL,
  `id_jual` int(11) DEFAULT NULL,
  `jumlah` double DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `tanggal` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `batal_kirim_detail`
--

CREATE TABLE `batal_kirim_detail` (
  `id_batal_kirim_detail` int(11) NOT NULL,
  `id_batal_kirim` int(11) DEFAULT NULL,
  `id_jual_detail` int(11) DEFAULT NULL,
  `id_barang_masuk_rak` int(11) DEFAULT NULL,
  `qty_ambil` int(11) DEFAULT NULL,
  `expire` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `batal_kirim_detail_2`
--

CREATE TABLE `batal_kirim_detail_2` (
  `id_batal_kirim_detail_id` int(11) NOT NULL,
  `id_batal_kirim_detail` int(11) DEFAULT NULL,
  `id_rak` int(11) DEFAULT NULL,
  `qty_balik` double DEFAULT NULL,
  `id_bmr` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bayar_ekspedisi`
--

CREATE TABLE `bayar_ekspedisi` (
  `id_bayar_ekspedisi` int(11) NOT NULL,
  `id_beli` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bayar_ekspedisi`
--

INSERT INTO `bayar_ekspedisi` (`id_bayar_ekspedisi`, `id_beli`, `status`) VALUES
(1, 27, 2),
(2, 31, 0),
(3, 50, 0),
(4, 29, 0),
(5, 28, 0),
(6, 26, 0);

-- --------------------------------------------------------

--
-- Table structure for table `bayar_ekspedisi_detail`
--

CREATE TABLE `bayar_ekspedisi_detail` (
  `id_bayar_ekspedisi_detail` int(11) NOT NULL,
  `id_bayar_ekspedisi` int(11) DEFAULT NULL,
  `tgl_bayar` date DEFAULT NULL,
  `jumlah_bayar` float DEFAULT NULL,
  `sisa` double NOT NULL,
  `stat` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bayar_ekspedisi_detail`
--

INSERT INTO `bayar_ekspedisi_detail` (`id_bayar_ekspedisi_detail`, `id_bayar_ekspedisi`, `tgl_bayar`, `jumlah_bayar`, `sisa`, `stat`) VALUES
(19, 1, '2019-01-17', 500, 999500, 1),
(20, 1, '2019-01-17', 1000, 998500, 1),
(22, 1, '2019-01-17', 998500, 0, 2);

-- --------------------------------------------------------

--
-- Table structure for table `bayar_nota_beli`
--

CREATE TABLE `bayar_nota_beli` (
  `id_bayar` bigint(20) NOT NULL,
  `tgl_bayar` date DEFAULT NULL,
  `no_nota_beli` varchar(15) DEFAULT NULL,
  `jenis` enum('Transfer','Tunai','Retur','Giro') DEFAULT NULL,
  `jumlah` double DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `pengirim_bank` varchar(50) DEFAULT NULL,
  `pengirim_nama` varchar(100) DEFAULT NULL,
  `pengirim_no` varchar(20) DEFAULT NULL,
  `penerima_bank` varchar(50) DEFAULT NULL,
  `penerima_nama` varchar(100) DEFAULT NULL,
  `penerima_no` varchar(20) DEFAULT NULL,
  `jatuh_tempo` date DEFAULT NULL,
  `keterangan` varchar(100) DEFAULT NULL,
  `sisa` double DEFAULT NULL,
  `status_giro` tinyint(1) DEFAULT NULL,
  `now` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bayar_nota_beli`
--

INSERT INTO `bayar_nota_beli` (`id_bayar`, `tgl_bayar`, `no_nota_beli`, `jenis`, `jumlah`, `status`, `pengirim_bank`, `pengirim_nama`, `pengirim_no`, `penerima_bank`, `penerima_nama`, `penerima_no`, `jatuh_tempo`, `keterangan`, `sisa`, `status_giro`, `now`) VALUES
(13, '2019-01-18', 'NB-0001', 'Tunai', 625000, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 23000000, 0, 2),
(18, '2019-01-18', 'NB-0001', 'Tunai', 3000000, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 20000000, NULL, 2);

-- --------------------------------------------------------

--
-- Table structure for table `bayar_nota_beli_detail`
--

CREATE TABLE `bayar_nota_beli_detail` (
  `id_bayar_detail` bigint(20) NOT NULL,
  `id_bayar` bigint(20) DEFAULT NULL,
  `no_retur_beli` varchar(13) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bayar_nota_jual`
--

CREATE TABLE `bayar_nota_jual` (
  `id_bayar` bigint(20) NOT NULL,
  `tgl_bayar` date DEFAULT NULL,
  `no_nota_jual` varchar(15) DEFAULT NULL,
  `jenis` enum('Transfer','Tunai','Retur','Giro') DEFAULT NULL,
  `jumlah` double DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `pengirim_bank` varchar(50) DEFAULT NULL,
  `pengirim_nama` varchar(100) DEFAULT NULL,
  `pengirim_no` varchar(20) DEFAULT NULL,
  `penerima_bank` varchar(50) DEFAULT NULL,
  `penerima_nama` varchar(100) DEFAULT NULL,
  `penerima_no` varchar(20) DEFAULT NULL,
  `jatuh_tempo` date DEFAULT NULL,
  `keterangan` varchar(100) DEFAULT NULL,
  `status_giro` tinyint(1) DEFAULT NULL,
  `sisa` double NOT NULL,
  `now` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bayar_nota_jual`
--

INSERT INTO `bayar_nota_jual` (`id_bayar`, `tgl_bayar`, `no_nota_jual`, `jenis`, `jumlah`, `status`, `pengirim_bank`, `pengirim_nama`, `pengirim_no`, `penerima_bank`, `penerima_nama`, `penerima_no`, `jatuh_tempo`, `keterangan`, `status_giro`, `sisa`, `now`) VALUES
(42, '2019-01-18', 'NJ-180907-002', 'Tunai', 9690000, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 30000000, 2),
(49, '2019-01-18', 'NJ-180907-002', 'Giro', 10000000, 2, 'a', 's', '2', 'a', 'a', '2', '2019-02-22', '', 1, 20000000, 2);

-- --------------------------------------------------------

--
-- Table structure for table `bayar_nota_jual_detail`
--

CREATE TABLE `bayar_nota_jual_detail` (
  `id_bayar_detail` bigint(20) NOT NULL,
  `id_bayar` bigint(20) DEFAULT NULL,
  `no_retur_jual` varchar(13) DEFAULT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `beli`
--

CREATE TABLE `beli` (
  `id_beli` int(11) NOT NULL,
  `no_nota_beli` varchar(15) NOT NULL,
  `tanggal` date NOT NULL,
  `id_supplier` int(11) NOT NULL,
  `id_ekspedisi` int(11) DEFAULT NULL,
  `id_karyawan` int(11) DEFAULT NULL,
  `berat_ekspedisi` int(11) DEFAULT NULL,
  `volume_ekspedisi` int(11) DEFAULT NULL,
  `tarif_ekspedisi` int(11) DEFAULT NULL,
  `keterangan` varchar(100) DEFAULT NULL,
  `status_konfirm` tinyint(1) NOT NULL,
  `diskon_all_persen` double DEFAULT NULL,
  `ppn_all_persen` double DEFAULT NULL,
  `hidden` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `beli`
--

INSERT INTO `beli` (`id_beli`, `no_nota_beli`, `tanggal`, `id_supplier`, `id_ekspedisi`, `id_karyawan`, `berat_ekspedisi`, `volume_ekspedisi`, `tarif_ekspedisi`, `keterangan`, `status_konfirm`, `diskon_all_persen`, `ppn_all_persen`, `hidden`) VALUES
(26, 'NB-0001', '2018-02-15', 1, 1, 2, 8000, NULL, 1000000, NULL, 1, 10, 5, 1),
(27, 'NB-0002', '2018-02-15', 1, 1, 2, NULL, NULL, 1000000, NULL, 1, 0, 0, 0),
(28, 'NB-0003', '2018-02-15', 1, 1, 6, NULL, NULL, 1000000, NULL, 1, 0, 0, 0),
(29, 'NB-0004', '2018-02-15', 1, 1, 2, NULL, NULL, 1000000, NULL, 1, 0, 0, 0),
(31, 'INV-2387283', '2018-03-24', 1, 1, 2, NULL, NULL, 1000000, NULL, 1, 0, 0, 0),
(36, 'nb-9000', '2018-05-14', 1, 1, 2, NULL, NULL, 1000000, NULL, 2, 0, 0, 0),
(37, 'nb-000', '2018-05-31', 1, 1, 2, NULL, NULL, 1000000, NULL, 2, 0, 0, 0),
(39, 'nb-0000078', '2018-06-08', 1, 1, 2, NULL, NULL, 1000000, NULL, 1, 0, 0, 0),
(40, 'nb-89999', '2018-06-12', 1, 1, 3, NULL, NULL, 1000000, NULL, 1, 0, 0, 0),
(41, 'nb-009', '2018-06-12', 1, 1, 3, NULL, NULL, 1000000, NULL, 1, 0, 0, 0),
(42, 'nb-999ew3', '2018-06-12', 10, 1, 2, NULL, NULL, 1000000, NULL, 2, 0, 0, 0),
(43, 'NB-000087', '2018-06-22', 1, 1, 3, NULL, NULL, 1000000, NULL, 1, 0, 0, 0),
(44, 'NB-98U', '2018-06-22', 1, 1, 3, NULL, NULL, 1000000, NULL, 1, 0, 0, 0),
(45, 'nb-000478', '2018-06-22', 1, 1, 3, NULL, NULL, 1000000, NULL, 2, 0, 0, 0),
(46, 'nb-000234', '2018-06-22', 1, 1, 3, 8000, 0, 1000000, NULL, 1, 0, 0, 0),
(47, 'nb-098732', '2018-06-27', 1, 1, 2, NULL, NULL, 1000000, NULL, 0, 0, 0, 0),
(48, 'nb-987632', '2018-06-27', 1, 1, 2, NULL, NULL, 1000000, NULL, 0, 0, 0, 0),
(49, 'nb-11111', '2018-06-29', 1, 1, 2, NULL, NULL, 1000000, NULL, 2, 0, 0, 0),
(50, 'nb-745', '2018-06-29', 1, 1, 2, 300000, 1000000, 5500000, NULL, 1, 0, 0, 0),
(51, 'nb-74527', '2018-07-03', 1, 1, 5, 8000, 0, 500000, NULL, 1, 0, 0, 0),
(52, 'nb-4354656', '2018-07-03', 1, 1, 2, 1000, 0, 500000, NULL, 1, 0, 0, 0),
(53, 'NB-237236', '2018-07-04', 1, 1, 2, 0, 8000, 500000, NULL, 1, 0, 0, 0),
(54, 'NB-68778', '2018-07-04', 1, 1, 2, 8000, 0, 1000000, NULL, 1, 0, 0, 0),
(55, 'NB-00978776', '2018-07-04', 1, 1, 2, 8000, 0, 500000, NULL, 1, 0, 0, 0),
(56, 'NB-786', '2018-07-04', 1, 1, 2, 0, 8000, 500000, NULL, 1, 0, 0, 0),
(57, 'nb-06766554', '2018-07-09', 1, 1, 2, 16000, 0, 500000, NULL, 1, 0, 10, 0),
(58, 'nb-783646257', '2018-08-27', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(59, 'nb-6247563', '2018-08-27', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(60, 'nb-3974835', '2018-08-27', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(63, 'nb-ue74653', '2018-08-27', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(64, 'nb-000156b', '2018-09-12', 1, 1, 5, NULL, NULL, NULL, NULL, 0, 15, 10, 0),
(66, 'nb-93479', '2018-10-24', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, 2.5, 10, 0),
(67, 'njnajnz', '2018-12-03', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, 10, 10, 0),
(68, 'nb-9894234', '2018-12-08', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, 10, 10, 0),
(69, 'nj-374863', '2018-12-19', 1, 1, 6, NULL, NULL, NULL, NULL, 0, 0, 0, 0),
(71, 'nb-3u28423847', '2018-12-28', 1, 1, 2, 120000, 0, 1000000, NULL, 1, 10, 0, 0),
(72, 'nb-092039829', '2018-12-28', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, 7.6, 0, 0),
(74, 'GH-5350280', '2019-01-10', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, 7.6, 10, 0),
(75, 'KT-8977979', '2019-01-11', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, 8.7, 10, 0),
(76, 'UT-7698797', '2019-01-15', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, 7, 10, 0),
(77, 'UG-6987897', '2019-01-15', 1, 1, 2, NULL, NULL, NULL, NULL, 0, 4.92, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `beli_detail`
--

CREATE TABLE `beli_detail` (
  `id_beli_detail` bigint(20) NOT NULL,
  `id_beli` int(11) NOT NULL,
  `id_barang_supplier` int(15) NOT NULL,
  `qty` int(11) NOT NULL,
  `harga` double NOT NULL,
  `status_barang` tinyint(1) NOT NULL,
  `diskon_persen` double DEFAULT NULL,
  `diskon_rp` double DEFAULT NULL,
  `diskon_persen_2` double DEFAULT NULL,
  `diskon_rp_2` double DEFAULT NULL,
  `diskon_persen_3` double DEFAULT NULL,
  `diskon_rp_3` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `beli_detail`
--

INSERT INTO `beli_detail` (`id_beli_detail`, `id_beli`, `id_barang_supplier`, `qty`, `harga`, `status_barang`, `diskon_persen`, `diskon_rp`, `diskon_persen_2`, `diskon_rp_2`, `diskon_persen_3`, `diskon_rp_3`) VALUES
(90, 26, 3, 10, 1000000, 1, 0, 0, 0, 0, 0, 0),
(91, 26, 10, 10, 1000000, 1, 0, 0, 0, 0, 0, 0),
(92, 26, 11, 10, 500000, 1, 0, 0, 0, 0, 0, 0),
(93, 27, 10, 5, 1000000, 1, 0, 0, 0, 0, 0, 0),
(94, 27, 3, 5, 1000000, 1, 0, 0, 0, 0, 0, 0),
(95, 28, 3, 3, 1000000, 1, 0, 0, 0, 0, 0, 0),
(96, 29, 3, 1, 1000, 1, 0, 0, 0, 0, 0, 0),
(97, 29, 10, 1, 1000, 1, 0, 0, 0, 0, 0, 0),
(98, 29, 11, 1, 1000, 1, 0, 0, 0, 0, 0, 0),
(100, 31, 3, 100, 1000000, 1, 0, 0, 0, 0, 0, 0),
(101, 31, 10, 100, 1000000, 1, 0, 0, 0, 0, 0, 0),
(140, 36, 3, 100, 1000000, 1, 0, 0, 0, 0, 0, 0),
(141, 36, 10, 100, 1000000, 1, 0, 0, 0, 0, 0, 0),
(142, 36, 22, 100, 1000000, 1, 0, 0, 0, 0, 0, 0),
(143, 36, 12, 100, 1000000, 2, 0, 0, 0, 0, 0, 0),
(144, 36, 11, 100, 1000000, 1, 0, 0, 0, 0, 0, 0),
(145, 36, 23, 100, 1000000, 2, 0, 0, 0, 0, 0, 0),
(146, 36, 24, 100, 1000000, 1, 0, 0, 0, 0, 0, 0),
(147, 36, 25, 100, 1000000, 1, 0, 0, 0, 0, 0, 0),
(148, 36, 26, 100, 1000000, 1, 0, 0, 0, 0, 0, 0),
(150, 36, 20, 100, 1000000, 1, 0, 0, 0, 0, 0, 0),
(151, 36, 27, 100, 1000000, 1, 0, 0, 0, 0, 0, 0),
(152, 36, 28, 100, 1000000, 0, 0, 0, 0, 0, 0, 0),
(153, 36, 19, 100, 1000000, 0, 0, 0, 0, 0, 0, 0),
(154, 36, 18, 100, 1000000, 1, 0, 0, 0, 0, 0, 0),
(155, 37, 22, 1, 100000, 1, 0, 0, 0, 0, 0, 0),
(156, 37, 12, 6, 1000000, 0, 0, 0, 0, 0, 0, 0),
(157, 37, 22, 5, 1000000, 1, 0, 0, 0, 0, 0, 0),
(158, 37, 22, 2, 0, 0, 0, 0, 0, 0, 0, 0),
(159, 39, 3, 25, 1000000, 1, 0, 0, 0, 0, 0, 0),
(160, 39, 10, 20, 1000000, 1, 0, 0, 0, 0, 0, 0),
(161, 40, 3, 100, 1000000, 1, 0, 0, 0, 0, 0, 0),
(162, 40, 10, 100, 1100000, 1, 0, 0, 0, 0, 0, 0),
(163, 41, 3, 5, 10000, 1, 0, 0, 0, 0, 0, 0),
(164, 42, 30, 1, 2, 2, 0, 0, 0, 0, 0, 0),
(165, 43, 3, 100, 1000000, 1, 0, 0, 0, 0, 0, 0),
(166, 44, 3, 10, 1000000, 1, 0, 0, 0, 0, 0, 0),
(167, 45, 3, 5, 100000, 2, 0, 0, 0, 0, 0, 0),
(170, 46, 3, 7, 150000, 2, 0, 0, 0, 0, 0, 0),
(171, 47, 3, 100, 1000000, 0, 0, 0, 0, 0, 0, 0),
(173, 48, 3, 10, 1000000, 0, 0, 0, 0, 0, 0, 0),
(174, 49, 3, 100, 1000000, 2, 0, 0, 0, 0, 0, 0),
(175, 50, 22, 10, 1000000, 1, 0, 0, 0, 0, 0, 0),
(176, 50, 12, 10, 1000000, 2, 0, 0, 0, 0, 0, 0),
(177, 51, 3, 100, 1000000, 1, 0, 0, 0, 0, 0, 0),
(179, 52, 21, 100, 1000000, 1, 0, 0, 0, 0, 0, 0),
(181, 52, 12, 10, 1000000, 0, 0, 0, 0, 0, 0, 0),
(182, 53, 12, 100, 1000000, 2, 0, 0, 0, 0, 0, 0),
(183, 54, 12, 10, 1000000, 2, 0, 0, 0, 0, 0, 0),
(184, 55, 3, 100, 1000000, 1, 0, 0, 0, 0, 0, 0),
(186, 56, 27, 100, 1000000, 1, 0, 0, 0, 0, 0, 0),
(187, 57, 21, 100, 1000000, 1, 0, 0, 0, 0, 0, 0),
(188, 57, 11, 100, 1000000, 1, 0, 0, 0, 0, 0, 0),
(189, 58, 20, 511, 10000, 0, 0, 0, 0, 0, 0, 0),
(190, 58, 20, 2, 11000, 0, 0, 0, 0, 0, 0, 0),
(191, 58, 20, 10, 0, 0, 0, 0, 0, 0, 0, 0),
(192, 59, 17, 2, 10000, 0, 0, 0, 0, 0, 0, 0),
(193, 59, 17, 3, 9000, 0, 0, 0, 0, 0, 0, 0),
(194, 60, 17, 1, 0, 0, 0, 0, 0, 0, 0, 0),
(195, 63, 13, 10, 10000, 0, 0, 0, 0, 0, 0, 0),
(196, 63, 14, 5, 5000, 0, 0, 0, 0, 0, 0, 0),
(197, 64, 3, 10, 1000000, 0, 0, 0, 0, 0, 0, 0),
(198, 64, 12, 10, 1200000, 0, 0, 0, 0, 0, 0, 0),
(199, 64, 22, 10, 1000000, 0, 0, 0, 0, 0, 0, 0),
(200, 66, 3, 10, 1000000, 0, 0, 0, 0, 0, 0, 0),
(202, 67, 22, 100, 1000000, 0, 0, 0, 0, 0, 0, 0),
(206, 68, 22, 12, 100000, 0, 0, 0, 0, 0, 0, 0),
(211, 69, 22, 12, 100000, 0, 0, 0, 0, 0, 0, 0),
(212, 69, 3, 10, 200000, 0, 0, 0, 0, 0, 0, 0),
(213, 71, 3, 100, 100000, 1, 10, 10000, 5, 4500, 5.3, 4531.5),
(214, 71, 10, 20, 16464, 1, 2.5, 411.6, 17, 2728.908, 2, 266.46984),
(216, 72, 22, 10, 100000.15, 0, 20.68, 20680.03102, 4.78, 3791.501687244, 1.99, 1503.0194841258),
(217, 72, 10, 65, 5464, 0, 1, 54.64, 5.89, 318.611304, 13, 661.79733048),
(218, 72, 10, 675, 134568, 0, 10, 13456.8, 5, 6055.56, 6, 6903.3384),
(219, 72, 13, 9, 8844, 0, 58.68, 5189.6592, 0, 0, 0, 0),
(220, 74, 3, 65, 5464.78, 0, 1, 54.6478, 5.89, 318.65678658, 13, 661.8918037446),
(221, 74, 10, 10, 100000.15, 0, 20.68, 20680.03102, 4.78, 3791.501687244, 1.99, 1503.0194841258),
(222, 74, 11, 675, 134568, 0, 10, 13456.8, 5, 6055.56, 6, 6903.3384),
(223, 74, 12, 9, 8844, 0, 58.68, 5189.6592, 0, 0, 0, 0),
(224, 75, 12, 8, 15336.36, 0, 5.7, 874.17252, 7, 1012.3531236, 10, 1344.98343564),
(225, 76, 10, 8, 152300, 0, 1, 1523, 2, 3015.54, 3, 4432.8438),
(226, 77, 3, 5, 563000, 0, 1, 5630, 2, 11147.4, 3, 16386.678);

-- --------------------------------------------------------

--
-- Table structure for table `bonus`
--

CREATE TABLE `bonus` (
  `id_bonus` int(11) NOT NULL,
  `tanggal_bonus` date DEFAULT NULL,
  `id_karyawan` int(11) DEFAULT NULL,
  `jumlah_bonus` float DEFAULT NULL,
  `jenis_bonus` enum('GAJI','TUNAI') DEFAULT NULL,
  `keterangan` varchar(200) DEFAULT NULL,
  `status_bonus_gaji` char(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bonus`
--

INSERT INTO `bonus` (`id_bonus`, `tanggal_bonus`, `id_karyawan`, `jumlah_bonus`, `jenis_bonus`, `keterangan`, `status_bonus_gaji`) VALUES
(1, '2018-07-07', 2, 200000, 'TUNAI', 'aa', '1'),
(2, '2018-07-07', 1, 2300000, 'GAJI', 'ADADA', '0');

-- --------------------------------------------------------

--
-- Table structure for table `bonus_gaji`
--

CREATE TABLE `bonus_gaji` (
  `id_bonus_gaji` int(11) NOT NULL,
  `id_penggajian_detail` int(11) DEFAULT NULL,
  `id_bonus` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `canvass_belum_siap`
--

CREATE TABLE `canvass_belum_siap` (
  `id_canvass_belum_siap` int(11) NOT NULL,
  `id_canvass_keluar` int(11) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `id_jual` int(11) DEFAULT NULL,
  `status` varchar(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `canvass_belum_siap`
--

INSERT INTO `canvass_belum_siap` (`id_canvass_belum_siap`, `id_canvass_keluar`, `tanggal`, `id_jual`, `status`) VALUES
(1, 1, '2018-09-12', 8, '0'),
(2, 1, '2018-12-27', 17, '0'),
(3, 1, '2018-12-27', 18, '0'),
(4, 1, '2018-12-27', 19, '0'),
(5, 1, '2018-12-27', 20, '0'),
(6, 1, '2018-12-27', 21, '0'),
(7, 1, '2018-12-27', 22, '0'),
(8, 1, '2018-12-27', 23, '0'),
(9, 1, '2018-12-28', 25, '0');

-- --------------------------------------------------------

--
-- Table structure for table `canvass_keluar`
--

CREATE TABLE `canvass_keluar` (
  `id_canvass_keluar` int(11) NOT NULL,
  `tanggal_canvass` date DEFAULT NULL,
  `id_mobil` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `canvass_keluar`
--

INSERT INTO `canvass_keluar` (`id_canvass_keluar`, `tanggal_canvass`, `id_mobil`, `status`) VALUES
(1, '2018-09-12', 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `canvass_keluar_barang`
--

CREATE TABLE `canvass_keluar_barang` (
  `id_canvass_keluar_barang` int(11) NOT NULL,
  `id_canvass_keluar` int(11) DEFAULT NULL,
  `tanggal_ambil` date DEFAULT NULL,
  `id_barang_masuk_rak` int(11) DEFAULT NULL,
  `id_barang` int(11) DEFAULT NULL,
  `id_rak` int(11) DEFAULT NULL,
  `expire` date DEFAULT NULL,
  `qty` double DEFAULT NULL,
  `qty_cek` double DEFAULT NULL,
  `stok` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `canvass_keluar_barang`
--

INSERT INTO `canvass_keluar_barang` (`id_canvass_keluar_barang`, `id_canvass_keluar`, `tanggal_ambil`, `id_barang_masuk_rak`, `id_barang`, `id_rak`, `expire`, `qty`, `qty_cek`, `stok`) VALUES
(1, 1, '2018-09-12', 56, 2, 7, '2022-02-22', 40, 40, 30),
(2, 1, '2018-09-12', 57, 2, 7, '2022-02-22', 36, 36, 36),
(3, 1, '2018-09-12', 98, 2, 7, '2022-02-22', 10, 10, 10),
(4, 1, '2018-09-12', 99, 2, 7, '2022-02-22', 14, 14, 14),
(5, 1, '2018-09-12', 17, 4, 7, '2022-02-22', 10, 10, 8),
(6, 1, '2018-09-12', 19, 4, 7, '2022-02-22', 3, 3, 3),
(7, 1, '2018-09-12', 22, 4, 7, '2022-02-22', 1, 1, 1),
(8, 1, '2018-09-12', 26, 4, 7, '2022-02-22', 50, 50, 50),
(9, 1, '2018-09-12', 27, 4, 7, '2022-02-22', 36, 36, 36);

-- --------------------------------------------------------

--
-- Table structure for table `canvass_keluar_karyawan`
--

CREATE TABLE `canvass_keluar_karyawan` (
  `id_canvass_keluar_karyawan` int(11) NOT NULL,
  `id_canvass_keluar` int(11) DEFAULT NULL,
  `id_karyawan` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `canvass_keluar_karyawan`
--

INSERT INTO `canvass_keluar_karyawan` (`id_canvass_keluar_karyawan`, `id_canvass_keluar`, `id_karyawan`) VALUES
(1, 1, 1),
(2, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `canvass_mutasi_mobil_gudang`
--

CREATE TABLE `canvass_mutasi_mobil_gudang` (
  `id_canvass_mutasi_mobil_gudang` int(11) NOT NULL,
  `id_canvass_keluar` int(11) DEFAULT NULL,
  `tanggal_ambil` date DEFAULT NULL,
  `id_barang_masuk_rak` int(11) DEFAULT NULL,
  `id_barang` int(11) DEFAULT NULL,
  `id_rak` int(11) DEFAULT NULL,
  `expire` date DEFAULT NULL,
  `qty_cek2` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `canvass_siap_kirim`
--

CREATE TABLE `canvass_siap_kirim` (
  `id_canvass_siap_kirim` int(11) NOT NULL,
  `id_canvass_keluar` int(11) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `id_jual` int(11) DEFAULT NULL,
  `status` varchar(1) DEFAULT '0',
  `id_karyawan` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `canvass_siap_kirim`
--

INSERT INTO `canvass_siap_kirim` (`id_canvass_siap_kirim`, `id_canvass_keluar`, `tanggal`, `id_jual`, `status`, `id_karyawan`) VALUES
(1, 1, '2018-09-12', 8, '2', 3),
(2, 1, '2018-12-28', 23, '0', 3);

-- --------------------------------------------------------

--
-- Table structure for table `canvass_siap_kirim_detail`
--

CREATE TABLE `canvass_siap_kirim_detail` (
  `id_canvass_siap_kirim_detail` int(11) NOT NULL,
  `id_canvass_siap_kirim` int(11) DEFAULT NULL,
  `id_jual_detail` int(11) DEFAULT NULL,
  `id_barang_masuk_rak` int(11) DEFAULT NULL,
  `qty_ambil` double DEFAULT NULL,
  `cek` tinyint(1) DEFAULT NULL,
  `expire` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `canvass_siap_kirim_detail`
--

INSERT INTO `canvass_siap_kirim_detail` (`id_canvass_siap_kirim_detail`, `id_canvass_siap_kirim`, `id_jual_detail`, `id_barang_masuk_rak`, `qty_ambil`, `cek`, `expire`) VALUES
(1, 1, 10, 17, 2, 0, '2022-02-22'),
(2, 1, 11, 56, 10, 0, '2022-02-22'),
(3, 2, 18, 17, 1, 0, '2022-02-22');

-- --------------------------------------------------------

--
-- Table structure for table `canvass_stock_opname`
--

CREATE TABLE `canvass_stock_opname` (
  `id_canvass_stock_opname` int(11) NOT NULL,
  `id_canvass_keluar` int(11) DEFAULT NULL,
  `id_canvass_keluar_barang` int(11) DEFAULT NULL,
  `id_barang` int(11) DEFAULT NULL,
  `tanggal_so` date DEFAULT NULL,
  `qty_cek_2` double DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `expire` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `checkin`
--

CREATE TABLE `checkin` (
  `id_checkin` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jam` time DEFAULT NULL,
  `barcode` varchar(20) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `id_karyawan` int(11) NOT NULL,
  `gps` varchar(50) NOT NULL,
  `kota` varchar(50) NOT NULL,
  `akurasi` int(11) DEFAULT NULL,
  `mock` varchar(1) DEFAULT NULL,
  `distance` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `checkin`
--

INSERT INTO `checkin` (`id_checkin`, `tanggal`, `jam`, `barcode`, `id_pelanggan`, `id_karyawan`, `gps`, `kota`, `akurasi`, `mock`, `distance`) VALUES
(1, '2018-09-01', '14:47:17', 'C06', 1, 1, 'Longitude: 105.26852519,Latitude: -5.43919594', 'Teluk Betung Utara', 12, '0', 4093),
(2, '2018-09-01', '15:25:18', 'C06', 1, 3, 'Longitude: 105.26837389,Latitude: -5.43936192', 'Teluk Betung Utara', 47, '0', 4110),
(3, '2018-09-03', '10:20:03', 'C06', 1, 1, 'Longitude: 105.26843822,Latitude: -5.43930454', 'Teluk Betung Utara', 16, '0', 4105),
(4, '2018-09-07', '09:16:54', 'C06', 1, 1, 'Longitude: 105.2684378,Latitude: -5.43951433', 'Teluk Betung Utara', 14, '0', 4128),
(5, '2018-09-07', '09:23:13', 'C06', 1, 3, 'Longitude: 105.2684378,Latitude: -5.43951433', 'Teluk Betung Utara', 14, '0', 4128),
(6, '2018-09-10', '16:51:02', 'C06', 1, 1, 'Longitude: 105.26840046,Latitude: -5.4389733', 'Teluk Betung Utara', 11, '0', 4068),
(7, '2018-09-10', '16:58:43', 'C06', 1, 3, 'Longitude: 105.26840046,Latitude: -5.4389733', 'Teluk Betung Utara', 11, '0', 4068),
(8, '2018-09-11', '15:54:49', 'C06', 1, 1, 'Longitude: 105.26842413,Latitude: -5.43913834', 'Teluk Betung Utara', 8, '0', 4086),
(9, '2018-09-12', '16:02:00', 'C06', 1, 1, 'Longitude: 105.2685445,Latitude: -5.43913662', 'Teluk Betung Utara', 30, '0', 4087),
(10, '2018-09-12', '16:05:29', 'C06', 1, 3, 'Longitude: 105.26852901,Latitude: -5.43942102', 'Teluk Betung Utara', 9, '0', 4118),
(11, '2018-09-19', '11:08:50', '', 1, 1, 'Longitude: 105.26857941,Latitude: -5.43929692', 'Teluk Betung Utara', 8, '0', 4105),
(12, '2018-09-22', '08:39:23', '', 1, 1, 'Longitude: 105.26849714,Latitude: -5.43947132', 'Teluk Betung Utara', 17, '0', 4123),
(13, '2018-09-24', '09:55:09', '', 1, 1, 'Longitude: 105.26840704,Latitude: -5.43935051', 'Teluk Betung Utara', 8, '0', 4109),
(14, '2018-09-25', '10:50:25', '', 1, 1, 'Longitude: 105.26845219,Latitude: -5.43939511', 'Teluk Betung Utara', 15, '0', 4115),
(15, '2018-10-01', '14:44:30', '', 1, 1, 'Longitude: 105.26831233,Latitude: -5.4393623', 'Teluk Betung Utara', 12, '0', 4110),
(16, '2018-10-06', '16:23:50', '', 1, 1, 'Longitude: 105.26856429,Latitude: -5.43943165', 'Bandar Lampung', 13, '0', 4119),
(17, '2018-10-19', '16:19:01', '', 1, 1, 'Longitude: 105.26848336,Latitude: -5.43915952', 'null', 21, '0', 4089),
(18, '2018-10-24', '15:16:28', '', 1, 1, 'Longitude: 105.26839886,Latitude: -5.4392772', 'Teluk Betung Utara', 9, '0', 4101),
(19, '2018-10-27', '10:41:54', '', 1, 1, 'Longitude: 105.26848817,Latitude: -5.43939566', 'null', 9, '0', 4115),
(20, '2018-10-29', '18:46:13', '', 1, 1, 'Longitude: 105.2684469,Latitude: -5.43932963', 'null', 9, '0', 4107),
(21, '2018-10-30', '14:23:28', '', 1, 1, 'Longitude: 105.26847448,Latitude: -5.43934318', 'null', 10, '0', 4109),
(22, '2018-10-31', '14:22:54', '', 1, 1, 'Longitude: 105.26861911,Latitude: -5.43932135', 'null', 23, '0', 4108),
(23, '2018-11-13', '14:46:45', '', 1, 1, 'Longitude: 105.26847127,Latitude: -5.43957486', 'null', 14, '0', 4135),
(24, '2018-11-20', '16:14:21', '', 1, 1, 'Longitude: 105.26836154,Latitude: -5.43931921', 'Teluk Betung Utara', 12, '0', 4106),
(25, '2018-11-22', '15:48:15', '', 1, 1, 'Longitude: 105.26817379,Latitude: -5.43906992', 'null', 26, '0', 4077),
(26, '2018-11-23', '16:35:26', '', 1, 1, 'Longitude: 105.26848041,Latitude: -5.43922729', 'null', 13, '0', 4096),
(27, '2018-11-26', '15:47:15', '', 1, 1, 'Longitude: 105.26842265,Latitude: -5.43946209', 'Teluk Betung Utara', 10, '0', 4122),
(28, '2018-12-06', '16:11:51', '', 1, 1, 'Longitude: 105.26850676,Latitude: -5.43913859', 'Bandar Lampung', 25, '0', 4087),
(29, '2018-12-07', '16:12:26', '', 1, 1, 'Longitude: 105.26833696,Latitude: -5.43932138', 'Teluk Betung Utara', 8, '0', 4106),
(30, '2018-12-08', '14:11:54', '', 1, 1, 'Longitude: 105.26840282,Latitude: -5.4385852', 'Bandar Lampung', 32, '0', 4025);

-- --------------------------------------------------------

--
-- Table structure for table `data_nota_jual`
--

CREATE TABLE `data_nota_jual` (
  `id_data_nota_jual` int(11) NOT NULL,
  `tgl_nota` date NOT NULL,
  `invoice` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_nota_jual`
--

INSERT INTO `data_nota_jual` (`id_data_nota_jual`, `tgl_nota`, `invoice`) VALUES
(31, '2018-12-28', 'NJ-181228-001'),
(32, '2018-12-28', 'NJ-181228-002');

-- --------------------------------------------------------

--
-- Table structure for table `ekspedisi`
--

CREATE TABLE `ekspedisi` (
  `id_ekspedisi` int(11) NOT NULL,
  `nama_ekspedisi` varchar(50) NOT NULL,
  `telepon` varchar(20) NOT NULL,
  `kontakperson` varchar(50) DEFAULT NULL,
  `telepon_kontak` varchar(20) DEFAULT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ekspedisi`
--

INSERT INTO `ekspedisi` (`id_ekspedisi`, `nama_ekspedisi`, `telepon`, `kontakperson`, `telepon_kontak`, `status`) VALUES
(1, 'EKSPEDISI KILAT', '0721780430', 'SURPI', '08120000000000000000', 1),
(2, 'XXXXXXXX', '11111111111111111111', 'XXXXXXXXXXXXX', '11111111111111111111', 0),
(3, 'JNE', '464846', '08599126644', '146494', 1);

-- --------------------------------------------------------

--
-- Table structure for table `gudang`
--

CREATE TABLE `gudang` (
  `id_gudang` int(11) NOT NULL,
  `nama_gudang` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gudang`
--

INSERT INTO `gudang` (`id_gudang`, `nama_gudang`) VALUES
(6, 'ffffffffffffffffffff'),
(1, 'Gudang A'),
(3, 'Gudang B'),
(8, 'Gudang Bahan Baku'),
(5, 'GUDANG C'),
(2, 'Gudang F'),
(4, 'Gudang Lama'),
(7, 'scell');

-- --------------------------------------------------------

--
-- Table structure for table `harga_jual`
--

CREATE TABLE `harga_jual` (
  `id_harga_jual` int(11) NOT NULL,
  `id_barang_supplier` int(11) DEFAULT NULL,
  `id_pelanggan` int(11) DEFAULT NULL,
  `harga_jual` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `harga_jual`
--

INSERT INTO `harga_jual` (`id_harga_jual`, `id_barang_supplier`, `id_pelanggan`, `harga_jual`) VALUES
(3, 2, 1, 10000),
(4, 3, 1, 123456),
(6, 4, 1, 10000000),
(7, 6, 1, 10000),
(8, 9, 1, 15000),
(9, 10, 1, 15000000),
(10, 11, 1, 1200000),
(11, 22, 1, 15000000),
(12, 12, 1, 15000000),
(13, 21, 1, 15000000),
(14, 23, 1, 15000000),
(15, 24, 1, 15000000),
(16, 25, 1, 15000000),
(17, 20, 1, 15000000),
(18, 19, 1, 15000000),
(19, 18, 1, 15000000),
(20, 17, 1, 15000000),
(21, 16, 1, 15000000),
(22, 15, 1, 15900000),
(23, 14, 1, 15000000),
(24, 13, 1, 15000000),
(25, 26, 1, 15000000),
(26, 27, 1, 13000000),
(28, 28, 1, 12500000),
(29, 30, 1, 0),
(30, 29, 9, 235654),
(31, 31, 10, 1331664.51),
(32, 32, 11, 156231);

-- --------------------------------------------------------

--
-- Table structure for table `harga_jual_kredit`
--

CREATE TABLE `harga_jual_kredit` (
  `id_harga_jual_kredit` bigint(20) NOT NULL,
  `id_harga_jual` int(11) NOT NULL,
  `harga_kredit` double NOT NULL,
  `hari` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `harga_jual_kredit`
--

INSERT INTO `harga_jual_kredit` (`id_harga_jual_kredit`, `id_harga_jual`, `harga_kredit`, `hari`) VALUES
(7, 7, 15000000, 90),
(12, 8, 900000, 50),
(38, 3, 100000, 10),
(39, 3, 200000, 20),
(40, 3, 250000, 30),
(41, 7, 1000000, 30),
(42, 7, 2000000, 60),
(43, 4, 14900000, 30),
(44, 4, 14950000, 60),
(45, 6, 10500000, 30),
(46, 6, 11000000, 60),
(47, 6, 11500000, 1000),
(48, 9, 15000000, 30),
(49, 9, 16000000, 60),
(50, 9, 16500000, 1000),
(51, 4, 13000000, 20),
(52, 30, 161616.25, 25),
(53, 32, 164616, 8);

-- --------------------------------------------------------

--
-- Table structure for table `hj_kredit_detail`
--

CREATE TABLE `hj_kredit_detail` (
  `id_hj_kredit_detail` bigint(20) NOT NULL,
  `id_harga_jual` int(11) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `harga_kredit` double DEFAULT NULL,
  `hari` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hj_kredit_detail`
--

INSERT INTO `hj_kredit_detail` (`id_hj_kredit_detail`, `id_harga_jual`, `tanggal`, `harga_kredit`, `hari`) VALUES
(1, 3, '2018-02-03', 1000000, 30),
(2, 3, '2018-02-03', 2000000, 60),
(3, 3, '2018-02-03', 3000000, 95),
(4, 3, '2018-02-07', 1000000, 30);

-- --------------------------------------------------------

--
-- Table structure for table `hj_tunai_detail`
--

CREATE TABLE `hj_tunai_detail` (
  `id_hj_tunai_detail` int(11) NOT NULL,
  `id_barang_supplier` int(11) DEFAULT NULL,
  `id_pelanggan` int(11) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `harga_jual` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hj_tunai_detail`
--

INSERT INTO `hj_tunai_detail` (`id_hj_tunai_detail`, `id_barang_supplier`, `id_pelanggan`, `tanggal`, `harga_jual`) VALUES
(1, 2, 1, '2018-02-02', 1000000),
(2, 2, 1, '2018-02-02', 500000),
(3, 2, 1, '2018-02-02', 500000),
(4, 2, 1, '2018-02-02', 750000),
(5, 11, 1, '2018-02-02', 30),
(6, 11, 1, '2018-02-02', 300),
(7, 2, 1, '2018-02-02', 750000),
(8, 2, 1, '2018-02-03', 750000),
(9, 2, 1, '2018-02-03', 1500000),
(10, 2, 1, '2018-02-03', 1500000),
(11, 2, 1, '2018-02-03', 1200000),
(12, 2, 1, '2018-02-03', 1200000),
(13, 2, 1, '2018-02-03', 2000000),
(14, 2, 1, '2018-02-03', 2000000),
(15, 2, 1, '2018-02-03', 1000000),
(16, 2, 1, '2018-02-03', 1000000),
(17, 2, 1, '2018-02-03', 1300000),
(18, 2, 1, '2018-02-03', 1300000),
(19, 2, 1, '2018-02-03', 1000000),
(20, 2, 1, '2018-02-03', 1000000),
(21, 2, 1, '2018-02-03', 1500000),
(22, 2, 1, '2018-02-03', 1500000),
(23, 2, 1, '2018-02-03', 1000000),
(24, 2, 1, '2018-02-03', 1000000),
(25, 2, 1, '2018-02-03', 500000),
(26, 2, 1, '2018-02-12', 500000),
(27, 2, 1, '2018-02-12', 10000),
(28, 2, 1, '2018-02-12', 10000),
(29, 2, 1, '2018-02-12', 10000),
(30, 10, 1, '2018-03-24', 100000000),
(31, 10, 1, '2018-03-24', 15000000),
(32, 10, 1, '2018-03-24', 100000000),
(33, 10, 1, '2018-03-24', 15000000),
(34, 11, 1, '2018-05-12', 300),
(35, 11, 1, '2018-05-12', 1000000),
(36, 11, 1, '2018-05-12', 1000000),
(37, 11, 1, '2018-05-12', 1000000),
(38, 11, 1, '2018-05-12', 1000000),
(39, 11, 1, '2018-05-12', 1200000),
(40, 22, 1, '2018-05-12', 15000000),
(41, 11, 1, '2018-05-12', 1200000),
(42, 11, 1, '2018-05-12', 1200000),
(43, 3, 1, '2018-05-16', 10000000),
(44, 27, 1, '2018-05-16', 13000000),
(45, 4, 1, '2018-05-16', 10000000),
(46, 28, 1, '2018-05-16', 12000000),
(47, 28, 1, '2018-05-16', 12000000),
(48, 28, 1, '2018-05-16', 12500000),
(49, 3, 1, '2018-05-18', 1000000),
(50, 30, 1, '2018-06-12', 0),
(51, 29, 9, '2019-01-04', 235654),
(52, 31, 10, '2019-01-11', 1331664.51),
(53, 32, 11, '2019-01-11', 156231);

-- --------------------------------------------------------

--
-- Table structure for table `jabatan`
--

CREATE TABLE `jabatan` (
  `id_jabatan` int(11) NOT NULL,
  `nama_jabatan` varchar(20) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jabatan`
--

INSERT INTO `jabatan` (`id_jabatan`, `nama_jabatan`, `status`) VALUES
(1, 'DIREKSI', 1),
(2, 'DRIVER', 1),
(3, 'SALES', 1),
(4, 'GUDANG', 1),
(5, 'CHECKER', 1),
(6, 'ADMINISTRASI', 1),
(7, 'COLLECTOR', 1),
(8, 'jhbhb', 1),
(9, 'zzz', 0),
(10, 'MANAJER', 1),
(11, 'KEPALA GUDANG', 0);

-- --------------------------------------------------------

--
-- Table structure for table `jual`
--

CREATE TABLE `jual` (
  `id_jual` int(11) NOT NULL,
  `tgl_nota` date NOT NULL,
  `invoice` varchar(15) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `id_karyawan` int(11) NOT NULL,
  `jenis_bayar` enum('Lunas','Kredit') DEFAULT NULL,
  `tenor` int(5) DEFAULT '0',
  `status_konfirm` tinyint(1) NOT NULL DEFAULT '0',
  `cetak` tinyint(1) DEFAULT '0',
  `tgl_cetak` date DEFAULT NULL,
  `diskon_all_persen` double DEFAULT NULL,
  `ppn_all_persen` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jual`
--

INSERT INTO `jual` (`id_jual`, `tgl_nota`, `invoice`, `id_pelanggan`, `id_karyawan`, `jenis_bayar`, `tenor`, `status_konfirm`, `cetak`, `tgl_cetak`, `diskon_all_persen`, `ppn_all_persen`) VALUES
(1, '2018-09-07', 'NJ-180907-001', 1, 1, 'Lunas', 0, 2, 1, '2018-12-28', 10, 5),
(2, '2018-09-07', 'NJ-180907-002', 1, 1, 'Lunas', 0, 2, 1, '2018-12-08', 10, 5),
(3, '2018-09-10', 'NJ-180910-001', 1, 1, 'Lunas', 0, 2, 1, '2018-11-23', 0, 0),
(4, '2018-09-10', 'NJ-180910-002', 1, 1, 'Lunas', 0, 2, 1, '2018-11-23', 0, 0),
(5, '2018-09-10', 'NJ-180910-003', 1, 1, 'Lunas', 0, 2, 1, '2018-11-23', 0, 0),
(6, '2018-09-10', 'NJ-180910-004', 1, 1, 'Lunas', 0, 2, 1, '2018-10-19', 0, 0),
(7, '2018-09-11', 'NJ-180911-001', 1, 1, 'Lunas', 0, 2, 1, '2018-10-19', 0, 0),
(8, '2018-09-12', 'NJ-180912-001', 1, 1, 'Lunas', 0, 7, 1, '2018-10-19', 0, 0),
(9, '2018-09-12', 'NJ-180912-002', 1, 1, 'Lunas', 0, 1, 1, '2019-01-18', 0, 0),
(10, '2018-11-28', 'NJ-181128-001', 1, 6, 'Lunas', 0, 0, 0, NULL, 10, 0),
(11, '2018-12-07', 'NJ-181207-001', 1, 1, 'Lunas', 0, 0, 0, NULL, 10, 0),
(15, '2018-12-21', 'NJ-181221-004', 1, 6, 'Lunas', 0, 0, 0, NULL, 0, 0),
(16, '2018-12-23', 'NJ-181223-001', 1, 6, 'Lunas', 0, 0, 0, NULL, 0, 0),
(23, '2018-12-27', 'NJ-181227-007', 1, 1, 'Lunas', 0, 5, 0, NULL, 0, 0),
(24, '2018-12-28', 'NJ-181228-001', 1, 6, 'Lunas', 0, 0, 0, NULL, 7, 0),
(25, '2018-12-28', 'NJ-181228-002', 1, 1, 'Lunas', 0, 5, 0, NULL, 5.7, 0);

-- --------------------------------------------------------

--
-- Table structure for table `jual_detail`
--

CREATE TABLE `jual_detail` (
  `id_jual_detail` bigint(20) NOT NULL,
  `id_jual` int(11) NOT NULL,
  `id_harga_jual` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `harga` double NOT NULL,
  `diskon_persen` double DEFAULT NULL,
  `diskon_rp` double DEFAULT NULL,
  `diskon_persen_2` double DEFAULT NULL,
  `diskon_rp_2` double DEFAULT NULL,
  `diskon_persen_3` double DEFAULT NULL,
  `diskon_rp_3` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jual_detail`
--

INSERT INTO `jual_detail` (`id_jual_detail`, `id_jual`, `id_harga_jual`, `qty`, `harga`, `diskon_persen`, `diskon_rp`, `diskon_persen_2`, `diskon_rp_2`, `diskon_persen_3`, `diskon_rp_3`) VALUES
(1, 1, 9, 2, 15000000, 10, 1500000, 0, 0, 0, 0),
(2, 1, 4, 100, 123456, 1.5, 1851.84, 0, 0, 0, 0),
(3, 2, 10, 10, 1200000, 0, 0, 0, 0, 0, 0),
(4, 2, 13, 2, 15000000, 0, 0, 0, 0, 0, 0),
(5, 3, 4, 20, 123456, 0, 0, 0, 0, 0, 0),
(6, 4, 26, 2, 13000000, 2.9, 377000, 0, 0, 0, 0),
(7, 5, 16, 1, 15000000, 0, 0, 0, 0, 0, 0),
(8, 6, 10, 10, 1200000, 0, 0, 0, 0, 0, 0),
(9, 7, 4, 10, 123456, 0, 0, 0, 0, 0, 0),
(10, 8, 9, 2, 15000000, 2, 300000, 0, 0, 0, 0),
(11, 8, 4, 10, 123456, 1, 1234.56, 0, 0, 0, 0),
(12, 9, 11, 2, 15000000, 3, 450000, 0, 0, 0, 0),
(13, 10, 11, 1, 15000000, 12, 1800000, 0, 0, 0, 0),
(14, 10, 4, 1, 123456, 0, 0, 0, 0, 0, 0),
(15, 11, 11, 1, 15000000, 10, 1500000, 0, 0, 0, 0),
(16, 15, 12, 2, 15000000, 10, 3000000, 0, 0, 0, 0),
(17, 16, 11, 2, 15000000, 10, 3000000, 10, 2700000, 10, 2430000),
(18, 23, 9, 1, 15000000, 10, 1500000, 10, 1350000, 10, 1215000),
(19, 24, 11, 2, 15000000, 10, 1500000, 10, 1350000, 10, 1215000),
(21, 24, 12, 2, 15000000, 10, 1500000, 10, 1350000, 10, 1215000),
(24, 25, 9, 2, 15000000, 10, 1500000, 10, 1350000, 10, 1215000);

-- --------------------------------------------------------

--
-- Table structure for table `kabupaten`
--

CREATE TABLE `kabupaten` (
  `id_kab` int(11) NOT NULL,
  `id_prov` int(11) NOT NULL,
  `nama_kab` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kabupaten`
--

INSERT INTO `kabupaten` (`id_kab`, `id_prov`, `nama_kab`) VALUES
(1, 1, 'LAMPUNG SELATAN'),
(2, 1, 'LAMPUNG TENGAH'),
(3, 3, '1'),
(6, 0, 'fdvcdsvdsvdv'),
(7, 2, 'efwcsdv'),
(8, 1, 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX'),
(9, 5, 'XXXXXXXXXXXXXXXX'),
(10, 2, 'lampung'),
(11, 0, 'khkh'),
(12, 0, 'kgbuk'),
(13, 0, 'gukg'),
(14, 11, 'Ku'),
(15, 11, 'Ghie');

-- --------------------------------------------------------

--
-- Table structure for table `karyawan`
--

CREATE TABLE `karyawan` (
  `id_karyawan` int(11) NOT NULL,
  `nama_karyawan` varchar(50) NOT NULL,
  `barcode` varchar(10) NOT NULL,
  `ktp` varchar(17) NOT NULL,
  `no_hp` varchar(14) NOT NULL,
  `id_jabatan` int(11) NOT NULL,
  `gaji` float NOT NULL,
  `harian` float NOT NULL,
  `lembur` float NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `karyawan`
--

INSERT INTO `karyawan` (`id_karyawan`, `nama_karyawan`, `barcode`, `ktp`, `no_hp`, `id_jabatan`, `gaji`, `harian`, `lembur`, `status`) VALUES
(1, 'FLASH', '121212', '12121212121212', '08121212121211', 3, 2000000, 0, 0, 1),
(2, 'RIN', '2453453453', '3525252353255323', '32523523525235', 4, 2000000, 0, 0, 1),
(3, 'ZEN', '8999999999', '32345345345', '534535345', 2, 245435, 32523, 3252, 1),
(4, 'refvever', 'fecvrfccvc', '3242343', '3255335', 9, 12123, 21312, 213, 0),
(5, 'ADMIN', '3423423423', '4242423432432423', '44234234342342', 1, 3424230, 3424340, 3242420, 1),
(6, 'OWNER', '122122121', '1212121212112', '1212121212', 1, 0, 0, 0, 1),
(7, 'UYUH', '23312', '2313123', '2132313', 1, 2131230, 3213, 231313, 0),
(8, 'AAAAA', '3223443', '211434234', '34234325235', 3, 1000000, 20000, 50000, 1),
(9, 'hi', '254523', '324', '3242342', 3, 23423, 342, 4324, 1),
(10, 'ADMIN2', '1111111111', '1111111111111111', '11111111111111', 1, 1000, 1000, 1000, 1),
(11, 'Bean', '161616', '161626', '05465161', 5, 9520000, 100000, 80000, 1),
(12, 'Andri', '152352', '153523525', '08984835252', 1, 15625000, 100000, 200000, 1),
(13, 'Aan Siahaan', '123456', '321456', '02826265', 1, 3500000, 100000, 100000, 0);

-- --------------------------------------------------------

--
-- Table structure for table `kas_kecil`
--

CREATE TABLE `kas_kecil` (
  `id_kas_kecil` int(11) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `komponen` varchar(50) DEFAULT NULL,
  `jenis` enum('MASUK','KELUAR') DEFAULT NULL,
  `keterangan` varchar(50) DEFAULT NULL,
  `jumlah` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kas_kecil`
--

INSERT INTO `kas_kecil` (`id_kas_kecil`, `tanggal`, `komponen`, `jenis`, `keterangan`, `jumlah`) VALUES
(1, '2018-03-09', 'PENDAPATAN LAIN-LAIN', 'MASUK', ' ', 1000000),
(3, '2018-03-09', 'BIAYA LAIN-LAIN', 'KELUAR', ' ', 500000),
(4, '2018-04-09', 'PENDAPATAN LAIN-LAIN', 'MASUK', ' ', 453346),
(5, '2018-06-22', 'PENDAPATAN LAIN-LAIN', 'MASUK', 'jjjj', 1000000),
(6, '2018-07-03', 'PENDAPATAN LAIN-LAIN', 'MASUK', ' ', 1),
(9, '2019-01-04', 'BIAYA ADM', 'KELUAR', 'b', 200000),
(10, '2019-01-05', 'PENDAPATAN LAIN-LAIN', 'MASUK', 'PT. Prima Larva', 1523000);

-- --------------------------------------------------------

--
-- Table structure for table `kecamatan`
--

CREATE TABLE `kecamatan` (
  `id_kec` int(11) NOT NULL,
  `id_kab` int(11) NOT NULL,
  `nama_kec` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kecamatan`
--

INSERT INTO `kecamatan` (`id_kec`, `id_kab`, `nama_kec`) VALUES
(1, 1, 'NATAR'),
(2, 1, 'TANJUNG BINTANG'),
(3, 1, 'efwfergfregg'),
(4, 3, 'N'),
(5, 1, 'dsvdfvfdv'),
(6, 8, 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX'),
(7, 1, 'dfwefwedf'),
(8, 14, 'Bades'),
(9, 15, 'Krige');

-- --------------------------------------------------------

--
-- Table structure for table `kelurahan`
--

CREATE TABLE `kelurahan` (
  `id_kel` int(11) NOT NULL,
  `id_kec` int(11) NOT NULL,
  `nama_kel` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kelurahan`
--

INSERT INTO `kelurahan` (`id_kel`, `id_kec`, `nama_kel`) VALUES
(1, 1, 'HAJIMENA'),
(2, 1, 'SIDOSARI'),
(3, 3, 'FINEST'),
(4, 4, 'O'),
(5, 1, 'sacsdvcsdvsdv'),
(6, 6, 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX'),
(7, 1, 'kel 1'),
(8, 1, 'kel2'),
(9, 8, 'Namu'),
(10, 8, 'Bidas'),
(11, 9, 'Lampasan');

-- --------------------------------------------------------

--
-- Table structure for table `kendaraan`
--

CREATE TABLE `kendaraan` (
  `id_kendaraan` int(11) NOT NULL,
  `nama_kendaraan` varchar(25) NOT NULL,
  `jenis_kendaraan` varchar(5) NOT NULL,
  `id_varian` int(11) NOT NULL,
  `plat` varchar(15) NOT NULL,
  `perbandingan` int(4) NOT NULL,
  `km_awal` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `canvass` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kendaraan`
--

INSERT INTO `kendaraan` (`id_kendaraan`, `nama_kendaraan`, `jenis_kendaraan`, `id_varian`, `plat`, `perbandingan`, `km_awal`, `status`, `canvass`) VALUES
(1, 'MOBIL A', 'MOBIL', 1, 'BE 4444 idx', 20, 2134213, 1, 1),
(10, 'MOBIL D', 'MOBIL', 1, 'BE 8888 GBV', 100, 300435, 1, 0),
(11, 'MOBIL B', 'MOBIL', 1, 'be 444 rer', 100, 99999, 1, 0),
(12, 'MOBIL C', 'MOBIL', 1, 'br 5454 rg', 10, 3423423, 1, 0),
(13, '4444444444444444444444444', 'MOBIL', 2, 'rg 4565 rgv', 105, 325435, 1, 0),
(14, '1111111111111111111111111', 'MOBIL', 1, 'wd 2323 dsd', 1111, 9999, 1, 0),
(15, '32434', 'MOBIL', 1, 'be 3333 xxx', 12222, 122222, 1, 1),
(16, 'qwerty', 'MOBIL', 2, 'B 986 JJ', 25365, 31321, 0, 1),
(17, 'Honda Beat', 'MOTOR', 5, 'D 7854 FF', 2546, 1648, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `komisi`
--

CREATE TABLE `komisi` (
  `id_komisi` int(11) NOT NULL,
  `id_karyawan` int(11) NOT NULL,
  `target_awal` double NOT NULL,
  `target_akhir` double NOT NULL,
  `tunai` decimal(4,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `komisi`
--

INSERT INTO `komisi` (`id_komisi`, `id_karyawan`, `target_awal`, `target_akhir`, `tunai`) VALUES
(10, 1, 0, 100000000, '0.10'),
(11, 1, 100000001, 150000000, '0.12'),
(12, 1, 150000001, 200000000, '0.15'),
(18, 1, 200000001, 250000000, '0.20'),
(19, 8, 100000000, 500000000, '5.12'),
(20, 9, 5000000, 15000000, '10.63'),
(21, 9, 15000001, 25000000, '15.66');

-- --------------------------------------------------------

--
-- Table structure for table `komisi_kredit`
--

CREATE TABLE `komisi_kredit` (
  `id_komisi_kredit` bigint(20) NOT NULL,
  `id_komisi` int(11) NOT NULL,
  `kredit` decimal(4,2) NOT NULL,
  `hari` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `komisi_kredit`
--

INSERT INTO `komisi_kredit` (`id_komisi_kredit`, `id_komisi`, `kredit`, `hari`) VALUES
(1, 10, '0.13', 30),
(2, 10, '0.12', 60),
(3, 10, '0.11', 90),
(4, 10, '0.10', 120),
(5, 11, '0.20', 10);

-- --------------------------------------------------------

--
-- Table structure for table `konfirm_owner`
--

CREATE TABLE `konfirm_owner` (
  `id_konfirm_owner` int(11) NOT NULL,
  `tgl_konfirm` date DEFAULT NULL,
  `deskripsi` varchar(100) DEFAULT NULL,
  `tipe` enum('canvass_stock_opname') DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `url` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `konfirm_owner_detail`
--

CREATE TABLE `konfirm_owner_detail` (
  `id_konfirm_owner_detail` int(11) NOT NULL,
  `id_konfirm_owner` int(11) DEFAULT NULL,
  `target` enum('id_laporan_stock_opname') DEFAULT NULL,
  `jenis` enum('diterima','ditolak') DEFAULT NULL,
  `nilai` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lap_stock_opname`
--

CREATE TABLE `lap_stock_opname` (
  `id_laporan_stock_opname` int(11) NOT NULL,
  `id_canvass_keluar` int(11) DEFAULT NULL,
  `tgl_lap` date DEFAULT NULL,
  `id_barang` int(11) DEFAULT NULL,
  `qty_sisa` int(11) DEFAULT NULL,
  `qty_cek` int(11) DEFAULT NULL,
  `selisih` int(11) DEFAULT NULL,
  `id_karyawan` int(11) DEFAULT NULL,
  `expire` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mst_kas_kecil`
--

CREATE TABLE `mst_kas_kecil` (
  `id_kas_kecil` int(11) NOT NULL,
  `nama_kas_kecil` varchar(100) NOT NULL,
  `jenis` enum('MASUK','KELUAR') NOT NULL,
  `status` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mst_kas_kecil`
--

INSERT INTO `mst_kas_kecil` (`id_kas_kecil`, `nama_kas_kecil`, `jenis`, `status`) VALUES
(1, 'PENDAPATAN LAIN-LAIN', 'MASUK', 1),
(2, 'BIAYA LAIN-LAIN', 'KELUAR', 1),
(3, 'BIAYA ADM', 'KELUAR', 1),
(4, 'Iuran Bulanan', 'MASUK', 1),
(5, 'Pajak', 'KELUAR', 0),
(6, 'Premi Asuransi', 'KELUAR', 0);

-- --------------------------------------------------------

--
-- Table structure for table `negara`
--

CREATE TABLE `negara` (
  `id_negara` int(11) NOT NULL,
  `nama_negara` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `negara`
--

INSERT INTO `negara` (`id_negara`, `nama_negara`) VALUES
(2, 'Filipina'),
(1, 'Indonesia'),
(4, 'Malaysia'),
(3, 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx');

-- --------------------------------------------------------

--
-- Table structure for table `nota_siap_kirim`
--

CREATE TABLE `nota_siap_kirim` (
  `id_nota_siap_kirim` int(11) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `id_jual` int(11) DEFAULT NULL,
  `status` varchar(1) DEFAULT '0',
  `id_karyawan` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `nota_siap_kirim`
--

INSERT INTO `nota_siap_kirim` (`id_nota_siap_kirim`, `tanggal`, `id_jual`, `status`, `id_karyawan`) VALUES
(1, '2018-09-07', 2, '1', 2),
(3, '2018-09-07', 1, '1', 2),
(4, '2018-09-10', 6, '1', 2),
(5, '2018-09-10', 5, '1', 2),
(6, '2018-09-10', 4, '1', 2),
(7, '2018-09-10', 3, '1', 2),
(8, '2018-09-11', 7, '1', 2),
(9, '2018-09-12', 9, '1', 2);

-- --------------------------------------------------------

--
-- Table structure for table `nota_siap_kirim_detail`
--

CREATE TABLE `nota_siap_kirim_detail` (
  `id_nota_siap_kirim_detail` int(11) NOT NULL,
  `id_nota_siap_kirim` int(11) DEFAULT NULL,
  `id_jual_detail` int(11) DEFAULT NULL,
  `id_barang_masuk_rak` int(11) DEFAULT NULL,
  `qty_ambil` double DEFAULT NULL,
  `expire` date DEFAULT NULL,
  `id_rak` int(11) DEFAULT NULL,
  `cek` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `nota_siap_kirim_detail`
--

INSERT INTO `nota_siap_kirim_detail` (`id_nota_siap_kirim_detail`, `id_nota_siap_kirim`, `id_jual_detail`, `id_barang_masuk_rak`, `qty_ambil`, `expire`, `id_rak`, `cek`) VALUES
(1, 1, 3, 23, 1, '2022-02-22', 7, 1),
(2, 1, 3, 18, 9, '2022-02-22', 7, 1),
(3, 1, 4, 116, 2, '2022-02-22', 7, 1),
(4, 3, 1, 19, 2, '2022-02-22', 7, 1),
(5, 3, 2, 21, 1, '2022-02-22', 7, 1),
(6, 3, 2, 20, 5, '2022-02-22', 7, 1),
(7, 3, 2, 25, 50, '2022-02-22', 7, 1),
(8, 3, 2, 24, 44, '2022-02-22', 7, 1),
(9, 4, 8, 18, 1, '2022-02-22', 7, 1),
(10, 4, 8, 61, 9, '2022-02-22', 7, 1),
(11, 5, 7, 64, 1, '2022-02-22', 7, 1),
(12, 6, 6, 67, 2, '2022-02-22', 7, 1),
(13, 7, 5, 24, 6, '2022-02-22', 7, 1),
(14, 7, 5, 57, 14, '2022-02-22', 7, 1),
(15, 8, 9, 56, 10, '2022-02-22', 7, 1),
(16, 9, 12, 73, 2, '2022-02-22', 7, 1);

-- --------------------------------------------------------

--
-- Table structure for table `nota_sudah_cek`
--

CREATE TABLE `nota_sudah_cek` (
  `id_nota_sudah_cek` int(11) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `id_jual` int(11) DEFAULT NULL,
  `jumlah` double DEFAULT NULL,
  `status` varchar(1) DEFAULT NULL,
  `id_karyawan` int(11) DEFAULT NULL,
  `tanggal_cetak` date DEFAULT NULL,
  `tipe_kirim` enum('Kirim Sendiri','Via Ekspedisi') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `nota_sudah_cek`
--

INSERT INTO `nota_sudah_cek` (`id_nota_sudah_cek`, `tanggal`, `id_jual`, `jumlah`, `status`, `id_karyawan`, `tanggal_cetak`, `tipe_kirim`) VALUES
(1, '2018-09-07', 2, 42000000, '3', 2, '2018-12-08', 'Kirim Sendiri'),
(2, '2018-09-07', 1, 39160416, '3', 2, '2018-12-28', 'Kirim Sendiri'),
(3, '2018-09-10', 6, 12000000, '3', 2, '2018-10-19', 'Kirim Sendiri'),
(4, '2018-09-10', 5, 15000000, '3', 2, '2018-11-23', 'Kirim Sendiri'),
(5, '2018-09-10', 4, 25246000, '3', 2, '2018-11-23', 'Kirim Sendiri'),
(6, '2018-09-10', 3, 2469120, '3', 2, '2018-11-23', 'Kirim Sendiri'),
(7, '2018-09-11', 7, 1234560, '3', 2, '2018-10-19', 'Kirim Sendiri'),
(8, '2018-09-12', 9, 29100000, '2', 2, '2019-01-18', 'Kirim Sendiri');

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int(11) NOT NULL,
  `nama_pelanggan` varchar(50) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `lat` varchar(50) DEFAULT NULL,
  `lng` varchar(50) DEFAULT NULL,
  `telepon_pelanggan` varchar(20) NOT NULL,
  `kontakperson` varchar(30) DEFAULT NULL,
  `telepon_kontak` varchar(20) DEFAULT NULL,
  `plafon` double NOT NULL,
  `barcode` varchar(20) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `blacklist` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `nama_pelanggan`, `alamat`, `lat`, `lng`, `telepon_pelanggan`, `kontakperson`, `telepon_kontak`, `plafon`, `barcode`, `status`, `blacklist`) VALUES
(1, 'TOKO ANGIN RIBUT', 'JLN. TAK BERUJUNG', '-5.40225363', '105.26623657', '3243', '4656', '08120000000000000000', 900000000, 'C06', 1, 1),
(2, 'afsadcfasc', 'asafsfas', '', '', '145436', '1ggegeb', '1432543545', 0, '1768678687687', 1, 1),
(3, 'sqcxsqcq', 'sxscsq', '', '', '223123123', '213123123', '2313123', 2147483647, '3211231', 1, 0),
(4, '1421242', 'scsacascsacsc', '', '', '121414124124', 'dfdfdsfg', '121421414124', 0, '1343243414214', 1, 0),
(5, 'sgfggegf', 'ewgfegveg', '-5.439263', '105.268318', '3243', '4656', '08120000', 89368.69, '4970129727514', 1, 1),
(6, 'sdascdf', 'dsfsdfdsf', '', '', '3424342434', '3242344', '3243242', 2342342, '22342354235345', 1, 0),
(7, '111111111111111111111', '11111111111111111111111111111111', '8656677878,989009', '3242342,42342354', '11111111111111111111', '11111111111111', '11111111111111111111', 1, '11111111111111111111', 0, 1),
(8, 'efvefvfev', 'edvfcevev', 'evefvefv', 'ervefvefv', '43543534534545', '435646435455', '45345345', 435345345, '433534534543545', 0, 0),
(9, '324354', '324324234', '', '', '4324234', '3244234', '724234324', 324234, '3242343', 1, 1),
(10, 'PT. Cahya Abadi', 'llknholhoi', '', '', '0721368743', '089829390213', '56386', 15830000, '16646499', 1, 0),
(11, 'sd', 'sd', '', '', '1646494', '6449', '64949', 155484566, '361654161', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `penagihan`
--

CREATE TABLE `penagihan` (
  `id_penagihan` int(11) NOT NULL,
  `id_karyawan` int(11) DEFAULT NULL,
  `tanggal_tagih` date DEFAULT NULL,
  `tipe` enum('DALAM KOTA','LUAR KOTA') DEFAULT NULL,
  `status_tagih` tinyint(1) DEFAULT NULL,
  `id_admin` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `penagihan`
--

INSERT INTO `penagihan` (`id_penagihan`, `id_karyawan`, `tanggal_tagih`, `tipe`, `status_tagih`, `id_admin`) VALUES
(5, 1, '2018-11-23', 'DALAM KOTA', 0, 5);

-- --------------------------------------------------------

--
-- Table structure for table `penagihan_detail`
--

CREATE TABLE `penagihan_detail` (
  `id_penagihan_detail` int(11) NOT NULL,
  `id_penagihan` int(11) DEFAULT NULL,
  `id_jual` double DEFAULT NULL,
  `bayar` double DEFAULT NULL,
  `status_bayar` tinyint(1) DEFAULT NULL,
  `tgl_janji_next` date DEFAULT NULL,
  `status_nota_kembali` tinyint(4) DEFAULT NULL,
  `setor` double DEFAULT NULL,
  `pengirim_bank` varchar(50) DEFAULT NULL,
  `pengirim_nama` varchar(100) DEFAULT NULL,
  `pengirim_no` varchar(20) DEFAULT NULL,
  `penerima_bank` varchar(50) DEFAULT NULL,
  `penerima_nama` varchar(100) DEFAULT NULL,
  `penerima_no` varchar(20) DEFAULT NULL,
  `jatuh_tempo` date DEFAULT NULL,
  `keterangan` varchar(100) DEFAULT NULL,
  `status_giro` tinyint(1) DEFAULT NULL,
  `jenis` enum('Transfer','Tunai','Retur','Giro') DEFAULT NULL,
  `tgl_bayar` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `penagihan_detail`
--

INSERT INTO `penagihan_detail` (`id_penagihan_detail`, `id_penagihan`, `id_jual`, `bayar`, `status_bayar`, `tgl_janji_next`, `status_nota_kembali`, `setor`, `pengirim_bank`, `pengirim_nama`, `pengirim_no`, `penerima_bank`, `penerima_nama`, `penerima_no`, `jatuh_tempo`, `keterangan`, `status_giro`, `jenis`, `tgl_bayar`) VALUES
(9, 5, 2, NULL, 3, '2018-12-09', 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, 'Retur', '2018-12-08'),
(10, 5, 1, 39160416, 2, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, 'Tunai', '2018-12-08');

-- --------------------------------------------------------

--
-- Table structure for table `penagihan_retur_detail`
--

CREATE TABLE `penagihan_retur_detail` (
  `id_penagihan_retur_detail` bigint(20) NOT NULL,
  `id_penagihan_detail` bigint(20) DEFAULT NULL,
  `no_retur_jual` varchar(13) DEFAULT NULL,
  `jumlah_retur` double DEFAULT NULL,
  `status_retur` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `penagihan_retur_detail`
--

INSERT INTO `penagihan_retur_detail` (`id_penagihan_retur_detail`, `id_penagihan_detail`, `no_retur_jual`, `jumlah_retur`, `status_retur`) VALUES
(1, 9, 'rb-91937248', 500000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `penggajian`
--

CREATE TABLE `penggajian` (
  `id_penggajian` int(11) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `status` char(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `penggajian`
--

INSERT INTO `penggajian` (`id_penggajian`, `tanggal`, `status`) VALUES
(1, '2018-07-06', '0');

-- --------------------------------------------------------

--
-- Table structure for table `penggajian_detail`
--

CREATE TABLE `penggajian_detail` (
  `id_penggajian_detail` int(11) NOT NULL,
  `id_penggajian` int(11) DEFAULT NULL,
  `id_karyawan` int(11) DEFAULT NULL,
  `jumlah_gaji` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `penggajian_detail`
--

INSERT INTO `penggajian_detail` (`id_penggajian_detail`, `id_penggajian`, `id_karyawan`, `jumlah_gaji`) VALUES
(1, 1, 1, 0),
(2, 1, 2, NULL),
(3, 1, 3, NULL),
(4, 1, 4, NULL),
(5, 1, 5, NULL),
(6, 1, 6, NULL),
(7, 1, 7, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pengiriman`
--

CREATE TABLE `pengiriman` (
  `id_pengiriman` int(11) NOT NULL,
  `id_jual` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `tanggal_kirim` date DEFAULT NULL,
  `id_karyawan` int(11) DEFAULT NULL,
  `id_ekspedisi` int(11) DEFAULT NULL,
  `berat` decimal(10,0) DEFAULT NULL,
  `volume` decimal(10,0) DEFAULT NULL,
  `tarif` double DEFAULT NULL,
  `jenis` enum('DALAM KOTA','LUAR KOTA') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pengiriman`
--

INSERT INTO `pengiriman` (`id_pengiriman`, `id_jual`, `status`, `tanggal_kirim`, `id_karyawan`, `id_ekspedisi`, `berat`, `volume`, `tarif`, `jenis`) VALUES
(1, 1, 1, '2018-09-07', 3, NULL, NULL, NULL, NULL, 'DALAM KOTA'),
(2, 2, 1, '2018-09-07', 3, NULL, NULL, NULL, NULL, 'DALAM KOTA'),
(3, 3, 1, '2018-09-10', 3, NULL, NULL, NULL, NULL, 'DALAM KOTA'),
(4, 4, 1, '2018-09-10', 3, NULL, NULL, NULL, NULL, 'DALAM KOTA'),
(5, 5, 1, '2018-09-10', 3, NULL, NULL, NULL, NULL, 'DALAM KOTA'),
(6, 6, 1, '2018-09-10', 3, NULL, NULL, NULL, NULL, 'DALAM KOTA'),
(7, 7, 1, '2018-09-12', 3, NULL, NULL, NULL, NULL, 'DALAM KOTA'),
(8, 8, 1, '2018-09-12', 3, NULL, NULL, NULL, NULL, 'LUAR KOTA');

-- --------------------------------------------------------

--
-- Table structure for table `perusahaan`
--

CREATE TABLE `perusahaan` (
  `id_perusahaan` int(11) NOT NULL,
  `nama_pt` varchar(50) NOT NULL,
  `alamat` varchar(50) NOT NULL,
  `id_negara` int(11) NOT NULL,
  `id_prov` int(11) NOT NULL,
  `id_kab` int(11) NOT NULL,
  `id_kec` int(11) DEFAULT NULL,
  `id_kel` int(11) DEFAULT NULL,
  `kode_pos` varchar(7) DEFAULT NULL,
  `telepon` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `perusahaan`
--

INSERT INTO `perusahaan` (`id_perusahaan`, `nama_pt`, `alamat`, `id_negara`, `id_prov`, `id_kab`, `id_kec`, `id_kel`, `kode_pos`, `telepon`) VALUES
(1, 'PT. ABC', 'JLN. ABC NO. 1', 4, 11, 14, 8, 10, '4354356', '34455443');

-- --------------------------------------------------------

--
-- Table structure for table `pesan`
--

CREATE TABLE `pesan` (
  `id_pesan` int(11) NOT NULL,
  `tanggal` datetime DEFAULT NULL,
  `id_karyawan` int(11) DEFAULT NULL,
  `judul` varchar(100) DEFAULT NULL,
  `pesan` text,
  `status_pesan` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pesan`
--

INSERT INTO `pesan` (`id_pesan`, `tanggal`, `id_karyawan`, `judul`, `pesan`, `status_pesan`) VALUES
(1, '2018-10-19 20:06:31', 6, 'Ada barang yang dihapus sales.', 'Tipe: Dalam Kota\r\nTgl Nota Jual : 19-10-2018\r\nNo Nota Jual : NJ-181019-001\r\nNama Pelanggan : TOKO ANGIN RIBUT\r\nNama Sales : FLASH\r\nNama Barang : Barang 5 - 1\r\n	10 pcs\r\n', 0),
(2, '2018-10-19 20:06:34', 6, 'Ada nota jual yang dihapus secara otomatis karena kosong', 'Berikut nota jual yang dihapus : \r\n\r\nTgl Hapus : 19-10-2018, 20:06:34\r\nTgl Nota : 19-10-2018\r\nNota Nota Jual : NJ-181019-001\r\nTipe : Dalam Kota\r\nNama Sales : FLASH\r\nNama Pelanggan : TOKO ANGIN RIBUT\r\n\r\n', 0),
(3, '2018-10-19 20:08:42', 6, 'Ada barang yang dihapus sales.', 'Tipe: Dalam Kota\r\nTgl Nota Jual : 19-10-2018\r\nNo Nota Jual : NJ-181019-002\r\nNama Pelanggan : TOKO ANGIN RIBUT\r\nNama Sales : FLASH\r\nNama Barang : Barang 5 - 3\r\n	1 pcs\r\n', 0),
(4, '2018-10-19 20:08:44', 6, 'Ada nota jual yang dihapus secara otomatis karena kosong', 'Berikut nota jual yang dihapus : \r\n\r\nTgl Hapus : 19-10-2018, 20:08:44\r\nTgl Nota : 19-10-2018\r\nNota Nota Jual : NJ-181019-002\r\nTipe : Dalam Kota\r\nNama Sales : FLASH\r\nNama Pelanggan : TOKO ANGIN RIBUT\r\n\r\n', 0),
(5, '2018-10-19 20:09:24', 6, 'Ada barang yang dihapus sales.', 'Tipe: Dalam Kota\r\nTgl Nota Jual : 19-10-2018\r\nNo Nota Jual : NJ-181019-003\r\nNama Pelanggan : TOKO ANGIN RIBUT\r\nNama Sales : FLASH\r\nNama Barang : Barang 5 - 1\r\n	2 pcs\r\n', 0),
(6, '2018-10-19 20:09:27', 6, 'Ada nota jual yang dihapus secara otomatis karena kosong', 'Berikut nota jual yang dihapus : \r\n\r\nTgl Hapus : 19-10-2018, 20:09:27\r\nTgl Nota : 19-10-2018\r\nNota Nota Jual : NJ-181019-003\r\nTipe : Dalam Kota\r\nNama Sales : FLASH\r\nNama Pelanggan : TOKO ANGIN RIBUT\r\n\r\n', 0),
(7, '2018-12-01 16:05:24', 6, 'Ada nota jual yang dihapus secara otomatis karena kosong', 'Berikut nota jual yang dihapus : \r\n\r\nTgl Hapus : 01-12-2018, 16:05:24\r\nTgl Nota : 28-11-2018\r\nNota Nota Jual : NJ-181128-002\r\nTipe : Canvass\r\nNama Sales : OWNER\r\nNama Pelanggan : TOKO ANGIN RIBUT\r\n\r\n', 0),
(8, '2018-12-21 15:30:01', 6, 'Ada nota jual yang dihapus secara otomatis karena kosong', 'Berikut nota jual yang dihapus : \r\n\r\nTgl Hapus : 21-12-2018, 15:30:01\r\nTgl Nota : 21-12-2018\r\nNota Nota Jual : NJ-181221-001\r\nTipe : Dalam Kota\r\nNama Sales : OWNER\r\nNama Pelanggan : TOKO ANGIN RIBUT\r\n\r\n', 0),
(9, '2018-12-21 16:36:36', 6, 'Ada nota jual yang dihapus secara otomatis karena kosong', 'Berikut nota jual yang dihapus : \r\n\r\nTgl Hapus : 21-12-2018, 16:36:36\r\nTgl Nota : 21-12-2018\r\nNota Nota Jual : NJ-181221-002\r\nTipe : Dalam Kota\r\nNama Sales : OWNER\r\nNama Pelanggan : TOKO ANGIN RIBUT\r\n\r\nTgl Hapus : 21-12-2018, 16:36:36\r\nTgl Nota : 21-12-2018\r\nNota Nota Jual : NJ-181221-003\r\nTipe : Dalam Kota\r\nNama Sales : OWNER\r\nNama Pelanggan : TOKO ANGIN RIBUT\r\n\r\n', 0),
(10, '2018-12-21 16:50:54', 6, 'Ada barang yang dihapus sales.', 'Tipe: Dalam Kota\r\nTgl Nota Jual : 21-12-2018\r\nNo Nota Jual : NJ-181221-004\r\nNama Pelanggan : TOKO ANGIN RIBUT\r\nNama Sales : OWNER\r\nNama Barang : Barang 5 - 3\r\n	1 pcs\r\n', 0),
(11, '2018-12-21 17:43:32', 6, 'Ada barang yang dihapus sales.', 'Tipe: Dalam Kota\r\nTgl Nota Jual : 21-12-2018\r\nNo Nota Jual : NJ-181221-004\r\nNama Pelanggan : TOKO ANGIN RIBUT\r\nNama Sales : OWNER\r\nNama Barang : Barang 5 - 3\r\n	1 pcs\r\n', 0),
(12, '2018-12-21 17:43:37', 6, 'Ada barang yang dihapus sales.', 'Tipe: Dalam Kota\r\nTgl Nota Jual : 21-12-2018\r\nNo Nota Jual : NJ-181221-004\r\nNama Pelanggan : TOKO ANGIN RIBUT\r\nNama Sales : OWNER\r\nNama Barang : Barang 5 - 3\r\n	1 pcs\r\n', 0),
(13, '2018-12-21 17:43:40', 6, 'Ada barang yang dihapus sales.', 'Tipe: Dalam Kota\r\nTgl Nota Jual : 21-12-2018\r\nNo Nota Jual : NJ-181221-004\r\nNama Pelanggan : TOKO ANGIN RIBUT\r\nNama Sales : OWNER\r\nNama Barang : Barang 5 - 3\r\n	1 pcs\r\n', 0),
(14, '2018-12-23 10:20:32', 6, 'Ada barang yang dihapus sales.', 'Tipe: Dalam Kota\r\nTgl Nota Jual : 23-12-2018\r\nNo Nota Jual : NJ-181223-001\r\nNama Pelanggan : TOKO ANGIN RIBUT\r\nNama Sales : OWNER\r\nNama Barang : Barang 5 - 3\r\n	2 pcs\r\n', 0),
(15, '2018-12-23 10:20:52', 6, 'Ada barang yang dihapus sales.', 'Tipe: Dalam Kota\r\nTgl Nota Jual : 23-12-2018\r\nNo Nota Jual : NJ-181223-001\r\nNama Pelanggan : TOKO ANGIN RIBUT\r\nNama Sales : OWNER\r\nNama Barang : Barang 5 - 3\r\n	2 pcs\r\n', 0),
(16, '2018-12-27 23:51:25', 6, 'Ada nota jual yang dihapus secara otomatis karena kosong.', 'Berikut nota jual yang dihapus : \r\n\r\nTgl Hapus : 27-12-2018, 23:51:25\r\nTgl Nota : 27-12-2018\r\nNota Nota Jual : NJ-181227-001\r\nTipe : Canvass\r\nNama Sales : FLASH\r\nNama Pelanggan : TOKO ANGIN RIBUT\r\n\r\nTgl Hapus : 27-12-2018, 23:51:25\r\nTgl Nota : 27-12-2018\r\nNota Nota Jual : NJ-181227-002\r\nTipe : Canvass\r\nNama Sales : FLASH\r\nNama Pelanggan : TOKO ANGIN RIBUT\r\n\r\nTgl Hapus : 27-12-2018, 23:51:25\r\nTgl Nota : 27-12-2018\r\nNota Nota Jual : NJ-181227-003\r\nTipe : Canvass\r\nNama Sales : FLASH\r\nNama Pelanggan : TOKO ANGIN RIBUT\r\n\r\nTgl Hapus : 27-12-2018, 23:51:25\r\nTgl Nota : 27-12-2018\r\nNota Nota Jual : NJ-181227-004\r\nTipe : Canvass\r\nNama Sales : FLASH\r\nNama Pelanggan : TOKO ANGIN RIBUT\r\n\r\nTgl Hapus : 27-12-2018, 23:51:25\r\nTgl Nota : 27-12-2018\r\nNota Nota Jual : NJ-181227-005\r\nTipe : Canvass\r\nNama Sales : FLASH\r\nNama Pelanggan : TOKO ANGIN RIBUT\r\n\r\nTgl Hapus : 27-12-2018, 23:51:25\r\nTgl Nota : 27-12-2018\r\nNota Nota Jual : NJ-181227-006\r\nTipe : Canvass\r\nNama Sales : FLASH\r\nNama Pelanggan : TOKO ANGIN RIBUT\r\n\r\n', 1),
(17, '2018-12-28 22:47:29', 6, 'Ada barang yang dihapus sales.', 'Tipe: Dalam Kota\r\nTgl Nota Jual : 28-12-2018\r\nNo Nota Jual : NJ-181228-001\r\nNama Pelanggan : TOKO ANGIN RIBUT\r\nNama Sales : OWNER\r\nNama Barang : Barang 5 - 3\r\n	2 pcs\r\n', 1),
(18, '2018-12-28 23:16:18', 6, 'Ada barang yang dihapus sales.', 'Tipe: Canvass\r\nTgl Nota Jual : 28-12-2018\r\nNo Nota Jual : NJ-181228-002\r\nNama Pelanggan : TOKO ANGIN RIBUT\r\nNama Sales : OWNER\r\nNama Barang : Barang 5 - 1\r\n	10 pcs\r\n', 1),
(19, '2018-12-28 23:16:25', 6, 'Ada barang yang dihapus sales.', 'Tipe: Canvass\r\nTgl Nota Jual : 28-12-2018\r\nNo Nota Jual : NJ-181228-002\r\nNama Pelanggan : TOKO ANGIN RIBUT\r\nNama Sales : OWNER\r\nNama Barang : Barang 5 - 2\r\n	2 pcs\r\n', 1);

-- --------------------------------------------------------

--
-- Table structure for table `plat_detail`
--

CREATE TABLE `plat_detail` (
  `id_plat_detail` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `id_kendaraan` int(11) NOT NULL,
  `plat` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `plat_detail`
--

INSERT INTO `plat_detail` (`id_plat_detail`, `tanggal`, `id_kendaraan`, `plat`) VALUES
(1, '2017-12-20', 1, 'be 5555 Ggg'),
(2, '2017-12-30', 1, 'be 3242 fgf'),
(4, '2017-12-30', 1, 'be 4545 dfb'),
(5, '2017-12-21', 13, 'dv 3244 def'),
(6, '2017-12-30', 13, 'sd 3253 Ewf'),
(8, '2017-12-21', 13, 'ew 4324 dfs'),
(9, '2017-12-21', 13, 'rg 4565 rgv'),
(11, '2017-12-22', 1, 'be 4353 fdv'),
(13, '2017-12-22', 14, 'be 9999 sss'),
(14, '2017-12-22', 14, 'de 4545 fg'),
(16, '2017-12-30', 14, 'wd 2323 dsd'),
(18, '2018-02-02', 1, 'BE 4444 idx'),
(19, '2019-01-10', 17, 'D 8536 CE'),
(20, '2019-01-11', 17, 'D 7854 FF');

-- --------------------------------------------------------

--
-- Table structure for table `potongan`
--

CREATE TABLE `potongan` (
  `id_potongan` int(11) NOT NULL,
  `tanggal_potongan` date DEFAULT NULL,
  `id_karyawan` int(11) DEFAULT NULL,
  `jumlah_potongan` float DEFAULT NULL,
  `jenis_potongan` enum('GAJI','TUNAI') DEFAULT NULL,
  `keterangan` text,
  `status_potong_gaji` char(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `potongan`
--

INSERT INTO `potongan` (`id_potongan`, `tanggal_potongan`, `id_karyawan`, `jumlah_potongan`, `jenis_potongan`, `keterangan`, `status_potong_gaji`) VALUES
(2, '2018-07-06', 6, 3000000, 'GAJI', 'aa', '2'),
(3, '2018-07-06', 1, 4000000, 'TUNAI', 'haha', '1'),
(4, '2018-07-06', 1, 250000, 'GAJI', 'sip', '0'),
(5, '2018-07-07', 1, 1000, 'TUNAI', 'f', '1'),
(6, '2018-07-07', 1, 300000, 'GAJI', 'dad', '0');

-- --------------------------------------------------------

--
-- Table structure for table `potongan_gaji`
--

CREATE TABLE `potongan_gaji` (
  `id_potongan_gaji` int(11) NOT NULL,
  `id_penggajian_detail` int(11) DEFAULT NULL,
  `id_potongan` int(11) DEFAULT NULL,
  `jumlah_potongan_gaji` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `potongan_gaji`
--

INSERT INTO `potongan_gaji` (`id_potongan_gaji`, `id_penggajian_detail`, `id_potongan`, `jumlah_potongan_gaji`) VALUES
(5, 1, 2, 1200000);

-- --------------------------------------------------------

--
-- Table structure for table `provinsi`
--

CREATE TABLE `provinsi` (
  `id_prov` int(11) NOT NULL,
  `id_negara` int(11) NOT NULL,
  `nama_prov` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `provinsi`
--

INSERT INTO `provinsi` (`id_prov`, `id_negara`, `nama_prov`) VALUES
(1, 1, 'Lampung'),
(2, 1, 'DKI JAKARTA'),
(3, 2, 'M'),
(4, 2, 'Y'),
(5, 3, 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'),
(6, 2, 'abc'),
(9, 2, 'def'),
(10, 4, 'Sorok'),
(11, 4, 'Kuala Lumpur');

-- --------------------------------------------------------

--
-- Table structure for table `rak`
--

CREATE TABLE `rak` (
  `id_rak` int(11) NOT NULL,
  `id_gudang` int(11) NOT NULL,
  `nama_rak` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rak`
--

INSERT INTO `rak` (`id_rak`, `id_gudang`, `nama_rak`) VALUES
(1, 2, 'A01'),
(2, 2, 'B02'),
(3, 3, 'C02'),
(5, 3, 'XYZ'),
(6, 6, 'yuweywr'),
(7, 3, 'C06'),
(8, 4, 'qwerty'),
(9, 5, 'cdd'),
(10, 7, 'Food'),
(11, 8, 'Powder');

-- --------------------------------------------------------

--
-- Table structure for table `retur_beli`
--

CREATE TABLE `retur_beli` (
  `id_retur_beli` int(11) NOT NULL,
  `tgl_retur` date NOT NULL,
  `no_retur_beli` varchar(13) NOT NULL,
  `id_beli` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `retur_beli`
--

INSERT INTO `retur_beli` (`id_retur_beli`, `tgl_retur`, `no_retur_beli`, `id_beli`, `status`) VALUES
(1, '2018-12-23', 'RB-181223-001', 26, 0);

-- --------------------------------------------------------

--
-- Table structure for table `retur_beli_detail`
--

CREATE TABLE `retur_beli_detail` (
  `id_retur_beli_detail` int(11) NOT NULL,
  `id_retur_beli` int(11) DEFAULT NULL,
  `id_beli_detail` bigint(20) DEFAULT NULL,
  `id_barang_masuk_rak` bigint(20) DEFAULT NULL,
  `qty_retur` int(11) DEFAULT NULL,
  `harga_retur` double DEFAULT NULL,
  `qty_keluar` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `retur_beli_detail`
--

INSERT INTO `retur_beli_detail` (`id_retur_beli_detail`, `id_retur_beli`, `id_beli_detail`, `id_barang_masuk_rak`, `qty_retur`, `harga_retur`, `qty_keluar`) VALUES
(6, 1, 90, 16, 5, 500000, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `retur_jual`
--

CREATE TABLE `retur_jual` (
  `id_retur_jual` int(11) NOT NULL,
  `tgl_retur` date NOT NULL,
  `no_retur_jual` varchar(13) NOT NULL,
  `id_jual` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `retur_jual`
--

INSERT INTO `retur_jual` (`id_retur_jual`, `tgl_retur`, `no_retur_jual`, `id_jual`, `status`) VALUES
(2, '2018-09-01', 'RJ-180901-001', 4, 2),
(3, '2018-09-01', 'RJ-180901-002', 4, 0),
(5, '2018-11-23', 'RJ-181123-001', 3, 0),
(6, '2018-11-23', 'RJ-181123-002', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `retur_jual_detail`
--

CREATE TABLE `retur_jual_detail` (
  `id_retur_jual_detail` int(11) NOT NULL,
  `id_retur_jual` int(11) DEFAULT NULL,
  `id_jual_detail` bigint(20) DEFAULT NULL,
  `qty_retur` int(11) DEFAULT NULL,
  `harga_retur` double DEFAULT NULL,
  `qty_masuk` int(11) DEFAULT NULL,
  `id_rak` int(11) DEFAULT NULL,
  `id_bmr` int(11) DEFAULT NULL,
  `expire` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `retur_jual_detail`
--

INSERT INTO `retur_jual_detail` (`id_retur_jual_detail`, `id_retur_jual`, `id_jual_detail`, `qty_retur`, `harga_retur`, `qty_masuk`, `id_rak`, `id_bmr`, `expire`) VALUES
(3, 2, 6, 1, 1000000, 1, 7, 135, '2018-10-19'),
(4, 4, 3, 1, 1000000, NULL, NULL, NULL, NULL),
(5, 5, 5, 4, 13523.88, NULL, NULL, NULL, NULL),
(6, 6, 2, 1, 100000, NULL, NULL, NULL, NULL),
(7, 6, 1, 1, 10000, NULL, NULL, NULL, NULL),
(8, 7, 1, 1, 10000, NULL, NULL, NULL, NULL),
(10, 3, 6, 1, 160698, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `satuan`
--

CREATE TABLE `satuan` (
  `id_satuan` int(11) NOT NULL,
  `nama_satuan` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `satuan`
--

INSERT INTO `satuan` (`id_satuan`, `nama_satuan`) VALUES
(6, 'bisri'),
(3, 'buah'),
(5, 'kotak'),
(1, 'pcs'),
(7, 'Tabung'),
(2, 'unit');

-- --------------------------------------------------------

--
-- Table structure for table `stock_opname`
--

CREATE TABLE `stock_opname` (
  `id_so` int(11) NOT NULL,
  `tanggal_so` date DEFAULT NULL,
  `status_so` tinyint(1) DEFAULT NULL,
  `id_karyawan` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stock_opname`
--

INSERT INTO `stock_opname` (`id_so`, `tanggal_so`, `status_so`, `id_karyawan`) VALUES
(1, '2018-12-03', 0, 2),
(2, '2018-12-03', 0, 2),
(3, '2018-12-03', 1, 2),
(4, '2019-01-08', 0, 1),
(5, '2019-01-09', 0, 5);

-- --------------------------------------------------------

--
-- Table structure for table `stock_opname_detail`
--

CREATE TABLE `stock_opname_detail` (
  `id_so_detail` int(11) NOT NULL,
  `id_so` int(11) DEFAULT NULL,
  `id_barang` int(11) DEFAULT NULL,
  `id_rak` int(11) DEFAULT NULL,
  `expire` date DEFAULT NULL,
  `jumlah_barang` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stock_opname_detail`
--

INSERT INTO `stock_opname_detail` (`id_so_detail`, `id_so`, `id_barang`, `id_rak`, `expire`, `jumlah_barang`) VALUES
(2, 3, 1, 7, '2022-02-22', 15);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id_supplier` int(11) NOT NULL,
  `nama_supplier` varchar(50) NOT NULL,
  `alamat` varchar(200) NOT NULL,
  `id_negara` int(11) NOT NULL,
  `id_prov` int(11) NOT NULL,
  `id_kab` int(11) NOT NULL,
  `id_kec` int(11) DEFAULT NULL,
  `id_kel` int(11) DEFAULT NULL,
  `kode_pos` varchar(7) DEFAULT NULL,
  `telepon_supplier` varchar(20) NOT NULL,
  `kontakperson` varchar(50) DEFAULT NULL,
  `telepon_kontak` varchar(20) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id_supplier`, `nama_supplier`, `alamat`, `id_negara`, `id_prov`, `id_kab`, `id_kec`, `id_kel`, `kode_pos`, `telepon_supplier`, `kontakperson`, `telepon_kontak`, `status`) VALUES
(1, 'PT. ABC', 'dasvdsvdsb', 1, 1, 1, 1, 1, '', '02431413435', '2143425265', '4535435', 1),
(2, 'PT. XYZ', 'dvgefvfev', 1, 1, 1, 1, 1, '35132', '56462527', 'dascvdsv', '453435', 1),
(3, 'dsvfbvee ', 'fecvef vfvfvd', 1, 1, 1, 1, 1, '35132', '23423523525', 'fdv dfcv dfv', '234235', 1),
(4, 'qwfdewcfwec', 'ewdfwfwcdc', 1, 1, 1, 1, 1, '322344', '3423423424', 'scdvdvcdv', '2312423434234', 1),
(5, 'rfgvbfd', 'fgvfdbvfdbv', 2, 3, 3, 4, 4, '35132', '3432534534556', 'fgdsg', '435345435435', 1),
(6, 'dcdcds', 'dwcwdc', 2, 3, 3, 4, 4, '352314', '231242', '214241', '21424', 1),
(7, 'wedfcsdvc', 'dsvsdvdv', 2, 3, 3, 4, 4, '2344', '32423424', '23423423', '324234234', 1),
(8, 'cdcsdcdvc', 'fedwcvwdvcwdvc', 2, 3, 3, 4, 4, '7765765', '32423423325325235253', 'ewfwefwewgege', '32532525353523523523', 1),
(9, '111111111111', '111111111111111111111111', 1, 1, 1, 1, 0, '', '111111111111', '111111111', '111111111', 0),
(10, 'DIRI SENDIRI', '-', 1, 1, 1, 1, 1, '', '5675765', 'sdscs', '234', 1),
(11, 'test', 'dfdscf', 1, 1, 1, 0, 0, '', '324234', '434242', '434234', 1),
(12, 'PT. Insan Jaya', 'hvyufy', 4, 11, 15, 9, 11, '646', '3156464', '6166', '66464', 1),
(13, 'gh', 'hg', 4, 11, 15, 9, 11, '6757', '1651651', '16161', '61616', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `id_karyawan` int(11) NOT NULL,
  `posisi` varchar(20) NOT NULL,
  `user` varchar(30) NOT NULL,
  `password` text NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `id_karyawan`, `posisi`, `user`, `password`, `status`) VALUES
(1, 1, 'SALES', 'FLASH', '202cb962ac59075b964b07152d234b70', 1),
(2, 2, 'GUDANG', 'RIN', '202cb962ac59075b964b07152d234b70', 1),
(3, 3, 'DRIVER', 'ZEN', '202cb962ac59075b964b07152d234b70', 1),
(4, 4, 'GUDANG', 'edfewf', 'cd6a1a15421189de23d7309feebff8d7', 1),
(5, 5, 'DIREKSI', 'ADMIN', '73acd9a5972130b75066c82595a1fae3', 1),
(6, 6, 'OWNER', 'OWNER', '202cb962ac59075b964b07152d234b70', 1),
(7, 9, 'DRIVER', 'HI', '202cb962ac59075b964b07152d234b70', 0),
(8, 10, 'DIREKSI', 'ADMIN2', '63db3feba0befbb1d61a7e38ae0bf069', 1),
(9, 11, 'SALES', 'BEAN', '202cb962ac59075b964b07152d234b70', 1),
(10, 12, 'DRIVER', 'ANDRI', '202cb962ac59075b964b07152d234b70', 0);

-- --------------------------------------------------------

--
-- Table structure for table `varian_kendaraan`
--

CREATE TABLE `varian_kendaraan` (
  `id_varian` int(11) NOT NULL,
  `nama_jenis` varchar(25) NOT NULL,
  `nama_varian` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `varian_kendaraan`
--

INSERT INTO `varian_kendaraan` (`id_varian`, `nama_jenis`, `nama_varian`) VALUES
(1, 'MOBIL', 'PICK UP'),
(2, 'MOBIL', 'MINI VAN'),
(3, 'MOBIL', 'hhhhhhhhhhhhhhhhhhhh'),
(4, 'MOTOR', 'Vespa'),
(5, 'MOTOR', 'Matic');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`),
  ADD UNIQUE KEY `nama_barang` (`nama_barang`),
  ADD KEY `id_satuan` (`id_satuan`);

--
-- Indexes for table `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD PRIMARY KEY (`id_barang_masuk`),
  ADD KEY `id_beli_detail` (`id_beli_detail`);

--
-- Indexes for table `barang_masuk_rak`
--
ALTER TABLE `barang_masuk_rak`
  ADD PRIMARY KEY (`id_barang_masuk_rak`),
  ADD KEY `id_barang_masuk` (`id_barang_masuk`),
  ADD KEY `id_rak` (`id_rak`);

--
-- Indexes for table `barang_supplier`
--
ALTER TABLE `barang_supplier`
  ADD PRIMARY KEY (`id_barang_supplier`),
  ADD KEY `id_barang` (`id_barang`);

--
-- Indexes for table `batal_kirim`
--
ALTER TABLE `batal_kirim`
  ADD PRIMARY KEY (`id_batal_kirim`),
  ADD UNIQUE KEY `id_jual` (`id_jual`);

--
-- Indexes for table `batal_kirim_detail`
--
ALTER TABLE `batal_kirim_detail`
  ADD PRIMARY KEY (`id_batal_kirim_detail`);

--
-- Indexes for table `batal_kirim_detail_2`
--
ALTER TABLE `batal_kirim_detail_2`
  ADD PRIMARY KEY (`id_batal_kirim_detail_id`);

--
-- Indexes for table `bayar_ekspedisi`
--
ALTER TABLE `bayar_ekspedisi`
  ADD PRIMARY KEY (`id_bayar_ekspedisi`),
  ADD UNIQUE KEY `id_beli` (`id_beli`);

--
-- Indexes for table `bayar_ekspedisi_detail`
--
ALTER TABLE `bayar_ekspedisi_detail`
  ADD PRIMARY KEY (`id_bayar_ekspedisi_detail`);

--
-- Indexes for table `bayar_nota_beli`
--
ALTER TABLE `bayar_nota_beli`
  ADD PRIMARY KEY (`id_bayar`);

--
-- Indexes for table `bayar_nota_beli_detail`
--
ALTER TABLE `bayar_nota_beli_detail`
  ADD PRIMARY KEY (`id_bayar_detail`);

--
-- Indexes for table `bayar_nota_jual`
--
ALTER TABLE `bayar_nota_jual`
  ADD PRIMARY KEY (`id_bayar`);

--
-- Indexes for table `bayar_nota_jual_detail`
--
ALTER TABLE `bayar_nota_jual_detail`
  ADD PRIMARY KEY (`id_bayar_detail`);

--
-- Indexes for table `beli`
--
ALTER TABLE `beli`
  ADD PRIMARY KEY (`id_beli`),
  ADD UNIQUE KEY `no_nota_beli` (`no_nota_beli`),
  ADD KEY `id_supplier` (`id_supplier`),
  ADD KEY `id_ekspedisi` (`id_ekspedisi`);

--
-- Indexes for table `beli_detail`
--
ALTER TABLE `beli_detail`
  ADD PRIMARY KEY (`id_beli_detail`),
  ADD KEY `id_beli` (`id_beli`),
  ADD KEY `id_barang_supplier` (`id_barang_supplier`);

--
-- Indexes for table `bonus`
--
ALTER TABLE `bonus`
  ADD PRIMARY KEY (`id_bonus`);

--
-- Indexes for table `bonus_gaji`
--
ALTER TABLE `bonus_gaji`
  ADD PRIMARY KEY (`id_bonus_gaji`);

--
-- Indexes for table `canvass_belum_siap`
--
ALTER TABLE `canvass_belum_siap`
  ADD PRIMARY KEY (`id_canvass_belum_siap`),
  ADD UNIQUE KEY `id_jual` (`id_jual`);

--
-- Indexes for table `canvass_keluar`
--
ALTER TABLE `canvass_keluar`
  ADD PRIMARY KEY (`id_canvass_keluar`);

--
-- Indexes for table `canvass_keluar_barang`
--
ALTER TABLE `canvass_keluar_barang`
  ADD PRIMARY KEY (`id_canvass_keluar_barang`);

--
-- Indexes for table `canvass_keluar_karyawan`
--
ALTER TABLE `canvass_keluar_karyawan`
  ADD PRIMARY KEY (`id_canvass_keluar_karyawan`);

--
-- Indexes for table `canvass_mutasi_mobil_gudang`
--
ALTER TABLE `canvass_mutasi_mobil_gudang`
  ADD PRIMARY KEY (`id_canvass_mutasi_mobil_gudang`);

--
-- Indexes for table `canvass_siap_kirim`
--
ALTER TABLE `canvass_siap_kirim`
  ADD PRIMARY KEY (`id_canvass_siap_kirim`),
  ADD UNIQUE KEY `id_jual` (`id_jual`);

--
-- Indexes for table `canvass_siap_kirim_detail`
--
ALTER TABLE `canvass_siap_kirim_detail`
  ADD PRIMARY KEY (`id_canvass_siap_kirim_detail`);

--
-- Indexes for table `canvass_stock_opname`
--
ALTER TABLE `canvass_stock_opname`
  ADD PRIMARY KEY (`id_canvass_stock_opname`);

--
-- Indexes for table `checkin`
--
ALTER TABLE `checkin`
  ADD PRIMARY KEY (`id_checkin`);

--
-- Indexes for table `data_nota_jual`
--
ALTER TABLE `data_nota_jual`
  ADD PRIMARY KEY (`id_data_nota_jual`);

--
-- Indexes for table `ekspedisi`
--
ALTER TABLE `ekspedisi`
  ADD PRIMARY KEY (`id_ekspedisi`),
  ADD UNIQUE KEY `nama_ekspedisi` (`nama_ekspedisi`);

--
-- Indexes for table `gudang`
--
ALTER TABLE `gudang`
  ADD PRIMARY KEY (`id_gudang`),
  ADD UNIQUE KEY `nama_gudang` (`nama_gudang`);

--
-- Indexes for table `harga_jual`
--
ALTER TABLE `harga_jual`
  ADD PRIMARY KEY (`id_harga_jual`),
  ADD KEY `id_barang_supplier` (`id_barang_supplier`),
  ADD KEY `id_customer` (`id_pelanggan`);

--
-- Indexes for table `harga_jual_kredit`
--
ALTER TABLE `harga_jual_kredit`
  ADD PRIMARY KEY (`id_harga_jual_kredit`);

--
-- Indexes for table `hj_kredit_detail`
--
ALTER TABLE `hj_kredit_detail`
  ADD PRIMARY KEY (`id_hj_kredit_detail`);

--
-- Indexes for table `hj_tunai_detail`
--
ALTER TABLE `hj_tunai_detail`
  ADD PRIMARY KEY (`id_hj_tunai_detail`);

--
-- Indexes for table `jabatan`
--
ALTER TABLE `jabatan`
  ADD PRIMARY KEY (`id_jabatan`);

--
-- Indexes for table `jual`
--
ALTER TABLE `jual`
  ADD PRIMARY KEY (`id_jual`),
  ADD UNIQUE KEY `invoice` (`invoice`);

--
-- Indexes for table `jual_detail`
--
ALTER TABLE `jual_detail`
  ADD PRIMARY KEY (`id_jual_detail`),
  ADD KEY `id_harga_jual` (`id_harga_jual`),
  ADD KEY `id_jual` (`id_jual`);

--
-- Indexes for table `kabupaten`
--
ALTER TABLE `kabupaten`
  ADD PRIMARY KEY (`id_kab`),
  ADD UNIQUE KEY `nama` (`nama_kab`);

--
-- Indexes for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`id_karyawan`),
  ADD UNIQUE KEY `barcode` (`barcode`),
  ADD UNIQUE KEY `ktp` (`ktp`);

--
-- Indexes for table `kas_kecil`
--
ALTER TABLE `kas_kecil`
  ADD PRIMARY KEY (`id_kas_kecil`);

--
-- Indexes for table `kecamatan`
--
ALTER TABLE `kecamatan`
  ADD PRIMARY KEY (`id_kec`),
  ADD UNIQUE KEY `nama` (`nama_kec`);

--
-- Indexes for table `kelurahan`
--
ALTER TABLE `kelurahan`
  ADD PRIMARY KEY (`id_kel`),
  ADD UNIQUE KEY `nama` (`nama_kel`);

--
-- Indexes for table `kendaraan`
--
ALTER TABLE `kendaraan`
  ADD PRIMARY KEY (`id_kendaraan`),
  ADD UNIQUE KEY `nama_kendaraan` (`nama_kendaraan`),
  ADD UNIQUE KEY `plat` (`plat`);

--
-- Indexes for table `komisi`
--
ALTER TABLE `komisi`
  ADD PRIMARY KEY (`id_komisi`);

--
-- Indexes for table `komisi_kredit`
--
ALTER TABLE `komisi_kredit`
  ADD PRIMARY KEY (`id_komisi_kredit`),
  ADD UNIQUE KEY `hari` (`hari`);

--
-- Indexes for table `konfirm_owner`
--
ALTER TABLE `konfirm_owner`
  ADD PRIMARY KEY (`id_konfirm_owner`);

--
-- Indexes for table `konfirm_owner_detail`
--
ALTER TABLE `konfirm_owner_detail`
  ADD PRIMARY KEY (`id_konfirm_owner_detail`);

--
-- Indexes for table `lap_stock_opname`
--
ALTER TABLE `lap_stock_opname`
  ADD PRIMARY KEY (`id_laporan_stock_opname`);

--
-- Indexes for table `mst_kas_kecil`
--
ALTER TABLE `mst_kas_kecil`
  ADD PRIMARY KEY (`id_kas_kecil`),
  ADD UNIQUE KEY `nama_kas_kecil` (`nama_kas_kecil`);

--
-- Indexes for table `negara`
--
ALTER TABLE `negara`
  ADD PRIMARY KEY (`id_negara`),
  ADD UNIQUE KEY `nama_negara` (`nama_negara`);

--
-- Indexes for table `nota_siap_kirim`
--
ALTER TABLE `nota_siap_kirim`
  ADD PRIMARY KEY (`id_nota_siap_kirim`),
  ADD UNIQUE KEY `id_jual` (`id_jual`);

--
-- Indexes for table `nota_siap_kirim_detail`
--
ALTER TABLE `nota_siap_kirim_detail`
  ADD PRIMARY KEY (`id_nota_siap_kirim_detail`);

--
-- Indexes for table `nota_sudah_cek`
--
ALTER TABLE `nota_sudah_cek`
  ADD PRIMARY KEY (`id_nota_sudah_cek`),
  ADD UNIQUE KEY `id_jual` (`id_jual`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indexes for table `penagihan`
--
ALTER TABLE `penagihan`
  ADD PRIMARY KEY (`id_penagihan`);

--
-- Indexes for table `penagihan_detail`
--
ALTER TABLE `penagihan_detail`
  ADD PRIMARY KEY (`id_penagihan_detail`);

--
-- Indexes for table `penagihan_retur_detail`
--
ALTER TABLE `penagihan_retur_detail`
  ADD PRIMARY KEY (`id_penagihan_retur_detail`);

--
-- Indexes for table `penggajian`
--
ALTER TABLE `penggajian`
  ADD PRIMARY KEY (`id_penggajian`),
  ADD UNIQUE KEY `NewIndex1` (`tanggal`);

--
-- Indexes for table `penggajian_detail`
--
ALTER TABLE `penggajian_detail`
  ADD PRIMARY KEY (`id_penggajian_detail`);

--
-- Indexes for table `pengiriman`
--
ALTER TABLE `pengiriman`
  ADD PRIMARY KEY (`id_pengiriman`),
  ADD UNIQUE KEY `id_jual` (`id_jual`);

--
-- Indexes for table `perusahaan`
--
ALTER TABLE `perusahaan`
  ADD PRIMARY KEY (`id_perusahaan`);

--
-- Indexes for table `pesan`
--
ALTER TABLE `pesan`
  ADD PRIMARY KEY (`id_pesan`);

--
-- Indexes for table `plat_detail`
--
ALTER TABLE `plat_detail`
  ADD PRIMARY KEY (`id_plat_detail`),
  ADD UNIQUE KEY `plat` (`plat`);

--
-- Indexes for table `potongan`
--
ALTER TABLE `potongan`
  ADD PRIMARY KEY (`id_potongan`);

--
-- Indexes for table `potongan_gaji`
--
ALTER TABLE `potongan_gaji`
  ADD PRIMARY KEY (`id_potongan_gaji`);

--
-- Indexes for table `provinsi`
--
ALTER TABLE `provinsi`
  ADD PRIMARY KEY (`id_prov`),
  ADD UNIQUE KEY `nama` (`nama_prov`);

--
-- Indexes for table `rak`
--
ALTER TABLE `rak`
  ADD PRIMARY KEY (`id_rak`),
  ADD UNIQUE KEY `nama_rak` (`nama_rak`),
  ADD KEY `id_gudang` (`id_gudang`);

--
-- Indexes for table `retur_beli`
--
ALTER TABLE `retur_beli`
  ADD PRIMARY KEY (`id_retur_beli`),
  ADD UNIQUE KEY `id_beli` (`id_beli`);

--
-- Indexes for table `retur_beli_detail`
--
ALTER TABLE `retur_beli_detail`
  ADD PRIMARY KEY (`id_retur_beli_detail`);

--
-- Indexes for table `retur_jual`
--
ALTER TABLE `retur_jual`
  ADD PRIMARY KEY (`id_retur_jual`);

--
-- Indexes for table `retur_jual_detail`
--
ALTER TABLE `retur_jual_detail`
  ADD PRIMARY KEY (`id_retur_jual_detail`);

--
-- Indexes for table `satuan`
--
ALTER TABLE `satuan`
  ADD PRIMARY KEY (`id_satuan`),
  ADD UNIQUE KEY `nama_satuan` (`nama_satuan`);

--
-- Indexes for table `stock_opname`
--
ALTER TABLE `stock_opname`
  ADD PRIMARY KEY (`id_so`);

--
-- Indexes for table `stock_opname_detail`
--
ALTER TABLE `stock_opname_detail`
  ADD PRIMARY KEY (`id_so_detail`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id_supplier`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `id_karyawan` (`id_karyawan`),
  ADD UNIQUE KEY `user` (`user`);

--
-- Indexes for table `varian_kendaraan`
--
ALTER TABLE `varian_kendaraan`
  ADD PRIMARY KEY (`id_varian`),
  ADD UNIQUE KEY `nama_varian` (`nama_varian`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id_barang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `barang_masuk`
--
ALTER TABLE `barang_masuk`
  MODIFY `id_barang_masuk` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=284;

--
-- AUTO_INCREMENT for table `barang_masuk_rak`
--
ALTER TABLE `barang_masuk_rak`
  MODIFY `id_barang_masuk_rak` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- AUTO_INCREMENT for table `barang_supplier`
--
ALTER TABLE `barang_supplier`
  MODIFY `id_barang_supplier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `batal_kirim`
--
ALTER TABLE `batal_kirim`
  MODIFY `id_batal_kirim` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `batal_kirim_detail`
--
ALTER TABLE `batal_kirim_detail`
  MODIFY `id_batal_kirim_detail` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `batal_kirim_detail_2`
--
ALTER TABLE `batal_kirim_detail_2`
  MODIFY `id_batal_kirim_detail_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bayar_ekspedisi`
--
ALTER TABLE `bayar_ekspedisi`
  MODIFY `id_bayar_ekspedisi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `bayar_ekspedisi_detail`
--
ALTER TABLE `bayar_ekspedisi_detail`
  MODIFY `id_bayar_ekspedisi_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `bayar_nota_beli`
--
ALTER TABLE `bayar_nota_beli`
  MODIFY `id_bayar` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `bayar_nota_beli_detail`
--
ALTER TABLE `bayar_nota_beli_detail`
  MODIFY `id_bayar_detail` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bayar_nota_jual`
--
ALTER TABLE `bayar_nota_jual`
  MODIFY `id_bayar` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `bayar_nota_jual_detail`
--
ALTER TABLE `bayar_nota_jual_detail`
  MODIFY `id_bayar_detail` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `beli`
--
ALTER TABLE `beli`
  MODIFY `id_beli` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `beli_detail`
--
ALTER TABLE `beli_detail`
  MODIFY `id_beli_detail` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=227;

--
-- AUTO_INCREMENT for table `bonus`
--
ALTER TABLE `bonus`
  MODIFY `id_bonus` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bonus_gaji`
--
ALTER TABLE `bonus_gaji`
  MODIFY `id_bonus_gaji` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `canvass_belum_siap`
--
ALTER TABLE `canvass_belum_siap`
  MODIFY `id_canvass_belum_siap` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `canvass_keluar`
--
ALTER TABLE `canvass_keluar`
  MODIFY `id_canvass_keluar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `canvass_keluar_barang`
--
ALTER TABLE `canvass_keluar_barang`
  MODIFY `id_canvass_keluar_barang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `canvass_keluar_karyawan`
--
ALTER TABLE `canvass_keluar_karyawan`
  MODIFY `id_canvass_keluar_karyawan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `canvass_mutasi_mobil_gudang`
--
ALTER TABLE `canvass_mutasi_mobil_gudang`
  MODIFY `id_canvass_mutasi_mobil_gudang` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `canvass_siap_kirim`
--
ALTER TABLE `canvass_siap_kirim`
  MODIFY `id_canvass_siap_kirim` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `canvass_siap_kirim_detail`
--
ALTER TABLE `canvass_siap_kirim_detail`
  MODIFY `id_canvass_siap_kirim_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `canvass_stock_opname`
--
ALTER TABLE `canvass_stock_opname`
  MODIFY `id_canvass_stock_opname` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `checkin`
--
ALTER TABLE `checkin`
  MODIFY `id_checkin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `data_nota_jual`
--
ALTER TABLE `data_nota_jual`
  MODIFY `id_data_nota_jual` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `ekspedisi`
--
ALTER TABLE `ekspedisi`
  MODIFY `id_ekspedisi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `gudang`
--
ALTER TABLE `gudang`
  MODIFY `id_gudang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `harga_jual`
--
ALTER TABLE `harga_jual`
  MODIFY `id_harga_jual` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `harga_jual_kredit`
--
ALTER TABLE `harga_jual_kredit`
  MODIFY `id_harga_jual_kredit` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `hj_kredit_detail`
--
ALTER TABLE `hj_kredit_detail`
  MODIFY `id_hj_kredit_detail` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `hj_tunai_detail`
--
ALTER TABLE `hj_tunai_detail`
  MODIFY `id_hj_tunai_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `jabatan`
--
ALTER TABLE `jabatan`
  MODIFY `id_jabatan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `jual`
--
ALTER TABLE `jual`
  MODIFY `id_jual` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `jual_detail`
--
ALTER TABLE `jual_detail`
  MODIFY `id_jual_detail` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `kabupaten`
--
ALTER TABLE `kabupaten`
  MODIFY `id_kab` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `karyawan`
--
ALTER TABLE `karyawan`
  MODIFY `id_karyawan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `kas_kecil`
--
ALTER TABLE `kas_kecil`
  MODIFY `id_kas_kecil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `kecamatan`
--
ALTER TABLE `kecamatan`
  MODIFY `id_kec` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `kelurahan`
--
ALTER TABLE `kelurahan`
  MODIFY `id_kel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `kendaraan`
--
ALTER TABLE `kendaraan`
  MODIFY `id_kendaraan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `komisi`
--
ALTER TABLE `komisi`
  MODIFY `id_komisi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `komisi_kredit`
--
ALTER TABLE `komisi_kredit`
  MODIFY `id_komisi_kredit` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `konfirm_owner`
--
ALTER TABLE `konfirm_owner`
  MODIFY `id_konfirm_owner` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `konfirm_owner_detail`
--
ALTER TABLE `konfirm_owner_detail`
  MODIFY `id_konfirm_owner_detail` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lap_stock_opname`
--
ALTER TABLE `lap_stock_opname`
  MODIFY `id_laporan_stock_opname` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mst_kas_kecil`
--
ALTER TABLE `mst_kas_kecil`
  MODIFY `id_kas_kecil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `negara`
--
ALTER TABLE `negara`
  MODIFY `id_negara` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `nota_siap_kirim`
--
ALTER TABLE `nota_siap_kirim`
  MODIFY `id_nota_siap_kirim` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `nota_siap_kirim_detail`
--
ALTER TABLE `nota_siap_kirim_detail`
  MODIFY `id_nota_siap_kirim_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `nota_sudah_cek`
--
ALTER TABLE `nota_sudah_cek`
  MODIFY `id_nota_sudah_cek` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `penagihan`
--
ALTER TABLE `penagihan`
  MODIFY `id_penagihan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `penagihan_detail`
--
ALTER TABLE `penagihan_detail`
  MODIFY `id_penagihan_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `penagihan_retur_detail`
--
ALTER TABLE `penagihan_retur_detail`
  MODIFY `id_penagihan_retur_detail` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `penggajian`
--
ALTER TABLE `penggajian`
  MODIFY `id_penggajian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `penggajian_detail`
--
ALTER TABLE `penggajian_detail`
  MODIFY `id_penggajian_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `pengiriman`
--
ALTER TABLE `pengiriman`
  MODIFY `id_pengiriman` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `pesan`
--
ALTER TABLE `pesan`
  MODIFY `id_pesan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `plat_detail`
--
ALTER TABLE `plat_detail`
  MODIFY `id_plat_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `potongan`
--
ALTER TABLE `potongan`
  MODIFY `id_potongan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `potongan_gaji`
--
ALTER TABLE `potongan_gaji`
  MODIFY `id_potongan_gaji` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `provinsi`
--
ALTER TABLE `provinsi`
  MODIFY `id_prov` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `rak`
--
ALTER TABLE `rak`
  MODIFY `id_rak` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `retur_beli`
--
ALTER TABLE `retur_beli`
  MODIFY `id_retur_beli` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `retur_beli_detail`
--
ALTER TABLE `retur_beli_detail`
  MODIFY `id_retur_beli_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `retur_jual`
--
ALTER TABLE `retur_jual`
  MODIFY `id_retur_jual` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `retur_jual_detail`
--
ALTER TABLE `retur_jual_detail`
  MODIFY `id_retur_jual_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `satuan`
--
ALTER TABLE `satuan`
  MODIFY `id_satuan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `stock_opname`
--
ALTER TABLE `stock_opname`
  MODIFY `id_so` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `stock_opname_detail`
--
ALTER TABLE `stock_opname_detail`
  MODIFY `id_so_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id_supplier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `varian_kendaraan`
--
ALTER TABLE `varian_kendaraan`
  MODIFY `id_varian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `barang_ibfk_1` FOREIGN KEY (`id_satuan`) REFERENCES `satuan` (`id_satuan`);

--
-- Constraints for table `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD CONSTRAINT `barang_masuk_ibfk_1` FOREIGN KEY (`id_beli_detail`) REFERENCES `beli_detail` (`id_beli_detail`);

--
-- Constraints for table `barang_masuk_rak`
--
ALTER TABLE `barang_masuk_rak`
  ADD CONSTRAINT `barang_masuk_rak_ibfk_1` FOREIGN KEY (`id_barang_masuk`) REFERENCES `barang_masuk` (`id_barang_masuk`),
  ADD CONSTRAINT `barang_masuk_rak_ibfk_3` FOREIGN KEY (`id_rak`) REFERENCES `rak` (`id_rak`);

--
-- Constraints for table `barang_supplier`
--
ALTER TABLE `barang_supplier`
  ADD CONSTRAINT `barang_supplier_ibfk_1` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`);

--
-- Constraints for table `beli`
--
ALTER TABLE `beli`
  ADD CONSTRAINT `beli_ibfk_1` FOREIGN KEY (`id_supplier`) REFERENCES `supplier` (`id_supplier`),
  ADD CONSTRAINT `beli_ibfk_2` FOREIGN KEY (`id_ekspedisi`) REFERENCES `ekspedisi` (`id_ekspedisi`);

--
-- Constraints for table `beli_detail`
--
ALTER TABLE `beli_detail`
  ADD CONSTRAINT `beli_detail_ibfk_1` FOREIGN KEY (`id_beli`) REFERENCES `beli` (`id_beli`),
  ADD CONSTRAINT `beli_detail_ibfk_2` FOREIGN KEY (`id_barang_supplier`) REFERENCES `barang_supplier` (`id_barang_supplier`);

--
-- Constraints for table `harga_jual`
--
ALTER TABLE `harga_jual`
  ADD CONSTRAINT `harga_jual_ibfk_1` FOREIGN KEY (`id_barang_supplier`) REFERENCES `barang_supplier` (`id_barang_supplier`),
  ADD CONSTRAINT `harga_jual_ibfk_2` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`);

--
-- Constraints for table `jual_detail`
--
ALTER TABLE `jual_detail`
  ADD CONSTRAINT `jual_detail_ibfk_1` FOREIGN KEY (`id_harga_jual`) REFERENCES `harga_jual` (`id_harga_jual`),
  ADD CONSTRAINT `jual_detail_ibfk_2` FOREIGN KEY (`id_jual`) REFERENCES `jual` (`id_jual`);

--
-- Constraints for table `rak`
--
ALTER TABLE `rak`
  ADD CONSTRAINT `rak_ibfk_1` FOREIGN KEY (`id_gudang`) REFERENCES `gudang` (`id_gudang`);

--
-- Constraints for table `retur_beli`
--
ALTER TABLE `retur_beli`
  ADD CONSTRAINT `retur_beli_ibfk_1` FOREIGN KEY (`id_beli`) REFERENCES `beli` (`id_beli`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
