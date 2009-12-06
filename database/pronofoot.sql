
-- phpMyAdmin SQL Dump
-- version 2.11.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 05, 2009 at 11:13 AM
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `groupe`
--

INSERT INTO `groupe` VALUES(1, 'EPF');
INSERT INTO `groupe` VALUES(2, 'TUVB');
INSERT INTO `groupe` VALUES(3, 'CVPT');
INSERT INTO `groupe` VALUES(4, 'DESCARTES');

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=15 ;

--
-- Dumping data for table `joueur`
--

INSERT INTO `joueur` VALUES(1, 'arthurfoucher@hotmail.com', 'Arthur', '411939730e04b1973ebc27489f545a2a5f082c1d', 46, 15, '1,2,3');
INSERT INTO `joueur` VALUES(2, 'lesnegaga@hotmail.com', 'Gaga', 'f11d4b1546373cc6f83bb0fbc74409cf0214a901', 49, 14, '1');
INSERT INTO `joueur` VALUES(3, 'guiry_anand@hotmail.com', 'Tok', '0c33e9d0f158346a970d0ada74ce6d61f43e46c9', 38, 15, '1');
INSERT INTO `joueur` VALUES(4, 'tonio_it93@hotmail.com', 'Tonio', '8a57b5f684b486a7b6006ca6f04207ae5f3d61c3', 38, 14, '1');
INSERT INTO `joueur` VALUES(5, 'lalecys@hotmail.com', 'Chasseur', 'f2a3121c47d8f97ad3681a532090f15e867b56f8', 50, 15, '1');
INSERT INTO `joueur` VALUES(6, 'geoffreysteines2@hotmail.com', 'Kiddo', '4a8dc115563750b59e9bef9ca1cc9798f0bc7358', 27, 12, '2,3');
INSERT INTO `joueur` VALUES(7, 'bentourret@gmail.com', 'Jaminben', 'db1f121dcd4dc8961288a25a103b053f44aec33d', 13, 7, '3');
INSERT INTO `joueur` VALUES(8, 'j.paroche@gmail.com', 'Falco', '3856a55506fec13418072fa8fcceeb05318e3ff4', 25, 11, '3,4');
INSERT INTO `joueur` VALUES(9, 'arabe2luxe@hotmail.fr', 'Momo', 'd6bddf8d0c2b776a2466c953a800840ea7da7b71', 15, 6, '4');
INSERT INTO `joueur` VALUES(10, 'mayk_nyc@hotmail.fr', 'Mayk', 'c15bdba5e9542430124fc427add5097d0f34f2bf', 12, 6, '3');
INSERT INTO `joueur` VALUES(13, 'delahayejeanbaptiste@gmail.com', 'JB', 'bbd510dd4ab631e75b85041d6cc86be7ddd27eba', 0, 1, '3');
INSERT INTO `joueur` VALUES(12, 'benjamin_300@msn.com', 'Benji', '18566558943d98c75fd622cea3d91474ebe3ff5d', 18, 7, '1');
INSERT INTO `joueur` VALUES(14, 'tournefier.florian@gmail.com', 'Iflo93', 'e40ae386308aff26a006ded5d1d66a5a54487bd2', 17, 8, '4');

-- --------------------------------------------------------

--
-- Table structure for table `journee`
--

