<?php
/**
 * Template part for centered Header layout.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Caldera
 */
?>

<div class="header-container__flex">
	<div class="site-branding">
		<?php caldera_header_logo() ?>
		<?php caldera_site_description(); ?>
	</div>
	<div class="header_caption">
		<?php caldera_main_menu(); ?>
		<?php caldera_top_search( '<div class="header__search">%s</div>' ); ?>
	</div>
</div>
