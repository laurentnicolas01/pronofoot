<?php
require_once('lib/joueur.php');
require_once('lib/groupe.php');

$avg = isset($_GET['sort']) && $_GET['sort'] == 'avg';
$sorted_row = $avg ? 'avg' : 'points';
$is_asc = isset($_GET['asc']) ? true : false;
$groups = groupe_get_list($_SESSION['groups']);

if(isset($_GET['groupe'])) {
	$groupe = intval($_GET['groupe']);
	
	echo '<p>Afficher le classement : <strong><a href="classements" class="ui-state-default">Général</a></strong> ';
	while($group = mysql_fetch_assoc($groups)) {
		if($group['id'] != $groupe)
			echo '<strong><a href="classements-'.$group['id'].'" class="ui-state-default">'.$group['nom'].'</a></strong> ';
	}
	echo '</p>';

	echo '<h3>Classement pour le groupe '.groupe_get_name($groupe).'</h3>';
	
	$classement = joueur_get_classement($groupe,$sorted_row,$is_asc);
	$uri = 'classements-'.$groupe;
}
else {
	echo '<p>Afficher le classement : ';
	while($group = mysql_fetch_assoc($groups)) echo '<strong><a href="classements-'.$group['id'].'" class="ui-state-default">'.$group['nom'].'</a></strong> ';
	echo '</p>';
	echo '<h3>Classement général</h3>';

	$classement = joueur_get_classement(0,$sorted_row,$is_asc);
	$uri = 'classements';
}

if(mysql_num_rows($classement)) {
	echo '<table class="table-contain"><thead class="ui-state-default"><th>Position</th><th>Pseudo</th><th>Matchs</th>';
	print_sorted_th('Points', 'points', $sorted_row, $is_asc, $uri);
	print_sorted_th('Moyenne', 'avg', $sorted_row, $is_asc, $uri);
	echo '</thead>';
	
	for($i=1 ; $joueur = mysql_fetch_assoc($classement) ; ++$i) {
		if($avg)
			$position = $i == 1 || $joueur['avg'] != $old_value ? $i : $old_position;
		else
			$position = $i == 1 || $joueur['points'] != $old_value ? $i : $old_position;
		
		echo '<tr>
		<td>'.$position.'</td>
		<td>'.$joueur['pseudo'].'</td>
		<td>'.$joueur['nbmatchs'].'</td>
		<td>'.$joueur['points'].'</td>
		<td>'.$joueur['avg'].'</td>
		</tr>';
		
		$old_value = $avg ? $joueur['avg'] : $joueur['points'];
		$old_position = $position;
	}
	
	echo '</table>';
}
else {
	echo '<p class="error">Il n\'y a aucun joueur dans le classement pour le moment</p>';
}
