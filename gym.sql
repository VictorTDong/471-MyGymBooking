-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 17, 2022 at 03:25 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gym`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `Username` varchar(200) NOT NULL,
  `FirstName` varchar(200) NOT NULL,
  `LastName` varchar(20) NOT NULL,
  `Startdate` date NOT NULL DEFAULT current_timestamp(),
  `AccountType` int(5) NOT NULL,
  `VaccinationStatus` int(5) NOT NULL,
  `BirthDate` date NOT NULL,
  `Certification` varchar(200) DEFAULT NULL,
  `SSN` int(10) NOT NULL,
  `Password` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`Username`, `FirstName`, `LastName`, `Startdate`, `AccountType`, `VaccinationStatus`, `BirthDate`, `Certification`, `SSN`, `Password`) VALUES
('trainer1', 'Victor', 'Bill', '2022-04-14', 1, 1, '1990-04-12', 'CPR', 123, 'password'),
('janitor1', 'Brendan', 'Bob', '2022-04-14', 2, 1, '2005-04-12', 'CPR', 321, 'password'),
('client2', 'Kevin', 'Cool', '2022-04-14', 0, 1, '2022-04-12', '', 654, 'password'),
('manager1', 'Samantha', 'House', '2022-04-14', 3, 1, '2001-04-12', 'CPR', 741, 'password'),
('client1', 'Anthony', 'Pit', '2022-04-14', 0, 0, '0200-04-12', '', 789, 'password'),
('client3', 'Deane', 'Gale', '2022-04-14', 0, 0, '1999-12-25', '', 856, 'password'),
('client4', 'Kim', 'Possible', '2022-04-16', 0, 1, '2005-05-29', NULL, 4567, 'password');

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `ClassID` int(11) NOT NULL,
  `SSN` int(10) NOT NULL,
  `Name` varchar(200) NOT NULL,
  `Time` time NOT NULL,
  `NumParticipants` int(11) NOT NULL,
  `RoomNum` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`ClassID`, `SSN`, `Name`, `Time`, `NumParticipants`, `RoomNum`) VALUES
(9, 123, 'Hot Yoga', '17:00:00', 8, 3),
(10, 123, 'Power Lifting', '09:00:00', 8, 4),
(13, 123, 'Cycling', '09:00:00', 9, 2),
(214, 123, 'Cross Fit', '15:00:00', 4, 4),
(456, 123, 'Swimming', '15:00:00', 1, 6),
(655, 123, 'Zumba', '09:00:00', 7, 2);

-- --------------------------------------------------------

--
-- Table structure for table `facility`
--

CREATE TABLE `facility` (
  `RoomNum` int(10) NOT NULL,
  `MaxOccupancy` int(10) NOT NULL,
  `Cleaned` tinyint(1) NOT NULL,
  `FacilityName` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `facility`
--

INSERT INTO `facility` (`RoomNum`, `MaxOccupancy`, `Cleaned`, `FacilityName`) VALUES
(1, 50, 1, 'Gym 1'),
(2, 50, 0, 'Gym 2'),
(3, 50, 0, 'Gym 3'),
(4, 50, 0, 'Weight Room 1'),
(6, 50, 0, 'Swimming pool');

-- --------------------------------------------------------

--
-- Table structure for table `membership`
--

CREATE TABLE `membership` (
  `MembershipID` int(11) NOT NULL,
  `SSN` int(10) NOT NULL,
  `PaymentDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `membership`
--

INSERT INTO `membership` (`MembershipID`, `SSN`, `PaymentDate`) VALUES
(2359, 789, '2022-04-16'),
(2360, 654, '2022-04-17'),
(2361, 856, '2022-04-05'),
(2372, 4567, '2022-04-16');

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `BookingID` int(10) NOT NULL,
  `ClassID` int(10) NOT NULL,
  `RoomNum` int(10) NOT NULL,
  `ScheduleUsername` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`BookingID`, `ClassID`, `RoomNum`, `ScheduleUsername`) VALUES
(247, 10, 4, 'client2'),
(248, 655, 4, 'client2'),
(249, 13, 4, 'client2'),
(251, 9, 4, 'client2'),
(252, 214, 4, 'client2'),
(253, 10, 4, 'client3'),
(254, 655, 4, 'client3'),
(255, 13, 4, 'client3'),
(257, 9, 4, 'client3'),
(258, 214, 4, 'client3'),
(259, 10, 4, 'client4'),
(261, 13, 4, 'client4'),
(263, 9, 4, 'client4'),
(264, 214, 4, 'client4'),
(266, 13, 4, 'client4'),
(267, 13, 6, 'client1'),
(268, 10, 6, 'client1'),
(269, 9, 6, 'client1'),
(270, 655, 6, 'client1'),
(271, 214, 6, 'client1'),
(273, 456, 6, 'client1');

