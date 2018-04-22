<div class="propery-style-6">
    <?php if (get_post_meta( $property_id, 'rem_property_sale_price', true ) != '') { ?>
        <div class="rem-sale rem-sale-top-left"><span>
            <?php echo rem_get_option('property_sale_ribbon_text', 'Sale'); ?>
        </span></div>
    <?php } ?>
    <div class="post-img image image-fill">
        <?php do_action( 'rem_property_picture', $property_id ); ?>
        <div class="category">
            <span class="price">
                <?php echo rem_display_property_price($property_id); ?>
            </span>
            <span><?php echo $city; ?></span>
        </div>
        <div class="category-1"><?php echo $purpose; ?></div>
        <div class="property-type"><?php echo $property_type; ?></div>
    </div>
    <div class="post-review">
        <h3 class="post-title">
            <a target="<?php echo $target; ?>" href="<?php the_permalink(); ?>">
                <?php echo get_the_title($property_id); ?>
            </a>
        </h3>
        <span class="location"><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo $address; ?></span>
        <p class="post-description">
            <?php echo wp_trim_words( get_the_excerpt( $property_id ), rem_get_option('properties_excerpt_length', 15)); ?>
        </p>
        <hr>
        <div class="post-bar">
            <?php if ($bathrooms != '') { ?>
                <span><i class="fa fa-bath"></i> <?php echo $bathrooms; ?></span> |
            <?php } ?>
            <?php if ($bedrooms != '') { ?>
                <span class="comments"><i class="fa fa-bed"></i> <?php echo $bedrooms; ?></span> |
            <?php } ?>
            <?php if ($area != '') { ?>
                <span class="comments"><i class="fa fa-arrows-alt"></i> <?php echo $area.' '. rem_get_option('properties_area_unit', 'Sq Ft'); ?></span>
            <?php } ?>
            <a target="<?php echo $target; ?>" href="<?php the_permalink(); ?>" class="btn btn-default btn-xs pull-right"><?php _e( 'Detail', 'real-estate-manager' ); ?></a>
        </div>
    </div>
</div>