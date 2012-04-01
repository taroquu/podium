-- phpMyAdmin SQL Dump
-- version 3.4.3.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 02, 2012 at 12:51 AM
-- Server version: 5.5.15
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `podium`
--

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `widget_config_image`
--

INSERT INTO `widget_config_image` (`id`, `config_id`, `path`, `height`, `width`) VALUES
(1, 106, 'media/images/marble_ioannina.JPG', 50, 50);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `widget_config_image`
--
ALTER TABLE `widget_config_image`
  ADD CONSTRAINT `widget_config_image_ibfk_1` FOREIGN KEY (`config_id`) REFERENCES `widget_config` (`id`) ON UPDATE CASCADE;
