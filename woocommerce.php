<?php
/**
 * The woocommerce template file
 *
 * @package Fold
 */

declare(strict_types=1);

get_header();
?>
<main id="main" class="mt-3">
	<div class="container">
		<?php
		// @phan-suppress-next-line PhanPluginRedundantAssignmentInGlobalScope
		$extra_class = '';
		if ( is_active_sidebar( 'sidebar-1' ) ) {
			$extra_class = ' col-md-8 col-lg-9 order-2 p-2';
			echo '<div class="row">';
		}
		?>
		<div id="primary" class="col-12<?php echo esc_attr( $extra_class ); ?>">
			<div class="wc-content shadow rounded p-3">
				<?php woocommerce_content(); ?>
			</div>
		</div>
		<?php
		if ( is_active_sidebar( 'sidebar-1' ) ) {
			get_sidebar();
			echo '</div>';
		}
		?>
	</div>
</main>
<?php
get_footer();
