-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 13, 2021 at 08:35 AM
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
-- Table structure for table `business`
--

CREATE TABLE `business` (
  `sl_no` int(10) NOT NULL,
  `user_id` int(11) NOT NULL,
  `business` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `bizimage` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `biztype` varchar(255) NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `business`
--

INSERT INTO `business` (`sl_no`, `user_id`, `business`, `logo`, `bizimage`, `biztype`, `description`) VALUES
(1, 57, 'Legal Services', 'profile-user.png', 'Architecture Design.jpg', 'Services', ';neflknf ohioir lihgriel sliehios sleihfel '),
(5, 57, 'Legal Services', 'profile-user.png', 'Product Architecture.jpg', '', ''),
(6, 57, 'Legal Services', 'profile-user.png', 'PCBDesignServices.jpg', '', '');

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
(23, 'admin', 'admin', '3', 'icons8-view-48.png', '', '19arunaryan@gmail.com', '23d42f5f3f66498b2c8ff4c20b8c5ac826e47146', '9448734591', 1, 0, '2021-11-23', '2021-11-23'),
(42, 'Aryan', 'Arya', '1', '', 'Medical Delivery Services', 'arya@gmail.com', '07c90324691eb8e35202f53d951b0f3383e25129', '9448734591', 2, 0, '2021-12-02', '0000-00-00'),
(43, 'Arun', 'Arun', '1', '', 'Sell Custom Printed Products (T-shirts, Mugs)', 'arun@gmail.com', '78999612756394ae7f9b46549bb69fe83f5316c3', '9565235262', 3, 0, '2021-12-02', '2021-12-02'),
(44, 'Darsh', 'Darsh', '2', '', 'Personal Training or Coaching', 'darsh@gmail.com', '0a426559073560226d767d05ed579e244e074a93', '9856232658', 2, 1, '2021-12-02', '2021-12-02'),
(45, 'Darpan', 'Darpan', '1', '', 'Repairing Services (Plumbing, Automobiles, Phone)', 'darpan@gmail.com', 'f74e254b037941942b102a65c51f21cf69704b65', '9856236251', 3, 1, '2021-12-02', '2021-12-02'),
(46, 'Tejas', 'Tejas', '2', '', 'Food Trucks', 'tejas@gmail.com', 'b1932719262ca4afe3638577530378142d8cd1cf', '9325265326', 3, 0, '2021-12-02', '2021-12-02'),
(47, 'Yash', 'Yash', '1', '', 'Wedding Planning', 'yash@gmail.com', 'cb124dd92de4e4b6bc24898396162315c8f18ec0', '9555414251', 3, 0, '2021-12-02', '2021-12-02'),
(48, 'Pranit', 'Pranit', '2', '', 'Travel Agency', 'pranit@gmail.com', '6e62ca7acce82dd5a6b9773937fcff4915ee0c53', '974584586', 3, 1, '2021-12-02', '2021-12-02'),
(49, 'Mayan', 'Mayan', '2', '', 'Organic Farming', 'mayan@gmail.com', 'f92d549d342fa169c9f5a2d4f7005faaf093554b', '9784584587', 2, 0, '2021-12-02', '2021-12-02'),
(50, 'Aarav', 'Aarav', '2', '', 'Home-based Bakery', 'aarav@gmail.com', '5b44a8103d01abd568fdd1c5fc8780a4a624549f', '9562562547', 2, 0, '2021-12-02', '2021-12-02'),
(51, 'Vedant', 'Vedant', '1', '', 'Virtual Event Planning', 'vedant@gmail.com', '549b26216ea48011eef3700dc026096895271f0e', '958545745', 3, 0, '2021-12-02', '2021-12-02'),
(52, 'Ishaan', 'Ishaan', '1', '', 'Home-based catering', 'ishaan@gmail.com', 'e0489d72986a3bc50df077fa1b547c708d6f91fb', '956852652', 3, 0, '2021-12-02', '2021-12-02'),
(53, 'Ayush', 'Ayush', '1', '', 'Food Stall', '19arunarya@gmail.com', '45c001b4d509ee9926c584389fbe762cff0aaf14', '9448734591', 2, 0, '2021-12-02', '2021-12-02'),
(57, 'Aadarsh', 'Aadarsh', '1', 'icons8-registration-96.png', 'Legal Services', 'aadarsh@gmail.com', '3c529fcd37879da75a15601dc2d3878553081d93', '95868865455', 1, 0, '2021-12-08', '2021-12-08');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `business`
--
ALTER TABLE `business`
  ADD PRIMARY KEY (`sl_no`);

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
-- AUTO_INCREMENT for table `business`
--
ALTER TABLE `business`
  MODIFY `sl_no` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_roles`
--
ALTER TABLE `tbl_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'role_id', AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
