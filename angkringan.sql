-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Generation Time: Jan 17, 2022 at 01:41 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `angkringan`
--

-- --------------------------------------------------------

--
-- Table structure for table `brg`
--

CREATE TABLE `brg` (
  `idx` int(11) NOT NULL,
  `nama_barang` varchar(400) NOT NULL,
  `harga` double NOT NULL,
  `stok` int(11) NOT NULL,
  `foto` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `brg`
--

INSERT INTO `brg` (`idx`, `nama_barang`, `harga`, `stok`, `foto`) VALUES
(3, 'Paket Sate Satean Sate Satean 2 + Bakso Ikan 2', 15000, 30, 'paketsatesatean.jpeg'),
(4, 'Paket Makan Nasi Kucing + Sate Satean + Teh Obenk + Tahu', 15000, 20, 'paketmakan.jpeg'),
(5, 'Paket Sate + Minum Sate Satean 3 + Teh Obenk', 16000, 18, 'paketsateminum.jpeg'),
(6, 'Sate Telur Puyuh', 4000, 20, 'satetelorpuyuh.jpeg'),
(7, 'Bakso Ikan Kuning', 4000, 20, 'baksoikankuning.jpeg'),
(8, 'Ceker', 4000, 20, 'ceker.jpeg'),
(9, 'Sosis', 3000, 20, 'sosis.jpeg'),
(10, 'Sate Hati dan Ampela', 4000, 20, 'satehatidanampela.jpeg'),
(11, 'Bakso Ikan Putih', 4000, 20, 'baksoikanputih.jpeg'),
(12, 'Bakso', 4000, 20, 'bakso.jpeg'),
(13, 'Sate Babat', 4000, 20, 'satebabat.jpeg'),
(14, 'Teh Obenk', 6000, 20, 'tehobeng.jpg'),
(15, 'Sanford', 5000, 20, 'sanford.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `brgkeluar`
--

CREATE TABLE `brgkeluar` (
  `id` int(11) NOT NULL,
  `idx` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jumlah` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `brgkeluar`
--

INSERT INTO `brgkeluar` (`id`, `idx`, `tanggal`, `jumlah`) VALUES
(3, 2, '2022-01-17', 26),
(5, 3, '2022-01-17', 5),
(6, 3, '2022-01-17', 5),
(7, 5, '2022-01-17', 2);

-- --------------------------------------------------------

--
-- Table structure for table `brgmasuk`
--

CREATE TABLE `brgmasuk` (
  `id` int(11) NOT NULL,
  `idx` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jumlah` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `brgmasuk`
--

INSERT INTO `brgmasuk` (`id`, `idx`, `tanggal`, `jumlah`) VALUES
(16, 1, '2022-01-17', 50),
(17, 2, '2022-01-17', 124),
(18, 3, '2022-01-17', 30);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` varchar(1020) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(4, 'ricky', '$2y$10$GQzX2KHBawUc/yjeAVHf9.oc9D3f5s/ap8DBbUSbYIAtVQm9kKFmS'),
(5, 'riki', '$2y$10$YNP665MI9cqhoo1fdGiYjervsmm.TKAj8hf8xGm3ALwtNDE73Ds8O');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brg`
--
ALTER TABLE `brg`
  ADD PRIMARY KEY (`idx`);

--
-- Indexes for table `brgkeluar`
--
ALTER TABLE `brgkeluar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brgmasuk`
--
ALTER TABLE `brgmasuk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brg`
--
ALTER TABLE `brg`
  MODIFY `idx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `brgkeluar`
--
ALTER TABLE `brgkeluar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `brgmasuk`
--
ALTER TABLE `brgmasuk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
