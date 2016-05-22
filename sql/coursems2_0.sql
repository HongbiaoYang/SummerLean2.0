-- phpMyAdmin SQL Dump
-- version 3.1.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 28, 2009 at 08:04 PM
-- Server version: 5.1.30
-- PHP Version: 5.2.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
--

-- --------------------------------------------------------

--
-- Table structure for table `bands`
--

CREATE TABLE IF NOT EXISTS `bands` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) COLLATE latin1_general_ci NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `bands`
--


-- --------------------------------------------------------

--
-- Table structure for table `calendar`
--

CREATE TABLE IF NOT EXISTS `calendar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `dates` text COLLATE latin1_general_ci NOT NULL,
  `resources` text COLLATE latin1_general_ci,
  `instructors` text COLLATE latin1_general_ci COMMENT 'serialized array of instructor id''s',
  `reg_online` int(2) NOT NULL DEFAULT '0',
  `registered` int(11) NOT NULL DEFAULT '0',
  `waiting_list` int(11) NOT NULL DEFAULT '0',
  `cancelled` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL,
  `cDate` datetime DEFAULT NULL,
  `mDate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=9 ;

--
-- Dumping data for table `calendar`
--


-- --------------------------------------------------------

--
-- Table structure for table `centers`
--

CREATE TABLE IF NOT EXISTS `centers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `address_line1` varchar(70) COLLATE latin1_general_ci NOT NULL,
  `address_line2` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `city` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `country` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `postcode` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `contact_name` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `contact_phone` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `contact_fax` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `contact_email` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `gmaplat` varchar(20) COLLATE latin1_general_ci DEFAULT NULL,
  `gmaplon` varchar(20) COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `centers`
--


-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE IF NOT EXISTS `courses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `description` text COLLATE latin1_general_ci,
  `cDate` datetime NOT NULL,
  `mDate` datetime NOT NULL,
  `min_instructors` int(11) DEFAULT NULL,
  `max_attendance` int(11) NOT NULL,
  `min_attendance` int(11) NOT NULL,
  `default_start_time` time NOT NULL DEFAULT '00:00:00',
  `default_end_time` time NOT NULL DEFAULT '00:00:00',
  `category` varchar(50) COLLATE latin1_general_ci NOT NULL DEFAULT '0',
  `center` varchar(50) COLLATE latin1_general_ci NOT NULL DEFAULT '0',
  `type` int(11) NOT NULL DEFAULT '1',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `courses`
--

-- --------------------------------------------------------

--
-- Table structure for table `course_categories`
--

CREATE TABLE IF NOT EXISTS `course_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `description` text COLLATE latin1_general_ci,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `course_categories`
--


-- --------------------------------------------------------

--
-- Table structure for table `course_types`
--

CREATE TABLE IF NOT EXISTS `course_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `description` text COLLATE latin1_general_ci,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `course_types`
--


-- --------------------------------------------------------

--
-- Table structure for table `details`
--

