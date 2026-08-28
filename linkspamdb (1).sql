-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 28, 2026 at 09:34 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `linkspamdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `userID` varchar(30) NOT NULL,
  `userName` varchar(30) NOT NULL,
  `content` varchar(300) NOT NULL,
  `userTags` varchar(50) NOT NULL,
  `hashTags` varchar(64) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `image` varchar(50) NOT NULL,
  `promotes` int(11) NOT NULL,
  `shares` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `userlogin`
--

CREATE TABLE `userlogin` (
  `userID` varchar(30) NOT NULL,
  `userName` varchar(30) NOT NULL,
  `fullName` text NOT NULL,
  `userEmail` varchar(50) NOT NULL,
  `userPassword` varchar(64) NOT NULL,
  `subType` text NOT NULL,
  `userLevel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userlogin`
--

INSERT INTO `userlogin` (`userID`, `userName`, `fullName`, `userEmail`, `userPassword`, `subType`, `userLevel`) VALUES
('user_86d6f24dea1878cd', 'LolwethuD22', 'Lolwethu Damane', 'lolwethudamane07@gmail.com', '$2y$10$VYXxtu.v.KFhURto9wDk5.EfOQVyW9643FR3hPFKQ8cs./sGF8UCG', 'Free', 0);

-- --------------------------------------------------------

--
-- Table structure for table `userprofile`
--

CREATE TABLE `userprofile` (
  `userId` varchar(50) NOT NULL,
  `userName` varchar(50) NOT NULL,
  `affiliationCount` int(11) NOT NULL,
  `followerCount` int(11) NOT NULL,
  `followingCount` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `skill` text NOT NULL,
  `profile-bio` text NOT NULL,
  `profile-picture` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userprofile`
--

INSERT INTO `userprofile` (`userId`, `userName`, `affiliationCount`, `followerCount`, `followingCount`, `skill`, `profile-bio`, `profile-picture`) VALUES
('0', '0', 0, 0, '0', '0', '0', '[value-7]'),
('user_86d6f24dea1878cd', 'LolwethuD22', 0, 0, '0', 'none yet', 'a digital marketer with five years of experience. I help small businesses grow their online reach through clear SEO strategies and social media campaigns. Outside of work, I love hiking and reading mystery', 'public/images/OnePiece.jpg');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
