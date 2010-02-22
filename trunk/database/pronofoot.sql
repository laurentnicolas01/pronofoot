-- phpMyAdmin SQL Dump
-- version OVH
-- http://www.phpmyadmin.net
--
-- Serveur: mysql5-4.perso
-- Généré le : Dim 21 Février 2010 à 02:10
-- Version du serveur: 5.0.90
-- Version de PHP: 5.2.6-1+lenny4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Base de données: `julienp_prono`
--

-- --------------------------------------------------------

--
-- Structure de la table `demande`
--

DROP TABLE IF EXISTS `demande`;
CREATE TABLE `demande` (
  `id` int(11) NOT NULL auto_increment,
  `email` varchar(64) collate utf8_unicode_ci NOT NULL,
  `pseudo` varchar(32) collate utf8_unicode_ci NOT NULL,
  `pass` char(40) collate utf8_unicode_ci NOT NULL,
  `idgroups` varchar(11) collate utf8_unicode_ci default NULL,
  `autre_groupe` varchar(32) collate utf8_unicode_ci default NULL,
  `date` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Structure de la table `groupe`
--

DROP TABLE IF EXISTS `groupe`;
CREATE TABLE `groupe` (
  `id` int(11) NOT NULL auto_increment,
  `nom` varchar(32) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Structure de la table `joueur`
--

DROP TABLE IF EXISTS `joueur`;
CREATE TABLE `joueur` (
  `id` int(11) NOT NULL auto_increment,
  `email` varchar(64) collate utf8_unicode_ci NOT NULL,
  `pseudo` varchar(32) collate utf8_unicode_ci NOT NULL,
  `pass` char(40) collate utf8_unicode_ci NOT NULL,
  `points` int(11) NOT NULL,
  `nbmatchs` int(11) NOT NULL,
  `reminder` tinyint(4) NOT NULL default '1',
  `idgroups` varchar(11) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

--
-- Structure de la table `journee`
--

DROP TABLE IF EXISTS `journee`;
CREATE TABLE `journee` (
  `id` int(11) NOT NULL auto_increment,
  `date` int(11) NOT NULL,
  `numero` int(11) NOT NULL,
  `terminated` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=25 ;

-- --------------------------------------------------------

--
-- Structure de la table `match`
--

DROP TABLE IF EXISTS `match`;
CREATE TABLE `match` (
  `id` int(11) NOT NULL auto_increment,
  `score` varchar(5) collate utf8_unicode_ci NOT NULL,
  `equipe1` varchar(32) collate utf8_unicode_ci NOT NULL,
  `equipe2` varchar(32) collate utf8_unicode_ci NOT NULL,
  `idjournee` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=102 ;

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

DROP TABLE IF EXISTS `message`;
CREATE TABLE `message` (
  `id` int(11) NOT NULL auto_increment,
  `date` int(11) NOT NULL,
  `texte` text collate utf8_unicode_ci NOT NULL,
  `idjoueur` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=279 ;

-- --------------------------------------------------------

--
-- Structure de la table `news`
--

DROP TABLE IF EXISTS `news`;
CREATE TABLE `news` (
  `id` int(11) NOT NULL auto_increment,
  `date` int(11) NOT NULL,
  `titre` varchar(128) collate utf8_unicode_ci NOT NULL,
  `contenu` text collate utf8_unicode_ci NOT NULL,
  `image` varchar(32) collate utf8_unicode_ci NOT NULL default 'football.jpg',
  `idjoueur` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Structure de la table `prono`
--

DROP TABLE IF EXISTS `prono`;
CREATE TABLE `prono` (
  `idmatch` int(11) NOT NULL,
  `idjoueur` int(11) NOT NULL,
  `score` varchar(5) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`idmatch`,`idjoueur`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DELIMITER $$
--
-- Procédures
--
CREATE DEFINER=`julienp_prono`@`%` PROCEDURE `update_nbmatchs`()
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

--
-- Fonctions
--
CREATE DEFINER=`julienp_prono`@`%` FUNCTION `prono_result`(scorem CHAR(3), scorej CHAR(3)) RETURNS int(11)
    DETERMINISTIC
BEGIN
		DECLARE	sml, smr, sjl, sjr INTEGER;
	
		IF scorem = scorej THEN
		RETURN 3;
	ELSE
				SELECT CAST(LEFT(scorem,1) AS UNSIGNED) INTO sml;
		SELECT CAST(RIGHT(scorem,1) AS UNSIGNED) INTO smr;
		SELECT CAST(LEFT(scorej,1) AS UNSIGNED) INTO sjl;
		SELECT CAST(RIGHT(scorej,1) AS UNSIGNED) INTO sjr;
		
		IF (sml < smr AND sjl < sjr) OR (sml > smr AND sjl > sjr) OR (sml = smr AND sjl = sjr) THEN
			RETURN 1;
		ELSE
			RETURN 0;
		END IF;
	END IF;
END$$

DELIMITER ;
