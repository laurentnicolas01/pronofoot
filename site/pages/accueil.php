<?php
if(!$_SESSION['is_connect']) { ?>
	<div class="bienvenue">
	<img src="images/accueil_ballon.png" alt="Pronostics de Football !" />
	<p>Bienvenue sur le site de pronostics pour le "big five" de la ligue 1 !</p>
	</div>
	<p class="go acc_dec clear">Il faut se connecter dans l'espace membre pour accéder aux fonctionnalités du site</p>
	<p class="go acc_dec">Si vous n'avez pas de compte et que vous voulez en créer un, <a href="inscription">cliquez ici</a></p>
	<p class="go acc_dec">Si vous avez un problème ou juste besoin de contacter un admin, <a href="contact">cliquez ici</a></p>
	<?php
}
else {
	// News
	require_once('lib/news.php');
	$page = isset($_GET['numpage']) ? $_GET['numpage'] : 1;
	$news = news_get($page*4-4,4);
	

	while($row = mysql_fetch_assoc($news))
		echo '<div class="news">
				<img src="images/news/'.$row['image'].'" alt="News" />
				<p class="title"><span class="title">'.$row['titre'].'</span><br /><span class="date">'.time_to_str($row['date']).'</span></p><p class="content verdana">'.$row['contenu'].'</p>
			</div>';
			
	if($page > 1)
		echo '<a href="accueil-'.($page-1).'" class="fleft"><img src="images/icons/arrow_left.png" alt="< " /></a>';
	if(news_count()/4 > $page)
		echo '<a href="accueil-'.($page+1).'" class="fright"><img src="images/icons/arrow_right.png" alt=" >" /></a>';
	
}

