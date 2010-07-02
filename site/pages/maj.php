<h2>Admin : mises à jour</h2>
<?php
require_once('lib/journee.php');
require_once('lib/match.php');
require_once('lib/joueur.php');
require_once('lib/prono.php');
require_once('lib/groupe.php');

if(isset($_POST['submit_delj'])) {
	$idj = intval($_POST['joueurs_d']);
	$joueur = mysql_fetch_assoc(joueur_get($idj));
	
	if(joueur_delete($idj))
		echo '<span class="success">Le joueur <strong>'.$joueur['pseudo'].'</strong> a bien été supprimé</span>';
	else
		echo '<span class="error">Il y a eu une erreur lors de la suppression en base de données</span>';
}

if(isset($_POST['submit_delm'])) {
	$idm = intval($_POST['matchs']);
	
	if(match_delete($idm))
		echo '<span class="success">Le match a bien été supprimé</span>';
	else
		echo '<span class="error">Il y a eu une erreur lors de la suppression en base de données</span>';
}

if(isset($_POST['submit_deli'])) {
	$idj = intval($_POST['journees']);
	
	if(journee_delete($idj))
		echo '<span class="success">La journée a bien été supprimée</span>';
	else
		echo '<span class="error">Il y a eu une erreur lors de la suppression en base de données</span>';
}

if(isset($_POST['submit_modidj'])) {
	$idjour = $_POST['journees'];
	$idma = $_POST['matchs'];
	
	if(journee_exists($idjour) && match_id_exists($idma)) {
		if(prono_add($idma, $idjour))
			echo '<p class="success">Journée du match modifiée avec succès !</p>';
		else
			echo '<span class="error">Il y a eu une erreur lors de la modification en base de données</span>';
	}
	else
		echo '<p class="error">Impossible, vous avez fait n\'importe quoi avec les selects !</p>';
}

if(isset($_POST['submit_modt'])) {
	$idma = intval(intval($_POST['matchs']));
	$team1 = ucwords(clean_str(mysql_real_escape_string($_POST['team1'])));
	$team2 = ucwords(clean_str(mysql_real_escape_string($_POST['team2'])));
	$journee = match_get_journee($idma);

	if($team1 == '' || $team2 == '')
		echo '<span class="error">Vous devez donner un nom pour chaque équipe</span>';
	elseif(match_exists($journee, $team1, $team2))
		echo '<span class="error">Le match modifié existe déjà</span>';
	else
		if(match_update_teams($idma, $team1, $team2))
			echo '<span class="success">Match modifié avec succès : <strong>'.$team1.' - '.$team2.'</strong></span>';
		else
			echo '<span class="error">Il y a eu une erreur lors de la modification en base de données</span>';
}

if(isset($_POST['submit_modj'])) {
	if($_POST['journees'] == '' || $_POST['dateheure'] == '')
		echo '<span class="error">Pour mettre à jour une journée, il faut en choisir une dans la liste et préciser la date/heure du premier match</span>';
	else {
		$idj = intval($_POST['journees']);
		$timestamp = get_timestamp($_POST['dateheure'],'/');
		
		if($timestamp) {
			if(journee_update_date($idj,$timestamp))
				echo '<span class="success">La date de la journée a bien été mise à jour</span>';
			else
				echo '<span class="error">Il y a eu une erreur lors de la mise à jour en base de données</span>';
		}
		else echo '<span class="error">Le format de la date entrée est invalide</span>';
	}
}

if(isset($_POST['submit_rss'])) {
	require_once('lib/news.php');
	news_feed_rss();
	echo '<p class="success">Flux RSS regénéré avec succès</p>';
}

if(isset($_POST['submit_xml'])) {
	$file = clean_str($_POST['file']);
	$path = clean_str($_POST['path']);
	generate_sprite_xml($file,$path);
	echo '<p class="success">Fichier XML regénéré avec succès</p>';
}
?>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
	<p class="strong">Modifier la journée d'un match</p>
	<p>
		<label>Match : </label>
		<?php
		$matchs = match_get_allnext();
		echo '<select name="matchs">';
		while($match = mysql_fetch_assoc($matchs))
			echo '<option value="'.$match['id'].'">('.shortdate_to_str($match['numero']).') '.$match['equipe1'].' - '.$match['equipe2'].'&nbsp;&nbsp;</option>';
		echo '</select>';
		?>
	</p>
	<p>
		<label>Journée du : </label>
		<?php
		$journees = journee_get_next($all = true);
		echo '<select name="journees">';
		while($journee = mysql_fetch_assoc($journees))
			echo '<option value="'.$journee['id'].'">'.time_to_str($journee['date']).'&nbsp;&nbsp;</option>';
		echo '</select>';
		?>
	</p>
	<p>
		<input type="submit" name="submit_modidj" id="submit_modidj" value="Modifier" />
	</p>	
