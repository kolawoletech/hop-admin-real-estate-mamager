<?php
/**
* Real Estate Manager - This Class handles all hook (filters + actions) for templates
*/
class REM_Hooks
{
	
	function __construct(){
		add_action( 'rem_agent_picture', array($this, 'agent_picture'), 10, 1 );
		add_action( 'rem_property_details_icons', array($this, 'property_icons'), 20, 1 );
		add_action( 'rem_property_picture', array($this, 'property_picture'), 10, 2 );
		add_action( 'rem_property_box', array($this, 'property_box'), 10, 3 );
        add_action( 'rem_single_property_agent', array($this, 'single_property_agent_form'), 10, 1 );
        add_action( 'rem_contact_social_icons', array($this, 'contact_social_icons'), 10, 1 );
        add_action( 'rem_single_agent_after_contact_form', array($this, 'display_agent_custom_data'), 10, 1 );

        // Emails Hooks
        add_action( 'rem_new_agent_register', array($this, 'new_agent_registered' ), 10, 1 );
        add_action( 'rem_new_agent_approved', array($this, 'new_agent_approved' ), 10, 1 );
        add_action( 'rem_new_agent_rejected', array($this, 'new_agent_rejected' ), 10, 1 );

        // Property Fields Related
        add_filter( 'rem_property_features', array($this, 'property_features' ), 10, 1 );        
        add_filter( 'rem_property_types', array($this, 'property_types' ), 10, 1 );
        add_filter( 'rem_property_purposes', array($this, 'property_purposes' ), 10, 1 );
        add_filter( 'rem_property_statuses', array($this, 'property_statuses' ), 10, 1 );
        add_filter( 'rem_maps_location_icon', array($this, 'location_icon' ), 10, 1 );
        add_filter( 'rem_maps_drag_icon', array($this, 'drag_icon' ), 10, 1 );
        add_filter( 'rem_maps_api', array($this, 'maps_api' ), 10, 1 );

        // Single Property Display
        add_action( 'rem_single_property_slider', array($this, 'single_property_slider' ), 10, 1 );
        add_action( 'rem_single_property_contents', array($this, 'single_property_contents' ), 20, 1 );
        add_action( 'rem_single_property_contents', array($this, 'single_property_details' ), 30, 1 );
        add_action( 'rem_single_property_contents', array($this, 'single_property_features' ), 40, 1 );
        add_action( 'rem_single_property_contents', array($this, 'single_property_attachments' ), 45, 1 );
        add_action( 'rem_single_property_contents', array($this, 'single_property_video' ), 50, 1 );
        add_action( 'rem_single_property_contents', array($this, 'single_property_map' ), 60, 1 );
        add_action( 'rem_single_property_contents', array($this, 'single_property_tags' ), 70, 1 );

        // Pagination
        add_action( 'rem_pagination', array($this, 'render_rem_pagination' ), 10, 2 );

        // Tags page Title
        add_filter( 'get_the_archive_title', array($this, 'custom_archive_title' ), 10, 1 );
        add_action( 'pre_get_posts', array($this, 'archive_page_properties_count') );
        add_filter( 'plugin_row_meta', array($this, 'rem_action_btns'), 10, 2 );

        add_filter('manage_rem_property_posts_columns', array($this, 'rem_property_column_head'));
        add_action('manage_rem_property_posts_custom_column', array($this, 'rem_property_column_content'), 10, 2);        
	}

	function agent_picture($user_id){
		if(get_the_author_meta( 'rem_agent_meta_image', $user_id ) != '') {
			echo '<img src="'.esc_url_raw( get_the_author_meta( 'rem_agent_meta_image', $user_id ) ).'">';
		} else {
			echo get_avatar( $user_id , 512 );
		}		
	}

	function property_picture($id = '', $thumbnail = 'full'){
		if ($id == '') {
			global $post;
			$id = $post->ID;
		}

	    if( has_post_thumbnail($id) ){
	    	echo get_the_post_thumbnail( $id, $thumbnail, array('class' => 'img-responsive', 'data-pid' => $id ) );
	    }
	}

