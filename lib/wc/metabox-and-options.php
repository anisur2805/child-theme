<?php

// Control core classes for avoid errors
if ( class_exists( 'CSF' ) ) {

 //
 // Set a unique slug-like ID
 $prefix = 'wp-ct-product';

 // Create a section
//  CSF::createMetabox( $prefix, array(
//   'title'     => 'Customize Product',
//   'post_type' => 'post',
//  ) );


 // Create a section
 CSF::createSection( $prefix, array(
  'fields' => array(

   array(
    'id'           => 'top_tab',
    'type'         => 'group',
    'title'        => 'Top Tab',
    'button_title' => 'Add new',
    'fields'       => array(
     array(
      'id'    => 'title',
      'type'  => 'text',
      'title' => 'Tab Title',
     ),
     array(
      'id'    => 'content',
      'type'  => 'wp_editor',
      'title' => 'Content',
     ),
    ),
   ),

  ),
 ) );

} else {
  function wpct_codestar_install_notice() {
    ?>
      <div class="notice notice-warning">
        <p>Somethin message</p>
      </div>
    <?php 
  }
  
  add_action('admin_notices', 'wpct_codestar_install_notice');
}
