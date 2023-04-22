-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 22, 2023 at 05:54 PM
-- Server version: 5.7.36
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `car_dealership`
--

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

DROP TABLE IF EXISTS `brands`;
CREATE TABLE IF NOT EXISTS `brands` (
  `BrandID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` text NOT NULL,
  `Country` text NOT NULL,
  PRIMARY KEY (`BrandID`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`BrandID`, `Name`, `Country`) VALUES
(10, 'BMW', 'Germany'),
(11, 'Tesla', 'USA'),
(12, 'volvo', ' ');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

DROP TABLE IF EXISTS `clients`;
CREATE TABLE IF NOT EXISTS `clients` (
  `ClientID` int(11) NOT NULL,
  `FirstName` text NOT NULL,
  `LastName` text NOT NULL,
  `Address` text NOT NULL,
  `Phone` text NOT NULL,
  `Email` text NOT NULL,
  `Notes` longtext NOT NULL,
  PRIMARY KEY (`ClientID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`ClientID`, `FirstName`, `LastName`, `Address`, `Phone`, `Email`, `Notes`) VALUES
(100, 'ameer', 'qalalweh', 'Ramallah', '012010203', 'omarqalasd@xsa.xo', 'no'),
(123, 'cads', 'adsf', 'dakmsf', '13214', 'omarqalawelnkh@gmail.com', 'pkdapfs'),
(12398, 'cads', 'adsf', 'dakmsf', '13214', 'omarqalawelnkh@gmail.com', 'pkdapfs'),
(56656, 'omar', 'qalalweh', 'gfhgfg', '12345', 'omar@sdsa.com', 'ghvfhgvfhg');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

DROP TABLE IF EXISTS `employee`;
CREATE TABLE IF NOT EXISTS `employee` (
  `EmpID` int(11) NOT NULL,
  `FirstName` text NOT NULL,
  `LastName` text NOT NULL,
  `dob` date NOT NULL,
  `Address` text NOT NULL,
  `Phone` text NOT NULL,
  `Email` text NOT NULL,
  `Notes` longtext NOT NULL,
  PRIMARY KEY (`EmpID`),
  UNIQUE KEY `EmpID` (`EmpID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`EmpID`, `FirstName`, `LastName`, `dob`, `Address`, `Phone`, `Email`, `Notes`) VALUES
(11, 'omar', 'qalalweh', '2006-05-11', 'Ramallah', '243', 'omarqalaweh@gmail.com', 'wer'),
(123, 'soso', 'momo', '2015-06-13', 'pokp', '2121221', '123@123.com', 'kmkl');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

DROP TABLE IF EXISTS `expenses`;
CREATE TABLE IF NOT EXISTS `expenses` (
  `ExpenseID` int(11) NOT NULL AUTO_INCREMENT,
  `VehicleID` int(11) NOT NULL,
  `Date` text NOT NULL,
  `Description` text NOT NULL,
  `Amount` double NOT NULL,
  `Notes` longtext NOT NULL,
  PRIMARY KEY (`ExpenseID`),
  KEY `fk_Vehicle_ID` (`VehicleID`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`ExpenseID`, `VehicleID`, `Date`, `Description`, `Amount`, `Notes`) VALUES
(12, 1007, '2022-06-12 17:21:07', 'broken', 1000, 'ds');

-- --------------------------------------------------------

--
-- Table structure for table `models`
--

DROP TABLE IF EXISTS `models`;
CREATE TABLE IF NOT EXISTS `models` (
  `ModelID` int(11) NOT NULL AUTO_INCREMENT,
  `BrandID` int(11) NOT NULL,
  `Name` text NOT NULL,
  PRIMARY KEY (`ModelID`),
  KEY `fk_BrandID_1` (`BrandID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `models`
--

INSERT INTO `models` (`ModelID`, `BrandID`, `Name`) VALUES
(1, 10, 'x5'),
(2, 12, 'xx'),
(3, 10, 'x6');

-- --------------------------------------------------------

--
-- Table structure for table `other_emp`
--

DROP TABLE IF EXISTS `other_emp`;
CREATE TABLE IF NOT EXISTS `other_emp` (
  `EmpID` int(11) NOT NULL,
  `salary` double NOT NULL,
  PRIMARY KEY (`EmpID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

DROP TABLE IF EXISTS `payment_methods`;
CREATE TABLE IF NOT EXISTS `payment_methods` (
  `pm_id` int(11) NOT NULL,
  `Name` text NOT NULL,
  `First_Amount_Percent` int(11) NOT NULL,
  `Percent_Per_Month` int(11) NOT NULL,
  PRIMARY KEY (`pm_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payment_methods`
--

INSERT INTO `payment_methods` (`pm_id`, `Name`, `First_Amount_Percent`, `Percent_Per_Month`) VALUES
(1, 'Cash', 100, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

DROP TABLE IF EXISTS `sales`;
CREATE TABLE IF NOT EXISTS `sales` (
  `sales_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Client_ID` int(11) NOT NULL,
  `Vehicle_ID` int(11) NOT NULL,
  `emp_id` int(11) DEFAULT NULL,
  `pm_id` int(11) NOT NULL,
  `date_of_purchase` text NOT NULL,
  `final_price` double NOT NULL,
  PRIMARY KEY (`sales_ID`),
  KEY `fk_Client_Id_1` (`Client_ID`),
  KEY `fk_VehicleID_2` (`Vehicle_ID`),
  KEY `fk_pm_id_2` (`pm_id`),
  KEY `fk_emp_id_11` (`emp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`sales_ID`, `Client_ID`, `Vehicle_ID`, `emp_id`, `pm_id`, `date_of_purchase`, `final_price`) VALUES
(6, 56656, 1007, 11, 1, '2022-06-14 12:02:21', 200000);

-- --------------------------------------------------------

--
-- Table structure for table `sales_employee`
--

DROP TABLE IF EXISTS `sales_employee`;
CREATE TABLE IF NOT EXISTS `sales_employee` (
  `EmpID` int(11) NOT NULL,
  `salary` double NOT NULL,
  `Bonus_Per_Sale` int(11) NOT NULL,
  PRIMARY KEY (`EmpID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sales_employee`
--

INSERT INTO `sales_employee` (`EmpID`, `salary`, `Bonus_Per_Sale`) VALUES
(123, 12, 10);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
CREATE TABLE IF NOT EXISTS `transactions` (
  `TransID` int(11) NOT NULL AUTO_INCREMENT,
  `sale_ID` int(11) NOT NULL,
  `amount` double NOT NULL,
  `date_of_payment` date NOT NULL,
  PRIMARY KEY (`TransID`),
  KEY `fk_sale_id_sales` (`sale_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=123463 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`TransID`, `sale_ID`, `amount`, `date_of_payment`) VALUES
(123461, 6, 100000, '2022-06-14'),
(123462, 6, 100000, '2022-06-14');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `UserID` int(11) NOT NULL AUTO_INCREMENT,
  `EmpID` int(11) NOT NULL,
  `email_for_web` text NOT NULL,
  `password` text NOT NULL,
  `isAdmin` tinyint(1) NOT NULL,
  PRIMARY KEY (`UserID`),
  KEY `fk_emp_user` (`EmpID`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `EmpID`, `email_for_web`, `password`, `isAdmin`) VALUES
(23, 11, 'omarqalaweh@gmail.com', '$2y$10$34lBwOgrCJHyv8X6OaQKd.COjBfARQWqz65bosCqeVrJWNsjPor0u', 1),
(30, 123, '123@123.com', '$2y$10$aLa57s4Lr52Mjz/UI3.H5OAbofhaPSkcuynRu4wfVHRbsY58p6c3y', 0);

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

DROP TABLE IF EXISTS `vehicles`;
CREATE TABLE IF NOT EXISTS `vehicles` (
  `VehicleID` int(11) NOT NULL AUTO_INCREMENT,
  `KeyNo` text NOT NULL,
  `Type` text NOT NULL COMMENT 'New  | Used',
  `ModelID` int(11) NOT NULL,
  `Transmission` text NOT NULL,
  `Year` int(11) NOT NULL,
  `KM` int(11) NOT NULL,
  `Fuel` text NOT NULL,
  `CC` int(11) NOT NULL,
  `Color` text NOT NULL,
  `Warranty` int(11) NOT NULL,
  `Chassis` text NOT NULL,
  `Buying_Price` double NOT NULL,
  `Export_Price` double NOT NULL,
  `Selling_Price` double NOT NULL,
  `Features` longtext NOT NULL,
  `date_added` date NOT NULL,
  PRIMARY KEY (`VehicleID`),
  KEY `fk_ModelID_1` (`ModelID`)
) ENGINE=InnoDB AUTO_INCREMENT=1008 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`VehicleID`, `KeyNo`, `Type`, `ModelID`, `Transmission`, `Year`, `KM`, `Fuel`, `CC`, `Color`, `Warranty`, `Chassis`, `Buying_Price`, `Export_Price`, `Selling_Price`, `Features`, `date_added`) VALUES
(1007, '2332', 'new', 1, 'automatic', 2002, 3000, 'hybrid', 1000, 'black', 23, 'suv', 10000, 221, 200000, 'kjlk', '2022-06-12');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `fk_Vehicle_ID` FOREIGN KEY (`VehicleID`) REFERENCES `vehicles` (`VehicleID`) ON DELETE CASCADE;

--
-- Constraints for table `models`
--
ALTER TABLE `models`
  ADD CONSTRAINT `fk_BrandID_1` FOREIGN KEY (`BrandID`) REFERENCES `brands` (`BrandID`) ON DELETE CASCADE;

--
-- Constraints for table `other_emp`
--
ALTER TABLE `other_emp`
  ADD CONSTRAINT `fk_emp_id_oe` FOREIGN KEY (`EmpID`) REFERENCES `employee` (`EmpID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `fk_Client_Id_1` FOREIGN KEY (`Client_ID`) REFERENCES `clients` (`ClientID`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_VehicleID_2` FOREIGN KEY (`Vehicle_ID`) REFERENCES `vehicles` (`VehicleID`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_emp_id_11` FOREIGN KEY (`emp_id`) REFERENCES `employee` (`EmpID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pm_id_2` FOREIGN KEY (`pm_id`) REFERENCES `payment_methods` (`pm_id`) ON DELETE CASCADE;

--
-- Constraints for table `sales_employee`
--
ALTER TABLE `sales_employee`
  ADD CONSTRAINT `fk_emp_id_se` FOREIGN KEY (`EmpID`) REFERENCES `employee` (`EmpID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `fk_sale_id_sales` FOREIGN KEY (`sale_ID`) REFERENCES `sales` (`sales_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_emp_user` FOREIGN KEY (`EmpID`) REFERENCES `employee` (`EmpID`) ON DELETE CASCADE;

--
-- Constraints for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD CONSTRAINT `fk_ModelID_1` FOREIGN KEY (`ModelID`) REFERENCES `models` (`ModelID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