CREATE TABLE IF NOT EXISTS `details` (
  `surname` varchar(30) NOT NULL,
  `firstname` varchar(30) NOT NULL,
  `title` varchar(10) NOT NULL,
  `elective` varchar(5) NOT NULL,
  `sub` varchar(6) NOT NULL,
  `cid` varchar(10) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `details`
--


-- --------------------------------------------------------

--
-- Table structure for table `diet`
--

CREATE TABLE IF NOT EXISTS `diet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) COLLATE latin1_general_ci DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `diet`
--

INSERT INTO `diet` (`id`, `name`, `deleted`) VALUES
(1, 'Wheelchair Access', 0),
(2, 'None', 0),
(3, 'Front Seat', 0),
(4, 'Induction Loop', 0);

-- --------------------------------------------------------

--
-- Table structure for table `domains`
--

CREATE TABLE IF NOT EXISTS `domains` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `cDate` datetime NOT NULL,
  `mDate` datetime NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `domains`
--

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE IF NOT EXISTS `files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `folder_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `file_type` varchar(35) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `visible` varchar(11) NOT NULL,
  `order_number` int(11) NOT NULL,
  `cDate` datetime NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `files`
--


-- --------------------------------------------------------

--
-- Table structure for table `folders`
--

CREATE TABLE IF NOT EXISTS `folders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `center` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `course` int(11) NOT NULL,
  `parentfolder` int(11) NOT NULL DEFAULT '0' COMMENT 'In case of course subfolders this value will be set',
  `visible` varchar(3) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `cDate` datetime NOT NULL,
  `mDate` datetime NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `folders`
--


-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `cDate` datetime NOT NULL,
  `mDate` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `groups`
--


-- --------------------------------------------------------

--
-- Table structure for table `group_users`
--

CREATE TABLE IF NOT EXISTS `group_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `group_users`
--


-- --------------------------------------------------------

--
-- Table structure for table `how_hear`
--

CREATE TABLE IF NOT EXISTS `how_hear` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) COLLATE latin1_general_ci DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `how_hear`
--


-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE IF NOT EXISTS `jobs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `cDate` datetime NOT NULL,
  `mDate` datetime NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `jobs`
--


-- --------------------------------------------------------
--
-- Table structure for table `notes`
--

CREATE TABLE IF NOT EXISTS `notes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `calendar_id` int(11) DEFAULT NULL,
  `description` longtext NOT NULL,
  `cDate` datetime NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `notes`
--


-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE IF NOT EXISTS `profiles` (
  `profile_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(6) COLLATE latin1_general_ci DEFAULT NULL,
  `firstname` varchar(40) COLLATE latin1_general_ci NOT NULL,
  `lastname` varchar(40) COLLATE latin1_general_ci NOT NULL,
  `email` varchar(60) COLLATE latin1_general_ci DEFAULT NULL,
  `email2` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `hospital_name` varchar(60) COLLATE latin1_general_ci DEFAULT NULL,
  `home_telephone` varchar(15) COLLATE latin1_general_ci DEFAULT NULL,
  `mobile` varchar(15) COLLATE latin1_general_ci DEFAULT NULL,
  `mobile_telephone` varchar(15) COLLATE latin1_general_ci DEFAULT NULL,
  `bleep` varchar(15) COLLATE latin1_general_ci DEFAULT NULL,
  `address_line1` varchar(50) COLLATE latin1_general_ci DEFAULT NULL,
  `address_line2` varchar(50) COLLATE latin1_general_ci DEFAULT NULL,
  `city` varchar(40) COLLATE latin1_general_ci DEFAULT NULL,
  `county` varchar(30) COLLATE latin1_general_ci DEFAULT NULL,
  `country` varchar(35) COLLATE latin1_general_ci DEFAULT NULL,
  `postcode` varchar(10) COLLATE latin1_general_ci DEFAULT NULL,
  `cDate` datetime NOT NULL,
  `mDate` datetime NOT NULL,
  `job_title_id` int(11) DEFAULT NULL,
  `specialty_id` int(11) DEFAULT NULL,
  `specialty2_id` int(11) DEFAULT NULL,
  `band` int(11) DEFAULT NULL,
  `gmc_reg` int(11) DEFAULT NULL,
  `diet` int(11) DEFAULT NULL,
  `how_hear` int(11) DEFAULT NULL,
  `qualifications` varchar(50) COLLATE latin1_general_ci DEFAULT NULL,
  `photo` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `instructor` int(11) DEFAULT NULL,
  `accessibility` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`profile_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1981 ;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`profile_id`, `user_id`, `title`, `firstname`, `lastname`, `email`, `email2`, `hospital_name`, `home_telephone`, `mobile`, `mobile_telephone`, `bleep`, `address_line1`, `address_line2`, `city`, `county`, `country`, `postcode`, `cDate`, `mDate`, `job_title_id`, `specialty_id`, `specialty2_id`, `band`, `gmc_reg`, `diet`, `how_hear`, `qualifications`, `photo`, `instructor`, `accessibility`) VALUES
(62, 1, 'mr', 'Admin', 'User', 'admin', NULL, '', '', '', '', '', '', '', '', '', '', '', '2008-02-27 10:36:39', '2008-02-27 10:36:39', 0, 0, 0, 0, 0, 0, 0, '', '', 0, 0);
-- --------------------------------------------------------

--
-- Table structure for table `registrations`
--

CREATE TABLE IF NOT EXISTS `registrations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `calendar_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` varchar(40) COLLATE latin1_general_ci NOT NULL,
  `cDate` datetime NOT NULL,
  `mDate` datetime NOT NULL,
  `cancelled` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=19 ;

--
-- Dumping data for table `registrations`
--

-- --------------------------------------------------------

--
-- Table structure for table `reporting`
--

CREATE TABLE IF NOT EXISTS `reporting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `calendar_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `attended` int(11) DEFAULT NULL,
  `pass` int(11) DEFAULT NULL,
  `fail` int(11) DEFAULT NULL,
  `mark` int(11) DEFAULT NULL,
  `comment` varchar(200) COLLATE latin1_general_ci DEFAULT NULL,
  `cDate` datetime NOT NULL,
  `mDate` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=47 ;

--
-- Dumping data for table `reporting`
--

-- --------------------------------------------------------

--
-- Table structure for table `requirements`
--

CREATE TABLE IF NOT EXISTS `requirements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) NOT NULL,
  `requirement_id` int(11) NOT NULL,
  `requirement_type` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `cDate` datetime NOT NULL,
  `mDate` datetime NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=9 ;

--
-- Dumping data for table `requirements`
--

-- --------------------------------------------------------

--
-- Table structure for table `resources`
--

CREATE TABLE IF NOT EXISTS `resources` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `type` varchar(15) COLLATE latin1_general_ci NOT NULL DEFAULT '0',
  `center` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `resources`
--


-- --------------------------------------------------------

--
-- Table structure for table `resource_type`
--

CREATE TABLE IF NOT EXISTS `resource_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `order_value` int(11) NOT NULL DEFAULT '0',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `resource_type`
--

-- --------------------------------------------------------

--
-- Table structure for table `specialties`
--

CREATE TABLE IF NOT EXISTS `specialties` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) COLLATE latin1_general_ci NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `specialties`
--


