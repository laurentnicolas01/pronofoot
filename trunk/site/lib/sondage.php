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
 * Pour un sondage, renvoie une chaine avec la liste des réponses possible et le nombre de choix effectué pour chacune
 * @param idsondage : l'id du sondage dont on veut les résultats
 * @param set : (facultatif) un tableau avec les réponses possibles pour le sondage
 */
function sondage_get_resultstring($idsondage, $set = array()) {
	if(!count($set)) {
		$where = $idsondage ? "WHERE id = $idsondage" : 'WHERE id = (SELECT MAX(id) FROM `sondage`)';
		$sql = "SELECT reponse_set
				FROM `sondage`
				$where;";
	
		$result = sql_query($sql);
		if(!mysql_num_rows($result)) return '';
	
		$set = mysql_fetch_row($result);
		$set = explode(',', $set[0]);
	}
	
	$nbrep = 0;
	$poll_res = '<table>';
	foreach($set as $reponse) {
		$nb = sondage_get_nbrep($idsondage, $reponse);
		$poll_res .= '<tr><td>'.ucfirst($reponse).'</td><td>&nbsp;&nbsp;&nbsp;&nbsp;'.$nb.'</td></tr>';
		$nbrep += $nb;
	}
	$poll_res .= '<tr><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td><strong>Total</strong></td><td>&nbsp;&nbsp;&nbsp;&nbsp;'.$nbrep.'</td></tr></table>';
	
	return $poll_res;
}

/**
 * Pour un sondage et une reponse (en string), renvoie le nombre de réponses données
 */
function sondage_get_nbrep($idsondage, $reponse) {
	$sql = "SELECT COUNT(idjoueur)
			FROM reponse
			WHERE idsondage = $idsondage
			AND reponse = '$reponse'
			LIMIT 1;";
	
	$result = mysql_fetch_row(sql_query($sql));
	return $result[0];
}
