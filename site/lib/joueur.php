<?php
require_once('constants.php');

/*
Gestion de la table joueur

*/

function joueur_update_points($id, $value) {
	$sql = "UPDATE joueur
			SET points = points + $value
			WHERE id = $id;";
	
	return sql_query($sql);
}

function joueur_update_nbmatchs() {
	return sql_query('CALL update_nbmatchs();');
}

/**
 * Renvoie un set de <joueur;points> pour une journée donnée
 * @param idjournee: l'id de la journée dont on veut le set de results
 * Ne renvoie le résultat que pour les joueurs ayant au moins un prono pour la journée
 */
function joueur_get_resultset($idjournee) {
	$sql = "SELECT j.pseudo, journee_result(j.id, $idjournee) points
			FROM joueur j
			WHERE EXISTS (
				SELECT p.idjoueur
				FROM prono p
				INNER JOIN `match` m
				ON p.idmatch = m.id
				AND m.idjournee = $idjournee
				WHERE p.idjoueur = j.id
			)
			ORDER BY pseudo;";
	
	return sql_query($sql);
}

/**
 * Renvoie le nombre de points obtenus par un joueur pour une journée
 * @param idjoueur: l'id du joueur sont on veut le score
 * @param idjournee: l'id de la journée dont on veut le resultat
 */
function joueur_get_result($idjoueur, $idjournee) {
	$result = mysql_fetch_row(sql_query("SELECT journee_result($idjoueur, $idjournee);"));
	return $result[0];
}

function joueur_get_classement($groupe = 0, $sort, $is_asc) {
	$order = $is_asc ? 'ASC' : 'DESC';

	$sql = 'SELECT ROUND(points/nbmatchs, 2) AS avg, pseudo, points, nbmatchs
			FROM joueur
			WHERE nbmatchs <> 0
			';
			
	if($groupe) $sql .= "AND idgroups LIKE '%$groupe%'\n";
			
	// $sort doit être égal à 'points' ou 'avg'
	if($sort == 'avg') $sort = 'points/nbmatchs';
	$sql .= "ORDER BY $sort $order, pseudo ASC;";
	
	return sql_query($sql);
}

function joueur_get_stringscore($pseudo, $nbpoints) {
	return $pseudo.' +'.$nbpoints.' '.plural('point', $nbpoints);
}

function joueur_get($exp) {
	$sql = "SELECT *
			FROM joueur\n";
	
	$sql .= $exp == 'all' ? ';' : 'WHERE id = '.$exp.' LIMIT 1;';
	
	return sql_query($sql);
}

function joueur_get_pseudo($id) {
	$id = intval($id);
	$sql = "SELECT pseudo
			FROM joueur
			WHERE id = $id
			LIMIT 1;";
	
	$data = mysql_fetch_assoc(sql_query($sql));
	return $data['pseudo'];
}

function joueur_get_emails() {
	// Eventuellement rajouter un filtre sur les groupes
	$sql = 'SELECT email
			FROM joueur;';
			
	return sql_query($sql);
}

function joueur_get_id($email) {
	$email = mysql_real_escape_string($email);
	$sql = "SELECT id
			FROM joueur
			WHERE email = '$email'
			LIMIT 1;";
	
	$result = mysql_fetch_row(sql_query($sql));
	return $result[0];
}

function joueur_wants_reminder($id) {
	$sql = "SELECT reminder
			FROM joueur
			WHERE id = $id
			AND reminder = 1;";
			
	return mysql_num_rows(sql_query($sql));
}

function joueur_update_reminder($id, $wants_reminder) {
	$reminder = $wants_reminder ? 1 : 0;
	$sql = "UPDATE joueur
			SET reminder = $reminder
			WHERE id=$id;";
			
	return sql_query($sql);
}

function joueur_exists($email) {
	$email = mysql_real_escape_string($email);
	$sql = "SELECT id
			FROM joueur
			WHERE email = '$email'
			LIMIT 1;";
	
	return mysql_num_rows(sql_query($sql));
}

function joueur_pseudo_exists($pseudo) {
	$pseudo = mysql_real_escape_string($pseudo);
	$sql = "SELECT id
			FROM joueur
			WHERE pseudo = '$pseudo'
			LIMIT 1;";
	
	return mysql_num_rows(sql_query($sql));
}

function joueur_id_exists($id) {
	$id = intval($id);
	$sql = "SELECT id
			FROM joueur
			WHERE id = $id
			LIMIT 1;";
	
	return mysql_num_rows(sql_query($sql));
}

function joueur_add($mail, $pseudo, $pass, $groupes) {
	$pseudo = mysql_real_escape_string($pseudo);
	$sql = "INSERT INTO joueur(email, pseudo, pass, idgroups)
			VALUES('$mail', '$pseudo', '$pass', '$groupes');";
	
	return sql_query($sql);
}

function joueur_delete($id) {
	$id = intval($id);
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

/*********************************/
/* Gestion des membres 'online'
/*********************************/

function joueur_refresh($id) {
	$date = time();
	$sql = "UPDATE joueur
			SET online = 1,
				last_connection = $date
			WHERE id = $id
			LIMIT 1;";
			
	return sql_query($sql);
}

function joueur_set_offline($id) {
	$sql = "UPDATE joueur
			SET online = 0,
				last_connection = 0
			WHERE id = $id
			LIMIT 1;";
			
	return sql_query($sql);
}

function joueur_timeout() {
	$date = time();
	$timeout = TIMEOUT;
	$sql = "UPDATE joueur
			SET online = 0,
				last_connection = 0
			WHERE last_connection < $date-($timeout*60);";
			
	return sql_query($sql);
}

function joueur_get_nbconnect() {
	$sql = "SELECT COUNT(id) nbconnect
			FROM joueur
			WHERE online = 1;";
			
	$result = mysql_fetch_row(sql_query($sql));
	return $result[0];	
}

function joueur_get_listconnect() {
	$sql = "SELECT pseudo
			FROM joueur
			WHERE online = 1
			AND last_connection <> 0
			ORDER BY pseudo;";
	
	return sql_query($sql);
}

function joueur_print_nbco($nb) {
	return $nb.' '.plural('membre', $nb);
}

