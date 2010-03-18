<?php
session_start();

// Tampon qui intercepte tous les output jusqu'à ob_end_flush
ob_start();

require_once('lib/constants.php');
error_reporting(E_ALL | E_STRICT);

// Définition du fuseau horaire
date_default_timezone_set(TIMEZONE);

require_once('lib/utils.php');
require_once('lib/mysql.php');
require_once('lib/joueur.php');

// connexion à la BDD
sql_connect();

// session de l'utilisateur
if(!isset($_SESSION['is_connect'])) {
	$_SESSION['is_connect'] = false;
}

if(!$_SESSION['is_connect']) {
	// connexion depuis le formulaire
	if(isset($_POST['submit-connection'])) {
		$email = clean_str($_POST['log_email']);
		$password = crypt_password($_POST['pass']);
	
		session_connect($email, $password);
	}
}
elseif(isset($_GET['deconnexion'])) {
	// demande de déconnexion
	if(isset($_SESSION['id'])) {
		$deco_id = intval($_SESSION['id']);
		joueur_set_offline($deco_id);
	}
	session_destroy();
	$_SESSION['is_connect'] = false;
}

$idadmins = array(1,8);
$restricted = array('add','maj','scores','mailing','demandes');
$authorized = array('accueil','contact','inscription','password');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
<head>
	<title><?php echo TITLE; ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="author" content="Julien P." />
	<meta name="robots" content="noindex, nofollow" />

	<!-- css -->
	<link rel="stylesheet" media="screen" type="text/css" href="css/style.css" />
	
	<!-- website mini-icon -->
	<link rel="icon" href="images/icons/sport_soccer.png" type="image/png" />
</head>
<body>
	<div id="title">
		<h1 class="ui-helper-hidden">pronofoot.julienp.fr</h1>
		<a href="/"><img src="images/ban-weblink.png" alt="pronofoot.julienp.fr" /></a>
	</div>
	<div id="global">
		<!-- head -->
		<div id="ban"></div>
		<div id="menu" class="ui-widget ui-widget-header">
			<input id="href" type="hidden" value="<?php echo get_pageval($_SERVER['REQUEST_URI']); ?>" />
			<?php include_once('includes/menu.php'); ?>
		</div>
		
		<!-- middle -->
		<div id="content">
			<?php				
			$page = isset($_GET['p']) ? $_GET['p'] : 'accueil';
			$path = 'pages/'.$page.'.php';
			
			if(in_array($page, $authorized))
				require_once($path);
			elseif(in_array($page, $restricted) && (!$_SESSION['is_connect'] || !in_array($_SESSION['id'], $idadmins)))
				echo '<p class="error">Vous n\'êtes pas autorisé à consulter cette page</p>';				
			elseif(($_SESSION['is_connect'] && file_exists($path)))
				require_once($path);
			elseif(!file_exists($path))
				echo '<p class="error">La page demandée n\'existe pas</p>';
			else
				echo '<p class="error">Vous n\'êtes pas autorisé à consulter cette page</p>';
			?>
		</div>
		<div id="member" class="ui-dialog ui-widget ui-widget-content ui-corner-all">
			<div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">Membre</div>
			<div class="ui-dialog-content ui-widget-content">
				<?php include_once('includes/member.php'); ?>
			</div>
		</div>
		<div id="chatbox" class="ui-dialog ui-widget ui-widget-content ui-corner-all">
			<div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">Chatbox</div>
			<div class="ui-dialog-content ui-widget-content">
				<?php include_once('includes/chatbox.php'); ?>
			</div>
		</div>
		
		<!-- bottom -->
		<!-- <div id="pub">adsense</div> -->
		<div id="footer" class="ui-widget-header">
			<?php 
				include_once('includes/footer.php');
				ob_end_flush(); // Envoie sur la sortie le contenu du tampon et le vide
			?>
		</div>
	</div>
	
	<!-- jQuery Libs - deployed -->
	<script src="http://www.google.com/jsapi" type="text/javascript"></script>
	<script type="text/javascript">
		google.load('jquery', '1.4.2');
	</script>
	
	<!-- jQuery Libs - dev -->
	<!--
	<script src="javascript/jquery-1.4.2.min.js" type="text/javascript"></script>
	<script src="javascript/jquery-ui-1.8.min.js" type="text/javascript"></script>
	-->
	
	<!-- jQuery add-ons & perso -->
	<script type="text/javascript" src="javascript/jquery.timers-1.2.js"></script>
	<script type="text/javascript" src="javascript/myjs.js"></script>
	
	<!-- Stats Google
	<script type="text/javascript" src="javascript/google-analytics.js"></script> -->
</body>
</html>
