<?php

add_action( 'admin_menu', 'stp_api_add_admin_menu' );
add_action( 'admin_init', 'stp_api_settings_init' );

function stp_api_add_admin_menu(  ) {
    add_options_page( 'Settings API Page', 'Settings API Page', 'manage_options', 'settings-api-page', 'stp_api_options_page' );
    // add_options_page( $page_title:string, $menu_title:string, $capability:string, $menu_slug:string, $function:callable, $position:integer|null )
}

function stp_api_settings_init(  ) {
    register_setting( 'test', 'test_settings' );
    add_settings_section(
        'test_section',
        __( 'Test Title', 'wordpress' ),
        'test_settings_section_callback',
        'stpPlugin'
    );
    add_settings_field(
        'test_text_field_0',
        __( 'Test 0 Title', 'wordpress' ),
        'test_text_field_0_render',
        'stpPlugin',
        'test_section'
    );
    
    register_setting( 'stpPlugin', 'stp_api_settings' );
    add_settings_section(
        'stp_api_stpPlugin_section',
        __( 'Our Section Title', 'wordpress' ),
        'stp_api_settings_section_callback',
        'stpPlugin'
    );
    
    // register_setting( $option_group:string, $option_name:string, $args:array )
    // add_settings_section( $id:string, $title:string, $callback:callable, $page:string )
    // add_settings_field( $id:string, $title:string, $callback:callable, $page:string, $section:string, $args:array )
    add_settings_field(
        'stp_api_text_field_0',
        __( 'Text Field', 'wordpress' ),
        'stp_api_text_field_0_render',
        'stpPlugin',
        'stp_api_stpPlugin_section'
    );

    add_settings_field(
        'stp_api_select_field_1',
        __( 'Select Field', 'wordpress' ),
        'stp_api_select_field_1_render',
        'stpPlugin',
        'stp_api_stpPlugin_section'
    );
    
    add_settings_field(
        'std_description',
        __( 'Description', 'wordpress' ),
        'std_description_render',
        'stpPlugin',
        'stp_api_stpPlugin_section'
    );
    add_settings_field(
        'std_choose',
        __( 'Choose Field', 'wordpress' ),
        'choose_render',
        'stpPlugin',
        'stp_api_stpPlugin_section'
    );    
    
    add_settings_field(
        'std_checkbox',
        __( 'Checkbox Field', 'wordpress' ),
        'checkbox_render',
        'stpPlugin',
        'stp_api_stpPlugin_section'
    );
    
    add_settings_field(
        'std_multiple_checkbox',
        __( 'Multiple Checkbox', 'wordpress' ),
        'multiple_checkbox_render',
        'stpPlugin',
        'stp_api_stpPlugin_section'
    );
    add_settings_field(
        'uwcc_checkbox_field_1',
        __( 'Test Purpose', 'wordpress' ),
        'uwcc_checkbox_field_1_render',
        'stpPlugin',
        'stp_api_stpPlugin_section'
    );
}

function test_text_field_0_render(){
    echo "Hi from Test 0";
}
function stp_api_text_field_0_render(  ) {
    $options = get_option( 'stp_api_settings' );
    ?>
    <input type='text' name='stp_api_settings[stp_api_text_field_0]' value='<?php echo $options['stp_api_text_field_0']; ?>'>
    <?php
}

function stp_api_select_field_1_render(  ) {
    $options = get_option( 'stp_api_settings' );
    ?>
    <select name='stp_api_settings[stp_api_select_field_1]'>
        <option value='1' <?php selected( $options['stp_api_select_field_1'], 1 ); ?>>Option 1</option>
        <option value='2' <?php selected( $options['stp_api_select_field_1'], 2 ); ?>>Option 2</option>
    </select>

<?php
}

function std_description_render(  ) {
    $options = get_option( 'stp_api_settings' );
    ?>
    <textarea name='stp_api_settings[std_description]'> <?php echo $options['std_description']; ?></textarea>
<?php
}

function checkbox_render(  ) {
    $options = get_option( 'stp_api_settings' );
    $html = '<input type="checkbox" id="std_checkbox_one" name="stp_api_settings[std_checkbox]" value="1"' . checked( 1, $options['std_checkbox'], false ) . '/>';
    $html .= '<label for="std_checkbox_one">Mango</label>';
    
    $html .= '<input type="checkbox" id="std_checkbox_two" name="stp_api_settings[std_checkbox]" value="2"' . checked( 2, $options['std_checkbox'], false ) . '/>';
    $html .= '<label for="std_checkbox_two">banana</label>';
    
    echo $html;
}

function choose_render(  ) {
    $options = get_option( 'stp_api_settings' );
    $html = '<input type="radio" id="std_choose" name="stp_api_settings[std_choose]" value="1"' . checked( 1, $options['std_choose'], false ) . '/>';
    $html .= '<label for="std_choose">Option One</label>';
    
    $html .= '<input type="radio" id="std_choose_two" name="stp_api_settings[std_choose]" value="2"' . checked( 2, $options['std_choose'], false ) . '/>';
    $html .= '<label for="std_choose_two">Option Two</label>';
    
    echo $html;
}

function multiple_checkbox_render() {

    $options = get_option( 'stp_api_settings', [] );

    $stp_api_settings = isset( $options['stp_api_settings'] )
        ? (array) $options['stp_api_settings'] : [];
    ?>
    <input type='checkbox' name='stp_api_settings[std_multiple_checkbox][]' <?php checked( in_array( 'Mastercard', $stp_api_settings ), 1 ); ?> value='Mastercard'>
        <label>Mastercard</label>
    <input type='checkbox' name='stp_api_settings[std_multiple_checkbox][]' <?php checked( in_array( 'Visa', $stp_api_settings ), 1 ); ?> value='Visa'>
       <label>Visa</label>
    <input type='checkbox' name='stp_api_settings[std_multiple_checkbox][]' <?php checked( in_array( 'Amex', $stp_api_settings ), 1 ); ?> value='Amex'>
       <label>Amex</label>

    <?php

} 


function uwcc_checkbox_field_1_render() {

    $options = get_option( 'stp_api_settings', [] );

    $uwcc_checkbox_field_1 = isset( $options['uwcc_checkbox_field_1'] )
        ? (array) $options['uwcc_checkbox_field_1'] : [];
    ?>
    <input type='checkbox' name='stp_api_settings[uwcc_checkbox_field_1][]' <?php checked( in_array( 'Mastercard', $uwcc_checkbox_field_1 ), 1 ); ?> value='Mastercard'>
        <label>Mastercard</label>
    <input type='checkbox' name='stp_api_settings[uwcc_checkbox_field_1][]' <?php checked( in_array( 'Visa', $uwcc_checkbox_field_1 ), 1 ); ?> value='Visa'>
       <label>Visa</label>
    <input type='checkbox' name='stp_api_settings[uwcc_checkbox_field_1][]' <?php checked( in_array( 'Amex', $uwcc_checkbox_field_1 ), 1 ); ?> value='Amex'>
       <label>Amex</label>
    <?php

}

function stp_api_settings_section_callback(  ) {
    echo __( 'This Section Description', 'wordpress' );
}
function test_settings_section_callback(  ) {
    echo __( 'Test Section Description', 'wordpress' );
}

function stp_api_options_page(  ) {
    ?>
    <form action='options.php' method='post'>
        <h2>Site Point Settings API Admin Page</h2>
        <?php
            settings_fields( 'stpPlugin' );
            do_settings_sections( 'stpPlugin' );
            submit_button();
        ?>
    </form>
    <?php
}