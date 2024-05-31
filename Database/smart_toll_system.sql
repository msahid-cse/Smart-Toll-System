-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Generation Time: May 25, 2024 at 10:02 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smart_toll_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_user_pass`
--

CREATE TABLE `admin_user_pass` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_user_pass`
--

INSERT INTO `admin_user_pass` (`id`, `username`, `password`) VALUES
(14, 'admin2', '$2y$10$KprvPklSBNLCpCqopBPV2OFtwAvYCkBGK/9D6KBKTy6Tq2/SOb2qy'),
(15, 'admin3', '$2y$10$RXruokGl69TjK87DVDgjKe8EE71RiYJ0T.S6yca3n7XhogPaYmD1e'),
(16, 'admin10', '$2y$10$q7ZyOH1/CPGyr50NyJI8kOHGDUBRDFTC79cpoPrK.UzfzC3mQ.fji'),
(17, 'admin11', '$2y$10$jPmRjRCTB3dbFfb7GXLGsuoZ0aKOb9mCuxct2WjUeYSopNdH/JOhG'),
(18, '123', '$2y$10$sHc8/1CD8AKR/xl5PLR4KO/q1pbugiwSHJOG4DQSeryTFrIAnMfse'),
(19, 'sahid', '$2y$10$VsmR03FA9c7CsAkB8aZZyOpnUwTBkU2GhmljLV84nosyKKlpflpdG'),
(20, '1111', '$2y$10$Y.qQOGBNSTUKj4phBdQotuL3VCrEr6wHgJqJWykFSn25qzJg7MjKe'),
(21, 'AdminSahid', '$2y$10$XC9KK3S5gs2RoBBi4a69nuBbaXc2j23lB5u21AKRW0gRN/R9pY1OW');

-- --------------------------------------------------------

--
-- Table structure for table `suggestion`
--

