<?php

/**
 * Accepts arguments as wrap_before, wrap_after, delimiter, before, after, home
 * all of these are self explanatory
 * so no need to describe theme.
 */
$args = array(
    'delimiter'   => '>',
    'wrap_before' => '<div id="wrap-class">',
    'wrap_after'  => '</div>',
    'before'      => '<span class="breadcrumb-title">' . __( 'This is where you are:', 'woothemes' ) . '</span>',
    'home'        => 'Home Page',
);

global $product;

// $id = $loop->post->ID;
// $image = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'single-post-thumbnail' ); 
?> 
<!-- <div class="woo-breadcrumb" style="background-image: url( <?php echo $image[0]; ?> ) "> -->
<?php 
woocommerce_breadcrumb( $args );
echo '</div>';