	function property_box($property_id, $style = '3', $target=""){
		global $rem_ob;
        $area = get_post_meta($property_id, 'rem_property_area', true);
		$property_type = get_post_meta($property_id, 'rem_property_type', true);
		$address = get_post_meta($property_id, 'rem_property_address', true);
		$latitude = get_post_meta($property_id, 'rem_property_latitude', true);
		$longitude = get_post_meta($property_id, 'rem_property_longitude', true);
		$city = get_post_meta($property_id, 'rem_property_city', true);
		$country = get_post_meta($property_id, 'rem_property_country', true);
		$purpose = get_post_meta($property_id, 'rem_property_purpose', true);
		$status = get_post_meta($property_id, 'rem_property_status', true);
		$bathrooms = get_post_meta($property_id, 'rem_property_bathrooms', true);
		$bedrooms = get_post_meta($property_id, 'rem_property_bedrooms', true);
        
        if (class_exists('REM_Property_Styles')) {
            $file_path = ABSPATH . '/wp-content/plugins/rem-property-listing-styles/templates/style'.$style.'.php';
        } else {
            $file_path = REM_PATH . '/templates/property/style'.$style.'.php';
        }

        if (file_exists($file_path)) {
		  include $file_path;
        }

	}

    function new_agent_registered($new_agent){

        // Sending Email to Admin
        $site_title = get_bloginfo();
        $admin_email = get_bloginfo('admin_email');
        
        $headers[] = "From: {$site_title}<{$admin_email}>";
        $headers[] = "Content-Type: text/html";
        $headers[] = "MIME-Version: 1.0\r\n";
        $subject = __( 'New Agent Registered ', 'real-estate-manager' ). $site_title;

        $message = (rem_get_option('email_admin_register_agent') != '') ? rem_get_option('email_admin_register_agent') : 'New agent is registered...' ;

        $message = str_replace("%username%", $new_agent['username'], $message);
        $message = str_replace("%email%", $new_agent['useremail'], $message);


        wp_mail( $admin_email, $subject, $message, $headers );

        // Sending Email to Agent
        $subject_agent = __( 'Registration Successfull ', 'real-estate-manager' ). $site_title;

        $message_for_agent = (rem_get_option('email_pending_agent') != '') ? rem_get_option('email_pending_agent') : 'Please wait for approval' ;
        
        $message_for_agent = str_replace("%username%", $new_agent['username'], $message_for_agent);
        $message_for_agent = str_replace("%email%", $new_agent['useremail'], $message_for_agent);

        wp_mail( $new_agent['useremail'], $subject_agent, $message_for_agent, $headers );

    }

    function new_agent_approved($new_agent){
        // Sending Email to Approved Agent
        $site_title = get_bloginfo();
        $admin_email = get_bloginfo('admin_email');
        
        $headers[] = "From: {$site_title}<{$admin_email}>";
        $headers[] = "Content-Type: text/html";
        $headers[] = "MIME-Version: 1.0\r\n";
        $subject = __( 'Approved ', 'real-estate-manager' ). $site_title;

        $message_for_agent = (rem_get_option('email_approved_agent') != '') ? rem_get_option('email_approved_agent') : 'You are Approved' ;
        
        $message_for_agent = str_replace("%username%", $new_agent['username'], $message_for_agent);
        $message_for_agent = str_replace("%email%", $new_agent['useremail'], $message_for_agent);

        wp_mail( $new_agent['useremail'], $subject, $message_for_agent, $headers );

    }

    function new_agent_rejected($new_agent){
        // Sending Email to Approved Agent
        $site_title = get_bloginfo();
        $admin_email = get_bloginfo('admin_email');
        
        $headers[] = "From: {$site_title}<{$admin_email}>";
        $headers[] = "Content-Type: text/html";
        $headers[] = "MIME-Version: 1.0\r\n";
        $subject = __( 'Rejected ', 'real-estate-manager' ). $site_title;

        $message_for_agent = (rem_get_option('email_reject_agent') != '') ? rem_get_option('email_reject_agent') : 'You are Approved' ;
        
        $message_for_agent = str_replace("%username%", $new_agent['username'], $message_for_agent);
        $message_for_agent = str_replace("%email%", $new_agent['useremail'], $message_for_agent);

        wp_mail( $new_agent['useremail'], $subject, $message_for_agent, $headers );

    }

