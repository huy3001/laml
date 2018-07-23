<?php
/**
 * Template part for displaying cureent item meta
 */

if ( ! $this->_var( 'meta_data' ) || 'off' === $this->_var( 'meta_data' ) ) {
	return;
}
?>
<div class="tm-posts_item_meta"><?php

	tm_builder_core()->utility()->meta_data->get_author( array(
		'prefix' => esc_html__( 'by ', 'caldera' ),
		'echo'   => true,
	) );

	tm_builder_core()->utility()->meta_data->get_date( array(
		'echo' => true,
	) );

	tm_builder_core()->utility()->meta_data->get_comment_count( array(
		'icon'  => apply_filters( 'cherry_comment_icon', '<i class="material-icons" aria-hidden="true">chat_bubble_outline</i>' ),
		'sufix' => _n_noop( '%s', '%s', 'caldera' ),
		'echo'  => true,
	) );

	?></div>
