DELIMITER //
DROP PROCEDURE IF EXISTS update_nbmatchs;
CREATE PROCEDURE update_nbmatchs()
BEGIN
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
								FROM prono p, `match` m
								WHERE p.idjoueur = j.id
								AND p.idmatch = m.id
								AND m.score <> '');
END//
DELIMITER ;

-- Trigger score_match : se déclenche quand le score d'un match est inséré pour mettre à jour les points des joueurs
DELIMITER //
DROP TRIGGER IF EXISTS score_match;
CREATE TRIGGER score_match
AFTER UPDATE ON `match`
FOR EACH ROW
BEGIN
	IF NEW.score <> '' THEN
		UPDATE joueur j
		SET points = points + (SELECT prono_result(NEW.score, p.score)
							   FROM prono p
							   WHERE p.idmatch = NEW.id
							   AND p.idjoueur = j.id);
	END IF;
	
	CALL update_nbmatchs();
END//
DELIMITER ;

-- Fonction prono_result : calcule le nombre de points obtenu pour un prono
DELIMITER //
DROP FUNCTION IF EXISTS prono_result;
CREATE FUNCTION prono_result(scorem CHAR(3), scorej CHAR(3))
RETURNS INTEGER
DETERMINISTIC
BEGIN
	-- Variables locales
	DECLARE	sml, smr, sjl, sjr INTEGER;
	
	-- Calcul du nombre de points obtenu avec les deux scores
	IF scorem = scorej THEN
		RETURN 3;
	ELSE
		-- Affectation des variables qui représentent une moitié de score
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
END//
DELIMITER ;

-- Test
SELECT  prono_result('3-2', '3-2'),
		prono_result('0-2', '3-5'),
		prono_result('2-2', '3-3'),
		prono_result('0-0', '0-1'),
		prono_result('1-2', '1-2'),
		prono_result('7-0', '1-0'),
		prono_result('1-2', '3-3');
		