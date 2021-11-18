<?php 


// Add Shortcode
function ct_shortcode( $atts , $content = null ) {

	// Attributes
	$atts = shortcode_atts(
		array(
			'id' => '',
			'class' => '',
			'bg' => '',
		),
		$atts,
		'section'
	);
	
	
	$html = '';
	$html .= '<div class="section section-" ' .  $atts['id'] .' style="background: #" ' . $atts['bg'] .'>';
	$html .= '<div class="container">';
	$html .= do_shortcode( $content );
	$html .= '</div></div>';
	
	return $html;

}
add_shortcode( 'section', 'ct_shortcode' );