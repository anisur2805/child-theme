<?php
    /**
     * The sidebar containing the main widget area.
     *
     * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
     *
     * @package child-theme
     * @since 1.0.0
     */

    if ( !defined( 'ABSPATH' ) ) {
        exit; // Exit if accessed directly.
}?>

	<div class="sidebar-main"> 
		<?php
			if ( is_active_sidebar( 'shop_sidebar' ) ):
				dynamic_sidebar( 'shop_sidebar' );
			endif; 
		?>
	</div><!-- .sidebar-main --> 
