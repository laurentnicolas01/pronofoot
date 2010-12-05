<?php
echo '<h2>Actualiés</h2><p class="ystar"><a href="reglement">Le règlement du jeu est disponible ici</a></p><p class="rss"><a href="'.FLUX_RSS.'">Abonnez vous au flux RSS</a></p>';
// Ligne avec asterisk à DELETE en fin de CDM

require_once('lib/news.php');
$numpage = isset($_GET['numpage']) ? $_GET['numpage'] : 1;
$nbnews = news_count();

if($numpage > ceil($nbnews/4)) { echo '<p class="error">La page de news demandée n\'existe pas</p>'; return; }

$news = news_get($numpage*4-4,4);

while($row = mysql_fetch_assoc($news))
	echo '<div class="news">
			<img src="images/news/'.$row['image'].'" alt="News" />
			<p class="title"><span class="title">'.$row['titre'].'</span><br /><span class="date">'.time_to_str($row['date']).'</span></p><p class="content verdana">'.$row['contenu'].'</p>
		</div>';
		
if($numpage > 1)
	echo '<a href="'.$page.'-'.($numpage-1).'" class="fleft"><img src="images/icons/arrow_left.png" alt="< " /></a>';
if($nbnews/4 > $numpage)
	echo '<a href="'.$page.'-'.($numpage+1).'" class="fright"><img src="images/icons/arrow_right.png" alt=" >" /></a>';
