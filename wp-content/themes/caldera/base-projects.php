<?php get_header( caldera_template_base() ); ?>

<?php do_action( 'caldera_render_widget_area', 'full-width-header-area' ); ?>

<?php caldera_site_breadcrumbs(); ?>

<div <?php echo caldera_get_container_classes( array( 'site-content_wrap' ), 'content' ); ?>>

	<?php do_action( 'caldera_render_widget_area', 'before-content-area' ); ?>

	<div class="row">

		<div id="primary" class="col-xs-12 col-md-12">

			<?php do_action( 'caldera_render_widget_area', 'before-loop-area' ); ?>

			<main id="main" class="site-main" role="main">

				<?php include caldera_template_path(); ?>

			</main>
			<!-- #main -->

			<?php do_action( 'caldera_render_widget_area', 'after-loop-area' ); ?>

		</div>
		<!-- #primary -->

	</div>
	<!-- .row -->

	<?php do_action( 'caldera_render_widget_area', 'after-content-area' ); ?>

</div><!-- .container -->

<?php do_action( 'caldera_render_widget_area', 'after-content-full-width-area' ); ?>

<?php get_footer( caldera_template_base() ); ?>
