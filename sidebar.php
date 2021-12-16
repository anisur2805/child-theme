<?php
    /**
     * The sidebar containing the main widget area.
     *
     * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
     *
     * @package child-theme
     * @since 1.0.0
     */

if( is_shop() && !is_active_sidebar('shop-sidebar')) {
	return;
} else if( !is_shop() && !is_active_sidebar('blog-sidebar')) {
	return;
}

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>

	<div class="sidebar-main">
		<?php
          if( is_shop() ) {
						echo '<div class="title-bg"><img src="https://www.radiustheme.com/demo/wordpress/themes/metro/wp-content/themes/metro/assets/img/menubar.png" /><h3 class="ml-10">Categories</h3></div>';
			  dynamic_sidebar('shop-sidebar');
		  } else {
			  dynamic_sidebar( 'blog-sidebar' );
		  }
        ?>
	</div><!-- .sidebar-main -->
