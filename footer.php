<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @package Fold
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 */

declare(strict_types=1);

?>
<footer id="page-footer" class="bg-primary">
	<div class="container">
		<div class="row">
			<div class="col-12 col-sm-3"><?php dynamic_sidebar( 'footer-column-1' ); ?></div>
			<div class="col-12 col-sm-3"><?php dynamic_sidebar( 'footer-column-2' ); ?></div>
			<div class="col-12 col-sm-3"><?php dynamic_sidebar( 'footer-column-3' ); ?></div>
			<div class="col-12 col-sm-3"><?php dynamic_sidebar( 'footer-column-4' ); ?></div>
		</div>
		<?php get_template_part( 'template-parts/part/nav-bottom' ); ?>
		<div id="footer-bottom" class="row">
			<div id="created-by" class="col-12 col-sm-6">
				<a href="<?php echo esc_url( esc_attr__( 'https://dedidata.com', 'fold' ) ); ?>" title="<?php esc_attr_e( 'Free Theme by DediData', 'fold' ); ?>" target="_blank">
					<?php esc_attr_e( 'Theme Design by DediData', 'fold' ); ?>
				</a>
			</div>
			<div id="copyright" class="col-12 col-sm-6">
				<?php
				// Translators: %1$s is current year and %2$s is site name
				$format_string = esc_html__( 'Copyright &copy; %1$s %2$s. All rights reserved.', 'fold' );
				// @phan-suppress-next-line PhanPluginPrintfVariableFormatString
				printf(
					esc_html( $format_string ),
					esc_html( gmdate( 'Y' ) ),
					esc_html( get_bloginfo( 'name' ) )
				);
				?>
			</div>
		</div>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
