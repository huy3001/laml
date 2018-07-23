<?php
/**
 * Template for displaying standard post format item content
 */
?>
<?php tm_pb_gallery_images( 'slider' ); ?>
<div class="entry-header">
	<h4 class="entry-title">
		<a href="<?php esc_url( the_permalink() ); ?>">
			<?php the_title(); ?>
		</a>
	</h4>
</div>

<?php echo $this->get_post_content(); ?>

<div class="caption">
	<?php echo $this->get_template_part( 'blog/meta.php' ); ?>
	<?php echo $this->get_more_button(); ?>
</div>
