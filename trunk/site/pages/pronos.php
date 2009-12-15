<?php
require_once('lib/prono.php');
require_once('lib/journee.php');
require_once('lib/match.php');

$journee = mysql_fetch_assoc(journee_get_current());
$matchs = match_get_by_journee($journee['id']);
$pronos = prono_get_by_journee($journee['id']);

if(mysql_num_rows($pronos)) {
	$pseudo = '';
	while($prono = mysql_fetch_assoc($pronos)) {
		if($pseudo == '') {
			echo '<h3>Tous les pronostics pour la '.display_number($prono['numero']).' journée</H3>
				  <table class="table-contain"><thead class="ui-state-default"><th></th>';
			while($match = mysql_fetch_assoc($matchs))
				echo '<th>'.$match['equipe1'].' - '.$match['equipe2'].'</th>';
			echo '</thead></tbody>';
		}
		if($prono['pseudo'] != $pseudo) {
			echo '</tr><tr><td class="strong">'.$prono['pseudo'].'</td><td>'.$prono['score'].'</td>';
			$pseudo = $prono['pseudo'];
		}
		else {
			echo '<td>'.$prono['score'].'</td>';
		}
	}
	echo '</tr></tbody></table>';
}
else {
	echo '<span class="error">Il n\'y a pas encore de pronostics effectués pour la journée en cours</span>';
}
