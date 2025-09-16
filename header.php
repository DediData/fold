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
	<?php get_template_part( 'template-parts/part/nav-header-top' ); ?>
	<?php get_template_part( 'template-parts/part/header-carousel' ); ?>
	<?php get_template_part( 'template-parts/part/nav-header-bottom' ); ?>
</header>
