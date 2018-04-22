<?php
	// geting data from rem class
	global $rem_ob;
	$property_purposes = $rem_ob->get_all_property_purpose();
	$property_types = $rem_ob->get_all_property_types();
	$property_status = $rem_ob->get_all_property_status();
	$default_fields = $rem_ob->single_property_fields_builtin();
	$custom_fields = $rem_ob->single_property_fields();		
	$default_fields = array_merge($default_fields, $custom_fields);

	$fields_arr =  explode(',', $fields_to_show );

	$property_individual_cbs = $rem_ob->get_all_property_features();
?>
<div class="ich-settings-main-wrap">
<section id="rem-search-box" class="no-margin search-property-page">
	<form data-resselector="<?php echo $results_selector; ?>" class="<?php echo ($results_page != '') ? '' : 'search-property-form' ; ?>" action="<?php echo $results_page; ?>" method="get" id="search-property" data-ajaxurl="<?php echo admin_url( 'admin-ajax.php' ); ?>">
		<?php
			if ($fixed_fields != '') {
				$fixed_va_arr = explode(",", $fixed_fields);
				foreach ($fixed_va_arr as $fixed_va) {
					$fixed_data = explode("|", $fixed_va);
					echo '<input type="hidden" name="'.$fixed_data[0].'" value="'.$fixed_data[1].'">';
				}
			}
		?>
		<input type="hidden" name="action" value="rem_search_property">
		<div class="search-container fixed-map">
			<div class="search-options sample-page">
				<div class="searcher">
					<div class="row margin-div <?php echo ($disable_eq_height != 'yes') ? 'wcp-eq-height' : '' ; ?>">
						
						<?php if (in_array('search', $fields_arr)) { ?>
							<div class="col-sm-6 col-md-<?php echo $columns; ?> margin-bottom">
								<input class="form-control" type="text" name="search_property" id="keywords" placeholder="<?php _e( 'Keywords', 'real-estate-manager' ); ?>" />
							</div>
						<?php } else {
							echo '<input value="" type="hidden" name="search_property" />';
						} ?>

						<?php foreach ($default_fields as $field) { if (in_array($field['key'], $fields_arr) && 'property_price' != $field['key']):
						
							if ($field['key'] == 'property_type') { ?>

								<div class="col-sm-6 col-md-<?php echo $columns; ?> margin-bottom">
									<select class="dropdown" data-settings='{"cutOff": 5}' name="<?php echo $field['key']; ?>">
										<option value="">-- <?php echo stripcslashes($field['title']); ?> --</option>
										<?php
											foreach ($property_types as $val => $title) {
												echo '<option value="'.$val.'">'.$title.'</option>';
											}
										?>                     
									</select>
								</div>

							<?php } elseif ($field['key'] == 'property_purpose') { ?>

								<div class="col-sm-6 col-md-<?php echo $columns ?> margin-bottom">
									<select class="dropdown" data-settings='{"cutOff": 5}' name="<?php echo $field['key']; ?>">
										<option value="">-- <?php echo stripcslashes($field['title']); ?> --</option>
										<?php
											foreach ($property_purposes as $val => $title) {
												echo '<option value="'.$val.'">'.$title.'</option>';
											}
										?>
									</select>
								</div>

							<?php } elseif ($field['key'] == 'property_status') { ?>

								<div class="col-sm-6 col-md-<?php echo $columns ?> margin-bottom">
									<select class="dropdown" name="<?php echo $field['key']; ?>" data-settings='{"cutOff": 5}'>
										<option value="">-- <?php echo stripcslashes($field['title']); ?> --</option>
										<?php
											foreach ($property_status as $val => $title) {
												echo '<option value="'.$val.'">'.$title.'</option>';
											}
										?>
									</select>
								</div>

							<?php } elseif ($field['key'] == 'property_bedrooms') { ?>

								<?php if (rem_get_option('search_bedrooms_options', '') != '') { ?>
								<div class="col-sm-6 col-md-<?php echo $columns; ?> margin-bottom">
									<select class="dropdown" data-settings='{"cutOff": 5}' name="<?php echo stripcslashes($field['key']); ?>" id="<?php echo $field['key']; ?>">
										<option value="">-- <?php echo stripcslashes($field['title']); ?> --</option>
										<?php
											$options = explode("\n", rem_get_option('search_bedrooms_options'));
											foreach ($options as $val => $title) {
												echo '<option value="'.$title.'">'.$title.'</option>';
											}
										?>
									</select>
								</div>									
								<?php } else { ?>
									<div class="col-sm-6 col-md-<?php echo $columns; ?> margin-bottom">
										<span id="span-<?php echo $field['key']; ?>" data-text="<?php echo $field['title']; ?>"></span>
										<input class="form-control" name="<?php echo $field['key']; ?>" placeholder="<?php echo stripcslashes($field['title']); ?>" type="text" id="<?php echo $field['key']; ?>" value=""/>
									</div>
								<?php } ?>

							<?php } elseif ($field['key'] == 'property_bathrooms') { ?>

								<?php if (rem_get_option('search_bathrooms_options', '') != '') { ?>
								<div class="col-sm-6 col-md-<?php echo $columns; ?> margin-bottom">
									<select class="dropdown" data-settings='{"cutOff": 5}' name="<?php echo stripcslashes($field['key']); ?>" id="<?php echo $field['key']; ?>">
										<option value="">-- <?php echo stripcslashes($field['title']); ?> --</option>
										<?php
											$options = explode("\n", rem_get_option('search_bathrooms_options'));
											foreach ($options as $val => $title) {
												echo '<option value="'.$title.'">'.$title.'</option>';
											}
										?>
									</select>
								</div>									
								<?php } else { ?>
									<div class="col-sm-6 col-md-<?php echo $columns; ?> margin-bottom">
										<span id="span-<?php echo $field['key']; ?>" data-text="<?php echo $field['title']; ?>"></span>
										<input class="form-control" name="<?php echo $field['key']; ?>" placeholder="<?php echo stripcslashes($field['title']); ?>" type="text" id="<?php echo $field['key']; ?>" value=""/>
									</div>
								<?php } ?>

							<?php } elseif ($field['type'] == 'number') { ?>

								<div class="col-sm-6 col-md-<?php echo $columns; ?> margin-bottom">
									<span id="span-<?php echo $field['key']; ?>" data-text="<?php echo $field['title']; ?>"></span>
									<input class="form-control" type="number" name="<?php echo $field['key']; ?>" placeholder="<?php echo stripcslashes($field['title']); ?>" id="<?php echo $field['key']; ?>" value=""/>
								</div>

							<?php } elseif ($field['key'] == 'property_area') { ?>
								<?php if (rem_get_option('search_area_options', '') != '') { ?>
								<div class="col-sm-6 col-md-<?php echo $columns; ?> margin-bottom">
									<select class="dropdown" data-settings='{"cutOff": 5}' name="<?php echo stripcslashes($field['key']); ?>" id="<?php echo $field['key']; ?>">
										<option value="">-- <?php echo stripcslashes($field['title']).' '. rem_get_option('properties_area_unit', 'Sq Ft'); ?> --</option>
										<?php
											$options = explode("\n", rem_get_option('search_area_options'));
											foreach ($options as $val => $title) {
												echo '<option value="'.trim($title).'">'.trim($title).'</option>';
											}
										?>
									</select>
								</div>									
								<?php } else { ?>
									<div class="col-sm-6 col-md-<?php echo $columns; ?> margin-bottom">
										<span id="span-<?php echo $field['key']; ?>" data-text="<?php echo $field['title']; ?>"></span>
										<input class="form-control" name="<?php echo $field['key']; ?>" placeholder="<?php echo stripcslashes($field['title']).' '. rem_get_option('properties_area_unit', 'Sq Ft'); ?>" type="text" id="<?php echo $field['key']; ?>" value=""/>
									</div>
								<?php } ?>

							<?php } elseif ($field['type'] == 'text') { ?>

								<div class="col-sm-6 col-md-<?php echo $columns; ?> margin-bottom">
									<span id="span-<?php echo $field['key']; ?>" data-text="<?php echo $field['title']; ?>"></span>
									<input class="form-control" name="<?php echo $field['key']; ?>" placeholder="<?php echo stripcslashes($field['title']); ?>" type="text" id="<?php echo $field['key']; ?>" value=""/>
								</div>

							<?php } elseif ($field['type'] == 'select') { ?>
								<div class="col-sm-6 col-md-<?php echo $columns; ?> margin-bottom">
									<select class="dropdown" data-settings='{"cutOff": 5}' name="<?php echo stripcslashes($field['key']); ?>" id="<?php echo $field['key']; ?>">
										<option value="">-- <?php echo stripcslashes($field['title']); ?> --</option>
										<?php
											$options = explode("\n", $field['options']);
											foreach ($options as $val => $title) {
												echo '<option value="'.stripcslashes($title).'">'.stripcslashes($title).'</option>';
											}
										?>
									</select>
								</div>
							<?php }
						endif; } ?>

						
						<?php if (in_array('property_price', $fields_arr)) { ?>
							<div class="p-slide-wrap col-sm-6 col-md-<?php echo $columns ?> margin-bottom">
								<div class="slider price-range">
								</div>
								<div class="price-slider price">
									<span id="price-value-min"></span> 
									<span class="separator"><?php echo rem_get_currency_symbol(); ?></span>
									<span id="price-value-max"></span>
								</div>
								<input type="hidden" name="price_min" id="min-value">
								<input type="hidden" name="price_max" id="max-value">
							</div>
						<?php } ?>

					</div>
					<div class="row filter hide-filter hidden-xs hidden-sm">
						<?php foreach ($property_individual_cbs as $cb) { ?>
								<div class="col-xs-6 col-sm-4 col-md-3">
									<input class="labelauty" type="checkbox" name="detail_cbs[<?php echo $cb; ?>]" data-labelauty="<?php echo stripcslashes($cb); ?>">
								</div>
						<?php } ?>
					</div><!-- ./filter -->
					<div class="margin-div footer">
						<?php if ($filters_btn_text != '') { ?>
							<button type="button" class="btn btn-default more-button hidden-xs hidden-sm">
								<?php echo $filters_btn_text; ?>
							</button>
						<?php } ?>
						<?php if ($reset_btn_text != '') { ?>
							<button type="reset" class="btn btn-default">
								<?php echo $reset_btn_text; ?>
							</button>
						<?php } ?>
						<button type="submit" class="btn btn-default search-button">
							<?php echo $search_btn_text; ?>
						</button>
					</div><!-- ./footer -->
				</div><!-- ./searcher -->
			</div><!-- search-options -->
		</div><!-- search-container fixed-map -->
	</form>
</section>


<section id="grid-content" class="search-results">
	<div class="loader text-center margin-bottom" style="display:none;margin-top:20px;">
		<img src="<?php echo REM_URL.'/assets/images/ajax-loader.gif'; ?>" alt="<?php _e( 'Loading...', 'real-estate-manager' ); ?>">
	</div>
	<div class="searched-proerpties">
		<?php echo apply_filters( 'the_content', $content ); ?>
	</div>
</section>
</div>