<?php
/**
 * Thumbnails configuration.
 *
 * @package Caldera
 */

add_action( 'after_setup_theme', 'caldera_register_image_sizes', 5 );
function caldera_register_image_sizes() {
	set_post_thumbnail_size( 370, 253, true );

	// Registers a new image sizes.
	add_image_size( 'caldera-thumb-s', 150, 150, true );
	add_image_size( 'caldera-thumb-m', 400, 400, true );
	add_image_size( 'caldera-thumb-l', 1354, 645, true );
	add_image_size( 'caldera-thumb-xl', 1920, 1080, true );
	add_image_size( 'caldera-author-avatar', 512, 512, true );
	add_image_size( 'caldera-thumb-183-133', 183, 133, true );

	add_image_size( 'caldera-thumb-240-100', 240, 100, true );
	add_image_size( 'caldera-thumb-560-300', 560, 300, true );
	add_image_size( 'caldera-thumb-1920-880', 1920, 880, true );

	//projects categories
	add_image_size( 'caldera-thumb-480-500', 480, 500, true );
	add_image_size( 'caldera-thumb-836-608-fullscreen', 836, 608, true );

}
