<?php
require_once('lib/utils.php');
require_once('lib/constants.php');
require_once('lib/groupe.php');
require_once('lib/demande.php');
require_once('lib/joueur.php');

/**
 * Envoie d'un mail depuis le formulaire
 * @param email: l'email de la personne qui envoie le mail
 * @param names: les nom et prénom de la personne qui recevra le mail
 * @param message: le message à envoyer à l'équipe adrénaline
 * @return true si le mail a bien été envoyé, false sinon
 */
function send_contact_mail($email)
{
	// préparation envoyeur et destinataire
	$contact = '(PronoFoot)';
	$sender = $email;
	$receiver = DEFAULT_MAIL;
	
	// en-têtes
	$headers  = 'MIME-Version: 1.0'."\n";
    $headers .= 'From: "'.$contact.'"<'.$sender.'>'."\n";
    $headers .= 'Reply-To: '.$sender."\n";
    $headers .= 'Content-Type: text/plain; charset="utf-8"'."\n";
    $headers .= 'Content-Transfer-Encoding: 8bit';
	
	// preparation de l'objet
	$object = 'Demande de compte sur Prono Foot';
	
	// préparation du contenu du mail
	$content  = 'Il y a une nouvelle demande de compte sur Prono Foot';
	
	// envoi du mail et retour du résultat (true ou false)
	return mail($receiver, $object, $content, $headers);
}

if(isset($_POST['send'])) {
	$pseudo = clean_str($_POST['pseudo']);
	$email = clean_str($_POST['email']);
	$pass = clean_str($_POST['pass']);
	$pass2 = clean_str($_POST['pass2']);
	$idgroup = intval($_POST['groupe']);
	$new_groupe = clean_str($_POST['new_groupe']);
	$rand = $_POST['rand'];
	$confirm = $_POST['confirm'];
	
	$errors = array();
	
	if(joueur_pseudo_exists($pseudo) || demande_pseudo_exists($pseudo)) {
		$errors[] = 'Ce pseudo est déjà utilisé pour un compte ou une demande en cours';
	}
	if(!valid_email($email)) {
		$errors[] = 'L\'e-mail que vous avez entré est invalide';
	}
	if($pass == '') {
		$errors[] = 'Il faut préciser un mot de passe';
	}
	if($pass != $pass2) {
		$errors[] = 'Les deux mots de passe ne correspondent pas';
	}
	if(joueur_exists($email) || demande_exists($email)) {
		$errors[] = 'Cet email est déjà utilisé pour un compte ou une demande en cours';
	}
	if($confirm != $rand) {
		$errors[] = 'Le code de confirmation ne correspond pas';
	}
	
	if (count($errors) == 0) {
		if(demande_add($email, $pseudo, crypt_password($pass), $idgroup, $new_groupe)) {
			send_contact_mail($email);
			echo '<p class="success">Votre demande de compte a bien été enregistrée</p>';
		}
		else
			echo '<p class="error">Il y a eu un problème à l\'enregistrement, veuillez réessayer plus tard</p>';
	}
	else {
		?>
		<div class="error">
			Des erreurs ont été trouvées :
			<?php print_array($errors); ?>
		</div>
		<?php
	}
}
else {
	$pseudo = '';
	$email = '';
	$new_groupe = '';
	?>
	<p>
	Les demandes de nouveau compte sont verifiées avant d'être validées. Le délai d'attente 
	pour validation est d'environ 24h.<br />
	Pour compléter votre demande, merci de remplir le formulaire suivant :
	</p><?php
}
?>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
	<p>
		<label for="pseudo">Votre pseudo :</label><br />
		<input type="text" name="pseudo" id="pseudo" size="30" value="<?php echo $pseudo; ?>" />
	</p>
	<p>
		<label for="email">Votre adresse e-mail :</label><br />
		<input type="text" name="email" id="email" size="30" value="<?php echo $email ?>" />
	</p>
	<p>
		<label for="pass">Votre mot de passe :</label><br />
		<input type="password" name="pass" id="pass" size="30" value="" />
	</p>
	<p>
		<label for="pass2">Confirmez le passe :</label><br />
		<input type="password" name="pass2" id="pass2" size="30" value="" />
	</p>
	<p>
		<span class="info">Les joueurs sont repartis par groupe, les choix ci-dessous ne sont pas définitifs et pourront changer sur simple demande</span>
	</p>
	<p>
		<label for="group">Séléctionnez un groupe :</label><br />
		<?php
		$groups = groupe_get_all();
		echo '<select name="groupe">';
		while($group = mysql_fetch_assoc($groups))
			echo '<option value="'.$group['id'].'">'.$group['nom'].'&nbsp;&nbsp;</option>';
		echo '</select>';
		?>
	</p>
	<p>
		<label for="new_groupe">Nouveau groupe (facultatif) :</label><br />
		<input type="text" name="new_groupe" id="new_groupe" size="30" value="<?php echo $new_groupe ?>" />
	</p>
	<p>
		Code de sécurité : &nbsp;<strong><?php echo $confirm=substr(md5(rand()), 3, 4); ?></strong><br />
		<label for="confirm">Merci de recopier le code donné ci-dessus : </label>
		<input type="text" name="confirm" id="confirm" maxlength="4" size="4" />
		<input type="hidden" name="rand" id="rand" value="<?php echo $confirm; ?>" />
	</p>
	<p>
		<input type="submit" name="send" id="send" value="Valider" />
	</p>
</form>

