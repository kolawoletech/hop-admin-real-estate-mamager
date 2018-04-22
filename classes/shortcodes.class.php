<?php
/**
* Real Estate Management - Shortcodes Class
*/
class REM_Shortcodes
{
	
	function __construct(){

        /***********************************************************************************************/
        /* Add Shortcodes */
        /***********************************************************************************************/

		add_shortcode( 'rem_register_agent', array($this, 'register_agent') );
		add_shortcode( 'rem_search_property', array($this, 'search_property') );
		add_shortcode( 'rem_agent_login', array($this, 'login_agent') );
		add_shortcode( 'rem_create_property', array($this, 'create_property') );
		add_shortcode( 'rem_edit_property', array($this, 'edit_property') );
		add_shortcode( 'rem_my_properties', array($this, 'my_properties') );
		add_shortcode( 'rem_list_properties', array($this, 'list_properties') );
		add_shortcode( 'rem_search_results', array($this, 'display_search_results') );
		add_shortcode( 'rem_carousel', array($this, 'display_carousel') );
		add_shortcode( 'rem_maps', array($this, 'display_maps') );
		add_shortcode( 'rem_agent_profile', array($this, 'display_agent') );
		add_shortcode( 'rem_agent_edit', array($this, 'edit_agent') );
		add_shortcode( 'rem_property', array($this, 'single_property') );

        /***********************************************************************************************/
        /* Shortcodes button in editor and WP Bakery Page Builder Support */
        /***********************************************************************************************/

		add_action('admin_init', array($this, 'shortcode_button'));
		add_action( 'vc_before_init', array($this, 'rem_integrateWithVC' ) );

        /***********************************************************************************************/
        /* AJAX Callbacks */
        /***********************************************************************************************/

        // Agent Login
        add_action( 'wp_ajax_rem_user_login', array($this, 'rem_user_login_check' ) );
        add_action( 'wp_ajax_nopriv_rem_user_login', array($this, 'rem_user_login_check' ) );

        // Create Property Frontend
        add_action( 'wp_ajax_rem_create_pro_ajax', array($this, 'create_property_frontend' ) );
        
        // Saving Agent Profile Frontend
        add_action( 'wp_ajax_rem_save_profile_front', array($this, 'rem_save_profile_front' ) );
        
        // Search Property Frontend
        add_action( 'wp_ajax_rem_search_property', array($this, 'search_results' ) );
        add_action( 'wp_ajax_nopriv_rem_search_property', array($this, 'search_results' ) );

        // Register New Agent
        add_action( 'wp_ajax_nopriv_rem_agent_register', array($this, 'rem_register_agent' ) );
	}

	function register_agent($attrs, $content = ''){
		if (!is_user_logged_in()) {

			extract( shortcode_atts( array(
				'redirect' => '',
			), $attrs ) );

            rem_load_bs_and_fa();
            rem_load_basic_styles();
            wp_enqueue_style( 'rem-register-css', REM_URL . '/assets/front/css/register-agent.css' );
            wp_enqueue_script( 'rem-register-agent-js', REM_URL . '/assets/front/js/register-agent.js', array('jquery'));
			
			ob_start();
				include REM_PATH. '/shortcodes/register-agent.php';
			return ob_get_clean();
		} else {
			return apply_filters( 'the_content', $content );
		}
	}

