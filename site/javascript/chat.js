$(function() {
	var loading = $('span#chat_loading'),
		div = $('div#message_list'),
		nbmess = $('select#nbmess');

	$('select#nbmess').change(function() {
		loading.html('&nbsp<img src="images/ajax-loader.gif" alt="Load..."');
	});

	$('#submit_message').click(function() {
		$('select#nbmess').change();
	
		var message = $('input#message').val(),
			id = $('input#idj').val() / 2;
		
		$.ajax({
			type: "POST",
			url: "pages/ajax_insert.php",
			data: "action=insert"
				+ "&id=" + id
				+ "&message=" + message,
			
			success: function(result) {
				result = result.split('&&&');
				if(result[0] == 'ok') {
					$('input#message').val('');
					div.prepend(result[1]);
					loading.html('');
				}
			}
		});
		
		return false;
	});
	
	// Nécéssite le plug-in "jquery timers"
	if(div.is(':visible')) {		
		$(div).everyTime('5s', function() {
			div.load('pages/ajax_update.php', {action:'update', nb:nbmess.val()}, function(result) {
				div.html(result);
				loading.html('');
			});
		}, 0);
	}
})
