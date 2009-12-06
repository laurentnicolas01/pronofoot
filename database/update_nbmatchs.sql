UPDATE joueur
SET nbmatchs = 0;

UPDATE joueur
SET nbmatchs = 4
WHERE id = 6;

UPDATE joueur
SET nbmatchs = 19
WHERE id BETWEEN 1 AND 5;

UPDATE joueur j
SET nbmatchs =  nbmatchs + (SELECT COUNT(*)
							FROM prono p
							WHERE p.idjoueur = j.id);