    function property_icons($property_id){
		$bathrooms = get_post_meta( $property_id, 'rem_property_bathrooms', true );
		$bedrooms = get_post_meta( $property_id, 'rem_property_bedrooms', true );
		$status = get_post_meta($property_id, 'rem_property_status', true);
		$area = get_post_meta($property_id, 'rem_property_area', true);

        $property_details = array(
            /*'status' => array(
                'label' => __( 'Status', 'real-estate-manager' ),
                'class' => 'status',
                'value' => $status,
            ),*/
            'bed' => array(
                'label' => __( 'Beds', 'real-estate-manager' ),
                'class' => 'bed',
                'value' => $bedrooms,
            ),
            'bath' => array(
                'label' => __( 'Baths', 'real-estate-manager' ),
                'class' => 'bath',
                'value' => $bathrooms,
            ),
            'area' => array(
                'label' => __( 'Area', 'real-estate-manager' ),
                'class' => 'area',
                'value' => $area .' '. rem_get_option('properties_area_unit', 'Sq Ft'),
            ),
        );

        if(has_filter('rem_property_icons')) {
            $property_details = apply_filters('rem_property_icons', $property_details);
        }

	?>
    <dl class="detail">
        <?php
            foreach ($property_details as $key => $data) { ?>
                <?php if ($data['value'] != '') { ?>
                    <dt class="<?php echo $data['class']; ?>"><?php $data['label']; ?>:</dt><dd><span><?php echo $data['value']; ?></span></dd>
                <?php } ?>
            <?php }
        ?>
    </dl>
    <?php
    }

    function single_property_agent_form($author_id){
        $single_property_agent = rem_get_option('property_page_agent_card', 'enable');
        $p_sidebar = rem_get_option('property_page_sidebar', '');
        if ($single_property_agent == 'enable') {
            include REM_PATH . '/inc/sidebar-agent-contact.php';
        }
        if ( is_active_sidebar( $p_sidebar )  ) :
            dynamic_sidebar( $p_sidebar ); 
        endif;
    }

    function property_features($default_fields){

        if (rem_get_option('property_detail_fields') != '') {
            $options_arr = explode(PHP_EOL, rem_get_option('property_detail_fields'));
            $default_fields = array();
            foreach ($options_arr as $option) {
                $option = trim($option);
                if ($option != '') {
                    if (in_array($option, $default_fields)) {
                        $default_fields = array_diff($default_fields, array($option));
                    } else {
                        $default_fields[] = $option;
                    }
                }
            }
        }

        return $default_fields;
    }

    function property_types($default_fields){

        if (rem_get_option('property_type_options') != '') {
            $default_fields = array();
            $options_arr = explode(PHP_EOL, rem_get_option('property_type_options'));
            foreach ($options_arr as $option) {
                $option = trim($option);
                if ($option != '') {
                    if (in_array($option, $default_fields)) {
                        $default_fields = array_diff($default_fields, array($option));
                    } else {
                        $default_fields[$option] = $option;
                    }
                }
            }
        }

        return $default_fields;
    }

    function property_purposes($default_fields){

        if (rem_get_option('property_purpose_options') != '') {
            $options_arr = explode(PHP_EOL, rem_get_option('property_purpose_options'));
            $default_fields = array();
            foreach ($options_arr as $option) {
                $option = trim($option);
                if ($option != '') {
                    if (in_array($option, $default_fields)) {
                        $default_fields = array_diff($default_fields, array($option));
                    } else {
                        $default_fields[$option] = $option;
                    }
                }
            }
        }

        return $default_fields;
    }

    function property_statuses($default_fields){

        if (rem_get_option('property_status_options') != '') {
            $options_arr = explode(PHP_EOL, rem_get_option('property_status_options'));
            $default_fields = array();
            foreach ($options_arr as $option) {
                $option = trim($option);
                if ($option != '') {
                    if (in_array($option, $default_fields)) {
                        $default_fields = array_diff($default_fields, array($option));
                    } else {
                        $default_fields[$option] = $option;
                    }
                }
            }
        }

        return $default_fields;
    }

