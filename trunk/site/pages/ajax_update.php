<?php
/***************************/
/* AJAX UPDATE MESSAGES    */
/***************************/

function get_file($short_path) {
	return file_exists($short_path)	? $short_path : get_file('../'.$short_path);
}

require_once(get_file('lib/mysql.php'));
require_once(get_file('lib/message.php'));

sql_connect();

$nb = isset($_POST['nb']) ? intval($_POST['nb']) : 10;

$messages = message_get_list($nb);
while($message = mysql_fetch_assoc($messages))
	message_print($message['pseudo'], $message['date'], $message['texte']);
