-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 14, 2024 at 10:28 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `elearningdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookmark`
--

CREATE TABLE `bookmark` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `playlist_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookmark`
--

INSERT INTO `bookmark` (`id`, `user_id`, `playlist_id`) VALUES
(4, 6, 5),
(5, 6, 6),
(6, 6, 7),
(7, 6, 5);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `content_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tutor_id` int(11) NOT NULL,
  `comment` varchar(500) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `content_id`, `user_id`, `tutor_id`, `comment`, `date`) VALUES
(6, 68, 6, 5, 'nicevideo', '2024-04-13');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(30) NOT NULL,
  `number` int(10) NOT NULL,
  `message` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `name`, `email`, `number`, `message`) VALUES
(1, 'Vikas Verma', 'vikas@gmail.com', 1234567890, 'nice website'),
(2, 'Vikas Verma', 'vikas@gmail.com', 1234567890, 'asas');

-- --------------------------------------------------------

--
-- Table structure for table `content`
--

CREATE TABLE `content` (
  `id` int(11) NOT NULL,
  `tutor_id` int(11) NOT NULL,
  `playlist_id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` varchar(300) NOT NULL,
  `video` varchar(50) NOT NULL,
  `thumb` varchar(50) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `content`
--

INSERT INTO `content` (`id`, `tutor_id`, `playlist_id`, `title`, `description`, `video`, `thumb`, `date`, `status`) VALUES
(3, 3, 6, 'java1', 'java1', 'nfnLOKVLoT5u6YJlBQAc.mp4', '482kY7ryV1Zo4KQgjGTP.png', '2024-04-01', 'active'),
(7, 2, 5, 'html2', 'html2', 'VlZjWxZkQIj25IjeNI0W.mp4', 'dwTuzbGkVh7Sd3sRBvkf.png', '2024-04-01', 'active'),
(8, 2, 5, 'html', 'html', '2MTkanI3FLPnaIopKVTD.mp4', 'VIO8l04UcFDjEhMgYiiM.png', '2024-04-01', 'active'),
(66, 3, 7, 'cpp1', 'cpp1', 'VXLjsxFMwx1IMYW526Rr.mp4', '5sauihAzB4BlzzLPLHdH.png', '2024-04-01', 'active'),
(67, 4, 8, 'Opps1', 'oops1', 'ZzEusudyKv1Io07ws1qL.mp4', 'xbG6FjqbC4ld8MhgCfCo.png', '2024-04-02', 'active'),
(68, 5, 48, 'php1', 'php1', '7dtiJYtTIuQeH5q3akVv.mp4', 'AXcyFIMbXM457GtI8MV5.png', '2024-04-13', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `user_id` int(11) NOT NULL,
  `tutor_id` int(11) NOT NULL,
  `content_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `card_no` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`id`, `user_id`, `card_no`) VALUES
(53, 6, 2147483647),
(54, 6, 1111),
(55, 6, 2147483647),
(56, 6, 2147483647),
(57, 6, 2147483647),
(58, 6, 1111),
(59, 6, 1111),
(60, 6, 1),
(61, 6, 111),
(62, 6, 2222),
(63, 6, 2222),
(64, 6, 2147483647),
(65, 6, 12),
(66, 6, 12),
(67, 6, 2147483647),
(68, 6, 2147483647),
(69, 6, 2147483647),
(70, 6, 2147483647),
(71, 6, 1),
(72, 6, 2147483647),
(73, 6, 2147483647),
(74, 6, 2147483647),
(75, 6, 2147483647),
(76, 6, 1),
(77, 6, 2147483647),
(78, 6, 2147483647),
(79, 6, 2147483647),
(80, 6, 2147483647),
(81, 6, 2147483647),
(82, 6, 2147483647),
(83, 6, 2147483647),
(84, 6, 2147483647),
(85, 6, 2147483647),
(86, 8, 2147483647);

-- --------------------------------------------------------

--
-- Table structure for table `playlist`
--

CREATE TABLE `playlist` (
  `id` int(11) NOT NULL,
  `tutor_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(500) NOT NULL,
  `thumb` varchar(200) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) NOT NULL,
  `premium` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `playlist`
--

INSERT INTO `playlist` (`id`, `tutor_id`, `title`, `description`, `thumb`, `date`, `status`, `premium`) VALUES
(5, 2, 'html', 'html', 'peDECM2jOh4N7o2fjJ4M.png', '2024-04-01', 'active', 'no'),
(6, 3, 'java', 'java', 'jBfESRNRSfUusIdVkela.png', '2024-04-01', 'active', 'yes'),
(7, 3, 'cpp', 'cpp', 'DCEUhW1k5VA3grryhzoA.png', '2024-04-01', 'active', 'yes'),
(8, 4, 'Opps', 'Opps', 'ZDvXWWp0VzHm2TGNCsM4.png', '2024-04-02', 'active', 'no'),
(48, 5, 'php', 'php', 'adxBFSN0MkB80fMGreje.png', '2024-04-13', 'active', 'yes'),
(49, 3, 'sql', 'sql', '73hRHbZwDOrAoFs2qOoR.png', '2024-04-14', 'active', ' yes');

-- --------------------------------------------------------

--
-- Table structure for table `tutors`
--

CREATE TABLE `tutors` (
  `id` int(10) NOT NULL,
  `name` varchar(30) NOT NULL,
  `profession` varchar(25) NOT NULL,
  `email` varchar(25) NOT NULL,
  `password` varchar(30) NOT NULL,
  `image` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tutors`
--

INSERT INTO `tutors` (`id`, `name`, `profession`, `email`, `password`, `image`) VALUES
(2, 'Tejas', ' teacher', 'tejas@gmail.com', 't', 'MI0EkTqyU9IduPagI1UL.jpg'),
(3, 'Vikas Verma', 'teacher', 'vk@gmail.com', 'vk', '3hW79acWBW0CglhJtSdI.jpg'),
(4, 'Kriti Verma', ' developer', 'kriti@gmail.com', 'kriti123', 'lX4LVHeV2P90BVAjiRjn.jpg'),
(5, 'pratham', ' teacher', 'pratham@gmail.com', 'pratham12', 'InNvl4SB69V7Ryb4vySt.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(25) NOT NULL,
  `email` varchar(25) NOT NULL,
  `password` varchar(255) NOT NULL,
  `image` varchar(25) NOT NULL,
  `premium` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `image`, `premium`) VALUES
(6, 'Vikas Verma', 'vikas@gmail.com', 'vv', 'ovG9ASMnxww9d3hwSio6.jpg', 1),
(8, 'Kriti Verma', 'kriti@gmail.com', 'kriti123', 'k6XowRgXzj6YpcY0iiKl.jpg', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookmark`
--
ALTER TABLE `bookmark`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `content`
--
ALTER TABLE `content`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `playlist`
--
ALTER TABLE `playlist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tutors`
--
ALTER TABLE `tutors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookmark`
--
ALTER TABLE `bookmark`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `content`
--
ALTER TABLE `content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `playlist`
--
ALTER TABLE `playlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `tutors`
--
ALTER TABLE `tutors`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
