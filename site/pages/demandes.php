<h2>Admin : demandes de comptes</h2>
<p class="strong">Tableau des validations</p>
<?php
require_once('lib/constants.php');
require_once('lib/demande.php');
require_once('lib/utils.php');

if(isset($_GET['dr'])) {
	$idd = intval($_GET['dr']);
	echo demande_decline($idd) ? '<p class="success">Demande refusée</p>' : '<p class="error">Erreur de traitement</p>';
}
if(isset($_GET['da'])) {
	$idd = intval($_GET['da']);
	if(demande_validate($idd)) {
		$content = "Bonjour,

Votre demande de compte sur Prono Foot a été validée par un administrateur.

Pour vous connecter, rendez-vous sur la page d'accueil et utilisez votre adresse email ainsi que le mot de passe que vous avez spécifié à l'inscription.

A bientôt sur Prono Foot !

L'équipe Prono Foot
".DEFAULT_MAIL."\n".WEBLINK;
		send_mail(DEFAULT_MAIL, demande_get_mail($idd), 'Prono Foot', 'Demande de compte', $content);
		echo '<p class="success">Demande acceptée</p>';
	}
	else echo '<p class="error">Erreur de traitement</p>';
}

$demandes = demande_get();
if(mysql_num_rows($demandes)) {
	echo '<table class="table-contain">
	<thead class="ui-state-default">
	<tr>
		<th>Email</th>
		<th>Pseudo</th>
		<th>Groupe</th>
		<th>Autre</th>
		<th>Date</th>
		<th>Validation</th>
	</tr>
	</thead>';
	
	while($demande = mysql_fetch_assoc($demandes)) {
		$autre = $demande['autre_groupe'] != '' ? $demande['autre_groupe'] : '-';
		if($demande['declined']) $validation = '<span class="cross"></span>';
		else $validation = $demande['validated'] ? '<span class="tick"></span>' : '<a class="demande_link" href="demandes-a-'.$demande['id'].'"><img src="images/icons/accept.png" alt="OK" /></a>&nbsp;&nbsp;<a class="demande_link" href="demandes-r-'.$demande['id'].'"><img src="images/icons/exclamation.png" alt="NO" /></a>';
		echo '
		<tr>
			<td>'.$demande['email'].'</td>
			<td>'.$demande['pseudo'].'</td>
			<td>'.$demande['groupe'].'</td>
			<td>'.$autre.'</td>
			<td>'.std_time_to_str($demande['date']).'</td>
			<td>'.$validation.'</td>
		</tr>';
	}
	
	echo '</table>';
}
else echo '<p class="error">Aucune demande effectuée</p>';
