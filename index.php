<?php
/**
 * The main template file
 *
 * @package Fold
 */

get_header(); ?>
<div class="container pb-1">
	<?php
	$sidebar_condition = is_active_sidebar( 'sidebar-1' );
	$extra_class       = '';
	if ( $sidebar_condition ) {
		$extra_class = ' col-md-8 col-lg-9 order-1 order-md-2 p-2';
		echo '<div class="row">';
	}
	?>
	<div id="primary" class="col-12<?php echo esc_attr( $extra_class ); ?>">
		<?php
		get_template_part( 'template-parts/sidebars/content-top-frontend' );
		get_template_part( 'template-parts/sidebars/content-top' );

		if ( 'template-no-header.php' === get_page_template_slug() ) {
			?>
			<h1 class="page-title text-center py-2"><?php single_post_title(); ?></h1>
			<?php
		}

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
