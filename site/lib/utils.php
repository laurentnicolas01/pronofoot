<?php

// fonctions utilitaires

require_once('constants.php');

// Définition du fuseau horaire 
date_default_timezone_set(TIMEZONE);


/**
 * Savoir si un chaîne contient une ou plusieurs expressions données
 * @param exp: les expressions recherchées separées par des 'ou' (par exemple 'exp1|exp2|exp3')
 * @param string: la chaîne à examiner
 * @return true si les expressions sont trouvées dans la chaîne, false sinon
 */
function contains($exp, $string)
{
	return preg_match('/'.$exp.'/i', $string);
}

/**
 * Génération d'un password aléatoire
 * @param size: la taille désirée pour le password (6 par défaut)
 * @return une chaîne de caractères composées de chiffres et lettres minuscules de N caractères (N = size)
 */
function generate_password($size = 6)
{
	return strtolower(substr(base64_encode(md5(rand())), 0, $size));
}

/**
 * Obtenir le lien 'réel' de la page précédente, quelque soit le contexte
 */
function get_previous_link()
{
	$tab = explode('/', $_SERVER['HTTP_REFERER']);
	$size = count($tab);
	return $tab[--$size];
}

/**
 * Nettoyer une chaîne de caractères issue d'un formulaire
 */
function clean_str($str)
{
	$str = htmlspecialchars(trim($str));
	if (get_magic_quotes_gpc()) {
		$str = stripslashes($str);
	}
	return $str;
}

/**
 * Variante qui laisse les tags HTML intactes
 */
function clean_str_preserve_tags($str)
{
	$str = trim($str);
	if (get_magic_quotes_gpc()) {
		$str = stripslashes($str);
	}
	return $str;
}

/**
 * Conversion d'un timestamp en chaîne de caractères
 * @param[in] timestamp: temps à convertir
 * @return 'JJ/MM/AAAA à HH:MM'
 */
function time_to_str($timestamp)
{
	return date('d/m/Y à H:i', $timestamp);
}

function date_to_str($timestamp)
{
	return date('d/m/Y', $timestamp);
}

/*
 * Retourne une chaîne représentant des octets dans l'unité adéquate
 */
function bytes_symbol($bytes)
{
    $symbols = array('octets', 'Kio', 'Mio', 'Gio', 'Tio', 'Pio', 'Eio', 'Zio', 'Yio');
    $exp = $bytes ? floor(log($bytes) / log(1024)) : 0;
    
    return sprintf('%.2f '.$symbols[$exp], $bytes / pow(1024, floor($exp)));
}

/**
 * Détermine si une adresse e-mail est valide
 * @return true si l'adresse est bonne, sinon false
 */
function valid_email($email)
{
	return preg_match('/^([\w._-]+@[a-z._-]+?\.[a-z]{2,4})$/i', $email);
}

/**
 * Détermine si un mot de passe est valide
 * @return true si le password est bon, false sinon
 */
function valid_pass($pass)
{
	return preg_match('/^([A-Za-z0-9._-]+){6,}$/',$pass);
}

/**
 * Détermine si un numéro de téléphone est valide (10 chiffres, commence par 0)
 */
function valid_phone($phonenumber)
{
	return preg_match('/^0[0-9]{9}$/', $phonenumber);
}

/**
 * Détermine si un code postal est valide (5 chiffres)
 */
function valid_postal_code($code)
{
	return preg_match('/^[0-9]{5}$/', $code);
}

/**
 * Détermine si une date est valide
 * @return true si date au format JJ/MM/AAAA
 */
function valid_date($date)
{
	return preg_match('/^[0-9]{2}\/[0-9]{2}\/[0-9]{4}$/', $date);
}

/**
 * Afficher un tableau sous form de liste
 */
function print_array($tab)
{
	echo '<ul class="list">';
	foreach ($tab as $item)
	{
		echo '<li>'.$item.'</li>';
	}
	echo '</ul>';
}

/**
 * Calculer l'age
 * @param birth_date: date de naissance au format JJ/MM/AAAA
 * @return age (entier)
 */
function get_age($birth_date)
{
	$current_day = intval(date('d'));
	$current_month = intval(date('m'));
	$current_year = intval(date('Y'));
	
	$birth_infos = explode('/', $birth_date);
	$birth_day = intval($birth_infos[0]);
	$birth_month = intval($birth_infos[1]);
	$birth_year = intval($birth_infos[2]);
	
	if ($current_month > $birth_month) {
		return $current_year - $birth_year;
	}
	if ($current_month < $birth_month) {
		return $current_year - $birth_year - 1;
	}
	return $current_year - $birth_year - ($current_day >= $birth_day ? 0 : 1);
}

/**
 * Fonction de récupération du chemin relatif vers un fichier
 * @param path: le chemin 'minimal' vers le fichier desiré
 * @return une chaine de caractères contenant le chemin vers le fichier
 */
