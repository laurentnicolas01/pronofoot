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
	
	function start_loading() {
		loading.html('&nbsp<img src="images/ajax-loader.gif" alt="Load..."');
	}
	
	function stop_loading() {
		loading.html('');
	}
	
	function update_list(div) {
		div.load('pages/ajax.php', {action:'message_update',nb:nbmess.val()}, function(result) {
			div.html(result);
			stop_loading();
		});	
	}

	$('select#nbmess').change(function() {
		start_loading();
		update_list(div);
	});

	$('#submit_message, #hidden_submit').click(function() {
		start_loading();
		
		var message = $('input#message').val(),
			id = $('input#idj').val() / 2;
		
		$.ajax({
			type: "POST",
			url: "pages/ajax.php",
			data: "action=message_insert"
				+ "&id=" + id
				+ "&message=" + message,
			
			success: function(result) {
				result = result.split('&&&');
				if(result[0] == 'ok') {
					$('input#message').val(' ');
					div.prepend(result[1]);
				}
				stop_loading();
			}
		});
		
		return false;
	});
	
	/* Nécéssite le plug-in "jquery timers" */
	if(nbmess.is(':visible')) {
		$(div).everyTime('30s', function() {
			update_list(div);
		}, 0);
	}
	
	/* Historique */
	$('select[name=idj_asked]').change(function() {
		$('input[name=submit_asked]').click();
	});
});
