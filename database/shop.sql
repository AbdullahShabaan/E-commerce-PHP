-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 18, 2023 at 07:25 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `ordering` int(11) NOT NULL,
  `visibility` tinyint(1) NOT NULL DEFAULT 0,
  `allow_comment` tinyint(1) NOT NULL DEFAULT 0,
  `allow_ads` tinyint(1) NOT NULL DEFAULT 0,
  `parent` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `ordering`, `visibility`, `allow_comment`, `allow_ads`, `parent`) VALUES
(9, 'medical', 'for doctors ', 1, 1, 1, 1, 0),
(10, 'sports', 'for football and basketball', 7, 0, 0, 0, 0),
(11, 'electronics', 'for all electronics', 3, 0, 1, 1, 0),
(21, 'nokia', 'nokia news', 1, 0, 0, 0, 9),
(22, 'nokia2', 'new', 2, 0, 0, 0, 9),
(23, 'dsad', 'asa', 1, 0, 0, 0, 10),
(26, 'sport child', 'for sports childs', 0, 0, 0, 0, 10);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `c_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `comment_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `item_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`c_id`, `comment`, `status`, `comment_date`, `item_id`, `user_id`) VALUES
(11, 'niceeee', 0, '2023-03-25 15:12:19', 12, 47),
(17, 'good', 0, '2023-03-28 03:18:16', 16, 1),
(19, 'this is sooo baaaaaad', 0, '2023-03-28 04:02:10', 12, 1),
(20, 'hello', 0, '2023-03-30 04:44:49', 17, 1),
(21, 'good', 0, '2023-03-30 04:44:56', 17, 1),
(39, 'good', 0, '2023-03-30 05:56:59', 12, 40),
(40, 'good', 0, '2023-03-30 05:57:13', 12, 40),
(41, 'good', 0, '2023-03-30 05:57:15', 12, 40),
(42, 'good', 0, '2023-03-30 05:59:41', 12, 40),
(48, 'bad', 0, '2023-04-02 08:34:38', 19, 1);

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `item_id` int(11) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `item_description` text NOT NULL,
  `price` varchar(255) NOT NULL,
  `dates` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `made_in` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `rating` tinyint(11) NOT NULL,
  `approve` tinyint(4) NOT NULL DEFAULT 0,
  `cat_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`item_id`, `item_name`, `item_description`, `price`, `dates`, `made_in`, `image`, `status`, `rating`, `approve`, `cat_id`, `member_id`) VALUES
(12, 'lab', '8 g ram core i 7', '12000', '2023-04-01 21:46:07', 'china', '', '2', 0, 1, 11, 40),
(16, 'new', 'new new', '12', '2023-03-30 01:17:52', 'chinaa', '', '1', 0, 0, 9, 1),
(17, 'mouse', 'apple mouse', '12', '2023-03-30 15:06:55', 'china', '', '1', 0, 1, 11, 1),
(19, 'assas', 'asasas', '1212', '2023-04-01 21:46:41', 'asda', '', '1', 0, 1, 10, 103),
(21, 'bike', 'BMW bike like new', '4000', '2023-03-30 15:36:13', 'india', '', '2', 0, 1, 10, 1),
(22, 'new ad', 'new', '12', '2023-04-01 21:46:38', 'egypt', '', '2', 0, 1, 9, 1),
(23, 'nokiaaa', 'new nokia phone', '123', '2023-04-02 07:16:32', 'egypt', '', '1', 0, 1, 21, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL COMMENT 'user name to login',
  `password` varchar(255) NOT NULL,
  `e_mail` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL COMMENT 'the local name in website',
  `group_id` int(11) NOT NULL DEFAULT 0 COMMENT 'identify user and admin',
  `trust_status` int(11) NOT NULL DEFAULT 0 COMMENT 'seller rank',
  `reg_status` int(11) NOT NULL DEFAULT 0 COMMENT 'user approve',
  `registerd_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `password`, `e_mail`, `full_name`, `group_id`, `trust_status`, `reg_status`, `registerd_date`) VALUES
(1, 'abdullah', '356a192b7913b04c54574d18c28d46e6395428ab', 'abdullah.sha3ban@yahoo.com', 'abdullah shaaban mahmoud', 1, 0, 1, '2023-03-22 15:04:35'),
(40, 'salah', '7b52009b64fd0a2a49e6d8a939753077792b0554', 'ahme@yahoo.com', 'ahmed mohamed', 0, 0, 1, '2023-04-17 15:41:36'),
(42, 'omar', '7b52009b64fd0a2a49e6d8a939753077792b0554', 'omar@yahoo.com', 'omar mostafa', 0, 0, 1, '2023-03-25 03:15:03'),
(47, 'osman', '123', 'khaled.omar@yahoo.com', 'osman omar', 0, 0, 0, '2023-03-25 15:11:31'),
(100, 'cola', '1', 'cola@yahoo.com', 'cola cola', 0, 0, 0, '2023-03-27 04:04:43'),
(101, 'toto', '356a192b7913b04c54574d18c28d46e6395428ab', 'tot@totooo.com', 'tototoooo', 0, 0, 0, '2023-03-27 04:08:17'),
(102, 'oop', '356a192b7913b04c54574d18c28d46e6395428ab', 'oop@yahoo.com', 'oop', 0, 0, 0, '2023-03-27 14:19:17'),
(103, 'boda', '356a192b7913b04c54574d18c28d46e6395428ab', 'abdullah@yahoo.com', 'bodaaaaa', 0, 0, 1, '2023-04-17 15:40:12'),
(104, 'bodaa', '86f7e437faa5a7fce15d1ddcb9eaeaea377667b8', 'abdullah@yahoo.com', 'aaa', 0, 0, 1, '2023-04-01 21:09:15'),
(105, 'bodaaaa', '356a192b7913b04c54574d18c28d46e6395428ab', 'abdullah@yahoo.com', 'assa', 0, 0, 1, '2023-04-01 21:09:10'),
(106, 'abo 3obd', '356a192b7913b04c54574d18c28d46e6395428ab', 'abdullah.123@yahoo.com', 'assa', 0, 0, 1, '2023-04-01 21:08:49');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`c_id`),
  ADD KEY `item_comments` (`item_id`),
  ADD KEY `comment_users` (`user_id`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `member_1` (`member_id`),
  ADD KEY `cat_1` (`cat_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_name` (`user_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comment_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `item_comments` FOREIGN KEY (`item_id`) REFERENCES `item` (`item_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `cat_1` FOREIGN KEY (`cat_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `member_1` FOREIGN KEY (`member_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
