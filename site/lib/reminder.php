<?php
/* A ajouter dans la lib de fonctions 'joueur.php' */
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
			
	$date = mysql_fetch_row(sql_query($sql));
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
$object = 'Prono Foot';

$message = "Allez prono ! Pour ne plus recevoir ces messages, allez sur le site vous connectez et modifier le paramètre dans la section mon profil (module à droite)."; // A ajouter : telle journée, qui commence tel jour à tel heure...

while($email = mysql_fetch_row($emails)) {
	xmail($sender, $email[0] /* email de chaque joueur à reminder */, $object, $message)
}

xmail($sender, 'j.paroche@gmail.com', $object, "Un mail de rappel à été envoyé à $nb personnes le ".time_to_str(time()).'.');

