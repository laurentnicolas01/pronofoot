<?php

/*
Gestion de la table `match`

*/

function match_exists($idjournee, $team1, $team2) {
	$sql = "SELECT id
			FROM `match`
			WHERE idjournee = '$idjournee'
			AND equipe1 = '$team1'
			AND equipe2 = '$team2';";
	
	return mysql_num_rows(sql_query($sql));
}

function match_add($idjournee, $team1, $team2) {
	$sql = "INSERT INTO `match`(equipe1, equipe2, idjournee)
			VALUES('$team1', '$team2', '$idjournee');";
	
	return sql_query($sql);
}

function match_get_by_journee($idjournee) {
	$sql = "SELECT *
			FROM `match`
			WHERE idjournee = '$idjournee';";
	
	return sql_query($sql);
}

