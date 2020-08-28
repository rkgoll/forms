-- phpMyAdmin SQL Dump
-- version 4.3.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 06, 2015 at 06:21 PM
-- Server version: 5.6.22
-- PHP Version: 5.5.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `lendlift_riskmodel`
--

-- --------------------------------------------------------

--
-- Table structure for table `TABLE 2`
--

CREATE TABLE IF NOT EXISTS `TABLE 2` (
  `Band` int(2) DEFAULT NULL,
  `Loan Amount` varchar(6) DEFAULT NULL,
  `Term` int(2) DEFAULT NULL,
  `Orig Fee` varchar(5) DEFAULT NULL,
  `Svc Fee` varchar(5) DEFAULT NULL,
  `New Rate` varchar(6) DEFAULT NULL,
  `Effective Rate` varchar(6) DEFAULT NULL,
  `Payment` varchar(4) DEFAULT NULL,
  `Reward Rdmpt` varchar(5) DEFAULT NULL,
  `Curr Rate` varchar(3) DEFAULT NULL,
  `ROI` varchar(3) DEFAULT NULL,
  `Ann. Yield` varchar(5) DEFAULT NULL,
  `Net Ann after Rewards` varchar(5) DEFAULT NULL,
  `VaRImp` varchar(6) DEFAULT NULL,
  `CurrMinPay` varchar(4) DEFAULT NULL,
  `TimetoPayoff` int(2) DEFAULT NULL,
  `DeltaMinPayment` varchar(7) DEFAULT NULL,
  `PercentDeltaMinPayment` varchar(3) DEFAULT NULL,
  `TPCreditCard` varchar(7) DEFAULT NULL,
  `TPLendlift` varchar(7) DEFAULT NULL,
  `Tsavings` varchar(6) DEFAULT NULL,
  `PS` varchar(6) DEFAULT NULL,
  `BaseRate` varchar(2) DEFAULT NULL,
  `AdjforRisk` varchar(3) DEFAULT NULL,
  `UnsuccessfulFee` varchar(3) DEFAULT NULL,
  `LateFee` varchar(3) DEFAULT NULL,
  `CheckProcessingFee` varchar(3) DEFAULT NULL,
  `Collection60` varchar(3) DEFAULT NULL,
  `ProcessingFee` varchar(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `TABLE 2`
--

INSERT INTO `TABLE 2` (`Band`, `Loan Amount`, `Term`, `Orig Fee`, `Svc Fee`, `New Rate`, `Effective Rate`, `Payment`, `Reward Rdmpt`, `Curr Rate`, `ROI`, `Ann. Yield`, `Net Ann after Rewards`, `VaRImp`, `CurrMinPay`, `TimetoPayoff`, `DeltaMinPayment`, `PercentDeltaMinPayment`, `TPCreditCard`, `TPLendlift`, `Tsavings`, `PS`, `BaseRate`, `AdjforRisk`, `UnsuccessfulFee`, `LateFee`, `CheckProcessingFee`, `Collection60`, `ProcessingFee`) VALUES
(0, '$9,643', 37, '7.40%', '2.50%', '15.00%', '20.10%', '$355', '1.00%', '25%', '25%', '8.30%', '7.70%', '4.10%', '$225', 58, '$65.34', '18%', '$16,703', '$12,977', '$3,726', '22.30%', '5%', '10%', '$15', '$25', '$15', '30%', '1%'),
(1, '$7,500', 38, '7.50%', '2.50%', '15.00%', '20.00%', '$268', '1.00%', '25%', '25%', '8.30%', '7.70%', '4.10%', '$225', 58, '$42.83', '16%', '$12,991', '$10,178', '$2,814', '21.66%', '5%', '10%', '$15', '$25', '$15', '30%', '1%'),
(2, '$7,500', 38, '7.50%', '2.50%', '15.00%', '20.00%', '$268', '1.00%', '25%', '25%', '8.30%', '7.70%', '4.10%', '$225', 58, '$42.83', '16%', '$12,991', '$10,178', '$2,814', '21.66%', '5%', '10%', '$15', '$25', '$15', '30%', '1%'),
(3, '$7,500', 38, '7.50%', '2.90%', '15.00%', '20.00%', '$269', '1.00%', '25%', '25%', '8.30%', '7.20%', '5.00%', '$225', 58, '$44.34', '16%', '$12,991', '$10,163', '$2,829', '27.83%', '5%', '10%', '$15', '$25', '$15', '30%', '1%'),
(4, '$7,500', 36, '7.50%', '5.20%', '15.00%', '20.20%', '$279', '1.00%', '25%', '25%', '8.30%', '3.00%', '12.20%', '$225', 58, '$54.49', '19%', '$12,991', '$10,062', '$2,930', '22.55%', '5%', '10%', '$15', '$25', '$15', '30%', '1%'),
(5, '$7,500', 36, '7.50%', '3.90%', '15.00%', '20.20%', '$279', '1.00%', '25%', '25%', '8.30%', '3.00%', '12.20%', '$225', 58, '$54.49', '19%', '$12,991', '$10,062', '$2,930', '22.55%', '5%', '10%', '$15', '$25', '$15', '30%', '1%'),
(6, '$7,500', 35, '7.50%', '2.70%', '15.00%', '20.20%', '$279', '1.00%', '25%', '25%', '8.30%', '3.40%', '11.40%', '$225', 58, '$54.49', '19%', '$12,991', '$10,062', '$2,930', '22.55%', '5%', '10%', '$15', '$25', '$15', '30%', '1%'),
(7, '$7,500', 36, '7.50%', '2.50%', '15.00%', '20.20%', '$279', '1.00%', '25%', '25%', '8.30%', '3.00%', '12.20%', '$225', 58, '$54.49', '19%', '$12,991', '$10,062', '$2,930', '22.55%', '5%', '10%', '$15', '$25', '$15', '30%', '1%'),
(8, '$7,500', 36, '7.50%', '2.50%', '15.00%', '20.20%', '$279', '1.40%', '25%', '25%', '8.30%', '3.30%', '11.30%', '$225', 58, '$54.49', '19%', '$12,991', '$10,062', '$2,930', '22.55%', '5%', '10%', '$15', '$25', '$15', '30%', '1%'),
(9, '$7,500', 35, '7.60%', '2.20%', '15.00%', '20.50%', '$290', '1.00%', '25%', '25%', '8.30%', '4.90%', '8.90%', '$225', 58, '$64.59', '22%', '$12,991', '$9,996', '$2,996', '23.06%', '5%', '10%', '$15', '$25', '$15', '30%', '1%'),
(10, '$7,500', 23, '8.60%', '2.50%', '15.00%', '24.80%', '$475', '1.00%', '25%', '25%', '8.30%', '7.70%', '4.10%', '$225', 58, '$250.12', '46%', '$12,991', '$9,458', '$3,533', '27.19%', '5%', '10%', '$15', '$25', '$15', '30%', '1%'),
(11, '$7,448', 36, '7.50%', '2.50%', '24.80%', '30.40%', '$317', '1.00%', '25%', '25%', '8.30%', '8.00%', '4.10%', '$225', 58, '$94.58', '30%', '$12,991', '$11,420', '$1,435', '11.04%', '5%', '10%', '$15', '$25', '$15', '30%', '1%');

-- --------------------------------------------------------

--
-- Table structure for table `UserInput`
--

CREATE TABLE IF NOT EXISTS `UserInput` (
  `Loan Amount` int(5) DEFAULT NULL,
  `Credit Score` int(3) DEFAULT NULL,
  `Revolving Line Utilization` varchar(3) DEFAULT NULL,
  `Inquiries in last 6 months` int(1) DEFAULT NULL,
  `Months since last Delinquency` int(4) DEFAULT NULL,
  `Comp. Grade Score` int(4) DEFAULT NULL,
  `LL Comp Bands(p)` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `UserInput`
--

INSERT INTO `UserInput` (`Loan Amount`, `Credit Score`, `Revolving Line Utilization`, `Inquiries in last 6 months`, `Months since last Delinquency`, `Comp. Grade Score`, `LL Comp Bands(p)`) VALUES
(7500, 660, '52%', 0, 28, 1350, 4),
(5000, 800, '1%', 0, 1, 3350, 9),
(5000, 740, '19%', 0, 1, 3150, 7),
(8500, 690, '27%', 1, 9, 2450, 4),
(2500, 760, '13%', 0, 1, 3150, 8),
(5000, 755, '23%', 0, 1, 2950, 8),
(5000, 785, '1%', 0, 1, 3350, 9),
(5000, 670, '16%', 3, 1, 2150, 3),
(5000, 705, '49%', 1, 1, 2550, 5),
(5000, 715, '39%', 1, 1, 2750, 6),
(5000, 740, '26%', 0, 1, 3150, 7),
(5000, 775, '17%', 0, 1, 3350, 9),
(3000, 750, '8%', 1, 1, 2950, 7),
(3000, 675, '0%', 0, 78, 2450, 4),
(5000, 700, '47%', 0, 1, 2150, 6),
(5300, 795, '14%', 0, 1, 3050, 9),
(5400, 760, '17%', 0, 1, 3250, 8),
(5100, 770, '24%', 0, 1, 3050, 8),
(5000, 720, '38%', 0, 1, 2850, 6),
(10000, 710, '54%', 0, 1, 2450, 6),
(25000, 760, '23%', 0, 1, 2350, 6),
(5000, 770, '7%', 0, 1, 3350, 8),
(5000, 775, '20%', 0, 1, 3350, 9),
(3500, 710, '41%', 1, 1, 2550, 6),
(5000, 710, '37%', 0, 9, 2850, 6),
(2700, 660, '92%', 1, 1, 650, 4),
(12250, 745, '8%', 2, 78, 2350, 6),
(1200, 660, '76%', 2, 134, 2050, 4),
(20000, 680, '74%', 0, 1, 1450, 3),
(12000, 680, '93%', 3, 6848, 1750, 4),
(6400, 710, '69%', 0, 1, 2650, 6),
(5000, 780, '0%', 1, 1, 3350, 8),
(12000, 680, '72%', 0, 4, 1950, 4),
(5000, 770, '14%', 2, 1, 3350, 8),
(5750, 790, '10%', 0, 1, 3350, 9),
(3500, 680, '32%', 0, 1, 2450, 5),
(3000, 665, '71%', 2, 1, 1950, 4),
(3500, 750, '6%', 0, 48, 3150, 8),
(1000, 685, '37%', 1, 1, 2350, 5),
(3500, 700, '21%', 0, 9, 2550, 6),
(5000, 770, '14%', 0, 1, 3350, 8),
(5000, 710, '40%', 0, 476, 2650, 6),
(10000, 705, '66%', 0, 760, 1350, 5),
(5000, 750, '2%', 1, 949, 3250, 7),
(5000, 800, '1%', 0, 1, 3350, 9),
(7500, 755, '24%', 4, 1, 3150, 7),
(8000, 720, '48%', 3, 1, 2550, 5),
(6500, 675, '75%', 0, 1, 950, 5),
(2500, 770, '4%', 3, 1, 2650, 8),
(2500, 680, '35%', 1, 1, 1650, 5),
(15450, 710, '34%', 3, 1554, 2150, 4);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
