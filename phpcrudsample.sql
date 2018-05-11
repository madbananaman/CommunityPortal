-- phpMyAdmin SQL Dump
-- version 4.7.8
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 10, 2018 at 07:05 PM
-- Server version: 5.7.19-log
-- PHP Version: 7.2.3
use cttan;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `phpcrudsample`
--

DELIMITER $$
--
-- Procedures
--


DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tb_feedback`
--

CREATE TABLE `tb_feedback` (
  `id` int(5) NOT NULL,
  `firstname` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `comments` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_feedback`
--



-- --------------------------------------------------------

--
-- Table structure for table `tb_forum`
--

CREATE TABLE `tb_forum` (
  `forum_id` int(11) NOT NULL,
  `parent_Forum_id` int(11) DEFAULT NULL,
  `forumMessage` text NOT NULL,
  `forumMessage_Author_id` int(11) NOT NULL,
  `forumMessage_Author_email` varchar(60) NOT NULL,
  `createdDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `category` varchar(20) DEFAULT NULL,
  `forumTitle` varchar(50) DEFAULT NULL,
  `forumThreadLevel` int(11) DEFAULT NULL,
  `thread_id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_forum`
--



-- --------------------------------------------------------

--
-- Table structure for table `tb_message`
--

CREATE TABLE `tb_message` (
  `id` int(11) NOT NULL,
  `authorID` int(11) DEFAULT NULL,
  `author` varchar(255) NOT NULL,
  `recipients` text,
  `subject` text,
  `message` text,
  `sentTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_message`
--


-- --------------------------------------------------------

--
-- Table structure for table `tb_messageboard`
--

CREATE TABLE `tb_messageboard` (
  `comment_id` int(11) NOT NULL,
  `parent_comment_id` int(11) NOT NULL,
  `comment` varchar(200) NOT NULL,
  `comment_sender_name` varchar(40) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_messageboard`
--



-- --------------------------------------------------------

--
-- Table structure for table `tb_subscribe`
--

CREATE TABLE `tb_subscribe` (
  `id` int(11) NOT NULL,
  `email` varchar(60) DEFAULT NULL,
  `hashkey` text,
  `subscribe_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_subscribe`
--



-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `id` int(11) NOT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `email` varchar(60) DEFAULT NULL,
  `password` text,
  `account_creation_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `role` varchar(10) NOT NULL DEFAULT '''user'''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_user`
--


--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_feedback`
--
ALTER TABLE `tb_feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `tb_forum`
--
ALTER TABLE `tb_forum`
  ADD PRIMARY KEY (`forum_id`),
  ADD KEY `forumMessage_Author_email` (`forumMessage_Author_email`),
  ADD KEY `forumMessage_Author_id` (`forumMessage_Author_id`);

--
-- Indexes for table `tb_message`
--
ALTER TABLE `tb_message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `authorID` (`authorID`),
  ADD KEY `author` (`author`);

--
-- Indexes for table `tb_messageboard`
--
ALTER TABLE `tb_messageboard`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `tb_subscribe`
--
ALTER TABLE `tb_subscribe`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tb_subscribe_ibfk_2` (`email`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_feedback`
--
ALTER TABLE `tb_feedback`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tb_message`
--
ALTER TABLE `tb_message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tb_messageboard`
--
ALTER TABLE `tb_messageboard`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_forum`
--
ALTER TABLE `tb_forum`
  ADD CONSTRAINT `tb_forum_ibfk_1` FOREIGN KEY (`forumMessage_Author_email`) REFERENCES `tb_user` (`email`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_forum_ibfk_2` FOREIGN KEY (`forumMessage_Author_id`) REFERENCES `tb_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_message`
--
ALTER TABLE `tb_message`
  ADD CONSTRAINT `tb_message_ibfk_1` FOREIGN KEY (`authorID`) REFERENCES `tb_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_message_ibfk_2` FOREIGN KEY (`author`) REFERENCES `tb_user` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_subscribe`
--
ALTER TABLE `tb_subscribe`
  ADD CONSTRAINT `tb_subscribe_ibfk_1` FOREIGN KEY (`id`) REFERENCES `tb_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_subscribe_ibfk_2` FOREIGN KEY (`email`) REFERENCES `tb_user` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
