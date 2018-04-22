<?php

/**
* Real Estate Management Main Class - Since 1.0.0
*/

class WCP_Real_Estate_Management
{
    
    function __construct(){

        /***********************************************************************************************/
        /* Admin Menus, Settings, Scripts */
        /***********************************************************************************************/

        // Actions
        add_action( 'init', array($this, 'register_property' ) );
        add_action( 'admin_menu', array( $this, 'menu_pages' ) );
        add_action( 'admin_enqueue_scripts', array($this, 'admin_scripts' ) );
        add_action( 'wp_enqueue_scripts', array($this, 'front_scripts' ) );
        add_action( 'save_post', array($this, 'save_property' ) );
        add_action( 'add_meta_boxes', array($this, 'property_metaboxes' ) );
        add_action( 'admin_init', array($this, 'rem_role_cap') , 999);

        // Edit Profile Fields
        add_action( 'show_user_profile', array($this, 'rem_agent_extra_fields' ) );
        add_action( 'edit_user_profile', array($this, 'rem_agent_extra_fields' ) );

        // Save Profile Fields
        add_action( 'personal_options_update', array($this, 'save_rem_agent_fields' ) );
        add_action( 'edit_user_profile_update', array($this, 'save_rem_agent_fields' ) );        

        // Filters
        add_filter( 'post_updated_messages', array($this, 'property_messages' ) );
        add_filter( 'single_template', array($this, 'property_front_template') );
        add_filter( 'template_include', array($this, 'rem_templates'), 99 );

        //disable WordPress sanitization to allow more than just $allowedtags from /wp-includes/kses.php
        remove_filter('pre_user_description', 'wp_filter_kses');

        // Translations
        add_action( 'plugins_loaded', array($this, 'wcp_load_plugin_textdomain' ) );

        // Change author in proeprties page
        add_filter( 'wp_dropdown_users', array($this, 'author_override') );

        // Permalink settings
        add_filter( 'load-options-permalink.php', array($this, 'permalink_settings') );        

        /***********************************************************************************************/
        /* AJAX Callbacks */
        /***********************************************************************************************/

        // Saving Admin Settings
        add_action( 'wp_ajax_wcp_rem_save_settings', array($this, 'save_admin_settings' ) );
        
        // Contact Agent
        add_action( 'wp_ajax_rem_contact_agent', array($this, 'send_email_agent' ) );
        add_action( 'wp_ajax_nopriv_rem_contact_agent', array($this, 'send_email_agent' ) );

        // Agent Approve/ Deny
        add_action( 'wp_ajax_deny_agent', array($this, 'deny_agent' ) );
        add_action( 'wp_ajax_approve_agent', array($this, 'approve_agent' ) );

        add_filter( 'plugin_action_links', array($this, 'updrage_pro_button'), 10, 5 );
    }

    function wcp_load_plugin_textdomain(){
        load_plugin_textdomain( 'real-estate-manager', FALSE, basename( REM_PATH ) . '/languages/' );
    }

    /**
    * Registers a new post type property
    * @since 1.0.0
    */
    function register_property() {
        include_once REM_PATH.'/inc/admin/register-property.php';
    }
    
    /**
    * Property page settings metaboxes
    * @since 1.0.0
    */
    function property_metaboxes(){
        add_meta_box( 'property_settings_meta_box', __( 'Property Information', 'real-estate-manager' ), array($this, 'render_property_settings' ), array('rem_property'));
        add_meta_box( 'property_images_meta_box', __( 'Gallery Images', 'real-estate-manager' ), array($this, 'render_property_images' ), array('rem_property'));
        add_meta_box( 'rem_pro_version', 'Pro Version', array($this, 'render_pro_version' ), array('rem_property'), 'side');
    }

    function render_pro_version(){ ?>
        <h3><?php _e( 'Real Estate Manager Pro Features', 'real-estate-manager' ); ?></h3>
        <ol>
            <li><?php _e( 'Drag Drop Interface for Fields', 'real-estate-manager' ); ?></li>
            <li><?php _e( 'Create Unlimited Custom Fields', 'real-estate-manager' ); ?></li>
            <li><?php _e( 'Property approval after submission', 'real-estate-manager' ); ?></li>
            <li><?php _e( 'Custom icons on map by property type or purpose', 'real-estate-manager' ); ?></li>
            <li><?php _e( 'Properties Touch Sliders', 'real-estate-manager' ); ?></li>
            <li><?php _e( 'Location Based Listings', 'real-estate-manager' ); ?></li>
            <li><?php _e( 'Drag on Map when creating property', 'real-estate-manager' ); ?></li>
            <li><?php _e( 'Support for Extensions', 'real-estate-manager' ); ?></li>
            <li><?php _e( 'Your existing properties and settings will remain saved ', 'real-estate-manager' ); ?></li>
            <li><?php _e( 'Free Updates and New Features', 'real-estate-manager' ); ?></li>
            <li><?php _e( '24/7 Support', 'real-estate-manager' ); ?></li>
        </ol>
        <a style="width: 100%; text-align:center;" target="_blank" class="button button-primary button-hero" href="https://codecanyon.net/item/real-estate-manager-pro/20482813?ref=WebCodingPlace">
            <?php _e( 'Unlock Pro Features', 'real-estate-manager' ); ?>
        </a>
    <?php }    

