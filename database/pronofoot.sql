-- phpMyAdmin SQL Dump
-- version 3.1.3
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Mar 01 Septembre 2009 à 04:05
-- Version du serveur: 5.1.32
-- Version de PHP: 5.2.9-1

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
  `idgroups` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Contenu de la table `joueur`
--

INSERT INTO `joueur` (`id`, `email`, `pseudo`, `pass`, `points`, `journees`, `idgroups`) VALUES
(1, 'arthurfoucher@hotmail.com', 'Arthur', '4b140bfcbfea1fc724d73b2081d64c22209d0218', 14, 3, 0),
(2, 'lesnegaga@hotmail.com', 'Gaga', '', 17, 3, 0),
(3, 'guiry_anand@hotmail.com', 'Tok', '', 13, 3, 0),
(4, 'tonio_it93@hotmail.com', 'Tonio', '', 13, 3, 0),
(5, 'lalecys@hotmail.com', 'Chasseur', '', 14, 3, 0),
(6, 'geoffreysteines2@hotmail.com', 'Kiddo', '', 7, 1, 0),
(7, 'canasucre_tm@hotmail.com', 'Jaminben', '', 0, 0, 0);

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Contenu de la table `journee`
--


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
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Contenu de la table `match`
--


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


-- --------------------------------------------------------

--
-- Structure de la table `stat`
--

DROP TABLE IF EXISTS `stat`;
CREATE TABLE `stat` (
  `idjoueur` int(11) NOT NULL,
  `idequipe` int(11) NOT NULL,
  `victoires` int(11) NOT NULL,
  `defaites` int(11) NOT NULL,
  `nuls` int(11) NOT NULL,
  PRIMARY KEY (`idjoueur`,`idequipe`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `stat`
--

