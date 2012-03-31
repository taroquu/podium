-- phpMyAdmin SQL Dump
-- version 3.4.3.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 31, 2012 at 05:32 PM
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `arrangement`
--

INSERT INTO `arrangement` (`id`, `layout_id`, `name`) VALUES
(1, 21, 'test a 1');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

--
-- Dumping data for table `arrangement_elements`
--

INSERT INTO `arrangement_elements` (`id`, `arrangement_id`, `block_id`, `index`, `widget_id`, `widget_config_id`) VALUES
(32, 1, 16, 0, 3, 26),
(33, 1, 17, 0, 8, 47);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=45 ;

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
(43, 'test with theme', 5),
(44, 'test with theme', 5);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `content_attributes`
--

INSERT INTO `content_attributes` (`id`, `name`, `widget_id`) VALUES
(1, 'heading', 3),
(2, 'text block', 4);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

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
(19, 42, 7, 45);

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
(1, 'web pageddd', 'page', 1, 2),
(2, 'blog post', 'post', 1, 2),
(3, 'test with arrangement', 'post', 1, 2),
(4, 'testtest', 'page', 1, 6),
(5, 'test with theme', 'page', 1, 5);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `content_type_attributes`
--

INSERT INTO `content_type_attributes` (`id`, `name`, `content_type_id`, `attribute_id`, `index`) VALUES
(3, 'test attribute 3', 1, 2, 1),
(7, 'test attribute 6', 1, 2, 0),
(8, 'test attribute 5', 1, 1, 2),
(9, 'text', 2, 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `form`
--

CREATE TABLE IF NOT EXISTS `form` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `action` int(11) NOT NULL,
  `action_value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `form`
--

INSERT INTO `form` (`id`, `name`, `action`, `action_value`) VALUES
(1, 'sample form', 1, 'AdminHomePage'),
(2, 'test', 1, '');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

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
(24, 2, 'TextField', 'test', 1, 0, '', ''),
(25, 2, 'TextAreaField', 'test2', 0, 0, '', '');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=75 ;

--
-- Dumping data for table `form_element_options`
--

INSERT INTO `form_element_options` (`id`, `form_element_id`, `option`) VALUES
(67, 19, 'op1'),
(68, 19, 'op2'),
(69, 19, 'op3'),
(70, 20, 'radio op1'),
(71, 20, 'another op'),
(72, 22, 'check op1'),
(73, 22, 'check op2'),
(74, 22, 'check op3');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=43 ;

--
-- Dumping data for table `page`
--

INSERT INTO `page` (`id`, `content_id`, `parent_id`, `index`, `arrangement_id`, `seo_title`, `meta_keys`, `meta_desc`, `homepage`, `theme_id`) VALUES
(39, 37, NULL, 1, NULL, 'titleddd', 'keysdd', 'descdd', 1, NULL),
(40, 42, NULL, 2, 1, '', '', '', 0, NULL),
(42, 44, NULL, 3, NULL, '', '', '', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE IF NOT EXISTS `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `content_id` (`content_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`id`, `content_id`) VALUES
(2, 40);

-- --------------------------------------------------------

--
-- Table structure for table `submits`
--

CREATE TABLE IF NOT EXISTS `submits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
(7, 'testlinksvalues2');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=380 ;

--
-- Dumping data for table `theme_attributes`
--

INSERT INTO `theme_attributes` (`id`, `theme_element_id`, `name`, `value`) VALUES
(165, 135, 'background', 'FF0F0F'),
(166, 135, 'fontsize', '8'),
(167, 135, 'fontcolour', 'FF00F7'),
(168, 136, 'textColour', 'FF0000'),
(169, 136, 'textSize', '10'),
(170, 136, 'decoration', 'underline'),
(171, 136, 'weight', 'bold'),
(172, 137, 'textColour', 'FFCD03'),
(173, 137, 'textSize', '10'),
(174, 137, 'decoration', 'underline'),
(175, 137, 'weight', 'normal'),
(176, 138, 'textColour', 'E5FF00'),
(177, 138, 'textSize', '10'),
(178, 138, 'decoration', 'overline'),
(179, 138, 'weight', 'lighter'),
(180, 139, 'textColour', '00FF00'),
(181, 139, 'textSize', '10'),
(182, 139, 'decoration', 'line-through'),
(183, 139, 'weight', 'lighter'),
(184, 140, 'textColour', '0AA5FF'),
(185, 140, 'textSize', '10'),
(186, 140, 'decoration', 'line-through'),
(187, 140, 'weight', 'bolder'),
(188, 141, 'textColour', 'FF05F7'),
(189, 141, 'textSize', '10'),
(190, 141, 'decoration', 'overline'),
(191, 141, 'weight', 'bolder'),
(192, 142, 'fontsize', '72'),
(193, 142, 'fontcolour', '5FFF0F'),
(263, 162, 'background', 'FFFFFF'),
(264, 162, 'fontsize', '10'),
(265, 162, 'fontcolour', '000000'),
(266, 163, 'textColour', '000000'),
(267, 163, 'textSize', '10'),
(268, 163, 'decoration', 'none'),
(269, 163, 'weight', 'bold'),
(270, 164, 'textColour', '000000'),
(271, 164, 'textSize', '10'),
(272, 164, 'decoration', 'none'),
(273, 164, 'weight', 'bold'),
(274, 165, 'textColour', '000000'),
(275, 165, 'textSize', '10'),
(276, 165, 'decoration', 'none'),
(277, 165, 'weight', 'bold'),
(278, 166, 'textColour', '000000'),
(279, 166, 'textSize', '10'),
(280, 166, 'decoration', 'none'),
(281, 166, 'weight', 'bold'),
(282, 167, 'textColour', '000000'),
(283, 167, 'textSize', '10'),
(284, 167, 'decoration', 'none'),
(285, 167, 'weight', 'bold'),
(286, 168, 'textColour', '000000'),
(287, 168, 'textSize', '10'),
(288, 168, 'decoration', 'none'),
(289, 168, 'weight', 'bold'),
(290, 170, 'fontsize', '10'),
(291, 170, 'fontcolour', 'FF0000'),
(292, 170, 'decoration', ''),
(293, 170, 'weight', ''),
(294, 171, 'fontsize', '10'),
(295, 171, 'fontcolour', '22FF00'),
(296, 171, 'decoration', ''),
(297, 171, 'weight', ''),
(298, 172, 'fontsize', '10'),
(299, 172, 'fontcolour', '0000FF'),
(300, 172, 'decoration', ''),
(301, 172, 'weight', ''),
(302, 173, 'background', 'FFFFFF'),
(303, 173, 'fontsize', '10'),
(304, 173, 'fontcolour', '000000'),
(305, 174, 'textColour', '000000'),
(306, 174, 'textSize', '10'),
(307, 174, 'decoration', 'none'),
(308, 174, 'weight', 'bold'),
(309, 175, 'textColour', '000000'),
(310, 175, 'textSize', '10'),
(311, 175, 'decoration', 'none'),
(312, 175, 'weight', 'bold'),
(313, 176, 'textColour', '000000'),
(314, 176, 'textSize', '10'),
(315, 176, 'decoration', 'none'),
(316, 176, 'weight', 'bold'),
(317, 177, 'textColour', '000000'),
(318, 177, 'textSize', '10'),
(319, 177, 'decoration', 'none'),
(320, 177, 'weight', 'bold'),
(321, 178, 'textColour', '000000'),
(322, 178, 'textSize', '10'),
(323, 178, 'decoration', 'none'),
(324, 178, 'weight', 'bold'),
(325, 179, 'textColour', '000000'),
(326, 179, 'textSize', '10'),
(327, 179, 'decoration', 'none'),
(328, 179, 'weight', 'bold'),
(329, 181, 'fontsize', '10'),
(330, 181, 'fontcolour', 'FF0F0F'),
(331, 181, 'decoration', ''),
(332, 181, 'weight', ''),
(333, 182, 'fontsize', '10'),
(334, 182, 'fontcolour', '22FF00'),
(335, 182, 'decoration', ''),
(336, 182, 'weight', ''),
(337, 183, 'fontsize', '10'),
(338, 183, 'fontcolour', 'FF00D4'),
(339, 183, 'decoration', 'none'),
(340, 183, 'weight', ''),
(341, 184, 'background', 'FFFFFF'),
(342, 184, 'fontsize', '10'),
(343, 184, 'fontcolour', '000000'),
(344, 185, 'textColour', '000000'),
(345, 185, 'textSize', '10'),
(346, 185, 'decoration', 'none'),
(347, 185, 'weight', 'bold'),
(348, 186, 'textColour', '000000'),
(349, 186, 'textSize', '10'),
(350, 186, 'decoration', 'none'),
(351, 186, 'weight', 'bold'),
(352, 187, 'textColour', '000000'),
(353, 187, 'textSize', '10'),
(354, 187, 'decoration', 'none'),
(355, 187, 'weight', 'bold'),
(356, 188, 'textColour', '000000'),
(357, 188, 'textSize', '10'),
(358, 188, 'decoration', 'none'),
(359, 188, 'weight', 'bold'),
(360, 189, 'textColour', '000000'),
(361, 189, 'textSize', '10'),
(362, 189, 'decoration', 'none'),
(363, 189, 'weight', 'bold'),
(364, 190, 'textColour', '000000'),
(365, 190, 'textSize', '10'),
(366, 190, 'decoration', 'none'),
(367, 190, 'weight', 'bold'),
(368, 192, 'fontsize', '10'),
(369, 192, 'fontcolour', '000000'),
(370, 192, 'decoration', 'none'),
(371, 192, 'weight', 'bold'),
(372, 193, 'fontsize', '10'),
(373, 193, 'fontcolour', '000000'),
(374, 193, 'decoration', 'none'),
(375, 193, 'weight', 'bold'),
(376, 194, 'fontsize', '10'),
(377, 194, 'fontcolour', '000000'),
(378, 194, 'decoration', 'none'),
(379, 194, 'weight', 'bold');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=195 ;

--
-- Dumping data for table `theme_elements`
--

INSERT INTO `theme_elements` (`id`, `theme_id`, `name`, `type`, `class`, `index`, `parent_element`) VALUES
(135, 2, 'page', 'object', 'ThemePage', NULL, NULL),
(136, 2, 'headings', 'array', 'HeadingElement', 1, NULL),
(137, 2, 'headings', 'array', 'HeadingElement', 2, NULL),
(138, 2, 'headings', 'array', 'HeadingElement', 3, NULL),
(139, 2, 'headings', 'array', 'HeadingElement', 4, NULL),
(140, 2, 'headings', 'array', 'HeadingElement', 5, NULL),
(141, 2, 'headings', 'array', 'HeadingElement', 6, NULL),
(142, 2, 'links', 'object', 'ThemeLink', NULL, NULL),
(162, 5, 'page', 'object', 'ThemePage', NULL, NULL),
(163, 5, 'headings', 'array', 'HeadingElement', 1, NULL),
(164, 5, 'headings', 'array', 'HeadingElement', 2, NULL),
(165, 5, 'headings', 'array', 'HeadingElement', 3, NULL),
(166, 5, 'headings', 'array', 'HeadingElement', 4, NULL),
(167, 5, 'headings', 'array', 'HeadingElement', 5, NULL),
(168, 5, 'headings', 'array', 'HeadingElement', 6, NULL),
(169, 5, 'links', 'object', 'ThemeLink', NULL, NULL),
(170, 5, 'normal', 'object', 'LinkState', NULL, 169),
(171, 5, 'hover', 'object', 'LinkState', NULL, 169),
(172, 5, 'active', 'object', 'LinkState', NULL, 169),
(173, 6, 'page', 'object', 'ThemePage', NULL, NULL),
(174, 6, 'headings', 'array', 'HeadingElement', 1, NULL),
(175, 6, 'headings', 'array', 'HeadingElement', 2, NULL),
(176, 6, 'headings', 'array', 'HeadingElement', 3, NULL),
(177, 6, 'headings', 'array', 'HeadingElement', 4, NULL),
(178, 6, 'headings', 'array', 'HeadingElement', 5, NULL),
(179, 6, 'headings', 'array', 'HeadingElement', 6, NULL),
(180, 6, 'links', 'object', 'ThemeLink', NULL, NULL),
(181, 6, 'normal', 'object', 'LinkState', NULL, 180),
(182, 6, 'hover', 'object', 'LinkState', NULL, 180),
(183, 6, 'active', 'object', 'LinkState', NULL, 180),
(184, 7, 'page', 'object', 'ThemePage', NULL, NULL),
(185, 7, 'headings', 'array', 'HeadingElement', 1, NULL),
(186, 7, 'headings', 'array', 'HeadingElement', 2, NULL),
(187, 7, 'headings', 'array', 'HeadingElement', 3, NULL),
(188, 7, 'headings', 'array', 'HeadingElement', 4, NULL),
(189, 7, 'headings', 'array', 'HeadingElement', 5, NULL),
(190, 7, 'headings', 'array', 'HeadingElement', 6, NULL),
(191, 7, 'links', 'object', 'ThemeLink', NULL, NULL),
(192, 7, 'normal', 'object', 'LinkState', NULL, 191),
(193, 7, 'hover', 'object', 'LinkState', NULL, 191),
(194, 7, 'active', 'object', 'LinkState', NULL, 191);

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
  `category_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `setup` varchar(255) NOT NULL,
  `config` varchar(255) NOT NULL,
  `target_table` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `widgets`
--

INSERT INTO `widgets` (`id`, `category_id`, `name`, `class`, `setup`, `config`, `target_table`) VALUES
(3, 1, 'Heading', 'HeadingWidget', 'HeaderWidgetConfigPanel', 'HeaderWidgetConfig', 'widget_config_heading'),
(4, 1, 'Text Block', 'TextWidget', 'TextWidgetConfigPanel', 'TextWidgetConfig', 'widget_config_textbox'),
(6, 1, 'Form', 'FormWidget', 'FormWidgetConfigPanel', 'FormWidgetConfig', 'widget_config_form'),
(7, 1, 'Image', 'ImageWidget', 'ImageWidgetConfigPanel', 'ImageWidgetConfig', 'widget_config_image'),
(8, 1, 'Content Block', 'ContentWidget', 'ContentWidgetConfigPanel', 'ContentWidgetConfig', 'widget_config_content');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=48 ;

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
(1, 4),
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
(30, 6),
(35, 6),
(39, 6),
(40, 6),
(46, 8),
(47, 8);

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
(1, 47);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `widget_config_form`
--

INSERT INTO `widget_config_form` (`id`, `config_id`, `form`) VALUES
(4, 30, 1),
(6, 35, 1),
(7, 39, 1),
(8, 40, 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=43 ;

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
(42, 26, 'Heading 1', 'asdfasdf');

-- --------------------------------------------------------

--
-- Table structure for table `widget_config_image`
--

CREATE TABLE IF NOT EXISTS `widget_config_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `config_id` int(11) NOT NULL,
  `path` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `config_id` (`config_id`)
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=43 ;

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
(42, 45, '<p>sdfsdf</p>');

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
-- Constraints for table `page`
--
ALTER TABLE `page`
  ADD CONSTRAINT `page_ibfk_13` FOREIGN KEY (`theme_id`) REFERENCES `theme` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `page_ibfk_10` FOREIGN KEY (`content_id`) REFERENCES `content` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `page_ibfk_11` FOREIGN KEY (`parent_id`) REFERENCES `page` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `page_ibfk_12` FOREIGN KEY (`arrangement_id`) REFERENCES `arrangement` (`id`) ON UPDATE CASCADE;

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
  ADD CONSTRAINT `theme_elements_ibfk_2` FOREIGN KEY (`parent_element`) REFERENCES `theme_elements` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `theme_elements_ibfk_1` FOREIGN KEY (`theme_id`) REFERENCES `theme` (`id`) ON UPDATE CASCADE;

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
-- Constraints for table `widget_config_textbox`
--
ALTER TABLE `widget_config_textbox`
  ADD CONSTRAINT `widget_config_textbox_ibfk_1` FOREIGN KEY (`config_id`) REFERENCES `widget_config` (`id`) ON UPDATE CASCADE;
