<h2>Mes pronostics</h2>
<?php
require_once('lib/journee.php');
require_once('lib/match.php');
require_once('lib/joueur.php');
require_once('lib/prono.php');

$futures_journees = journee_get_next($all = true);
if(mysql_num_rows($futures_journees) > 1) {
	echo '<p id="myplistj">Journée : ';
	while($nextj = mysql_fetch_assoc($futures_journees))
		echo '<strong><a href="mypronos-'.$nextj['id'].'" class="ui-state-default">'.$nextj['numero'].'</a></strong> ';
	echo '<br />';
}

if(isset($_GET['journee'])) {
	$idjournee = intval($_GET['journee']);
	if(!journee_exists($idjournee))
		echo '<span class="error">La journée demandée n\'existe pas</span>';
	elseif(!journee_has_match($idjournee))
		echo '<span class="error">Aucun match n\'est enregistré pour la journée demandée</span>';
	elseif(journee_locked($idjournee))
		echo '<span class="error">Les pronostics sont fermés pour la journée demandée</span>';
	else {
		$journee = journee_get_by_id($idjournee);
		echo '<p class="strong">Mes pronostics pour la '.display_number($journee['numero']).' journée (premier match le '.time_to_str($journee['date']).')</p>';
	}
}
else {
	$journee = mysql_fetch_assoc(journee_get_next());
	$idjournee = $journee['id'];
	if(!journee_has_match($idjournee))
		echo '<span class="error">Aucun match n\'est enregistré pour la prochaine journée</span>';
	else
		echo '<p class="strong">Mes pronostics pour la '.display_number($journee['numero']).' journée (premier match le '.time_to_str($journee['date']).')</p>';
}

if(isset($_POST['submit_pronos'])) {
	$display = array('error' => '', 'success' => '');
	foreach($_POST as $key => $score) {
		$name = explode('_',$key);
		if($name[0] == 'match' && $score != '') {
			$idm = intval($name[1]);
			if(journee_of_match_is_locked($idm)) {
				$display['error'] = '<span class="warning">N\'essayez pas de tricher, les pronostics sont fermés pour cette journée</span>';
			}
			else if(valid_score($score)) {
				if(prono_exists($idm, $_SESSION['id']))
					prono_update($idm, $_SESSION['id'], $score);
				else
					prono_record($idm, $_SESSION['id'], $score);
					
				$display['success'] = '<span class="success">Les scores correctement écrits ont été enregistrés et/ou mis à jour !</span>';
			}
			else
				$display['error'] = '<span class="error">Un ou plusieurs scores n\'ont pas été enregistrés car la syntaxe était incorrecte</span>';
		}
	}
	echo $display['success'];
	echo $display['error'];
}



$matchs = match_get_by_journee($idjournee);
if(mysql_num_rows($matchs) && !journee_locked($idjournee)) {
?>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
	<?php
	while($match = mysql_fetch_assoc($matchs)) {
		$value = prono_exists($match['id'], $_SESSION['id']) ? prono_get_score($match['id'], $_SESSION['id']) : '';
		echo '<p><input type="text" name="match_'.$match['id'].'" value="'.$value.'" size="4" />&nbsp;&nbsp;'.$match['equipe1'].' - '.$match['equipe2'].'</p>';
	}
	?>
	<br />
	<p>
		<input type="submit" name="submit_pronos" id="submit_pronos" value="Valider mes pronostics" />
	</p>	
</form>
<p class="smalltext">
Note :<br />
Les scores doivent être au format "Score1-Score2" (exemples : 3-2, 0-1, 5-1...)<br />
Vous n'êtes pas obligé de tout remplir en une fois.<br />
Vous pouvez modifier vos pronostics tant que le premier match de la journée n'a pas commencé.
</p>
<?php
}

