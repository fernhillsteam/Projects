-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 22, 2021 at 04:59 PM
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
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `mobile` int(10) NOT NULL,
  `roleid` tinyint(4) NOT NULL,
  `isActive` tinyint(4) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `username`, `email`, `password`, `mobile`, `roleid`, `isActive`, `created_at`, `update_at`) VALUES
(23, 'admin', 'admin', '19arunaryan@gmail.com', '23d42f5f3f66498b2c8ff4c20b8c5ac826e47146', 2147483647, 1, 0, '2021-12-01 09:18:38', '2021-12-01 09:18:38');

-- --------------------------------------------------------

--
-- Table structure for table `biz_images`
--

CREATE TABLE `biz_images` (
  `sl_no` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `biz_images`
--

INSERT INTO `biz_images` (`sl_no`, `user_id`, `image`) VALUES
(84, 57, 'Screenshot (2).png'),
(85, 57, 'Screenshot (3) - Copy.png'),
(86, 57, 'Screenshot (3).png'),
(91, 53, 'Screenshot (5) - Copy.png'),
(92, 53, 'Screenshot (1).png'),
(93, 53, 'Screenshot (4).png'),
(94, 53, 'Screenshot (4).png');

-- --------------------------------------------------------

--
-- Table structure for table `business`
--

CREATE TABLE `business` (
  `sl_no` int(10) NOT NULL,
  `user_id` int(11) NOT NULL,
  `business` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `biztype` varchar(255) NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `business`
--

INSERT INTO `business` (`sl_no`, `user_id`, `business`, `logo`, `biztype`, `description`) VALUES
(1, 53, 'Legal Services', 'Screenshot (4).png', 'Services', 'Legal Services Authorities are statutory bodies constituted in the states of India by the Legal Services Authorities Act 1987, as enshrined by article 39-A of the Constitution of India, for providing free legal services for the citizens.'),
(9, 71, 'Food Stall', 'WhatsApp Image 2021-12-21 at 2.27.02 PM.jpeg', 'mobile', 'new business details'),
(10, 42, 'Home-based catering', 'Screenshot (6).png', 'catering', 'Legal Services Authorities are statutory bodies constituted in the states of India by the Legal Services Authorities Act 1987, as enshrined by article 39-A of the Constitution of India, for providing free legal services for the citizens.'),
(11, 43, 'Virtual Event Planning', 'Screenshot (6).png', 'Event Planning', 'Legal Services Authorities are statutory bodies constituted in the states of India by the Legal Services Authorities Act 1987, as enshrined by article 39-A of the Constitution of India, for providing free legal services for the citizens.'),
(12, 44, 'Home-based Bakery', 'Screenshot (6).png', 'Bakery', 'Legal Services Authorities are statutory bodies constituted in the states of India by the Legal Services Authorities Act 1987, as enshrined by article 39-A of the Constitution of India, for providing free legal services for the citizens.'),
(13, 45, 'Organic Farming', 'Screenshot (6).png', 'Farm', 'Legal Services Authorities are statutory bodies constituted in the states of India by the Legal Services Authorities Act 1987, as enshrined by article 39-A of the Constitution of India, for providing free legal services for the citizens.'),
(14, 46, 'Travel Agency', 'Screenshot (6).png', 'Agency', 'Legal Services Authorities are statutory bodies constituted in the states of India by the Legal Services Authorities Act 1987, as enshrined by article 39-A of the Constitution of India, for providing free legal services for the citizens.'),
(15, 47, 'Wedding Planning', 'Screenshot (6).png', 'Event Planning', 'Legal Services Authorities are statutory bodies constituted in the states of India by the Legal Services Authorities Act 1987, as enshrined by article 39-A of the Constitution of India, for providing free legal services for the citizens.'),
(16, 48, 'Food Trucks', 'Screenshot (6).png', 'catering', 'Legal Services Authorities are statutory bodies constituted in the states of India by the Legal Services Authorities Act 1987, as enshrined by article 39-A of the Constitution of India, for providing free legal services for the citizens.'),
(17, 49, 'Repairing Services (Plumbing, Automobiles, Phone)', 'Screenshot (6).png', 'Service', 'Legal Services Authorities are statutory bodies constituted in the states of India by the Legal Services Authorities Act 1987, as enshrined by article 39-A of the Constitution of India, for providing free legal services for the citizens.'),
(18, 51, 'Personal Training or Coaching', 'Screenshot (6).png', 'Training', 'Legal Services Authorities are statutory bodies constituted in the states of India by the Legal Services Authorities Act 1987, as enshrined by article 39-A of the Constitution of India, for providing free legal services for the citizens.'),
(19, 52, 'Sell Custom Printed Products (T-shirts, Mugs)	', 'Screenshot (6).png', 'Printed Products', 'Legal Services Authorities are statutory bodies constituted in the states of India by the Legal Services Authorities Act 1987, as enshrined by article 39-A of the Constitution of India, for providing free legal services for the citizens.'),
(20, 50, 'Medical Delivery Services', 'Screenshot (6).png', 'Services', 'Legal Services Authorities are statutory bodies constituted in the states of India by the Legal Services Authorities Act 1987, as enshrined by article 39-A of the Constitution of India, for providing free legal services for the citizens.');

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
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=Active, 0=Block'
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

-- --------------------------------------------------------

--
-- Table structure for table `tbl_roles`
--

CREATE TABLE `tbl_roles` (
  `id` int(11) NOT NULL COMMENT 'role_id',
  `role` varchar(255) DEFAULT NULL COMMENT 'role_text',
  `designation` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_roles`
--

INSERT INTO `tbl_roles` (`id`, `role`, `designation`) VALUES
(1, 'Admin', 'Prime'),
(2, 'Editor', 'Mentor'),
(3, 'User', 'Vice President');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `designation` varchar(255) NOT NULL,
  `profile` varchar(255) NOT NULL,
  `business` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `mobile` varchar(25) DEFAULT NULL,
  `roleid` tinyint(4) DEFAULT NULL,
  `isActive` tinyint(4) DEFAULT 0,
  `created_at` date NOT NULL DEFAULT current_timestamp(),
  `updated_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `name`, `username`, `designation`, `profile`, `business`, `email`, `password`, `mobile`, `roleid`, `isActive`, `created_at`, `updated_at`) VALUES
(42, 'Aryan', 'Arya', '1', 'Screenshot (4).png', 'Medical Delivery Services', 'arya@gmail.com', '07c90324691eb8e35202f53d951b0f3383e25129', '9448734591', 2, 0, '2021-12-02', '0000-00-00'),
(43, 'Arun', 'Arun', '1', 'Screenshot (4).png', 'Sell Custom Printed Products (T-shirts, Mugs)', 'arun@gmail.com', '78999612756394ae7f9b46549bb69fe83f5316c3', '9565235262', 3, 0, '2021-12-02', '2021-12-02'),
(44, 'Darsh', 'Darsh', '2', 'Screenshot (4).png', 'Home-based Bakery', 'darsh@gmail.com', '0a426559073560226d767d05ed579e244e074a93', '9856232658', 2, 1, '2021-12-02', '2021-12-02'),
(45, 'Darpan', 'Darpan', '1', 'Screenshot (4).png', 'Organic Farming', 'darpan@gmail.com', 'f74e254b037941942b102a65c51f21cf69704b65', '9856236251', 3, 1, '2021-12-02', '2021-12-02'),
(46, 'Tejas', 'Tejas', '2', 'Screenshot (4).png', 'Travel Agency', 'tejas@gmail.com', 'b1932719262ca4afe3638577530378142d8cd1cf', '9325265326', 3, 0, '2021-12-02', '2021-12-02'),
(47, 'Yash', 'Yash', '1', 'Screenshot (4).png', 'Wedding Planning', 'yash@gmail.com', 'cb124dd92de4e4b6bc24898396162315c8f18ec0', '9555414251', 3, 0, '2021-12-02', '2021-12-02'),
(48, 'Pranit', 'Pranit', '2', '', 'Food Trucks', 'pranit@gmail.com', '6e62ca7acce82dd5a6b9773937fcff4915ee0c53', '974584586', 3, 1, '2021-12-02', '2021-12-02'),
(49, 'Mayan', 'Mayan', '2', 'Screenshot (4).png', 'Repairing Services (Plumbing, Automobiles, Phone)', 'mayan@gmail.com', 'f92d549d342fa169c9f5a2d4f7005faaf093554b', '9784584587', 2, 0, '2021-12-02', '2021-12-02'),
(50, 'Aarav', 'Aarav', '2', 'Screenshot (4).png', 'Medical Delivery Services', 'aarav@gmail.com', '5b44a8103d01abd568fdd1c5fc8780a4a624549f', '9562562547', 2, 0, '2021-12-02', '2021-12-02'),
(51, 'Vedant', 'Vedant', '1', 'Screenshot (4).png', 'Personal Training or Coaching', 'vedant@gmail.com', '549b26216ea48011eef3700dc026096895271f0e', '958545745', 3, 0, '2021-12-02', '2021-12-02'),
(52, 'Ishaan', 'Ishaan', '1', 'Screenshot (4).png', 'Sell Custom Printed Products (T-shirts, Mugs)	', 'ishaan@gmail.com', 'e0489d72986a3bc50df077fa1b547c708d6f91fb', '956852652', 1, 0, '2021-12-02', '2021-12-02'),
(53, 'Ayush', 'Ayush', '1', 'Screenshot (4).png', 'Legal Services', '19arunarya@gmail.com', '45c001b4d509ee9926c584389fbe762cff0aaf14', '9448734591', 2, 0, '2021-12-02', '2021-12-02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `biz_images`
--
ALTER TABLE `biz_images`
  ADD PRIMARY KEY (`sl_no`);

--
-- Indexes for table `business`
--
ALTER TABLE `business`
  ADD PRIMARY KEY (`sl_no`);

--
-- Indexes for table `events1`
--
ALTER TABLE `events1`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_roles`
--
ALTER TABLE `tbl_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `biz_images`
--
ALTER TABLE `biz_images`
  MODIFY `sl_no` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `business`
--
ALTER TABLE `business`
  MODIFY `sl_no` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `events1`
--
ALTER TABLE `events1`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `tbl_roles`
--
ALTER TABLE `tbl_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'role_id', AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
