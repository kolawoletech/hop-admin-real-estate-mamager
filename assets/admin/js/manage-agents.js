jQuery(document).ready(function($) {
	$('.deny-user').click(function(event) {
		event.preventDefault();
		$(this).attr('disabled', 'disabled');
		var data = {
			userindex: $(this).data('userindex'),
			action: 'deny_agent',
		}

		$.post(ajaxurl, data, function(resp) {
			alert('Denied!');
			window.location.reload();
		});
	});
	$('.approve-user').click(function(event) {
		event.preventDefault();
		$(this).attr('disabled', 'disabled');
		var data = {
			userindex: $(this).data('userindex'),
			action: 'approve_agent',
		}

		$.post(ajaxurl, data, function(resp) {
			alert('Approved!');
			window.location.reload();
		});
	});
});