<h2>Admin : mises à jour</h2>
<?php
require_once('lib/journee.php');
require_once('lib/match.php');
require_once('lib/joueur.php');
require_once('lib/prono.php');
require_once('lib/groupe.php');


if(isset($_POST['submit_groupes'])) {
	$idg = intval($_POST['joueurs_g']);
	$new_groupes = clean_str($_POST['groupes']);
	
	if(joueur_update_groupes($idg, $new_groupes)) {
		$joueur = mysql_fetch_assoc(joueur_get($idg));
		echo '<span class="success">Les groupes de <strong>'.$joueur['pseudo'].'</strong> ont été modifiés avec succès</span>';
	}
	else
		echo '<span class="error">Il y a eu une erreur lors de la mise à jour en base de données</span>';
}

if(isset($_POST['submit_delj'])) {
	$idj = intval($_POST['joueurs_d']);
	$joueur = mysql_fetch_assoc(joueur_get($idj));
	
	if(joueur_delete($idj))
		echo '<span class="success">Le joueur <strong>'.$joueur['pseudo'].'</strong> a bien été supprimé</span>';
	else
		echo '<span class="error">Il y a eu une erreur lors de la suppression en base de données</span>';
}

if(isset($_POST['submit_delg'])) {
	$idg = intval($_POST['groupe']);
	$nom = groupe_get_name($idg);
	
	if(groupe_delete($idg))
		echo '<span class="success">Le groupe <strong>'.$nom.'</strong> a bien été supprimé</span>';
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
	<p class="strong">Modifier le/les groupe(s) d'un joueur</p>
	<p>
		Groupes :<br />
		<?php
		$groupes = groupe_get_all();
		while($groupe = mysql_fetch_assoc($groupes))
			echo '('.$groupe['id'].') '.$groupe['nom'].'<br />';
		?>
		<span class="smalltext">(IDs à séparer par des virgules)</span>
	</p>
	<p>
		<label>Joueur : </label>
		<?php
		$joueurs = joueur_get('all');
		echo '<select name="joueurs_g">';
		while($joueur = mysql_fetch_assoc($joueurs))
			echo '<option value="'.$joueur['id'].'">'.$joueur['pseudo'].'</option>';
		echo '</select>';
		?>
		<br /><br />
		<label>Nouveaux groupes : </label>
		<input type="text" name="groupes" id="groupes" />
	</p>
	<p>
		<input type="submit" name="submit_groupes" id="submit_groupes" value="Modifier" />
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
		<input type="submit" name="submit_delj" id="submit_delj" value="Supprimer" />
	</p>	
</form>

<br />
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
	<p class="strong">Supprimer groupe</p>
	<p>
		<label>Groupe : </label>
		<?php
		$groupes = groupe_get_all();
		echo '<select name="groupe">';
		while($groupe = mysql_fetch_assoc($groupes))
			echo '<option value="'.$groupe['id'].'">'.$groupe['nom'].'&nbsp;&nbsp;</option>';
		echo '</select>';
		?>
	</p>
	<p>
		<input type="submit" name="submit_delg" id="submit_delg" value="Supprimer" />
	</p>	
</form>

<br />
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
	<p class="strong">Supprimer match</p>
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
		<input type="submit" name="submit_delm" id="submit_delm" value="Supprimer" />
	</p>	
</form>

<br />
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
	<p class="strong">Supprimer journée</p>
	<p class="smalltext">(Tous les matchs liés à cette journée seront supprimés)</p>
	<p>
		<label>Journée du: </label>
		<?php
		$journees = journee_get_next($all = true);
		echo '<select name="journees">';
		while($journee = mysql_fetch_assoc($journees))
			echo '<option value="'.$journee['id'].'">'.time_to_str($journee['date']).'&nbsp;&nbsp;</option>';
		echo '</select>';
		?>
	</p>
	<p>
		<input type="submit" name="submit_deli" id="submit_deli" value="Supprimer" />
	</p>
</form>

<br />
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
	<p class="strong">Modifier heure de début de journée</p>
	<p>
		<label>Journée du: </label>
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
	<p class="strong">Regénérer le flux RSS</p>
	<p>
		<input type="submit" name="submit_rss" id="submit_rss" value="Générer RSS" />
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
