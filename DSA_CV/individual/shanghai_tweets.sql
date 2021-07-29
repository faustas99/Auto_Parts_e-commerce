-- phpMyAdmin SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- Host: mysql5
-- Generation Time: Mar 06, 2020 at 02:39 PM
-- Server version: 10.1.44-MariaDB-0+deb9u1
-- PHP Version: 7.3.14-1~deb10u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fet18000990`
--

-- --------------------------------------------------------

--
-- Table structure for table `shanghai_tweets`
--

CREATE TABLE `shanghai_tweets` (
  `tweet_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `comment` varchar(280) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shanghai_tweets`
--

INSERT INTO `shanghai_tweets` (`tweet_id`, `username`, `comment`) VALUES
(1, 'r2-delriohall', 'test comment');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `shanghai_tweets`
--
ALTER TABLE `shanghai_tweets`
  ADD PRIMARY KEY (`tweet_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `shanghai_tweets`
--
ALTER TABLE `shanghai_tweets`
  MODIFY `tweet_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
