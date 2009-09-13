<?php
require_once('lib/prono.php');
require_once('lib/journee.php');

$journee = mysql_fetch_assoc(journee_get_current());
$pronos = prono_get_by_journee($journee['id']);

if(mysql_num_rows($pronos)) {
	$pseudo = '';
	while($prono = mysql_fetch_assoc($pronos)) {
		if($pseudo == '')
			echo '<p class="strong">Les pronostics de tout le monde pour la '.display_number($prono['numero']).' journée</p>';
		if($prono['pseudo'] != $pseudo) {
			echo '<br /><span class="strong">Pronos de '.$prono['pseudo'].'</span><br />';
			$pseudo = $prono['pseudo'];
		}
		echo $prono['equipe1'].' - '.$prono['equipe2'].' : '.$prono['score'].'<br />';
	}
}
else {
	echo '<p class="strong">Les pronostics de tout le monde pour la journée en cours</p>';
	echo '<span class="error">Il n\'y a pas encore de pronostics effectués pour la journée en cours</span>';
}

