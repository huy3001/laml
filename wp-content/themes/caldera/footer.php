<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link    https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Caldera
 */

?>

</div><!-- #content -->

<footer id="colophon" <?php caldera_footer_class() ?> role="contentinfo">
	<?php get_template_part( 'template-parts/footer/layout', get_theme_mod( 'footer_layout_type' ) ); ?>
</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>
<script type= \text/javascript\>
$(document).ready(function() {
$(“.site-header.centered .main-navigation .menu > li > a”).on(“click touchend”, function(e) {
var el = $(this);
var link = el.attr(“href”);
window.location = link;
});
});
</script>
</body>
</html>