	function search_property($attrs, $content = ''){

		extract( shortcode_atts( array(
			'fields_to_show' => 'property_address,search,property_type,property_country,property_purpose,property_price',
			'columns' => '6',
			'search_btn_text' => __( 'Search', 'real-estate-manager' ),
			'filters_btn_text' => __( 'More Filters', 'real-estate-manager' ),
			'reset_btn_text' => '',
			'fixed_fields' => '',
			'results_page' => '',
			'results_selector' => '',
			'disable_eq_height' => '',
		), $attrs ) );		
		
        rem_load_bs_and_fa();
        rem_load_basic_styles();
        wp_enqueue_style( 'rem-archive-css', REM_URL . '/assets/front/css/archive-property.css' );
        
        wp_enqueue_style( 'rem-nouislider-css', REM_URL . '/assets/front/lib/nouislider.min.css' );
        wp_enqueue_style( 'rem-easydropdown-css', REM_URL . '/assets/front/lib/easydropdown.css' );
        wp_enqueue_style( 'rem-labelauty-css', REM_URL . '/assets/front/lib/labelauty.css' );
        wp_enqueue_script( 'rem-labelauty', REM_URL . '/assets/front/lib/labelauty.min.js', array('jquery'));
        wp_enqueue_script( 'rem-easy-drop', REM_URL . '/assets/front/lib/jquery.easydropdown.min.js', array('jquery'));
        wp_enqueue_script( 'rem-nouislider-drop', REM_URL . '/assets/front/lib/nouislider.all.min.js', array('jquery'));
        wp_enqueue_script( 'rem-match-height', REM_URL . '/assets/front/lib/jquery.matchheight-min.js', array('jquery'));

        wp_enqueue_script( 'rem-imagefill-js', REM_URL . '/assets/front/lib/imagefill.min.js', array('jquery'));   
        wp_enqueue_script( 'rem-imagesloaded-js', REM_URL . '/assets/front/lib/imagesloaded.min.js', array('jquery'));
        
        wp_enqueue_style( 'rem-search-css', REM_URL . '/assets/front/css/search-property.css' );

        $script_settings = array(
            'price_min'         => rem_get_option('minimum_price', '350'),
            'price_max'         => rem_get_option('maximum_price', '45000'), 
            'price_min_default' => rem_get_option('default_minimum_price', '7000'), 
            'price_max_default' => rem_get_option('default_maximum_price', '38500'), 
            'price_step'        => rem_get_option('price_step', '10'),
            'currency_symbol'   => rem_get_currency_symbol(),
            'thousand_separator'=> rem_get_option('thousand_separator', ''),
            'decimal_separator' => rem_get_option('decimal_separator', ''),
            'decimal_points'    => rem_get_option('decimal_points', '0'),
        );
        wp_enqueue_script( 'rem-search-script', REM_URL . '/assets/front/js/search-property.js', array('jquery'));
        wp_localize_script( 'rem-search-script', 'rem_ob', $script_settings );

		ob_start();
			include REM_PATH . '/shortcodes/search-property.php';
		return ob_get_clean();	
	}

	function login_agent($attrs, $content = ''){
		if (is_user_logged_in()) {
			return apply_filters( 'the_content', $content );
		} else {

	        rem_load_bs_and_fa();
	        rem_load_basic_styles();
	        wp_enqueue_style( 'rem-login-css', REM_URL . '/assets/front/css/login-agent.css' );
	        wp_enqueue_style( 'rem-labelauty-css', REM_URL . '/assets/front/lib/labelauty.css' );
	        wp_enqueue_script( 'rem-labelauty', REM_URL . '/assets/front/lib/labelauty.min.js', array('jquery'));
	        wp_enqueue_script( 'rem-login-agent', REM_URL . '/assets/front/js/login.js', array('jquery'));

			extract( shortcode_atts( array(
				'heading' => 'Login Here',
				'redirect' => '',
			), $attrs ) );
			ob_start();
				include REM_PATH. '/shortcodes/login.php';
			return ob_get_clean();
		}
	}

	function create_property($attrs, $content = ''){
		if (is_user_logged_in()) {
			extract( shortcode_atts( array(
				'style' => '',
			), $attrs ) );

			global $rem_ob;
	        wp_enqueue_media();
			rem_load_bs_and_fa();
			rem_load_basic_styles();
			wp_enqueue_style( 'rem-admin-css', REM_URL . '/assets/admin/css/admin.css' );

			wp_enqueue_style( 'rem-easydropdown-css', REM_URL . '/assets/front/lib/easydropdown.css' );
			wp_enqueue_style( 'rem-labelauty-css', REM_URL . '/assets/front/lib/labelauty.css' );
			wp_enqueue_script( 'rem-labelauty', REM_URL . '/assets/front/lib/labelauty.min.js', array('jquery'));
			wp_enqueue_script( 'rem-easy-drop', REM_URL . '/assets/front/lib/jquery.easydropdown.min.js', array('jquery'));
			wp_enqueue_script( 'rem-create-pro', REM_URL . '/assets/front/js/create-property.js', array('jquery'));

			ob_start(); ?>
		<?php
			$property_purposes = $rem_ob->get_all_property_purpose();
			$property_types = $rem_ob->get_all_property_types();
			$property_status = $rem_ob->get_all_property_status();
			$property_individual_cbs = $rem_ob->get_all_property_features();
			$rem_options = get_option( 'rem_all_settings' );
			$price_symbol = rem_get_currency_symbol();
			include REM_PATH. '/shortcodes/create-property.php';
			return ob_get_clean();
		} else {
			return apply_filters( 'the_content', $content );
		}		
	}

