<?php
if(!$_SESSION['is_connect']) {
	if(isset($_POST['submit-connection'])) {
		echo '<span class="error">Identifiants incorrects</span>';
	} ?>
	<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
		<p>
			<label class="user block">Email</label>
			<input type="text" name="email" id="email" size="25" />
		</p>
		<p>
			<label class="connect block">Pass</label>
			<input type="password" name="pass" id="pass" size="25" />
		</p>
		<p>
			<input type="submit" name="submit-connection" id="submit-connection" value="Connexion" />
		</p>
	</form><?php 
}
else { ?>
	<span class="success">Vous êtes connecté</span>
	<p class="user"><?php echo $_SESSION['pseudo']; ?> (<a href="profil">mon profil</a>)</p>
	<p class="disconnect"><a href="deconnexion">Déconnexion</a></p><?php
}
