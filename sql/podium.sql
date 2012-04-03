-- phpMyAdmin SQL Dump
-- version 3.4.3.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 03, 2012 at 06:47 PM
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `arrangement`
--

INSERT INTO `arrangement` (`id`, `layout_id`, `name`) VALUES
(4, 22, 'Default');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=45 ;

--
-- Dumping data for table `arrangement_elements`
--

INSERT INTO `arrangement_elements` (`id`, `arrangement_id`, `block_id`, `index`, `widget_id`, `widget_config_id`) VALUES
(43, 4, 21, 1, 12, 132),
(44, 4, 22, 2, 8, 133);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=78 ;

--
-- Dumping data for table `content`
--

INSERT INTO `content` (`id`, `name`, `content_type_id`) VALUES
(77, 'Podium CMS', 5);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=83 ;

--
-- Dumping data for table `content_entries`
--

INSERT INTO `content_entries` (`id`, `content_id`, `content_type_attribute_id`, `widget_config_id`) VALUES
(82, 77, 13, 134);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `content_type`
--

INSERT INTO `content_type` (`id`, `name`, `type`, `arrangement_id`, `theme_id`) VALUES
(5, 'Default', 'page', 4, 8);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `content_type_attributes`
--

INSERT INTO `content_type_attributes` (`id`, `name`, `content_type_id`, `attribute_id`, `index`) VALUES
(13, 'Main Text', 5, 2, 0);

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `layout`
--

INSERT INTO `layout` (`id`, `name`) VALUES
(22, 'Default');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `layout_blocks`
--

INSERT INTO `layout_blocks` (`id`, `layout_id`, `type`, `parent_block_id`, `position`) VALUES
(21, 22, 1, NULL, 0),
(22, 22, 1, NULL, 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=87 ;

--
-- Dumping data for table `layout_block_attributes`
--

INSERT INTO `layout_block_attributes` (`id`, `block_id`, `name`, `value`) VALUES
(83, 21, 'height', ' 36px'),
(84, 21, ' width', ' 1281px'),
(85, 22, 'height', ' 386px'),
(86, 22, ' width', ' 1281px');

-- --------------------------------------------------------

--
-- Table structure for table `navigation_menu`
--

CREATE TABLE IF NOT EXISTS `navigation_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `navigation_menu`
--

INSERT INTO `navigation_menu` (`id`, `name`) VALUES
(4, '');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `navigation_menu_elements`
--

INSERT INTO `navigation_menu_elements` (`id`, `menu_id`, `title`, `type`, `page_id`, `post_id`, `url`) VALUES
(9, 4, 'Podium Project', 'external', NULL, NULL, 'http://code.google.com/p/podium/'),
(10, 4, 'Picon Framework', 'external', NULL, NULL, 'http://code.google.com/p/picon-framework/');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=67 ;

--
-- Dumping data for table `page`
--

INSERT INTO `page` (`id`, `content_id`, `parent_id`, `index`, `arrangement_id`, `seo_title`, `meta_keys`, `meta_desc`, `homepage`, `theme_id`) VALUES
(66, 77, NULL, 1, NULL, '', '', '', 1, NULL);

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

-- --------------------------------------------------------

--
-- Table structure for table `theme`
--

CREATE TABLE IF NOT EXISTS `theme` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `theme`
--

INSERT INTO `theme` (`id`, `name`) VALUES
(8, 'Default');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=235 ;

--
-- Dumping data for table `theme_attributes`
--

INSERT INTO `theme_attributes` (`id`, `theme_element_id`, `name`, `value`) VALUES
(196, 250, 'background', 'EDFAFF'),
(197, 250, 'fontsize', '12'),
(198, 250, 'fontcolour', '140063'),
(199, 251, 'textColour', '140063'),
(200, 251, 'textSize', '16'),
(201, 251, 'decoration', 'none'),
(202, 251, 'weight', 'bolder'),
(203, 252, 'textColour', '140063'),
(204, 252, 'textSize', '14'),
(205, 252, 'decoration', 'none'),
(206, 252, 'weight', 'bold'),
(207, 253, 'textColour', '140063'),
(208, 253, 'textSize', '12'),
(209, 253, 'decoration', 'none'),
(210, 253, 'weight', 'bold'),
(211, 254, 'textColour', '140063'),
(212, 254, 'textSize', '11'),
(213, 254, 'decoration', 'none'),
(214, 254, 'weight', 'bold'),
(215, 255, 'textColour', '140063'),
(216, 255, 'textSize', '10'),
(217, 255, 'decoration', 'none'),
(218, 255, 'weight', 'normal'),
(219, 256, 'textColour', '140063'),
(220, 256, 'textSize', '8'),
(221, 256, 'decoration', 'none'),
(222, 256, 'weight', 'normal'),
(223, 258, 'fontsize', '12'),
(224, 258, 'fontcolour', '140063'),
(225, 258, 'decoration', 'none'),
(226, 258, 'weight', 'normal'),
(227, 259, 'fontsize', '12'),
(228, 259, 'fontcolour', '140063'),
(229, 259, 'decoration', 'underline'),
(230, 259, 'weight', 'normal'),
(231, 260, 'fontsize', '10'),
(232, 260, 'fontcolour', '2B00FF'),
(233, 260, 'decoration', 'underline'),
(234, 260, 'weight', 'normal');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=261 ;

--
-- Dumping data for table `theme_elements`
--

INSERT INTO `theme_elements` (`id`, `theme_id`, `name`, `type`, `class`, `index`, `parent_element`) VALUES
(250, 8, 'page', 'object', 'ThemePage', NULL, NULL),
(251, 8, 'headings', 'array', 'HeadingElement', 1, NULL),
(252, 8, 'headings', 'array', 'HeadingElement', 2, NULL),
(253, 8, 'headings', 'array', 'HeadingElement', 3, NULL),
(254, 8, 'headings', 'array', 'HeadingElement', 4, NULL),
(255, 8, 'headings', 'array', 'HeadingElement', 5, NULL),
(256, 8, 'headings', 'array', 'HeadingElement', 6, NULL),
(257, 8, 'links', 'object', 'ThemeLink', NULL, NULL),
(258, 8, 'normal', 'object', 'LinkState', NULL, 257),
(259, 8, 'hover', 'object', 'LinkState', NULL, 257),
(260, 8, 'active', 'object', 'LinkState', NULL, 257);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(6, 'admin', '_J9..rasmMO3MxzFQWiQ');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=135 ;

--
-- Dumping data for table `widget_config`
--

INSERT INTO `widget_config` (`id`, `widget_id`) VALUES
(134, 4),
(133, 8),
(132, 12);

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `widget_config_content`
--

CREATE TABLE IF NOT EXISTS `widget_config_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `config_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `config_id` (`config_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `widget_config_content`
--

INSERT INTO `widget_config_content` (`id`, `config_id`) VALUES
(1, 133);

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `widget_config_navigation`
--

INSERT INTO `widget_config_navigation` (`id`, `config_id`, `orientation`, `menu_id`) VALUES
(1, 132, 1, 4);

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `widget_config_textbox`
--

INSERT INTO `widget_config_textbox` (`id`, `config_id`, `text`) VALUES
(2, 134, '<p>This is the default Podium CMS page.</p>\r\n<p>Podium is a new CMS which aims to allow the creation of fully semantic content and also permit the creation of layouts and themes with nothing more than a browser. Podium uses no HTML or CSS templates to produce the design of a page.</p>\r\n<p>Podium has been created using the Picon Framework.</p>\r\n<p>Navigate to the admin portal to start creating content, layouts and themes.</p>');

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
