<?php
/*
Widget Name: Image Grid widget
Description: This widget is used to display a list of images from your posts
Settings:
 Title - Widget's text title
 Choose taxonomy type - Choose the posts source type
 Select cateogory / tag - Choose the posts source
 Post sorted - Choose the sort order
 Posts number - Limit the posts
 Offset post - Specify the offset
 Title words length - Specify post title length
 Columns number - Choose the number of columns
 Items padding - Choose the offset between items
*/

/**
 * @package Caldera
 */
if ( ! class_exists( 'Caldera_Image_Grid_Widget' ) ) {

	/**
	 * Image Grid Widget
	 */
	class Caldera_Image_Grid_Widget extends Cherry_Abstract_Widget {

		/**
		 * Contain utility module from Cherry framework
		 *
		 * @since 1.0.0
		 * @var   object
		 */
		private $utility = null;

		/**
		 * Constructor.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			$this->widget_name = esc_html__( 'Image Grid', 'caldera' );
			$this->widget_description = esc_html__( 'This widget displays images from post.', 'caldera' );
			$this->widget_id = 'widget-image-grid';
			$this->widget_cssclass = 'widget-image-grid';
			$this->utility = caldera_utility()->utility;
			$this->settings = array(
				'title'          => array(
					'type'  => 'text',
					'value' => 'Image Grid',
					'label' => esc_html__( 'Widget title', 'caldera' ),
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
					),
					'label'   => esc_html__( 'Choose taxonomy type', 'caldera' ),
				),
				'category_name'  => array(
					'type'             => 'select',
					'multiple'         => true,
					'value'            => '',
					'options'          => false,
					'options_callback' => array( $this->utility->satellite, 'get_terms_array', array( 'category', 'slug' ) ),
					'label'            => esc_html__( 'Select categories to show', 'caldera' ),
					'master'           => 'terms_type_post_category',
				),
				'tag'            => array(
					'type'             => 'select',
					'multiple'         => true,
					'value'            => '',
					'options'          => false,
					'options_callback' => array( $this->utility->satellite, 'get_terms_array', array( 'post_tag', 'slug' ) ),
					'label'            => esc_html__( 'Select tags to show', 'caldera' ),
					'master'           => 'terms_type_post_tag',
				),
				'post_sort'      => array(
					'type'    => 'select',
					'value'   => 'date',
					'options' => array(
						'date'          => esc_html__( 'Publish Date', 'caldera' ),
						'title'         => esc_html__( 'Post Title', 'caldera' ),
						'comment_count' => esc_html__( 'Comment Count', 'caldera' ),
					),
					'label'   => esc_html__( 'Post sorted', 'caldera' ),
				),
				'post_number'    => array(
					'type'       => 'stepper',
					'value'      => '5',
					'max_value'  => '100',
					'min_value'  => '1',
					'step_value' => '1',
					'label'      => esc_html__( 'Posts number', 'caldera' ),
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
				'columns_number' => array(
					'type'       => 'stepper',
					'value'      => '3',
					'max_value'  => '4',
					'min_value'  => '1',
					'step_value' => '1',
					'label'      => esc_html__( 'Columns number', 'caldera' ),
				),
				'items_padding'  => array(
					'type'       => 'stepper',
					'value'      => '5',
					'max_value'  => '50',
					'min_value'  => '0',
					'step_value' => '1',
					'label'      => esc_html__( 'Items padding ( size in pixels )', 'caldera' ),
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
			global $post;

			$args = apply_filters( 'caldera_image_grid_widget_args', $args, $instance );

			if ( $this->get_cached_widget( $args ) ) {
				return;
			}

			$template = locate_template( '/inc/widgets/image-grid/views/image-grid-view.php', false, false );

			if ( empty( $template ) ) {
				return;
			}

			ob_start();

			$this->setup_widget_data( $args, $instance );
			$this->widget_start( $args, $instance );

			$terms_type = $instance['terms_type'];
			$title_length = $instance['title_length'];
			$columns_number = $instance['columns_number'];
			$items_padding = $instance['items_padding'];

			if ( array_key_exists( $terms_type, $instance ) ) {
				$post_taxonomy = $instance[ $terms_type ];

				if ( $post_taxonomy ) {
					$post_args = array(
						'post_type'   => 'post',
						'offset'      => $instance['post_offset'],
						'orderby'     => $instance['post_sort'],
						'order'       => apply_filters( 'caldera_order_image_grid_widget', 'DESC', $instance ),//ASC
						'numberposts' => ( int )$instance['post_number'],
					);

					$post_args[ $terms_type ] = implode( ',', $post_taxonomy );

					$posts = get_posts( $post_args );
				}
			}

			if ( isset( $posts ) && $posts ) {
				global $post;

				$columns_class = 4 < $columns_number ? 3 : ( int )( 12 / $columns_number );
				$row_inline_style = '';
				$inline_style = '';

				if ( '0' !== $items_padding ) {
					caldera_theme()->dynamic_css->add_style(
						$this->add_selector( '.row' ),
						array( 'margin-left' => '-' . $items_padding . 'px' )
					);

					caldera_theme()->dynamic_css->add_style(
						$this->add_selector( '.widget-image-grid__inner' ),
						array( 'margin' => '0 0 ' . $items_padding . 'px ' . $items_padding . 'px' )
					);
				}

				echo apply_filters(
					'caldera_image_grid_widget_before',
					'<div class="row columns-number-' . $columns_number . '">',
					$instance
				);

				foreach ( $posts as $post ) {
					setup_postdata( $post );

					$image = $this->utility->media->get_image( array(
						'size'        => 'caldera-thumb-m',
						'mobile_size' => 'caldera-thumb-s',
						'class'       => 'widget-image-grid__img',
						'html'        => '<img %2$s src="%3$s" alt="%4$s" %5$s>',
					) );
					$permalink = $this->utility->attributes->get_post_permalink();
					$title_visible = ( '0' === $title_length ) ? false : true;

					$title = $this->utility->attributes->get_title( array(
						'visible' => $title_visible,
						'length'  => $title_length,
						'class'   => 'widget-image-grid__title',
						'html'    => '<h6 %1$s><a href="%2$s" %3$s rel="bookmark">%4$s</a></h6>',
					) );

					$date = $this->utility->meta_data->get_date( array(
						'class' => 'widget-image-grid__link',
					) );

					include $template;
				}

				echo apply_filters( 'caldera_image_grid_widget_after', '</div>', $instance );
			}

			$this->widget_end( $args );
			$this->reset_widget_data();

			wp_reset_postdata();

			echo $this->cache_widget( $args, ob_get_clean() );
		}
	}

	add_action( 'widgets_init', 'caldera_register_image_grid_widget' );
	function caldera_register_image_grid_widget() {
		register_widget( 'Caldera_Image_Grid_Widget' );
	}
}
