<?php
/**
 * Template part for displaying carousel item slides
 */
?>
<!-- Slide-->
<div class="swiper-slide">
	<?php echo $this->_var( 'image' ); ?>

	<header class="entry-content">
		<?php echo $this->_var( 'post_title' ); ?>
		<?php echo $this->_var( 'category' ); ?>
		<?php echo $this->_var( 'excerpt' ); ?>
	</header>

	<footer class="entry-footer">
		<div class="meta_wrap">
			<div><?php echo $this->_var( 'author' ); ?></div>
			<div><?php echo $this->_var( 'date' ); ?></div>
			<div class="count_wrap"><?php echo $this->_var( 'count' ); ?></div>
			<?php echo $this->_var( 'tag' ); ?>
		</div>
		<div class="btn_wrap">
			<?php echo $this->_var( 'more_button' ); ?>
		</div>
	</footer>

</div>
