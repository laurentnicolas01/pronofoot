<?php
/********************************/
/* Gestion de la table message  */
/********************************/

require_once('utils.php');
require_once('mysql.php');

sql_connect();

// Fonctions
function message_create($texte, $idjoueur) {
	$sql = "INSERT INTO message(date,texte,idjoueur)
			VALUES(".time().",'$texte',$idjoueur);";
			
	return sql_query($sql);
}

function message_get_list($nb) {
	$sql = 'SELECT m.date, m.texte, j.pseudo
			FROM message m
			LEFT JOIN joueur j
			ON j.id = m.idjoueur
			ORDER BY m.date DESC';
			
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
