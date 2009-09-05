<?php
require_once('lib/journee.php');
require_once('lib/match.php');
require_once('lib/joueur.php');

if(isset($_POST['submit_match'])) {
	$journee = intval($_POST['journee']);
	$team1 = ucfirst(clean_str($_POST['team1']));
	$team2 = ucfirst(clean_str($_POST['team2']));
	
	if(match_exists($journee, $team1, $team2))
		echo '<span class="error">Le match que vous voulez ajouter existe déjà</span>';
	else
		if(match_add($journee, $team1, $team2))
			echo '<span class="success">Match ajouté avec succès : <strong>'.$team1.' - '.$team2.'</strong></span>';
		else
			echo '<span class="error">Il y a eu une erreur lors de l\'ajout en base de données</span>';
}

if(isset($_POST['submit_journee'])) {
	$numero = intval($_POST['numero']);
	$dh = explode('/',$_POST['dateheure']);
	$timestamp = mktime($dh[0],$dh[1],0,$dh[3],$dh[2],$dh[4]);
	
	if(journee_exists($numero, $timestamp))
		echo '<span class="error">La journée que vous voulez ajouter existe déjà</span>';
	else
		if(journee_add($numero, $timestamp))
			echo '<span class="success">Journée ajoutée avec succès : <strong>Journée '.$numero.' ('.time_to_str($timestamp).')</strong></span>';
		else
			echo '<span class="error">Il y a eu une erreur lors de l\'ajout en base de données</span>';
}

if(isset($_POST['submit_joueur'])) {
	$mail = clean_str($_POST['mail']);
	$pseudo = clean_str($_POST['pseudo']);
	$pass = clean_str($_POST['pass']);
	
	if(joueur_exists($mail))
		echo '<span class="error">Ce mail est déjà utilisé par un autre joueur</span>';
	elseif(!valid_email($mail))
		echo '<span class="error">Le mail saisi n\'est pas valide</span>';
	else
		if(joueur_add($mail, $pseudo, crypt_password($pass)))
			echo '<span class="success">Joueur ajouté avec succès : <strong>'.$pseudo.' ('.$mail.')</strong></span>';
		else
			echo '<span class="error">Il y a eu une erreur lors de l\'ajout en base de données</span>';
}

$journees_actives = journee_get_active();
?>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
	<p class="strong">Ajouter un match</p>
	<p>
		<label>Journée : </label>
		<?php
		if(mysql_num_rows($journees_actives)) {
			echo '<select name="journee">';
			while($journee = mysql_fetch_assoc($journees_actives))
				echo '<option value="'.$journee['id'].'">'.$journee['numero'].' ('.time_to_str($journee['date']).')&nbsp;</option>';
			echo '</select>';
		}
		?>
		<br /><br />
		<label>Equipes : </label>
		<input type="text" name="team1" id="team1" /> -
		<input type="text" name="team2" id="team2" />
	</p>
	<p>
		<input type="submit" name="submit_match" id="submit_match" value="Ajouter match" />
	</p>	
</form>

<br /><!-- ------------------------------------- -->
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
	<p class="strong">Ajouter une journée</p>
	<p>
		<label>Numéro : </label>
		<select name="numero">
		<?php
		for($id = 1 ; $i < 39 ; ++$i)
			echo '<option value="'.$i.'">'.$i.'&nbsp;&nbsp;&nbsp;</option>';
		?>
		</select>
		<br /><br />
		<label>Heure/Date premier match : </label>
		<input type="text" name="dateheure" id="dateheure" />
		<p>(heure/minute/jour/mois/annee ; 20/30/12/09/2009)</p>
	</p>
	<p>
		<input type="submit" name="submit_journee" id="submit_journee" value="Ajouter journée" />
	</p>	
</form>

<br /><!-- ------------------------------------- -->
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
	<p class="strong">Ajouter un joueur</p>
	<p>
		<label>Mail : </label><br />
		<input type="text" name="mail" id="mail" />
		<br /><br />
		<label>Pseudo : </label><br />
		<input type="text" name="pseudo" id="pseudo" />
		<br /><br />
		<label>Pass : </label><br />
		<input type="password" name="pass" id="pass" />
	</p>
	<p>
		<input type="submit" name="submit_joueur" id="submit_joueur" value="Ajouter joueur" />
	</p>	
</form>
