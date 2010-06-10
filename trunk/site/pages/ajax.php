<?php
/***************************/
/* AJAX CLIENT SCRIPTS	   */
/***************************/

/**
 * Donne le chemin d'un fichier à partir de son chemin absolu en partant de la racine (sans ../)
 * @param short_path: string du type 'lib/script.php' ou 'design/images/header.png'
 * @return le chemin relatif du fichier s'il existe dans le chemin spécifié
 * Si le nombre de '..' dépasse 50, le chemin de fichier est renvoyé tel quel (inutilisable)
 */
function get_file($short_path) {
	return file_exists($short_path)	&& substr_count($short_path, '..') < 50 ? $short_path : get_file('../'.$short_path);
}

// Définition du fuseau horaire
require_once(get_file('lib/constants.php'));
date_default_timezone_set(TIMEZONE);
// Connexion à la base
require_once(get_file('lib/mysql.php'));
sql_connect();

switch($_REQUEST['action']) {
	
	/* Messages ------------------------------- */
	
	case 'message_update':
		require_once(get_file('lib/message.php'));
		require_once(get_file('lib/groupe.php'));
		$nb = isset($_POST['nb']) && intval($_POST['nb']) >= 0 ? intval($_POST['nb']) : 10;
		$idg = isset($_POST['idg']) && groupe_id_exists(intval($_POST['idg'])) ? intval($_POST['idg']) : 0;
		$messages = message_get_list($nb, $idg);
		if(mysql_num_rows($messages)) {
			while($message = mysql_fetch_assoc($messages))
				message_print($message['pseudo'], $message['date'], $message['texte']);
		}
		else {
			message_print('Notification', time(), '(aucun message pour le moment)');
		}
		break;
	
	case 'message_insert':
		require_once(get_file('lib/utils.php'));
		require_once(get_file('lib/message.php'));
		require_once(get_file('lib/joueur.php'));
		require_once(get_file('lib/groupe.php'));

		$texte = mysql_real_escape_string(clean_str($_POST['message']));
		$idjoueur = intval($_POST['id']);
		$idgroup = groupe_id_exists(intval($_POST['idg'])) ? intval($_POST['idg']) : 0;
		if($texte != '' && joueur_id_exists($idjoueur) && message_create($texte,$idjoueur,$idgroup)) {
			echo 'ok&&&';
			message_print(joueur_get_pseudo($idjoueur), time(), stripslashes($texte));
		}
		else
			echo 'pas ok&&&';
		break;
		
	/* Member list ------------------------------- */
	
	case 'members_connected':
		session_start();
		require_once(get_file('lib/utils.php'));
		require_once(get_file('lib/joueur.php'));
		
		joueur_refresh($_SESSION['id']);
		joueur_timeout();
		$list_connected = joueur_get_listconnect();
		if(mysql_num_rows($list_connected)) {
			echo 'ok&&&'.joueur_print_nbco(joueur_get_nbconnect()).'&&&<p class="strong table">Liste des membres connectés</p>';
			while($co = mysql_fetch_row($list_connected))
				echo '<p class="bgreen pseudo_co">'.$co[0].'</p>';
		}
		else
			echo 'pas ok&&&';
		break;
		
	/* Si l'action n'est pas trouvée ---------- */
	
	default:
		echo 'fail&&&';
		break;
}
