<?php
/**
 * The 404 template file
 *
 * @package Fold
 */

declare(strict_types=1);

get_header();
$sidebar_condition = is_active_sidebar( 'sidebar-1' ); ?>
<main id="main" class="container mt-3">
<?php
$extra_class = '';
if ( $sidebar_condition ) {
	$extra_class = ' col-md-8 col-lg-9 order-2 p-2';
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
			dynamic_sidebar( 'frontend-content-top' );
			dynamic_sidebar( 'content-top' );
			dynamic_sidebar( 'frontend-content-bottom' );
			dynamic_sidebar( 'content-bottom' );
			?>
		</div>
		<?php
		if ( $sidebar_condition ) {
			get_sidebar();
			?>
	</div>
			<?php
		}
		?>
</main>
<?php
get_footer();
