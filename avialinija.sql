-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 28, 2022 at 09:13 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `avialinija`
--

-- --------------------------------------------------------

--
-- Table structure for table `airports`
--

CREATE TABLE `airports` (
  `id` int(11) NOT NULL,
  `country_iso` int(11) NOT NULL,
  `location` point NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `airports`
--

INSERT INTO `airports` (`id`, `country_iso`, `location`) VALUES
(1, 370, 0x0000000001010000002cba6eb3e07b4b406cfc147284123840),
(2, 370, 0x000000000101000000e74e7c6d67514b407bc522f014483940);

-- --------------------------------------------------------

--
-- Table structure for table `airports_avlines`
--

CREATE TABLE `airports_avlines` (
  `airport_id` int(11) NOT NULL,
  `avline_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `airports_avlines`
--

INSERT INTO `airports_avlines` (`airport_id`, `avline_id`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `avlines`
--

CREATE TABLE `avlines` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `country_iso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `avlines`
--

INSERT INTO `avlines` (`id`, `name`, `country_iso`) VALUES
(1, 'Ryanair', 370),
(2, 'British Airways', 44);

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `iso` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`iso`, `name`) VALUES
(44, 'United Kingdom'),
(49, 'Germany'),
(370, 'Lithuania');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `airports`
--
ALTER TABLE `airports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `avlines`
--
ALTER TABLE `avlines`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`iso`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `airports`
--
ALTER TABLE `airports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `avlines`
--
ALTER TABLE `avlines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
