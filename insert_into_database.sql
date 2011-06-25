-- phpMyAdmin SQL Dump
-- version 3.3.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
<<<<<<< HEAD
-- Generation Time: Jun 17, 2011 at 02:35 AM
=======
-- Generation Time: Jun 14, 2011 at 04:34 PM
>>>>>>> f9332a8ad0cd4e27505f162718c69fc8ea297aa7
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
<<<<<<< HEAD
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=42 ;
=======
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=40 ;
>>>>>>> f9332a8ad0cd4e27505f162718c69fc8ea297aa7

--
-- Dumping data for table `accountBalance`
--

<<<<<<< HEAD
INSERT INTO `accountBalance` (`id`, `userId`, `balance`, `payoutAddress`, `threshhold`) VALUES
(40, 43, '0.00', '12QY5HYbiT5Nx6fek8ss5pAywPsV3kqdu3', '1'),
(41, 44, '0.00', '', '');
=======
>>>>>>> f9332a8ad0cd4e27505f162718c69fc8ea297aa7

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
<<<<<<< HEAD
  `txid` varchar(255) NOT NULL,
  `confirms` int(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;
=======
  `accountAddress` varchar(255) NOT NULL,
  `confirms` int(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;
>>>>>>> f9332a8ad0cd4e27505f162718c69fc8ea297aa7

--
-- Dumping data for table `networkBlocks`
--

<<<<<<< HEAD
INSERT INTO `networkBlocks` (`id`, `blockNumber`, `timestamp`, `txid`, `confirms`) VALUES
(11, 131185, 1308197153, '', 0),
(12, 131186, 1308198419, '', 0),
(13, 131187, 1308198525, '', 0),
(14, 131188, 1308199186, '', 0),
(15, 131189, 1308199949, '', 0);

=======
>>>>>>> f9332a8ad0cd4e27505f162718c69fc8ea297aa7
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
<<<<<<< HEAD
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;
=======
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;
>>>>>>> f9332a8ad0cd4e27505f162718c69fc8ea297aa7

--
-- Dumping data for table `pool_worker`
--

<<<<<<< HEAD
INSERT INTO `pool_worker` (`id`, `associatedUserId`, `username`, `password`) VALUES
(19, 43, 'Xenland.username', 'password'),
(20, 44, 'test.username', 'password'),
(21, 44, 'test.username2', 'password'),
(22, 43, 'Xenland.username2', 'password');
=======
>>>>>>> f9332a8ad0cd4e27505f162718c69fc8ea297aa7

-- --------------------------------------------------------

--
-- Table structure for table `shares`
--

CREATE TABLE IF NOT EXISTS `shares` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `epochTimestamp` int NOT NULL,
  `rem_host` varchar(255) NOT NULL,
  `username` varchar(120) NOT NULL,
  `our_result` enum('Y','N') NOT NULL,
  `upstream_result` enum('Y','N') DEFAULT NULL,
  `reason` varchar(50) DEFAULT NULL,
  `solution` varchar(257) NOT NULL,
  PRIMARY KEY (`id`)
<<<<<<< HEAD
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2;
=======
>>>>>>> f9332a8ad0cd4e27505f162718c69fc8ea297aa7

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
<<<<<<< HEAD
-- Table structure for table `stats_poolMHashHistory`
--

CREATE TABLE IF NOT EXISTS `stats_poolMHashHistory` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `timestamp` int(255) NOT NULL,
  `averageMhash` int(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=47 ;

--
-- Dumping data for table `stats_poolMHashHistory`
--

INSERT INTO `stats_poolMHashHistory` (`id`, `timestamp`, `averageMhash`) VALUES
(1, 1308290433, 0),
(2, 1308290449, 0),
(3, 1308290463, 0),
(4, 1308290469, 0),
(5, 1308290531, 0),
(6, 1308290595, 0),
(7, 1308290616, 188),
(8, 1308290625, 215),
(9, 1308290729, 228),
(10, 1308290786, 295),
(11, 1308290808, 322),
(12, 1308290859, 322),
(13, 1308291462, 322),
(14, 1308291486, 349),
(15, 1308291611, 442),
(16, 1308291658, 429),
(17, 1308294707, 0),
(18, 1308294710, 0),
(19, 1308294867, 0),
(20, 1308295718, 0),
(21, 1308295718, 0),
(22, 1308295718, 0),
(23, 1308295723, 0),
(24, 1308295769, 0),
(25, 1308297180, 0),
(26, 1308297335, 0),
(27, 1308298023, 0),
(28, 1308298782, 0),
(29, 1308299238, 0),
(30, 1308299241, 0),
(31, 1308301903, 0),
(32, 1308302117, 0),
(33, 1308302258, 27),
(34, 1308302262, 27),
(35, 1308302349, 121),
(36, 1308302703, 295),
(37, 1308302842, 241),
(38, 1308302895, 188),
(39, 1308302904, 175),
(40, 1308303012, 295),
(41, 1308303021, 322),
(42, 1308303079, 375),
(43, 1308303132, 349),
(44, 1308303233, 389),
(45, 1308303273, 308),
(46, 1308303278, 295);

-- --------------------------------------------------------

--
=======
>>>>>>> f9332a8ad0cd4e27505f162718c69fc8ea297aa7
-- Table structure for table `stats_userMHashHistory`
--

CREATE TABLE IF NOT EXISTS `stats_userMHashHistory` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `mhashes` varchar(20) NOT NULL,
  `timestamp` int(11) NOT NULL,
  PRIMARY KEY (`id`)
<<<<<<< HEAD
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2309 ;
=======
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1937 ;
>>>>>>> f9332a8ad0cd4e27505f162718c69fc8ea297aa7

--
-- Dumping data for table `stats_userMHashHistory`
--

<<<<<<< HEAD
INSERT INTO `stats_userMHashHistory` (`id`, `username`, `mhashes`, `timestamp`) VALUES
(1937, 'Xenland.username', '0', 1308197163),
(1938, 'Xenland.username', '0', 1308197255),
(1939, 'Xenland.username', '0', 1308197256),
(1940, 'Xenland.username', '0', 1308197283),
(1941, 'Xenland.username', '0', 1308197285),
(1942, 'Xenland.username', '0', 1308197286),
(1943, 'Xenland.username', '0', 1308197358),
(1944, 'Xenland.username', '134', 1308197454),
(1945, 'Xenland.username', '375', 1308197658),
(1946, 'Xenland.username', '375', 1308197790),
(1947, 'Xenland.username', '81', 1308198030),
(1948, 'test.username', '241', 1308198030),
(1949, 'Xenland.username', '0', 1308198256),
(1950, 'test.username', '349', 1308198256),
(1951, 'Xenland.username', '0', 1308198383),
(1952, 'test.username', '335', 1308198383),
(1953, 'Xenland.username', '0', 1308198409),
(1954, 'test.username', '335', 1308198409),
(1955, 'Xenland.username', '0', 1308198418),
(1956, 'test.username', '322', 1308198418),
(1957, 'Xenland.username', '0', 1308198432),
(1958, 'test.username', '308', 1308198432),
(1959, 'Xenland.username', '0', 1308198450),
(1960, 'test.username', '295', 1308198450),
(1961, 'Xenland.username', '0', 1308198451),
(1962, 'test.username', '295', 1308198451),
(1963, 'Xenland.username', '0', 1308198451),
(1964, 'test.username', '295', 1308198451),
(1965, 'Xenland.username', '0', 1308198452),
(1966, 'test.username', '295', 1308198452),
(1967, 'Xenland.username', '0', 1308198454),
(1968, 'test.username', '308', 1308198454),
(1969, 'Xenland.username', '0', 1308198454),
(1970, 'test.username', '308', 1308198454),
(1971, 'Xenland.username', '0', 1308198454),
(1972, 'test.username', '308', 1308198454),
(1973, 'Xenland.username', '0', 1308198456),
(1974, 'test.username', '308', 1308198456),
(1975, 'Xenland.username', '0', 1308198456),
(1976, 'test.username', '308', 1308198456),
(1977, 'Xenland.username', '0', 1308198456),
(1978, 'test.username', '308', 1308198456),
(1979, 'Xenland.username', '0', 1308198457),
(1980, 'test.username', '308', 1308198457),
(1981, 'Xenland.username', '0', 1308198457),
(1982, 'test.username', '308', 1308198457),
(1983, 'Xenland.username', '0', 1308198457),
(1984, 'test.username', '308', 1308198457),
(1985, 'Xenland.username', '0', 1308198458),
(1986, 'test.username', '295', 1308198458),
(1987, 'Xenland.username', '0', 1308198458),
(1988, 'test.username', '295', 1308198458),
(1989, 'Xenland.username', '0', 1308198458),
(1990, 'test.username', '295', 1308198458),
(1991, 'Xenland.username', '0', 1308198458),
(1992, 'test.username', '295', 1308198458),
(1993, 'Xenland.username', '0', 1308198459),
(1994, 'test.username', '295', 1308198459),
(1995, 'Xenland.username', '0', 1308198459),
(1996, 'test.username', '295', 1308198459),
(1997, 'Xenland.username', '0', 1308198459),
(1998, 'test.username', '295', 1308198459),
(1999, 'Xenland.username', '0', 1308198461),
(2000, 'test.username', '295', 1308198461),
(2001, 'Xenland.username', '0', 1308198461),
(2002, 'test.username', '295', 1308198461),
(2003, 'Xenland.username', '0', 1308198461),
(2004, 'test.username', '295', 1308198461),
(2005, 'Xenland.username', '0', 1308198461),
(2006, 'test.username', '295', 1308198461),
(2007, 'Xenland.username', '0', 1308198461),
(2008, 'test.username', '295', 1308198461),
(2009, 'Xenland.username', '0', 1308198461),
(2010, 'test.username', '295', 1308198461),
(2011, 'Xenland.username', '0', 1308198461),
(2012, 'test.username', '295', 1308198461),
(2013, 'Xenland.username', '0', 1308198462),
(2014, 'test.username', '295', 1308198462),
(2015, 'Xenland.username', '0', 1308198463),
(2016, 'test.username', '295', 1308198463),
(2017, 'Xenland.username', '0', 1308198464),
(2018, 'test.username', '295', 1308198464),
(2019, 'Xenland.username', '0', 1308198464),
(2020, 'test.username', '295', 1308198464),
(2021, 'Xenland.username', '0', 1308198464),
(2022, 'test.username', '295', 1308198464),
(2023, 'Xenland.username', '0', 1308198465),
(2024, 'test.username', '295', 1308198465),
(2025, 'Xenland.username', '0', 1308198465),
(2026, 'test.username', '295', 1308198465),
(2027, 'Xenland.username', '0', 1308198465),
(2028, 'test.username', '295', 1308198465),
(2029, 'Xenland.username', '0', 1308198466),
(2030, 'test.username', '295', 1308198466),
(2031, 'Xenland.username', '0', 1308198466),
(2032, 'test.username', '308', 1308198466),
(2033, 'Xenland.username', '0', 1308198468),
(2034, 'test.username', '308', 1308198468),
(2035, 'Xenland.username', '0', 1308198468),
(2036, 'test.username', '308', 1308198468),
(2037, 'Xenland.username', '0', 1308198469),
(2038, 'test.username', '308', 1308198469),
(2039, 'Xenland.username', '0', 1308198471),
(2040, 'test.username', '308', 1308198471),
(2041, 'Xenland.username', '0', 1308198471),
(2042, 'test.username', '308', 1308198471),
(2043, 'Xenland.username', '0', 1308198472),
(2044, 'test.username', '308', 1308198472),
(2045, 'Xenland.username', '0', 1308198472),
(2046, 'test.username', '308', 1308198472),
(2047, 'Xenland.username', '0', 1308198477),
(2048, 'test.username', '308', 1308198477),
(2049, 'Xenland.username', '0', 1308198528),
(2050, 'test.username', '268', 1308198528),
(2051, 'Xenland.username', '0', 1308198612),
(2052, 'test.username', '268', 1308198612),
(2053, 'Xenland.username', '0', 1308198684),
(2054, 'test.username', '362', 1308198684),
(2055, 'Xenland.username', '0', 1308199187),
(2056, 'test.username', '215', 1308199187),
(2057, 'Xenland.username', '0', 1308199197),
(2058, 'test.username', '201', 1308199197),
(2059, 'Xenland.username', '0', 1308199398),
(2060, 'test.username', '415', 1308199398),
(2061, 'Xenland.username', '0', 1308199458),
(2062, 'test.username', '469', 1308199458),
(2063, 'Xenland.username', '0', 1308199925),
(2064, 'test.username', '375', 1308199925),
(2065, 'Xenland.username', '0', 1308199928),
(2066, 'test.username', '375', 1308199928),
(2067, 'Xenland.username', '0', 1308199930),
(2068, 'test.username', '375', 1308199930),
(2069, 'Xenland.username', '0', 1308199933),
(2070, 'test.username', '375', 1308199933),
(2071, 'Xenland.username', '0', 1308199939),
(2072, 'test.username', '389', 1308199939),
(2073, 'Xenland.username', '0', 1308199946),
(2074, 'test.username', '375', 1308199946),
(2075, 'Xenland.username', '0', 1308199952),
(2076, 'test.username', '375', 1308199952),
(2077, 'Xenland.username', '0', 1308200190),
(2078, 'test.username', '362', 1308200190),
(2079, 'Xenland.username', '0', 1308218008),
(2080, 'test.username', '0', 1308218008),
(2081, 'Xenland.username', '0', 1308218089),
(2082, 'test.username', '0', 1308218089),
(2083, 'Xenland.username', '0', 1308218124),
(2084, 'test.username', '0', 1308218124),
(2085, 'Xenland.username', '0', 1308218756),
(2086, 'test.username', '0', 1308218756),
(2087, 'Xenland.username', '0', 1308219262),
(2088, 'test.username', '0', 1308219262),
(2089, 'Xenland.username', '0', 1308219910),
(2090, 'test.username', '0', 1308219910),
(2091, 'Xenland.username', '0', 1308221625),
(2092, 'test.username', '0', 1308221625),
(2093, 'Xenland.username', '134', 1308288003),
(2094, 'test.username', '0', 1308288003),
(2095, 'test.username2', '0', 1308288003),
(2096, 'Xenland.username', '161', 1308288081),
(2097, 'test.username', '0', 1308288081),
(2098, 'test.username2', '0', 1308288081),
(2099, 'Xenland.username', '215', 1308288314),
(2100, 'test.username', '0', 1308288314),
(2101, 'test.username2', '0', 1308288314),
(2102, 'Xenland.username', '241', 1308288319),
(2103, 'test.username', '0', 1308288319),
(2104, 'test.username2', '0', 1308288319),
(2105, 'Xenland.username', '241', 1308288321),
(2106, 'test.username', '0', 1308288321),
(2107, 'test.username2', '0', 1308288321),
(2108, 'Xenland.username', '268', 1308288347),
(2109, 'test.username', '0', 1308288347),
(2110, 'test.username2', '0', 1308288347),
(2111, 'Xenland.username', '282', 1308288370),
(2112, 'test.username', '0', 1308288370),
(2113, 'test.username2', '0', 1308288370),
(2114, 'Xenland.username', '308', 1308288407),
(2115, 'test.username', '0', 1308288407),
(2116, 'test.username2', '0', 1308288407),
(2117, 'Xenland.username', '335', 1308288544),
(2118, 'test.username', '0', 1308288544),
(2119, 'test.username2', '0', 1308288544),
(2120, 'Xenland.username', '0', 1308288794),
(2121, 'test.username', '0', 1308288794),
(2122, 'test.username2', '0', 1308288794),
(2123, 'Xenland.username', '349', 1308288837),
(2124, 'test.username', '0', 1308288837),
(2125, 'test.username2', '0', 1308288837),
(2126, 'Xenland.username', '335', 1308288896),
(2127, 'test.username', '0', 1308288896),
(2128, 'test.username2', '0', 1308288896),
(2129, 'Xenland.username', '335', 1308288917),
(2130, 'test.username', '0', 1308288917),
(2131, 'test.username2', '0', 1308288917),
(2132, 'Xenland.username', '375', 1308289029),
(2133, 'test.username', '0', 1308289029),
(2134, 'test.username2', '0', 1308289029),
(2135, 'Xenland.username', '322', 1308289163),
(2136, 'test.username', '0', 1308289163),
(2137, 'test.username2', '0', 1308289163),
(2138, 'Xenland.username', '375', 1308289234),
(2139, 'test.username', '0', 1308289234),
(2140, 'test.username2', '0', 1308289234),
(2141, 'Xenland.username', '349', 1308289246),
(2142, 'test.username', '0', 1308289246),
(2143, 'test.username2', '0', 1308289246),
(2144, 'Xenland.username', '335', 1308290020),
(2145, 'test.username', '0', 1308290020),
(2146, 'test.username2', '0', 1308290020),
(2147, 'Xenland.username', '268', 1308290074),
(2148, 'test.username', '0', 1308290074),
(2149, 'test.username2', '0', 1308290074),
(2150, 'Xenland.username', '268', 1308290081),
(2151, 'test.username', '0', 1308290081),
(2152, 'test.username2', '0', 1308290081),
(2153, 'Xenland.username', '268', 1308290085),
(2154, 'test.username', '0', 1308290085),
(2155, 'test.username2', '0', 1308290085),
(2156, 'Xenland.username', '282', 1308290088),
(2157, 'test.username', '0', 1308290088),
(2158, 'test.username2', '0', 1308290088),
(2159, 'Xenland.username', '268', 1308290433),
(2160, 'test.username', '0', 1308290433),
(2161, 'test.username2', '0', 1308290433),
(2162, 'Xenland.username', '282', 1308290449),
(2163, 'test.username', '0', 1308290449),
(2164, 'test.username2', '0', 1308290449),
(2165, 'Xenland.username', '295', 1308290463),
(2166, 'test.username', '0', 1308290463),
(2167, 'test.username2', '0', 1308290463),
(2168, 'Xenland.username', '282', 1308290469),
(2169, 'test.username', '0', 1308290469),
(2170, 'test.username2', '0', 1308290469),
(2171, 'Xenland.username', '255', 1308290531),
(2172, 'test.username', '0', 1308290531),
(2173, 'test.username2', '0', 1308290531),
(2174, 'Xenland.username', '215', 1308290595),
(2175, 'test.username', '0', 1308290595),
(2176, 'test.username2', '0', 1308290595),
(2177, 'Xenland.username', '188', 1308290616),
(2178, 'test.username', '0', 1308290616),
(2179, 'test.username2', '0', 1308290616),
(2180, 'Xenland.username', '215', 1308290625),
(2181, 'test.username', '0', 1308290625),
(2182, 'test.username2', '0', 1308290625),
(2183, 'Xenland.username', '228', 1308290729),
(2184, 'test.username', '0', 1308290729),
(2185, 'test.username2', '0', 1308290729),
(2186, 'Xenland.username', '295', 1308290786),
(2187, 'test.username', '0', 1308290786),
(2188, 'test.username2', '0', 1308290786),
(2189, 'Xenland.username', '322', 1308290808),
(2190, 'test.username', '0', 1308290808),
(2191, 'test.username2', '0', 1308290808),
(2192, 'Xenland.username', '322', 1308290859),
(2193, 'test.username', '0', 1308290859),
(2194, 'test.username2', '0', 1308290859),
(2195, 'Xenland.username', '322', 1308291462),
(2196, 'test.username', '0', 1308291462),
(2197, 'test.username2', '0', 1308291462),
(2198, 'Xenland.username', '349', 1308291486),
(2199, 'test.username', '0', 1308291486),
(2200, 'test.username2', '0', 1308291486),
(2201, 'Xenland.username', '442', 1308291611),
(2202, 'test.username', '0', 1308291611),
(2203, 'test.username2', '0', 1308291611),
(2204, 'Xenland.username', '429', 1308291658),
(2205, 'test.username', '0', 1308291658),
(2206, 'test.username2', '0', 1308291658),
(2207, 'Xenland.username', '0', 1308294707),
(2208, 'test.username', '0', 1308294707),
(2209, 'test.username2', '0', 1308294707),
(2210, 'Xenland.username', '0', 1308294710),
(2211, 'test.username', '0', 1308294710),
(2212, 'test.username2', '0', 1308294710),
(2213, 'Xenland.username', '0', 1308294867),
(2214, 'test.username', '0', 1308294867),
(2215, 'test.username2', '0', 1308294867),
(2216, 'Xenland.username', '0', 1308295718),
(2217, 'test.username', '0', 1308295718),
(2218, 'test.username2', '0', 1308295718),
(2219, 'Xenland.username', '0', 1308295718),
(2220, 'test.username', '0', 1308295718),
(2221, 'test.username2', '0', 1308295718),
(2222, 'Xenland.username', '0', 1308295718),
(2223, 'test.username', '0', 1308295718),
(2224, 'test.username2', '0', 1308295718),
(2225, 'Xenland.username', '0', 1308295723),
(2226, 'test.username', '0', 1308295723),
(2227, 'test.username2', '0', 1308295723),
(2228, 'Xenland.username', '0', 1308295769),
(2229, 'test.username', '0', 1308295769),
(2230, 'test.username2', '0', 1308295769),
(2231, 'Xenland.username', '0', 1308297180),
(2232, 'test.username', '0', 1308297180),
(2233, 'test.username2', '0', 1308297180),
(2234, 'Xenland.username', '0', 1308297335),
(2235, 'test.username', '0', 1308297335),
(2236, 'test.username2', '0', 1308297335),
(2237, 'Xenland.username', '0', 1308298023),
(2238, 'test.username', '0', 1308298023),
(2239, 'test.username2', '0', 1308298023),
(2240, 'Xenland.username', '0', 1308298782),
(2241, 'test.username', '0', 1308298782),
(2242, 'test.username2', '0', 1308298782),
(2243, 'Xenland.username', '0', 1308299238),
(2244, 'test.username', '0', 1308299238),
(2245, 'test.username2', '0', 1308299238),
(2246, 'Xenland.username', '0', 1308299241),
(2247, 'test.username', '0', 1308299241),
(2248, 'test.username2', '0', 1308299241),
(2249, 'Xenland.username', '0', 1308301903),
(2250, 'test.username', '0', 1308301903),
(2251, 'test.username2', '0', 1308301903),
(2252, 'Xenland.username', '0', 1308302117),
(2253, 'test.username', '0', 1308302117),
(2254, 'test.username2', '0', 1308302117),
(2255, 'Xenland.username', '27', 1308302258),
(2256, 'test.username', '0', 1308302258),
(2257, 'test.username2', '0', 1308302258),
(2258, 'Xenland.username', '27', 1308302262),
(2259, 'test.username', '0', 1308302262),
(2260, 'test.username2', '0', 1308302262),
(2261, 'Xenland.username', '121', 1308302349),
(2262, 'test.username', '0', 1308302349),
(2263, 'test.username2', '0', 1308302349),
(2264, 'Xenland.username2', '0', 1308302349),
(2265, 'Xenland.username', '295', 1308302703),
(2266, 'test.username', '0', 1308302703),
(2267, 'test.username2', '0', 1308302703),
(2268, 'Xenland.username2', '0', 1308302703),
(2269, 'Xenland.username', '241', 1308302842),
(2270, 'test.username', '0', 1308302842),
(2271, 'test.username2', '0', 1308302842),
(2272, 'Xenland.username2', '0', 1308302842),
(2273, 'Xenland.username', '188', 1308302895),
(2274, 'test.username', '0', 1308302895),
(2275, 'test.username2', '0', 1308302895),
(2276, 'Xenland.username2', '0', 1308302895),
(2277, 'Xenland.username', '175', 1308302904),
(2278, 'test.username', '0', 1308302904),
(2279, 'test.username2', '0', 1308302904),
(2280, 'Xenland.username2', '0', 1308302904),
(2281, 'Xenland.username', '295', 1308303012),
(2282, 'test.username', '0', 1308303012),
(2283, 'test.username2', '0', 1308303012),
(2284, 'Xenland.username2', '0', 1308303012),
(2285, 'Xenland.username', '322', 1308303021),
(2286, 'test.username', '0', 1308303021),
(2287, 'test.username2', '0', 1308303021),
(2288, 'Xenland.username2', '0', 1308303021),
(2289, 'Xenland.username', '375', 1308303079),
(2290, 'test.username', '0', 1308303079),
(2291, 'test.username2', '0', 1308303079),
(2292, 'Xenland.username2', '0', 1308303079),
(2293, 'Xenland.username', '349', 1308303132),
(2294, 'test.username', '0', 1308303132),
(2295, 'test.username2', '0', 1308303132),
(2296, 'Xenland.username2', '0', 1308303132),
(2297, 'Xenland.username', '389', 1308303233),
(2298, 'test.username', '0', 1308303233),
(2299, 'test.username2', '0', 1308303233),
(2300, 'Xenland.username2', '0', 1308303233),
(2301, 'Xenland.username', '308', 1308303273),
(2302, 'test.username', '0', 1308303273),
(2303, 'test.username2', '0', 1308303273),
(2304, 'Xenland.username2', '0', 1308303273),
(2305, 'Xenland.username', '295', 1308303278),
(2306, 'test.username', '0', 1308303278),
(2307, 'test.username2', '0', 1308303278),
(2308, 'Xenland.username2', '0', 1308303278);

=======
>>>>>>> f9332a8ad0cd4e27505f162718c69fc8ea297aa7
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
  `serverFeePercentage` varchar(20) NOT NULL,
<<<<<<< HEAD
  `cashoutMinimum` varchar(5) NOT NULL COMMENT 'The minimum balance required before a user can cash out',
  `footerWelcomeTitle` varchar(255) NOT NULL,
  `footerWelcomeContent` text NOT NULL
=======
  `cashoutMinimum` varchar(5) NOT NULL COMMENT 'The minimum balance required before a user can cash out'
>>>>>>> f9332a8ad0cd4e27505f162718c69fc8ea297aa7
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `websiteSettings`
--

<<<<<<< HEAD
INSERT INTO `websiteSettings` (`header`, `noreplyEmail`, `confirmEmailPrefix`, `slogan`, `browserTitle`, `cashoutMinimum`, `footerWelcomeTitle`, `footerWelcomeContent`) VALUES
('Mining Farm #2', 'no-reply@yourdomain.com', 'Welcome you "Your pool name here" glad you are interested in our services, In order to activate your account you must click the link provided and you will be allowed immediate login access past this point. Thank you for you time.', 'IP:173.212.217.202 · PORT: 8341', 'Mining Farm #2 | Mining Pool', '1', '', '');
=======
INSERT INTO `websiteSettings` (`header`, `noreplyEmail`, `confirmEmailPrefix`, `slogan`, `browserTitle`, `cashoutMinimum`) VALUES
('Mining Pool v3', 'no-reply@yourdomain.com', 'Welcome you "Your pool name here" glad you are interested in our services, In order to activate your account you must click the link provided and you will be allowed immediate login access past this point. Thank you for you time.', 'IP:66.197.184.28 · PORT: 8341', 'Mining Pool', '1');
>>>>>>> f9332a8ad0cd4e27505f162718c69fc8ea297aa7

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
<<<<<<< HEAD
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=45 ;
=======
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=43 ;
>>>>>>> f9332a8ad0cd4e27505f162718c69fc8ea297aa7

--
-- Dumping data for table `websiteUsers`
--

