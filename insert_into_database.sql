-- phpMyAdmin SQL Dump
-- version 3.3.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 14, 2011 at 04:34 PM
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=40 ;

--
-- Dumping data for table `accountBalance`
--


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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `blogPosts`
--

INSERT INTO `blogPosts` (`id`, `timestamp`, `title`, `message`) VALUES
(5, 1307966616, 'We Mine Coins!', 'Welcome to the <b>Mining farm</b>, if you''ve stumbled across here by accident, You are in for a treat. You can use your computer to help the community mine an Internet commodity known as Bitcoins. You can buy all sorts of stuff with bitcoins like Amazon giftcards, web servers, MMORPG game, or even trade it for cash!\r\n<br/>\r\n<br/>\r\n<h3>Okay, So how do I get BitCoins?</h3>\r\nBitcoins are obtained by a term known as <i>Mining</i>, which is just an easier way to say <i><b>Hashing transactions across the network with Cryptographic algorithims</i></b>. Mining involves your computer to run a program to encrypt transactions with either an on-board processor or your Video Card(Recommended). When there are enough transactions encrypted you obtain a virtual object called a <i>Block</i> which will then be sent out to the network for verification. After a Mining Pool has found a <i>block</i> they will split up the reward according to how many transactions your CPU or GPU(Video Card) executed.\r\n<br/><br/>\r\n<h3>And I use them, how?</h3>\r\nYou can use Bitcoins by downloading a Bitcoin wallet for free over at <a href="http://bitcoin.org">www.BitCoin.org</a>. After you''ve obtained a free Bitcoin wallet you can login to your account here and type in one of your many assigned <i>wallet address</i> to have the payment sent to. Upon payment you are free do to what you want with your Bitcoins. Here is a rough list of websites that accept Bitcoins as payment. <a href="https://en.bitcoin.it/wiki/Trade" target="_BLANK">Sites that accept bitcoins</a>');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

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
  `epochTimestamp` int(50) NOT NULL,
  `rem_host` varchar(255) NOT NULL,
  `username` varchar(120) NOT NULL,
  `our_result` enum('Y','N') NOT NULL,
  `upstream_result` enum('Y','N') DEFAULT NULL,
  `reason` varchar(50) DEFAULT NULL,
  `solution` varchar(257) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=703 ;

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
-- Table structure for table `stats_userMHashHistory`
--

CREATE TABLE IF NOT EXISTS `stats_userMHashHistory` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `mhashes` varchar(20) NOT NULL,
  `timestamp` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1937 ;

--
-- Dumping data for table `stats_userMHashHistory`
--

-- --------------------------------------------------------

--
-- Table structure for table `websiteSettings`
--

CREATE TABLE IF NOT EXISTS `websiteSettings` (
  `header` varchar(255) NOT NULL,
  `noreplyEmail` text NOT NULL,
  `confirmEmailPrefix` text NOT NULL COMMENT 'The text or HTML written email that is sent for email confirmation',
  `slogan` varchar(255) NOT NULL,
  `browserTitle` varchar(255) NOT NULL,
  `cashoutMinimum` varchar(5) NOT NULL COMMENT 'The minimum balance required before a user can cash out'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `websiteSettings`
--

INSERT INTO `websiteSettings` (`header`, `noreplyEmail`, `confirmEmailPrefix`, `slogan`, `browserTitle`, `cashoutMinimum`) VALUES
('Mining Pool v3', 'no-reply@yourdomain.com', 'Welcome you "Your pool name here" glad you are interested in our services, In order to activate your account you must click the link provided and you will be allowed immediate login access past this point. Thank you for you time.', 'IP:66.197.184.28 · PORT: 8341', 'Mining Pool', '1');

-- --------------------------------------------------------

--
-- Table structure for table `websiteUsers`
--

CREATE TABLE IF NOT EXISTS `websiteUsers` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `isAdmin` int(1) NOT NULL,
  `disabled` int(1) NOT NULL DEFAULT '0',
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `randomSecret` varchar(10) NOT NULL COMMENT 'Generated at login, this secret secures cookies when hashing',
  `sessTimestamp` int(255) NOT NULL COMMENT 'Session timestamp for valid cookie checking',
  `loggedIp` varchar(255) NOT NULL COMMENT 'Validating hashed cookies',
  `email` varchar(255) NOT NULL,
  `emailAuthorised` int(1) NOT NULL DEFAULT '0',
  `emailAuthorisePin` varchar(64) NOT NULL,
  `authPin` varchar(255) NOT NULL COMMENT 'A pin that must be supplied when changing details to various things',
  `apiToken` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=43 ;

--
-- Dumping data for table `websiteUsers`
--

