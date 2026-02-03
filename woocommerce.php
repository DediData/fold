<?php
/**
 * The woocommerce template file
 *
 * @package Fold
 */

get_header(); ?>
<div class="container pb-1">
	<?php
	$sidebar_condition = is_active_sidebar( 'sidebar-1' );
	$extra_class = '';
	if ( $sidebar_condition ) {
		$extra_class = ' col-md-8 col-lg-9 order-1 order-md-2 p-2';
		echo '<div class="row">';
	}
	?>
	<div id="primary" class="col-12<?php echo esc_attr( $extra_class ); ?>">
		<?php
		get_template_part( 'template-parts/sidebars/content-top-frontend' );
		get_template_part( 'template-parts/sidebars/content-top' );
		?>
		<div class="wc-content shadow rounded p-3">
			<div class="pb-2"><?php woocommerce_breadcrumb(); ?></div>
			<?php woocommerce_content(); ?>
		</div>
		<?php
		get_template_part( 'template-parts/sidebars/content-bottom-frontend' );
		get_template_part( 'template-parts/sidebars/content-bottom' );
		?>
	</div>
	<?php
	if ( $sidebar_condition ) {
		get_template_part( 'template-parts/sidebars/sidebar' );
		echo '</div>';
	}
	?>
</div>
<?php
get_footer();
