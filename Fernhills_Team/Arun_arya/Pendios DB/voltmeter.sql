-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 16, 2021 at 09:11 AM
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
-- Database: `login_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `voltmeter`
--

CREATE TABLE `voltmeter` (
  `Sl_no` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `time_stamp` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ac_v` int(20) NOT NULL,
  `ac_c` int(20) NOT NULL,
  `ac_p` int(20) NOT NULL,
  `dc_v` int(20) NOT NULL,
  `dc_c` int(20) NOT NULL,
  `dc_p` int(20) NOT NULL,
  `c_t` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `voltmeter`
--

INSERT INTO `voltmeter` (`Sl_no`, `user_id`, `time_stamp`, `ac_v`, `ac_c`, `ac_p`, `dc_v`, `dc_c`, `dc_p`, `c_t`) VALUES
(1, 1, '02-04-2021_17:09', 240, 10, 2400, 24, 10, 240, '2021-04-10 05:59:51'),
(2, 1, '03-04-2021_18:38', 239, 9, 2151, 23, 8, 184, '2021-04-10 05:59:51'),
(3, 2, '03-04-2021_18:38', 239, 9, 2151, 23, 8, 184, '2021-04-10 05:59:51'),
(4, 1, '03-04-2021_18:43', 240, 10, 2400, 23, 10, 230, '2021-04-10 05:59:51'),
(5, 1, '03-04-2021_18:43', 240, 10, 2400, 23, 10, 230, '2021-04-10 05:59:51'),
(6, 0, '03-04-2021_19:07', 238, 10, 2380, 8, 10, 80, '2021-04-10 05:59:51'),
(7, 1, '03-04-2021_19:17', 230, 10, 2300, 9, 10, 90, '2021-04-10 05:59:51'),
(8, 1, '03-04-2021_19:25', 240, 10, 2400, 8, 10, 80, '2021-04-10 05:59:51'),
(9, 2, '03-04-2021_19:26', 241, 10, 2410, 8, 10, 80, '2021-04-10 05:59:51'),
(10, 1, '03-04-2021_19:26', 241, 10, 2410, 8, 10, 80, '2021-04-10 05:59:51'),
(11, 1, '03-04-2021_19:26', 241, 10, 2410, 8, 10, 80, '2021-04-10 05:59:51'),
(12, 2, '03-04-2021_12:40', 241, 10, 2410, 8, 10, 80, '2021-04-10 05:59:51'),
(13, 2, '03-04-2021_12:42', 238, 10, 2380, 8, 10, 80, '2021-04-10 05:59:51'),
(14, 2, '03-04-2021_12:42', 238, 10, 2380, 8, 10, 80, '2021-04-10 05:59:51'),
(15, 2, '03-04-2021_19:07', 238, 10, 2380, 8, 10, 80, '2021-04-10 05:59:51'),
(16, 1, '07-04-2021_12:42', 238, 10, 2380, 8, 10, 80, '2021-04-10 05:59:51'),
(17, 1, '07-04-2021_12:42', 242, 12, 2380, 8, 10, 80, '2021-04-10 05:59:51'),
(18, 1, '07-04-2021_18:14', 230, 10, 0, 24, 5, 90, '2021-04-10 05:59:51'),
(19, 0, '07-04-2021_18:42', 230, 10, 2300, 24, 10, 240, '2021-04-10 05:59:51'),
(20, 0, '07-04-2021_18:42', 230, 10, 2300, 24, 10, 240, '2021-04-10 05:59:51'),
(21, 0, '07-04-2021_18:42', 230, 10, 2300, 24, 10, 240, '2021-04-10 05:59:51'),
(22, 0, '08-04-2021_18:42', 230, 10, 2300, 24, 10, 240, '2021-04-10 05:59:51'),
(23, 0, '07-04-2021_12:42', 242, 12, 2380, 8, 10, 80, '2021-04-10 05:59:51'),
(24, 0, '10-04-2021_18:42', 230, 10, 2300, 24, 10, 240, '2021-04-10 05:59:51'),
(25, 0, '10-04-2021_12:42', 242, 12, 2380, 8, 10, 80, '2021-04-10 06:00:10'),
(26, 0, '10-04-2021_18:42', 220, 10, 2300, 24, 10, 240, '2021-04-10 06:41:52'),
(27, 0, '10-04-2021_18:42', 220, 10, 2300, 24, 10, 240, '2021-04-10 06:45:00'),
(28, 0, '10-04-2021_18:42', 220, 10, 2300, 24, 10, 240, '2021-04-12 09:45:58'),
(29, 0, '03-04-2021_19:17', 230, 10, 2300, 9, 10, 90, '2021-04-12 11:30:19'),
(30, 0, '10-04-2021_18:42', 220, 10, 2300, 24, 10, 240, '2021-04-12 12:43:10'),
(31, 0, '10-04-2021_18:42', 220, 10, 2300, 24, 10, 240, '2021-04-12 12:43:33'),
(32, 0, '10-04-2021_18:42', 220, 10, 2300, 24, 10, 240, '2021-04-12 12:44:58'),
(33, 0, '10-04-2021_18:42', 220, 10, 2300, 24, 10, 240, '2021-04-12 12:47:17'),
(34, 0, '10-04-2021_18:42', 220, 10, 2300, 24, 10, 240, '2021-04-12 12:48:16'),
(35, 0, '10-04-2021_18:42', 220, 10, 2300, 24, 10, 240, '2021-04-12 12:49:07'),
(36, 0, '10-04-2021_18:42', 220, 10, 2300, 24, 10, 240, '2021-04-13 12:46:42'),
(37, 0, '10-04-2021_18:42', 220, 10, 2300, 24, 10, 240, '2021-04-13 12:53:17'),
(38, 0, '10-04-2021_18:42', 220, 10, 2300, 24, 10, 240, '2021-04-13 12:56:33'),
(39, 0, '10-04-2021_18:42', 220, 10, 2300, 24, 10, 240, '2021-04-13 12:56:59'),
(40, 0, '10-04-2021_18:42', 220, 10, 2300, 24, 10, 240, '2021-04-13 12:59:18'),
(41, 0, '10-04-2021_12:42', 242, 12, 2380, 8, 10, 80, '2021-04-14 06:55:58'),
(42, 0, '10-04-2021_18:42', 220, 10, 2300, 24, 10, 240, '2021-04-20 09:58:09'),
(43, 0, '07-04-2021_12:42', 241, 12, 2380, 8, 10, 80, '2021-04-20 10:29:22'),
(44, 0, '10-04-2021_18:42', 220, 10, 2300, 24, 10, 240, '2021-04-20 10:41:47'),
(45, 0, '10-04-2021_18:42', 220, 10, 2300, 24, 10, 240, '2021-04-20 10:43:40'),
(46, 0, '10-04-2021_18:42', 220, 10, 2300, 24, 10, 240, '2021-04-20 10:46:49'),
(47, 0, '10-04-2021_18:42', 220, 10, 2300, 24, 10, 240, '2021-04-20 11:09:19'),
(48, 0, '10-04-2021_18:42', 220, 10, 2300, 24, 10, 240, '2021-04-20 11:13:04'),
(49, 0, '10-04-2021_18:42', 220, 10, 2300, 24, 10, 240, '2021-04-20 11:15:01'),
(50, 0, '10-04-2021_18:42', 220, 10, 2300, 24, 10, 240, '2021-04-20 11:27:31'),
(51, 0, '10-04-2021_18:42', 220, 10, 2300, 24, 10, 240, '2021-04-20 11:33:36'),
(52, 0, '10-04-2021_18:42', 220, 10, 2300, 24, 10, 240, '2021-04-20 11:40:05'),
(53, 0, '10-04-2021_18:42', 220, 10, 2300, 24, 10, 240, '2021-04-20 12:34:32'),
(54, 0, '10-04-2021_18:42', 220, 10, 2300, 24, 10, 240, '2021-04-20 12:43:15'),
(55, 0, '10-04-2021_18:42', 220, 10, 2300, 24, 10, 240, '2021-04-20 12:47:16'),
(56, 0, '07-04-2021_12:42', 241, 12, 2380, 8, 10, 80, '2021-04-22 12:36:14'),
(57, 0, '03-04-2021_19:07', 238, 10, 2380, 8, 10, 80, '2021-04-28 06:29:59'),
(58, 0, '28-04-2021_12:01', 220, 10, 2200, 9, 10, 90, '2021-04-28 06:32:27'),
(59, 0, '03-04-2021_19:07', 238, 10, 2380, 8, 10, 80, '2021-04-28 08:46:09'),
(60, 0, '03-04-2021_19:07', 238, 10, 2380, 8, 10, 80, '2021-04-28 09:01:23'),
(61, 0, '10-04-2021_18:42', 220, 10, 2300, 24, 10, 240, '2021-04-29 10:27:46'),
(62, 0, '', 0, 0, 0, 0, 0, 0, '2021-04-29 10:32:59'),
(63, 0, '10-04-2021_18:42', 220, 10, 2300, 24, 10, 240, '2021-04-29 10:46:03'),
(64, 0, '10-04-2021_18:42', 220, 10, 2300, 24, 10, 240, '2021-04-29 10:47:49'),
(65, 0, '', 0, 0, 0, 0, 0, 0, '2021-04-29 10:51:54'),
(66, 0, '10-04-2021_18:42', 220, 10, 2300, 24, 10, 240, '2021-04-29 11:09:07'),
(67, 0, '10-04-2021_18:42', 220, 10, 2300, 24, 10, 240, '2021-04-29 11:11:06'),
(68, 0, '10-04-2021_18:42', 220, 10, 2300, 24, 10, 240, '2021-04-29 11:17:46'),
(69, 0, '10-04-2021_18:42', 220, 10, 2300, 24, 10, 240, '2021-04-29 11:19:06'),
(70, 0, '10-04-2021_18:42', 220, 10, 2300, 24, 10, 240, '2021-04-29 11:22:49'),
(71, 0, '10-04-2021_18:42', 220, 10, 2300, 24, 10, 240, '2021-04-29 11:24:21'),
(72, 0, '10-04-2021_18:42', 220, 10, 2300, 24, 10, 240, '2021-04-29 11:33:24'),
(73, 0, '10-04-2021_18:42', 220, 10, 2300, 24, 10, 240, '2021-04-29 11:37:17'),
(74, 0, '10-04-2021_18:42', 220, 10, 2300, 24, 10, 240, '2021-04-29 11:37:25'),
(75, 0, '10-04-2021_18:42', 220, 10, 2300, 24, 10, 240, '2021-04-29 11:38:13'),
(76, 0, '10-04-2021_18:42', 220, 10, 2300, 24, 10, 240, '2021-04-29 11:40:43'),
(77, 0, '10-04-2021_18:42', 220, 10, 2300, 24, 10, 240, '2021-04-29 11:41:59'),
(78, 0, '10-04-2021_18:42', 220, 10, 2300, 24, 10, 240, '2021-04-29 11:43:03'),
(79, 0, '10-04-2021_18:42', 220, 10, 2300, 24, 10, 240, '2021-04-29 11:44:08'),
(80, 0, '10-04-2021_18:42', 220, 10, 2300, 24, 10, 240, '2021-04-29 11:46:54'),
(81, 0, '10-04-2021_18:42', 220, 10, 2300, 24, 10, 240, '2021-04-29 11:47:46'),
(82, 0, '10-04-2021_18:42', 220, 10, 2300, 24, 10, 240, '2021-04-29 11:52:04'),
(83, 0, '10-04-2021_18:42', 220, 10, 2300, 24, 10, 240, '2021-04-29 11:52:41'),
(84, 0, '10-04-2021_18:42', 220, 10, 2300, 24, 10, 240, '2021-04-29 12:03:23'),
(85, 0, '03-04-2021_19:07', 238, 10, 2380, 8, 10, 80, '2021-04-29 12:04:50'),
(86, 0, '10-04-2021_18:42', 220, 10, 2300, 24, 10, 240, '2021-04-29 12:13:12'),
(87, 0, '10-04-2021_18:42', 220, 10, 2300, 24, 10, 90, '2021-04-29 12:14:45'),
(88, 0, '29-04-2021_18:00', 220, 10, 2300, 24, 10, 90, '2021-04-29 12:35:03'),
(89, 0, '29-04-2021_18:00', 220, 10, 3000, 24, 10, 90, '2021-04-29 12:38:50'),
(90, 0, '29-04-2021_18:00', 220, 10, 3000, 24, 10, 90, '2021-04-29 12:42:32'),
(91, 0, '29-04-2021_18:00', 220, 10, 3000, 24, 10, 90, '2021-04-29 12:45:37'),
(92, 0, '29-04-2021_18:00', 220, 10, 3000, 24, 10, 90, '2021-04-29 14:54:45'),
(93, 0, '29-04-2021_18:00', 220, 10, 3000, 24, 10, 90, '2021-04-29 14:56:00'),
(94, 0, '29-04-2021_20:00', 240, 10, 2400, 22, 10, 100, '2021-04-29 15:05:37'),
(95, 0, '29-04-2021_20:00', 240, 10, 2400, 22, 10, 100, '2021-04-29 15:07:25'),
(96, 0, '29-04-2021_20:00', 240, 10, 2400, 22, 10, 100, '2021-05-04 07:55:21'),
(97, 0, '29-04-2021_20:00', 240, 10, 2400, 22, 10, 100, '2021-05-04 08:02:49'),
(98, 0, '29-04-2021_20:00', 240, 10, 2400, 22, 10, 100, '2021-05-04 08:13:42'),
(99, 0, '29-04-2021_20:00', 240, 10, 2400, 22, 10, 100, '2021-05-04 08:18:11'),
(100, 0, '29-04-2021_20:00', 240, 10, 2400, 22, 10, 100, '2021-05-04 08:24:20'),
(101, 0, '29-04-2021_20:00', 240, 10, 2400, 22, 10, 100, '2021-05-04 08:24:56'),
(102, 0, '29-04-2021_20:00', 240, 10, 2400, 22, 10, 100, '2021-05-04 08:25:55'),
(103, 0, '29-04-2021_20:00', 240, 10, 2400, 22, 10, 100, '2021-05-04 08:32:45'),
(104, 0, '29-04-2021_20:00', 240, 10, 2400, 22, 10, 100, '2021-05-04 08:34:26'),
(105, 0, '29-04-2021_20:00', 240, 10, 2400, 22, 10, 100, '2021-05-04 08:35:50'),
(106, 0, '29-04-2021_20:00', 240, 10, 2400, 22, 10, 100, '2021-05-04 08:37:45'),
(107, 0, '29-04-2021_20:00', 240, 10, 2400, 22, 10, 100, '2021-05-04 08:42:59'),
(108, 0, '29-04-2021_20:00', 240, 10, 2400, 22, 10, 100, '2021-05-04 08:44:41'),
(109, 0, '29-04-2021_20:00', 240, 10, 2400, 22, 10, 100, '2021-05-04 08:54:02'),
(110, 0, '29-04-2021_20:00', 240, 10, 2400, 22, 10, 100, '2021-05-04 08:56:59'),
(111, 0, '29-04-2021_20:00', 240, 10, 2400, 22, 10, 100, '2021-05-04 09:04:59'),
(112, 0, '29-04-2021_20:00', 240, 10, 2400, 22, 10, 100, '2021-05-04 09:05:54'),
(113, 0, '29-04-2021_20:00', 240, 10, 2400, 22, 10, 100, '2021-05-04 11:55:09'),
(114, 0, '29-04-2021_20:00', 240, 10, 2400, 22, 10, 100, '2021-05-04 12:09:07'),
(115, 0, '18:02', 240, 5, 1200, 30, 3, 100, '2021-05-04 12:11:41'),
(116, 0, '15-05-2021_20:00', 200, 10, 2400, 22, 10, 101, '2021-05-15 09:50:58'),
(117, 0, '17-0-2021_20:00', 230, 10, 2000, 22, 10, 200, '2021-05-15 10:07:47'),
(118, 0, '29-04-2021_20:00', 240, 10, 2400, 22, 10, 100, '2021-05-15 12:02:48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `voltmeter`
--
ALTER TABLE `voltmeter`
  ADD PRIMARY KEY (`Sl_no`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `voltmeter`
--
ALTER TABLE `voltmeter`
  MODIFY `Sl_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;