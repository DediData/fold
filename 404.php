<?php
/**
 * The 404 template file
 *
 * @package Fold
 */

declare(strict_types=1);

get_header(); ?>
<div class="container pb-1">
<?php
$sidebar_condition = is_active_sidebar( 'sidebar-1' );
$extra_class       = '';
if ( $sidebar_condition ) {
	$extra_class = ' col-md-8 col-lg-9 order-1 order-md-2 p-2';
	?>
	<div class="row">
	<?php
}
?>
		<div id="primary" class="col-12<?php echo esc_attr( $extra_class ); ?>">
			<section class="shadow rounded mb-3 p-3" >
				<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'fold' ); ?></p>
				<?php get_search_form(); ?>
			</section>
			<?php
			get_template_part( 'template-parts/sidebars/content-top-frontend' );
			get_template_part( 'template-parts/sidebars/content-top' );
			get_template_part( 'template-parts/sidebars/content-bottom-frontend' );
			get_template_part( 'template-parts/sidebars/content-bottom' );
			?>
		</div>
		<?php
		if ( $sidebar_condition ) {
			get_template_part( 'template-parts/sidebars/sidebar' );
			?>
	</div>
			<?php
		}
		?>
</div>
<?php
get_footer();
