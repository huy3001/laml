<?php
/**
 * Register required plugins for TGM Plugin Activator
 *
 * @package Caldera
 */
add_action( 'tgmpa_register', 'caldera_register_required_plugins' );
/**
 * Register the required plugins for this theme.
 *
 * In this example, we register five plugins:
 * - one included with the TGMPA library
 * - two from an external source, one from an arbitrary source, one from a GitHub repository
 * - two from the .org repo, where one demonstrates the use of the `is_callable` argument
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
function caldera_register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(
		array(
			'name'     => esc_html__( 'Contact Form 7', 'caldera' ),
			'slug'     => 'contact-form-7',
			'required' => false,
		),
		array(
			'name'         => esc_html__( 'Cherry Sidebars', 'caldera' ),
			'slug'         => 'cherry-sidebars',
			'source'       => 'https://downloads.wordpress.org/plugin/cherry-sidebars.1.0.zip',
			'external_url' => 'https://wordpress.org/plugins/cherry-sidebars',
			'required'     => false,
		),
		array(
			'name'         => esc_html__( 'Cherry Projects', 'caldera' ),
			'slug'         => 'cherry-projects',
			'source'       => 'https://downloads.wordpress.org/plugin/cherry-projects.1.0.0.zip',
			'external_url' => 'https://github.com/CherryFramework/cherry-projects',
			'required'     => false,
		),
		array(
			'name'     => 'Power Builder',
			'slug'     => 'tm-content-builder',
			'required' => false,
			'source'   => CALDERA_THEME_DIR . '/assets/plugins/tm-content-builder.zip',
		),
		array(
			'name'     => 'Power Builder Integrator',
			'slug'     => 'tm-builder-integrator',
			'required' => false,
			'source'   => CALDERA_THEME_DIR . '/assets/plugins/tm-builder-integrator.zip',
		),
		array(
			'name'     => 'Cherry Ld Mods Switcher',
			'slug'     => 'cherry-ld-mods-switcher',
			'required' => false,
			'source'   => CALDERA_THEME_DIR . '/assets/plugins/cherry-ld-mods-switcher.zip',
		),
		array(
			'name'     => esc_html__( 'Simple File Downloader', 'caldera' ),
			'slug'     => 'simple-file-downloader',
			'source'   => 'https://downloads.wordpress.org/plugin/simple-file-downloader.1.0.4.zip',
			'required' => false,
		),
	);

	/*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
	 * sending in a pull-request with .po file(s) with the translations.
	 *
	 * Only uncomment the strings in the config array if you want to customize the strings.
	 */
	$config = array(
		'id'           => 'caldera',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
	);

	tgmpa( $plugins, $config );
}
