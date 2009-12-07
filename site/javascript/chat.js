$(function() {
	$('select#nbmess').change(function() {
		$('span#chat_loading').html('&nbsp<img src="images/ajax-loader.gif" alt="(loading)"');
	});

	$('#submit_message').click(function() {
		$('select#nbmess').change();
	
		var message = $('input#message').val(),
			id = $('input#idj').val() / 2;
		
		$.ajax({
			type: "POST",
			url: "lib/chat.php",
			data: "action=insert"
				+ "&id=" + id
				+ "&message=" + message,
			
			success: function(result) {
				result = result.split('&&&');
				if(result[0] == 'ok') {
					$('input#message').val('');
					$('ul#message_list').prepend(result[1]);
					$('span#chat_loading').html('');
				}
			}
		});
		
		return false;
	});
	
	function load(ul, nb) {
		$.ajax({
			type: "POST",
			url: "lib/chat.php",
			data: "action=update"
				+ "&nb=" + nb,
			
			success: function(result) {
				$(ul).html(result);
				$('span#chat_loading').html('');
			}
		});
	}
	
	// Nécéssite le plug-in "jquery timers"
	var ul = $('ul#message_list'), nb = $('select#nbmess').val();
	if(ul.is(':visible')) {
		load(ul, nb);
	
		$(ul).everyTime('10s', function() {
			load(ul, nb);
		}, 0);
	}
})
