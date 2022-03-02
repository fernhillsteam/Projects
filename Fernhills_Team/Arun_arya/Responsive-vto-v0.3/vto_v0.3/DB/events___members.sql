-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 03, 2022 at 04:17 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `events & members`
--

-- --------------------------------------------------------

--
-- Table structure for table `events1`
--

CREATE TABLE `events1` (
  `id` int(11) NOT NULL,
  `title` varchar(225) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(225) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `start_date` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `end_date` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created` date NOT NULL DEFAULT current_timestamp(),
  `stime` varchar(225) NOT NULL,
  `etime` time NOT NULL,
  `efee` varchar(225) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=Active, 0=Block'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `events1`
--

INSERT INTO `events1` (`id`, `title`, `description`, `start_date`, `end_date`, `created`, `stime`, `etime`, `efee`, `status`) VALUES
(4, 'vto', '', '2021-12-05 10:00:00', '2021-12-05 08:00:00', '2021-12-05', '', '00:00:00', '', 0),
(9, 'check', 'ok', '2021-12-17', '17-12-2021', '0000-00-00', '', '00:00:00', '', 1),
(10, 'vto12', '2021-12-15', '12:29', 'bangalore', '0000-00-00', '', '00:00:00', '', 1),
(12, 'vt1', 'chennai', '2021-12-23 00:00:00', '2021-12-23 00:00:00', '0000-00-00', '', '00:00:00', '', 1),
(13, 'vto ee', 'testing ', '2021-12-08 00:00:00', '2021-12-08 00:00:00', '0000-00-00', '', '00:00:00', '', 1),
(14, 'r', 'testing ', '2021-12-10', '', '0000-00-00', '', '00:00:00', '', 1),
(15, 'rr', 'testing 1', '2021-12-10', '2021-12-10', '0000-00-00', '', '00:00:00', '', 1),
(16, 'vtooo1', 'bangalore', '2021-12-15', '2021-12-15', '0000-00-00', '', '00:00:00', '', 1),
(17, 'vtoo1', 'bangalore', '2021-12-14', '2021-12-14', '0000-00-00', '', '00:00:00', '', 1),
(18, 'p-working', 'p-working', '2021-12-16', '2021-12-16', '0000-00-00', '03:00', '05:00:00', '500', 1),
(19, 'test ok', 'test ok', '2021-12-22', '2021-12-22', '0000-00-00', '01:30', '04:01:00', '400', 1),
(20, 'checking', 'details on event mangement', '2021-12-09', '', '0000-00-00', '09:30', '11:00:00', '500', 1),
(21, 'checking 2', 'banglore', '2021-12-17', '', '0000-00-00', '16:00', '18:50:00', '500', 1),
(22, 'checking 3', 'details on event mangement', '2021-12-18', '', '0000-00-00', '14:05', '17:05:00', '500', 1),
(23, 'program', 'banglore', '2021-12-09', '', '0000-00-00', '12:11', '12:12:00', '500', 1),
(24, 'checking 6', 'details on event mangement', '2021-12-19', '2021-12-19', '0000-00-00', '19:55', '21:55:00', '500', 1),
(25, 'checking 7', 'details on event mangement', '2021-12-20', '2021-12-20', '0000-00-00', '17:04', '20:02:00', '500', 1),
(26, 'checking 8', 'details on event mangement', '2021-12-21', '2021-12-21', '0000-00-00', '17:10', '21:05:00', '500', 1),
(27, 'checking 9', 'details on event mangement', '2021-12-24', '2021-12-24', '0000-00-00', '17:07', '19:07:00', '500', 1),
(28, 'program ', 'details on event mangement', '2021-12-25', '2021-12-25', '0000-00-00', '09:43', '00:43:00', '500', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `events1`
--
ALTER TABLE `events1`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `events1`
--
ALTER TABLE `events1`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
