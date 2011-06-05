-- phpMyAdmin SQL Dump
-- version 3.3.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 04, 2011 at 04:56 PM
-- Server version: 5.1.54
-- PHP Version: 5.3.5-1ubuntu7.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mp3`
--

-- --------------------------------------------------------

--
-- Table structure for table `accountBalance`
--

CREATE TABLE IF NOT EXISTS `accountBalance` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `userId` int(255) NOT NULL,
  `balance` varchar(10) NOT NULL,
  `payoutAddress` varchar(255) NOT NULL,
  `threshhold` varchar(5) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `userId` (`userId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `accountBalance`
--

INSERT INTO `accountBalance` (`id`, `userId`, `balance`, `payoutAddress`, `threshhold`) VALUES
(14, 17, '0.00', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `blogPosts`
--

CREATE TABLE IF NOT EXISTS `blogPosts` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `timestamp` int(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `blogPosts`
--

INSERT INTO `blogPosts` (`id`, `timestamp`, `title`, `message`) VALUES
(1, 0, 'OH yeas!', 'Welcome to <b>State your Website Here</b> made with Mining Pool v3 basically the best front-end software and not a total kidding you can get this stuff installed on your server in no less then 30 minutes if you already have pushpoold or someother back-end pooling softwares :)');

-- --------------------------------------------------------

--
-- Table structure for table `networkBlocks`
--

CREATE TABLE IF NOT EXISTS `networkBlocks` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `blockNumber` int(255) NOT NULL,
  `timestamp` int(255) NOT NULL,
  `accountAddress` varchar(255) NOT NULL,
  `confirms` int(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `networkBlocks`
--


-- --------------------------------------------------------

--
-- Table structure for table `pool_worker`
--

CREATE TABLE IF NOT EXISTS `pool_worker` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `associatedUserId` int(255) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `pool_worker`
--


-- --------------------------------------------------------

--
-- Table structure for table `shares`
--

CREATE TABLE IF NOT EXISTS `shares` (
  `id` bigint(30) NOT NULL AUTO_INCREMENT,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `rem_host` varchar(255) NOT NULL,
  `username` varchar(120) NOT NULL,
  `our_result` enum('Y','N') NOT NULL,
  `upstream_result` enum('Y','N') DEFAULT NULL,
  `reason` varchar(50) DEFAULT NULL,
  `solution` varchar(257) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `shares`
--


-- --------------------------------------------------------

--
-- Table structure for table `shares_history`
--

CREATE TABLE IF NOT EXISTS `shares_history` (
  `id` bigint(30) NOT NULL AUTO_INCREMENT,
  `shareCounted` int(1) NOT NULL,
  `blockNumber` int(255) NOT NULL,
  `time` varchar(255) NOT NULL,
  `rem_host` varchar(255) NOT NULL,
  `username` varchar(120) NOT NULL,
  `our_result` enum('Y','N') NOT NULL,
  `upstream_result` enum('Y','N') DEFAULT NULL,
  `reason` varchar(50) DEFAULT NULL,
  `solution` varchar(257) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `shares_history`
--


-- --------------------------------------------------------

--
-- Table structure for table `websiteSettings`
--

CREATE TABLE IF NOT EXISTS `websiteSettings` (
  `header` varchar(255) NOT NULL,
  `confirmEmail` text NOT NULL,
  `slogan` varchar(255) NOT NULL,
  `browserTitle` varchar(255) NOT NULL,
  `cashoutMinimum` varchar(5) NOT NULL COMMENT 'The minimum balance required before a user can cash out'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `websiteSettings`
--

INSERT INTO `websiteSettings` (`header`, `confirmEmail`, `slogan`, `browserTitle`, `cashoutMinimum`) VALUES
('Mining Pool v3', 'no-reply@yourdomain.com', 'IP:66.197.184.28 · PORT: 8341', 'Mining Pool v3', '1');

-- --------------------------------------------------------

--
-- Table structure for table `websiteUsers`
--

CREATE TABLE IF NOT EXISTS `websiteUsers` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `isAdmin` int(1) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `randomSecret` varchar(10) NOT NULL COMMENT 'Generated at login, this secret secures cookies when hashing',
  `sessTimestamp` int(255) NOT NULL COMMENT 'Session timestamp for valid cookie checking',
  `loggedIp` varchar(255) NOT NULL COMMENT 'Validating hashed cookies',
  `email` varchar(255) NOT NULL,
  `emailAuthorised` int(1) NOT NULL DEFAULT '0',
  `emailAuthorisePin` varchar(64) NOT NULL,
  `authPin` varchar(255) NOT NULL COMMENT 'A pin that must be supplied when changing details to various things',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `websiteUsers`
--

INSERT INTO `websiteUsers` (`id`, `isAdmin`, `username`, `password`, `randomSecret`, `sessTimestamp`, `loggedIp`, `email`, `emailAuthorised`, `emailAuthorisePin`, `authPin`) VALUES
(17, 0, ' fdsa', '6b8dca09e851a987050463c9c60603e9ad797ba09117056fc2e0c07bcac66e43', '', 0, '', 'xennetwork@hotmail.com', 0, 'rwYUUXIVMIzkHVYfVRqarI2AxFJOKtY2PNMABlmeTLpqxdwjUMkbldCIIbmjubba', '');
