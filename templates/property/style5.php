<div class="box-property-slide">
    <?php if (get_post_meta( $property_id, 'rem_property_sale_price', true ) != '') { ?>
        <div class="rem-sale rem-sale-top-left"><span>
            <?php echo rem_get_option('property_sale_ribbon_text', 'Sale'); ?>
        </span></div>
    <?php } ?>
	<a target="<?php echo $target; ?>" href="<?php echo get_permalink($property_id); ?>" class="hover-effect right-block image-fill">
		<?php do_action( 'rem_property_picture', $property_id ); ?>
		<span class="cover"></span>
		<span class="cover-title"><?php echo get_the_title($property_id); ?></span>
	</a>
	<div class="left-block">
		<span class="title"><?php echo $address; ?></span>
		<span class="description"><?php echo wp_trim_words( get_the_excerpt( $property_id ), rem_get_option('properties_excerpt_length', 15)); ?></span>

		<?php do_action( 'rem_property_details_icons', $property_id ); ?>

		<span class="price"><?php echo rem_display_property_price($property_id); ?></span>
		<a target="<?php echo $target; ?>" href="<?php echo get_permalink($property_id); ?>" class="btn btn-reverse button">
		<i class="fa fa-search"></i> <?php _e( 'Details', 'real-estate-manager' ); ?></a>
	</div>
</div><!-- /.box-property-slide -->