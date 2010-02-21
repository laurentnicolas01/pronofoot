<?php
if(!$_SESSION['is_connect']) { ?>
	<p>Bienvenue sur le site de pronostics pour le "big five" de la ligue 1 !</p>
	<p>Veuillez vous connecter pour accéder aux fonctionnalités du site</p>
	<p>Si vous n'avez pas de compte et que vous voulez en créer un, <a href="inscription">cliquez ici</a></p>
	<p>Si vous avez un compte et que vous avez un problème, <a href="contact">cliquez ici</a></p>
	<br /><?php
}
else {
	// News
	require_once('lib/news.php');
	$news = news_get_all(5);
	while($row = mysql_fetch_assoc($news))
		echo '<div class="news">
				<img src="images/news/'.$row['image'].'" alt="Img News" />
				<p class="title"><span class="title">'.$row['titre'].'</span><br /><span class="date">'.time_to_str($row['date']).'</span></p><p class="content">'.$row['contenu'].'</p>
			</div>';
}
?>

