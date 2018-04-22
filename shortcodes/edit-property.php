<?php
$drag_icon = apply_filters( 'rem_maps_drag_icon', REM_URL.'/assets/images/pin-drag.png' );
$maps_api = apply_filters( 'rem_maps_api', 'AIzaSyBbpbij9IIXGftKhFLMHOuTpAbFoTU_8ZQ' );
$property_data = get_post( $_GET['property_id'] );
$p_address = get_post_meta( $_GET['property_id'], 'rem_property_address', true );
$p_price = get_post_meta( $_GET['property_id'], 'rem_property_price', true );
$p_country = get_post_meta( $_GET['property_id'], 'rem_property_country', true );
$p_city = get_post_meta( $_GET['property_id'], 'rem_property_city', true );
$p_purpose = get_post_meta( $_GET['property_id'], 'rem_property_purpose', true );
$p_type = get_post_meta( $_GET['property_id'], 'rem_property_type', true );
$p_status = get_post_meta( $_GET['property_id'], 'rem_property_status', true );
$p_bathrooms = get_post_meta( $_GET['property_id'], 'rem_property_bathrooms', true );
$p_bedrooms = get_post_meta( $_GET['property_id'], 'rem_property_bedrooms', true );
$p_area = get_post_meta( $_GET['property_id'], 'rem_property_area', true );
$p_cbs = get_post_meta( $_GET['property_id'], 'rem_property_detail_cbs', true );
$p_tags = wp_get_post_terms( $_GET['property_id'] ,'rem_property_tag' );
// var_dump();
?>
<div class="ich-settings-main-wrap">
<section id="new-property">
	<form id="create-property" data-ajaxurl="<?php echo admin_url( 'admin-ajax.php' ); ?>">
		<input type="hidden" name="action" value="rem_create_pro_ajax">
		<input type="hidden" name="latitude" value="" class="map-latitude">
		<input type="hidden" name="longitude" value="" class="map-longitude">
			<div class="row">
				<div class="col-sm-12 col-md-12">
					<div class="info-block" id="basic">
						<div class="section-title line-style no-margin">
							<h3 class="title"><?php _e( 'Basic Information', 'real-estate-manager' ); ?></h3>
						</div>
						<div class="row">
							<div class="col-md-5 space-form">
								<input value="<?php echo $property_data->post_title; ?>" id="title" class="form-control" type="text" required placeholder="<?php _e( 'Property Title', 'real-estate-manager' ); ?>" name="title">
							</div>
							<div class="col-md-7 space-form">
								<input value="<?php echo $p_address; ?>" id="address" class="form-control" type="text" placeholder="<?php _e( 'Address', 'real-estate-manager' ); ?>" name="address">
							</div>
							<div class="col-md-12">
								<?php wp_editor( $property_data->post_content, 'rem-content', array('textarea_name' => 'content', 'editor_height' => 350 ) ); ?>
								<div class="clearfix"></div>
							</div>
						</div>
					</div>
					<div class="info-block" id="summary">
						<div class="section-title line-style">
							<h3 class="title"><?php _e( 'Summary', 'real-estate-manager' ); ?></h3>
						</div>

						<div class="row">
							<div class="col-md-4 space-form">
								<input class="form-control" value="<?php echo $p_price; ?>" type="text" placeholder="<?php _e( 'Price in', 'real-estate-manager' ); ?> <?php echo $price_symbol; ?>" name="price">
							</div>
							<div class="col-md-4 space-form">
								<input class="form-control" value="<?php echo $p_country; ?>" type="text" placeholder="<?php _e( 'Property Country', 'real-estate-manager' ); ?>" name="country">
							</div>
							<div class="col-md-4 space-form">
								<input  class="form-control" value="<?php echo $p_city; ?>" type="text" placeholder="<?php _e( 'Property City', 'real-estate-manager' ); ?>" name="city">
							</div>
							<div class="col-md-4 space-form">
								<select class="dropdown" data-settings='{"cutOff": 5}' name="purpose">
									<option value="">-- <?php _e( 'Any Purpose', 'real-estate-manager' ); ?> --</option>
									<?php
										foreach ($property_purposes as $val => $title) {
											echo '<option value="'.$val.'" '.selected( $p_purpose, $val, true ).'>'.$title.'</option>';
										}
									?>
								</select>
							</div>
							<div class="col-md-4 space-form">
								<select class="dropdown" data-settings='{"cutOff": 5}' name="type">
									<option value="">-- <?php _e( 'Any Type', 'real-estate-manager' ); ?> --</option>
									<?php
										foreach ($property_types as $val => $title) {
											echo '<option value="'.$val.'" '.selected( $p_type, $val, true ).'>'.$title.'</option>';
										}
									?>                     
								</select>
							</div>
							<div class="col-md-4 space-form">
								<select class="dropdown" name="status" data-settings='{"cutOff": 5}'>
									<option value="">-- <?php _e( 'Any Status', 'real-estate-manager' ); ?> --</option>
									<?php
										foreach ($property_status as $val => $title) {
											echo '<option value="'.$val.'" '.selected( $p_status, $val, true ).'>'.$title.'</option>';
										}
									?>
								</select>
							</div>
							<div class="col-md-4 space-form">
								<input class="form-control" value="<?php echo $p_bathrooms; ?>" type="number" name="bathrooms" placeholder="<?php _e( 'Bathrooms', 'real-estate-manager' ); ?>" id="bathroom" data-text="Bathroom" />
							</div>
							<div class="col-md-4 space-form">
								<input class="form-control" value="<?php echo $p_bedrooms; ?>" type="number" name="bedrooms" placeholder="<?php _e( 'Bedrooms', 'real-estate-manager' ); ?>" id="bedroom" data-text="Bedroom" />
							</div>
							<div class="col-md-4 space-form">
								<?php $area_unit = rem_get_option('properties_area_unit', 'Square Foot'); ?>
								<input class="form-control" value="<?php echo $p_area; ?>" type="number" name="area" placeholder="<?php _e( 'Property Area - ', 'real-estate-manager' ); echo $area_unit; ?>" id="property-size" data-text="Size Property"/>
							</div>
						</div>
					</div>
					<div class="info-block" id="images">
						<div class="section-title line-style">
							<h3 class="title"><?php _e( 'Images', 'real-estate-manager' ); ?></h3>
						</div>
						<p style="text-align: center">
							<button class="btn btn-default upload_image_button">
								<span class="dashicons dashicons-images-alt2"></span>
								<?php _e( 'Click here to Upload Images', 'real-estate-manager' ); ?>
							</button>
						</p>
						<br>
						<br>
							<?php 
								$images_ids = get_post_meta( $_GET['property_id'], 'rem_property_images', true );
							?>
							<div class="thumbs-prev">
								<?php if ($images_ids != '') {
									foreach ($images_ids as $id) {
										$image_url = wp_get_attachment_image_src( $id, 'thumbnail' );
										// var_dump($image_url);
										// $image_url = wp_get_attachment_url( $id );
										echo '<div><input type="hidden" name="rem_property_data[property_images]['.$id.']" value="'.$id.'"><img src="'.$image_url[0].'"><span class="dashicons dashicons-dismiss"></span></div>';
									}
								} ?>
							</div>
						<div style="clear: both; display: block;"></div>						
					</div>

					<div class="info-block" id="features">
						<div class="section-title line-style">
							<h3 class="title"><?php _e( 'Features', 'real-estate-manager' ); ?></h3>
						</div>
						<div class="row features-box">
							<?php
								foreach ($property_individual_cbs as $cb) { ?>
									<div class="col-xs-6 col-sm-4 col-md-3">
										<?php $chkd = (isset($p_cbs[$cb])) ? 'checked' : '' ; ?>
										<input <?php echo $chkd; ?> class="labelauty" type="checkbox" name="detail_cbs[<?php echo $cb; ?>]" data-labelauty="<?php echo stripcslashes($cb); ?>">
									</div>
							<?php } ?>
						</div>
					</div>

					<div class="info-block" id="tags">
						<div class="section-title line-style">
							<h3 class="title"><?php _e( 'Tags', 'real-estate-manager' ); ?></h3>
						</div>
						<div class="row features-box">
							<div class="col-lg-12">
								<p><?php _e( 'Each tag separated by comma', 'real-estate-manager' ); ?>  <code>,</code></p>
								<textarea class="form-control" name="tags"><?php
									foreach ($p_tags as $tag) {
										echo $tag->name.',';
									}
								?></textarea>
							</div>
						</div>
					</div>

					<div class="info-block" id="map">
						<div class="section-title line-style">
							<h3 class="title"><?php _e( 'Place on Map', 'real-estate-manager' ); ?></h3>
						</div>
						<input type="text" class="form-control" id="search-map" placeholder="<?php _e( 'Type to Search...', 'real-estate-manager' ); ?>">
						<div id="map-canvas" style="height: 300px"></div>
							<?php if (is_ssl()) { ?>
									<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $maps_api; ?>&libraries=places"></script>
							<?php } else { ?>
									<script src="http://maps.googleapis.com/maps/api/js?key=<?php echo $maps_api; ?>&libraries=places"></script>
							<?php } ?>
							<?php
								$def_lat = rem_get_option('default_map_lat', '-33.890542'); 
								$def_long = rem_get_option('default_map_long', '151.274856');
								$zoom_level = rem_get_option('maps_zoom_level', '18');
							?>
							<script>
								function initialize() {

								    var map = new google.maps.Map(document.getElementById('map-canvas'), {
								        center: new google.maps.LatLng(<?php echo $def_lat; ?>, <?php echo $def_long; ?>),
								        scrollwheel: false,
								        zoom: <?php echo $zoom_level; ?>
								    });


								    var searchBox = new google.maps.places.SearchBox(document.getElementById('search-map'));
								    // map.controls[google.maps.ControlPosition.TOP_LEFT].push(document.getElementById('search-map'));
								    google.maps.event.addListener(searchBox, 'places_changed', function() {
								        searchBox.set('map', null);


								        var places = searchBox.getPlaces();

								        var bounds = new google.maps.LatLngBounds();
								        var i, place;
								        for (i = 0; place = places[i]; i++) {
								            (function(place) {
								                var marker = new google.maps.Marker({
								                    position: place.geometry.location,
													map: map,
													icon: '<?php echo $drag_icon; ?>',
													draggable: true								                    
								                });
												var location = place.geometry.location;
												var n_lat = location.lat();
												var n_lng = location.lng();
												jQuery('.map-latitude').val(n_lat);
												jQuery('.map-longitude').val(n_lng);
								                marker.bindTo('map', searchBox, 'map');
								                google.maps.event.addListener(marker, 'map_changed', function(event) {
								                    if (!this.getMap()) {
								                        this.unbindAll();
								                    }
								                });
												google.maps.event.addListener(marker, 'drag', function(event) {
													jQuery('.map-latitude').val(event.latLng.lat());
													jQuery('.map-longitude').val(event.latLng.lng());
													jQuery('#position').text('Position: ' + event.latLng.lat() + ' , ' + event.latLng.lng() );
												});
												google.maps.event.addListener(marker, 'dragend', function(event) {
													jQuery('.map-latitude').val(event.latLng.lat());
													jQuery('.map-longitude').val(event.latLng.lng());
													jQuery('#position').text('Position: ' + event.latLng.lat() + ' , ' + event.latLng.lng() );
												});								                
								                bounds.extend(place.geometry.location);


								            }(place));

								        }
								        map.fitBounds(bounds);
								        searchBox.set('map', map);
								        map.setZoom(Math.min(map.getZoom(), 12));

								    });
								}
								google.maps.event.addDomListener(window, 'load', initialize);
							</script>

						<div id="position"><i class="fa fa-map-marker"></i> <?php _e( 'Drag the pin to the location on the map', 'real-estate-manager' ); ?></div>
					</div>
					<br>
					<input type="hidden" name="property_id" value="<?php echo $_GET['property_id']; ?>">
					<input class="btn btn-default" type="submit" value="<?php _e( 'Save Changes', 'real-estate-manager' ); ?>">
					<br>
					<br>
					<div class="alert with-icon alert-info creating-prop" style="display:none;" role="alert">
						<i class="icon fa fa-info"></i>
						<span class="msg"><?php _e( 'Please wait! your porperty is being modified...', 'real-estate-manager' ); ?></span>
					</div>
				</div>
			</div>
	</form>
</section>
</div>