<?php
require_once('lib/joueur.php');
require_once('lib/groupe.php');

$avg = isset($_GET['sort']) && $_GET['sort'] == 'avg';
$sorted_row = $avg ? 'avg' : 'points';
$is_asc = isset($_GET['asc']) ? true : false;
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
	
	$classement = joueur_get_classement($groupe,$sorted_row,$is_asc);
	$uri = 'p=classements&groupe='.$groupe;
}
else {
	echo '<p>Afficher le classement : ';
	foreach($groups as $group) echo '<strong><a href="?p=classements&groupe='.$group.'">'.groupe_get_name($group).'</a></strong> ';
	echo '</p>';
	echo '<h2>Classement général</h2><br />';

	$classement = joueur_get_classement(0,$sorted_row,$is_asc);
	$uri = 'p=classements';
}

if(mysql_num_rows($classement)) {	
	echo '<table class="table-contain"><th>Position</th><th>Pseudo</th><th>Journées</th>';
	print_sorted_th('Points', 'points', $sorted_row, $is_asc, $uri);
	print_sorted_th('Moyenne', 'avg', $sorted_row, $is_asc, $uri);
	
	for($i=1 ; $joueur = mysql_fetch_assoc($classement) ; ++$i) {
		if($avg)
			$position = $i == 1 || $joueur['avg'] != $old_value ? $i : $old_position;
		else
			$position = $i == 1 || $joueur['points'] != $old_value ? $i : $old_position;
		
		echo '<tr>
		<td>'.$position.'</td>
		<td>'.$joueur['pseudo'].'</td>
		<td>'.$joueur['journees'].'</td>
		<td>'.$joueur['points'].'</td>
		<td>'.round($joueur['avg'], 1).'</td>
		</tr>';
		
		$old_value = $avg ? $joueur['avg'] : $joueur['points'];
		$old_position = $position;
	}
	
	echo '</table>';
}
else {
	echo '<p class="error">Il n\'y a aucun joueur dans le classement pour le moment</p>';
}
