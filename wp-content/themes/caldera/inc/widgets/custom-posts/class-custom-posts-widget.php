<?php
/*
Widget Name: Custom Posts widget
Description: This widget is used to display a list of posts from a category, tag or a single post format
Settings:
 Title - Widget's text title
 Choose taxonomy type - Choose the posts source type
 Select cateogory / tag / post format - Choose the posts source
 Posts Count - Limit the posts
 Offset Post - Specify the offset
 Title words length - Specify post title length
 Excerpt words length - Specify post content length
 Display post meta data - Choose which meta data should be displayed to the user
 Post read more button label - Specify a read more button label
*/

/**
 * @package Caldera
 */

if ( ! class_exists( 'Caldera_Custom_Posts_Widget' ) ) {

	class Caldera_Custom_Posts_Widget extends Cherry_Abstract_Widget {

		/**
		 * Contain utility module from Cherry framework
		 *
		 * @since 1.0.0
		 * @var   object
		 */
		private $utility = null;

		/**
		 * Constructor
		 *
		 * @since  1.0.0
		 */
		public function __construct() {
			$this->widget_name = esc_html__( 'Custom Posts', 'caldera' );
			$this->widget_description = esc_html__( 'Display custom posts your site.', 'caldera' );
			$this->widget_id = apply_filters( 'caldera_custom_posts_widget_ID', 'widget-custom-posts' );
			$this->widget_cssclass = apply_filters( 'caldera_custom_posts_widget_cssclass', 'widget-custom-posts custom-posts' );
			$this->utility = caldera_utility()->utility;
			$this->settings = array(
				'title'          => array(
					'type'  => 'text',
					'value' => esc_html__( 'Custom Posts', 'caldera' ),
					'label' => esc_html__( 'Title', 'caldera' ),
				),
				'terms_type'     => array(
					'type'    => 'radio',
					'value'   => 'category_name',
					'options' => array(
						'category_name' => array(
							'label' => esc_html__( 'Category', 'caldera' ),
							'slave' => 'terms_type_post_category',
						),
						'tag'           => array(
							'label' => esc_html__( 'Tag', 'caldera' ),
							'slave' => 'terms_type_post_tag',
						),
						'post_format'   => array(
							'label' => esc_html__( 'Post Format', 'caldera' ),
							'slave' => 'terms_type_post_format',
						),
					),
					'label'   => esc_html__( 'Choose taxonomy type', 'caldera' ),
				),
				'category_name'  => array(
					'type'             => 'select',
					'size'             => 1,
					'value'            => '',
					'options_callback' => array( $this->utility->satellite, 'get_terms_array', array( 'category', 'slug' ) ),
					'options'          => false,
					'label'            => esc_html__( 'Select category', 'caldera' ),
					'multiple'         => true,
					'placeholder'      => esc_html__( 'Select category', 'caldera' ),
					'master'           => 'terms_type_post_category',
				),
				'tag'            => array(
					'type'             => 'select',
					'size'             => 1,
					'value'            => '',
					'options_callback' => array( $this->utility->satellite, 'get_terms_array', array( 'post_tag', 'slug' ) ),
					'options'          => false,
					'label'            => esc_html__( 'Select tags', 'caldera' ),
					'multiple'         => true,
					'placeholder'      => esc_html__( 'Select tags', 'caldera' ),
					'master'           => 'terms_type_post_tag',
				),
				'post_format'    => array(
					'type'             => 'select',
					'size'             => 1,
					'value'            => '',
					'options_callback' => array( $this->utility->satellite, 'get_terms_array', array( 'post_format', 'slug' ) ),
					'options'          => false,
					'label'            => esc_html__( 'Select post format', 'caldera' ),
					'multiple'         => true,
					'placeholder'      => esc_html__( 'Select post format', 'caldera' ),
					'master'           => 'terms_type_post_format',
				),
				'posts_per_page' => array(
					'type'      => 'stepper',
					'value'     => 10,
					'max_value' => 50,
					'min_value' => 0,
					'label'     => esc_html__( 'Posts count ( Set 0 to show all. )', 'caldera' ),
				),
				'post_offset'    => array(
					'type'       => 'stepper',
					'value'      => '0',
					'max_value'  => '10000',
					'min_value'  => '0',
					'step_value' => '1',
					'label'      => esc_html__( 'Offset post', 'caldera' ),
				),
				'title_length'   => array(
					'type'       => 'stepper',
					'value'      => '10',
					'max_value'  => '500',
					'min_value'  => '0',
					'step_value' => '1',
					'label'      => esc_html__( 'Title words length ( Set 0 to hide title. )', 'caldera' ),
				),
				'excerpt_length' => array(
					'type'       => 'stepper',
					'value'      => '10',
					'max_value'  => '500',
					'min_value'  => '0',
					'step_value' => '1',
					'label'      => esc_html__( 'Excerpt words length ( Set 0 to hide excerpt. )', 'caldera' ),
				),
				'meta_data'      => array(
					'type'    => 'checkbox',
					'value'   => array(
						'date'          => 'true',
						'author'        => 'false',
						'comment_count' => 'false',
						'category'      => 'false',
						'tag'           => 'false',
						'more_button'   => 'false',
					),
					'options' => array(
						'date'          => esc_html__( 'Date', 'caldera' ),
						'author'        => esc_html__( 'Author', 'caldera' ),
						'comment_count' => esc_html__( 'Comment count', 'caldera' ),
						'category'      => esc_html__( 'Category', 'caldera' ),
						'post_tag'      => esc_html__( 'Tag', 'caldera' ),
						'more_button'   => esc_html__( 'More Button', 'caldera' ),
					),
					'label' > esc_html__( 'Display post meta data', 'caldera' ),
				),
				'button_text'    => array(
					'type'  => 'text',
					'value' => 'Read More',
					'label' => esc_html__( 'Post read more button label', 'caldera' ),
				),
			);

			parent::__construct();
		}

		/**
		 * Widget function.
		 *
		 * @see    WP_Widget
		 *
		 * @since  1.0.0
		 *
		 * @param array $args
		 * @param array $instance
		 */
		public function widget( $args, $instance ) {

			if ( $this->get_cached_widget( $args ) ) {
				return;
			}

			$template = locate_template( 'inc/widgets/custom-posts/views/custom-post-view.php', false, false );

			if ( empty( $template ) ) {
				return;
			}

			ob_start();

			$this->setup_widget_data( $args, $instance );
			$this->widget_start( $args, $instance );

			$terms_type = $instance['terms_type'];
			$post_offset = $instance['post_offset'];
			$title_length = $instance['title_length'];
			$excerpt_length = $instance['excerpt_length'];
			$meta_data = $instance['meta_data'];
			$button_text = $instance['button_text'];

			if ( ! isset( $instance[ $terms_type ] ) || ! $instance[ $terms_type ] ) {
				return;
			}

			$posts_per_page = ( '0' === $instance['posts_per_page'] ) ? -1 : ( int )$instance['posts_per_page'];
			$post_args = array(
				'post_type'   => 'post',
				'offset'      => ( int )$post_offset,
				'numberposts' => $posts_per_page,
			);

			$post_args[ $terms_type ] = implode( ',', $instance[ $terms_type ] );

			$grid_class_array = array(
				'default'             => 'col-xs-6 col-sm-6 col-md-6 col-lg-4 col-xl-4',
				'before-content-area' => 'col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-4',
				'after-content-area'  => 'col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-4',
				'sidebar'             => 'col-xs-6 col-sm-6 col-md-12 col-lg-12 col-xl-12',
				'before-loop-area'    => 'col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6',
				'after-loop-area'     => 'col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6',
				'footer-area'         => 'col-xs-6 col-sm-6 col-md-12 col-lg-12 col-xl-12',
			);

			$grid_class = isset( $grid_class_array[ $args['id'] ] ) ? $grid_class_array[ $args['id'] ] : $grid_class_array['default'];

			$posts = get_posts( $post_args );

			if ( $posts ) {
				global $post;

				echo '<div class="custom-posts__holder row" >';

				foreach ( $posts as $post ) {
					setup_postdata( $post );

					$image = $this->utility->media->get_image( array(
						'size'        => 'caldera-thumb-m',
						'mobile_size' => 'caldera-thumb-s',
						'class'       => 'post-thumbnail__link',
						'html'        => '<a href="%1$s" %2$s><img class="post-thumbnail__img" src="%3$s" alt="%4$s" %5$s></a>',
					) );

					$excerpt_visible = ( '0' === $excerpt_length ) ? false : true;
					$excerpt = $this->utility->attributes->get_content( array(
						'visible'      => $excerpt_visible,
						'length'       => $excerpt_length,
						'content_type' => 'post_excerpt',
					) );

					$title_visible = ( '0' === $title_length ) ? false : true;
					$title = $this->utility->attributes->get_title( array(
						'visible' => $title_visible,
						'length'  => $title_length,
						'html'    => '<h6 %1$s><a href="%2$s" %3$s>%4$s</a></h6>',
					) );

					$permalink = $this->utility->attributes->get_post_permalink();

					$date = $this->utility->meta_data->get_date( array(
						'visible' => $meta_data['date'],
						'html'    => '<span class="post__date">%1$s<a href="%2$s" %3$s %4$s><time datetime="%5$s">%6$s%7$s</time></a></span>',
						'class'   => 'post__date-link',
					) );

					$count = $this->utility->meta_data->get_comment_count( array(
						'visible' => $meta_data['comment_count'],
						'html'    => '<span class="post__comments">%1$s<a href="%2$s" %3$s %4$s>%5$s%6$s</a></span>',
						'class'   => 'post__comments-link',
						'sufix'   => _n_noop( '%s comment', '%s comments', 'caldera' ),
					) );

					$author = $this->utility->meta_data->get_author( array(
						'visible' => $meta_data['author'],
						'html'    => '<span class="posted-by">%1$s<a href="%2$s" %3$s %4$s rel="author">%5$s%6$s</a></span>',
						'class'   => 'posted-by__author',
					) );

					$category = $this->utility->meta_data->get_terms( array(
						'delimiter' => ', ',
						'type'      => 'category',
						'visible'   => $meta_data['category'],
						'before'    => '<div class="post__cats">',
						'after'     => '</div>',
					) );

					$tag = $this->utility->meta_data->get_terms( array(
						'delimiter' => ', ',
						'type'      => 'post_tag',
						'visible'   => $meta_data['post_tag'],
						'before'    => '<div class="post__tags">',
						'after'     => '</div>',
					) );

					$button = $this->utility->attributes->get_button( array(
						'visible' => $meta_data['more_button'],
						'text'    => $button_text,
						'icon'    => '',
					) );

					include $template;
				}

				echo '</div>';
			}

			$this->widget_end( $args );
			$this->reset_widget_data();

			wp_reset_postdata();

			echo $this->cache_widget( $args, ob_get_clean() );
		}
	}

	add_action( 'widgets_init', 'caldera_register_custom_posts_widget' );
	function caldera_register_custom_posts_widget() {
		register_widget( 'Caldera_Custom_Posts_Widget' );
	}
}
