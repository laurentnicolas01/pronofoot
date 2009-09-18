<?php
session_start();

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
		$email = clean_str($_POST['email']);
		$password = crypt_password($_POST['pass']);
	
		session_connect($email, $password);
	}
}
elseif(isset($_GET['deconnexion'])) {
	// demande de déconnexion
	session_destroy();
	$_SESSION['is_connect'] = false;
}

$idadmins = array(1,8);
$restricted = array('add','maj','scores');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
<head>
	<title><?php echo TITLE; ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="author" content="Julien Paroche, Arthur Foucher" />

	<!-- css -->
	<link rel="stylesheet" media="screen" type="text/css" href="css/style.css" />
	<link rel="stylesheet" media="screen" type="text/css" href="css/utils.css" />

	<!-- jquery libs - deployed -->
	<!--
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js" type="text/javascript"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.1/jquery-ui.min.js" type="text/javascript"></script>
	-->
	
	<!-- jquery libs - dev -->
	<script src="javascript/jquery-1.3.2.min.js" type="text/javascript"></script>
	<script src="javascript/jquery-ui-1.7.1.custom.min.js" type="text/javascript"></script>

	<script type="text/javascript" src="javascript/utils.js"></script>
	<script type="text/javascript" src="javascript/toolbar.js"></script>
	
	<!-- rss feed link -->
	<link rel="alternate" type="application/rss+xml" href="resources/xml/feed.xml" title="Adrénaline - Actualités" />
	
	<!-- website mini-icon -->
	<link rel="icon" href="images/icons/sport_soccer.png" type="image/png" />
</head>

<body>
	<div id="global">
		<div id="container">
			
			<?php require_once('includes/menu.php'); ?>
			
			<div id="content" class="colonne">
				<?php				
				$page = isset($_GET['p']) ? $_GET['p'] : 'accueil';
				$path = 'pages/'.$page.'.php';
				
				if(in_array($page, $restricted) && (!$_SESSION['is_connect'] || !in_array($_SESSION['id'], $idadmins))) {
					echo '<h1>Pronos Foot Arthur</h1><p class="error">Vous n\'êtes pas autorisé à consulter cette page</p>';
				}				
				elseif($page == 'accueil' || $page == 'contact' || ($page != 'accueil' && $_SESSION['is_connect'] && file_exists($path))) {
					echo '<h1>Pronos Foot Arthur - '.ucfirst($page).'</h1>';
					require_once($path);
				}
				elseif(!file_exists($path)) {
					echo '<h1>Pronos Foot Arthur</h1><p class="error">La page demandée n\'existe pas</p>';
				}
				else {
					echo '<h1>Pronos Foot Arthur</h1><p class="error">Vous n\'êtes pas autorisé à consulter cette page</p>';
				}
				?>
			</div>
			
		</div>
		
		<?php require_once('includes/footer.php'); ?>
	</div>
</body>
</html>
