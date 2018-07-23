<?php
/**
 * Template part for showcase panel in header.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Caldera
 */

// Don't show showcase panel if all elements are disabled.
if ( ! caldera_is_showcase_panel_visible() ) {
	return;
} ?>

<div class="showcase-panel">

	<?php caldera_showcase_text_elements( '<h1 class="showcase-panel__title">%s</h1>', 'title' ); ?>
	<?php caldera_showcase_text_elements( '<h2 class="showcase-panel__subtitle">%s</h2>', 'subtitle' ); ?>
	<?php caldera_showcase_text_elements( '<p class="showcase-panel__description">%s</p>', 'description' ); ?>
	<?php caldera_showcase_btn(); ?>

</div><!-- .showcase-panel -->
