<?php

/*
Gestion de la table prono

*/

function prono_exists($idmatch, $idjoueur) {
	$sql = "SELECT idjoueur
			FROM prono
			WHERE idmatch = '$idmatch'
			AND idjoueur = '$idjoueur';";
	
	return mysql_num_rows(sql_query($sql));
}

function prono_record($idmatch, $idjoueur, $score) {
	$sql = "INSERT INTO prono(idmatch, idjoueur, score)
			VALUES('$idmatch', '$idjoueur', '$score');";
	
	return sql_query($sql);
}

function prono_update($idmatch, $idjoueur, $score) {
	$sql = "UPDATE prono
			SET score = '$score'
			WHERE idmatch = '$idmatch'
			AND idjoueur = '$idjoueur';";
	
	return sql_query($sql);
}

function prono_get_score($idmatch, $idjoueur) {
	$sql = "SELECT score
			FROM prono
			WHERE idmatch = '$idmatch'
			AND idjoueur = '$idjoueur';";
	
	$score = mysql_fetch_row(sql_query($sql));
	return $score[0];
}

