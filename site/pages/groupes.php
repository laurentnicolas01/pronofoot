<h2>Admin : gestion des groupes</h2>
<?php
require_once('lib/groupe.php');

// Ajout joueur/groupe
if(isset($_POST['submit_selj'])) {
	$idj = intval($_POST['joueur']);
	if(joueur_id_exists($idj)) {
		$selected_pseudo = joueur_get_pseudo($idj);
		$idj_sel = $idj;
	}
}
else {
	$selected_pseudo = '';
}

if(isset($_POST['submit_addjg'])) {
	$idj = intval($_POST['joueur_id']);
	$idg = intval($_POST['groupe']);
	
	if(joueur_id_exists($idj) && groupe_id_exists($idg) && !groupe_adhesion_exists($idg, $idj)) {
		if(groupe_add_joueur($idg, $idj))
			echo '<span class="success">Joueur ajouté au groupe avec succès !</span>';
		else
			echo '<p class="error">Il y a eu une erreur lors de l\'ajout en base de données</p>';
	}
	else {
		echo '<p class="error">Erreurs dans les inputs !</p>';
	}
}

// Suppression joueur/groupe
if(isset($_POST['submit_selj2'])) {
	$idj = intval($_POST['joueur']);
	if(joueur_id_exists($idj)) {
		$selected_pseudo2 = joueur_get_pseudo($idj);
		$idj_sel2 = $idj;
	}
}
else {
	$selected_pseudo2 = '';
}

if(isset($_POST['submit_deljg'])) {
	$idj = intval($_POST['joueur_id']);
	$idg = intval($_POST['groupe']);
	
	if(joueur_id_exists($idj) && groupe_id_exists($idg) && groupe_adhesion_exists($idg, $idj)) {
		if(groupe_remove_joueur($idg, $idj))
			echo '<span class="success">Joueur supprimé du groupe avec succès !</span>';
		else
			echo '<p class="error">Il y a eu une erreur lors de l\'ajout en base de données</p>';
	}
	else {
		echo '<p class="error">Erreurs dans les inputs !</p>';
	}
}

// Ajout groupe
if(isset($_POST['submit_groupe'])) {
	require_once('lib/groupe.php');

	$nom = clean_str($_POST['nom']);
	
	if(groupe_exists($nom))
		echo '<span class="error">Un groupe portant le même nom existe déjà</span>';
	else if($nom == '')
		echo '<span class="error">Impossible de mettre un nom vide</span>';
	else
		if(groupe_add($nom))
			echo '<span class="success">Groupe ajouté avec succès : <strong>'.$nom.'</strong></span>';
		else
			echo '<span class="error">Il y a eu une erreur lors de l\'ajout en base de données</span>';
}

// Suppression groupe
if(isset($_POST['submit_delg'])) {
	$idg = intval($_POST['groupe']);
	$nom = groupe_get_name($idg);
	
	if(groupe_delete($idg))
		echo '<span class="success">Le groupe <strong>'.$nom.'</strong> a bien été supprimé</span>';
	else
		echo '<span class="error">Il y a eu une erreur lors de la suppression en base de données</span>';
}
?>
<p class="strong">Liste des groupes existants</p>
<?php
$groupes = groupe_get_all();
if(mysql_num_rows($groupes)) {
	for($i = 1 ; $groupe = mysql_fetch_row($groupes) ; ++$i)
		echo $i < mysql_num_rows($groupes) ? $groupe[1].', ' : $groupe[1];
}
else {
	echo '<span class="warning">Il n\'y a aucun groupe pour le moment</span>';
}
?>

<br /><br />
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
	<p class="strong">Ajouter un joueur à un groupe</p>
	<p>
		<label>Joueur : </label>
		<?php
		$joueurs = joueur_get('all');
		$dis = isset($idj_sel) ? 'disabled="disabled"' : '';
		echo '<select name="joueur" '.$dis.'>';
		while($joueur = mysql_fetch_assoc($joueurs)) {
			$status = $selected_pseudo == $joueur['pseudo'] ? 'selected="selected"' : '';
			echo '<option value="'.$joueur['id'].'" '.$status.'>'.$joueur['pseudo'].'</option>';
		}
		echo '</select>';
		?>
	</p>
	<?php if(isset($idj_sel)) { ?>
	<p>
		<input type="hidden" name="joueur_id" id="joueur_id" value="<?php echo $idj_sel; ?>" />
	</p>
	<p>
		<label>Groupes disponibles : </label>
		<?php
		$groupes = groupe_get_by_idjoueur($idj_sel, false);
		echo '<select name="groupe">';
		while($groupe = mysql_fetch_assoc($groupes))
			echo '<option value="'.$groupe['id'].'">'.$groupe['nom'].'&nbsp;&nbsp;</option>';
		echo '</select>';
		?>
	</p>
	<p>
		<input type="submit" name="submit_addjg" id="submit_addjg" value="Ajouter" />&nbsp;&nbsp;
		<input type="submit" name="submit_canjg" id="submit_canjg" value="Annuler" />	
	</p>
	<?php } else { ?>
	<p>
		<input type="submit" name="submit_selj" id="submit_selj" value="Selectionner" />&nbsp;&nbsp;
	</p>
	<?php } ?>
</form>

<br />
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
	<p class="strong">Supprimer un joueur d'un groupe</p>
	<p>
		<label>Joueur : </label>
		<?php
		$joueurs = joueur_get('all');
		$dis = isset($idj_sel2) ? 'disabled="disabled"' : '';
		echo '<select name="joueur" '.$dis.'>';
		while($joueur = mysql_fetch_assoc($joueurs)) {
			$status = $selected_pseudo2 == $joueur['pseudo'] ? 'selected="selected"' : '';
			echo '<option value="'.$joueur['id'].'" '.$status.'>'.$joueur['pseudo'].'</option>';
		}
		echo '</select>';
		?>
	</p>
	<?php if(isset($idj_sel2)) { ?>
	<p>
		<input type="hidden" name="joueur_id" id="joueur_id" value="<?php echo $idj_sel2; ?>" />
	</p>
	<p>
		<label>Groupes du joueur : </label>
		<?php
		$groupes = groupe_get_by_idjoueur($idj_sel2, true);
		echo '<select name="groupe">';
		while($groupe = mysql_fetch_assoc($groupes))
			echo '<option value="'.$groupe['id'].'">'.$groupe['nom'].'&nbsp;&nbsp;</option>';
		echo '</select>';
		?>
	</p>
	<p>
		<input type="submit" name="submit_deljg" id="submit_deljg" value="Supprimer" class="need_confirm" />&nbsp;&nbsp;
		<input type="submit" name="submit_candeljg" id="submit_candeljg" value="Annuler" />
	</p>
	<?php } else { ?>
	<p>
		<input type="submit" name="submit_selj2" id="submit_selj2" value="Selectionner" />&nbsp;&nbsp;
	</p>
	<?php } ?>
</form>

<br />
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

<br />
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
	<p class="strong">Supprimer groupe</p>
	<p class="smalltext">(Toutes les adhésions à ce groupe seront supprimées)</p>
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
		<input type="submit" name="submit_delg" id="submit_delg" value="Supprimer" class="need_confirm" />
	</p>	
</form>
