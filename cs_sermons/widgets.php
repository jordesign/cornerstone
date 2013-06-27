<?php 
/**
 *  ShortCodes
 *
 *  Shortcode to output a single sermon in the editor
 *  
 */

function cs_sermon_single_shortcode( $atts ) {
	extract( shortcode_atts( array(
		'sermon_id' => 1,
		'sermon_image' => false,
		'sermon_series' => false,
		'sermon_speaker' => false,
	), $atts ) );

	return "show sermon $sermon_id";
}
add_shortcode( 'sermon', 'cs_sermon_single_shortcode' );