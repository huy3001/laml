<?php
/**
 * Theme Customizer.
 *
 * @package Caldera
 */

/**
 * Retrieve a holder for Customizer options.
 *
 * @since  1.0.0
 * @return array
 */
function caldera_get_customizer_options() {
	/**
	 * Filter a holder for Customizer options (for theme/plugin developer customization).
	 *
	 * @since 1.0.0
	 */
	return apply_filters( 'caldera_get_customizer_options', array(
		'prefix'     => 'caldera',
		'capability' => 'edit_theme_options',
		'type'       => 'theme_mod',
		'options'    => array(

			/** `Site Indentity` section */
			'show_tagline'                     => array(
				'title'    => esc_html__( 'Show tagline after logo', 'caldera' ),
				'section'  => 'title_tagline',
				'priority' => 60,
				'default'  => true,
				'field'    => 'checkbox',
				'type'     => 'control',
			),
			'totop_visibility'                 => array(
				'title'    => esc_html__( 'Show ToTop button', 'caldera' ),
				'section'  => 'title_tagline',
				'priority' => 61,
				'default'  => true,
				'field'    => 'checkbox',
				'type'     => 'control',
			),
			'page_preloader'                   => array(
				'title'    => esc_html__( 'Show page preloader', 'caldera' ),
				'section'  => 'title_tagline',
				'priority' => 62,
				'default'  => true,
				'field'    => 'checkbox',
				'type'     => 'control',
			),
			'general_settings'                 => array(
				'title'    => esc_html__( 'General Site settings', 'caldera' ),
				'priority' => 40,
				'type'     => 'panel',
			),

			/** `Logo & Favicon` section */
			'logo_favicon'                     => array(
				'title'    => esc_html__( 'Logo &amp; Favicon', 'caldera' ),
				'priority' => 25,
				'panel'    => 'general_settings',
				'type'     => 'section',
			),
			'header_logo_type'                 => array(
				'title'   => esc_html__( 'Logo Type', 'caldera' ),
				'section' => 'logo_favicon',
				'default' => 'image',
				'field'   => 'radio',
				'choices' => array(
					'image' => esc_html__( 'Image', 'caldera' ),
					'text'  => esc_html__( 'Text', 'caldera' ),
				),
				'type'    => 'control',
			),
			'header_logo_url'                  => array(
				'title'           => esc_html__( 'Logo Upload', 'caldera' ),
				'description'     => esc_html__( 'Upload logo image', 'caldera' ),
				'section'         => 'logo_favicon',
				'default'         => '%s/assets/images/logo.png',
				'field'           => 'image',
				'type'            => 'control',
				'active_callback' => 'caldera_is_header_logo_image',
			),
			'retina_header_logo_url'           => array(
				'title'           => esc_html__( 'Retina Logo Upload', 'caldera' ),
				'description'     => esc_html__( 'Upload logo for retina-ready devices', 'caldera' ),
				'section'         => 'logo_favicon',
				'field'           => 'image',
				'type'            => 'control',
				'active_callback' => 'caldera_is_header_logo_image',
			),
			'header_logo_font_family'          => array(
				'title'           => esc_html__( 'Font Family', 'caldera' ),
				'section'         => 'logo_favicon',
				'default'         => 'Poppins, sans-serif',
				'field'           => 'fonts',
				'type'            => 'control',
				'active_callback' => 'caldera_is_header_logo_text',
			),
			'header_logo_font_style'           => array(
				'title'           => esc_html__( 'Font Style', 'caldera' ),
				'section'         => 'logo_favicon',
				'default'         => 'normal',
				'field'           => 'select',
				'choices'         => caldera_get_font_styles(),
				'type'            => 'control',
				'active_callback' => 'caldera_is_header_logo_text',
			),
			'header_logo_font_weight'          => array(
				'title'           => esc_html__( 'Font Weight', 'caldera' ),
				'section'         => 'logo_favicon',
				'default'         => '400',
				'field'           => 'select',
				'choices'         => caldera_get_font_weight(),
				'type'            => 'control',
				'active_callback' => 'caldera_is_header_logo_text',
			),
			'header_logo_font_size'            => array(
				'title'           => esc_html__( 'Font Size, px', 'caldera' ),
				'section'         => 'logo_favicon',
				'default'         => '27',
				'field'           => 'number',
				'input_attrs'     => array(
					'min'  => 6,
					'max'  => 50,
					'step' => 1,
				),
				'type'            => 'control',
				'active_callback' => 'caldera_is_header_logo_text',
			),
			'header_logo_character_set'        => array(
				'title'           => esc_html__( 'Character Set', 'caldera' ),
				'section'         => 'logo_favicon',
				'default'         => 'latin',
				'field'           => 'select',
				'choices'         => caldera_get_character_sets(),
				'type'            => 'control',
				'active_callback' => 'caldera_is_header_logo_text',
			),

			/** `Header showcase title` section */
			'showcase_title_typography'        => array(
				'title'    => esc_html__( 'Header showcase title', 'caldera' ),
				'priority' => 40,
				'panel'    => 'typography',
				'type'     => 'section',
			),
			'showcase_title_font_family'       => array(
				'title'   => esc_html__( 'Font Family', 'caldera' ),
				'section' => 'showcase_title_typography',
				'default' => 'Raleway, sans-serif',
				'field'   => 'fonts',
				'type'    => 'control',
			),
			'showcase_title_font_style'        => array(
				'title'   => esc_html__( 'Font Style', 'caldera' ),
				'section' => 'showcase_title_typography',
				'default' => 'normal',
				'field'   => 'select',
				'choices' => caldera_get_font_styles(),
				'type'    => 'control',
			),
			'showcase_title_font_weight'       => array(
				'title'   => esc_html__( 'Font Weight', 'caldera' ),
				'section' => 'showcase_title_typography',
				'default' => '400',
				'field'   => 'select',
				'choices' => caldera_get_font_weight(),
				'type'    => 'control',
			),
			'showcase_title_font_size'         => array(
				'title'       => esc_html__( 'Font Size, px', 'caldera' ),
				'section'     => 'showcase_title_typography',
				'default'     => '36',
				'field'       => 'number',
				'input_attrs' => array(
					'min'  => 10,
					'max'  => 200,
					'step' => 1,
				),
				'type'        => 'control',
			),
			'showcase_title_line_height'       => array(
				'title'       => esc_html__( 'Line Height', 'caldera' ),
				'description' => esc_html__( 'Relative to the font-size of the element', 'caldera' ),
				'section'     => 'showcase_title_typography',
				'default'     => '1.28',
				'field'       => 'number',
				'input_attrs' => array(
					'min'  => 1.0,
					'max'  => 3.0,
					'step' => 0.1,
				),
				'type'        => 'control',
			),
			'showcase_title_letter_spacing'    => array(
				'title'       => esc_html__( 'Letter Spacing, px', 'caldera' ),
				'section'     => 'showcase_title_typography',
				'default'     => '2',
				'field'       => 'number',
				'input_attrs' => array(
					'min'  => -10,
					'max'  => 10,
					'step' => 1,
				),
				'type'        => 'control',
			),
			'showcase_title_character_set'     => array(
				'title'   => esc_html__( 'Character Set', 'caldera' ),
				'section' => 'showcase_title_typography',
				'default' => 'latin',
				'field'   => 'select',
				'choices' => caldera_get_character_sets(),
				'type'    => 'control',
			),

			'showcase_title_text_transform'    => array(
				'title'   => esc_html__( 'Text transform', 'caldera' ),
				'section' => 'showcase_title_typography',
				'default' => 'none',
				'field'   => 'select',
				'choices' => caldera_get_text_transform(),
				'type'    => 'control',
			),

			/** `Header showcase subtitle` section */
			'showcase_subtitle_typography'     => array(
				'title'    => esc_html__( 'Header showcase subtitle', 'caldera' ),
				'priority' => 45,
				'panel'    => 'typography',
				'type'     => 'section',
			),
			'showcase_subtitle_font_family'    => array(
				'title'   => esc_html__( 'Font Family', 'caldera' ),
				'section' => 'showcase_subtitle_typography',
				'default' => 'Raleway, sans-serif',
				'field'   => 'fonts',
				'type'    => 'control',
			),
			'showcase_subtitle_font_style'     => array(
				'title'   => esc_html__( 'Font Style', 'caldera' ),
				'section' => 'showcase_subtitle_typography',
				'default' => 'normal',
				'field'   => 'select',
				'choices' => caldera_get_font_styles(),
				'type'    => 'control',
			),
			'showcase_subtitle_font_weight'    => array(
				'title'   => esc_html__( 'Font Weight', 'caldera' ),
				'section' => 'showcase_subtitle_typography',
				'default' => '400',
				'field'   => 'select',
				'choices' => caldera_get_font_weight(),
				'type'    => 'control',
			),
			'showcase_subtitle_font_size'      => array(
				'title'       => esc_html__( 'Font Size, px', 'caldera' ),
				'section'     => 'showcase_subtitle_typography',
				'default'     => '56',
				'field'       => 'number',
				'input_attrs' => array(
					'min'  => 10,
					'max'  => 200,
					'step' => 1,
				),
				'type'        => 'control',
			),
			'showcase_subtitle_line_height'    => array(
				'title'       => esc_html__( 'Line Height', 'caldera' ),
				'description' => esc_html__( 'Relative to the font-size of the element', 'caldera' ),
				'section'     => 'showcase_subtitle_typography',
				'default'     => '1.18',
				'field'       => 'number',
				'input_attrs' => array(
					'min'  => 1.0,
					'max'  => 3.0,
					'step' => 0.1,
				),
				'type'        => 'control',
			),
			'showcase_subtitle_letter_spacing' => array(
				'title'       => esc_html__( 'Letter Spacing, px', 'caldera' ),
				'section'     => 'showcase_subtitle_typography',
				'default'     => '3',
				'field'       => 'number',
				'input_attrs' => array(
					'min'  => -10,
					'max'  => 10,
					'step' => 1,
				),
				'type'        => 'control',
			),
			'showcase_subtitle_character_set'  => array(
				'title'   => esc_html__( 'Character Set', 'caldera' ),
				'section' => 'showcase_subtitle_typography',
				'default' => 'latin',
				'field'   => 'select',
				'choices' => caldera_get_character_sets(),
				'type'    => 'control',
			),

			'showcase_subtitle_text_transform' => array(
				'title'   => esc_html__( 'Text transform', 'caldera' ),
				'section' => 'showcase_subtitle_typography',
				'default' => 'none',
				'field'   => 'select',
				'choices' => caldera_get_text_transform(),
				'type'    => 'control',
			),

			/** `Breadcrumbs` section */
			'breadcrumbs'                      => array(
				'title'    => esc_html__( 'Breadcrumbs', 'caldera' ),
				'priority' => 30,
				'type'     => 'section',
				'panel'    => 'general_settings',
			),
			'breadcrumbs_visibillity'          => array(
				'title'   => esc_html__( 'Enable Breadcrumbs', 'caldera' ),
				'section' => 'breadcrumbs',
				'default' => false,
				'field'   => 'checkbox',
				'type'    => 'control',
			),
			'breadcrumbs_front_visibillity'    => array(
				'title'   => esc_html__( 'Enable Breadcrumbs on front page', 'caldera' ),
				'section' => 'breadcrumbs',
				'default' => false,
				'field'   => 'checkbox',
				'type'    => 'control',
			),
			'breadcrumbs_page_title'           => array(
				'title'   => esc_html__( 'Enable page title in breadcrumbs area', 'caldera' ),
				'section' => 'breadcrumbs',
				'default' => true,
				'field'   => 'checkbox',
				'type'    => 'control',
			),
			'breadcrumbs_path_type'            => array(
				'title'   => esc_html__( 'Show full/minified path', 'caldera' ),
				'section' => 'breadcrumbs',
				'default' => 'minified',
				'field'   => 'select',
				'choices' => array(
					'full'     => esc_html__( 'Full', 'caldera' ),
					'minified' => esc_html__( 'Minified', 'caldera' ),
				),
				'type'    => 'control',
			),

			/** `Social links` section */
			'social_links'                     => array(
				'title'    => esc_html__( 'Social links', 'caldera' ),
				'priority' => 50,
				'type'     => 'section',
				'panel'    => 'general_settings',
			),
			'header_social_links'              => array(
				'title'   => esc_html__( 'Show social links in header', 'caldera' ),
				'section' => 'social_links',
				'default' => true,
				'field'   => 'checkbox',
				'type'    => 'control',
			),
			'footer_social_links'              => array(
				'title'   => esc_html__( 'Show social links in footer', 'caldera' ),
				'section' => 'social_links',
				'default' => true,
				'field'   => 'checkbox',
				'type'    => 'control',
			),
			'blog_post_share_buttons'          => array(
				'title'   => esc_html__( 'Show social sharing to blog posts', 'caldera' ),
				'section' => 'social_links',
				'default' => false,
				'field'   => 'checkbox',
				'type'    => 'control',
			),
			'single_post_share_buttons'        => array(
				'title'   => esc_html__( 'Show social sharing to single blog post', 'caldera' ),
				'section' => 'social_links',
				'default' => true,
				'field'   => 'checkbox',
				'type'    => 'control',
			),

			/** `Page Layout` section */
			'page_layout'                      => array(
				'title'    => esc_html__( 'Page Layout', 'caldera' ),
				'priority' => 55,
				'type'     => 'section',
				'panel'    => 'general_settings',
			),
			'header_container_type'            => array(
				'title'   => esc_html__( 'Header type', 'caldera' ),
				'section' => 'page_layout',
				'default' => 'fullwidth',
				'field'   => 'select',
				'choices' => array(
					'boxed'     => esc_html__( 'Boxed', 'caldera' ),
					'fullwidth' => esc_html__( 'Fullwidth', 'caldera' ),
				),
				'type'    => 'control',
			),
			'content_container_type'           => array(
				'title'   => esc_html__( 'Content type', 'caldera' ),
				'section' => 'page_layout',
				'default' => 'boxed',
				'field'   => 'select',
				'choices' => array(
					'boxed'     => esc_html__( 'Boxed', 'caldera' ),
					'fullwidth' => esc_html__( 'Fullwidth', 'caldera' ),
				),
				'type'    => 'control',
			),
			'footer_container_type'            => array(
				'title'   => esc_html__( 'Footer type', 'caldera' ),
				'section' => 'page_layout',
				'default' => 'fullwidth',
				'field'   => 'select',
				'choices' => array(
					'boxed'     => esc_html__( 'Boxed', 'caldera' ),
					'fullwidth' => esc_html__( 'Fullwidth', 'caldera' ),
				),
				'type'    => 'control',
			),
			'container_width'                  => array(
				'title'       => esc_html__( 'Container width (px)', 'caldera' ),
				'section'     => 'page_layout',
				'default'     => 1760,
				'field'       => 'number',
				'input_attrs' => array(
					'min'  => 960,
					'max'  => 1920,
					'step' => 1,
				),
				'type'        => 'control',
			),
			'sidebar_width'                    => array(
				'title'             => esc_html__( 'Sidebar width', 'caldera' ),
				'section'           => 'page_layout',
				'default'           => '1/3',
				'field'             => 'select',
				'choices'           => array(
					'1/3' => '1/3',
					'1/4' => '1/4',
				),
				'sanitize_callback' => 'sanitize_text_field',
				'type'              => 'control',
			),

			/** `Color Scheme` panel */
			'color_scheme'                     => array(
				'title'       => esc_html__( 'Color Scheme', 'caldera' ),
				'description' => esc_html__( 'Configure Color Scheme', 'caldera' ),
				'priority'    => 40,
				'type'        => 'panel',
			),

			/** `Regular scheme` section */
			'regular_scheme'                   => array(
				'title'    => esc_html__( 'Regular scheme', 'caldera' ),
				'priority' => 1,
				'panel'    => 'color_scheme',
				'type'     => 'section',
			),
			'regular_accent_color_1'           => array(
				'title'   => esc_html__( 'Accent color (1)', 'caldera' ),
				'section' => 'regular_scheme',
				'default' => '#eb6f31',
				'field'   => 'hex_color',
				'type'    => 'control',
			),
			'regular_accent_color_2'           => array(
				'title'   => esc_html__( 'Accent color (2)', 'caldera' ),
				'section' => 'regular_scheme',
				'default' => '#313131',
				'field'   => 'hex_color',
				'type'    => 'control',
			),
			'regular_text_color'               => array(
				'title'   => esc_html__( 'Text color', 'caldera' ),
				'section' => 'regular_scheme',
				'default' => '#2b2b2b',
				'field'   => 'hex_color',
				'type'    => 'control',
			),
			'regular_link_color'               => array(
				'title'   => esc_html__( 'Link color', 'caldera' ),
				'section' => 'regular_scheme',
				'default' => '#eb6f31',
				'field'   => 'hex_color',
				'type'    => 'control',
			),
			'regular_link_hover_color'         => array(
				'title'   => esc_html__( 'Link hover color', 'caldera' ),
				'section' => 'regular_scheme',
				'default' => '#3c3c3c',
				'field'   => 'hex_color',
				'type'    => 'control',
			),
			'regular_h1_color'                 => array(
				'title'   => esc_html__( 'H1 color', 'caldera' ),
				'section' => 'regular_scheme',
				'default' => '#3c3c3c',
				'field'   => 'hex_color',
				'type'    => 'control',
			),
			'regular_h2_color'                 => array(
				'title'   => esc_html__( 'H2 color', 'caldera' ),
				'section' => 'regular_scheme',
				'default' => '#3c3c3c',
				'field'   => 'hex_color',
				'type'    => 'control',
			),
			'regular_h3_color'                 => array(
				'title'   => esc_html__( 'H3 color', 'caldera' ),
				'section' => 'regular_scheme',
				'default' => '#3c3c3c',
				'field'   => 'hex_color',
				'type'    => 'control',
			),
			'regular_h4_color'                 => array(
				'title'   => esc_html__( 'H4 color', 'caldera' ),
				'section' => 'regular_scheme',
				'default' => '#3c3c3c',
				'field'   => 'hex_color',
				'type'    => 'control',
			),
			'regular_h5_color'                 => array(
				'title'   => esc_html__( 'H5 color', 'caldera' ),
				'section' => 'regular_scheme',
				'default' => '#3c3c3c',
				'field'   => 'hex_color',
				'type'    => 'control',
			),
			'regular_h6_color'                 => array(
				'title'   => esc_html__( 'H6 color', 'caldera' ),
				'section' => 'regular_scheme',
				'default' => '#3c3c3c',
				'field'   => 'hex_color',
				'type'    => 'control',
			),

			/** `Invert scheme` section */
			'invert_scheme'                    => array(
				'title'    => esc_html__( 'Invert scheme', 'caldera' ),
				'priority' => 1,
				'panel'    => 'color_scheme',
				'type'     => 'section',
			),
			'invert_accent_color_1'            => array(
				'title'   => esc_html__( 'Accent color (1)', 'caldera' ),
				'section' => 'invert_scheme',
				'default' => '#fff',
				'field'   => 'hex_color',
				'type'    => 'control',
			),
			'invert_accent_color_2'            => array(
				'title'   => esc_html__( 'Accent color (2)', 'caldera' ),
				'section' => 'invert_scheme',
				'default' => '#313131',
				'field'   => 'hex_color',
				'type'    => 'control',
			),
			'invert_accent_color_3'            => array(
				'title'   => esc_html__( 'Accent color (3)', 'caldera' ),
				'section' => 'invert_scheme',
				'default' => '#e5e5e6',
				'field'   => 'hex_color',
				'type'    => 'control',
			),
			'invert_text_color'                => array(
				'title'   => esc_html__( 'Text color', 'caldera' ),
				'section' => 'invert_scheme',
				'default' => '#fff',
				'field'   => 'hex_color',
				'type'    => 'control',
			),
			'invert_link_color'                => array(
				'title'   => esc_html__( 'Link color', 'caldera' ),
				'section' => 'invert_scheme',
				'default' => '#fff',
				'field'   => 'hex_color',
				'type'    => 'control',
			),
			'invert_link_hover_color'          => array(
				'title'   => esc_html__( 'Link hover color', 'caldera' ),
				'section' => 'invert_scheme',
				'default' => '#eb6f31',
				'field'   => 'hex_color',
				'type'    => 'control',
			),
			'invert_h1_color'                  => array(
				'title'   => esc_html__( 'H1 color', 'caldera' ),
				'section' => 'invert_scheme',
				'default' => '#fff',
				'field'   => 'hex_color',
				'type'    => 'control',
			),
			'invert_h2_color'                  => array(
				'title'   => esc_html__( 'H2 color', 'caldera' ),
				'section' => 'invert_scheme',
				'default' => '#fff',
				'field'   => 'hex_color',
				'type'    => 'control',
			),
			'invert_h3_color'                  => array(
				'title'   => esc_html__( 'H3 color', 'caldera' ),
				'section' => 'invert_scheme',
				'default' => '#fff',
				'field'   => 'hex_color',
				'type'    => 'control',
			),
			'invert_h4_color'                  => array(
				'title'   => esc_html__( 'H4 color', 'caldera' ),
				'section' => 'invert_scheme',
				'default' => '#ffffff',
				'field'   => 'hex_color',
				'type'    => 'control',
			),
			'invert_h5_color'                  => array(
				'title'   => esc_html__( 'H5 color', 'caldera' ),
				'section' => 'invert_scheme',
				'default' => '#fff',
				'field'   => 'hex_color',
				'type'    => 'control',
			),
			'invert_h6_color'                  => array(
				'title'   => esc_html__( 'H6 color', 'caldera' ),
				'section' => 'invert_scheme',
				'default' => '#fff',
				'field'   => 'hex_color',
				'type'    => 'control',
			),

			/** `Typography Settings` panel */
			'typography'                       => array(
				'title'       => esc_html__( 'Typography', 'caldera' ),
				'description' => esc_html__( 'Configure typography settings', 'caldera' ),
				'priority'    => 45,
				'type'        => 'panel',
			),

			/** `Body text` section */
			'body_typography'                  => array(
				'title'    => esc_html__( 'Body text', 'caldera' ),
				'priority' => 5,
				'panel'    => 'typography',
				'type'     => 'section',
			),
			'body_font_family'                 => array(
				'title'   => esc_html__( 'Font Family', 'caldera' ),
				'section' => 'body_typography',
				'default' => 'Open Sans, sans-serif',
				'field'   => 'fonts',
				'type'    => 'control',
			),
			'body_font_style'                  => array(
				'title'   => esc_html__( 'Font Style', 'caldera' ),
				'section' => 'body_typography',
				'default' => 'normal',
				'field'   => 'select',
				'choices' => caldera_get_font_styles(),
				'type'    => 'control',
			),
			'body_font_weight'                 => array(
				'title'   => esc_html__( 'Font Weight', 'caldera' ),
				'section' => 'body_typography',
				'default' => '300',
				'field'   => 'select',
				'choices' => caldera_get_font_weight(),
				'type'    => 'control',
			),
			'body_font_size'                   => array(
				'title'       => esc_html__( 'Font Size, px', 'caldera' ),
				'section'     => 'body_typography',
				'default'     => '16',
				'field'       => 'number',
				'input_attrs' => array(
					'min'  => 6,
					'max'  => 50,
					'step' => 1,
				),
				'type'        => 'control',
			),
			'body_line_height'                 => array(
				'title'       => esc_html__( 'Line Height', 'caldera' ),
				'description' => esc_html__( 'Relative to the font-size of the element', 'caldera' ),
				'section'     => 'body_typography',
				'default'     => '1.625',
				'field'       => 'number',
				'input_attrs' => array(
					'min'  => 1.0,
					'max'  => 3.0,
					'step' => 0.1,
				),
				'type'        => 'control',
			),
			'body_letter_spacing'              => array(
				'title'       => esc_html__( 'Letter Spacing, px', 'caldera' ),
				'section'     => 'body_typography',
				'default'     => '0',
				'field'       => 'number',
				'input_attrs' => array(
					'min'  => -10,
					'max'  => 10,
					'step' => 1,
				),
				'type'        => 'control',
			),
			'body_character_set'               => array(
				'title'   => esc_html__( 'Character Set', 'caldera' ),
				'section' => 'body_typography',
				'default' => 'latin',
				'field'   => 'select',
				'choices' => caldera_get_character_sets(),
				'type'    => 'control',
			),
			'body_text_align'                  => array(
				'title'   => esc_html__( 'Text Align', 'caldera' ),
				'section' => 'body_typography',
				'default' => 'left',
				'field'   => 'select',
				'choices' => caldera_get_text_aligns(),
				'type'    => 'control',
			),

			/** `H1 Heading` section */
			'h1_typography'                    => array(
				'title'    => esc_html__( 'H1 Heading', 'caldera' ),
				'priority' => 10,
				'panel'    => 'typography',
				'type'     => 'section',
			),
			'h1_font_family'                   => array(
				'title'   => esc_html__( 'Font Family', 'caldera' ),
				'section' => 'h1_typography',
				'default' => 'Open Sans, sans-serif',
				'field'   => 'fonts',
				'type'    => 'control',
			),
			'h1_font_style'                    => array(
				'title'   => esc_html__( 'Font Style', 'caldera' ),
				'section' => 'h1_typography',
				'default' => 'normal',
				'field'   => 'select',
				'choices' => caldera_get_font_styles(),
				'type'    => 'control',
			),
			'h1_font_weight'                   => array(
				'title'   => esc_html__( 'Font Weight', 'caldera' ),
				'section' => 'h1_typography',
				'default' => '600',
				'field'   => 'select',
				'choices' => caldera_get_font_weight(),
				'type'    => 'control',
			),
			'h1_font_size'                     => array(
				'title'       => esc_html__( 'Font Size, px', 'caldera' ),
				'section'     => 'h1_typography',
				'default'     => '175',
				'field'       => 'number',
				'input_attrs' => array(
					'min'  => 10,
					'max'  => 200,
					'step' => 1,
				),
				'type'        => 'control',
			),
			'h1_line_height'                   => array(
				'title'       => esc_html__( 'Line Height', 'caldera' ),
				'description' => esc_html__( 'Relative to the font-size of the element', 'caldera' ),
				'section'     => 'h1_typography',
				'default'     => '1.029',
				'field'       => 'number',
				'input_attrs' => array(
					'min'  => 1.0,
					'max'  => 3.0,
					'step' => 0.1,
				),
				'type'        => 'control',
			),
			'h1_letter_spacing'                => array(
				'title'       => esc_html__( 'Letter Spacing, px', 'caldera' ),
				'section'     => 'h1_typography',
				'default'     => '7',
				'field'       => 'number',
				'input_attrs' => array(
					'min'  => -10,
					'max'  => 10,
					'step' => 1,
				),
				'type'        => 'control',
			),
			'h1_character_set'                 => array(
				'title'   => esc_html__( 'Character Set', 'caldera' ),
				'section' => 'h1_typography',
				'default' => 'latin',
				'field'   => 'select',
				'choices' => caldera_get_character_sets(),
				'type'    => 'control',
			),
			'h1_text_align'                    => array(
				'title'   => esc_html__( 'Text Align', 'caldera' ),
				'section' => 'h1_typography',
				'default' => 'inherit',
				'field'   => 'select',
				'choices' => caldera_get_text_aligns(),
				'type'    => 'control',
			),

			/** `H2 Heading` section */
			'h2_typography'                    => array(
				'title'    => esc_html__( 'H2 Heading', 'caldera' ),
				'priority' => 15,
				'panel'    => 'typography',
				'type'     => 'section',
			),
			'h2_font_family'                   => array(
				'title'   => esc_html__( 'Font Family', 'caldera' ),
				'section' => 'h2_typography',
				'default' => 'Open Sans, sans-serif',
				'field'   => 'fonts',
				'type'    => 'control',
			),
			'h2_font_style'                    => array(
				'title'   => esc_html__( 'Font Style', 'caldera' ),
				'section' => 'h2_typography',
				'default' => 'normal',
				'field'   => 'select',
				'choices' => caldera_get_font_styles(),
				'type'    => 'control',
			),
			'h2_font_weight'                   => array(
				'title'   => esc_html__( 'Font Weight', 'caldera' ),
				'section' => 'h2_typography',
				'default' => '600',
				'field'   => 'select',
				'choices' => caldera_get_font_weight(),
				'type'    => 'control',
			),
			'h2_font_size'                     => array(
				'title'       => esc_html__( 'Font Size, px', 'caldera' ),
				'section'     => 'h2_typography',
				'default'     => '80',
				'field'       => 'number',
				'input_attrs' => array(
					'min'  => 10,
					'max'  => 200,
					'step' => 1,
				),
				'type'        => 'control',
			),
			'h2_line_height'                   => array(
				'title'       => esc_html__( 'Line Height', 'caldera' ),
				'description' => esc_html__( 'Relative to the font-size of the element', 'caldera' ),
				'section'     => 'h2_typography',
				'default'     => '1.25',
				'field'       => 'number',
				'input_attrs' => array(
					'min'  => 1.0,
					'max'  => 3.0,
					'step' => 0.1,
				),
				'type'        => 'control',
			),
			'h2_letter_spacing'                => array(
				'title'       => esc_html__( 'Letter Spacing, px', 'caldera' ),
				'section'     => 'h2_typography',
				'default'     => '3',
				'field'       => 'number',
				'input_attrs' => array(
					'min'  => -10,
					'max'  => 10,
					'step' => 1,
				),
				'type'        => 'control',
			),
			'h2_character_set'                 => array(
				'title'   => esc_html__( 'Character Set', 'caldera' ),
				'section' => 'h2_typography',
				'default' => 'latin',
				'field'   => 'select',
				'choices' => caldera_get_character_sets(),
				'type'    => 'control',
			),
			'h2_text_align'                    => array(
				'title'   => esc_html__( 'Text Align', 'caldera' ),
				'section' => 'h2_typography',
				'default' => 'inherit',
				'field'   => 'select',
				'choices' => caldera_get_text_aligns(),
				'type'    => 'control',
			),

			/** `H3 Heading` section */
			'h3_typography'                    => array(
				'title'    => esc_html__( 'H3 Heading', 'caldera' ),
				'priority' => 20,
				'panel'    => 'typography',
				'type'     => 'section',
			),
			'h3_font_family'                   => array(
				'title'   => esc_html__( 'Font Family', 'caldera' ),
				'section' => 'h3_typography',
				'default' => 'Raleway, sans-serif',
				'field'   => 'fonts',
				'type'    => 'control',
			),
			'h3_font_style'                    => array(
				'title'   => esc_html__( 'Font Style', 'caldera' ),
				'section' => 'h3_typography',
				'default' => 'normal',
				'field'   => 'select',
				'choices' => caldera_get_font_styles(),
				'type'    => 'control',
			),
			'h3_font_weight'                   => array(
				'title'   => esc_html__( 'Font Weight', 'caldera' ),
				'section' => 'h3_typography',
				'default' => '600',
				'field'   => 'select',
				'choices' => caldera_get_font_weight(),
				'type'    => 'control',
			),
			'h3_font_size'                     => array(
				'title'       => esc_html__( 'Font Size, px', 'caldera' ),
				'section'     => 'h3_typography',
				'default'     => '56',
				'field'       => 'number',
				'input_attrs' => array(
					'min'  => 10,
					'max'  => 200,
					'step' => 1,
				),
				'type'        => 'control',
			),
			'h3_line_height'                   => array(
				'title'       => esc_html__( 'Line Height', 'caldera' ),
				'description' => esc_html__( 'Relative to the font-size of the element', 'caldera' ),
				'section'     => 'h3_typography',
				'default'     => '1.179',
				'field'       => 'number',
				'input_attrs' => array(
					'min'  => 1.0,
					'max'  => 3.0,
					'step' => 0.1,
				),
				'type'        => 'control',
			),
			'h3_letter_spacing'                => array(
				'title'       => esc_html__( 'Letter Spacing, px', 'caldera' ),
				'section'     => 'h3_typography',
				'default'     => '3',
				'field'       => 'number',
				'input_attrs' => array(
					'min'  => -10,
					'max'  => 10,
					'step' => 1,
				),
				'type'        => 'control',
			),
			'h3_character_set'                 => array(
				'title'   => esc_html__( 'Character Set', 'caldera' ),
				'section' => 'h3_typography',
				'default' => 'latin',
				'field'   => 'select',
				'choices' => caldera_get_character_sets(),
				'type'    => 'control',
			),
			'h3_text_align'                    => array(
				'title'   => esc_html__( 'Text Align', 'caldera' ),
				'section' => 'h3_typography',
				'default' => 'inherit',
				'field'   => 'select',
				'choices' => caldera_get_text_aligns(),
				'type'    => 'control',
			),

			/** `H4 Heading` section */
			'h4_typography'                    => array(
				'title'    => esc_html__( 'H4 Heading', 'caldera' ),
				'priority' => 25,
				'panel'    => 'typography',
				'type'     => 'section',
			),
			'h4_font_family'                   => array(
				'title'   => esc_html__( 'Font Family', 'caldera' ),
				'section' => 'h4_typography',
				'default' => 'Raleway, sans-serif',
				'field'   => 'fonts',
				'type'    => 'control',
			),
			'h4_font_style'                    => array(
				'title'   => esc_html__( 'Font Style', 'caldera' ),
				'section' => 'h4_typography',
				'default' => 'normal',
				'field'   => 'select',
				'choices' => caldera_get_font_styles(),
				'type'    => 'control',
			),
			'h4_font_weight'                   => array(
				'title'   => esc_html__( 'Font Weight', 'caldera' ),
				'section' => 'h4_typography',
				'default' => '500',
				'field'   => 'select',
				'choices' => caldera_get_font_weight(),
				'type'    => 'control',
			),
			'h4_font_size'                     => array(
				'title'       => esc_html__( 'Font Size, px', 'caldera' ),
				'section'     => 'h4_typography',
				'default'     => '36',
				'field'       => 'number',
				'input_attrs' => array(
					'min'  => 10,
					'max'  => 200,
					'step' => 1,
				),
				'type'        => 'control',
			),
			'h4_line_height'                   => array(
				'title'       => esc_html__( 'Line Height', 'caldera' ),
				'description' => esc_html__( 'Relative to the font-size of the element', 'caldera' ),
				'section'     => 'h4_typography',
				'default'     => '1.28',
				'field'       => 'number',
				'input_attrs' => array(
					'min'  => 1.0,
					'max'  => 3.0,
					'step' => 0.1,
				),
				'type'        => 'control',
			),
			'h4_letter_spacing'                => array(
				'title'       => esc_html__( 'Letter Spacing, px', 'caldera' ),
				'section'     => 'h4_typography',
				'default'     => '2',
				'field'       => 'number',
				'input_attrs' => array(
					'min'  => -10,
					'max'  => 10,
					'step' => 1,
				),
				'type'        => 'control',
			),
			'h4_character_set'                 => array(
				'title'   => esc_html__( 'Character Set', 'caldera' ),
				'section' => 'h4_typography',
				'default' => 'latin',
				'field'   => 'select',
				'choices' => caldera_get_character_sets(),
				'type'    => 'control',
			),
			'h4_text_align'                    => array(
				'title'   => esc_html__( 'Text Align', 'caldera' ),
				'section' => 'h4_typography',
				'default' => 'inherit',
				'field'   => 'select',
				'choices' => caldera_get_text_aligns(),
				'type'    => 'control',
			),

			/** `H5 Heading` section */
			'h5_typography'                    => array(
				'title'    => esc_html__( 'H5 Heading', 'caldera' ),
				'priority' => 30,
				'panel'    => 'typography',
				'type'     => 'section',
			),
			'h5_font_family'                   => array(
				'title'   => esc_html__( 'Font Family', 'caldera' ),
				'section' => 'h5_typography',
				'default' => 'Raleway, sans-serif',
				'field'   => 'fonts',
				'type'    => 'control',
			),
			'h5_font_style'                    => array(
				'title'   => esc_html__( 'Font Style', 'caldera' ),
				'section' => 'h5_typography',
				'default' => 'normal',
				'field'   => 'select',
				'choices' => caldera_get_font_styles(),
				'type'    => 'control',
			),
			'h5_font_weight'                   => array(
				'title'   => esc_html__( 'Font Weight', 'caldera' ),
				'section' => 'h5_typography',
				'default' => '600',
				'field'   => 'select',
				'choices' => caldera_get_font_weight(),
				'type'    => 'control',
			),
			'h5_font_size'                     => array(
				'title'       => esc_html__( 'Font Size, px', 'caldera' ),
				'section'     => 'h5_typography',
				'default'     => '23',
				'field'       => 'number',
				'input_attrs' => array(
					'min'  => 10,
					'max'  => 200,
					'step' => 1,
				),
				'type'        => 'control',
			),
			'h5_line_height'                   => array(
				'title'       => esc_html__( 'Line Height', 'caldera' ),
				'description' => esc_html__( 'Relative to the font-size of the element', 'caldera' ),
				'section'     => 'h5_typography',
				'default'     => '1.58',
				'field'       => 'number',
				'input_attrs' => array(
					'min'  => 1.0,
					'max'  => 3.0,
					'step' => 0.1,
				),
				'type'        => 'control',
			),
			'h5_letter_spacing'                => array(
				'title'       => esc_html__( 'Letter Spacing, px', 'caldera' ),
				'section'     => 'h5_typography',
				'default'     => '1',
				'field'       => 'number',
				'input_attrs' => array(
					'min'  => -10,
					'max'  => 10,
					'step' => 1,
				),
				'type'        => 'control',
			),
			'h5_character_set'                 => array(
				'title'   => esc_html__( 'Character Set', 'caldera' ),
				'section' => 'h5_typography',
				'default' => 'latin',
				'field'   => 'select',
				'choices' => caldera_get_character_sets(),
				'type'    => 'control',
			),
			'h5_text_align'                    => array(
				'title'   => esc_html__( 'Text Align', 'caldera' ),
				'section' => 'h5_typography',
				'default' => 'inherit',
				'field'   => 'select',
				'choices' => caldera_get_text_aligns(),
				'type'    => 'control',
			),

			/** `H6 Heading` section */
			'h6_typography'                    => array(
				'title'    => esc_html__( 'H6 Heading', 'caldera' ),
				'priority' => 35,
				'panel'    => 'typography',
				'type'     => 'section',
			),
			'h6_font_family'                   => array(
				'title'   => esc_html__( 'Font Family', 'caldera' ),
				'section' => 'h6_typography',
				'default' => 'Raleway, sans-serif',
				'field'   => 'fonts',
				'type'    => 'control',
			),
			'h6_font_style'                    => array(
				'title'   => esc_html__( 'Font Style', 'caldera' ),
				'section' => 'h6_typography',
				'default' => 'normal',
				'field'   => 'select',
				'choices' => caldera_get_font_styles(),
				'type'    => 'control',
			),
			'h6_font_weight'                   => array(
				'title'   => esc_html__( 'Font Weight', 'caldera' ),
				'section' => 'h6_typography',
				'default' => '600',
				'field'   => 'select',
				'choices' => caldera_get_font_weight(),
				'type'    => 'control',
			),
			'h6_font_size'                     => array(
				'title'       => esc_html__( 'Font Size, px', 'caldera' ),
				'section'     => 'h6_typography',
				'default'     => '17',
				'field'       => 'number',
				'input_attrs' => array(
					'min'  => 10,
					'max'  => 200,
					'step' => 1,
				),
				'type'        => 'control',
			),
			'h6_line_height'                   => array(
				'title'       => esc_html__( 'Line Height', 'caldera' ),
				'description' => esc_html__( 'Relative to the font-size of the element', 'caldera' ),
				'section'     => 'h6_typography',
				'default'     => '1.58',
				'field'       => 'number',
				'input_attrs' => array(
					'min'  => 1.0,
					'max'  => 3.0,
					'step' => 0.1,
				),
				'type'        => 'control',
			),
			'h6_letter_spacing'                => array(
				'title'       => esc_html__( 'Letter Spacing, px', 'caldera' ),
				'section'     => 'h6_typography',
				'default'     => '0',
				'field'       => 'number',
				'input_attrs' => array(
					'min'  => -10,
					'max'  => 10,
					'step' => 1,
				),
				'type'        => 'control',
			),
			'h6_character_set'                 => array(
				'title'   => esc_html__( 'Character Set', 'caldera' ),
				'section' => 'h6_typography',
				'default' => 'latin',
				'field'   => 'select',
				'choices' => caldera_get_character_sets(),
				'type'    => 'control',
			),
			'h6_text_align'                    => array(
				'title'   => esc_html__( 'Text Align', 'caldera' ),
				'section' => 'h6_typography',
				'default' => 'inherit',
				'field'   => 'select',
				'choices' => caldera_get_text_aligns(),
				'type'    => 'control',
			),

			/** `Breadcrumbs` section */
			'breadcrumbs_typography'           => array(
				'title'    => esc_html__( 'Breadcrumbs', 'caldera' ),
				'priority' => 45,
				'panel'    => 'typography',
				'type'     => 'section',
			),
			'breadcrumbs_font_family'          => array(
				'title'   => esc_html__( 'Font Family', 'caldera' ),
				'section' => 'breadcrumbs_typography',
				'default' => 'Poppins, sans-serif',
				'field'   => 'fonts',
				'type'    => 'control',
			),
			'breadcrumbs_font_style'           => array(
				'title'   => esc_html__( 'Font Style', 'caldera' ),
				'section' => 'breadcrumbs_typography',
				'default' => 'normal',
				'field'   => 'select',
				'choices' => caldera_get_font_styles(),
				'type'    => 'control',
			),
			'breadcrumbs_font_weight'          => array(
				'title'   => esc_html__( 'Font Weight', 'caldera' ),
				'section' => 'breadcrumbs_typography',
				'default' => '300',
				'field'   => 'select',
				'choices' => caldera_get_font_weight(),
				'type'    => 'control',
			),
			'breadcrumbs_font_size'            => array(
				'title'       => esc_html__( 'Font Size, px', 'caldera' ),
				'section'     => 'breadcrumbs_typography',
				'default'     => '13',
				'field'       => 'number',
				'input_attrs' => array(
					'min'  => 6,
					'max'  => 50,
					'step' => 1,
				),
				'type'        => 'control',
			),
			'breadcrumbs_line_height'          => array(
				'title'       => esc_html__( 'Line Height', 'caldera' ),
				'description' => esc_html__( 'Relative to the font-size of the element', 'caldera' ),
				'section'     => 'breadcrumbs_typography',
				'default'     => '1.6',
				'field'       => 'number',
				'input_attrs' => array(
					'min'  => 1.0,
					'max'  => 3.0,
					'step' => 0.1,
				),
				'type'        => 'control',
			),
			'breadcrumbs_letter_spacing'       => array(
				'title'       => esc_html__( 'Letter Spacing, px', 'caldera' ),
				'section'     => 'breadcrumbs_typography',
				'default'     => '0',
				'field'       => 'number',
				'input_attrs' => array(
					'min'  => -10,
					'max'  => 10,
					'step' => 1,
				),
				'type'        => 'control',
			),
			'breadcrumbs_character_set'        => array(
				'title'   => esc_html__( 'Character Set', 'caldera' ),
				'section' => 'breadcrumbs_typography',
				'default' => 'latin',
				'field'   => 'select',
				'choices' => caldera_get_character_sets(),
				'type'    => 'control',
			),

			/** `Header` panel */
			'header_options'                   => array(
				'title'    => esc_html__( 'Header', 'caldera' ),
				'priority' => 60,
				'type'     => 'panel',
			),

			/** `Header styles` section */
			'header_styles'                    => array(
				'title'    => esc_html__( 'Styles', 'caldera' ),
				'priority' => 5,
				'panel'    => 'header_options',
				'type'     => 'section',
			),
			'header_bg_color'                  => array(
				'title'   => esc_html__( 'Background Color', 'caldera' ),
				'section' => 'header_styles',
				'field'   => 'hex_color',
				'default' => '#313131',
				'type'    => 'control',
			),
			'header_bg_image'                  => array(
				'title'   => esc_html__( 'Background Image', 'caldera' ),
				'section' => 'header_styles',
				'field'   => 'image',
				'default' => '%s/assets/images/header-bg.jpg',
				'type'    => 'control',
			),
			'header_bg_repeat'                 => array(
				'title'   => esc_html__( 'Background Repeat', 'caldera' ),
				'section' => 'header_styles',
				'default' => 'repeat',
				'field'   => 'select',
				'choices' => array(
					'no-repeat' => esc_html__( 'No Repeat', 'caldera' ),
					'repeat'    => esc_html__( 'Tile', 'caldera' ),
					'repeat-x'  => esc_html__( 'Tile Horizontally', 'caldera' ),
					'repeat-y'  => esc_html__( 'Tile Vertically', 'caldera' ),
				),
				'type'    => 'control',
			),
			'header_bg_position_x'             => array(
				'title'   => esc_html__( 'Background Position', 'caldera' ),
				'section' => 'header_styles',
				'default' => 'left',
				'field'   => 'select',
				'choices' => array(
					'left'   => esc_html__( 'Left', 'caldera' ),
					'center' => esc_html__( 'Center', 'caldera' ),
					'right'  => esc_html__( 'Right', 'caldera' ),
				),
				'type'    => 'control',
			),
			'header_bg_attachment'             => array(
				'title'   => esc_html__( 'Background Attachment', 'caldera' ),
				'section' => 'header_styles',
				'default' => 'scroll',
				'field'   => 'select',
				'choices' => array(
					'scroll' => esc_html__( 'Scroll', 'caldera' ),
					'fixed'  => esc_html__( 'Fixed', 'caldera' ),
				),
				'type'    => 'control',
			),
			'header_layout_type'               => array(
				'title'   => esc_html__( 'Layout', 'caldera' ),
				'section' => 'header_styles',
				'default' => 'centered',
				'field'   => 'select',
				'choices' => array(
					'minimal'  => esc_html__( 'Style 1', 'caldera' ),
					'centered' => esc_html__( 'Style 2', 'caldera' ),
					'default'  => esc_html__( 'Style 3', 'caldera' ),
				),
				'type'    => 'control',
			),

			/** `Top Panel` section */
			'header_top_panel'                 => array(
				'title'    => esc_html__( 'Top Panel', 'caldera' ),
				'priority' => 10,
				'panel'    => 'header_options',
				'type'     => 'section',
			),
			'top_panel_text'                   => array(
				'title'       => esc_html__( 'Disclaimer Text', 'caldera' ),
				'description' => esc_html__( 'HTML formatting support', 'caldera' ),
				'section'     => 'header_top_panel',
				'default'     => caldera_get_default_top_panel_text(),
				'field'       => 'textarea',
				'type'        => 'control',
			),
			'top_panel_search'                 => array(
				'title'   => esc_html__( 'Enable search', 'caldera' ),
				'section' => 'header_main_menu',
				'default' => true,
				'field'   => 'checkbox',
				'type'    => 'control',
			),
			'top_panel_bg'                     => array(
				'title'   => esc_html__( 'Background color', 'caldera' ),
				'section' => 'header_top_panel',
				'default' => '#313131',
				'field'   => 'hex_color',
				'type'    => 'control',
			),

			/** `Header Showcase` section */
			'header_showcase_panel'            => array(
				'title'    => esc_html__( 'Showcase Panel', 'caldera' ),
				'priority' => 15,
				'panel'    => 'header_options',
				'type'     => 'section',
			),

			'header_showcase_title'            => array(
				'title'   => esc_html__( 'Header showcase title', 'caldera' ),
				'section' => 'header_showcase_panel',
				'default' => esc_html__( 'We are never afraid of technical challenges…', 'caldera' ),
				'field'   => 'text',
				'type'    => 'control'
			),

			'header_showcase_subtitle'         => array(
				'title'   => esc_html__( 'Header showcase subtitle', 'caldera' ),
				'section' => 'header_showcase_panel',
				'default' => esc_html__( 'Just see our most recent steelworks projects!', 'caldera' ),
				'field'   => 'text',
				'type'    => 'control'
			),

			'header_showcase_description'      => array(
				'title'   => esc_html__( 'Header showcase description', 'caldera' ),
				'section' => 'header_showcase_panel',
				'default' => caldera_get_default_showcase_description(),
				'field'   => 'textarea',
				'type'    => 'control'
			),

			'header_showcase_btn_text'         => array(
				'title'   => esc_html__( 'Header showcase button text(leave empty to hide button)', 'caldera' ),
				'section' => 'header_showcase_panel',
				'default' => esc_html__( 'View our project', 'caldera' ),
				'field'   => 'text',
				'type'    => 'control'
			),

			'header_showcase_btn_url'          => array(
				'title'   => esc_html__( 'Header showcase button url', 'caldera' ),
				'section' => 'header_showcase_panel',
				'default' => caldera_get_default_showcase_btn_url(),
				'field'   => 'text',
				'type'    => 'control'
			),

			'header_showcase_bg_image'         => array(
				'title'   => esc_html__( 'Background Image', 'caldera' ),
				'section' => 'header_showcase_panel',
				'field'   => 'image',
				'default' => '%s/assets/images/showcase_bg.jpg',
				'type'    => 'control',
			),

			'header_showcase_bg_color'         => array(
				'title'   => esc_html__( 'Background Color', 'caldera' ),
				'section' => 'header_showcase_panel',
				'field'   => 'hex_color',
				'default' => '#313131',
				'type'    => 'control',
			),

			'header_showcase_bg_repeat'        => array(
				'title'   => esc_html__( 'Background Repeat', 'caldera' ),
				'section' => 'header_showcase_panel',
				'default' => 'no-repeat',
				'field'   => 'select',
				'choices' => array(
					'no-repeat' => esc_html__( 'No Repeat', 'caldera' ),
					'repeat'    => esc_html__( 'Tile', 'caldera' ),
					'repeat-x'  => esc_html__( 'Tile Horizontally', 'caldera' ),
					'repeat-y'  => esc_html__( 'Tile Vertically', 'caldera' ),
				),
				'type'    => 'control',
			),

			'header_showcase_bg_position_x'    => array(
				'title'   => esc_html__( 'Background Position', 'caldera' ),
				'section' => 'header_showcase_panel',
				'default' => 'center',
				'field'   => 'select',
				'choices' => array(
					'left'   => esc_html__( 'Left', 'caldera' ),
					'center' => esc_html__( 'Center', 'caldera' ),
					'right'  => esc_html__( 'Right', 'caldera' ),
				),
				'type'    => 'control',
			),

			'header_showcase_bg_attachment'    => array(
				'title'   => esc_html__( 'Background Attachment', 'caldera' ),
				'section' => 'header_showcase_panel',
				'default' => 'scroll',
				'field'   => 'select',
				'choices' => array(
					'scroll' => esc_html__( 'Scroll', 'caldera' ),
					'fixed'  => esc_html__( 'Fixed', 'caldera' ),
				),
				'type'    => 'control',
			),

			'header_showcase_color_mask'       => array(
				'title'   => esc_html__( 'Color Image Mask', 'caldera' ),
				'section' => 'header_showcase_panel',
				'field'   => 'hex_color',
				'default' => '#000000',
				'type'    => 'control',
			),

			'header_showcase_opacity_mask'     => array(
				'title'       => esc_html__( 'Opacity Image Mask', 'caldera' ),
				'section'     => 'header_showcase_panel',
				'default'     => '0',
				'field'       => 'number',
				'input_attrs' => array(
					'min'  => 0,
					'max'  => 100,
					'step' => 1,
				),
				'type'        => 'control',
			),

			'showcase_title_color'             => array(
				'title'   => esc_html__( 'Showcase title color', 'caldera' ),
				'section' => 'header_showcase_panel',
				'default' => '#ffffff',
				'field'   => 'hex_color',
				'type'    => 'control',
			),

			'showcase_subtitle_color'          => array(
				'title'   => esc_html__( 'Showcase subtitle color', 'caldera' ),
				'section' => 'header_showcase_panel',
				'default' => '#ffffff',
				'field'   => 'hex_color',
				'type'    => 'control',
			),

			'showcase_description_color'       => array(
				'title'   => esc_html__( 'Showcase description color', 'caldera' ),
				'section' => 'header_showcase_panel',
				'default' => '#ffffff',
				'field'   => 'hex_color',
				'type'    => 'control',
			),

			/** `Main Menu` section */
			'header_main_menu'                 => array(
				'title'    => esc_html__( 'Main Menu', 'caldera' ),
				'priority' => 15,
				'panel'    => 'header_options',
				'type'     => 'section',
			),
			'header_menu_sticky'               => array(
				'title'   => esc_html__( 'Enable sticky menu', 'caldera' ),
				'section' => 'header_main_menu',
				'default' => false,
				'field'   => 'checkbox',
				'type'    => 'control',
			),
			'header_menu_attributes'           => array(
				'title'   => esc_html__( 'Enable title attributes', 'caldera' ),
				'section' => 'header_main_menu',
				'default' => true,
				'field'   => 'checkbox',
				'type'    => 'control',
			),
			'more_button_type'                 => array(
				'title'   => esc_html__( 'More Menu Button Type', 'caldera' ),
				'section' => 'header_main_menu',
				'default' => 'text',
				'field'   => 'radio',
				'choices' => array(
					'image' => esc_html__( 'Image', 'caldera' ),
					'icon'  => esc_html__( 'Icon', 'caldera' ),
					'text'  => esc_html__( 'Text', 'caldera' ),
				),
				'type'    => 'control',
			),
			'more_button_text'                 => array(
				'title'           => esc_html__( 'More Menu Button Text', 'caldera' ),
				'section'         => 'header_main_menu',
				'default'         => esc_html__( '...', 'caldera' ),
				'field'           => 'input',
				'type'            => 'control',
				'active_callback' => 'caldera_is_more_button_type_text',
			),
			'more_button_icon'                 => array(
				'title'           => esc_html__( 'More Menu Button Icon', 'caldera' ),
				'section'         => 'header_main_menu',
				'field'           => 'iconpicker',
				'type'            => 'control',
				'active_callback' => 'caldera_is_more_button_type_icon',
				'icon_data'       => array(
					'icon_set'    => 'moreButtonFontAwesome',
					'icon_css'    => CALDERA_THEME_URI . '/assets/css/font-awesome.min.css',
					'icon_base'   => 'fa',
					'icon_prefix' => 'fa-',
					'icons'       => caldera_get_icons_set(),
				),
			),
			'more_button_image_url'            => array(
				'title'           => esc_html__( 'More Button Image Upload', 'caldera' ),
				'description'     => esc_html__( 'Upload More Button image', 'caldera' ),
				'section'         => 'header_main_menu',
				'default'         => ' ',
				'field'           => 'image',
				'type'            => 'control',
				'active_callback' => 'caldera_is_more_button_type_image',
			),
			'retina_more_button_image_url'     => array(
				'title'           => esc_html__( 'Retina More Button Image Upload', 'caldera' ),
				'description'     => esc_html__( 'Upload More Button image for retina-ready devices', 'caldera' ),
				'section'         => 'header_main_menu',
				'field'           => 'image',
				'type'            => 'control',
				'active_callback' => 'caldera_is_more_button_type_image',
			),

			/** `Sidebar` section */
			'sidebar_settings'                 => array(
				'title'    => esc_html__( 'Sidebar', 'caldera' ),
				'priority' => 105,
				'type'     => 'section',
			),
			'sidebar_position'                 => array(
				'title'   => esc_html__( 'Sidebar Position', 'caldera' ),
				'section' => 'sidebar_settings',
				'default' => 'one-right-sidebar',
				'field'   => 'select',
				'choices' => array(
					'one-left-sidebar'  => esc_html__( 'Sidebar on left side', 'caldera' ),
					'one-right-sidebar' => esc_html__( 'Sidebar on right side', 'caldera' ),
					'two-sidebars'      => esc_html__( '2 sidebars', 'caldera' ),
					'fullwidth'         => esc_html__( 'No sidebars', 'caldera' ),
				),
				'type'    => 'control',
			),

			/** `MailChimp` section */
			'mailchimp'                        => array(
				'title'       => esc_html__( 'MailChimp', 'caldera' ),
				'description' => esc_html__( 'Setup MailChimp settings for subscribe widget', 'caldera' ),
				'priority'    => 109,
				'type'        => 'section',
			),
			'mailchimp_api_key'                => array(
				'title'   => esc_html__( 'MailChimp API key', 'caldera' ),
				'section' => 'mailchimp',
				'field'   => 'text',
				'type'    => 'control',
			),
			'mailchimp_list_id'                => array(
				'title'   => esc_html__( 'MailChimp list ID', 'caldera' ),
				'section' => 'mailchimp',
				'field'   => 'text',
				'type'    => 'control',
			),

			/** `Ads Management` panel */
			'ads_management'                   => array(
				'title'    => esc_html__( 'Ads Management', 'caldera' ),
				'priority' => 110,
				'type'     => 'section',
			),
			'ads_header'                       => array(
				'title'             => esc_html__( 'Header', 'caldera' ),
				'section'           => 'ads_management',
				'field'             => 'textarea',
				'default'           => '',
				'sanitize_callback' => 'esc_html',
				'type'              => 'control',
			),
			'ads_home_before_loop'             => array(
				'title'             => esc_html__( 'Front Page Before Loop', 'caldera' ),
				'section'           => 'ads_management',
				'field'             => 'textarea',
				'default'           => '',
				'sanitize_callback' => 'esc_html',
				'type'              => 'control',
			),
			'ads_post_before_content'          => array(
				'title'             => esc_html__( 'Post Before Content', 'caldera' ),
				'section'           => 'ads_management',
				'field'             => 'textarea',
				'default'           => '',
				'sanitize_callback' => 'esc_html',
				'type'              => 'control',
			),
			'ads_post_before_comments'         => array(
				'title'             => esc_html__( 'Post Before Comments', 'caldera' ),
				'section'           => 'ads_management',
				'field'             => 'textarea',
				'default'           => '',
				'sanitize_callback' => 'esc_html',
				'type'              => 'control',
			),

			/** `Footer` panel */
			'footer_options'                   => array(
				'title'    => esc_html__( 'Footer', 'caldera' ),
				'priority' => 110,
				'type'     => 'section',
			),
			'footer_logo_url'                  => array(
				'title'   => esc_html__( 'Logo upload', 'caldera' ),
				'section' => 'footer_options',
				'field'   => 'image',
				'default' => '%s/assets/images/footer-logo1.png',
				'type'    => 'control',
			),
			'footer_copyright'                 => array(
				'title'   => esc_html__( 'Copyright text', 'caldera' ),
				'section' => 'footer_options',
				'default' => caldera_get_default_footer_copyright(),
				'field'   => 'textarea',
				'type'    => 'control',
			),
			'footer_widget_columns'            => array(
				'title'   => esc_html__( 'Widget Area Columns', 'caldera' ),
				'section' => 'footer_options',
				'default' => '3',
				'field'   => 'select',
				'choices' => array(
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
				),
				'type'    => 'control'
			),
			'footer_layout_type'               => array(
				'title'   => esc_html__( 'Layout', 'caldera' ),
				'section' => 'footer_options',
				'default' => 'default',
				'field'   => 'select',
				'choices' => array(
					'default'  => esc_html__( 'Style 1', 'caldera' ),
					'centered' => esc_html__( 'Style 2', 'caldera' ),
					'minimal'  => esc_html__( 'Style 3', 'caldera' ),
				),
				'type'    => 'control'
			),
			'footer_widgets_bg'                => array(
				'title'   => esc_html__( 'Footer Widgets Area color', 'caldera' ),
				'section' => 'footer_options',
				'default' => '#313131',
				'field'   => 'hex_color',
				'type'    => 'control',
			),
			'footer_bg'                        => array(
				'title'   => esc_html__( 'Footer Background color', 'caldera' ),
				'section' => 'footer_options',
				'default' => '#484848',
				'field'   => 'hex_color',
				'type'    => 'control',
			),
			'footer_logo_visibility'           => array(
				'title'   => esc_html__( 'Show Footer Logo', 'caldera' ),
				'section' => 'footer_options',
				'default' => false,
				'field'   => 'checkbox',
				'type'    => 'control',
			),
			'footer_menu_visibility'           => array(
				'title'   => esc_html__( 'Show Menu', 'caldera' ),
				'section' => 'footer_options',
				'default' => false,
				'field'   => 'checkbox',
				'type'    => 'control',
			),

			/** `Blog Settings` panel */
			'blog_settings'                    => array(
				'title'    => esc_html__( 'Blog Settings', 'caldera' ),
				'priority' => 115,
				'type'     => 'panel',
			),

			/** `Blog` section */
			'blog'                             => array(
				'title'           => esc_html__( 'Blog', 'caldera' ),
				'panel'           => 'blog_settings',
				'priority'        => 10,
				'type'            => 'section',
				'active_callback' => 'is_home',
			),
			'blog_layout_type'                 => array(
				'title'   => esc_html__( 'Layout', 'caldera' ),
				'section' => 'blog',
				'default' => 'default',
				'field'   => 'select',
				'choices' => array(
					'default'          => esc_html__( 'Listing', 'caldera' ),
					'grid-2-cols'      => esc_html__( 'Grid (2 Columns)', 'caldera' ),
					'grid-3-cols'      => esc_html__( 'Grid (3 Columns)', 'caldera' ),
					'masonry-2-cols'   => esc_html__( 'Masonry (2 Columns)', 'caldera' ),
					'masonry-3-cols'   => esc_html__( 'Masonry (3 Columns)', 'caldera' ),
					'vertical-justify' => esc_html__( 'Vertical Justify', 'caldera' ),
				),
				'type'    => 'control',
			),
			'blog_sticky_label'                => array(
				'title'       => esc_html__( 'Featured Post Label', 'caldera' ),
				'description' => esc_html__( 'Label for sticky post', 'caldera' ),
				'section'     => 'blog',
				'default'     => 'icon:material:star_border',
				'field'       => 'text',
				'type'        => 'control',
			),
			'blog_posts_content'               => array(
				'title'   => esc_html__( 'Post content', 'caldera' ),
				'section' => 'blog',
				'default' => 'excerpt',
				'field'   => 'select',
				'choices' => array(
					'excerpt' => esc_html__( 'Only excerpt', 'caldera' ),
					'full'    => esc_html__( 'Full content', 'caldera' ),
				),
				'type'    => 'control',
			),
			'blog_featured_image'              => array(
				'title'   => esc_html__( 'Featured image', 'caldera' ),
				'section' => 'blog',
				'default' => 'fullwidth',
				'field'   => 'select',
				'choices' => array(
					'small'     => esc_html__( 'Small', 'caldera' ),
					'fullwidth' => esc_html__( 'Fullwidth', 'caldera' ),
				),
				'type'    => 'control',
			),
			'blog_read_more_text'              => array(
				'title'   => esc_html__( 'Read More button text', 'caldera' ),
				'section' => 'blog',
				'default' => esc_html__( 'Read more', 'caldera' ),
				'field'   => 'text',
				'type'    => 'control',
			),
			'blog_post_author'                 => array(
				'title'   => esc_html__( 'Show post author', 'caldera' ),
				'section' => 'blog',
				'default' => true,
				'field'   => 'checkbox',
				'type'    => 'control',
			),
			'blog_post_publish_date'           => array(
				'title'   => esc_html__( 'Show publish date', 'caldera' ),
				'section' => 'blog',
				'default' => true,
				'field'   => 'checkbox',
				'type'    => 'control',
			),
			'blog_post_categories'             => array(
				'title'   => esc_html__( 'Show categories', 'caldera' ),
				'section' => 'blog',
				'default' => true,
				'field'   => 'checkbox',
				'type'    => 'control',
			),
			'blog_post_tags'                   => array(
				'title'   => esc_html__( 'Show tags', 'caldera' ),
				'section' => 'blog',
				'default' => true,
				'field'   => 'checkbox',
				'type'    => 'control',
			),
			'blog_post_comments'               => array(
				'title'   => esc_html__( 'Show comments', 'caldera' ),
				'section' => 'blog',
				'default' => true,
				'field'   => 'checkbox',
				'type'    => 'control',
			),

			/** `Post` section */
			'blog_post'                        => array(
				'title'           => esc_html__( 'Post', 'caldera' ),
				'panel'           => 'blog_settings',
				'priority'        => 20,
				'type'            => 'section',
				'active_callback' => 'callback_single',
			),
			'single_post_author'               => array(
				'title'   => esc_html__( 'Show post author', 'caldera' ),
				'section' => 'blog_post',
				'default' => true,
				'field'   => 'checkbox',
				'type'    => 'control',
			),
			'single_post_publish_date'         => array(
				'title'   => esc_html__( 'Show publish date', 'caldera' ),
				'section' => 'blog_post',
				'default' => true,
				'field'   => 'checkbox',
				'type'    => 'control',
			),
			'single_post_categories'           => array(
				'title'   => esc_html__( 'Show categories', 'caldera' ),
				'section' => 'blog_post',
				'default' => true,
				'field'   => 'checkbox',
				'type'    => 'control',
			),
			'single_post_tags'                 => array(
				'title'   => esc_html__( 'Show tags', 'caldera' ),
				'section' => 'blog_post',
				'default' => true,
				'field'   => 'checkbox',
				'type'    => 'control',
			),
			'single_post_comments'             => array(
				'title'   => esc_html__( 'Show comments', 'caldera' ),
				'section' => 'blog_post',
				'default' => true,
				'field'   => 'checkbox',
				'type'    => 'control',
			),
			'single_author_block'              => array(
				'title'   => esc_html__( 'Enable the author block after each post', 'caldera' ),
				'section' => 'blog_post',
				'default' => true,
				'field'   => 'checkbox',
				'type'    => 'control',
			),
		)
	) );
}