    function render_property_settings(){
        wp_nonce_field( plugin_basename( __FILE__ ), 'rem_property_settings_nonce' );
        include_once REM_PATH.'/inc/admin/property-settings-metabox.php';
    }

    function render_property_images(){
        include REM_PATH.'/inc/admin/property-images-metabox.php';
    }

    function save_property($post_id){
        // verify if this is an auto save routine. 
        // If it is our form has not been submitted, so we dont want to do anything
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
            return;

        // verify this came from the our screen and with proper authorization,
        // because save_post can be triggered at other times
        if ( !isset( $_POST['rem_property_settings_nonce'] ) )
            return;

        if ( !wp_verify_nonce( $_POST['rem_property_settings_nonce'], plugin_basename( __FILE__ ) ) )
            return;

        // OK, we're authenticated: we need to find and save the data

        if (isset($_POST['rem_property_data']) && $_POST['rem_property_data'] != '') {
            foreach ($_POST['rem_property_data'] as $key => $value) {
                update_post_meta( $post_id, 'rem_'.$key, $value );
            }
            if (!isset($_POST['rem_property_data']['property_detail_cbs'])) {
                update_post_meta( $post_id, 'rem_property_detail_cbs', '' );
            }        
        }
    }

    function admin_scripts($check){
        global $post;
        if ( $check == 'post-new.php' || $check == 'post.php' || 'edit.php') {
            if (isset($post->post_type) && 'rem_property' === $post->post_type) {
                wp_enqueue_media();
                wp_enqueue_style( 'rem-bs-css', REM_URL . '/assets/admin/css/bootstrap.min.css' );
                wp_enqueue_script( 'rem-new-property-js', REM_URL . '/assets/admin/js/admin-property.js' , array('jquery', 'wp-color-picker', 'jquery-ui-sortable'));
                wp_enqueue_style( 'rem-new-property-css', REM_URL . '/assets/admin/css/admin.css' );
            }
        }

        if ( $check == 'rem_property_page_rem_settings' ) {
            wp_enqueue_style( 'wp-color-picker' );
            wp_enqueue_media();
            wp_enqueue_style( 'rem-bs-css', REM_URL . '/assets/admin/css/bootstrap.min.css' );
            wp_enqueue_style( 'rem-select2-css', REM_URL . '/assets/admin/css/select2.min.css' );
            wp_enqueue_style( 'rem-new-property-css', REM_URL . '/assets/admin/css/admin.css' );
            wp_enqueue_script( 'rem-select2-js', REM_URL . '/assets/admin/js/select2.min.js' , array('jquery'));
            wp_enqueue_script( 'rem-save-settings-js', REM_URL . '/assets/admin/js/page-settings.js' , array('jquery', 'wp-color-picker' ));
        }

        if ($check == 'user-edit.php' || $check == 'profile.php') {
            wp_enqueue_media();
            wp_enqueue_script( 'rem-profile-edit', REM_URL . '/assets/admin/js/profile.js' , array('jquery'));
        }

        if ($check == 'rem_property_page_rem_property_agents') {
            wp_enqueue_style( 'rem-bs-css', REM_URL . '/assets/admin/css/bootstrap.min.css' );
            wp_enqueue_script( 'rem-agents-settings-js', REM_URL . '/assets/admin/js/manage-agents.js'  , array('jquery'));
        }

        if ($check == 'rem_property_page_rem_custom_fields') {
            wp_enqueue_script( 'rem-save-settings-page', REM_URL . '/assets/admin/js/property-layout.js'  , array( 'jquery', 'jquery-ui-accordion', 'jquery-ui-sortable', 'jquery-ui-draggable' ));
        }
    }

