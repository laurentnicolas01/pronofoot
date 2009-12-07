<div id="chatbox" class="colonne">
	<h2>Chatbox</h2>
	<?php if($_SESSION['is_connect']) { ?>
	
	<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
		<input type="hidden" name="idj" id="idj" value="<?php echo $_SESSION['id']*2; ?>" />
		<input type="text" name="message" id="message" />
		<input type="submit" name="submit_message" id="submit_message" value="Envoyer" />
	</form>
	
	<div id="selectnb">
		Afficher 
		<select name="nbmess" id="nbmess">
			<?php for($i=10;$i<51;$i+=10) echo '<option value='.$i.'>'.$i.'&nbsp</option>'; ?>
		</select> 
		messages <span id="chat_loading"></span>
	</div>
	
	<ul id="message_list"></ul>
	
	<?php } else echo '<p class="warning center">Déconnecté</span>'; ?>
</div>