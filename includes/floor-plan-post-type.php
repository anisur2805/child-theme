<?php
if ( !function_exists( 'floor_plan_custom_post_type' ) ) {

// Register Custom Floor Plan
    function floor_plan_custom_post_type() {

        $labels = array(
            'name'                  => _x( 'Floor Plans', 'Floor Plan General Name', 'floor_plan' ),
            'singular_name'         => _x( 'Floor Plan', 'Floor Plan Singular Name', 'floor_plan' ),
            'menu_name'             => __( 'Floor Plan', 'floor_plan' ),
            'name_admin_bar'        => __( 'Floor Plan', 'floor_plan' ),
            'archives'              => __( 'Item Archives', 'floor_plan' ),
            'attributes'            => __( 'Item Attributes', 'floor_plan' ),
            'parent_item_colon'     => __( 'Parent Item:', 'floor_plan' ),
            'all_items'             => __( 'All Items', 'floor_plan' ),
            'add_new_item'          => __( 'Add New Item', 'floor_plan' ),
            'add_new'               => __( 'Add New', 'floor_plan' ),
            'new_item'              => __( 'New Item', 'floor_plan' ),
            'edit_item'             => __( 'Edit Item', 'floor_plan' ),
            'update_item'           => __( 'Update Item', 'floor_plan' ),
            'view_item'             => __( 'View Item', 'floor_plan' ),
            'view_items'            => __( 'View Items', 'floor_plan' ),
            'search_items'          => __( 'Search Item', 'floor_plan' ),
            'not_found'             => __( 'Not found', 'floor_plan' ),
            'not_found_in_trash'    => __( 'Not found in Trash', 'floor_plan' ),
            'featured_image'        => __( 'Featured Image', 'floor_plan' ),
            'set_featured_image'    => __( 'Set featured image', 'floor_plan' ),
            'remove_featured_image' => __( 'Remove featured image', 'floor_plan' ),
            'use_featured_image'    => __( 'Use as featured image', 'floor_plan' ),
            'insert_into_item'      => __( 'Insert into item', 'floor_plan' ),
            'uploaded_to_this_item' => __( 'Uploaded to this item', 'floor_plan' ),
            'items_list'            => __( 'Items list', 'floor_plan' ),
            'items_list_navigation' => __( 'Items list navigation', 'floor_plan' ),
            'filter_items_list'     => __( 'Filter items list', 'floor_plan' ),
        );
		
        $args = array(
            'label'               => __( 'Floor Plan', 'floor_plan' ),
            'description'         => __( 'Floor Plan Description', 'floor_plan' ),
            'labels'              => $labels,
            'supports'            => array( 'title', 'editor', 'thumbnail' ),
            'hierarchical'        => false,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'menu_position'       => 6,
            'show_in_admin_bar'   => true,
            'show_in_nav_menus'   => true,
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
        );
		
        register_post_type( 'floor_plan', $args );

    }
    add_action( 'init', 'floor_plan_custom_post_type', 0 );
	
}

/**
 * Register home_type taxonomy for post type 'vehicle'.
 *
 * @see register_post_type() for registering post types.
 */
function ct_register_vehicle_taxonomy() {
    $args = array(
        'label'        => __( 'Home Type', 'textdomain' ),
        'public'       => true,
        'rewrite'      => false,
        'hierarchical' => true
    );
     
    register_taxonomy( 'home_type', array('floor_plan'), $args );
}
add_action( 'init', 'ct_register_vehicle_taxonomy', 0 );

/**
 * Add Image on Taxonomy
 *
 * @param [type] $taxonomy
 * @return void
 */
 $home_type_taxonomy = 'home_type';
function add_category_image ( $taxonomy ) {
?>
    <div class="form-field term-group">

        <label for="image_id"><?php _e('Image', 'taxt-domain'); ?></label>
        <input type="hidden" id="image_id" name="image_id" class="custom_media_url" value="">

        <div id="image_wrapper"></div>

        <p>
            <input type="button" class="button button-secondary taxonomy_media_button" id="taxonomy_media_button" name="taxonomy_media_button" value="<?php _e( 'Add Image', 'taxt-domain' ); ?>">
            <input type="button" class="button button-secondary taxonomy_media_remove" id="taxonomy_media_remove" name="taxonomy_media_remove" value="<?php _e( 'Remove Image', 'taxt-domain' ); ?>">
        </p>

    </div>
<?php
}
add_action( "{$home_type_taxonomy}_add_form_fields", "add_category_image", 10, 2 );

/**
 * Save the image of taxonomy
 *
 * @param [type] $term_id
 * @param [type] $tt_id
 * @return void
 */
add_action( "created_{$home_type_taxonomy}", "save_category_image", 10, 2 );
function save_category_image ( $term_id, $tt_id ) {
    if( isset( $_POST['image_id'] ) && '' !== $_POST['image_id'] ){
     $image = $_POST['image_id'];
     add_term_meta( $term_id, 'category_image_id', $image, true );
    }
}
