<h2>Historique des pronostics</h2>
<?php
require_once('lib/prono.php');
require_once('lib/journee.php');
require_once('lib/joueur.php');
require_once('lib/match.php');

$journees = journee_get_all_terminated($asc = false);
$selected_journee = isset($_POST['idj_asked']) && journee_exists(intval($_POST['idj_asked'])) ? journee_get_by_id(intval($_POST['idj_asked'])) : journee_get_last_terminated();
$idjournee = $selected_journee['id'];
$numjournee = $selected_journee['numero'];

echo '<form method="post" action="'.$_SERVER['REQUEST_URI'].'"><p><label>Afficher l\'historique de la journée : </label><select name="idj_asked">';
while($journee = mysql_fetch_assoc($journees)) {
	$selected = $journee['id'] == $idjournee ? ' selected="selected" ' : '';
	echo '<option value="'.$journee['id'].'" '.$selected.'>'.shortdate_to_str($journee['numero']).'&nbsp;</option>';
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
			echo '<h3>Historique des pronostics pour le '.shortdate_to_str($numjournee).'</h3>
				<p> Les équipes sont représentées par leurs initiales. Vous pouvez consulter la liste des équivalences en bas de page.</p>	
				  <table class="table-contain"><thead class="ui-state-default"><tr><th></th>';
			while($match = mysql_fetch_assoc($matchs))
				echo '<th>'.team_shortname($match['equipe1']).'<br> - <br>'.team_shortname($match['equipe2']).'</th>';
			echo '<th>Points</th></tr></thead><tbody><tr><td class="strong left">'.$prono['pseudo'].'</td><td>'.$prono['score'].'</td>';
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
	echo '<td class="strong">'.joueur_get_result($idj,$idjournee).'</td></tr><tr><td class="strong">Scores</td>';
	$match_res = match_get_scores($idjournee);
	while($m = mysql_fetch_assoc($match_res))
		echo '<td class="strong">'.$m['score'].'</td>';
	echo '</tr></tbody></table>';
	echo'<h3>Noms des équipes :</h3>
	<p><strong>ACA</strong> = Arles-Avignon; <strong>AJA</strong> = Auxerre; <strong>ASM</strong> = Monaco; <strong>ASNL</strong> = Nancy;
	<strong>ASSE</strong> = Saint-Etienne; <strong>FCGB</strong> = Bordeaux; <strong>FCL</strong> = Lorient; <strong>FCSM</strong> = Sochaux;
	<strong>LOSC</strong> = Lille; <strong>MHSC</strong> = Montpellier; <strong>OGCN</strong> = Nice; <strong>OL</strong> = Lyon;
	<strong>OM</strong> = Marseille; <strong>PSG</strong> = Paris; <strong>RCL</strong> = Lens; <strong>SB29</strong> = Brest;
	<strong>SMC</strong> = Caen; <strong>SRFC</strong> = Rennes; <strong>TFC</strong> = Toulouse; <strong>VAFC</strong> = Valenciennes</p>';
		
	
}
else {
	echo '<span class="error">Il n\'y a pas encore d\'historique des pronostics</span>';
}
