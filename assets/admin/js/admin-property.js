jQuery(document).ready(function($) {
    var rem_property_images;
     
    jQuery('.upload_image_button').live('click', function( event ){
     
        event.preventDefault();
     
        // var parent = jQuery(this).closest('.tab-content').find('.thumbs-prev');
        // Create the media frame.
        rem_property_images = wp.media.frames.rem_property_images = wp.media({
          title: 'Select images for property gallery',
          button: {
            text: 'Add',
          },
          multiple: true  // Set to true to allow multiple files to be selected
        });
     
        // When an image is selected, run a callback.
        rem_property_images.on( 'select', function() {
            // We set multiple to false so only get one image from the uploader
            var selection = rem_property_images.state().get('selection');
            selection.map( function( attachment ) {
                attachment = attachment.toJSON();
                jQuery('.thumbs-prev').append('<div><input type="hidden" name="rem_property_data[property_images]['+attachment.id+']" value="'+attachment.id+'"><img src="'+attachment.url+'"><span class="dashicons dashicons-dismiss"></span></div>');

            });  
        });
     
        // Finally, open the modal
        rem_property_images.open();
    });
    jQuery('.thumbs-prev').on('click', '.dashicons-dismiss', function() {
        jQuery(this).parent('div').remove();
    });
    jQuery(".thumbs-prev").sortable({
      placeholder: "ui-state-highlight"
    });

    var rem_attachments;
     
    jQuery('.upload-attachment').live('click', function( event ){
     
        event.preventDefault();
        var text_field = $(this).closest('div').find('.place-attachment');
     
        // var parent = jQuery(this).closest('.tab-content').find('.thumbs-prev');
        // Create the media frame.
        rem_attachments = wp.media.frames.rem_attachments = wp.media({
          title: 'Select attachment for property',
          button: {
            text: 'Add',
          },
          multiple: true  // Set to true to allow multiple files to be selected
        });
     
        // When an image is selected, run a callback.
        rem_attachments.on( 'select', function() {
            // We set multiple to false so only get one image from the uploader
            var selection = rem_attachments.state().get('selection');
            selection.map( function( attachment ) {
                attachment = attachment.toJSON();
                if (text_field.val() != '') {
                    text_field.val( text_field.val() + '\n'+attachment.id);
                } else {
                    text_field.val( text_field.val() +attachment.id);
                }

            });
        });
     
        // Finally, open the modal
        rem_attachments.open();
    });

    $(".rem-settings-box .tabs-panel").hide().first().show();
    $(".rem-settings-box .nav-tabs li:first").addClass("active");
    $(".rem-settings-box .nav-tabs a").on('click', function (e) {
        e.preventDefault();
        $(this).closest('li').addClass("active").siblings().removeClass("active");
        $($(this).attr('href')).show().siblings('.tabs-panel').hide();
    });    
});