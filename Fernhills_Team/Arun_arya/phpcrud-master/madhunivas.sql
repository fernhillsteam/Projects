-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 20, 2021 at 03:49 PM
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
-- Database: `madhunivas`
--

-- --------------------------------------------------------

--
-- Table structure for table `bird_multiple_images`
--

CREATE TABLE `bird_multiple_images` (
  `id` int(11) NOT NULL,
  `imgName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bird_multiple_images`
--

INSERT INTO `bird_multiple_images` (`id`, `imgName`) VALUES
(2, '0'),
(3, '0'),
(4, 'download (4).png'),
(5, 'Untitled_design__47_-removebg-preview.png'),
(6, 'spo1 (2).png'),
(8, 'icons8-angularjs-96.png'),
(9, 'icons8-python-96.png'),
(10, 'icons8-microsoft-sql-server-96.png');

-- --------------------------------------------------------

--
-- Table structure for table `property`
--

CREATE TABLE `property` (
  `p_id` int(11) NOT NULL,
  `images` varchar(200) NOT NULL,
  `name` varchar(100) NOT NULL,
  `location` varchar(100) NOT NULL,
  `beds` int(100) NOT NULL,
  `bathrooms` int(100) NOT NULL,
  `garden` int(100) NOT NULL,
  `area` varchar(100) NOT NULL,
  `price` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `register`
--

CREATE TABLE `register` (
  `name` varchar(20) NOT NULL,
  `location` varchar(20) NOT NULL,
  `beds` varchar(50) NOT NULL,
  `bathrooms` varchar(15) NOT NULL,
  `image` varchar(100) NOT NULL,
  `parking` varchar(10) NOT NULL,
  `area` varchar(200) NOT NULL,
  `price` varchar(200) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `register`
--

INSERT INTO `register` (`name`, `location`, `beds`, `bathrooms`, `image`, `parking`, `area`, `price`, `id`) VALUES
('user1', 'bangalore', '3', '2', 'image/1.png', 'yes', '11000', '20,000', 19),
('property3', 'mysore', '2', '1', 'image/4.png', 'yes', '12001', '120,000', 21),
('property4', 'pune', '1', '1', 'image/4.png', 'no', '11000', '220,000', 22),
('testing2', 'pune', '2', '1', '', 'No', '11200', '220,000', 24),
('demo1', 'mumbai', '1', '1', '', 'Yes', '11000', '120,000', 25),
('demo1', 'pune', '2', '2', '', 'Yes', '12001', '1200000', 27);

-- --------------------------------------------------------

--
-- Table structure for table `rent`
--

CREATE TABLE `rent` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `location` varchar(200) NOT NULL,
  `beds` varchar(200) NOT NULL,
  `bathrooms` varchar(200) NOT NULL,
  `image` varchar(200) NOT NULL,
  `parking` varchar(200) NOT NULL,
  `area` varchar(200) NOT NULL,
  `price` varchar(200) NOT NULL,
  `amount` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rent`
--

INSERT INTO `rent` (`id`, `name`, `location`, `beds`, `bathrooms`, `image`, `parking`, `area`, `price`, `amount`) VALUES
(3, 'y1', 'pune', '4', '2', 'rent/big-data-science-analysis-isometric-colored-composition-with-related-steps-networking_1284-54448.jpg', 'no', '11000', '220,000', '50,000'),
(5, 'testing1', 'pune', '3', '2', 'rent/electric-car-charging-charger-station_333239-284.jpg', 'yes', '11000', '220,000', '50,000');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bird_multiple_images`
--
ALTER TABLE `bird_multiple_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `property`
--
ALTER TABLE `property`
  ADD PRIMARY KEY (`p_id`);

--
-- Indexes for table `register`
--
ALTER TABLE `register`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rent`
--
ALTER TABLE `rent`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bird_multiple_images`
--
ALTER TABLE `bird_multiple_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `property`
--
ALTER TABLE `property`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `register`
--
ALTER TABLE `register`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `rent`
--
ALTER TABLE `rent`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
