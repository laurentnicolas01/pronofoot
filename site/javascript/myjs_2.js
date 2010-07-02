$(function() {
	/* General */
	function start_loading(elem) {
		elem.html('&nbsp<img src="images/ajax-loader.gif" alt="Load..." id="iload" />');
	}
	
	function stop_loading() {
		$('img#iload').remove();
	}

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
		nbmess = $('select#nbmess'),
		idgroup = $('select#idgroup');
	
	function update_list(div) {
		div.load('pages/ajax.php', {action:'message_update',nb:nbmess.val(),idg:idgroup.val()}, function(result) {
			div.html(result);
			stop_loading();
		});	
	}

	$('select#nbmess, select#idgroup').change(function() {
		start_loading(loading);
		update_list(div);
	});

	$('#submit_message, #hidden_submit').click(function() {
		start_loading(loading);
		
		var message = $('input#message').val(),
			id = $('input#idj').val() / 2;
			grp = $('select#idgroup').val();
		
		$.ajax({
			type: "POST",
			url: "pages/ajax.php",
			data: "action=message_insert"
				+ "&id=" + id
				+ "&message=" + message
				+ "&idg=" + grp,
			
			success: function(result) {
				result = result.split('&&&');
				if(result[0] == 'ok') {
					$('input#message').val('');
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
	
	/* Members */
	$('body').append('<div id="connected_members" class="ui-helper-hidden"></div>');
	
	var div_co = $('div#connected_members'),
		decalX = div_co.width() * -1.4,
		decalY = 15;
	
	$('a#see_list').hover(function(e) {
		div_co.css('top', e.pageY + decalY).css('left', e.pageX + decalX).show().load();
	}, function() {
		div_co.hide();
	})
	.mousemove(function(e) {
		div_co.css('top', e.pageY + decalY).css('left', e.pageX + decalX);
	});
	
	div_co.load(function() {
		start_loading(div_co);
		$.ajax({
			type: "POST",
			url: "pages/ajax.php",
			data: "action=members_connected",
			
			success: function(result) {
				result = result.split('&&&');
				stop_loading();
				if(result[0] == 'ok') {
					$('span#nbco').html(result[1]);
					div_co.html(result[2]);
				}
				else
					div_co.html('<span class="error">Erreur de traitement</span>');				
			}
		});
	});
	
	/* Demandes */
	$('a.demande_link').click(function() {
		return confirm('Confirmer ?');
	});
	
	/* Add news */
	$('img.add_img_news').click(function() {
		$('input#image, input#image_dis').val($(this).attr('alt'));
	});
	
	$('img#clear_img_news').click(function() {
		$('input#image, input#image_dis').val('');
	});
	
	/* Sondage */
	$('div#answers').dialog({
		autoOpen: false,
		modal: true,
		closeOnEscape: true,
		resizable: false,
		width: 350
	});
	
	$('a#show_answers').click(function() {
		$('div#answers').dialog('open');
	});
	
	if(href == 'maj' || href == 'groupes') {
		$('input[type=submit]').click(function() {
			return confirm('Etes vous sûr ?');
		});
	}
});
