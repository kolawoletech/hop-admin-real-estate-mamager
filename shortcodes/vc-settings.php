<?php

	$default_fields = $rem_ob->single_property_fields_builtin();
	$custom_fields = $rem_ob->single_property_fields();		
	$default_fields = array_merge($default_fields, $custom_fields);

	$fields_to_show = array( __( 'Search Field', 'real-estate-manager' ) => 'search' );

	foreach ($default_fields as $field) {
		$fields_to_show[$field['title']] = $field['key'];
	}

	$shortcodes = array(
		array(
			'name'		=>	 	__( 'Register Agent', 'real-estate-manager' ),
			'base'		=>		'rem_register_agent',
			'category'	=>		__( 'Real Estate Manager', 'real-estate-manager' ),
			'icon' 		=> plugins_url( '/assets/images/icon.png', dirname(__FILE__) ),
    		'description'	=>	__( 'Renders a form to register new agent', 'real-estate-manager' ),
			'params'	=>		array(
				array(
    				'type'			=>	'textfield',
    				'param_name'	=>	'redirect',
    				'heading'		=>	__( 'Redirect', 'real-estate-manager' ),
    				'description'	=>	__( 'Provide URL to redirect after successfull registration', 'real-estate-manager' ),
				),				
				array(
    				'type'			=>	'textarea_html',
    				'param_name'	=>	'content',
    				'heading'		=>	__( 'Content for Logged In Users', 'real-estate-manager' ),
    				'description'	=>	__( 'Provide content for already logged in users', 'real-estate-manager' ),
				),
			),
		),
		array(
			'name'		=>	 	__( 'Edit Agent Profile', 'real-estate-manager' ),
			'base'		=>		'rem_agent_edit',
			'category'	=>		__( 'Real Estate Manager', 'real-estate-manager' ),
			'icon' 		=> plugins_url( '/assets/images/icon.png', dirname(__FILE__) ),
    		'description'	=>	__( 'Renders a form to edit logged in agent\'s profile', 'real-estate-manager' ),
			'params'	=>		array(
				array(
    				'type'			=>	'textarea_html',
    				'param_name'	=>	'content',
    				'heading'		=>	__( 'Content for Non Logged In Users', 'real-estate-manager' ),
    				'description'	=>	__( 'Provide content for non logged in users', 'real-estate-manager' ),
				),
			),
		),
		array(
			'name'		=>	 	__( 'Login Agent', 'real-estate-manager' ),
			'base'		=>		'rem_agent_login',
			'category'	=>		__( 'Real Estate Manager', 'real-estate-manager' ),
			'icon' 		=> plugins_url( '/assets/images/icon.png', dirname(__FILE__) ),
			'description'	=>	__( 'Renders an AJAX based login form', 'real-estate-manager' ),
			'params'	=>		array(
				array(
    				'type'			=>	'textfield',
    				'param_name'	=>	'heading',
    				'heading'		=>	__( 'Heading', 'real-estate-manager' ),
    				'description'	=>	__( 'Heading will appear above the login form', 'real-estate-manager' ),
				),
				array(
    				'type'			=>	'textfield',
    				'param_name'	=>	'redirect',
    				'heading'		=>	__( 'Redirect', 'real-estate-manager' ),
    				'description'	=>	__( 'Provide URL to redirect after successfull login', 'real-estate-manager' ),
				),
				array(
    				'type'			=>	'textarea_html',
    				'param_name'	=>	'content',
    				'heading'		=>	__( 'Content for Logged In Users', 'real-estate-manager' ),
    				'description'	=>	__( 'Provide content for already logged in users', 'real-estate-manager' ),
				),
			),
		),
		array(
			'name'		=>	 	__( 'Create Property', 'real-estate-manager' ),
			'base'		=>		'rem_create_property',
			'category'	=>		__( 'Real Estate Manager', 'real-estate-manager' ),
			'icon' 		=> plugins_url( '/assets/images/icon.png', dirname(__FILE__) ),
			'description'	=>	__( 'Renders a form to create property', 'real-estate-manager' ),
			'params'	=>		array(
				array(
    				'type'			=>	'textarea_html',
    				'param_name'	=>	'content',
    				'heading'		=>	__( 'Content for Non Logged In Users', 'real-estate-manager' ),
    				'description'	=>	__( 'Provide content to display if user is not logged in', 'real-estate-manager' ),
				),
			),
		),
		array(
			'name'		=>	 	__( 'Edit Property', 'real-estate-manager' ),
			'base'		=>		'rem_edit_property',
			'category'	=>		__( 'Real Estate Manager', 'real-estate-manager' ),
			'icon' 		=> plugins_url( '/assets/images/icon.png', dirname(__FILE__) ),
			'description'	=>	__( 'Renders a form to edit property', 'real-estate-manager' ),
			'params'	=>		array(
				array(
    				'type'			=>	'textarea_html',
    				'param_name'	=>	'content',
    				'heading'		=>	__( 'Content for Non Logged In Users', 'real-estate-manager' ),
    				'description'	=>	__( 'Provide content to display if user is not logged in', 'real-estate-manager' ),
				),
			),
		),
		array(
			'name'		=>	 	__( 'Single Property', 'real-estate-manager' ),
			'base'		=>		'rem_property',
			'category'	=>		__( 'Real Estate Manager', 'real-estate-manager' ),
			'icon' 		=> plugins_url( '/assets/images/icon.png', dirname(__FILE__) ),
			'description'	=>	__( 'Display a single property', 'real-estate-manager' ),
			'params'	=>		array(
				array(
    				'type'			=>	'textfield',
    				'param_name'	=>	'id',
    				'heading'		=>	__( 'Property ID', 'real-estate-manager' ),
    				'description'	=>	__( 'Provide property id here', 'real-estate-manager' ),
				),
			),
		),
		array(
			'name'		=>	 	__( 'List Properties', 'real-estate-manager' ),
			'base'		=>		'rem_list_properties',
			'category'	=>		__( 'Real Estate Manager', 'real-estate-manager' ),
			'icon' 		=> plugins_url( '/assets/images/icon.png', dirname(__FILE__) ),
			'description'	=>	__( 'Displays properties according to the settings', 'real-estate-manager' ),
			'params'	=>		array(
				array(
		            'type' 			=> 'dropdown',
		            'param_name' 	=> 'order',
		            'heading' 		=> __('Order', 'real-estate-manager'),
		            'description' 	=> __('Choose order to display properties', 'real-estate-manager'),
		            'value' => array(
		                __('Ascending', 'real-estate-manager') => 'ASC',
		                __('Descending', 'real-estate-manager') => 'DESC',
		            ),
				),
				array(
		            'type' 			=> 'dropdown',
		            'param_name' 	=> 'orderby',
		            'heading' 		=> __('Order By', 'real-estate-manager'),
		            'description' 	=> __('Choose order by to display properties', 'real-estate-manager'),
		            'value' => array(
		                __('Date', 'real-estate-manager') => 'date',
		                __('Agent', 'real-estate-manager') => 'author',
		                __('Property Name', 'real-estate-manager') => 'title',
		                __('Random', 'real-estate-manager') => 'rand',
		            ),
				),
				array(
		            'type' 			=> 'dropdown',
		            'param_name' 	=> 'style',
		            'heading' 		=> __('Property Style', 'real-estate-manager'),
		            'description' 	=> __('Choose properties display style', 'real-estate-manager'),
		            'value' => array(
		                __('List', 'real-estate-manager') => '1',
		                __('Grid 1', 'real-estate-manager') => '2',
		                __('Grid 2', 'real-estate-manager') => '3',
		                __('Grid 3', 'real-estate-manager') => '4',
		                __('Grid 4', 'real-estate-manager') => '6',
		            ),
				),
				array(
		            'type' 			=> 'dropdown',
		            'param_name' 	=> 'class',
		            'heading' 		=> __('Columns', 'real-estate-manager'),
		            'description' 	=> __('Number of properties in a row', 'real-estate-manager'),
		            'value' => array(
		                __('2 Columns', 'real-estate-manager') => 'col-sm-6',
		                __('3 Columns', 'real-estate-manager') => 'col-sm-4',
		                __('4 Columns', 'real-estate-manager') => 'col-sm-3',
		            ),
		            'dependency' => array(
		                'element' => 'style',
		                'value' => array( '2', '3', '4', '6' ),
		            ),
				),
				array(
		            'type' 			=> 'textfield',
		            'param_name' 	=> 'posts',
		            'heading' 		=> __('Number of Properties in a Page', 'real-estate-manager'),
		            'description' 	=> __('Provide total number of properties to show, after that pagination will display', 'real-estate-manager'),
				),
				array(
		            'type' 			=> 'dropdown',
		            'param_name' 	=> 'purpose',
		            'heading' 		=> __('Property Purpose', 'real-estate-manager'),
		            'description' 	=> __('Choose to display properties of specific purpose', 'real-estate-manager'),
		            'value' => $property_purposes,
				),
				array(
		            'type' 			=> 'dropdown',
		            'param_name' 	=> 'type',
		            'heading' 		=> __('Property Type', 'real-estate-manager'),
		            'description' 	=> __('Choose to display properties of specific type', 'real-estate-manager'),
		            'value' => $property_types,
				),
				array(
		            'type' 			=> 'dropdown',
		            'param_name' 	=> 'status',
		            'heading' 		=> __('Property Status', 'real-estate-manager'),
		            'description' 	=> __('Choose to display properties of specific status', 'real-estate-manager'),
		            'value' => $property_status,
				),
				array(
		            'type' 			=> 'textfield',
		            'param_name' 	=> 'tags',
		            'heading' 		=> __('Property Tags', 'real-estate-manager'),
		            'description' 	=> __('Comma separated list of tags to filter properties', 'real-estate-manager'),
		            'value' => $property_status,
				),
		        array(
		            'type' 			=> 'exploded_textarea',
		            'param_name' 	=> 'meta',
		            'heading' 		=> __('Filter Properties', 'real-estate-manager'),
		            'description' 	=> __('Provide meta key and value on each line to filter. Eg: property_status|normal', 'real-estate-manager'),
		        ),
				array(
		            'type' 			=> 'dropdown',
		            'param_name' 	=> 'nearest_porperties',
		            'heading' 		=> __('Prefer Nearest Properties', 'real-estate-manager'),
		            'description' 	=> __('It will enable Geo Location Trackor to track visitors location and will display properties near them', 'real-estate-manager'),
		            'value' => array(
		                __('Disable', 'real-estate-manager') => 'disable',
		                __('Enable', 'real-estate-manager') => 'enable',
		            ),
				),
			),
		),
		array(
			'name'		=>	 	__( 'My Properties', 'real-estate-manager' ),
			'base'		=>		'rem_my_properties',
			'category'	=>		__( 'Real Estate Manager', 'real-estate-manager' ),
			'icon' 		=> plugins_url( '/assets/images/icon.png', dirname(__FILE__) ),
			'description'	=>	__( 'Displays properties of current logged in agent', 'real-estate-manager' ),
			'params'	=>		array(
				array(
    				'type'			=>	'textarea_html',
    				'param_name'	=>	'content',
    				'heading'		=>	__( 'Content for Non Logged In Users', 'real-estate-manager' ),
    				'description'	=>	__( 'Provide content to display if user is not logged in', 'real-estate-manager' ),
				),
			),
		),
		array(
			'name'		=>	 	__( 'Agent Profile', 'real-estate-manager' ),
			'base'		=>		'rem_agent_profile',
			'category'	=>		__( 'Real Estate Manager', 'real-estate-manager' ),
			'icon' 		=> plugins_url( '/assets/images/icon.png', dirname(__FILE__) ),
			'description'	=>	__( 'Displays profile of specific agent', 'real-estate-manager' ),
			'params'	=>		array(
		        array(
		            'type' 			=> 'dropdown',
		            'param_name' 	=> 'author_id',
		            'heading' 		=> __('Agent', 'real-estate-manager'),
		            'description' 	=> __('Choose agent who\'s profile you want to display', 'real-estate-manager'),
		            'value' => $agents_arr,
		        ),
			),
		),
		array(
			'name'		=>	 	__( 'Search Results', 'real-estate-manager' ),
			'base'		=>		'rem_search_results',
			'category'	=>		__( 'Real Estate Manager', 'real-estate-manager' ),
			'icon' 		=> plugins_url( '/assets/images/icon.png', dirname(__FILE__) ),
			'description'	=>	__( 'Displays search results if searched from widget', 'real-estate-manager' ),
			'show_settings_on_create' => false,
		),
		array(
			'name'		=>	 	__( 'Properties Map', 'real-estate-manager' ),
			'base'		=>		'rem_maps',
			'category'	=>		__( 'Real Estate Manager', 'real-estate-manager' ),
			'icon' 		=> plugins_url( '/assets/images/icon.png', dirname(__FILE__) ),
			'description'	=>	__( 'Displays properties on a large map', 'real-estate-manager' ),
			'params'	=> array(
		        array(
		            'type' 			=> 'dropdown',
		            'param_name' 	=> 'query_type',
		            'heading' 		=> __('Display Properties', 'real-estate-manager'),
		            'description' 	=> __('How you want to display properties on map', 'real-estate-manager'),
		            'value' => array(
		                __('Properties by IDs', 'real-estate-manager') => 'ids',
		                __('Use Property Query', 'real-estate-manager') => 'p_query',
		            ),
		        ),				
		        array(
		            "type" => "exploded_textarea",
		            "param_name" => "ids",
		            "heading" => __("Property IDs", 'real-estate-manager'),
		            "description" => __("Property ID each per line to display on map", 'real-estate-manager'),
		            'dependency' => array(
		                'element' => 'query_type',
		                'value' => array( 'ids' ),
		            ),
		        ),
				array(
		            'type' 			=> 'dropdown',
		            'param_name' 	=> 'order',
		            'heading' 		=> __('Order', 'real-estate-manager'),
		            'description' 	=> __('Choose order to display properties', 'real-estate-manager'),
		            'value' => array(
		                __('Ascending', 'real-estate-manager') => 'ASC',
		                __('Descending', 'real-estate-manager') => 'DESC',
		            ),
		            'dependency' => array(
		                'element' => 'query_type',
		                'value' => array( 'p_query' ),
		            ),
				),
				array(
		            'type' 			=> 'dropdown',
		            'param_name' 	=> 'orderby',
		            'heading' 		=> __('Order By', 'real-estate-manager'),
		            'description' 	=> __('Choose order by to display properties', 'real-estate-manager'),
		            'value' => array(
		                __('Date', 'real-estate-manager') => 'date',
		                __('Agent', 'real-estate-manager') => 'author',
		                __('Property Name', 'real-estate-manager') => 'title',
		            ),
		            'dependency' => array(
		                'element' => 'query_type',
		                'value' => array( 'p_query' ),
		            ),
				),
				array(
		            'type' 			=> 'textfield',
		            'param_name' 	=> 'total_properties',
		            'heading' 		=> __('Number of Properties', 'real-estate-manager'),
		            'description' 	=> __('Provide total number of properties to show. -1 for all', 'real-estate-manager'),
		            'dependency' => array(
		                'element' => 'query_type',
		                'value' => array( 'p_query' ),
		            ),		            
				),
		        array(
		            'type' 			=> 'exploded_textarea',
		            'param_name' 	=> 'meta',
		            'heading' 		=> __('Filter Properties', 'real-estate-manager'),
		            'description' 	=> __('Provide meta key and value on each line to filter. Eg: property_status|normal', 'real-estate-manager'),
		            'dependency' => array(
		                'element' => 'query_type',
		                'value' => array( 'p_query' ),
		            ),
		        ),				
				array(
		            'type' 			=> 'dropdown',
		            'param_name' 	=> 'type_filtering',
		            'heading' 		=> __('Property Type Filtering', 'real-estate-manager'),
		            'description' 	=> __('Enable to display property type buttons below maps to filter', 'real-estate-manager'),
		            'value' => array(
		                __('Disable', 'real-estate-manager') => 'disable',
		                __('Enable', 'real-estate-manager') => 'enable',
		            ),
				),
		        array(
		            'type' 			=> 'exploded_textarea',
		            'param_name' 	=> 'tags',
		            'heading' 		=> __('Filter by Tags', 'real-estate-manager'),
		            'description' 	=> __('Provide single tag on each line to filter.', 'real-estate-manager'),
		            'dependency' => array(
		                'element' => 'query_type',
		                'value' => array( 'p_query' ),
		            ),
		        ),
				array(
		            'type' 			=> 'dropdown',
		            'param_name' 	=> 'nearest_porperties',
		            'heading' 		=> __('Prefer Nearest Properties', 'real-estate-manager'),
		            'description' 	=> __('It will enable Geo Location Trackor to track visitors location and will display properties near them', 'real-estate-manager'),
		            'value' => array(
		                __('Disable', 'real-estate-manager') => 'disable',
		                __('Enable', 'real-estate-manager') => 'enable',
		            ),
				),
		        array(
		            'type' 			=> 'textfield',
		            'param_name' 	=> 'map_height',
		            'heading' 		=> __('Map Height', 'real-estate-manager'),
		            'description' 	=> __('Provide map height Eg: 550px', 'real-estate-manager'),
		        ),
		        array(
		            "type" => "textfield",
		            "param_name" => "load_heading",
		            "heading" => __("Loading Heading", 'real-estate-manager'),
		            "description" => __("Provide map loading text heading", 'real-estate-manager'),
		            "group" => __("Settings", 'real-estate-manager'),
		        ),
		        array(
		            "type" => "textfield",
		            "param_name" => "load_desc",
		            "heading" => __("Loading Description", 'real-estate-manager'),
		            "description" => __("Provide map loading text description", 'real-estate-manager'),
		            "group" => __("Settings", 'real-estate-manager'),
		        ),
		        array(
		            "type" => "colorpicker",
		            "param_name" => "btn_bg_color",
		            "heading" => __("Buttons Background Color", 'real-estate-manager'),
		            "description" => __("Choose background color for map buttons", 'real-estate-manager'),
		            "group" => __("Colors", 'real-estate-manager'),
		        ),
		        array(
		            "type" => "colorpicker",
		            "param_name" => "btn_text_color",
		            "heading" => __("Buttons Text Color", 'real-estate-manager'),
		            "description" => __("Choose text color for map buttons", 'real-estate-manager'),
		            "group" => __("Colors", 'real-estate-manager'),
		        ),
		        array(
		            "type" => "colorpicker",
		            "param_name" => "btn_bg_color_hover",
		            "heading" => __("Buttons Background Color - Hover", 'real-estate-manager'),
		            "description" => __("Choose hover background color for map buttons", 'real-estate-manager'),
		            "group" => __("Colors", 'real-estate-manager'),
		        ),
		        array(
		            "type" => "colorpicker",
		            "param_name" => "btn_text_color_hover",
		            "heading" => __("Buttons Text Color - Hover", 'real-estate-manager'),
		            "description" => __("Choose text hover color for map buttons", 'real-estate-manager'),
		            "group" => __("Colors", 'real-estate-manager'),
		        ),
		        array(
		            "type" => "colorpicker",
		            "param_name" => "loader_color",
		            "heading" => __("Loader Color", 'real-estate-manager'),
		            "description" => __("Choose color for maps loader box", 'real-estate-manager'),
		            "group" => __("Colors", 'real-estate-manager'),
		        ),

		        array(
		            "type" => "colorpicker",
		            "param_name" => "water_color",
		            "heading" => __("Water Color", 'real-estate-manager'),
		            "description" => __("Choose water color in map", 'real-estate-manager'),
		            "group" => __("Map Colors", 'real-estate-manager'),
		        ),
		        array(
		            "type" => "colorpicker",
		            "param_name" => "fill_color",
		            "heading" => __("Fill Color", 'real-estate-manager'),
		            "description" => __("Choose natural fill color in map", 'real-estate-manager'),
		            "group" => __("Map Colors", 'real-estate-manager'),
		        ),
		        array(
		            "type" => "colorpicker",
		            "param_name" => "poi_color",
		            "heading" => __("Points of Interest Color", 'real-estate-manager'),
		            "description" => __("Choose poi color in map", 'real-estate-manager'),
		            "group" => __("Map Colors", 'real-estate-manager'),
		        ),
		        array(
		            "type" => "colorpicker",
		            "param_name" => "poi_color_hue",
		            "heading" => __("Points of Interest Hue Color", 'real-estate-manager'),
		            "description" => __("Choose poi hue color in map", 'real-estate-manager'),
		            "group" => __("Map Colors", 'real-estate-manager'),
		        ),
		        array(
		            "type" => "textfield",
		            "param_name" => "roads_lightness",
		            "heading" => __("Road Lightness", 'real-estate-manager'),
		            "description" => __("Choose road lightness in map, Default: 100", 'real-estate-manager'),
		            "group" => __("Map Colors", 'real-estate-manager'),
		        ),
		        array(
		            "type" => "textfield",
		            "param_name" => "lines_lightness",
		            "heading" => __("Lines Lightness", 'real-estate-manager'),
		            "description" => __("Choose line lightness in map, Default: 700", 'real-estate-manager'),
		            "group" => __("Map Colors", 'real-estate-manager'),
		        ),
		        array(
		            "type" => "colorpicker",
		            "param_name" => "bottom_btn_bg_color",
		            "heading" => __("Buttons Background Color", 'real-estate-manager'),
		            "description" => __("Background color for bottom buttons", 'real-estate-manager'),
		            "group" => __("Filter Options", 'real-estate-manager'),
		            'dependency' => array(
		                'element' => 'type_filtering',
		                'value' => array( 'enable' ),
		            ),
		        ),
		        array(
		            "type" => "colorpicker",
		            "param_name" => "bottom_btn_text_color",
		            "heading" => __("Buttons Text Color", 'real-estate-manager'),
		            "description" => __("Text color for bottom buttons", 'real-estate-manager'),
		            "group" => __("Filter Options", 'real-estate-manager'),
		            'dependency' => array(
		                'element' => 'type_filtering',
		                'value' => array( 'enable' ),
		            ),
		        ),
		        array(
		            "type" => "colorpicker",
		            "param_name" => "bottom_btn_bg_color_hover",
		            "heading" => __("Buttons Background Color - Hover", 'real-estate-manager'),
		            "description" => __("Background color for bottom buttons on hover", 'real-estate-manager'),
		            "group" => __("Filter Options", 'real-estate-manager'),
		            'dependency' => array(
		                'element' => 'type_filtering',
		                'value' => array( 'enable' ),
		            ),
		        ),
		        array(
		            "type" => "colorpicker",
		            "param_name" => "bottom_btn_text_color_hover",
		            "heading" => __("Buttons Text Color - Hover", 'real-estate-manager'),
		            "description" => __("Text color for bottom buttons on hover", 'real-estate-manager'),
		            "group" => __("Filter Options", 'real-estate-manager'),
		            'dependency' => array(
		                'element' => 'type_filtering',
		                'value' => array( 'enable' ),
		            ),
		        ),
		        array(
		            "type" => "colorpicker",
		            "param_name" => "bottom_btn_bg_color_active",
		            "heading" => __("Buttons Background Color - Active", 'real-estate-manager'),
		            "description" => __("Background color for bottom buttons on active", 'real-estate-manager'),
		            "group" => __("Filter Options", 'real-estate-manager'),
		            'dependency' => array(
		                'element' => 'type_filtering',
		                'value' => array( 'enable' ),
		            ),
		        ),
			)
		),
		array(
			'name'		=>	 	__( 'Search Property', 'real-estate-manager' ),
			'base'		=>		'rem_search_property',
			'category'	=>		__( 'Real Estate Manager', 'real-estate-manager' ),
			'icon' 		=> plugins_url( '/assets/images/icon.png', dirname(__FILE__) ),
			'description'	=>	__( 'Renders a form to search properties via AJAX', 'real-estate-manager' ),
			'params'	=>		array(
				array(
    				'type'			=>	'checkbox',
    				'param_name'	=>	'fields_to_show',
    				'heading'		=>	__( 'Check Fields to Display', 'real-estate-manager' ),
    				'description'	=>	__( 'Check the required fields for search menu', 'real-estate-manager' ),
		            'value' => $fields_to_show,    				
				),
		        array(
		            'type' 			=> 'dropdown',
		            'param_name' 	=> 'columns',
		            'heading' 		=> __('Columns', 'real-estate-manager'),
		            'description' 	=> __('Choose number of fields in each row', 'real-estate-manager'),
		            'value' => array(
		                __('2 Columns', 'real-estate-manager') => '6',
		                __('3 Columns', 'real-estate-manager') => '4',
		                __('4 Columns', 'real-estate-manager') => '3',
		                __('6 Columns', 'real-estate-manager') => '2',
		            ),
		        ),
		        array(
		            'type' 			=> 'textfield',
		            'param_name' 	=> 'search_btn_text',
		            'heading' 		=> __('Search Button Title', 'real-estate-manager'),
		            'description' 	=> __('Provide text for search button', 'real-estate-manager'),
		        ),
		        array(
		            'type' 			=> 'textfield',
		            'param_name' 	=> 'filters_btn_text',
		            'heading' 		=> __('Filter Button Title', 'real-estate-manager'),
		            'description' 	=> __('Provide text for more filter button', 'real-estate-manager'),
		        ),
		        array(
		            'type' 			=> 'vc_link',
		            'param_name' 	=> 'results_page',
		            'heading' 		=> __('Results Page', 'real-estate-manager'),
		            'description' 	=> __('Provide url, it will disable AJAX search and will open up that page to display results. Make sure to paste shortcode [rem_search_results] on provided page to display results.', 'real-estate-manager'),
		        ),
		        array(
		            'type' 			=> 'textfield',
		            'param_name' 	=> 'search_btn_target',
		            'heading' 		=> __('Form Target', 'real-estate-manager'),
		            'description' 	=> __('_blank if you want to open results in separate page', 'real-estate-manager'),
		        ),
		        array(
		            'type' 			=> 'exploded_textarea',
		            'param_name' 	=> 'fixed_fields',
		            'heading' 		=> __('Fixed Fields', 'real-estate-manager'),
		            'description' 	=> __('Provide data for fixed fields on each line. Eg: property_status|normal', 'real-estate-manager'),
		        ),
				array(
    				'type'			=>	'textarea_html',
    				'param_name'	=>	'content',
    				'heading'		=>	__( 'Hard Coded Contents', 'real-estate-manager' ),
    				'description'	=>	__( 'You can paste shortcode here to list some default properties', 'real-estate-manager' ),
				),
			),
		),

		array(
			'name'		=>	 	__( 'Touch Carousel', 'real-estate-manager' ),
			'base'		=>		'rem_carousel',
			'category'	=>		__( 'Real Estate Manager', 'real-estate-manager' ),
			'icon' 		=> plugins_url( '/assets/images/icon.png', dirname(__FILE__) ),
			'description'	=>	__( 'Renders responsive carousel of properties', 'real-estate-manager' ),
			'params'	=>		array(
				array(
		            'type' 			=> 'dropdown',
		            'param_name' 	=> 'order',
		            'heading' 		=> __('Order', 'real-estate-manager'),
		            'description' 	=> __('Choose order to display properties', 'real-estate-manager'),
		            'value' => array(
		                __('Ascending', 'real-estate-manager') => 'ASC',
		                __('Descending', 'real-estate-manager') => 'DESC',
		            ),
				),
				array(
		            'type' 			=> 'dropdown',
		            'param_name' 	=> 'orderby',
		            'heading' 		=> __('Order By', 'real-estate-manager'),
		            'description' 	=> __('Choose order by to display properties', 'real-estate-manager'),
		            'value' => array(
		                __('Date', 'real-estate-manager') => 'date',
		                __('Agent', 'real-estate-manager') => 'author',
		                __('Property Name', 'real-estate-manager') => 'title',
		                __('Random', 'real-estate-manager') => 'rand',
		            ),
				),
				array(
		            'type' 			=> 'dropdown',
		            'param_name' 	=> 'style',
		            'heading' 		=> __('Property Style', 'real-estate-manager'),
		            'description' 	=> __('Choose properties display style', 'real-estate-manager'),
		            'value' => array(
		                __('List', 'real-estate-manager') => '1',
		                __('Grid 1', 'real-estate-manager') => '2',
		                __('Grid 2', 'real-estate-manager') => '3',
		                __('Grid 3', 'real-estate-manager') => '4',
		                __('Grid 4', 'real-estate-manager') => '6',
		            ),
				),
				array(
		            'type' 			=> 'textfield',
		            'param_name' 	=> 'total_properties',
		            'heading' 		=> __('Total Properties', 'real-estate-manager'),
		            'description' 	=> __('Provide total number of properties to show', 'real-estate-manager'),
				),
		        array(
		            'type' 			=> 'exploded_textarea',
		            'param_name' 	=> 'meta',
		            'heading' 		=> __('Filter Properties', 'real-estate-manager'),
		            'description' 	=> __('Provide meta key and value on each line to filter. Eg: property_status|normal', 'real-estate-manager'),
		        ),
		        array(
		            'type' 			=> 'exploded_textarea',
		            'param_name' 	=> 'tags',
		            'heading' 		=> __('Tags', 'real-estate-manager'),
		            'description' 	=> __('Provide tags each per line to display specific properties', 'real-estate-manager'),
		        ),
		        array(
		            "type" => "exploded_textarea",
		            "param_name" => "ids",
		            "heading" => __("Property IDs", 'real-estate-manager'),
		            "description" => __("Provide IDs if you want to display specific properties, each per line", 'real-estate-manager'),
		        ),
				array(
		            'type' 			=> 'dropdown',
		            'param_name' 	=> 'nearest_porperties',
		            'heading' 		=> __('Prefer Nearest Properties', 'real-estate-manager'),
		            'description' 	=> __('It will enable Geo Location Trackor to track visitors location and will display properties near them', 'real-estate-manager'),
		            'value' => array(
		                __('Disable', 'real-estate-manager') => 'disable',
		                __('Enable', 'real-estate-manager') => 'enable',
		            ),
				),

		        array(
		            "type" => "textfield",
		            "param_name" => "slidestoshow",
		            "heading" => __("Properties in Row", 'real-estate-manager'),
		            "description" => __("Provide number of properties you want to show at a time", 'real-estate-manager'),
		            "group" => "Carousel Settings",
		        ),
		        array(
		            "type" => "textfield",
		            "param_name" => "slidestoscroll",
		            "heading" => __("Properties to Scroll", 'real-estate-manager'),
		            "description" => __("Provide number of properties you want to scroll at a time", 'real-estate-manager'),
		            "group" => "Carousel Settings",
		        ),
		        array(
		            "type" => "textfield",
		            "param_name" => "speed",
		            "heading" => __("Speed", 'real-estate-manager'),
		            "description" => __("Speed in ms Eg: 2000", 'real-estate-manager'),
		            "group" => "Carousel Settings",
		        ),
				array(
		            'type' 			=> 'dropdown',
		            'param_name' 	=> 'autoplay',
		            'heading' 		=> __('Auto Play', 'real-estate-manager'),
		            'description' 	=> __('Enable to display auto rotation of properties', 'real-estate-manager'),
		            'value' => array(
		                __('Disable', 'real-estate-manager') => 'disable',
		                __('Enable', 'real-estate-manager') => 'enable',
		            ),
		            "group" => "Carousel Settings",
				),
				array(
		            'type' 			=> 'textfield',
		            'param_name' 	=> 'autoplayspeed',
		            'heading' 		=> __('Auto Play Speed', 'real-estate-manager'),
		            'description' 	=> __('Auto play speed in ms Eg: 2000', 'real-estate-manager'),
		            "group" => "Carousel Settings",
				),
				array(
		            'type' 			=> 'dropdown',
		            'param_name' 	=> 'arrows',
		            'heading' 		=> __('Arrows', 'real-estate-manager'),
		            'description' 	=> __('Enable to display arrows for navigation', 'real-estate-manager'),
		            'value' => array(
		                __('Disable', 'real-estate-manager') => 'disable',
		                __('Enable', 'real-estate-manager') => 'enable',
		            ),
		            "group" => "Carousel Settings",
				),
				array(
		            'type' 			=> 'dropdown',
		            'param_name' 	=> 'dots',
		            'heading' 		=> __('Dots', 'real-estate-manager'),
		            'description' 	=> __('Enable to display bottom dots for navigation', 'real-estate-manager'),
		            'value' => array(
		                __('Disable', 'real-estate-manager') => 'disable',
		                __('Enable', 'real-estate-manager') => 'enable',
		            ),
		            "group" => "Carousel Settings",
				),
			),
		),
	);

?>