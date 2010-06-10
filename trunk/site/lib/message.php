<?php
/********************************/
/* Gestion de la table message  */
/********************************/

require_once('utils.php');
require_once('mysql.php');

sql_connect();

// Fonctions
function message_create($texte, $idjoueur, $idgroup) {
	$date = time();
	$sql = "INSERT INTO message(date,texte,idjoueur,idgroup)
			VALUES($date,'$texte',$idjoueur,$idgroup);";
			
	return sql_query($sql);
}

function message_get_list($nb, $idgroup) {
	$sql = "SELECT m.date, m.texte, j.pseudo
			FROM message m
			LEFT JOIN joueur j
			ON j.id = m.idjoueur
			WHERE m.idgroup = $idgroup
			ORDER BY m.date DESC";
			
	$sql .= $nb != 0 ? " LIMIT $nb;" : ';';
			
	return sql_query($sql);
}

function message_print($pseudo, $date, $texte) {
	echo '<div class="message">
			<span class="mess_auteur">'.$pseudo.'</span>
			<span class="mess_date">'.time_to_str($date).'</span><br />
			<span class="mess_texte">'.$texte.'</span>
		</div>';
}
