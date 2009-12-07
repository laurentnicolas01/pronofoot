<?php
/**************************************************************/
/* Gestion de la table messages et scripts AJAX pout le tchat */
/**************************************************************/

session_start();

chdir('..');

require_once('lib/constants.php');
require_once('lib/utils.php');
require_once('lib/mysql.php');
require_once('lib/joueur.php');

sql_connect();

// Fonctions
function message_create($texte, $idjoueur) {
	$sql = "INSERT INTO message(date,texte,idjoueur)
			VALUES(".time().",'$texte',$idjoueur);";
			
	return sql_query($sql);
}

function message_get_list($nb) {
	$sql = "SELECT m.date, m.texte, j.pseudo
			FROM message m
			LEFT JOIN joueur j
			ON j.id = m.idjoueur
			ORDER BY m.date DESC
			LIMIT $nb;";
			
	return sql_query($sql);
}

function message_print($pseudo, $date, $texte) {
	echo '<li class="message">
			<span class="mess_auteur">'.$pseudo.'</span>
			<span class="mess_date">'.time_to_str($date).'</span><br />
			<span class="mess_texte">'.$texte.'</span>
		</li>';
}

// AJAX
if(isset($_POST['action']) && $_POST['action'] != '') {
	switch(clean_str($_POST['action'])) {
		case 'insert':
			$texte = mysql_real_escape_string(clean_str($_POST['message']));
			$idjoueur = intval($_POST['id']);
			if($texte != '' && joueur_id_exists($idjoueur) && message_create($texte,$idjoueur)) {
				echo 'ok&&&';
				message_print(joueur_get_pseudo($idjoueur), time(), $texte);
			}
			else
				echo 'pas ok&&&';
			break;
			
		case 'update':
			$messages = message_get_list(intval($_POST['nb']));
			while($message = mysql_fetch_assoc($messages))
				message_print($message['pseudo'], $message['date'], $message['texte']);
			break;
	}
}
