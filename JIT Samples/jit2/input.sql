-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 13, 2015 at 05:20 PM
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
-- Table structure for table `input`
--

CREATE TABLE IF NOT EXISTS `input` (
  `user` int(11) NOT NULL,
  `Approve/Decline` varchar(250) NOT NULL,
  `LoanID` int(11) NOT NULL,
  `signin` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `name` varchar(250) NOT NULL,
  `lastname` varchar(250) NOT NULL,
  `homeaddress` varchar(250) NOT NULL,
  `city` varchar(250) NOT NULL,
  `state` varchar(250) NOT NULL,
  `zipCode` int(11) NOT NULL,
  `homephone` varchar(250) NOT NULL,
  `secondaryphone` varchar(250) NOT NULL,
  `dob` date NOT NULL,
  `annualincome` int(11) NOT NULL,
  `ssn` int(11) NOT NULL,
  UNIQUE KEY `signin` (`signin`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `input`
--

INSERT INTO `input` (`user`, `Approve/Decline`, `LoanID`, `signin`, `password`, `name`, `lastname`, `homeaddress`, `city`, `state`, `zipCode`, `homephone`, `secondaryphone`, `dob`, `annualincome`, `ssn`) VALUES
(1, 'Approve', 1, 'lluser1@gmail.com', 'demo123', 'Raj', 'Demo', 'Demo Address', 'Atlanta', 'GA', 30329, '(000)000-0001', '(000)000-0001', '1981-03-13', 60000, 1111111111);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
