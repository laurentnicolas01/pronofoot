<h2>Mon profil</h2>
<?php
// Quelle équipe supportez vous ? Email publique ? Image ?
require_once('lib/joueur.php');

if(isset($_POST['submit_pass'])) {
	$id = intval($_SESSION['id']);
	$pass = clean_str($_POST['pass']);
	$pass2 = clean_str($_POST['pass2']);
	
	if($pass != $pass2) {
		echo '<span class="error">Les deux mots de passe ne correspondent pas</span>';
	}
	elseif($pass == '') {
		echo '<span class="error">Impossible de mettre un mot de passe vide !</span>';
	}
	else {
		if(joueur_update_pass($id, crypt_password($pass)))
			echo '<span class="success">Votre pass a été modifié avec succès</span>';
		else
			echo '<span class="error">Il y a eu une erreur lors de la mise à jour en base de données</span>';
	}
	echo '<br />';
}

if(isset($_POST['submit_save'])) {
	// Sauvegarder tous les changements dans le profil
	$id = intval($_SESSION['id']);
	if(isset($_POST['reminder']) && $_POST['reminder'] == 'on')
		echo joueur_update_reminder($id, true) ? '<span class="success">Modifications enregistrées</span>' : '<span class="error">Erreur d\'enregistrement</span>';
	else
		echo joueur_update_reminder($id, false) ? '<span class="success">Modifications enregistrées</span>' : '<span class="error">Erreur d\'enregistrement</span>';
	echo '<br />';
}

?>

<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
	<p class="strong">Modification du mot de pass</p>
	<p>
		<label>Nouveau pass : </label>
		<input type="password" name="pass" id="pass" />
	</p>
	<p>
		<label>Confirmation : </label>
		<input type="password" name="pass2" id="pass2" />
	</p>
	<p>
		<input type="submit" name="submit_pass" id="submit_pass" value="Modifier" />
	</p>	
</form>

<br />

<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
	<?php $checked = joueur_wants_reminder($_SESSION['id']) ? 'checked="checked"' : ''; ?>
	<p>
		<label>Je veux recevoir un rappel automatique par mail chaque semaine : </label>
		<input type="checkbox" name="reminder" id="reminder" <?php echo $checked; ?> />
	</p>
	<p>
		<input type="submit" name="submit_save" id="submit_save" value="Enregistrer" />
	</p>	
</form>

<br />
<p class="info">D'autres options bientôt !</p>
