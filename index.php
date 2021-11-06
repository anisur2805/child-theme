<?php
get_header();

?>
<div class="container d-none">
    <form class="d-none" action="<?php print site_url();?>" method="post">
        <label>Search here</label>
        <input value="<?php if ( isset( $_POST['s'] ) ) {print $_POST['s'];}?>" name="s" />
        <input type="submit" name="Search here..." />
    </form>
</div>
<?php
// The Query

// The main query of wordpress
$args = array(
    'post_type' => 'post',
);
$the_query = new WP_Query( $args );
/* 
if ( $the_query->have_posts() ) {
    echo '<ul>';
    while ( $the_query->have_posts() ) {
        $the_query->the_post();
        echo '<li>' . get_the_title() . '</li>';
    }
    echo '</ul>';
} else {
    
}
wp_reset_postdata(); */

/**
 * Another way to query posts
 */ 
	/*  $alter_wp_query = get_posts( array(
		'posts_per_page' => 5,
		'offset'         => 2,
		'category'       => 1,
	) );

	if ( $alter_wp_query ) {
		foreach ( $alter_wp_query as $myPost ):
		setup_postdata( $myPost );?>
		<li>
			<a href="<?php the_permalink();?>"><?php the_title();?></a>
			<p><?php the_excerpt();?></p>
		</li>
		<?php endforeach; wp_reset_postdata(); 
	}
*/

/**
 * Another way to query posts
 */ 
 global $wpdb;
 $results = $wpdb->get_results(
	 "SELECT post_title, post_excerpt, ID
	  FROM $wpdb->posts
	  LEFT JOIN $wpdb->term_relationships as t
	  ON ID = t.object_id
	  WHERE post_type = 'post'
	  AND post_status = 'publish'
	  AND t.term_taxonomy_id = 1
	  LIMIT 4"
 );
 echo '<div class="posts-wrapper">';
	foreach ($results as  $result) {
		echo '<h1>' . $result->post_title . '</h1>';
		echo '<a href="' . get_the_permalink( $result->ID) . '">Read More</a>';
		echo '<hr  />';
	}
 echo '</div>';

// if( is_page('Vehicle') ) {
// 	echo "Hello";
// }
/**
 * Test get posts function
 *
 * return posts 
 */
// ct_get_posts();

get_footer();