	function edit_property($attrs, $content = ''){
		$current_user_data = wp_get_current_user();
		if (is_user_logged_in() && isset($_GET['property_id']) && get_post_field( 'post_author', $_REQUEST['property_id'] ) == $current_user_data->ID) {
			extract( shortcode_atts( array(
				'style' => '',
			), $attrs ) );

			global $rem_ob;
	        wp_enqueue_media();
			rem_load_bs_and_fa();
			rem_load_basic_styles();
			wp_enqueue_style( 'rem-admin-css', REM_URL . '/assets/admin/css/admin.css' );

			wp_enqueue_style( 'rem-easydropdown-css', REM_URL . '/assets/front/lib/easydropdown.css' );
			wp_enqueue_style( 'rem-labelauty-css', REM_URL . '/assets/front/lib/labelauty.css' );
			wp_enqueue_script( 'rem-labelauty', REM_URL . '/assets/front/lib/labelauty.min.js', array('jquery'));
			wp_enqueue_script( 'rem-easy-drop', REM_URL . '/assets/front/lib/jquery.easydropdown.min.js', array('jquery'));
			wp_enqueue_script( 'rem-create-pro', REM_URL . '/assets/front/js/create-property.js', array('jquery'));


			ob_start(); ?>
		<?php
			$property_purposes = $rem_ob->get_all_property_purpose();
			$property_types = $rem_ob->get_all_property_types();
			$property_status = $rem_ob->get_all_property_status();
			$property_individual_cbs = $rem_ob->get_all_property_features();
			$rem_options = get_option( 'rem_all_settings' );
			$price_symbol = rem_get_currency_symbol();
			include REM_PATH. '/shortcodes/edit-property.php';
			return ob_get_clean();
		} else {
			return apply_filters( 'the_content', $content );
		}		
	}

	function my_properties($attrs, $content = ''){
		if (is_user_logged_in()) {
			extract( shortcode_atts( array(
				'style' => '',
			), $attrs ) );

	        rem_load_bs_and_fa();
	        rem_load_basic_styles();
	        wp_enqueue_style( 'dashicons' );
	        wp_enqueue_style( 'rem-myproperties-css', REM_URL . '/assets/front/css/my-properties.css' );

			ob_start();
			
			include REM_PATH . '/shortcodes/my-properties.php';
			return ob_get_clean();
		} else {
			return apply_filters( 'the_content', $content );
		}		
	}

