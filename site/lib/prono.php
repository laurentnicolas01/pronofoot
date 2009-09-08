<?php

/*
Gestion de la table prono

*/

function prono_exists($idjoueur, $idmatch) {
	$sql = "SELECT score
			FROM prono
			WHERE idjoueur = '$idjoueur'
			AND idmatch = '$idmatch';";
	
	return mysql_num_rows(sql_query($sql));
}


