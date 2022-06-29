-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 28, 2022 at 10:30 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vvto`
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
-- Table structure for table `album_list`
--

CREATE TABLE `album_list` (
  `id` int(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `date` varchar(100) NOT NULL,
  `venue` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `album_list`
--

INSERT INTO `album_list` (`id`, `title`, `date`, `venue`, `description`) VALUES
(1, 'event1', '1/1/22', 'venue1', 'Description'),
(2, 'event2', '2/1/22', 'venue2', 'description2'),
(3, 'event3', '3/1/22', 'venue3', 'description3'),
(4, 'event4', '4/1/22', 'venue4', 'description4'),
(5, 'event5', '4/1/22', 'venue4', 'description5'),
(6, 'event6', '6/1/22', 'venue6', 'description6'),
(7, 'event7', '1/2/22', 'venue7', 'description7'),
(8, 'event8', '1/2/22', 'venue4', 'description1'),
(9, 'event9', '1/2/22', 'venue4', 'description2'),
(10, 'event10', '1/2/22', 'venue6', 'description1');

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
(1, 53, 'Legal Services', 'Screenshot (4).png', 'Services', 'Legal Services'),
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
(19, 52, 'Sell Custom Printed Products (T-shirts, Mugs)	', 'WhatsApp Image 2021-12-21 at 2.27.02 PM.jpeg', 'printed product', 'Legal Services Authorities are statutory bodies constituted in the states of India by the Legal Services Authorities Act 1987, as enshrined by article 39-A of the Constitution of India, for providing free legal services for the citizens.'),
(20, 50, 'Medical Delivery Services', 'Screenshot (6).png', 'Services', 'Legal Services Authorities are statutory bodies constituted in the states of India by the Legal Services Authorities Act 1987, as enshrined by article 39-A of the Constitution of India, for providing free legal services for the citizens.');

-- --------------------------------------------------------

--
-- Table structure for table `events1`
--

CREATE TABLE `events1` (
  `id` int(11) NOT NULL,
  `title` varchar(225) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `venue` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
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

INSERT INTO `events1` (`id`, `title`, `venue`, `description`, `start_date`, `end_date`, `created`, `stime`, `etime`, `efee`, `status`) VALUES
(34, 'Todays VTO Monthly Meeting.', 'Hotel Paraag- (Hotel Capitol Entrance, Diagonally Opposite to GPO, Near Vidhana Soudha).', 'This message is a Gentle reminder for Todays VTO Monthly Meeting.  Its Our Pleasure to Invite You for Our VTO Monthly Meeting Today Friday 27th May 2022, 5:30 pm to 9 pm.  Please Block Your Calender...', '2022-05-27', '2022-05-27', '2022-05-27', '17:30', '18:30:00', '650', 1);

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `sl_no` int(100) NOT NULL,
  `album_id` int(100) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`sl_no`, `album_id`, `image`) VALUES
(46, 1, '2.JPG'),
(49, 2, '3.JPG'),
(50, 3, '4.JPG'),
(64, 4, '5.JPG'),
(66, 7, '2.JPG'),
(80, 8, '9.JPG'),
(84, 5, '6.JPG'),
(87, 6, '7.JPG'),
(115, 9, '3.JPG'),
(116, 10, '11.JPG'),
(117, 6, '11.jpg'),
(118, 5, '9.jpg'),
(119, 4, '4.jpg'),
(120, 4, '7.jpg'),
(121, 4, '9.jpg'),
(122, 10, '4.jpg'),
(123, 10, '6.jpg'),
(124, 10, '7.jpg'),
(125, 10, '11.jpg'),
(126, 9, '2.jpg'),
(127, 9, '3.jpg'),
(128, 9, '11.jpg'),
(129, 8, '3.jpg'),
(130, 8, '5.jpg'),
(131, 8, '6.jpg'),
(132, 7, '6.jpg'),
(133, 7, '7.jpg'),
(134, 6, '2.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `slider_images`
--

CREATE TABLE `slider_images` (
  `sl_no` int(100) NOT NULL,
  `slider` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `slider_images`
--

INSERT INTO `slider_images` (`sl_no`, `slider`) VALUES
(283, 'home-slider-1.png'),
(286, 'home-slider-2.png'),
(287, 'home-slider-3.png');

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
(42, 'Aryan', 'Arya', '1', 'profile3.jpg', 'Medical Delivery Services', 'arya@gmail.com', '07c90324691eb8e35202f53d951b0f3383e25129', '9448734591', 2, 0, '2021-12-02', '0000-00-00'),
(43, 'Arun', 'Arun', '1', 'profile12.jpg', 'Sell Custom Printed Products (T-shirts, Mugs)', 'arun@gmail.com', '78999612756394ae7f9b46549bb69fe83f5316c3', '9565235262', 3, 0, '2021-12-02', '2021-12-02'),
(44, 'Darsh', 'Darsh', '2', 'profile9.jpg', 'Home-based Bakery', 'darsh@gmail.com', '0a426559073560226d767d05ed579e244e074a93', '9856232658', 2, 1, '2021-12-02', '2021-12-02'),
(46, 'Tejas', 'Tejas', '2', 'profile6.jpg', 'Travel Agency', 'tejas@gmail.com', 'b1932719262ca4afe3638577530378142d8cd1cf', '9325265326', 3, 0, '2021-12-02', '2021-12-02'),
(47, 'Yash', 'Yash', '1', 'profile2.jpg', 'Wedding Planning', 'yash@gmail.com', 'cb124dd92de4e4b6bc24898396162315c8f18ec0', '9555414251', 3, 0, '2021-12-02', '2021-12-02'),
(48, 'Pranit', 'Pranit', '2', 'profile1.jpg', 'Food Trucks', 'pranit@gmail.com', '6e62ca7acce82dd5a6b9773937fcff4915ee0c53', '974584586', 3, 1, '2021-12-02', '2021-12-02'),
(49, 'Mayan', 'Mayan', '2', 'profile8.jpg', 'Repairing Services (Plumbing, Automobiles, Phone)', 'mayan@gmail.com', 'f92d549d342fa169c9f5a2d4f7005faaf093554b', '9784584587', 2, 0, '2021-12-02', '2021-12-02'),
(50, 'Aarav', 'Aarav', '2', 'profile7.jpg', 'Medical Delivery Services', 'aarav@gmail.com', '5b44a8103d01abd568fdd1c5fc8780a4a624549f', '9562562547', 2, 0, '2021-12-02', '2021-12-02'),
(51, 'Vedant', 'Vedant', '1', 'profile4.jpg', 'Personal Training or Coaching', 'vedant@gmail.com', '549b26216ea48011eef3700dc026096895271f0e', '958545745', 3, 0, '2021-12-02', '2021-12-02'),
(52, 'Ishaan', 'Ishaan', '1', 'profile9.jpg', 'Sell Custom Printed Products (T-shirts, Mugs)	', 'ishaan@gmail.com', 'e0489d72986a3bc50df077fa1b547c708d6f91fb', '956852652', 1, 0, '2021-12-02', '2021-12-02'),
(53, 'Ayush', 'Ayush', '1', 'profile1.jpg', 'Legal Services', '19arunarya@gmail.com', '45c001b4d509ee9926c584389fbe762cff0aaf14', '9448734591', 1, 0, '2021-12-02', '2021-12-02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `album_list`
--
ALTER TABLE `album_list`
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
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`sl_no`);

--
-- Indexes for table `slider_images`
--
ALTER TABLE `slider_images`
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
-- AUTO_INCREMENT for table `album_list`
--
ALTER TABLE `album_list`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `biz_images`
--
ALTER TABLE `biz_images`
  MODIFY `sl_no` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `business`
--
ALTER TABLE `business`
  MODIFY `sl_no` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `events1`
--
ALTER TABLE `events1`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `sl_no` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;

--
-- AUTO_INCREMENT for table `slider_images`
--
ALTER TABLE `slider_images`
  MODIFY `sl_no` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=288;

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
