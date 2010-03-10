<?php
require_once('lib/sondage.php');
/******************/
/* RETRIEVE DATAS
/******************/
$ids = isset($_GET['s']) ? $_GET['s'] : 0;
$sdg = mysql_fetch_assoc(sondage_get_by_id($ids));
$idsondage = $sdg['id'];
$question = $sdg['question'];
$choices = explode(',', $sdg['reponse_set']);
$answers = sondage_get_numanswers($ids);
/******************/
/* CONSTS
/******************/
$idj = intval($_SESSION['id']);
$chk = 'checked="checked"';
$dis = 'disabled="disabled"';
$old_rep = sondage_reponse_joueur($idsondage, $idj);
$already_done = $old_rep != '';
$nbanswers = 0;
/******************/
/* ANSWERS
/******************/
$i = 0; $nbfield = 0; $nbanswers = 0;
if(mysql_num_rows($answers)) {
	$nbfield = mysql_num_fields($answers);
	$column = mysql_fetch_row($answers);
}
echo '<div id="answers" class="fright"><p class="strong">Réponses</p><table>';
foreach($choices as $choice) {
	echo '<tr id="rep_'.($i+1).'"><td>'.ucfirst($choice).'</td><td>&nbsp;&nbsp;&nbsp;'.$column[$i].'</td></tr>';
	$nbanswers += $column[$i];
	++$i;
}
echo '</table></div>';

/******************/
if(isset($_POST['submit_sondage']) && isset($_POST['choix']) && !$already_done) {
	$rep = clean_str($_POST['choix'][0]);
	if($rep != 'autre' && in_array($rep, $choices)) {
		if(sondage_rec_rep($idsondage, $idj, $rep)) {
			echo '<p class="success">Merci d\'avoir voté !</p>';
			$old_rep = $rep;
			$already_done = true;
		}
		else echo '<p class="error">Problème à l\'enregistrement, veuillez rééssayer</p>';
	}
	elseif($rep == 'autre' && $_POST['autre_rep'] != '' && in_array($rep, $choices)) {
		$autre_rep = clean_str($_POST['autre_rep']);
		if(sondage_rec_rep($idsondage, $idj, $rep, $autre_rep)) {
			echo '<p class="success">Merci d\'avoir voté !</p>';
			$old_rep = $rep;
			$already_done = true;
		}
		else echo '<p class="error">Problème à l\'enregistrement, veuillez rééssayer</p>';
	}
	else
		echo '<p class="error">Choix erroné, veuillez rééssayer</p>';
}
elseif(isset($_POST['submit_sondage']) && !isset($_POST['choix']))
	echo '<p class="warning">Vous devez séléctionner une des réponses proposées</p>';
elseif(isset($_POST['submit_sondage']) && $already_done)
	echo '<p class="error">Vous avez déjà voté pour ce sondage</p>';
elseif($already_done)
	echo '<span class="info">Vous avez déjà voté pour ce sondage</span>';
	
echo '<p id="question" class="strong justify">Question :<br />'.$question.'</p>';
?>

<form method="post" action="<?php echo $_SERVER['REQUEST_URI'] ?>">
	<?php
	foreach($choices as $choice) {
		$status = $already_done && $old_rep == $choice ? $chk.' '.$dis : ($already_done ? $dis : '');
		echo '<p><input type="radio" name="choix[]" value="'.$choice.'" '.$status.' />&nbsp;&nbsp;<label>'.ucfirst($choice).'</label>';
		echo $choice == 'autre' ? ' : <input type="text" name="autre_rep" value="" '.$status.' /></p>' : '</p>';
	}
	?>
	<p>
		<input type="submit" name="submit_sondage" id="submit_sondage" value="Valider" <?php if($already_done) echo $dis; ?> />
	</p>
</form>
<p>
Vous ne pouvez répondre qu'une fois et le choix n'est plus modifiable après validation.
Si toutefois vous deviez changer ou ajouter un commentaire, vous pouvez <a href="contact">nous contacter</a>.
</p>