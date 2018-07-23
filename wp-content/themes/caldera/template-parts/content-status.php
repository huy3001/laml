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

		<figure class="post-thumbnail">
			<?php $size = caldera_post_thumbnail_size( array( 'class_prefix' => 'post-thumbnail--' ) ); ?>

			<?php $utility->media->get_image( array(
				'size'        => $size['size'],
				'class'       => 'post-thumbnail__link ' . $size['class'],
				'html'        => '<a href="%1$s" %2$s><img class="post-thumbnail__img wp-post-image" src="%3$s" alt="%4$s" %5$s></a>',
				'placeholder' => false,
				'echo'        => true,
			) );
			?>

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
		</figure>
		<!-- .post-thumbnail -->

		<header class="entry-header">
			<?php
			$title_html = ( is_single() ) ? '<h3 %1$s>%4$s</h3>' : '<h4 %1$s><a href="%2$s" rel="bookmark">%4$s</a></h4>';

			$utility->attributes->get_title( array(
				'class' => 'entry-title',
				'html'  => $title_html,
				'echo'  => true,
			) );
			?>
		</header>
		<!-- .entry-header -->

		<div class="entry-content">
			<?php
			$embed_args = array(
				'fields' => array( 'twitter', 'facebook' ),
				'height' => 300,
				'width'  => 300,
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
					<div class="post__date">
						<?php $date_visible = caldera_is_meta_visible( 'blog_post_publish_date', 'loop' ) ? 'true' : 'false';

						$utility->meta_data->get_date( array(
							'visible' => $date_visible,
							'class'   => 'post__date-link',
							'icon'    => '<i class="material-icons"></i>',
							'echo'    => true,
							'prefix'  => esc_html__( '- ', 'caldera' ),
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
					<?php $tags_visible = caldera_is_meta_visible( 'blog_post_tags', 'loop' ) ? 'true' : 'false';

					$utility->meta_data->get_terms( array(
						'visible'   => $tags_visible,
						'type'      => 'post_tag',
						'delimiter' => ', ',
						'icon'      => '<i class="material-icons">folder_open</i>',
						'before'    => '<div class="post__tags">',
						'after'     => '</div>',
						'echo'      => true,
					) );
					?>
				</div><!-- .entry-meta -->

			<?php endif; ?>

		</div>
		<!-- .post-list__item-content -->

		<footer class="entry-footer">
			<?php caldera_share_buttons( 'loop' ); ?>

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

</article><!-- #post-## -->
