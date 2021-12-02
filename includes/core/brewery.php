<?php

/**
 * Register post type
 *
 * @return void
 */
add_action( 'init', 'brewery_setup_post_type' );
function brewery_setup_post_type() {
    $args = array(
        'public'    => true,
        'label'     => __( 'Brewery', 'textdomain' ),
        'menu_icon' => 'dashicons-filter',
        'supports'  => array( 'title' ),
    );
    register_post_type( 'brewery', $args );
}

/**
 * Check next schedule if not then ran a weekly cron update
 */
if ( !wp_next_scheduled( 'update_brewery_list' ) ) {
    wp_schedule_event( time(), 'weekly', 'get_brewery_from_api' );
}

/**
 * Filter action for log in/ out user
 */
add_action( 'wp_ajax_get_brewery_from_api', 'get_brewery_from_api' );
add_action( 'wp_ajax_nopriv_get_brewery_from_api', 'get_brewery_from_api' );
/**
 * Get brewery from API
 *
 */
function get_brewery_from_api() {

    $file         = get_stylesheet_directory() . '/includes/core/report.txt';
    $current_page = ( !empty( $_POST['current_page'] ) ) ? $_POST['current_page'] : 1;
    $breweries    = [];

    $results = wp_remote_retrieve_body( wp_remote_get( 'https://api.openbrewerydb.org/breweries/?page=' . $current_page . '&per_page=50' ) );

    file_put_contents( $file, "Current page " . $current_page . "\n\n", FILE_APPEND );

    $results = json_decode( $results );

    if ( !is_array( $results ) || empty( $results ) ) {
        return false;
    }

    $breweries[] = $results;

    foreach ( $breweries[0] as $brewery ) {
        $brewery_slug = sanitize_title( $brewery->name . '-' . $brewery->id );

        $existing_brewery = get_page_by_path( $brewery_slug, 'OBJECT', 'brewery' );

        if ( $existing_brewery === null ) {
            $inserted_brewery = wp_insert_post( array(
                'post_name'   => $brewery_slug,
                'post_title'  => $brewery_slug,
                'post_type'   => 'brewery',
                'post_status' => 'publish',
            ) );

            if ( is_wp_error( $inserted_brewery ) ) {
                continue;
            }

            $fillable = array(
                'field_618fe5c892adc' => 'name',
                'field_618fe5d992add' => 'brewery_type',
                'field_618fe5ed92ade' => 'street',
                'field_618fe5f592adf' => 'city',
                'field_618fe5fa92ae0' => 'state',
                'field_618fe60092ae1' => 'postal_code',
                'field_618fe60a92ae2' => 'country',
                'field_618fe61092ae3' => 'longitude',
                'field_618fe8d492ae4' => 'latitude',
                'field_618fe8de92ae5' => 'phone',
                'field_618fe8e692ae6' => 'website_url',
                'field_618fe8ef92ae7' => 'updated_at',
            );

            foreach ( $fillable as $key => $name ) {
                update_field( $key, $brewery->$name, $inserted_brewery );
            }
        } else {
            $existing_brewery_id        = $existing_brewery->ID;
            $existing_brewery_timestamp = get_field( 'updated_at', $existing_brewery_id );

            if ( $brewery->updated_at >= $existing_brewery_timestamp ) {
                $fillable = array(
                    'field_619daa2b76b8d' => 'name',
                    'field_619daa4576b8e' => 'brewery_type',
                    'field_619daa5176b8f' => 'street',
                    'field_619daa5876b90' => 'city',
                    'field_619daa6076b91' => 'state',
                    'field_619daa6676b92' => 'postal_code',
                    'field_619daa7076b93' => 'country',
                    'field_619daa7776b94' => 'longitude',
                    'field_619daa7f76b95' => 'latitude',
                    'field_619daa8776b96' => 'phone',
                    'field_619daa9076b97' => 'website_url',
                    'field_619daa9a76b98' => 'updated_at',
                );

                foreach ( $fillable as $key => $name ) {
                    update_field( $key, $brewery->$name, $existing_brewery_id );
                }
            }
        }

    }

    $current_page = $current_page + 1;
    wp_remote_post( admin_url( 'admin-ajax.php?action=get_brewery_from_api' ), array(
        'blocking'  => false,
        'sslverify' => false,
        'body'      => array(
            'current_page' => $current_page,
        ),
    ) );

}