function get_path($path)
{
	return file_exists($path) ? $path : get_path('../'.$path);
}

/**
 * Crypter un mot de passe (SHA1 inversé)
 */
function crypt_password($password)
{
	return invert_hash(sha1($password));
}

/**
 * Fonction d'inversion des caractères d'une chaine
 * @param hash: une chaine de caractères de longeur paire
 * @return la chaine avec les caractères inversés 2 à 2
 */
function invert_hash($hash)
{
	$inverted = "";
	$j = 0;
	for ($i=0 ; $i < strlen($hash) ; $i++) {
		$inverted .= substr($hash,$j+1,1);
		$inverted .= substr($hash,$j,1);
		$j += 2;
	}
	return $inverted;
}

function plural($name, $count)
{
	if ($name[strlen($name) - 1] != 's') {
		return $count > 1 ? $name.'s' : $name;
	}
	return $name;
}

function remove_updir($path)
{
	return str_replace('..', '.', $path);
}

/**
 * Affiche un en-tête de tableau $name d'une colonne de tri
 * La colonne a la classe "sorted" si $self_row est $sorted_row
 * Icône flèche bas si le tri est $is_desc, sinon flèche haut
 */
function print_sorted_th($name, $self_row, $sorted_row, $is_desc, $uri = NULL)
{
    $sorted = $self_row == $sorted_row;
    echo '<th';
    // si colonne de tri
    if ($sorted)
    {
        echo ' class="sorted"';
    }
    echo '>
        <a href="'.$_SERVER['PHP_SELF'].'?'.$uri.'&amp;sort='.$self_row;
    if (!$is_desc and $sorted)
    {
        // si le tri est ascendant, le lien propose le tri descendant
        // sinon, le tri est déjà ascendant par défaut dans le lien
        echo '&amp;desc';
    }
    echo '">'.$name.'  '; // fin <a>
    if (!$is_desc and $sorted)
    {
        // seule la colonne triée permet d'alterner ascendant/descendant
        // -> le seul cas on l'on affiche un lien de tri descendant est
        // lorsque le lien appartient à la colonne triée ET qu'elle n'est pas
        // déjà en desc
       echo '<img src="images/up.png" alt="^" />';
    }
    else
    {
        // les autres colonnes proposent toujours le tri ascendant par défaut
        echo '<img src="images/down.png" alt="v" />';
    }
    echo '</a>
        </th>';
}

/**
 * Ajouter un événement au fichier de logs
 * @return true si le log a réussi, false sinon
 */
function log_action($ip, $status, $name, $firstname, $mail, $query)
{
	$log_file = fopen(LOG, 'a+');
	if($log_file) {
		$query_elements = explode(' ', strtoupper($query));
		
		// Récupération de l'action
		$action = $query_elements[0];
		
		// Récupération de la table affectée
		if($query_elements[1] == 'INTO')
			$table = $query_elements[2];
		else {
			$pos = $query_elements[1] == 'FROM' ? 2 : 1;
			$table = explode("\t", $query_elements[$pos]);
			$table = substr($table[0], 0, -1);
		}
		
		$time = time_to_str(time());

		fputs($log_file, "* $ip $name $firstname ($mail) [$status] Action: $action, Table: $table ($time)\n");
		fclose($log_file);
		return true;
	}
	else return false;
}


/**
 * Générer un titre 'correct' pour le <title>
 * @param page, rubrique: les param page et rubrique du $_GET
 */
function generate_title($page, $rubrique)
{
	if($page == 'generique')
		return TITLE.' '.ucfirst($rubrique);	
	elseif($page != $rubrique) {
		$cleaned_rub = explode('_', $rubrique);
		$cleaned_rub = $cleaned_rub[0];
		return TITLE.' '.ucfirst($page).' '.ucfirst($cleaned_rub);
	}
	elseif($page == $rubrique && $page != 'club')
		return TITLE.' '.ucfirst($page);
	else
		return TITLE.' Accueil';
}


/**
 * Connecter un joueur
 * @param email: email servant de login
 * @param password: hash du mot de passe
 * @return true si connexion réussie, sinon false
 */
function session_connect($email, $password)
{
	$email = mysql_real_escape_string($email);
	
	$sql = 'SELECT id, email, pseudo
	        FROM joueur
	        WHERE email = "'.$email.'" AND pass = "'.$password.'";';
	
	$data = sql_query($sql);
	if($row = mysql_fetch_assoc($data)) {
		$_SESSION['is_connect'] = true;
		$_SESSION['id'] = intval($row['id']);
		$_SESSION['email'] = $row['email'];
		$_SESSION['pseudo'] = $row['pseudo'];
		return true;
	}
	$_SESSION['is_connect'] = false;
	return false;
}

