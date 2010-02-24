<?php
/* A ajouter dans la lib de fonctions 'joueur.php' */
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

// Si la prochaine journée est dans plus de 30 heures, on ne fait rien
if(journee_get_next_date() > time() + (3600 * 35));
	exit;

// On récupère la liste éventuelle des abonnés n'ayant pas encore pronotiqué
$emails = joueur_get_remindable();
$nb = mysql_num_rows($emails);

// S'il n'y a aucun abonné qui n'a pas pronostiqué, on ne fait rien
if(!$nb)
	exit;

// Arrivé ici, on peut envoyer les mails de rappel à ceux qui sont abonnés et qui n'ont pas encore pronostiqué
$sender = 'pronofoot@julienp.fr';
$object = 'Rappel aux pronostiqueurs en retard';

// A ajouter : telle journée, qui commence tel jour à tel heure...
$message = <<<EOT
Allez prono !
Pour ne plus recevoir ces messages,
allez sur le site vous connectez et
modifiez le paramètre dans la section
mon profil (module à droite).
EOT;

while($email = mysql_fetch_row($emails)) {
	send_mail($sender, $email[0] /* email de chaque joueur à reminder */, 'Prono Foot', $object, $message)
}

send_mail($sender, DEFAULT_MAIL, 'Prono Foot', $object, "Un mail de rappel à été envoyé à $nb personnes le ".time_to_str(time()).'.');

