<?php

    /**
     * Show Vehicle post types in Vehicle page
     * and its id is
     */
    // if ( is_page( 'vehicle' ) ) {
    $vehicles = get_posts( array(
        'post_type'   => 'vehicle',
        'post_status' => 'publish',
    ) );

?>
					<table>
						<tr>
							<th>Make</th>
							<th>Model</th>

							<?php if ( current_user_can( 'view_assigned_technician' ) ) {
                                    echo '<th>Price</th>';
                            }?>

							<?php if ( current_user_can( 'view_assigned_technician' ) ) {
                                    echo '<th>Assigned To</th>';
                            }?>
						</tr>

						<?php
                            if ( $vehicles ) {
                                foreach ( $vehicles as $key => $vehicle ) {
                                    echo '<tr>';
                                    echo '<td>' . get_field( 'make', $vehicle->ID ) . '</td>';
                                    echo '<td>' . get_field( 'model', $vehicle->ID ) . '</td>';
                                    if ( current_user_can( 'view_assigned_technician' ) ) {
                                        echo '<td>' . get_field( 'price', $vehicle->ID ) . '</td>';
                                    }
                                    if ( current_user_can( 'technician' ) || current_user_can( 'view_assigned_technician' ) ) {
                                        echo '<td>' . get_field( 'assigned_technician', $vehicle->ID ) . '</td>';
                                    }
                                    echo '</tr>';
                                }
                            }
                        echo '</table>';
                        // }