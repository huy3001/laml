<?php
/**
 * The template for displaying the default footer layout.
 *
 * @package Caldera
 */
?>

<div class="footer-container">
	<div <?php echo caldera_get_container_classes( array( 'site-info' ), 'footer' ); ?>>
		<div class="site-info-wrapper container">

			<?php
			caldera_footer_logo();
			caldera_footer_copyright();
			?>

			<div class="site-info__bottom">
				<?php
				caldera_footer_menu();
				caldera_social_list( 'footer' );
				?>
			</div>

		</div>
		<!-- .site-info -->
	</div>
</div><!-- .container -->
