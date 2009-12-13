<?php
/***************************/
/* AJAX INSERT NEW MESSAGE */
/***************************/

chdir('..');

require_once('lib/constants.php');
require_once('lib/mysql.php');
require_once('lib/utils.php');
require_once('lib/message.php');
require_once('lib/joueur.php');

sql_connect();

$texte = mysql_real_escape_string(clean_str($_POST['message']));
$idjoueur = intval($_POST['id']);
if($texte != '' && joueur_id_exists($idjoueur) && message_create($texte,$idjoueur)) {
	echo 'ok&&&';
	message_print(joueur_get_pseudo($idjoueur), time(), stripslashes($texte));
}
else
	echo 'pas ok&&&';
