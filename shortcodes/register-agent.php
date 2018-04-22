<div class="ich-settings-main-wrap">
<form id="agent_login" data-ajaxurl="<?php echo admin_url( 'admin-ajax.php' ); ?>" data-redirect="<?php echo $redirect; ?>">
	<section id="rem-agent-page">
		<div class="row">
				<input type="hidden" value="rem_agent_register" name="action">
				<div class="col-sm-12">
					<?php
						global $rem_ob;
						$field_tabs = rem_get_agent_fields_tabs();
						$agent_fields = $rem_ob->get_agent_fields();

					foreach ($field_tabs as $tab_name => $tab_title) { ?>
						<?php echo ($tab_name != 'personal_info') ? '<br>' : '' ; ?>
						<div class="section-title line-style no-margin">
							<h3 class="title"><?php echo $tab_title; ?></h3>
						</div>
						<ul class="profile create">
							<?php if ($tab_name == 'personal_info') { ?>
								<li>
									<span><?php _e( 'First Name', 'real-estate-manager' ); ?> *</span>
									<input type="text" class="form-control" name="firstname" required />
								</li>
								<li>
									<span><?php _e( 'Last Name', 'real-estate-manager' ); ?> *</span>
									<input type="text" class="form-control" name="lastname" required />
								</li>
								<li>
									<span><?php _e( 'Username', 'real-estate-manager' ); ?> *</span>
									<input type="text" class="form-control" name="username" required />
								</li>
								<li>
									<span><?php _e( 'Email', 'real-estate-manager' ); ?> *</span> 
									<input type="email" class="form-control" name="useremail" required />
								</li>
								<li>
									<span><?php _e( 'Password', 'real-estate-manager' ); ?> *</span>
									<input type="password" class="form-control" name="password" id="password" required />
								</li>
								<li>
									<span><?php _e( 'Pepeat Password', 'real-estate-manager' ); ?> *</span>
									<input type="password" class="form-control" name="repassword" id="repassword" required />
								</li>
								<li>
									<span><?php _e( 'Biographical Info', 'real-estate-manager' ); ?></span>
									<textarea name="info" class="form-control"></textarea>
								</li>									
								
							<?php } ?>

							<?php foreach ($agent_fields as $field) { ?>	

								<?php if (isset($field['tab']) && $field['tab'] == $tab_name && in_array('register', $field['display'])) { ?>
									<li>
										<span><?php echo $field['title']; ?></span>
										<?php switch ($field['type']) {
											case 'text': ?>
												<input type="text" class="form-control" name="<?php echo $field['key']; ?>" <?php echo (isset($field['required'])) ? 'required' : '' ; ?> />
												<?php break;

											case 'textarea': ?>
												<textarea name="<?php echo $field['key']; ?>" <?php echo (isset($field['required'])) ? 'required' : '' ; ?> class="form-control"></textarea>
												<br>
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
						
				</div>
				<div class="col-sm-12">
					<button class="btn btn-default signin-button" type="submit"><i class="fa fa-sign-in"></i> <?php _e( 'Sign up', 'real-estate-manager' ); ?></button>
				</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<br><br>
				<div class="alert with-icon alert-info agent-register-info" style="display:none;" role="alert">
					<span class="glyphicon glyphicon-info-sign pull-left"></span>
					&nbsp;
					<span class="msg"></span>
				</div>
			</div>			
		</div>
	</section>
</form>
</div>