/**
 * Return true if logo in header has image type. Otherwise - return false.
 *
 * @param  object $control
 *
 * @return bool
 */
function caldera_is_header_logo_image( $control ) {

	if ( $control->manager->get_setting( 'header_logo_type' )->value() == 'image' ) {
		return true;
	}

	return false;
}

/**
 * Return true if logo in header has text type. Otherwise - return false.
 *
 * @param  object $control
 *
 * @return bool
 */
function caldera_is_header_logo_text( $control ) {

	if ( $control->manager->get_setting( 'header_logo_type' )->value() == 'text' ) {
		return true;
	}

	return false;
}

// Move native `site_icon` control (based on WordPress core) in custom section.
add_action( 'customize_register', 'caldera_customizer_change_core_controls', 20 );
function caldera_customizer_change_core_controls( $wp_customize ) {
	$wp_customize->get_control( 'site_icon' )->section = 'caldera_logo_favicon';
	$wp_customize->get_control( 'background_color' )->label = esc_html__( 'Body Background Color', 'caldera' );
}

////////////////////////////////////
// Typography utility function    //
////////////////////////////////////
function caldera_get_font_styles() {
	return apply_filters( 'caldera_get_font_styles', array(
		'normal'  => esc_html__( 'Normal', 'caldera' ),
		'italic'  => esc_html__( 'Italic', 'caldera' ),
		'oblique' => esc_html__( 'Oblique', 'caldera' ),
		'inherit' => esc_html__( 'Inherit', 'caldera' ),
	) );
}

