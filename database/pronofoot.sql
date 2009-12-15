-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Mar 15 Décembre 2009 à 00:56
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
-- Structure de la table `groupe`
--

DROP TABLE IF EXISTS `groupe`;
CREATE TABLE `groupe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

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
  `nbmatchs` int(11) NOT NULL,
  `idgroups` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=16 ;

-- --------------------------------------------------------

--
-- Structure de la table `journee`
--

DROP TABLE IF EXISTS `journee`;
CREATE TABLE `journee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` int(11) NOT NULL,
  `numero` int(11) NOT NULL,
  `terminated` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=18 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=70 ;

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

DROP TABLE IF EXISTS `message`;
CREATE TABLE `message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` int(11) NOT NULL,
  `texte` text COLLATE utf8_unicode_ci NOT NULL,
  `idjoueur` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=133 ;

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

DELIMITER $$
--
-- Procédures
--
DROP PROCEDURE IF EXISTS `update_nbmatchs`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `update_nbmatchs`()
BEGIN
		UPDATE joueur
	SET nbmatchs = 0;

		UPDATE joueur
	SET nbmatchs = 19
	WHERE id = 1;

		UPDATE joueur
	SET nbmatchs = 4
	WHERE id = 6;

		UPDATE joueur
	SET nbmatchs = 24
	WHERE id BETWEEN 2 AND 5;

		UPDATE joueur j
	SET nbmatchs =  nbmatchs + (SELECT COUNT(*)
								FROM prono p, `match` m
								WHERE p.idjoueur = j.id
								AND p.idmatch = m.id
								AND m.score <> '');
END$$

DELIMITER ;
