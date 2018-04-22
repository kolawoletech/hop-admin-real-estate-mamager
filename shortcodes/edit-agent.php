<?php
	$current_user = wp_get_current_user();
	$agent_id = $current_user->ID;
	$agent_email = $current_user->user_email;
?>
<div class="ich-settings-main-wrap" id="rem-agent-page">
<form action="" id="agent-profile-form">
	<input type="hidden" name="action" value="rem_save_profile_front">
	<input type="hidden" name="agent_id" value="<?php echo $agent_id; ?>">
	<input type="hidden" class="rem-ajax-url" value="<?php echo admin_url('admin-ajax.php'); ?>">

	<?php
		global $rem_ob;
		$field_tabs = rem_get_agent_fields_tabs();
		$agent_fields = $rem_ob->get_agent_fields();

	foreach ($field_tabs as $tab_name => $tab_title) { ?>
	<?php echo ($tab_name != 'personal_info') ? '<br>' : '' ; ?>
		<div class="section-title line-style no-margin">
			<h3 class="title"><?php echo $tab_title; ?></h3>
		</div>
		<ul class="profile edit-agent-profile">

			<?php if ($tab_name == 'personal_info') { ?>

			<li>
				<span><?php _e( 'Username', 'real-estate-manager' ); ?></span> <?php echo $current_user->user_login; ?>
				<i class="icon fa fa-lock"></i>
			</li>
			<li>
				<span><?php _e( 'First Name', 'real-estate-manager' ); ?></span>
				<input type="text" name="first_name" value="<?php echo get_user_meta( $agent_id, 'first_name', true ); ?>">
				<i class="icon fa fa-pencil"></i>
			</li>
			<li>
				<span><?php _e( 'Last Name', 'real-estate-manager' ); ?></span>
				<input type="text" name="last_name" value="<?php echo get_user_meta( $agent_id, 'last_name', true ); ?>">
				<i class="icon fa fa-pencil"></i>
			</li>
			<li>
				<span><?php _e( 'Nickname', 'real-estate-manager' ); ?></span>
				<input type="text" name="nickname" value="<?php echo get_user_meta( $agent_id, 'nickname', true ); ?>">
				<i class="icon fa fa-pencil"></i>
			</li>
			<li>
				<span><?php _e( 'Email', 'real-estate-manager' ); ?></span>
				<input type="email" name="user_email" value="<?php echo $agent_email; ?>" required>
				<i class="icon fa fa-pencil"></i>
			</li>
			<li style="padding-right: 7px;">
				<span><?php _e( 'Biographical Info', 'real-estate-manager' ); ?></span>
				<textarea rows="4" name="description"><?php echo get_user_meta( $agent_id, 'description', true ); ?></textarea>
			</li>

			<?php } ?>

			<?php foreach ($agent_fields as $field) { ?>	

					<?php if (isset($field['tab']) && $field['tab'] == $tab_name && in_array('edit', $field['display'])) { ?>
						<li style="padding-right: 7px;">
							<span><?php echo $field['title']; ?></span>
							<?php switch ($field['type']) {
								case 'text': ?>
									<input type="text" value="<?php echo get_user_meta( $agent_id, $field['key'], true ); ?>" name="<?php echo $field['key']; ?>" <?php echo (isset($field['required'])) ? 'required' : '' ; ?> />
									<i class="icon fa fa-pencil"></i>
									<?php break;

								case 'textarea': ?>
									<textarea rows="4" name="<?php echo $field['key']; ?>" <?php echo (isset($field['required'])) ? 'required' : '' ; ?>><?php echo get_user_meta( $agent_id, $field['key'] , true ); ?></textarea>
									<p><?php echo $field['help']; ?></p>
									<?php break;
								
								default:
									
									break;
							} ?>
						</li>
					<?php }
				} ?>
			</ul>
		<?php } ?>
	<br>
	<input type="submit" value="<?php _e( 'Save Changes', 'real-estate-manager' ); ?>" class="btn btn-default">
	<a href="<?php echo esc_url( wp_logout_url(home_url()) ); ?>" class="btn btn-default"><?php _e( 'Logout', 'real-estate-manager' ); ?></a>
	<div class="rem-res">
		<p class="alert alert-info"><?php _e( 'Saving Changes...', 'real-estate-manager' ); ?></p>
	</div>
</form>
</div>