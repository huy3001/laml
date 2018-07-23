<?php
/**
 * Template part to display Carousel widget.
 *
 * @package    Caldera
 * @subpackage widgets
 */
?>

<div class="inner">
	<div class="content-wrapper">
		<header class="entry-header">
			<?php echo $image; ?>
			<?php echo $terms_line; ?>
		</header>
		<div class="entry-content">

			<?php echo $title; ?>
			<?php echo $content; ?>
			<?php echo $more_button; ?>
		</div>
	</div>
	<footer class="entry-footer">
		<div class="entry-meta">
			<span class="posted-by"><?php echo esc_html__( 'by ', 'caldera' ); ?><?php echo $author; ?></span>
			<span><?php echo $date; ?></span>
			<?php echo $comments; ?>
		</div>
	</footer>
</div>
