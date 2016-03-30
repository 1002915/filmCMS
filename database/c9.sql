-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 29, 2016 at 12:52 AM
-- Server version: 5.5.47-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `c9`
--

-- --------------------------------------------------------

--
-- Table structure for table `academic`
--

CREATE TABLE IF NOT EXISTS `academic` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `film_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `campus`
--

CREATE TABLE IF NOT EXISTS `campus` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `location` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `collaborators`
--

CREATE TABLE IF NOT EXISTS `collaborators` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `film_id` int(10) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `role` varchar(100) NOT NULL,
  `email` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `film`
--

CREATE TABLE IF NOT EXISTS `film` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) NOT NULL,
  `synopsis` text NOT NULL,
  `video_link` varchar(250) NOT NULL,
  `cover_image` varchar(250) NOT NULL,
  `runtime` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `published` tinyint(1) NOT NULL,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `film`
--

INSERT INTO `film` (`id`, `title`, `synopsis`, `video_link`, `cover_image`, `runtime`, `user_id`, `published`, `active`) VALUES
(1, 'The First Video', 'This is a very exciting video. You should watch it.', 'https://www.youtube.com/watch?v=06dAqSFn1lk&feature=youtu.be', 'C:/Pictures/angrypenguin.jpg', 4, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `film_history`
--

CREATE TABLE IF NOT EXISTS `film_history` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `film_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `time_now` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_action` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `login_history`
--

CREATE TABLE IF NOT EXISTS `login_history` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `time_now` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_action` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE IF NOT EXISTS `rating` (
  `id` int(10) NOT NULL,
  `film_id` int(10) NOT NULL,
  `ip` varchar(100) NOT NULL,
  `rating` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `campus_id` int(10) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `user_type` tinyint(1) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password_hash` varchar(250) DEFAULT NULL,
  `password_salt` varchar(250) DEFAULT NULL,
  `verify_hash` varchar(250) DEFAULT NULL,
  `verified` tinyint(1) DEFAULT NULL,
  `verify_time` timestamp NULL DEFAULT NULL,
  `forgot_hash` varchar(250) DEFAULT NULL,
  `forgot_time` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
