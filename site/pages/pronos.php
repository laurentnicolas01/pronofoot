<?php
require_once('lib/journee.php');
require_once('lib/match.php');
require_once('lib/joueur.php');

$futures_journees = journee_get_next($all = true);
if(mysql_num_rows($futures_journees) > 1) {
	echo '<p>Journée : ';
	for($i = 1 ; $nextj = mysql_fetch_assoc($futures_journees) ; ++$i)
		echo '<strong><a href="?p=pronos&journee='.$nextj['id'].'">'.$nextj['numero'].'</a></strong> ';
	echo '<br /><br />';
}

if(isset($_GET['journee'])) {
	$idjournee = intval($_GET['journee']);
	if(!journee_exists($idjournee))
		echo '<span class="error">La journée demandée n\'existe pas</span>';
	elseif(!journee_has_match($idjournee))
		echo '<span class="error">Aucun match n\'est enregistré pour la journée demandée</span>';
	else {
		$journee = journee_get_by_id($idjournee);
		echo '<p class="strong">Pronostiquer pour la journée '.$journee['numero'].' du '.time_to_str($journee['date']).'</p>';
	}	
}
else {
	$journee = mysql_fetch_assoc(journee_get_next());
	$idjournee = $journee['id'];
	if(!journee_has_match($idjournee))
		echo '<span class="error">Aucun match n\'est enregistré pour la prochaine journée</span>';
	else
		echo '<p class="strong">Pronostiquer pour la journée '.$journee['numero'].' du '.time_to_str($journee['date']).'</p>';
}

$matchs = match_get_by_journee($idjournee);
if(mysql_num_rows($matchs)) {
?>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
	<?php
	
		while($match = mysql_fetch_assoc($matchs)) {
			echo '<p>'.$match['equipe1'].' - '.$match['equipe2'].'&nbsp;&nbsp;<input type="text" name="'.$match['id'].'" size="4" /></p>';
		}
	
	?>
	<br />
	<p>
		<input type="submit" name="submit_pronos" id="submit_pronos" value="Valider mes pronostics" />
	</p>	
</form>
<p style="font-size:10px;">Les scores doivent être au format "Score1-Score2" (exemples : 3-2, 1-0, 5-1...)</p>
<?php
}

