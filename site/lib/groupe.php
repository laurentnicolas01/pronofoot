<?php

require_once('constants.php');

/*
Gestion des tables 'groupe' et 'adhesion'

*/

function groupe_get_name($id) {
	$id = intval($id);
	$data = mysql_fetch_row(sql_query("SELECT nom FROM groupe WHERE id = $id LIMIT 1;"));
	return $data[0];
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
	$id = intval($id);
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
	$id = intval($id);
	$sql = "DELETE FROM groupe
			WHERE id = $id;";
	
	$lsq = "DELETE FROM adhesion
			WHERE idgroupe = $id;";
	
	return sql_query($sql) && sql_query($lsq);
}

function groupe_adhesion_exists($idg, $idj) {
	$idj = intval($idj);
	$idg = intval($idg);
	$sql = "SELECT idjoueur, idgroupe
			FROM adhesion
			WHERE idjoueur = $idj
			AND idgroupe = $idg
			LIMIT 1;";
			
	$result = sql_query($sql);
	return mysql_num_rows($result);
}

function groupe_add_joueur($idg, $idj) {
	$idj = intval($idj);
	$idg = intval($idg);
	$date = time();
	$sql = "INSERT INTO adhesion(idjoueur,idgroupe,date)
			VALUES($idj,$idg,$date);";
			
	return $idj != 0 && $idg != 0 ? sql_query($sql) : 0;
}

function groupe_remove_joueur($idg, $idj) {
	$idj = intval($idj);
	$idg = intval($idg);
	$sql = "DELETE
			FROM adhesion
			WHERE idjoueur = $idj
			AND idgroupe = $idg;";
			
	return $idj != 0 && $idg != 0 ? sql_query($sql) : 0;
}

/**
 * Permet d'obtenir une liste des groupe en fonction d'un joueur et d'un "mode"
 * @param idj: l'id du joueur concerné
 * @param adhesions: 'true' pour avoir les liste des groupes auxquels le joueur est lié, 'false' pour la liste de ceux auxuquels il n'est PAS affilé
 * @return recordset correspondant à une liste de noms de groupes determinée par les paramètres
 */
function groupe_get_by_idjoueur($idj, $adhesions) {
	$idj = intval($idj);
	if($adhesions)
		$sql = "SELECT g.id, g.nom
				FROM adhesion a
				
				INNER JOIN joueur j
				ON j.id = $idj
				AND j.id = a.idjoueur
				
				INNER JOIN groupe g
				ON g.id = a.idgroupe
				
				ORDER BY g.nom;";
	else
		$sql = "SELECT g.id, g.nom
				FROM groupe g
				WHERE NOT EXISTS (SELECT a.idjoueur
								  FROM adhesion a
								  WHERE a.idgroupe = g.id
								  AND a.idjoueur = $idj)
				ORDER BY g.nom;";
			
	return sql_query($sql);
}

function groupe_get_string_by_idjoueur($idjoueur) {
	$idjoueur = intval($idjoueur);
	$sql = "SELECT idgroupe
			FROM adhesion
			WHERE idjoueur = $idjoueur;";
			
	$result = sql_query($sql);
	$grp_lst = array();
	if(mysql_num_rows($result)) {
		while($row = mysql_fetch_row($result))
			$grp_lst[] = $row[0];
	}
	
	return count($grp_lst) ? implode(',',$grp_lst) : '1';
}

