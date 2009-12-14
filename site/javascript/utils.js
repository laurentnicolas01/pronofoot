$(function() {
	function set_sub() {
		$('#menu ul li ul li a').addClass('ui-widget-header').addClass('sub');
	}
	
	set_sub();

	href = $('input#href').val();
	$('#menu a').each(function() {
		if($(this).attr('href') == href)
			$(this).removeClass().css('border', 'none').css('font-weight', 'bold').addClass('ui-state-active');
	});

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
});
