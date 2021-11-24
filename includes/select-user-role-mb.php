<?php 
/*
create class
cons -> action add meta boxes -> cb function
cb->add_meta_box -> cb_html

cb_html 

new WP_User_Query
	role ' editor
	number all 
	fields [display name ID]
	
	chekc if exixt than foreach with select 
	than save 
	*/ 
	
class User_Role_Editor_MetaBox {
	public function __construct() {
		add_action( 'add_meta_boxes', [ $this, 'create_meta_boxes' ] );
		add_action( 'save_post', [ $this, 'save_editor' ] );
	}
	
	
	public function create_meta_boxes() {
		add_meta_box('editor_id', 'Post Editor', [$this, 'meta_box_html_cb'], 'post' );
	}
	
	public function meta_box_html_cb() {
		$user_query = new WP_User_Query([
			'role' => 'editor',
			'number' => -1,
			'fields' => [
				'display_name',
				'ID'
			],
		]);
		
		$editors = $user_query->get_results();
		if ( !empty( $editors ) ) {
			?>
				<label for="post_editor"><?php __('Editor: ', 'ct') ?></label>
				<select name="ct_post_editor" id="post_editor">
					<option>- Select One -</option>
					<?php 
						foreach ($editors as $editor) {
							echo '<option value="'.$editor->ID . '" ' . selected( get_post_meta( get_the_ID(), 'ct_post_editor', true ), $editor->ID, false ) . '>' . $editor->display_name . '</option>';
						}
					?>
				</select>
			<?php
		} else {
			echo '<p>No Editor Found!</p>';
		}
	}
	
	
	
	public function save_editor( $post_id ) {
		if( isset( $_POST['ct_post_editor']) && is_numeric( $_POST['ct_post_editor'])) {
			$editor_id = sanitize_text_field( $_POST['ct_post_editor']);
			
			update_post_meta($post_id, 'ct_post_editor', $editor_id );
		}
	}
	
	
}

new User_Role_Editor_MetaBox();