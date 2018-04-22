jQuery(document).ready(function($) {
        jQuery(".labelauty").labelauty();
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

    // Creating Property
    jQuery('#create-property').submit(function(event){
        event.preventDefault();
        $('.creating-prop').show();
        

        if (jQuery("#wp-rem-content-wrap").hasClass("tmce-active")){
            content = tinyMCE.get('rem-content').getContent();
        }else{
            content = $('#rem-content').val();
        }        

        var ajaxurl = $(this).data('ajaxurl');
        var data = $(this).serialize()+'&content='+content;

        $.post(ajaxurl, data , function(resp) {
            // console.log(resp);
            $('.creating-prop').removeClass('alert-info').addClass('alert-success');
            $('.creating-prop .msg').html('Successfull, you are now directing to this property...');
            window.location = resp;
        });
    });    
});