	function list_properties($attrs, $content = ''){
		extract( shortcode_atts( array(
	        'order' 	=> 'ASC',
	        'orderby' 	=> 'date',
	        'style' 	=> '1',
	        'posts' 	=> -1,
	        'class'  	=> 'col-sm-3',
	        'purpose'  	=> '',
	        'status'  	=> '',
	        'type'  	=> '',
	        'tags'  	=> '',
	        'pagination'  	=> 'enable',
	        'meta'  	=> '',
	        'nearest_porperties'  	=> 'disable',
		), $attrs ) );

		if($style == '1'){
			$class = 'col-sm-12';
		}

        rem_load_bs_and_fa();
        rem_load_basic_styles();

        // Imagesfill and Loaded
        wp_enqueue_script( 'rem-imagefill-js', REM_URL . '/assets/front/lib/imagefill.min.js', array('jquery'));   
        wp_enqueue_script( 'rem-imagesloaded-js', REM_URL . '/assets/front/lib/imagesloaded.min.js', array('jquery'));   
        
        // Page Specific
        wp_enqueue_style( 'rem-archive-property-css', REM_URL . '/assets/front/css/archive-property.css' );
        wp_enqueue_script( 'rem-archive-property-js', REM_URL . '/assets/front/js/archive-property.js', array('jquery'));

		$args = array(
			'order'       => $order,
			'orderby'     => $orderby,			
			'post_type'   => 'rem_property',
			'posts_per_page'         => $posts,
		);
	    if ($purpose != '') {
	        $args['meta_query'][] = array(
	            array(
	                'key'     => 'rem_property_purpose',
	                'value'   => $purpose,
	                'compare' => 'LIKE',
	            ),
	        );
	    }
	    if ($status != '') {
	        $args['meta_query'][] = array(
	            array(
	                'key'     => 'rem_property_status',
	                'value'   => $status,
	                'compare' => 'LIKE',
	            ),
	        );
	    }
	    if ($type != '') {
	        $args['meta_query'][] = array(
	            array(
	                'key'     => 'rem_property_type',
	                'value'   => $type,
	                'compare' => 'LIKE',
	            ),
	        );
	    }
	    if ($tags != '') {
	    	$p_tags = array_map('trim', explode(',', $tags));
	        $args['tax_query'] = array(
				array(
					'taxonomy' => 'rem_property_tag',
					'field'    => 'name',
					'terms'    => $p_tags,
				),
	        );
	    }
		if ($meta != '') {
			$meta_data = explode(",", $meta);
			foreach ($meta_data as $single_meta) {
				$m_k_v = explode("|", $single_meta);
			    if (isset($m_k_v[1]) && $m_k_v[1] != '') {
			        $args['meta_query'][] = array(
			            array(
			                'key'     => 'rem_'.trim($m_k_v[0]),
			                'value'   => trim($m_k_v[1]),
			                'compare' => 'LIKE',
			            ),
			        );
			    }
				
			}
		}	    

	    if ($pagination == 'enable') {
	    	if (is_front_page()) {
	    		$paged = ( get_query_var('page') ) ? get_query_var('page') : 1;
	    	} else {
				$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
	    	}
			$args['paged'] = $paged;
	    }
	    		
		ob_start();

			if($nearest_porperties == 'enable'){
				?>
				<script>
				    if (navigator.geolocation) {
				        navigator.geolocation.getCurrentPosition(wcpSetPosition);
				    }
					function wcpSetPosition(position) {
						var href = window.location.href;
						if (href.indexOf('lat') == -1) {
							window.location.href = href += '/?lat='+position.coords.latitude+'&long='+position.coords.longitude;
						}
					}    
				</script>
				<?php
			}
			if ($nearest_porperties == 'enable' && isset($_GET['lat']) && isset($_GET['long'])) {
				$args['posts_per_page'] = -1;
				$the_query = new WP_Query( $args );
				include REM_PATH . '/shortcodes/list/nearby.php';
			} else {
				$the_query = new WP_Query( $args );
				include REM_PATH . '/shortcodes/list/list.php';
			}

			
		return ob_get_clean();
	}

	function display_carousel($attrs, $content = ''){
		extract( shortcode_atts( array(
	        'order' 	=> 'ASC',
	        'orderby' 	=> 'date',
	        'style' 	=> '1',
	        'slidestoshow'  	=> '1',
	        'slidestoscroll'  	=> '1',
	        'speed'  	=> '2000',
	        'autoplay'  	=> 'disable',
	        'autoplayspeed'  	=> '2000',
	        'arrows'  	=> 'disable',
	        'dots'  	=> 'disable',
	        'ids'  	=> '',
	        'meta'  	=> '',
	        'tags'  	=> '',
	        'total_properties' 	=> '10',
	        'nearest_porperties' 	=> 'disable',
		), $attrs ) );
		if($style == '1'){
			$attrs['slidestoshow'] = '1';
		}
	    $data_attr = '';
	    if(is_array($attrs)){
	        foreach ($attrs as $p_name => $p_val) {
	            if ($p_val != '') {
	                $data_attr .= ' data-'.$p_name.' = '.$p_val;
	            }
	        }
	    }

        rem_load_bs_and_fa();
        rem_load_basic_styles();



		$args = array(
			'order'       => $order,
			'orderby'     => $orderby,			
			'post_type'   => 'rem_property',
			'posts_per_page'         => $total_properties,
		);

		if ($meta != '') {
			$meta_data = explode(",", $meta);
			foreach ($meta_data as $single_meta) {
				$m_k_v = explode("|", $single_meta);
			    if (isset($m_k_v[1]) && $m_k_v[1] != '') {
			        $args['meta_query'][] = array(
			            array(
			                'key'     => 'rem_'.trim($m_k_v[0]),
			                'value'   => trim($m_k_v[1]),
			                'compare' => 'LIKE',
			            ),
			        );
			    }
				
			}
		}
	    if ($tags != '') {
	    	$p_tags = array_map('trim', explode(',', $tags));
	        $args['tax_query'] = array(
				array(
					'taxonomy' => 'rem_property_tag',
					'field'    => 'name',
					'terms'    => $p_tags,
				),
	        );
	    }
	    
	    if ($ids != '') {
	        $args['post__in'] = explode(',', $ids);
	    }

		ob_start();

			if($nearest_porperties == 'enable'){
				?>
				<script>
				    if (navigator.geolocation) {
				        navigator.geolocation.getCurrentPosition(wcpSetPosition);
				    }
					function wcpSetPosition(position) {
						var href = window.location.href;
						if (href.indexOf('lat') == -1) {
							window.location.href = href += '/?lat='+position.coords.latitude+'&long='+position.coords.longitude;
						}
					}    
				</script>
				<?php
			}
			if ($nearest_porperties == 'enable' && isset($_GET['lat']) && isset($_GET['long'])) {
				$args['posts_per_page'] = -1;
				$the_query = new WP_Query( $args );
				include REM_PATH . '/shortcodes/carousel/nearby.php';
			} else {
				// The Loop
				$the_query = new WP_Query( $args );
				include REM_PATH . '/shortcodes/carousel/carousel.php';
			}

		return ob_get_clean();
	}

