-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 09, 2015 at 05:48 PM
-- Server version: 5.5.32
-- PHP Version: 5.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `campaign`
--

-- --------------------------------------------------------

--
-- Table structure for table `accesslevel`
--

CREATE TABLE IF NOT EXISTS `accesslevel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `accesslevel`
--

INSERT INTO `accesslevel` (`id`, `name`) VALUES
(1, 'admin'),
(3, 'Customer'),
(2, 'Designer');

-- --------------------------------------------------------

--
-- Table structure for table `campaigngroupstatus`
--

CREATE TABLE IF NOT EXISTS `campaigngroupstatus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `campaigngroupstatus`
--

INSERT INTO `campaigngroupstatus` (`id`, `name`) VALUES
(1, 'Active'),
(2, 'Rejected'),
(3, 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `campaignstatus`
--

CREATE TABLE IF NOT EXISTS `campaignstatus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `campaignstatus`
--

INSERT INTO `campaignstatus` (`id`, `name`) VALUES
(1, 'Assigning Groups'),
(2, 'Group Assigned Completed'),
(3, 'AB Testing Pending'),
(4, 'AB Testing Completed'),
(5, 'Publishing Pending'),
(6, 'Publishing Completed');

-- --------------------------------------------------------

--
-- Table structure for table `campaign_campaign`
--

CREATE TABLE IF NOT EXISTS `campaign_campaign` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL,
  `startdate` date NOT NULL,
  `testdate` date NOT NULL,
  `publishingdate` date NOT NULL,
  `user` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `campaign_campaign`
--

INSERT INTO `campaign_campaign` (`id`, `Name`, `startdate`, `testdate`, `publishingdate`, `user`, `status`) VALUES
(5, 'demo edit', '2015-03-04', '2015-03-05', '2015-03-05', 13, 1),
(7, 'demo2', '2015-03-07', '2015-03-06', '2015-03-08', 1, 6),
(8, 'demo2', '2015-03-07', '2015-03-06', '2015-03-08', 1, 1),
(9, 'avinashcampaign', '2015-03-08', '2015-03-10', '2015-03-12', 14, 6),
(10, 'Chintan', '2015-03-11', '2015-03-13', '2015-03-15', 14, 6),
(11, 'Mahesh', '2015-03-15', '2015-03-18', '2015-03-19', 14, 6),
(12, 'Test', '2015-03-05', '2015-03-07', '2015-03-14', 14, 6);

-- --------------------------------------------------------

--
-- Table structure for table `campaign_campaigngroup`
--

CREATE TABLE IF NOT EXISTS `campaign_campaigngroup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `campaign` varchar(255) NOT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `order` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `campaign_campaigngroup`
--

INSERT INTO `campaign_campaigngroup` (`id`, `campaign`, `Timestamp`, `order`, `status`, `group`) VALUES
(1, '5', '2015-03-07 06:29:43', '1', '1', '2'),
(2, '7', '2015-03-07 04:32:57', '1', '1', '2'),
(3, '7', '2015-03-05 11:30:25', '2', '1', '3'),
(4, '7', '2015-03-05 11:30:31', '3', '3', '4'),
(5, '5', '2015-03-07 07:57:17', '1', '2', '3'),
(6, '5', '2015-03-07 07:57:23', 'demooo', '1', '4'),
(7, '9', '2015-03-07 10:10:42', '1', '1', '2'),
(8, '9', '2015-03-07 10:10:53', '2', '1', '3'),
(9, '9', '2015-03-07 10:10:35', '3', '2', '4'),
(10, '10', '2015-03-09 05:48:35', '1', '1', '5'),
(11, '10', '2015-03-09 05:54:16', '2', '2', '6'),
(12, '10', '2015-03-09 05:54:21', '3', '1', '2'),
(13, '11', '2015-03-09 07:54:08', '1', '1', '5'),
(14, '11', '2015-03-09 08:01:10', '2', '1', '6'),
(15, '11', '2015-03-09 07:54:57', '3', '2', '2'),
(16, '12', '2015-03-09 11:13:09', '1', '1', '5'),
(17, '12', '2015-03-09 11:13:12', '2', '1', '6'),
(18, '12', '2015-03-09 11:13:00', '3', '2', '2');

-- --------------------------------------------------------

--
-- Table structure for table `campaign_campaignresult`
--

CREATE TABLE IF NOT EXISTS `campaign_campaignresult` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `reports` text NOT NULL,
  `campaign` varchar(255) NOT NULL,
  `group` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `campaign_campaignresult`
--

INSERT INTO `campaign_campaignresult` (`id`, `Timestamp`, `reports`, `campaign`, `group`) VALUES
(1, '2015-03-05 12:51:25', '[{"label":"Open Rate","type":"text","classes":"","placeholder":"","value":"23"},{"label":"Click Rate","type":"text","classes":"","placeholder":"","value":"21"}]', '7', 2),
(2, '2015-03-07 10:34:00', '[{"label":"Open Rate","type":"text","classes":"","placeholder":"","value":"30"},{"label":"Click Rate","type":"text","classes":"","placeholder":"","value":"25"}]', '9', 2),
(3, '2015-03-09 05:55:52', '[{"label":"Open Rate","type":"text","classes":"","placeholder":"","value":"30"},{"label":"Click Rate","type":"text","classes":"","placeholder":"","value":"25"}]', '10', 2),
(4, '2015-03-09 10:34:55', '[{"label":"Open Rate","type":"text","classes":"","placeholder":"","value":"40"},{"label":"Click Rate","type":"text","classes":"","placeholder":"","value":"33"}]', '11', 6),
(5, '2015-03-09 11:15:10', '[{"label":"Open Rate","type":"text","classes":"","placeholder":"","value":"50"},{"label":"Click Rate","type":"text","classes":"","placeholder":"","value":"40"}]', '12', 6);

-- --------------------------------------------------------

--
-- Table structure for table `campaign_campaigntest`
--

CREATE TABLE IF NOT EXISTS `campaign_campaigntest` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `campaign` varchar(255) NOT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `group` int(11) NOT NULL,
  `reports` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `campaign_campaigntest`
--

INSERT INTO `campaign_campaigntest` (`id`, `campaign`, `Timestamp`, `group`, `reports`) VALUES
(1, '7', '2015-03-05 12:25:52', 2, '[{"label":"Open Rate","type":"text","classes":"","placeholder":"","value":"20"},{"label":"Click Rate","type":"text","classes":"","placeholder":"","value":"18"}]'),
(2, '7', '2015-03-05 12:14:26', 3, '[{"label":"Open Rate","type":"text","classes":"","placeholder":"","value":"20"},{"label":"Click Rate","type":"text","classes":"","placeholder":"","value":"19"}]'),
(3, '9', '2015-03-07 10:30:45', 2, '[{"label":"Open Rate","type":"text","classes":"","placeholder":"","value":"20"},{"label":"Click Rate","type":"text","classes":"","placeholder":"","value":"15"}]'),
(4, '9', '2015-03-07 10:30:56', 3, '[{"label":"Open Rate","type":"text","classes":"","placeholder":"","value":"30"},{"label":"Click Rate","type":"text","classes":"","placeholder":"","value":"25"}]'),
(5, '10', '2015-03-09 05:52:24', 2, '[{"label":"Open Rate","type":"text","classes":"","placeholder":"","value":"30"},{"label":"Click Rate","type":"text","classes":"","placeholder":"","value":"25"}]'),
(6, '10', '2015-03-09 05:52:36', 5, '[{"label":"Open Rate","type":"text","classes":"","placeholder":"","value":"20"},{"label":"Click Rate","type":"text","classes":"","placeholder":"","value":"15"}]'),
(9, '11', '2015-03-09 09:40:48', 5, '[{"label":"Open Rate","type":"text","classes":"","placeholder":"","value":"20"},{"label":"Click Rate","type":"text","classes":"","placeholder":"","value":"19"}]'),
(11, '11', '2015-03-09 10:34:26', 6, '[{"label":"Open Rate","type":"text","classes":"","placeholder":"","value":"40"},{"label":"Click Rate","type":"text","classes":"","placeholder":"","value":"33"}]'),
(12, '12', '2015-03-09 11:14:24', 5, '[{"label":"Open Rate","type":"text","classes":"","placeholder":"","value":"49"},{"label":"Click Rate","type":"text","classes":"","placeholder":"","value":"40"}]'),
(13, '12', '2015-03-09 11:14:35', 6, '[{"label":"Open Rate","type":"text","classes":"","placeholder":"","value":"50"},{"label":"Click Rate","type":"text","classes":"","placeholder":"","value":"40"}]');

-- --------------------------------------------------------

--
-- Table structure for table `campaign_group`
--

CREATE TABLE IF NOT EXISTS `campaign_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL,
  `designer` int(11) NOT NULL,
  `contentwriter` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `campaign_group`
--

INSERT INTO `campaign_group` (`id`, `Name`, `designer`, `contentwriter`) VALUES
(2, 'demo2', 5, 1),
(3, 'demo3', 5, 1),
(4, 'demo', 5, 1),
(5, 'Group 1', 4, 5),
(6, 'Group 2', 6, 7);

-- --------------------------------------------------------

--
-- Table structure for table `campaign_order`
--

CREATE TABLE IF NOT EXISTS `campaign_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(255) NOT NULL,
  `Plan` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `campaign_order`
--

INSERT INTO `campaign_order` (`id`, `user`, `Plan`, `status`, `Timestamp`) VALUES
(1, '1', 2, 2, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `campaign_plan`
--

CREATE TABLE IF NOT EXISTS `campaign_plan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL,
  `Duration` varchar(255) NOT NULL,
  `Amount` varchar(255) NOT NULL,
  `numberofcampaigns` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `campaign_plan`
--

INSERT INTO `campaign_plan` (`id`, `Name`, `Duration`, `Amount`, `numberofcampaigns`) VALUES
(2, 'dmeo', '12', '15000', '2'),
(4, 'demo2', '23', '10000', '3'),
(5, 'demo3 sss', '23', '20000', '4');

-- --------------------------------------------------------

--
-- Table structure for table `logintype`
--

CREATE TABLE IF NOT EXISTS `logintype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `logintype`
--

INSERT INTO `logintype` (`id`, `name`) VALUES
(1, 'Facebook'),
(2, 'Twitter'),
(3, 'Email'),
(4, 'Google');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `keyword` varchar(255) NOT NULL,
  `url` text NOT NULL,
  `linktype` int(11) NOT NULL,
  `parent` int(11) NOT NULL,
  `isactive` int(11) NOT NULL,
  `order` int(11) NOT NULL,
  `icon` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `name`, `description`, `keyword`, `url`, `linktype`, `parent`, `isactive`, `order`, `icon`) VALUES
(1, 'Users', '', '', 'site/viewusers', 1, 0, 1, 1, 'icon-user'),
(4, 'Dashboard', '', '', 'site/index', 1, 0, 1, 0, 'icon-dashboard'),
(5, 'plan list', '', '', 'site/viewplan', 1, 0, 1, 1, 'icon-dashboard'),
(6, 'Order List', '', '', 'site/vieworder', 1, 0, 1, 1, 'icon-dashboard'),
(7, 'Campaign', '', '', 'site/viewcampaign', 1, 0, 1, 1, 'icon-dashboard'),
(8, 'Group List\r\n', '', '', 'site/viewgroup', 1, 0, 1, 1, 'icon-dashboard'),
(9, 'Campaign Group List', '', '', 'site/viewcampaigngroup', 1, 0, 1, 1, ''),
(10, 'Campaign Test List\r\n', '', '', 'site/viewCampaignTest', 1, 0, 1, 1, ''),
(11, 'Campaign Result List\r\n', '', '', 'site/viewCampaignResult', 1, 0, 1, 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `menuaccess`
--

CREATE TABLE IF NOT EXISTS `menuaccess` (
  `menu` int(11) NOT NULL,
  `access` int(11) NOT NULL,
  UNIQUE KEY `menu` (`menu`,`access`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menuaccess`
--

INSERT INTO `menuaccess` (`menu`, `access`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(7, 3),
(8, 1);

-- --------------------------------------------------------

--
-- Table structure for table `orderstatus`
--

CREATE TABLE IF NOT EXISTS `orderstatus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `orderstatus`
--

INSERT INTO `orderstatus` (`id`, `name`) VALUES
(1, 'Confirm'),
(2, 'Pending'),
(3, 'Processing');

-- --------------------------------------------------------

--
-- Table structure for table `plan`
--

CREATE TABLE IF NOT EXISTS `plan` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `plan`
--

INSERT INTO `plan` (`id`, `name`) VALUES
(1, 'plan1'),
(2, 'plan2');

-- --------------------------------------------------------

--
-- Table structure for table `statuses`
--

CREATE TABLE IF NOT EXISTS `statuses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `statuses`
--

INSERT INTO `statuses` (`id`, `name`) VALUES
(1, 'inactive'),
(2, 'Active'),
(3, 'Waiting'),
(4, 'Active Waiting'),
(5, 'Blocked');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `accesslevel` int(11) DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `socialid` varchar(255) NOT NULL,
  `logintype` int(11) NOT NULL,
  `json` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `password`, `email`, `accesslevel`, `timestamp`, `status`, `image`, `username`, `socialid`, `logintype`, `json`) VALUES
(1, 'wohlig', 'a63526467438df9566c508027d9cb06b', 'wohlig@wohlig.com', 1, '0000-00-00 00:00:00', 1, NULL, '', '', 0, ''),
(4, 'pratik', '0cb2b62754dfd12b6ed0161d4b447df7', 'pratik@wohlig.com', 1, '2014-05-12 06:52:44', 1, NULL, 'pratik', '1', 1, ''),
(5, 'wohlig123', 'wohlig123', 'wohlig1@wohlig.com', 1, '2014-05-12 06:52:44', 1, NULL, '', '', 0, ''),
(6, 'wohlig1', 'a63526467438df9566c508027d9cb06b', 'wohlig2@wohlig.com', 1, '2014-05-12 06:52:44', 1, NULL, '', '', 0, ''),
(7, 'A', '7b0a80efe0d324e937bbfc7716fb15d3', 'avinash@wohlig.com', 1, '2014-10-17 06:22:29', 1, NULL, '', '', 1, ''),
(9, 'avi', 'a208e5837519309129fa466b0c68396b', 'a@email.com', 2, '2014-12-03 11:06:19', 3, '', '', '123', 1, 'demojson'),
(13, 'aaa', 'a208e5837519309129fa466b0c68396b', 'aaa3@email.com', 3, '2014-12-04 06:55:42', 3, NULL, '', '1', 2, 'userjson'),
(14, 'Avinash', 'a208e5837519309129fa466b0c68396b', 'avinash2@wohlig.com', 3, '2015-03-07 09:02:04', 1, 'event48830.jpg', '', '1', 1, 'demojson');

-- --------------------------------------------------------

--
-- Table structure for table `userlog`
--

CREATE TABLE IF NOT EXISTS `userlog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `onuser` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

--
-- Dumping data for table `userlog`
--

INSERT INTO `userlog` (`id`, `onuser`, `status`, `description`, `timestamp`) VALUES
(1, 1, 1, 'User Address Edited', '2014-05-12 06:50:21'),
(2, 1, 1, 'User Details Edited', '2014-05-12 06:51:43'),
(3, 1, 1, 'User Details Edited', '2014-05-12 06:51:53'),
(4, 4, 1, 'User Created', '2014-05-12 06:52:44'),
(5, 4, 1, 'User Address Edited', '2014-05-12 12:31:48'),
(6, 23, 2, 'User Created', '2014-10-07 06:46:55'),
(7, 24, 2, 'User Created', '2014-10-07 06:48:25'),
(8, 25, 2, 'User Created', '2014-10-07 06:49:04'),
(9, 26, 2, 'User Created', '2014-10-07 06:49:16'),
(10, 27, 2, 'User Created', '2014-10-07 06:52:18'),
(11, 28, 2, 'User Created', '2014-10-07 06:52:45'),
(12, 29, 2, 'User Created', '2014-10-07 06:53:10'),
(13, 30, 2, 'User Created', '2014-10-07 06:53:33'),
(14, 31, 2, 'User Created', '2014-10-07 06:55:03'),
(15, 32, 2, 'User Created', '2014-10-07 06:55:33'),
(16, 33, 2, 'User Created', '2014-10-07 06:59:32'),
(17, 34, 2, 'User Created', '2014-10-07 07:01:18'),
(18, 35, 2, 'User Created', '2014-10-07 07:01:50'),
(19, 34, 2, 'User Details Edited', '2014-10-07 07:04:34'),
(20, 18, 2, 'User Details Edited', '2014-10-07 07:05:11'),
(21, 18, 2, 'User Details Edited', '2014-10-07 07:05:45'),
(22, 18, 2, 'User Details Edited', '2014-10-07 07:06:03'),
(23, 7, 6, 'User Created', '2014-10-17 06:22:29'),
(24, 7, 6, 'User Details Edited', '2014-10-17 06:32:22'),
(25, 7, 6, 'User Details Edited', '2014-10-17 06:32:37'),
(26, 8, 6, 'User Created', '2014-11-15 12:05:52'),
(27, 9, 6, 'User Created', '2014-12-02 10:46:36'),
(28, 9, 6, 'User Details Edited', '2014-12-02 10:47:34'),
(29, 4, 6, 'User Details Edited', '2014-12-03 10:34:49'),
(30, 4, 6, 'User Details Edited', '2014-12-03 10:36:34'),
(31, 4, 6, 'User Details Edited', '2014-12-03 10:36:49'),
(32, 8, 6, 'User Details Edited', '2014-12-03 10:47:16');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
