-- phpMyAdmin SQL Dump
-- version 2.10.1
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Jun 26, 2008 at 11:01 AM
-- Server version: 5.0.41
-- PHP Version: 5.2.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Database: `CourseMSver1_3beta`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `bands`
-- 

CREATE TABLE `bands` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(40) collate latin1_general_ci NOT NULL,
  `deleted` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `bands`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `calendar`
-- 

CREATE TABLE `calendar` (
  `id` int(11) NOT NULL auto_increment,
  `course_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `dates` text collate latin1_general_ci NOT NULL,
  `resources` text collate latin1_general_ci,
  `instructors` text collate latin1_general_ci COMMENT 'serialized array of instructor id''s',
  `instructor1` int(11) default NULL,
  `instructor2` int(11) default NULL,
  `instructor3` int(11) default NULL,
  `reg_online` int(2) NOT NULL default '0',
  `registered` int(11) NOT NULL default '0',
  `waiting_list` int(11) NOT NULL default '0',
  `cancelled` int(11) NOT NULL default '0',
  `user_id` int(11) NOT NULL,
  `cDate` datetime default NULL,
  `mDate` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `calendar`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `centers`
-- 

CREATE TABLE `centers` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) collate latin1_general_ci NOT NULL,
  `address_line1` varchar(70) collate latin1_general_ci NOT NULL,
  `address_line2` varchar(50) collate latin1_general_ci NOT NULL,
  `city` varchar(50) collate latin1_general_ci NOT NULL,
  `country` varchar(50) collate latin1_general_ci NOT NULL,
  `postcode` varchar(20) collate latin1_general_ci NOT NULL,
  `contact_name` varchar(50) collate latin1_general_ci NOT NULL,
  `contact_phone` varchar(20) collate latin1_general_ci NOT NULL,
  `contact_fax` varchar(20) collate latin1_general_ci NOT NULL,
  `contact_email` varchar(100) collate latin1_general_ci NOT NULL,
  `deleted` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `centers`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `courses`
-- 

CREATE TABLE `courses` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) collate latin1_general_ci NOT NULL,
  `description` text collate latin1_general_ci,
  `cDate` datetime NOT NULL,
  `mDate` datetime NOT NULL,
  `min_instructors` int(11) default NULL,
  `max_attendance` int(11) NOT NULL,
  `min_attendance` int(11) NOT NULL,
  `category` varchar(50) collate latin1_general_ci NOT NULL default '0',
  `center` varchar(50) collate latin1_general_ci NOT NULL default '0',
  `type` int(11) NOT NULL default '1',
  `deleted` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `courses`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `course_categories`
-- 

CREATE TABLE `course_categories` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) collate latin1_general_ci NOT NULL,
  `description` text collate latin1_general_ci,
  `deleted` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `course_categories`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `course_types`
-- 

CREATE TABLE `course_types` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) collate latin1_general_ci NOT NULL,
  `description` text collate latin1_general_ci,
  `deleted` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `course_types`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `diet`
-- 

CREATE TABLE `diet` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(40) collate latin1_general_ci default NULL,
  `deleted` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `diet`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `files`
-- 

CREATE TABLE `files` (
  `id` int(11) NOT NULL auto_increment,
  `folder_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `file_type` varchar(35) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `visible` varchar(11) NOT NULL,
  `order_number` int(11) NOT NULL,
  `cDate` datetime NOT NULL,
  `deleted` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `files`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `folders`
-- 

CREATE TABLE `folders` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL,
  `center` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `course` int(11) NOT NULL,
  `parentfolder` int(11) NOT NULL default '0' COMMENT 'In case of course subfolders this value will be set',
  `visible` varchar(3) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `cDate` datetime NOT NULL,
  `mDate` datetime NOT NULL,
  `deleted` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `folders`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `how_hear`
-- 

CREATE TABLE `how_hear` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(40) collate latin1_general_ci default NULL,
  `deleted` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `how_hear`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `instructors`
-- 

CREATE TABLE `instructors` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `name` varchar(60) collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `instructors`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `jobs`
-- 

CREATE TABLE `jobs` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) collate latin1_general_ci NOT NULL,
  `cDate` datetime NOT NULL,
  `mDate` datetime NOT NULL,
  `deleted` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `jobs`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `notes`
-- 

