<?php

/*
Gestion de la table news

*/

require_once('joueur.php');

/**
 * Retourne un set de news en permettant la pagination
 * @param nbstart: début de la séléction
 * @param nb: nombre de news souhaité
 * @example: news_get(13,4) renvoie les news 13 à 16
 */
function news_get($nbstart,$nb) {
	$sql = "SELECT image,titre,date,contenu
			FROM news
			ORDER BY date DESC
			LIMIT $nbstart,$nb;";
			
	return sql_query($sql);
}

function news_count() {
	$sql = "SELECT count(*)
			FROM news;";
	
	$result = mysql_fetch_row(sql_query($sql));
	return $result[0];
}

function news_add($titre, $contenu, $idjoueur, $image = 'reload.png') {
	$date = time();
	$sql = "INSERT INTO news(date,titre,contenu,image,idjoueur)
			VALUES($date,'$titre','$contenu','$image',$idjoueur);";
			
	return sql_query($sql);
}

function news_make_results($idjournee) {
	$num = mysql_fetch_row(sql_query("SELECT numero FROM journee WHERE id = $idjournee LIMIT 1;"));
	$c = "Pour cette journée, les résultats sont les suivants :<br />";
	$resultats = joueur_get_resultset($idjournee);
	while($res = mysql_fetch_assoc($resultats))
		$c .= joueur_get_stringscore($res['pseudo'],$res['points']).', ';
	return news_add('Résultats de la '.display_number($num[0]).' journée',substr($c,0,strlen($c)-2),1);
}