</form>

<br />
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
	<p class="strong">Modifier les équipes d'un match</p>
	<p>
		<label>Match : </label>
		<?php
		$matchs = match_get_allnext();
		echo '<select name="matchs">';
		while($match = mysql_fetch_assoc($matchs))
			echo '<option value="'.$match['id'].'">('.shortdate_to_str($match['numero']).') '.$match['equipe1'].' - '.$match['equipe2'].'&nbsp;&nbsp;</option>';
		echo '</select>';
		?>
	</p>	
	<p>
		<label>Equipes : </label>
		<input type="text" name="team1" id="team1" /> -
		<input type="text" name="team2" id="team2" />
	</p>
	<p>
		<input type="submit" name="submit_modt" id="submit_modt" value="Modifier" />
	</p>	
</form>

<br />
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
	<p class="strong">Modifier l'heure de début d'une journée</p>
	<p>
		<label>Journée du : </label>
		<?php
		$journees = journee_get_next($all = true);
		echo '<select name="journees">';
		while($journee = mysql_fetch_assoc($journees))
			echo '<option value="'.$journee['id'].'">'.time_to_str($journee['date']).'&nbsp;&nbsp;</option>';
		echo '</select>';
		?>
	</p>
	<p>
		<label>Date/Heure premier match : </label>
		<input type="text" name="dateheure" id="dateheure" />
	</p>
	<p>
		<input type="submit" name="submit_modj" id="submit_modj" value="Modifier" />
	</p>
</form>

<br />
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
	<p class="strong">Supprimer journée</p>
	<p class="smalltext">(Tous les matchs et les pronostics liés à cette journée seront supprimés)</p>
	<p>
		<label>Journée du : </label>
		<?php
		$journees = journee_get_next($all = true);
		echo '<select name="journees">';
		while($journee = mysql_fetch_assoc($journees))
			echo '<option value="'.$journee['id'].'">'.time_to_str($journee['date']).'&nbsp;&nbsp;</option>';
		echo '</select>';
		?>
	</p>
	<p>
		<input type="submit" name="submit_deli" id="submit_deli" value="Supprimer" class="need_confirm" />
	</p>
</form>

<br />
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
	<p class="strong">Supprimer match</p>
	<p class="smalltext">(Tous les pronostics liés à ce match seront supprimés)</p>
	<p>
		<label>Match : </label>
		<?php
		$matchs = match_get_allnext();
		echo '<select name="matchs">';
		while($match = mysql_fetch_assoc($matchs))
			echo '<option value="'.$match['id'].'">('.shortdate_to_str($match['numero']).') '.$match['equipe1'].' - '.$match['equipe2'].'&nbsp;&nbsp;</option>';
		echo '</select>';
		?>
	</p>
	<p>
		<input type="submit" name="submit_delm" id="submit_delm" value="Supprimer" class="need_confirm" />
	</p>	
</form>

<br />
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
	<p class="strong">Supprimer joueur</p>
	<p>
		<label>Joueur : </label>
		<?php
		$joueurs = joueur_get('all');
		echo '<select name="joueurs_d">';
		while($joueur = mysql_fetch_assoc($joueurs))
			echo '<option value="'.$joueur['id'].'">'.$joueur['pseudo'].'</option>';
		echo '</select>';
		?>
	</p>
	<p>
		<input type="submit" name="submit_delj" id="submit_delj" value="Supprimer" class="need_confirm" />
	</p>	
</form>

<br />
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
	<p class="strong">Regénérer un XML de sprites</p>
	<p>
		<label>Chemin du fichier XML : </label>
		<input type="text" name="file" id="file" value="resources/sprites_news.xml" size="30" />
	</p>
	<p>
		<label>Chemin des images : </label>
		<input type="text" name="path" id="path" value="images/news/*" size="30" />
	</p>
	<p>
		<input type="submit" name="submit_xml" id="submit_xml" value="Générer" />
	</p>
</form>

<br />
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
	<p class="strong">Regénérer le flux RSS</p>
	<p>
		<input type="submit" name="submit_rss" id="submit_rss" value="Générer RSS" />
	</p>
</form>
