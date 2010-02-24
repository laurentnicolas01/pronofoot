<?php


/**
 * Récupère la réponse d'un joueur à un sondage
 * Retourne NULL si le joueur n'a pas répondu
 */
function sondage_reponse_joueur($idsondage, $idj) {
	$sql = "SELECT reponse
			FROM `sondage`
			WHERE idsondage = '$idsondage'
			AND idjoueur = $idj
			LIMIT 1;";
			
	$result = sql_query($sql);
	$rep = mysql_num_rows($result) ? mysql_fetch_row($result) : array('');
	return $rep[0];
}

/**
 * Enregistre la réponse d'un joueur pour un sondage
 * Retourne True si l'enregistrement s'est bien passé, False sinon
 */
function sondage_rec_rep($idsondage, $idj, $rep, $autre_rep = NULL) {
	$date = time();
	$sql = "INSERT INTO `sondage`(idsondage, idjoueur, reponse, autre_reponse, date)
			VALUES('$idsondage', $idj, '$rep', '$autre_rep', $date);";
			
	return sql_query($sql);
}