-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 14, 2021 at 04:17 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.0.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db-test`
--

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `start_date` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `end_date` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=Active, 0=Block'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `description`, `start_date`, `end_date`, `created`, `status`) VALUES
(1, 'This is a special events about web development', '', '2018-02-12 00:00:00', '2018-02-16 00:00:00', '2018-02-10 00:00:00', 1),
(2, 'PHP Seminar 2018', '', '2018-02-11 00:00:00', '2018-02-17 00:00:00', '2018-02-10 00:00:00', 1),
(3, 'Bootstrap events 2018', '', '2018-02-4 00:00:00', '2018-02-4 00:00:00', '2018-02-01 00:00:00', 1),
(4, 'Developers events', '', '2018-02-04 00:00:00', '2018-02-04 00:00:00', '2018-02-01 00:00:00', 1),
(5, 'Annual Conference 2018', '', '2018-02-05 00:00:00', '2018-02-05 00:00:00', '2018-02-01 00:00:00', 1),
(6, 'Bootstrap Annual events 2018', '', '2018-02-05 00:00:00', '2018-02-05 00:00:00', '2018-02-01 00:00:00', 1),
(7, 'HTML5 events', '', '2018-02-05 00:00:00', '2018-02-05 00:00:00', '2018-02-01 00:00:00', 1),
(8, 'PHP conference events 2018', '', '2018-02-08 00:00:00', '2018-02-08 00:00:00', '2018-02-02 00:00:00', 1),
(9, 'Web World events', '', '2018-02-08 00:00:00', '2018-02-08 00:00:00', '2018-02-01 00:00:00', 1),
(10, 'Wave PHP 2018', '', '2018-02-08 00:00:00', '2018-02-08 00:00:00', '2018-02-02 00:00:00', 1),
(11, 'Dev PHP 2018', '', '2018-02-08 00:00:00', '2018-02-08 00:00:00', '2018-02-01 00:00:00', 1),
(0, 'demo test', 'ok working', '2021-11-08 00:00:00', '2021-11-08 00:00:00', '2021-11-08 00:00:00', 1),
(0, 'vto', '', '2021-11-30 00:00:00', '2021-11-30 00:00:00', '2021-11-30 00:00:00', 1),
(0, 'test vto', 'testing ', '2021-11-21 00:00:00', '2021-11-21 00:00:00', '2021-11-21 00:00:00', 1),
(0, 'vto1', 'testing 1', '2021-11-21 00:00:00', '2021-11-21 00:00:00', '2021-11-21 00:00:00', 1),
(0, 'vto 22', 'testing 1', '2021-11-21 00:00:00', '2021-11-21 00:00:00', '2021-11-21 00:00:00', 1),
(0, 'ttt', 'testing 14', '2021-11-24 00:00:00', '2021-11-24 00:00:00', '2021-11-24 00:00:00', 1),
(0, 'tt', 'testing 14', '2021-11-30 00:00:00', '2021-11-30 00:00:00', '2021-11-30 00:00:00', 1),
(0, 'ok', 'ok', '2021-11-30 00:00:00', '2021-11-30 00:00:00', '2021-11-30 00:00:00', 1),
(0, 'yy', 'tt', '2021-11-31 00:00:00', '2021-11-31 00:00:00', '0000-00-00 00:00:00', 1),
(0, 'hh', 'h', '2021-11-24 00:00:00', '2021-11-24 00:00:00', '2021-11-24 00:00:00', 1),
(0, 'gg', 'testing ', '2021-11-24 00:00:00', '2021-11-24 00:00:00', '2021-11-24 00:00:00', 1),
(0, 'dd', 'uu', '2021-11-25 00:00:00', '2021-11-25 00:00:00', '2021-11-25 00:00:00', 1),
(0, 'kkl', 'bv', '2021-11-25 00:00:00', '2021-11-25 00:00:00', '2021-11-25 00:00:00', 1),
(0, 'hy', 'hy', '2021-11-26 00:00:00', '2021-11-26 00:00:00', '2021-11-26 00:00:00', 1),
(0, 'gg', 'gg', '2021-11-26 00:00:00', '2021-11-26 00:00:00', '2021-11-26 00:00:00', 1),
(0, 'demo', 'demo1', '2021-11-26 00:00:00', '2021-11-26 00:00:00', '2021-11-26 00:00:00', 1),
(0, 'ev1', 'ok', '2021-12-05 00:00:00', '2021-12-05 00:00:00', '2021-12-05 00:00:00', 1),
(0, 'vto1', 'testing ', '2021-12-05 00:00:00', '2021-12-05 00:00:00', '2021-12-05 00:00:00', 1),
(0, 'vtt2', '', '2021-12-06 00:00:00', '2021-12-06 00:00:00', '2021-12-06 00:00:00', 1),
(0, '', '', '', '', '0000-00-00 00:00:00', 1);

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
  `created` datetime NOT NULL,
  `stime` varchar(225) NOT NULL,
  `etime` varchar(225) NOT NULL,
  `efee` varchar(225) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=Active, 0=Block'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `events1`
--

INSERT INTO `events1` (`id`, `title`, `description`, `start_date`, `end_date`, `created`, `stime`, `etime`, `efee`, `status`) VALUES
(4, 'vto', '', '2021-12-05 10:00:00', '2021-12-05 08:00:00', '2021-12-05 00:00:00', '', '', '', 0),
(9, 'check', 'ok', '2021-12-17', '17-12-2021', '0000-00-00 00:00:00', '', '', '', 1),
(10, 'vto12', '2021-12-15', '12:29', 'bangalore', '0000-00-00 00:00:00', '', '', '', 1),
(12, 'vt1', 'chennai', '2021-12-23 00:00:00', '2021-12-23 00:00:00', '0000-00-00 00:00:00', '', '', '', 1),
(13, 'vto ee', 'testing ', '2021-12-08 00:00:00', '2021-12-08 00:00:00', '0000-00-00 00:00:00', '', '', '', 1),
(14, 'r', 'testing ', '2021-12-10', '', '0000-00-00 00:00:00', '', '', '', 1),
(15, 'rr', 'testing 1', '2021-12-10', '2021-12-10', '0000-00-00 00:00:00', '', '', '', 1),
(16, 'vtooo1', 'bangalore', '2021-12-15', '2021-12-15', '0000-00-00 00:00:00', '', '', '', 1),
(17, 'vtoo1', 'bangalore', '2021-12-14', '2021-12-14', '0000-00-00 00:00:00', '', '', '', 1),
(18, 'p-working', 'p-working', '2021-12-16', '2021-12-16', '0000-00-00 00:00:00', '03:00', '05:00', '500', 1),
(19, 'test ok', 'test ok', '2021-12-22', '2021-12-22', '0000-00-00 00:00:00', '01:30', '04:01', '400', 1);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
