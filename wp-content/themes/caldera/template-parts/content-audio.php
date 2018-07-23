<?php
/**
 * Template part for displaying posts.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Caldera
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'posts-list__item card' ); ?>>

	<?php $utility = caldera_utility()->utility; ?>

	<div class="post-list__item-content">

		<?php $cats_visible = caldera_is_meta_visible( 'blog_post_categories', 'loop' ) ? 'true' : 'false'; ?>

		<?php $utility->meta_data->get_terms( array(
			'visible' => $cats_visible,
			'type'    => 'category',
			'icon'    => '',
			'before'  => '<div class="post__cats">',
			'after'   => '</div>',
			'echo'    => true,
		) );
		?>

		<?php caldera_sticky_label(); ?>

		<header class="entry-header">

			<?php
			$title_html = ( is_single() ) ? '<h3 %1$s>%4$s</h3>' : '<h4 %1$s><a href="%2$s" rel="bookmark">%4$s</a></h4>';

			$utility->attributes->get_title( array(
				'class' => 'entry-title',
				'html'  => $title_html,
				'echo'  => true,
			) );
			?>

			<?php do_action( 'cherry_post_format_audio' ); ?>

		</header>
		<!-- .entry-header -->

		<div class="entry-content">
			<?php $embed_args = array(
				'fields' => array( 'soundcloud' ),
				'height' => 310,
				'width'  => 310,
			);

			$embed_content = apply_filters( 'cherry_get_embed_post_formats', false, $embed_args );

			if ( false === $embed_content ) {

				$blog_content = get_theme_mod( 'blog_posts_content', caldera_theme()->customizer->get_default( 'blog_posts_content' ) );
				$length = ( 'full' === $blog_content ) ? -1 : 55;

				$utility->attributes->get_content( array(
					'length'       => $length,
					'content_type' => 'post_excerpt',
					'echo'         => true,
				) );

			} else {
				printf( '<div class="embed-wrapper">%s</div>', $embed_content );
			}
			?>
		</div>
		<!-- .entry-content -->

		<div class="entry_info">
			<?php if ( 'post' === get_post_type() ) : ?>

				<div class="entry-meta">
					<?php $author_visible = caldera_is_meta_visible( 'blog_post_author', 'loop' ) ? 'true' : 'false'; ?>

					<?php $utility->meta_data->get_author( array(
						'visible' => $author_visible,
						'class'   => 'posted-by__author',
						'prefix'  => esc_html__( 'by ', 'caldera' ),
						'html'    => '<div class="posted-by">%1$s<a href="%2$s" %3$s %4$s rel="author">%5$s%6$s</a></div>',
						'echo'    => true,
					) );
					?>
					<div class="post__date">
						<?php $date_visible = caldera_is_meta_visible( 'blog_post_publish_date', 'loop' ) ? 'true' : 'false';

						$utility->meta_data->get_date( array(
							'visible' => $date_visible,
							'class'   => 'post__date-link',
							'icon'    => '',
							'echo'    => true,
						) );
						?>
					</div>
					<div class="post__comments">
						<?php $comment_visible = caldera_is_meta_visible( 'blog_post_comments', 'loop' ) ? 'true' : 'false';

						$utility->meta_data->get_comment_count( array(
							'visible' => $comment_visible,
							'class'   => 'post__comments-link',
							'icon'    => '<i class="material-icons">chat_bubble_outline</i>',
							'echo'    => true,
						) );
						?>
					</div>
					<div class="post__tags__header">
						<?php $tags_visible = caldera_is_meta_visible( 'blog_post_tags', 'loop' ) ? 'true' : 'false';

						$utility->meta_data->get_terms( array(
							'visible'   => $tags_visible,
							'type'      => 'post_tag',
							'delimiter' => ', ',
							'prefix'    => esc_html__( 'Tags: ', 'caldera' ),
							'icon'      => '',
							'before'    => '<div class="post__tags">',
							'after'     => '</div>',
							'echo'      => true,
						) );
						?>
					</div>
				</div><!-- .entry-meta -->

			<?php endif; ?>

			<footer class="entry-footer">
				<?php $utility->attributes->get_button( array(
					'class' => 'btn btn-primary',
					'text'  => get_theme_mod( 'blog_read_more_text', caldera_theme()->customizer->get_default( 'blog_read_more_text' ) ),
					'icon'  => '<i class="material-icons">arrow_forward</i>',
					'html'  => '<a href="%1$s" %3$s><span class="btn__text">%4$s</span>%5$s</a>',
					'echo'  => true,
				) );
				?>
			</footer>
			<!-- .entry-footer -->
		</div>
	</div>

</article><!-- #post-## -->
