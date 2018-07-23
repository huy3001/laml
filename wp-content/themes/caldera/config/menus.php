<?php
/**
 * Menus configuration.
 *
 * @package Caldera
 */

add_action( 'after_setup_theme', 'caldera_register_menus', 5 );
function caldera_register_menus() {

	// This theme uses wp_nav_menu() in four locations.
	register_nav_menus( array(
		'top'    => esc_html__( 'Top', 'caldera' ),
		'main'   => esc_html__( 'Main', 'caldera' ),
		'footer' => esc_html__( 'Footer', 'caldera' ),
		'social' => esc_html__( 'Social', 'caldera' ),
	) );
}
