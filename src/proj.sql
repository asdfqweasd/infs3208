-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 13, 2021 at 06:10 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 7.4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `proj`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `address_id` bigint(20) NOT NULL,
  `userid` int(11) NOT NULL,
  `address1` varchar(500) DEFAULT NULL,
  `address2` varchar(500) DEFAULT NULL,
  `suburb` varchar(50) NOT NULL,
  `postcode` int(10) NOT NULL,
  `state` varchar(500) NOT NULL,
  `receiver` varchar(500) NOT NULL,
  `phone_number` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`address_id`, `userid`, `address1`, `address2`, `suburb`, `postcode`, `state`, `receiver`, `phone_number`) VALUES
(2, 5, '40 High St', '', 'Toowong', 4066, 'Queensland', 'xihan', 424871015);

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `image_filepath` varchar(500) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `qty` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `product_id`, `product_name`, `category`, `image_filepath`, `price`, `qty`) VALUES
(5, 1, 4, 'apple', '', '', 0, 2),
(6, 1, 3, 'lansu', '', '', 0, 2),
(7, 1, 5, 'e1212', '', '', 0, 1),
(8, 1, 1, 'refre', '', '', 0, 2),
(9, 1, 8, 'fw', '', ';UQ.png', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `category` varchar(255) DEFAULT NULL,
  `price` varchar(10) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image_filepath` text DEFAULT NULL,
  `uploader` int(11) DEFAULT NULL,
  `buyer` varchar(255) DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `qty` int(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `created_at`, `category`, `price`, `description`, `image_filepath`, `uploader`, `buyer`, `unit`, `street`, `state`, `qty`) VALUES
(8, 'fw', '2021-09-27 18:27:16', 'fruit', '123', 'fw', ';UQ.png', 1, '7,6,6,7', 'fw', 'fwf', 'f', NULL),
(10, 'IRONman', '2021-09-27 20:25:31', 'vegetable', '2341234', 'lsakfdjasldfjafalskdjfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfsadfasdfasf\'d', ';12.jpg', 1, '0,6,6,6', '2', '3', '4', 1234),
(11, 'cat', '2021-09-27 20:30:01', 'processed_food', '333', 'w', ';aaad.jpg;539ab52fa38b9df5ab55f4bcf0e784f.jpg;32.jpg', 1, NULL, 'w', 'w', 'werw', 0),
(12, 'nizai', '2021-09-27 20:44:59', 'snacks', '123123', 'aa', ';abs.jpg;hamnao.jpg;c3rt.jpg', 1, '7,6,7', 'asdf', 'ddd', 'dfa', 0),
(13, 'touxiang', '2021-09-27 20:50:01', 'fruit', '1231231', 'haokan', ';stack.jpg;039e4cdc66c37.jpg;6c3f8d41ee25b91d2d99a797ea408b1.jpg;7484cb9.jpg;2630643888f6195f7a828644dccabc5.jpg', 1, '0,6,6', '1', 'eqw', 'eqw', 44),
(16, 'su', '2021-10-07 05:04:08', 'processed_food', '7', '777', '', 7, '0', '7', 'efwyugf', 'QLD', 7),
(17, 'su', '2021-10-07 05:14:30', 'processed_food', '7', '777', ';apple.jpeg', 7, '0', '7', 'efwyugf', 'QLD', 7),
(18, 'sfhudfweufhweui', '2021-10-09 07:19:31', 'snacks', '7', '777', ';??2021-10-10 ??1.16.53.png', 7, '7', '7', '7', 'QLD', 7);

-- --------------------------------------------------------

--
-- Table structure for table `stores`
--

CREATE TABLE `stores` (
  `id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `store_name` varchar(50) NOT NULL,
  `city` varchar(20) DEFAULT NULL,
  `location` text DEFAULT NULL,
  `contact_number` char(11) DEFAULT NULL,
  `opening_time` varchar(20) DEFAULT NULL,
  `closing_time` varchar(20) DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `username` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(15) NOT NULL,
  `password` varchar(500) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `user_img_path` text DEFAULT NULL,
  `emotion` text DEFAULT NULL,
  `email_verification_key` int(255) NOT NULL,
  `email_vertified` int(11) DEFAULT NULL,
  `date_created` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `user_img_path`, `emotion`, `email_verification_key`, `email_vertified`, `date_created`) VALUES
(1, 's4551715', '$2y$10$bzexVp0aiZrOl32YSebzgO6ayBh0Es779XNABBaW/Vpbztyp/VO7q', '123456@gmail.com', NULL, NULL, 0, NULL, '2021-09-26 21:39:58'),
(2, 'test1', '$2y$10$4B8PN/4wzbYSiWV1ipNYqeKXkfrfPtNyCJNPgf2muzh/y.Bcf5LLG', 'ha@gmail.com', '/1111111.jpg', NULL, 0, NULL, '2021-10-01 06:51:11'),
(4, 'test2', '$2y$10$V/4E02.u4fMseG16Dv1rKe2OBQr8w/56AO6stk5XvhaBAxIplCgm.', 'd@gmail.com', '/foodmoji_default_user_icon.jpg', NULL, 0, NULL, '2021-10-01 19:02:07'),
(5, 'test3', '$2y$10$LaIz1QQsqOMGo4w.Sx5DM.ubdNCNm27gtJ5GR6kCyAQZfrA/jVyh6', 'bi@gmail.com', '/girl1.png', NULL, 0, NULL, '2021-10-01 19:21:38'),
(6, 'alexsu', '$2y$10$kzVLvYLGHZkg0vrRqZEl6OocTjXPm1nHrubjPzF3MobdAmOXAzdUu', 'shiyansu@gmail.com', '/foodmoji_default_user_icon.jpg', NULL, 0, NULL, '2021-10-05 12:27:32'),
(7, 'alex', '$2y$10$ffzn9SlfLgrS0as78BE.LeuUjsyXJ78PNPDvpjMUQKLVJAhu3Ri1y', 'lansu123@gmail.com', '/foodmoji_default_user_icon.jpg', NULL, 0, NULL, '2021-10-05 12:30:14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD KEY `fk_userid` (`userid`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stores`
--
ALTER TABLE `stores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `store_name` (`store_name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `stores`
--
ALTER TABLE `stores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=140;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `fk_userid` FOREIGN KEY (`userid`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
