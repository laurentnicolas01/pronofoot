<?php
require_once('lib/sondage.php');
/******************/
/* RETRIEVE DATAS
/******************/
$ids = isset($_GET['s']) ? $_GET['s'] : 0;
$sdg = mysql_fetch_assoc(sondage_get_by_id($ids));
$idsondage = $sdg['id'];
$question = $sdg['question'];
$reponses = explode(',', $sdg['reponse_set']);
/******************/
/* CONSTS
/******************/
$idj = intval($_SESSION['id']);
$chk = 'checked="checked"';
$dis = 'disabled="disabled"';
$old_rep = sondage_reponse_joueur($idsondage, $idj);
$already_done = $old_rep != '';

/******************/
if(isset($_POST['submit_sondage']) && isset($_POST['choix']) && !$already_done) {
	$rep = clean_str($_POST['choix'][0]);
	if($rep != 'autre' && in_array($rep, $reponses)) {
		if(sondage_rec_rep($idsondage, $idj, $rep)) {
			echo '<p class="success">Merci d\'avoir voté !</p>';
			$old_rep = $rep;
			$already_done = true;
		}
		else echo '<p class="error">Problème à l\'enregistrement, veuillez rééssayer</p>';
	}
	elseif($rep == 'autre' && $_POST['autre_rep'] != '' && in_array($rep, $reponses)) {
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
	
echo '<p class="strong">Question :<br />'.$question.'</p>';
?>

<form method="post" action="<?php echo $_SERVER['REQUEST_URI'] ?>">
	<?php
	foreach($reponses as $reponse) {
		$status = $already_done && $old_rep == $reponse ? $chk.' '.$dis : ($already_done ? $dis : '');
		echo '<p><input type="radio" name="choix[]" value="'.$reponse.'" '.$status.' />&nbsp;&nbsp;<label>'.ucfirst($reponse).'</label>';
		echo $reponse == 'autre' ? ' : <input type="test" name="autre_rep" value="" '.$status.' /></p>' : '</p>';
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