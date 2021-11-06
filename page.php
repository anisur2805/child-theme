<?php

    /**
     * The template for displaying all single posts
     *
     * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
     *
     * @package WordPress
     * @subpackage Twenty_Twenty_One
     * @since Twenty Twenty-One 1.0
     */

    get_header();

    /* Start the Loop */
    while ( have_posts() ):
        the_post();
        get_template_part( 'template-parts/content/content-page' );

        /**
         * This is for Floor Plan Page and 225 is the ID
         */
        if ( is_page( 225 ) ) { ?>
			<div class="container">
				<form method="GET">

					<select name="orderby" id="orderby">
						<option value="date" <?php echo selected( $_GET['orderby'], 'date' ) ?>>
							Old to New
						</option>
						<option value="title" <?php echo selected( $_GET['orderby'], 'title' ) ?>>
							Alphabetically
						</option>
					</select>

					<input type="hidden" name="order" id="order" value="<?php echo ( isset( $_GET['order'] ) && $_GET['order'] == 'ASC' ) ? 'ASC' : 'DESC'; ?>"  />

						<?php

							/**
								* check the taxonomy
								* @link https://i.imgur.com/jLxtKed.png
								*/
							/*
							$terms = get_terms( 'home_type' );
							echo "<pre>";
							print_r( $terms );
							wp_die();
								*/
							$terms = get_terms( [
								'taxonomy'   => 'home_type',
								'hide_empty' => false,
							] );

							foreach ( $terms as $term ):
						?>
						
						<label>
							<input type="checkbox" value="<?php echo $term->slug; ?>" name="home_type[]"<?php checked(  ( isset( $_GET['home_type'] ) && in_array( $term->slug, $_GET['home_type'] ) ) );?> />
							<?php echo $term->name; ?>
						</label>
						<?php endforeach;?>
						<button type="submit">Apply</button>

					</form>

				<div class="floor_plan_wrapper">
					<?php
						$args = array(
								'post_type' => 'floor_plan',
							);
							$floor_plans = new WP_Query( $args );
							if ( $floor_plans->have_posts() ) {
								while ( $floor_plans->have_posts() ) {
									$floor_plans->the_post(); ?>
									
									<div class="home-card">
										<?php
											if ( has_post_thumbnail() ) {
															the_post_thumbnail();
														}
													?>
										<h3><?php the_title();?></h3>

										<?php $term_obj_list = get_the_terms( $post->ID, 'home_type' );
											echo '<p><strong>Type: </strong>' . join( ', ', wp_list_pluck( $term_obj_list, 'name' ) ) . '</p>'; ?>
									</div>

							<?php }
									}
								?>
				</div>
			</div>
		<?php
        }
		
		
        endwhile; // End of the loop.		

    get_footer();
