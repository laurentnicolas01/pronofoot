<?php

require_once('constants.php');

/*
Gestion de la table groupe

*/

function groupe_get_name($id) {
	$data = mysql_fetch_assoc(sql_query("SELECT nom FROM groupe WHERE id = $id LIMIT 1;"));
	return $data['nom'];
}

function groupe_get_list($group_list) {
	return sql_query("SELECT id, nom FROM groupe WHERE id IN ($group_list);");
}

function groupe_get_all() {
	return sql_query("SELECT id, nom FROM groupe;");
}

function groupe_exists($nom) {
	$sql = "SELECT id
			FROM groupe
			WHERE nom = '$nom'
			LIMIT 1;";
	
	return mysql_num_rows(sql_query($sql));
}

function groupe_id_exists($id) {
	$sql = "SELECT id
			FROM groupe
			WHERE id = $id
			LIMIT 1;";
	
	return mysql_num_rows(sql_query($sql));
}

function groupe_add($nom) {
	$sql = "INSERT INTO groupe(nom)
			VALUES('$nom');";
	
	return sql_query($sql);
}

function groupe_delete($id) {
	$sql = "DELETE FROM groupe
			WHERE id = $id;";
	
	return sql_query($sql);
}

