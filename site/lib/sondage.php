<?php

/*******************************************************
/* Gestion des sondages (tables sondage et reponse)
/*******************************************************

/**
 * Récupère les infos utiles à la génération d'un sondage
 */
function sondage_get_by_id($idsondage) {
	$var = $idsondage ? "WHERE idsondage = '$idsondage'" : 'ORDER BY date DESC';
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
function sondage_rec_rep($idsondage, $idjoueur, $rep, $autre_rep = NULL) {
	$date = time();
	$sql = "INSERT INTO `reponse`(idsondage, idjoueur, reponse, autre_reponse, date)
			VALUES('$idsondage', $idjoueur, '$rep', '$autre_rep', $date);";
			
	return sql_query($sql);
}
