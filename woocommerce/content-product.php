<?php
	/**
	 * The template for displaying product content within loops
	 *
	 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
	 *
	 * HOWEVER, on occasion WooCommerce will need to update template files and you
	 * (the theme developer) will need to copy the new files to your theme to
	 * maintain compatibility. We try to do this as little as possible, but it does
	 * happen. When this occurs the version of the template file will be bumped and
	 * the readme will list any important changes.
	 *
	 * @see     https://docs.woocommerce.com/document/template-structure/
	 * @package WooCommerce\Templates
	 * @version 3.6.0
	 */

	defined( 'ABSPATH' ) || exit;

	global $product;

	// Ensure visibility.
	if ( empty( $product ) || !$product->is_visible() ) {
		return;
	}
?>
<li <?php wc_product_class( '', $product );?>>
	<?php
		/**
		 * Hook: woocommerce_before_shop_loop_item.
		 *
		 * @hooked woocommerce_template_loop_product_link_open - 10
		 */
		// do_action( 'woocommerce_before_shop_loop_item' );

		/**
		 * Hook: woocommerce_before_shop_loop_item_title.
		 *
		 * @hooked woocommerce_show_product_loop_sale_flash - 10
		 * @hooked woocommerce_template_loop_product_thumbnail - 10
		 */
		// do_action( 'woocommerce_before_shop_loop_item_title' );

		/**
		 * Hook: woocommerce_shop_loop_item_title.
		 *
		 * @hooked woocommerce_template_loop_product_title - 10
		 */
		// do_action( 'woocommerce_shop_loop_item_title' );

		/**
		 * Hook: woocommerce_after_shop_loop_item_title.
		 *
		 * @hooked woocommerce_template_loop_rating - 5
		 * @hooked woocommerce_template_loop_price - 10
		 */
		// do_action( 'woocommerce_after_shop_loop_item_title' );

		/**
		 * Hook: woocommerce_after_shop_loop_item.
		 *
		 * @hooked woocommerce_template_loop_product_link_close - 5
		 * @hooked woocommerce_template_loop_add_to_cart - 10
		 */
		// do_action( 'woocommerce_after_shop_loop_item' );
	?>

	<div class="product_bg" style="background-image: url(<?php echo get_the_post_thumbnail_url( get_the_ID(), 'medium' ); ?>);">
			
			<div class="products-button">
			
			<a href="<?php echo site_url()?>/shop/?add-to-cart=<?php echo get_the_ID(  ); ?>" data-quantity="1" class="overlay_btn button add_to_cart_button ajax_add_to_cart" data-product_id="<?php echo  get_the_ID(); ?>" rel="nofollow"><i class="fa fa-cart-plus"></i></a>
			
				<?php echo do_shortcode('[yith_wcwl_add_to_wishlist]');?>
					<!-- <a href="<?php echo site_url(); ?>/?add_to_wishlist=<?php echo get_the_ID(); ?>" class="add_to_wishlist single_add_to_wishlist" data-product-id="<?php echo get_the_ID(); ?>" data-product-type="variable" data-original-product-id="<?php echo get_the_ID(); ?>" data-title="Add to wishlist" rel="nofollow">
						<i class="yith-wcwl-icon fa fa-heart-o"></i>		<span>Add to wishlist</span>
					</a> -->
					
					<a href="<?php echo site_url(); ?>/?action=yith-woocompare-add-product&id=<?php echo get_the_ID(); ?>" class="compare overlay_btn" data-product_id="<?php echo get_the_ID(); ?>" rel="nofollow"><i class="fa fa-plus"></i></a>
					
				</div>

								<?php 
								
								// woocommerce_template_loop_add_to_cart();
									woocommerce_template_loop_rating();
								
								?>
					</div>
					
					<?php 	do_action( 'woocommerce_shop_loop_item_title' );
									woocommerce_template_loop_price();
									?>


</li>

