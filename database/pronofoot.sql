-- phpMyAdmin SQL Dump
-- version 3.1.3.1
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Ven 04 Septembre 2009 à 16:03
-- Version du serveur: 5.1.36
-- Version de PHP: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `pronofoot`
--

-- --------------------------------------------------------

--
-- Structure de la table `equipe`
--

DROP TABLE IF EXISTS `equipe`;
CREATE TABLE `equipe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Contenu de la table `equipe`
--


-- --------------------------------------------------------

--
-- Structure de la table `groupe`
--

DROP TABLE IF EXISTS `groupe`;
CREATE TABLE `groupe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Contenu de la table `groupe`
--

INSERT INTO `groupe` (`id`, `nom`) VALUES
(1, 'EPF'),
(2, 'TUVB'),
(3, 'CVPT');

-- --------------------------------------------------------

--
-- Structure de la table `joueur`
--

DROP TABLE IF EXISTS `joueur`;
CREATE TABLE `joueur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `pseudo` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `pass` char(40) COLLATE utf8_unicode_ci NOT NULL,
  `points` int(11) NOT NULL,
  `journees` int(11) NOT NULL,
  `idgroups` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Contenu de la table `joueur`
--

INSERT INTO `joueur` (`id`, `email`, `pseudo`, `pass`, `points`, `journees`, `idgroups`) VALUES
(1, 'arthurfoucher@hotmail.com', 'Arthur', '411939730e04b1973ebc27489f545a2a5f082c1d', 14, 3, '1,2,3'),
(2, 'lesnegaga@hotmail.com', 'Gaga', 'f11d4b1546373cc6f83bb0fbc74409cf0214a901', 17, 3, '1'),
(3, 'guiry_anand@hotmail.com', 'Tok', '0c33e9d0f158346a970d0ada74ce6d61f43e46c9', 13, 3, '1'),
(4, 'tonio_it93@hotmail.com', 'Tonio', 'b0a12e054f92c1fe43f87d29f601c24104382165', 13, 3, '1'),
(5, 'lalecys@hotmail.com', 'Chasseur', 'f2a3121c47d8f97ad3681a532090f15e867b56f8', 14, 3, '1'),
(6, 'geoffreysteines2@hotmail.com', 'Kiddo', '', 7, 1, '2,3'),
(7, 'canasucre_tm@hotmail.com', 'Jaminben', '', 0, 0, '2,3');

-- --------------------------------------------------------

--
-- Structure de la table `journee`
--

DROP TABLE IF EXISTS `journee`;
CREATE TABLE `journee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` int(11) NOT NULL,
  `numero` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Contenu de la table `journee`
--

INSERT INTO `journee` (`id`, `date`, `numero`) VALUES
(1, 1252774800, 5),
(2, 1253379600, 6),
(3, 1253984400, 7);

-- --------------------------------------------------------

--
-- Structure de la table `match`
--

DROP TABLE IF EXISTS `match`;
CREATE TABLE `match` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `score` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `equipe1` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `equipe2` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `idjournee` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Contenu de la table `match`
--

INSERT INTO `match` (`id`, `score`, `equipe1`, `equipe2`, `idjournee`) VALUES
(1, '', 'Le Mans', 'Marseilles', 1),
(2, '', 'Lyon', 'Lorient', 1),
(3, '', 'Nancy', 'Toulouse', 1),
(5, '', 'Monaco', 'Paris-SG', 1),
(6, '', 'Bordeaux', 'Grenoble', 1);


-- --------------------------------------------------------

--
-- Structure de la table `prono`
--

DROP TABLE IF EXISTS `prono`;
CREATE TABLE `prono` (
  `idmatch` int(11) NOT NULL,
  `idjoueur` int(11) NOT NULL,
  `score` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idmatch`,`idjoueur`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `prono`
--


