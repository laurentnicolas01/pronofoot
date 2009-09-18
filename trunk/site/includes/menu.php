<div id="menu" class="colonne">
	<h2>Menu</h2>
	<ul class="listmenu">
		<li><a href="/pronofoot">Accueil</a></li>
		<?php 
		if($_SESSION['is_connect']) { ?>
			<li><a href="?p=mypronos">Mes pronos</a></li>
			<li><a href="?p=pronos">Tous les pronos</a></li>
			<li><a href="?p=classements">Classements</a></li>
			
				<?php 
				if(in_array($_SESSION['id'], $idadmins)) { ?>
				<li><a href="?p=add">Création</a></li>
				<li><a href="?p=maj">Mises à jour</a></li>
				<li><a href="?p=scores">Saisie scores</a></li><?php
				}
				?>
			
			<li><a href="?deconnexion" class="last">Déconnexion</a></li><?php
		} ?>
	</ul>
</div>