    function front_scripts(){
        $layout_agent = rem_get_option('agent_page_layout', 'plugin');
        $layout_archive = rem_get_option('archive_property_layout', 'plugin');
        if (is_singular( 'rem_property' )) {

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

        }
        if(is_author() && $layout_agent == 'plugin'){
            global $wp_query;
            $curauth = $wp_query->get_queried_object();
            $author_info = $curauth;
            $author_id = $curauth->ID;
            // if ( in_array( 'rem_property_agent', (array) $curauth->roles ) ) {
            if ( 1 ) {
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
            }            
        }
        if (is_archive() && $layout_archive == 'plugin') {
            global $post;
            if (isset($post->post_type) && $post->post_type == 'rem_property') {
                rem_load_bs_and_fa();
                rem_load_basic_styles();

                // Imagesfill and Loaded
                wp_enqueue_script( 'rem-imagefill-js', REM_URL . '/assets/front/lib/imagefill.min.js', array('jquery'));   
                wp_enqueue_script( 'rem-imagesloaded-js', REM_URL . '/assets/front/lib/imagesloaded.min.js', array('jquery'));   
                
                // Page Specific
                wp_enqueue_style( 'rem-archive-property-css', REM_URL . '/assets/front/css/archive-property.css' );
                wp_enqueue_script( 'rem-archive-property-js', REM_URL . '/assets/front/js/archive-property.js', array('jquery'));
            }
        }
    }

    function rem_role_cap(){

        if (!$GLOBALS['wp_roles']->is_role( 'rem_property_agent' )) {
            add_role(
                'rem_property_agent',
                __( 'Property Agent', 'real-estate-manager' ),
                array(
                    'read' => true,
                    'edit_posts' => true,
                    'delete_posts' => false,
                    'publish_posts' => false,
                    'upload_files' => true,
                )
            );
            flush_rewrite_rules();
        }

        $roles = array('rem_property_agent', 'editor', 'administrator');

        // Loop through each role and assign capabilities
        foreach($roles as $the_role) { 

            $role = get_role($the_role);

            if ($role) {
                $role->add_cap( 'read' );
                $role->add_cap( 'read_rem_property');
                $role->add_cap( 'read_private_rem_properties' );
                $role->add_cap( 'edit_rem_property' );
                $role->add_cap( 'edit_rem_properties' );

                if($the_role == 'administrator'){
                    $role->add_cap( 'edit_others_rem_properties' );
                    $role->add_cap( 'delete_others_rem_properties' );
                }

                $role->add_cap( 'edit_published_rem_properties' );
                $role->add_cap( 'publish_rem_properties' );
                $role->add_cap( 'delete_private_rem_properties' );
                $role->add_cap( 'delete_published_rem_properties' );
            }
        }
    }

    function rem_agent_extra_fields($user){
        if (1) {
            include REM_PATH . '/inc/menu/agent-profile-fields.php';
        }
    }

    function save_rem_agent_fields($user_id){
        if ( current_user_can( 'edit_user', $user_id )){
            $agent_fields = $this->get_agent_fields();
            foreach ($agent_fields as $field) {
                update_user_meta( $user_id, $field['key'], $_POST[$field['key']] );
            }
        }
    }

    function get_all_property_features(){

        $property_individual_cbs = array(
            __( 'Attic', 'real-estate-manager' ),
            __( 'Gas Heat', 'real-estate-manager' ),
            __( 'Balcony', 'real-estate-manager' ),
            __( 'Wine Cellar', 'real-estate-manager' ),
            __( 'Basketball Court', 'real-estate-manager' ),
            __( 'Trash Compactors', 'real-estate-manager' ),
            __( 'Fireplace', 'real-estate-manager' ),
            __( 'Pool', 'real-estate-manager' ),
            __( 'Lake View', 'real-estate-manager' ),
            __( 'Solar Heat', 'real-estate-manager' ),
            __( 'Separate Shower', 'real-estate-manager' ),
            __( 'Wet Bar', 'real-estate-manager' ),
            __( 'Remodeled', 'real-estate-manager' ),
            __( 'Skylights', 'real-estate-manager' ),
            __( 'Stone Surfaces', 'real-estate-manager' ),
            __( 'Golf Course', 'real-estate-manager' ),
            __( 'Health Club', 'real-estate-manager' ),
            __( 'Backyard', 'real-estate-manager' ),
            __( 'Pet Allowed', 'real-estate-manager' ),
            __( 'Office/Den', 'real-estate-manager' ),
            __( 'Laundry', 'real-estate-manager' ),
        );

        if(has_filter('rem_property_features')) {
            $property_individual_cbs = apply_filters('rem_property_features', $property_individual_cbs);
        }

        return $property_individual_cbs;
    }

