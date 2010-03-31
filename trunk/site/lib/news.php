<?php

/*
Gestion de la table news

*/

require_once('constants.php');
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
	$titre = mysql_real_escape_string($titre);
	$contenu = mysql_real_escape_string($contenu);
	$image = $image != '' ? mysql_real_escape_string($image) : 'bulle.png';
	$date = time();
	
	$sql = "INSERT INTO news(date,titre,contenu,image,idjoueur)
			VALUES($date,'$titre','$contenu','$image',$idjoueur);";
			
	return sql_query($sql);
}

function news_make_results($idjournee) {
	$num = mysql_fetch_row(sql_query("SELECT numero FROM journee WHERE id = $idjournee LIMIT 1;"));
	$c = 'Pour cette journée, les résultats sont les suivants :<br /> ';
	$resultats = joueur_get_resultset($idjournee);
	while($res = mysql_fetch_assoc($resultats))
		$c .= joueur_get_stringscore($res['pseudo'],$res['points']).', ';
	return news_add('Résultats de la '.display_number($num[0]).' journée',substr($c,0,strlen($c)-2),1);
}

/**
 * Générer le flux RSS des dernières news de la 1ère page
 */
function get_flux($short_path) {
	return file_exists($short_path)	&& substr_count($short_path, '..') < 50 ? $short_path : get_file('../'.$short_path);
}
function news_feed_rss() {
        $rss = fopen(get_flux(FLUX_RSS), 'w');
        if($rss) {
                fputs($rss, '<?xml version="1.0" encoding="utf-8" ?>'."\n");
                fputs($rss, '<rss version="2.0">'."\n");
                fputs($rss, "\t<channel>\n");
                fputs($rss, "\t\t<title>Prono Foot</title>\n");
                fputs($rss, "\t\t<link>".WEBLINK."</link>\n");
                fputs($rss, "\t\t<description>Les dernières news</description>\n");
                fputs($rss, "\t\t<lastBuildDate>".date('r', time())."</lastBuildDate>\n");
                fputs($rss, "\t\t<language>fr</language>\n");
                
                $image = "
                <image>
                        <title>Prono Foot - News</title>
                        <url>".WEBLINK."/images/rss_ballon.png</url>
                        <link>".WEBLINK."</link>
                        <width>64</width>
                        <height>64</height>
                </image>\n";
                
                fputs($rss, $image);
                
                $rec = news_get(0,10);
                while($row = mysql_fetch_assoc($rec)) {
                        fputs($rss, "\t\t<item>\n");
                        fputs($rss, "\t\t\t<title>".$row['titre']."</title>\n");
                        fputs($rss, "\t\t\t<link>".WEBLINK."/accueil</link>\n");
                        fputs($rss, "\t\t\t<description>".html_entity_decode(strip_tags($row['contenu']), ENT_QUOTES, 'UTF-8')."</description>\n");
                        fputs($rss, "\t\t\t<pubDate>".date('r', $row['date'])."</pubDate>\n");
                        fputs($rss, "\t\t</item>\n");
                }
                fputs($rss, "\t</channel>\n");
                fputs($rss, "</rss>\n");
                fclose($rss);
        }
}
