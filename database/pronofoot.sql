-- phpMyAdmin SQL Dump
-- version OVH
-- http://www.phpmyadmin.net
--
-- Serveur: mysql5-4.perso
-- Généré le : Jeu 04 Mars 2010 à 22:04
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
  `validated` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

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
  `points` int(11) NOT NULL default '0',
  `nbmatchs` int(11) NOT NULL default '0',
  `reminder` tinyint(4) NOT NULL default '1',
  `idgroups` varchar(11) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=19 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=27 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=111 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=310 ;

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
  `image` varchar(32) collate utf8_unicode_ci NOT NULL default 'bulle.png',
  `idjoueur` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

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

-- --------------------------------------------------------

--
-- Structure de la table `reponse`
--

DROP TABLE IF EXISTS `reponse`;
CREATE TABLE `reponse` (
  `idsondage` int(11) NOT NULL,
  `idjoueur` int(11) NOT NULL,
  `reponse` varchar(64) collate utf8_unicode_ci NOT NULL,
  `autre_reponse` varchar(64) collate utf8_unicode_ci default NULL,
  `date` int(11) NOT NULL,
  PRIMARY KEY  (`idsondage`,`idjoueur`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `sondage`
--

DROP TABLE IF EXISTS `sondage`;
CREATE TABLE `sondage` (
  `id` int(11) NOT NULL auto_increment,
  `nom` varchar(32) collate utf8_unicode_ci NOT NULL,
  `question` text collate utf8_unicode_ci NOT NULL,
  `reponse_set` varchar(128) collate utf8_unicode_ci NOT NULL,
  `date` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;