function caldera_get_character_sets() {
	return apply_filters( 'caldera_get_character_sets', array(
		'latin'        => esc_html__( 'Latin', 'caldera' ),
		'greek'        => esc_html__( 'Greek', 'caldera' ),
		'greek-ext'    => esc_html__( 'Greek Extended', 'caldera' ),
		'vietnamese'   => esc_html__( 'Vietnamese', 'caldera' ),
		'cyrillic-ext' => esc_html__( 'Cyrillic Extended', 'caldera' ),
		'latin-ext'    => esc_html__( 'Latin Extended', 'caldera' ),
		'cyrillic'     => esc_html__( 'Cyrillic', 'caldera' ),
	) );
}

function caldera_get_text_aligns() {
	return apply_filters( 'caldera_get_text_aligns', array(
		'inherit' => esc_html__( 'Inherit', 'caldera' ),
		'center'  => esc_html__( 'Center', 'caldera' ),
		'justify' => esc_html__( 'Justify', 'caldera' ),
		'left'    => esc_html__( 'Left', 'caldera' ),
		'right'   => esc_html__( 'Right', 'caldera' ),
	) );
}

function caldera_get_font_weight() {
	return apply_filters( 'caldera_get_font_weight', array(
		'100' => '100',
		'200' => '200',
		'300' => '300',
		'400' => '400',
		'500' => '500',
		'600' => '600',
		'700' => '700',
		'800' => '800',
		'900' => '900',
	) );
}

