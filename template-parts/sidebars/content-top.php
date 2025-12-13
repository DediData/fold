<?php
/**
 * Content Top Sidebar
 *
 * @package Fold
 */

declare(strict_types=1);

/**
 * Display breadcrumbs
 */
if (
	( ! is_home() && ! is_front_page() ) &&
	! ( function_exists( 'is_woocommerce' ) && ( is_woocommerce() || is_shop() || is_cart() || is_checkout() || is_account_page() || is_product() || is_product_category() || is_product_tag() ) )
) {
	if ( function_exists( 'rank_math_the_breadcrumbs' ) ) {
		?>
		<section id="breadcrumbs" class="px-1">
		<?php rank_math_the_breadcrumbs(); ?>
		</section>
		<?php
	}

	if ( function_exists( 'yoast_breadcrumb' ) ) {
		yoast_breadcrumb( '<section id="breadcrumbs" class="px-1">', '</section>' );
	}
}

if ( is_active_sidebar( 'content-top' ) ) {
	?>
	<section id="content-top-sidebar" style="height: fit-content;" class="shadow rounded p-3 mb-3">
		<?php dynamic_sidebar( 'content-top' ); ?>
	</section>
	<?php
}

