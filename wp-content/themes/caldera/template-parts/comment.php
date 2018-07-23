<footer class="comment-meta">
	<div class="comment-author vcard">
		<?php echo caldera_comment_author_avatar(); ?>
	</div>
	<div class="comment-metadata">
		<?php printf(
			'<span class="posted-by">%s</span> %s',
			esc_html__( 'by', 'caldera' ),
			caldera_get_comment_author_link()
		);
		?>
		<?php echo caldera_get_comment_date( array( 'format' => '- M. d, Y' ) ); ?>
	</div>
</footer>
<div class="comment-content">
	<?php echo caldera_get_comment_text(); ?>
</div>
<div class="reply">
	<?php echo caldera_get_comment_reply_link( array( 'reply_text' => '<i class="material-icons">reply</i>' ) ); ?>
</div>