function caldera_get_text_transform() {
	return apply_filters( 'caldera_get_text_transform', array(
		'none'       => esc_html__( 'None ', 'caldera' ),
		'uppercase'  => esc_html__( 'Uppercase ', 'caldera' ),
		'lowercase'  => esc_html__( 'Lowercase', 'caldera' ),
		'capitalize' => esc_html__( 'Capitalize', 'caldera' ),
	) );
}

/**
 * Return array of arguments for dynamic CSS module
 *
 * @return array
 */
function caldera_get_dynamic_css_options() {
	return apply_filters( 'caldera_get_dynamic_css_options', array(
		'prefix'    => 'caldera',
		'type'      => 'theme_mod',
		'single'    => true,
		'css_files' => array(
			CALDERA_THEME_DIR . '/assets/css/dynamic.css',
			CALDERA_THEME_DIR . '/assets/css/dynamic/builder/brands-showcase-module.css',
			CALDERA_THEME_DIR . '/assets/css/dynamic/site/elements.css',
			CALDERA_THEME_DIR . '/assets/css/dynamic/site/header.css',
			CALDERA_THEME_DIR . '/assets/css/dynamic/site/forms.css',
			CALDERA_THEME_DIR . '/assets/css/dynamic/site/social.css',
			CALDERA_THEME_DIR . '/assets/css/dynamic/site/menus.css',
			CALDERA_THEME_DIR . '/assets/css/dynamic/site/post.css',
			CALDERA_THEME_DIR . '/assets/css/dynamic/site/navigation.css',
			CALDERA_THEME_DIR . '/assets/css/dynamic/site/footer.css',
			CALDERA_THEME_DIR . '/assets/css/dynamic/site/misc.css',
			CALDERA_THEME_DIR . '/assets/css/dynamic/site/buttons.css',
			CALDERA_THEME_DIR . '/assets/css/dynamic/site/projects.css',
			CALDERA_THEME_DIR . '/assets/css/dynamic/site/map.css',
			CALDERA_THEME_DIR . '/assets/css/dynamic/widgets/widget-default.css',
			CALDERA_THEME_DIR . '/assets/css/dynamic/widgets/taxonomy-tiles.css',
			CALDERA_THEME_DIR . '/assets/css/dynamic/widgets/image-grid.css',
			CALDERA_THEME_DIR . '/assets/css/dynamic/widgets/carousel.css',
			CALDERA_THEME_DIR . '/assets/css/dynamic/widgets/smart-slider.css',
			CALDERA_THEME_DIR . '/assets/css/dynamic/widgets/instagram.css',
			CALDERA_THEME_DIR . '/assets/css/dynamic/widgets/subscribe.css',
		),
		'options'   => array(
			'header_logo_font_style',
			'header_logo_font_weight',
			'header_logo_font_size',
			'header_logo_font_family',

			'body_font_style',
			'body_font_weight',
			'body_font_size',
			'body_line_height',
			'body_font_family',
			'body_letter_spacing',
			'body_text_align',

			'h1_font_style',
			'h1_font_weight',
			'h1_font_size',
			'h1_line_height',
			'h1_font_family',
			'h1_letter_spacing',
			'h1_text_align',

			'h2_font_style',
			'h2_font_weight',
			'h2_font_size',
			'h2_line_height',
			'h2_font_family',
			'h2_letter_spacing',
			'h2_text_align',

			'h3_font_style',
			'h3_font_weight',
			'h3_font_size',
			'h3_line_height',
			'h3_font_family',
			'h3_letter_spacing',
			'h3_text_align',

			'h4_font_style',
			'h4_font_weight',
			'h4_font_size',
			'h4_line_height',
			'h4_font_family',
			'h4_letter_spacing',
			'h4_text_align',

			'h5_font_style',
			'h5_font_weight',
			'h5_font_size',
			'h5_line_height',
			'h5_font_family',
			'h5_letter_spacing',
			'h5_text_align',

			'h6_font_style',
			'h6_font_weight',
			'h6_font_size',
			'h6_line_height',
			'h6_font_family',
			'h6_letter_spacing',
			'h6_text_align',

			'showcase_title_font_style',
			'showcase_title_font_weight',
			'showcase_title_font_size',
			'showcase_title_line_height',
			'showcase_title_font_family',
			'showcase_title_letter_spacing',
			'showcase_title_text_transform',

			'showcase_subtitle_font_style',
			'showcase_subtitle_font_weight',
			'showcase_subtitle_font_size',
			'showcase_subtitle_line_height',
			'showcase_subtitle_font_family',
			'showcase_subtitle_letter_spacing',
			'showcase_subtitle_text_transform',

			'header_showcase_bg_color',
			'header_showcase_bg_repeat',
			'header_showcase_bg_position_x',
			'header_showcase_bg_attachment',
			'header_showcase_color_mask',
			'header_showcase_opacity_mask',
			'showcase_title_color',
			'showcase_subtitle_color',
			'showcase_description_color',

			'breadcrumbs_font_style',
			'breadcrumbs_font_weight',
			'breadcrumbs_font_size',
			'breadcrumbs_line_height',
			'breadcrumbs_font_family',
			'breadcrumbs_letter_spacing',
			'breadcrumbs_text_align',

			'regular_accent_color_1',
			'regular_accent_color_2',
			'regular_text_color',
			'regular_link_color',
			'regular_link_hover_color',
			'regular_h1_color',
			'regular_h2_color',
			'regular_h3_color',
			'regular_h4_color',
			'regular_h5_color',
			'regular_h6_color',

			'invert_accent_color_1',
			'invert_accent_color_2',
			'invert_accent_color_3',
			'invert_text_color',
			'invert_link_color',
			'invert_link_hover_color',
			'invert_h1_color',
			'invert_h2_color',
			'invert_h3_color',
			'invert_h4_color',
			'invert_h5_color',
			'invert_h6_color',

			'header_bg_color',
			'header_bg_image',
			'header_bg_repeat',
			'header_bg_position_x',
			'header_bg_attachment',

			'top_panel_bg',

			'container_width',

			'footer_widgets_bg',
			'footer_bg',
		),
	) );
}

