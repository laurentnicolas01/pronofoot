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

function prono_get_by_journee($idjournee) {
	$sql = "SELECT p.score, j.pseudo, i.numero, m.equipe1, m.equipe2
			FROM prono AS p, `match` AS m, joueur AS j, journee AS i
			WHERE m.idjournee = '$idjournee'
			AND i.id = '$idjournee'
			AND p.idmatch = m.id
			AND p.idjoueur = j.id
			ORDER BY j.pseudo, m.id;";
	
	return sql_query($sql);
}

function prono_calculate_result($score_j, $score_m) {
	$temp = array_merge(explode('-',$score_j),explode('-',$score_m));
	$j = array('left' => $temp[0], 'right' => $temp[1]);
	$m = array('left' => $temp[2], 'right' => $temp[3]);
	
	if(true) {
		return true;
	}
}

