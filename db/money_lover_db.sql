-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 10, 2015 at 11:27 AM
-- Server version: 5.6.21
-- PHP Version: 5.5.19

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `money_lover_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
`id` int(7) NOT NULL,
  `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `delete_flag` tinyint(2) NOT NULL,
  `wallet_id` int(7) NOT NULL,
  `typename_id` int(1) NOT NULL,
  `special_id` tinyint(2) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `created`, `modified`, `delete_flag`, `wallet_id`, `typename_id`, `special_id`) VALUES
(63, 'Other Spent', '2015-04-10 05:35:59', '2015-04-10 05:35:59', 1, 45, 1, NULL),
(64, 'Other Earned', '2015-04-10 05:35:59', '2015-04-10 05:35:59', 1, 45, 2, NULL),
(65, 'Loan Spent', '2015-04-10 05:35:59', '2015-04-10 05:35:59', 1, 45, 1, 1),
(66, 'Debt Earned', '2015-04-10 05:35:59', '2015-04-10 05:35:59', 1, 45, 2, 2),
(67, '123', '2015-04-10 05:36:08', '2015-04-10 05:36:08', 0, 45, 1, 1),
(68, 'Other Spent', '2015-04-10 06:21:59', '2015-04-10 06:21:59', 1, 46, 1, NULL),
(69, 'Other Earned', '2015-04-10 06:21:59', '2015-04-10 06:21:59', 1, 46, 2, NULL),
(70, 'Loan Spent', '2015-04-10 06:21:59', '2015-04-10 06:21:59', 1, 46, 1, 1),
(71, 'Debt Earned', '2015-04-10 06:21:59', '2015-04-10 06:21:59', 1, 46, 2, 2),
(72, 'Other Spent', '2015-04-10 10:32:15', '2015-04-10 10:32:15', 1, 47, 1, NULL),
(73, 'Other Earned', '2015-04-10 10:32:15', '2015-04-10 10:32:15', 1, 47, 2, NULL),
(74, 'Loan Spent', '2015-04-10 10:32:15', '2015-04-10 10:32:15', 1, 47, 1, 1),
(75, 'Debt Earned', '2015-04-10 10:32:15', '2015-04-10 10:32:15', 1, 47, 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE IF NOT EXISTS `currencies` (
`id` int(3) NOT NULL,
  `name` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `rate` decimal(10,2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`id`, `name`, `rate`) VALUES
(1, 'LAK', '8026.60'),
(3, 'VND', '21600.00'),
(4, 'BAT', '32.57'),
(5, 'USD', '1.00'),
(6, 'EUR', '0.92'),
(7, 'CNY', '6.21'),
(8, 'CAD', '1.25'),
(9, 'JPY', '119.85');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE IF NOT EXISTS `reports` (
`id` int(7) NOT NULL,
  `wallet_id` int(7) NOT NULL,
  `month_report` date NOT NULL,
  `openning_balance` decimal(10,0) NOT NULL,
  `ending_balance` decimal(10,0) NOT NULL,
  `net_income` decimal(10,0) NOT NULL,
  `expense` decimal(10,0) NOT NULL,
  `income` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `specials`
--

CREATE TABLE IF NOT EXISTS `specials` (
`id` tinyint(2) NOT NULL,
  `name` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `specials`
--

INSERT INTO `specials` (`id`, `name`) VALUES
(1, 'loan'),
(2, 'borrowing');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE IF NOT EXISTS `transactions` (
`id` int(9) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `transaction_value` decimal(10,2) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `category_id` int(7) NOT NULL,
  `delete_flag` tinyint(2) NOT NULL,
  `date_of_execution` date NOT NULL,
  `parent_transaction` int(9) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `name`, `transaction_value`, `created`, `modified`, `category_id`, `delete_flag`, `date_of_execution`, `parent_transaction`) VALUES
(30, 'chan', '1000.00', '2015-04-01 00:00:00', '2015-04-10 09:50:58', 64, 0, '0000-00-00', NULL),
(31, '123', '1221.00', '2015-04-10 06:05:52', '2015-04-10 06:05:52', 65, 0, '2015-04-10', NULL),
(33, '1234', '123.00', '2015-04-10 06:18:44', '2015-04-10 09:58:39', 63, 0, '0000-00-00', NULL),
(34, 'chan', '0.00', '2015-04-10 06:39:48', '2015-04-10 09:50:43', 65, 0, '0000-00-00', 31),
(35, 'choi choi', '123.00', '2015-04-10 07:04:17', '2015-04-10 10:10:07', 63, 0, '2015-05-16', NULL),
(36, 'di da ngoai', '1000000.00', '2015-04-10 09:52:29', '2015-04-10 10:04:34', 63, 0, '0000-00-00', NULL),
(37, 'linh', '123.00', '2015-04-10 09:58:00', '2015-04-10 09:58:00', 63, 0, '2015-04-10', NULL),
(38, 'linh', '123.00', '2015-04-10 10:03:20', '2015-04-10 10:03:20', 63, 0, '2015-04-10', NULL),
(39, 'linh11', '21312.00', '2015-04-10 10:03:33', '2015-04-10 10:03:33', 65, 0, '2015-04-10', NULL),
(40, 'gin', '1111.00', '2015-04-10 10:03:48', '2015-04-10 10:03:48', 65, 0, '2015-04-10', 39),
(41, 'mua nha', '12.00', '2015-04-10 10:11:10', '2015-04-10 10:11:10', 63, 0, '2015-04-17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `typenames`
--

CREATE TABLE IF NOT EXISTS `typenames` (
`id` int(1) NOT NULL,
  `name` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `typenames`
--

INSERT INTO `typenames` (`id`, `name`) VALUES
(1, 'spent on'),
(2, 'earn from');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` int(7) NOT NULL,
  `username` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `default_wallet` int(7) DEFAULT NULL,
  `current_wallet` int(7) DEFAULT NULL,
  `first_login` tinyint(2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created`, `modified`, `default_wallet`, `current_wallet`, `first_login`) VALUES
(1, 'linh', 'b71e6c35c3b7c743104cfa10fa864595', '2015-04-01 00:00:00', '2015-04-01 00:00:00', 1, 1, 0),
(2, '1', '5c1e39fdc8a6713cb10ba7cc2cbcb737', '2015-04-06 03:15:31', '2015-04-06 03:15:31', NULL, NULL, 0),
(15, '2', '1bbd886460827015e5d605ed44252251', '2015-04-06 05:12:31', '2015-04-06 05:12:31', NULL, NULL, 0),
(16, 'mail.example0506@gmail.com', '1bbd886460827015e5d605ed44252251', '2015-04-06 05:12:44', '2015-04-06 05:12:44', NULL, NULL, 0),
(17, 'gin', '2dee98876e6ccceebd7b8ef429a706ed5f0b183a', '2015-04-06 05:56:43', '2015-04-06 05:56:43', NULL, NULL, 0),
(19, 'linh@gmail.com', 'cf2abcbad2d69ccfc74bbfadc86c48ab', '2015-04-07 03:59:40', '2015-04-07 03:59:40', NULL, NULL, 0),
(20, 'manhlinh0506@gmail.com', 'a5302c2843eaadb36cc3451d18b75aef0534ce50', '2015-04-07 10:51:47', '2015-04-07 10:51:47', NULL, 47, 0),
(21, 'suhaoxaocucai@gmail.com', 'a5302c2843eaadb36cc3451d18b75aef0534ce50', '2015-04-09 13:04:11', '2015-04-09 13:04:11', NULL, 45, 0);

-- --------------------------------------------------------

--
-- Table structure for table `wallets`
--

CREATE TABLE IF NOT EXISTS `wallets` (
`id` int(7) NOT NULL,
  `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `currency_id` int(3) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `balance` decimal(10,2) NOT NULL,
  `delete_flag` tinyint(2) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `wallets`
--

INSERT INTO `wallets` (`id`, `name`, `currency_id`, `created`, `modified`, `user_id`, `balance`, `delete_flag`) VALUES
(7, 'vi 1', 3, '2015-04-01 00:00:00', '2015-04-01 00:00:00', 1, '1000000.00', NULL),
(12, 'vi 3', 4, '2015-04-22 00:00:00', '2015-04-25 00:00:00', 16, '1000000.00', NULL),
(13, 'vi 4', 4, '2015-04-01 00:00:00', '2015-04-01 00:00:00', 2, '1000000.00', NULL),
(14, 'vi 5', 3, '2015-04-22 00:00:00', '2015-04-25 00:00:00', 15, '1000000.00', NULL),
(45, '123', 4, '2015-04-10 05:35:59', '2015-04-10 06:27:22', 21, '124.51', NULL),
(46, 'linh', 3, '2015-04-10 06:21:59', '2015-04-10 06:27:22', 21, '232.00', NULL),
(47, 'gin wallet', 5, '2015-04-10 10:32:15', '2015-04-10 10:32:15', 20, '10000000.00', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
 ADD PRIMARY KEY (`id`), ADD KEY `wallet_id` (`wallet_id`), ADD KEY `typename_id` (`typename_id`), ADD KEY `special_id` (`special_id`);

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
 ADD PRIMARY KEY (`id`), ADD KEY `wallet_id` (`wallet_id`);

--
-- Indexes for table `specials`
--
ALTER TABLE `specials`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
 ADD PRIMARY KEY (`id`), ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `typenames`
--
ALTER TABLE `typenames`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `wallets`
--
ALTER TABLE `wallets`
 ADD PRIMARY KEY (`id`), ADD KEY `currency_id` (`currency_id`), ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
MODIFY `id` int(7) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=76;
--
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
MODIFY `id` int(3) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
MODIFY `id` int(7) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `specials`
--
ALTER TABLE `specials`
MODIFY `id` tinyint(2) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
MODIFY `id` int(9) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=42;
--
-- AUTO_INCREMENT for table `typenames`
--
ALTER TABLE `typenames`
MODIFY `id` int(1) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(7) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `wallets`
--
ALTER TABLE `wallets`
MODIFY `id` int(7) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=48;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`wallet_id`) REFERENCES `wallets` (`id`),
ADD CONSTRAINT `categories_ibfk_2` FOREIGN KEY (`typename_id`) REFERENCES `typenames` (`id`),
ADD CONSTRAINT `categories_ibfk_3` FOREIGN KEY (`special_id`) REFERENCES `specials` (`id`);

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
ADD CONSTRAINT `reports_ibfk_1` FOREIGN KEY (`wallet_id`) REFERENCES `wallets` (`id`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `wallets`
--
ALTER TABLE `wallets`
ADD CONSTRAINT `wallets_ibfk_1` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`),
ADD CONSTRAINT `wallets_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
SET FOREIGN_KEY_CHECKS=1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