    function get_all_property_types(){

        $property_type_options  = array(
            __( 'Duplex', 'real-estate-manager' )   => __( 'Duplex', 'real-estate-manager' ),
            __( 'House', 'real-estate-manager' )    => __( 'House', 'real-estate-manager' ),
            __( 'Office', 'real-estate-manager' )   => __( 'Office', 'real-estate-manager' ),
            __( 'Retail', 'real-estate-manager' )   => __( 'Retail', 'real-estate-manager' ),
            __( 'Vila', 'real-estate-manager' )     => __( 'Vila', 'real-estate-manager' ),
        );

        if(has_filter('rem_property_types')) {
            $property_type_options = apply_filters('rem_property_types', $property_type_options);
        }

        return $property_type_options;
    }

    function get_all_property_purpose(){
        
        $property_purpose_options  = array(
           __( 'Rent', 'real-estate-manager' )  => __( 'Rent', 'real-estate-manager' ) ,
           __( 'Sell', 'real-estate-manager' )  => __( 'Sell', 'real-estate-manager' ) ,
        );

        if(has_filter('rem_property_purposes')) {
            $property_purpose_options = apply_filters('rem_property_purposes', $property_purpose_options);
        }

        return $property_purpose_options;
    }

    function get_all_property_status(){

        $property_status_options  = array(
            __( 'Normal', 'real-estate-manager' )       => __( 'Normal', 'real-estate-manager' ),
            __( 'Available', 'real-estate-manager' )    => __( 'Available', 'real-estate-manager' ),
            __( 'Not Available', 'real-estate-manager' )=> __( 'Not Available', 'real-estate-manager' ),
            __( 'Sold', 'real-estate-manager' )         => __( 'Sold', 'real-estate-manager' ),
            __( 'Open House', 'real-estate-manager' )   => __( 'Open House', 'real-estate-manager' ),
        );

        if(has_filter('rem_property_statuses')) {
            $property_status_options = apply_filters('rem_property_statuses', $property_status_options);
        }

        return $property_status_options;
    }

    function send_email_agent(){
        if (isset($_REQUEST) && $_REQUEST != '') {
            extract($_REQUEST);

            $agent_info = get_userdata($agent_id);
            $agent_email = $agent_info->user_email;

            // Additional Emails
            $emails_meta = rem_get_option('email_agent_contact', '');



            if (isset($subject) && $subject != '') {
                $subject = $subject;
            } else {
                $subject = get_the_title( $property_id );
            }
            $headers = array();
            $headers[] = 'From: '.$client_name.'  <'.$client_email.'>' . "\r\n";
            
            if ($emails_meta != '') {
                $emails = explode("\n", $emails_meta);
                if (is_array($emails)) {
                    foreach ($emails as $e) {
                        $headers[] = "Cc: $e";
                    }
                }
            }
            if (wp_mail( $agent_email, $subject, $client_msg, $headers )) {
                $resp = array('status' => 'sent', 'msg' => __( 'Email Sent Successfully', 'real-estate-manager' ) );
            } else {
                $resp = array('status' => 'fail', 'msg' => __( 'There is some problem, please try later', 'real-estate-manager' ) );
            }
        }

        echo json_encode($resp); die(0);
    }

    function menu_pages(){
        add_submenu_page( 'edit.php?post_type=rem_property', 'All Property Agents', __( 'Agents', 'real-estate-manager' ), 'manage_options', 'rem_property_agents', array($this, 'render_agents_page') );
        add_submenu_page( 'edit.php?post_type=rem_property', 'Real Estate Manager - Custom Fields', __( 'Custom Fields', 'real-estate-manager' ), 'manage_options', 'rem_custom_fields', array($this, 'render_custom_fields_page') );
        add_submenu_page( 'edit.php?post_type=rem_property', 'Real Estate Manager - Settings', __( 'Settings', 'real-estate-manager' ), 'manage_options', 'rem_settings', array($this, 'render_settings_page') );
        add_submenu_page( 'edit.php?post_type=rem_property', 'Real Estate Manager - Documentation', __( 'Shortcodes', 'real-estate-manager' ), 'manage_options', 'rem_documentation', array($this, 'render_docs_page') );
    }

    function render_custom_fields_page(){
        include_once REM_PATH. '/inc/menu/custom-fields/custom-fields-page.php';
    }

    function render_agents_page(){
        include_once REM_PATH. '/inc/menu/page-agents.php';
    }

    function render_docs_page(){
        include_once REM_PATH. '/inc/menu/page-docs.php';
    }

    function render_settings_page(){
        include_once REM_PATH. '/inc/menu/page-settings.php';
    }

