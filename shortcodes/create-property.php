<?php
$drag_icon = apply_filters( 'rem_maps_drag_icon', REM_URL.'/assets/images/pin-drag.png' );
$maps_api = apply_filters( 'rem_maps_api', 'AIzaSyBbpbij9IIXGftKhFLMHOuTpAbFoTU_8ZQ' );
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
								<input id="title" class="form-control" type="text" required placeholder="<?php _e( 'Property Title', 'real-estate-manager' ); ?>" name="title">
							</div>
							<div class="col-md-7 space-form">
								<input id="address" class="form-control" type="text" placeholder="<?php _e( 'Address', 'real-estate-manager' ); ?>" name="address">
							</div>
							<div class="col-md-12">
								<?php wp_editor( __( 'Property Description', 'real-estate-manager' ), 'rem-content', array('textarea_name' => 'content', 'editor_height' => 350 ) ); ?>
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
								<input class="form-control" type="text" placeholder="<?php _e( 'Price in', 'real-estate-manager' ); ?> <?php echo $price_symbol; ?>" name="price">
							</div>
							<div class="col-md-4 space-form">
								<input class="form-control" type="text" placeholder="<?php _e( 'Property Country', 'real-estate-manager' ); ?>" name="country">
							</div>
							<div class="col-md-4 space-form">
								<input  class="form-control" type="text" placeholder="<?php _e( 'Property City', 'real-estate-manager' ); ?>" name="city">
							</div>
							<div class="col-md-4 space-form">
								<select class="dropdown" data-settings='{"cutOff": 5}' name="purpose">
									<option value="">-- <?php _e( 'Any Purpose', 'real-estate-manager' ); ?> --</option>
									<?php
										foreach ($property_purposes as $val => $title) {
											echo '<option value="'.$val.'">'.$title.'</option>';
										}
									?>
								</select>
							</div>
							<div class="col-md-4 space-form">
								<select class="dropdown" data-settings='{"cutOff": 5}' name="type">
									<option value="">-- <?php _e( 'Any Type', 'real-estate-manager' ); ?> --</option>
									<?php
										foreach ($property_types as $val => $title) {
											echo '<option value="'.$val.'">'.$title.'</option>';
										}
									?>                     
								</select>
							</div>
							<div class="col-md-4 space-form">
								<select class="dropdown" name="status" data-settings='{"cutOff": 5}'>
									<option value="">-- <?php _e( 'Any Status', 'real-estate-manager' ); ?> --</option>
									<?php
										foreach ($property_status as $val => $title) {
											echo '<option value="'.$val.'">'.$title.'</option>';
										}
									?>
								</select>
							</div>
							<div class="col-md-4 space-form">
								<input class="form-control" type="number" name="bathrooms" placeholder="<?php _e( 'Bathrooms', 'real-estate-manager' ); ?>" id="bathroom" data-text="Bathroom" />
							</div>
							<div class="col-md-4 space-form">
								<input class="form-control" type="number" name="bedrooms" placeholder="<?php _e( 'Bedrooms', 'real-estate-manager' ); ?>" id="bedroom" data-text="Bedroom" />
							</div>
							<div class="col-md-4 space-form">
								<?php $area_unit = rem_get_option('properties_area_unit', 'Square Foot'); ?>
								<input class="form-control" type="number" name="area" placeholder="<?php _e( 'Property Area - ', 'real-estate-manager' ); echo $area_unit; ?>" id="property-size" data-text="Size Property"/>
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
						<div class="thumbs-prev">

						</div>
						<div style="clear: both; display: block;"></div>						
					</div>




					<br>
					<input class="btn btn-default btn-lg" type="submit" value="<?php _e( 'Post Ad', 'real-estate-manager' ); ?>">
					<br>
					<br>
					<div class="alert with-icon alert-info creating-prop" style="display:none;" role="alert">
						<i class="icon fa fa-info"></i>
						<span class="msg"><?php _e( 'Please wait! your porperty is being created...', 'real-estate-manager' ); ?></span>
					</div>
				</div>
			</div>
	</form>
</section>
</div>