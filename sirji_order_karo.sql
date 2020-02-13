-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 13, 2020 at 03:03 PM
-- Server version: 5.7.9
-- PHP Version: 7.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sirji_order_karo`
--

-- --------------------------------------------------------

--
-- Table structure for table `brand_tbl`
--

DROP TABLE IF EXISTS `brand_tbl`;
CREATE TABLE IF NOT EXISTS `brand_tbl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `brand_name` varchar(255) NOT NULL,
  `brand_slug` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `category_tbl`
--

DROP TABLE IF EXISTS `category_tbl`;
CREATE TABLE IF NOT EXISTS `category_tbl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(100) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  KEY `brand_id` (`brand_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dealer_destributor_tbl`
--

DROP TABLE IF EXISTS `dealer_destributor_tbl`;
CREATE TABLE IF NOT EXISTS `dealer_destributor_tbl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dist_id` int(11) NOT NULL,
  `dealer_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  KEY `dist_id` (`dist_id`,`dealer_id`),
  KEY `dealer_id` (`dealer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `order_tbl`
--

DROP TABLE IF EXISTS `order_tbl`;
CREATE TABLE IF NOT EXISTS `order_tbl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `unit_price` double NOT NULL,
  `discount` double NOT NULL,
  `total_amout` double NOT NULL,
  `order_no` bigint(20) NOT NULL,
  `order_date` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`,`product_id`),
  KEY `order_no` (`order_no`),
  KEY `order_tbl_ibfk_2` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `product_tbl`
--

DROP TABLE IF EXISTS `product_tbl`;
CREATE TABLE IF NOT EXISTS `product_tbl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(255) NOT NULL,
  `qty` int(11) NOT NULL,
  `unit_price` double NOT NULL,
  `in_stock` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `cate_id` int(11) NOT NULL,
  `sub_cate_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `cate_id` (`cate_id`),
  KEY `sub_cate_id` (`sub_cate_id`),
  KEY `brand_id` (`brand_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sub_category`
--

DROP TABLE IF EXISTS `sub_category`;
CREATE TABLE IF NOT EXISTS `sub_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sub_cate_name` varchar(100) NOT NULL,
  `cate_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cate_id` (`cate_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_tbl`
--

DROP TABLE IF EXISTS `user_tbl`;
CREATE TABLE IF NOT EXISTS `user_tbl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile_no` varchar(20) NOT NULL,
  `user_role` varchar(50) NOT NULL,
  `profile_pic` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_tbl`
--

INSERT INTO `user_tbl` (`id`, `name`, `email`, `mobile_no`, `user_role`, `profile_pic`, `address`, `created_at`) VALUES
(5, 'shailendra verma', 'shail5788@gmail.com', '7892374982', '1', 'default.png', '', '2020-02-13 13:47:37'),
(6, 'shailendra verma', 'shail5788@gmail.com', '7892374982', '1', 'default.png', '', '2020-02-13 13:48:10'),
(7, 'shailendra verma', 'shail5788@gmail.com', '78923749821', '1', 'default.png', '', '2020-02-13 13:57:01'),
(8, 'shailendra verma', 'shail5788@gmail.com', '78923749820', '1', 'default.png', '', '2020-02-13 13:57:50'),
(9, 'shailendra verma', 'shail5788@gmail.com', '78923749720', '1', 'default.png', '', '2020-02-13 14:02:32'),
(10, 'shailendra verma', 'shail5788@gmail.com', '15345345', '1', 'default.png', '', '2020-02-13 14:03:00'),
(11, 'shailendra verma', 'shail5788@gmail.com', '153453435', '1', 'default.png', '', '2020-02-13 14:03:16'),
(12, 'shailendra verma', 'shail5788@gmail.com', '153453423435', '1', 'default.png', '', '2020-02-13 14:03:41'),
(13, 'shailendra verma', 'shail5788@gmail.com', '15345234', '1', 'default.png', '', '2020-02-13 14:12:15'),
(14, 'shailendra verma', 'shail5788@gmail.com', '15345224', '1', 'default.png', '', '2020-02-13 14:26:05');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `category_tbl`
--
ALTER TABLE `category_tbl`
  ADD CONSTRAINT `category_tbl_ibfk_1` FOREIGN KEY (`brand_id`) REFERENCES `brand_tbl` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `dealer_destributor_tbl`
--
ALTER TABLE `dealer_destributor_tbl`
  ADD CONSTRAINT `dealer_destributor_tbl_ibfk_1` FOREIGN KEY (`dist_id`) REFERENCES `user_tbl` (`id`),
  ADD CONSTRAINT `dealer_destributor_tbl_ibfk_2` FOREIGN KEY (`dealer_id`) REFERENCES `user_tbl` (`id`);

--
-- Constraints for table `order_tbl`
--
ALTER TABLE `order_tbl`
  ADD CONSTRAINT `order_tbl_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_tbl` (`id`),
  ADD CONSTRAINT `order_tbl_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product_tbl` (`id`);

--
-- Constraints for table `product_tbl`
--
ALTER TABLE `product_tbl`
  ADD CONSTRAINT `product_tbl_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_tbl` (`id`),
  ADD CONSTRAINT `product_tbl_ibfk_2` FOREIGN KEY (`cate_id`) REFERENCES `category_tbl` (`id`),
  ADD CONSTRAINT `product_tbl_ibfk_3` FOREIGN KEY (`brand_id`) REFERENCES `brand_tbl` (`id`);

--
-- Constraints for table `sub_category`
--
ALTER TABLE `sub_category`
  ADD CONSTRAINT `sub_category_ibfk_1` FOREIGN KEY (`cate_id`) REFERENCES `category_tbl` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
