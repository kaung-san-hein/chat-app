-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 25, 2019 at 04:03 PM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chat`
--

-- --------------------------------------------------------

--
-- Table structure for table `chat_message`
--

CREATE TABLE `chat_message` (
  `chat_message_id` int(11) NOT NULL,
  `to_user_id` int(11) NOT NULL,
  `from_user_id` int(11) NOT NULL,
  `chat_message` varchar(1000) COLLATE utf8mb4_bin NOT NULL,
  `status` varchar(5) COLLATE utf8mb4_bin NOT NULL,
  `timestamp` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `chat_message`
--

INSERT INTO `chat_message` (`chat_message_id`, `to_user_id`, `from_user_id`, `chat_message`, `status`, `timestamp`) VALUES
(1, 2, 1, 'Hi', '0', '2019-10-24 17:28:43'),
(2, 2, 1, 'Hello', '0', '2019-10-24 17:29:49'),
(3, 1, 2, 'Hi', '0', '2019-10-24 17:31:30'),
(4, 2, 1, 'how are you?', '0', '2019-10-24 17:34:51'),
(5, 1, 2, 'I\'m fine', '0', '2019-10-24 17:35:07'),
(6, 1, 2, 'and you', '0', '2019-10-24 17:35:51'),
(7, 2, 1, 'i\'fine too', '2', '2019-10-24 17:36:49'),
(8, 1, 2, 'what are you doing?', '2', '2019-10-24 17:38:47'),
(9, 1, 2, 'where?', '0', '2019-10-24 17:39:33'),
(10, 3, 1, 'hi bro', '0', '2019-10-24 21:10:23'),
(11, 3, 1, 'hello', '0', '2019-10-24 21:10:44'),
(12, 1, 3, 'hi', '0', '2019-10-24 21:11:08'),
(13, 1, 3, 'hello', '0', '2019-10-24 21:11:26'),
(14, 1, 3, 'Ha ha', '0', '2019-10-24 21:11:41'),
(15, 1, 3, 'yes', '0', '2019-10-24 21:12:12'),
(16, 1, 3, 'hi', '0', '2019-10-24 21:12:40'),
(17, 1, 3, 'bro', '0', '2019-10-24 21:12:57'),
(18, 3, 1, 'ha ha', '0', '2019-10-24 21:13:40'),
(19, 3, 1, 'yes sir', '0', '2019-10-24 21:14:08'),
(20, 1, 3, 'hi 😀😀', '0', '2019-10-25 00:10:03'),
(21, 1, 3, 'how are you?😇😇', '0', '2019-10-25 00:14:37'),
(22, 3, 1, '😃😃', '0', '2019-10-25 00:16:03'),
(23, 0, 1, '🤣🤣Hi friends', '1', '2019-10-25 10:38:33'),
(24, 0, 3, 'hello😋', '2', '2019-10-25 10:40:50'),
(25, 0, 2, 'Hi all my friends🍉🍉\n', '1', '2019-10-25 10:41:40'),
(26, 0, 1, '😝', '1', '2019-10-25 10:42:43'),
(27, 0, 2, '🍳', '1', '2019-10-25 10:45:28'),
(28, 0, 1, '<p><img src=\"upload/p2.png\" class=\"img-thumbnail\" width=\"200\" height=\"160\"></p>Hi', '2', '2019-10-25 11:29:47'),
(29, 0, 2, 'Nice pic<br>', '2', '2019-10-25 11:30:34'),
(30, 0, 2, '<p><img src=\"upload/p4.png\" class=\"img-thumbnail\" width=\"200\" height=\"160\"></p>Ok lar<br>', '1', '2019-10-25 12:29:27'),
(31, 3, 5, '😇', '0', '2019-10-25 12:38:49'),
(32, 2, 1, '😍😍', '0', '2019-10-25 12:48:21');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `user_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`user_id`, `username`, `password`) VALUES
(1, 'Kaung San Hein', '$2y$10$Ghk1poBqtogiDTc9IMgb9e4HwBwZPjwk7VqnLK.lrqhGYUyiA6iXO'),
(2, 'Yoon Wadi Phyo', '$2y$10$g1liZhpbETl/7amihJyqp.4N6tNN543JtLGC2l5g3wAir80NSUlRS'),
(3, 'Khant Maw Hein', '$2y$10$vW2sECGQNTAeiZJdTO7nAeErc7e9m.mnFWJ7d.PurZkJqGZJMsbMi'),
(5, 'Friend', '$2y$10$jasNj11J8FLTC3epiA3vfeyBAR.wm01X8X8geTtssAZNdhitLbII6');

-- --------------------------------------------------------

--
-- Table structure for table `login_details`
--

CREATE TABLE `login_details` (
  `login_details_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `last_activity` datetime NOT NULL,
  `is_type` enum('no','yes') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16;

--
-- Dumping data for table `login_details`
--

INSERT INTO `login_details` (`login_details_id`, `user_id`, `last_activity`, `is_type`) VALUES
(2, 1, '2019-10-11 13:33:47', 'yes'),
(3, 2, '2019-10-11 13:27:31', 'yes'),
(4, 2, '2019-10-11 13:33:55', 'yes'),
(5, 2, '2019-10-11 13:35:50', 'yes'),
(6, 1, '2019-10-11 13:41:22', 'yes'),
(7, 2, '2019-10-11 17:24:37', 'yes'),
(8, 1, '2019-10-11 19:54:20', 'yes'),
(9, 1, '2019-10-23 16:37:41', 'yes'),
(10, 1, '2019-10-23 20:28:48', 'yes'),
(11, 2, '2019-10-23 23:10:18', 'yes'),
(12, 1, '2019-10-23 23:10:39', 'yes'),
(13, 1, '2019-10-24 23:54:50', 'no'),
(14, 2, '2019-10-24 21:05:34', 'no'),
(15, 3, '2019-10-24 22:39:59', 'no'),
(16, 3, '2019-10-25 00:15:22', 'no'),
(17, 1, '2019-10-25 00:53:26', 'no'),
(18, 1, '2019-10-25 12:30:31', 'no'),
(19, 2, '2019-10-25 12:39:36', 'no'),
(20, 3, '2019-10-25 12:39:14', 'no'),
(21, 5, '2019-10-25 12:39:14', 'no'),
(22, 2, '2019-10-25 14:42:06', 'no'),
(23, 1, '2019-10-25 16:36:40', 'no');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chat_message`
--
ALTER TABLE `chat_message`
  ADD PRIMARY KEY (`chat_message_id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `login_details`
--
ALTER TABLE `login_details`
  ADD PRIMARY KEY (`login_details_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chat_message`
--
ALTER TABLE `chat_message`
  MODIFY `chat_message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `login_details`
--
ALTER TABLE `login_details`
  MODIFY `login_details_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