    function deny_agent(){
        if (isset($_REQUEST) && current_user_can( 'manage_options' )) {
            $pending_agents = get_option( 'rem_pending_users' );
            unset($pending_agents[$_REQUEST['userindex']]);
            update_option( 'rem_pending_users', $pending_agents );
            do_action( 'rem_new_agent_rejected', $_REQUEST['userindex'] );
        }
        die(0);
    }

    function approve_agent(){
        if (isset($_REQUEST) && current_user_can( 'manage_options' )) {
            $pending_agents = get_option( 'rem_pending_users' );

            $new_agent = $pending_agents[$_REQUEST['userindex']];

            extract($new_agent);

            $agent_id = wp_create_user( $username, $password, $useremail );

            do_action( 'rem_new_agent_approved', $new_agent );

            wp_update_user( array( 'ID' => $agent_id, 'role' => 'rem_property_agent' ) );

            update_user_meta( $agent_id, 'first_name', $firstname);
            update_user_meta( $agent_id, 'last_name', $lastname);
            update_user_meta( $agent_id, 'description', $info);

            $agent_fields = $this->get_agent_fields();

            foreach ($agent_fields as $field) {
                if (isset($new_agent[$field['key']])) {
                    update_user_meta( $agent_id, $field['key'], $new_agent[$field['key']]);
                }
            }

            unset($pending_agents[$_REQUEST['userindex']]);

            update_option( 'rem_pending_users', $pending_agents );
        }

        die(0);
    }
    
    static function rem_activated(){
        /*
         * Adding Custom Role 'rem_property_agent'
         */
        $roles_set = get_option('rem_role_isset');

        if(!$roles_set){
            add_role(
                'rem_property_agent',
                __( 'Property Agent', 'real-estate-manager' ),
                array(
                    'read' => true,
                    'edit_posts' => true,
                    'delete_posts' => false,
                    'publish_posts' => false,
                    'upload_files' => true,
                )
            );
            flush_rewrite_rules();
            update_option('rem_role_isset', true);
        }       
    }

    function property_front_template($single_template){
        global $post;
        $property_layout = rem_get_option('single_property_layout', 'plugin');

        if (isset($post->post_type) && $post->post_type == 'rem_property' && $property_layout == 'plugin') {
            $single_template = REM_PATH . '/templates/single/default.php';
        }

        if (isset($post->post_type) && $post->post_type == 'rem_property' && $property_layout == 'full_width') {
            $single_template = REM_PATH . '/templates/single/full-width.php';
        }

        if (isset($post->post_type) && $post->post_type == 'rem_property' && $property_layout == 'left_sidebar') {
            $single_template = REM_PATH . '/templates/single/left-sidebar.php';
        }

        return $single_template;
    }

    function rem_templates($template){
        $layout_agent = rem_get_option('agent_page_layout', 'plugin');
        $layout_archive = rem_get_option('archive_property_layout', 'plugin');

        if (is_author() && $layout_agent == 'plugin') {
            global $wp_query;
            $curauth = $wp_query->get_queried_object();
            $author_info = $curauth;
            $author_id = $curauth->ID;
            // if ( in_array( 'rem_property_agent', (array) $curauth->roles ) ) {
            if ( 1 ) {
                $template = REM_PATH . '/templates/agent.php';
            }
        }
        if (is_archive() && $layout_archive == 'plugin') {
            global $post;
            if (isset($post->post_type) && $post->post_type == 'rem_property') {
                $template = REM_PATH . '/templates/list-properties.php';
            }
        }
        return $template;
    }

    function admin_settings_fields(){

        include REM_PATH.'/inc/menu/admin-settings-arr.php';

        return $fieldsData;
    }

    function render_setting_field($field){
        include REM_PATH.'/inc/menu/render-admin-settings.php';
    }

    function save_admin_settings(){
        if (isset($_REQUEST)) {
            update_option( 'rem_all_settings', $_REQUEST );
            echo __( 'Settings Saved', 'real-estate-manager' );
        }
        die(0);
    }

