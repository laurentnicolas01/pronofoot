<?php
require_once('lib/prono.php');
require_once('lib/journee.php');
require_once('lib/joueur.php');
require_once('lib/match.php');

$journees = journee_get_all_terminated($asc = false);
$selected_journee = isset($_POST['idj_asked']) && journee_exists(intval($_POST['idj_asked'])) ? journee_get_by_id(intval($_POST['idj_asked'])) : journee_get_last_terminated();
$idjournee = $selected_journee['id'];

echo '<form method="post" action="'.$_SERVER['REQUEST_URI'].'"><p><label>Afficher l\'historique de la journée : </label><select name="idj_asked">';
while($journee = mysql_fetch_assoc($journees)) {
	$selected = $journee['id'] == $idjournee ? ' selected="selected" ' : '';
	echo '<option value="'.$journee['id'].'" '.$selected.'>'.$journee['numero'].'</option>';
}
echo '</select><input type="submit" name="submit_asked" value="GO" class="hidden" /></p></form>';

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