-- --------------------------------------------------------

--
-- Table structure for table `shift`
--

CREATE TABLE `shift` (
  `ShiftID` int(11) NOT NULL,
  `SSN` int(10) NOT NULL,
  `Date` date NOT NULL,
  `StartTime` time NOT NULL,
  `EndTime` time NOT NULL,
  `RoomNum` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `shift`
--

INSERT INTO `shift` (`ShiftID`, `SSN`, `Date`, `StartTime`, `EndTime`, `RoomNum`) VALUES
(28, 321, '2022-04-14', '09:00:00', '12:00:00', 1),
(29, 321, '2022-04-15', '09:00:00', '12:00:00', 1),
(30, 321, '2022-04-16', '09:00:00', '12:00:00', 1),
(31, 321, '2022-04-17', '09:00:00', '12:00:00', 1),
(32, 321, '2022-04-18', '09:00:00', '12:00:00', 1),
(33, 321, '2022-04-19', '09:00:00', '12:00:00', 1),
(34, 321, '2022-04-20', '09:00:00', '12:00:00', 1),
(35, 321, '2022-04-21', '09:00:00', '12:00:00', 1),
(36, 321, '2022-04-22', '09:00:00', '12:00:00', 1),
(37, 321, '2022-04-23', '09:00:00', '12:00:00', 1),
(38, 321, '2022-04-24', '09:00:00', '12:00:00', 1),
(39, 321, '2022-04-25', '09:00:00', '12:00:00', 1),
(40, 321, '2022-04-26', '09:00:00', '12:00:00', 1),
(41, 321, '2022-04-27', '09:00:00', '12:00:00', 1),
(42, 321, '2022-04-28', '09:00:00', '12:00:00', 1),
(43, 321, '2022-04-29', '09:00:00', '12:00:00', 1),
(44, 321, '2022-04-30', '09:00:00', '12:00:00', 1),
(45, 321, '2022-04-14', '12:00:00', '15:00:00', 2),
(46, 321, '2022-04-15', '12:00:00', '15:00:00', 2),
(47, 321, '2022-04-16', '12:00:00', '15:00:00', 2),
(48, 321, '2022-04-17', '12:00:00', '15:00:00', 2),
(49, 321, '2022-04-18', '12:00:00', '15:00:00', 2),
(50, 321, '2022-04-19', '12:00:00', '15:00:00', 2),
(51, 321, '2022-04-20', '12:00:00', '15:00:00', 2),
(52, 321, '2022-04-21', '12:00:00', '15:00:00', 2),
(53, 321, '2022-04-22', '12:00:00', '15:00:00', 2),
(54, 321, '2022-04-23', '12:00:00', '15:00:00', 2),
(55, 321, '2022-04-24', '12:00:00', '15:00:00', 2),
(56, 321, '2022-04-25', '12:00:00', '15:00:00', 2),
(57, 321, '2022-04-26', '12:00:00', '15:00:00', 2),
(58, 321, '2022-04-27', '12:00:00', '15:00:00', 2),
(59, 321, '2022-04-28', '12:00:00', '15:00:00', 2),
(60, 321, '2022-04-29', '12:00:00', '15:00:00', 2),
(61, 321, '2022-04-30', '12:00:00', '15:00:00', 2),
(63, 321, '2022-04-15', '15:00:00', '17:00:00', 3),
(64, 321, '2022-04-16', '15:00:00', '17:00:00', 3),
(65, 321, '2022-04-17', '15:00:00', '17:00:00', 3),
(66, 321, '2022-04-18', '15:00:00', '17:00:00', 3),
(67, 321, '2022-04-19', '15:00:00', '17:00:00', 3),
(68, 321, '2022-04-20', '15:00:00', '17:00:00', 3),
(69, 321, '2022-04-21', '15:00:00', '17:00:00', 3),
(70, 321, '2022-04-22', '15:00:00', '17:00:00', 3),
(71, 321, '2022-04-23', '15:00:00', '17:00:00', 3),
(72, 321, '2022-04-24', '15:00:00', '17:00:00', 3),
(73, 321, '2022-04-25', '15:00:00', '17:00:00', 3),
(74, 321, '2022-04-26', '15:00:00', '17:00:00', 3),
(75, 321, '2022-04-27', '15:00:00', '17:00:00', 3),
(76, 321, '2022-04-28', '15:00:00', '17:00:00', 3),
(77, 321, '2022-04-29', '15:00:00', '17:00:00', 3),
(78, 321, '2022-04-30', '15:00:00', '17:00:00', 3),
(79, 741, '2022-04-14', '09:00:00', '17:00:00', 4),
(80, 741, '2022-04-15', '09:00:00', '17:00:00', 2),
(81, 741, '2022-04-16', '09:00:00', '17:00:00', 6),
(82, 123, '2022-04-14', '09:00:00', '17:00:00', 6),
(84, 123, '2022-04-16', '09:00:00', '17:00:00', 4),
(85, 123, '2022-04-17', '09:00:00', '17:00:00', 3),
(86, 123, '2022-04-18', '09:00:00', '17:00:00', 2),
(88, 123, '2022-04-19', '09:00:00', '17:00:00', 4),
(89, 123, '2022-04-20', '09:00:00', '17:00:00', 6),
(90, 123, '2022-04-21', '09:00:00', '17:00:00', 1),
(91, 123, '2022-04-22', '09:00:00', '17:00:00', 2),
(92, 123, '2022-04-23', '09:00:00', '17:00:00', 4),
(93, 123, '2022-04-25', '09:00:00', '17:00:00', 3),
(94, 123, '2022-04-26', '09:00:00', '17:00:00', 3),
(95, 123, '2022-04-27', '09:00:00', '17:00:00', 1),
(96, 123, '2022-04-28', '09:00:00', '17:00:00', 2),
(97, 123, '2022-04-29', '09:00:00', '17:00:00', 6),
(98, 123, '2022-04-30', '09:00:00', '17:00:00', 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`SSN`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`ClassID`),
  ADD UNIQUE KEY `ClassID` (`ClassID`),
  ADD KEY `ROOMNUM_FOREIGN` (`RoomNum`),
  ADD KEY `TEACHSSN_FOREIGN` (`SSN`);

--
-- Indexes for table `facility`
--
ALTER TABLE `facility`
  ADD PRIMARY KEY (`RoomNum`);

--
-- Indexes for table `membership`
--
ALTER TABLE `membership`
  ADD PRIMARY KEY (`MembershipID`),
  ADD UNIQUE KEY `MembershipID` (`MembershipID`),
  ADD KEY `MEMBERSHIP_FOREIGN` (`SSN`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`BookingID`),
  ADD KEY `CLASSID_FOREIGN` (`ClassID`),
  ADD KEY `SCHEDULEROOMNUMBER` (`RoomNum`),
  ADD KEY `SCHEDULEUSER_FOREIGN` (`ScheduleUsername`);

--
-- Indexes for table `shift`
--
ALTER TABLE `shift`
  ADD PRIMARY KEY (`ShiftID`),
  ADD KEY `SSNSHIFT_FOREIGN` (`SSN`),
  ADD KEY `SHIFTROOM_FOREIGN` (`RoomNum`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `ClassID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4569;

--
-- AUTO_INCREMENT for table `membership`
--
ALTER TABLE `membership`
  MODIFY `MembershipID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2374;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `BookingID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=274;

--
-- AUTO_INCREMENT for table `shift`
--
ALTER TABLE `shift`
  MODIFY `ShiftID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `class`
--
ALTER TABLE `class`
  ADD CONSTRAINT `ROOMNUM_FOREIGN` FOREIGN KEY (`RoomNum`) REFERENCES `facility` (`RoomNum`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `TEACHSSN_FOREIGN` FOREIGN KEY (`SSN`) REFERENCES `account` (`SSN`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `membership`
--
ALTER TABLE `membership`
  ADD CONSTRAINT `MEMBERSHIP_FOREIGN` FOREIGN KEY (`SSN`) REFERENCES `account` (`SSN`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `schedule`
--
ALTER TABLE `schedule`
  ADD CONSTRAINT `CLASSID_FOREIGN` FOREIGN KEY (`ClassID`) REFERENCES `class` (`ClassID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `SCHEDULEROOMNUMBER` FOREIGN KEY (`RoomNum`) REFERENCES `class` (`RoomNum`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `SCHEDULEUSER_FOREIGN` FOREIGN KEY (`ScheduleUsername`) REFERENCES `account` (`Username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `shift`
--
ALTER TABLE `shift`
  ADD CONSTRAINT `SHIFTROOM_FOREIGN` FOREIGN KEY (`RoomNum`) REFERENCES `facility` (`RoomNum`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `SSNSHIFT_FOREIGN` FOREIGN KEY (`SSN`) REFERENCES `account` (`SSN`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
