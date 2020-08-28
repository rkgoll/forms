-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 20, 2015 at 04:13 PM
-- Server version: 5.5.28
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `app`
--

-- --------------------------------------------------------

--
-- Table structure for table `inputinvestor`
--

CREATE TABLE IF NOT EXISTS `inputinvestor` (
  `email` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `portcapital` int(11) NOT NULL,
  `investedloans` varchar(250) NOT NULL,
  `investedamount` int(11) NOT NULL,
  `remaining` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `inputinvestor`
--

INSERT INTO `inputinvestor` (`email`, `password`, `portcapital`, `investedloans`, `investedamount`, `remaining`) VALUES
('llinvestor1@gmail.com\r\n', 'demo123	', 100000, 'loan-X1,loan-X2,loan-X3,loan-X4, loan-X5	', 37500, 62500),
('llinvestor1@gmail.com', 'demo123	\r\n', 50000, 'loan-X6	', 7500, 42500);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