    function drag_icon($url){

        if (rem_get_option('maps_drag_image') != '') {
            $url = rem_get_option('maps_drag_image');
        }

        return $url;
    }

    function location_icon($url){

        if (rem_get_option('maps_location_image') != '') {
            $url = rem_get_option('maps_location_image');
        }

        return $url;
    }

    function maps_api($api){

        if (rem_get_option('maps_api_key') != '') {
            $api = rem_get_option('maps_api_key');
        }

        return $api;
    }

    function single_property_slider($property_id){
        global $rem_ob;
        $property_images = get_post_meta( $property_id, 'rem_property_images', true );
        $price = get_post_meta($property_id, 'rem_property_price', true);
        if (isset($property_images) && is_array($property_images)) { ?>
            <?php if($price){ ?>
                <span class="large-price"><?php echo rem_display_property_price($property_id); ?></span>
            <?php } ?>

            <div class="fotorama" data-width="100%" data-fit="cover" data-max-width="100%" data-nav="thumbs" data-transition="flip">
                <?php if(has_post_thumbnail( $property_id )){
                    echo get_the_post_thumbnail( $property_id, 'full' );
                } ?>
                <?php foreach ($property_images as $id) {
                    $image_url = wp_get_attachment_url( $id );
                    echo '<img src="'.$image_url.'">';
                } ?>
            </div>
        <?php }        
    }

    function single_property_contents($property_id){
        ?>
            <div class="section-title line-style">
                <h3 class="title"><?php echo get_the_title( $property_id ); ?></h3>
            </div>
            <div class="description">
                <?php
                    $content_property = get_post($property_id);
                    $content = $content_property->post_content;
                    $content = apply_filters('the_content', $content);
                    $content = str_replace(']]>', ']]&gt;', $content);
                    echo $content;
                ?>
            </div>            
        <?php
    }

