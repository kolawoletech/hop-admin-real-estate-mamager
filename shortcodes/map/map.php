<?php
if ( $the_query->have_posts() ) {
	while ( $the_query->have_posts() ) {
		$the_query->the_post();

		$author_id = get_the_author_meta('ID');
		$author_info = get_userdata($author_id);
		$property_price = get_post_meta(get_the_id(), 'rem_property_price', true);
		$status = get_post_meta(get_the_id(), 'rem_property_status', true);
		$area = get_post_meta(get_the_id(), 'rem_property_area', true);
		$bathrooms = get_post_meta( get_the_id(), 'rem_property_bathrooms', true );
		$address = get_post_meta(get_the_id(), 'rem_property_address', true);
		$bedrooms = get_post_meta( get_the_id(), 'rem_property_bedrooms', true );
		$type = get_post_meta(get_the_id(), 'rem_property_type', true);
		$latitude = get_post_meta(get_the_id(), 'rem_property_latitude', true);
		$longitude = get_post_meta(get_the_id(), 'rem_property_longitude', true);

		$property_data = array(
			'id' 			=> get_the_id(),
			'title' 		=> get_the_title(),
			'description' 	=> get_the_excerpt(),
			'info' 			=> array(
				'price' 		=> rem_get_property_price($property_price),
				'bathRoom' 		=> $bathrooms,
				'bedRoom' 		=> $bedrooms,
				'perimeter' 	=> $area.' '. rem_get_option('properties_area_unit', 'Sq Ft'),
				'room' 			=> $type,
			),
			'img' 			=>  get_the_post_thumbnail_url(get_the_id(), 'full'),
			'propertyType' 	=>  $type,
			'url' 			=>  get_permalink(),
			'lat' 			=>  $latitude,
			'lon' 			=>  $longitude,
		);

		$all_properties[] = $property_data;

	}
	wp_reset_postdata();
}

rem_load_bs_and_fa();
rem_load_basic_styles();
wp_enqueue_style( 'rem-maps-css', REM_URL . '/assets/front/css/maps.css' );
$maps_api = apply_filters( 'rem_maps_api', 'AIzaSyBbpbij9IIXGftKhFLMHOuTpAbFoTU_8ZQ' );
if (is_ssl()) {
    wp_enqueue_script( 'rem-gmap-api-js', 'https://maps.google.com/maps/api/js?key='.$maps_api);
} else {
    wp_enqueue_script( 'rem-gmap-api-js', 'http://maps.google.com/maps/api/js?key='.$maps_api);
}
wp_enqueue_script( 'rem-infobox', REM_URL . '/assets/front/lib/infobox.js', array('jquery'));
wp_enqueue_script( 'rem-home-maps', REM_URL . '/assets/front/lib/home-maps.js', array('jquery'));
wp_enqueue_script( 'rem-markerclusterer', REM_URL . '/assets/front/lib/markerclusterer.js', array('jquery'));

$mapsData = array(
	'theme_path' => REM_URL.'/assets/',
	'properties' => $all_properties,
	'water_color' => $water_color,
	'fill_color' => $fill_color,
	'poi_color' => $poi_color,
	'poi_color_hue' => $poi_color_hue,
	'roads_lightness' => $roads_lightness,
	'lines_lightness' => $lines_lightness,
);
wp_localize_script( 'rem-home-maps', 'mapsData', $mapsData );
wp_localize_script( 'rem-markerclusterer', 'mapsData', $mapsData );
 
?>
<style>
	#maps {
		height: <?php echo $map_height; ?> !important;
	}
	#maps .find-result, #maps .find-result:after {
		background-color: <?php echo $btn_bg_color; ?> !important;
		color: <?php echo $btn_text_color; ?> !important;
	}
	#maps .control-left-wrapper div:after, #maps .control-right-wrapper div:after {
		background-color: <?php echo $btn_bg_color; ?>;
		border: none;
		color: <?php echo $btn_text_color; ?>;
		border-radius: 0;
		padding-top: 10px;
		font-size: 20px;
	}
	#maps .find-result, #maps .find-result:after, .ads-type a.item-type {
		background-color: <?php echo $btn_bg_color; ?>;
		color: <?php echo $btn_text_color; ?>;
	}
	#maps .control-left-wrapper div:hover:after,
	#maps .control-right-wrapper div:hover:after,
	.ads-type a.item-type.item-selected,
	.ads-type a.item-type:hover {
		background-color: <?php echo $btn_bg_color_hover; ?>;
		color: <?php echo $btn_text_color_hover; ?>;
	}
	.ads-type {
		background-color: <?php echo $type_bar_bg_color; ?>;
	}
	#maps .loading-container .spinner {
		background-color: <?php echo $loader_color; ?> !important;
	}
	.type-filtering .btn {
		background-color: <?php echo $bottom_btn_bg_color; ?> !important;
		color: <?php echo $bottom_btn_text_color; ?> !important;
	}
	.type-filtering .btn:hover {
		background-color: <?php echo $bottom_btn_bg_color_hover; ?> !important;
		color: <?php echo $bottom_btn_text_color_hover; ?> !important;
	}
	.type-filtering .btn.active {
		background-color: <?php echo $bottom_btn_bg_color_active; ?> !important;
	}
</style>
<div class="ich-settings-main-wrap">
	<section id="maps">
		<div class="loading-container">
			<div class="spinner"></div>
			<div class="text">
				<span><?php echo $load_heading; ?></span>
				<?php echo $load_desc; ?>
			</div>
		</div>
		<div class="find-result"></div>
		<div class="map map-home" id="map-canvas"></div>
	</section>
	<?php if ($type_filtering == 'enable') { 
		global $rem_ob;
		$all_types = $rem_ob->get_all_property_types();
	?>
	<div class="type-filtering">
		<div class="btn-group btn-group-justified" role="group">
			<?php foreach ($all_types as $p_type) { ?>
			<div class="btn-group" role="group">
				<button type="button" class="item-type btn btn-default" data-type="<?php echo $p_type; ?>"><?php echo $p_type; ?></button>
			</div>
			<?php } ?>
		</div>	
	</div>
	<?php } ?>
</div>