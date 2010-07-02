------------------------------------
-- Nouvelle gestion groupe
------------------------------------

-- Structure de la table `adhesion` pour prendre en compte la nouvelle gestion des groupes
DROP TABLE IF EXISTS `adhesion`;
CREATE TABLE `adhesion` (
  `idjoueur` int(11) NOT NULL,
  `idgroupe` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  PRIMARY KEY (`idjoueur`,`idgroupe`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Modification de la table JOUEUR pour prendre en compte la nouvelle gestion des groupes (à passer APRES execution du script PHP de bascule)
ALTER TABLE `joueur` DROP `idgroups`
