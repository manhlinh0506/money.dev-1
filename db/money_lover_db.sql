-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 07, 2015 at 03:23 AM
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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `created`, `modified`, `delete_flag`, `wallet_id`, `typename_id`, `special_id`) VALUES
(13, 'tra tien', '2015-04-22 00:00:00', '2015-04-25 00:00:00', 0, 11, 1, 1),
(14, 'study', '2015-04-01 00:00:00', '2015-04-01 00:00:00', 0, 14, 2, 1),
(16, 'hang out', '2015-04-01 00:00:00', '2015-04-01 00:00:00', 0, 7, 1, 1),
(17, 'vay hang xom', '2015-04-22 00:00:00', '2015-04-25 00:00:00', 0, 12, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE IF NOT EXISTS `currencies` (
`id` int(3) NOT NULL,
  `name` varchar(3) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`id`, `name`) VALUES
(1, 'lao'),
(3, 'VND'),
(4, 'BAT');

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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `name`, `transaction_value`, `created`, `modified`, `category_id`, `delete_flag`, `date_of_execution`, `parent_transaction`) VALUES
(8, 'choi', '1000.00', '2015-04-06 11:17:11', '2015-04-06 11:17:11', 13, 0, '2015-04-06', NULL),
(9, 'nghi', '1000.00', '2015-04-06 11:17:20', '2015-04-06 11:17:20', 17, 0, '2015-04-06', NULL),
(10, 'ngu', '12.00', '2015-04-06 11:17:30', '2015-04-06 11:17:30', 16, 0, '2015-04-06', NULL);

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
  `current_wallet` int(7) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created`, `modified`, `default_wallet`, `current_wallet`) VALUES
(1, 'linh', '12345678', '2015-04-01 00:00:00', '2015-04-01 00:00:00', 1, 1),
(2, 'suhaoxaocucai@gmail.com', '5c1e39fdc8a6713cb10ba7cc2cbcb737', '2015-04-06 03:15:31', '2015-04-06 03:15:31', NULL, NULL),
(15, 'manhlinh0506@gmail.com', '1bbd886460827015e5d605ed44252251', '2015-04-06 05:12:31', '2015-04-06 05:12:31', NULL, NULL),
(16, 'mail.example0506@gmail.com', '1bbd886460827015e5d605ed44252251', '2015-04-06 05:12:44', '2015-04-06 05:12:44', NULL, NULL),
(17, 'gin', '2dee98876e6ccceebd7b8ef429a706ed5f0b183a', '2015-04-06 05:56:43', '2015-04-06 05:56:43', NULL, NULL);

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
  `balance` decimal(10,0) NOT NULL,
  `delete_flag` tinyint(2) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `wallets`
--

INSERT INTO `wallets` (`id`, `name`, `currency_id`, `created`, `modified`, `user_id`, `balance`, `delete_flag`) VALUES
(7, 'vi 1', 3, '2015-04-01 00:00:00', '2015-04-01 00:00:00', 1, '1000000', NULL),
(11, 'vi 2', 1, '2015-04-01 00:00:00', '2015-04-01 00:00:00', 2, '1000000', NULL),
(12, 'vi 3', 4, '2015-04-22 00:00:00', '2015-04-25 00:00:00', 16, '1000000', NULL),
(13, 'vi 4', 4, '2015-04-01 00:00:00', '2015-04-01 00:00:00', 2, '1000000', NULL),
(14, 'vi 5', 3, '2015-04-22 00:00:00', '2015-04-25 00:00:00', 15, '1000000', NULL);

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
 ADD PRIMARY KEY (`id`);

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
MODIFY `id` int(7) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
MODIFY `id` int(3) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
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
MODIFY `id` int(9) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `typenames`
--
ALTER TABLE `typenames`
MODIFY `id` int(1) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(7) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `wallets`
--
ALTER TABLE `wallets`
MODIFY `id` int(7) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
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