/**
 * Return array of arguments for Google Font loader module.
 *
 * @since  1.0.0
 * @return array
 */
function caldera_get_fonts_options() {
	return apply_filters( 'caldera_get_fonts_options', array(
		'prefix'  => 'caldera',
		'type'    => 'theme_mod',
		'single'  => true,
		'options' => array(
			'body'              => array(
				'family'  => 'body_font_family',
				'style'   => 'body_font_style',
				'weight'  => 'body_font_weight',
				'charset' => 'body_character_set',
			),
			'h1'                => array(
				'family'  => 'h1_font_family',
				'style'   => 'h1_font_style',
				'weight'  => 'h1_font_weight',
				'charset' => 'h1_character_set',
			),
			'h2'                => array(
				'family'  => 'h2_font_family',
				'style'   => 'h2_font_style',
				'weight'  => 'h2_font_weight',
				'charset' => 'h2_character_set',
			),
			'h3'                => array(
				'family'  => 'h3_font_family',
				'style'   => 'h3_font_style',
				'weight'  => 'h3_font_weight',
				'charset' => 'h3_character_set',
			),
			'h4'                => array(
				'family'  => 'h4_font_family',
				'style'   => 'h4_font_style',
				'weight'  => 'h4_font_weight',
				'charset' => 'h4_character_set',
			),
			'h5'                => array(
				'family'  => 'h5_font_family',
				'style'   => 'h5_font_style',
				'weight'  => 'h5_font_weight',
				'charset' => 'h5_character_set',
			),
			'h6'                => array(
				'family'  => 'h6_font_family',
				'style'   => 'h6_font_style',
				'weight'  => 'h6_font_weight',
				'charset' => 'h6_character_set',
			),
			'header_logo'       => array(
				'family'  => 'header_logo_font_family',
				'style'   => 'header_logo_font_style',
				'weight'  => 'header_logo_font_weight',
				'charset' => 'header_logo_character_set',
			),
			'showcase_title'    => array(
				'family'  => 'showcase_title_font_family',
				'style'   => 'showcase_title_font_style',
				'weight'  => 'showcase_title_font_weight',
				'charset' => 'showcase_title_character_set',
			),
			'showcase_subtitle' => array(
				'family'  => 'showcase_subtitle_font_family',
				'style'   => 'showcase_subtitle_font_style',
				'weight'  => 'showcase_subtitle_font_weight',
				'charset' => 'showcase_subtitle_character_set',
			),
			'breadcrumbs'       => array(
				'family'  => 'breadcrumbs_font_family',
				'style'   => 'breadcrumbs_font_style',
				'weight'  => 'breadcrumbs_font_weight',
				'charset' => 'breadcrumbs_character_set',
			),
		)
	) );
}

