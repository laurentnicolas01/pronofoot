-- Init
UPDATE joueur
SET nbmatchs = 0;

-- Arthur
UPDATE joueur
SET nbmatchs = 19
WHERE id = 1;

-- Geo
UPDATE joueur
SET nbmatchs = 4
WHERE id = 6;

-- EPF (sauf arthur)
UPDATE joueur
SET nbmatchs = 24
WHERE id BETWEEN 2 AND 5;

-- Everybody
UPDATE joueur j
SET nbmatchs =  nbmatchs + (SELECT COUNT(*)
							FROM prono p
							WHERE p.idjoueur = j.id);