<?php

/*
Gestion de la table demande

*/

function demande_get($id = 0) {
	$end_req = $id ? 'WHERE id = '.$id.' LIMIT 1' : 'ORDER BY date DESC';
	
	$sql = "SELECT d.id, d.email, d.pseudo, g.nom groupe, d.autre_groupe, d.date, d.validated, d.declined
			FROM demande d
			INNER JOIN groupe g
			ON g.id = idgroups
			$end_req;";
	
	return sql_query($sql);
}

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

function demande_validate($idd) {
	return sql_query("CALL validate_demande($idd);");
}

function demande_decline($idd) {
	$sql = "UPDATE demande
			SET `declined` = 1
			WHERE id = $idd
			AND `declined` = 0
			AND `validated` = 0
			LIMIT 1;";
			
	return sql_query($sql);
}

function demande_get_mail($idd) {
	$sql = "SELECT email
			FROM demande
			WHERE id = $idd
			LIMIT 1;";
	
	$mail = mysql_fetch_row(sql_query($sql));
	return $mail[0];
}
