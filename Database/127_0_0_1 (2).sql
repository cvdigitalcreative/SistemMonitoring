-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 11, 2018 at 04:15 PM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 5.6.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sistemmonitoring`
--
CREATE DATABASE IF NOT EXISTS `sistemmonitoring` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `sistemmonitoring`;

-- --------------------------------------------------------

--
-- Table structure for table `laporan`
--

CREATE TABLE `laporan` (
  `id_laporan` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `upload_path` varchar(250) NOT NULL,
  `laporan_path` varchar(250) NOT NULL,
  `absen_path` varchar(250) NOT NULL,
  `photo_path` varchar(250) NOT NULL,
  `photo_2_path` varchar(250) NOT NULL,
  `date_range` varchar(250) NOT NULL,
  `judullaporan` varchar(250) NOT NULL,
  `qr_code_path` varchar(250) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `username` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `laporan`
--

INSERT INTO `laporan` (`id_laporan`, `id_user`, `upload_path`, `laporan_path`, `absen_path`, `photo_path`, `photo_2_path`, `date_range`, `judullaporan`, `qr_code_path`, `status`, `username`) VALUES
(17, 1, 'gambar/user', 'Asian_Games_-_Tiket_jadwal1.pdf', 'photo_2018-06-27_16-39-16.jpg', 'photo_2018-06-27_16-39-24.jpg', 'photo_2018-06-27_16-24-17.jpg', '2018-07-11 - 2018-08-11', 'agung ganteng', '1.png', 0, 'user');

-- --------------------------------------------------------

--
-- Table structure for table `peserta`
--

CREATE TABLE `peserta` (
  `id` int(11) NOT NULL,
  `nama` varchar(250) NOT NULL,
  `tanggal_lahir` varchar(250) NOT NULL,
  `tempat_tinggal` varchar(250) NOT NULL,
  `tamatan` varchar(250) NOT NULL,
  `waktu_dimulai` varchar(250) NOT NULL,
  `waktu_berakhir` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `peserta`
--

INSERT INTO `peserta` (`id`, `nama`, `tanggal_lahir`, `tempat_tinggal`, `tamatan`, `waktu_dimulai`, `waktu_berakhir`) VALUES
(5, 'agung', '2018-07-25', 'palembang', 'polrsri', '2018-07-19', '2018-07-26');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `role` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `role`) VALUES
(1, 'user', 'ee11cbb19052e40b07aac0ca060c23ee', 1),
(2, 'admindispora', '21232f297a57a5a743894a0e4a801fc3', 2),
(3, 'adminkeuangan', '21232f297a57a5a743894a0e4a801fc3', 3),
(4, 'kepalakantor', '21232f297a57a5a743894a0e4a801fc3', 4),
(5, 'agung', 'e59cd3ce33a68f536c19fedb82a7936f', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `laporan`
--
ALTER TABLE `laporan`
  ADD PRIMARY KEY (`id_laporan`);

--
-- Indexes for table `peserta`
--
ALTER TABLE `peserta`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `laporan`
--
ALTER TABLE `laporan`
  MODIFY `id_laporan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
