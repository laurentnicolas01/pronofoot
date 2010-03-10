<?php

/*
Gestion de la table demande

*/

function demande_add($email, $pseudo, $pass, $idgroup, $new_groupe) {
	$date = time();
	$pseudo = mysql_real_escape_string($pseudo);
	$new_groupe = mysql_real_escape_string($new_groupe);
	$sql = "INSERT INTO demande(email, pseudo, pass, idgroups, autre_groupe, date)
			VALUES('$email', '$pseudo', '$pass', '$idgroup', '$new_groupe', $date)";
			
	return sql_query($sql);
}

function demande_exists($email) {
	$sql = "SELECT id
			FROM demande
			WHERE email = '$email'
			LIMIT 1;";
	
	return mysql_num_rows(sql_query($sql));
}

function demande_pseudo_exists($pseudo) {
	$pseudo = mysql_real_escape_string($pseudo);
	$sql = "SELECT id
			FROM demande
			WHERE pseudo = '$pseudo'
			LIMIT 1;";
	
	return mysql_num_rows(sql_query($sql));
}