    /**
     * Create a shortcode button for tinymce
     *
     * @return [type] [description]
     */
    public function shortcode_button(){
        if( current_user_can('edit_posts') &&  current_user_can('edit_pages') ){
            add_filter( 'mce_external_plugins', array($this, 'add_buttons' ));
            add_filter( 'mce_buttons', array($this, 'register_buttons' ));
        }
    }

    /**
     * Add new Javascript to the plugin scrippt array
     *
     * @param  Array $plugin_array - Array of scripts
     *
     * @return Array
     */
    public function add_buttons( $plugin_array )
    {
        $plugin_array['rem_shortcodes'] = REM_URL . '/assets/admin/js/shortcode.js';

        return $plugin_array;
    }

    /**
     * Add new button to tinymce
     *
     * @param  Array $buttons - Array of buttons
     *
     * @return Array
     */
    public function register_buttons( $buttons )
    {
        array_push( $buttons, 'separator', 'rem_shortcodes' );
        return $buttons;
    }

    /**
     * It displays search results from widgets
     */
    function display_search_results(){
		
        rem_load_bs_and_fa();
        rem_load_basic_styles();
        wp_enqueue_style( 'rem-archive-css', REM_URL . '/assets/front/css/archive-property.css' );
        
        wp_enqueue_style( 'rem-nouislider-css', REM_URL . '/assets/front/lib/nouislider.min.css' );
        wp_enqueue_style( 'rem-easydropdown-css', REM_URL . '/assets/front/lib/easydropdown.css' );
        wp_enqueue_style( 'rem-labelauty-css', REM_URL . '/assets/front/lib/labelauty.css' );
        wp_enqueue_script( 'rem-labelauty', REM_URL . '/assets/front/lib/labelauty.min.js', array('jquery'));
        wp_enqueue_script( 'rem-easy-drop', REM_URL . '/assets/front/lib/jquery.easydropdown.min.js', array('jquery'));
        wp_enqueue_script( 'rem-nouislider-drop', REM_URL . '/assets/front/lib/nouislider.all.min.js', array('jquery'));
        wp_enqueue_script( 'rem-match-height', REM_URL . '/assets/front/lib/jquery.matchheight-min.js', array('jquery'));

        wp_enqueue_script( 'rem-imagefill-js', REM_URL . '/assets/front/lib/imagefill.min.js', array('jquery'));   
        wp_enqueue_script( 'rem-imagesloaded-js', REM_URL . '/assets/front/lib/imagesloaded.min.js', array('jquery'));
        
        wp_enqueue_style( 'rem-search-css', REM_URL . '/assets/front/css/search-property.css' );

        $script_settings = array(
            'price_min'         => rem_get_option('minimum_price', '350'),
            'price_max'         => rem_get_option('maximum_price', '45000'), 
            'price_min_default' => rem_get_option('default_minimum_price', '7000'), 
            'price_max_default' => rem_get_option('default_maximum_price', '38500'), 
            'price_step'        => rem_get_option('price_step', '10'),
            'currency_symbol'   => rem_get_currency_symbol(),
            'thousand_separator'=> rem_get_option('thousand_separator', ''),
            'decimal_separator' => rem_get_option('decimal_separator', ''),
            'decimal_points'    => rem_get_option('decimal_points', '0'),
        );
        wp_enqueue_script( 'rem-search-script', REM_URL . '/assets/front/js/search-property.js', array('jquery'));
        wp_localize_script( 'rem-search-script', 'rem_ob', $script_settings );

    	ob_start();
    		include REM_PATH . '/shortcodes/search-results.php';
    	return ob_get_clean();
    }

