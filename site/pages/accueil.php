<?php 
if(!$_SESSION['is_connect']) {
	if(isset($_POST['submit-connection'])) {
		echo '<span class="error">Les identifiants saisis sont incorrects</span>';
	} ?>
	<p>Bienvenue sur le site de pronostics pour le "big five" de la ligue 1 !</p>
	<p>Veuillez vous connecter pour accéder aux fonctionnalités du site</p>
	<p>Si vous n'avez pas de compte et que vous voulez en créer un, ou si vous avez un problème, <a href="?p=contact">cliquez ici</a></p>
	<br /><?php
}
else {
	echo '<span class="success">Vous êtes connecté sous le pseudonyme <strong>'.$_SESSION['pseudo'].'</strong></span>
		  <p>Vous pouvez maintenant pronostiquer et utiliser le chat à droite !</p>';
}
?>

