<?php

require_once('constants.php');

/*
Gestion de la table groupe

*/

function groupe_get_name($id) {
	$data = mysql_fetch_assoc(sql_query("SELECT nom FROM groupe WHERE id = $id;"));
	return $data['nom'];
}