    function single_property_features($property_id){
        $title = rem_get_option('single_property_features_text', __( 'Features', 'real-estate-manager' ));
        $property_details_cbs = get_post_meta( $property_id, 'rem_property_detail_cbs', true );
        if (is_array($property_details_cbs)) { ?>
            <div class="section-title line-style line-style">
                <h3 class="title"><?php echo $title; ?></h3>
            </div>
            <div class="details">
                <div class="row">
                    <?php foreach ($property_details_cbs as $option_name => $value) { ?>
                        <div class="col-sm-4 col-xs-6">
                            <span class="detail"><i class="fa fa-square"></i>
                                <?php echo (str_replace('_', ' ', ucwords(stripcslashes($option_name)))); ?>
                            </span>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php }
    }

    function single_property_attachments($property_id){
        $attachment_data = get_post_meta( $property_id, 'rem_file_attachments', true );
        if ($attachment_data != '') {
            $attachments = explode(PHP_EOL, $attachment_data);
        }
        $title =  rem_get_option('single_property_attachments_text', __( 'Attachments', 'real-estate-manager' ));
        if (isset($attachments)) { ?>
            <div class="section-title line-style line-style">
                <h3 class="title"><?php echo $title; ?></h3>
            </div>
            <div class="details">
                <div class="row">
                    <?php foreach ($attachments as $a_id) {
                        if ($a_id != '') {
                            $a_id = intval($a_id);
                            $filename_only = basename( get_attached_file( $a_id ) );
                            $fullsize_path = get_attached_file( $a_id );
                            $attachment_title = get_the_title($a_id);
                            $display_title = ($attachment_title != '') ? $attachment_title : $filename_only ;                        
                            $file_url = wp_get_attachment_url( $a_id );
                            $file_type = wp_check_filetype_and_ext($fullsize_path, $filename_only);
                            $extension = ($file_type['ext']) ? $file_type['ext'] : 'file' ; ?>
                            <div class="col-sm-3 rem-attachment-icon">
                                <span class="file-type-icon pull-left <?php echo $extension; ?>" filetype="<?php echo $extension; ?>">
                                    <span class="fileCorner"></span>
                                </span>
                                <a target="_blank" href="<?php echo $file_url; ?>"><?php echo substr($display_title, 0, 15); ?></a>                            
                            </div>
                    <?php
                        }
                    } ?>
                </div>        
            </div>
        <?php }        
    }    

    function single_property_video($property_id){
        $title = rem_get_option('single_property_video_text', __( 'Video', 'real-estate-manager' ));
        $property_video = get_post_meta($property_id, 'rem_property_video', true);
        if ($property_video != '') { ?>
            <div class="section-title line-style line-style">
                <h3 class="title"><?php echo $title; ?></h3>
            </div>
            <div class="details">
                <div class="row">
                    <div class="col-sm-12 video-wrap">
                        <?php echo apply_filters( 'the_content', $property_video ); ?>
                    </div>
                </div>
            </div>
        <?php }
    }

    function single_property_tags($property_id){
        $terms = wp_get_post_terms( $property_id ,'rem_property_tag' );
        if (!empty($terms)) {
            $title = rem_get_option('single_property_tags_text', __( 'Tags', 'real-estate-manager' ));
            ?>
            <div class="section-title line-style">
                <h3 class="title"><?php echo $title; ?></h3>
            </div>
            <?php
                 
            echo '<div id="filter-box">';
                 
                foreach ( $terms as $term ) {
                 
                    // The $term is an object, so we don't need to specify the $taxonomy.
                    $term_link = get_term_link( $term );
                    
                    // If there was an error, continue to the next term.
                    if ( is_wp_error( $term_link ) ) {
                        continue;
                    }
                 
                    // We successfully got a link. Print it out.
                    echo '<a class="filter" href="' . esc_url( $term_link ) . '">' . $term->name . ' <span class="glyphicon glyphicon-tags"></span></a>';
                }
                 
            echo '</div>';
        }
    }



    function single_property_details($property_id){
        $title = rem_get_option('single_property_details_text', __( 'Details', 'real-estate-manager' ) );

        global $rem_ob;
        $builtin_fields = $rem_ob->single_property_fields_builtin();

        $all_fields = $rem_ob->single_property_fields();
        $all_fields = array_merge($builtin_fields, $all_fields);
        ?>
        <div class="section-title line-style line-style">
            <h3 class="title"><?php echo $title; ?></h3>
        </div>
        <div class="details">
            <div class="row">

                <?php foreach ($all_fields as $field) {
                    $label = $field['title'];
                    $key = $field['key'];
                    $value = get_post_meta($property_id, 'rem_'.$key, true);
                    if ($value != '' && $key != 'property_sale_price') { ?>
                        <div class="col-sm-4 col-xs-6">
                            <div class="details no-padding">
                              <div class="detail" style="padding: 6px 15px;">
                                <?php
                                    $val_to_show = '';
                                    $val_to_show = ('property_price' == $key) ? rem_display_property_price($property_id) : $val_to_show ;
                                    $val_to_show = ('property_area' == $key) ? $value.' '. rem_get_option('properties_area_unit', 'Sq Ft') : $val_to_show ;
                                    if ($val_to_show == '') {
                                        $val_to_show = $value;
                                    }
                                ?>
                                <strong><?php echo stripcslashes($label); ?></strong> : <?php echo stripcslashes($val_to_show); ?>
                              </div>
                            </div>
                        </div>
                    <?php }
                } ?>
            </div>
        </div>

        <?php
    }

    function contact_social_icons($agent_id){
        global $rem_ob;
        $agent_fields = $rem_ob->get_agent_fields();
        $count = 0;
        foreach ($agent_fields as $field) {
            if (isset($field['display']) && in_array('card', $field['display']) && get_user_meta( $agent_id, $field['key'] , true ) != '') {
              $count++;
            }
        }
        echo '<ul class="contact">';
        
            foreach ($agent_fields as $field) {
                if (isset($field['display']) && in_array('card', $field['display']) && get_user_meta( $agent_id, $field['key'] , true ) != '') {
                    $url = get_user_meta( $agent_id, $field['key'] , true );
                    $target = '_blank';

                    if($field['key'] == 'rem_mobile_url'){
                        $target = '';
                    }

                    if($field['key'] == 'rem_agent_url'){
                        $url = ($url != '') ? $url : get_author_posts_url( $agent_id ) ;
                        $target = '';
                    }
                    if ($url != '' && $url != 'disable') { ?>
                        <li style="width: <?php echo 100/$count; ?>%;">
                            <a class="icon" href="<?php echo $url; ?>" target="<?php echo $target; ?>">
                                <i class="<?php echo $field['icon_class']; ?>"></i>
                            </a>
                        </li>
                    <?php
                    } 
                }
            } ?>
        <?php
        echo '</ul>';
    }

    function display_agent_custom_data($agent_id){
        global $rem_ob;
        $agent_fields = $rem_ob->get_agent_fields();

        echo '<table class="table table-bordered">';
        foreach ($agent_fields as $field) {
            if (isset($field['display']) && in_array('content', $field['display']) && get_user_meta( $agent_id, $field['key'] , true ) != '') { ?>
                <tr>
                    <th><?php echo $field['title']; ?></th>
                    <td><?php echo get_user_meta( $agent_id, $field['key'] , true ); ?></td>
                </tr>
            <?php }
        }
        echo '</table>';
    }

    function render_rem_pagination($paged = '', $max_page = ''){
        global $wp_query;
        wp_enqueue_script( 'rem-pagination', REM_URL . '/assets/front/js/pagination.js' , array('jquery'));
        $big = 999999999; // need an unlikely integer
        if( ! $paged )
            $paged = get_query_var('paged');
        if( ! $max_page )
            $max_page = $wp_query->max_num_pages;
        echo '<div class="text-center">';
        $search_for   = array( $big, '#038;' );
        $replace_with = array( '%#%', '&' );          
        echo paginate_links( array(
            'base'       => str_replace($search_for, $replace_with, esc_url(get_pagenum_link( $big ))),
            'format'     => '?paged=%#%',
            'current'    => max( 1, $paged ),
            'total'      => $max_page,
            'mid_size'   => 1,
            'prev_text'  => __('«', 'real-estate-manager'),
            'next_text'  => __('»', 'real-estate-manager'),
            'type'       => 'list'
        ) );
        echo '</div>';
    }

    function custom_archive_title($title){
        if( is_tax('rem_property_tag') ) {
            $title = (rem_get_option('archive_title') != '') ? str_replace('%tag%', single_cat_title( '', false ), rem_get_option('archive_title')) : __( 'Tag:', 'real-estate-manager' ).single_cat_title( '', false ) ;
        }
        return $title;        
    }

    function archive_page_properties_count($query){
        if ( is_admin() || ! $query->is_main_query() ) {
            return;
        }
        $number_of_properties = rem_get_option('properties_per_page', 10);
        if(is_archive( 'rem_property_tag')){
            $query->set( 'posts_per_page', $number_of_properties );
        }
    }

    function rem_action_btns($links, $file){
        if ( strpos( $file, 'rem.php' ) !== false ) {
            $settings_url = admin_url( 'edit.php?post_type=rem_property&page=rem_settings' );
            $new_links = array(
                    'rem_settings' => '<a href="'.$settings_url.'">'.__( 'Settings', 'real-estate-manager' ).'</a>',
                    'rem_custom'       => '<a href="https://webcodingplace.com/contact-us/" target="_blank">'.__( 'Request for Customize', 'real-estate-manager' ).'</a>'
                    );
            
            $links = array_merge( $links, $new_links );
        }
        
        return $links;
    }

    function rem_property_column_head($defaults){
        $new_fields = array(
            'wcp_pid' => __( 'Property ID', 'real-estate-manager' ),
            'wcp_pthumb' => __( 'Featured Image', 'real-estate-manager' ),
        );

        return $new_fields+$defaults;
    }

    function rem_property_column_content($column_name, $p_id){
        if ($column_name == 'wcp_pid') {
            echo $p_id;
        }
        if ($column_name == 'wcp_pthumb') {
            echo get_the_post_thumbnail( $p_id, array(50,50) );
        }
    }    
}
?>