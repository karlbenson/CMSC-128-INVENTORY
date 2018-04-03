-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 03, 2018 at 04:10 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 7.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chem_glasswares`
--

-- --------------------------------------------------------

--
-- Table structure for table `borrower`
--

CREATE TABLE `borrower` (
  `Borrower_Id` int(11) NOT NULL,
  `First_Name` varchar(256) NOT NULL,
  `Last_Name` varchar(256) NOT NULL,
  `Student_Number` varchar(20) NOT NULL,
  `Amt_of_transactions` int(11) NOT NULL,
  `Group_Id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `borrower`
--

INSERT INTO `borrower` (`Borrower_Id`, `First_Name`, `Last_Name`, `Student_Number`, `Amt_of_transactions`, `Group_Id`) VALUES
(1, 'Kiana Alessandra ', 'Villaera', '2014-15055', 1, 1),
(2, 'Karl Vinzon', 'Mabutas', '2015-12345', 1, 1),
(3, 'Bernadette', 'Genove', '2015-54321', 1, 2),
(4, 'Ralston Mark', 'Chan', '2015-78945', 1, 2),
(5, 'Karissa Isabel', 'Patriarca', '2016-52416', 0, 3),
(6, 'Paul', 'Kline', '2007-85246', 0, 3);

-- --------------------------------------------------------

--
-- Table structure for table `chemicals`
--

