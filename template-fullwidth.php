<?php
/**
 * The template for displaying full width pages.
 *
 * Template Name: Full width
 *
 * @package Fold
 */

get_header(); ?>
<div id="primary" class="col-12">
	<?php
	get_template_part( 'template-parts/sidebars/content-top-frontend' );
	get_template_part( 'template-parts/sidebars/content-top' );
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
		FOLD()::posts_pagination(
			array(
				'prev_text' => '<span>' . esc_html__( 'Previous', 'fold' ) . '</span>',
				'next_text' => '<span>' . esc_html__( 'Next', 'fold' ) . '</span>',
				'type'      => 'list',
				'end_size'  => 3,
				'mid_size'  => 3,
			)
		);
	}//end if
	get_template_part( 'template-parts/sidebars/content-bottom-frontend' );
	get_template_part( 'template-parts/sidebars/content-bottom' );
	?>
</div>
<?php
get_footer();
