-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: Dec 25, 2024 at 05:42 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webbbbbb`
--

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `id` int(11) NOT NULL,
  `car_name` varchar(255) NOT NULL,
  `color` varchar(50) NOT NULL,
  `model_year` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `car_photo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`id`, `car_name`, `color`, `model_year`, `price`, `stock`, `car_photo`) VALUES
(9, 'bmw', '#2b00ff', 2016, 500000.00, 2, 'uploads/67675221d3dce.jpg'),
(10, 'audi', '#0008ff', 2017, 500500.00, 4, 'uploads/6767522e65f52.jpg'),
(11, 'lamborghini', '#ff0000', 2016, 99999999.99, 5, 'uploads/67675291b47ae.jpg'),
(12, 'jeep', '#ffffff', 2015, 5000550.00, 5, 'uploads/67675299ce044.jpg'),
(13, 'mercedes', '#655d5d', 2018, 600000.00, 5, 'uploads/676752a821a33.jpg'),
(14, 'ford', '#000000', 2019, 500000.00, 2, 'uploads/676752af4e5ff.jpg'),
(15, 'Dodge', '#ff0505', 2017, 500000.00, 3, 'uploads/676752b92e9a4.jpg'),
(16, 'bmw', '#ffffff', 2016, 500000.00, 3, 'uploads/676752c5db2f6.jpg'),
(17, 'spernza A113', '#4b4444', 2009, 50000.00, 3, 'uploads/676752cdd5335.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `message` text NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `name`, `email`, `phone`, `message`, `submitted_at`) VALUES
(3, 'zeyad', 'zeyady1974@gmail.com', '4531531531', 'vadlml;adm vl;adsvdsv', '2024-12-21 12:29:15'),
(4, 'zeyad', 'zeyady1974@gmail.com', '20000032032', 'cv,ldmlv;davadv', '2024-12-21 12:29:23'),
(5, 'zeyad', 'zeyady1974@gmail.com', '20000032032', 'cv,ldmlv;davadv', '2024-12-21 12:29:47'),
(6, 'zeyad', 'zeyady1974@gmail.com', '20000032032', 'cv,ldmlv;davadv', '2024-12-21 12:30:15'),
(7, 'zeyad', 'zeyady1974@gmail.com', '4531531531', 'adafasff', '2024-12-21 12:30:21'),
(8, 'zeyad', 'zeyady1974@gmail.com', '4531531531', 'adafasff', '2024-12-21 12:30:57'),
(9, 'zeyad', 'zeyady1974@gmail.com', '0530530', 'afsfasfasfasf', '2024-12-21 12:31:05'),
(10, 'zeyad', 'zeyady1974@gmail.com', '0530530', 'afsfasfasfasf', '2024-12-21 12:32:33'),
(11, 'شبسب', 'zeyady1974@gmail.com', '0530530', 'شبشسبشسبسب', '2024-12-21 12:33:32'),
(12, 'شبسب', 'zeyady1974@gmail.com', '0530530', 'شبشسبشسبسب', '2024-12-21 12:34:03'),
(13, 'zeyad', 'zeyady1974@gmail.com', '20000032032', 'بشسب', '2024-12-21 12:34:09'),
(14, 'zeyad', 'zeyady1974@gmail.com', '4531531531', 'adfmasmf&#039;asm&#039;asc ', '2024-12-21 12:43:27'),
(15, 'zeyad', 'zeyady1974@gmail.com', '20000032032', 'asfasfasfasfasfasfasfafasf', '2024-12-21 12:46:25'),
(16, '', '', '', '', '2024-12-22 00:01:57'),
(17, 'zeyad', 'zeyady1974@gmail.com', '01033309615', '1;niobiugyubuojm;&#039;', '2024-12-22 07:24:06');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `Phone` varchar(20) DEFAULT NULL,
  `Role` varchar(20) NOT NULL,
  `pin_code` int(11) NOT NULL,
  `otp` int(6) DEFAULT NULL,
  `otp_expiration` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Username`, `Email`, `pass`, `Phone`, `Role`, `pin_code`, `otp`, `otp_expiration`) VALUES
(21, 'zeyad_yasser22', 'zeyady1974@gmail.com', '$2y$10$XE8DLOi1BPbN9OpSaNDgWe/HrRiuAFo509/7TLSj/IRA1jktLooaG', '01033309615', 'admin', 949665, 317983, '2024-12-21 17:01:04'),
(34, 'oma_khald', 'omar@gmail.com', '$2y$10$/ERX8MGRaQ1QCSf9TvcpIOjc.MteTDc3sRQ8OuDO2qmBopcFedjQu', '01033309615', 'user', 4020210, NULL, NULL),
(42, 'norhan', 'walidnorhan2@gmail.com', '$2y$10$VnD08TcvoYW.UW6uJ9Vqp.cbReg5SgaxnCGzsgfkwnBbGn46TvOa.', '01033309615', 'admin', 0, NULL, NULL),
(43, 'Mennna', 'walidnorha22n2@gmail.com', '$2y$10$ZIQL6h1E7EDtxb/sTdxH7.d5TW9GSI0K72T23SK.nuQyORJpXZmWG', '01033309615', 'admin', 0, NULL, NULL),
(44, 'vuhik', 'm@gmasil.com', '$2y$10$kcYJxIxUEInlnifRLiKMVOivQ561iHD.TrhI7rkyUipNk6mZz07ly', '01033309615', 'admin', 0, NULL, NULL),
(45, 'faresss', 'fareess.mohameedd@gmail.com', '$2y$10$kCwaYlEseAvu0i2GhZEUr.sJAMWyYCyFMsD01qK2E9vqklTV9eaU6', '01033309615', 'user', 11156515, 562270, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`,`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
