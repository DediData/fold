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

$mod_bs_theme = get_theme_mod( 'bootstrap_theme', 'light' );
if ( 'light-only' === $mod_bs_theme || 'light' === $mod_bs_theme ) {
	$extra_prop = 'light';
} elseif ( 'dark-only' === $mod_bs_theme || 'dark' === $mod_bs_theme ) {
	$extra_prop = 'dark';
}
?><!DOCTYPE html>
<html <?php language_attributes(); ?> itemscope itemtype="https://schema.org/WebPage" data-bs-theme="<?php echo esc_attr( $extra_prop ); ?>">
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
<a id="back-to-top" href="#" class="btn back-to-top" type="button" role="button" title="<?php esc_attr_e( 'Go to top', 'fold' ); ?>">
	<span class="fas fa-chevron-up"></span>
</a>
<div id="wrapper" class="shadow-lg">
	<header>
		<?php
		get_template_part( 'template-parts/part/popup-login' );
		get_template_part( 'template-parts/part/popup-search' );
		if (
			! is_home() &&
			! is_front_page() &&
			(
				is_404() ||
				is_archive() ||
				'template-no-header.php' === get_page_template_slug() ||
				(
					function_exists( 'is_woocommerce' ) &&
					( is_woocommerce() || is_shop() || is_cart() || is_checkout() || is_account_page() || is_product() || is_product_category() || is_product_tag() )
				)
			)
		) {
			get_template_part( 'template-parts/part/nav-no-header-top' );
		} else {
			get_template_part( 'template-parts/part/nav-header-top' );
			get_template_part( 'template-parts/part/header-carousel' );
			get_template_part( 'template-parts/part/nav-header-bottom' );
		}
		?>
	</header>
	<main id="main" class="mt-3">
