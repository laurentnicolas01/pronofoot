<?php

// identifiants MySQL
define('SQL_HOST', 'localhost');
define('SQL_USER', 'root');
define('SQL_PASS', '');
define('SQL_NAME', 'pronofoot');


/**
 * Connexion au serveur MySQL et sélection de la base de données
 */
function sql_connect()
{
	mysql_connect(SQL_HOST, SQL_USER, SQL_PASS) or die(mysql_error());
	mysql_select_db(SQL_NAME) or die(mysql_error());
	mysql_query('SET CHARACTER SET utf8');
}


/**
 * Effectuer une reqûete SQL (die si erreur)
 * Enregistre une ligne dans le fichier de log si besoin
 */
function sql_query($query)
{
	$handle = mysql_query($query) or die('MySQL query error : '.mysql_error().'<br /><br />'.nl2br($query));
	return $handle;
}

