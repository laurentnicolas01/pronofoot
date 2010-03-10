<?php if($_SESSION['is_connect']) { $is_hidden = ''; ?>
	<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
	<p id="inputmess">
		<input type="hidden" name="idj" id="idj" value="<?php echo $_SESSION['id']*2; ?>" />
		<input type="text" name="message" id="message" class="ui-widget-content ui-corner-all" />
		<input type="submit" id="hidden_submit" class="ui-helper-hidden" />
		<a href="javascript:;" id="submit_message"><img src="images/icons/add.png" alt="Envoyer" /></a>
		<span id="chat_loading"></span>
	</p>
	</form>
<?php } else { $is_hidden = ' class="ui-helper-hidden"'; } ?>

<p id="selectnb"<?php echo $is_hidden; ?>>
	Afficher 
	<select name="nbmess" id="nbmess" class="ui-widget-content">
		<?php for($i=10;$i<100;$i+=20) echo '<option value="'.$i.'">'.$i.'&nbsp;</option>'; ?>
		<option value="0">tous&nbsp;</option>
	</select> 
	messages
</p>

<div id="message_list"><?php $_REQUEST['action'] = 'message_update'; include_once('pages/ajax.php'); ?></div>
