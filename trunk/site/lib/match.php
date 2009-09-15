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

function match_set_score($id, $score) {
	$sql = "UPDATE `match`
			SET score = '$score'
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

function match_get_allnext() {
	$current_date = time();
	$sql = "SELECT m.id, m.equipe1, m.equipe2, j.numero
			FROM `match` as m, journee as j
			WHERE m.idjournee = j.id
			AND j.date > $current_date
			ORDER BY j.numero, m.id;";
	
	return sql_query($sql);
}

