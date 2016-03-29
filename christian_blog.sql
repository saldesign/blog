-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 29, 2016 at 06:51 PM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `christian_blog`
--
CREATE DATABASE IF NOT EXISTS `christian_blog` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `christian_blog`;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
`category_id` smallint(6) NOT NULL,
  `name` varchar(250) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `name`) VALUES
(1, 'Food'),
(2, 'Drinks');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
`comment_id` smallint(6) NOT NULL,
  `date` datetime NOT NULL,
  `body` text NOT NULL,
  `user_id` smallint(6) NOT NULL,
  `post_id` mediumint(9) NOT NULL,
  `is_approved` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `date`, `body`, `user_id`, `post_id`, `is_approved`) VALUES
(1, '2016-03-09 09:36:40', 'This post really sucks. Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. ', 1, 1, 1),
(2, '2016-03-09 09:36:40', 'This post is really amazing. Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. ', 1, 2, 1),
(3, '2016-03-15 09:33:06', 'aksldjf', 1, 2, 1),
(4, '2016-03-16 08:23:48', 'nope', 1, 1, 1),
(5, '2016-03-24 09:16:59', 'chicken butts', 1, 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `links`
--

DROP TABLE IF EXISTS `links`;
CREATE TABLE IF NOT EXISTS `links` (
`link_id` tinyint(4) NOT NULL,
  `title` varchar(50) NOT NULL,
  `url` text NOT NULL,
  `description` varchar(50) NOT NULL,
  `user_id` smallint(6) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `links`
--

INSERT INTO `links` (`link_id`, `title`, `url`, `description`, `user_id`) VALUES
(1, 'Allied Climbers', 'http://www.alliedclimbers.org/', 'Allied Climbers are a community of outdoorsmen ded', 1),
(2, 'Mountain Project', 'https://www.mountainproject.com/', 'A site for climbing beta', 1);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
`post_id` smallint(6) NOT NULL,
  `title` varchar(120) NOT NULL,
  `date` datetime NOT NULL,
  `body` text NOT NULL,
  `user_id` smallint(6) NOT NULL,
  `category_id` tinyint(4) NOT NULL,
  `is_published` tinyint(1) NOT NULL,
  `allow_comments` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `title`, `date`, `body`, `user_id`, `category_id`, `is_published`, `allow_comments`) VALUES
(1, 'I love pizza', '2016-03-09 09:34:07', 'Let me tell you something great about pizza. Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. \r\n', 1, 1, 1, 1),
(2, 'IPA Beer', '2016-03-09 09:34:07', 'Let me tell you something great about beer. Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. \r\n', 1, 2, 1, 1),
(3, 'Cookies', '2016-03-10 09:36:04', 'Let me tell you something great about cookies. Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. \r\n', 1, 1, 1, 0),
(4, 'stuff', '2016-03-24 09:10:33', 'otghers stuff', 1, 2, 1, 1),
(5, 'stuff', '2016-03-24 09:11:11', 'otghers stuff', 1, 2, 1, 1),
(6, 'stuff', '2016-03-24 09:19:14', 'otghers stuff', 1, 2, 1, 1),
(7, 'test', '2016-03-24 09:41:39', 'test', 1, 2, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
`user_id` smallint(6) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(40) NOT NULL,
  `email` varchar(254) NOT NULL,
  `bio` text NOT NULL,
  `user_pic` varchar(40) NOT NULL,
  `date_joined` datetime NOT NULL,
  `is_admin` tinyint(1) NOT NULL,
  `secret_key` varchar(40) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `bio`, `user_pic`, `date_joined`, `is_admin`, `secret_key`) VALUES
(1, 'Christian', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'saldarriagadesign@gmail.com', 'This is mee!', '', '2016-03-09 10:00:00', 1, 'adf7fbd307594ac3af9c85cefa864cc0fbfa56e7'),
(2, 'someGuy', 'password', 'rando@mail.com', 'stuff not admin user', '', '2016-03-09 09:26:29', 0, ''),
(4, 'alexander', 'e46fc836cca3acec03944314d1457c2ae6c68ef3', 'alexander@mail.com', '', '', '2016-03-22 09:24:03', 0, '8e85d9ca27d02b3c61b6255c1181368a93fef6dc');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
 ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
 ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `links`
--
ALTER TABLE `links`
 ADD PRIMARY KEY (`link_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
 ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
MODIFY `category_id` smallint(6) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
MODIFY `comment_id` smallint(6) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `links`
--
ALTER TABLE `links`
MODIFY `link_id` tinyint(4) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
MODIFY `post_id` smallint(6) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `user_id` smallint(6) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
