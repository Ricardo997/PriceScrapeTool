-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 09, 2018 at 12:22 PM
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
-- Database: `scrapeprices`
--
CREATE DATABASE IF NOT EXISTS scrapeprices;
USE scrapeprices;
-- --------------------------------------------------------

--
-- Table structure for table `carphone`
--

CREATE TABLE `carphone` (
  `idCarphone` int(9) NOT NULL,
  `carphoneName` varchar(80) DEFAULT NULL,
  `carphonePrice` float(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Table structure for table `magpie`
--

CREATE TABLE `magpie` (
  `idMagpie` int(9) NOT NULL,
  `magpieName` varchar(80) DEFAULT NULL,
  `magpiePrice` float(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Table structure for table `mazuma`
--

CREATE TABLE `mazuma` (
  `idMazuma` int(9) NOT NULL,
  `mazumaName` varchar(80) DEFAULT NULL,
  `mazumaPrice` float(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- --------------------------------------------------------

--
-- Table structure for table `mpx`
--

CREATE TABLE `mpx` (
  `idMpx` int(9) NOT NULL,
  `mpxName` varchar(80) DEFAULT NULL,
  `mpxPrice` float(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- --------------------------------------------------------

--
-- Table structure for table `recyclee`
--

CREATE TABLE `recyclee` (
  `idRecycle` int(9) NOT NULL,
  `recycleName` varchar(80) DEFAULT NULL,
  `recyclePrice` float(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- --------------------------------------------------------

--
-- Table structure for table `redeem`
--

CREATE TABLE `redeem` (
  `id` int(9) NOT NULL,
  `model` varchar(80) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `redeem`
--

INSERT INTO `redeem` (`id`, `model`) VALUES
(1, 'Apple iPhone 5S 16GB'),
(2, 'Apple iPhone 5S 32GB'),
(3, 'Apple iPhone 5S 64GB'),
(4, 'Apple iPhone 6 128GB'),
(5, 'Apple iPhone 6 16GB'),
(6, 'Apple iPhone 6 32GB'),
(7, 'Apple iPhone 6 64GB'),
(8, 'Apple iPhone 6 Plus 128GB'),
(9, 'Apple iPhone 6 Plus 16GB'),
(10, 'Apple iPhone 6 Plus 64GB'),
(11, 'Apple iPhone 6S 128GB'),
(12, 'Apple iPhone 6S 16GB'),
(13, 'Apple iPhone 6S 32GB'),
(14, 'Apple iPhone 6S 64GB'),
(15, 'Apple iPhone 6S Plus 128GB'),
(16, 'Apple iPhone 6S Plus 16GB'),
(17, 'Apple iPhone 6S Plus 32GB'),
(18, 'Apple iPhone 6S Plus 64GB'),
(19, 'Apple iPhone 7 128GB'),
(20, 'Apple iPhone 7 256GB'),
(21, 'Apple iPhone 7 32GB'),
(22, 'Apple iPhone 7 Plus 128GB'),
(23, 'Apple iPhone 7 Plus 256GB'),
(24, 'Apple iPhone 7 Plus 32GB'),
(25, 'Apple iPhone 8 256GB'),
(26, 'Apple iPhone 8 64GB'),
(27, 'Apple iPhone 8 Plus 256GB'),
(28, 'Apple iPhone 8 Plus 64GB'),
(29, 'Apple iPhone SE 128GB'),
(30, 'Apple iPhone SE 16GB'),
(31, 'Apple iPhone SE 32GB'),
(32, 'Apple iPhone SE 64GB'),
(33, 'Apple iPhone X 256GB'),
(34, 'Apple iPhone X 64GB'),
(35, 'Samsung Galaxy A3'),
(36, 'Samsung Galaxy A3 (2016)'),
(37, 'Samsung Galaxy J3 (2016)'),
(38, 'Samsung Galaxy J5'),
(39, 'Samsung Galaxy Note 4'),
(40, 'Samsung Galaxy S5'),
(41, 'Samsung Galaxy S6 Edge'),
(42, 'Samsung Galaxy S6 Edge 64GB'),
(43, 'Samsung Galaxy S6 Edge Plus'),
(44, 'Samsung Galaxy S6 G920'),
(45, 'Samsung Galaxy S7 Edge 32GB'),
(46, 'Samsung Galaxy S7 32GB'),
(47, 'Samsung Galaxy S8'),
(48, 'Samsung Galaxy S8 Plus'),
(49, 'Sony Xperia Z5'),
(50, 'Sony Xperia Z5 Compact');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(9) NOT NULL,
  `firstName` varchar(80) NOT NULL,
  `lastName` varchar(80) NOT NULL,
  `mail` varchar(80) NOT NULL,
  `password` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `firstName`, `lastName`, `mail`, `password`) VALUES
(null, 'Admin', 'Admin', 'admin@test.com', '$2y$10$TpwCIaiU8OM/HNHmTRrVU.EtBYf6oLbKT7fNOaAPh3r38eardbYNe');

-- --------------------------------------------------------

--
-- Table structure for table `vodafone`
--

CREATE TABLE `vodafone` (
  `idVodafone` int(9) NOT NULL,
  `vodafoneName` varchar(80) DEFAULT NULL,
  `vodafonePrice` float(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Indexes for dumped tables
--

--
-- Indexes for table `carphone`
--
ALTER TABLE `carphone`
  ADD KEY `idCarphone` (`idCarphone`);

--
-- Indexes for table `magpie`
--
ALTER TABLE `magpie`
  ADD KEY `idMagpie` (`idMagpie`);

--
-- Indexes for table `mazuma`
--
ALTER TABLE `mazuma`
  ADD KEY `idMazuma` (`idMazuma`);

--
-- Indexes for table `mpx`
--
ALTER TABLE `mpx`
  ADD KEY `idMpx` (`idMpx`);

--
-- Indexes for table `recyclee`
--
ALTER TABLE `recyclee`
  ADD KEY `idRecycle` (`idRecycle`);

--
-- Indexes for table `redeem`
--
ALTER TABLE `redeem`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `vodafone`
--
ALTER TABLE `vodafone`
  ADD KEY `idVodafone` (`idVodafone`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `redeem`
--
ALTER TABLE `redeem`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carphone`
--
ALTER TABLE `carphone`
  ADD CONSTRAINT `carphone_ibfk_1` FOREIGN KEY (`idCarphone`) REFERENCES `redeem` (`id`);

--
-- Constraints for table `magpie`
--
ALTER TABLE `magpie`
  ADD CONSTRAINT `magpie_ibfk_1` FOREIGN KEY (`idMagpie`) REFERENCES `redeem` (`id`);

--
-- Constraints for table `mazuma`
--
ALTER TABLE `mazuma`
  ADD CONSTRAINT `mazuma_ibfk_1` FOREIGN KEY (`idMazuma`) REFERENCES `redeem` (`id`);

--
-- Constraints for table `mpx`
--
ALTER TABLE `mpx`
  ADD CONSTRAINT `mpx_ibfk_1` FOREIGN KEY (`idMpx`) REFERENCES `redeem` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `recyclee`
--
ALTER TABLE `recyclee`
  ADD CONSTRAINT `recyclee_ibfk_1` FOREIGN KEY (`idRecycle`) REFERENCES `redeem` (`id`);

--
-- Constraints for table `vodafone`
--
ALTER TABLE `vodafone`
  ADD CONSTRAINT `vodafone_ibfk_1` FOREIGN KEY (`idVodafone`) REFERENCES `redeem` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
