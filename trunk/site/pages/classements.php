<?php
require_once('lib/joueur.php');
require_once('lib/groupe.php');

$groups = explode(',', $_SESSION['groups']);

if(isset($_GET['groupe'])) {
	$groupe = intval($_GET['groupe']);
	
	echo '<p>Afficher le classement : <strong><a href="?p=classements">Général</a></strong> ';
	foreach($groups as $group) {
		if($group != $groupe)
			echo '<strong><a href="?p=classements&groupe='.$group.'">'.groupe_get_name($group).'</a></strong> ';
	}
	echo '</p>';

	echo '<h2>Classement pour le groupe '.groupe_get_name($groupe).'</h2><br />';

	$classement = joueur_get_classement($groupe);
}
else {
	echo '<p>Afficher le classement : ';
	foreach($groups as $group) echo '<strong><a href="?p=classements&groupe='.$group.'">'.groupe_get_name($group).'</a></strong> ';
	echo '</p>';
	echo '<h2>Classement général</h2><br />';

	$classement = joueur_get_classement();
}

if(mysql_num_rows($classement)) {
	echo '<table class="table-contain"><th>Position</th><th>Pseudo</th><th>Points</th><th>Moyenne par journée</th>';
	
	for($i=1 ; $joueur = mysql_fetch_assoc($classement) ; ++$i) {
		$average = $joueur['journees'] == 0 ? 0 : round($joueur['points']/$joueur['journees'], 1);
		$position = $i == 1 || $joueur['points'] != $old_score ? $i : $old_position;
		
		echo '<tr>
		<td>'.$position.'</td>
		<td>'.$joueur['pseudo'].'</td>
		<td>'.$joueur['points'].'</td>
		<td>'.$average.'</td>		
		</tr>';
		
		$old_score = $joueur['points'];
		$old_position = $position;
	}
	
	echo '</table>';
}
else {
	echo '<p class="error">Il n\'y a aucun joueur dans le classement pour le moment</p>';
}
