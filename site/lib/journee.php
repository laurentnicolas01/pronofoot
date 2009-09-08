<?php

/*
Gestion de la table journee

*/

function journee_get_next($all = false) {
	$current_date = time();
	$sql = "SELECT *
			FROM journee
			WHERE date > $current_date
			";
			if(!$all) $sql .= 'ORDER BY date LIMIT 1;';
	return sql_query($sql);
}

function journee_add($numero, $timestamp) {
	$sql = "INSERT INTO journee(numero, date)
			VALUES($numero, $timestamp);";
	
	return sql_query($sql);
}

function journee_exists($id = '', $numero = 0, $timestamp = 0) {
	$sql = "SELECT id
			FROM journee
			";
			if($id != '')
				$sql .= "WHERE id = $id";
			else
				$sql .= "WHERE numero = $numero AND date = $timestamp;";
	
	return mysql_num_rows(sql_query($sql));
}

function journee_has_match($id) {
	$sql = "SELECT id
			FROM `match`
			WHERE idjournee = '$id'";
	
	return mysql_num_rows(sql_query($sql));
}

function journee_get_by_id($id) {
	$sql = "SELECT *
			FROM journee
			WHERE id = '$id'";
	
	return mysql_fetch_assoc(sql_query($sql));
}


