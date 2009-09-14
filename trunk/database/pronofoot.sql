
-- phpMyAdmin SQL Dump
-- version 2.11.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 13, 2009 at 05:34 PM
-- Server version: 5.0.67
-- PHP Version: 5.2.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `a7959742_prono`
--

-- --------------------------------------------------------

--
-- Table structure for table `groupe`
--

DROP TABLE IF EXISTS `groupe`;
CREATE TABLE `groupe` (
  `id` int(11) NOT NULL auto_increment,
  `nom` varchar(32) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `groupe`
--

INSERT INTO `groupe` VALUES(1, 'EPF');
INSERT INTO `groupe` VALUES(2, 'TUVB');
INSERT INTO `groupe` VALUES(3, 'CVPT');

-- --------------------------------------------------------

--
-- Table structure for table `joueur`
--

DROP TABLE IF EXISTS `joueur`;
CREATE TABLE `joueur` (
  `id` int(11) NOT NULL auto_increment,
  `email` varchar(64) collate utf8_unicode_ci NOT NULL,
  `pseudo` varchar(32) collate utf8_unicode_ci NOT NULL,
  `pass` char(40) collate utf8_unicode_ci NOT NULL,
  `points` int(11) NOT NULL,
  `journees` int(11) NOT NULL,
  `idgroups` varchar(11) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Dumping data for table `joueur`
--

INSERT INTO `joueur` VALUES(1, 'arthurfoucher@hotmail.com', 'Arthur', '411939730e04b1973ebc27489f545a2a5f082c1d', 16, 4, '1,2,3');
INSERT INTO `joueur` VALUES(2, 'lesnegaga@hotmail.com', 'Gaga', 'f11d4b1546373cc6f83bb0fbc74409cf0214a901', 24, 5, '1');
INSERT INTO `joueur` VALUES(3, 'guiry_anand@hotmail.com', 'Tok', '0c33e9d0f158346a970d0ada74ce6d61f43e46c9', 18, 5, '1');
INSERT INTO `joueur` VALUES(4, 'tonio_it93@hotmail.com', 'Tonio', '8a57b5f684b486a7b6006ca6f04207ae5f3d61c3', 18, 5, '1');
INSERT INTO `joueur` VALUES(5, 'lalecys@hotmail.com', 'Chasseur', 'f2a3121c47d8f97ad3681a532090f15e867b56f8', 24, 5, '1');
INSERT INTO `joueur` VALUES(6, 'geoffreysteines2@hotmail.com', 'Kiddo', '4a8dc115563750b59e9bef9ca1cc9798f0bc7358', 7, 1, '2,3');
INSERT INTO `joueur` VALUES(7, 'canasucre_tm@hotmail.com', 'Jaminben', 'db1f121dcd4dc8961288a25a103b053f44aec33d', 0, 0, '3');
INSERT INTO `joueur` VALUES(8, 'j.paroche@gmail.com', 'faLco', 'e7342e6259084756aa6af71f24e79e85a3e033eb', 0, 0, '3');

-- --------------------------------------------------------

--
-- Table structure for table `journee`
--

DROP TABLE IF EXISTS `journee`;
CREATE TABLE `journee` (
  `id` int(11) NOT NULL auto_increment,
  `date` int(11) NOT NULL,
  `numero` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `journee`
--

INSERT INTO `journee` VALUES(1, 1252774800, 5);
INSERT INTO `journee` VALUES(2, 1253379600, 6);
INSERT INTO `journee` VALUES(3, 1253984400, 7);

-- --------------------------------------------------------

--
-- Table structure for table `match`
--

DROP TABLE IF EXISTS `match`;
CREATE TABLE `match` (
  `id` int(11) NOT NULL auto_increment,
  `score` varchar(5) collate utf8_unicode_ci NOT NULL,
  `equipe1` varchar(32) collate utf8_unicode_ci NOT NULL,
  `equipe2` varchar(32) collate utf8_unicode_ci NOT NULL,
  `idjournee` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=14 ;

--
-- Dumping data for table `match`
--

INSERT INTO `match` VALUES(1, '1-2', 'Le Mans', 'Marseilles', 1);
INSERT INTO `match` VALUES(2, '1-0', 'Lyon', 'Lorient', 1);
INSERT INTO `match` VALUES(3, '0-0', 'Nancy', 'Toulouse', 1);
INSERT INTO `match` VALUES(4, '', 'Boulogne / Mer', 'Bordeaux', 2);
INSERT INTO `match` VALUES(5, '2-0', 'Monaco', 'Paris-SG', 1);
INSERT INTO `match` VALUES(6, '1-0', 'Bordeaux', 'Grenoble', 1);
INSERT INTO `match` VALUES(7, '', 'Marseille', 'Montpellier', 2);
INSERT INTO `match` VALUES(8, '', 'Toulouse', 'Le Mans', 2);
INSERT INTO `match` VALUES(9, '', 'Paris-SG', 'Lyon', 2);
INSERT INTO `match` VALUES(10, '', 'Lorient', 'Paris-SG', 3);
INSERT INTO `match` VALUES(11, '', 'Lyon', 'Toulouse', 3);
INSERT INTO `match` VALUES(12, '', 'Valenciennes', 'Marseille', 3);
INSERT INTO `match` VALUES(13, '', 'Bordeaux', 'Rennes', 3);

-- --------------------------------------------------------

--
-- Table structure for table `prono`
--

DROP TABLE IF EXISTS `prono`;
CREATE TABLE `prono` (
  `idmatch` int(11) NOT NULL,
  `idjoueur` int(11) NOT NULL,
  `score` varchar(5) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`idmatch`,`idjoueur`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `prono`
--

INSERT INTO `prono` VALUES(1, 8, '0-3');
INSERT INTO `prono` VALUES(2, 8, '2-1');
INSERT INTO `prono` VALUES(3, 8, '1-1');
INSERT INTO `prono` VALUES(5, 8, '2-1');
INSERT INTO `prono` VALUES(6, 8, '2-0');
INSERT INTO `prono` VALUES(1, 1, '0-2');
INSERT INTO `prono` VALUES(4, 8, '0-2');
INSERT INTO `prono` VALUES(2, 1, '2-0');
INSERT INTO `prono` VALUES(3, 1, '1-1');
INSERT INTO `prono` VALUES(5, 1, '1-1');
INSERT INTO `prono` VALUES(6, 1, '3-1');
INSERT INTO `prono` VALUES(7, 8, '1-0');
INSERT INTO `prono` VALUES(8, 8, '1-1');
INSERT INTO `prono` VALUES(9, 8, '2-1');
INSERT INTO `prono` VALUES(1, 7, '1-2');
INSERT INTO `prono` VALUES(2, 7, '2-0');
INSERT INTO `prono` VALUES(3, 7, '0-0');
INSERT INTO `prono` VALUES(5, 7, '1-1');
INSERT INTO `prono` VALUES(6, 7, '2-1');
INSERT INTO `prono` VALUES(1, 6, '0-2');
INSERT INTO `prono` VALUES(2, 6, '3-1');
INSERT INTO `prono` VALUES(3, 6, '2-1');
INSERT INTO `prono` VALUES(5, 6, '1-2');
INSERT INTO `prono` VALUES(6, 6, '3-0');
INSERT INTO `prono` VALUES(4, 7, '1-2');
INSERT INTO `prono` VALUES(7, 7, '2-0');
INSERT INTO `prono` VALUES(8, 7, '1-1');
INSERT INTO `prono` VALUES(9, 7, '0-0');
