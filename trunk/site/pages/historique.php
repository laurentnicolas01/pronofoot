<?php
require_once('lib/prono.php');
require_once('lib/journee.php');
require_once('lib/joueur.php');
require_once('lib/match.php');

$journees = journee_get_all_terminated($asc = true);

echo '<p class="">Afficher l\'historique de la journée :</p>';
while($journee = mysql_fetch_assoc($journees)) {
	echo '<strong><a href="historique-'.$journee['id'].'" class="ui-state-default">'.$journee['numero'].'</a></strong> ';
}

$journee = isset($_GET['j']) && journee_exists($_GET['j']) ? journee_get_by_id($_GET['j']) : journee_get_all_terminated($asc = false);
$idjournee = $journee['id'];

$matchs = match_get_by_journee($idjournee);
$pronos = prono_get_by_journee($idjournee);

if(mysql_num_rows($pronos)) {
	$nickname = '';
	$idj = 0;
	$count = 0;
	$nbmatchs = mysql_num_rows($matchs);
	while($prono = mysql_fetch_assoc($pronos)) {
		if($nickname == '') {
			echo '<h3>Historique des pronostics pour la '.display_number($prono['numero']).' journée</h3>
				  <table class="table-contain"><thead class="ui-state-default"><tr><th></th>';
			while($match = mysql_fetch_assoc($matchs))
				echo '<th>'.$match['equipe1'].' - '.$match['equipe2'].'</th>';
			echo '<th>*Points*</th></tr></thead><tbody><tr><td class="strong left">'.$prono['pseudo'].'</td><td>'.$prono['score'].'</td>';
			$nickname = $prono['pseudo'];
			$idj = $prono['idjoueur'];
			++$count;
			continue;
		}
		if($prono['pseudo'] != $nickname) {
			if($count < $nbmatchs) {
				for($i = $count ; $i < $nbmatchs ; ++$i)
					echo '<td>X</td>';
			}
			echo '<td class="strong">'.joueur_get_result($idj,$idjournee).'</td></tr><tr><td class="strong left">'.$prono['pseudo'].'</td><td>'.$prono['score'].'</td>';
			$count = 1;
		}
		else {
			echo '<td>'.$prono['score'].'</td>';
			++$count;
		}
		$nickname = $prono['pseudo'];
		$idj = $prono['idjoueur'];
	}
	echo '<td class="strong">'.joueur_get_result($idj,$idjournee).'</td></tr><tr><td class="strong">*Scores*</td>';
	$match_res = match_get_scores($idjournee);
	while($m = mysql_fetch_assoc($match_res))
		echo '<td class="strong">'.$m['score'].'</td>';
	echo '</tr></tbody></table>';
}
else {
	echo '<span class="error">Il n\'y a pas encore d\'historique des pronostics</span>';
}
