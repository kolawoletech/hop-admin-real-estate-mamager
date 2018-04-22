<?php

$fieldsData = array(

    array(
        'panel_title'   =>  __( 'Currency Options', 'real-estate-manager' ),

        'fields'        => array(

            array(
                'type' => 'currency',
                'name' => 'currency',
                'title' => __( 'Currency', 'real-estate-manager' ),
                'help' => __( 'Currency Symbol for Properties', 'real-estate-manager' ),
            ),


            array(
                'type' => 'select',
                'name' => 'currency_position',
                'title' => __( 'Currency Position', 'real-estate-manager' ),
                'options' => array(
                    'left' => __( 'Left', 'real-estate-manager' ),
                    'right' => __( 'Right', 'real-estate-manager' ),
                    'left_space' => __( 'Left with Space', 'real-estate-manager' ),
                    'right_space' => __( 'Right with Space', 'real-estate-manager' ),
                ),
                'help' => __( 'Position of the Currency Symbol', 'real-estate-manager' ),
            ),

            array(
                'type' => 'text',
                'name' => 'thousand_separator',
                'title' => __( 'Thousand Separator', 'real-estate-manager' ),
                'help' => __( 'Thousand separator of display price', 'real-estate-manager' ),
                'default' => ',',
            ),

            array(
                'type' => 'text',
                'name' => 'decimal_separator',
                'title' => __( 'Decimal Separator', 'real-estate-manager' ),
                'help' => __( 'Decimal separator of display price', 'real-estate-manager' ),
                'default' => '.',
            ),

            array(
                'type' => 'text',
                'name' => 'decimal_points',
                'title' => __( 'Number of Decimals', 'real-estate-manager' ),
                'help' => __( 'Number of decimal points shown in display price', 'real-estate-manager' ),
                'default' => '2',
            ),
        ),

    ),

    array(
        'panel_title'   =>  __( 'Property Settings', 'real-estate-manager' ),

        'fields'        => array(

            array(
                'type' => 'text',
                'name' => 'properties_per_page',
                'title' => __( 'Properties Per Page', 'real-estate-manager' ),
                'help' => __( 'Number of properties you want to display on search results and archive pages.', 'real-estate-manager' ),
            ),

            array(
                'type' => 'text',
                'name' => 'properties_area_unit',
                'title' => __( 'Area Unit', 'real-estate-manager' ),
                'help' => __( 'Provide unit of area Eg: Square Feet', 'real-estate-manager' ),
            ),            

            array(
                'type' => 'text',
                'name' => 'properties_excerpt_length',
                'title' => __( 'Excerpt Length', 'real-estate-manager' ),
                'help' => __( 'Number of words to be displayed from the property excerpt. Eg: 15', 'real-estate-manager' ),
            ),
            
            array(
                'type' => 'textarea',
                'name' => 'property_detail_fields',
                'title' => __( 'Property Features', 'real-estate-manager' ),
                'help' => __( 'One per line. This will add checkboxes to your property edit page for you to select. Leave blank to use default', 'real-estate-manager' ),
            ),

            array(
                'type' => 'textarea',
                'name' => 'property_type_options',
                'title' => __( 'Property Types', 'real-estate-manager' ),
                'help' => __( 'One per line. This will add property types to select from when entering properties. Leave blank to use default', 'real-estate-manager' ),
            ),

            array(
                'type' => 'textarea',
                'name' => 'property_purpose_options',
                'title' => __( 'Property Purposes', 'real-estate-manager' ),
                'help' => __( 'One per line. This will add property purposes to select from when entering properties. Leave blank to use default', 'real-estate-manager' ),
            ),

            array(
                'type' => 'textarea',
                'name' => 'property_status_options',
                'title' => __( 'Property Statuses', 'real-estate-manager' ),
                'help' => __( 'One per line. This will add property status to select from when entering properties. Leave blank to use default', 'real-estate-manager' ),
            ),

        ),

    ),

    array(
        
        'panel_title'   =>  __( 'Templates Settings', 'real-estate-manager' ),
        'fields'        => array(

            array(
                'type'  => 'select',
                'name'  => 'single_property_layout',
                'title' => __( 'Property Page Template', 'real-estate-manager' ),
                'help'  => __( 'Choose single property display layout', 'real-estate-manager' ),
                'options' => array(
                    'plugin' => __( 'Default', 'real-estate-manager' ),
                    'full_width' => __( 'Full Width', 'real-estate-manager' ),
                    'left_sidebar' => __( 'Left Sidebar', 'real-estate-manager' ),
                    'theme' => __( 'From Theme', 'real-estate-manager' ),
                ),
            ),
            array(
                'type'  => 'select',
                'name'  => 'archive_property_layout',
                'title' => __( 'Archive Page Template', 'real-estate-manager' ),
                'help'  => __( 'Choose tags and archive properties display layout', 'real-estate-manager' ),
                'options' => array(
                    'plugin' => __( 'From Plugin', 'real-estate-manager' ),
                    'theme' => __( 'From Theme', 'real-estate-manager' ),
                ),
            ),
            array(
                'type'  => 'select',
                'name'  => 'agent_page_layout',
                'title' => __( 'Agent Page Template', 'real-estate-manager' ),
                'help'  => __( 'Choose agent page display layout', 'real-estate-manager' ),
                'options' => array(
                    'plugin' => __( 'From Plugin', 'real-estate-manager' ),
                    'theme' => __( 'From Theme', 'real-estate-manager' ),
                ),
            ),
            array(
                'type'  => 'text',
                'name'  => 'templates_max_width',
                'title' => __( 'Container Maximum Width', 'real-estate-manager' ),
                'help'  => __( 'Provide container max width in px, eg: 1140px', 'real-estate-manager' ),
                'default'  => '1170px',
            ),
            array(
                'type'  => 'select',
                'name'  => 'property_page_agent_card',
                'title' => __( 'Property Page Sidebar Card', 'real-estate-manager' ),
                'help'  => __( 'Enable or disable default agent card and contact form on single property page', 'real-estate-manager' ),
                'options' => array(
                    'enable' => __( 'Enable', 'real-estate-manager' ),
                    'disable' => __( 'Disable', 'real-estate-manager' ),
                ),
            ),
            array(
                'type'  => 'select',
                'name'  => 'agent_page_agent_card',
                'title' => __( 'Agent Page Sidebar Card', 'real-estate-manager' ),
                'help'  => __( 'Enable or disable default agent card and contact form on single agent page', 'real-estate-manager' ),
                'options' => array(
                    'enable' => __( 'Enable', 'real-estate-manager' ),
                    'disable' => __( 'Disable', 'real-estate-manager' ),
                ),
            ),
            array(
                'type'  => 'widget',
                'name'  => 'property_page_sidebar',
                'title' => __( 'Property Page Sidebar', 'real-estate-manager' ),
                'help'  => __( 'Choose sidebar for single property page', 'real-estate-manager' ),
            ),
            array(
                'type'  => 'widget',
                'name'  => 'agent_page_sidebar',
                'title' => __( 'Agent Page Sidebar', 'real-estate-manager' ),
                'help'  => __( 'Choose sidebar for agent details page', 'real-estate-manager' ),
            ),
            array(
                'type'  => 'pages',
                'name'  => 'property_edit_page',
                'title' => __( 'Property Edit Page', 'real-estate-manager' ),
                'help'  => __( 'Paste shortcode [rem_edit_property] on selected page', 'real-estate-manager' ),
            ),
            array(
                'type'  => 'textarea',
                'name'  => 'inline_property_bar_fields',
                'title' => __( 'Inline Property Bar Fields', 'real-estate-manager' ),
                'help'  => __( 'Provide field names each per line to display on top bar of inline property listing style', 'real-estate-manager' ),
            ),

        ),

    ),

    array(
        'panel_title'   =>  __( 'Search Settings', 'real-estate-manager' ),

        'fields'        => array(

            array(
                'type' => 'select',
                'name' => 'search_results_style',
                'title' => __( 'Search Results Style', 'real-estate-manager' ),
                'help' => __( 'Choose style for search results', 'real-estate-manager' ),
                'options' => array(
                    '1' => __( 'Inline', 'real-estate-manager' ),
                    '2' => __( 'Box Style 1', 'real-estate-manager' ),
                    '3' => __( 'Box Style 2', 'real-estate-manager' ),
                    '4' => __( 'Box Style 3', 'real-estate-manager' ),
                    '6' => __( 'Box Style 4', 'real-estate-manager' ),
                    '5' => __( 'Full Box', 'real-estate-manager' ),
                ),
            ),

            array(
                'type' => 'select',
                'name' => 'search_results_cols',
                'title' => __( 'Search Results Columns', 'real-estate-manager' ),
                'help' => __( 'Choose columns in a row for box styles', 'real-estate-manager' ),
                'options' => array(
                    'col-sm-12' => __( '1', 'real-estate-manager' ),
                    'col-sm-6' => __( '2', 'real-estate-manager' ),
                    'col-sm-4' => __( '3', 'real-estate-manager' ),
                    'col-sm-3' => __( '4', 'real-estate-manager' ),
                ),
            ),

            array(
                'type' => 'textarea',
                'name' => 'search_area_options',
                'title' => __( 'Search Area Options', 'real-estate-manager' ),
                'help' => __( 'Provide area range each per line, to display dropdown of area ranges instead of input field when searching.', 'real-estate-manager' ),
            ),

            array(
                'type' => 'textarea',
                'name' => 'search_bedrooms_options',
                'title' => __( 'Search Bedrooms Options', 'real-estate-manager' ),
                'help' => __( 'Provide bedrooms range each per line, to display dropdown of bedroom ranges instead of input field when searching.', 'real-estate-manager' ),
            ),

            array(
                'type' => 'textarea',
                'name' => 'search_bathrooms_options',
                'title' => __( 'Search Bathrooms Options', 'real-estate-manager' ),
                'help' => __( 'Provide bathrooms range each per line, to display dropdown of bathroom ranges instead of input field when searching.', 'real-estate-manager' ),
            ),

            array(
                'type' => 'text',
                'name' => 'searched_properties_target',
                'title' => __( 'Search Results Link Target', 'real-estate-manager' ),
                'help' => __( 'Provide link target for results of search form. _blank to open in new tab', 'real-estate-manager' ),
            ),
        ),

    ),

    array(

        'panel_title'   =>  __( 'Price Slider', 'real-estate-manager' ),
        'fields'        => array(

            array(
                'type' => 'number',
                'name' => 'minimum_price',
                'title' => __( 'Minimum Price', 'real-estate-manager' ),
                'help' => __( 'Minimum price for price slider', 'real-estate-manager' ),
            ),

            array(
                'type' => 'number',
                'name' => 'maximum_price',
                'title' => __( 'Maximum Price', 'real-estate-manager' ),
                'help' => __( 'Maximum price for price slider', 'real-estate-manager' ),
            ),

            array(
                'type' => 'number',
                'name' => 'price_step',
                'title' => __( 'Step', 'real-estate-manager' ),
                'help' => __( 'Step or interval for price slider', 'real-estate-manager' ),
            ),

            array(
                'type' => 'number',
                'name' => 'default_minimum_price',
                'title' => __( 'Default Minimum Price', 'real-estate-manager' ),
                'help' => __( 'Default Minimum price for price slider', 'real-estate-manager' ),
            ),

            array(
                'type' => 'number',
                'name' => 'default_maximum_price',
                'title' => __( 'Default Maximum Price', 'real-estate-manager' ),
                'help' => __( 'Default Maximum price for price slider', 'real-estate-manager' ),
            ),

        ),

    ),

    array(

        'panel_title'   =>  __( 'Email Messages', 'real-estate-manager' ),
        'fields'        => array(

            array(
                'type' => 'textarea',
                'name' => 'email_admin_register_agent',
                'title' => __( 'Agent Registered', 'real-estate-manager' ),
                'help' => __( 'This message will sent to ', 'real-estate-manager' ).'<b>'.get_bloginfo('admin_email').'</b>'.__( ' when new agent is registered. You can use %username% and %email% for details', 'real-estate-manager' ),
            ),

            array(
                'type' => 'textarea',
                'name' => 'email_pending_agent',
                'title' => __( 'Agent Pending', 'real-estate-manager' ),
                'help' => __( 'Email Message for agent when new agent is registered but status is pending. You can use %username% and %email% for details', 'real-estate-manager' ),
            ),

            array(
                'type' => 'textarea',
                'name' => 'email_approved_agent',
                'title' => __( 'Agent Approved', 'real-estate-manager' ),
                'help' => __( 'Email Message for agent when registered agent is approved. You can use %username% and %email% for details', 'real-estate-manager' ),
            ),

            array(
                'type' => 'textarea',
                'name' => 'email_reject_agent',
                'title' => __( 'Agent Rejected', 'real-estate-manager' ),
                'help' => __( 'Email Message for agent when registered agent is rejected. You can use %username% and %email% for details', 'real-estate-manager' ),
            ),

            array(
                'type' => 'textarea',
                'name' => 'email_agent_contact',
                'title' => __( 'Agent Contact Email Addresses', 'real-estate-manager' ),
                'help' => __( 'Provide Additional Email addresses each per line to cc mail when visitor fills the contact agent form.', 'real-estate-manager' ),
            ),            

        ),

    ),

    array(

        'panel_title'   =>  __( 'Labels and Headings', 'real-estate-manager' ),
        'fields'        => array(

            array(
                'type' => 'text',
                'name' => 'single_property_details_text',
                'title' => __( 'Features Heading', 'real-estate-manager' ),
                'help' => __( 'Provide heading text for property features on property pages', 'real-estate-manager' ),
            ),

            array(
                'type' => 'text',
                'name' => 'single_property_features_text',
                'title' => __( 'Features Heading', 'real-estate-manager' ),
                'help' => __( 'Provide heading text for property features on property pages', 'real-estate-manager' ),
            ),

            array(
                'type' => 'text',
                'name' => 'single_property_video_text',
                'title' => __( 'Video Heading', 'real-estate-manager' ),
                'help' => __( 'Provide heading text for property video on property pages', 'real-estate-manager' ),
            ),

            array(
                'type' => 'text',
                'name' => 'single_property_maps_text',
                'title' => __( 'Maps Heading', 'real-estate-manager' ),
                'help' => __( 'Provide heading text for maps on property pages', 'real-estate-manager' ),
            ),

            array(
                'type' => 'text',
                'name' => 'single_property_tags_text',
                'title' => __( 'Tags Heading', 'real-estate-manager' ),
                'help' => __( 'Provide heading text for tags on property pages', 'real-estate-manager' ),
            ),

            array(
                'type' => 'text',
                'name' => 'single_property_attachments_text',
                'title' => __( 'Attachments Heading', 'real-estate-manager' ),
                'help' => __( 'Provide heading text for attachments on property pages', 'real-estate-manager' ),
            ),

            array(
                'type' => 'text',
                'name' => 'archive_title',
                'title' => __( 'Tags Heading for Archive Pages', 'real-estate-manager' ),
                'help' => __( 'You can use %tag% for tag name', 'real-estate-manager' ),
            ),

            array(
                'type' => 'text',
                'name' => 'property_sale_ribbon_text',
                'title' => __( 'Sale Ribbon Text', 'real-estate-manager' ),
                'help' => __( 'Provide text for ribbon of on sale properties', 'real-estate-manager' ),
            ),

        ),

    ),

    array(

        'panel_title'   =>  __( 'Maps Settings', 'real-estate-manager' ),
        'fields'        => array(

            array(
                'type' => 'text',
                'name' => 'maps_api_key',
                'title' => __( 'Google Maps API Key', 'real-estate-manager' ),
                'help' => __( 'Provide Google Maps API key here. You can create API key ', 'real-estate-manager' ).'<a target="_blank" href="https://developers.google.com/maps/documentation/javascript/get-api-key#get-an-api-key">'.__( 'here', 'real-estate-manager' ).'</a>',
            ),

            array(
                'type' => 'select',
                'name' => 'maps_type',
                'title' => __( 'Map Type', 'real-estate-manager' ),
                'options' => array(
                    'roadmap' => __( 'Road Map', 'real-estate-manager' ),
                    'satellite' => __( 'Google Earth', 'real-estate-manager' ),
                    'hybrid' => __( 'Hybrid', 'real-estate-manager' ),
                    'terrain' => __( 'Terrain', 'real-estate-manager' ),
                ),                
                'help' => __( 'Choose default map type here', 'real-estate-manager' ),
            ),

            array(
                'type' => 'text',
                'name' => 'maps_zoom_level',
                'title' => __( 'Map Zoom Level', 'real-estate-manager' ),
                'help' => __( 'Provide Zoom level between 0 and 21+ for single property map', 'real-estate-manager' ),
            ),

            array(
                'type' => 'image',
                'name' => 'maps_drag_image',
                'title' => __( 'Drag Icon URL', 'real-estate-manager' ),
                'help' => __( 'Upload custom icon for dragging on map while creating new property. Recommended size: 72x60', 'real-estate-manager' ),
            ),

            array(
                'type' => 'image',
                'name' => 'maps_location_image',
                'title' => __( 'Location Icon URL', 'real-estate-manager' ),
                'help' => __( 'Upload custom icon for location on map when visiting property page. Recommended size: 72x60', 'real-estate-manager' ),
            ),
            
            array(
                'type' => 'text',
                'name' => 'default_map_lat',
                'title' => __( 'Default Latitude', 'real-estate-manager' ),
                'help' => __( 'Provide latitude for default map location on create property page', 'real-estate-manager' ),
            ),

            array(
                'type' => 'text',
                'name' => 'default_map_long',
                'title' => __( 'Default Longitude', 'real-estate-manager' ),
                'help' => __( 'Provide longitude for default map location on create property page', 'real-estate-manager' ),
            ),            

        ),

    ),

    array(

        'panel_title'   =>  __( 'Colors and CSS', 'real-estate-manager' ),
        'fields'        => array(

            array(
                'type' => 'color',
                'name' => 'headings_underline_color_default',
                'title' => __( 'Headings Underline', 'real-estate-manager' ),
                'default' => '#F2F2F2',
                'help' => __( 'Choose bottom border color for headings area', 'real-estate-manager' ),
            ),

            array(
                'type' => 'color',
                'name' => 'headings_underline_color_active',
                'title' => __( 'Headings Underline Active', 'real-estate-manager' ),
                'default' => '#1fb7a6',
                'help' => __( 'Choose bottom border color for headings active area', 'real-estate-manager' ),
            ),

            array(
                'type' => 'color',
                'name' => 'buttons_background_color',
                'title' => __( 'Buttons Background', 'real-estate-manager' ),
                'default' => '#fff',
                'help' => __( 'Choose background color for buttons', 'real-estate-manager' ),
            ),

            array(
                'type' => 'color',
                'name' => 'buttons_text_color',
                'title' => __( 'Buttons Text', 'real-estate-manager' ),
                'default' => '#333',
                'help' => __( 'Choose text color for buttons', 'real-estate-manager' ),
            ),

            array(
                'type' => 'color',
                'name' => 'buttons_background_color_hover',
                'title' => __( 'Buttons Background - Hover', 'real-estate-manager' ),
                'default' => '#e6e6e6',
                'help' => __( 'Choose background color for buttons on hover state', 'real-estate-manager' ),
            ),

            array(
                'type' => 'color',
                'name' => 'buttons_text_color_hover',
                'title' => __( 'Buttons Text - Hover', 'real-estate-manager' ),
                'default' => '#333',
                'help' => __( 'Choose text color for buttons', 'real-estate-manager' ),
            ),

            array(
                'type' => 'color',
                'name' => 'rem_main_color',
                'title' => __( 'Theme Main Color', 'real-estate-manager' ),
                'default' => '#1FB7A6',
                'help' => __( 'Choose main theme color for templates', 'real-estate-manager' ),
            ),

            array(
                'type' => 'textarea',
                'name' => 'custom_css',
                'title' => __( 'Custom CSS Code', 'real-estate-manager' ),
                'default' => '',
                'help' => __( 'Paste your custom css code here, you can prefix with', 'real-estate-manager' ).'<code>.ich-settings-main-wrap</code>',
            ),

        ),

    ),

    array(
        'panel_title'   =>  __( 'Advanced Settings', 'real-estate-manager' ),

        'fields'        => array(
            array(
                'type' => 'select',
                'name' => 'use_bootstrap',
                'title' => __( 'Bootstrap CSS', 'real-estate-manager' ),
                'options' => array(
                    'enable' => __( 'Enable', 'real-estate-manager' ),
                    'disable' => __( 'Disable', 'real-estate-manager' ),
                ),
                'help' => __( 'Disable it, if your theme loads its own bootstrap 3 styles', 'real-estate-manager' ),
            ),
            array(
                'type' => 'select',
                'name' => 'use_fontawesome',
                'title' => __( 'Font Awesome', 'real-estate-manager' ),
                'options' => array(
                    'enable' => __( 'Enable', 'real-estate-manager' ),
                    'disable' => __( 'Disable', 'real-estate-manager' ),
                ),
                'help' => __( 'Disable it, if your theme loads its own font awesome icons', 'real-estate-manager' ),
            ),
        ),

    ),
);
?>