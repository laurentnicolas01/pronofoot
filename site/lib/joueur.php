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

function joueur_update_nbmatchs($id, $nbmatchs) {
	$sql = "UPDATE joueur
			SET nbmatchs = nbmatchs + $nbmatchs
			WHERE id = $id;";
	
	return sql_query($sql);
}

function joueur_get_classement($groupe = 0, $sort, $is_asc) {
	$order = $is_asc ? 'ASC' : 'DESC';

	$sql = 'SELECT points/nbmatchs AS avg, pseudo, points, nbmatchs
			FROM joueur
			';
			
	if($groupe) $sql .= "WHERE idgroups LIKE '%$groupe%'\n";
			
	// $order doit être égal à 'points' ou 'avg'
	$sql .= "ORDER BY $sort $order, pseudo ASC;";
	
	return sql_query($sql);
}

function joueur_get($exp) {
	$sql = "SELECT *
			FROM joueur\n";
	
	$sql .= $exp == 'all' ? ';' : 'WHERE id = '.$exp.' LIMIT 1;';
	
	return sql_query($sql);
}

function joueur_get_pseudo($id) {
	$sql = "SELECT pseudo
			FROM joueur
			WHERE id = $id
			LIMIT 1;";
	
	$data = mysql_fetch_assoc(sql_query($sql));
	return $data['pseudo'];
}

function joueur_exists($mail) {
	$sql = "SELECT id
			FROM joueur
			WHERE email = '$mail'
			LIMIT 1;";
	
	return mysql_num_rows(sql_query($sql));
}

function joueur_id_exists($id) {
	$sql = "SELECT id
			FROM joueur
			WHERE id = $id
			LIMIT 1;";
	
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

function joueur_update_groupes($id, $groupes) {
	$sql = "UPDATE joueur
			SET idgroups = '$groupes'
			WHERE id = $id;";
	
	return sql_query($sql);
}

