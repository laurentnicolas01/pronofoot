<?php
require_once('lib/prono.php');
require_once('lib/journee.php');
require_once('lib/match.php');

$journees = journee_get_all_terminated($asc = true);

echo '<p class="">Afficher l\'historique de la journée :</p>';
while($journee = mysql_fetch_assoc($journees)) {
	echo '<strong><a href="historique-'.$journee['id'].'" class="ui-state-default">'.$journee['numero'].'</a></strong> ';
}

$journee = isset($_GET['j']) && journee_exists($_GET['j']) ? journee_get_by_id($_GET['j']) : journee_get_all_terminated($asc = false);

$matchs = match_get_by_journee($journee['id']);
$pronos = prono_get_by_journee($journee['id']);

if(mysql_num_rows($pronos)) {
	$pseudo = '';
	$count = 0;
	$nbmatchs = mysql_num_rows($matchs);
	while($prono = mysql_fetch_assoc($pronos)) {
		if($pseudo == '') {
			echo '<h3>Historique des pronostics pour la '.display_number($prono['numero']).' journée</h3>
				  <table class="table-contain"><thead class="ui-state-default"><th></th>';
			while($match = mysql_fetch_assoc($matchs))
				echo '<th>'.$match['equipe1'].' - '.$match['equipe2'].'</th>';
			echo '</thead><tbody><tr><td class="strong">'.$prono['pseudo'].'</td><td>'.$prono['score'].'</td>';
			$pseudo = $prono['pseudo'];
			++$count;
			continue;
		}
		if($prono['pseudo'] != $pseudo) {
			if($count < $nbmatchs) {
				for($i = $count ; $i < $nbmatchs ; ++$i)
					echo '<td>X</td>';
			}
			echo '</tr><tr><td class="strong">'.$prono['pseudo'].'</td><td>'.$prono['score'].'</td>';
			$count = 1;
		}
		else {
			echo '<td>'.$prono['score'].'</td>';
			++$count;
		}
		$pseudo = $prono['pseudo'];
	}
	echo '</tr></tbody></table>';
}
else {
	echo '<span class="error">Il n\'y a pas encore d\'historique des pronostics</span>';
}
