<?php
/**
 * The template for displaying pages without header.
 *
 * Template Name: No Header
 *
 * @package Fold
 */

declare(strict_types=1);

?>
<!DOCTYPE html>
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
<a id="back-to-top" href="#" class="btn btn-outline-primary back-to-top" type="button" role="button" title="<?php esc_attr_e( 'Go to top', 'fold' ); ?>">
	<span class="fas fa-chevron-up"></span>
</a>
<header>
	<?php get_template_part( 'template-parts/part/popup-login' ); ?>
	<?php get_template_part( 'template-parts/part/nav-no-header-top' ); ?>
</header>
<main id="main" class="mt-3">
	<div class="container">
		<div id="primary" class="col-12">
			<?php
			if ( is_home() || is_front_page() ) {
				dynamic_sidebar( 'frontend-content-top' );
			}
			dynamic_sidebar( 'content-top' );
			if ( have_posts() ) {
				/* Start the Loop */
				while ( have_posts() ) {
					the_post();

					/*
					* Include the Post-Format-specific template for the content.
					* If you want to override this in a child theme, then include a file
					* called content-___.php (where ___ is the Post Format name) and that will be used instead.
					*/
					get_template_part( 'template-parts/post/content', (string) get_post_format() );
				}
				\FOLD()::posts_pagination(
					array(
						'prev_text' => '<span>' . esc_html__( 'Previous', 'fold' ) . '</span>',
						'next_text' => '<span>' . esc_html__( 'Next', 'fold' ) . '</span>',
						'type'      => 'list',
						'end_size'  => 3,
						'mid_size'  => 3,
					)
				);
			}//end if
			if ( is_home() || is_front_page() ) {
				dynamic_sidebar( 'frontend-content-bottom' );
			}
			dynamic_sidebar( 'content-bottom' );
			?>
		</div>
	</div>
</main>
<?php
get_footer();
