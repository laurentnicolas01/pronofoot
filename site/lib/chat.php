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
	$sql = "SELECT date, texte, idjoueur
			FROM message
			ORDER BY date DESC
			LIMIT $nb;";
			
	return sql_query($sql);
}

function message_print($idjoueur, $date, $texte) {
	echo '<li class="message">
			<span class="mess_auteur">'.joueur_get_pseudo($idjoueur).'</span>
			<span class="mess_date">'.time_to_str($date).'</span><br />
			<span class="mess_texte">'.$texte.'</span>
		</li>';
}

// AJAX
if(isset($_POST['action']) && $_POST['action'] != '') {
	switch(clean_str($_POST['action'])) {
		case 'insert':
			$texte = mysql_real_escape_string(clean_str($_POST['message']));
			$auteur = intval($_POST['id']);
			if($texte != '' && joueur_id_exists($auteur) && message_create($texte,$auteur)) {
				echo 'ok&&&';
				message_print($auteur, time(), $texte);
			}
			else
				echo 'pas ok&&&';
			break;
			
		case 'update':
			$messages = message_get_list(intval($_POST['nb']));
			while($message = mysql_fetch_assoc($messages))
				message_print($message['idjoueur'], $message['date'], $message['texte']);
			break;
	}
}
