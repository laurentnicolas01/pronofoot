<?php if($_SESSION['is_connect']) { ?>
	<p id="submess">
		<input type="hidden" name="idj" id="idj" value="<?php echo $_SESSION['id']*2; ?>" />
		<input type="text" name="message" id="message" class="ui-widget-content ui-corner-all" />
		<a href="javascript:void();" id="submit_message"><img src="images/icons/add.png" alt="Envoyer" /></a>
		<span id="chat_loading"></span>
	</p>
	
	<p id="selectnb">
		Afficher 
		<select name="nbmess" id="nbmess" class="ui-widget-content">
			<?php for($i=10;$i<100;$i+=20) echo '<option value='.$i.'>'.$i.'&nbsp&nbsp</option>'; ?>
		</select> 
		derniers messages
	</p>	
<?php } ?>

<div id="message_list"><?php include_once('pages/ajax_update.php'); ?></div>
