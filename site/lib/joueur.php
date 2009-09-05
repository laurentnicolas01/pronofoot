<?php

/*
Gestion de la table joueur

*/

function joueur_get_classement($groupe = 0) {
	$sql = 'SELECT *
			FROM joueur
			';
			
	if($groupe) $sql .= "WHERE idgroups LIKE '%$groupe%'\n";
			
	$sql .= 'ORDER BY points DESC, pseudo ASC;';
	
	return sql_query($sql);
}

function joueur_point_match($prono, $score) {

}

function joueur_exists($mail) {
	$sql = "SELECT id
			FROM joueur
			WHERE email = '$mail';";
	
	return mysql_num_rows(sql_query($sql));
}

function joueur_add($mail, $pseudo, $pass) {
	$sql = "INSERT INTO joueur(email, pseudo, pass)
			VALUES('$mail', '$pseudo', '$pass');";
	
	return sql_query($sql);
}

