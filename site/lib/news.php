<?php

/*
Gestion de la table news

*/

function news_get_all($nb) {
	$sql = "SELECT *
			FROM news
			ORDER BY date DESC
			LIMIT $nb;";
			
	return sql_query($sql);
}

