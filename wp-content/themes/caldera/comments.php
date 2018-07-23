<?php
/**
 * The template for displaying comments.
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Caldera
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php caldera_ads_post_before_comments() ?>

	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) : ?>
		<h3 class="comments-title">
			<?php
			printf( // WPCS: XSS OK.
				esc_html( _nx( 'One Response', '%1$s Reviews', get_comments_number(), 'comments title', 'caldera' ) ),
				number_format_i18n( get_comments_number() )
			);
			?>
		</h3>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
			<nav id="comment-nav-above" class="navigation comment-navigation" role="navigation">
				<h3 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'caldera' ); ?></h3>

				<div class="nav-links">

					<div class="nav-previous"><?php previous_comments_link( esc_html__( 'Older Comments', 'caldera' ) ); ?></div>
					<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments', 'caldera' ) ); ?></div>

				</div>
				<!-- .nav-links -->
			</nav><!-- #comment-nav-above -->
		<?php endif; // Check for comment navigation. ?>

		<ol class="comment-list">
			<?php
			wp_list_comments( array(
				'style'       => 'ol',
				'avatar_size' => 98,
				'short_ping'  => true,
				'callback'    => 'caldera_rewrite_comment_item',
			) );
			?>
		</ol><!-- .comment-list -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
			<nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
				<h3 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'caldera' ); ?></h3>

				<div class="nav-links">

					<div class="nav-previous"><?php previous_comments_link( esc_html__( 'Older Comments', 'caldera' ) ); ?></div>
					<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments', 'caldera' ) ); ?></div>

				</div>
				<!-- .nav-links -->
			</nav><!-- #comment-nav-below -->
			<?php
		endif; // Check for comment navigation.

	endif; // Check for have_comments().


	// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>

		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'caldera' ); ?></p>
		<?php
	endif;

	comment_form();
	?>

</div><!-- #comments -->