    function property_messages( $messages ) {
        $post             = get_post();
        $post_type        = get_post_type( $post );
        $post_type_object = get_post_type_object( $post_type );

        $messages['rem_property'] = array(
            0  => '', // Unused. Messages start at index 1.
            1  => __( 'Property updated.', 'real-estate-manager' ),
            2  => __( 'Custom field updated.', 'real-estate-manager' ),
            3  => __( 'Custom field deleted.', 'real-estate-manager' ),
            4  => __( 'Property updated.', 'real-estate-manager' ),
            /* translators: %s: date and time of the revision */
            5  => isset( $_GET['revision'] ) ? sprintf( __( 'Property restored to revision from %s', 'real-estate-manager' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
            6  => __( 'Property published.', 'real-estate-manager' ),
            7  => __( 'Property saved.', 'real-estate-manager' ),
            8  => __( 'Property submitted.', 'real-estate-manager' ),
            9  => sprintf(
                __( 'Property scheduled for: <strong>%1$s</strong>.', 'real-estate-manager' ),
                // translators: Publish box date format, see http://php.net/date
                date_i18n( __( 'M j, Y @ G:i', 'real-estate-manager' ), strtotime( $post->post_date ) )
            ),
            10 => __( 'Property draft updated.', 'real-estate-manager' )
        );

        if ( $post_type_object->publicly_queryable && 'rem_property' === $post_type ) {
            $permalink = get_permalink( $post->ID );

            $view_link = sprintf( ' <a href="%s">%s</a>', esc_url( $permalink ), __( 'View Property', 'real-estate-manager' ) );
            $messages[ $post_type ][1] .= $view_link;
            $messages[ $post_type ][6] .= $view_link;
            $messages[ $post_type ][9] .= $view_link;

            $preview_permalink = add_query_arg( 'preview', 'true', $permalink );
            $preview_link = sprintf( ' <a target="_blank" href="%s">%s</a>', esc_url( $preview_permalink ), __( 'Preview Property', 'real-estate-manager' ) );
            $messages[ $post_type ][8]  .= $preview_link;
            $messages[ $post_type ][10] .= $preview_link;
        }

        return $messages;
    }

    function single_property_fields(){
        $area_unit = rem_get_option('properties_area_unit', 'Sq Ft');
        $saved_fields = get_option( 'rem_property_fields' );
        $inputFields  = array();
        if ($saved_fields != '' && is_array($saved_fields)) {
            $inputFields = $saved_fields;
        } else {
            $inputFields = array(

                array(
                    'key' => 'property_area',
                    'type' => 'text',
                    'tab' => 'general_settings',
                    'default' => '',
                    'title' => __( 'Area', 'real-estate-manager' ),
                    'help' => __( 'Size - ', 'real-estate-manager' ).$area_unit,
                ),

                array(
                    'key' => 'property_address',
                    'type' => 'text',
                    'tab' => 'general_settings',
                    'default' => __( 'Some Area, City', 'real-estate-manager' ),
                    'title' => __( 'Address', 'real-estate-manager' ),
                    'help' => __( 'If latitude and longitude fields are blank, this address will be used for rendering map', 'real-estate-manager' ),
                ),

                array(
                    'key' => 'property_state',
                    'type' => 'text',
                    'tab' => 'general_settings',
                    'default' => '',
                    'title' => __( 'State', 'real-estate-manager' ),
                    'help' => __( 'State', 'real-estate-manager' ),
                ),

                array(
                    'key' => 'property_zipcode',
                    'type' => 'text',
                    'tab' => 'general_settings',
                    'default' => '',
                    'title' => __( 'Zip Code', 'real-estate-manager' ),
                    'help' => __( 'Zipcode', 'real-estate-manager' ),
                ),

                array(
                    'key' => 'property_city',
                    'type' => 'text',
                    'tab' => 'general_settings',
                    'default' => '',
                    'title' => __( 'City', 'real-estate-manager' ),
                    'help' => __( 'City', 'real-estate-manager' ),
                ),

                array(
                    'key' => 'property_country',
                    'type' => 'text',
                    'tab' => 'general_settings',
                    'default' => '',
                    'title' => __( 'Country', 'real-estate-manager' ),
                    'help' => __( 'Country', 'real-estate-manager' ),
                ),

                array(
                    'key' => 'property_rooms',
                    'type' => 'number',
                    'tab' => 'internal_structure',
                    'default' => '',
                    'title' => __( 'Rooms', 'real-estate-manager' ),
                    'help' => __( 'Number of rooms', 'real-estate-manager' ),
                ),
            );
        }

        if(has_filter('rem_property_settings_fields')) {
            $inputFields = apply_filters('rem_property_settings_fields', $inputFields);
        }

        return $inputFields;
    }

    function single_property_fields_builtin(){
        $inputFields = array(
            array(
                'key' => 'property_price',
                'type' => 'text',
                'tab' => 'general_settings',
                'default' => '',
                'title' => __( 'Price', 'real-estate-manager' ),
                'help' => __( 'Regular Price of Property', 'real-estate-manager' ),
            ),     
            array(
                'key' => 'property_sale_price',
                'type' => 'text',
                'tab' => 'general_settings',
                'default' => '',
                'title' => __( 'Sale Price', 'real-estate-manager' ),
                'help' => __( 'Sale Price of Property', 'real-estate-manager' ),
            ),            
            array(
                'key' => 'property_type',
                'type' => 'select',
                'tab' => 'general_settings',
                'default' => 'duplex',
                'title' => __( 'Property Type', 'real-estate-manager' ),
                'help' => sprintf( '%s <a href="%s">%s.</a>', __( 'Choose type of property. You can add your own', 'real-estate-manager' ), admin_url('edit.php?post_type=rem_property&page=rem_settings#property-settings'), __( 'here', 'real-estate-manager' ) ),
                'options'   => $this->get_all_property_types(),
            ),
            array(
                'key' => 'property_purpose',
                'type' => 'select',
                'tab' => 'general_settings',
                'default' => '2000',
                'title' => __( 'Purpose', 'real-estate-manager' ),
                'help' => sprintf( '%s <a href="%s">%s.</a>', __( 'Choose purpose of property. You can add your own', 'real-estate-manager' ), admin_url('edit.php?post_type=rem_property&page=rem_settings#property-settings'), __( 'here', 'real-estate-manager' ) ),
                'options'   => $this->get_all_property_purpose(),
            ),
            array(
                'key' => 'property_status',
                'type' => 'select',
                'tab' => 'general_settings',
                'default' => 'normal',
                'title' => __( 'Status', 'real-estate-manager' ),
                'help' => sprintf( '%s <a href="%s">%s.</a>', __( 'Choose status of property. You can add your own', 'real-estate-manager' ), admin_url('edit.php?post_type=rem_property&page=rem_settings#property-settings'), __( 'here', 'real-estate-manager' ) ),
                'options'   => $this->get_all_property_status(),
            ),
            array(
                'key' => 'property_bedrooms',
                'type' => 'text',
                'tab' => 'internal_structure',
                'default' => '',
                'title' => __( 'Bedrooms', 'real-estate-manager' ),
                'help' => __( 'Number of bedrooms', 'real-estate-manager' ),
            ),

            array(
                'key' => 'property_bathrooms',
                'type' => 'text',
                'tab' => 'internal_structure',
                'default' => '',
                'title' => __( 'Bathrooms', 'real-estate-manager' ),
                'help' => __( 'Number of bathrooms', 'real-estate-manager' ),
            ),
        );

        if(has_filter('rem_property_settings_fields_builtin')) {
            $inputFields = apply_filters('rem_property_settings_fields_builtin', $inputFields);
        }

        return $inputFields;
    }

    function author_override($output){
        global $post, $user_ID;
        if (isset($post->post_type) && 'rem_property' === $post->post_type) {

            // return if this isn't the theme author override dropdown
            if (!preg_match('/post_author_override/', $output)) return $output;

            // return if we've already replaced the list (end recursion)
            if (preg_match ('/post_author_override_replaced/', $output)) return $output;

            // replacement call to wp_dropdown_users
            $output = wp_dropdown_users(array(
                'echo' => 0,
                'name' => 'post_author_override_replaced',
                'selected' => empty($post->ID) ? $user_ID : $post->post_author,
                'include_selected' => true
            ));

            // put the original name back
            $output = preg_replace('/post_author_override_replaced/', 'post_author_override', $output);

        }

        return $output;

    }

    function permalink_settings(){
        if( isset( $_POST['rem_property_permalink'] ) ){
            update_option( 'rem_property_permalink', sanitize_title_with_dashes( $_POST['rem_property_permalink'] ) );
        }
        
        // Add a settings field to the permalink page
        add_settings_field( 'rem_property_permalink', __( 'Property Page Base' , 'real-estate-manager' ), array($this, 'render_property_permalink_field'), 'permalink', 'optional' );
    }

    function render_property_permalink_field(){
        $s_value = get_option( 'rem_property_permalink' );
        $value = ($s_value != '') ? $s_value : 'property' ;
        echo '<input type="text" value="' . esc_attr( $value ) . '" name="rem_property_permalink" id="rem_property_permalink" class="regular-text" />';
    }

    function get_agent_fields(){
        $saved_fields = get_option( 'rem_agent_fields' );
        $fields  = array();
        if ($saved_fields != '' && is_array($saved_fields)) {
            $fields = $saved_fields;
        } else {        
            $fields = array(
                array(
                    'key' => 'rem_agent_meta_image',
                    'type' => 'image',
                    'display' => array('admin'),
                    'title' => __( 'Picture of Agent', 'real-estate-manager' ),
                    'help' => __( 'Upload an additional image for your profile', 'real-estate-manager' ),
                ),
                array(
                    'key' => 'rem_agent_url',
                    'type' => 'text',
                    'display' => array('card', 'register', 'edit'),
                    'tab' => 'personal_info',
                    'icon_class' => 'fa fa-info-circle',
                    'title' => __( 'Profile Url', 'real-estate-manager' ),
                    'help' => __( 'Provide url for agent profile', 'real-estate-manager' ),
                ),
                array(
                    'key' => 'rem_mobile_url',
                    'type' => 'text',
                    'display' => array('card', 'register', 'edit'),
                    'tab' => 'personal_info',
                    'icon_class' => 'fa fa-phone',
                    'title' => __( 'Phone Number', 'real-estate-manager' ),
                ),
                array(
                    'key' => 'rem_facebook_url',
                    'type' => 'text',
                    'tab' => 'social_profiles',
                    'display' => array('card', 'register', 'edit'),
                    'icon_class' => 'fa fa-facebook',
                    'title' => __( 'Facebook Profile', 'real-estate-manager' ),
                ),
                array(
                    'key' => 'rem_twitter_url',
                    'type' => 'text',
                    'tab' => 'social_profiles',
                    'display' => array('card', 'register', 'edit'),
                    'icon_class' => 'fa fa-twitter',
                    'title' => __( 'Twitter Profile', 'real-estate-manager' ),
                ),
                array(
                    'key' => 'rem_googleplus_url',
                    'type' => 'text',
                    'tab' => 'social_profiles',
                    'display' => array('card', 'register', 'edit'),
                    'icon_class' => 'fa fa-google-plus',
                    'title' => __( 'Google+ Profile', 'real-estate-manager' ),
                ),
                array(
                    'key' => 'rem_linkedin_url',
                    'type' => 'text',
                    'display' => array('card', 'register', 'edit'),
                    'tab' => 'social_profiles',
                    'icon_class' => 'fa fa-linkedin',
                    'title' => __( 'LinkedIn Profile', 'real-estate-manager' ),
                ),
                array(
                    'key' => 'rem_facebook_page_url',
                    'type' => 'text',
                    'display' => array('card', 'register', 'edit'),
                    'tab' => 'social_profiles',
                    'icon_class' => 'fa fa-facebook-square',
                    'title' => __( 'Facebook Page', 'real-estate-manager' ),
                ),
                array(
                    'key' => 'rem_instagram_url',
                    'type' => 'text',
                    'display' => array('card', 'register', 'edit'),
                    'tab' => 'social_profiles',
                    'icon_class' => 'fa fa-instagram',
                    'title' => __( 'Instagram', 'real-estate-manager' ),
                ),
                array(
                    'key' => 'rem_youtube_url',
                    'type' => 'text',
                    'tab' => 'social_profiles',
                    'display' => array('card', 'register', 'edit'),
                    'icon_class' => 'fa fa-youtube',
                    'title' => __( 'YouTube', 'real-estate-manager' ),
                ),
                array(
                    'key' => 'rem_user_tagline',
                    'type' => 'text',
                    'tab' => 'social_profiles',
                    'display' => array('register', 'edit'),
                    'title' => __( 'User Tagline', 'real-estate-manager' ),
                    'help' => __( 'Will display under username', 'real-estate-manager' ),
                ),
                array(
                    'key' => 'rem_user_skills',
                    'type' => 'textarea',
                    'tab' => 'skills',
                    'display' => array('register', 'edit'),
                    'title' => __( 'Skills Level', 'real-estate-manager' ),
                    'help' => __( 'Skill name with value on each line, eg: Properties Sold, 185', 'real-estate-manager' ),
                ),
                array(
                    'key' => 'rem_user_contact_sc',
                    'type' => 'text',
                    'title' => __( 'Contact Form Shortcode', 'real-estate-manager' ),
                    'help' => __( 'Leave blank for default contact form', 'real-estate-manager' ),
                ),
            );
        }

        $fields = apply_filters( 'rem_agent_fields', $fields );

        return $fields;
    }

    function updrage_pro_button($actions, $plugin_file){
        
        if (REM_BN == $plugin_file) {

            $rem_pro = array('rem_pro' => '<a style="color:red;" target="_blank" href="https://codecanyon.net/item/real-estate-manager-pro/20482813?ref=WebCodingPlace">' . __('Get Pro Version', 'real-estate-manager') . '</a>');
        
            $actions = array_merge($actions, $rem_pro);

        }
            
        return $actions;
    }

}
?>