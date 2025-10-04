<?php
/**
 * The woocommerce template file
 *
 * @package Fold
 */

declare(strict_types=1);

?><!DOCTYPE html>
<html <?php language_attributes(); ?> itemscope itemtype="https://schema.org/WebPage">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="visually-hidden-focusable rounded shadow d-flex justify-content-center p-1 m-1" href="#primary"><?php esc_html_e( 'Skip to main content', 'fold' ); ?></a>
<a id="back-to-top" href="#" class="btn back-to-top shadow" type="button" role="button" title="<?php esc_attr_e( 'Go to top', 'fold' ); ?>">
	<span class="fas fa-chevron-up"></span>
</a>
<header>
	<?php get_template_part( 'template-parts/part/popup-login' ); ?>
	<?php get_template_part( 'template-parts/part/nav-no-header-top' ); ?>
</header>
<main id="main" class="mt-3">
	<div class="container">
		<?php
		// @phan-suppress-next-line PhanPluginRedundantAssignmentInGlobalScope
		$extra_class = '';
		if ( is_active_sidebar( 'sidebar-1' ) ) {
			$extra_class = ' col-md-8 col-lg-9 order-1 order-md-2 p-2';
			echo '<div class="row">';
		}
		?>
		<div id="primary" class="col-12<?php echo esc_attr( $extra_class ); ?>">
			<div class="wc-content shadow rounded p-3">
				<div class="pb-2"><?php woocommerce_breadcrumb(); ?></div>
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
