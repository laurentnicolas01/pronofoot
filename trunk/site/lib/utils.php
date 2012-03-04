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
 * Obtenir la valeur du premier paramètre d'une URL
 * @param uri: l'url à analyser au format /folder/folder/../param1-param2-param3
 * @return la valeur du premier paramètre. "/site/pronos-4-asc" retourne "pronos"
 */
function get_pageval($uri) {
	$uri = explode('/', $uri);
	$uri = $uri[sizeOf($uri)-1];
	if(contains('-', $uri)) {
		$uri = explode('-', $uri);
		return $uri[0];
	}
	else
		return $uri;
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
 * Retour le lien avec l'id "current" s'il correspond à la page active
 */
function show_link($link, $name)
{
	echo '<a href="'.$link.'"';	
	if (isset($_SERVER['REDIRECT_URL']) && $link == basename($_SERVER['REDIRECT_URL'])) {
		echo' id="current"';
	}
	echo '>'.$name.'</a>';
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
 * @return 'jj/mm/aaaa à HH:MM'
 */
function std_time_to_str($timestamp)
{
	return date('d/m/Y à H:i', $timestamp);
}

/**
 * @return 'jj/mm HH:MM'
 */
function time_to_str($timestamp)
{
	return date('d/m  H:i', $timestamp);
}

/**
 * @return 'jj/mm/aaaa'
 */
function date_to_str($timestamp)
{
	return date('d/m/Y', $timestamp);
}
/**
 * @return 'jj/mm'
 */
function shortdate_to_str($timestamp)
{
	return date('d/m', $timestamp);
}
/**
 * @return 'HH:MM'
 */
function shorttime_to_str($timestamp)
{
	return date('H:i', $timestamp);
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
 * Détermine si un score de match est correct (type x-y)
 */
function valid_score($score)
{
	return preg_match('/^[0-9]{1}-[0-9]{1}$/', $score);
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

function pourcent($nb, $total) {
	$result = round($nb/$total,2)*100;
	return $result.'%';
}

function remove_updir($path)
{
	return str_replace('..', '.', $path);
}

/**
 * Affiche un en-tête de tableau $name d'une colonne de tri
 * La colonne a la classe "sorted" si $self_row est $sorted_row
 * Icône flèche bas si le tri est $is_asc, sinon flèche haut
 */
function print_sorted_th($name, $self_row, $sorted_row, $is_asc, $uri = NULL)
{
    $sorted = $self_row == $sorted_row;
    echo '<th';
    // si colonne de tri
    if ($sorted)
    {
        echo ' class="ui-state-active"';
    }
    echo '>
        <a href="'.$uri.'-'.$self_row;
    if (!$is_asc and $sorted)
    {
        // si le tri est ascendant, le lien propose le tri descendant
        // sinon, le tri est déjà ascendant par défaut dans le lien
        echo '-asc';
    }
    echo '">'.$name.'  '; // fin <a>
    if (!$is_asc and $sorted)
    {
        // seule la colonne triée permet d'alterner ascendant/descendant
        // -> le seul cas on l'on affiche un lien de tri descendant est
        // lorsque le lien appartient à la colonne triée ET qu'elle n'est pas
        // déjà en desc
       echo '<img src="images/bullet_arrow_down.png" alt="^" />';
    }
    else
    {
        // les autres colonnes proposent toujours le tri ascendant par défaut
        echo '<img src="images/bullet_arrow_up.png" alt="v" />';
    }
    echo '</a>
        </th>';
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
 * Connecter une session
 * @param login: email ou pseudo servant de login
 * @param password: hash du mot de passe
 * @return true si connexion réussie, sinon false
 */
function session_connect($login, $password)
{
	require_once('groupe.php');

	$login = mysql_real_escape_string($login);
	
	$sql = 'SELECT id, email, pseudo
	        FROM joueur
	        WHERE (email = "'.$login.'" OR pseudo = "'.$login.'")
			AND pass = "'.$password.'";';
	
	$data = sql_query($sql);
	if($row = mysql_fetch_assoc($data)) {
		$_SESSION['is_connect'] = true;
		$_SESSION['id'] = intval($row['id']);
		$_SESSION['email'] = $row['email'];
		$_SESSION['pseudo'] = $row['pseudo'];
		$_SESSION['groups'] = groupe_get_string_by_idjoueur(intval($row['id']));
		return true;
	}
	$_SESSION['is_connect'] = false;
	return false;
}


/**
 * Afficher un nombre au format 1er / 1ère / 3ème / 23ème...
 * @param number: le nombre à afficher
 * @param gender: f ou m, se rapporte à quelque chose de féminin/masculin
 */
function display_number($number, $gender = 'f') {
	if($number == 1)
		return $gender == 'f' ? '1ère' : '1er';
	else
		return $number.'ème';
}


/**
 * Calculer le nombre de points obtenu pour un pronostic
 * @param score_j: le score que le joueur a pronostiqué
 * @param score_m: le score du match
 * @return le nombre de points résultant du pronostic (0, 1 ou 3)
 */
function calculate_prono_result($score_j, $score_m) {
	$temp = array_merge(explode('-',$score_j),explode('-',$score_m));
	$j = array('left' => $temp[0], 'right' => $temp[1]);
	$m = array('left' => $temp[2], 'right' => $temp[3]);
	
	if($score_j == $score_m)
		return 3;
	elseif(($j['left'] > $j['right'] && $m['left'] > $m['right'])
		|| ($j['left'] < $j['right'] && $m['left'] < $m['right'])
		|| ($j['left'] == $j['right'] && $m['left'] == $m['right']))
		return 1;
	else
		return 0;
}


/**
 * Envoie d'un mail
 * @param s: l'email de l'expéditeur
 * @param r: l'email du destinataire
 * @param n: la chaine qui sera affichée pour l'expéditeur (ex: Prenom Nom)
 * @param o: l'objet de l'email qui sera envoyé
 * @param message: le message à envoyer à l'équipe adrénaline
 * @return true si le mail a bien été envoyé, false sinon
 */
function send_mail($s, $r, $n, $o, $m)
{
	// préparation envoyeur et destinataire
	$contact = $n;
	$sender = $s;
	$receiver = $r;
	
	// en-têtes
	$headers  = 'MIME-Version: 1.0'."\n";
    $headers .= 'From: "'.$contact.'"<'.$sender.'>'."\n";
    $headers .= 'Reply-To: '.$sender."\n";
    $headers .= 'Content-Type: text/plain; charset="utf-8"'."\n";
    $headers .= 'Content-Transfer-Encoding: 8bit';
	
	// preparation de l'objet
	$object = $o;
	
	// préparation du contenu du mail
	$content  = $m;
	
	// envoi du mail et retour du résultat (true ou false)
	return mail($receiver, $object, $content, $headers);
}


/**
 * Permet d'obtenir un timestamp à partir d'une chaine qui contient jour/mois/annee/heure/minute
 * @param string : la chaine contenant les infos
 * @param sep : le caractère séparateur des infos ('/' dans l'exemple ci-dessus)
 * @return le timestamp correspondant à la chaine
 */
function get_timestamp($string, $sep) {
	if(!preg_match('/^([0-9]{2}\/){2}([0-9]{4}\/){1}([0-9]{2}\/[0-9]{2})$/', $string)) return 0;
	$dh = explode($sep,$string);
	return mktime($dh[3],$dh[4],0,$dh[1],$dh[0],$dh[2]);
}


/**
 * Génère un fichier XML listant toutes les images d'un dossier
 * @param path: le chemin du dossier
 */
function generate_sprite_xml($file,$path) {
        $xml = fopen($file, 'w');
        if($xml) {
                fputs($xml, '<?xml version="1.0" encoding="utf-8" ?>'."\n");
                fputs($xml, "<image_list>\n");
				
				$images = glob($path);
				foreach($images as $img) {
					$name = substr(basename($img), 0, strlen(basename($img))-4);
					fputs($xml, "\t<image>$name</image>\n");
				}
				
                fputs($xml, "</image_list>\n");
                fclose($xml);
		}
}

/**
 * Transformer le nom d'une equipe en ses initiales
 * @param string: le nom de lequipe
 * @return les initiales
 */
function team_shortname($team) {
	$team_init = $team;
	
	switch($team) {
		case 'Toulouse':
			$team_init = 'TFC';
			break;
		
		case 'Saint-Etienne':
			$team_init = 'ASSE';
			break;
		
		case 'Auxerre':
			$team_init = 'AJA';
			break;
		
		case 'Caen':
			$team_init = 'SMC';
			break;
		
		case 'Nice':
			$team_init = 'OGCN';
			break;
		
		case 'Bordeaux':
			$team_init = 'FCGB';
			break;
		
		case 'Paris':
			$team_init = 'PSG';
			break;
		
		case 'Arles-Avignon':
			$team_init = 'ACA';
			break;
		
		case 'Rennes':
			$team_init = 'SRFC';
			break;
		
		case 'Sochaux':
			$team_init = 'FCSM';
			break;
		
		case 'Montpellier':
			$team_init = 'MHSC';
			break;
		
		case 'Nancy':
			$team_init = 'ASNL';
			break;
		
		case 'Marseille':
			$team_init = 'OM';
			break;
		
		case 'Monaco':
			$team_init = 'ASM';
			break;
		
		case 'Brest':
			$team_init = 'SB29';
			break;
		
		case 'Lorient':
			$team_init = 'FCL';
			break;
		
		case 'Lens':
			$team_init = 'RCL';
			break;
		
		case 'Lille':
			$team_init = 'LOSC';
			break;
		
		case 'Lyon':
			$team_init = 'OL';
			break;
		
		case 'Valenciennes':
			$team_init = 'VAFC';
			break;
	}
	
	return $team_init;
}

function clean_lequipe_teamname($teamname) {
	$removable_pieces = array('&nbsp;', '(1)', '(2)', '(3)', '(4)', '(5)', '(6)', '(7)', '(8)', '(9)', '(10)', '(11)', '(12)', '(13)', '(14)', '(15)', '(16)', '(17)', '(18)', '(19)', '(20)');
	$cleaned_teamname = str_replace($removable_pieces, '', $teamname);
	return trim($cleaned_teamname);
}
