<?php

/*
Gestion de la table joueur

*/

function joueur_update_points($id, $value) {
	$sql = "UPDATE joueur
			SET points = points + $value
			WHERE id = $id;";
	
	return sql_query($sql);
}

function joueur_update_nbjournee($id) {
	$sql = "UPDATE joueur
			SET journees = journees + 1
			WHERE id = $id;";
	
	return sql_query($sql);
}

function joueur_get_classement($groupe = 0) {
	$sql = 'SELECT *
			FROM joueur
			';
			
	if($groupe) $sql .= "WHERE idgroups LIKE '%$groupe%'\n";
			
	$sql .= 'ORDER BY points DESC, pseudo ASC;';
	
	return sql_query($sql);
}

function joueur_get($exp) {
	$sql = "SELECT *
			FROM joueur\n";
	
	$sql .= $exp == 'all' ? ';' : 'WHERE id = '.$exp;
	
	return sql_query($sql);
}

function joueur_exists($mail) {
	$sql = "SELECT id
			FROM joueur
			WHERE email = '$mail';";
	
	return mysql_num_rows(sql_query($sql));
}

function joueur_add($mail, $pseudo, $pass, $groupes) {
	$sql = "INSERT INTO joueur(email, pseudo, pass, idgroups)
			VALUES('$mail', '$pseudo', '$pass', '$groupes');";
	
	return sql_query($sql);
}

function joueur_delete($id) {
	$sql = "DELETE FROM joueur
			WHERE id = $id;";
	
	return sql_query($sql);
}

function joueur_update_pass($id, $pass) {
	$sql = "UPDATE joueur
			SET pass = '$pass'
			WHERE id = $id;";
	
	return sql_query($sql);
}