/**
 * Get default top panel text.
 *
 * @since  1.0.0
 * @return string
 */
function caldera_get_default_top_panel_text() {
	return sprintf(
		'<div class="info-block">%s</div><div class="info-block address"> <i class="material-icons">location_on</i> %s</div>',
		esc_html__( 'We&#8217;re as trustworthy and robust as a sheet of steel!', 'caldera' ),
		esc_html__( '11559 Ventura Boulevard, Studio City, CA 91604', 'caldera' )
	);
}

/**
 * Get default footer copyright.
 *
 * @since  1.0.0
 * @return string
 */
function caldera_get_default_footer_copyright() {
	return esc_html__( 'Copyright %%year%% Caldera. All rights reserved.', 'caldera' );
}

/**
 * Get default header backgroung image.
 *
 * @since  1.0.0
 * @return string
 */
function caldera_get_default_header_bg_image() {
	return get_home_url() . '/wp-content/themes/caldera/assets/images/header-bg.jpg';
}

/**
 * Return true if More button (in the main menu) has image type. Otherwise - return false.
 *
 * @param  object $control
 *
 * @return bool
 */
function caldera_is_more_button_type_image( $control ) {
	if ( $control->manager->get_setting( 'more_button_type' )->value() == 'image' ) {
		return true;
	}
	return false;
}

