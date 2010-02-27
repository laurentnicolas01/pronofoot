<?php
/* A ajouter dans la lib de fonctions 'joueur.php' */
require_once('mysql.php');
require_once('constants.php');
require_once('utils.php');
require_once('joueur.php');
require_once('journee.php');

function joueur_reminder($id, $activated) {
	$val = $activated ? 1 : 0;
	
	$sql = "UPDATE joueur
			SET reminder = $val
			WHERE id = $id;";
			
	return sql_query($sql);
}

function joueur_get_remindable() {
	$sql = "SELECT j.email
			FROM `joueur` j
			WHERE j.reminder = 1
			AND NOT EXISTS (
				SELECT p.score
				FROM `prono` p, `match` m, `journee` je
				WHERE p.idjoueur = j.id
				AND p.idmatch = m.id
				AND p.score <> ''
				AND m.idjournee = je.id
				AND je.date = (SELECT `date` FROM journee WHERE `terminated` = 0 ORDER BY `date` ASC LIMIT 1)
			);";
			
	return sql_query($sql);
}

function journee_get_next_date() {
	$sql = "SELECT `date`
			FROM journee
			WHERE `terminated` = 0
			ORDER BY `date` ASC
			LIMIT 1;";
	
	$result = sql_query($sql);
	$date = mysql_num_rows($result) ? mysql_fetch_row($result) : array(0);
	return $date[0];
}


/*********************************************************************************************************/
/*																									     */
/*  Tâche planifiée qui envoie des mails de rappel aux pronostiqueurs abonnés qui n'ont pas pronostiqué  */
/*																									     */
/*********************************************************************************************************/

sql_connect();

echo 'Script exécuté le '.std_time_to_str(time()).'<br />';

// Si la prochaine journée est dans plus de 35 heures, on ne fait rien
$date_next = journee_get_next_date();
if(!$date_next || $date_next > time() + (3600 * 35)) {
	echo 'Pas de journée programmée<br />';
	exit;
}

$hours = round(($date_next - time()) / 3600, 2);
echo 'Prochaine journée dans '.$hours.' heures<br />';

// On récupère la liste éventuelle des abonnés n'ayant pas encore pronotiqué
$emails = joueur_get_remindable();
$nb = mysql_num_rows($emails);

// S'il n'y a aucun abonné qui n'a pas pronostiqué, on ne fait rien
if(!$nb) {
	echo 'Aucun joueur à rappeler, tout le monde a été sérieux<br />';
	exit;
}

echo 'Il y a '.$nb.' joueurs qui n\'ont pas pronotiqué<br />';

// Arrivé ici, on peut envoyer les mails de rappel à ceux qui sont abonnés et qui n'ont pas encore pronostiqué
$sender = DEFAULT_MAIL;
$link = WEBLINK;
$object = 'Rappel aux pronostiqueurs en retard';

// A ajouter : telle journée, qui commence tel jour à tel heure...
$message = <<<EOT
Bonjour,

Voici le mail de rappel de la semaine. Vous n'avez toujours pas pronostiqué et au moment où sont écrites ces lignes, il ne reste plus que $hours heures avant le début de la prochaine journée.
Pensez-y !

Note : Pour ne plus recevoir ces messages automatiques, connectez-vous sur le site et modifiez le paramètre dans l'espace "mon profil".

L'équipe Prono Foot
$sender
$link
EOT;

// Envoie de l'email à chaque joueur à reminder
echo 'Mail(s) des joueurs à rappeler :<br />';
while($email = mysql_fetch_row($emails)) {
	echo $email[0].'<br />';
	//send_mail($sender, $email[0], 'Prono Foot', $object, $message);
}
send_mail($sender, 'j.paroche@gmail.com', 'Prono Foot', $object, $message);//prod: a suppr