    function display_maps($attrs){
		extract( shortcode_atts( array(
			'load_heading' 		=> 'Loading Maps',
			'load_desc' 		=> 'Please Wait...',
			'ids' 				=> '',
			'total_properties' 	=> '10',
	        'order' 	=> 'ASC',
	        'orderby' 	=> 'date',			
	        'meta' 	=> '',			
	        'tags' 	=> '',		
			'btn_bg_color' 		=> '',
			'btn_text_color' 	=> '',
			'btn_bg_color_hover' => '',
			'btn_text_color_hover' => '',
			'loader_color' => '',
			'type_bar_bg_color' => '',
			'water_color' 		=> '',
			'fill_color' 		=> '',
			'poi_color' 		=> '',
			'poi_color_hue' 	=> '',
			'roads_lightness' 	=> '',
			'lines_lightness'	=> '',
			'nearest_porperties'=> 'disable',
			'map_height'=> '',
			
			'type_filtering' 	=> 'disable',
			'bottom_btn_bg_color'=> '',
			'bottom_btn_text_color'=> '',
			'bottom_btn_bg_color_hover'=> '',
			'bottom_btn_text_color_hover'=> '',
			'bottom_btn_bg_color_active'=> '',
		), $attrs ) );

		// Fetching Properties and creating array
		$all_properties = array();

		$args = array(
			'order'       => $order,
			'orderby'     => $orderby,			
			'post_type'   => 'rem_property',
			'posts_per_page'         => $total_properties,
		);

		if ($meta != '') {
			$meta_data = explode(",", $meta);
			foreach ($meta_data as $single_meta) {
				$m_k_v = explode("|", $single_meta);
			    if (isset($m_k_v[1]) && $m_k_v[1] != '') {
			        $args['meta_query'][] = array(
			            array(
			                'key'     => 'rem_'.trim($m_k_v[0]),
			                'value'   => trim($m_k_v[1]),
			                'compare' => 'LIKE',
			            ),
			        );
			    }
				
			}
		}
	    if ($tags != '') {
	    	$p_tags = array_map('trim', explode(',', $tags));
	        $args['tax_query'] = array(
				array(
					'taxonomy' => 'rem_property_tag',
					'field'    => 'name',
					'terms'    => $p_tags,
				),
	        );
	    }
	    if ($ids != '') {
	        $args['post__in'] = explode(',', $ids);
	    }

		ob_start();

		if($nearest_porperties == 'enable'){
			?>
			<script>
			    if (navigator.geolocation) {
			        navigator.geolocation.getCurrentPosition(wcpSetPosition);
			    }
				function wcpSetPosition(position) {
					var href = window.location.href;
					if (href.indexOf('lat') == -1) {
						window.location.href = href += '/?lat='+position.coords.latitude+'&long='+position.coords.longitude;
					}
				}    
			</script>
			<?php
		}
		if ($nearest_porperties == 'enable' && isset($_GET['lat']) && isset($_GET['long'])) {
			$args['posts_per_page'] = -1;
			$the_query = new WP_Query( $args );
			include REM_PATH . '/shortcodes/map/nearby.php';
		} else {
			// The Loop
			$the_query = new WP_Query( $args );
			include REM_PATH . '/shortcodes/map/map.php';
		}

		return ob_get_clean();
    }

    function rem_integrateWithVC(){
    	global $rem_ob;
		$property_purposes = $rem_ob->get_all_property_purpose();
		$property_types = $rem_ob->get_all_property_types();
		$property_status = $rem_ob->get_all_property_status();

		$all_agents = get_users( 'role=rem_property_agent' );

		$agents_arr = array( 'Administrator' => 1 );
		foreach ($all_agents as $agent) {
			$agents_arr[$agent->display_name] = $agent->ID;
		}

		array_unshift($property_purposes, array('any' => 'Any'));
		array_unshift($property_types, array('any' => 'Any'));
		array_unshift($property_status, array('any' => 'Any'));
    	include REM_PATH. '/shortcodes/vc-settings.php';

    	foreach ($shortcodes as $sc) {
			vc_map($sc);
    	}
    }

