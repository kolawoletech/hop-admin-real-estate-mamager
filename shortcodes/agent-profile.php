<?php
	$max_width = apply_filters( 'rem_max_container_width', '1170px' );
?>
<section id="rem-agent-page" class="ich-settings-main-wrap">
	<div style="max-width:<?php echo $max_width; ?>; width:100%; margin:0 auto;">
		<div class="row">				

			<div class="col-sm-12 col-md-12">
				<div class="row">
					<div class="col-sm-4 col-md-4">
						<?php $agent_card = rem_get_option('agent_page_agent_card', 'enable');
							if ($agent_card == 'enable') { ?>
						<!-- . Agent Box -->
						<div class="agent-box-card grey">
							<div class="image-content">
								<div class="image image-fill">
									<?php do_action( 'rem_agent_picture', $author_id ); ?>
								</div>						
							</div>
							<div class="info-agent">
								<div class="text text-center">
									<?php echo get_user_meta( $author_id, 'rem_user_tagline', true ); ?>
								</div>
								<?php do_action( 'rem_contact_social_icons', $author_id ); ?>
							</div>
						</div>

						<div class="skill-box">
							<?php
								$author_skills = get_user_meta( $author_id, 'rem_user_skills', true );
								$allskills = explode(PHP_EOL, $author_skills);
								if (is_array($allskills)) {
									foreach ($allskills as $skill) {
										$single_skill = explode(',', $skill);
										if (isset($single_skill[0]) && isset($single_skill[1])) {
												?>
												<div class="skillbar" data-percent="<?php echo trim($single_skill[1]); ?>">
													<div class="skillbar-title"><span><?php echo $single_skill[0]; ?></span></div>
													<div class="skillbar-bar"></div>
													<div class="skill-bar-percent"><?php echo trim($single_skill[1]); ?></div>
												</div>
										<?php }
										
									}
								}
							?>
						</div>

						<?php } ?>

						<?php
							$p_sidebar = rem_get_option('agent_page_sidebar', '');
						    if ( is_active_sidebar( $p_sidebar )  ) :
						        dynamic_sidebar( $p_sidebar ); 
						    endif;
						?>

					</div>				
					<div class="col-sm-8 col-md-8">
						<div class="section-title line-style no-margin">
							<h1 class="name title">
								<?php echo get_user_meta( $author_id, 'first_name', true ); ?>
								<?php echo get_user_meta( $author_id, 'last_name', true ); ?>
							</h1>
						</div>
						<span class="text">
							<?php echo get_user_meta( $author_id, 'description', true ); ?>
						</span>
						<hr>
						<?php $custom_form = get_the_author_meta( 'rem_user_contact_sc', $author_id );
							if ($custom_form != '') {
								echo do_shortcode( $custom_form );
							} else {
						?>
							<form class="form-contact" method="post" action="" id="contact-agent" role="form" data-toggle="validator" data-ajaxurl="<?php echo admin_url( 'admin-ajax.php' ); ?>">
								<div class="row">
									<div class="col-md-6 col-sm-12">
										<input type="hidden" name="agent_id" value="<?php echo $author_id; ?>">
										<input type="hidden" name="action" value="rem_contact_agent">				
										<input name="client_name" id="name" type="text" class="form-control" placeholder="<?php _e( 'Name', 'real-estate-manager' ); ?> *" required>
									</div>
									<div class="col-md-6 col-sm-12">
										<input type="email" class="form-control" name="client_email" id="email" placeholder="<?php _e( 'Email', 'real-estate-manager' ); ?> *" required>
									</div>
									<div class="col-md-12 col-sm-12">
										<input name="subject" id="subject" type="text" class="form-control" placeholder="<?php _e( 'Subject', 'real-estate-manager' ); ?> *">
									</div>
									<div class="col-md-12 col-sm-12">
										<textarea name="client_msg" id="text-message" class="form-control text-form" placeholder="<?php _e( 'Your Message', 'real-estate-manager' ); ?> *" required></textarea>
									</div>
									<div class="col-md-12 col-sm-12">
										<button type="submit" class="btn btn-default"><span class=""></span> <?php _e( 'SEND MESSAGE', 'real-estate-manager' ); ?></button>
									</div>
								</div><!-- /.row -->
							</form><!-- /.form -->
							<br>
							<div class="alert with-icon alert-info sending-email" style="display:none;" role="alert">
								<i class="icon fa fa-info"></i>
								<span class="msg"><?php _e( 'Sending Email, Please Wait...', 'real-estate-manager' ); ?></span>
							</div>
						<?php } ?>
						<?php do_action( 'rem_single_agent_after_contact_form', $author_id ); ?>
					</div><!-- /.col-md-8 -->
				</div>

			</div>				
		</div>
		
		<?php do_action( 'rem_single_agent_before_slider', $author_id ); ?>
		<?php 
		$property_args = array(
			'posts_per_page' => 10,
			'post_type' => 'rem_property',
			'author' => $author_id,
		);
		$the_query = new WP_Query( $property_args ); ?>

		<?php if ( $the_query->have_posts() ) : ?>
			<div class="section-title line-style no-margin">
				<h3 class="title"><?php _e( 'My Properties', 'real-estate-manager' ); ?></h3>
			</div>

			<section class="wcp-slick">
				<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
					<div style="padding:10px;">
						<?php do_action('rem_property_box', get_the_id(), 3) ?>
					</div>
				<?php endwhile; ?>
			</section>

			<?php wp_reset_postdata(); ?>

		<?php else : ?>
			
		<?php endif; ?>

		<?php do_action( 'rem_single_agent_after_slider', $author_id ); ?>

	</div><!-- ./container -->
</section>