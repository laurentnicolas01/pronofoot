<?php

/*******************************************************/
/* Gestion des sondages (tables sondage et reponse)
/*******************************************************/


/**
 * Récupère les infos utiles à la génération d'un sondage
 */
function sondage_get_by_id($idsondage) {
	$var = $idsondage ? "WHERE id = $idsondage" : 'ORDER BY date DESC';
	$sql = "SELECT id, question, reponse_set
			FROM `sondage`
			$var
			LIMIT 1;";
			
	return sql_query($sql);
}

/**
 * Récupère la réponse d'un joueur à un sondage
 * Retourne une chaine vide si le joueur n'a pas répondu
 */
function sondage_reponse_joueur($idsondage, $idjoueur) {
	$sql = "SELECT reponse
			FROM `reponse`
			WHERE idsondage = '$idsondage'
			AND idjoueur = $idjoueur
			LIMIT 1;";
			
	$result = sql_query($sql);
	$rep = mysql_num_rows($result) ? mysql_fetch_row($result) : array('');
	return $rep[0];
}

/**
 * Enregistre la réponse d'un joueur pour un sondage
 * Retourne True si l'enregistrement s'est bien passé, False sinon
 */
function sondage_rec_rep($idsondage, $idjoueur, $rep, $autre_rep = '') {
	$date = time();
	$autre_rep = mysql_real_escape_string($autre_rep);
	$sql = "INSERT INTO `reponse`(idsondage, idjoueur, reponse, autre_reponse, date)
			VALUES('$idsondage', $idjoueur, '$rep', '$autre_rep', $date);";
			
	return sql_query($sql);
}

/**
 * Pour un sondage, récupère une ligne avec le nombre de réponses pour chaque choix
 */
function sondage_get_numanswers($idsondage) {
	$where = $idsondage ? "WHERE id = $idsondage" : 'WHERE id = (SELECT MAX(id) FROM `sondage`)';
	$sql = "SELECT reponse_set
			FROM `sondage`
			$where;";
	$result = sql_query($sql);
	
	if(mysql_num_rows($result)) {
		$i = 1;
		$selects = '';
		$joins = '';
		$result = mysql_fetch_row($result);
		$reponse_set = explode(',', $result[0]);
		foreach($reponse_set as $rep) {
			$selects .= " COUNT(r$i.idjoueur) rep$i, ";
			$joins .= " LEFT JOIN reponse r$i ON r$i.reponse = '$rep' ";
			++$i;
		}
		$selects = substr($selects,0,strlen($selects)-2);
		$sql = "SELECT $selects
				FROM `sondage`
				$joins
				$where
				LIMIT 1;";
		
		return sql_query($sql);
	}
	
	return $result;
}
