<?php

/*
Gestion de la table journee

*/

function journee_get_active() {
	$current_date = time();
	$sql = "SELECT *
			FROM journee
			WHERE date > $current_date
			ORDER BY date;";
	return sql_query($sql);
}

function journee_add($numero, $timestamp) {
	$sql = "INSERT INTO journee(numero, date)
			VALUES($numero, $timestamp);";
	
	return sql_query($sql);
}

function journee_exists($numero, $timestamp) {
	$sql = "SELECT id
			FROM journee
			WHERE numero = $numero
			AND date = $timestamp;";
	
	return mysql_num_rows(sql_query($sql));
}

