$(function() {
	$('#submit_message').click(function() {
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
				}
			}
		});
		
		return false;
	});
	
	$('select#nbmess').change(function() {
		$('span#chat_loading').html('&nbsp<img src="images/ajax-loader.gif" alt="(loading)"');
	});
})

function update() {
	$(function() {
		var nb,
			select = $('select#nbmess');
			
		if(select.is(':visible')) {
			nb = select.val();
			
			$.ajax({
				type: "POST",
				url: "lib/chat.php",
				data: "action=update"
					+ "&nb=" + nb,
				
				success: function(result) {
					$('ul#message_list').html(result);
					$('span#chat_loading').html('');
				}
			});
		}
	})
	
	setTimeout('update()',10000);
}