    function display_agent($attrs, $content = ''){
		extract( shortcode_atts( array(
			'author_id' 		=> '1',
		), $attrs ) );
		global $rem_ob;

        rem_load_bs_and_fa();
        rem_load_basic_styles();
        wp_enqueue_style( 'rem-skillbars-css', REM_URL . '/assets/front/lib/skill-bars.css' );

        // Imagesfill and Loaded
        wp_enqueue_script( 'rem-imagefill-js', REM_URL . '/assets/front/lib/imagefill.min.js', array('jquery'));   
        wp_enqueue_script( 'rem-imagesloaded-js', REM_URL . '/assets/front/lib/imagesloaded.min.js', array('jquery'));   
        
        // Carousel
        wp_enqueue_style( 'rem-carousel-css', REM_URL . '/assets/front/lib/slick.css' );
        wp_enqueue_script( 'rem-carousel-js', REM_URL . '/assets/front/lib/slick.min.js', array('jquery'));

        // Page Specific
        wp_enqueue_style( 'rem-archive-property-css', REM_URL . '/assets/front/css/archive-property.css' );
        wp_enqueue_style( 'rem-profile-agent-css', REM_URL . '/assets/front/css/profile-agent.css' );
        wp_enqueue_script( 'rem-profile-agent-js', REM_URL . '/assets/front/js/profile-agent.js', array('jquery'));

		ob_start();
			include REM_PATH . '/shortcodes/agent-profile.php';
		return ob_get_clean();
    }

    function edit_agent($attrs, $content = ''){
		if (is_user_logged_in()) {

            rem_load_bs_and_fa();
            rem_load_basic_styles();
            wp_enqueue_style( 'rem-register-css', REM_URL . '/assets/front/css/register-agent.css' );
            wp_enqueue_script( 'rem-register-agent-js', REM_URL . '/assets/front/js/edit-agent.js', array('jquery'));

			ob_start();
				include REM_PATH . '/shortcodes/edit-agent.php';
			return ob_get_clean();
		} else {
			return apply_filters( 'the_content', $content );
		}
    }

    function single_property($attrs, $content = ''){
		if (isset($attrs['id'])) {

            rem_load_bs_and_fa();

            rem_load_basic_styles();

            // Photorama
            wp_enqueue_style( 'rem-fotorama-css', REM_URL . '/assets/front/lib/fotorama.min.css' );
            wp_enqueue_script( 'rem-photorama-js', REM_URL . '/assets/front/lib/fotorama.min.js', array('jquery'));

            // Imagesfill and Loaded
            wp_enqueue_script( 'rem-imagefill-js', REM_URL . '/assets/front/lib/imagefill.min.js', array('jquery'));   
            wp_enqueue_script( 'rem-imagesloaded-js', REM_URL . '/assets/front/lib/imagesloaded.min.js', array('jquery'));   
            
            // Page Specific
            wp_enqueue_style( 'rem-single-property-css', REM_URL . '/assets/front/css/single-property.css' );
            wp_enqueue_script( 'rem-single-property-js', REM_URL . '/assets/front/js/single-property.js', array('jquery'));

			ob_start(); ?>
				<section id="property-content" class="ich-settings-main-wrap">
					<?php do_action( 'rem_single_property_slider', $attrs['id'] ); ?>
					<?php do_action( 'rem_single_property_contents', $attrs['id'] ); ?>
				</section>
			<?php return ob_get_clean();
		}
    }

    function rem_user_login_check(){
        if (isset($_REQUEST)) {
            extract($_REQUEST);
            global $user;
            $creds = array();
            $creds['user_login'] = $rem_username;
            $creds['user_password'] =  $rem_userpass;
            $creds['remember'] = (isset($rememberme)) ? true : false;
            $user = wp_signon( $creds, false );

            if ( is_wp_error($user) ) {
                $resp = array(
                    'status'    => 'failed',
                    'message'   => $user->get_error_message(),
                );
                echo json_encode($resp);
            }
            if ( !is_wp_error($user) ) {
                $resp = array(
                    'status'    => 'success',
                    'message'   => '',
                );
                echo json_encode($resp);
            }

            die(0);
        }
    }