DROP TABLE IF EXISTS `journee`;
CREATE TABLE `journee` (
  `id` int(11) NOT NULL auto_increment,
  `date` int(11) NOT NULL,
  `numero` int(11) NOT NULL,
  `terminated` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=14 ;

--
-- Dumping data for table `journee`
--

INSERT INTO `journee` VALUES(1, 1252774800, 5, 1);
INSERT INTO `journee` VALUES(2, 1253379600, 6, 1);
INSERT INTO `journee` VALUES(3, 1253984400, 7, 1);
INSERT INTO `journee` VALUES(4, 1254589200, 8, 1);
INSERT INTO `journee` VALUES(5, 1255798800, 9, 1);
INSERT INTO `journee` VALUES(6, 1256403600, 10, 1);
INSERT INTO `journee` VALUES(7, 1257012000, 12, 1);
INSERT INTO `journee` VALUES(8, 1257616800, 13, 1);
INSERT INTO `journee` VALUES(9, 1258740000, 14, 1);
INSERT INTO `journee` VALUES(10, 1259431200, 15, 1);
INSERT INTO `journee` VALUES(13, 1259776500, 14, 1);
INSERT INTO `journee` VALUES(12, 1260036000, 16, 0);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=54 ;

--
-- Dumping data for table `match`
--

INSERT INTO `match` VALUES(1, '1-2', 'Le Mans', 'Marseilles', 1);
INSERT INTO `match` VALUES(2, '1-0', 'Lyon', 'Lorient', 1);
INSERT INTO `match` VALUES(3, '0-0', 'Nancy', 'Toulouse', 1);
INSERT INTO `match` VALUES(4, '0-2', 'Boulogne / Mer', 'Bordeaux', 2);
INSERT INTO `match` VALUES(5, '2-0', 'Monaco', 'Paris-SG', 1);
INSERT INTO `match` VALUES(6, '1-0', 'Bordeaux', 'Grenoble', 1);
INSERT INTO `match` VALUES(7, '4-2', 'Marseille', 'Montpellier', 2);
INSERT INTO `match` VALUES(8, '2-0', 'Toulouse', 'Le Mans', 2);
INSERT INTO `match` VALUES(9, '1-1', 'Paris-SG', 'Lyon', 2);
INSERT INTO `match` VALUES(10, '1-1', 'Lorient', 'Paris-SG', 3);
INSERT INTO `match` VALUES(11, '2-1', 'Lyon', 'Toulouse', 3);
INSERT INTO `match` VALUES(12, '3-2', 'Valenciennes', 'Marseille', 3);
INSERT INTO `match` VALUES(13, '1-0', 'Bordeaux', 'Rennes', 3);
INSERT INTO `match` VALUES(14, '1-1', 'PSG', 'Nancy', 4);
INSERT INTO `match` VALUES(15, '3-1', 'AS St-Etienne', 'Bordeaux', 4);
INSERT INTO `match` VALUES(16, '0-1', 'Toulouse', 'Lorient', 4);
INSERT INTO `match` VALUES(17, '0-2', 'Lens', 'Lyon', 4);
INSERT INTO `match` VALUES(18, '1-2', 'Marseille', 'Monaco', 4);
INSERT INTO `match` VALUES(19, '1-0', 'Auxerre', 'Bordeaux', 5);
INSERT INTO `match` VALUES(20, '0-2', 'Lyon', 'Sochaux', 5);
INSERT INTO `match` VALUES(21, '0-3', 'Nancy', 'Marseille', 5);
INSERT INTO `match` VALUES(22, '1-0', 'Toulouse', 'Paris-SG', 5);
INSERT INTO `match` VALUES(23, '3-0', 'Bordeaux', 'Le Mans', 6);
INSERT INTO `match` VALUES(24, '4-1', 'Nice', 'Lyon', 6);
INSERT INTO `match` VALUES(25, '0-2', 'Lens', 'Toulouse', 6);
INSERT INTO `match` VALUES(27, '1-1', 'Marseille', 'Toulouse', 7);
INSERT INTO `match` VALUES(28, '1-0', 'Bordeaux', 'Monaco', 7);
INSERT INTO `match` VALUES(29, '1-4', 'Sochaux', 'Paris SG', 7);
INSERT INTO `match` VALUES(30, '0-1', 'Saint-Etienne', 'Lyon', 7);
INSERT INTO `match` VALUES(31, '0-1', 'Paris', 'Nice', 8);
INSERT INTO `match` VALUES(32, '3-2', 'Toulouse', 'Rennes', 8);
INSERT INTO `match` VALUES(33, '2-0', 'Lille', 'Bordeaux', 8);
INSERT INTO `match` VALUES(34, '5-5', 'Lyon', 'Marseille', 8);
INSERT INTO `match` VALUES(35, '0-1', 'Bordeaux', 'Valenciennes', 9);
INSERT INTO `match` VALUES(36, '1-0', 'Nice', 'Toulouse', 9);
INSERT INTO `match` VALUES(38, '1-1', 'Grenoble', 'Lyon', 9);
INSERT INTO `match` VALUES(41, '1-0', 'Marseille', 'Paris', 9);
INSERT INTO `match` VALUES(42, '1-0', 'Lens', 'Marseille', 10);
INSERT INTO `match` VALUES(43, '1-0', 'Toulouse', 'Boulogne', 10);
INSERT INTO `match` VALUES(44, '1-0', 'Paris', 'Auxerre', 10);
INSERT INTO `match` VALUES(45, '0-3', 'Nancy', 'Bordeaux', 10);
INSERT INTO `match` VALUES(46, '1-1', 'Lyon', 'Rennes', 10);
INSERT INTO `match` VALUES(53, '2-5', 'Boulogne', 'Paris-SG', 13);
INSERT INTO `match` VALUES(49, '', 'Grenoble', 'Toulouse', 12);
INSERT INTO `match` VALUES(50, '', 'Lille', 'Lyon', 12);
INSERT INTO `match` VALUES(51, '', 'Bordeaux', 'Paris', 12);
INSERT INTO `match` VALUES(52, '', 'Nice', 'Marseille', 12);

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
INSERT INTO `prono` VALUES(9, 8, '1-2');
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
INSERT INTO `prono` VALUES(4, 7, '0-1');
INSERT INTO `prono` VALUES(7, 7, '2-0');
INSERT INTO `prono` VALUES(8, 7, '1-1');
INSERT INTO `prono` VALUES(9, 7, '1-0');
INSERT INTO `prono` VALUES(4, 6, '0-2');
INSERT INTO `prono` VALUES(7, 6, '4-1');
INSERT INTO `prono` VALUES(8, 6, '1-0');
INSERT INTO `prono` VALUES(9, 6, '2-1');
INSERT INTO `prono` VALUES(4, 1, '1-2');
INSERT INTO `prono` VALUES(7, 1, '2-0');
INSERT INTO `prono` VALUES(8, 1, '1-0');
INSERT INTO `prono` VALUES(9, 1, '0-2');
INSERT INTO `prono` VALUES(4, 4, '0-2');
INSERT INTO `prono` VALUES(7, 4, '2-1');
INSERT INTO `prono` VALUES(8, 4, '1-0');
INSERT INTO `prono` VALUES(9, 4, '1-1');
INSERT INTO `prono` VALUES(4, 3, '1-2');
INSERT INTO `prono` VALUES(7, 3, '3-1');
INSERT INTO `prono` VALUES(8, 3, '0-1');
INSERT INTO `prono` VALUES(9, 3, '1-2');
INSERT INTO `prono` VALUES(4, 5, '0-2');
INSERT INTO `prono` VALUES(7, 5, '2-1');
INSERT INTO `prono` VALUES(8, 5, '1-1');
INSERT INTO `prono` VALUES(9, 5, '1-2');
INSERT INTO `prono` VALUES(4, 2, '0-2');
INSERT INTO `prono` VALUES(7, 2, '1-0');
INSERT INTO `prono` VALUES(8, 2, '2-0');
INSERT INTO `prono` VALUES(9, 2, '1-1');
INSERT INTO `prono` VALUES(4, 10, '1-2');
INSERT INTO `prono` VALUES(7, 10, '2-1');
INSERT INTO `prono` VALUES(8, 10, '2-0');
INSERT INTO `prono` VALUES(9, 10, '1-0');
INSERT INTO `prono` VALUES(10, 8, '1-2');
INSERT INTO `prono` VALUES(11, 8, '1-1');
INSERT INTO `prono` VALUES(12, 8, '0-2');
INSERT INTO `prono` VALUES(13, 8, '2-1');
INSERT INTO `prono` VALUES(10, 10, '1-2');
INSERT INTO `prono` VALUES(11, 10, '1-1');
INSERT INTO `prono` VALUES(12, 10, '0-2');
INSERT INTO `prono` VALUES(13, 10, '2-0');
INSERT INTO `prono` VALUES(10, 6, '0-2');
INSERT INTO `prono` VALUES(11, 6, '1-1');
INSERT INTO `prono` VALUES(12, 6, '1-2');
INSERT INTO `prono` VALUES(13, 6, '2-2');
INSERT INTO `prono` VALUES(10, 1, '1-1');
INSERT INTO `prono` VALUES(11, 1, '1-1');
INSERT INTO `prono` VALUES(12, 1, '0-2');
INSERT INTO `prono` VALUES(13, 1, '2-1');
INSERT INTO `prono` VALUES(10, 2, '1-2');
INSERT INTO `prono` VALUES(11, 2, '1-1');
INSERT INTO `prono` VALUES(12, 2, '1-3');
INSERT INTO `prono` VALUES(13, 2, '2-0');
INSERT INTO `prono` VALUES(10, 9, '0-1');
INSERT INTO `prono` VALUES(11, 9, '2-1');
INSERT INTO `prono` VALUES(12, 9, '0-2');
INSERT INTO `prono` VALUES(13, 9, '1-1');
INSERT INTO `prono` VALUES(10, 12, '1-1');
INSERT INTO `prono` VALUES(11, 12, '2-1');
INSERT INTO `prono` VALUES(12, 12, '0-2');
INSERT INTO `prono` VALUES(13, 12, '3-1');
INSERT INTO `prono` VALUES(10, 7, '1-2');
INSERT INTO `prono` VALUES(11, 7, '1-1');
INSERT INTO `prono` VALUES(12, 7, '0-2');
INSERT INTO `prono` VALUES(13, 7, '2-2');
INSERT INTO `prono` VALUES(10, 5, '1-2');
INSERT INTO `prono` VALUES(11, 5, '1-0');
INSERT INTO `prono` VALUES(12, 5, '0-2');
INSERT INTO `prono` VALUES(13, 5, '1-1');
INSERT INTO `prono` VALUES(10, 3, '0-1');
INSERT INTO `prono` VALUES(11, 3, '2-1');
INSERT INTO `prono` VALUES(12, 3, '1-3');
INSERT INTO `prono` VALUES(13, 3, '2-1');
INSERT INTO `prono` VALUES(10, 4, '0-1');
INSERT INTO `prono` VALUES(11, 4, '0-1');
INSERT INTO `prono` VALUES(12, 4, '1-3');
INSERT INTO `prono` VALUES(13, 4, '2-1');
INSERT INTO `prono` VALUES(10, 13, '0-1');
INSERT INTO `prono` VALUES(11, 13, '1-1');
INSERT INTO `prono` VALUES(12, 13, '0-2');
INSERT INTO `prono` VALUES(13, 13, '1-1');
INSERT INTO `prono` VALUES(14, 10, '1-0');
INSERT INTO `prono` VALUES(15, 10, '2-2');
INSERT INTO `prono` VALUES(16, 10, '1-1');
INSERT INTO `prono` VALUES(17, 10, '0-1');
INSERT INTO `prono` VALUES(18, 10, '2-0');
INSERT INTO `prono` VALUES(14, 9, '3-1');
INSERT INTO `prono` VALUES(15, 9, '1-2');
INSERT INTO `prono` VALUES(16, 9, '0-1');
INSERT INTO `prono` VALUES(17, 9, '0-2');
INSERT INTO `prono` VALUES(18, 9, '0-1');
INSERT INTO `prono` VALUES(14, 14, '2-1');
INSERT INTO `prono` VALUES(15, 14, '0-2');
INSERT INTO `prono` VALUES(16, 14, '0-1');
INSERT INTO `prono` VALUES(17, 14, '1-3');
INSERT INTO `prono` VALUES(18, 14, '2-2');
INSERT INTO `prono` VALUES(14, 6, '3-1');
INSERT INTO `prono` VALUES(15, 6, '1-1');
INSERT INTO `prono` VALUES(16, 6, '1-1');
INSERT INTO `prono` VALUES(17, 6, '0-2');
INSERT INTO `prono` VALUES(18, 6, '2-1');
INSERT INTO `prono` VALUES(14, 8, '2-1');
INSERT INTO `prono` VALUES(15, 8, '0-2');
INSERT INTO `prono` VALUES(16, 8, '2-0');
INSERT INTO `prono` VALUES(17, 8, '0-2');
INSERT INTO `prono` VALUES(18, 8, '3-1');
INSERT INTO `prono` VALUES(14, 12, '2-0');
INSERT INTO `prono` VALUES(15, 12, '1-2');
INSERT INTO `prono` VALUES(16, 12, '1-1');
INSERT INTO `prono` VALUES(17, 12, '0-1');
INSERT INTO `prono` VALUES(18, 12, '2-0');
INSERT INTO `prono` VALUES(14, 7, '2-1');
INSERT INTO `prono` VALUES(15, 7, '1-2');
INSERT INTO `prono` VALUES(16, 7, '2-1');
INSERT INTO `prono` VALUES(17, 7, '1-1');
INSERT INTO `prono` VALUES(18, 7, '2-0');
INSERT INTO `prono` VALUES(14, 5, '2-0');
INSERT INTO `prono` VALUES(15, 5, '1-1');
INSERT INTO `prono` VALUES(16, 5, '1-0');
INSERT INTO `prono` VALUES(17, 5, '0-2');
INSERT INTO `prono` VALUES(18, 5, '2-1');
INSERT INTO `prono` VALUES(14, 2, '2-0');
INSERT INTO `prono` VALUES(15, 2, '0-1');
INSERT INTO `prono` VALUES(16, 2, '1-1');
INSERT INTO `prono` VALUES(17, 2, '0-2');
INSERT INTO `prono` VALUES(18, 2, '2-1');
INSERT INTO `prono` VALUES(14, 4, '2-0');
INSERT INTO `prono` VALUES(15, 4, '1-1');
INSERT INTO `prono` VALUES(16, 4, '1-0');
INSERT INTO `prono` VALUES(17, 4, '0-1');
INSERT INTO `prono` VALUES(18, 4, '2-1');
INSERT INTO `prono` VALUES(14, 3, '2-1');
INSERT INTO `prono` VALUES(15, 3, '0-1');
INSERT INTO `prono` VALUES(16, 3, '1-1');
INSERT INTO `prono` VALUES(17, 3, '0-2');
INSERT INTO `prono` VALUES(18, 3, '3-1');
INSERT INTO `prono` VALUES(14, 1, '2-0');
INSERT INTO `prono` VALUES(15, 1, '1-2');
INSERT INTO `prono` VALUES(16, 1, '1-1');
INSERT INTO `prono` VALUES(17, 1, '0-2');
INSERT INTO `prono` VALUES(18, 1, '2-0');
INSERT INTO `prono` VALUES(19, 14, '0-1');
INSERT INTO `prono` VALUES(20, 14, '3-0');
INSERT INTO `prono` VALUES(21, 14, '1-1');
INSERT INTO `prono` VALUES(22, 14, '1-3');
INSERT INTO `prono` VALUES(19, 10, '1-1');
INSERT INTO `prono` VALUES(20, 10, '4-0');
INSERT INTO `prono` VALUES(21, 10, '1-1');
INSERT INTO `prono` VALUES(22, 10, '0-1');
INSERT INTO `prono` VALUES(19, 8, '0-3');
INSERT INTO `prono` VALUES(20, 8, '3-0');
INSERT INTO `prono` VALUES(21, 8, '0-2');
INSERT INTO `prono` VALUES(22, 8, '2-1');
INSERT INTO `prono` VALUES(19, 7, '1-2');
INSERT INTO `prono` VALUES(20, 7, '3-1');
INSERT INTO `prono` VALUES(21, 7, '1-3');
INSERT INTO `prono` VALUES(22, 7, '1-1');
INSERT INTO `prono` VALUES(23, 7, '2-1');
INSERT INTO `prono` VALUES(24, 7, '0-2');
INSERT INTO `prono` VALUES(25, 7, '1-3');
INSERT INTO `prono` VALUES(27, 4, '0-1');
INSERT INTO `prono` VALUES(19, 1, '0-2');
INSERT INTO `prono` VALUES(20, 1, '2-0');
INSERT INTO `prono` VALUES(21, 1, '1-3');
INSERT INTO `prono` VALUES(22, 1, '1-1');
INSERT INTO `prono` VALUES(19, 6, '0-2');
INSERT INTO `prono` VALUES(20, 6, '4-1');
INSERT INTO `prono` VALUES(21, 6, '1-1');
INSERT INTO `prono` VALUES(22, 6, '1-2');
INSERT INTO `prono` VALUES(19, 2, '0-2');
INSERT INTO `prono` VALUES(20, 2, '2-0');
INSERT INTO `prono` VALUES(21, 2, '0-2');
INSERT INTO `prono` VALUES(22, 2, '1-2');
INSERT INTO `prono` VALUES(19, 4, '0-2');
INSERT INTO `prono` VALUES(20, 4, '2-1');
INSERT INTO `prono` VALUES(21, 4, '1-1');
INSERT INTO `prono` VALUES(22, 4, '2-1');
INSERT INTO `prono` VALUES(19, 3, '0-2');
INSERT INTO `prono` VALUES(20, 3, '3-0');
INSERT INTO `prono` VALUES(21, 3, '1-2');
INSERT INTO `prono` VALUES(22, 3, '2-1');
INSERT INTO `prono` VALUES(19, 5, '0-2');
INSERT INTO `prono` VALUES(20, 5, '2-0');
INSERT INTO `prono` VALUES(21, 5, '1-2');
INSERT INTO `prono` VALUES(22, 5, '1-2');
INSERT INTO `prono` VALUES(19, 12, '0-3');
INSERT INTO `prono` VALUES(20, 12, '2-1');
INSERT INTO `prono` VALUES(21, 12, '1-1');
INSERT INTO `prono` VALUES(22, 12, '2-1');
INSERT INTO `prono` VALUES(23, 8, '2-0');
INSERT INTO `prono` VALUES(24, 8, '1-2');
INSERT INTO `prono` VALUES(25, 8, '1-2');
INSERT INTO `prono` VALUES(30, 8, '0-2');
INSERT INTO `prono` VALUES(23, 14, '2-0');
INSERT INTO `prono` VALUES(24, 14, '1-2');
INSERT INTO `prono` VALUES(25, 14, '0-1');
INSERT INTO `prono` VALUES(27, 8, '2-1');
INSERT INTO `prono` VALUES(23, 9, '2-0');
INSERT INTO `prono` VALUES(24, 9, '0-2');
INSERT INTO `prono` VALUES(25, 9, '1-0');
INSERT INTO `prono` VALUES(29, 8, '0-0');
INSERT INTO `prono` VALUES(23, 10, '3-2');
INSERT INTO `prono` VALUES(24, 10, '0-3');
INSERT INTO `prono` VALUES(25, 10, '0-2');
INSERT INTO `prono` VALUES(28, 8, '1-1');
INSERT INTO `prono` VALUES(23, 6, '3-1');
INSERT INTO `prono` VALUES(24, 6, '0-3');
INSERT INTO `prono` VALUES(25, 6, '1-1');
INSERT INTO `prono` VALUES(28, 4, '2-1');
INSERT INTO `prono` VALUES(23, 1, '2-0');
INSERT INTO `prono` VALUES(24, 1, '0-2');
INSERT INTO `prono` VALUES(25, 1, '1-0');
INSERT INTO `prono` VALUES(28, 3, '1-1');
INSERT INTO `prono` VALUES(23, 5, '2-0');
INSERT INTO `prono` VALUES(24, 5, '1-3');
INSERT INTO `prono` VALUES(25, 5, '1-0');
INSERT INTO `prono` VALUES(29, 4, '1-1');
INSERT INTO `prono` VALUES(23, 3, '2-1');
INSERT INTO `prono` VALUES(24, 3, '0-2');
INSERT INTO `prono` VALUES(25, 3, '1-1');
INSERT INTO `prono` VALUES(27, 3, '3-1');
INSERT INTO `prono` VALUES(23, 4, '2-0');
INSERT INTO `prono` VALUES(24, 4, '1-2');
INSERT INTO `prono` VALUES(25, 4, '0-0');
INSERT INTO `prono` VALUES(30, 4, '1-2');
INSERT INTO `prono` VALUES(29, 3, '1-1');
INSERT INTO `prono` VALUES(30, 3, '1-2');
INSERT INTO `prono` VALUES(27, 12, '1-1');
INSERT INTO `prono` VALUES(28, 12, '2-0');
INSERT INTO `prono` VALUES(29, 12, '1-0');
INSERT INTO `prono` VALUES(30, 12, '2-2');
INSERT INTO `prono` VALUES(27, 1, '1-1');
INSERT INTO `prono` VALUES(28, 1, '1-0');
INSERT INTO `prono` VALUES(29, 1, '0-1');
INSERT INTO `prono` VALUES(30, 1, '1-1');
INSERT INTO `prono` VALUES(27, 5, '2-0');
INSERT INTO `prono` VALUES(28, 5, '2-1');
INSERT INTO `prono` VALUES(29, 5, '0-1');
INSERT INTO `prono` VALUES(30, 5, '1-2');
INSERT INTO `prono` VALUES(27, 2, '1-1');
INSERT INTO `prono` VALUES(28, 2, '2-1');
INSERT INTO `prono` VALUES(29, 2, '0-1');
INSERT INTO `prono` VALUES(30, 2, '0-2');
INSERT INTO `prono` VALUES(28, 14, '2-1');
INSERT INTO `prono` VALUES(29, 14, '1-3');
INSERT INTO `prono` VALUES(30, 14, '0-2');
INSERT INTO `prono` VALUES(27, 14, '1-1');
INSERT INTO `prono` VALUES(27, 6, '2-1');
INSERT INTO `prono` VALUES(28, 6, '2-0');
INSERT INTO `prono` VALUES(29, 6, '0-2');
INSERT INTO `prono` VALUES(30, 6, '2-2');
INSERT INTO `prono` VALUES(27, 9, '2-1');
INSERT INTO `prono` VALUES(28, 9, '2-1');
INSERT INTO `prono` VALUES(29, 9, '0-1');
INSERT INTO `prono` VALUES(30, 9, '1-2');
INSERT INTO `prono` VALUES(31, 5, '2-1');
INSERT INTO `prono` VALUES(32, 5, '1-1');
INSERT INTO `prono` VALUES(33, 5, '0-1');
INSERT INTO `prono` VALUES(34, 5, '1-1');
INSERT INTO `prono` VALUES(31, 14, '2-1');
INSERT INTO `prono` VALUES(32, 14, '0-0');
INSERT INTO `prono` VALUES(33, 14, '0-1');
INSERT INTO `prono` VALUES(34, 14, '1-1');
INSERT INTO `prono` VALUES(31, 1, '1-0');
INSERT INTO `prono` VALUES(32, 1, '1-0');
INSERT INTO `prono` VALUES(33, 1, '1-2');
INSERT INTO `prono` VALUES(34, 1, '2-1');
INSERT INTO `prono` VALUES(31, 7, '2-2');
INSERT INTO `prono` VALUES(32, 7, '1-1');
INSERT INTO `prono` VALUES(33, 7, '1-1');
INSERT INTO `prono` VALUES(34, 7, '1-2');
INSERT INTO `prono` VALUES(31, 6, '2-0');
INSERT INTO `prono` VALUES(32, 6, '1-1');
INSERT INTO `prono` VALUES(33, 6, '2-2');
INSERT INTO `prono` VALUES(34, 6, '2-1');
INSERT INTO `prono` VALUES(31, 9, '2-0');
INSERT INTO `prono` VALUES(32, 9, '1-1');
INSERT INTO `prono` VALUES(33, 9, '0-2');
INSERT INTO `prono` VALUES(34, 9, '1-0');
INSERT INTO `prono` VALUES(31, 8, '2-1');
INSERT INTO `prono` VALUES(32, 8, '1-1');
INSERT INTO `prono` VALUES(33, 8, '0-2');
INSERT INTO `prono` VALUES(34, 8, '1-3');
INSERT INTO `prono` VALUES(31, 3, '1-0');
INSERT INTO `prono` VALUES(32, 3, '0-0');
INSERT INTO `prono` VALUES(33, 3, '0-2');
INSERT INTO `prono` VALUES(34, 3, '1-2');
INSERT INTO `prono` VALUES(31, 2, '3-1');
INSERT INTO `prono` VALUES(32, 2, '2-1');
INSERT INTO `prono` VALUES(33, 2, '1-1');
INSERT INTO `prono` VALUES(34, 2, '2-1');
INSERT INTO `prono` VALUES(31, 12, '2-0');
INSERT INTO `prono` VALUES(32, 12, '1-0');
INSERT INTO `prono` VALUES(33, 12, '0-2');
INSERT INTO `prono` VALUES(34, 12, '1-1');
INSERT INTO `prono` VALUES(41, 8, '9-0');
INSERT INTO `prono` VALUES(41, 14, '5-5');
INSERT INTO `prono` VALUES(35, 10, '1-0');
INSERT INTO `prono` VALUES(36, 10, '2-1');
INSERT INTO `prono` VALUES(38, 10, '0-2');
INSERT INTO `prono` VALUES(41, 10, '2-3');
INSERT INTO `prono` VALUES(35, 6, '3-1');
INSERT INTO `prono` VALUES(36, 6, '2-1');
INSERT INTO `prono` VALUES(38, 6, '0-3');
INSERT INTO `prono` VALUES(41, 6, '1-2');
INSERT INTO `prono` VALUES(35, 1, '2-0');
INSERT INTO `prono` VALUES(36, 1, '1-1');
INSERT INTO `prono` VALUES(38, 1, '0-1');
INSERT INTO `prono` VALUES(41, 1, '1-1');
INSERT INTO `prono` VALUES(35, 3, '1-0');
INSERT INTO `prono` VALUES(36, 3, '1-1');
INSERT INTO `prono` VALUES(38, 3, '0-2');
INSERT INTO `prono` VALUES(41, 3, '2-0');
INSERT INTO `prono` VALUES(35, 5, '2-0');
INSERT INTO `prono` VALUES(36, 5, '1-0');
INSERT INTO `prono` VALUES(38, 5, '0-2');
INSERT INTO `prono` VALUES(41, 5, '1-2');
INSERT INTO `prono` VALUES(35, 2, '1-0');
INSERT INTO `prono` VALUES(36, 2, '1-1');
INSERT INTO `prono` VALUES(38, 2, '0-2');
INSERT INTO `prono` VALUES(35, 4, '1-0');
INSERT INTO `prono` VALUES(36, 4, '0-1');
INSERT INTO `prono` VALUES(38, 4, '0-2');
INSERT INTO `prono` VALUES(41, 4, '1-1');
INSERT INTO `prono` VALUES(35, 8, '2-1');
INSERT INTO `prono` VALUES(36, 8, '2-2');
INSERT INTO `prono` VALUES(38, 8, '0-3');
INSERT INTO `prono` VALUES(42, 8, '1-3');
INSERT INTO `prono` VALUES(43, 8, '2-0');
INSERT INTO `prono` VALUES(44, 8, '1-0');
INSERT INTO `prono` VALUES(45, 8, '0-2');
INSERT INTO `prono` VALUES(46, 8, '2-1');
INSERT INTO `prono` VALUES(42, 1, '0-3');
INSERT INTO `prono` VALUES(43, 1, '2-0');
INSERT INTO `prono` VALUES(44, 1, '1-0');
INSERT INTO `prono` VALUES(45, 1, '0-1');
INSERT INTO `prono` VALUES(46, 1, '2-0');
INSERT INTO `prono` VALUES(42, 3, '1-3');
INSERT INTO `prono` VALUES(43, 3, '1-0');
INSERT INTO `prono` VALUES(44, 3, '2-0');
INSERT INTO `prono` VALUES(45, 3, '0-1');
INSERT INTO `prono` VALUES(46, 3, '1-0');
INSERT INTO `prono` VALUES(42, 6, '1-2');
INSERT INTO `prono` VALUES(43, 6, '2-0');
INSERT INTO `prono` VALUES(44, 6, '2-0');
INSERT INTO `prono` VALUES(45, 6, '1-3');
INSERT INTO `prono` VALUES(46, 6, '2-2');
INSERT INTO `prono` VALUES(42, 2, '0-2');
INSERT INTO `prono` VALUES(43, 2, '2-0');
INSERT INTO `prono` VALUES(44, 2, '2-1');
INSERT INTO `prono` VALUES(45, 2, '1-1');
INSERT INTO `prono` VALUES(46, 2, '1-0');
INSERT INTO `prono` VALUES(42, 12, '1-2');
INSERT INTO `prono` VALUES(43, 12, '2-0');
INSERT INTO `prono` VALUES(44, 12, '0-1');
INSERT INTO `prono` VALUES(45, 12, '0-2');
INSERT INTO `prono` VALUES(46, 12, '3-1');
INSERT INTO `prono` VALUES(42, 14, '0-3');
INSERT INTO `prono` VALUES(43, 14, '2-1');
INSERT INTO `prono` VALUES(44, 14, '2-1');
INSERT INTO `prono` VALUES(45, 14, '0-2');
INSERT INTO `prono` VALUES(46, 14, '0-1');
INSERT INTO `prono` VALUES(42, 5, '1-3');
INSERT INTO `prono` VALUES(43, 5, '2-0');
INSERT INTO `prono` VALUES(44, 5, '1-0');
INSERT INTO `prono` VALUES(45, 5, '0-1');
INSERT INTO `prono` VALUES(46, 5, '1-1');
INSERT INTO `prono` VALUES(42, 4, '0-2');
INSERT INTO `prono` VALUES(43, 4, '2-0');
INSERT INTO `prono` VALUES(44, 4, '1-0');
INSERT INTO `prono` VALUES(45, 4, '0-1');
INSERT INTO `prono` VALUES(46, 4, '2-1');
INSERT INTO `prono` VALUES(49, 8, '0-2');
INSERT INTO `prono` VALUES(50, 8, '1-1');
INSERT INTO `prono` VALUES(51, 8, '2-1');
INSERT INTO `prono` VALUES(52, 8, '1-2');
INSERT INTO `prono` VALUES(49, 10, '1-0');
INSERT INTO `prono` VALUES(50, 10, '2-1');
INSERT INTO `prono` VALUES(51, 10, '1-1');
INSERT INTO `prono` VALUES(52, 10, '1-3');
INSERT INTO `prono` VALUES(53, 1, '0-2');
INSERT INTO `prono` VALUES(53, 3, '0-1');
INSERT INTO `prono` VALUES(53, 4, '0-1');
INSERT INTO `prono` VALUES(53, 5, '0-1');
INSERT INTO `prono` VALUES(53, 8, '0-2');
INSERT INTO `prono` VALUES(53, 2, '0-2');
INSERT INTO `prono` VALUES(53, 12, '1-2');
INSERT INTO `prono` VALUES(53, 14, '0-2');
INSERT INTO `prono` VALUES(53, 6, '0-2');
INSERT INTO `prono` VALUES(53, 9, '0-2');
INSERT INTO `prono` VALUES(49, 5, '0-2');
INSERT INTO `prono` VALUES(50, 5, '1-1');
INSERT INTO `prono` VALUES(51, 5, '1-2');
INSERT INTO `prono` VALUES(52, 5, '0-1');
INSERT INTO `prono` VALUES(49, 6, '1-0');
INSERT INTO `prono` VALUES(50, 6, '2-1');
INSERT INTO `prono` VALUES(51, 6, '1-2');
INSERT INTO `prono` VALUES(52, 6, '1-1');
INSERT INTO `prono` VALUES(49, 2, '1-2');
INSERT INTO `prono` VALUES(50, 2, '1-1');
INSERT INTO `prono` VALUES(51, 2, '2-0');
INSERT INTO `prono` VALUES(52, 2, '0-1');
INSERT INTO `prono` VALUES(49, 12, '0-1');
INSERT INTO `prono` VALUES(50, 12, '1-2');
INSERT INTO `prono` VALUES(51, 12, '3-1');
INSERT INTO `prono` VALUES(52, 12, '1-1');
INSERT INTO `prono` VALUES(49, 4, '0-1');
INSERT INTO `prono` VALUES(50, 4, '1-1');
INSERT INTO `prono` VALUES(51, 4, '2-1');
INSERT INTO `prono` VALUES(52, 4, '1-2');
INSERT INTO `prono` VALUES(49, 1, '1-1');
INSERT INTO `prono` VALUES(50, 1, '2-1');
INSERT INTO `prono` VALUES(51, 1, '2-0');
INSERT INTO `prono` VALUES(52, 1, '0-1');
INSERT INTO `prono` VALUES(49, 7, '2-1');
INSERT INTO `prono` VALUES(50, 7, '1-1');
INSERT INTO `prono` VALUES(51, 7, '2-1');
INSERT INTO `prono` VALUES(52, 7, '0-2');
INSERT INTO `prono` VALUES(49, 9, '0-2');
INSERT INTO `prono` VALUES(50, 9, '1-1');
INSERT INTO `prono` VALUES(51, 9, '0-1');
INSERT INTO `prono` VALUES(52, 9, '2-1');
