<?php

function moby6_init() {
	// Add mobile headers for wp-admin
	add_action( 'admin_head', 'moby6_add_mobile_headers' );

	// Add CSS/JS for wp-admin
	add_action( 'admin_print_styles', 'moby6_add_css' );
	add_action( 'admin_print_scripts', 'moby6_add_js' );

	// Add toolbar CSS
	add_action( 'admin_print_styles', 'moby6_add_toolbar_css' );
	add_action( 'wp_enqueue_scripts', 'moby6_add_toolbar_css' );

	add_filter( 'shortcut_link', 'moby6_enlarge_pressthis' );
}
add_action( 'init', 'moby6_init' );

function moby6_add_mobile_headers() {
	echo '<meta name="viewport" content="width=device-width,user-scalable=no,initial-scale=1.0,maximum-scale=1.0">';
}

function moby6_add_css() {
	$modtime = filemtime( plugin_dir_path( __FILE__ ) . 'css/moby6.css' );
	wp_enqueue_style( 'moby6', plugins_url( 'css/moby6.css', __FILE__ ), false, $modtime );
}

function moby6_add_toolbar_css() {
	$modtime = filemtime( plugin_dir_path( __FILE__ ) . 'css/admin-bar.css' );
	wp_enqueue_style( 'moby6-admin-bar', plugins_url( 'css/admin-bar.css', __FILE__ ), false, $modtime );
}

function moby6_add_js() {
	$modtime = filemtime( plugin_dir_path( __FILE__ ) . 'js/moby6.js' );
	wp_enqueue_script( 'moby6', plugins_url( 'js/moby6.js', __FILE__ ), array( 'jquery', 'backbone' ), $modtime );
	wp_enqueue_script( 'moby6-jq-mobile', plugins_url( 'js/jquery.mobile.custom.min.js', __FILE__ ), array( 'jquery', 'backbone' ), '1.3.1' );
}

function moby6_enlarge_pressthis( $link ) {
	return str_replace( 'width=720,height=570', 'width=770,height=570', $link );
}