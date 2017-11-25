-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 24 Nov 2017 pada 23.45
-- Versi Server: 10.1.26-MariaDB
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventaris`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_barang`
--

CREATE TABLE `tb_barang` (
  `id` int(11) NOT NULL,
  `kodeb` varchar(50) NOT NULL,
  `namab` varchar(50) NOT NULL,
  `jenisb` varchar(50) NOT NULL,
  `keadaanb` varchar(15) NOT NULL,
  `statusb` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_barang`
--

INSERT INTO `tb_barang` (`id`, `kodeb`, `namab`, `jenisb`, `keadaanb`, `statusb`) VALUES
(1, '1', 'qwe', 'Berkas', 'Sangat Baik', 'Ada'),
(2, '2', 'iop', 'Berkas', 'Cukup', 'Ada'),
(3, '3', 'ert', 'Alat Tulis', 'Baik', 'Ada');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_kembali`
--

CREATE TABLE `tb_kembali` (
  `id` int(11) NOT NULL,
  `kodekembali` varchar(50) NOT NULL,
  `kodepinjam` varchar(50) NOT NULL,
  `tglkembali` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_kembali`
--

INSERT INTO `tb_kembali` (`id`, `kodekembali`, `kodepinjam`, `tglkembali`) VALUES
(1, '1', '1', '2017-11-25');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_peminjaman`
--

CREATE TABLE `tb_peminjaman` (
  `id` int(11) NOT NULL,
  `kodepinjam` varchar(50) NOT NULL,
  `kodebarangpinjam` varchar(50) NOT NULL,
  `namauserpinjam` varchar(50) NOT NULL,
  `tglpinjam` date NOT NULL,
  `tglkembali` date NOT NULL,
  `konfirmasi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_peminjaman`
--

INSERT INTO `tb_peminjaman` (`id`, `kodepinjam`, `kodebarangpinjam`, `namauserpinjam`, `tglpinjam`, `tglkembali`, `konfirmasi`) VALUES
(1, '1', '1', 'user', '2017-11-24', '2017-11-25', 1),
(2, '2', '2', 'iop', '2017-11-24', '2017-11-25', 0),
(3, '3', '1', 'iop', '2017-11-24', '2017-11-25', 0),
(4, '4', '1', 'iop', '2017-11-24', '2017-11-25', 0),
(5, '5', '3', 'iop', '2017-11-24', '2017-11-25', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_user`
--

CREATE TABLE `tb_user` (
  `id` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL,
  `nim` varchar(11) NOT NULL,
  `notelp` varchar(15) NOT NULL,
  `hakakses` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_user`
--

INSERT INTO `tb_user` (`id`, `firstname`, `lastname`, `username`, `password`, `nim`, `notelp`, `hakakses`) VALUES
(1, 'Kresna', 'Yulianta', 'admin', '21232f297a57a5a743894a0e4a801fc3', '15050974030', '085749066789', 'Administrator'),
(2, 'iop', 'iop', 'iop', '9fbfb220e03aa76d424088e43314b0d0', 'iop', 'iop', 'Peminjam'),
(3, 'Abhimata', 'Pramudita', 'kahima', 'ac34bc00bd05fed0b4091779b664fbb6', '15', '12', 'Kahima'),
(4, 'Rizky', 'Rizaldy', 'admin2', 'c84258e9c39059a89ab77d846ddab909', '15050974022', '085', 'Administrator'),
(5, 'agustin', 'fatimah', 'user', 'ee11cbb19052e40b07aac0ca060c23ee', '15050974012', '085', 'Peminjam');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_barang`
--
ALTER TABLE `tb_barang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_kembali`
--
ALTER TABLE `tb_kembali`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_peminjaman`
--
ALTER TABLE `tb_peminjaman`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_barang`
--
ALTER TABLE `tb_barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_kembali`
--
ALTER TABLE `tb_kembali`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_peminjaman`
--
ALTER TABLE `tb_peminjaman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