-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE IF NOT EXISTS `status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `colour` varchar(15) NOT NULL DEFAULT '0',
  `def` varchar(10) NOT NULL DEFAULT '0',
  `type` varchar(20) DEFAULT NULL,
  `cDate` datetime NOT NULL,
  `mDate` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id`, `name`, `colour`, `def`, `type`, `cDate`, `mDate`) VALUES
(2, 'Registered Interest', 'green', '0', 'register', '2007-10-23 14:35:38', '2008-04-10 16:40:37'),
(4, 'Waiting List', 'orange', '0', 'waiting', '2007-10-23 15:34:07', '2008-04-10 16:46:38'),
(5, 'Place Offered', 'green', '0', 'register', '2007-10-23 15:34:31', '2008-04-10 16:41:30'),
(6, 'Booked', 'green', '1', 'register', '2007-10-23 15:34:52', '2008-04-10 16:41:45'),
(7, 'Cancelled', 'red', '0', 'cancel', '2007-10-23 15:35:15', '2007-10-23 15:35:15');

-- --------------------------------------------------------

--
-- Table structure for table `surveys`
--

CREATE TABLE IF NOT EXISTS `surveys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `phpesp_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `surveys`
--


-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(80) COLLATE latin1_general_ci NOT NULL,
  `password` varchar(32) COLLATE latin1_general_ci NOT NULL,
  `admin` int(11) NOT NULL DEFAULT '0',
  `center` int(11) NOT NULL DEFAULT '0',
  `type` int(11) NOT NULL DEFAULT '0',
  `instructor` int(11) NOT NULL DEFAULT '0',
  `active` int(10) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=2721 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `admin`, `center`, `type`, `instructor`, `active`) VALUES
(1, 'admin', '704b037a97fa9b25522b7c014c300f8a', 1, 0, 0, 0, 0);