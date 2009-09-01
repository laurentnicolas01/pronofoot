<?php 
if(!$_SESSION['is_connect']) {
	if(isset($_POST['submit-connection'])) {
		echo '<span class="error">Les identifiants saisis sont incorrects</span>';
	} ?>
	<p>Bienvenue sur le site de pronostics pour le "big five" de la ligue 1 !</p>
	<p>Veuillez vous connecter pour accéder aux pronostics</p>
	<p>Si vous n'avez pas de compte, ou si vous avez un problème, veuillez consulter la rubrique "Contact" (en bas)</p>
	<br />
	<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
		<p>
			<label>Email : </label>
			<input type="text" name="email" id="email" size="25" />
		</p>
		<p>
			<label>Pass : </label>
			<input type="password" name="pass" id="pass" style="margin-left:4px;" size="25" />
		</p>
		<p>
			<input type="submit" name="submit-connection" id="submit-connection" value="Connexion" />
		</p>	
	</form><?php
}
else {
	echo '<span class="success">Vous êtes connecté sous le pseudonyme <strong>'.$_SESSION['pseudo'].'</strong></span>
		  <p>Vous pouvez maintenant utiliser le menu à gauche</p>';
}
?>

