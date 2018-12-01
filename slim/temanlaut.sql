-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 18, 2018 at 12:06 PM
-- Server version: 10.1.29-MariaDB
-- PHP Version: 7.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `temanlaut`
--

-- --------------------------------------------------------

--
-- Table structure for table `dermaga`
--

CREATE TABLE `dermaga` (
  `id_dermaga` int(11) NOT NULL,
  `nama` varchar(2048) NOT NULL,
  `lat` float NOT NULL,
  `lon` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dermaga`
--

INSERT INTO `dermaga` (`id_dermaga`, `nama`, `lat`, `lon`) VALUES
(1, 'asda', 12, 12);

-- --------------------------------------------------------

--
-- Table structure for table `laporan`
--

CREATE TABLE `laporan` (
  `id_laporan` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `lat` float NOT NULL,
  `lon` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pasang_surut`
--

CREATE TABLE `pasang_surut` (
  `id` int(11) NOT NULL,
  `nilai` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pdpi`
--

CREATE TABLE `pdpi` (
  `id_pdpi` int(11) NOT NULL,
  `bd` float NOT NULL,
  `bm` float NOT NULL,
  `bs` float NOT NULL,
  `ld` float NOT NULL,
  `lm` float NOT NULL,
  `ls` float NOT NULL,
  `tanggal_perkiraan` date NOT NULL,
  `id_pulau` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pulau`
--

CREATE TABLE `pulau` (
  `nama` varchar(2048) NOT NULL,
  `id_pulau` int(11) NOT NULL,
  `tanggal_perkiraan` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dermaga`
--
ALTER TABLE `dermaga`
  ADD PRIMARY KEY (`id_dermaga`);

--
-- Indexes for table `laporan`
--
ALTER TABLE `laporan`
  ADD PRIMARY KEY (`id_laporan`);

--
-- Indexes for table `pasang_surut`
--
ALTER TABLE `pasang_surut`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pdpi`
--
ALTER TABLE `pdpi`
  ADD PRIMARY KEY (`id_pdpi`);

--
-- Indexes for table `pulau`
--
ALTER TABLE `pulau`
  ADD PRIMARY KEY (`id_pulau`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dermaga`
--
ALTER TABLE `dermaga`
  MODIFY `id_dermaga` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `laporan`
--
ALTER TABLE `laporan`
  MODIFY `id_laporan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pasang_surut`
--
ALTER TABLE `pasang_surut`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pdpi`
--
ALTER TABLE `pdpi`
  MODIFY `id_pdpi` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pulau`
--
ALTER TABLE `pulau`
  MODIFY `id_pulau` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
