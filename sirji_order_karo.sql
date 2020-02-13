-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 13, 2020 at 08:49 PM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
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

CREATE TABLE `brand_tbl` (
  `id` int(11) NOT NULL,
  `brand_name` varchar(255) NOT NULL,
  `brand_slug` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `category_tbl`
--

CREATE TABLE `category_tbl` (
  `id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dealer_destributor_tbl`
--

CREATE TABLE `dealer_destributor_tbl` (
  `id` int(11) NOT NULL,
  `dist_id` int(11) NOT NULL,
  `dealer_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `order_tbl`
--

CREATE TABLE `order_tbl` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `unit_price` double NOT NULL,
  `discount` double NOT NULL,
  `total_amout` double NOT NULL,
  `order_no` bigint(20) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `product_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `product_tbl`
--

CREATE TABLE `product_tbl` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `qty` int(11) NOT NULL,
  `unit_price` double NOT NULL,
  `in_stock` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `cate_id` int(11) NOT NULL,
  `sub_cate_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sub_category`
--

CREATE TABLE `sub_category` (
  `id` int(11) NOT NULL,
  `sub_cate_name` varchar(100) NOT NULL,
  `cate_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_otp`
--

CREATE TABLE `tbl_otp` (
  `id` int(11) NOT NULL,
  `otp_code` varchar(10) NOT NULL,
  `user_id` int(11) NOT NULL,
  `expire_in` time NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user_tbl`
--

CREATE TABLE `user_tbl` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile_no` varchar(20) NOT NULL,
  `user_role` varchar(50) NOT NULL,
  `profile_pic` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_tbl`
--

INSERT INTO `user_tbl` (`id`, `name`, `email`, `mobile_no`, `user_role`, `profile_pic`, `address`, `created_at`) VALUES
(23, 'shailendra verma', 'shail5788@gmail.com', '89343934', '1', 'default.png', '', '2020-02-13 19:45:08');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brand_tbl`
--
ALTER TABLE `brand_tbl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category_tbl`
--
ALTER TABLE `category_tbl`
  ADD PRIMARY KEY (`id`),
  ADD KEY `brand_id` (`brand_id`);

--
-- Indexes for table `dealer_destributor_tbl`
--
ALTER TABLE `dealer_destributor_tbl`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dist_id` (`dist_id`,`dealer_id`),
  ADD KEY `dealer_id` (`dealer_id`);

--
-- Indexes for table `order_tbl`
--
ALTER TABLE `order_tbl`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`,`product_id`),
  ADD KEY `order_no` (`order_no`),
  ADD KEY `order_tbl_ibfk_2` (`product_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product_tbl`
--
ALTER TABLE `product_tbl`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `cate_id` (`cate_id`),
  ADD KEY `sub_cate_id` (`sub_cate_id`),
  ADD KEY `brand_id` (`brand_id`);

--
-- Indexes for table `sub_category`
--
ALTER TABLE `sub_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cate_id` (`cate_id`) USING BTREE;

--
-- Indexes for table `tbl_otp`
--
ALTER TABLE `tbl_otp`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_tbl`
--
ALTER TABLE `user_tbl`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brand_tbl`
--
ALTER TABLE `brand_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `category_tbl`
--
ALTER TABLE `category_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dealer_destributor_tbl`
--
ALTER TABLE `dealer_destributor_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_tbl`
--
ALTER TABLE `order_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_tbl`
--
ALTER TABLE `product_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sub_category`
--
ALTER TABLE `sub_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_otp`
--
ALTER TABLE `tbl_otp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_tbl`
--
ALTER TABLE `user_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

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
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product_tbl` (`id`);

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

--
-- Constraints for table `tbl_otp`
--
ALTER TABLE `tbl_otp`
  ADD CONSTRAINT `tbl_otp_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_tbl` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
