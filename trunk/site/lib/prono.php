<?php

/*
Gestion de la table prono

*/

function prono_exists($idmatch, $idjoueur) {
	$sql = "SELECT idjoueur
			FROM prono
			WHERE idmatch = $idmatch
			AND idjoueur = $idjoueur;";
	
	return mysql_num_rows(sql_query($sql));
}

function prono_record($idmatch, $idjoueur, $score) {
	$sql = "INSERT INTO prono(idmatch, idjoueur, score)
			VALUES($idmatch, $idjoueur, '$score');";
	
	return sql_query($sql);
}

function prono_update($idmatch, $idjoueur, $score) {
	$sql = "UPDATE prono
			SET score = '$score'
			WHERE idmatch = $idmatch
			AND idjoueur = $idjoueur;";
	
	return sql_query($sql);
}

function prono_get_score($idmatch, $idjoueur) {
	$sql = "SELECT score
			FROM prono
			WHERE idmatch = $idmatch
			AND idjoueur = $idjoueur;";
	
	$score = mysql_fetch_row(sql_query($sql));
	return $score[0];
}

function prono_get_by_journee($idjournee) {
	$sql = "SELECT p.score, j.id AS idjoueur, j.pseudo
					FROM prono AS p, `match` AS m, joueur AS j
					WHERE m.idjournee = '$idjournee'
					AND p.idmatch = m.id
					AND p.idjoueur = j.id
					ORDER BY j.pseudo, m.id;";

	/*
	$sql = "SELECT p.idmatch, p.score, j.id idjoueur, j.pseudo, journee_result(j.id,$idjournee)
			FROM prono p
			
			LEFT JOIN joueur j
			ON p.idjoueur = j.id
			
			WHERE p.idmatch IN (SELECT id FROM `match` WHERE idjournee = $idjournee)
			ORDER BY j.pseudo, p.idmatch;";*/
	
	return sql_query($sql);
}

function prono_delete_by_idmatch($idmatch) {
	$sql = "DELETE FROM prono
			WHERE idmatch = $idmatch;";
	
	return sql_query($sql);
}

