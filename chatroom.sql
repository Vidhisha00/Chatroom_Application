-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 22, 2023 at 09:05 AM
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
-- Database: `chatroom`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(1000) NOT NULL,
  `code` varchar(255) NOT NULL,
  `status` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`username`, `password`, `email`, `code`, `status`) VALUES
('jinay', 'abcd@@11', '', '', 0),
('jinaybest', 'jinay@123', '', '', 0),
('jinayss', 'jinay#shah1', '', '', 0),
('jinayyyyyy', 'jinayshah@1', 'jinay1619@gmail.com', 'a30a0a6b831a1bee6dbc937cab329d74', 1),
('priya', 'priya@fut420', '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `bart`
--

CREATE TABLE `bart` (
  `id` int(11) NOT NULL,
  `sender_name` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `sent_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bart`
--

INSERT INTO `bart` (`id`, `sender_name`, `message`, `sent_at`) VALUES
(1, 'jinaybest', 'heyyy', '2023-04-21 17:11:14');

-- --------------------------------------------------------

--
-- Table structure for table `profile pictures`
--

CREATE TABLE `profile pictures` (
  `username` varchar(20) NOT NULL,
  `profilepic` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profile pictures`
--

INSERT INTO `profile pictures` (`username`, `profilepic`) VALUES
('jinay', 0x75706c6f6164732f36343432336235336536376137382e35303632373737332e706e67),
('jinay11', 0x75706c6f6164732f64656661756c742e6a706567),
('jinaybest', 0x75706c6f6164732f64656661756c742e6a706567),
('jinayok', 0x75706c6f6164732f64656661756c742e6a706567),
('jinayss', 0x75706c6f6164732f36343432623338333733353864342e35303335373531302e6a706567),
('jinayyyy', 0x75706c6f6164732f64656661756c742e6a706567),
('jinayyyyyy', 0x75706c6f6164732f64656661756c742e6a706567),
('priya', 0x75706c6f6164732f64656661756c742e6a706567),
('_jinay_09', 0x75706c6f6164732f64656661756c742e6a706567);

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `roomcode` varchar(4) NOT NULL,
  `roomname` varchar(20) NOT NULL,
  `admin` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`roomcode`, `roomname`, `admin`) VALUES
('bart', '', 'jinaybest');

-- --------------------------------------------------------

--
-- Table structure for table `user_room`
--

CREATE TABLE `user_room` (
  `user` varchar(255) NOT NULL,
  `room` varchar(20) NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT current_timestamp(),
  `status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_room`
--

INSERT INTO `user_room` (`user`, `room`, `timestamp`, `status`) VALUES
('jinaybest', 'bart', '2023-04-21 22:41:04', 0),
('jinayss', 'bart', '2023-04-21 22:41:59', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `bart`
--
ALTER TABLE `bart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `profile pictures`
--
ALTER TABLE `profile pictures`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`roomcode`);

--
-- Indexes for table `user_room`
--
ALTER TABLE `user_room`
  ADD PRIMARY KEY (`user`,`room`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bart`
--
ALTER TABLE `bart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
