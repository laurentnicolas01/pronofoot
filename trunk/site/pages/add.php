<h2>Admin : création</h2>
<?php
require_once('lib/journee.php');

if(isset($_POST['submit_match'])) {
	require_once('lib/match.php');
	
	$journee = intval($_POST['journee']);
	$team1 = ucwords(clean_str(mysql_real_escape_string($_POST['team1'])));
	$team2 = ucwords(clean_str(mysql_real_escape_string($_POST['team2'])));
	
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

if(isset($_POST['submit_prono'])) {
	$idjoue = intval($_POST['joueur']);
	$idma = intval($_POST['match']);
	$score = clean_str(mysql_real_escape_string($_POST['pronoj']));
	
	if(valid_score($score) && joueur_id_exists($idjoue) && match_id_exists($idma) && !prono_exists($idma, $idjoue)) {
		if(prono_record($idma, $idjoue, $score))
			echo '<p class="success">Pronostic ajouté avec succès !</p>';
		else
			echo '<span class="error">Il y a eu une erreur lors de la modification en base de données</span>';
	}
	else
		echo '<p class="error">Impossible, vous avez fait n\'importe quoi avec les inputs !</p>';
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
			$journee = array();
			for($i = mysql_num_rows($journees_actives) ; $tmpj = mysql_fetch_assoc($journees_actives) ; --$i) {
				$journee[$i-1]['id'] = $tmpj['id'];
				$journee[$i-1]['numero'] = $tmpj['numero'];
				$journee[$i-1]['date'] = $tmpj['date'];
			}
			echo '<select name="journee">';
			for($i = 0 ; $i < count($journee) ; ++$i)
				echo '<option value="'.$journee[$i]['id'].'">'.$journee[$i]['numero'].' ('.time_to_str($journee[$i]['date']).')&nbsp;</option>';
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
	<p class="strong">Ajouter un pronostic pour un joueur</p>
	<p>
		<label>Joueur : </label>
		<?php
		$joueurs = joueur_get('all');
		echo '<select name="joueur">';
		while($joueur = mysql_fetch_assoc($joueurs))
			echo '<option value="'.$joueur['id'].'">'.$joueur['pseudo'].'</option>';
		echo '</select>';
		?>
	</p>
	<p>
		<label>Match : </label>
		<?php
		$matchs = journee_get_waiting_results();
		if(mysql_num_rows($matchs)) {
			echo '<select name="match">';
			while($match = mysql_fetch_assoc($matchs))
				echo '<option value="'.$match['idmatch'].'">('.shortdate_to_str($match['numero']).') '.$match['equipe1'].' - '.$match['equipe2'].'&nbsp;&nbsp;</option>';
			echo '</select>';
		}
		?>
	</p>
	<p>
		<label>Score : </label>
		<input type="text" name="pronoj" id="pronoj" />
	</p>
	<p>
		<input type="submit" name="submit_prono" id="submit_prono" value="Ajouter pronostic" />
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
        $images = glob('images/news/*');
        foreach($images as $img) {
            echo '<img src="'.$img.'" alt="'.basename($img).'" class="add_img_news" />';
        }
		?>
		<div class="clear"></div>
		<br /><br /><span class="smalltext">Cliquez sur l'image que vous voulez utiliser pour la news</span>
	</p>
	<p>
		<input type="submit" name="submit_news" id="submit_news" value="Ajouter news" />
	</p>
</form>