CREATE TABLE `suggestion` (
  `id` int(11) NOT NULL,
  `feedback` text NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `suggestion`
--

INSERT INTO `suggestion` (`id`, `feedback`, `submitted_at`) VALUES
(1, 'hello world ', '2024-05-23 17:27:10'),
(2, 'hello world ', '2024-05-23 17:29:16'),
(3, 'nice', '2024-05-23 17:29:40');

-- --------------------------------------------------------

--
-- Table structure for table `toll_data`
--

CREATE TABLE `toll_data` (
  `serial` int(11) NOT NULL,
  `license_number` varchar(10) DEFAULT NULL,
  `toll_fee` int(11) DEFAULT NULL,
  `Payment_Gateway` varchar(255) DEFAULT NULL,
  `record_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `Date` date NOT NULL DEFAULT current_timestamp(),
  `Time` time NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `toll_data`
--

INSERT INTO `toll_data` (`serial`, `license_number`, `toll_fee`, `Payment_Gateway`, `record_at`, `Date`, `Time`) VALUES
(1, 'LIC5839', 1200, 'Online', '2024-05-23 09:14:51', '2024-05-23', '23:49:50'),
(2, 'LIC8531', 1200, 'Cash', '2024-05-23 09:18:05', '2024-05-23', '21:49:50'),
(3, 'LIC5564', 1200, 'Cash', '2024-05-23 09:20:18', '2024-05-23', '21:49:50'),
(4, 'LIC8589', 1200, 'Cash', '2024-05-23 09:21:14', '2024-05-23', '21:49:50'),
(5, 'LIC4627', 1200, 'Cash', '2024-05-23 09:36:29', '2024-05-23', '21:49:50'),
(6, 'LIC4627', 1200, 'Cash', '2024-05-23 09:36:29', '2024-05-23', '21:49:50'),
(7, 'LIC9478', 2400, 'Cash', '2024-05-23 14:11:29', '2024-05-23', '21:49:50'),
(8, 'LIC4482', 2000, 'Cash', '2024-05-23 14:21:21', '2024-05-23', '21:49:50'),
(9, 'LIC1031', 1200, 'Cash', '2024-05-23 16:14:52', '2024-05-23', '22:14:52'),
(10, 'LIC2428', 13500, 'Cash', '2024-05-23 16:21:43', '2024-05-23', '22:21:43'),
(11, 'LIC7691', 1200, 'Cash', '2024-05-23 16:31:39', '2024-05-23', '22:31:39'),
(12, 'LIC1868', 1200, 'Cash', '2024-05-23 17:06:57', '2024-05-23', '23:06:57'),
(13, 'LIC9311', 1200, 'Cash', '2024-05-23 17:07:00', '2024-05-23', '23:07:00'),
(14, 'LIC9466', 1200, 'Cash', '2024-05-23 17:07:16', '2024-05-23', '23:07:16'),
(15, 'LIC6309', 13500, 'Cash', '2024-05-24 04:12:01', '2024-05-24', '10:12:01'),
(16, 'LIC6550', 2400, 'Cash', '2024-05-24 05:15:35', '2024-05-24', '11:15:35'),
(17, 'LIC1196', 127500, 'Cash', '2024-05-24 05:16:46', '2024-05-24', '11:16:46'),
(18, '666666', 1300, 'Cash', '2024-05-24 02:46:21', '2024-05-24', '08:46:21'),
(19, '666666', 1600, 'online', '2024-05-24 02:49:50', '2024-05-24', '08:49:50'),
(20, '666666', 5, 'online', '2024-05-24 20:08:12', '2024-05-25', '02:08:12'),
(21, '666666', 5, 'online', '2024-05-24 20:12:17', '2024-05-25', '02:12:17'),
(22, '666666', 5, 'online', '2024-05-24 20:12:24', '2024-05-25', '02:12:24'),
(23, 'sahidM', 5, 'online', '2024-05-24 20:28:05', '2024-05-25', '02:28:05'),
(24, 'sahidM', 5, 'online', '2024-05-24 20:28:28', '2024-05-25', '02:28:28'),
(25, 'sahidM', 5, 'online', '2024-05-24 20:30:58', '2024-05-25', '02:30:58'),
(26, 'sahidM', 5, 'online', '2024-05-24 20:35:23', '2024-05-25', '02:35:23'),
(27, 'sahidM', 5, 'online', '2024-05-24 20:35:33', '2024-05-25', '02:35:33'),
(28, 'sahidM', 5, 'online', '2024-05-24 20:38:23', '2024-05-25', '02:38:23'),
(29, 'sahidM', 5, 'online', '2024-05-24 20:44:58', '2024-05-25', '02:44:58'),
(30, 'LIC4765', 2400, 'Cash', '2024-05-24 21:21:10', '2024-05-25', '03:21:10'),
(31, 'LIC8263', 1300, 'Cash', '2024-05-24 21:32:57', '2024-05-25', '03:32:57'),
(32, 'SKM', 1300, 'online', '2024-05-25 10:15:07', '2024-05-25', '16:15:07'),
(33, 'SKM', 1300, 'online', '2024-05-25 10:15:18', '2024-05-25', '16:15:18'),
(34, 'SKM', 100, 'online', '2024-05-25 10:17:29', '2024-05-25', '16:17:29'),
(35, 'LIC3782', 1200, 'Cash', '2024-05-25 10:19:11', '2024-05-25', '16:19:11'),
(36, 'SK10102', 100, 'online', '2024-05-25 13:48:57', '2024-05-25', '19:48:57'),
(37, 'LCM1020', 100, 'online', '2024-05-25 17:48:32', '2024-05-25', '23:48:32'),
(38, 'LCM100', 100, 'online', '2024-05-25 19:42:44', '2024-05-26', '01:42:44');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `vehicle_name` varchar(50) NOT NULL,
  `license_number` varchar(50) NOT NULL,
  `toll_fee` varchar(10) NOT NULL,
  `password` varchar(255) NOT NULL,
  `payment_gateway` varchar(50) NOT NULL,
  `payment_account_number` varchar(50) NOT NULL,
  `account_pin_number` varchar(50) NOT NULL,
  `current_balance` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `vehicle_name`, `license_number`, `toll_fee`, `password`, `payment_gateway`, `payment_account_number`, `account_pin_number`, `current_balance`) VALUES
(40, 'Car', '1234', '5', '123', 'PayPal', '123', '123', 10000),
(41, 'Truck', '12345', '5', '12345', 'PayPal', '12345', '12345', 50000),
(42, 'Car', '000', '5', '000', 'PayPal', '000', '000', 15987),
(43, 'Car', '111', '5', '111', 'PayPal', '111', '111', 6000),
(44, 'Car', '123', '5', '$2y$10$s2jM0krqRqO2SdGQdi236eNzePPBKfWokbXNp5KU61OWLI7GxCjHG', 'Bkash', '123', '123', 123456),
(48, 'Car', '0000', '2', '0000', 'PayPal', '0000', '0000', 987654),
(51, 'Truck', '1111', '10', '$2y$10$jnbqqMy9.THFXCRefX3soOpslInT5rnb3PDSGq7BwOE0dhQIvGG0W', 'PayPal', '1111', '1111', 123987),
(52, 'Car', '999', '5', '$2y$10$5xNkXOdMoQzfvvswnY3K6uta5ekZbs.J34DkLm3MVC3lnbfr3oC4G', 'PayPal', '999', '999', 100000),
(53, 'Car', '444', '5', '$2y$10$i5YdjjCsxCdq.BXOuxGmI.sUjRlqPiLpSslHvLKM2XH0ssMSESgtC', 'PayPal', '444', '444', 100121),
(54, 'Motorcycle', '777', '5', '$2y$10$XC4b8irib2j52lMNboJ2X.8xxVFEnMMoqSuQO.dLwXN4Mn686AeXC', 'PayPal', '777', '777', 12587),
(55, 'Motorcycle', '321', '5', '$2y$10$XlA/t9A5HVllGfMvUWVcVOw3zXX0sScSmBLQR2X2X9Vay/twqYUB6', 'PayPal', '321', '321', 951),
(56, 'Motorcycle', '888', '5', '$2y$10$k/9wiBgt4EwAKFaouo4Lr.ctP9MSmjL2nEu6HP7GkOMKsz4SF8STC', 'PayPal', '888', '888', 102030),
(57, 'Car', 'SK1010', '5', '$2y$10$kwO/C2VkwMfnen6t4plaQOG8/JTYPZFirD6.SVUgls.FY.V77bYfW', 'PayPal', '1010', '1010', 101010),
(58, 'Car', 'SK101010', '5', '$2y$10$xT6I6.E31o570Fpdv1XpFutxWGbhbMyPDNk/qOYseaDSJzdLjVvfe', 'PayPal', '101010', '$2y$10$FSRkgzpC6tJ3e5pjQe3bSu7t2UY27y7Yojy.mfLdX5J', 101010),
(59, 'Car', '666666', '5', '$2y$10$ijPb9UE.kaYHOAOOUCQiTOaR./NI0P4A8Jb/ysfe8.fVXyo.ginka', 'Square', '1415', '', 666651),
(60, 'Car', '963', '5', '$2y$10$IZGFQ4DHbl5BYxh8YPMySOKkcAAgoRNc5Epw1lrOQdW.oRdH33gAa', 'PayPal', '963', '963', 1000),
(61, 'Truck', 'sahid10', '5', '$2y$10$EN/xrqb.J6SFO6/Mv/ZnjuTszthzQH/cyuF.iNkx/0xKIrAs5UBBS', 'PayPal', '1020', '$2y$10$r.w4Y3Tg5En/quGGj0oJi.IlafPB3jcTjnEidnlK17z', 1020),
(62, 'Car', 'sahidM', '5', '$2y$10$XCrJOP2C9UHsnuVnEQNA4OHAfLf6gKxG.deVzLkPSHUH0Lpse5AP.', 'PayPal', '1010', '$2y$10$aPTRG.ZzXHM2l6WpXI53YeQopRxwnVxaHDVzVvDX.EL', 975),
(63, 'Car', 'LCM10', '5', '$2y$10$2Xqn7cuPXf9Nw6Ql4RMBT.8667ryqsVRL2vcNPmj.DSA.VfUW0O8e', 'PayPal', '1020', '$2y$10$5DbPCACktF36JfleTWd.w.D.bUKBuJnkgZ1.FH5QPVo', 1020),
(65, 'Motorcycle', 'SKM', '100', '$2y$10$yxumUrWXAn/TmdVx4Jsllu4LmwGu0CtTtSP2wsQ4qYL8mqSQD1Kki', 'Bkash', '1020', '$2y$10$m8WYaumAe4zw.RsDVMVsgOilBHpVQdLxJLRhX.fqBZW', 9900),
(66, 'Motorcycle', 'SK10102', '100', '$2y$10$OD6SJYC3vxOG67mHstRlbu0If4i6l7NsfB6njnJufkKTQkL5I5Dmy', 'Rocket', '5', '$2y$10$7TtzyUvDN9lv/RFvxD.0Iea5sVQ3tJ831IGSzbAeh3H', -95),
(67, 'Motorcycle', 'SK10', '100', '$2y$10$gOvHhRYWPfxkV1yaswvr9OV7znwdZJI5JiiKHJceCD8fnMq3HJapy', 'Bkash', '1020', '$2y$10$//..sLHYodBF5hw3GnYRl.Ooy3Xy9bOnNvYpxW9r9C.', 50),
(70, 'Motorcycle', 'LCM1020', '100', '$2y$10$JdPGNYcRl/sJYQ/Z1UOJrugZfHzpcwYlGiZN5WvurPbV/Jng2G.dO', 'Bkash', '1020', '$2y$10$6yB3LzPaVB3f4qEh/TumHeDMCBX2ctu70yCucJrc9J0', 920),
(71, 'Motorcycle', 'LCM100', '100', '$2y$10$CcEDguCH/T3OnK7JBMxrt.b.T5AqSnXvluTF9xAay8Fjw5VXFRqsS', 'PayPal', '1000', '1000', 900);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_user_pass`
--
ALTER TABLE `admin_user_pass`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `suggestion`
--
ALTER TABLE `suggestion`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `toll_data`
--
ALTER TABLE `toll_data`
  ADD PRIMARY KEY (`serial`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `license_number` (`license_number`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_user_pass`
--
ALTER TABLE `admin_user_pass`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `suggestion`
--
ALTER TABLE `suggestion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `toll_data`
--
ALTER TABLE `toll_data`
  MODIFY `serial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
