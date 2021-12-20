<?php

 add_action( 'wp_enqueue_scripts', 'wpct_enqueue_styles' );
 function wpct_enqueue_styles() {

  wp_enqueue_style( 'bs-style', '//cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' );
  wp_enqueue_style( 'slick-style', '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css' );

  wp_enqueue_script( 'bs-script', '//cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js' );
  wp_enqueue_script( 'slick-script', '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js' );

 }

 function my_simple_custom_product_tab( $tabs ) {

  $tabs['my_custom_tab'] = array(
   'title'    => __( 'Custom Tab', 'textdomain' ),
   'callback' => 'my_simple_custom_tab_content',
   'priority' => 50,
  );

  return $tabs;

 }

 add_filter( 'woocommerce_product_tabs', 'my_simple_custom_product_tab' );

 /**
  * Function that displays output for the shipping tab.
  */
 function my_simple_custom_tab_content( $slug, $tab ) {

 ?><h2><?php echo wp_kses_post( $tab['title'] ); ?></h2>
    <p>Tab Content</p><?php
}

    add_filter( 'woocommerce_before_add_to_cart_form', 'wpct_woocommerce_get_price_html' );
    function wpct_woocommerce_get_price_html() {
    $product = wc_get_product( get_the_ID() );

    if ( $product->is_on_sale() ) {
        $save_amount = $product->get_price('regular');
        echo '<div class="price_html">' . $product->get_price_html() . ' You save - '. $save_amount .'</div>';
    } else {
        echo '<div class="price_html">test' . $product->get_price_html() . '</div>';
    }
    }
