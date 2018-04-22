jQuery(document).ready(function($) {
	$('.fa-pencil').click(function(event) {
		$(this).closest('li').find('input').trigger('focus');
	});

	$('#agent-profile-form').submit(function(event) {
		event.preventDefault();
		$('.rem-res').show();
		$.post($('.rem-ajax-url').val(), $(this).serialize(), function(resp) {
			$('.rem-res').html(resp);
			window.location.reload();
		});
	});
});