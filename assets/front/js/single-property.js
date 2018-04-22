jQuery(document).ready(function($) {
	// Contact Agent frontend
	$('#contact-agent').submit(function(event) {
		event.preventDefault();
		$('.sending-email').show();
		var ajaxurl = $(this).data('ajaxurl');
		var data = $(this).serialize();
		// console.log(data);

		$.post(ajaxurl, data, function(resp) {
			// console.log(resp);
			if (resp.status == 'sent') {
				$('.sending-email').removeClass('alert-info').addClass('alert-success');
				$('.sending-email .msg').html(resp.msg);
			} else {
				$('.sending-email').removeClass('alert-info').addClass('alert-danger');
				$('.sending-email .msg').html(resp.msg);
			}
		}, 'json');
	});

	// Apply ImageFill	
	jQuery('.ich-settings-main-wrap .image-fill').each(function(index, el) {
		jQuery(this).imagefill();
	});		
});