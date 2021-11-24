<?php

get_header();

// get_template_part( 'template-parts/header/entry-header' );

echo '<div class="woo-wrapper">';
echo '<div class="col-md-8">';
woocommerce_content();
echo '</div>';

if ( is_active_sidebar( 'shop-sidebar ' ) ) {
    echo '<div class="col-md-4">';
    get_sidebar( 'shop-sidebar' );
    echo '</div>';
}

echo '</div>';

get_footer();
