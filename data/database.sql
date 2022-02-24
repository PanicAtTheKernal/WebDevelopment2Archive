-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 23, 2022 at 08:25 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.3.31

set global sql_mode = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `assginmentdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `ISBN` varchar(20) NOT NULL,
  `BookTitle` varchar(30) NOT NULL,
  `Author` varchar(30) NOT NULL,
  `Edition` int(11) NOT NULL,
  `Year` int(4) NOT NULL,
  `Category` int(11) NOT NULL,
  `Reserverd` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`ISBN`, `BookTitle`, `Author`, `Edition`, `Year`, `Category`, `Reserverd`) VALUES
('093-403992', 'Computer in Business', 'Alica Oneil', 3, 1997, 3, 'N'),
('23472-8729', 'Exploring Peru', 'Stephanie Birchi', 4, 2005, 5, 'N'),
('237-34823', 'Business Strategy', 'Joe Peppard', 2, 2002, 2, 'N'),
('23u8-9223849', 'A guide to nutrition ', 'John Thrope', 2, 1997, 1, 'N'),
('2983-3494', 'Cooking for children', 'Anabelle Sharpe', 1, 2003, 7, 'N'),
('82n8-308', 'Computers for idiots ', 'Susan O\'Neill', 5, 1998, 4, 'N'),
('9823-23984', 'My life in a picture', 'Kevin Graham', 8, 2004, 1, 'N'),
('9823-2403-0', 'DaVinci Code', 'Dan Brown ', 1, 2003, 8, 'Y'),
('9823-98345', 'How to cook Italian food', 'Jamie Oliver', 2, 2005, 7, 'Y'),
('9823-98487', 'Optimising your business', 'Cleo Blair', 1, 2001, 2, 'N'),
('98234-029384', 'My ranch in Texas', 'Geogre Bush', 1, 2005, 1, 'Y'),
('988745-234', 'Tara Road', 'Meave Binchy', 4, 2002, 8, 'N'),
('993-004-00', 'My life in bits', 'John Smith', 1, 2001, 1, 'N'),
('9987-0039882', 'Shooting History', 'Jon Snow', 1, 2003, 1, 'N');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `CategoryID` int(11) NOT NULL,
  `CategoryDescription` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`CategoryID`, `CategoryDescription`) VALUES
(1, 'Health '),
(2, 'Business'),
(3, 'Biography'),
(4, 'Technology'),
(5, 'Travel'),
(6, 'Self-Help'),
(7, 'Cookery'),
(8, 'Fiction');

-- --------------------------------------------------------

--
-- Table structure for table `reseverdbooks`
--

CREATE TABLE `reseverdbooks` (
  `ISBN` varchar(20) NOT NULL,
  `Username` varchar(30) NOT NULL,
  `ReservedDate` date DEFAULT CURRENT_TIMESTAMP NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reseverdbooks`
--

INSERT INTO `reseverdbooks` (`ISBN`, `Username`, `ReservedDate`) VALUES
('9823-2403-0', 'qwerty', '2021-11-29'),
('9823-98345', 'tommy100', '2008-10-11'),
('98234-029384', 'joecrotty', '2008-10-11');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `Users` (
  `Username` varchar(30) NOT NULL,
  `Password` varchar(6) NOT NULL,
  `FirstName` varchar(30) NOT NULL,
  `Surname` varchar(30) NOT NULL,
  `AddressLine1` varchar(50) NOT NULL,
  `AddressLine2` varchar(50) NOT NULL,
  `City` varchar(30) NOT NULL,
  `Telephone` int(10) NOT NULL,
  `Moblie` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `Users` (`Username`, `Password`, `FirstName`, `Surname`, `AddressLine1`, `AddressLine2`, `City`, `Telephone`, `Moblie`) VALUES
('alanjmckenna', 't1234s', 'Alan', 'Joseph', '38 Cranley Road', 'Fairview', 'Dublin', 9998377, 856625567),
('Chesseboi', 'bire', 'Perrie', 'Mario', '16 Chocolete Junction', 'Blackrock', 'Dublin', 863456343, 852387345),
('joecrotty', 'kj7899', 'Joesph', 'Crotty', 'Apt 5 Clyde Road', 'Donnybrook', 'Dublin', 8887889, 876654456),
('qwerty', '123', 'Louis', 'McDoyle', '13 Dumbar Road', 'Grangegorman', 'Dublin', 21473647, 21748647),
('tommy100', '12345', 'Tom', 'Behan', '14 Hyde Road', 'Dalkey', 'Dublin', 9983747, 876738782);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`ISBN`),
  ADD KEY `books_category_fk` (`Category`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`CategoryID`);

--
-- Indexes for table `reseverdbooks`
--
ALTER TABLE `reseverdbooks`
  ADD PRIMARY KEY (`ISBN`,`Username`),
  ADD KEY `reseverdbooks_username_fk` (`Username`);

--
-- Indexes for table `users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`Username`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_category_fk` FOREIGN KEY (`Category`) REFERENCES `category` (`CategoryID`);

--
-- Constraints for table `reseverdbooks`
--
ALTER TABLE `reseverdbooks`
  ADD CONSTRAINT `reseverdbooks_isbn_fk` FOREIGN KEY (`ISBN`) REFERENCES `books` (`ISBN`),
  ADD CONSTRAINT `reseverdbooks_username_fk` FOREIGN KEY (`Username`) REFERENCES `Users` (`Username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
