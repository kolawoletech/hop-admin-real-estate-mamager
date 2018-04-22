<?php if(isset($_GET['search_property'])){ ?>
	<div class="ich-settings-main-wrap">
    <div class="row">
		<?php
        $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1; 
			extract($_REQUEST);

		$args = array(
            'post_type'   => 'rem_property',
            'paged'       => $paged,
            'post_status' => 'publish',
        );
        global $rem_ob;
        $default_fields = $rem_ob->single_property_fields_builtin();
        $custom_fields = $rem_ob->single_property_fields();   
        $default_fields = array_merge($default_fields, $custom_fields);       

		if (isset($search_property) && $search_property != '') {
			$args['s'] = $search_property;
		}

        foreach ($default_fields as $field) {
  			if (isset($_REQUEST[$field['key']]) && $_REQUEST[$field['key']] != '') {

                if (preg_match('/^\d{1,}\+/', $_REQUEST[$field['key']])) {
                    $numb = intval($_REQUEST[$field['key']]);
                    $args['meta_query'][] = array(
                        array(
                            'key'     => 'rem_'.$field['key'],
                            'value'   => $numb,
                            'type'    => 'numeric',
                            'compare' => '>=',
                        ),
                    );
                } else if (preg_match('/^\d{1,}-\d{1,}$/', $_REQUEST[$field['key']])) {
                    $area_arr = explode('-', $_REQUEST[$field['key']]);
                    $args['meta_query'][] = array(
                        array(
                            'key'     => 'rem_'.$field['key'],
                            'value'   => array( $area_arr[0], $area_arr[1] ),
                            'type'    => 'numeric',
                            'compare' => 'BETWEEN',
                        ),
                    );
                } else {
                    $args['meta_query'][] = array(
                         array(
                             'key'     => 'rem_'.$field['key'],
                             'value'   => stripcslashes($_REQUEST[$field['key']]),
                             'compare' => 'LIKE',
                         ),
                    );
                }
  			}
        }

    if (isset($price_min) && $price_min != '') {
        $t_sep = rem_get_option('thousand_separator', '');
        $d_points = rem_get_option('decimal_points', '');
        $d_sep = rem_get_option('decimal_separator', '');
        if ($t_sep != '') {
            $price_min = str_replace($t_sep, '', $price_min);
            $price_max = str_replace($t_sep, '', $price_max);
        }
    
        if ($d_points != '' && $d_points != '0' && $d_sep != '') {
            $price_min = explode($d_sep, $price_min );
            $price_min = $price_min[0];
            $price_max = explode($d_sep, $price_max );
            $price_max = $price_max[0];
        }
        $args['meta_query'][] = array(
            array(
                'key'     => 'rem_property_price',
                'value'   => array( intval($price_min), intval($price_max) ),
                'type'    => 'numeric',
                'compare' => 'BETWEEN',
            ),
        );
    }
		$property_query = new WP_Query( $args );
        $layout_style = rem_get_option('search_results_style', '1');
        $layout_cols = rem_get_option('search_results_cols', 'col-sm-12');  
        $target = rem_get_option('searched_properties_target', '');    
			if( $property_query->have_posts() ){
        while( $property_query->have_posts() ){ $property_query->the_post(); 
		 		?>
            <div id="property-<?php echo get_the_id(); ?>" class="<?php echo $layout_cols; ?>">
                <?php do_action('rem_property_box', get_the_id(), $layout_style, $target); ?>
            </div>
        <?php

		 	}
			wp_reset_postdata();
      echo '<div class="clearfix"></div>';
      do_action( 'rem_pagination', $paged, $property_query->max_num_pages );
	} else { ?>
  <div class="clearfix"></div>
    <div class="col-md-12">
        <div class="alert with-icon alert-info" role="alert">
            <p style="margin-top: 12px;margin-left: 10px;">
            <i class="icon fa fa-info"></i> <?php _e( 'Sorry! No Properties Found. Try Searching Again.', 'real-estate-manager' ); ?></p>
        </div>
    </div>
	<?php } ?>
  </div>
	</div>
<?php } ?>