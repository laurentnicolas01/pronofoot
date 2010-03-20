-- Affiche une ligne avec les résultats du sondage "idparam" sur une ligne
DELIMITER //
DROP PROCEDURE IF EXISTS get_sondage_reponses//
CREATE PROCEDURE get_sondage_reponses(idparam VARCHAR(32))
BEGIN
	SELECT COUNT(s.idsondage) total_rep, COUNT(so.idjoueur) oui, COUNT(son.idjoueur) non
	FROM sondage s
	LEFT JOIN sondage so ON so.reponse = 'oui'
	LEFT JOIN sondage son ON son.reponse = 'non'
	WHERE s.idsondage = idparam
	LIMIT 1;
END//
DELIMITER ;

-- Recalcul et met à jour tous les "nbmatchs" des joueurs
DELIMITER //
DROP PROCEDURE IF EXISTS update_nbmatchs//
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

-- Valide une demande de compte (passage de la table demande à joueur)
DELIMITER //
DROP PROCEDURE IF EXISTS validate_demande//
CREATE PROCEDURE validate_demande(param_iddemande INTEGER)
BEGIN
	INSERT INTO `joueur`(email,pseudo,pass,idgroups)
	(SELECT email, pseudo, pass, idgroups
	FROM `demande`
	WHERE id = param_iddemande
	AND declined = 0
	AND validated = 0
	LIMIT 1);
	
	UPDATE `demande`
	SET `validated` = 1
	WHERE id = param_iddemande;
END//
DELIMITER ;

-- Trigger score_match : se déclenche quand le score d'un match est inséré pour mettre à jour les points des joueurs
DELIMITER //
DROP TRIGGER IF EXISTS score_match//
CREATE TRIGGER score_match
AFTER UPDATE ON `match`
FOR EACH ROW
BEGIN
	IF NEW.score <> '' THEN
		UPDATE joueur j
		SET nbmatchs = nbmatchs + 1,
			points = points + (SELECT prono_result(NEW.score, p.score)
							   FROM prono p
							   WHERE p.idmatch = NEW.id
							   AND p.idjoueur = j.id);
	END IF;
END//
DELIMITER ;

-- Fonction prono_result : calcule le nombre de points obtenu pour un prono
DELIMITER //
DROP FUNCTION IF EXISTS prono_result//
CREATE FUNCTION prono_result(scorem CHAR(3), scorej CHAR(3))
RETURNS INTEGER
DETERMINISTIC
BEGIN
	-- Variables locales
	DECLARE sml, smr, sjl, sjr INTEGER;
	
	-- Calcul du nombre de points obtenu avec les deux scores
	IF scorem = '' OR scorej = '' THEN
		RETURN 0;
	END IF;
	
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


-- Fonction journee_result : calcule le nombre de points obtenu par un joueur pour une journee
DELIMITER //
DROP FUNCTION IF EXISTS journee_result//
CREATE FUNCTION journee_result(param_idjoueur INTEGER, param_idjournee INTEGER)
RETURNS INTEGER
DETERMINISTIC
BEGIN
	-- Variables locales et curseur (contenant les points gagnés pour chaque match)
	DECLARE points, temp, done INTEGER DEFAULT 0;
	DECLARE mycurs CURSOR FOR   SELECT prono_result(m.score, p.score)
								FROM `match` m
							
								LEFT JOIN `prono` p
								ON p.idjoueur = param_idjoueur
								AND p.idmatch = m.id
								
								WHERE m.score <> ''
								AND m.idjournee =  param_idjournee;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;
	
	-- Calcul du nombre de points pour la journee en cours
	OPEN mycurs;
	
	REPEAT
		FETCH mycurs INTO temp;
		IF NOT done THEN
			SET points = points + temp;
		END IF;
	UNTIL done END REPEAT;
	
	CLOSE mycurs;
	
	RETURN points;
END//
DELIMITER ;


---------------
-- OTHER
---------------		
-- Récupérer les pronos de la journée précédente
SELECT j.pseudo, m.equipe1, m.equipe2, p.score
FROM `prono` p, `joueur` j, `match` m
WHERE p.idjoueur = j.id
AND p.idmatch = m.id
AND m.idjournee =  (SELECT id
					FROM `journee`
					WHERE `terminated` = 1
					ORDER BY `date` DESC
					LIMIT 1)
ORDER BY j.pseudo, m.id;


-- Récupérer les pronos de la journée en cours
SELECT j.pseudo, m.equipe1, m.equipe2, p.score
FROM `prono` p, `joueur` j, `match` m
WHERE p.idjoueur = j.id
AND p.idmatch = m.id
AND m.idjournee =  (SELECT id
					FROM `journee`
					WHERE `terminated` = 0
					ORDER BY `date` ASC
					LIMIT 1)
ORDER BY j.pseudo, m.id;
