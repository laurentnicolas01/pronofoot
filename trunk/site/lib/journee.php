<?php

/*
Gestion de la table journee

*/

require_once('match.php');
require_once('prono.php');

function journee_get_next($all = false) {
	$current_date = time();
	$sql = "SELECT *
			FROM journee
			WHERE date > $current_date
			ORDER BY date
			";
			if(!$all) $sql .= 'LIMIT 1;';
	return sql_query($sql);
}

function journee_get_current() {
	$sql = 'SELECT j.id, j.numero, j.date
			FROM journee j, `match` m
			WHERE m.idjournee = j.id
			AND m.score = ""
			ORDER BY date
			LIMIT 1;';
	return sql_query($sql);
}

function journee_get_last_unterminated() {
	$current_date = time();
	$sql = "SELECT j.id AS idjournee, j.date, j.numero, m.id AS idmatch, m.score AS score_match, p.score AS score_joueur, p.idjoueur, jr.pseudo AS pseudo
			FROM journee j, `match` m, prono p, joueur jr
			WHERE j.date < $current_date
			AND m.idjournee = j.id
			AND p.idmatch = m.id
			AND p.idjoueur = jr.id
			AND j.terminated = 0
			AND m.score != ''
			ORDER BY date, idjoueur;";
	return sql_query($sql);
}

function journee_get_waiting_results($idjournee = false) {
	$current_date = time();
	$sql = "SELECT j.id, j.date, j.numero, m.id AS idmatch, m.equipe1, m.equipe2, m.score AS score_match
			FROM journee AS j, `match` AS m
			WHERE j.date < $current_date
			AND m.idjournee = j.id
			AND m.score = ''";
			
	if($idjournee)
	$sql .= "
			AND j.id = $idjournee";
			
	$sql .=	"
			GROUP BY idmatch
			ORDER BY j.numero;";
			
	return sql_query($sql);
}

function journee_get_all_terminated($is_asc) {
	$order = $is_asc ? 'ASC' : 'DESC';
	$sql = 'SELECT id, numero
			FROM journee
			WHERE `terminated` = 1
			ORDER BY numero '.$order.', date '.$order.';';
	return sql_query($sql);
}

function journee_get_last_terminated() {
	$sql = 'SELECT id, numero
			FROM journee
			WHERE `terminated` = 1
			ORDER BY numero DESC, date DESC
			LIMIT 1;';
	return mysql_fetch_assoc(sql_query($sql));
}

function journee_get_nbunterminate() {
	$current_date = time();
	return sql_query("SELECT id FROM journee WHERE date < $current_date AND `terminated` = 0;");
}

function journee_add($numero, $timestamp) {
	$sql = "INSERT INTO journee(numero, date)
			VALUES($numero, $timestamp);";
	
	return sql_query($sql);
}

function journee_delete($id) {	
	// Récupération de l'id des matchs à supprimer pour supprimer les pronos liés
	$matchs = match_get_by_journee($id);
	
	// Suppression des pronos
	while($match = mysql_fetch_assoc($matchs))
		prono_delete_by_idmatch($match['id']);
	
	// Récupération de l'id des matchs à supprimer
	$matchs = match_get_by_journee($id);
	
	// Suppression des matchs
	while($match = mysql_fetch_assoc($matchs))
		match_delete($match['id']);
			
	// Suppression de la journée
	$sql = "DELETE FROM journee
			WHERE id = $id;";
	
	return sql_query($sql);
}

function journee_exists($id = '', $numero = 0, $timestamp = 0) {
	$sql = "SELECT id
			FROM journee
			";
			if($id != '')
				$sql .= "WHERE id = $id";
			else
				$sql .= "WHERE numero = $numero AND date = $timestamp;";
	
	return mysql_num_rows(sql_query($sql));
}

function journee_has_match($id) {
	$sql = "SELECT id
			FROM `match`
			WHERE idjournee = '$id'";
	
	return mysql_num_rows(sql_query($sql));
}

/**
 * Similaire à la précédente mais nécessaire pour éviter de retoucher du code qui marche
 */
function journee_remain_match($id) {
	$sql = "SELECT id
			FROM `match`
			WHERE idjournee = '$id'
			AND score = ''
			LIMIT 1";
			
	return mysql_num_rows(sql_query($sql));
}

function journee_get_by_id($id) {
	$sql = "SELECT id, numero, date
			FROM journee
			WHERE id = '$id'";
	
	return mysql_fetch_assoc(sql_query($sql));
}

function journee_terminate($id) {	
	$sql = "UPDATE journee
			SET `terminated` = 1
			WHERE id = $id";
	
	return sql_query($sql);
}

function journee_locked($id) {
	$sql = "SELECT date AS timestamp
			FROM journee
			WHERE id = $id";
	
	$date = mysql_fetch_assoc(sql_query($sql));
	return $date['timestamp'] < time();
}

function journee_update_date($id,$timestamp) {
	$sql = "UPDATE journee
			SET date = $timestamp
			WHERE id = $id
			LIMIT 1;";
	
	return sql_query($sql);
}

