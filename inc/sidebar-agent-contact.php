<div class="agent-box-card grey">
	<div class="image-content">
		<div class="image image-fill">
			<?php do_action( 'rem_agent_picture', $author_id ); ?>
		</div>						
	</div>
	<div class="info-agent">
		<span class="name">
			<?php echo get_user_meta( $author_id, 'first_name', true ); ?>
			<?php echo get_user_meta( $author_id, 'last_name', true ); ?>									
		</span>
		<div class="text text-center">
			<?php echo get_user_meta( $author_id, 'rem_user_tagline', true ); ?>
		</div>
		<?php do_action( 'rem_contact_social_icons', $author_id ); ?>
	</div>
</div>

<div class="contact-agent">
	<?php
		$custom_form = get_the_author_meta( 'rem_user_contact_sc', $author_id );

		if ($custom_form != '') {
			echo do_shortcode( $custom_form );
		} else { ?>
			<form method="post" id="contact-agent" action="" data-ajaxurl="<?php echo admin_url( 'admin-ajax.php' ); ?>" role="form" data-toggle="validator">
				<div class="form-group">
					<input type="hidden" name="agent_id" value="<?php echo $author_id; ?>">
					<input type="hidden" name="action" value="rem_contact_agent">
					<input type="hidden" name="property_id" value="<?php global $post; echo $post->ID; ?>">
					<input type="text" placeholder="<?php _e( 'Your Name', 'real-estate-manager' ); ?> *" class="form-control" name="client_name" id="name" required>
				</div>
				<div class="form-group">
					<input type="email" placeholder="<?php _e( 'Your Email', 'real-estate-manager' ); ?> *" class="form-control" name="client_email" id="email" required>
				</div>
				<div class="form-group">
					<textarea placeholder="<?php _e( 'Message', 'real-estate-manager' ); ?> *" rows="5" class="form-control" name="client_msg" id="text-message" required></textarea>
				</div> 
				<button class="btn btn-default" type="submit"><?php _e( 'Send Message', 'real-estate-manager' ); ?></button>
			</form>
			<br>
			<div class="alert with-icon alert-info sending-email" style="display:none;" role="alert">
				<i class="icon fa fa-info"></i>
				<span class="msg"><?php _e( 'Sending Email, Please Wait...', 'real-estate-manager' ); ?></span>
			</div>
		<?php }
	?>
</div>