CREATE TABLE `notes` (
  `id` int(11) NOT NULL auto_increment,
  `admin_id` int(11) NOT NULL,
  `user_id` int(11) default NULL,
  `calendar_id` int(11) default NULL,
  `description` longtext NOT NULL,
  `cDate` datetime NOT NULL,
  `deleted` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `notes`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `profiles`
-- 

CREATE TABLE `profiles` (
  `profile_id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `title` varchar(6) collate latin1_general_ci default NULL,
  `firstname` varchar(40) collate latin1_general_ci NOT NULL,
  `lastname` varchar(40) collate latin1_general_ci NOT NULL,
  `email` varchar(60) collate latin1_general_ci NOT NULL,
  `hospital_name` varchar(60) collate latin1_general_ci NOT NULL,
  `home_telephone` varchar(15) collate latin1_general_ci default NULL,
  `work_telephone` varchar(15) collate latin1_general_ci default NULL,
  `mobile_telephone` varchar(15) collate latin1_general_ci default NULL,
  `bleep` varchar(15) collate latin1_general_ci default NULL,
  `address_line1` varchar(50) collate latin1_general_ci NOT NULL,
  `address_line2` varchar(50) collate latin1_general_ci default NULL,
  `city` varchar(40) collate latin1_general_ci NOT NULL,
  `county` varchar(30) collate latin1_general_ci default NULL,
  `country` varchar(35) collate latin1_general_ci default NULL,
  `postcode` varchar(10) collate latin1_general_ci NOT NULL,
  `cDate` datetime NOT NULL,
  `mDate` datetime NOT NULL,
  `job_title_id` int(11) NOT NULL,
  `specialty_id` int(11) default NULL,
  `band` int(11) default NULL,
  `gmc_reg` int(11) default NULL,
  `diet` int(11) default NULL,
  `how_hear` int(11) default NULL,
  `qualifications` varchar(50) collate latin1_general_ci default NULL,
  `photo` varchar(100) collate latin1_general_ci NOT NULL,
  `instructor` int(11) NOT NULL,
  PRIMARY KEY  (`profile_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `profiles`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `registrations`
-- 

CREATE TABLE `registrations` (
  `id` int(11) NOT NULL auto_increment,
  `calendar_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` varchar(40) collate latin1_general_ci NOT NULL,
  `cDate` datetime NOT NULL,
  `mDate` datetime NOT NULL,
  `deleted` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `registrations`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `reporting`
-- 

CREATE TABLE `reporting` (
  `id` int(11) NOT NULL auto_increment,
  `calendar_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `attended` int(11) default NULL,
  `pass` int(11) default NULL,
  `fail` int(11) default NULL,
  `mark` int(11) default NULL,
  `comment` varchar(200) collate latin1_general_ci default NULL,
  `cDate` datetime NOT NULL,
  `mDate` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `reporting`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `requirements`
-- 

CREATE TABLE `requirements` (
  `id` int(11) NOT NULL auto_increment,
  `course_id` int(11) NOT NULL,
  `requirement_id` int(11) NOT NULL,
  `requirement_type` varchar(30) collate latin1_general_ci NOT NULL,
  `cDate` datetime NOT NULL,
  `mDate` datetime NOT NULL,
  `deleted` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `requirements`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `resources`
-- 

CREATE TABLE `resources` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) collate latin1_general_ci NOT NULL,
  `type` varchar(15) collate latin1_general_ci NOT NULL default '0',
  `center` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `resources`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `resource_type`
-- 

CREATE TABLE `resource_type` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) collate latin1_general_ci NOT NULL,
  `order_value` int(11) NOT NULL default '0',
  `deleted` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `resource_type`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `specialties`
-- 

CREATE TABLE `specialties` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(40) collate latin1_general_ci NOT NULL,
  `deleted` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `specialties`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `status`
-- 

CREATE TABLE `status` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL,
  `colour` varchar(15) NOT NULL default '0',
  `def` varchar(10) NOT NULL default '0',
  `cDate` datetime NOT NULL,
  `mDate` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

-- 
-- Dumping data for table `status`
-- 

INSERT INTO `status` (`id`, `name`, `colour`, `def`, `cDate`, `mDate`) VALUES 
(2, 'Paid', 'green', '0', '2007-10-23 14:35:38', '2007-10-23 15:01:41'),
(4, 'Place Offered', 'green', '0', '2007-10-23 15:34:07', '2007-10-23 15:34:07'),
(5, 'Registered Interest', 'green', '1', '2007-10-23 15:34:31', '2007-10-23 15:34:31'),
(6, 'Waiting List', 'orange', '0', '2007-10-23 15:34:52', '2007-10-23 15:34:52'),
(7, 'Cancelled', 'red', '0', '2007-10-23 15:35:15', '2007-10-23 15:35:15');

-- --------------------------------------------------------

-- 
-- Table structure for table `surveys`
-- 

CREATE TABLE `surveys` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) collate latin1_general_ci NOT NULL,
  `phpesp_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `surveys`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `titles`
-- 

CREATE TABLE `titles` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(10) collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `titles`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `users`
-- 

CREATE TABLE `users` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(80) collate latin1_general_ci NOT NULL,
  `password` varchar(32) collate latin1_general_ci NOT NULL,
  `admin` int(11) NOT NULL default '0',
  `center` int(11) NOT NULL default '0',
  `type` int(11) default NULL,
  `instructor` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=120 ;

-- 
-- Dumping data for table `users`
-- 

INSERT INTO `users` (`id`, `username`, `password`, `admin`, `center`, `type`, `instructor`) VALUES 
(1, 'admin', '704b037a97fa9b25522b7c014c300f8a', 1, 0, 0, 0);