CREATE TABLE `chemicals` (
  `Chemical_Id` int(11) NOT NULL,
  `Name` varchar(256) NOT NULL,
  `Quantity_Available_ml` float DEFAULT NULL,
  `Quantity_Available_mg` float DEFAULT NULL,
  `Original_Amt` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chemicals`
--

INSERT INTO `chemicals` (`Chemical_Id`, `Name`, `Quantity_Available_ml`, `Quantity_Available_mg`, `Original_Amt`) VALUES
(26, 'Good stuff ', NULL, 10.2, 50),
(27, 'Air Force Liquiblunt', 5.4, NULL, 20.12),
(28, 'We Stan Good Fumes', NULL, 14.2, 14.2),
(29, 'Unstan Milktea', 74.53, NULL, 74.53);

-- --------------------------------------------------------

--
-- Table structure for table `glasswares`
--

CREATE TABLE `glasswares` (
  `Glassware_Id` int(11) NOT NULL,
  `Name` varchar(256) NOT NULL,
  `Quantity_Available` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `glasswares`
--

INSERT INTO `glasswares` (`Glassware_Id`, `Name`, `Quantity_Available`) VALUES
(1, 'Bong Pok Marcos', 0),
(2, 'Angel''s Burger MayoChup Tarpaulin', 10),
(3, 'Lofi Stereo', 2);

-- --------------------------------------------------------

--
-- Table structure for table `group_table`
--

CREATE TABLE `group_table` (
  `Group_Id` int(11) NOT NULL,
  `Professor` varchar(256) NOT NULL,
  `Subject` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `group_table`
--

INSERT INTO `group_table` (`Group_Id`, `Professor`, `Subject`) VALUES
(1, 'Sir Lee Javellana', 'Cmsc 125'),
(2, 'Ma''am Ashlyn Balangcod', 'Cmsc 128'),
(3, 'Sir Martin Roy Nabus', 'Cmsc 130');

-- --------------------------------------------------------

--
-- Table structure for table `page_permissions`
--

CREATE TABLE `page_permissions` (
  `User_Id` int(11) NOT NULL,
  `Page_Name` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `Staff_Id` int(11) NOT NULL,
  `First_Name` varchar(256) NOT NULL,
  `Last_Name` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`Staff_Id`, `First_Name`, `Last_Name`) VALUES
(1, 'Kiana Alessandra', 'V. Villaera');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `Trans_Id` int(11) NOT NULL,
  `Glassware_Id` int(11) DEFAULT NULL,
  `Chemical_Id` int(11) DEFAULT NULL,
  `Group_Id` int(11) NOT NULL,
  `Qty_Borrowed_Glasswares` int(11) NOT NULL,
  `Qty_Borrowed_Chemicals_ml` float NOT NULL,
  `Qty_Borrowed_Chemicals_mg` float NOT NULL,
  `Date_Borrowed` date NOT NULL,
  `Date_Returned` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`Trans_Id`, `Glassware_Id`, `Chemical_Id`, `Group_Id`, `Qty_Borrowed_Glasswares`, `Qty_Borrowed_Chemicals_ml`, `Qty_Borrowed_Chemicals_mg`, `Date_Borrowed`, `Date_Returned`) VALUES
(1, 1, NULL, 1, 4, 0, 0, '2018-04-01', NULL),
(2, 2, NULL, 2, 1, 0, 0, '2018-03-19', '2018-03-21'),
(3, NULL, 26, 3, 0, 0, 5.2, '2018-02-14', NULL),
(4, 2, NULL, 1, 3, 0, 0, '2018-04-16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_accounts`
--

CREATE TABLE `user_accounts` (
  `User_Id` int(11) NOT NULL,
  `Staff_Id` int(11) NOT NULL,
  `Username` varchar(256) NOT NULL,
  `Password` varchar(256) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_accounts`
--

INSERT INTO `user_accounts` (`User_Id`, `Staff_Id`, `Username`, `Password`, `status`) VALUES
(1, 1, 'admin', '$2y$10$TXqiyhSKm/2zWJT843WsaurTzjpxrvQ5vNq/VCnLj8QLasfE.KWWu', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `borrower`
--
ALTER TABLE `borrower`
  ADD PRIMARY KEY (`Borrower_Id`),
  ADD KEY `Group_Id` (`Group_Id`);

--
-- Indexes for table `chemicals`
--
ALTER TABLE `chemicals`
  ADD PRIMARY KEY (`Chemical_Id`);

--
-- Indexes for table `glasswares`
--
ALTER TABLE `glasswares`
  ADD PRIMARY KEY (`Glassware_Id`);

--
-- Indexes for table `group_table`
--
ALTER TABLE `group_table`
  ADD PRIMARY KEY (`Group_Id`);

--
-- Indexes for table `page_permissions`
--
ALTER TABLE `page_permissions`
  ADD KEY `User_Id` (`User_Id`),
  ADD KEY `Page_Name` (`Page_Name`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`Staff_Id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`Trans_Id`),
  ADD KEY `Glassware_Id` (`Glassware_Id`),
  ADD KEY `Chemical_Id` (`Chemical_Id`),
  ADD KEY `Group_Id` (`Group_Id`);

--
-- Indexes for table `user_accounts`
--
ALTER TABLE `user_accounts`
  ADD PRIMARY KEY (`User_Id`),
  ADD KEY `Staff_Id` (`Staff_Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `borrower`
--
ALTER TABLE `borrower`
  MODIFY `Borrower_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `chemicals`
--
ALTER TABLE `chemicals`
  MODIFY `Chemical_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `glasswares`
--
ALTER TABLE `glasswares`
  MODIFY `Glassware_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `group_table`
--
ALTER TABLE `group_table`
  MODIFY `Group_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `Staff_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `Trans_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `user_accounts`
--
ALTER TABLE `user_accounts`
  MODIFY `User_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `borrower`
--
ALTER TABLE `borrower`
  ADD CONSTRAINT `borrower_ibfk_1` FOREIGN KEY (`Group_Id`) REFERENCES `group_table` (`Group_Id`) ON UPDATE CASCADE;

--
-- Constraints for table `page_permissions`
--
ALTER TABLE `page_permissions`
  ADD CONSTRAINT `page_permissions_ibfk_1` FOREIGN KEY (`User_Id`) REFERENCES `user_accounts` (`User_Id`) ON UPDATE CASCADE;

--
-- Constraints for table `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`Glassware_Id`) REFERENCES `glasswares` (`Glassware_Id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `transaction_ibfk_2` FOREIGN KEY (`Chemical_Id`) REFERENCES `chemicals` (`Chemical_Id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `transaction_ibfk_3` FOREIGN KEY (`Group_Id`) REFERENCES `group_table` (`Group_Id`) ON UPDATE CASCADE;

--
-- Constraints for table `user_accounts`
--
ALTER TABLE `user_accounts`
  ADD CONSTRAINT `user_accounts_ibfk_1` FOREIGN KEY (`Staff_Id`) REFERENCES `staff` (`Staff_Id`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
