<?php
require_once('lib/utils.php');
require_once('lib/constants.php');

/**
 * Envoie d'un mail depuis le formulaire
 * @param email: l'email de la personne qui envoie le mail
 * @param names: les nom et prénom de la personne qui recevra le mail
 * @param message: le message à envoyer à l'équipe adrénaline
 * @return true si le mail a bien été envoyé, false sinon
 */
function send_contact_mail($email, $names, $message)
{
	// préparation envoyeur et destinataire
	$contact = '(Adrénaline) '.$names;
	$sender = $email;
	$receiver = DEFAULT_MAIL;
	
	// en-têtes
	$headers  = 'MIME-Version: 1.0'."\n";
    $headers .= 'From: "'.$contact.'"<'.$sender.'>'."\n";
    $headers .= 'Reply-To: '.$sender."\n";
    $headers .= 'Content-Type: text/plain; charset="utf-8"'."\n";
    $headers .= 'Content-Transfer-Encoding: 8bit';
	
	// preparation de l'objet
	$object = 'Message depuis le formulaire de contact Adrénaline';
	
	// préparation du contenu du mail
	$content  = $message;
	
	// envoi du mail et retour du résultat (true ou false)
	return mail($receiver, $object, $content, $headers);
}

if(isset($_POST['send'])) {
	$names = clean_str($_POST['names']);
	$email = clean_str($_POST['email']);
	$message = clean_str($_POST['message']);
	$rand = $_POST['rand'];
	$confirm = $_POST['confirm'];
	
	$errors = array();

	if(!valid_email($email)) {
		$errors[] = 'L\'e-mail que vous avez entré est invalide';
	}
	if($confirm != $rand) {
		$errors[] = 'Le code de confirmation ne correspond pas';
	}
	if($message == '') {
		$errors[] = 'Vous devez écrire un message pour pouvoir envoyer le mail';
	}
	
	if (count($errors) == 0) {
		if(send_contact_mail($email, $names, $message))
			echo '<p class="success">Votre message a bien été envoyé à l\'équipe Adrénaline</p>';
		else
			echo '<p class="error">L\'envoi du message n\'a pas fonctionné</p>';
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
	Si vous avez des suggestions, un problème ou tout simplement besoin d'un compte, veuillez nous contacter à l'aide de ce formulaire :
	</p><?php
}
?>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
	<p>
		<label for="names">Vos nom et prénom :</label><br />
		<input type="text" name="names" id="names" size="50" value="<?php echo $names; ?>" />
	</p>
	<p>
		<label for="email">Votre adresse e-mail :</label><br />
		<input type="text" name="email" id="email" size="50" value="<?php echo $email ?>" />
	</p>
	<p>
		<label for="message">Votre message :</label><br />
		<textarea name="message" id="message" rows="10" cols="50"><?php echo $message; ?></textarea>
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

