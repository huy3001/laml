<?php
/**
 * Template Name: Projects
 *
 * The template for displaying CPT Projects.
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

while ( have_posts() ) : the_post();
	cherry_projects()->projects_single_data->render_projects_single();
endwhile;
?>

<div class="product-related related-projects" excluded-project="<?php echo $wp_query->query['name'] ?>">
	<div class="product-related-title">
		<h4>Related Products</h4>
	</div>
	<?php
		$terms = get_the_terms( $post->ID, 'projects_category' );
		foreach ( $terms as $term ) {
			$single_term =  $term->slug;
		}

		$attr = array(
			'filter-visible'               => true,
			'loading-animation'            => 'none',
			'single-term'                  => $single_term,
			'order-filter-default-value'   => 'asc',
			'orderby-filter-default-value' => 'name'
		);

		cherry_projects()->projects_data->render_projects( $attr );
	?>
</div>

<?php

	do_action( 'cherry_projects_after_main_content' );

	if ( did_action( 'cherry_projects_before_main_content' ) ) { ?>
				</article><!-- #post-## -->
			</main><!-- .site-main -->
		</div><!-- .content-area -->

		<?php do_action( 'cherry_projects_content_after' );

		get_sidebar();

		get_footer();
	}
?>