/**
 * Return true if More button (in the main menu) has text type. Otherwise - return false.
 *
 * @param  object $control
 *
 * @return bool
 */
function caldera_is_more_button_type_text( $control ) {
	if ( $control->manager->get_setting( 'more_button_type' )->value() == 'text' ) {
		return true;
	}
	return false;
}

/**
 * Return true if More button (in the main menu) has icon type. Otherwise - return false.
 *
 * @param  object $control
 *
 * @return bool
 */
function caldera_is_more_button_type_icon( $control ) {
	if ( $control->manager->get_setting( 'more_button_type' )->value() == 'icon' ) {
		return true;
	}
	return false;
}

/**
 * Get icons set
 *
 * @return array
 */
function caldera_get_icons_set() {
	ob_start();

	include CALDERA_THEME_DIR . '/assets/js/icons.json';

	$json = ob_get_clean();
	$result = array();
	$icons = json_decode( $json, true );

	foreach ( $icons['icons'] as $icon ) {
		$result[] = $icon['id'];
	}

	return $result;
}

/**
 * Get default showcase description.
 *
 * @since  1.0.0
 * @return string
 */
function caldera_get_default_showcase_description() {
	return esc_html__( ' ', 'caldera' );
}

function caldera_get_default_showcase_btn_url() {
	return '%%projects%%';
}