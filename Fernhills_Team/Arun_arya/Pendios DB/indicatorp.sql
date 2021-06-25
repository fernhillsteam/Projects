-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 17, 2021 at 12:31 PM
-- Server version: 10.4.19-MariaDB-cll-lve
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u949021360_Pendios`
--

-- --------------------------------------------------------

--
-- Table structure for table `indicator`
--

CREATE TABLE `indicator` (
  `Sl_no` int(10) NOT NULL,
  `Short_circuit` int(10) NOT NULL,
  `Shutdown` int(10) NOT NULL,
  `Overload` int(10) NOT NULL,
  `Tampering` int(10) NOT NULL,
  `Health` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `indicator`
--

INSERT INTO `indicator` (`Sl_no`, `Short_circuit`, `Shutdown`, `Overload`, `Tampering`, `Health`) VALUES
(1, 1, 0, 0, 0, 0),
(2, 1, 0, 0, 1, 0),
(3, 0, 0, 0, 0, 0),
(4, 0, 1, 0, 1, 0),
(5, 0, 0, 1, 1, 1),
(6, 1, 0, 0, 0, 0),
(7, 1, 0, 0, 0, 0),
(8, 0, 0, 1, 1, 0),
(9, 0, 0, 1, 1, 0),
(10, 1, 1, 0, 0, 0),
(11, 1, 0, 1, 0, 1),
(12, 0, 0, 0, 0, 0),
(13, 0, 0, 0, 0, 0),
(14, 0, 0, 0, 0, 0),
(15, 1, 0, 0, 0, 0),
(16, 1, 0, 0, 0, 1),
(17, 1, 0, 0, 0, 1),
(18, 0, 0, 1, 0, 1),
(19, 1, 0, 0, 0, 1),
(20, 0, 0, 1, 0, 1),
(21, 1, 0, 0, 0, 1),
(22, 0, 0, 0, 0, 0),
(23, 1, 0, 0, 0, 1),
(24, 1, 0, 0, 0, 1),
(25, 0, 0, 1, 0, 1),
(26, 1, 0, 0, 0, 1),
(27, 0, 0, 1, 0, 1),
(28, 1, 0, 0, 0, 1),
(29, 0, 0, 0, 0, 0),
(30, 1, 0, 0, 0, 1),
(31, 0, 0, 0, 0, 0),
(32, 0, 0, 1, 0, 1),
(33, 0, 0, 0, 0, 0),
(34, 0, 0, 1, 0, 1),
(35, 0, 0, 1, 0, 1),
(36, 0, 0, 0, 0, 0),
(37, 0, 0, 0, 0, 0),
(38, 0, 0, 0, 0, 0),
(39, 0, 0, 0, 0, 0),
(40, 0, 0, 0, 0, 0),
(41, 0, 0, 0, 0, 0),
(42, 0, 0, 0, 0, 0),
(43, 1, 0, 0, 0, 1),
(44, 0, 0, 0, 0, 0),
(45, 0, 0, 0, 0, 0),
(46, 0, 0, 1, 0, 1),
(47, 0, 0, 1, 0, 1),
(48, 0, 0, 0, 0, 0),
(49, 1, 0, 0, 0, 1),
(50, 1, 0, 0, 0, 1),
(51, 0, 0, 1, 0, 1),
(52, 0, 0, 0, 0, 0),
(53, 0, 0, 0, 0, 0),
(54, 0, 0, 1, 0, 1),
(55, 0, 0, 1, 0, 1),
(56, 0, 0, 0, 0, 0),
(57, 1, 0, 0, 0, 1),
(58, 1, 0, 0, 0, 1),
(59, 1, 0, 0, 0, 1),
(60, 1, 0, 0, 0, 1),
(61, 1, 0, 0, 0, 1),
(62, 1, 0, 0, 1, 1),
(63, 0, 1, 1, 0, 1),
(64, 0, 0, 0, 0, 1),
(65, 0, 0, 0, 0, 0),
(66, 1, 0, 0, 0, 0),
(67, 1, 0, 0, 0, 1),
(68, 0, 0, 0, 0, 1),
(69, 0, 0, 0, 0, 0),
(70, 1, 0, 0, 0, 0),
(71, 1, 0, 0, 0, 0),
(72, 1, 0, 0, 0, 1),
(73, 0, 0, 0, 0, 0),
(74, 0, 1, 0, 0, 0),
(75, 0, 1, 0, 0, 0),
(76, 0, 1, 0, 0, 0),
(77, 0, 1, 0, 0, 0),
(78, 0, 1, 0, 0, 1),
(79, 0, 1, 0, 0, 0),
(80, 0, 1, 0, 0, 1),
(81, 0, 0, 0, 0, 1),
(82, 0, 0, 0, 0, 1),
(83, 0, 0, 0, 0, 1),
(84, 0, 0, 0, 0, 1),
(85, 0, 0, 0, 0, 1),
(86, 0, 0, 0, 0, 1),
(87, 0, 0, 0, 0, 0),
(88, 0, 0, 0, 0, 0),
(89, 1, 0, 0, 0, 0),
(90, 1, 0, 0, 0, 0),
(91, 1, 0, 0, 0, 0),
(92, 1, 0, 0, 0, 0),
(93, 0, 0, 0, 0, 0),
(94, 0, 0, 0, 0, 0),
(95, 0, 0, 0, 0, 0),
(96, 0, 0, 0, 0, 0),
(97, 0, 0, 0, 0, 0),
(98, 0, 0, 0, 0, 0),
(99, 0, 1, 0, 0, 0),
(100, 0, 1, 0, 0, 0),
(101, 0, 1, 0, 0, 0),
(102, 0, 0, 0, 0, 0),
(103, 0, 0, 0, 0, 0),
(104, 0, 0, 0, 0, 0),
(105, 1, 0, 0, 0, 0),
(106, 1, 0, 0, 0, 0),
(107, 1, 0, 0, 0, 0),
(108, 1, 0, 0, 0, 0),
(109, 1, 0, 0, 0, 0),
(110, 0, 0, 0, 0, 0),
(111, 0, 0, 0, 0, 0),
(112, 1, 0, 0, 0, 0),
(113, 0, 0, 0, 0, 0),
(114, 0, 0, 0, 0, 0),
(115, 1, 0, 0, 0, 0),
(116, 1, 0, 0, 0, 0),
(117, 0, 0, 0, 0, 0),
(118, 0, 0, 0, 0, 0),
(119, 1, 0, 0, 0, 0),
(120, 1, 1, 1, 0, 0),
(121, 1, 1, 1, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `indicator`
--
ALTER TABLE `indicator`
  ADD PRIMARY KEY (`Sl_no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `indicator`
--
ALTER TABLE `indicator`
  MODIFY `Sl_no` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
