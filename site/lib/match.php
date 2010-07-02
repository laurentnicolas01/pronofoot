<?php

/*
Gestion de la table `match` (attention confusion avec le mot-clé sql "match")

*/

require_once('prono.php');

function match_exists($idjournee, $team1, $team2) {
	$sql = "SELECT id
			FROM `match`
			WHERE idjournee = '$idjournee'
			AND equipe1 = '$team1'
			AND equipe2 = '$team2';";
	
	return mysql_num_rows(sql_query($sql));
}

function match_id_exists($id) {
	$id = intval($id);
	$sql = "SELECT id
			FROM `match`
			WHERE id = $id;";
	
	return mysql_num_rows(sql_query($sql));
}

/**
 * Fonction coeur
 * Met à jour le score d'un match ET aussi les <points;nbmatchs> des joueurs ayant pronostiqué sur ce match
 */
function match_set_score($id, $score) {
	$sql = "UPDATE `match`
			SET score = '$score'
			WHERE id = $id;";
			
	$lsq = "UPDATE joueur j
			SET nbmatchs = nbmatchs + 1,
				points = points + (SELECT prono_result('$score', p.score)
								   FROM prono p
								   WHERE p.idmatch = $id
								   AND p.idjoueur = j.id)
			WHERE EXISTS (SELECT p.score
					      FROM prono p
					      WHERE p.idmatch = $id
					      AND p.idjoueur = j.id);";
			
	return sql_query($sql) && sql_query($lsq);
}

/**
 * Change l'idjournee d'un match
 */
function match_update_journee($id, $idjour) {
	$id = intval($id);
	$idjour = intval($idjour);
	$sql = "UPDATE `match`
			SET idjournee = $idjour
			WHERE id = $id;";
			
	return sql_query($sql);
}

/**
 * Change les equipes d'un match
 */
function match_update_teams($id, $team1, $team2) {
	$id = intval($id);
	$sql = "UPDATE `match`
			SET equipe1 = '$team1', equipe2 = '$team2'
			WHERE id = $id;";
			
	return sql_query($sql);
}

function match_add($idjournee, $team1, $team2) {
	$sql = "INSERT INTO `match`(equipe1, equipe2, idjournee)
			VALUES('$team1', '$team2', '$idjournee');";
	
	return sql_query($sql);
}

function match_delete($id) {
	$sql = "DELETE FROM `match`
			WHERE id = $id;";
	
	return sql_query($sql) && prono_delete_by_idmatch($id);
}

function match_get_by_journee($idjournee) {
	$sql = "SELECT *
			FROM `match`
			WHERE idjournee = '$idjournee';";
	
	return sql_query($sql);
}

function match_get_scores($idjournee) {
	$sql = "SELECT score
			FROM `match`
			WHERE idjournee = $idjournee
			ORDER BY id;";
	
	return sql_query($sql);
}

function match_get_journee($id) {
	$sql = "SELECT idjournee
			FROM `match`
			WHERE id = $id;";
	
	$idj = mysql_fetch_row(sql_query($sql));
	return $idj[0];
}

function match_get_allnext() {
	$current_date = time();
	$sql = "SELECT m.id, m.equipe1, m.equipe2, j.numero
			FROM `match` as m, journee as j
			WHERE m.idjournee = j.id
			AND j.date > $current_date
			ORDER BY j.numero, m.id;";
	
	return sql_query($sql);
}

