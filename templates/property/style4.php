<div class="landz-box-property box-grid mini">
    <?php if (get_post_meta( $property_id, 'rem_property_sale_price', true ) != '') { ?>
        <div class="rem-sale rem-sale-top-left"><span>
            <?php echo rem_get_option('property_sale_ribbon_text', 'Sale'); ?>
        </span></div>
    <?php } ?>
	<a target="<?php echo $target; ?>" class="hover-effect image image-fill" href="<?php echo get_permalink($property_id); ?>">
		<span class="cover"></span>
		<?php do_action( 'rem_property_picture', $property_id ); ?>
		<h3 class="title"><?php echo get_the_title($property_id); ?></h3>
	</a>
	<span class="price"><?php echo rem_display_property_sale_price($property_id); ?></span>
	<div class="footer">
		<a target="<?php echo $target; ?>" class="btn btn-default" href="<?php echo get_permalink($property_id); ?>"><?php _e( 'Details', 'real-estate-manager' ); ?></a>
	</div>	
</div>