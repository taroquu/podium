-- phpMyAdmin SQL Dump
-- version 3.4.3.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 03, 2012 at 06:26 PM
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

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

-- --------------------------------------------------------

--
-- Table structure for table `navigation_menu`
--

CREATE TABLE IF NOT EXISTS `navigation_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
