<?php // @TODO : gérer le cas "autre reponse"
require_once('lib/sondage.php');
/**************/
/* GLOBALS
/**************/
$idsondage = 'classement_segmente';
$question = <<<EOT
Serait-il intéressant d'afficher dans le classement général seulement
les membres qui font parti d'au moins un même groupe que moi ? (pour segmenter les classements
dans le cas où il y aurait beaucoup plus de joueurs)
EOT;
$reponses = array('oui','non');
/**************/
/* CONSTS
/**************/
$idj = intval($_SESSION['id']);
$chk = 'checked="checked"';
$dis = 'disabled="disabled"';
$old_rep = sondage_reponse_joueur($idsondage, $idj);
$already_done = $old_rep != '';

/**************/
if(isset($_POST['submit_sondage']) && !$already_done) {
	$rep = clean_str($_POST['choix'][0]);
	if(in_array($rep, $reponses)) {
		if(sondage_rec_rep($idsondage, $idj, $rep)) {
			echo '<p class="success">Merci d\'avoir voté !</p>';
			$old_rep = $rep;
			$already_done = true;
		}
		else echo '<p class="error">Problème à l\'enregistrement, veuillez rééssayer</p>';
	}
	else
		echo '<p class="error">Choix erroné, veuillez rééssayer</p>';
}
elseif(isset($_POST['submit_sondage']) && $already_done)
	echo '<p class="error">Vous avez déjà voté pour ce sondage</p>';
	
echo '<p class="strong">Question :<br />'.$question.'</p>';
?>

<form method="post" action="<?php echo $_SERVER['REQUEST_URI'] ?>">
	<?php
	foreach($reponses as $reponse) {
		$status = $already_done && $old_rep == $reponse ? $chk.' '.$dis : ($already_done ? $dis : '');
		echo '<p><input type="radio" name="choix[]" value="'.$reponse.'" '.$status.' />&nbsp;&nbsp;<label>'.ucfirst($reponse).'</label></p>';
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