<div class="custom-posts__item post <?php echo $grid_class; ?>">
	<div class="post-inner">
		<div class="post-thumbnail">
			<?php echo $image; ?>
		</div>
		<div class="post_wrapper">
			<div class="entry-header">
				<?php echo $category; ?>
				<?php echo $title; ?>
			</div>
			<div class="entry-content">
				<?php echo $excerpt; ?>
				<div class="entry-meta">
					<span><?php echo $author; ?></span>
					<span><?php echo $date; ?></span>
					<?php echo $count; ?>
					<?php echo $tag; ?>
				</div>
			</div>
			<div class="entry-footer">
				<?php echo $button; ?>
			</div>
		</div>
	</div>
</div>
