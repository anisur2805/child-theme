<?php
if ( !function_exists( 'vehicle_custom_post_type' ) ) {

// Register Custom Vehicle
    function vehicle_custom_post_type() {

        $labels = array(
            'name'                  => _x( 'Vehicles', 'Vehicle General Name', 'vehicle' ),
            'singular_name'         => _x( 'Vehicle', 'Vehicle Singular Name', 'vehicle' ),
            'menu_name'             => __( 'Vehicles', 'vehicle' ),
            'name_admin_bar'        => __( 'Vehicle', 'vehicle' ),
            'archives'              => __( 'Item Archives', 'vehicle' ),
            'attributes'            => __( 'Item Attributes', 'vehicle' ),
            'parent_item_colon'     => __( 'Parent Item:', 'vehicle' ),
            'all_items'             => __( 'All Items', 'vehicle' ),
            'add_new_item'          => __( 'Add New Item', 'vehicle' ),
            'add_new'               => __( 'Add New', 'vehicle' ),
            'new_item'              => __( 'New Item', 'vehicle' ),
            'edit_item'             => __( 'Edit Item', 'vehicle' ),
            'update_item'           => __( 'Update Item', 'vehicle' ),
            'view_item'             => __( 'View Item', 'vehicle' ),
            'view_items'            => __( 'View Items', 'vehicle' ),
            'search_items'          => __( 'Search Item', 'vehicle' ),
            'not_found'             => __( 'Not found', 'vehicle' ),
            'not_found_in_trash'    => __( 'Not found in Trash', 'vehicle' ),
            'featured_image'        => __( 'Featured Image', 'vehicle' ),
            'set_featured_image'    => __( 'Set featured image', 'vehicle' ),
            'remove_featured_image' => __( 'Remove featured image', 'vehicle' ),
            'use_featured_image'    => __( 'Use as featured image', 'vehicle' ),
            'insert_into_item'      => __( 'Insert into item', 'vehicle' ),
            'uploaded_to_this_item' => __( 'Uploaded to this item', 'vehicle' ),
            'items_list'            => __( 'Items list', 'vehicle' ),
            'items_list_navigation' => __( 'Items list navigation', 'vehicle' ),
            'filter_items_list'     => __( 'Filter items list', 'vehicle' ),
        );
		
        $args = array(
            'label'               => __( 'Vehicle', 'vehicle' ),
            'description'         => __( 'Vehicle Description', 'vehicle' ),
            'labels'              => $labels,
            'supports'            => array( 'title' ),
            'hierarchical'        => false,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'menu_position'       => 5,
            'show_in_admin_bar'   => true,
            'show_in_nav_menus'   => true,
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            // 'capability_type'     => 'vehicle',
        );
		
        register_post_type( 'vehicle', $args );

    }
    add_action( 'init', 'vehicle_custom_post_type', 0 );
	
}

/**
 * Add Custom User with role
 */
add_action('init', function(){
	add_role('technician', 'Technician' );
	
	$tech = get_role('technician');
	$tech->add_cap('read');
	$tech->add_cap('edit_vehicles');
	$tech->add_cap('edit_vehicle');
	$tech->add_cap('edit_others_vehicle');
	$tech->add_cap('edit_others_vehicles');
	$tech->add_cap('view_assigned_technician');
	 
	$admin = get_role('administrator');
	$admin->add_cap('view_assigned_technician');
	
});