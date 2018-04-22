<?php
	
	$tabsData = rem_get_single_property_settings_tabs();	

	$inputFields = array(
        array(
            'key' => 'property_latitude',
            'type' => 'text',
            'tab' => 'general_settings',
            'default' => '',
            'title' => __( 'Latitude', 'real-estate-manager' ),
            'help' => __( 'Latitude of property, will use for map', 'real-estate-manager' ),
        ),
        array(
            'key' => 'property_longitude',
            'type' => 'text',
            'tab' => 'general_settings',
            'default' => '',
            'title' => __( 'Longitude', 'real-estate-manager' ),
            'help' => __( 'Longitude of property, will use for map', 'real-estate-manager' ),
        ),
        array(
            'key' => 'property_video',
            'type' => 'text',
            'tab' => 'property_video',
            'default' => '',
            'title' => __( 'Video URL', 'real-estate-manager' ),
            'help' => __( 'Provide video URL', 'real-estate-manager' ),
        ),
		array(
	        'key' => 'file_attachments',
	        'type' => 'upload',
	        'tab' => 'property_attachments',
	        'default' => '',
	        'title' => __( 'File Attachments', 'real-estate-manager' ),
	        'help' => __( 'One file ID per line', 'real-estate-manager' ),
		),
        array(
            'key' => 'after_price_text',
            'type' => 'text',
            'tab' => 'general_settings',
            'default' => '',
            'title' => __( 'After Price', 'real-estate-manager' ),
            'help' => __( 'Text to display after price, Eg: / Month', 'real-estate-manager' ),
        ),        
	);

	
	$builtin_fields = $this->single_property_fields_builtin();
    $dynamic_fields = $this->single_property_fields();

    foreach ($builtin_fields as $field) {
        $inputFields[] = $field;
    }

	foreach ($dynamic_fields as $field) {
		$inputFields[] = $field;
	}

    $property_individual_cbs = $this->get_all_property_features();

    foreach ($property_individual_cbs as $cb) {
        $field_option = array(
            'key' => $cb,
            'type' => 'checkbox',
            'tab' => 'property_details',
            'default' => '',
            'title' => $cb,
            'help' => __( 'Check if property have this option', 'real-estate-manager' ),
        );
        $inputFields[] = $field_option;
    }

	function rem_render_field($field){
		global $post;
		$saved_value = get_post_meta( $post->ID, 'rem_'.$field['key'], true );

		$value = ($saved_value != '') ? $saved_value : $field['default'] ;

		if ($field['type'] == 'text' || $field['type'] == 'number') {

			echo '<input id="'.$field['key'].'" class="form-control input-sm" type="'.$field['type'].'" name="rem_property_data['.$field['key'].']" value="'.$value.'">';

		} elseif ($field['type'] == 'select') { ?>
			<select id="<?php echo $field['key'] ?>" name="rem_property_data[<?php echo $field['key']; ?>]" class="form-control input-sm">
				<?php
					$options = (is_array($field['options'])) ? $field['options'] : explode("\n", $field['options']);
					foreach ($options as $name) {
						echo '<option value="'.stripcslashes($name).'" '.selected( $value, $name, false ).'>'.stripcslashes($name).'</option>';
					}
				?>
			</select>
		<?php } elseif ($field['type'] == 'upload') { ?>
            <div class="input-group">
                <textarea id="<?php echo $field['key']; ?>" name="rem_property_data[<?php echo $field['key']; ?>]" class="form-control custom-control place-attachment" rows="2" style="resize:none;"><?php echo stripcslashes($value); ?></textarea>     
                <span class="upload-attachment input-group-addon btn btn-info"><?php _e( 'Upload', 'real-estate-manager' ); ?></span>
            </div>

		<?php } elseif ($field['type'] == 'widget') { ?>
			<select name="rem_property_data[<?php echo $field['key']; ?>]" class="form-control input-sm">
				<?php
					foreach ($GLOBALS['wp_registered_sidebars'] as $sidebar) {
						echo '<option value="'.$sidebar['id'].'" '.selected( $saved_m[$field['key']], $sidebar['id'], true ).'>'.$sidebar['name'].'</option>';
					}
				?>
			</select>
		<?php } elseif ($field['type'] == 'checkbox') {

			$saved_value = get_post_meta( $post->ID, 'rem_property_detail_cbs', true );
			$value = (isset($saved_value[$field['key']])) ? $saved_value[$field['key']] : $field['default']; ?>
				<div class="onoffswitch">
				    <input type="checkbox" <?php checked( $value, 'on', true); ?> value="on" name="rem_property_data[property_detail_cbs][<?php echo $field['key']; ?>]" class="onoffswitch-checkbox" id="<?php echo $field['key']; ?>">
				    <label class="onoffswitch-label" for="<?php echo $field['key']; ?>">
				        <span class="onoffswitch-inner" data-off="<?php _e( 'NO', 'real-estate-manager' ); ?>" data-on="<?php _e( 'YES', 'real-estate-manager' ); ?>"></span>
				        <span class="onoffswitch-switch"></span>
				    </label>
				</div>
		<?php }
	}
?>