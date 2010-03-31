<h2>Admin : création</h2>
<?php
require_once('lib/journee.php');

if(isset($_POST['submit_match'])) {
	require_once('lib/match.php');
	
	$journee = intval($_POST['journee']);
	$team1 = ucwords(clean_str($_POST['team1']));
	$team2 = ucwords(clean_str($_POST['team2']));
	
	if($team1 == '' || $team2 == '')
		echo '<span class="error">Vous devez donner un nom pour chaque équipe</span>';
	elseif(match_exists($journee, $team1, $team2))
		echo '<span class="error">Le match que vous voulez ajouter existe déjà</span>';
	else
		if(match_add($journee, $team1, $team2))
			echo '<span class="success">Match ajouté avec succès : <strong>'.$team1.' - '.$team2.'</strong></span>';
		else
			echo '<span class="error">Il y a eu une erreur lors de l\'ajout en base de données</span>';
}

if(isset($_POST['submit_journee'])) {
	if($_POST['numero'] == '' || $_POST['dateheure'] == '')
		echo '<span class="error">Pour ajouter une journée, il faut préciser le numéro et la date/heure du premier match</span>';
	else {
		$numero = intval($_POST['numero']);
		$timestamp = get_timestamp($_POST['dateheure'],'/');
		
		if($timestamp) {
			if(journee_exists('',$numero, $timestamp))
				echo '<span class="error">La journée que vous voulez ajouter existe déjà</span>';
			else
				if(journee_add($numero, $timestamp))
					echo '<span class="success">Journée ajoutée avec succès : <strong>Journée '.$numero.' ('.time_to_str($timestamp).')</strong></span>';
				else
					echo '<span class="error">Il y a eu une erreur lors de l\'ajout en base de données</span>';
		}
		else echo '<span class="error">Le format de la date entrée est invalide</span>';
	}
}

if(isset($_POST['submit_groupe'])) {
	require_once('lib/groupe.php');

	$nom = clean_str($_POST['nom']);
	
	if(groupe_exists($nom))
		echo '<span class="error">Un groupe portant le même nom existe déjà</span>';
	else
		if(groupe_add($nom))
			echo '<span class="success">Groupe ajouté avec succès : <strong>'.$nom.'</strong></span>';
		else
			echo '<span class="error">Il y a eu une erreur lors de l\'ajout en base de données</span>';
}

if(isset($_POST['submit_news'])) {
	require_once('lib/utils.php');
	require_once('lib/news.php');

	$idp = intval($_POST['idposteur']);
	$titre = clean_str($_POST['titre']);
	$contenu = clean_str_preserve_tags($_POST['contenu']);
	$image = isset($_POST['image']) ? clean_str($_POST['image']) : '';
	
	if($titre != '' && $contenu != '' && $idp != '') {
		if(news_add($titre, $contenu, $idp, $image)) {
			news_feed_rss();
			echo '<p class="success">News ajoutée avec succès</p>';
		}
		else
			echo '<p class="error">Il y a eu une erreur lors de l\'ajout en base de données</p>';
	}
	else
		echo '<p class="error">Il faut remplir tous les champs</p>';
}
else $contenu = '';

$journees_actives = journee_get_next($all = true);
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
		<option value=""></option>
		<?php
		for($i = 1 ; $i < 39 ; ++$i)
			echo '<option value="'.$i.'">'.$i.'&nbsp;&nbsp;&nbsp;</option>'."\n";
		?>
		</select>
		<br /><br />
		<label>Date/Heure premier match : </label>
		<input type="text" name="dateheure" id="dateheure" /><br /><br />
		<span class="smalltext">(jour/mois/annee/heure/minute ; 25/11/2009/20/30)</span>
	</p>
	<p>
		<input type="submit" name="submit_journee" id="submit_journee" value="Ajouter journée" />
	</p>	
</form>

<br /><!-- ------------------------------------- -->
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
	<p class="strong">Ajouter un groupe</p>
	<p>
		<label>Nom : </label>
		<input type="text" name="nom" id="nom" />
	</p>
	<p>
		<input type="submit" name="submit_groupe" id="submit_groupe" value="Ajouter groupe" />
	</p>	
</form>

<br /><!-- ------------------------------------- -->
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
	<p class="strong">Ajouter une news</p>
	<p>
		<input type="hidden" name="idposteur" value="<?php echo isset($_SESSION['id']) ? $_SESSION['id'] : '' ?>" />
		<label for="titre">Titre : </label><br />
		<input type="text" name="titre" id="titre" size="50" />
		<br /><br />
		<label>Contenu : </label><br />
		<textarea name="contenu" id="contenu" rows="10" cols="50"><?php echo $contenu; ?></textarea>
	</p>
	<p>
		<label for="image">Image : </label><br />
		<input type="text" name="image_dis" id="image_dis" disabled="disabled" size="30" />
		<input type="hidden" name="image" id="image" />
		&nbsp;<img src="images/icons/cross.png" alt="clear" id="clear_img_news" /><br /><br />
		<?php
		$xml = simplexml_load_file('resources/sprites_news.xml');
		$images = $xml->image;
        foreach($xml as $img) {
			echo '<div class="fleft sprite sprite-'.$img.'"></div>';
		}
		?>
		<div class="clear"></div>
		<br /><br /><span class="smalltext">Cliquez sur l'image que vous voulez utiliser pour la news</span>
	</p>
	<p>
		<input type="submit" name="submit_news" id="submit_news" value="Ajouter news" />
	</p>
</form>
