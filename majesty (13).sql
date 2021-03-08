-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 29, 2021 at 07:20 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `majesty`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_activitylogs`
--

CREATE TABLE `tbl_activitylogs` (
  `actID` int(11) NOT NULL,
  `actAccountID` varchar(255) NOT NULL,
  `actActions` varchar(255) NOT NULL,
  `actDate` varchar(255) NOT NULL,
  `actTime` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_branches`
--

CREATE TABLE `tbl_branches` (
  `branchID` int(11) NOT NULL,
  `branchName` varchar(255) NOT NULL,
  `branchStatus` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_branches`
--

INSERT INTO `tbl_branches` (`branchID`, `branchName`, `branchStatus`) VALUES
(1, 'Main', 'Active'),
(2, 'Zabarte', 'Active'),
(3, 'Malakas', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_contactus`
--

CREATE TABLE `tbl_contactus` (
  `contactID` int(11) NOT NULL,
  `contactName` varchar(255) NOT NULL,
  `contactNumber` varchar(255) NOT NULL,
  `contactEmail` varchar(255) NOT NULL,
  `contactSubject` varchar(255) NOT NULL,
  `contactMessage` text NOT NULL,
  `contactStatus` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_dlcodes`
--

CREATE TABLE `tbl_dlcodes` (
  `dlCodeID` int(11) NOT NULL,
  `dlCodeName` varchar(255) NOT NULL,
  `dlCodeDesc` varchar(255) NOT NULL,
  `dlCodeSubName` varchar(255) NOT NULL,
  `dlCodeSubDesc` varchar(255) NOT NULL,
  `dlCodeType` varchar(255) NOT NULL,
  `dlCodeTransmission` varchar(255) NOT NULL,
  `dlCodeStatus` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_dlcodes`
--

INSERT INTO `tbl_dlcodes` (`dlCodeID`, `dlCodeName`, `dlCodeDesc`, `dlCodeSubName`, `dlCodeSubDesc`, `dlCodeType`, `dlCodeTransmission`, `dlCodeStatus`) VALUES
(1, 'A', 'Motorcycle', 'L1', 'Two wheels with a maximum design speed not exceeding 50 kph', 'NPL-PL', 'AT-MT', 'Active'),
(2, 'A', 'Motorcycle', 'L2', 'Three wheels with a maximum design speed not exceeding 50 kph', 'NPL-PL', 'AT-MT', 'Active'),
(3, 'A', 'Motorcycle', 'L3', 'Two wheels with a maximum design speed exceeding 50 kph', 'NPL-PL', 'AT-MT', 'Active'),
(4, 'A1', 'Tricycle', 'L4', 'Motorcycle with side cars with a maximum design speed exceeding 50 kph', 'NPL-PL', 'AT-MT', 'Active'),
(5, 'A1', 'Tricycle', 'L5', 'Three wheels symmetrically arranged with a maximum speed exceeding 50 kph', 'NPL-PL', 'AT-MT', 'Active'),
(6, 'A1', 'Tricycle', 'L6', 'Four wheels whose unladen mass is not more than 350kg with maximum design speed not exceeding 45 kph', 'NPL-PL', 'AT-MT', 'Active'),
(7, 'A1', 'Tricycle', 'L7', 'Four wheels whose unladen mass is not more than 550kg with maximum design speed not exceeding 45 kph', 'NPL-PL', 'AT-MT', 'Active'),
(8, 'B', 'Light Passenger Car', 'M1', 'Vehicle used for carriage of passengers, comprising not more than 8 seats in addition to the drivers seat with GVW up to 5000kgs', 'NPL-PL', 'AT-MT', 'Active'),
(9, 'B1', 'Jeepney and Passenger Van', 'M2', 'Vehicle used for carriage of passengers, comprising more than 8 seats in addition to the drivers seat with GVW up to 5000kgs', 'NPL-PL', 'AT-MT', 'Active'),
(10, 'B2', 'Light Commercial Vehicle', 'N1', 'Vehicles used for the carriage of goods and having up to 3500kgs', 'NPL-PL', 'AT-MT', 'Active'),
(11, 'BE', 'Articulated Passenger Car', 'O1', 'Trailers with a maximum GVW not exceeding 750kgs', '-PL', 'AT-MT', 'Active'),
(12, 'BE', 'Articulated Passenger Car', 'O2', 'Trailers with a maximum GVW exceeding 750kgs, but not exceeding 3500kgs', '-PL', 'AT-MT', 'Active'),
(13, 'C', 'Heavy Commercial Vehicle', 'N2', 'Vehicles used for the carriage of goods and having a maximum GVW exceeding 3500kgs but not exceeding 12000kgs', '-PL', 'AT-MT', 'Active'),
(14, 'C', 'Heavy Commercial Vehicle', 'N3', 'Vehicles used for the carriage of goods and having a maximum GVW exceeding 12000kgs', '-PL', 'AT-MT', 'Active'),
(15, 'CE', 'Heavy Ariculated Vehicle', 'O3', 'Trailers with a maximum GVW exceeding 3500kgs, but not exceeding 10000kgs', '-PL', 'AT-MT', 'Active'),
(16, 'CE', 'Heavy Ariculated Vehicle', 'O4', 'Trailers with a maximum GVW exceeding 10000kgs', '-PL', 'AT-MT', 'Active'),
(17, 'D', 'Buses, Coaches and the likes', 'M3', 'Vehicle used for carriage of passengers, comprising more that 8 seats in addition to the drivers seat and having maximum GVW exceeding 5000kgs', '-PL', 'AT-MT', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_instructorinfo`
--

CREATE TABLE `tbl_instructorinfo` (
  `instID` int(11) NOT NULL,
  `instAccred` varchar(255) NOT NULL,
  `instFirstname` varchar(255) NOT NULL,
  `instMiddlename` varchar(255) NOT NULL,
  `instLastname` varchar(255) NOT NULL,
  `instPassword` varchar(255) NOT NULL,
  `instEmail` varchar(255) NOT NULL,
  `instPicture` blob NOT NULL,
  `instSignature` blob NOT NULL,
  `instAccountType` varchar(255) NOT NULL,
  `instStatus` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_instructorinfo`
--

INSERT INTO `tbl_instructorinfo` (`instID`, `instAccred`, `instFirstname`, `instMiddlename`, `instLastname`, `instPassword`, `instEmail`, `instPicture`, `instSignature`, `instAccountType`, `instStatus`) VALUES
(1, '', 'Liza Marie', 'Sample', 'Lugtu', '492934e888a749f772b6b70988d2c1c8', 'LMSLugtu@majestydrivingschool.com', '', '', 'Super-Admin', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_studentinfo`
--

CREATE TABLE `tbl_studentinfo` (
  `studID` int(11) NOT NULL,
  `studFirstname` varchar(255) NOT NULL,
  `studMiddlename` varchar(255) NOT NULL,
  `studLastname` varchar(255) NOT NULL,
  `studAddress` varchar(255) NOT NULL,
  `studDOB` varchar(255) NOT NULL,
  `studNationality` varchar(255) NOT NULL,
  `studGender` varchar(255) NOT NULL,
  `studMaritalStatus` varchar(255) NOT NULL,
  `studCapture` blob NOT NULL,
  `studCount` varchar(255) NOT NULL,
  `studStatus` varchar(255) NOT NULL,
  `studDateCertified` varchar(255) NOT NULL,
  `studInstructorID` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_traininginfo`
--

CREATE TABLE `tbl_traininginfo` (
  `trainID` int(11) NOT NULL,
  `trainStudentID` varchar(255) NOT NULL,
  `trainCourse` varchar(255) NOT NULL,
  `trainProgram` varchar(255) NOT NULL,
  `trainDLNo` varchar(255) NOT NULL,
  `trainPurpose` varchar(255) NOT NULL,
  `trainMV` varchar(255) NOT NULL,
  `trainDL` varchar(255) NOT NULL,
  `trainStarted` varchar(255) NOT NULL,
  `trainCompleted` varchar(255) NOT NULL,
  `trainHours` varchar(255) NOT NULL,
  `trainAssessment` varchar(255) NOT NULL,
  `trainOverall` varchar(255) NOT NULL,
  `trainRemarks` varchar(255) NOT NULL,
  `trainBranch` varchar(255) NOT NULL,
  `trainActive` varchar(255) NOT NULL,
  `trainCount` varchar(255) NOT NULL,
  `trainInstructorID` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_activitylogs`
--
ALTER TABLE `tbl_activitylogs`
  ADD PRIMARY KEY (`actID`);

--
-- Indexes for table `tbl_branches`
--
ALTER TABLE `tbl_branches`
  ADD PRIMARY KEY (`branchID`);

--
-- Indexes for table `tbl_contactus`
--
ALTER TABLE `tbl_contactus`
  ADD PRIMARY KEY (`contactID`);

--
-- Indexes for table `tbl_dlcodes`
--
ALTER TABLE `tbl_dlcodes`
  ADD PRIMARY KEY (`dlCodeID`);

--
-- Indexes for table `tbl_instructorinfo`
--
ALTER TABLE `tbl_instructorinfo`
  ADD PRIMARY KEY (`instID`);

--
-- Indexes for table `tbl_studentinfo`
--
ALTER TABLE `tbl_studentinfo`
  ADD PRIMARY KEY (`studID`);

--
-- Indexes for table `tbl_traininginfo`
--
ALTER TABLE `tbl_traininginfo`
  ADD PRIMARY KEY (`trainID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_activitylogs`
--
ALTER TABLE `tbl_activitylogs`
  MODIFY `actID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_branches`
--
ALTER TABLE `tbl_branches`
  MODIFY `branchID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_contactus`
--
ALTER TABLE `tbl_contactus`
  MODIFY `contactID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_dlcodes`
--
ALTER TABLE `tbl_dlcodes`
  MODIFY `dlCodeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tbl_instructorinfo`
--
ALTER TABLE `tbl_instructorinfo`
  MODIFY `instID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_studentinfo`
--
ALTER TABLE `tbl_studentinfo`
  MODIFY `studID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_traininginfo`
--
ALTER TABLE `tbl_traininginfo`
  MODIFY `trainID` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
