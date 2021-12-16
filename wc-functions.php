<?php


/**
 * This function will override woocommerce default
 * category page button text base on product type
 */
add_filter('woocommerce_loop_add_to_cart_link', 'ct_woocommerce_loop_add_to_cart_link');
function ct_woocommerce_loop_add_to_cart_link()
{
    global $product;
    if (!$product->is_in_stock()) {
        $button_text = __('Unavailable', 'woocommerce');
    } elseif ($product->is_type('simple')) {
        $button_text = __("Show product", "ct");
    } elseif ($product->is_type('variable')) {
        $button_text = __("Select product", "ct");
    } else {
        // $button_text = add_to_cart_text();
        $button_text = __('Add to Cart', 'ct');
    }
    return '<a class="view-product button" href="' . $product->get_permalink() . '">' . $button_text . '</a>';
}

/* Replace text of Sale! badge with percentage */
// add_filter( 'woocommerce_sale_flash', 'ds_replace_sale_text' );
function ds_replace_sale_text($text)
{
    global $product;
    $stock         = $product->get_stock_status();
    $product_type  = $product->get_type();
    $sale_price    = 0;
    $regular_price = 0;
    if ($product_type == 'variable') {
        $product_variations = $product->get_available_variations();
        foreach ($product_variations as $kay => $value) {
            if ($value['display_price'] < $value['display_regular_price']) {
                $sale_price    = $value['display_price'];
                $regular_price = $value['display_regular_price'];
            }
        }
        if ($regular_price > $sale_price && $stock != 'outofstock') {
            $product_sale = (int) ((((int) ($regular_price) - (int) ($sale_price)) / (int) ($regular_price)) * 100);
            if ($product_sale > 5) {
                return '<span class="onsale test"> <span class="sale-icon" aria-hidden="true" data-icon="&#xe0da"></span> ' . $product_sale . '% OFF</span>';
            }
            if ($product_sale <= 5) {
                return '<span class="onsale abc"> <span class="sale-icon" aria-hidden="true" data-icon="&#xe0da"></span>Sale!</span>';
            }
        } else {
            return '';
        }
    } else {
        $regular_price = get_post_meta(get_the_ID(), '_regular_price', true);
        $sale_price    = get_post_meta(get_the_ID(), '_sale_price', true);
        if ($regular_price > 5) {
            $product_sale = (int) ((((int) ($regular_price) - (int) ($sale_price)) / (int) ($regular_price)) * 100);
            return '<span class="onsale 1"> <span class="sale-icon" aria-hidden="true" data-icon="&#xe0da"></span> ' . $product_sale . '% OFF</span>';
        }
        if ($regular_price >= 0 && $regular_price <= 5) {
            $product_sale = (int) ((((int) ($regular_price) - (int) ($sale_price)) / (int) ($regular_price)) * 100);
            return '<span class="onsale" 2> <span class="sale-icon" aria-hidden="true" data-icon="&#xe0da"></span>Sale!</span>';
        } else {
            return '';
        }
    }
}

/**
 * remove dropdown sorting
 * @link https://i.imgur.com/esM3m6o.png
 */
// add_action( 'init', 'ct_woo_catalog_ordering' );
function ct_woo_catalog_ordering()
{
    remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30, 0);
}

/**
 * WooCommerce Page show per page dropdown
 * ####### this is not working correctly ########
 * */
// add_action( 'woocommerce_before_shop_loop', 'ct_select_box', 25, 0 );
function ct_select_box()
{
    $per_page = filter_input(INPUT_GET, 'perpage', FILTER_SANITIZE_NUMBER_INT);
    echo '<div class="woocommerce-perpage">';
    echo '<span>Show Items</span>';
    echo '<select onchange="if (this.value) window.location.href=this.value">';
    $orderby_options = array(
        '10' => '10',
        '5'  => '5',
        '20' => '20',
        '30' => '30',
        '40' => '40',
        '-1' => 'Show All',
    );
    foreach ($orderby_options as $value => $label) {
        echo "<option " . selected($per_page, $value) . " value='?perpage=$value'>$label</option>";
    }
    echo '</select>';
    echo '</div>';
}

/**
 * Add custom sorting options (asc/desc)
 * if we want to pass arguments
 */
// add_filter( 'woocommerce_get_catalog_ordering_args', 'ct_custom_woocommerce_get_catalog_ordering_args' );
// function ct_custom_woocommerce_get_catalog_ordering_args( $args ) {
//   $orderby_value = isset( $_GET['orderby'] ) ? wc_clean( $_GET['orderby'] ) : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );
//     if ( 'random_list' == $orderby_value ) {
//         $args['orderby'] = 'rand';
//         $args['order'] = '';
//         $args['meta_key'] = '';
//     }
//     return $args;
// }
// add_filter( 'woocommerce_default_catalog_orderby_options', 'ct_custom_woocommerce_catalog_orderby' );

add_filter('woocommerce_catalog_orderby', 'ct_custom_woocommerce_catalog_orderby');
function ct_custom_woocommerce_catalog_orderby($sortby)
{
    $sortby['random_list'] = 'Random';
    $sortby['date']        = 'Latest';
    $sortby['popularity']  = 'Popular';
    unset($sortby["price-desc"]);
    unset($sortby["price"]);
    unset($sortby["rating"]);
    return $sortby;
}

