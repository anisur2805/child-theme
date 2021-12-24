<?php

get_header();

// get_template_part( 'template-parts/header/entry-header' );
?>
    <div class="woo-wrapper">
        <div class="col-md-8">
            <?php woocommerce_content(); ?>
    </div>

    <?php 
    if ( is_active_sidebar( 'shop-sidebar ' ) ) {
        echo '<div class="col-md-4">';
        get_sidebar( 'shop-sidebar' );
        echo '</div>';
    }

echo '</div>';

get_footer();