    function create_property_frontend(){

        // print_r($_REQUEST); exit;
        if (isset($_REQUEST) && $_REQUEST != '') {
            extract($_REQUEST);
            $current_user_data = wp_get_current_user();

            // Create post object
            $my_post = array(
              'post_title'    => wp_strip_all_tags( $title ),
              'post_content'  => $content,
              'post_status'   => 'publish',
              'post_author'   => $current_user_data->ID,
              'post_type'   => 'rem_property',
            );

            if (isset($_REQUEST['property_id']) && get_post_field( 'post_author', $_REQUEST['property_id'] ) == $current_user_data->ID) {
                $my_post['ID'] = $_REQUEST['property_id'];
            }
             
            // Insert the post into the database
            $property_id = wp_insert_post( $my_post );

            foreach ($_REQUEST as $key => $data) {
                if ($key != 'title' || $key != 'content' || $key != 'rem_property_data' || $key != 'tags') {
                    update_post_meta( $property_id, 'rem_property_'.$key, $data );
                }

                if ($key == 'rem_property_data') {
                    update_post_meta( $property_id, 'rem_property_images', $data['property_images'] );                    
                    foreach ($data['property_images'] as $imgID => $id) {
                        if (!has_post_thumbnail( $property_id )) {
                            set_post_thumbnail( $property_id, $imgID );
                        }
                    }
                }

                if ($key == 'tags') {
                    wp_set_post_terms( $property_id, $data, 'rem_property_tag' );
                }
            }

            echo apply_filters( 'rem_redirect_after_property_submit', get_permalink( $property_id ) );

        }

        die();
    }

    function rem_save_profile_front(){
        $current_user = wp_get_current_user();
        $agent_id = $current_user->ID;
        if ($agent_id == $_REQUEST['agent_id']) {
            foreach ($_REQUEST as $key => $value) {
                if ($key == 'user_email') {
                    wp_update_user( array(
                        'ID' => $agent_id,
                        'user_email' => $value,
                    ));
                } elseif ($key == 'action') {
                    
                } elseif ($key == 'agent_id') {
                    
                } else {
                    update_user_meta( $agent_id, $key, $value );
                }
            }
        }

        echo '<p class="alert alert-success">'.__( "Changes Saved!", 'real-estate-manager' ).'</p>';

        die(0);
    }

    
    function get_distance( $latitude1, $longitude1, $latitude2, $longitude2 ) {  
        $earth_radius = 6371;

        $dLat = deg2rad( $latitude2 - $latitude1 );
        $dLon = deg2rad( $longitude2 - $longitude1 );

        $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * sin($dLon/2) * sin($dLon/2);  
        $c = 2 * asin(sqrt($a));  
        $d = $earth_radius * $c;  

        return $d;
    }

    function search_results(){
        if(isset($_REQUEST)){
            extract($_REQUEST);
            include REM_PATH . '/inc/ajax/search-property-ajax.php';
        }

        die(0);
    }

    function rem_register_agent(){

        if (isset($_REQUEST)) {

            $resp = array();
            // Lets Check if username already exists
            if (username_exists( $_REQUEST['username'] ) || email_exists( $_REQUEST['useremail'] )) {
                $resp = array('status' => 'already', 'msg' => __( 'Username or Email already exists', 'real-estate-manager' ));
            } else {

                $_REQUEST['time'] = current_time( 'mysql' );

                $previous_users = get_option( 'rem_pending_users' );

                if ( $previous_users != '' && is_array($previous_users)) {
                   foreach ($previous_users as $single_user) {
                       if ($single_user['username'] == $_REQUEST['username'] || $single_user['useremail'] == $_REQUEST['useremail']) {
                            $resp = array('status' => 'already', 'msg' => __( 'Username or Email already exists', 'real-estate-manager' ));
                            echo json_encode($resp);
                            exit;
                       }
                   }
                   $previous_users[] = $_REQUEST;
                } else {
                   $previous_users = array($_REQUEST);
                }

                if (update_option( 'rem_pending_users', $previous_users )) {
                    do_action( 'rem_new_agent_register', $_REQUEST );
                    $resp = array('status' => 'success', 'msg' => __( 'Registered Successfully, please wait until admin approves.', 'real-estate-manager' ));
                } else {
                    $resp = array('status' => 'error', 'msg' => __( 'Error, please try later', 'real-estate-manager' ));
                }
                
            }

            echo json_encode($resp);
            die(0);
        }

    }
}
?>