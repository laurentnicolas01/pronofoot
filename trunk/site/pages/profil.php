<?php
// Quelle équipe supportez vous ? Email publique ? Image ?

if(isset($_POST['submit_pass'])) {
	$id = intval($_SESSION['id']);
	$pass = clean_str($_POST['pass']);
	
	if($pass != '') {
		if(joueur_update_pass($id, crypt_password($pass))) {
			$joueur = mysql_fetch_assoc(joueur_get($id));
			echo '<span class="success">Votre pass a été modifié avec succès</span>';
		}
		else
			echo '<span class="error">Il y a eu une erreur lors de la mise à jour en base de données</span>';
	}
	else
		echo '<span class="error">Impossible de mettre un mot de passe vide !</span>';
}

?>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
	<p class="strong">Modification du mot de pass</p>
	<p>
		<label>Nouveau pass : </label>
		<input type="password" name="pass" id="pass" />
	</p>
	<p>
		<input type="submit" name="submit_pass" id="submit_pass" value="Modifier" />
	</p>	
</form>
<br />
<p class="info">D'autres options bientôt !</p>
