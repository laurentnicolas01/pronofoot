<h2>Envoi de mails aux membres</h2>
<?php
require_once('lib/utils.php');
require_once('lib/constants.php');
require_once('lib/joueur.php');

/**
 * Envoie d'un mail depuis le formulaire
 * @param email: l'email de la personne qui envoie le mail
 * @param names: les nom et prénom de la personne qui recevra le mail
 * @param message: le message à envoyer à l'équipe adrénaline
 * @return true si le mail a bien été envoyé, false sinon
 */
function send_contact_mail($email, $message)
{
	// préparation envoyeur et destinataire
	$contact = 'Prono Foot';
	$sender = 'pronofoot@julienp.fr';
	$receiver = $email;
	
	// en-têtes
	$headers  = 'MIME-Version: 1.0'."\n";
    $headers .= 'From: "'.$contact.'"<'.$sender.'>'."\n";
    $headers .= 'Reply-To: '.$sender."\n";
    $headers .= 'Content-Type: text/plain; charset="utf-8"'."\n";
    $headers .= 'Content-Transfer-Encoding: 8bit';
	
	// preparation de l'objet
	$object = 'Message de l\'équipe Prono Foot';
	
	// préparation du contenu du mail (clean_str nécessaire pour le problème slashes)
	$content = clean_str_preserve_tags($message)."\n".DEFAULT_MAIL."\n".WEBLINK;
	
	// envoi du mail et retour du résultat (true ou false)
	return mail($receiver, $object, $content, $headers);
}

if(isset($_POST['send'])) {
	$message = $_POST['message'];
	$rand = $_POST['rand'];
	$confirm = $_POST['confirm'];
	
	$errors = array();

	if($confirm != $rand) {
		$errors[] = 'Le code de confirmation ne correspond pas';
	}
	if($message == '') {
		$errors[] = 'Vous devez écrire un message pour pouvoir envoyer le mail';
	}
	
	if(count($errors) == 0) {
		$emails = joueur_get_emails();
		$count = 0;
		while($email = mysql_fetch_row($emails)) {
			if(send_contact_mail($email[0], $message))
				++$count;
			else
				$errors[] = $email;
		}
		
		if($count != 0)
			echo '<p class="success">'.$count.' '.plural('message', $count).' '.plural('envoyé', $count).'</p>';
		
		if(count($errors) != 0) {
			?>
			<div class="error">
				L'envoi n'a pas fonctionné pour les mails suivants :
				<?php print_array($errors); ?>
			</div>
			<?php
		}
	}
	else {
		?>
		<div class="error">
			Merci de corriger les erreurs suivantes :
			<?php print_array($errors); ?>
		</div>
		<?php
	}
}
else {
	$names = '';
	$email = '';
	$message = '';
	?>
	<p>
	Formulaire pour envoyer un message à tous les membres du site
	</p><?php
}
?>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
	<p>
		<label for="message">Message :</label><br />
		<textarea name="message" id="message" rows="15" cols="70"><?php echo $message; ?></textarea>
	</p>
	<p>
		Code de sécurité : &nbsp;<strong><?php echo $confirm=substr(md5(rand()), 3, 4); ?></strong><br />
		<label for="confirm">Merci de recopier le code donné ci-dessus : </label>
		<input type="text" name="confirm" id="confirm" maxlength="4" size="4" />
		<input type="hidden" name="rand" id="rand" value="<?php echo $confirm; ?>" />
	</p>
	<p>
		<input type="submit" name="send" id="send" value="Envoyer" />
	</p>
</form>
