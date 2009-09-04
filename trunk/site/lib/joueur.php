<?php

require_once('constants.php');

/*
Gestion de la table joueur

*/

function joueur_get_classement($groupe = '0') {
	$sql = 'SELECT *
			FROM joueur
			';
			
	if($groupe) $sql .= "WHERE idgroups LIKE '%$groupe%'\n";
			
	$sql .= 'ORDER BY points DESC, pseudo ASC;';
	
	return sql_query($sql);
}