// Remove list/ grid view plugin default option
add_action('woocommerce_archive_description', 'ct_list_grid_plugin_option');
function ct_list_grid_plugin_option()
{
    global $WC_List_Grid;
    remove_action('woocommerce_before_shop_loop', array($WC_List_Grid, 'gridlist_toggle_button'), 30);
}

/**
 * Show SKU on product page before cart button
 * @link https://i.imgur.com/1O6oYNT.png
 */
// add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_after_shop_loop_item_sku_in_cart', 20, 1 );
function woocommerce_after_shop_loop_item_sku_in_cart($template)
{
    global $product;
    $sku = $product->get_sku();
    echo $sku;
}

/**
 * Remove SKU's from product page
 * somehow its not working
 */
// add_filter( 'wc_product_sku_enabled', 'ct_remove_sku_from_product_page' );
function ct_remove_sku_from_product_page($enabled)
{
    if (!is_admin() && is_product()) {
        return false;
    }
    return $enabled;
}

/**
 * Change several of the breadcrumb defaults
 */
add_filter('woocommerce_breadcrumb_defaults', 'jk_woocommerce_breadcrumbs');
function jk_woocommerce_breadcrumbs()
{
    return array(
        'delimiter'   => ' &#47; ',
        'wrap_before' => '<nav class="woocommerce-breadcrumb" itemprop="breadcrumb">',
        'wrap_after'  => '</nav>',
        'before'      => '',
        'after'       => '',
        'home'        => _x('Home', 'breadcrumb', 'woocommerce'),
    );
}


// add_action( 'woocommerce_after_shop_loop_item_title', 'ct_add_star_rating' );
function ct_add_star_rating()
{
    global $woocommerce, $product;
    $rating = $product->get_average_rating();
    if ($rating > 0) {
        $title = sprintf(__('Rated %s out of 5:', 'woocommerce'), $rating);
    } else {
        $title  = 'Rate this product';
        $rating = 0;
    }

    $rating_html = '<a href="' . get_the_permalink() . '#respond"><div class="star-rating ehi-star-rating"><span style="width:' . (($rating / 5) * 100) . '%"><span></div><span style="font-size: 0.857em;"><em><strong&gt;' . $title . '&lt;/strong></em></span></a&gt;';
    // echo $rating_html;
}
// add_filter( 'woocommerce_product_get_rating_html', 'ct_woocommerce_product_get_rating_html', 10, 3 );
function ct_woocommerce_product_get_rating_html($rating, $count)
{
    global $product;
    $review_count    = $product->get_review_count();
    $additional_info = '<span class="reviews">reviews</span>';
    // $render_html = '<div>'. $rating . $additional_info . (int) $count .$review_count .'</div>';
    $render_html = '<div class="all-align">' . $rating . $additional_info . " " . (int) $review_count . '</div>';

    return $render_html;
}
function ct_shorten_woo_product_title($title, $id)
{
    if (!is_singular(array('product')) && get_post_type($id) === 'product') {
        return wp_trim_words($title, 5, '...');
    } else {
        return $title;
    }
}

add_filter('the_title', 'ct_shorten_woo_product_title', 10, 2);
// Woocommerce Support
add_action('after_setup_theme', 'woocommerce_support');
function woocommerce_support()
{
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');

    // add_theme_support( 'woocommerce', array(
    //     'thumbnail_image_width' => 150,
    //     'single_image_width'    => 300,

    //     'product_grid'          => array(
    //         'default_rows'    => 3,
    //         'min_rows'        => 2,
    //         'max_rows'        => 8,
    //         'default_columns' => 4,
    //         'min_columns'     => 2,
    //         'max_columns'     => 5,
    //     ),
    // ) );
}

        // add_action( 'woocommerce_product_thumbnails', 'ct_woocommerce_product_thumbnails' );
        // function ct_woocommerce_product_thumbnails() {
        //     echo "Hello world";
        // }
        // }


// Redirect Shop Page With Custom One
// add_action('template_redirect', 'ct_shop_page_redirect');
function ct_shop_page_redirect()
{
    if (function_exists('is_shop') && is_shop()) {
        wp_redirect('http://wp.local/new-shop');
        exit;
    }
}


/**
 * @snippet       Hide Item Image - WooCommerce Product Grid Blocks
 * @how-to        Get CustomizeWoo.com FREE
 * @author        Rodolfo Melogli
 * @compatible    WooCommerce 5
 */
 
// add_filter('woocommerce_blocks_product_grid_item_html', 'ct_remove_product_grid_block_image');

function ct_remove_product_grid_block_image($html, $data, $product)
{
    return "<li class=\"wc-block-grid__product\">
        <a href=\"{$data->permalink}\" class=\"wc-block-grid__product-link\">
            {$data->title}
        </a>
        {$data->badge}
        {$data->price}
        {$data->rating}
        {$data->button}
    </li>";
}


/**
 * Url: http://i.imgur.com/AoWydfz.png
 */
// add_filter('woocommerce_before_add_to_cart_button', 'test');
// function test(){
// 	echo "Hello Sir";
// }


remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

add_action('woocommerce_before_main_content', 'my_theme_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'my_theme_wrapper_end', 10);

function my_theme_wrapper_start() {
    echo '<section id="anisur-id">';
}

function my_theme_wrapper_end() {
    echo '</section>';
}