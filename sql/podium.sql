-- phpMyAdmin SQL Dump
-- version 3.4.3.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 03, 2012 at 04:36 PM
-- Server version: 5.5.15
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `podium`
--

-- --------------------------------------------------------

--
-- Table structure for table `arrangement`
--

CREATE TABLE IF NOT EXISTS `arrangement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `layout_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `layout_id` (`layout_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `arrangement`
--

INSERT INTO `arrangement` (`id`, `layout_id`, `name`) VALUES
(1, 21, 'test a 1'),
(3, 21, 'tgtgt');

-- --------------------------------------------------------

--
-- Table structure for table `arrangement_elements`
--

CREATE TABLE IF NOT EXISTS `arrangement_elements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `arrangement_id` int(11) NOT NULL,
  `block_id` int(11) NOT NULL,
  `index` int(11) NOT NULL,
  `widget_id` int(11) NOT NULL,
  `widget_config_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `widget_id` (`widget_config_id`),
  KEY `block_id` (`block_id`),
  KEY `arrangement_id` (`arrangement_id`),
  KEY `widget_id_2` (`widget_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=43 ;

--
-- Dumping data for table `arrangement_elements`
--

INSERT INTO `arrangement_elements` (`id`, `arrangement_id`, `block_id`, `index`, `widget_id`, `widget_config_id`) VALUES
(32, 1, 16, 0, 3, 26),
(34, 1, 17, 0, 8, 48),
(38, 3, 17, 0, 8, 62),
(39, 1, 20, 0, 7, 106),
(40, 1, 18, 0, 6, 119),
(41, 1, 6, 0, 11, 127),
(42, 1, 20, 1, 12, 131);

-- --------------------------------------------------------

--
-- Table structure for table `content`
--

CREATE TABLE IF NOT EXISTS `content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `content_type_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `content_type_id` (`content_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=77 ;

--
-- Dumping data for table `content`
--

INSERT INTO `content` (`id`, `name`, `content_type_id`) VALUES
(37, 'Home pagechange', 1),
(38, 'first post', 2),
(39, 'test post create 1', 2),
(40, 'test create 2dddd', 2),
(41, 'test with arrangmenet', 1),
(42, 'test with arrangmenet', 1),
(48, 'test config delete', 2),
(49, 'newpage', 1),
(51, 'pagemapupdatetest', 1),
(54, 'testinsertpage', 1),
(70, 'testdate', 1),
(71, 'testimagepage', 1),
(72, 'testnewimagepage', 1),
(73, 'thank you', 1),
(74, 'My second post', 2),
(75, 'test update', 2),
(76, 'test update 2', 2);

-- --------------------------------------------------------

--
-- Table structure for table `content_attributes`
--

CREATE TABLE IF NOT EXISTS `content_attributes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `widget_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `widget_id` (`widget_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `content_attributes`
--

INSERT INTO `content_attributes` (`id`, `name`, `widget_id`) VALUES
(1, 'heading', 3),
(2, 'text block', 4),
(3, 'Author', 9),
(4, 'Date', 10),
(5, 'Image', 7);

-- --------------------------------------------------------

--
-- Table structure for table `content_entries`
--

CREATE TABLE IF NOT EXISTS `content_entries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content_id` int(11) NOT NULL,
  `content_type_attribute_id` int(11) NOT NULL,
  `widget_config_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `widget_config_id` (`widget_config_id`),
  KEY `content_id` (`content_id`),
  KEY `content_type_attribute_id` (`content_type_attribute_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=82 ;

--
-- Dumping data for table `content_entries`
--

INSERT INTO `content_entries` (`id`, `content_id`, `content_type_attribute_id`, `widget_config_id`) VALUES
(12, 37, 3, 18),
(13, 37, 7, 19),
(14, 37, 8, 20),
(15, 39, 9, 41),
(16, 40, 9, 42),
(17, 42, 8, 43),
(18, 42, 3, 44),
(19, 42, 7, 45),
(20, 37, 10, 63),
(21, 49, 3, 64),
(22, 49, 7, 65),
(23, 49, 8, 66),
(36, 54, 3, 80),
(37, 54, 7, 81),
(38, 54, 8, 82),
(39, 54, 10, 83),
(56, 70, 8, 101),
(57, 70, 3, 102),
(58, 70, 7, 103),
(59, 70, 10, 104),
(60, 70, 11, 105),
(61, 71, 8, 107),
(62, 71, 3, 108),
(63, 71, 7, 109),
(64, 71, 12, 110),
(65, 71, 10, 111),
(66, 71, 11, 112),
(67, 72, 8, 113),
(68, 72, 3, 114),
(69, 72, 7, 115),
(70, 72, 12, 116),
(71, 72, 10, 117),
(72, 72, 11, 118),
(73, 73, 8, 120),
(74, 73, 3, 121),
(75, 73, 7, 122),
(76, 73, 12, 123),
(77, 73, 10, 124),
(78, 73, 11, 125),
(79, 74, 9, 128),
(80, 75, 9, 129),
(81, 76, 9, 130);

-- --------------------------------------------------------

--
-- Table structure for table `content_type`
--

CREATE TABLE IF NOT EXISTS `content_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type` enum('post','page') NOT NULL,
  `arrangement_id` int(11) NOT NULL,
  `theme_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `arrangement_id` (`arrangement_id`),
  KEY `theme_id` (`theme_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `content_type`
--

INSERT INTO `content_type` (`id`, `name`, `type`, `arrangement_id`, `theme_id`) VALUES
(1, 'web pageddd', 'page', 1, 2),
(2, 'blog post', 'post', 1, 2),
(3, 'test with arrangement', 'post', 1, 2),
(4, 'testtest', 'page', 1, 6);

-- --------------------------------------------------------

--
-- Table structure for table `content_type_attributes`
--

CREATE TABLE IF NOT EXISTS `content_type_attributes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `content_type_id` int(11) NOT NULL,
  `attribute_id` int(11) NOT NULL,
  `index` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `content_type_id` (`content_type_id`),
  KEY `attribute_id` (`attribute_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `content_type_attributes`
--

INSERT INTO `content_type_attributes` (`id`, `name`, `content_type_id`, `attribute_id`, `index`) VALUES
(3, 'test attribute 3', 1, 2, 2),
(7, 'test attribute 6', 1, 2, 3),
(8, 'test attribute 5', 1, 1, 1),
(9, 'text', 2, 2, 0),
(10, 'author attribute', 1, 3, 4),
(11, 'datestuff', 1, 4, 5),
(12, 'image block', 1, 5, 0);

-- --------------------------------------------------------

--
-- Table structure for table `form`
--

CREATE TABLE IF NOT EXISTS `form` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `action` int(11) NOT NULL,
  `message` longtext NOT NULL,
  `page_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `page_id` (`page_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `form`
--

INSERT INTO `form` (`id`, `name`, `action`, `message`, `page_id`) VALUES
(1, 'sample form', 2, '', 65),
(2, 'test create message', 1, 'sdfsdf', NULL),
(3, 'dfgdfg', 2, '', 65);

-- --------------------------------------------------------

--
-- Table structure for table `form_elements`
--

CREATE TABLE IF NOT EXISTS `form_elements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `form_id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `index` int(11) NOT NULL,
  `required` tinyint(1) NOT NULL,
  `label` varchar(255) NOT NULL,
  `function` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `form_id` (`form_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

--
-- Dumping data for table `form_elements`
--

INSERT INTO `form_elements` (`id`, `form_id`, `type`, `name`, `index`, `required`, `label`, `function`) VALUES
(1, 1, 'TextField', 'name', 0, 1, '', ''),
(18, 1, 'TextAreaField', 'area', 1, 0, '', ''),
(19, 1, 'DropDownField', 'drop down', 2, 0, '', ''),
(20, 1, 'RadioField', 'radios', 3, 0, '', ''),
(21, 1, 'CheckBoxField', 'check', 4, 0, 'single check', ''),
(22, 1, 'CheckGroupField', 'check group', 5, 0, '', ''),
(23, 1, 'ButtonField', 'submit button', 6, 0, 'save', 'Submit'),
(24, 2, 'TextField', 'sdfsdf', 0, 0, '', ''),
(25, 2, 'ButtonField', 'sdf', 1, 0, 'sdf', 'Submit'),
(26, 3, 'TextField', 'dsfsdf', 0, 0, '', ''),
(27, 3, 'ButtonField', 'asdf', 1, 0, 'sdf', 'Submit');

-- --------------------------------------------------------

--
-- Table structure for table `form_element_options`
--

CREATE TABLE IF NOT EXISTS `form_element_options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `form_element_id` int(11) NOT NULL,
  `option` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `form_element_id` (`form_element_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=131 ;

--
-- Dumping data for table `form_element_options`
--

INSERT INTO `form_element_options` (`id`, `form_element_id`, `option`) VALUES
(123, 19, 'op1'),
(124, 19, 'op2'),
(125, 19, 'op3'),
(126, 20, 'radio op1'),
(127, 20, 'another op'),
(128, 22, 'check op1'),
(129, 22, 'check op2'),
(130, 22, 'check op3');

-- --------------------------------------------------------

--
-- Table structure for table `form_validation`
--

CREATE TABLE IF NOT EXISTS `form_validation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `form_element_id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `form_element_id` (`form_element_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `form_validation`
--

INSERT INTO `form_validation` (`id`, `form_element_id`, `type`) VALUES
(1, 1, 'Email Validator');

-- --------------------------------------------------------

--
-- Table structure for table `form_validation_options`
--

CREATE TABLE IF NOT EXISTS `form_validation_options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `form_validation_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `form_validation_id` (`form_validation_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `layout`
--

CREATE TABLE IF NOT EXISTS `layout` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `layout`
--

INSERT INTO `layout` (`id`, `name`) VALUES
(21, 'example layout');

-- --------------------------------------------------------

--
-- Table structure for table `layout_blocks`
--

CREATE TABLE IF NOT EXISTS `layout_blocks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `layout_id` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `parent_block_id` int(11) DEFAULT NULL,
  `position` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `layout_id` (`layout_id`),
  KEY `parent_block_id` (`parent_block_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `layout_blocks`
--

INSERT INTO `layout_blocks` (`id`, `layout_id`, `type`, `parent_block_id`, `position`) VALUES
(6, 21, 1, NULL, 0),
(15, 21, 2, NULL, 1),
(16, 21, 3, 15, 0),
(17, 21, 3, 15, 1),
(18, 21, 4, NULL, 2),
(19, 21, 2, NULL, 3),
(20, 21, 3, 19, 0);

-- --------------------------------------------------------

--
-- Table structure for table `layout_block_attributes`
--

CREATE TABLE IF NOT EXISTS `layout_block_attributes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `block_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `block_id` (`block_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=83 ;

--
-- Dumping data for table `layout_block_attributes`
--

INSERT INTO `layout_block_attributes` (`id`, `block_id`, `name`, `value`) VALUES
(69, 6, 'height', '50'),
(70, 15, 'height', ' 114px'),
(71, 16, 'width', ' 162px'),
(72, 16, ' height', ' 114px'),
(73, 17, 'width', ' 282px'),
(74, 17, ' height', ' 114px'),
(75, 18, 'height', ' 95px'),
(76, 18, ' width', ' 320px'),
(77, 18, ' top', ' 222px'),
(78, 18, ' left', ' 863px'),
(79, 18, ' position', ' absolute'),
(80, 19, 'height', ' 84px'),
(81, 20, 'width', ' 648px'),
(82, 20, ' height', ' 84px');

-- --------------------------------------------------------

--
-- Table structure for table `navigation_menu`
--

CREATE TABLE IF NOT EXISTS `navigation_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `navigation_menu`
--

INSERT INTO `navigation_menu` (`id`, `name`) VALUES
(1, ''),
(2, ''),
(3, '');

-- --------------------------------------------------------

--
-- Table structure for table `navigation_menu_elements`
--

CREATE TABLE IF NOT EXISTS `navigation_menu_elements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `type` enum('page','post','external') NOT NULL,
  `page_id` int(11) DEFAULT NULL,
  `post_id` int(11) DEFAULT NULL,
  `url` longtext,
  PRIMARY KEY (`id`),
  KEY `post_id` (`post_id`),
  KEY `page_id` (`page_id`),
  KEY `menu_id` (`menu_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `navigation_menu_elements`
--

INSERT INTO `navigation_menu_elements` (`id`, `menu_id`, `title`, `type`, `page_id`, `post_id`, `url`) VALUES
(2, 1, 'test1', 'page', 65, NULL, NULL),
(8, 3, 'google', 'external', NULL, NULL, 'google.com');

-- --------------------------------------------------------

--
-- Table structure for table `page`
--

CREATE TABLE IF NOT EXISTS `page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content_id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `index` int(11) NOT NULL,
  `arrangement_id` int(11) DEFAULT NULL,
  `seo_title` varchar(255) NOT NULL,
  `meta_keys` varchar(255) NOT NULL,
  `meta_desc` varchar(255) NOT NULL,
  `homepage` tinyint(1) NOT NULL DEFAULT '0',
  `theme_id` int(11) DEFAULT NULL,
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `content_id` (`content_id`),
  KEY `parent_id` (`parent_id`),
  KEY `arrangement_id` (`arrangement_id`),
  KEY `theme_id` (`theme_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=66 ;

--
-- Dumping data for table `page`
--

INSERT INTO `page` (`id`, `content_id`, `parent_id`, `index`, `arrangement_id`, `seo_title`, `meta_keys`, `meta_desc`, `homepage`, `theme_id`) VALUES
(39, 37, NULL, 1, NULL, 'titleddd', 'keysdd', 'descdd', 0, NULL),
(40, 42, NULL, 2, 1, '', '', '', 0, NULL),
(41, 49, NULL, 3, NULL, '', '', '', 0, NULL),
(43, 51, 41, 1, NULL, '', '', '', 0, NULL),
(46, 54, 41, 2, NULL, '', '', '', 0, NULL),
(62, 70, NULL, 4, NULL, '', '', '', 0, NULL),
(63, 71, NULL, 5, NULL, '', '', '', 0, NULL),
(64, 72, NULL, 6, NULL, '', '', '', 1, NULL),
(65, 73, NULL, 7, NULL, '', '', '', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE IF NOT EXISTS `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `content_id` (`content_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`id`, `content_id`) VALUES
(2, 40),
(3, 74),
(4, 75),
(5, 76);

-- --------------------------------------------------------

--
-- Table structure for table `submits`
--

CREATE TABLE IF NOT EXISTS `submits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `formName` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `submits`
--

INSERT INTO `submits` (`id`, `date`, `formName`) VALUES
(1, '2012-04-02 14:43:35', 'test1'),
(2, '2012-04-02 14:43:39', 'test2'),
(3, '2012-04-02 15:30:10', 'Array'),
(4, '2012-04-02 15:30:42', 'Array'),
(5, '2012-04-02 17:40:06', 'sample form'),
(6, '2012-04-02 17:41:34', 'sample form'),
(7, '2012-04-02 17:42:00', 'sample form'),
(8, '2012-04-02 17:42:31', 'sample form'),
(9, '2012-04-02 17:43:34', 'sample form'),
(10, '2012-04-02 17:45:26', 'sample form'),
(11, '2012-04-02 17:53:42', 'sample form'),
(12, '2012-04-02 18:24:17', 'sample form');

-- --------------------------------------------------------

--
-- Table structure for table `submit_attributes`
--

CREATE TABLE IF NOT EXISTS `submit_attributes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `submit_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `submit_id` (`submit_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=69 ;

--
-- Dumping data for table `submit_attributes`
--

INSERT INTO `submit_attributes` (`id`, `submit_id`, `name`, `value`) VALUES
(1, 1, 'name', 'nothingness'),
(2, 1, 'area', 'nothingness'),
(3, 1, 'drop down', 'nothingness'),
(4, 1, 'radios', 'nothingness'),
(5, 1, 'check', 'nothingness'),
(6, 1, 'check group', 'nothingness'),
(7, 1, 'submit button', 'nothingness'),
(8, 2, 'name', 'testing'),
(9, 2, 'area', 'hi there'),
(10, 2, 'drop down', 'op1'),
(11, 2, 'radios', 'radio op1'),
(12, 2, 'check', '1'),
(13, 2, 'check group', 'Array'),
(14, 2, 'submit button', ''),
(15, 5, 'name', 'test redirection'),
(16, 5, 'area', ''),
(17, 5, 'drop down', ''),
(18, 5, 'radios', ''),
(19, 5, 'check', ''),
(20, 5, 'check group', 'Array'),
(21, 5, 'submit button', ''),
(22, 6, 'name', 'redirection'),
(23, 6, 'area', ''),
(24, 6, 'drop down', ''),
(25, 6, 'radios', ''),
(26, 6, 'check', ''),
(27, 6, 'check group', 'Array'),
(28, 6, 'submit button', ''),
(29, 7, 'name', 'sdfsdf'),
(30, 7, 'area', ''),
(31, 7, 'drop down', ''),
(32, 7, 'radios', ''),
(33, 7, 'check', ''),
(34, 7, 'check group', 'Array'),
(35, 7, 'submit button', ''),
(36, 8, 'name', 'fghfgh'),
(37, 8, 'area', ''),
(38, 8, 'drop down', ''),
(39, 8, 'radios', ''),
(40, 8, 'check', ''),
(41, 8, 'check group', 'Array'),
(42, 8, 'submit button', ''),
(43, 9, 'name', 'rwerwer'),
(44, 9, 'area', ''),
(45, 9, 'drop down', ''),
(46, 9, 'radios', ''),
(47, 9, 'check', ''),
(48, 9, 'check group', 'Array'),
(49, 9, 'submit button', ''),
(50, 10, 'name', 'fdgdfgdfg'),
(51, 10, 'area', ''),
(52, 10, 'drop down', ''),
(53, 10, 'radios', ''),
(54, 10, 'check', ''),
(55, 10, 'check group', 'Array'),
(56, 10, 'submit button', ''),
(57, 11, 'name', 'test full submit'),
(58, 11, 'area', 'hi there!'),
(59, 11, 'drop down', 'op1'),
(60, 11, 'radios', 'radio op1'),
(61, 11, 'check', 'Checked'),
(62, 11, 'check group', 'check op1,check op3'),
(63, 12, 'name', 'gfhgfh'),
(64, 12, 'area', ''),
(65, 12, 'drop down', ''),
(66, 12, 'radios', ''),
(67, 12, 'check', 'Not Checked'),
(68, 12, 'check group', '');

-- --------------------------------------------------------

--
-- Table structure for table `theme`
--

CREATE TABLE IF NOT EXISTS `theme` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `theme`
--

INSERT INTO `theme` (`id`, `name`) VALUES
(2, 'theme1'),
(5, 'testrecursion4'),
(6, 'testlinks'),
(7, 'testlinksf');

-- --------------------------------------------------------

--
-- Table structure for table `theme_attributes`
--

CREATE TABLE IF NOT EXISTS `theme_attributes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `theme_element_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `theme_element_id` (`theme_element_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=157 ;

--
-- Dumping data for table `theme_attributes`
--

INSERT INTO `theme_attributes` (`id`, `theme_element_id`, `name`, `value`) VALUES
(79, 217, 'background', '2BFF00'),
(80, 217, 'fontsize', '10'),
(81, 217, 'fontcolour', '000000'),
(82, 218, 'textColour', 'FF0000'),
(83, 218, 'textSize', '10'),
(84, 218, 'decoration', 'none'),
(85, 218, 'weight', 'bold'),
(86, 219, 'textColour', '000000'),
(87, 219, 'textSize', '10'),
(88, 219, 'decoration', 'none'),
(89, 219, 'weight', 'bold'),
(90, 220, 'textColour', '000000'),
(91, 220, 'textSize', '10'),
(92, 220, 'decoration', 'none'),
(93, 220, 'weight', 'bold'),
(94, 221, 'textColour', '000000'),
(95, 221, 'textSize', '10'),
(96, 221, 'decoration', 'none'),
(97, 221, 'weight', 'bold'),
(98, 222, 'textColour', '000000'),
(99, 222, 'textSize', '10'),
(100, 222, 'decoration', 'none'),
(101, 222, 'weight', 'bold'),
(102, 223, 'textColour', '000000'),
(103, 223, 'textSize', '10'),
(104, 223, 'decoration', 'none'),
(105, 223, 'weight', 'bold'),
(106, 225, 'fontsize', '10'),
(107, 225, 'fontcolour', '000000'),
(108, 225, 'decoration', 'none'),
(109, 225, 'weight', 'bold'),
(110, 226, 'fontsize', '10'),
(111, 226, 'fontcolour', '000000'),
(112, 226, 'decoration', 'none'),
(113, 226, 'weight', 'bold'),
(114, 227, 'fontsize', '10'),
(115, 227, 'fontcolour', '000000'),
(116, 227, 'decoration', 'none'),
(117, 227, 'weight', 'bold'),
(118, 228, 'background', 'FFFFFF'),
(119, 228, 'fontsize', '10'),
(120, 228, 'fontcolour', '000000'),
(121, 229, 'textColour', '000000'),
(122, 229, 'textSize', '10'),
(123, 229, 'decoration', 'none'),
(124, 229, 'weight', 'bold'),
(125, 230, 'textColour', '000000'),
(126, 230, 'textSize', '10'),
(127, 230, 'decoration', 'none'),
(128, 230, 'weight', 'bold'),
(129, 231, 'textColour', '000000'),
(130, 231, 'textSize', '10'),
(131, 231, 'decoration', 'none'),
(132, 231, 'weight', 'bold'),
(133, 232, 'textColour', '000000'),
(134, 232, 'textSize', '10'),
(135, 232, 'decoration', 'none'),
(136, 232, 'weight', 'bold'),
(137, 233, 'textColour', '000000'),
(138, 233, 'textSize', '10'),
(139, 233, 'decoration', 'none'),
(140, 233, 'weight', 'bold'),
(141, 234, 'textColour', '000000'),
(142, 234, 'textSize', '10'),
(143, 234, 'decoration', 'none'),
(144, 234, 'weight', 'bold'),
(145, 236, 'fontsize', '10'),
(146, 236, 'fontcolour', '000000'),
(147, 236, 'decoration', 'none'),
(148, 236, 'weight', 'bold'),
(149, 237, 'fontsize', '10'),
(150, 237, 'fontcolour', '000000'),
(151, 237, 'decoration', 'none'),
(152, 237, 'weight', 'bold'),
(153, 238, 'fontsize', '10'),
(154, 238, 'fontcolour', '000000'),
(155, 238, 'decoration', 'none'),
(156, 238, 'weight', 'bold');

-- --------------------------------------------------------

--
-- Table structure for table `theme_elements`
--

CREATE TABLE IF NOT EXISTS `theme_elements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `theme_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` enum('array','object','nested') NOT NULL,
  `class` varchar(255) NOT NULL,
  `index` int(11) DEFAULT NULL,
  `parent_element` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `theme_id` (`theme_id`),
  KEY `parent_element` (`parent_element`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=239 ;

--
-- Dumping data for table `theme_elements`
--

INSERT INTO `theme_elements` (`id`, `theme_id`, `name`, `type`, `class`, `index`, `parent_element`) VALUES
(217, 2, 'page', 'object', 'ThemePage', NULL, NULL),
(218, 2, 'headings', 'array', 'HeadingElement', 1, NULL),
(219, 2, 'headings', 'array', 'HeadingElement', 2, NULL),
(220, 2, 'headings', 'array', 'HeadingElement', 3, NULL),
(221, 2, 'headings', 'array', 'HeadingElement', 4, NULL),
(222, 2, 'headings', 'array', 'HeadingElement', 5, NULL),
(223, 2, 'headings', 'array', 'HeadingElement', 6, NULL),
(224, 2, 'links', 'object', 'ThemeLink', NULL, NULL),
(225, 2, 'normal', 'object', 'LinkState', NULL, 224),
(226, 2, 'hover', 'object', 'LinkState', NULL, 224),
(227, 2, 'active', 'object', 'LinkState', NULL, 224),
(228, 7, 'page', 'object', 'ThemePage', NULL, NULL),
(229, 7, 'headings', 'array', 'HeadingElement', 1, NULL),
(230, 7, 'headings', 'array', 'HeadingElement', 2, NULL),
(231, 7, 'headings', 'array', 'HeadingElement', 3, NULL),
(232, 7, 'headings', 'array', 'HeadingElement', 4, NULL),
(233, 7, 'headings', 'array', 'HeadingElement', 5, NULL),
(234, 7, 'headings', 'array', 'HeadingElement', 6, NULL),
(235, 7, 'links', 'object', 'ThemeLink', NULL, NULL),
(236, 7, 'normal', 'object', 'LinkState', NULL, 235),
(237, 7, 'hover', 'object', 'LinkState', NULL, 235),
(238, 7, 'active', 'object', 'LinkState', NULL, 235);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(4, 'martin', '_J9..rasmHKzfRVVxcL6');

-- --------------------------------------------------------

--
-- Table structure for table `widgets`
--

CREATE TABLE IF NOT EXISTS `widgets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `setup` varchar(255) NOT NULL,
  `config` varchar(255) NOT NULL,
  `target_table` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `widgets`
--

INSERT INTO `widgets` (`id`, `category_id`, `name`, `class`, `setup`, `config`, `target_table`) VALUES
(3, 1, 'Heading', 'HeadingWidget', 'HeaderWidgetConfigPanel', 'HeaderWidgetConfig', 'widget_config_heading'),
(4, 1, 'Text Block', 'TextWidget', 'TextWidgetConfigPanel', 'TextWidgetConfig', 'widget_config_textbox'),
(6, 1, 'Form', 'FormWidget', 'FormWidgetConfigPanel', 'FormWidgetConfig', 'widget_config_form'),
(7, 1, 'Image', 'ImageWidget', 'ImageWidgetConfigPanel', 'ImageWidgetConfig', 'widget_config_image'),
(8, 1, 'Content Block', 'ContentWidget', 'ContentWidgetConfigPanel', 'ContentWidgetConfig', 'widget_config_content'),
(9, NULL, 'Author', 'AuthorWidget', 'AuthorWidgetConfigPanel', 'AuthorWidgetItem', 'widget_config_author'),
(10, NULL, 'Date', 'DateWidget', 'DateWidgetConfigPanel', 'DateWidgetItem', 'widget_config_date'),
(11, 2, 'Post List', 'PostListWidget', 'PostListConfigPanel', 'PostListItem', 'widget_config_postlist'),
(12, 2, 'Menu', 'NavigationMenuWidget', 'NavigationMenuConfigPanel', 'NavigationMenuItem', 'widget_config_navigation');

-- --------------------------------------------------------

--
-- Table structure for table `widget_category`
--

CREATE TABLE IF NOT EXISTS `widget_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `widget_category`
--

INSERT INTO `widget_category` (`id`, `name`) VALUES
(1, 'General'),
(2, 'Navigation');

-- --------------------------------------------------------

--
-- Table structure for table `widget_config`
--

CREATE TABLE IF NOT EXISTS `widget_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `widget_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `widget_id` (`widget_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=132 ;

--
-- Dumping data for table `widget_config`
--

INSERT INTO `widget_config` (`id`, `widget_id`) VALUES
(5, 3),
(8, 3),
(11, 3),
(14, 3),
(17, 3),
(20, 3),
(23, 3),
(24, 3),
(25, 3),
(26, 3),
(28, 3),
(31, 3),
(33, 3),
(34, 3),
(36, 3),
(37, 3),
(43, 3),
(52, 3),
(55, 3),
(66, 3),
(74, 3),
(78, 3),
(82, 3),
(96, 3),
(101, 3),
(107, 3),
(113, 3),
(120, 3),
(2, 4),
(3, 4),
(4, 4),
(6, 4),
(7, 4),
(9, 4),
(10, 4),
(12, 4),
(13, 4),
(15, 4),
(16, 4),
(18, 4),
(19, 4),
(21, 4),
(22, 4),
(27, 4),
(29, 4),
(32, 4),
(38, 4),
(41, 4),
(42, 4),
(44, 4),
(45, 4),
(53, 4),
(54, 4),
(56, 4),
(57, 4),
(64, 4),
(65, 4),
(72, 4),
(73, 4),
(76, 4),
(77, 4),
(80, 4),
(81, 4),
(97, 4),
(98, 4),
(102, 4),
(103, 4),
(108, 4),
(109, 4),
(114, 4),
(115, 4),
(121, 4),
(122, 4),
(128, 4),
(129, 4),
(130, 4),
(30, 6),
(35, 6),
(39, 6),
(40, 6),
(119, 6),
(106, 7),
(110, 7),
(116, 7),
(123, 7),
(46, 8),
(47, 8),
(48, 8),
(62, 8),
(63, 9),
(67, 9),
(75, 9),
(79, 9),
(83, 9),
(99, 9),
(104, 9),
(111, 9),
(117, 9),
(124, 9),
(100, 10),
(105, 10),
(112, 10),
(118, 10),
(125, 10),
(126, 11),
(127, 11),
(131, 12);

-- --------------------------------------------------------

--
-- Table structure for table `widget_config_author`
--

CREATE TABLE IF NOT EXISTS `widget_config_author` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `config_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `config_id` (`config_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `widget_config_author`
--

INSERT INTO `widget_config_author` (`id`, `config_id`, `user_id`) VALUES
(1, 63, 4),
(3, 75, 4),
(4, 79, 4),
(5, 83, 4),
(20, 99, 4),
(21, 104, 4),
(23, 111, 4),
(25, 124, 4),
(26, 117, 4);

-- --------------------------------------------------------

--
-- Table structure for table `widget_config_content`
--

CREATE TABLE IF NOT EXISTS `widget_config_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `config_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `config_id` (`config_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `widget_config_content`
--

INSERT INTO `widget_config_content` (`id`, `config_id`) VALUES
(3, 47),
(14, 48),
(9, 62);

-- --------------------------------------------------------

--
-- Table structure for table `widget_config_date`
--

CREATE TABLE IF NOT EXISTS `widget_config_date` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `config_id` int(11) NOT NULL,
  `date` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `config_id` (`config_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `widget_config_date`
--

INSERT INTO `widget_config_date` (`id`, `config_id`, `date`) VALUES
(1, 100, '04/04/2012'),
(2, 105, '04/02/2012'),
(4, 112, '04/17/2012'),
(6, 125, '05/05/2012'),
(7, 118, '04/24/2012');

-- --------------------------------------------------------

--
-- Table structure for table `widget_config_form`
--

CREATE TABLE IF NOT EXISTS `widget_config_form` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `config_id` int(11) NOT NULL,
  `form` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `config_id` (`config_id`),
  KEY `form` (`form`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `widget_config_form`
--

INSERT INTO `widget_config_form` (`id`, `config_id`, `form`) VALUES
(4, 30, 1),
(6, 35, 1),
(7, 39, 1),
(8, 40, 1),
(12, 119, 1);

-- --------------------------------------------------------

--
-- Table structure for table `widget_config_heading`
--

CREATE TABLE IF NOT EXISTS `widget_config_heading` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `config_id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `text` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `attribute_id` (`config_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=79 ;

--
-- Dumping data for table `widget_config_heading`
--

INSERT INTO `widget_config_heading` (`id`, `config_id`, `type`, `text`) VALUES
(3, 5, 'Heading 2', 'asdfasdf'),
(5, 8, 'Heading 1', 'dddddddd'),
(6, 11, 'Heading 1', 'eewr'),
(7, 14, 'Heading 1', 'jhjhj'),
(8, 17, 'Heading 1', 'some heading'),
(10, 23, 'Heading 1', 'heading stuff'),
(12, 20, 'Heading 6', 'heading stuffdddd'),
(15, 24, 'Heading 2', 'test heading'),
(17, 25, 'Heading 1', 'test heading'),
(29, 28, 'Heading 1', 'ghj'),
(32, 31, 'Heading 1', 'ghghgh'),
(33, 33, 'Heading 1', 'lolkomo'),
(35, 34, 'Heading 1', 'ghj'),
(36, 36, 'Heading 1', 'ghj'),
(37, 37, 'Heading 1', 'hjk'),
(38, 43, 'Heading 1', 'dsfsdf'),
(46, 52, 'Heading 1', 'sdafasdf'),
(47, 55, 'Heading 2', 'asdfasdf'),
(48, 66, 'Heading 1', 'sdfsdf'),
(50, 74, 'Heading 2', 'sdfsdf'),
(51, 78, 'Heading 2', 'sdfsdf'),
(52, 82, 'Heading 2', 'sdfsdf'),
(67, 96, 'Heading 1', 'werwer'),
(68, 101, 'Heading 1', 'sdfsdf'),
(71, 107, 'Heading 2', 'sdsd'),
(74, 120, 'Heading 1', 'THANK YOU'),
(76, 113, 'Heading 2', 'dsfsdf'),
(78, 26, 'Heading 1', 'asdfasdf');

-- --------------------------------------------------------

--
-- Table structure for table `widget_config_image`
--

CREATE TABLE IF NOT EXISTS `widget_config_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `config_id` int(11) NOT NULL,
  `path` varchar(255) NOT NULL,
  `height` int(11) NOT NULL,
  `width` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `config_id` (`config_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `widget_config_image`
--

INSERT INTO `widget_config_image` (`id`, `config_id`, `path`, `height`, `width`) VALUES
(3, 110, 'media/images/^black granite-04.jpg', 100, 100),
(6, 123, 'media/images/orig3.png', 150, 150),
(8, 116, 'media/images/', 40, 40),
(10, 106, 'media/images/marble_ioannina.JPG', 50, 50);

-- --------------------------------------------------------

--
-- Table structure for table `widget_config_navigation`
--

CREATE TABLE IF NOT EXISTS `widget_config_navigation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `config_id` int(11) NOT NULL,
  `orientation` tinyint(1) NOT NULL,
  `menu_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `config_id` (`config_id`),
  KEY `menu_id` (`menu_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `widget_config_navigation`
--

INSERT INTO `widget_config_navigation` (`id`, `config_id`, `orientation`, `menu_id`) VALUES
(2, 131, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `widget_config_postlist`
--

CREATE TABLE IF NOT EXISTS `widget_config_postlist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `config_id` int(11) NOT NULL,
  `content_type_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `config_id` (`config_id`),
  KEY `content_type_id` (`content_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `widget_config_postlist`
--

INSERT INTO `widget_config_postlist` (`id`, `config_id`, `content_type_id`, `amount`) VALUES
(3, 127, 2, 4);

-- --------------------------------------------------------

--
-- Table structure for table `widget_config_textbox`
--

CREATE TABLE IF NOT EXISTS `widget_config_textbox` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `config_id` int(11) NOT NULL,
  `text` longtext NOT NULL,
  PRIMARY KEY (`id`),
  KEY `attribute_id` (`config_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=103 ;

--
-- Dumping data for table `widget_config_textbox`
--

INSERT INTO `widget_config_textbox` (`id`, `config_id`, `text`) VALUES
(5, 3, '<p>asdfasd</p>'),
(6, 4, '<p>fasdf</p>'),
(12, 6, '<p>ddddddddddd</p>'),
(13, 7, '<p>dddddddddddddddddd</p>'),
(17, 9, '<p>dsfsdf</p>'),
(18, 10, '<p>sdfsdf</p>'),
(19, 12, '<p>kjkjkjkj</p>'),
(20, 13, '<p>kjkjuiuiui</p>'),
(21, 15, '<p>content block one</p>'),
(22, 16, '<p>second content block</p>'),
(25, 21, '<p>some content</p>'),
(26, 22, '<p><span style="color: #ff0000;">some other content</span></p>'),
(29, 18, '<p>some content change</p>'),
(30, 19, '<p>some other contentchange</p>'),
(32, 27, '<p>kkkikiki</p>'),
(34, 29, '<p><strong>asdasdasd</strong></p>'),
(36, 32, '<p><strong>kjnkinknin</strong></p>'),
(37, 38, '<p><span style="text-decoration: underline; font-size: large;">dfdfdf</span></p>'),
(38, 41, '<p>testing post insert</p>'),
(40, 42, '<p>my blog textdddd</p>'),
(41, 44, '<p>sdfsdf</p>'),
(42, 45, '<p>sdfsdf</p>'),
(43, 53, '<p>asdfasdf</p>'),
(44, 54, '<p>asdfasdf</p>'),
(45, 56, '<p>asdfasdf</p>'),
(46, 57, '<p>asdfasdf</p>'),
(47, 64, '<p>sdfsdf</p>'),
(48, 65, '<p>sdfsdf</p>'),
(51, 72, '<p>sdfsdf</p>'),
(52, 73, '<p>sdfsdf</p>'),
(53, 76, '<p>sdfsdf</p>'),
(54, 77, '<p>sdfsdf</p>'),
(55, 80, '<p>sdfsdf</p>'),
(56, 81, '<p>sdfsdf</p>'),
(85, 97, '<p>ewrwerwer</p>'),
(86, 98, '<p>ewr</p>'),
(87, 102, '<p>sdfsdf</p>'),
(88, 103, '<p>sdfsdf</p>'),
(91, 108, '<p>asdasd</p>'),
(92, 109, '<p style="text-align: right;">asdasd</p>'),
(95, 121, '<p>hhh</p>'),
(96, 122, '<p>hhhh</p>'),
(97, 128, '<p>Hi there</p>'),
(99, 130, '<p>asdfasdf</p>'),
(100, 114, '<p>sdfsdf</p>'),
(101, 115, '<p>sdfsdf</p>'),
(102, 129, '<p>asdfasdf</p>');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `arrangement`
--
ALTER TABLE `arrangement`
  ADD CONSTRAINT `arrangement_ibfk_1` FOREIGN KEY (`layout_id`) REFERENCES `layout` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `arrangement_elements`
--
ALTER TABLE `arrangement_elements`
  ADD CONSTRAINT `arrangement_elements_ibfk_19` FOREIGN KEY (`arrangement_id`) REFERENCES `arrangement` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `arrangement_elements_ibfk_20` FOREIGN KEY (`block_id`) REFERENCES `layout_blocks` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `arrangement_elements_ibfk_21` FOREIGN KEY (`widget_id`) REFERENCES `widgets` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `arrangement_elements_ibfk_22` FOREIGN KEY (`widget_config_id`) REFERENCES `widget_config` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `content`
--
ALTER TABLE `content`
  ADD CONSTRAINT `content_ibfk_1` FOREIGN KEY (`content_type_id`) REFERENCES `content_type` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `content_attributes`
--
ALTER TABLE `content_attributes`
  ADD CONSTRAINT `content_attributes_ibfk_1` FOREIGN KEY (`widget_id`) REFERENCES `widgets` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `content_entries`
--
ALTER TABLE `content_entries`
  ADD CONSTRAINT `content_entries_ibfk_3` FOREIGN KEY (`content_id`) REFERENCES `content` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `content_entries_ibfk_4` FOREIGN KEY (`content_type_attribute_id`) REFERENCES `content_type_attributes` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `content_entries_ibfk_5` FOREIGN KEY (`widget_config_id`) REFERENCES `widget_config` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `content_type`
--
ALTER TABLE `content_type`
  ADD CONSTRAINT `content_type_ibfk_1` FOREIGN KEY (`arrangement_id`) REFERENCES `arrangement` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `content_type_ibfk_2` FOREIGN KEY (`theme_id`) REFERENCES `theme` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `content_type_attributes`
--
ALTER TABLE `content_type_attributes`
  ADD CONSTRAINT `content_type_attributes_ibfk_2` FOREIGN KEY (`content_type_id`) REFERENCES `content_type` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `content_type_attributes_ibfk_3` FOREIGN KEY (`attribute_id`) REFERENCES `content_attributes` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `form`
--
ALTER TABLE `form`
  ADD CONSTRAINT `form_ibfk_1` FOREIGN KEY (`page_id`) REFERENCES `page` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `form_elements`
--
ALTER TABLE `form_elements`
  ADD CONSTRAINT `form_elements_ibfk_1` FOREIGN KEY (`form_id`) REFERENCES `form` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `form_element_options`
--
ALTER TABLE `form_element_options`
  ADD CONSTRAINT `form_element_options_ibfk_1` FOREIGN KEY (`form_element_id`) REFERENCES `form_elements` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `form_validation`
--
ALTER TABLE `form_validation`
  ADD CONSTRAINT `form_validation_ibfk_1` FOREIGN KEY (`form_element_id`) REFERENCES `form_elements` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `form_validation_options`
--
ALTER TABLE `form_validation_options`
  ADD CONSTRAINT `form_validation_options_ibfk_1` FOREIGN KEY (`form_validation_id`) REFERENCES `form_validation` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `layout_blocks`
--
ALTER TABLE `layout_blocks`
  ADD CONSTRAINT `layout_blocks_ibfk_1` FOREIGN KEY (`layout_id`) REFERENCES `layout` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `layout_blocks_ibfk_2` FOREIGN KEY (`parent_block_id`) REFERENCES `layout_blocks` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `layout_block_attributes`
--
ALTER TABLE `layout_block_attributes`
  ADD CONSTRAINT `layout_block_attributes_ibfk_1` FOREIGN KEY (`block_id`) REFERENCES `layout_blocks` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `navigation_menu_elements`
--
ALTER TABLE `navigation_menu_elements`
  ADD CONSTRAINT `navigation_menu_elements_ibfk_6` FOREIGN KEY (`menu_id`) REFERENCES `navigation_menu` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `navigation_menu_elements_ibfk_7` FOREIGN KEY (`page_id`) REFERENCES `page` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `navigation_menu_elements_ibfk_8` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `page`
--
ALTER TABLE `page`
  ADD CONSTRAINT `page_ibfk_10` FOREIGN KEY (`content_id`) REFERENCES `content` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `page_ibfk_11` FOREIGN KEY (`parent_id`) REFERENCES `page` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `page_ibfk_12` FOREIGN KEY (`arrangement_id`) REFERENCES `arrangement` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `page_ibfk_13` FOREIGN KEY (`theme_id`) REFERENCES `theme` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`content_id`) REFERENCES `content` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `submit_attributes`
--
ALTER TABLE `submit_attributes`
  ADD CONSTRAINT `submit_attributes_ibfk_1` FOREIGN KEY (`submit_id`) REFERENCES `submits` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `theme_attributes`
--
ALTER TABLE `theme_attributes`
  ADD CONSTRAINT `theme_attributes_ibfk_1` FOREIGN KEY (`theme_element_id`) REFERENCES `theme_elements` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `theme_elements`
--
ALTER TABLE `theme_elements`
  ADD CONSTRAINT `theme_elements_ibfk_3` FOREIGN KEY (`theme_id`) REFERENCES `theme` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `theme_elements_ibfk_4` FOREIGN KEY (`parent_element`) REFERENCES `theme_elements` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `widgets`
--
ALTER TABLE `widgets`
  ADD CONSTRAINT `widgets_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `widget_category` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `widget_config`
--
ALTER TABLE `widget_config`
  ADD CONSTRAINT `widget_config_ibfk_1` FOREIGN KEY (`widget_id`) REFERENCES `widgets` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `widget_config_author`
--
ALTER TABLE `widget_config_author`
  ADD CONSTRAINT `widget_config_author_ibfk_1` FOREIGN KEY (`config_id`) REFERENCES `widget_config` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `widget_config_author_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `widget_config_content`
--
ALTER TABLE `widget_config_content`
  ADD CONSTRAINT `widget_config_content_ibfk_1` FOREIGN KEY (`config_id`) REFERENCES `widget_config` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `widget_config_form`
--
ALTER TABLE `widget_config_form`
  ADD CONSTRAINT `widget_config_form_ibfk_1` FOREIGN KEY (`config_id`) REFERENCES `widget_config` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `widget_config_form_ibfk_2` FOREIGN KEY (`form`) REFERENCES `form` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `widget_config_heading`
--
ALTER TABLE `widget_config_heading`
  ADD CONSTRAINT `widget_config_heading_ibfk_1` FOREIGN KEY (`config_id`) REFERENCES `widget_config` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `widget_config_image`
--
ALTER TABLE `widget_config_image`
  ADD CONSTRAINT `widget_config_image_ibfk_1` FOREIGN KEY (`config_id`) REFERENCES `widget_config` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `widget_config_navigation`
--
ALTER TABLE `widget_config_navigation`
  ADD CONSTRAINT `widget_config_navigation_ibfk_2` FOREIGN KEY (`menu_id`) REFERENCES `navigation_menu` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `widget_config_navigation_ibfk_1` FOREIGN KEY (`config_id`) REFERENCES `widget_config` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `widget_config_postlist`
--
ALTER TABLE `widget_config_postlist`
  ADD CONSTRAINT `widget_config_postlist_ibfk_1` FOREIGN KEY (`config_id`) REFERENCES `widget_config` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `widget_config_postlist_ibfk_2` FOREIGN KEY (`content_type_id`) REFERENCES `content_type` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `widget_config_textbox`
--
ALTER TABLE `widget_config_textbox`
  ADD CONSTRAINT `widget_config_textbox_ibfk_1` FOREIGN KEY (`config_id`) REFERENCES `widget_config` (`id`) ON UPDATE CASCADE;
