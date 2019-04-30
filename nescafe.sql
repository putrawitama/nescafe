-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 29 Apr 2019 pada 05.39
-- Versi server: 10.1.31-MariaDB
-- Versi PHP: 5.6.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nescafe`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_berita`
--

CREATE TABLE `tbl_berita` (
  `ID_BERITA` int(11) NOT NULL,
  `JUDUL_BERITA` varchar(128) DEFAULT NULL,
  `ISI_BERITA` text,
  `FOTO_BERITA` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_berita`
--

INSERT INTO `tbl_berita` (`ID_BERITA`, `JUDUL_BERITA`, `ISI_BERITA`, `FOTO_BERITA`) VALUES
(3, 'aa', '<p>sddffsf</p>', 'aa.jpg'),
(4, 'event', '<p>promo yang</p>\r\n<p>terbai</p>\r\n<p>naewlggkgd</p>\r\n<p>&nbsp;</p>', 'event.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_isi_laporan`
--

CREATE TABLE `tbl_isi_laporan` (
  `AI_ISI_LAPORAN` int(11) NOT NULL,
  `ID_LAPORAN` int(11) NOT NULL,
  `ITEM_JUAL` varchar(50) NOT NULL,
  `HARGA_JUAL` int(11) NOT NULL,
  `JUMLAH_JUAL` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_isi_laporan`
--

INSERT INTO `tbl_isi_laporan` (`AI_ISI_LAPORAN`, `ID_LAPORAN`, `ITEM_JUAL`, `HARGA_JUAL`, `JUMLAH_JUAL`) VALUES
(6, 23, 'RA', 3000, 2),
(7, 23, 'DR', 3000, 3),
(10, 22, 'DR', 3000, 2),
(11, 23, 'LB', 3000, 2),
(14, 25, 'RA', 3000, 1),
(15, 25, 'LB', 3000, 2),
(16, 26, 'RA', 3000, 1),
(17, 26, 'LB', 3000, 1),
(18, 27, 'RA', 3000, 1),
(19, 28, 'OW', 3000, 2),
(20, 28, 'COR', 3000, 10);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_item`
--

CREATE TABLE `tbl_item` (
  `ID_ITEM` varchar(50) NOT NULL,
  `NAMA_ITEM` varchar(50) DEFAULT NULL,
  `HARGA_ITEM` int(11) DEFAULT NULL,
  `FOTO_ITEM` varchar(200) DEFAULT NULL,
  `AI_PRODUK` int(11) DEFAULT NULL,
  `AKTIF` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_item`
--

INSERT INTO `tbl_item` (`ID_ITEM`, `NAMA_ITEM`, `HARGA_ITEM`, `FOTO_ITEM`, `AI_PRODUK`, `AKTIF`) VALUES
('', '', 0, '.jpg', 3, 'n'),
('CAL', 'CAFÉ AU LAIT', 119900, 'CAL.jpg', 1, 'n'),
('COR', 'CORTADO', 119900, 'COR.jpg', 1, 'y'),
('DR', 'DROP RED', 3699000, 'DR.jpg', 1, 'y'),
('DS', 'DROP SILVER', 3699000, 'DS.jpg', 1, 'y'),
('EI', 'ESPRESSO INTENSO', 119000, 'EI.jpg', 1, 'y'),
('GB', 'GENIO 2 MATT BLACK', 2599000, 'machine8.jpg', 1, 'y'),
('GI', 'GRANDE INTENSO', 119000, 'GI.jpg', 1, 'y'),
('GR', 'GENIO 2 RED', 2599000, 'GR.jpg', 1, 'y'),
('LB', 'LUMIO BLACK', 2099000, 'LB.jpg', 1, 'y'),
('MB', 'MINIME BLACK', 1999000, 'MB.jpg', 1, 'y'),
('MW', 'MINIME WHITE', 1999000, 'MW.jpg', 1, 'y'),
('OB', 'OBLO BLACK', 1499000, 'OB.jpg', 1, 'y'),
('OO', 'OBLO ORANGE', 1499000, 'OO.jpg', 1, 'y'),
('OR', 'OBLO RED', 1499000, 'OR.jpg', 1, 'y'),
('OW', 'OBLO WHITE', 1499000, 'OW.jpg', 1, 'y'),
('PIC', 'PICCOLO', 1399000, 'PIC.jpg', 1, 'y'),
('RA', 'RISTRETTO ARDENZA', 119000, 'RA.jpg', 1, 'y');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_kategori`
--

CREATE TABLE `tbl_kategori` (
  `ID_KATEGORI` int(11) NOT NULL,
  `NAMA_KATEGORI` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_kategori`
--

INSERT INTO `tbl_kategori` (`ID_KATEGORI`, `NAMA_KATEGORI`) VALUES
(1, 'Machine'),
(2, 'Capsule'),
(3, 'WIRE'),
(4, 'HAMPERS');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_laporan`
--

CREATE TABLE `tbl_laporan` (
  `AI_LAPORAN` int(11) NOT NULL,
  `LAPORAN_DATE` date NOT NULL,
  `TOKO_JUAL` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_laporan`
--

INSERT INTO `tbl_laporan` (`AI_LAPORAN`, `LAPORAN_DATE`, `TOKO_JUAL`) VALUES
(22, '2019-03-11', 7),
(25, '2019-04-11', 7),
(28, '2019-04-22', 7);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_mutasi`
--

CREATE TABLE `tbl_mutasi` (
  `id_mutasi` int(11) NOT NULL,
  `id_toko` int(11) NOT NULL,
  `id_barang` varchar(50) NOT NULL,
  `stok_awal` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `stok_akhir` int(11) NOT NULL,
  `created_at` date NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_pegawai`
--

CREATE TABLE `tbl_pegawai` (
  `NIP` int(11) NOT NULL,
  `NAMA_PEG` varchar(50) DEFAULT NULL,
  `PASSWORD` varchar(50) DEFAULT NULL,
  `ALAMAT_PEG` varchar(200) DEFAULT NULL,
  `EMAIL_PEG` varchar(50) DEFAULT NULL,
  `TLP_PEG` varchar(20) DEFAULT NULL,
  `TGL_MASUK` date NOT NULL,
  `JENIS_KELAMIN` varchar(1) DEFAULT NULL,
  `TGL_LAHIR` date DEFAULT NULL,
  `FOTO_PEG` varchar(255) DEFAULT NULL,
  `STATUS_LOGIN` char(1) NOT NULL,
  `LEVEL` char(1) DEFAULT NULL,
  `AKTIF` char(1) DEFAULT NULL,
  `COOKIE` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_pegawai`
--

INSERT INTO `tbl_pegawai` (`NIP`, `NAMA_PEG`, `PASSWORD`, `ALAMAT_PEG`, `EMAIL_PEG`, `TLP_PEG`, `TGL_MASUK`, `JENIS_KELAMIN`, `TGL_LAHIR`, `FOTO_PEG`, `STATUS_LOGIN`, `LEVEL`, `AKTIF`, `COOKIE`) VALUES
(1020, 'dian', '81dc9bdb52d04dc20036dbd8313ed055', 'jl diannnnn', 'dian@g.com', '877777777', '2018-11-07', 'p', '2018-10-28', '1020.jpg', '', '2', 'y', ''),
(7777, 'wulanmm', '81dc9bdb52d04dc20036dbd8313ed055', 'wulaa', 'wla@g.com', '0888', '0000-00-00', 'p', '2018-10-04', '7777.jpg', '', '2', 'n', ''),
(11111, 'RIRIN WULAN', '81dc9bdb52d04dc20036dbd8313ed055', 'jl kalimas hilir', 'ririnwulan@gmail.com', '08222222222', '2016-02-20', 'p', '2018-08-01', '11111.jpg', '', '1', 'y', ''),
(22222, 'rofiq', '81dc9bdb52d04dc20036dbd8313ed055', 'jl wonokusumo', 'rofiq@gmail.com', '028384744', '2017-11-25', 'l', '2018-10-23', '22222.jpg', '1', '2', 'y', 'ac'),
(33322, 'ggg', '81dc9bdb52d04dc20036dbd8313ed055', 'ssss', 'dss@ss', '55', '0000-00-00', 'l', '2018-10-23', '33322.jpg', '', '2', 'y', ''),
(33333, 'pujo', '81dc9bdb52d04dc20036dbd8313ed055', 'jl semampir', 'pujo@gmail.com', '095887566', '2016-06-25', 'l', '2018-08-01', '33333.jpg', '1', '3', 'y', 'qeNcasovS4XKCHtZRyd5nffGngPIlEFsWk73ZjoMLmhTSQBH9pJ6zu0L2h5iwatP'),
(44444, 'rio', '81dc9bdb52d04dc20036dbd8313ed055', 'dddddd', 'dddd@gmail.com', '86775654', '0000-00-00', 'l', '2018-08-08', '44444.jpg', '2', '4', 'y', ''),
(55555, 'adi', '81dc9bdb52d04dc20036dbd8313ed055', 'jl merdeka', 'adi@gmail.com', '028384744', '2016-10-25', 'l', '2018-08-08', '55555.jpg', '1', '2', 'y', 'ac'),
(88888, 'djodi', '81dc9bdb52d04dc20036dbd8313ed055', 'jl rungkut surabaya', 'djodi@gmail.com', '082233555', '2017-09-17', 'l', '2018-10-17', '88888.jpg', '', '2', 'y', ''),
(99999, 'dika', '81dc9bdb52d04dc20036dbd8313ed055', 'jalan jalan', 'aaa@g.com', '0000', '0000-00-00', 'l', '2018-10-23', '99999.jpg', '', '2', 'y', ''),
(445566, 'asdfghj', '81dc9bdb52d04dc20036dbd8313ed055', 'dddddd', 'aaaa@gmail.com', '028384744', '0000-00-00', 'l', '2018-11-12', '445566.jpg', '', '3', 'n', ''),
(12222222, 'h', '81dc9bdb52d04dc20036dbd8313ed055', 'jl diannnnn', 'wla@g.com', '0888', '2018-11-28', 'l', '2018-11-12', '12222222.jpg', '', '2', 'y', ''),
(123456789, 'rafif', '81dc9bdb52d04dc20036dbd8313ed055', 'aa', 'wla@g.com', '88', '2018-11-09', 'l', '2018-11-12', '123456789.jpg', '', '2', 'y', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_pengiriman`
--

CREATE TABLE `tbl_pengiriman` (
  `ID_PENGIRIMAN` int(11) NOT NULL,
  `KODE_PENGIRIMAN` varchar(100) NOT NULL,
  `NAMA_PENGIRIMAN` varchar(50) DEFAULT NULL,
  `JUMLAH_PENGIRIMAN` int(11) NOT NULL,
  `TGL_PENGIRIMAN` date NOT NULL,
  `TOKO_PENGIRIMAN` int(11) NOT NULL,
  `BP_PENGIRIMAN` int(11) NOT NULL,
  `STATUS_PENGIRIMAN` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_pengiriman`
--

INSERT INTO `tbl_pengiriman` (`ID_PENGIRIMAN`, `KODE_PENGIRIMAN`, `NAMA_PENGIRIMAN`, `JUMLAH_PENGIRIMAN`, `TGL_PENGIRIMAN`, `TOKO_PENGIRIMAN`, `BP_PENGIRIMAN`, `STATUS_PENGIRIMAN`) VALUES
(59, 'MSD-SBY-DO-2018-0001', 'LB', 3, '2018-11-09', 7, 1020, 2),
(90, 'MSD-SBY-DO-2018-0003', 'RA', 2, '2018-11-08', 7, 1020, 2),
(91, 'MSD-SBY-DO-2018-0004', 'CAL', 1, '2018-11-08', 7, 1020, 2),
(92, 'MSD-SBY-DO-2018-0002', 'DR', 3, '2018-11-08', 7, 1020, 2),
(151, 'MSD-SBY-DO-2018-0005', NULL, 0, '2018-11-16', 2, 88888, 2),
(152, 'MSD-SBY-DO-2018-0010', NULL, 0, '2018-11-16', 2, 22222, 2),
(153, 'MSD-SBY-DO-2018-0011', NULL, 0, '2018-11-16', 2, 22222, 2),
(154, 'MSD-SBY-DO-2018-0013', NULL, 0, '2018-11-16', 2, 1020, 2),
(155, 'MSD-SBY-DO-2018-0012', NULL, 0, '2018-11-16', 2, 22222, 2),
(156, 'MSD-SBY-DO-2018-0014', NULL, 0, '2018-11-16', 2, 22222, 2),
(158, 'MSD-SBY-DO-2018-0015', 'DR', 3, '2018-11-16', 2, 22222, 2),
(159, 'MSD-SBY-DO-2018-0016', 'CAL', 4, '2018-11-19', 2, 22222, 2),
(160, 'MSD-SBY-DO-2018-0017', 'GB', 5, '2018-11-19', 2, 22222, 2),
(161, 'MSD-SBY-DO-2018-0018', NULL, 0, '2018-11-19', 2, 22222, 2),
(162, 'MSD-SBY-DO-2018-0018', 'PIC', 4, '2018-11-19', 2, 22222, 2),
(163, 'MSD-SBY-DO-2018-0019', 'DR', 3, '2018-11-26', 7, 55555, 2),
(164, 'MSD-SBY-DO-2018-0019', 'LB', 4, '2018-11-26', 7, 55555, 2),
(165, 'MSD-SBY-DO-2018-0019', 'RA', 6, '2018-11-26', 7, 55555, 2),
(166, 'MSD-SBY-DO-2019-0020', NULL, 0, '2019-01-29', 1, 7777, 1),
(167, 'MSD-SBY-DO-2019-0021', NULL, 0, '2019-02-27', 1, 22222, 1),
(168, 'MSD-SBY-DO-2019-0021', 'PIC', 1, '2019-02-27', 1, 22222, 1),
(169, 'MSD-SBY-DO-2019-0022', NULL, 0, '2019-02-27', 7, 1020, 2),
(170, 'MSD-SBY-DO-2019-0022', 'PIC', 10, '2019-02-27', 7, 1020, 2),
(171, 'MSD-SBY-DO-2019-0023', NULL, 0, '2019-02-28', 7, 1020, 2),
(172, 'MSD-SBY-DO-2019-0023', 'OW', 20, '2019-02-27', 7, 1020, 2),
(173, 'MSD-SBY-DO-2019-0024', NULL, 0, '2019-02-28', 7, 1020, 2),
(174, 'MSD-SBY-DO-2019-0024', 'PIC', 10, '2019-02-27', 7, 1020, 2),
(175, 'MSD-SBY-DO-2019-0025', NULL, 0, '2019-02-28', 7, 1020, 2),
(176, 'MSD-SBY-DO-2019-0025', 'PIC', 10, '2019-02-27', 7, 1020, 2),
(177, 'MSD-SBY-DO-2019-0026', NULL, 0, '2019-02-28', 7, 1020, 2),
(178, 'MSD-SBY-DO-2019-0026', 'PIC', 10, '2019-02-27', 7, 1020, 2),
(179, 'MSD-SBY-DO-2019-0027', NULL, 0, '2019-02-28', 7, 1020, 2),
(180, 'MSD-SBY-DO-2019-0027', 'PIC', 10, '2019-02-27', 7, 1020, 2),
(181, 'MSD-SBY-DO-2019-0028', NULL, 0, '2019-02-28', 7, 1020, 2),
(182, 'MSD-SBY-DO-2019-0028', 'PIC', 12, '2019-02-27', 7, 1020, 2),
(183, 'MSD-SBY-DO-2019-0029', NULL, 0, '2019-02-27', 7, 1020, 2),
(184, 'MSD-SBY-DO-2019-0029', 'PIC', 10, '2019-02-27', 7, 1020, 2),
(185, 'MSD-SBY-DO-2019-0030', NULL, 0, '2019-02-26', 7, 1020, 2),
(186, 'MSD-SBY-DO-2019-0030', 'PIC', 10, '2019-02-27', 7, 1020, 2),
(187, 'MSD-SBY-DO-2019-0031', NULL, 0, '2019-02-26', 7, 1020, 2),
(188, 'MSD-SBY-DO-2019-0031', 'OW', 10, '2019-02-27', 7, 1020, 2),
(189, 'MSD-SBY-DO-2019-0032', NULL, 0, '2019-02-27', 7, 22222, 2),
(190, 'MSD-SBY-DO-2019-0032', 'PIC', 10, '2019-02-27', 7, 22222, 2),
(191, 'MSD-SBY-DO-2019-0033', NULL, 0, '2019-02-28', 1, 1020, 1),
(192, 'MSD-SBY-DO-2019-0033', 'CAL', 12, '2019-02-27', 1, 1020, 1),
(193, 'MSD-SBY-DO-2019-0034', NULL, 0, '2019-02-28', 7, 1020, 2),
(194, 'MSD-SBY-DO-2019-0034', 'PIC', 12, '2019-02-27', 7, 1020, 2),
(195, 'MSD-SBY-DO-2019-0035', NULL, 0, '2019-02-28', 7, 1020, 2),
(196, 'MSD-SBY-DO-2019-0035', 'PIC', 10, '2019-02-27', 7, 1020, 2),
(197, 'MSD-SBY-DO-2019-0036', NULL, 0, '2019-02-28', 7, 1020, 2),
(198, 'MSD-SBY-DO-2019-0036', 'PIC', 10, '2019-02-27', 7, 1020, 2),
(199, 'MSD-SBY-DO-2019-0037', NULL, 0, '2019-02-28', 7, 1020, 2),
(200, 'MSD-SBY-DO-2019-0037', 'RA', 10, '2019-02-27', 7, 1020, 2),
(201, 'MSD-SBY-DO-2019-0038', NULL, 0, '2019-02-28', 7, 1020, 2),
(202, 'MSD-SBY-DO-2019-0038', 'COR', 10, '2019-02-27', 7, 1020, 2),
(203, 'MSD-SBY-DO-2019-0039', NULL, 0, '2019-02-28', 7, 1020, 2),
(204, 'MSD-SBY-DO-2019-0039', 'PIC', 10, '2019-02-27', 7, 1020, 2),
(205, 'MSD-SBY-DO-2019-0040', NULL, 0, '2019-02-28', 7, 1020, 2),
(206, 'MSD-SBY-DO-2019-0040', 'PIC', 20, '2019-02-28', 7, 1020, 2),
(207, 'MSD-SBY-DO-2019-0041', NULL, 0, '2019-02-28', 7, 1020, 2),
(208, 'MSD-SBY-DO-2019-0041', 'PIC', 40, '2019-02-28', 7, 1020, 2),
(209, 'MSD-SBY-DO-2019-0042', 'PIC', 10, '2019-02-28', 7, 1020, 3),
(210, 'MSD-SBY-DO-2019-0043', 'PIC', 10, '2019-02-28', 7, 1020, 3),
(211, 'MSD-SBY-DO-2019-0044', 'PIC', 10, '2019-02-28', 7, 1020, 3),
(212, 'MSD-SBY-DO-2019-0045', NULL, 0, '2019-02-28', 7, 1020, 2),
(213, 'MSD-SBY-DO-2019-0045', 'PIC', 20, '2019-02-28', 7, 1020, 2),
(214, 'MSD-SBY-DO-2019-0046', 'PIC', 10, '2019-02-28', 7, 1020, 3),
(215, 'MSD-SBY-DO-2019-0047', 'PIC', 10, '2019-03-01', 7, 1020, 3),
(216, 'MSD-SBY-DO-2019-0048', NULL, 0, '2019-03-01', 7, 1020, 2),
(217, 'MSD-SBY-DO-2019-0049', 'PIC', 10, '2019-03-01', 7, 1020, 3),
(218, 'MSD-SBY-DO-2019-0050', NULL, 0, '2019-03-02', 7, 1020, 2),
(219, 'MSD-SBY-DO-2019-0050', 'PIC', 10, '2019-03-02', 7, 1020, 2),
(220, 'MSD-SBY-DO-2019-0051', NULL, 0, '2019-03-04', 7, 1020, 2),
(221, 'MSD-SBY-DO-2019-0051', 'PIC', 10, '2019-03-04', 7, 1020, 2),
(222, 'MSD-SBY-DO-2019-0052', 'PIC', 10, '2019-04-22', 7, 1020, 2),
(223, 'MSD-SBY-DO-2019-0053', NULL, 0, '2019-04-22', 7, 1020, 2),
(224, 'MSD-SBY-DO-2019-0053', 'PIC', 10, '2019-04-22', 7, 1020, 2),
(225, 'MSD-SBY-DO-2019-0053', 'COR', 10, '2019-04-22', 7, 1020, 2),
(226, 'MSD-SBY-DO-2019-0054', NULL, 0, '2019-04-22', 7, 1020, 2),
(227, 'MSD-SBY-DO-2019-0054', 'PIC', 10, '2019-04-22', 7, 1020, 2),
(228, 'MSD-SBY-DO-2019-0054', 'COR', 10, '2019-04-22', 7, 1020, 2),
(229, 'MSD-SBY-DO-2019-0055', NULL, 0, '2019-04-22', 7, 1020, 2),
(230, 'MSD-SBY-DO-2019-0055', 'COR', 10, '2019-04-22', 7, 1020, 2),
(231, 'MSD-SBY-DO-2019-0055', 'OW', 10, '2019-04-22', 7, 1020, 2),
(232, 'MSD-SBY-DO-2019-0056', 'PIC', 10, '2019-04-22', 7, 1020, 3),
(233, 'MSD-SBY-DO-2019-0056', 'COR', 10, '2019-04-22', 7, 1020, 3),
(234, 'MSD-SBY-DO-2019-0057', 'PIC', 10, '2019-04-22', 7, 1020, 3),
(235, 'MSD-SBY-DO-2019-0057', 'COR', 10, '2019-04-22', 7, 1020, 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_penjaga`
--

CREATE TABLE `tbl_penjaga` (
  `AI_JAGA` int(11) NOT NULL,
  `NIP_JAGA` int(11) NOT NULL,
  `ID_TOKO_JAGA` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_penjaga`
--

INSERT INTO `tbl_penjaga` (`AI_JAGA`, `NIP_JAGA`, `ID_TOKO_JAGA`) VALUES
(1, 22222, 2),
(2, 55555, 7),
(3, 1020, 7),
(4, 7777, 2),
(5, 88888, 7),
(6, 7777, 8),
(7, 123456789, 1),
(8, 11111, 1),
(9, 33322, 1),
(11, 12222222, 1),
(13, 445566, 1),
(14, 44444, 1),
(15, 33333, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_penjualan`
--

CREATE TABLE `tbl_penjualan` (
  `AI_PENJUALAN` int(11) NOT NULL,
  `NAMA_BARANG` varchar(50) NOT NULL,
  `JUMLAH_PENJUALAN` int(11) NOT NULL,
  `HARGA_NET` int(11) NOT NULL,
  `TGL_PENJUALAN` date NOT NULL,
  `TOTAL_PENJUALAN` int(11) NOT NULL,
  `TOKO_PENJUALAN` int(11) NOT NULL,
  `BP_PENJUALAN` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_permintaan`
--

CREATE TABLE `tbl_permintaan` (
  `ID_PERMINTAAN` int(1) NOT NULL,
  `KODE_PERMINTAAN` varchar(32) NOT NULL,
  `NAMA_PERMINTAAN` varchar(50) DEFAULT NULL,
  `JUMLAH_PERMINTAAN` int(11) NOT NULL,
  `TGL_PERMINTAAN` date NOT NULL,
  `TOKO_PERMINTAAN` int(11) NOT NULL,
  `BP_PERMINTAAN` int(11) NOT NULL,
  `STATUS_PERMINTAAN` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_permintaan`
--

INSERT INTO `tbl_permintaan` (`ID_PERMINTAAN`, `KODE_PERMINTAAN`, `NAMA_PERMINTAAN`, `JUMLAH_PERMINTAAN`, `TGL_PERMINTAAN`, `TOKO_PERMINTAAN`, `BP_PERMINTAAN`, `STATUS_PERMINTAAN`) VALUES
(1, 'NDG-SBY-REQ-2018-0001', 'PIC', 3, '2018-11-07', 2, 22222, 2),
(48, 'NDG-SBY-REQ-2018-0002', NULL, 0, '2018-11-14', 2, 22222, 2),
(49, 'NDG-SBY-REQ-2018-0002', 'CAL', 1, '2018-11-14', 2, 22222, 2),
(50, 'NDG-SBY-REQ-2018-0002', 'PIC', 4, '2018-11-14', 2, 22222, 2),
(51, 'NDG-SBY-REQ-2018-0003', NULL, 0, '2018-11-15', 2, 22222, 2),
(52, 'NDG-SBY-REQ-2018-0003', 'EI', 5, '2018-11-14', 2, 22222, 2),
(53, 'NDG-SBY-REQ-2018-0003', 'PIC', 3, '2018-11-14', 2, 22222, 2),
(54, 'NDG-SBY-REQ-2018-0004', NULL, 0, '2018-11-15', 2, 22222, 2),
(55, 'NDG-SBY-REQ-2018-0004', 'EI', 5, '2018-11-14', 2, 22222, 2),
(56, 'NDG-SBY-REQ-2018-0004', 'DR', 5, '2018-11-14', 2, 22222, 2),
(57, 'NDG-SBY-REQ-2018-0005', NULL, 0, '2018-11-15', 2, 22222, 2),
(58, 'NDG-SBY-REQ-2018-0005', 'DR', 3, '2018-11-14', 2, 22222, 2),
(59, 'NDG-SBY-REQ-2018-0009', 'MB', 6, '2018-11-14', 2, 22222, 2),
(63, 'NDG-SBY-REQ-2018-0010', NULL, 0, '2018-11-15', 2, 22222, 2),
(64, 'NDG-SBY-REQ-2018-0010', NULL, 0, '2018-11-14', 2, 22222, 2),
(65, 'NDG-SBY-REQ-2018-0011', NULL, 0, '2018-11-13', 2, 22222, 2),
(66, 'NDG-SBY-REQ-2018-0011', 'CAL', 1, '2018-11-16', 2, 22222, 1),
(68, 'NDG-SBY-REQ-2018-0012', NULL, 0, '2018-11-16', 2, 22222, 2),
(69, 'NDG-SBY-REQ-2018-0013', NULL, 0, '2018-11-16', 2, 22222, 2),
(70, 'NDG-SBY-REQ-2018-0013', 'CAL', 4, '2018-11-16', 2, 22222, 2),
(71, 'NDG-SBY-REQ-2018-0014', NULL, 0, '2018-11-19', 2, 22222, 2),
(72, 'NDG-SBY-REQ-2018-0014', 'GB', 5, '2018-11-19', 2, 22222, 2),
(73, 'NDG-SBY-REQ-2018-0015', NULL, 0, '2018-11-25', 2, 22222, 1),
(74, 'NDG-SBY-REQ-2018-0015', 'MW', 5, '2018-11-25', 2, 22222, 1),
(75, 'NDG-SBY-REQ-2018-0015', 'DR', 1, '2018-11-25', 2, 22222, 1),
(76, 'NDG-SBY-REQ-2018-0016', NULL, 0, '2018-11-25', 7, 55555, 2),
(77, 'NDG-SBY-REQ-2018-0016', 'DR', 3, '2018-11-25', 7, 55555, 2),
(78, 'NDG-SBY-REQ-2018-0016', 'LB', 4, '2018-11-25', 7, 55555, 2),
(79, 'NDG-SBY-REQ-2018-0016', 'RA', 6, '2018-11-25', 7, 55555, 2),
(80, 'NDG-SBY-REQ-2019-0017', NULL, 0, '2019-02-28', 7, 1020, 1),
(81, 'NDG-SBY-REQ-2019-0018', NULL, 0, '2019-02-28', 7, 1020, 2),
(82, 'NDG-SBY-REQ-2019-0018', 'PIC', 10, '2019-02-28', 7, 1020, 2),
(83, 'NDG-SBY-REQ-2019-0019', NULL, 0, '2019-02-28', 7, 1020, 2),
(84, 'NDG-SBY-REQ-2019-0019', 'PIC', 10, '2019-02-28', 7, 1020, 2),
(85, 'NDG-SBY-REQ-2019-0020', NULL, 0, '2019-02-28', 7, 1020, 2),
(86, 'NDG-SBY-REQ-2019-0020', 'PIC', 10, '2019-02-28', 7, 1020, 2),
(87, 'NDG-SBY-REQ-2019-0021', NULL, 0, '2019-03-01', 7, 1020, 2),
(88, 'NDG-SBY-REQ-2019-0021', 'PIC', 10, '2019-03-01', 7, 1020, 2),
(89, 'NDG-SBY-REQ-2019-0022', NULL, 0, '2019-03-01', 7, 1020, 2),
(90, 'NDG-SBY-REQ-2019-0022', 'PIC', 10, '2019-03-01', 7, 1020, 2),
(91, 'NDG-SBY-REQ-2019-0023', NULL, 0, '2019-03-07', 7, 1020, 1),
(92, 'NDG-SBY-REQ-2019-0024', NULL, 0, '2019-04-23', 7, 1020, 2),
(93, 'NDG-SBY-REQ-2019-0024', 'PIC', 10, '2019-04-22', 7, 1020, 2),
(94, 'NDG-SBY-REQ-2019-0025', NULL, 0, '2019-04-22', 7, 1020, 2),
(95, 'NDG-SBY-REQ-2019-0025', 'PIC', 10, '2019-04-22', 7, 1020, 2),
(96, 'NDG-SBY-REQ-2019-0025', 'COR', 10, '2019-04-22', 7, 1020, 2),
(97, 'NDG-SBY-REQ-2019-0026', NULL, 0, '2019-04-22', 7, 1020, 2),
(98, 'NDG-SBY-REQ-2019-0026', 'PIC', 10, '2019-04-22', 7, 1020, 2),
(99, 'NDG-SBY-REQ-2019-0026', 'COR', 10, '2019-04-22', 7, 1020, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_reture`
--

CREATE TABLE `tbl_reture` (
  `ID_RETURE` int(11) NOT NULL,
  `KODE_RETURE` varchar(255) NOT NULL,
  `NAMA_RETURE` varchar(50) DEFAULT NULL,
  `JUMLAH_RETURE` int(11) NOT NULL,
  `TGL_RETURE` date NOT NULL,
  `TOKO_RETURE` int(11) NOT NULL,
  `BP_RETURE` int(11) NOT NULL,
  `STATUS_RETURE` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_reture`
--

INSERT INTO `tbl_reture` (`ID_RETURE`, `KODE_RETURE`, `NAMA_RETURE`, `JUMLAH_RETURE`, `TGL_RETURE`, `TOKO_RETURE`, `BP_RETURE`, `STATUS_RETURE`) VALUES
(8, 'NDG-SBY-RET-2018-0002', 'GR', 1, '2018-11-16', 2, 22222, 1),
(46, 'NDG-SBY-RET-2018-0003', NULL, 0, '2018-11-16', 2, 22222, 1),
(47, 'NDG-SBY-RET-2018-0003', 'RA', 2, '2018-11-16', 2, 22222, 1),
(48, 'NDG-SBY-RET-2018-0004', NULL, 0, '2018-11-19', 2, 22222, 2),
(49, 'NDG-SBY-RET-2018-0004', 'GB', 7, '2018-11-19', 2, 22222, 2),
(50, 'NDG-SBY-RET-2018-0005', NULL, 0, '2018-11-19', 2, 22222, 2),
(51, 'NDG-SBY-RET-2018-0005', 'RA', 2, '2018-11-19', 2, 22222, 2),
(52, 'NDG-SBY-RET-2018-0006', 'GR', 2, '2018-11-19', 2, 22222, 1),
(54, 'NDG-SBY-RET-2018-0001', 'PIC', 2, '2018-11-19', 2, 22222, 1),
(56, 'NDG-SBY-RET-2018-0001', 'DR', 11, '2018-11-19', 2, 22222, 1),
(57, 'NDG-SBY-RET-2018-0010', NULL, 0, '2018-11-19', 2, 22222, 1),
(58, 'NDG-SBY-RET-2018-0010', 'GR', 1, '2018-11-19', 2, 22222, 1),
(59, 'NDG-SBY-RET-2019-0011', NULL, 0, '2019-02-28', 7, 1020, 1),
(60, 'NDG-SBY-RET-2019-0012', NULL, 0, '2019-02-28', 7, 1020, 2),
(61, 'NDG-SBY-RET-2019-0012', 'PIC', 10, '2019-02-28', 7, 1020, 2),
(62, 'NDG-SBY-RET-2019-0013', NULL, 0, '2019-02-28', 7, 1020, 2),
(63, 'NDG-SBY-RET-2019-0013', 'PIC', 10, '2019-02-28', 7, 1020, 2),
(64, 'NDG-SBY-RET-2019-0014', NULL, 0, '2019-02-28', 7, 1020, 2),
(65, 'NDG-SBY-RET-2019-0014', 'PIC', 10, '2019-02-28', 7, 1020, 2),
(66, 'NDG-SBY-RET-2019-0015', NULL, 0, '2019-03-02', 7, 1020, 2),
(67, 'NDG-SBY-RET-2019-0015', 'PIC', 10, '2019-03-02', 7, 1020, 2),
(68, 'NDG-SBY-RET-2019-0016', NULL, 0, '2019-03-04', 7, 1020, 2),
(69, 'NDG-SBY-RET-2019-0016', 'RA', 50, '2019-03-04', 7, 1020, 2),
(70, 'NDG-SBY-RET-2019-0017', NULL, 0, '2019-03-11', 7, 1020, 1),
(71, '1', 'DR', 1, '2019-03-11', 7, 1020, 1),
(72, 'NDG-SBY-RET-2019-0018', NULL, 0, '2019-03-22', 7, 1020, 1),
(73, 'NDG-SBY-RET-2019-0018', 'RA', 10, '2019-03-15', 7, 1020, 1),
(74, 'NDG-SBY-RET-2019-0018', 'LB', 1, '2019-03-15', 7, 1020, 1),
(75, 'NDG-SBY-RET-2019-0019', NULL, 0, '2019-03-16', 7, 1020, 1),
(76, 'NDG-SBY-RET-2019-0019', 'RA', 10, '2019-03-16', 7, 1020, 1),
(77, 'NDG-SBY-RET-2019-0019', 'LB', 3, '2019-03-16', 7, 1020, 1),
(78, 'NDG-SBY-RET-2019-0020', NULL, 0, '2019-03-16', 7, 1020, 1),
(79, 'NDG-SBY-RET-2019-0020', 'RA', 10, '2019-03-16', 7, 1020, 1),
(80, 'NDG-SBY-RET-2019-0020', 'DR', 1, '2019-03-16', 7, 1020, 1),
(81, '4', 'RA', 12, '2019-03-16', 7, 1020, 1),
(82, '7', 'RA', 9, '2019-03-16', 7, 1020, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_stok`
--

CREATE TABLE `tbl_stok` (
  `ID_STOK` int(11) NOT NULL,
  `JUMLAH` int(11) NOT NULL,
  `ID_BARANG` varchar(50) NOT NULL,
  `ID_STORE` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_stok`
--

INSERT INTO `tbl_stok` (`ID_STOK`, `JUMLAH`, `ID_BARANG`, `ID_STORE`) VALUES
(2, 7, 'RA', 2),
(120, 1, 'GB', 2),
(121, 3, 'LB', 2),
(122, 5, 'PIC', 2),
(123, 8, 'GR', 2),
(124, 2, 'MB', 2),
(125, 6, 'DR', 2),
(126, 4, 'CAL', 2),
(127, 1, 'DR', 7),
(128, 0, 'LB', 7),
(129, 10, 'RA', 7),
(130, 1, 'CAL', 7),
(132, 8, 'OW', 7),
(134, 20, 'COR', 7),
(135, 30, 'PIC', 7);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_toko`
--

CREATE TABLE `tbl_toko` (
  `ID_TOKO` int(20) NOT NULL,
  `NAMA_TOKO` varchar(50) DEFAULT NULL,
  `ALAMAT_TOKO` varchar(100) DEFAULT NULL,
  `TLP_TOKO` varchar(20) DEFAULT NULL,
  `KOTA_TOKO` varchar(255) DEFAULT NULL,
  `EMAIL_TOKO` varchar(255) DEFAULT NULL,
  `STATUS_TOKO` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_toko`
--

INSERT INTO `tbl_toko` (`ID_TOKO`, `NAMA_TOKO`, `ALAMAT_TOKO`, `TLP_TOKO`, `KOTA_TOKO`, `EMAIL_TOKO`, `STATUS_TOKO`) VALUES
(1, 'PT MULTIFORTUNA SINARDELTA', 'Jl tegalsari no 50', '087754433', 'surabaya', 'agagagag@gmail.com', '1'),
(2, 'Hokky BDB', 'Bukit Darmo Boulevard', '08122233345444', 'surabaya', 'Hokkybdb@.com', '1'),
(7, 'sogo', 'tunjungan', '0833333355', 'sidoarjo', 'hhhhg@.dh', '1'),
(8, 'metro', 'ciwo', '0089787', 'surabaya', 'metro@g.com', '1'),
(9, 'BEST DENKI PTC', 'jl Mayjen Yono Suyono, Babatan, wiyung, Surabaya', '0317391250', 'Surabaya ', 'PTC@gmail.com', '1');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tbl_berita`
--
ALTER TABLE `tbl_berita`
  ADD PRIMARY KEY (`ID_BERITA`);

--
-- Indeks untuk tabel `tbl_isi_laporan`
--
ALTER TABLE `tbl_isi_laporan`
  ADD PRIMARY KEY (`AI_ISI_LAPORAN`);

--
-- Indeks untuk tabel `tbl_item`
--
ALTER TABLE `tbl_item`
  ADD PRIMARY KEY (`ID_ITEM`),
  ADD KEY `AI_PRODUK` (`AI_PRODUK`);

--
-- Indeks untuk tabel `tbl_kategori`
--
ALTER TABLE `tbl_kategori`
  ADD PRIMARY KEY (`ID_KATEGORI`);

--
-- Indeks untuk tabel `tbl_laporan`
--
ALTER TABLE `tbl_laporan`
  ADD PRIMARY KEY (`AI_LAPORAN`);

--
-- Indeks untuk tabel `tbl_mutasi`
--
ALTER TABLE `tbl_mutasi`
  ADD PRIMARY KEY (`id_mutasi`);

--
-- Indeks untuk tabel `tbl_pegawai`
--
ALTER TABLE `tbl_pegawai`
  ADD PRIMARY KEY (`NIP`);

--
-- Indeks untuk tabel `tbl_pengiriman`
--
ALTER TABLE `tbl_pengiriman`
  ADD PRIMARY KEY (`ID_PENGIRIMAN`),
  ADD KEY `TOKO_PENGIRIMAN` (`TOKO_PENGIRIMAN`),
  ADD KEY `BP_PENGIRIMAN` (`BP_PENGIRIMAN`),
  ADD KEY `NAMA_PENGIRIMAN` (`NAMA_PENGIRIMAN`);

--
-- Indeks untuk tabel `tbl_penjaga`
--
ALTER TABLE `tbl_penjaga`
  ADD PRIMARY KEY (`AI_JAGA`),
  ADD KEY `NIP_JAGA` (`NIP_JAGA`),
  ADD KEY `ID_TOKO_JAGA` (`ID_TOKO_JAGA`);

--
-- Indeks untuk tabel `tbl_penjualan`
--
ALTER TABLE `tbl_penjualan`
  ADD PRIMARY KEY (`AI_PENJUALAN`),
  ADD KEY `NAMA_BARANG` (`NAMA_BARANG`),
  ADD KEY `TOKO_PENJUALAN` (`TOKO_PENJUALAN`),
  ADD KEY `BP_PENJUALAN` (`BP_PENJUALAN`);

--
-- Indeks untuk tabel `tbl_permintaan`
--
ALTER TABLE `tbl_permintaan`
  ADD PRIMARY KEY (`ID_PERMINTAAN`),
  ADD KEY `BP_PERMINTAAN` (`BP_PERMINTAAN`),
  ADD KEY `BP_PERMINTAAN_2` (`BP_PERMINTAAN`),
  ADD KEY `NAMA_PERMINTAAN` (`NAMA_PERMINTAAN`),
  ADD KEY `TOKO_PERMINTAAN` (`TOKO_PERMINTAAN`);

--
-- Indeks untuk tabel `tbl_reture`
--
ALTER TABLE `tbl_reture`
  ADD PRIMARY KEY (`ID_RETURE`),
  ADD KEY `NAMA_RETURE` (`NAMA_RETURE`),
  ADD KEY `TOKO_RETURE` (`TOKO_RETURE`),
  ADD KEY `BP_RETURE` (`BP_RETURE`);

--
-- Indeks untuk tabel `tbl_stok`
--
ALTER TABLE `tbl_stok`
  ADD PRIMARY KEY (`ID_STOK`),
  ADD KEY `ID_STORE` (`ID_STORE`),
  ADD KEY `ID_BARANG` (`ID_BARANG`);

--
-- Indeks untuk tabel `tbl_toko`
--
ALTER TABLE `tbl_toko`
  ADD PRIMARY KEY (`ID_TOKO`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tbl_berita`
--
ALTER TABLE `tbl_berita`
  MODIFY `ID_BERITA` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `tbl_isi_laporan`
--
ALTER TABLE `tbl_isi_laporan`
  MODIFY `AI_ISI_LAPORAN` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `tbl_laporan`
--
ALTER TABLE `tbl_laporan`
  MODIFY `AI_LAPORAN` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT untuk tabel `tbl_mutasi`
--
ALTER TABLE `tbl_mutasi`
  MODIFY `id_mutasi` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbl_pengiriman`
--
ALTER TABLE `tbl_pengiriman`
  MODIFY `ID_PENGIRIMAN` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=236;

--
-- AUTO_INCREMENT untuk tabel `tbl_penjaga`
--
ALTER TABLE `tbl_penjaga`
  MODIFY `AI_JAGA` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `tbl_penjualan`
--
ALTER TABLE `tbl_penjualan`
  MODIFY `AI_PENJUALAN` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbl_permintaan`
--
ALTER TABLE `tbl_permintaan`
  MODIFY `ID_PERMINTAAN` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT untuk tabel `tbl_reture`
--
ALTER TABLE `tbl_reture`
  MODIFY `ID_RETURE` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT untuk tabel `tbl_stok`
--
ALTER TABLE `tbl_stok`
  MODIFY `ID_STOK` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;

--
-- AUTO_INCREMENT untuk tabel `tbl_toko`
--
ALTER TABLE `tbl_toko`
  MODIFY `ID_TOKO` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tbl_item`
--
ALTER TABLE `tbl_item`
  ADD CONSTRAINT `tbl_item_ibfk_1` FOREIGN KEY (`AI_PRODUK`) REFERENCES `tbl_kategori` (`ID_KATEGORI`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tbl_pengiriman`
--
ALTER TABLE `tbl_pengiriman`
  ADD CONSTRAINT `tbl_pengiriman_ibfk_3` FOREIGN KEY (`BP_PENGIRIMAN`) REFERENCES `tbl_pegawai` (`NIP`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_pengiriman_ibfk_4` FOREIGN KEY (`NAMA_PENGIRIMAN`) REFERENCES `tbl_item` (`ID_ITEM`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_pengiriman_ibfk_5` FOREIGN KEY (`TOKO_PENGIRIMAN`) REFERENCES `tbl_toko` (`ID_TOKO`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tbl_penjaga`
--
ALTER TABLE `tbl_penjaga`
  ADD CONSTRAINT `tbl_penjaga_ibfk_1` FOREIGN KEY (`NIP_JAGA`) REFERENCES `tbl_pegawai` (`NIP`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_penjaga_ibfk_2` FOREIGN KEY (`ID_TOKO_JAGA`) REFERENCES `tbl_toko` (`ID_TOKO`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tbl_penjualan`
--
ALTER TABLE `tbl_penjualan`
  ADD CONSTRAINT `tbl_penjualan_ibfk_3` FOREIGN KEY (`BP_PENJUALAN`) REFERENCES `tbl_pegawai` (`NIP`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_penjualan_ibfk_4` FOREIGN KEY (`NAMA_BARANG`) REFERENCES `tbl_item` (`ID_ITEM`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_penjualan_ibfk_5` FOREIGN KEY (`TOKO_PENJUALAN`) REFERENCES `tbl_toko` (`ID_TOKO`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tbl_permintaan`
--
ALTER TABLE `tbl_permintaan`
  ADD CONSTRAINT `tbl_permintaan_ibfk_2` FOREIGN KEY (`BP_PERMINTAAN`) REFERENCES `tbl_pegawai` (`NIP`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_permintaan_ibfk_4` FOREIGN KEY (`NAMA_PERMINTAAN`) REFERENCES `tbl_item` (`ID_ITEM`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_permintaan_ibfk_5` FOREIGN KEY (`TOKO_PERMINTAAN`) REFERENCES `tbl_toko` (`ID_TOKO`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tbl_reture`
--
ALTER TABLE `tbl_reture`
  ADD CONSTRAINT `tbl_reture_ibfk_3` FOREIGN KEY (`BP_RETURE`) REFERENCES `tbl_pegawai` (`NIP`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_reture_ibfk_4` FOREIGN KEY (`NAMA_RETURE`) REFERENCES `tbl_item` (`ID_ITEM`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_reture_ibfk_5` FOREIGN KEY (`TOKO_RETURE`) REFERENCES `tbl_toko` (`ID_TOKO`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tbl_stok`
--
ALTER TABLE `tbl_stok`
  ADD CONSTRAINT `tbl_stok_ibfk_1` FOREIGN KEY (`ID_STORE`) REFERENCES `tbl_toko` (`ID_TOKO`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_stok_ibfk_2` FOREIGN KEY (`ID_BARANG`) REFERENCES `tbl_item` (`ID_ITEM`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
