<?php
require_once('lib/journee.php');
require_once('lib/match.php');
require_once('lib/joueur.php');
require_once('lib/prono.php');
require_once('lib/groupe.php');

if(isset($_POST['submit_pass'])) {
	$id = intval($_POST['joueurs_e']);
	$pass = clean_str($_POST['pass']);
	
	if(joueur_update_pass($id, crypt_password($pass))) {
		$joueur = mysql_fetch_assoc(joueur_get($id));
		echo '<span class="success">Le pass de <strong>'.$joueur['pseudo'].'</strong> a été modifié avec succès</span>';
	}
	else
		echo '<span class="error">Il y a eu une erreur lors de la mise à jour en base de données</span>';
}

if(isset($_POST['submit_delj'])) {
	$id = intval($_POST['joueurs_d']);
	$joueur = mysql_fetch_assoc(joueur_get($id));
	
	if(joueur_delete($id))
		echo '<span class="success">Le joueur <strong>'.$joueur['pseudo'].'</strong> a bien été supprimé</span>';
	else
		echo '<span class="error">Il y a eu une erreur lors de la suppression en base de données</span>';
}

if(isset($_POST['submit_delg'])) {
	$id = intval($_POST['groupe']);
	$nom = groupe_get_name($id);
	
	if(groupe_delete($id))
		echo '<span class="success">Le groupe <strong>'.$nom.'</strong> a bien été supprimé</span>';
	else
		echo '<span class="error">Il y a eu une erreur lors de la suppression en base de données</span>';
}

if(isset($_POST['submit_delm'])) {
	$id = intval($_POST['matchs']);
	
	if(match_delete($id))
		echo '<span class="success">Le match a bien été supprimé</span>';
	else
		echo '<span class="error">Il y a eu une erreur lors de la suppression en base de données</span>';
}

if(isset($_POST['submit_deli'])) {
	$id = intval($_POST['journees']);
	
	if(journee_delete($id))
		echo '<span class="success">La journée a bien été supprimée</span>';
	else
		echo '<span class="error">Il y a eu une erreur lors de la suppression en base de données</span>';
}

if(isset($_POST['submit_maj'])) {
	$datas = journee_get_last_unterminated();
	if(mysql_num_rows($datas)) {
		$id = '';
		$nbpoints = 0;
		while($row = mysql_fetch_assoc($datas)) {
			if($id != '' && $id != $row['idjoueur']) {
				// mise à jour des points et du nombre de journées jouées de chaque pronostiqueur
				joueur_update_points($id, $nbpoints);
				joueur_update_nbjournee($id);
				
				echo joueur_get_pseudo($id).' : +'.$nbpoints.' point(s)<br />';
				$idjournee = $row['idjournee'];
				$numjournee = $row['numero'];
				$nbpoints = 0;
				$nbpoints += calculate_prono_result($row['score_joueur'], $row['score_match']);
			}
			else {
				$nbpoints += calculate_prono_result($row['score_joueur'], $row['score_match']);
			}
			$id = $row['idjoueur'];
		}
		joueur_update_points($id, $nbpoints);
		joueur_update_nbjournee($id);
		echo joueur_get_pseudo($id).' : +'.$nbpoints.' point(s)<br /><br />';
		
		if(journee_terminate($idjournee))
			echo '<span class="success">Mise à jour effectuée : '.display_number($numjournee).' journée</span>';
		else
			echo '<span class="error">Une erreur s\'est produite, contactez le webmaster avant de faire une autre action</span>';
	}
	else
		echo '<span class="error">Nothing to update ! Did you forget to update scores ? If not, please call an admin ;)</span>';
}
?>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
	<p class="strong">Modifier pass joueur</p>
	<p>
		<label>Joueur : </label>
		<?php
		$joueurs = joueur_get('all');
		echo '<select name="joueurs_e">';
		while($joueur = mysql_fetch_assoc($joueurs))
			echo '<option value="'.$joueur['id'].'">'.$joueur['pseudo'].'</option>';
		echo '</select>';
		?>
		<br /><br />
		<label>Nouveau pass : </label>
		<input type="password" name="pass" id="pass" />
	</p>
	<p>
		<input type="submit" name="submit_pass" id="submit_pass" value="Modifier" />
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
			echo '<option value="'.$match['id'].'">(J'.$match['numero'].') '.$match['equipe1'].' - '.$match['equipe2'].'&nbsp;&nbsp;</option>';
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
		<label>Journée : </label>
		<?php
		$journees = journee_get_next($all = true);
		echo '<select name="journees">';
		while($journee = mysql_fetch_assoc($journees))
			echo '<option value="'.$journee['id'].'">'.$journee['numero'].' ('.time_to_str($journee['date']).')&nbsp;&nbsp;</option>';
		echo '</select>';
		?>
	</p>
	<p>
		<input type="submit" name="submit_deli" id="submit_deli" value="Supprimer" />
	</p>	
</form>

<br />
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
	<p class="strong">Mettre à jour les points des joueurs et le classement</p>
	<span class="warning">Les scores de la dernière journée doivent être saisis</span>
	<p>
		<input type="submit" name="submit_maj" id="submit_maj" value="Mise à jour" />
	</p>	
</form>

