$(function() {
	/* Style */
	function set_sub() {
		$('#menu ul li ul li a').addClass('ui-widget-header').addClass('sub');
	}
	
	set_sub();

	var href = $('input#href').val();
	$('#menu a').each(function() {
		if($(this).attr('href') == href)
			$(this).removeClass().css('border', 'none').css('font-weight', 'bold').addClass('ui-state-active');
	});
	
	var active = false,
		sub = false;
	$('#menu a').hover(function() {
		active = $(this).hasClass('ui-state-active');
		sub = $(this).hasClass('sub');
		$(this).removeClass().css('border', 'none').css('font-weight', 'bold').addClass('ui-state-hover');
	}, function() {
		if(sub)
			set_sub();
		if(!active)
			$(this).removeClass('ui-state-hover');
		else
			$(this).addClass('ui-state-active');
	});

	/* Chat */
	var loading = $('span#chat_loading'),
		div = $('div#message_list'),
		nbmess = $('select#nbmess');

	$('select#nbmess').change(function() {
		loading.html('&nbsp<img src="images/ajax-loader.gif" alt="Load..."');
	});

	$('#submit_message, #hidden_submit').click(function() {
		$('select#nbmess').change();
	
		var message = $('input#message').val(),
			id = $('input#idj').val() / 2;
		
		$.ajax({
			type: "POST",
			url: "pages/ajax_insert.php",
			data: "&id=" + id
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
			div.load('pages/ajax_update.php', {nb:nbmess.val()}, function(result) {
				div.html(result);
				loading.html('');
			});
		}, 0);
	}
	
	/* Notifications */
	$('input#submit_maj').click(function() {
		alert('La mise à jour est désactivée !');
		return false;
	});
});
