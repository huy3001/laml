<?php
/**
 * Template Name: Projects
 *
 * The archive index page for CPT Projects.
 *
 * @package Cherry_Projects
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! did_action( 'get_header' ) ) {
	get_header();

	do_action( 'cherry_projects_before_main_content' ); ?>

		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<?php }

	global $wp_query;

?>

<div class="projects-category-picture">
	<img src="<?php echo get_template_directory_uri(); ?>/assets/images/all-products.jpg" alt="All products">
</div>

<div class="project-terms-caption">
	<h3><?php echo $wp_query->queried_object->name; ?></h3>
	<p><?php echo $wp_query->queried_object->description; ?></p>
</div>

<?php
	$default_options = cherry_projects()->projects_data->default_options;

	if ( is_tax() ) {
		$filter_visible = true;
	} elseif ( filter_var( $default_options['filter-visible'], FILTER_VALIDATE_BOOLEAN ) ) {
		$filter_visible = true;
	} else {
		$filter_visible = true;
	}

	if ( 'projects_category' === $wp_query->query_vars['taxonomy'] ) {
		$filter_type = 'category';
	} elseif ( 'projects_tag' === $wp_query->query_vars['taxonomy'] ) {
		$filter_type = 'tag';
	}

	// Render single term
	if ( $wp_query->query_vars['term'] ) {
		$attr = array(
			'filter-visible'               => $filter_visible,
			'single-term'                  => ! empty( $wp_query->query_vars['term'] ) ? $wp_query->query_vars['term'] : '',
			'filter-type'                  => $filter_type,
			'loading-animation'            => 'none',
			'order-filter-default-value'   => 'asc',
			'orderby-filter-default-value' => 'name'
		);
	
		cherry_projects()->projects_data->render_projects( $attr );
	}
	// Render multiple terms
	else {
		$terms = get_terms( 'projects_category' );
		$index = 0;
		foreach ( $terms as $term ) {
			$term_name =  $term->name;
			$term_slug =  $term->slug;
			$attr[$index] = array(
				'filter-visible'               => $filter_visible,
				'loading-animation'            => 'none',
				'single-term'                  => $term_slug,
				'order-filter-default-value'   => 'asc',
				'orderby-filter-default-value' => 'name'
			);

			echo '<div class="projects-category"><h4 class="projects-category__title">'. $term_name .'</h4>';

			cherry_projects()->projects_data->render_projects( $attr[$index] );

			echo '</div>';
			
			$index++;
		}
	}

	do_action( 'cherry_projects_after_main_content' );

	if ( did_action( 'cherry_projects_before_main_content' ) ) { ?>
				</article><!-- #post-## -->
			</main><!-- .site-main -->
		</div><!-- .content-area -->

	<?php do_action( 'cherry_projects_content_after' );

	get_sidebar();

	get_footer();
} ?>
